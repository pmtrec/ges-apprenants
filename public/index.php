<?php
use APP\MESS\Enums\Textes;
include __DIR__ ."/../app/enums/chemin.php";
include_once __DIR__ ."/../app/enums/fonctionEnumu.php";
session_start();
define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST']);


require_once __DIR__ . Chemins::Routes->value;