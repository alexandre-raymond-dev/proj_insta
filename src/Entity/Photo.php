<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
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
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $descr;

    /**
     * @ORM\Column(type="boolean")
     */
    private $prive;

    /**
     * @ORM\Column(type="integer")
     */
    private $userID;

    /**
     * @ORM\Column(type="date")
     */
    private $uploadPhoto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhotoID(): ?int
    {
        return $this->photoID;
    }

    public function setPhotoID(int $photoID): self
    {
        $this->photoID = $photoID;

        return $this;
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

    public function setDescr(string $descr): self
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

    public function getUserID(): ?int
    {
        return $this->userID;
    }

    public function setUserID(int $userID): self
    {
        $this->userID = $userID;

        return $this;
    }

    public function getUploadPhoto(): ?\DateTimeInterface
    {
        return $this->uploadPhoto;
    }

    public function setUploadPhoto(\DateTimeInterface $uploadPhoto): self
    {
        $this->uploadPhoto = $uploadPhoto;

        return $this;
    }
}
