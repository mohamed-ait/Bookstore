<?php

namespace App\Entity;

use App\Repository\AutheurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AutheurRepository::class)
 */
class Autheur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * Assert\Unique
     */
    private $nom_prenom;

    /**
     * @ORM\Column(type="string", length=1)
     * @Assert\Choice({"M"},{"F"})
     */
    private $sexe;

    /**
     * @ORM\Column(type="date")
     * @Assert\Type("DateTime")
     * 
     */
    private $date_de_naissance;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Country
     */
    private $nationalite;

    /**
     * @ORM\ManyToMany(targetEntity=Livre::class, inversedBy="autheurs")
     */
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

    public function getDateDeNaissance(): ?date
    {
        return $this->date_de_naissance;
    }

    public function setDateDeNaissance(date $date_de_naissance): self
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
     * @return Collection|livre[]
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(livre $livre): self
    {
        if (!$this->livres->contains($livre)) {
            $this->livres[] = $livre;
        }

        return $this;
    }

    public function removeLivre(livre $livre): self
    {
        $this->livres->removeElement($livre);

        return $this;
    }
    public function __toString(){
        return $this->nom_prenom;
    }

    
 

   
}
