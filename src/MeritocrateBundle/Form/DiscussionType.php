<?php

namespace MeritocrateBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiscussionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class, array(
                'required' => false
            ))
            ->add('name')
            ->add('ongoing', ChoiceType::class, array(
                'choices'  => array(
                    'Open' => true,
                    'Close' => false,
                ),
                'multiple' => false,
                'expanded' => false,
                'required' => false
            ))
            ->add('privacy', ChoiceType::class, array(
                'choices' => array(
                    'public' => false,
                    'private' => true
                ),
                'multiple' => false,
                'expanded' => false,
                'required' => true
            ))
            ->add('password', TextType::class, array(
                'required' => false
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MeritocrateBundle\Entity\Discussion'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'meritocratebundle_discussion';
    }


}
