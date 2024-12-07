<?php

namespace App\Entity;
use App\Entity\Users;

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
     * @var Collection<int, Opportunity>
     */
    #[ORM\OneToMany(targetEntity: Opportunity::class, mappedBy: 'createdBy', orphanRemoval: true)]
    private Collection $opportunities;

    public function __construct()
    {
        parent::__construct();
        $this->opportunities = new ArrayCollection();
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
     * @return Collection<int, Opportunity>
     */
    public function getOpportunities(): Collection
    {
        return $this->opportunities;
    }

    public function addOpportunity(Opportunity $opportunity): static
    {
        if (!$this->opportunities->contains($opportunity)) {
            $this->opportunities->add($opportunity);
            $opportunity->setCreatedBy($this);
        }

        return $this;
    }

    public function removeOpportunity(Opportunity $opportunity): static
    {
        if ($this->opportunities->removeElement($opportunity)) {
            // set the owning side to null (unless already changed)
            if ($opportunity->getCreatedBy() === $this) {
                $opportunity->setCreatedBy(null);
            }
        }

        return $this;
    }
}
