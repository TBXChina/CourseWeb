<?php
    include_once "include/configure.php";
    //some function related to web
    class Web {
        static public function Jump2Web($relativePath) {
            //$url = Configure::$URL."/".$relativePath;
            $url = $relativePath;
            header("Location: $url");
        }
    }
?>