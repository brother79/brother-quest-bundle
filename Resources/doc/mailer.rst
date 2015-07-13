Mailer Configuration
====================

To send emails, SwitfMailer must be installed and configured.

For more information about Swiftmailer configuration,
check the `SwiftmailerBundle Configuration documentation`_

.. _`SwiftmailerBundle Configuration documentation`: http://symfony.com/doc/current/reference/configuration/swiftmailer.html

To send admin notification emails (email sent to the admin each time a new quest entry is saved),
you must enable the mailer service and set the mail ``admin_email`` and ``sender_email`` config options

.. code-block:: yml

    # app/config/config.yml
    brother_quest:
        notify_admin: true

        mailer:
            admin_email: admin@localhost.com                # email the admin notification is sent to
            sender_email: admin@localhost.com               # sender email used
            email_title: New quest entry from {name}    # (optional)


Using a custom mailer class
---------------------------
You can specify your custom quest mailer manager class by overriding the mailer class option e.g.

.. code-block:: yml

    # app/config/config.yml
    brother_quest:
        class:
            manager: MyProject\MyBundle\Mailer\Mailer

Your custom class may extend the ``Brother\CommonBundle\Mailer\BaseMailer`` class. If you are not extending the
``Brother\CommonBundle\Mailer\BaseMailer`` class, your custom mailer class must implement the
``Brother\QuestBundle\Mailer\MailerInterface`` interface.


Using a custom spam detection service
-------------------------------------

You can also specify a custom mailer service by setting the `` mailer service`` config option.

.. code-block:: yml

    # app/config/config.yml
    brother_quest:
        service:
            mailer: my_mailer

Your mailer service class may extend the ``Brother\QuestBundle\Mailer\BaseMailer`` class. If you are not extending the
``Brother\QuestBundle\Mailer\BaseMailer`` class, your custom mailer class must implement the
``Brother\QuestBundle\Mailer\MailerInterface`` interface.


Using a custom notification template
------------------------------------

You can specify a custom notification template by overriding the mail template config setting

.. code-block:: yml

    # app/config/config.yml
    brother_quest:
        view:
            mail:
                notify: MyBundle:Mail:notify.txt.twig


Other topics
============

#. `Installation`_

#. `Doctrine Configuration`_

#. `Pager Configuration`_

#. `Spam Detection`_

#. `Views/Templates`_

#. `Quest Administration`_

#. `Default Configuration`_

.. _Installation: Resources/doc/index.rst
.. _`Doctrine Configuration`: Resources/doc/doctrine.rst
.. _`Pager Configuration`: Resources/doc/pager.rst
.. _`Spam Detection`: Resources/doc/spam_detection.rst
.. _`Views/Templates`: Resources/doc/views.rst
.. _`Quest Administration`: Resources/doc/admin.rst
.. _`Default Configuration`: Resources/doc/default_configuration.rst
