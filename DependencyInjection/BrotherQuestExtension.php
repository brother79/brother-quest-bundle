<?php

namespace Brother\QuestBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BrotherQuestExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        // get all Bundles
        $bundles = $container->getParameter('kernel.bundles');
        $rpsConfig = array();

        // get the RPSGuestbook configuration
        $configs = $container->getExtensionConfig($this->getAlias());
        $guestbookConfig = $this->processConfiguration(new Configuration(), $configs);

        // enable spam detection if AkismetBundle is registered
        // else disable spam detection
        // can be overridden by setting the brother_quest.spam_detection.enable config
        $rpsConfig['spam_detection'] = isset($bundles['AkismetBundle']) ? true : false;

        // check if WhiteOctoberPagerfantaBundle is registered
        // if not set the default pager class
        // can be overridden by setting the brother_quest.pager.class config
        if (!isset($bundles['WhiteOctoberPagerfantaBundle'])) {
            if ( 'orm' == $guestbookConfig['db_driver']) {
                $rpsConfig['class']['pager'] = 'RPS\CoreBundle\Pager\DefaultORM';
            } else {
                $rpsConfig['class']['pager'] = 'RPS\CoreBundle\Pager\DefaultMongodb';
            }
        }

        // add the RPSGuestbookBundle configurations
        // all options can be overridden in the app/config/config.yml file
        $container->prependExtensionConfig('brother_quest', $rpsConfig);
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (!in_array(strtolower($config['db_driver']), array('mongodb', 'orm'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }
        $loader->load(sprintf('%s.yml', $config['db_driver']));

        $loader->load('form.yml');

        // core config
        $container->setParameter('brother_quest.auto_publish', $config['auto_publish']);
        $container->setParameter('brother_quest.entry_per_page', $config['entry_per_page']);
        $container->setParameter('brother_quest.date_format', $config['date_format']);
        $container->setParameter('brother_quest.notify_admin', $config['notify_admin']);

        // mailer
        $container->setParameter('brother_quest.mailer.class', $config['class']['mailer']);
        $container->setParameter('brother_quest.mailer.email_title', $config['mailer']['email_title']);
        $container->setParameter('brother_quest.mailer.admin_email', $config['mailer']['admin_email']);
        $container->setParameter('brother_quest.mailer.sender_email', $config['mailer']['sender_email']);

        // forms
        $container->setParameter('brother_quest.form.entry.name', $config['form']['entry']['name']);
        $container->setParameter('brother_quest.form.entry.type', $config['form']['entry']['type']);
        $container->setParameter('brother_quest.form.entry.class', $config['form']['entry']['class']);

        $container->setParameter('brother_quest.form.edit.name', $config['form']['edit']['name']);		
        $container->setParameter('brother_quest.form.edit.type', $config['form']['edit']['type']);		
        $container->setParameter('brother_quest.form.edit.class', $config['form']['edit']['class']);

        $container->setParameter('brother_quest.form.reply.name', $config['form']['reply']['name']);		
        $container->setParameter('brother_quest.form.reply.type', $config['form']['reply']['type']);		
        $container->setParameter('brother_quest.form.reply.class', $config['form']['reply']['class']);		

        // views
        $container->setParameter('brother_quest.view.admin.list', $config['view']['admin']['list']);
        $container->setParameter('brother_quest.view.admin.edit', $config['view']['admin']['edit']);
        $container->setParameter('brother_quest.view.admin.reply', $config['view']['admin']['reply']);

        $container->setParameter('brother_quest.view.frontend.list', $config['view']['frontend']['list']);
        $container->setParameter('brother_quest.view.frontend.new', $config['view']['frontend']['new']);
        $container->setParameter('brother_quest.view.mail.notify', $config['view']['mail']['notify']);

        // set model class
        if (isset($config['class']['model'])) {
            $container->setParameter('brother_quest.model.entry.class', $config['class']['model']);
        }

        // set manager class
        if (isset($config['class']['manager'])) {
            $container->setParameter('brother_quest.manager.entry.class', $config['class']['manager']);
        }

        // set pager class
        if (isset($config['class']['pager'])) {
            $container->setParameter('brother_quest.pager.class', $config['class']['pager']);
        }

        // load custom mailer service if set
        if (isset($config['service']['mailer'])) {
            $container->setAlias('brother_quest.mailer', $config['service']['mailer']);
        }

        // load custom pager service if set  else load the default pager
        if (isset($config['service']['pager'])) {
            $container->setAlias('brother_quest.pager', $config['service']['pager']);
        } else {
            $container->setAlias('brother_quest.pager', 'brother_quest.pager.default');
        }

        // spam detection
        $container->setParameter('brother_quest.enable_spam_detection', $config['spam_detection']);

        if ($config['spam_detection']) {
            // load external spam detector if set else load default
            if (isset($config['service']['spam_detector'])) {
                $container->setAlias('brother_quest.spam_detector', $config['service']['spam_detector']);
            } else {
                $loader->load('spam_detection.xml');
                $container->setAlias('brother_quest.spam_detector', 'brother_quest.spam_detector.akismet');
            }
        }

    }
}
