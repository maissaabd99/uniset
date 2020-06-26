<?php

namespace App\Entity;

use App\Repository\EnsClasseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=EnsClasseRepository::class)
 */
class EnsClasse
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Enseignant::class, inversedBy="ensClasses", fetch="EAGER")
     */
    private $enseignant;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="ensClasses", fetch="EAGER",cascade={"persist","remove"})
     */

    private $classe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }
    public function __toString():string
    {
        return $this->getEnseignant()->getNom();
    }
}
