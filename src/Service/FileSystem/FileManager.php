<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 22.01.19
 * Time: 21:31
 */

namespace App\Service\FileSystem;

use Symfony\Component\HttpFoundation\File\UploadedFile;

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