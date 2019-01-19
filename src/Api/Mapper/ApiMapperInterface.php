<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Api\Mapper;

interface ApiMapperInterface
{
    /**
     * Gets type of resource.
     *
     * @return string
     */
    public function getType(): string;
    /**
     * Gets resource attributes.
     *
     * @param $entity
     *
     * @return iterable
     */
    public function getAttributes($entity): iterable;
}
