<?php

namespace Awgst\Sprint\Installers;

use Awgst\Sprint\Exceptions\SprintAlreadyExistsException;
use Exception;

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
        $success = false;
        $this->path = $path;
        $success = $this->runningType($type);

        return $success;
    }

    /**
     * Default way to install using shell command
     * 
     */
    private function defaultRun()
    {
        try {
            $path = $this->path;
            $template = str_replace('Installers/Installer.php', 'Templates/Apps/*', __FILE__);
            $command = "cp -R $template ./$path";
            if (file_exists($path)) {
                throw new SprintAlreadyExistsException('Sprint already exists');
            }
            mkdir($path, 0755, true);
            shell_exec($command);
            shell_exec("chmod -R 777 ./$path");
        } catch (Exception $e) {
            return sprint_error($e);
        }

        return true;
    }
}