<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlbumRepository::class)
 */
class Album
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
    private $albumID;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $descr;

    /**
     * @ORM\Column(type="integer")
     */
    private $prive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlbumID(): ?int
    {
        return $this->albumID;
    }

    public function setAlbumID(int $albumID): self
    {
        $this->albumID = $albumID;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescr(): ?string
    {
        return $this->descr;
    }

    public function setDescr(?string $descr): self
    {
        $this->descr = $descr;

        return $this;
    }

    public function getPrive(): ?int
    {
        return $this->prive;
    }

    public function setPrive(int $prive): self
    {
        $this->prive = $prive;

        return $this;
    }
}
