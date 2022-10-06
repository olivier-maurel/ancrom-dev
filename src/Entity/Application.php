<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $name = null;

    #[ORM\Column(length: 128)]
    private ?string $icon = null;

    #[ORM\Column(length: 16)]
    private ?string $color = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $about = null;

    #[ORM\Column(length: 32)]
    private ?string $action = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $page = null;

    #[ORM\Column(nullable: true)]
    private ?bool $processing = null;

    #[ORM\OneToOne(mappedBy: 'application', cascade: ['persist', 'remove'])]
    private ?ApplicationContent $applicationContent = null;

    #[ORM\ManyToMany(targetEntity: Technology::class, mappedBy: 'application')]
    private Collection $technologies;

    public function __construct()
    {
        $this->technologies = new ArrayCollection();
    }

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getPage(): ?string
    {
        return $this->page;
    }

    public function setPage(?string $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function isProcessing(): ?bool
    {
        return $this->processing;
    }

    public function setProcessing(?bool $processing): self
    {
        $this->processing = $processing;

        return $this;
    }

    public function getApplicationContent(): ?ApplicationContent
    {
        return $this->applicationContent;
    }

    public function setApplicationContent(ApplicationContent $applicationContent): self
    {
        // set the owning side of the relation if necessary
        if ($applicationContent->getApplication() !== $this) {
            $applicationContent->setApplication($this);
        }

        $this->applicationContent = $applicationContent;

        return $this;
    }

    /**
     * @return Collection<int, Technology>
     */
    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Technology $technology): self
    {
        if (!$this->technologies->contains($technology)) {
            $this->technologies->add($technology);
            $technology->addApplication($this);
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): self
    {
        if ($this->technologies->removeElement($technology)) {
            $technology->removeApplication($this);
        }

        return $this;
    }
}
