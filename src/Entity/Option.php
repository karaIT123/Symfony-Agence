<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 */
class Option
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
    private $Name;

    /**
     * @ORM\ManyToMany(targetEntity=Property::class, mappedBy="options")
     */
    private $Properties;

    #[Pure] public function __construct()
    {
        $this->Properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProperties(): ArrayCollection
    {
        return $this->Properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->Properties->contains($property)) {
            $this->Properties[] = $property;
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        $this->Properties->removeElement($property);

        return $this;
    }
}
