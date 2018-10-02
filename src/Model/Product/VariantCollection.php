<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Model\Product;

use FAPI\Sylius\Model\CreatableFromArray;

/**
 * @author Kasim Taskin <taskinkasim@gmail.com>
 */
final class VariantCollection implements CreatableFromArray
{
    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $pages;

    /**
     * @var int
     */
    private $total;

    /**
     * @var Variant[]
     */
    private $items;

    private function __construct(
        int $page,
        int $limit,
        int $pages,
        int $total,
        array $items
    ) {
        $this->page = $page;
        $this->limit = $limit;
        $this->pages = $pages;
        $this->total = $total;
        if ([] !== $items) {
            $this->items = $items;
        }
    }

    /**
     * @param array $data
     *
     * @return ProductCollection
     */
    public static function createFromArray(array $data): self
    {
        $page = -1;
        if (isset($data['page'])) {
            $page = $data['page'];
        }

        $limit = -1;
        if (isset($data['limit'])) {
            $limit = $data['limit'];
        }

        $pages = -1;
        if (isset($data['pages'])) {
            $pages = $data['pages'];
        }

        $total = -1;
        if (isset($data['total'])) {
            $total = $data['total'];
        }

        /** @var Variant[] $items */
        $items = [];
        if (isset($data['_embedded'], $data['_embedded']['items'])) {
            foreach ($data['_embedded']['items'] as $item) {
                $items[] = Variant::createFromArray($item);
            }
        }

        return new self($page, $limit, $pages, $total, $items);
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return Variant[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
