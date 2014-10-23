<?php
require_once("fretalaAPI.php");

$auth = array(
  "clientId" => "ecommerce",
  "clientSecret" => "Q6eH4nxD",
  "username" => "YOUR_EMAIL_HERE",
  "password" => "YOUR_PASSWORD_HERE"
);

$freta = new FretalaAPI("sandbox", $auth);

$frete = array(
 "orderId" => "MM8513110213",
 "productValue" => "6000",
 "from" => array(
   "name" => "Joaquim Pereira",
   "number" => "234",
   "street" => "Rua Rio de Janeiro",
   "city" => "Belo Horizonte", 
   "state" => "Minas Gerais",
   "cep" => "30160040"
 ),
 "to" => array(
   "name" => "Juliana Silva",
   "number" => "2500",
   "street" => "Rua Timbiras 2500",
   "city" => "Belo Horizonte", 
   "state" => "Minas Gerais",
   "cep" => "30140060"
 )
);

$route = array(
 "from" => "30120-908",
 "to" => "30110-005"
);

//remova o comentário da chamada que quiser testar

//$insertFreteRtn = $freta->insertFrete($frete);
//$freteRtn = $freta->getFrete('MM8513110213');
$costRtn        = $freta->cost($route);
print_r($costRtn);
