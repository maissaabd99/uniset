<?php

namespace App\Entity;

use App\Repository\DeposerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeposerRepository::class)
 */
class Deposer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Etudiant::class, inversedBy="deposers",fetch="EAGER")
     */
    private $etudiant;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $travail;

    /**
     * @ORM\ManyToOne(targetEntity=Support::class, inversedBy="deposers",fetch="EAGER")
     */
    private $support;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTravail(): ?string
    {
        return $this->travail;
    }

    public function setTravail(string $travail): self
    {
        $this->travail = $travail;

        return $this;
    }

    public function getSupport(): ?Support
    {
        return $this->support;
    }

    public function setSupport(?Support $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
