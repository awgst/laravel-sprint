<?php

if (! function_exists('apps')) {
    function apps()
    {
        $modules = [];
        $directory = './Modules';

        if (is_dir($directory)) {
            $folders = opendir($directory);

            while (($subfolder=readdir($folders)) !== false) {
                if ($subfolder != '.' && $subfolder != '..') {
                    array_push($modules, $subfolder);
                }
            }
        }

        return $modules;
    }
}

if (! function_exists('panic')) {
    function panic($e)
    {
        echo $e->getMessage();
    }
}