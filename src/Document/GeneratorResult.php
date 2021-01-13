<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class GeneratorResult
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $externalId;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    protected $content;

    /**
     * Advertisement constructor.
     * @param string $externalId
     * @param string $content
     */
    public function __construct(string $externalId, string $content)
    {
        $this->externalId = $externalId;
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Advertisement
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Advertisement
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param mixed $externalId
     * @return Advertisement
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;

        return $this;
    }
}
