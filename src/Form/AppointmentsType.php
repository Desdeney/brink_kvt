<?php

namespace App\Form;

use App\Entity\Appointments;
use App\Entity\Customer;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer', CustomerType::class, [
                'label' => false
            ])
            ->add('location', LocationType::class, [
                'label' => false
            ])
            ->add('occasion', options:[
                'label' => 'Veranstaltungsart'
            ])
            ->add('date', null, [
                'widget' => 'choice',
                'format' => 'dd.MM.yyyy',
            ])
            ->add('start_time', null, [
                'widget' => 'choice',
            ])
            ->add('end_time', null, [
                'widget' => 'choice',
            ])
            ->add('is_confirmed', CheckboxType::class, [
                'required' => false,  // Checkbox muss nicht zwingend ausgewählt sein
                'false_values' => [null, false, '0'], // Diese Werte werden als "false" betrachtet
                'empty_data' => '0',  // Falls nichts übergeben wird, setze Standardwert auf "0"
                'label' => 'Termin bestätigt?',
            ])
            ->add('setup_with_location',  CheckboxType::class, [
                'required' => false,  // Checkbox muss nicht zwingend ausgewählt sein
                'false_values' => [null, false, '0'], // Diese Werte werden als "false" betrachtet
                'empty_data' => '0',  // Falls nichts übergeben wird, setze Standardwert auf "0"
                'label' => 'Aufbau mit Location abklären?',
            ])
            ->add('teardown_with_location',  CheckboxType::class, [
                'required' => false,  // Checkbox muss nicht zwingend ausgewählt sein
                'false_values' => [null, false, '0'], // Diese Werte werden als "false" betrachtet
                'empty_data' => '0',  // Falls nichts übergeben wird, setze Standardwert auf "0"
                'label' => 'Abbau mit Location abklären?',
            ])
            ->add('setup_date', null, [
                'widget' => 'choice',
                'format' => 'dd MM yyyy',
                'label' => 'Datum (Aufbau)',
                'label_attr' => ['class' => 'setup_date'],
                'attr' => ['class' => 'setup_date'],
            ])
            ->add('setup_time', null, [
                'widget' => 'choice',
                'label' => 'Zeit (Aufbau)',
            ])
            ->add('teardown_date', null, [
                'widget' => 'choice',
                'format' => 'dd MM yyyy',
                'label' => 'Datum (Abbau)',
            ])
            ->add('teardown_time', null, [
                'widget' => 'choice',
                'label' => 'Zeit (Abbau)',
            ])
            ->add('attendees_count', options:['label' => 'Anzahl der Teilnehmer'])
            ->add('attendees_age_from')
            ->add('attendees_age_to')
            ->add('attendees_notes')
            ->add('music_pdf_path')
            ->add('dj_notes')
            ->add('price_dj_hour')
            ->add('price_dj_extention')
            ->add('price_tech')
            ->add('price_approach')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointments::class,
        ]);
    }
}
