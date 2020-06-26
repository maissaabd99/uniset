<?php

namespace App\Entity;

use App\Repository\EnsMatiereRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnsMatiereRepository::class)
 */
class EnsMatiere
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity=Enseignant::class, inversedBy="ensMatieres", fetch="EAGER")
     */
    private $enseignant;

    /**
     * @ORM\ManyToOne(targetEntity=Matiere::class, inversedBy="ensMatieres", fetch="EAGER",cascade={"persist","remove"})
     */
    private $matiere;

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

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }
  /*  public function  __toString():string
    {
        return $this->getMatiere()->getLibelle();
    }*/
}
