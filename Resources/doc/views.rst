Views/Templates
===============

You can specify custom templates/views by overriding the corresponding view parameter e.g.

.. code-block:: yml

    # app/config/config.yml
    brother_quest:
        view:
            frontend:
                list: MyprojectMyBundle:Frontend:index.html.twig
                new: MyprojectMyBundle:Frontend:new.html.twig

            admin:
                list: MyprojectMyBundle:Admin:index.html.twig
                edit: MyprojectMyBundle:Admin:edit.html.twig
                reply: MyprojectMyBundle:Admin:reply.html.twig

            mail:
                notify: MyprojectMyBundle:Mail:notify.txt.twig


Other topics
============

#. `Installation`_

#. `Doctrine Configuration`_

#. `Mailer Configuration`_

#. `Pager Configuration`_

#. `Spam Detection`_

#. `Guestbook Administration`_

#. `Default Configuration`_

.. _Installation: Resources/doc/index.rst
.. _Doctrine Configuration: Resources/doc/doctrine.rst
.. _Mailer Configuration: Resources/doc/mailer.rst
.. _Pager Configuration: Resources/doc/pager.rst
.. _`Spam Detection`: Resources/doc/spam_detection.rst
.. _`Guestbook Administration`: Resources/doc/admin.rst
.. _`Default Configuration`: Resources/doc/default_configuration.rst

