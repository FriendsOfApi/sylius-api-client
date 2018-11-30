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
    private $id = 0;

    /**
     * @var null|string
     */
    private $name;

    /**
     * @var null|string
     */
    private $code = '';

    /**
     * @var string[]
     */
    private $channels = [];

    /**
     * @var string[][]
     */
    private $translations = [];

    /**
     * @var Image[]
     */
    private $images = [];

    private function __construct()
    {
    }

    /**
     * @return Product
     */
    public static function createFromArray(array $data): self
    {
        $model = new self();
        if (isset($data['id'])) {
            $model->id = $data['id'];
        }

        if (isset($data['code'])) {
            $model->code = $data['code'];
        }
        if (isset($data['name'])) {
            $model->name = $data['name'];
        }

        if (isset($data['channels'])) {
            $model->channels = $data['channels'];
        }

        $translations = [];
        if (isset($data['translations'])) {
            $model->translations = $data['translations'];
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $image) {
                $model->images[] = Image::createFromArray($image);
            }
        }

        return $model;
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

    public function getName(): ?string
    {
        return $this->name;
    }
}
