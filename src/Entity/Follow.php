<?php

namespace App\Entity;

use App\Repository\FollowRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FollowRepository::class)
 */
class Follow
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
    private $followID;

    /**
     * @ORM\Column(type="integer")
     */
    private $followerID;

    /**
     * @ORM\Column(type="integer")
     */
    private $followingID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFollowID(): ?int
    {
        return $this->followID;
    }

    public function setFollowID(int $followID): self
    {
        $this->followID = $followID;

        return $this;
    }

    public function getFollowerID(): ?int
    {
        return $this->followerID;
    }

    public function setFollowerID(int $followerID): self
    {
        $this->followerID = $followerID;

        return $this;
    }

    public function getFollowingID(): ?int
    {
        return $this->followingID;
    }

    public function setFollowingID(int $followingID): self
    {
        $this->followingID = $followingID;

        return $this;
    }
}
