<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\Payment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Customer1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prename')
            ->add('lastname')
            ->add('street')
            ->add('housenr')
            ->add('postal')
            ->add('city')
            ->add('email')
            ->add('phone')
            ->add('require_cash')
            ->add('require_prepaid')
            ->add('payment', EntityType::class, [
                'class' => Payment::class,
                'choice_label' => 'id',
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
