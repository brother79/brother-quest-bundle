<?php

/*
 * This file is part of the RPSGuestbookBundle
 *
 * (c) Yos Okusanya <yos.okusanya@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace RPS\GuestbookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntryEditType extends AbstractType
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
                'translation_domain' => 'RPSGuestbookBundle'
            ))
            ->add('email', 'email', array(
                'label' => 'form.entry.email',
                'translation_domain' => 'RPSGuestbookBundle',
            ))
            ->add('comment', 'textarea', array(
                'label' => 'form.entry.message',
                'translation_domain' => 'RPSGuestbookBundle',
            ))
            ->add('state', 'choice', array(
                'label' => 'form.entry.state',
                'translation_domain' => 'RPSGuestbookBundle',
                'choices' => array(0 => 'no', 1 => 'yes'),
                'multiple' => false,
                'expanded' => false,
            ))
            ->add('createdAt', 'datetime', array(
                'label' => 'form.entry.created',
                'translation_domain' => 'RPSGuestbookBundle',
                'with_seconds' => true,
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
		return 'brother_quest_entry_edit';
	}
}