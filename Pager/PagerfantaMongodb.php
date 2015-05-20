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

use Pagerfanta\Adapter\DoctrineODMMongoDBAdapter;
use Doctrine\ODM\MongoDB\Query\Builder;

/**
 * Pagerfanta Mongodb ODM Pager.
 */
class PagerfantaMongodb extends PagerfantaPager
{
    /**
     * Get Paginated list
     *
     * @var Builder     $queryBuilder
     * @var integer     $offset         query offset
     * @var integer     $limit          query limit
     *
     * @return string
     */
    public function getList($queryBuilder, $offset, $limit)
    {
        $adapter = new DoctrineODMMongoDBAdapter($queryBuilder);

        return $this->getPager($adapter, $offset, $limit);
    }
}
