<?php

namespace App\Form;

use App\Entity\AppointmentDocument;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AppointmentDocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class , [
            'label' => 'Dokument (PDF, Bild)',
            'mapped' => false,
            'required' => true,
            'constraints' => [
                new File([
                    'maxSize' => '10M',
                    'mimeTypes' => [
                        'application/pdf',
                        'application/x-pdf',
                        'image/*',
                    ],
                    'mimeTypesMessage' => 'Bitte laden Sie ein gültiges PDF oder Bild hoch',
                ])
            ],
        ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AppointmentDocument::class ,
        ]);
    }
}