<?php

namespace App\Controller;

use App\Entity\MusicQuestionnaire;
use App\Form\MusicQuestionnaireType;
use App\Repository\AppointmentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/c')]
class MusicQuestionnaireController extends AbstractController
{
    #[Route('/{token}/music', name: 'app_customer_music_questionnaire', methods: ['GET', 'POST'])]
    public function index(string $token, Request $request, AppointmentsRepository $appointmentsRepository, EntityManagerInterface $entityManager): Response
    {
        $appointment = $appointmentsRepository->findOneBy(['token' => $token]);

        if (!$appointment) {
            throw $this->createNotFoundException('Appointment not found');
        }

        // Check if a questionnaire already exists
        $questionnaire = $entityManager->getRepository(MusicQuestionnaire::class)->findOneBy(['appointment' => $appointment]);

        if (!$questionnaire) {
            $questionnaire = new MusicQuestionnaire();
            $questionnaire->setAppointment($appointment);
        }

        $form = $this->createForm(MusicQuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionnaire->setIsSubmitted(true);
            $entityManager->persist($questionnaire);
            $entityManager->flush();

            $this->addFlash('success', 'Vielen Dank! Ihre Musikwünsche wurden gespeichert.');

            return $this->redirectToRoute('app_customer_appointment_view', ['token' => $token], Response::HTTP_SEE_OTHER);
        }

        return $this->render('customer_appointment/music_questionnaire.html.twig', [
            'appointment' => $appointment,
            'form' => $form->createView(),
        ]);
    }
}