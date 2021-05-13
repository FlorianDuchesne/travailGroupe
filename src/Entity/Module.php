<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModuleRepository::class)
 */
class Module
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptif;

    /**
     * @ORM\OneToMany(targetEntity=Categorie::class, mappedBy="module")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Programmer::class, mappedBy="module")
     */
    private $programmeModule;

    public function __construct()
    {
        $this->programmeModule = new ArrayCollection();
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

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(?string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie[] = $categorie;
            $categorie->setModule($this);
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): self
    {
        if ($this->categorie->removeElement($categorie)) {
            // set the owning side to null (unless already changed)
            if ($categorie->getModule() === $this) {
                $categorie->setModule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Programmer[]
     */
    public function getProgrammeModule(): Collection
    {
        return $this->programmeModule;
    }

    public function addProgrammeModule(Programmer $programmeModule): self
    {
        if (!$this->programmeModule->contains($programmeModule)) {
            $this->programmeModule[] = $programmeModule;
            $programmeModule->setModule($this);
        }

        return $this;
    }

    public function removeProgrammeModule(Programmer $programmeModule): self
    {
        if ($this->programmeModule->removeElement($programmeModule)) {
            // set the owning side to null (unless already changed)
            if ($programmeModule->getModule() === $this) {
                $programmeModule->setModule(null);
            }
        }

        return $this;
    }
}
