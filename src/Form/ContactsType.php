<?php

namespace App\Form;

use App\Entity\Contacts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prename', null, [
            'label' => 'Vorname',
            'attr' => ['placeholder' => 'Vorname eingeben']
        ])
            ->add('lastname', null, [
            'label' => 'Nachname',
            'attr' => ['placeholder' => 'Nachname eingeben']
        ])
            ->add('email', null, [
            'label' => 'E-Mail',
            'attr' => ['placeholder' => 'email@beispiel.de']
        ])
            ->add('phone', null, [
            'label' => 'Telefon',
            'attr' => ['placeholder' => '+49 123 456789']
        ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contacts::class ,
        ]);
    }
}