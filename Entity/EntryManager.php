<?php

namespace Brother\QuestBundle\Entity;

use Brother\CommonBundle\AppDebug;
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
     * @var EntityManager
     */
    protected $em;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     * @param \Doctrine\ORM\EntityManager $em
     * @param string $class
     * @param boolean $autoPublish
     */
    public function __construct(EventDispatcherInterface $dispatcher, EntityManager $em, $class, $autoPublish)
    {
        parent::__construct($dispatcher, $em->getClassMetadata($class)->name, $autoPublish);

        $this->em = $em;
        $this->repository = $em->getRepository($class);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * {@inheritDoc}
     */
    public function findOneBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
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
    protected function doSave(EntryInterface $entry)
    {
        $this->em->persist($entry);
        $this->em->flush();
    }

    /**
     * {@inheritDoc}
     */
    protected function doRemove(EntryInterface $entry)
    {
        $this->em->remove($entry);
        $this->em->flush();
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

        // set dates
        if (isset($criteria['date_from'])) {
            $queryBuilder->andWhere('c.created_at >= :from')
                ->setParameter('from', $criteria['date_from']);
        }

        if (isset($criteria['date_to'])) {
            $queryBuilder->andWhere('c.created_at <= :to')
                ->setParameter('to', $criteria['date_to']);
        }

        // set ordering
        if (isset($criteria['order'])) {
            foreach ($criteria['order'] as $ordering) {
                $queryBuilder->addOrderBy($ordering['field'], $ordering['order']);
            }
        } else {
            $queryBuilder->orderBy('c.created_at', 'DESC');    //default ordering
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

    /**
     * {@inheritDoc}
     */
    protected function doUpdateState($ids, $state)
    {
        $this->em->createQueryBuilder()
            ->update($this->getClass(), 'c')
            ->set('c.state', ':state')
            ->set('c.updatedAt', ':date')
            ->where('c.id IN (:ids)')
            ->setParameters(array(
                'state' => $state,
                'ids' => $ids,
                'date' => new \DateTime(),
            ))
            ->getQuery()
            ->execute();
    }

}
