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

/**
 * Quest Events.
 */
final class Events
{
    /**
     * The CREATE event occurs when the manager creates 
	 * a new quest entry instance.
	 *
     * The listener receives a Brother\QuestBundle\Event\EntryEvent instance.
     *
     * @var string
     */
    const ENTRY_CREATE = 'brother_quest.entry.create';
	
    /**
     * The PRE_PERSIST occurs prior to the manager persisting the entry.
	 *
     * The listener receives a Brother\QuestBundle\Event\EntryEvent instance.
	 *
     * Persistence can be aborted by calling $event->isPropagationStopped()
     *
     * @var string
     */
    const ENTRY_PRE_PERSIST = 'brother_quest.entry.prePersist';

    /**
     * The POST_PERSIST event occurs after the Quest is persisted.
	 *
     * The listener receives a Brother\QuestBundle\Event\EntryEvent instance.
     *
     * @var string
     */
    const ENTRY_POST_PERSIST = 'brother_quest.entry.postPersist';
	
    /**
     * The PRE_REMOVE event occurs prior to the manager 
	 * removing a quest entry.
	 *
     * The listener receives a Brother\QuestBundle\Event\EntryEvent instance.
	 *
     * Entry removal can be aborted by calling $event->isPropagationStopped().
     *
     * @var string
     */
    const ENTRY_PRE_REMOVE = 'brother_quest.entry.preDelete';

    /**
     * The POST_REMOVE event occurs after removing a quest entry.
	 *
     * The listener receives a Brother\QuestBundle\Event\EntryEvent instance.
     *
     * @var string
     */
    const ENTRY_POST_REMOVE = 'brother_quest.entry.postDelete';

    /**
     * The PRE_DELETE event occurs prior to the manager 
	 * deleting a list of quest entries.
	 *
     * The listener receives a Brother\QuestBundle\Event\EntryDeleteEvent instance.
	 *
     * Entry deletion can be aborted by calling $event->isPropagationStopped().
     *
     * @var string
     */
	
    const ENTRY_PRE_DELETE = 'brother_quest.entry.preDelete';

    /**
     * The POST_DELETE event occurs after deleting a list of quest entries.
	 *
     * The listener receives a Brother\QuestBundle\Event\EntryDeleteEvent instance.
     *
     * @var string
     */
    const ENTRY_POST_DELETE = 'brother_quest.entry.postDelete';

    /**
     * The PRE_UPDATE_STATE event occurs prior to updating 
	 * the status of a list of quest entries.
	 *
     * The listener receives a Brother\QuestBundle\Event\EntryStateEvent instance.
	 *
     * Status update can be aborted by calling $event->isPropagationStopped().
     *
     * @var string
     */
    const ENTRY_PRE_UPDATE_STATE = 'brother_quest.entry.preNotify';

    /**
     * The POST_UPDATE_STATE event occurs after updating
	 * the status of a list of quest entries.
	 *
     * The listener receives a Brother\QuestBundle\Event\EntryStateEvent instance.
     *
     * @var string
     */
    const ENTRY_POST_UPDATE_STATE = 'brother_quest.entry.postNotify';

    /**
     * The PRE_REPLY event occurs prior to replying a entry.
	 *
     * The listener receives a Brother\QuestBundle\Event\MailEvent instance.
	 *
     * Sending the reply can be aborted by calling $event->isPropagationStopped().
     *
     * @var string
     */	
    const ENTRY_PRE_REPLY = 'brother_quest.entry.preReply';

    /**
     * The POST_REPLY event occurs affer sending a reply.
	 *
     * The listener receives a Brother\QuestBundle\Event\MailEvent instance.
     *
     * @var string
     */
    const ENTRY_POST_REPLY = 'brother_quest.entry.postReply';

    /**
     * The PRE_NOTIFY event occurs prior to sending a 
	 * quest entry notification email.
	 *
     * Notification can be aborted by calling $event->isPropagationStopped().
	 *
     * The listener receives a Brother\QuestBundle\Event\MailEvent instance.
     *
     * @var string
     */
    const ENTRY_PRE_NOTIFY = 'brother_quest.entry.preNotify';

    /**
     * The POST_NOTIFY event occurs after sending a 
	 * quest entry notification email.
	 *
     * The listener receives a Brother\QuestBundle\Event\MailEvent instance.
     *
     * @var string
     */
    const ENTRY_POST_NOTIFY = 'brother_quest.entry.postNotify';
}
