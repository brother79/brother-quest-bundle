<?php

/*
 * This file is part of the BrotherQuestBundle package.
 *
 * (c) Yos Okusanya <yos.okusanya@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Brother\QuestBundle\Pager;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Doctrine\ORM\QueryBuilder;

/**
 * Pagerfanta ORM Pager.
 */
class PagerfantaORM extends PagerfantaPager
{
    /**
     * Get Paginated list
     *
     * @var QueryBuilder    $queryBuilder
     * @var integer         $offset         query offset
     * @var integer         $limit          query limit
     *
     * @return string
     */
    public function getList($queryBuilder, $offset, $limit)
    {
        $adapter = new DoctrineORMAdapter($queryBuilder);

        return $this->getPager($adapter, $offset, $limit);
    }
}
