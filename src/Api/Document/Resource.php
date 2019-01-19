<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Api\Document;

class Resource implements \JsonSerializable
{
    private $id;
    private $type;
    private $attributes;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'attributes' => $this->attributes,
        ];
    }

    public function __get(string $name): string
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
        throw new \LogicException(
            \sprintf(
                'Attribute "%s" not found in resource of type "%s"',
                $name,
                $this->type
            )
        );
    }
}
