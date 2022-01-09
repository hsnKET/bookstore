<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(
    fields: ['email'],
    message: 'L\'email est déja utilisé!',
)]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Email]
    private $email;

    #[Assert\Length(
        min: 8,
        minMessage: 'Votre mot de pass doit comporter au moins 8 caractères',
    )]
    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $role;

    #[Assert\EqualTo(propertyPath: 'password', message: 'Cette valeur doit être égale à la valeur de password')]
    private $confirm_password;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function getconfirm_password(): ?string
    {
        return $this->confirm_password;
    }
    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }

    public function setconfirm_password(string $password): self
    {
        $this->confirm_password = $password;

        return $this;
    }
    public function setConfirmPassword(string $password): self
    {
        $this->confirm_password = $password;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
    public function eraseCredentials()
    {
        return null;
    }
    public function getUsername()
    {
        return $this->email;
    }
}
