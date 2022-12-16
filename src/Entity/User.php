<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getFriends"])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(["getFriends"])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(["getFriends"])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(["getFriends"])]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["getFriends"])]
    private $isVerified = false;

    #[ORM\Column(length: 255)]
    #[Groups(["getFriends"])]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getFriends"])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $biography = null;

    #[ORM\Column(name: "phone_number", length: 255, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $birthday = null;

    #[ORM\Column]
    #[Groups(["getFriends"])]
    private ?int $private = null;


    public function __toString() {
        return $this->email;
    }

    #[ORM\OneToMany(mappedBy: 'linkToActualUser', targetEntity: Friend::class, orphanRemoval: true)]
    private Collection $friendList;

    public function __construct()
    {
        $this->friendList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    public function getPrivate(): ?int
    {
        return $this->private;
    }

    public function setPrivate(int $private): self
    {
        $this->private = $private;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    public function setBirthday(?string $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return Collection<int, Friend>
     */
    public function getFriendList(): Collection
    {
        return $this->friendList;
    }

    public function addFriendList(Friend $friendList): self
    {
        if (!$this->friendList->contains($friendList)) {
            $this->friendList->add($friendList);
            $friendList->setLinkToActualUser($this);
        }

        return $this;
    }

    public function removeFriendList(Friend $friendList): self
    {
        if ($this->friendList->removeElement($friendList)) {
            // set the owning side to null (unless already changed)
            if ($friendList->getLinkToActualUser() === $this) {
                $friendList->setLinkToActualUser(null);
            }
        }

        return $this;
    }
}
