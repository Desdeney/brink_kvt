<?php

namespace App\Service;

use App\Entity\Appointments;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EventMailer
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendAppointmentNotification(Appointments $appointment): void
    {
        foreach ($appointment->getUsers() as $user) {
            if (null === $user->getEmail()) {
                continue;
            }
            $email = (new Email())
                ->to($user->getEmail())
                ->subject('Termin aktualisiert')
                ->text(sprintf('Der Termin am %s wurde erstellt oder bearbeitet.',
                    $appointment->getDate()?->format('d.m.Y') ?? ''));
            $this->mailer->send($email);
        }
    }

    public function sendChecklist(\App\Entity\Checklist $checklist, string $pdfContent): void
    {
        $appointment = $checklist->getAppointment();
        $filename = sprintf('Checkliste_%s.pdf', str_replace(' ', '_', $checklist->getTitle()));

        foreach ($appointment->getUsers() as $user) {
            if (null === $user->getEmail()) {
                continue;
            }
            $email = (new Email())
                ->to($user->getEmail())
                ->subject('Checkliste: ' . $checklist->getTitle())
                ->text(sprintf('Anbei erhalten Sie die ausgefüllte Checkliste "%s" zum Termin am %s.',
                    $checklist->getTitle(),
                    $appointment->getDate()?->format('d.m.Y') ?? ''))
                ->attach($pdfContent, $filename, 'application/pdf');
            
            $this->mailer->send($email);
        }
    }
}