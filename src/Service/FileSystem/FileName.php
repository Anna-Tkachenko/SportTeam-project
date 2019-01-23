<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 22.01.19
 * Time: 21:40
 */

namespace App\Service\FileSystem;


class FileName implements FileNameInterface
{
    public function getName(string $originName): string
    {
        return \md5(\uniqid($originName));
    }
}