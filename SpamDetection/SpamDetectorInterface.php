<?php

/*
 * This file is part of the RPSGuestbookBundle package.
 *
 * (c) Yos Okusanya <yos.okusanya@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace RPS\GuestbookBundle\SpamDetection;

use RPS\GuestbookBundle\Model\EntryInterface;

/**
 * Interface to be implemented by the spam detector.
 */
interface SpamDetectorInterface
{
    /**
     * Checks if the guestbook entry is a spam.
     *
     * @param  EntryInterface $entry
     *
     * @return boolean
     */
    public function isSpam(EntryInterface $entry);
}
