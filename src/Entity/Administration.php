<?php

namespace App\Entity;

use App\Repository\AdministrationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministrationRepository::class)]
class Administration extends Users
{
    

    #[ORM\Column(length: 50)]
    private ?string $department = null;

    /**
     * @var Collection<int, Mobilite>
     */
    #[ORM\OneToMany(targetEntity: Mobilite::class, mappedBy: 'createdBy', orphanRemoval: true)]
    private Collection $mobilites;

    public function __construct()
    {
        parent::__construct();
        $this->mobilites = new ArrayCollection();
    }

   

    public function getDepartment(): ?string
    {
        return $this->department;
    }

    public function setDepartment(string $department): static
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Collection<int, Mobilite>
     */
    public function getMobilites(): Collection
    {
        return $this->mobilites;
    }

    public function addMobilite(Mobilite $mobilite): static
    {
        if (!$this->mobilites->contains($mobilite)) {
            $this->mobilites->add($mobilite);
            $mobilite->setCreatedBy($this);
        }

        return $this;
    }

    public function removeMobilite(Mobilite $mobilite): static
    {
        if ($this->mobilites->removeElement($mobilite)) {
            // set the owning side to null (unless already changed)
            if ($mobilite->getCreatedBy() === $this) {
                $mobilite->setCreatedBy(null);
            }
        }

        return $this;
    }
}
