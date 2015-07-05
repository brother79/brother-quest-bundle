<?php

/*
 * This file is part of the BrotherQuestBundle package.
 *
 * (c) Yos Okusanya <yos.okusanya@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Brother\QuestBundle\Model;

use Brother\QuestBundle\Event\Events;
use Brother\QuestBundle\Event\EntryEvent;
use Brother\QuestBundle\Event\EntryDeleteEvent;
use Brother\QuestBundle\Event\EntryStateEvent;
use Brother\QuestBundle\Pager\PagerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Base class for the quest manager.
 */
abstract class EntryManager implements EntryManagerInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var boolean
     */
    protected $autoPublish = true;

    /**
     * @var Pagination object
     */
    protected $pager = null;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface 	$dispatcher
     * @param string                                              			$class
     * @param boolean                                              			$autoPublish
     */
    public function __construct(EventDispatcherInterface $dispatcher, $class, $autoPublish)
    {
        $this->dispatcher = $dispatcher;
        $this->class = $class;
        $this->autoPublish = $autoPublish;
    }

    /**
     * Set pager
     *
     * @param PagerInterface $pager
     **/
    public function setPager(PagerInterface $pager)
    {
        $this->pager = $pager;
    }

    /**
     * Returns the fully qualified quest class name
     *
     * @return string
     **/
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Finds a quest entry by given id
     *
     * @param  string $id
	 *
     * @return EntryInterface
     */
    public function findOneById($id)
    {
        return $this->findOneBy(array('id' => $id));
    }

    /**
     * Creates an empty Entry instance
     *
     * @param integer $id
	 *
     * @return EntryInterface
     */
    public function createEntry($id = null)
    {
        $class = $this->getClass();
        $entry = new $class;
        /* @var $entry Entry */
        if (null !== $id) {
            $entry->setId($id);
        }

        $event = new EntryEvent($entry);
        $this->dispatcher->dispatch(Events::ENTRY_CREATE, $event);

        return $entry;
    }

    /**
     * Persists a quest entry.
     *
     * @param EntryInterface $entry
     *
     * @return boolean
     */
    public function save(EntryInterface $entry)
    {
        // set state for new entry
        if ($this->isNew($entry))  {
            if($this->autoPublish) {
                $entry->setState(1);
            } else {
                $entry->setState(0);
            }
        }

        $event = new EntryEvent($entry);
        $this->dispatcher->dispatch(Events::ENTRY_PRE_PERSIST, $event);

        $this->doSave($entry);

        if ($event->isPropagationStopped()) {
            return false;
        }

        $this->dispatcher->dispatch(Events::ENTRY_POST_PERSIST, $event);

        return true;
    }

    /**
     * Removes a quest entry.
     *
     * @param EntryInterface $entry
     *
     * @return boolean
     */
    public function remove(EntryInterface $entry)
    {
        $event = new EntryEvent($entry);
        $this->dispatcher->dispatch(Events::ENTRY_PRE_REMOVE, $event);

        if ($event->isPropagationStopped()) {
            return false;
        }

        $this->doRemove($entry);

        $this->dispatcher->dispatch(Events::ENTRY_POST_REMOVE, $event);

        return true;
    }

    /**
     * Deletes a list of quest entries
     *
     * @param array $ids
     *
     * @return boolean
     */
    public function delete(array $ids)
    {
        $event = new EntryDeleteEvent($ids);
        $this->dispatcher->dispatch(Events::ENTRY_PRE_DELETE, $event);

        if ($event->isPropagationStopped()) {
            return false;
        }

        $this->doDelete($ids);

        $this->dispatcher->dispatch(Events::ENTRY_POST_DELETE, $event);

        return true;
    }

    /**
     * Update the state of a list of quest entries
     *
     * @param array 	$ids
     * @param integer	$state
     *
     * @return boolean
     */
    public function updateState($ids, $state)
    {
        $event = new EntryStateEvent($ids, $state);
        $this->dispatcher->dispatch(Events::ENTRY_PRE_UPDATE_STATE, $event);

        if ($event->isPropagationStopped()) {
            return false;
        }

        $this->doUpdateState($ids, $state);

        $this->dispatcher->dispatch(Events::ENTRY_POST_UPDATE_STATE, $event);

        return true;
    }

    /**
     * Get the pagination html
     *
     * @return string
     */
    public function getPaginationHtml()
    {
        $html = '';
        if(null !== $this->pager)
        {
            $html = $this->pager->getHtml();
        }

        return $html;
    }

    /**
     * Update the quest entry replied fields.
     *
     * @param EntryInterface 							$entry
     * @param \Symfony\Component\Form\FormInterface		$form
	 *
     * @return boolean
     */
    public function updateReplyFields(EntryInterface $entry, FormInterface $form)
    {
        $entry->updateRepliedAt();

        return $this->save($entry);
    }

    /**
     * Performs the persistence of the quest entry.
     *
     * @param EntryInterface $entry
     */
    abstract protected function doSave(EntryInterface $entry);

    /**
     * Performs the removal of the entry.
     *
     * @param EntryInterface $entry
     */
    abstract protected function doRemove(EntryInterface $entry);
	
    /**
     * Performs the removal of a list of quest entries.
     *
     * @param array $ids
     */
    abstract protected function doDelete($ids);

    /**
     * Performs the state update of a list of quest entries.
     *
     * @param array 	$ids
     * @param integer   $state
     */
    abstract protected function doUpdateState($ids, $state);

}
