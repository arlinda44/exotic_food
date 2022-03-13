<?php

namespace App\Entity;

use App\Repository\ReceiptsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReceiptsRepository::class)
 */
class Receipts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $nameRecipe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country;

    /**
     * @ORM\Column(type="text")
     */
    private $vegetarian;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $preparationTime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cookingTime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pictureReceipts;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="receipts")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=TypesReceipts::class, inversedBy="receipts")
     */
    private $type_recipe;

    /**
     * @ORM\ManyToMany(targetEntity=Food::class, mappedBy="receipts")
     */
    private $food;

    public function __construct()
    {
        $this->food = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameRecipe(): ?string
    {
        return $this->nameRecipe;
    }

    public function setNameRecipe(string $nameRecipe): self
    {
        $this->nameRecipe = $nameRecipe;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getVegetarian(): ?string
    {
        return $this->vegetarian;
    }

    public function setVegetarian(string $vegetarian): self
    {
        $this->vegetarian = $vegetarian;

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

    public function getPreparationTime(): ?string
    {
        return $this->preparationTime;
    }

    public function setPreparationTime(string $preparationTime): self
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    public function getCookingTime(): ?string
    {
        return $this->cookingTime;
    }

    public function setCookingTime(string $cookingTime): self
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getPictureReceipts(): ?string
    {
        return $this->pictureReceipts;
    }

    public function setPictureReceipts(string $pictureReceipts): self
    {
        $this->pictureReceipts = $pictureReceipts;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTypeRecipe(): ?TypesReceipts
    {
        return $this->type_recipe;
    }

    public function setTypeRecipe(?TypesReceipts $type_recipe): self
    {
        $this->type_recipe = $type_recipe;

        return $this;
    }

    /**
     * @return Collection<int, Food>
     */
    public function getFood(): Collection
    {
        return $this->food;
    }

    public function addFood(Food $food): self
    {
        if (!$this->food->contains($food)) {
            $this->food[] = $food;
            $food->addReceipt($this);
        }

        return $this;
    }

    public function removeFood(Food $food): self
    {
        if ($this->food->removeElement($food)) {
            $food->removeReceipt($this);
        }

        return $this;
    }
}
