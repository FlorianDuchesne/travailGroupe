<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateFin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbPlaces;

    /**
     * @ORM\ManyToOne(targetEntity=Formation::class, inversedBy="session")
     */
    private $formation;

    /**
     * @ORM\ManyToMany(targetEntity=Stagiaire::class, inversedBy="sessions")
     */
    private $inscrit;

    /**
     * @ORM\OneToMany(targetEntity=Programmer::class, mappedBy="programmeSession", orphanRemoval=true)
     */
    private $programmeSession;

    public function __construct()
    {
        $this->inscrit = new ArrayCollection();
        $this->programmeSession = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nbPlaces;
    }

    public function setNbPlaces(?int $nbPlaces): self
    {
        $this->nbPlaces = $nbPlaces;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * @return Collection|Stagiaire[]
     */
    public function getInscrit(): Collection
    {
        return $this->inscrit;
    }

    public function addInscrit(Stagiaire $inscrit): self
    {
        if (!$this->inscrit->contains($inscrit)) {
            $this->inscrit[] = $inscrit;
        }

        return $this;
    }

    public function removeInscrit(Stagiaire $inscrit): self
    {
        $this->inscrit->removeElement($inscrit);

        return $this;
    }

    /**
     * @return Collection|Programmer[]
     */
    public function getProgrammeSession(): Collection
    {
        return $this->programmeSession;
    }

    public function addProgrammeSession(Programmer $programmeSession): self
    {
        if (!$this->programmeSession->contains($programmeSession)) {
            $this->programmeSession[] = $programmeSession;
            $programmeSession->setProgrammeSession($this);
        }

        return $this;
    }

    public function removeProgrammeSession(Programmer $programmeSession): self
    {
        if ($this->programmeSession->removeElement($programmeSession)) {
            // set the owning side to null (unless already changed)
            if ($programmeSession->getProgrammeSession() === $this) {
                $programmeSession->setProgrammeSession(null);
            }
        }

        return $this;
    }
}
