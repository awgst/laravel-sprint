<?php

namespace Awgst\Sprint\Generators;

use Awgst\Sprint\Contracts\Generator\GenerateController;
use Awgst\Sprint\Contracts\Generator\GenerateEntities;
use Awgst\Sprint\Contracts\Generator\GenerateProvider;
use Awgst\Sprint\Contracts\Generator\GenerateRoute;
use Awgst\Sprint\Generators\Files\Controller;
use Awgst\Sprint\Generators\Files\Entities;
use Awgst\Sprint\Generators\Files\Provider;
use Awgst\Sprint\Generators\Files\Route;
use Awgst\Sprint\Installers\Installer;
use Awgst\Sprint\Modules\Module;
use Awgst\Sprint\Support\Stuff;

class ModuleGenerator extends Generator implements 
GenerateEntities, 
GenerateController, 
GenerateProvider,
GenerateRoute
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
            $controller['namespace'] = (new Controller($module))->getNamespace().'\\'.(new Controller($module))->getClassName();
            $success = (new Controller($module))->generate();
        }

        if ($this instanceof GenerateProvider) {
            $providerObject= (new Provider($module));
            $provider['namespace'] = $providerObject->getNamespace().'\\'.$providerObject->getClassName();
            $success = (new Provider($module))->setStuff('provider/appserviceprovider.stuff')
                                            ->generate();
            $success = (new Provider($module))->setStuff('provider/routeserviceprovider.stuff')
                                            ->setClassName('Route')
                                            ->generate();
        }

        if ($this instanceof GenerateRoute) {
            $success = (new Route($module))->setController($controller)
                                        ->setStuff('route/web.stuff')
                                        ->generate();
            $success = (new Route($module))->setStuff('route/api.stuff')
                                        ->generate();
        }

        $success = $this->generateJsonFile($module, $provider);



        return $success;
    }

    /**
     * Generate json file
     * @param Module $module
     */
    private function generateJsonFile(Module $module, array $provider)
    {
        $success = false;
        foreach ([
            'composer'=>'json/composer.stuff', 
            'module'=>'json/module.stuff', 
            'package'=>'json/package.stuff'
        ] as $file => $stuff) {
            $content = (new Stuff($stuff, [
                'SPRINT_PATH' => str_replace('/', '\\\\', sprint_path($module->getName(), '')),
                'SPRINT' => $module->getName(),
                'SPRINT_LOWER' => strtolower($module->getName()),
                'PROVIDER_PATH' => str_replace('\\', '\\\\', $provider['namespace'])
            ]))->render();
    
            $success =  (new FileGenerator($module->getPath()."/{$file}.json", $content))->generate();
        }

        return $success;
    }
}