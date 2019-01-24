<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Api\Document;

use App\Api\Entity\EntityInterface;
use App\Api\Mapper\ApiMapperInterface;

final class DocumentBuilder
{
    private $apiMapper;
    private $document;

    public static function getInstance(ApiMapperInterface $apiMapper): self
    {
        $builder = new self($apiMapper);
        $builder->createDocument();

        return $builder;
    }

    public function __construct(ApiMapperInterface $apiMapper)
    {
        $this->apiMapper = $apiMapper;
    }

    public function createDocument(): self
    {
        $this->document = new Document();

        return $this;
    }

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function setEntity(EntityInterface $entity): self
    {
        $resource = new Resource($this->apiMapper->getType());
        $resource->setId($entity->getId());
        $resource->setAttributes($this->apiMapper->getAttributes($entity));
        $this->document->setData($resource);

        return $this;
    }
}
