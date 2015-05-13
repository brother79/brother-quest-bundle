<?php

/*
 * This file is part of the BrotherQuestBundle
 *
 * (c) Yos Okusanya <yos.okusanya@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Brother\QuestBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntryType extends AbstractType
{	
    /**
     * @var string
     */
    private $entryClass;

    /**
     * Constructor
     *
     * @param string $entryClass
     */
    public function __construct($entryClass)
    {
        $this->entryClass = $entryClass;
    }

    /**
     * {@inheritdoc}
     */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
        $builder->add('name', 'text', array(
                'label' => 'form.entry.name',
                'translation_domain' => 'BrotherQuestBundle'
            ))
            ->add('email', 'email', array(
                'label' => 'form.entry.email',
                'translation_domain' => 'BrotherQuestBundle',
            ))
            ->add('comment', 'textarea', array(
                'label' => 'form.entry.comment',
                'translation_domain' => 'BrotherQuestBundle',
            ))
            ->getForm();
	}

    /**
     * {@inheritdoc}
     */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array('data_class' => $this->entryClass));
	}

    /**
     * {@inheritdoc}
     */
	public function getName()
	{
		return 'brother_quest_entry';
	}
}