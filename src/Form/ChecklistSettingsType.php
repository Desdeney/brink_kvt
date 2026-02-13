<?php

namespace App\Form;

use App\Entity\Checklist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChecklistSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class , [
            'label' => 'Titel der Checkliste',
            'attr' => ['class' => 'form-control']
        ])
            ->add('isPublic', CheckboxType::class , [
            'label' => 'Öffentlich zugänglich?',
            'required' => false,
            'attr' => ['class' => 'form-check-input']
        ])
            ->add('publicPassword', TextType::class , [
            'label' => 'Passwort für öffentlichen Zugriff (optional)',
            'required' => false,
            'attr' => ['class' => 'form-control', 'placeholder' => 'Leer lassen für kein Passwort']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Checklist::class ,
        ]);
    }
}