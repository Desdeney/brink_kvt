<?php

namespace App\Form;

use App\Entity\Contacts;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('location_name', null, ['label' => 'Name der Location', 'attr' => ['placeholder' => 'Muster Locaton']])
            ->add('street', null, ['label' => 'Strasse', 'attr' => ['placeholder' => 'Strasse']],)
            ->add('streetnr', null, ['label' => 'Hausnummer', 'attr' => ['placeholder' => '12']])
            ->add('postal', null, ['label' => 'PLZ', 'attr' => ['placeholder' => '26721']])
            ->add('city', null, ['label' => 'Ort', 'attr' => ['placeholder' => 'Musterstadt']])
            ->add('notes', null, ['label' => 'Notizen zur Location', 'attr' => ['placeholder' => 'Hier Notizen hinterlegen']])
            ->add('contact_id', EntityType::class, [
                'class' => Contacts::class,
                'label' => 'Kontaktperson',
                'choice_value' => 'id',
                'choice_label' => function(Contacts $contact) {
                    return $contact->getPrename() . ' ' . $contact->getLastname();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
