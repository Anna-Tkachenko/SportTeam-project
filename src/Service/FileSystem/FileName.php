<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\FileSystem;

class FileName implements FileNameInterface
{
    public function getName(string $originName): string
    {
        return \md5(\uniqid($originName));
    }
}
