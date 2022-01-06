<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivreRepository::class)
 */
class Livre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=64, scale=8)
     */
    private $isbn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombre_pages;

    /**
     * @ORM\ManyToMany(targetEntity=Autheur::class, mappedBy="livres")
     */
    private $autheurs;

    /**
     * @ORM\ManyToMany(targetEntity=genre::class, inversedBy="livres")
     */
    private $genres;

    public function __construct()
    {
        $this->autheurs = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }

    
    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNombrePages(): ?int
    {
        return $this->nombre_pages;
    }

    public function setNombrePages(int $nombre_pages): self
    {
        $this->nombre_pages = $nombre_pages;

        return $this;
    }

    /**
     * @return Collection|Autheur[]
     */
    public function getAutheurs(): Collection
    {
        return $this->autheurs;
    }

    public function addAutheur(Autheur $autheur): self
    {
        if (!$this->autheurs->contains($autheur)) {
            $this->autheurs[] = $autheur;
            $autheur->addLivre($this);
        }

        return $this;
    }

    public function removeAutheur(Autheur $autheur): self
    {
        if ($this->autheurs->removeElement($autheur)) {
            $autheur->removeLivre($this);
        }

        return $this;
    }

    /**
     * @return Collection|genre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    public function removeGenre(genre $genre): self
    {
        $this->genres->removeElement($genre);

        return $this;
    }

   
}
