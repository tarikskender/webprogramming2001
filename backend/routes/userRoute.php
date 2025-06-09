<?php
require_once __DIR__ . '/../rest/UserRest.php';

Flight::route('GET    /users'       , ['UserRest','getAll']);
Flight::route('GET    /users/@id'   , ['UserRest','getById']);
Flight::route('POST   /users'       , ['UserRest','create']);
Flight::route('PUT    /users/@id'   , ['UserRest','update']);
Flight::route('DELETE /users/@id'   , ['UserRest','delete']);
?>

