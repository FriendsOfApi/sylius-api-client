<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\Model\Product;

use FAPI\Sylius\Model\CreatableFromArray;

/**
 * @author Radoje Albijanic <radoje.albijanic@gmail.com>
 */
final class Taxon implements CreatableFromArray
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

    private function __construct(
        int $id,
        string $code,
        array $translations
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->translations = $translations;
    }

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

    public function getId(): int
    {
        return $this->id;
    }

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
