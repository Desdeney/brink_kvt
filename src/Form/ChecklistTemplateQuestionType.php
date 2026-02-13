<?php

namespace App\Form;

use App\Entity\ChecklistTemplateQuestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChecklistTemplateQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('questionText', TextType::class , [
            'label' => 'Frage',
            'attr' => ['class' => 'form-control']
        ])
            ->add('fieldType', ChoiceType::class , [
            'label' => 'Feldtyp',
            'choices' => [
                'Text' => 'text',
                'Langer Text' => 'textarea',
                'Auswahl (Dropdown)' => 'select',
                'Checkbox' => 'checkbox',
                'Radio' => 'radio'
            ],
            'attr' => ['class' => 'form-select']
        ])
            ->add('isRequired', CheckboxType::class , [
            'label' => 'Pflichtfeld?',
            'required' => false,
            'attr' => ['class' => 'form-check-input']
        ])
            ->add('fieldOptions', TextareaType::class , [
            'label' => 'Optionen (eine pro Zeile, nur für Auswahl/Radio)',
            'required' => false,
            'attr' => ['class' => 'form-control', 'rows' => 2, 'placeholder' => "Option 1\nOption 2"]
        ])
            ->add('position', IntegerType::class , [
            'label' => 'Position',
            'attr' => ['class' => 'form-control']
        ]);

        $builder->get('fieldOptions')->addModelTransformer(new CallbackTransformer(
            function ($optionsArray) {
            return $optionsArray ? implode("\n", $optionsArray) : '';
        },
            function ($optionsString) {
            return $optionsString ? explode("\n", str_replace("\r", "", $optionsString)) : null;
        }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ChecklistTemplateQuestion::class ,
        ]);
    }
}