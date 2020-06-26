<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 * @Vich\Uploadable()
 */
class Etudiant
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
     * @ORM\Column(type="string", length=255)
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
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="etudiants")
     */
    private $classe;

    /**
     * @ORM\OneToMany(targetEntity=Deposer::class, mappedBy="etudiant",fetch="EAGER")
     */
    private $deposers;

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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

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

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

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
            $deposer->setEtudiant($this);
        }

        return $this;
    }

    public function removeDeposer(Deposer $deposer): self
    {
        if ($this->deposers->contains($deposer)) {
            $this->deposers->removeElement($deposer);
            // set the owning side to null (unless already changed)
            if ($deposer->getEtudiant() === $this) {
                $deposer->setEtudiant(null);
            }
        }

        return $this;
    }

}
