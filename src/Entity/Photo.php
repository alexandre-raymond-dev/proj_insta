<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 *
 * @ORM\Table(name="photo", indexes={@ORM\Index(name="IDX_14B78418F132696E", columns={"userid"})})
 * @ORM\Entity
 */
class Photo
{
    /**
     * @var int
     *
     * @ORM\Column(name="photoid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="photo_photoid_seq", allocationSize=1, initialValue=1)
     */
    private $photoid;

    /**
     * @var int
     *
     * @ORM\Column(name="albumid", type="integer", nullable=false)
     */
    private $albumid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descr", type="string", length=500, nullable=true)
     */
    private $descr;

    /**
     * @var int
     *
     * @ORM\Column(name="prive", type="integer", nullable=false)
     */
    private $prive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="uploadphoto", type="date", nullable=false)
     */
    private $uploadphoto;

    /**
     * @var string
     *
     * @ORM\Column(name="imagepath", type="string", nullable=false, options={"fixed"=true})
     */
    private $imagepath;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userid", referencedColumnName="id")
     * })
     */
    private $userid;

    public function getid(): ?int
    {
        return $this->photoid;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->descr = $description;

        return $this;
    }

    public function getPrivacy(): ?string
    {
        return $this->prive;
    }

    public function setPrivacy(string $privacy): self
    {
        $this->prive = $privacy;

        return $this;
    }

    public function getUploadDate(): ?\DateTimeInterface
    {
        return $this->uploadphoto;
    }

    public function setUploadDate(\DateTimeInterface $uploadDate): self
    {
        $this->uploadphoto = $uploadDate;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imageath;
    }

    public function setImagePath(string $imagePath): self
    {
        $this->imagepath = $imagePath;

        return $this;
    }
}
