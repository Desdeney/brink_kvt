<?php

namespace App\Controller;

use App\Entity\Appointments;
use App\Repository\AppointmentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/c')]
class CustomerAppointmentController extends AbstractController
{
    #[Route('/{token}', name: 'app_customer_appointment_view', methods: ['GET'])]
    public function view(string $token, AppointmentsRepository $appointmentsRepository): Response
    {
        $appointment = $appointmentsRepository->findOneBy(['token' => $token]);

        if (!$appointment) {
            throw $this->createNotFoundException('Appointment not found');
        }

        return $this->render('customer_appointment/index.html.twig', [
            'appointment' => $appointment,
        ]);
    }
}