<?php

namespace App\Entity;

use App\Repository\VolRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VolRepository::class)]
class Vol
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $villeDestination = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDeDepart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDArrivee = null;

    #[ORM\ManyToOne(inversedBy: 'vols')]
    private ?Aeroport $Aeroport = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVilleDestination(): ?string
    {
        return $this->villeDestination;
    }

    public function setVilleDestination(string $villeDestination): static
    {
        $this->villeDestination = $villeDestination;

        return $this;
    }

    public function getDateDeDepart(): ?\DateTimeInterface
    {
        return $this->dateDeDepart;
    }

    public function setDateDeDepart(\DateTimeInterface $dateDeDepart): static
    {
        $this->dateDeDepart = $dateDeDepart;

        return $this;
    }

    public function getDateDArrivee(): ?\DateTimeInterface
    {
        return $this->dateDArrivee;
    }

    public function setDateDArrivee(\DateTimeInterface $dateDArrivee): static
    {
        $this->dateDArrivee = $dateDArrivee;

        return $this;
    }

    public function getAeroport(): ?Aeroport
    {
        return $this->Aeroport;
    }

    public function setAeroport(?Aeroport $Aeroport): static
    {
        $this->Aeroport = $Aeroport;

        return $this;
    }
}
