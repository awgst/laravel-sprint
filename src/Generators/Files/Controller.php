<?php

namespace Awgst\Sprint\Generators\Files;

use Awgst\Sprint\Generators\FileGenerator;
use Awgst\Sprint\Generators\Generator;
use Awgst\Sprint\Modules\Module;
use Awgst\Sprint\Support\Stuff;

class Controller extends Generator
{
    private $module;
    private $namespace;
    private $path = "Http/Controllers";

    public function __construct(Module $module)
    {
        $this->module = $module;
        $this->namespace = $this->getDefaultNamespace();
    }

    /**
     * Set Path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    /**
     * Generate
     */
    public function generate()
    {
        return $this->generateController($this->module);
    }

    /**
     * Generate Controller
     * @param Module $module
     */
    private function generateController(Module $module)
    {
        $className = $this->className().'Controller';
        $content = (new Stuff('controller/controller.stuff', [
            'NAMESPACE' => $this->namespace,
            'CLASS' => $className
        ]))->render();
        return (new FileGenerator($module->getPath()."/{$this->path}/{$className}.php", $content))->generate();
    }

    /**
     * Get Entities default namespace
     */
    private function getDefaultNamespace() : string
    {
        $path = $this->module->getPath();
        $path .= '\\'.$this->path;

        $path = str_replace('/', '\\', $path);

        return rtrim($path, '\\');
    }

    /**
     * Get Entities default class name
     */
    private function className()
    {
        return $this->module->getName();
    }
}