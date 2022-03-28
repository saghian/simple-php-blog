<?php

// Config
define('BASE_URL', 'http://localhost/100DaysCode/PHP-toplearn/02-PHP-blog/');



function redirect($url)
{
    header('location: ' . trim(BASE_URL, '/ ') . '/' . trim($url, '/ '));
    exit;
}


function asset($file)
{

    return trim(BASE_URL, '/ ') . '/' . trim($file, '/ ');
}

function url($url)
{

    return trim(BASE_URL, '/ ') . '/' . trim($url, '/ ');
}

function dd($var)
{
    echo '<b>Var dump & Die!</b>';
    echo '<br> -----------------------------------------------';
    echo '<pre>';
    var_dump($var);
    exit;
}
