<?php

namespace App\Entity;

use App\Entity\Traits\EntitySluggableTrait;
use \Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    use EntitySluggableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $parent;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="parent")
     */
    private $children;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Entity\News", mappedBy="category")
     */
    private $news;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getParent(): ?Category
    {
        return $this->parent;
    }

    public function setParent(Category $category): self
    {
        $this->parent = $category;

        return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChildren(Category $category): self
    {
        $this->children[] = $category;

        return $this;
    }

    public function removeChildren(Category $category): self
    {
        $this->children->removeElement($category);

        return $this;
    }

    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): self
    {
        $this->news[] = $news;

        return $this;
    }

    public function removeNews(News $news): self
    {
        $this->news->removeElement($news);

        return $this;
    }
}
