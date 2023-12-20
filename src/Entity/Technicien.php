<?php

namespace App\Entity;

use App\Repository\TechnicienRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnicienRepository::class)]
class Technicien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idtechnicien = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $qualifications = null;

    #[ORM\OneToOne(inversedBy: 'technicien', cascade: ['persist', 'remove'])]
    private ?Utilisateur $idUser = null;

    public function getIdTechnicien(): ?int
    {
        return $this->idtechnicien;
    }

    public function getQualifications(): ?string
    {
        return $this->qualifications;
    }

    public function setQualifications(string $qualifications): static
    {
        $this->qualifications = $qualifications;

        return $this;
    }

    public function getIdUser(): ?Utilisateur
    {
        return $this->idUser;
    }

    public function setIdUser(?Utilisateur $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }


}
