Default Configuration
=====================

.. code-block:: yml

    brother_quest:
        db_driver: orm
        entry_per_page: 25                                          # number of entries to show on a page
        auto_publish: true                                          # publish new entries or wait for admin approval
        notify_admin: false                                         # send notification mail to admin when a new entry is saved
        spam_detection: false                                       # enable/disable spam detection
        date_format: "d/m/Y H:i:s"                                  # date format used

        mailer:
            admin_email: admin@localhost.com                        # email the admin notification is sent to
            sender_email: admin@localhost.com                       # sender email used
            email_title: New guestbook entry from {name}            # (optional) notification email title

        class:
            model: RPS\GuestbookBundle\Entity\Entry                 # (optional) guestbook model class
            manager: RPS\GuestbookBundle\Entity\EntryManager        # (optional) guestbook manager class
            pager : RPS\CoreBundle\Pager\PagerfantaORM              # (optional) pager class
            mailer: RPS\GuestbookBundle\Mailer\Mailer               # (optional) mailer class

        view:
            frontend:
                list: RPSGuestbookBundle:Frontend:index.html.twig   # guestbook entries view
                new: RPSGuestbookBundle:Frontend:new.html.twig      # guestbook form

            admin:
                list: RPSGuestbookBundle:Admin:index.html.twig      # admin guestbook entries view
                edit: RPSGuestbookBundle:Admin:edit.html.twig       # admin guestbook entry edit view
                reply: RPSGuestbookBundle:Admin:reply.html.twig     # admin guestbook entry reply view

            mail:
                notify: RPSGuestbookBundle:Mail:notify.txt.twig     # notification mail template

        form:
            entry:
                name: brother_quest_entry
                type: brother_quest_entry
                class: RPS\GuestbookBundle\Form\Type\EntryType      # guestbook entry form class

            edit:
                name: brother_quest_entry_edit
                type: brother_quest_entry_edit
                class: RPS\GuestbookBundle\Form\Type\EntryEditType  # guestbook entry edit form class

            reply:
                name: brother_quest_entry_reply
                type: brother_quest_entry_reply
                class: RPS\GuestbookBundle\Form\Type\EntryReplyType # guestbook entry reply form class

        service:
            pager: ~                                                # (optional) custom pager service
            mailer: ~                                               # (optional) custom mailer service
            spam_detector: ~                                        # (optional) custom spam detector service


Each of these configuration options can be overridden in your app/config/config.yml file


Other topics
============

#. `Installation`_

#. `Doctrine Configuration`_

#. `Mailer Configuration`_

#. `Pager Configuration`_

#. `Spam Detection`_

#. `Views/Templates`_

.. _Installation: Resources/doc/index.rst
.. _Doctrine Configuration: Resources/doc/doctrine.rst
.. _Mailer Configuration: Resources/doc/mailer.rst
.. _Pager Configuration: Resources/doc/pager.rst
.. _`Spam Detection`: Resources/doc/spam_detection.rst
.. _`Views/Templates`: Resources/doc/views.rst
.. _`Guestbook Administration`: Resources/doc/admin.rst
