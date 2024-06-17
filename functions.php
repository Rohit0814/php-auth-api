<?php
spl_autoload_register(function ($className) {
    $className = strtolower($className);
    $path = searchFile(__DIR__, $className . '.php');

    //echo $path . "<br/>";

    if ($path) {
        require_once($path);
    } else {
        echo "File for class $className is not found.";
    }
});

function searchFile($dir, $fileName)
{
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $file) {
        if (strtolower($file->getFilename()) === $fileName) {
            return $file->getPathname();
        }
    }
    return false;
}
