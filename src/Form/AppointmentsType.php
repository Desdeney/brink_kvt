<?php

namespace App\Form;

use App\Entity\Appointments;
use App\Entity\Customer;
use App\Entity\Location;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customerSelect', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => fn(Customer $c) => sprintf('%s %s — %s %s, %s %s',
                    $c->getPrename(), $c->getLastname(),
                    $c->getStreet(), $c->getHousenr(),
                    $c->getPostal(), $c->getCity()
                ),
                'placeholder' => 'Bitte wählen',
                'required' => false,
                'label' => 'Kunde',
                'mapped' => true,
                'property_path' => 'customer',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('locationSelect', EntityType::class, [
                'class' => Location::class,
                'choice_label' => fn(Location $l) => sprintf('%s — %s %s, %s %s',
                    $l->getLocationName(), $l->getStreet(), $l->getStreetnr(),
                    $l->getPostal(), $l->getCity()
                ),
                'placeholder' => 'Bitte wählen',
                'required' => false,
                'mapped' => true,
                'label' => 'Location',
                'property_path' => 'location',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('customer', CustomerType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
            ])
            ->add('location', LocationType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
            ])
            ->add('users', EntityType::class, [
                'class'         => User::class,
                'choice_label'  => 'fullName',
                'multiple'      => true,     // mehrere auswählbar
                'expanded'      => true,     // als Checkboxen rendern
                'by_reference'  => false,    // ruft addUser()/removeUser() auf
                'required'      => false,
                'label'         => 'Verantwortliche',
            ])
            ->add('occasion', options:[
                'label' => 'Veranstaltungsart'
            ])
            ->add('date', DateType::class, [
                'widget' => 'choice',
                'format' => 'dd.MM.yyyy',
                'label' => 'Datum der Veranstaltung',
                'input'  => 'datetime',         // bei DateTimeImmutable: 'datetime_immutable'
                'placeholder' => [           // damit die Felder wirklich leer starten
                    'year'  => 'Jahr',
                    'month' => 'Monat',
                    'day'   => 'Tag',
                ],
            ])
            ->add('start_time', TimeType::class, [
                'widget' => 'choice',
                'label'  => 'Beginn der Veranstaltung',
                'input'  => 'datetime',
                'placeholder' => [
                    'hour' => '18',
                    'minute' => '00',
                ],
                'minutes' => [0, 15, 30, 45],
            ])

            ->add('end_time', TimeType::class, [
                'widget'     => 'choice',
                'label'      => 'Ende der Veranstaltung',
                'input'      => 'datetime',
                'required'   => false,      // weil dein Setter null erlaubt
                'empty_data' => null,
                'placeholder' => [
                    'hour' => '02',
                    'minute' => '00',
                ],
                'minutes' => [0, 15, 30, 45],
                // optional: Minutenraster
                // 'minutes' => [0, 15, 30, 45],
            ])
            ->add('is_confirmed', CheckboxType::class, [
                'label' => 'Termin bestätigt?',
                'required' => false,
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
            ->add('attendees_age_from', options:['label' => 'Alter von'])
            ->add('attendees_age_to', options:['label' => 'Alter bis'])
            ->add('attendees_notes', options:['label' => 'Anmerkungen zum Publikum'])
            ->add('musicPdfPath', options:['label' => 'PDF mit Musikbeschreibung', 'data'=>'folgt'])
            ->add('dj_notes', options:['label' => 'Anmerkungen für den DJ'])
            ->add('price_dj_hour', options:['label' => 'Preis (DJ) / Std.'])
            ->add('price_dj_extention', options:['label' => 'Preis (Verlängerung)'])
            ->add('price_tech', options:['label' => 'Preis Technik'])
            ->add('price_approach', options:['label' => 'Preis Anfahrt'])
            ->add('save', SubmitType::class, [
                'label' => 'Speichern',
                'attr' => ['class' => 'btn btn-primary']
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointments::class,
        ]);
    }
}
