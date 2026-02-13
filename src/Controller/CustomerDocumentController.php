<?php

namespace App\Controller;

use App\Entity\AppointmentDocument;
use App\Form\AppointmentDocumentType;
use App\Repository\AppointmentsRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/c')]
class CustomerDocumentController extends AbstractController
{
    #[Route('/{token}/documents', name: 'app_customer_documents', methods: ['GET', 'POST'])]
    public function index(string $token, Request $request, AppointmentsRepository $appointmentsRepository, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $appointment = $appointmentsRepository->findOneBy(['token' => $token]);

        if (!$appointment) {
            throw $this->createNotFoundException('Appointment not found');
        }

        $document = new AppointmentDocument();
        $form = $this->createForm(AppointmentDocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();
            if ($file) {
                $filename = $fileUploader->upload($file);
                $document->setFilename($filename);
                $document->setOriginalName($file->getClientOriginalName());
                $document->setAppointment($appointment);
                
                $entityManager->persist($document);
                $entityManager->flush();

                $this->addFlash('success', 'Dokument erfolgreich hochgeladen.');
            }

            return $this->redirectToRoute('app_customer_documents', ['token' => $token], Response::HTTP_SEE_OTHER);
        }

        return $this->render('customer_appointment/documents.html.twig', [
            'appointment' => $appointment,
            'form' => $form->createView(),
            'documents' => $appointment->getDocuments(), // Assuming getDocuments relation exists
        ]);
    }
}