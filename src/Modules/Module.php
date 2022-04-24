<?php

namespace Awgst\Sprint\Modules;

class Module
{
    private $name;
    private $path;
    public $namespace = [];

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->path = config('sprint.path').$name;
    }

    /**
     * Set Module Name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get Module Name
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set Module Path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    /**
     * Get Module Path
     */
    public function getPath() : string
    {
        return $this->path;
    }
}