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
    private $className;

    public function __construct(Module $module)
    {
        $this->module = $module;
        $this->namespace = $this->getDefaultNamespace();
        $this->className = $this->module->getName();
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
        $className = $this->getClassName();
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
     * Get Provider default class name
     */
    private function className()
    {
        return $this->className;
    }

    /**
     * Set Provider class name
     * @param string $name
     */
    public function setClassName(string $name)
    {
        $this->className = $name;
        return $this;
    }

    /**
     * Set Provider stuff
     */
    public function setStuff(string $stuff)
    {
        $this->stuff = $stuff;
        return $this;
    }

    /**
     * Get provider namespace
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Get Provider class name
     */
    public function getClassName()
    {
        return $this->className().'Controller';
    }
}