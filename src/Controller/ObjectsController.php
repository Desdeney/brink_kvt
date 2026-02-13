<?php

namespace App\Controller;

use App\Entity\Objects;
use App\Form\ObjectsType;
use App\Repository\ObjectsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/objects')]
class ObjectsController extends AbstractController
{
    #[Route('/', name: 'app_objects_index', methods: ['GET'])]
    public function index(ObjectsRepository $objectsRepository): Response
    {
        return $this->render('objects/index.html.twig', [
            'objects' => $objectsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_objects_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $object = new Objects();
        $form = $this->createForm(ObjectsType::class, $object);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($object);
            $entityManager->flush();

            return $this->redirectToRoute('app_objects_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('objects/new.html.twig', [
            'object' => $object,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objects_show', methods: ['GET'])]
    public function show(Objects $object): Response
    {
        return $this->render('objects/show.html.twig', [
            'object' => $object,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_objects_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Objects $object, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ObjectsType::class, $object);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_objects_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('objects/edit.html.twig', [
            'object' => $object,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objects_delete', methods: ['POST'])]
    public function delete(Request $request, Objects $object, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$object->getId(), $request->request->get('_token'))) {
            $entityManager->remove($object);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_objects_index', [], Response::HTTP_SEE_OTHER);
    }
}