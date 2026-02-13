<?php

namespace App\Controller;

use App\Entity\Appointments;
use App\Entity\Customer;
use App\Entity\User;
use App\Repository\AppointmentsRepository;
use App\Repository\ChecklistRepository;
use App\Repository\CustomerRepository;
use App\Repository\LocationRepository;
use App\Repository\ObjectsRepository;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(
        AppointmentsRepository $appointmentsRepository,
        CustomerRepository $customerRepository,
        LocationRepository $locationRepository,
        ObjectsRepository $objectsRepository,
        ChecklistRepository $checklistRepository,
        PaymentRepository $paymentRepository
    ): Response {
        // --- KPI Cards Data ---
        $customersCount = $customerRepository->count([]);
        $locationsCount = $locationRepository->count([]);
        $objectsCount = $objectsRepository->count([]);
        
        // Appointments
        $appointments = $appointmentsRepository->findAll();
        $upcomingAppointmentsCount = count(array_filter($appointments, fn($a) => $a->getDate() >= new \DateTime('today')));
        $confirmedAppointmentsCount = count(array_filter($appointments, fn($a) => $a->getIsConfirmed()));

        // Recent data for overview tables
        $recentCustomers = $customerRepository->findBy([], ['id' => 'DESC'], 5);
        $recentAppointments = array_slice(array_reverse($appointments), 0, 5);
        $recentLocations = $locationRepository->findBy([], ['id' => 'DESC'], 5);
        $recentChecklists = $checklistRepository->findBy([], ['id' => 'DESC'], 5);

        // Get all current appointments (today and future)
        $currentAppointments = array_filter($appointments, fn($a) => $a->getDate() >= new \DateTime('today'));
        // Sort by date ascending
        usort($currentAppointments, fn($a, $b) => $a->getDate() <=> $b->getDate());

        return $this->render('dashboard/index.html.twig', [
            'customers_count' => $customersCount,
            'locations_count' => $locationsCount,
            'objects_count' => $objectsCount,
            'upcoming_appointments_count' => $upcomingAppointmentsCount,
            'confirmed_appointments_count' => $confirmedAppointmentsCount,
            'recent_appointments' => $recentAppointments,
            'recent_customers' => $recentCustomers,
            'recent_locations' => $recentLocations,
            'recent_checklists' => $recentChecklists,
            'current_appointments' => $currentAppointments,
        ]);
    }
}