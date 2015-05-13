<?php

/*
 * This file is part of the BrotherQuestBundle package.
 *
 * (c) Yos Okusanya <yos.okusanya@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Brother\QuestBundle\Event;

use Brother\QuestBundle\Model\EntryInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Base class for a quest entry related event.
 */
class EntryEvent extends Event
{
    private $entry;

    /**
     * Constructor.
     *
     * @param EntryInterface $entry
     */
    public function __construct(EntryInterface $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Returns the quest entry for this event.
     *
     * @return EntryInterface
     */
    public function getEntry()
    {
        return $this->entry;
    }
}
