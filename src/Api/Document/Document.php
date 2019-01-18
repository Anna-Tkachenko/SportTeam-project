<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 19.01.19
 * Time: 0:20
 */

namespace App\Api\Document;


final class Document implements \JsonSerializable
{
    private $data = [];

    public function setData($data): void
    {
        $this->data = $data;
    }

    public function jsonSerialize()
    {
        return [
            'data' => $this->data,
        ];
    }
}