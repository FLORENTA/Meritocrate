<?php

// src/AppBundle/Form/RegistrationType.php

namespace MeritocrateBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('full_name')
                ->add('gender', ChoiceType::class, array(
                    'choices' => array(
                        'F' => 'Female',
                        'M' => 'Male'
                    )
                ))
                ->add('dateofbirth', DateType::class)
                ->add('nationality',CountryType::class, array(
                    'multiple'=>true
                ))
                ->add('ethnicity')
                ->add('picture', FileType::class);
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}