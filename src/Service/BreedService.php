<?php

namespace App\Service;

use App\Repository\BreedRepository;
use App\Resource\BreedResource;
use Symfony\Component\HttpFoundation\Request;

class BreedService
{
    public const DEFAULT_LIMIT = 10;

    public const UNKNOWN = "Can't find it?";

    public function __construct(private readonly BreedRepository $breedRepository)
    {
    }

    public function getBreeds(Request $request): array
    {
        $searchValue = $request->query->get('search');
        $petTypeId = $request->query->get('pet_type_id');
        $page = max((int) $request->query->get('page', 1), 1);
        $limit = self::DEFAULT_LIMIT;
        $offset = ($page - 1) * $limit;
        $breeds = $this->breedRepository->getBreeds($offset, $limit, $searchValue, $petTypeId);
        $total = $this->breedRepository->countBreedsBy([
            'pet_type' => $petTypeId,
            'name' => $searchValue,
        ]);
        if (0 === $total) {
            $unKnownBreed = $this->breedRepository->findOneBy([
                'name' => self::UNKNOWN,
            ]);
            if ($unKnownBreed) {
                $breeds = [$unKnownBreed];
            }
        }

        return [
            'items' => BreedResource::collection($breeds),
            'hasMore' => $total > ($offset + $limit),
        ];
    }
}
