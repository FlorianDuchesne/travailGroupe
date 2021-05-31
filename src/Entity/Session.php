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
     * @ORM\OneToMany(targetEntity=Programmer::class, mappedBy="session", orphanRemoval=true, cascade="persist")
     */
    private $programmeSession;

    /**
     * @ORM\ManyToOne(targetEntity=Salle::class, inversedBy="sessions")
     */
    private $salle;

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

    public function addProgrammeSession(Programmer $session): self
    {
        if (!$this->programmeSession->contains($session)) {
            $this->programmeSession[] = $session;
            $session->setProgrammeSession($this);
        }

        return $this;
    }

    public function removeProgrammeSession(Programmer $session): self
    {
        if ($this->programmeSession->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getProgrammeSession() === $this) {
                $session->setProgrammeSession(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getFormation() . ' du ' . $this->getDateDebut()->format('d/m/Y') . ' au ' . $this->getDateFin()->format('d/m/Y');
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }
}
