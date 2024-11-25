<?php

namespace App\Entity;

use App\Repository\JobeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobeRepository::class)]
class Jobe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $idJob = null;

    #[ORM\Column(length: 255)]
    private ?string $titelJob = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionJob = null;

    #[ORM\Column(length: 255)]
    private ?string $locationJob = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAtJob = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdJob(): ?string
    {
        return $this->idJob;
    }

    public function setIdJob(string $idJob): static
    {
        $this->idJob = $idJob;

        return $this;
    }

    public function getTitelJob(): ?string
    {
        return $this->titelJob;
    }

    public function setTitelJob(string $titelJob): static
    {
        $this->titelJob = $titelJob;

        return $this;
    }

    public function getDescriptionJob(): ?string
    {
        return $this->descriptionJob;
    }

    public function setDescriptionJob(string $descriptionJob): static
    {
        $this->descriptionJob = $descriptionJob;

        return $this;
    }

    public function getLocationJob(): ?string
    {
        return $this->locationJob;
    }

    public function setLocationJob(string $locationJob): static
    {
        $this->locationJob = $locationJob;

        return $this;
    }

    public function getCreatedAtJob(): ?\DateTimeInterface
    {
        return $this->createdAtJob;
    }

    public function setCreatedAtJob(\DateTimeInterface $createdAtJob): static
    {
        $this->createdAtJob = $createdAtJob;

        return $this;
    }
}
