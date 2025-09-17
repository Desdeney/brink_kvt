<?php

namespace App\Controller;

use App\Entity\Appointments;
use App\Form\AppointmentsType;
use App\Repository\AppointmentsRepository;
use App\Entity\Customer;
use App\Entity\Location;
use App\Service\EventMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/appointments')]
final class AppointmentsController extends AbstractController
{
    #[Route(name: 'app_appointments_index', methods: ['GET'])]
    public function index(AppointmentsRepository $appointmentsRepository): Response
    {
        $appointments = $appointmentsRepository->findActiveAppointments();
        $inactiveappointments = $appointmentsRepository->findInactiveAppointments();

        return $this->render('appointments/index.html.twig', [
            'appointments' => $appointments,
            'inactive' => $inactiveappointments,
        ]);
    }

    #[Route('/new', name: 'app_appointments_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, EventMailer $eventMailer): Response
    {
        $appointment = new Appointments();
        $form = $this->createForm(AppointmentsType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // 1) Falls KEIN bestehender Kunde gewählt wurde, aber "Neuer Kunde" ausgefüllt ist → anlegen
            if (null === $appointment->getCustomer()) {
                if ($newCustomer = $this->getSubmittedNewCustomer($form)) {
                    $entityManager->persist($newCustomer);
                    $appointment->setCustomer($newCustomer);
                }
            }

            // 2) Falls KEINE bestehende Location gewählt wurde, aber "Neue Location" ausgefüllt ist → anlegen
            if (null === $appointment->getLocation()) {
                if ($newLocation = $this->getSubmittedNewLocation($form)) {
                    $entityManager->persist($newLocation);
                    $appointment->setLocation($newLocation);
                }
            }

            $appointment->setDeactivated(false);
            $entityManager->persist($appointment);
            $entityManager->flush();

            $eventMailer->sendAppointmentNotification($appointment);

            return $this->redirectToRoute('app_appointments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('appointments/new.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_appointments_show', methods: ['GET'])]
    public function show(Appointments $appointment): Response
    {
        return $this->render('appointments/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_appointments_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appointments $appointment, EntityManagerInterface $entityManager, EventMailer $eventMailer): Response
    {
        $form = $this->createForm(AppointmentsType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Gleiches Prinzip wie in new():
            if (null === $appointment->getCustomer()) {
                if ($newCustomer = $this->getSubmittedNewCustomer($form)) {
                    $entityManager->persist($newCustomer);
                    $appointment->setCustomer($newCustomer);
                }
            }

            if (null === $appointment->getLocation()) {
                if ($newLocation = $this->getSubmittedNewLocation($form)) {
                    $entityManager->persist($newLocation);
                    $appointment->setLocation($newLocation);
                }
            }

            // Bei Edit reicht flush(), persist ist nicht nötig solange die Entitäten gemanaged sind
            $entityManager->flush();

            $eventMailer->sendAppointmentNotification($appointment);

            return $this->redirectToRoute('app_appointments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('appointments/edit.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_appointments_delete', methods: ['POST'])]
    public function delete(Request $request, Appointments $appointment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appointment->getId(), $request->getPayload()->getString('_token'))) {
            $appointment->setDeactivated(true);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_appointments_index', [], Response::HTTP_SEE_OTHER);
    }

    private function getSubmittedNewCustomer(FormInterface $form): ?Customer
    {
        /** @var ?Customer $c */
        $c = $form->get('customer')->getData();
        if (!$c instanceof Customer) {
            return null;
        }
        // "Leer?"-Heuristik – passe Felder nach Bedarf an
        $vals = [
            $c->getPrename(),
            $c->getLastname(),
            $c->getEmail(),
            $c->getStreet(),
            $c->getCity(),
            $c->getPostal(),
        ];
        $allEmpty = true;
        foreach ($vals as $v) {
            if ($v !== null && $v !== '') { $allEmpty = false; break; }
        }
        return $allEmpty ? null : $c;
    }

    private function getSubmittedNewLocation(FormInterface $form): ?Location
    {
        /** @var ?Location $l */
        $l = $form->get('location')->getData();
        if (!$l instanceof Location) {
            return null;
        }
        $vals = [
            $l->getLocationName(),
            $l->getStreet(),
            $l->getCity(),
            $l->getPostal(),
        ];
        $allEmpty = true;
        foreach ($vals as $v) {
            if ($v !== null && $v !== '') { $allEmpty = false; break; }
        }
        return $allEmpty ? null : $l;
    }
}
