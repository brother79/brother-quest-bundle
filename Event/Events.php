<?php

/*
 * This file is part of the RPSGuestbookBundle package.
 *
 * (c) Yos Okusanya <yos.okusanya@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace RPS\GuestbookBundle\Event;

/**
 * Guestbook Events.
 */
final class Events
{
    /**
     * The CREATE event occurs when the manager creates 
	 * a new guestbook entry instance.
	 *
     * The listener receives a RPS\GuestbookBundle\Event\EntryEvent instance.
     *
     * @var string
     */
    const ENTRY_CREATE = 'rps_guestbook.entry.create';
	
    /**
     * The PRE_PERSIST occurs prior to the manager persisting the entry.
	 *
     * The listener receives a RPS\GuestbookBundle\Event\EntryEvent instance.
	 *
     * Persistence can be aborted by calling $event->isPropagationStopped()
     *
     * @var string
     */
    const ENTRY_PRE_PERSIST = 'rps_guestbook.entry.prePersist';

    /**
     * The POST_PERSIST event occurs after the Guestbook is persisted.
	 *
     * The listener receives a RPS\GuestbookBundle\Event\EntryEvent instance.
     *
     * @var string
     */
    const ENTRY_POST_PERSIST = 'rps_guestbook.entry.postPersist';
	
    /**
     * The PRE_REMOVE event occurs prior to the manager 
	 * removing a guestbook entry.
	 *
     * The listener receives a RPS\GuestbookBundle\Event\EntryEvent instance.
	 *
     * Entry removal can be aborted by calling $event->isPropagationStopped().
     *
     * @var string
     */
    const ENTRY_PRE_REMOVE = 'rps_guestbook.entry.preDelete';

    /**
     * The POST_REMOVE event occurs after removing a guestbook entry.
	 *
     * The listener receives a RPS\GuestbookBundle\Event\EntryEvent instance.
     *
     * @var string
     */
    const ENTRY_POST_REMOVE = 'rps_guestbook.entry.postDelete';

    /**
     * The PRE_DELETE event occurs prior to the manager 
	 * deleting a list of guestbook entries.
	 *
     * The listener receives a RPS\GuestbookBundle\Event\EntryDeleteEvent instance.
	 *
     * Entry deletion can be aborted by calling $event->isPropagationStopped().
     *
     * @var string
     */
	
    const ENTRY_PRE_DELETE = 'rps_guestbook.entry.preDelete';

    /**
     * The POST_DELETE event occurs after deleting a list of guestbook entries.
	 *
     * The listener receives a RPS\GuestbookBundle\Event\EntryDeleteEvent instance.
     *
     * @var string
     */
    const ENTRY_POST_DELETE = 'rps_guestbook.entry.postDelete';

    /**
     * The PRE_UPDATE_STATE event occurs prior to updating 
	 * the status of a list of guestbook entries.
	 *
     * The listener receives a RPS\GuestbookBundle\Event\EntryStateEvent instance.
	 *
     * Status update can be aborted by calling $event->isPropagationStopped().
     *
     * @var string
     */
    const ENTRY_PRE_UPDATE_STATE = 'rps_guestbook.entry.preNotify';

    /**
     * The POST_UPDATE_STATE event occurs after updating
	 * the status of a list of guestbook entries.
	 *
     * The listener receives a RPS\GuestbookBundle\Event\EntryStateEvent instance.
     *
     * @var string
     */
    const ENTRY_POST_UPDATE_STATE = 'rps_guestbook.entry.postNotify';

    /**
     * The PRE_REPLY event occurs prior to replying a entry.
	 *
     * The listener receives a RPS\GuestbookBundle\Event\MailEvent instance.
	 *
     * Sending the reply can be aborted by calling $event->isPropagationStopped().
     *
     * @var string
     */	
    const ENTRY_PRE_REPLY = 'rps_guestbook.entry.preReply';

    /**
     * The POST_REPLY event occurs affer sending a reply.
	 *
     * The listener receives a RPS\GuestbookBundle\Event\MailEvent instance.
     *
     * @var string
     */
    const ENTRY_POST_REPLY = 'rps_guestbook.entry.postReply';

    /**
     * The PRE_NOTIFY event occurs prior to sending a 
	 * guestbook entry notification email.
	 *
     * Notification can be aborted by calling $event->isPropagationStopped().
	 *
     * The listener receives a RPS\GuestbookBundle\Event\MailEvent instance.
     *
     * @var string
     */
    const ENTRY_PRE_NOTIFY = 'rps_guestbook.entry.preNotify';

    /**
     * The POST_NOTIFY event occurs after sending a 
	 * guestbook entry notification email.
	 *
     * The listener receives a RPS\GuestbookBundle\Event\MailEvent instance.
     *
     * @var string
     */
    const ENTRY_POST_NOTIFY = 'rps_guestbook.entry.postNotify';
}
