<?php

include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\UsersTable;

$table=new UsersTable(new MySQL);
$id=$table->insert([
    "name"=>"Alice",
    "email"=>"alice@gmail.com",
    "phone"=>"123456",
    "address"=>"yangon",
    "password"=>"password",
    "role_id" => 2,
]);

echo $id;