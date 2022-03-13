<?php

namespace App\Entity;

use App\Repository\TypesReceiptsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypesReceiptsRepository::class)
 */
class TypesReceipts
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
    private $nametypeRecipe;

    /**
     * @ORM\OneToMany(targetEntity=Receipts::class, mappedBy="type_recipe")
     */
    private $receipts;

    public function __construct()
    {
        $this->receipts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNametypeRecipe(): ?string
    {
        return $this->nametypeRecipe;
    }

    public function setNametypeRecipe(string $nametypeRecipe): self
    {
        $this->nametypeRecipe = $nametypeRecipe;

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
            $receipt->setTypeRecipe($this);
        }

        return $this;
    }

    public function removeReceipt(Receipts $receipt): self
    {
        if ($this->receipts->removeElement($receipt)) {
            // set the owning side to null (unless already changed)
            if ($receipt->getTypeRecipe() === $this) {
                $receipt->setTypeRecipe(null);
            }
        }

        return $this;
    }
}
