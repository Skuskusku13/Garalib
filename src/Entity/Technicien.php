<?php

namespace App\Entity;

use App\Repository\TechnicienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TechnicienRepository::class)]
class Technicien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $qualifications = null;

    #[ORM\OneToOne(inversedBy: 'technicien', cascade: ['persist', 'remove'])]
    private ?Utilisateur $idUser = null;

    #[ORM\OneToMany(mappedBy: 'technicien', targetEntity: Reparation::class)]
    private Collection $reparations;

    public function __construct()
    {
        $this->reparations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Reparation>
     */
    public function getReparations(): Collection
    {
        return $this->reparations;
    }

    public function addReparation(Reparation $reparation): static
    {
        if (!$this->reparations->contains($reparation)) {
            $this->reparations->add($reparation);
            $reparation->setTechnicien($this);
        }

        return $this;
    }

    public function removeReparation(Reparation $reparation): static
    {
        if ($this->reparations->removeElement($reparation)) {
            // set the owning side to null (unless already changed)
            if ($reparation->getTechnicien() === $this) {
                $reparation->setTechnicien(null);
            }
        }

        return $this;
    }


}
