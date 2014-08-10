<?php
require_once("fretalaAPI.php");

$auth = array(
  "clientId" => "ecommerce",
  "clientSecret" => "Q6eH4nxD",
  "username" => "YOUR_EMAIL_HERE",
  "password" => "YOUR_PASSWORD_HERE"
);

$freta = new FretalaAPI("sandbox", $auth);

$card = array(
 "name" => "lucas lobosque",
 "number" => "4111111111111111",
 "cvv" => "123",
 "expDate" => "201812"
);

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

//$insertCardRtn  = $freta->insertCard($card);
//$deleteCardRtn  = $freta->deleteCard('car_2cc2750e0e6172cc24be429ee8e4e24af9a89973');
//$getCardsRtn    = $freta->getCards();
//$insertFreteRtn = $freta->insertFrete($frete);
//$costRtn        = $freta->cost($route);
//$token = $freta->authenticate(); //no caso de precisar mandar uma token pro browser
