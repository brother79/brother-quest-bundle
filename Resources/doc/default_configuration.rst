Default Configuration
=====================

.. code-block:: yml

    brother_quest:
        db_driver: orm
        entry_per_page: 25                                          # number of entries to show on a page
        notify_admin: false                                         # send notification mail to admin when a new entry is saved
        date_format: "d/m/Y H:i:s"                                  # date format used

        mailer:
            admin_email: admin@localhost.com                        # email the admin notification is sent to
            sender_email: admin@localhost.com                       # sender email used
            email_title: New quest entry from {name}            # (optional) notification email title

        class:
            model: Brother\QuestBundle\Entity\Entry                 # (optional) quest model class
            manager: Brother\QuestBundle\Entity\EntryManager        # (optional) quest manager class
            pager : Brother\CommonBundle\Pager\DefaultORM              # (optional) pager class
            mailer: Brother\CommonBundle\Mailer\Mailer               # (optional) mailer class

        form:
            entry:
                name: brother_quest_entry
                type: brother_quest_entry
                class: Brother\QuestBundle\Form\EntryType      # quest entry form class

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
.. _`Quest Administration`: Resources/doc/admin.rst
