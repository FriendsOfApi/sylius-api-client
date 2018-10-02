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
final class Product implements CreatableFromArray
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
     * @var string[]
     */
    private $channels;

    /**
     * @var string[][]
     */
    private $translations;

    /**
     * @var Image[]
     */
    private $images;

    private function __construct(
        int $id,
        string $code,
        array $channels,
        array $translations,
        array $images
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->channels = $channels;
        $this->translations = $translations;
        $this->images = $images;
    }

    /**
     * @param array $data
     *
     * @return Product
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

        $channels = [];
        if (isset($data['channels'])) {
            $channels = $data['channels'];
        }

        $translations = [];
        if (isset($data['translations'])) {
            $translations = $data['translations'];
        }

        $images = [];
        if (isset($data['images'])) {
            foreach ($data['images'] as $image) {
                $images[] = Image::createFromArray($image);
            }
        }

        return new self($id, $code, $channels, $translations, $images);
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
     * @return string[]
     */
    public function getChannels(): array
    {
        return $this->channels;
    }

    /**
     * @return \string[][]
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }

    /**
     * @return Image[]
     */
    public function getImages(): array
    {
        return $this->images;
    }
}
