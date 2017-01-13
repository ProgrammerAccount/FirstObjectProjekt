<?php

class ReadyFileToUpload
{
    // atrybuty
    private $concent_type;

    private $file_type;

    private $tmp_file_name;

    public $file_name;

    // img ,film or music
    private $file_size;

    public $error_verify;

    public $good = true;

    private $connect;
    // metody
    public function __construct ($OrginalFileName, $tmp_name)
    {
        $this->tmp_file_name = $tmp_name;
        $info = finfo_open(FILEINFO_MIME_TYPE);
        $this->concent_type = finfo_file($info, $this->tmp_file_name);
        finfo_close($info);
        pathinfo($this->tmp_file_name);
        $this->file_size = filesize($this->tmp_file_name);
        $this->file_name = $OrginalFileName;
        $this->file_type = pathinfo($this->file_name, PATHINFO_EXTENSION);
        $this->connect();
    }

    private function connect ()
    {
        require 'connect.php';
        $this->connect = new mysqli($host, $user, $pass, $base);
        if ($this->connect->connect_error) {
            echo "ERROR NUMER: " . $this->connect->connect_errno;
        }
    }

    public function __destruct ()
    {
        $this->connect->close();
    }

    public function VerifySizeFile ($LimitSizeInBytes)
    {
        if ($this->file_size >= $LimitSizeInBytes) {
            $this->good = false;
            return "Ten plik za dużo waży!";
        }
    }

    // ---------------
    public function VerifyTypeFile ()
    {
        $obj = new Strategy();
        $obj->setType($this->concent_type);
        if ($obj->getType() == false)
        {
            $this->error_verify = "To nie jest img";
            $this->good = false;
        } 
        else {
            $obj->getType()->CheckExtesion($this->file_type);
            if ($obj->getType()->good == false) {
                $this->error_verify = $obj->getType()->ReturnError();
                $this->good = false;
            }
        }
    }
    // ---------------
    public function VerifyName ($where) // usuń $where
    {
        $this->file_name = md5($this->file_name);
        $return = $this->connect->query(
                "SELECT * FROM $where WHERE file_name='" . $this->file_name . "'");

        if ($return != false)
            while (@$return->num_rows > 0) {

                $this->file_name = $this->file_name . $this->file_name;
                $return = $this->connect->query(
                        "SELECT * FROM $where WHERE file_name='" .
                                 $this->file_name . "'");
            }

        $this->file_name = $this->file_name . "." . $this->file_type;
    }

    public function MoveFile ($idUser,$where)
    {
        if ($this->good == true) {

            chmod($this->tmp_file_name, 0777);
            $path = "Upload/" . $idUser . "/" . $where . "/" . $this->file_name;
            if(move_uploaded_file($this->tmp_file_name, $path))
                return true;
        }
    }
    // ---------------
    public function SanitizationText ($text_to_verify, $how_much_characters)
    {
        $save_text = htmlentities($text_to_verify);

        if (($save_text != $text_to_verify) &&
                 (strlen($save_text) <= $how_much_characters)) {
            return array(
                    $save_text,
                    true
            );
        } else {

            return $save_text;
        }
    }
    // ---------------
    function GetSize ()
    {
        $size = getimagesize($this->tmp_file_name);
        if (! $size) {
            return "to nie jest zdjecie";
            $this->good = false;
        } else {

            return true;
        }
    }

    function ValideDate ($date)
    {
        if ($date) {
            if (strlen($date) == 10) {
                if ((preg_match(
                        "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",
                        $date)) || (preg_match(
                        "/^[0-9]{4}.(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",
                        $date))) {
                    str_replace('%.%', "-", $date);
                }
            } else {
                $this->good = false;
                return 'Zle wpisaleś date sprobuj tak np. "2016.05.12"';
            }
        }
    }
}

interface file
{

    public function CheckExtesion ($type);

    public function ReturnError ();
}

class image implements file
{

    public $good = true;

    function CheckExtesion ($type)
    {
        if (($type != "png") && ($type != "gif") && ($type != "jpg") &&
                 ($type != "jpeg")) {
            $this->good = false;
        }

        return $this->good;
    }
    // ---------------
    function ReturnError ()
    {
        if ($this->good == false) {
            return "Nieprawidłowy plik lub rozszeżenie";
        }
    }
}

class film implements file
{

    public $good = true;

    function CheckExtesion ($type)
    {
        if ($type != "mp4")
            $this->good = false;

        return $this->good;
    }
    // ---------------
    function ReturnError ()
    {
        if ($this->good == false) {
            return "Nieprawidłowy plik lub rozszeżenie";
        }
    }
}

class audio implements file
{

    public $good = true;

    function CheckExtesion ($type)
    {
        if ($type != "mp3")
            $this->good = false;
    }
    // ---------------
    function ReturnError ()
    {
        if ($this->good == false) {
            return "Nieprawidłowy plik lub rozszeżenie";
        }
    }
}

class Strategy
{

    private $strategy;

    public function setType ($type)
    {
        switch ($type) {
            case strstr($type, "audio"):
                $this->strategy = new audio();
                break;
            case strstr($type, "image"):
                $this->strategy = new image();
                break;
            case strstr($type, "video"):
                $this->strategy = new film();
                break;
            default:
                {
                    $this->strategy = false;
                }
                break;
        }
    }

    public function getType ()
    {
        return $this->strategy;
    }
}


