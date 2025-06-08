<?php
require_once __DIR__ . '/../rest/AuthRest.php';

Flight::route('POST /login', ['AuthRest', 'login']);
Flight::route('POST /register', ['AuthRest', 'register']);
Flight::route('POST /logout', ['AuthRest', 'logout']);

?>