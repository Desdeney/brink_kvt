<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class , [
            'label' => 'Email Adresse',
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => 'beispiel@email.de']
        ])
            ->add('username', TextType::class , [
            'label' => 'Benutzername',
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => 'benutzername']
        ])
            ->add('prename', TextType::class , [
            'label' => 'Vorname',
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => 'Vorname']
        ])
            ->add('lastname', TextType::class , [
            'label' => 'Nachname',
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => 'Nachname']
        ])
            ->add('password', PasswordType::class , [
            'mapped' => false,
            'required' => false,
            'label' => 'Passwort (leer lassen für keine Änderung)',
            'attr' => [
                'autocomplete' => 'new-password',
                'class' => 'form-control form-control-lg',
                'placeholder' => '••••••••'
            ],
            'constraints' => [
                new Length([
                    'min' => 6,
                    'minMessage' => 'Passwort muss mindestens {{ limit }} Zeichen lang sein',
                    'max' => 4096,
                ]),
            ],
        ])
            ->add('roles', ChoiceType::class , [
            'label' => 'Berechtigungen',
            'choices' => [
                'Administrator' => 'ROLE_ADMIN',
                'Benutzer' => 'ROLE_USER',
            ],
            'multiple' => true,
            'expanded' => true,
            'label_attr' => ['class' => 'fw-bold'],
            'attr' => ['class' => 'd-flex gap-3 mt-2']
        ])
            ->add('isBlocked', ChoiceType::class , [
            'label' => 'Status',
            'choices' => [
                'Aktiv' => false,
                'Gesperrt' => true,
            ],
            'expanded' => true,
            'multiple' => false,
            'attr' => ['class' => 'd-flex gap-3 mt-2']
        ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class ,
        ]);
    }
}