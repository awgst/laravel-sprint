<?php

namespace Awgst\Sprint\Generators\Files;

use Awgst\Sprint\Generators\FileGenerator;
use Awgst\Sprint\Generators\Generator;
use Awgst\Sprint\Modules\Module;
use Awgst\Sprint\Support\Stuff;

class Entities extends Generator
{
    private $module;
    private $namespace;

    public function __construct(Module $module)
    {
        $this->module = $module;
        $this->namespace = $this->getDefaultNamespace();
    }

    /**
     * Generate
     */
    public function generate()
    {
        return $this->generateEntities($this->module);
    }

    /**
     * Generate Entities
     * @param Module $module
     */
    private function generateEntities(Module $module)
    {
        $content = (new Stuff('model/model.stuff', [
            'NAMESPACE' => $this->namespace,
            'CLASS' => $this->className()
        ]))->render();
        return (new FileGenerator($module->getPath()."/Entities/{$module->getName()}.php", $content))->generate();
    }

    /**
     * Get Entities default namespace
     */
    private function getDefaultNamespace() : string
    {
        $path = $this->module->getPath();
        $path .= '\\Entities';

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