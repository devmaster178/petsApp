<?php
namespace App\Resource;
use App\Entity\Breed;

class BreedResource
{
    public static function collection(iterable $breeds): array{
        $data = array_map(fn(Breed $breed) => [
            'id' => $breed->getId(),
            'text' => $breed->getName(),
            'is_dangerous' => $breed->isDangerous(),
        ], is_array($breeds) ? $breeds : iterator_to_array($breeds));

        if(count($data) === 0){
            $data[] = [
                'id' => 0,
                'text' => "Can't find it?",
                'is_dangerous' => false,
            ];
        }
        return $data;
    }

}
