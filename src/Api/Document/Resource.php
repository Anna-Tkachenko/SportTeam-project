<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 19.01.19
 * Time: 0:28
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