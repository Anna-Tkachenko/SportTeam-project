<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 22.01.19
 * Time: 21:40
 */

namespace App\Service\FileSystem;


interface FileNameInterface
{
    public function getName(string $originName): string;
}