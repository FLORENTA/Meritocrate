<?php

// src/AppBundle/Form/RegistrationType.php

namespace MeritocrateBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fullname')
                ->remove('username')
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
                    'required' => false,
                    'years' => range(date('Y') -20, date('Y') -100)
                ))
                ->add('nationality',CountryType::class, array(
                    'multiple'=> false,
                    'required' => false
                ))
                ->add('picture', FileType::class, array(
                    'required' => false
                ));
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