<?php

namespace App\Controller;

use App\Entity\ChecklistTemplate;
use App\Form\ChecklistTemplateType;
use App\Repository\ChecklistTemplateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/settings/checklist-templates')]
class ChecklistTemplateController extends AbstractController
{
    #[Route('/', name: 'app_checklist_template_index', methods: ['GET'])]
    public function index(ChecklistTemplateRepository $repository): Response
    {
        return $this->render('checklist_template/index.html.twig', [
            'checklist_templates' => $repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_checklist_template_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $checklistTemplate = new ChecklistTemplate();
        $form = $this->createForm(ChecklistTemplateType::class, $checklistTemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($checklistTemplate);
            $entityManager->flush();

            $this->addFlash('success', 'Checklisten-Template erfolgreich erstellt.');

            return $this->redirectToRoute('app_checklist_template_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('checklist_template/new.html.twig', [
            'checklist_template' => $checklistTemplate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_checklist_template_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ChecklistTemplate $checklistTemplate, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChecklistTemplateType::class, $checklistTemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Checklisten-Template erfolgreich aktualisiert.');

            return $this->redirectToRoute('app_checklist_template_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('checklist_template/edit.html.twig', [
            'checklist_template' => $checklistTemplate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_checklist_template_delete', methods: ['POST'])]
    public function delete(Request $request, ChecklistTemplate $checklistTemplate, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$checklistTemplate->getId(), $request->request->get('_token'))) {
            $entityManager->remove($checklistTemplate);
            $entityManager->flush();
            $this->addFlash('success', 'Checklisten-Template erfolgreich gelöscht.');
        }

        return $this->redirectToRoute('app_checklist_template_index', [], Response::HTTP_SEE_OTHER);
    }
}