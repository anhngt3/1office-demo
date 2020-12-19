<?php

namespace App\Controllers;

class BaseController
{
    public function upload($file, $folder)
    {
        $target_dir = "uploads/$folder/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0775, true);
        }
        $uploadOk = 0;
        $imageFileType = strtolower(pathinfo(basename($file["name"]), PATHINFO_EXTENSION));
        $file_name = $this->generateRandomString(5) . '.' . $imageFileType;
        $target_file = $target_dir . $file_name;
        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($file["tmp_name"]);
            if ($check !== false) {
                // echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            }
        }

        // Check if file already exists
        if (!file_exists($target_file)) {
            //  echo "Sorry, file already exists.";
            $uploadOk = 1;
        }

        // Check file size
        $size = $file["size"]/1024/1024;
        if ($size < 2) {
            // echo "Sorry, your file is too large.";
            $uploadOk = 1;
        }

        $arr_file_type = ['jpg', 'png', 'jpeg', 'gif'];
        // Allow certain file formats
        if (in_array($imageFileType, $arr_file_type)) {
            $uploadOk = 1;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1) {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $folder . '/' . $file_name;
            }
        }
        return false;
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}