<?php

namespace App\Entity;

use App\Repository\LibrairieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=LibrairieRepository::class)
 */
class Librairie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * * @Assert\File(
     *     maxSize="5M",
     *     mimeTypes = {"application/pdf"},
     *     mimeTypesMessage = "Votre fichier doit être au format PDF"
     * )
     */
    private $support;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorie;



    /**
     * @ORM\Column(type="date")
     */
    private $date_ajout;

    /**
     * @ORM\ManyToOne(targetEntity=Enseignant::class, inversedBy="librairies")
     */
    private $enseignant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupport()
    {
        return $this->support;
    }

    public function setSupport($support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

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

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): self
    {
        $this->enseignant = $enseignant;

        return $this;
    }
}
