<?php

namespace Awgst\Sprint\Generators;

use Awgst\Sprint\Exceptions\FileAlreadyExistsException;

class FileGenerator extends Generator
{
    private $path;
    private $content;

    /**
     * File generator
     * @param string $path to put $content
     * @param mix $content
     */
    public function __construct(string $path, $content)
    {
        $this->path = $path;
        $this->content = $content;    
    }

    /**
     * Generate file
     */
    public function generate()
    {
        try {
            // Check if file already exists
            $fileExists = file_exists($this->path);
            if ($fileExists) {
                throw new FileAlreadyExistsException('File already exists');
            }

            file_put_contents($this->path, $this->content);
        } catch (FileAlreadyExistsException $e) {
            return sprint_error($e);
        }

        return true;
    }
}