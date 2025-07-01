<?php

namespace App\Entity;

use App\Enum\BreedChoiceEnum;
use App\Enum\GenderEnum;
use App\Enum\HasDobInformationEnum;
use App\Repository\PetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PetRepository::class)]
#[ORM\Index(fields: ["name"])]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Pet name is required.")]
    #[Assert\Length(
        min: 2,
        max: 20,
        minMessage: "Pet name must be at least {{ limit }} characters long.",
        maxMessage: "Pet name cannot be longer than {{ limit }} characters."
    )]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "Pet type is required")]
    #[Assert\Valid]
    private ?PetType $type = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Breed $breed;

    #[ORM\Column(nullable: true, enumType: HasDobInformationEnum::class)]
    #[Assert\Choice(callback: [HasDobInformationEnum::class, 'cases'])]
    private ?HasDobInformationEnum $has_dob_information = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_of_birth = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?string $age = null;

    #[ORM\Column(nullable: true, enumType: GenderEnum::class)]
    #[Assert\Choice(callback: [GenderEnum::class, 'cases'])]
    private ?GenderEnum $sex = null;

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

    public function getBreed():?Breed
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

    public function getBreedOther(): ?string
    {
        return $this->breed_other;
    }

    public function setBreedOther(?string $breed_other): static
    {
        $this->breed_other = $breed_other;

        return $this;
    }

    public function getBreedChoice(): ?BreedChoiceEnum
    {
        return $this->breed_choice;
    }

    public function setBreedChoice(BreedChoiceEnum $breed_choice): static
    {
        $this->breed_choice = $breed_choice;

        return $this;
    }

    public function getHasDobInformation(): ?HasDobInformationEnum
    {
        return $this->has_dob_information;
    }

    public function setHasDobInformation(?HasDobInformationEnum $hasDobInformation): static
    {
        $this->has_dob_information = $hasDobInformation;
        return $this;
    }
}
