<?php

namespace App\Entity;

use App\Repository\PetTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetTypeRepository::class)]
class PetType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Breed>
     */
    #[ORM\OneToMany(targetEntity: Breed::class, mappedBy: 'pet_type')]
    private Collection $breeds;

    /**
     * @var Collection<int, Pet>
     */
    #[ORM\OneToMany(targetEntity: Pet::class, mappedBy: 'type')]
    private Collection $pets;

    public function __construct()
    {
        $this->breeds = new ArrayCollection();
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

    /**
     * @return Collection<int, Breed>
     */
    public function getBreeds(): Collection
    {
        return $this->breeds;
    }

    public function addBreed(Breed $breed): static
    {
        if (!$this->breeds->contains($breed)) {
            $this->breeds->add($breed);
            $breed->setPetType($this);
        }

        return $this;
    }

    public function removeBreed(Breed $breed): static
    {
        if ($this->breeds->removeElement($breed)) {
            // set the owning side to null (unless already changed)
            if ($breed->getPetType() === $this) {
                $breed->setPetType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pet>
     */
    public function getPets(): Collection
    {
        return $this->pets;
    }

    public function addPet(Pet $pet): static
    {
        if (!$this->pets->contains($pet)) {
            $this->pets->add($pet);
            $pet->setType($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): static
    {
        if ($this->pets->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getType() === $this) {
                $pet->setType(null);
            }
        }

        return $this;
    }

}
