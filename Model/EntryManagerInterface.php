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

/**
 * Interface to be implemented by the quest manager.
 */
interface EntryManagerInterface
{
    /**
     * @param string $id
     *
     * @return EntryInterface
     */
    public function findOneById($id);

    /**
     * Finds a quest entry by the given criteria
     *
     * @param array $criteria
     *
     * @return EntryInterface
     */
    public function findOneBy(array $criteria);

    /**
     * Finds quest entries by the given criteria
     *
     * @param array $criteria
     *
     * @return array of EntryInterface
     */
    public function findBy(array $criteria);

    /**
     * Creates an empty quest entry instance
     *
     * @param integer $id
     *
     * @return EntryInterface
     */
    public function createEntry($id = null);

    /**
     * Returns the quest fully qualified class name
     *
     * @return string
     */
    public function getClass();

    /**
     * Deletes a list of quest entries
     *
     * @param array $ids
     */
    public function delete(array $ids);

    /**
     * Finds entries by the given criteria
     * and from the query offset.
     *
     * @param integer 	$offset
     * @param integer	$limit
     * @param array 	$criteria
     *
     * @return array of EntryInterface
     */
    public function getPaginatedList($offset, $limit, $criteria = array());

    /**
     * Gets the pagination html
     *
     * @return string
     */
    public function getPaginationHtml();

}
