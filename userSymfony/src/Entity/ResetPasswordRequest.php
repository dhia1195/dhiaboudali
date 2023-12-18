<?php

namespace App\Entity;

use App\Repository\ResetPasswordRequestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResetPasswordRequestRepository::class)]
class ResetPasswordRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct(object $utilisateur, \DateTimeInterface $expiresAt, string $selector, string $hashedToken)
    {
        $this->utilisateur = $utilisateur;
        $this->initialize($expiresAt, $selector, $hashedToken);
    }

  

    public function getUser(): object
    {
        return $this->utilisateur;
    }
}
