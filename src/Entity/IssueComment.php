<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IssueCommentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class IssueComment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $issueId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comments;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId()
    {
        return $this->id;
    }

    public function getIssueId(): ?int
    {
        return $this->issueId;
    }

    public function setIssueId(int $issueId): self
    {
        $this->issueId = $issueId;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

	/**
	 * @ORM\PrePersist
	 */
	public function prePersist()
	{
		if (!$this->getCreatedAt()) {
			$this->setCreatedAt(new \DateTime());
		}
	}
}
