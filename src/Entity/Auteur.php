<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]
#[UniqueEntity(
    fields: ['nom_prenom'],
    message: 'Le nom & prenom est déjà exist!',
)]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('readed')]
    private $id;

    #[Groups('readed')]
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $nom_prenom;

    #[Groups('readed')]
    #[ORM\Column(type: 'string', length: 1)]
    private $sexe;

    #[Groups('readed')]
    #[ORM\Column(type: 'date_immutable')]
    private $date_de_naissance;

    #[Groups('readed')]
    #[ORM\Column(type: 'string', length: 255)]
    private $nationalite;

    #[ORM\ManyToMany(targetEntity: Livre::class, inversedBy: 'auteurs')]
    private $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrenom(): ?string
    {
        return $this->nom_prenom;
    }
    public function getnom_prenom(): ?string
    {
        return $this->nom_prenom;
    }

    public function setNomPrenom(string $nom_prenom): self
    {
        $this->nom_prenom = $nom_prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->date_de_naissance;
    }
    public function getdate_de_naissance(): ?\DateTimeInterface
    {
        return $this->date_de_naissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $date_de_naissance): self
    {
        $this->date_de_naissance = $date_de_naissance;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * @return Collection|Livre[]
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): self
    {
        if (!$this->livres->contains($livre)) {
            $this->livres[] = $livre;
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        $this->livres->removeElement($livre);

        return $this;
    }
}
