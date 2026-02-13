<?php

namespace App\Form;

use App\Entity\Contacts;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('location_name', null, [
            'label' => 'Name der Location',
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => 'z.B. Stadthalle']
        ])
            ->add('street', null, [
            'label' => 'Straße',
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => 'Musterstraße']
        ])
            ->add('streetnr', null, [
            'label' => 'Hausnr.',
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => '12']
        ])
            ->add('postal', null, [
            'label' => 'PLZ',
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => '12345']
        ])
            ->add('city', null, [
            'label' => 'Ort',
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => 'Musterstadt']
        ])
            ->add('notes', null, [
            'label' => 'Zusatzinfos / Wegbeschreibung',
            'attr' => ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Stockwerk, Hintereingang, etc.']
        ])
            ->add('contact_id', EntityType::class , [
            'class' => Contacts::class ,
            'label' => 'Kontaktperson (Vorhanden)',
            'choice_value' => 'id',
            'choice_label' => function (Contacts $contact) {
            return $contact->getPrename() . ' ' . $contact->getLastname();
        },
            'required' => false,
            'placeholder' => 'Bitte wählen',
        ])
            ->add('new_contact', ContactsType::class , [
            'mapped' => false,
            'required' => false,
            'label' => 'Neue Kontaktperson anlegen',
        ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class ,
        ]);
    }
}