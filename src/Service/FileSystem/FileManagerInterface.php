<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\FileSystem;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Contract for file manager.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
interface FileManagerInterface
{
    public function upload(UploadedFile $file);
}
