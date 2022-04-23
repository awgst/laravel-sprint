<?php

namespace Awgst\Sprint\Support;

class Stuff
{
    private $path;
    private $replaces;

    public static $basepath = __DIR__.'/../Stuffs/';

    /**
     * Stuff
     * @param string $path to .stuff file
     * @param array $replace
     */
    public function __construct(string $path, array $replaces = [])
    {
        $this->path = $path;
        $this->replaces = $replaces;    
    }


    /**
     * Static create function
     * @param string $path to .stuff file
     * @param array $replace
     */
    public static function create(string $path, array $replaces = [])
    {
        return new static($path, $replaces);
    }

    /**
     * Get content of .stuff file
     */
    protected function getContent()
    {
        $contents = file_get_contents($this->getPath());

        foreach ($this->replaces as $search => $replace) {
            $contents = str_replace('%'.strtoupper($search).'%', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get Path of .stuff file
     */
    public function getPath()
    {
        return static::$basepath.$this->path;
    }

    /**
     * Function render
     */
    public function render()
    {
        return $this->getContent();
    }
}