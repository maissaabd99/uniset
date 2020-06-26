<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity(repositoryClass=EnseignantRepository::class)
 * @Vich\Uploadable()
 */
class Enseignant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @Assert\Regex("/^[0-9]{8}$/",message = " Numéro CIN contient uniquement 8 chiffres .")
     * @ORM\Column(type="string", length=8)
     */
    private $cin;
    /**
     * @ORM\Column(type="string",length=255)
     *
     * @var string|null
     */
    private $img;

    /**
     * @Vich\UploadableField(mapping="admini_image", fileNameProperty="img")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=EnsClasse::class, mappedBy="enseignant", cascade={"persist", "remove"})
     * @Assert\Unique

     */
    private $ensClasses;

    /**
     * @ORM\OneToMany(targetEntity=EnsMatiere::class, mappedBy="enseignant",fetch="EAGER", cascade={"persist","remove"})
     */
    private $ensMatieres;

    /**
     * @ORM\OneToMany(targetEntity=Librairie::class, mappedBy="enseignant",fetch="EAGER", cascade={"persist", "remove"})
     */
    private $librairies;

    /**
     * @ORM\ManyToOne(targetEntity=Iset::class, inversedBy="enseignants",fetch="EAGER")
     */
    private $iset;

    public function __construct()
    {
        $this->ensClasses = new ArrayCollection();
        $this->ensMatieres = new ArrayCollection();
        $this->librairies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(?string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImg(): ?string
    {
        return $this->img;
    }

    /**
     * @param string|null $img
     */
    public function setImg(?string $img): void
    {
        $this->img = $img;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    /**
     * @param File|null $imageFile
     * @throws Exception
     */
    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|EnsClasse[

     */
    public function getEnsClasses(): Collection
    {
        return $this->ensClasses;
    }

    public function addEnsClass(EnsClasse $ensClass): self
    {
        if (!$this->ensClasses->contains($ensClass)) {
            $this->ensClasses[] = $ensClass;
            $ensClass->setEnseignant($this);
        }

        return $this;
    }

    public function removeEnsClass(EnsClasse $ensClass): self
    {
        if ($this->ensClasses->contains($ensClass)) {
            $this->ensClasses->removeElement($ensClass);
            // set the owning side to null (unless already changed)
            if ($ensClass->getEnseignant() === $this) {
                $ensClass->setEnseignant(null);
            }
        }

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
            $ensMatiere->setEnseignant($this);
        }

        return $this;
    }

    public function removeEnsMatiere(EnsMatiere $ensMatiere): self
    {
        if ($this->ensMatieres->contains($ensMatiere)) {
            $this->ensMatieres->removeElement($ensMatiere);
            // set the owning side to null (unless already changed)
            if ($ensMatiere->getEnseignant() === $this) {
                $ensMatiere->setEnseignant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Librairie[]
     */
    public function getLibrairies(): Collection
    {
        return $this->librairies;
    }

    public function addLibrairy(Librairie $librairy): self
    {
        if (!$this->librairies->contains($librairy)) {
            $this->librairies[] = $librairy;
            $librairy->setEnseignant($this);
        }

        return $this;
    }

    public function removeLibrairy(Librairie $librairy): self
    {
        if ($this->librairies->contains($librairy)) {
            $this->librairies->removeElement($librairy);
            // set the owning side to null (unless already changed)
            if ($librairy->getEnseignant() === $this) {
                $librairy->setEnseignant(null);
            }
        }

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


}
