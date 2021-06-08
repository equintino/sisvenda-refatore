<?php

namespace _App;

class Image extends Controller
{
    public function open(array $data)
    {
        $img = $data["img"];
        echo "<img src='" . theme("assets/img/{$img}")  . "' alt='' />";
    }

    public function percent(array $data)
    {
        $percent = explode(",",(file_get_contents(__DIR__ . "/../public/percent.txt")));
        $reading = [
            "rowsTotal" => $percent[0],
            "rowLast"   => count($percent) - 1
        ];

        return print(json_encode($reading));
    }

    public function removeFile(array $file)
    {
        $handle = __DIR__ . "/../public/percent.txt";
        unlink($handle);
        fopen($handle, "w+");
        fclose($handle);

        return print(json_encode($file));
    }
}
