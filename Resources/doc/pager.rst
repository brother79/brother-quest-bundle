Pager Installation and Configuration
====================================

The RPSGuestbookBundle uses the ``WhiteOctoberPagerfantaBundle_`` for pagination.

To use ``WhiteOctoberPagerfantaBundle`` as the RPSGuestbookBundle pager ,
you must install the WhiteOctoberPagerfantaBundle_.

If the WhiteOctoberPagerfantaBundle is not installed, the RPSGuestbookBundle will disable pagination.

To limit the number of guestbook entries shown, set the ``entry_per_page`` config option

.. code-block:: yml

    # app/config/config.yml
    brother_quest:
        entry_per_page: 25


Using a custom pager manager class
----------------------------------

You can specify your custom pager manager class by overriding the pager class option e.g.

.. code-block:: yml

    # app/config/config.yml
    brother_quest:
        class:
            pager: MyProject\MyBundle\Pager\Pager

Your custom class **must** implement the ``\RPS\CoreBundle\Pager\PagerInterface`` interface.


Using a custom pager service
----------------------------

You can specify a custom pager service to handle the guestbook entries pagination
by setting the pager service config option.

.. code-block:: yml

    # app/config/config.yml
    brother_quest:
        service:
            pager: my_pager

Your pager service class **must** implement the ``\RPS\CoreBundle\Pager\PagerInterface`` interface.


Other topics
============

#. `Installation`_

#. `Doctrine Configuration`_

#. `Mailer Configuration`_

#. `Spam Detection`_

#. `Views/Templates`_

#. `Guestbook Administration`_

#. `Default Configuration`_

.. _Installation: Resources/doc/index.rst
.. _`Doctrine Configuration`: Resources/doc/doctrine.rst
.. _`Mailer Configuration`: Resources/doc/mailer.rst
.. _`Spam Detection`: Resources/doc/spam_detection.rst
.. _`Views/Templates`: Resources/doc/views.rst
.. _`Guestbook Administration`: Resources/doc/admin.rst
.. _`Default Configuration`: Resources/doc/default_configuration.rst
