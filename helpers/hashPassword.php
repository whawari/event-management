<?php
define("SALT", "@ss24!WH");

function hashPassword($password)
{
    return md5(SALT . $password);
}
