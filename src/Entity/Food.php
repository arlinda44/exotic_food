<?php

namespace App\Entity;

use App\Repository\FoodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FoodRepository::class)
 */
class Food
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
    private $nameFood;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pictureFood;

    /**
     * @ORM\ManyToMany(targetEntity=Receipts::class, inversedBy="food")
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

    public function getNameFood(): ?string
    {
        return $this->nameFood;
    }

    public function setNameFood(string $nameFood): self
    {
        $this->nameFood = $nameFood;

        return $this;
    }

    public function getPictureFood(): ?string
    {
        return $this->pictureFood;
    }

    public function setPictureFood(string $pictureFood): self
    {
        $this->pictureFood = $pictureFood;

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
        }

        return $this;
    }

    public function removeReceipt(Receipts $receipt): self
    {
        $this->receipts->removeElement($receipt);

        return $this;
    }
}
