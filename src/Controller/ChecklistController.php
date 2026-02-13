<?php

namespace App\Controller;

use App\Entity\Appointments;
use App\Entity\Checklist;
use App\Entity\ChecklistQuestion;
use App\Form\ChecklistSettingsType;
use App\Repository\ChecklistRepository;
use App\Repository\ChecklistTemplateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class ChecklistController extends AbstractController
{
    #[Route('/appointments/{id}/checklist/add', name: 'app_checklist_add', methods: ['POST'])]
    public function addChecklist(Request $request, Appointments $appointment, ChecklistTemplateRepository $templateRepository, EntityManagerInterface $entityManager): Response
    {
        $templateId = $request->request->get('template_id');
        $checklist = new Checklist();
        $checklist->setAppointment($appointment);
        
        if ($templateId) {
            $template = $templateRepository->find($templateId);
            if ($template) {
                $checklist->setTitle($template->getName());
                foreach ($template->getQuestions() as $tplQuestion) {
                    $question = new ChecklistQuestion();
                    $question->setQuestionText($tplQuestion->getQuestionText());
                    $question->setFieldType($tplQuestion->getFieldType());
                    $question->setFieldOptions($tplQuestion->getFieldOptions());
                    $question->setIsRequired($tplQuestion->isRequired());
                    $question->setPosition($tplQuestion->getPosition());
                    $checklist->addQuestion($question);
                }
            }
        } else {
            $checklist->setTitle('Eigene Checkliste');
        }

        $entityManager->persist($checklist);
        $entityManager->flush();

        $this->addFlash('success', 'Checkliste wurde zum Termin hinzugefügt.');

        return $this->redirectToRoute('app_checklist_show', ['id' => $checklist->getId()]);
    }

    #[Route('/checklist/{id}', name: 'app_checklist_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Checklist $checklist, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChecklistSettingsType::class, $checklist);
        
        if ($request->isMethod('POST')) {
            // Check WHICH form was submitted
            if ($request->request->has('responses')) {
                // Handle responses
                $data = $request->request->all('responses');
                foreach ($checklist->getQuestions() as $question) {
                    $val = $data[$question->getId()] ?? null;
                    if ($question->getFieldType() === 'checkbox') {
                        $question->setAnswer($val ? '1' : null);
                    } else {
                        if (is_array($val)) {
                            $question->setAnswer(json_encode($val));
                        } else {
                            $question->setAnswer($val);
                        }
                    }
                }
                $checklist->setIsCompleted(true);
                $checklist->setCompletedAt(new \DateTime());
                $entityManager->flush();

                $this->addFlash('success', 'Antworten wurden gespeichert.');
                return $this->redirectToRoute('app_checklist_show', ['id' => $checklist->getId()]);
            } else {
                // Handle settings form
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager->flush();
                    $this->addFlash('success', 'Checklisten-Einstellungen gespeichert.');
                    return $this->redirectToRoute('app_checklist_show', ['id' => $checklist->getId()]);
                }
            }
        }

        return $this->render('checklist/show.html.twig', [
            'checklist' => $checklist,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/checklist/public/{token}', name: 'app_checklist_public', methods: ['GET', 'POST'])]
    public function publicShow(Request $request, string $token, ChecklistRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $checklist = $repository->findOneBy(['publicToken' => $token]);
        if (!$checklist || !$checklist->isPublic()) {
            throw $this->createNotFoundException('Checkliste nicht gefunden oder nicht öffentlich.');
        }

        // Password check
        if ($checklist->getPublicPassword()) {
            $session = $request->getSession();
            $sessionKey = 'checklist_auth_' . $checklist->getId();
            
            if ($request->isMethod('POST') && $request->request->has('password')) {
                if ($request->request->get('password') === $checklist->getPublicPassword()) {
                    $session->set($sessionKey, true);
                } else {
                    return $this->render('checklist/public_password.html.twig', [
                        'checklist' => $checklist,
                        'error' => 'Ungültiges Passwort.',
                    ]);
                }
            }

            if (!$session->get($sessionKey)) {
                return $this->render('checklist/public_password.html.twig', [
                    'checklist' => $checklist,
                    'error' => null,
                ]);
            }
        }

        if ($request->isMethod('POST') && $request->request->has('responses')) {
            $data = $request->request->all('responses');
            foreach ($checklist->getQuestions() as $question) {
                $val = $data[$question->getId()] ?? null;
                if ($question->getFieldType() === 'checkbox') {
                    $question->setAnswer($val ? '1' : null);
                } else {
                    if (is_array($val)) {
                        $question->setAnswer(json_encode($val));
                    } else {
                        $question->setAnswer($val);
                    }
                }
            }
            $checklist->setIsCompleted(true);
            $checklist->setCompletedAt(new \DateTime());
            $entityManager->flush();

            return $this->render('checklist/submitted.html.twig', [
                'checklist' => $checklist,
            ]);
        }

        return $this->render('checklist/public_show.html.twig', [
            'checklist' => $checklist,
        ]);
    }

    #[Route('/checklist/{id}/toggle-public', name: 'app_checklist_toggle_public', methods: ['POST'])]
    public function togglePublic(Checklist $checklist, EntityManagerInterface $entityManager): Response
    {
        $checklist->setIsPublic(!$checklist->isPublic());
        $entityManager->flush();

        return $this->redirectToRoute('app_appointments_show', ['id' => $checklist->getAppointment()->getId()]);
    }

    #[Route('/checklist/{id}/add-question', name: 'app_checklist_question_add', methods: ['POST'])]
    public function addQuestion(Request $request, Checklist $checklist, EntityManagerInterface $entityManager): Response
    {
        $text = $request->request->get('question_text');
        $type = $request->request->get('field_type', 'text');
        
        if ($text) {
            $question = new ChecklistQuestion();
            $question->setQuestionText($text);
            $question->setFieldType($type);
            $question->setPosition(count($checklist->getQuestions()));
            $checklist->addQuestion($question);
            $entityManager->persist($question);
            $entityManager->flush();
            $this->addFlash('success', 'Frage hinzugefügt.');
        }

        return $this->redirectToRoute('app_checklist_show', ['id' => $checklist->getId()]);
    }

    #[Route('/checklist/question/{id}/delete', name: 'app_checklist_question_delete', methods: ['POST'])]
    public function deleteQuestion(ChecklistQuestion $question, EntityManagerInterface $entityManager): Response
    {
        $checklistId = $question->getChecklist()->getId();
        $entityManager->remove($question);
        $entityManager->flush();

        return $this->redirectToRoute('app_checklist_show', ['id' => $checklistId]);
    }

    #[Route('/checklist/{id}/pdf', name: 'app_checklist_pdf', methods: ['GET'])]
    public function downloadPdf(Checklist $checklist): Response
    {
        $html = $this->renderView('checklist/pdf.html.twig', [
            'checklist' => $checklist,
        ]);

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = sprintf('Checkliste_%s_%s.pdf', 
            str_replace([' ', '/', '\\'], '_', $checklist->getTitle()), 
            $checklist->getAppointment()->getDate()?->format('Y-m-d') ?? 'Termin'
        );

        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
        ]);
    }

    #[Route('/checklist/{id}/email', name: 'app_checklist_email', methods: ['POST'])]
    public function sendEmail(Checklist $checklist, \App\Service\EventMailer $eventMailer): Response
    {
        $html = $this->renderView('checklist/pdf.html.twig', [
            'checklist' => $checklist,
        ]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $pdfContent = $dompdf->output();

        $eventMailer->sendChecklist($checklist, $pdfContent);

        $this->addFlash('success', 'E-Mail mit Checkliste wurde versendet.');

        return $this->redirectToRoute('app_checklist_show', ['id' => $checklist->getId()]);
    }

    #[Route('/checklist/{id}/delete', name: 'app_checklist_delete', methods: ['POST'])]
    public function deleteChecklist(Request $request, Checklist $checklist, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $checklist->getId(), $request->request->get('_token'))) {
            $appointmentId = $checklist->getAppointment()->getId();
            $entityManager->remove($checklist);
            $entityManager->flush();
            $this->addFlash('success', 'Checkliste gelöscht.');
            return $this->redirectToRoute('app_appointments_show', ['id' => $appointmentId]);
        }

        return $this->redirectToRoute('app_checklist_show', ['id' => $checklist->getId()]);
    }
}