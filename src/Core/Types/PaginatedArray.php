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

    public function nextPage(string $baseUrl = null): ?string
    {
        if (!$this->hasNextPage()) {
            return null;
        }
        if (!$baseUrl) {
            $baseUrl = currentPath();
        }
        $nextPage = $this->currentPage + 1;

        return $baseUrl . "?page=" . $nextPage;
    }

    public function previousPage(string $baseUrl = null): ?string
    {
        if (!$this->hasPreviousPage()) {
            return null;
        }
        if (!$baseUrl) {
            $baseUrl = currentPath();
        }
        $previousPage = $this->currentPage - 1;

        return $baseUrl . "?page=" . $previousPage;
    }

    public function firstPage(string $baseUrl = null): string
    {
        if (!$baseUrl) {
            $baseUrl = currentPath();
        }
        return $baseUrl . "?page=1";
    }

    public function lastPage(string $baseUrl = null): string
    {
        if (!$baseUrl) {
            $baseUrl = currentPath();
        }
        return $baseUrl . "?page=" . $this->totalPages();
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