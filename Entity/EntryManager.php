<?php

namespace Brother\QuestBundle\Entity;

use Doctrine\ORM\EntityManager;
use Brother\QuestBundle\Model\EntryInterface;
use Brother\QuestBundle\Model\EntryManager as AbstractEntryManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Default ORM EntryManager.
 */
class EntryManager extends AbstractEntryManager
{

    const STATE_CREATED = 0;

    /**
     * {@inheritDoc}
     */
    public function getPaginatedList($offset, $limit, $criteria = array())
    {

        $queryBuilder = $this->repository->createQueryBuilder('c');

        // set state
        if (isset($criteria['state'])) {
            $queryBuilder->andWhere('c.state = :state')
                ->setParameter('state', $criteria['state']);
        }

        if (isset($criteria['a'])) {
            $queryBuilder->andWhere('c.a is not null');
        }

        if (null === $this->paginator) {
            return $queryBuilder->getQuery()->getResult();
        }
        return $this->makePagination($limit, array('page' => $offset, $queryBuilder->getQuery()));
    }


}
