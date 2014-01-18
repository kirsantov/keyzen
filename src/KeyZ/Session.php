<?php
/**
 * Created by PhpStorm.
 * User: anatoliykirsantov
 * Date: 05.01.14
 * Time: 23:58
 */

namespace KeyZ;


class Session extends App {
    public static $vars = array();

    public function start() {
        session_start();
    }

    public function set($var,$value) {
        self::$vars[$var] = $value;
        $_SESSION[$var]=$value;
    }

    public function get($var) {
        return $_SESSION[$var];
    }

    public function delete($var) {
        unset($_SESSION[$var]);
    }

    public function getVars() {
        return self::$vars;
    }

    public function isVar($var) {
        return isset(self::$vars[$var]);
    }

    public function check($var,$value) {
        return ($_SESSION[$var]===$value);
    }

    public function checkInList($list,$var,$value) {
        return ($_SESSION[$list][$var]===$value);
    }

    public function checkAuth() {
        return (isset($_SESSION['_user']['id']) && $_SESSION['_user']['id']>0);
    }
}