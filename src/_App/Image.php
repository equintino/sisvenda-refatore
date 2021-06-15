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
        $percent = explode(",", file_get_contents(__DIR__ . "/../public/percent.txt"));
        $reading = [
            "rowsTotal" => $percent[0],
            "rowLast"   => count($percent) - 1
        ];

        return print(json_encode($reading));
    }

    public function removeFile(array $data)
    {
        $file = $data["file"];
        $handle = __DIR__ . "/../public/{$file}";
        unlink($handle);
        $f = fopen($handle, "w+");
        fclose($f);

        return print(json_encode($file));
    }
}
