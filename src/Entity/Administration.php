<?php

namespace App\Entity;
use App\Entity\Users;

use App\Repository\AdministrationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministrationRepository::class)]
class Administration extends Users
{
    

    #[ORM\Column(length: 50)]
    private ?string $department = null;



    

    public function __construct()
    {
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

   

   
}
