<?php

namespace Awgst\Sprint\Generators;

use Awgst\Sprint\Contracts\Generator\GenerateEntities;
use Awgst\Sprint\Installers\Installer;
use Awgst\Sprint\Modules\Module;
use Awgst\Sprint\Support\Stuff;

class ModuleGenerator extends Generator implements GenerateEntities
{
    private $module;

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    /**
     * Generate Module
     */
    public function generate()
    {
        $module = $this->module;
        // Generate Folder
        $this->generateFolder($module);
        // Generate File
        $this->generateFile($module);

        return true;
    }

    /**
     * Generate Folder
     * @param Module $module
     */
    private function generateFolder(Module $module)
    {
        $path = $module->getPath();
        $install = (new Installer())->run($path);
    }

    /**
     * Generate file
     * @param Module $module
     */
    private function generateFile(Module $module)
    {
        if ($this instanceof GenerateEntities) {
            $this->generateEntities($module);
        }
    }

    /**
     * Generate Entities
     * @param Module $module
     */
    public function generateEntities(Module $module)
    {
        $content = (new Stuff('model/model.stuff', [
            'NAMESPACE' => $module->namespace['entities'],
            'CLASS' => $module->getName()
        ]))->render();
        (new FileGenerator($module->getPath()."/Entities/{$module->getName()}.php", $content))->generate();
    }
}