<?php

namespace App\Entity;

use App\Repository\AppointmentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentsRepository::class)]
class Appointments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: "appointments", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: "appointments", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $occasion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $start_time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $end_time = null;

    #[ORM\Column(nullable: true)]
    private ?int $is_confirmed = null;

    #[ORM\Column(nullable: true)]
    private ?int $setup_with_location = null;

    #[ORM\Column(nullable: true)]
    private ?int $teardown_with_location = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $setup_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $setup_time = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $teardown_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $teardown_time = null;

    #[ORM\Column(nullable: true)]
    private ?int $attendees_count = null;

    #[ORM\Column(nullable: true)]
    private ?int $attendees_age_from = null;

    #[ORM\Column(nullable: true)]
    private ?int $attendees_age_to = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $attendees_notes = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $music_pdf_path = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $dj_notes = null;

    #[ORM\Column]
    private ?float $price_dj_hour = null;

    #[ORM\Column]
    private ?float $price_dj_extention = null;

    #[ORM\Column]
    private ?float $price_tech = null;

    #[ORM\Column]
    private ?float $price_approach = null;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'appointment_id')]
    private Collection $orders;

    #[ORM\Column(nullable: true)]
    private ?bool $deactivated = null;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOccasion(): ?string
    {
        return $this->occasion;
    }

    public function setOccasion(?string $occasion): static
    {
        $this->occasion = $occasion;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeInterface $start_time): static
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(?\DateTimeInterface $end_time): static
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getIsConfirmed(): ?int
    {
        return $this->is_confirmed;
    }

    public function setIsConfirmed(?int $is_confirmed): static
    {
        $this->is_confirmed = $is_confirmed;

        return $this;
    }

    public function getSetupWithLocation(): ?int
    {
        return $this->setup_with_location;
    }

    public function setSetupWithLocation(?int $setup_with_location): static
    {
        $this->setup_with_location = $setup_with_location;

        return $this;
    }

    public function getTeardownWithLocation(): ?int
    {
        return $this->teardown_with_location;
    }

    public function setTeardownWithLocation(?int $teardown_with_location): static
    {
        $this->teardown_with_location = $teardown_with_location;

        return $this;
    }

    public function getSetupDate(): ?\DateTimeInterface
    {
        return $this->setup_date;
    }

    public function setSetupDate(?\DateTimeInterface $setup_date): static
    {
        $this->setup_date = $setup_date;

        return $this;
    }

    public function getSetupTime(): ?\DateTimeInterface
    {
        return $this->setup_time;
    }

    public function setSetupTime(?\DateTimeInterface $setup_time): static
    {
        $this->setup_time = $setup_time;

        return $this;
    }

    public function getTeardownDate(): ?\DateTimeInterface
    {
        return $this->teardown_date;
    }

    public function setTeardownDate(?\DateTimeInterface $teardown_date): static
    {
        $this->teardown_date = $teardown_date;

        return $this;
    }

    public function getTeardownTime(): ?\DateTimeInterface
    {
        return $this->teardown_time;
    }

    public function setTeardownTime(?\DateTimeInterface $teardown_time): static
    {
        $this->teardown_time = $teardown_time;

        return $this;
    }

    public function getAttendeesCount(): ?int
    {
        return $this->attendees_count;
    }

    public function setAttendeesCount(?int $attendees_count): static
    {
        $this->attendees_count = $attendees_count;

        return $this;
    }

    public function getAttendeesAgeFrom(): ?int
    {
        return $this->attendees_age_from;
    }

    public function setAttendeesAgeFrom(?int $attendees_age_from): static
    {
        $this->attendees_age_from = $attendees_age_from;

        return $this;
    }

    public function getAttendeesAgeTo(): ?int
    {
        return $this->attendees_age_to;
    }

    public function setAttendeesAgeTo(?int $attendees_age_to): static
    {
        $this->attendees_age_to = $attendees_age_to;

        return $this;
    }

    public function getAttendeesNotes(): ?string
    {
        return $this->attendees_notes;
    }

    public function setAttendeesNotes(?string $attendees_notes): static
    {
        $this->attendees_notes = $attendees_notes;

        return $this;
    }

    public function getMusicPdfPath(): ?string
    {
        return $this->music_pdf_path;
    }

    public function setMusicPdfPath(?string $music_pdf_path): static
    {
        $this->music_pdf_path = $music_pdf_path;

        return $this;
    }

    public function getDjNotes(): ?string
    {
        return $this->dj_notes;
    }

    public function setDjNotes(?string $dj_notes): static
    {
        $this->dj_notes = $dj_notes;

        return $this;
    }

    public function getPriceDjHour(): ?float
    {
        return $this->price_dj_hour;
    }

    public function setPriceDjHour(float $price_dj_hour): static
    {
        $this->price_dj_hour = $price_dj_hour;

        return $this;
    }

    public function getPriceDjExtention(): ?float
    {
        return $this->price_dj_extention;
    }

    public function setPriceDjExtention(float $price_dj_extention): static
    {
        $this->price_dj_extention = $price_dj_extention;

        return $this;
    }

    public function getPriceTech(): ?float
    {
        return $this->price_tech;
    }

    public function setPriceTech(float $price_tech): static
    {
        $this->price_tech = $price_tech;

        return $this;
    }

    public function getPriceApproach(): ?float
    {
        return $this->price_approach;
    }

    public function setPriceApproach(float $price_approach): static
    {
        $this->price_approach = $price_approach;

        return $this;
    }

    public function isDeactivated(): ?bool
    {
        return $this->deactivated;
    }

    public function setDeactivated(?bool $deactivated): static
    {
        $this->deactivated = $deactivated;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setAppointmentId($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getAppointmentId() === $this) {
                $order->setAppointmentId(null);
            }
        }

        return $this;
    }


}
