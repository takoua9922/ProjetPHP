<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant extends Users
{
    
    #[ORM\Column(length: 50)]
    private ?string $university = null;

    #[ORM\Column(length: 50)]
    private ?string $specialization = null;

    #[ORM\Column(length: 30)]
    private ?string $year = null;

    #[ORM\Column(length: 50)]
    private ?string $ancien_diplome = null;

    /**
     * @var Collection<int, Condidature>
     */
    #[ORM\OneToMany(targetEntity: Condidature::class, mappedBy: 'etudiant', orphanRemoval: true)]
    private Collection $condidatures;

    /**
     * @var Collection<int, CV>
     */
    #[ORM\OneToMany(targetEntity: CV::class, mappedBy: 'etudiant', orphanRemoval: true)]
    private Collection $cVs;

    public function __construct()
    {
        parent::__construct();
        $this->condidatures = new ArrayCollection();
        $this->cVs = new ArrayCollection();
    }

    

    public function getUniversity(): ?string
    {
        return $this->university;
    }

    public function setUniversity(string $university): static
    {
        $this->university = $university;

        return $this;
    }

    public function getSpecialization(): ?string
    {
        return $this->specialization;
    }

    public function setSpecialization(string $specialization): static
    {
        $this->specialization = $specialization;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getAncienDiplome(): ?string
    {
        return $this->ancien_diplome;
    }

    public function setAncienDiplome(string $ancien_diplome): static
    {
        $this->ancien_diplome = $ancien_diplome;

        return $this;
    }

    /**
     * @return Collection<int, Condidature>
     */
    public function getCondidatures(): Collection
    {
        return $this->condidatures;
    }

    public function addCondidature(Condidature $condidature): static
    {
        if (!$this->condidatures->contains($condidature)) {
            $this->condidatures->add($condidature);
            $condidature->setEtudiant($this);
        }

        return $this;
    }

    public function removeCondidature(Condidature $condidature): static
    {
        if ($this->condidatures->removeElement($condidature)) {
            // set the owning side to null (unless already changed)
            if ($condidature->getEtudiant() === $this) {
                $condidature->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CV>
     */
    public function getCVs(): Collection
    {
        return $this->cVs;
    }

    public function addCV(CV $cV): static
    {
        if (!$this->cVs->contains($cV)) {
            $this->cVs->add($cV);
            $cV->setEtudiant($this);
        }

        return $this;
    }

    public function removeCV(CV $cV): static
    {
        if ($this->cVs->removeElement($cV)) {
            // set the owning side to null (unless already changed)
            if ($cV->getEtudiant() === $this) {
                $cV->setEtudiant(null);
            }
        }

        return $this;
    }
}
