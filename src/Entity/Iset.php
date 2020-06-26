<?php

namespace App\Entity;

use App\Repository\IsetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=IsetRepository::class)
 * @UniqueEntity("nom",message = "Iset déjà existe .")
 */
class Iset
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Classe::class, mappedBy="iset")
     */
    private $classes;

    /**
     * @ORM\OneToMany(targetEntity=Enseignant::class, mappedBy="iset")
     */
    private $enseignants;

    public function __construct()
    {
        $this->matieres = new ArrayCollection();
        $this->classes = new ArrayCollection();
        $this->enseignants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Classe[]
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classe $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes[] = $class;
            $class->setIset($this);
        }

        return $this;
    }

    public function removeClass(Classe $class): self
    {
        if ($this->classes->contains($class)) {
            $this->classes->removeElement($class);
            // set the owning side to null (unless already changed)
            if ($class->getIset() === $this) {
                $class->setIset(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Enseignant[]
     */
    public function getEnseignants(): Collection
    {
        return $this->enseignants;
    }

    public function addEnseignant(Enseignant $enseignant): self
    {
        if (!$this->enseignants->contains($enseignant)) {
            $this->enseignants[] = $enseignant;
            $enseignant->setIset($this);
        }

        return $this;
    }

    public function removeEnseignant(Enseignant $enseignant): self
    {
        if ($this->enseignants->contains($enseignant)) {
            $this->enseignants->removeElement($enseignant);
            // set the owning side to null (unless already changed)
            if ($enseignant->getIset() === $this) {
                $enseignant->setIset(null);
            }
        }

        return $this;
    }

    public function __toString():string
{
    return $this->getNom();
}
}
