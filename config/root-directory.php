<?php
$serverName = $_SERVER["SERVER_NAME"];

$rootDirectory = "/";

if ($serverName === "localhost" || $serverName === "127.0.0.1") {
    $rootDirectory = "/event-management/";
}
