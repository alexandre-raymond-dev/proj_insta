<?php

namespace App\Entity;

use App\Repository\FriendRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FriendRepository::class)]
class Friend
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idFriend = null;

    #[ORM\Column(length: 255)]
    private ?string $usernameFriend = null;

    #[ORM\Column]
    private ?int $idUser = null;

    #[ORM\ManyToOne(inversedBy: 'friendList')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $linkToActualUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdFriend(): ?int
    {
        return $this->idFriend;
    }

    public function setIdFriend(int $idFriend): self
    {
        $this->idFriend = $idFriend;

        return $this;
    }

    public function getUsernameFriend(): ?string
    {
        return $this->usernameFriend;
    }

    public function setUsernameFriend(string $usernameFriend): self
    {
        $this->usernameFriend = $usernameFriend;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getLinkToActualUser(): ?User
    {
        return $this->linkToActualUser;
    }

    public function setLinkToActualUser(?User $linkToActualUser): self
    {
        $this->linkToActualUser = $linkToActualUser;

        return $this;
    }
}
