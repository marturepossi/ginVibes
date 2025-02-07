<?php
spl_autoload_register(function(string $className) {
    $fileName = $className . ".php";
    $filePath = __DIR__ . '/../clases/' . $fileName;
    require_once $filePath;
});
