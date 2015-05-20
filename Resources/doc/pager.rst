Pager Installation and Configuration
====================================

To limit the number of quest entries shown, set the ``entry_per_page`` config option

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

Your custom class **must** implement the ``\Brother\QuestBundle\Pager\PagerInterface`` interface.


Using a custom pager service
----------------------------

You can specify a custom pager service to handle the quest entries pagination
by setting the pager service config option.

.. code-block:: yml

    # app/config/config.yml
    brother_quest:
        service:
            pager: my_pager

Your pager service class **must** implement the ``\Brother\QuestBundle\Pager\PagerInterface`` interface.


Other topics
============

#. `Installation`_

#. `Doctrine Configuration`_

#. `Mailer Configuration`_

#. `Spam Detection`_

#. `Views/Templates`_

#. `Quest Administration`_

#. `Default Configuration`_

.. _Installation: Resources/doc/index.rst
.. _`Doctrine Configuration`: Resources/doc/doctrine.rst
.. _`Mailer Configuration`: Resources/doc/mailer.rst
.. _`Spam Detection`: Resources/doc/spam_detection.rst
.. _`Views/Templates`: Resources/doc/views.rst
.. _`Quest Administration`: Resources/doc/admin.rst
.. _`Default Configuration`: Resources/doc/default_configuration.rst
