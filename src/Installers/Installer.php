<?php

namespace Awgst\Sprint\Installers;

class Installer
{
    private $path;
    const DEFAULT = 1;

    /**
     * Installer running type
     */
    private function runningType($type)
    {
        $types = [
            self::DEFAULT => $this->defaultRun(),
        ];
        return $types[$type];
    }

    /**
     * Running
     */
    public function run($path, $type=self::DEFAULT)
    {
        $this->path = $path;
        $this->runningType($type);
    }

    /**
     * Default way to install using shell command
     * 
     */
    private function defaultRun()
    {
        $path = $this->path;
        $template = str_replace('Installers/Installer.php', 'Templates/Apps/*', __FILE__);
        $command = "cp -R $template ./$path";
        mkdir($path, 0755, true);
        shell_exec($command);
        shell_exec("chmod -R 777 ./$path");
    }
}