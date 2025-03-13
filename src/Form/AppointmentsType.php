<?php

namespace App\Form;

use App\Entity\Appointments;
use App\Entity\Customer;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('occasion')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('start_time', null, [
                'widget' => 'single_text',
            ])
            ->add('end_time', null, [
                'widget' => 'single_text',
            ])
            ->add('is_confirmed')
            ->add('setup_with_location')
            ->add('teardown_with_location')
            ->add('setup_date', null, [
                'widget' => 'single_text',
            ])
            ->add('setup_time', null, [
                'widget' => 'single_text',
            ])
            ->add('teardown_date', null, [
                'widget' => 'single_text',
            ])
            ->add('teardown_time', null, [
                'widget' => 'single_text',
            ])
            ->add('attendees_count')
            ->add('attendees_age_from')
            ->add('attendees_age_to')
            ->add('attendees_notes')
            ->add('music_pdf_path')
            ->add('dj_notes')
            ->add('price_dj_hour')
            ->add('price_dj_extention')
            ->add('price_tech')
            ->add('price_approach')
            ->add('customer', EntityType::class, [
                'class' => Customer::class,
                'choice_label' => function (Customer $customer) {
                    return $customer->getPrename() . ' ' . $customer->getLastname();
                },
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'locationname',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointments::class,
        ]);
    }
}
