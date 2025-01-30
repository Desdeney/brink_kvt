<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Payment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prename',TextType::class ,options: ['label' => 'Vorname', 'attr' => ['placeholder' => 'Max']])
            ->add('lastname',TextType::class ,options: ['label' => 'Nachname', 'attr' => ['placeholder' => 'Mustermann']])
            ->add('street',TextType::class ,options: ['label' => 'Straße', 'attr' => ['placeholder' => 'Musterstraße']])
            ->add('housenr',NumberType::class ,options: ['label' => 'Hausnummer', 'attr' => ['placeholder' => '13']])
            ->add('postal',TextType::class ,options: ['label' => 'Postleitzahl', 'attr' => ['placeholder' => '12345']])
            ->add('city',TextType::class ,options: ['label' => 'Stadt', 'attr' => ['placeholder' => 'Musterstadt']])
            ->add('email',EmailType::class ,options: ['label' => 'E-Mail', 'attr' => ['placeholder' => 'max@example.com']])
            ->add('phone',TextType::class ,options: ['label' => 'Telefonnr.', 'attr' => ['placeholder' => '0123456789']])
            ->add('payment', EntityType::class, [
                'class' => Payment::class, // Die Entität, die die Zahlungsoptionen repräsentiert
                'choice_label' => 'name', // Das Feld in der Entität, das im Dropdown angezeigt wird (z. B. "name")
                'label' => 'Zahlungsart', // Label für das Formularfeld
                'placeholder' => 'Bitte wählen', // Optional: Platzhalter für leere Auswahl
                'required' => true, // Optional: Macht das Feld erforderlich
            ])
            ->add('require_cash',CheckboxType::class, ['label' => 'Barzahlung erforderlich', 'required' => false , 'value' => '1'])
            ->add('require_prepaid',CheckboxType::class, ['label' => 'Anzahlung erforderlich','required' => false ,  'value' => '1'])
            ->add('save', SubmitType::class, ["label" => "Speichern"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
