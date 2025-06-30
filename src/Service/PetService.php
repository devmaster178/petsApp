<?php

namespace App\Service;

use App\Entity\Pet;
use App\Repository\PetRepository;
use Symfony\Component\HttpFoundation\Request;

class PetService{

    public function __construct(private readonly PetRepository $petRepository){}

    public function registerPet(Request $request, Pet $pet): void
    {
        $this->petRepository->save($pet,true);
    }
}
