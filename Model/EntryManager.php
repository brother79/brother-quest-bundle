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

use Brother\CommonBundle\Model\Entry\ORMEntryManager;
use Brother\QuestBundle\Event\Events;
use Brother\QuestBundle\Event\EntryEvent;
use Brother\QuestBundle\Event\EntryDeleteEvent;
use Brother\QuestBundle\Pager\PagerInterface;

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Base class for the quest manager.
 */
abstract class EntryManager extends ORMEntryManager implements EntryManagerInterface
{

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
    public function __construct(EventDispatcherInterface $dispatcher, EntityManager $em, $class)
    {
        $this->dispatcher = $dispatcher;
        $this->class = $class;
        parent::__construct($dispatcher, $em, $class );
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
