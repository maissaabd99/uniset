<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClasseRepository::class)
 */
class Classe
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
     * @ORM\Column(type="integer")
     */
    private $nbr_etudiant;

    /**
     * @ORM\ManyToOne(targetEntity=Iset::class, inversedBy="classes",fetch="EAGER")
     */
    private $iset;

    /**
     * @ORM\OneToMany(targetEntity=EnsClasse::class, mappedBy="classe",cascade={"persist", "remove"},fetch="EAGER")
     */
    private $ensClasses;

    /**
     * @ORM\OneToMany(targetEntity=Etudiant::class, mappedBy="classe",fetch="EAGER")
     */
    private $etudiants;

    public function __construct()
    {
        $this->ensClasses = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
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

    public function getNbrEtudiant(): ?int
    {
        return $this->nbr_etudiant;
    }

    public function setNbrEtudiant(int $nbr_etudiant): self
    {
        $this->nbr_etudiant = $nbr_etudiant;

        return $this;
    }

    public function getIset(): ?Iset
    {
        return $this->iset;
    }

    public function setIset(?Iset $iset): self
    {
        $this->iset = $iset;

        return $this;
    }

    /**
     * @return Collection|EnsClasse[]
     */
    public function getEnsClasses(): Collection
    {
        return $this->ensClasses;
    }

    public function addEnsClass(EnsClasse $ensClass): self
    {
        if (!$this->ensClasses->contains($ensClass)) {
            $this->ensClasses[] = $ensClass;
            $ensClass->setClasse($this);
        }

        return $this;
    }

    public function removeEnsClass(EnsClasse $ensClass): self
    {
        if ($this->ensClasses->contains($ensClass)) {
            $this->ensClasses->removeElement($ensClass);
            // set the owning side to null (unless already changed)
            if ($ensClass->getClasse() === $this) {
                $ensClass->setClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setClasse($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->contains($etudiant)) {
            $this->etudiants->removeElement($etudiant);
            // set the owning side to null (unless already changed)
            if ($etudiant->getClasse() === $this) {
                $etudiant->setClasse(null);
            }
        }

        return $this;
    }

    public function __toString():string
    {
        return $this->getNom();
    }
}
