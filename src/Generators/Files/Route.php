<?php

namespace Awgst\Sprint\Generators\Files;

use Awgst\Sprint\Generators\FileGenerator;
use Awgst\Sprint\Generators\Generator;
use Awgst\Sprint\Modules\Module;
use Awgst\Sprint\Support\Stuff;

class Route extends Generator
{
    private $module;
    private $path = "Routes";
    private $className;
    private $stuff;

    public function __construct(Module $module)
    {
        $this->module = $module;
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
        return $this->generateRoute($this->module);
    }

    /**
     * Generate Route
     * @param Module $module
     */
    private function generateRoute(Module $module)
    {
        $content = (new Stuff($this->stuff, [
            'NAME_LOWER' => strtolower($module->getName()),
            'CONTROLLER' => $module->getName().'Controller'
        ]))->render();

        if ($this->stuff == 'route/web.stuff') {
            $file = 'web';
        }

        if ($this->stuff == 'route/api.stuff') {
            $file = 'api';
        }

        return (new FileGenerator($module->getPath()."/{$this->path}/{$file}.php", $content))->generate();
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
     * Get Route default class name
     */
    private function className()
    {
        return $this->className;
    }

    /**
     * Set Route class name
     * @param string $name
     */
    public function setClassName(string $name)
    {
        $this->className = $name;
        return $this;
    }

    /**
     * Set Route stuff
     */
    public function setStuff(string $stuff)
    {
        $this->stuff = $stuff;
        return $this;
    }
}