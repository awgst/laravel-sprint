<?php 

namespace Awgst\Sprint\Contracts\Generator;

use Awgst\Sprint\Modules\Module;

interface GenerateEntities
{
    public function generateEntities(Module $module);
}