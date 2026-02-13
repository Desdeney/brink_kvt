<?php

namespace App\Form;

use App\Entity\MusicQuestionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MusicQuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('genres', ChoiceType::class , [
            'label' => 'Welche Genres sollen gespielt werden?',
            'choices' => [
                'Pop' => 'Pop',
                'Rock' => 'Rock',
                'Schlager' => 'Schlager',
                '90er' => '90er',
                '2000er' => '2000er',
                'Charts' => 'Charts',
                'House' => 'House',
                'RnB' => 'RnB',
                'Oldies' => 'Oldies',
            ],
            'multiple' => true,
            'expanded' => true,
            'required' => false,
        ])
            ->add('mustHaves', TextareaType::class , [
            'label' => 'Must Haves (Titel/Interpreten)',
            'required' => false,
            'attr' => ['rows' => 5],
            'help' => 'Lieder, die unbedingt gespielt werden sollen.'
        ])
            ->add('noGos', TextareaType::class , [
            'label' => 'No Gos (Titel/Interpreten/Genres)',
            'required' => false,
            'attr' => ['rows' => 5],
            'help' => 'Lieder, die auf keinen Fall gespielt werden sollen.'
        ])
            ->add('atmosphere', TextareaType::class , [
            'label' => 'Gewünschte Atmosphäre / Sonstiges',
            'required' => false,
            'attr' => ['rows' => 5],
        ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MusicQuestionnaire::class ,
        ]);
    }
}