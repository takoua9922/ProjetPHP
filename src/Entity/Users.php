<?php

namespace App\Entity;

use DateTimeInterface;
use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Driver\Mysqli\Initializer\Options;


#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "role", type: "string")]
#[ORM\DiscriminatorMap([
    "etudiant" => Etudiant::class,
    "societe" => Societe::class,
    "user" => Users::class, 
    "administration" => Administration::class,
    "club" => Club::class,
])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180 , unique: true)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 100)]
    private ?string $adress = null;

    #[ORM\Column (type:'date')]
    private ?\DateTime $created_at = null;
    
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Reclamation::class, orphanRemoval: true)]
    private Collection $reclamations;
    
    

#[ORM\OneToMany(targetEntity: Opportunity::class, mappedBy: "createdBy")]
private Collection $opportunities;



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
        // Set the owning side to null (unless already changed)
        if ($opportunity->getCreatedBy() === $this) {
            $opportunity->setCreatedBy(null);
        }
    }

    return $this;
}

    


/**
 * Initializes a new Users instance, setting up an empty collection for reclamations
 * and assigning the current timestamp to the creation date.
 */
    public function __construct()
    {
        $this->reclamations = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->opportunities = new ArrayCollection();
    }
    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles);
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // Garantir que chaque utilisateur a au moins le rôle "ROLE_USER"
        if (!in_array('ROLE_USER', $roles, true)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        // Ajouter une vérification des rôles valides
        $validRoles = ['ROLE_ETUDIANT', 'ROLE_ADMINISTRATION', 'ROLE_CLUB', 'ROLE_SOCIETE'];

        foreach ($roles as $role) {
            if (!in_array($role, $validRoles, true)) {
                throw new \InvalidArgumentException(sprintf('Le rôle "%s" est invalide.', $role));
            }
        }

        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Si vous stockez des données sensibles temporaires, les effacer ici
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations->add($reclamation);
            $reclamation->setUser($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            if ($reclamation->getUser() === $this) {
                $reclamation->setUser(null);
            }
        }

        return $this;
    }
}
