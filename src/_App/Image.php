<?php

namespace _App;

class Image extends Controller
{
    public function open(array $data)
    {
        $img = $data["img"];
        echo "<img src='" . theme("assets/img/{$img}")  . "' alt='' />";
    }
}
