<?php

namespace App\Entity;
use DateTime;
use DateInterval;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Domaine;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity; 
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur", indexes={@ORM\Index(name="role", columns={"role"})})
 * @ORM\Entity
 */
#[UniqueEntity(fields: ['login'], message: 'There is already an account with this login')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    const repositoryClass = "App\Repository\UtilisateurRepository";


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=100, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100, nullable=false)
     */
    private $password;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=100, nullable=false)
     */
    private $prenom;

    /**
     * @var int
     *
     * @ORM\Column(name="numTel", type="integer", nullable=false)
     */
    private $numtel;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=100, nullable=false)
     */
    private $adresse;

    /**
     * @var int
     *
     * @ORM\Column(name="role", type="integer", nullable=false)
     */
    private $role;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Domaine", inversedBy="users")
     */
    private $domaine;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cv")
     */
    private $cv;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isVerified", type="boolean", nullable=false)
     */
    private $isVerified = false;
    
    /**
     * @var string
     *
     * @ORM\Column(name="tokenRegistration", type="string", length=255, nullable=true)
     */
    private $tokenRegistration;

    /**
     * @var datetime
     *
     * @ORM\Column(name="tokenRegistrationLifeTime", type="datetime", nullable=true)
     */
    private $tokenRegistrationLifeTime;

    /**
     * @var datetime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="resettoken", type="string", nullable=true)
     */
    private $resettoken;


    /**
     * @var boolean
     *
     * @ORM\Column(name="isblocked", type="boolean", nullable=true)
     */
    private $isblocked;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }


    public function getIsBlocked()
    {
        return $this->isblocked;
    }

    public function setIsBlocked($is): self
    {
        $this->isblocked = $is;

        return $this;
    }

    public function __construct()
    {
        $this->createdAt = new DateTime('now');
        $this->isVerified = false;
        $this->tokenRegistrationLifeTime = (new DateTime('now'))->add(new DateInterval("P1D"));
    }



    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumtel(): ?int
    {
        return $this->numtel;
    }

    public function setNumtel(int $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getCv(): ?Cv
    {
        return $this->cv;
    }

    public function setCv(Cv $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getDomaine(): ?Domaine
    {
        return $this->domaine;
    }

    public function setDomaine(Domaine $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
         return $roles;
        // guarantee every user at least has ROLE_USER
       
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
     /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

     /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->login;
    }

    public function getIsVerified()
    {
        return $this->isVerified;
    }


    public function setIsVerified($isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getTokenRegistration(): ?string
    {
        return $this->tokenRegistration;
    }

    public function setTokenRegistration(?string $tokenRegistration): self
    {
        $this->tokenRegistration = $tokenRegistration;

        return $this;
    }

    public function getTokenRegistrationLifeTime()
    {
        return $this->tokenRegistrationLifeTime;
    }

    public function setTokenRegistrationLifeTime($tokenRegistrationLifeTime): self
    {
        $this->tokenRegistrationLifeTime = $tokenRegistrationLifeTime;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getResettoken()
    {
        return $this->resettoken;
    }

    public function setResettoken($resettoken): self
    {
        $this->resettoken = $resettoken;

        return $this;
    }

}
