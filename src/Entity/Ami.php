<?php

namespace App\Entity;

use App\Repository\AmiRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AmiRepository::class)
 */
class Ami
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
    private $amiID;

    /**
     * @ORM\Column(type="integer")
     */
    private $ami2ID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmiID(): ?int
    {
        return $this->amiID;
    }

    public function setAmiID(int $amiID): self
    {
        $this->amiID = $amiID;

        return $this;
    }

    public function getAmi2ID(): ?int
    {
        return $this->ami2ID;
    }

    public function setAmi2ID(int $ami2ID): self
    {
        $this->ami2ID = $ami2ID;

        return $this;
    }
}
