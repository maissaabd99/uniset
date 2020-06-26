<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatiereRepository::class)
 */
class Matiere
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
    private $libelle;

   /* /**
     * @ORM\ManyToOne(targetEntity=Iset::class, inversedBy="matieres")
     */
    //private $iset;

    /**
     * @ORM\OneToMany(targetEntity=EnsMatiere::class, mappedBy="matiere",fetch="EAGER",cascade={"persist", "remove"})
     */
    private $ensMatieres;

    /**
     * @ORM\OneToMany(targetEntity=Support::class, mappedBy="matiere", fetch="EAGER",cascade={"persist", "remove"})
     */
    private $supports;

    public function __construct()
    {
        $this->ensMatieres = new ArrayCollection();
        $this->cours = new ArrayCollection();
        $this->supports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }


    /**
     * @return Collection|EnsMatiere[]
     */
    public function getEnsMatieres(): Collection
    {
        return $this->ensMatieres;
    }

    public function addEnsMatiere(EnsMatiere $ensMatiere): self
    {
        if (!$this->ensMatieres->contains($ensMatiere)) {
            $this->ensMatieres[] = $ensMatiere;
            $ensMatiere->setMatiere($this);
        }

        return $this;
    }

    public function removeEnsMatiere(EnsMatiere $ensMatiere): self
    {
        if ($this->ensMatieres->contains($ensMatiere)) {
            $this->ensMatieres->removeElement($ensMatiere);
            // set the owning side to null (unless already changed)
            if ($ensMatiere->getMatiere() === $this) {
                $ensMatiere->setMatiere(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Support[]
     */
    public function getSupports(): Collection
    {
        return $this->supports;
    }

    public function addSupport(Support $support): self
    {
        if (!$this->supports->contains($support)) {
            $this->supports[] = $support;
            $support->setMatiere($this);
        }

        return $this;
    }

    public function removeSupport(Support $support): self
    {
        if ($this->supports->contains($support)) {
            $this->supports->removeElement($support);
            // set the owning side to null (unless already changed)
            if ($support->getMatiere() === $this) {
                $support->setMatiere(null);
            }
        }

        return $this;
    }
public function __toString():string
{
return $this->getLibelle();}

}
