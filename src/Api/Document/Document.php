<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
