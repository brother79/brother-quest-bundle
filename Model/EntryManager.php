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

use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Base class for the quest manager.
 */
abstract class EntryManager extends ORMEntryManager
{

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
