<?php

namespace Awgst\Sprint\Generators\Files;

use Awgst\Sprint\Generators\FileGenerator;
use Awgst\Sprint\Generators\Generator;
use Awgst\Sprint\Modules\Module;
use Awgst\Sprint\Support\Stuff;

class Provider extends Generator
{
    private $module;
    private $namespace;
    private $path = "Providers";
    private $className;
    private $stuff;

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
        return $this->generateProvider($this->module);
    }

    /**
     * Generate Provider
     * @param Module $module
     */
    private function generateProvider(Module $module)
    {
        $className = $this->getClassName();
        $content = (new Stuff($this->stuff, [
            'NAMESPACE' => $this->namespace,
            'CLASS' => $className,
            'NAME' => $module->getName(),
            'NAME_LOWER' => strtolower($module->getName()),
            'SPRINT_NAMESPACE' => $this->getSprintNamespace($module)
        ]))->render();
        return (new FileGenerator($module->getPath()."/{$this->path}/{$className}.php", $content))->generate();
    }

    /**
     * Get Provider default namespace
     */
    private function getDefaultNamespace() : string
    {
        $path = $this->module->getPath();
        $path .= '\\'.$this->path;

        $path = str_replace('/', '\\', $path);

        return rtrim($path, '\\');
    }

    /**
     * Get sprint namespace
     * @param Module $module
     */
    private function getSprintNamespace(Module $module)
    {
        $namespace = sprint_path($module->getName(), 'Http/Controller');

        $namespace = str_replace('/', '\\', $namespace);

        return rtrim($namespace, '\\');
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
        return $this->className().'ServiceProvider';
    }
}