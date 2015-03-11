<?php
class Registry
{
    static private $_instance = null;

    private $_registry = array();

    static public function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    static public function set($key, $object) {
        self::getInstance()->_registry[$key] = $object;
    }

    static public function get($key) {
        return self::getInstance()->_registry[$key];
    }

    private function __wakeup() {
    }

    private function __construct() {
    }

    private function __clone() {
    }
}
