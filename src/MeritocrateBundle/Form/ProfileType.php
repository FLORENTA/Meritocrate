<?php

// src/AppBundle/Form/RegistrationType.php

namespace MeritocrateBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fullname')
            ->add('gender', ChoiceType::class, array(
                'choices' => array(
                    'Female-identifying' => 'F',
                    'Male-identifying' => 'M',
                    'Non-Binary / Genderfluid' => 'N',
                    'Other' => 'O',
                    'Prefer Not to say' => 'P'
                ),
                'required' => false
            ))
            ->add('dateofbirth', BirthdayType::class, array(
                'required' => false
            ))
            ->add('nationality',CountryType::class, array(
                'multiple' => false,
                'required' => false
            ))
            ->add('picture', FileType::class, array(
                'required' => false,
                'data_class' => null
            ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}