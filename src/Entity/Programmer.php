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
     * @ORM\ManyToOne(targetEntity=Session::class, inversedBy="session", cascade="persist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $session;

    /**
     * @ORM\ManyToOne(targetEntity=Module::class, inversedBy="module", cascade="persist")
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
        return $this->session;
    }

    public function setProgrammeSession(?Session $programmeSession): self
    {
        $this->session = $programmeSession;

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

    public function __toString()
    {
        return "Le module " . $this->module . " dure " .  $this->duree . ' jours';
    }
}
