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
     * Constructor.
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     * @param \Doctrine\ORM\EntityManager $em
     * @param string $class
     */
    public function __construct(EventDispatcherInterface $dispatcher, EntityManager $em, $class)
    {
        parent::__construct($dispatcher, $em, $class);


    }

    /**
     * {@inheritDoc}
     */
    public function isNew(EntryInterface $entry)
    {
        return !$this->em->getUnitOfWork()->isInIdentityMap($entry);
    }

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

        if (null === $this->pager) {
            return $queryBuilder->getQuery()->getResult();
        }

        return $this->pager->getList($queryBuilder, $offset, $limit);
    }

    /**
     * {@inheritDoc}
     */
    protected function doDelete($ids)
    {
        $this->em->createQueryBuilder()
            ->delete($this->getClass(), 'c')
            ->where('c.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->execute();
    }

}
