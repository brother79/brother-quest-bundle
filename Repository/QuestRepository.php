<?php

namespace Brother\QuestBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * QuestRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class QuestRepository extends EntityRepository
{
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
            ->andWhere('status =?', svBasePeer::STATUS_CREATED);
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
    		->where('t.status=?', svBasePeer::STATUS_DELETED)
    		->andWhere('t.updated_at<?', $d)
    		->delete();
        $q->execute();
        $q->free();
    }
    
    public function createQueryLast($params)
    {
        return $this->createQuery()
            ->where('status = ?', svBasePeer::STATUS_CREATED)
            ->orderBy('created_at desc');
    }
}
