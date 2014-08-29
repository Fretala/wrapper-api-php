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
 "id" => "MM8513110213",
 "productValue" => "6000",
 "from" => array(
   "number" => "234",
   "street" => "Rua Rio de Janeiro",
   "city" => "Belo Horizonte", 
   "state" => "Minas Gerais"
 ),
 "to" => array(
   "number" => "2500",
   "street" => "Rua Timbiras 2500",
   "city" => "Belo Horizonte", 
   "state" => "Minas Gerais"
 )
);

$route = array(
 "from" => array(
   "number" => "234",
   "street" => "Rua Rio de Janeiro 653",
   "city" => "Belo Horizonte", 
   "state" => "Minas Gerais"
 ),
 "to" => "30140-122"
);

//remova o comentário da chamada que quiser testar

//$insertFreteRtn = $freta->insertFrete($frete);
//$costRtn        = $freta->cost($route);
