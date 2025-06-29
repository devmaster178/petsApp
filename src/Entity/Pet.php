<?php

namespace App\Entity;

use App\Enum\BreedChoiceEnum;
use App\Enum\GenderEnum;
use App\Repository\PetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetRepository::class)]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PetType $type = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    private ?Breed $breed = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_of_birth = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?string $age = null;

    #[ORM\Column(nullable: true, enumType: GenderEnum::class)]
    private ?GenderEnum $sex = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $is_dangerous = false;

    #[ORM\Column(nullable: true, enumType: BreedChoiceEnum::class)]
    private ?BreedChoiceEnum $breed_choice = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $breed_other = null;

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

    public function getType(): ?PetType
    {
        return $this->type;
    }

    public function setType(?PetType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getBreed(): ?Breed
    {
        return $this->breed;
    }

    public function setBreed(?Breed $breed): static
    {
        $this->breed = $breed;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTime
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(?\DateTime $date_of_birth): static
    {
        $this->date_of_birth = $date_of_birth;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $name): static
    {
        $this->age = $name;

        return $this;
    }


    public function getSex(): ?GenderEnum
    {
        return $this->sex;
    }

    public function setSex(?GenderEnum $sex): static
    {
        $this->sex = $sex;

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

    public function getBreedOther(): ?string
    {
        return $this->breed_other;
    }

    public function setBreedOther(?string $breed_other): static
    {
        $this->breed_other = $breed_other;

        return $this;
    }

    public function getBreedChoice(): ?bool
    {
        return $this->breed_choice;
    }

    public function setChoice(bool $breed_choice): static
    {
        $this->breed_choice = $breed_choice;

        return $this;
    }
}
