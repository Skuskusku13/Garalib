<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'client', cascade: ['persist', 'remove'])]
    private ?Utilisateur $idUser = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Vehicule::class)]
    private Collection $vehicules;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Reparation::class)]
    private Collection $reparations;

    public function __construct()
    {
        $this->vehicules = new ArrayCollection();
        $this->reparations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Vehicule>
     */
    public function getVehicules(): Collection
    {
        return $this->vehicules;
    }

    public function addVehicule(Vehicule $vehicule): static
    {
        if (!$this->vehicules->contains($vehicule)) {
            $this->vehicules->add($vehicule);
            $vehicule->setClient($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicule $vehicule): static
    {
        if ($this->vehicules->removeElement($vehicule)) {
            // set the owning side to null (unless already changed)
            if ($vehicule->getClient() === $this) {
                $vehicule->setClient(null);
            }
        }

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
            $reparation->setClient($this);
        }

        return $this;
    }

    public function removeReparation(Reparation $reparation): static
    {
        if ($this->reparations->removeElement($reparation)) {
            // set the owning side to null (unless already changed)
            if ($reparation->getClient() === $this) {
                $reparation->setClient(null);
            }
        }

        return $this;
    }
}
