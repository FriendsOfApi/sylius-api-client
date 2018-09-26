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
final class Variant implements CreatableFromArray
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string[][]
     */
    private $translations;

    /**
     * Variant constructor.
     *
     * @param int        $id
     * @param string     $code
     * @param string[][] $translations
     */
    private function __construct(
        int $id,
        string $code,
        array $translations
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->translations = $translations;
    }

    /**
     * @param array $data
     *
     * @return Variant
     */
    public static function createFromArray(array $data): self
    {
        $id = -1;
        if (isset($data['id'])) {
            $id = $data['id'];
        }

        $code = '';
        if (isset($data['code'])) {
            $code = $data['code'];
        }

        $translations = [];
        if (isset($data['translations'])) {
            $translations = $data['translations'];
        }

        return new self($id, $code, $translations);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return \string[][]
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }
}
