<?php
class Session {
    public $data = array();

    public function __construct() {
        if (!session_id()) {
            ini_set('session.use_only_cookies', 'On');
            ini_set('session.use_cookies', 'On');
            ini_set('session.trans_sid', 'Off');
            ini_set('session.cookie_httponly', 'On');

            session_start();
        }

        // Связываем локальный массив с глобальной сессией PHP
        $this->data =& $_SESSION;
    }
}
