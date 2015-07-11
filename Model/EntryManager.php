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
     * @var Pagination object
     */
    protected $pager = null;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface 	$dispatcher
     * @param string                                              			$class
     */
    public function __construct(EventDispatcherInterface $dispatcher, $class)
    {
        $this->dispatcher = $dispatcher;
        $this->class = $class;
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

    /**
     * Enter description here...
     *
     * @param Doctrine_Query $query
     * @return Doctrine_Query
     */
    
	function getTasksQuery($query = null)
    {
    	if ($query == null) {
    		$query = $this->createQuery()->orderBy('updated_at');
    	}
        return $query->andWhere('a is null')
            ->andWhere('state =?', svBasePeer::STATE_CREATED);
    }
    
    function getTasks($query = null)
    {
        $q = $this->getTasksQuery($query);
    	$r = $q->execute();
        $q->free();
        return $r;
    }

    function clearOld($month = 3)
    {
    	$d = strtotime("-$month month");
		svDebug::_dx($d);
        $q = $this->createQuery('t')
    		->where('t.state=?', svBasePeer::STATE_DELETED)
    		->andWhere('t.updated_at<?', $d)
    		->delete();
        $q->execute();
        $q->free();
    }
    
    public function createQueryLast($params)
    {
        return $this->createQuery()
            ->where('state = ?', svBasePeer::STATE_CREATED)
            ->orderBy('created_at desc');
    }
}
