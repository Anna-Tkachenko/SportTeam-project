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
 * File manager for uploads files to project.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
class FileManager implements FileManagerInterface
{
    private $fileName;
    private $uploadDir;

    public function __construct(FileNameInterface $fileName, string $uploadDir)
    {
        $this->fileName = $fileName;
        $this->uploadDir = $uploadDir;
    }

    public function upload(UploadedFile $file)
    {
        $newFileName = $this->fileName->getName($file->getClientOriginalName());
        $file->move($this->uploadDir, $newFileName);

        return $newFileName;
    }
}
