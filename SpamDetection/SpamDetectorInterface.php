<?php

/*
 * This file is part of the BrotherQuestBundle package.
 *
 * (c) Yos Okusanya <yos.okusanya@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Brother\QuestBundle\SpamDetection;

use Brother\QuestBundle\Model\EntryInterface;

/**
 * Interface to be implemented by the spam detector.
 */
interface SpamDetectorInterface
{
    /**
     * Checks if the quest entry is a spam.
     *
     * @param  EntryInterface $entry
     *
     * @return boolean
     */
    public function isSpam(EntryInterface $entry);
}
