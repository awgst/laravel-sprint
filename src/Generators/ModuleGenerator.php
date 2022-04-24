<?php

namespace Awgst\Sprint\Generators;

use Awgst\Sprint\Contracts\Generator\GenerateController;
use Awgst\Sprint\Contracts\Generator\GenerateEntities;
use Awgst\Sprint\Generators\Files\Controller;
use Awgst\Sprint\Generators\Files\Entities;
use Awgst\Sprint\Installers\Installer;
use Awgst\Sprint\Modules\Module;

class ModuleGenerator extends Generator implements GenerateEntities, GenerateController
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
        $success = false;
        $module = $this->module;
        // Generate Folder
        $success = $this->generateFolder($module);
        // Generate File
        if ($success) {
            $success = $this->generateFile($module);
        }

        return $success;
    }

    /**
     * Generate Folder
     * @param Module $module
     */
    private function generateFolder(Module $module)
    {
        $path = $module->getPath();
        $install = (new Installer())->run($path);

        return $install;
    }

    /**
     * Generate file
     * @param Module $module
     */
    private function generateFile(Module $module)
    {
        $success = false;
        if ($this instanceof GenerateEntities) {
            $success = (new Entities($module))->generate();
        }

        if ($this instanceof GenerateController) {
            $success = (new Controller($module))->generate();
        }

        return $success;
    }
}