<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 19.01.19
 * Time: 0:02
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