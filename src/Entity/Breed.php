<?php

namespace App\Entity;

use App\Repository\BreedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BreedRepository::class)]
class Breed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'breeds')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PetType $pet_type = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $is_dangerous = false;

    /**
     * @var Collection<int, Pet>
     */
    #[ORM\OneToMany(targetEntity: Pet::class, mappedBy: 'breed')]
    private Collection $pets;

    public function __construct()
    {
        $this->pets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }


    public function getPetType(): ?PetType
    {
        return $this->pet_type;
    }

    public function setPetType(?PetType $pet_type): static
    {
        $this->pet_type = $pet_type;

        return $this;
    }

    public function isDangerous(): ?bool
    {
        return $this->is_dangerous;
    }

    public function setIsDangerous(bool $is_dangerous): static
    {
        $this->is_dangerous = $is_dangerous;

        return $this;
    }

    /**
     * @return Collection<int, Pet>
     */
    public function getPets(): Collection
    {
        return $this->pets;
    }

    public function addPets(Pet $pets): static
    {
        if (!$this->pets->contains($pets)) {
            $this->pets->add($pets);
            $pets->setBreed($this);
        }

        return $this;
    }

    public function removePets(Pet $pets): static
    {
        if ($this->pets->removeElement($pets)) {
            // set the owning side to null (unless already changed)
            if ($pets->getBreed() === $this) {
                $pets->setBreed(null);
            }
        }

        return $this;
    }

}
