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

    public function hasNextPage()
    {
        return $this->currentPage < $this->totalPages();
    }

    public function hasPreviousPage()
    {
        return $this->currentPage > 1;
    }
}