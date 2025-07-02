<?php

namespace App\Components;

use App\Service\PetService;
use Pagerfanta\Pagerfanta;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('PetTableComponent', template: 'components/pet_table_component.html.twig')]
class PetTableComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public int $currentPage = 1;

    #[LiveProp(writable: true)]
    public int $itemsPerPage = 5;

    #[LiveProp(writable: true)]
    public ?string $searchQuery = null;
    #[LiveProp(writable: true)]
    public ?string $selectedPetType = null;

    #[LiveProp(writable: true)]
    public array $petTypes = [];

    public function __construct(private readonly PetService $petService)
    {
    }

    public function getPets(): Pagerfanta
    {
        return $this->petService->getPets(
            $this->currentPage,
            $this->itemsPerPage,
            $this->searchQuery,
            $this->selectedPetType
        );
    }

    #[LiveAction]
    public function goToPage(#[LiveArg] int $page): void
    {
        $this->currentPage = $page;
    }

    #[LiveAction]
    public function nextPage(): void
    {
        $petsPager = $this->getPets();
        if ($petsPager->hasNextPage()) {
            ++$this->currentPage;
        }
    }

    #[LiveAction]
    public function previousPage(): void
    {
        $petsPager = $this->getPets();
        if ($petsPager->hasPreviousPage()) {
            --$this->currentPage;
        }
    }

    #[LiveAction]
    public function resetPage(): void
    {
        $this->currentPage = 1;
    }
}
