<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    /**
     * @ORM\OneToMany(targetEntity=Blogs::class, mappedBy="user")
     */
    private $blogs;

    /**
     * @ORM\OneToMany(targetEntity=Receipts::class, mappedBy="user")
     */
    private $receipts;

    public function __construct()
    {
        $this->blogs = new ArrayCollection();
        $this->receipts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * @return Collection<int, Blogs>
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    public function addBlog(Blogs $blog): self
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs[] = $blog;
            $blog->setUser($this);
        }

        return $this;
    }

    public function removeBlog(Blogs $blog): self
    {
        if ($this->blogs->removeElement($blog)) {
            // set the owning side to null (unless already changed)
            if ($blog->getUser() === $this) {
                $blog->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Receipts>
     */
    public function getReceipts(): Collection
    {
        return $this->receipts;
    }

    public function addReceipt(Receipts $receipt): self
    {
        if (!$this->receipts->contains($receipt)) {
            $this->receipts[] = $receipt;
            $receipt->setUser($this);
        }

        return $this;
    }

    public function removeReceipt(Receipts $receipt): self
    {
        if ($this->receipts->removeElement($receipt)) {
            // set the owning side to null (unless already changed)
            if ($receipt->getUser() === $this) {
                $receipt->setUser(null);
            }
        }

        return $this;
    }
}
