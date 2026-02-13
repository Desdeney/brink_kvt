<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\Objects;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('object_id', EntityType::class , [
            'class' => Objects::class ,
            'choice_label' => 'name',
            'label' => 'Objekt',
            'attr' => ['class' => 'form-select select-object']
        ])
            ->add('amount', IntegerType::class , [
            'label' => 'Anzahl',
            'attr' => ['class' => 'form-control', 'min' => 1]
        ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class ,
        ]);
    }
}