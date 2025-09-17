<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Payment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prename', null, ['label' => 'Vorname', 'attr' => ['placeholder' => 'Max']])
            ->add('lastname', null, ['label' => 'Nachname', 'attr' => ['placeholder' => 'Mustermann']])
            ->add('street', null, ['label' => 'Strasse', 'attr' => ['placeholder' => 'Strasse']])
            ->add('housenr', null, ['label' => 'Hausnummer', 'attr' => ['placeholder' => '12']])
            ->add('postal', null, ['label' => 'PLZ', 'attr' => ['placeholder' => '26721']])
            ->add('city', null, ['label' => 'Ort', 'attr' => ['placeholder' => 'Musterstadt']])
            ->add('email', null, ['label' => 'E-Mail', 'attr' => ['placeholder' => 'mail@example.com']])
            ->add('phone', null, ['label' => 'Telefon', 'attr' => ['placeholder' => '012345678901']])
            ->add('require_cash', null, ['label' => 'Barzahlung erforderlich', 'data' => false])
            ->add('require_prepaid', null, ['label' => 'Vorkasse erforderlich', 'data' => false])
            ->add('payment', EntityType::class, [
                'class' => Payment::class,
                'choice_value' => 'id',
                'choice_label' => 'name',
                'label' => 'Zahlungsart',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
