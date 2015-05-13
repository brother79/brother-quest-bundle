<?php

namespace Brother\QuestBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('brother_quest');

        $treeBuilder->root('brother_quest')
            ->children()
                ->scalarNode('db_driver')->defaultValue('orm')->end()
                ->integerNode('entry_per_page')->min(1)->defaultValue(25)->end()
                ->booleanNode('auto_publish')->defaultTrue()->end()
                ->booleanNode('notify_admin')->defaultFalse()->end()
                ->booleanNode('spam_detection')->defaultFalse()->end()
                ->scalarNode('date_format')->defaultValue('d/m/Y H:i:s')->end()
				
                ->arrayNode('mailer')->addDefaultsIfNotSet()
					->children()
						->scalarNode('admin_email')->defaultValue('admin@localhost.com')->end()
						->scalarNode('sender_email')->defaultValue('admin@localhost.com')->end()
                        ->scalarNode('email_title')->defaultValue('New guestbook entry from {name}')->end()
					->end()
                ->end()
				
                ->arrayNode('view')->addDefaultsIfNotSet()
					->children()
						->arrayNode('frontend')->addDefaultsIfNotSet()
							->children()
								->scalarNode('list')
									->cannotBeEmpty()
									->defaultValue('BrotherQuestBundle:Frontend:index.html.twig')
								->end()
								->scalarNode('new')
									->cannotBeEmpty()
									->defaultValue('BrotherQuestBundle:Frontend:new.html.twig')
								->end()
							->end()
						->end()	
						
						->arrayNode('admin')->addDefaultsIfNotSet()
							->children()
								->scalarNode('list')
									->cannotBeEmpty()
									->defaultValue('BrotherQuestBundle:Admin:index.html.twig')
								->end()
								->scalarNode('edit')
									->cannotBeEmpty()
									->defaultValue('BrotherQuestBundle:Admin:edit.html.twig')
								->end()
								->scalarNode('reply')
									->cannotBeEmpty()
									->defaultValue('BrotherQuestBundle:Admin:reply.html.twig')
								->end()
							->end()
						->end()	
						
						->arrayNode('mail')->addDefaultsIfNotSet()
							->children()
								->scalarNode('notify')
									->cannotBeEmpty()
									->defaultValue('BrotherQuestBundle:Mail:notify.txt.twig')
								->end()
							->end()
						->end()	
						
					->end()
                ->end()
				
                ->arrayNode('form')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('entry')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('name')
									->cannotBeEmpty()
									->defaultValue('brother_quest_entry')
								->end()
                                ->scalarNode('type')
									->cannotBeEmpty()
									->defaultValue('brother_quest_entry')
								->end()
                                ->scalarNode('class')
									->cannotBeEmpty()
									->defaultValue('Brother\QuestBundle\Form\Type\EntryType')
								->end()
                            ->end()
                        ->end()
						->arrayNode('edit')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('name')
									->cannotBeEmpty()
									->defaultValue('brother_quest_entry_edit')
								->end()
                                ->scalarNode('type')
									->cannotBeEmpty()
									->defaultValue('brother_quest_entry_edit')
								->end()
                                ->scalarNode('class')
									->cannotBeEmpty()
									->defaultValue('Brother\QuestBundle\Form\Type\EntryEditType')
								->end()
                            ->end()
                        ->end()
						->arrayNode('reply')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('name')
									->cannotBeEmpty()
									->defaultValue('brother_quest_entry_reply')
								->end()
                                ->scalarNode('type')
									->cannotBeEmpty()
									->defaultValue('brother_quest_entry_reply')
								->end()
                                ->scalarNode('class')
									->cannotBeEmpty()
									->defaultValue('Brother\QuestBundle\Form\Type\EntryReplyType')
								->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('class')->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('mailer')
							->cannotBeEmpty()
							->defaultValue('Brother\QuestBundle\Mailer\Mailer')
						->end()
						->scalarNode('model')->cannotBeEmpty()->end()
						->scalarNode('manager')->cannotBeEmpty()->end()
						->scalarNode('pager')->cannotBeEmpty()->end()
                    ->end()
                ->end()	

                ->arrayNode('service')->addDefaultsIfNotSet()
                    ->children()
						->scalarNode('pager')->cannotBeEmpty()->end()
                        ->scalarNode('mailer')->cannotBeEmpty()->end()
                        ->scalarNode('spam_detector')->cannotBeEmpty()->end()
                    ->end()
                ->end()	
				
            ->end()
        ->end();

        return $treeBuilder;
    }
}
