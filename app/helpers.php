<?php

function mix($path)
{
    $manifest = json_decode(file_get_contents(__DIR__ . '/../mix-manifest.json'), true);

    if ( ! array_key_exists($path, $manifest)) {
        throw new Exception(sprintf('File [%s] does not exists', $path));
    }

    return $manifest[$path];
}
