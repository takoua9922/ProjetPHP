<?php

namespace App\Entity;

use App\Repository\OpportunityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: OpportunityRepository::class)]
class Opportunity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le titre de l'opportunité est obligatoire.")]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: "Le titre doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La description est obligatoire.")]

    private ?string $description = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "L'université est obligatoire.")]

    private ?string $university = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le pays est obligatoire.")]

    private ?string $country = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La date de création est obligatoire.")]
    private ?\DateTimeImmutable $createdAt = null;

    
    #[ORM\ManyToOne(targetEntity: "App\Entity\Users",fetch: "EAGER" , inversedBy:"opportunities")]
    #[ORM\JoinColumn(name: "created_by_id", referencedColumnName: "id")]
    private ?Users $createdBy = null;


    /**
     * @var Collection<int, Condidature>
     */
    #[ORM\OneToMany(targetEntity: Condidature::class, mappedBy: 'opportunity', orphanRemoval: true)]
    private Collection $condidatures;

    public function __construct()
    {
        $this->condidatures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?Users
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?Users $createdBy): static
    {
        $this->createdBy = $createdBy;

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
            $condidature->setOpportunity($this);
        }

        return $this;
    }

    public function removeCondidature(Condidature $condidature): static
    {
        if ($this->condidatures->removeElement($condidature)) {
            // set the owning side to null (unless already changed)
            if ($condidature->getOpportunity() === $this) {
                $condidature->setOpportunity(null);
            }
        }

        return $this;
    }
}
