<?php

namespace App\DataFixtures;

use App\Entity\Appointments;
use App\Entity\Contacts;
use App\Entity\Customer;
use App\Entity\Location;
use App\Entity\Objects;
use App\Entity\Payment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('de_DE');

        // --- Users ---
        $admin = new User();
        $admin->setEmail('admin@brink.va');
        $admin->setUsername('admin');
        $admin->setPrename('Fabian');
        $admin->setLastname('Ernst');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'password'));
        $admin->setIsBlocked(false);
        $manager->persist($admin);

        $users = [$admin];
        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setUsername($faker->userName());
            $user->setPrename($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->hasher->hashPassword($user, 'password'));
            $user->setIsBlocked(false);
            $manager->persist($user);
            $users[] = $user;
        }


        // ... inside load() method
        // --- Payments ---
        $paymentMethods = [];
        $paymentNames = ['Rechnung', 'Bar', 'Vorkasse', 'PayPal'];
        foreach ($paymentNames as $name) {
            $payment = new Payment();
            $payment->setName($name);
            $manager->persist($payment);
            $paymentMethods[] = $payment;
        }

        // --- Customers ---
        $customers = [];
        for ($i = 0; $i < 10; $i++) {
            $customer = new Customer();
            $customer->setPrename($faker->firstName());
            $customer->setLastname($faker->lastName());
            $customer->setStreet($faker->streetName());
            $customer->setHousenr($faker->numberBetween(1, 150));
            $customer->setPostal((int)$faker->postcode());
            $customer->setCity($faker->city());
            $customer->setEmail($faker->email());
            $customer->setPhone($faker->phoneNumber());

            $customer->setPayment($faker->randomElement($paymentMethods));
            $customer->setRequireCash($faker->boolean(20));
            $customer->setRequirePrepaid($faker->boolean(10));

            $manager->persist($customer);
            $customers[] = $customer;
        }

        // --- Contacts ---
        $contacts = [];
        for ($i = 0; $i < 15; $i++) {
            $contact = new Contacts();
            $contact->setPrename($faker->firstName());
            $contact->setLastname($faker->lastName());
            $contact->setEmail($faker->email());
            $contact->setPhone($faker->phoneNumber());
            $manager->persist($contact);
            $contacts[] = $contact;
        }

        // --- Locations ---
        $locations = [];
        for ($i = 0; $i < 8; $i++) {
            $location = new Location();
            $location->setLocationName($faker->company() . ' Events');
            $location->setStreet($faker->streetName());
            $location->setStreetnr((int)$faker->buildingNumber());
            $location->setPostal((int)$faker->postcode());
            $location->setCity($faker->city());
            $location->setNotes($faker->text(100));
            $location->setContactId($faker->randomElement($contacts));
            $manager->persist($location);
            $locations[] = $location;
        }

        // --- Objects ---
        $objects = [];
        $objectNames = ['Lautsprecher', 'Mikrofon', 'Mischpult', 'Scheinwerfer', 'Nebelmaschine', 'Kabelkiste', 'Stativ'];
        foreach ($objectNames as $name) {
            $obj = new Objects();
            $obj->setName($name);
            $obj->setAvailableAmount($faker->numberBetween(2, 20));
            $obj->setPrice($faker->randomFloat(2, 10, 500));
            $manager->persist($obj);
            $objects[] = $obj;
        }

        // --- Appointments ---
        for ($i = 0; $i < 20; $i++) {
            $appointment = new Appointments();
            $appointment->setCustomer($faker->randomElement($customers));
            $appointment->setLocation($faker->randomElement($locations));
            $appointment->setOccasion($faker->randomElement(['Hochzeit', 'Geburtstag', 'Firmenfeier', 'Gala']));

            $date = $faker->dateTimeBetween('-2 months', '+6 months');
            $appointment->setDate($date);

            $appointment->setStartTime($faker->dateTime());
            $appointment->setEndTime($faker->dateTime());

            $appointment->setAttendeesCount($faker->numberBetween(30, 200));
            $appointment->setAttendeesAgeFrom($faker->numberBetween(18, 30));
            $appointment->setAttendeesAgeTo($faker->numberBetween(50, 80));

            $appointment->setPriceDjHour($faker->numberBetween(50, 150));
            $appointment->setPriceDjExtention($faker->numberBetween(50, 150));
            $appointment->setPriceTech($faker->numberBetween(200, 1000));
            $appointment->setPriceApproach($faker->numberBetween(20, 100));

            $appointment->setDeactivated(false);
            $appointment->setIsConfirmed($faker->boolean(70));

            // Add some users
            $appointment->addUser($faker->randomElement($users));

            $manager->persist($appointment);
        }

        $manager->flush();
    }
}