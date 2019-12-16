<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [new Email()],
                'attr' => [
                    'placeholder' => 'El. paštas'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Jūs turite įvesti slaptažodį'
                    ]),
                    new Length([
                        'min' => '6',
                        'minMessage' => 'Slaptažodžio ilgis turi būti bent 6 simboliai'
                    ])
                ],
                'invalid_message' => 'Slaptažodžių laukai turi sutapti',
                'first_options' => [
                    'label' => 'Slaptažodis',
                    'attr' => [
                        'placeholder' => 'Slaptažodis'
                    ]
                ],
                'second_options' => [
                    'label' => 'Pakartokite slaptažodį',
                    'attr' => [
                        'placeholder' => 'Pakartokite slaptažodį'
                    ]
                ],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}