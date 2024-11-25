<?php
namespace App\Http\Controllers;

function pr($param)
{
    echo "<pre style='background-color:black; color:gold; padding:5px;'>";
    print_r($param);
    echo "</pre>";
}

function vd($param)
{
    echo "<pre style='background-color:black; color:gold; padding:5px;'>";
    var_dump($param);
    echo "</pre>";
}
