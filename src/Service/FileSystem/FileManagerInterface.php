<?php
/**
 * Created by PhpStorm.
 * User: anna
 * Date: 22.01.19
 * Time: 21:34
 */

namespace App\Service\FileSystem;


use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileManagerInterface
{
    public function upload(UploadedFile $file);
}