<?php

include("../vendor/autoload.php");

use Faker\Factory as Faker;

use Helpers\Auth;
use Helpers\HTTP;
use Libs\Database\MySQL;
use Libs\Database\UsersTable;

Auth::check();
HTTP::redirect($url);

(new MySQL)->connect();
(new UsersTable($db))->insert($data);

$fake=Faker::create();
echo $fake->name;
echo "<br>";
echo $fake->email;
echo "<br>";
echo $fake->address;
echo "<br>";
