<?php

if (! function_exists('sprint_apps')) {
    function sprint_apps()
    {
        $modules = [];
        $directory = './'.config('sprint.path');

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

if (! function_exists('sprint_error')) {
    function sprint_error($e)
    {
        $message = is_string($e) ? $e : $e->getMessage();
        $GLOBALS['SPRINT_ERRORS'] = $message;
        return false;
    }
}

if (! function_exists('sprint_path')) {
    function sprint_path($name, $filePath)
    {
        return config('sprint.path')."{$name}/{$filePath}";
    }
}