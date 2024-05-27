<?php

/**
 * Description of FixUrl
 *
 * @author Andrey
 */
trait FixUrl {
    protected function getUrl(){
        #session_start();
        #$_SESSION['url'] = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
    }
}
