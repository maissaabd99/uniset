<?php

namespace App\Entity;

use App\Repository\SupportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SupportRepository::class)
 */
class Support
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
     * @ORM\Column(type="string", length=255)
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=Matiere::class, inversedBy="supports",fetch="EAGER")
     */
    private $matiere;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_ajout;

    /**
     * @ORM\OneToMany(targetEntity=Deposer::class, mappedBy="support",fetch="EAGER",cascade={"persist","remove"})
     */
    private $deposers;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $espace_depot;

    public function __construct()
    {
        $this->deposers = new ArrayCollection();
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

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->date_ajout;
    }

    public function setDateAjout(\DateTimeInterface $date_ajout): self
    {
        $this->date_ajout = $date_ajout;

        return $this;
    }

    /**
     * @return Collection|Deposer[]
     */
    public function getDeposers(): Collection
    {
        return $this->deposers;
    }

    public function addDeposer(Deposer $deposer): self
    {
        if (!$this->deposers->contains($deposer)) {
            $this->deposers[] = $deposer;
            $deposer->setSupport($this);
        }

        return $this;
    }

    public function removeDeposer(Deposer $deposer): self
    {
        if ($this->deposers->contains($deposer)) {
            $this->deposers->removeElement($deposer);
            // set the owning side to null (unless already changed)
            if ($deposer->getSupport() === $this) {
                $deposer->setSupport(null);
            }
        }

        return $this;
    }

    public function getEspaceDepot(): ?string
    {
        return $this->espace_depot;
    }

    public function setEspaceDepot(string $espace_depot): self
    {
        $this->espace_depot = $espace_depot;

        return $this;
    }
}
