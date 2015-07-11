<?php

namespace Brother\QuestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('q')
            ->add('a')
            ->add('email')
            ->add('executor')
            ->add('comment')
            ->add('priority')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Brother\QuestBundle\Entity\Quest'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'brother_questbundle_quest';
    }
}
