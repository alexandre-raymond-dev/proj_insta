<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
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
    private $photoID;

    /**
     * @ORM\Column(type="date")
     */
    private $uploadComment;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentID(): ?int
    {
        return $this->commentID;
    }

    public function setCommentID(int $commentID): self
    {
        $this->commentID = $commentID;

        return $this;
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

    public function getUploadComment(): ?string
    {
        return $this->uploadComment;
    }

    public function setUploadComment(string $uploadComment): self
    {
        $this->uploadComment = $uploadComment;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
