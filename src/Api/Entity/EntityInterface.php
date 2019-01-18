<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 19.01.19
 * Time: 0:25
 */

namespace App\Api\Entity;


interface EntityInterface
{
    /**
     * Gets unique ID of entity.
     *
     * @return mixed
     */
    public function getId();
}