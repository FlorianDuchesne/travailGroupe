<?php

namespace App\Entity;

use App\Repository\ProgrammerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgrammerRepository::class)
 */
class Programmer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="session")
     * @ORM\JoinColumn(nullable=false)
     */
    private $session;

    /**
     * @ORM\ManyToOne(targetEntity=Module::class, inversedBy="module")
     */
    private $module;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getProgrammeSession(): ?Session
    {
        return $this->programmeSession;
    }

    public function setProgrammeSession(?Session $programmeSession): self
    {
        $this->programmeSession = $programmeSession;

        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

        return $this;
    }
}
