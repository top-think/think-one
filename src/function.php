<?php

function think_one_check_install()
{
    $assets = $_SERVER['DOCUMENT_ROOT'] . '/static/think/one';
    if (!is_dir($assets)) {
        recurse_copy(THINK_ONE_ASSETS, $assets);
    }
}

function recurse_copy($src, $des)
{
    $dir  = opendir($src);
    @mkdir($des);
    while (false !== ( $file = readdir($dir))) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if (is_dir($src . '/' . $file)) {
                recurse_copy($src . '/' . $file, $des . '/' . $file);
            } else {
                if (!is_dir(dirname($des . '/' . $file))) {
                    mkdir(dirname($des . '/' . $file), 0777, true);
                }
                copy($src . '/' . $file, $des . '/' . $file);
            }
        }
    }
    closedir($dir);
}

function think_one_assets($assets = '')
{
    return '/static/think/one/' . $assets;
}
