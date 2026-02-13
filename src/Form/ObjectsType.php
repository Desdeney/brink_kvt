<?php

namespace App\Form;

use App\Entity\Objects;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class , [
            'label' => 'Bezeichnung',
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => 'z.B. Mischpult']
        ])
            ->add('brand', TextType::class , [
            'label' => 'Marke',
            'required' => false,
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => 'z.B. Yamaha']
        ])
            ->add('modell', TextType::class , [
            'label' => 'Modell',
            'required' => false,
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => 'z.B. MG16XU']
        ])
            ->add('serial', TextType::class , [
            'label' => 'Seriennummer',
            'required' => false,
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => 'S/N 123456789']
        ])
            ->add('available_amount', IntegerType::class , [
            'label' => 'Bestand',
            'attr' => ['class' => 'form-control form-control-lg', 'placeholder' => 'Anzahl']
        ])
            ->add('price', MoneyType::class , [
            'label' => 'Mietpreis (pro Tag)',
            'currency' => 'EUR',
            'attr' => ['class' => 'form-control form-control-lg']
        ])
            ->add('notes', TextareaType::class , [
            'label' => 'Interne Notizen',
            'required' => false,
            'attr' => ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Weitere Details...']
        ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Objects::class ,
        ]);
    }
}