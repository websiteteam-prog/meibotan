<?php
declare(strict_types=1);

namespace App\Core;

final class Paginator
{
    public int $page;
    public int $pages;
    public int $offset;

    public function __construct(public int $total, public int $perPage = 12, ?int $page = null)
    {
        $this->perPage = max(1, $perPage);
        $this->pages = max(1, (int) ceil($total / $this->perPage));
        $this->page = min(max(1, $page ?? input_int('page', 1)), $this->pages);
        $this->offset = ($this->page - 1) * $this->perPage;
    }

    public function hasMore(): bool
    {
        return $this->page < $this->pages;
    }

    public function from(): int
    {
        return $this->total === 0 ? 0 : $this->offset + 1;
    }

    public function to(): int
    {
        return min($this->total, $this->offset + $this->perPage);
    }

    /** Page numbers to display, with "…" gaps. */
    public function window(int $around = 1): array
    {
        $out = [];
        for ($i = 1; $i <= $this->pages; $i++) {
            if ($i === 1 || $i === $this->pages || abs($i - $this->page) <= $around) {
                $out[] = $i;
            } elseif (end($out) !== '…') {
                $out[] = '…';
            }
        }
        return $out;
    }
}
