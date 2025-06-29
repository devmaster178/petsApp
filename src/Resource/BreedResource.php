<?php
namespace App\Resource;
use App\Entity\Breed;

class BreedResource
{
    public static function collection(iterable $breeds): array{
        return array_map(fn(Breed $u) => [
            'id' => $u->getId(),
            'text' => $u->getName(),
            'is_dangerous' => $u->isDangerous(),
        ], is_array($breeds) ? $breeds : iterator_to_array($breeds));
    }

}
