<?php


Class Session implements ArrayAccess{
    
    const prefix = _SESSION_PREFIX;

    public function __construct() {
        session_name("ss");
        @session_start();
    }

    public function get_id() {
        return session_id();    
    }
    
    function destroy() {
        session_destroy();
    }

    public function offsetExists($property) {
        return isset($_SESSION[self::prefix.$property]);
    }
    public function offsetGet($property) {
        if ($this->offsetExists($property)) {
            return $_SESSION[self::prefix.$property];
        }
        else {
            return false;
        }
    }    
    public function offsetSet($property,$value) {
        $_SESSION[self::prefix.$property] = $value;
    }
    public function offsetUnset($property) {
        if ($this->offsetExists($property)) {
            unset($_SESSION[self::prefix.$property]);
        }
    }


}
?>