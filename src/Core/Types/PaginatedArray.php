<?php

namespace Core\Types;

class PaginatedArray
{
    public function __construct(
        public array $items,
        public int   $itemsPerPage,
        public int   $totalItems,
        public int   $currentPage,
    )
    {
    }

    public function totalPages(): int
    {
        if ($this->itemsPerPage === 0) return 0;

        return ceil($this->totalItems / $this->itemsPerPage);
    }

    public function hasNextPage(): bool
    {
        return $this->currentPage < $this->totalPages();
    }

    public function hasPreviousPage(): bool
    {
        return $this->currentPage > 1;
    }

    public function nextPage(): ?string
    {
        if (!$this->hasNextPage()) {
            return null;
        }
        $nextPage = $this->currentPage + 1;

        return currentPath() . "?page=" . $nextPage;
    }

    public function previousPage(): ?string
    {
        if (!$this->hasPreviousPage()) {
            return null;
        }
        $previousPage = $this->currentPage - 1;

        return currentPath() . "?page=" . $previousPage;
    }

    public function firstPage(): string
    {
        return currentPath() . "?page=1";
    }

    public function lastPage(): string
    {
        return currentPath() . "?page=" . $this->totalPages();
    }

    public function currentlyShowing(): string
    {
        if (($this->currentPage - 1) * $this->itemsPerPage > $this->totalItems) {
            return "?";
        }
        $start = (($this->currentPage - 1) * $this->itemsPerPage) + 1;
        $end = min($this->currentPage * $this->itemsPerPage, $this->totalItems);
        return "Visar $start till $end av $this->totalItems";
    }
}