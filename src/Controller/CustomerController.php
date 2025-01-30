<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CustomerController extends AbstractController
{
    #[Route('/customer', name: 'app_customer')]
    public function index(CustomerRepository $cr): Response
    {
        $customers = $cr->findAll();


        return $this->render('customer/index.html.twig', [
            'customers' => $customers,
        ]);
    }

    #[Route('/customer/add', name: 'customer_add')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('app_customer');
        }



        return $this->render('customer/add.html.twig', [
            'controller_name' => 'CustomerController',
            'customer' => $form->createView(),
        ]);
    }
}
