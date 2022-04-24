<?php

namespace Awgst\Sprint\Generators\Files;

use Awgst\Sprint\Generators\FileGenerator;
use Awgst\Sprint\Generators\Generator;
use Awgst\Sprint\Modules\Module;
use Awgst\Sprint\Support\Stuff;

class Entities extends Generator
{
    private $module;

    public function __construct(Module $module)
    {
        $this->module = $module;    
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
            'NAMESPACE' => $module->namespace['entities'],
            'CLASS' => $module->getName()
        ]))->render();
        return (new FileGenerator($module->getPath()."/Entities/{$module->getName()}.php", $content))->generate();
    }
}