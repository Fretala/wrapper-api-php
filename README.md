Freta la - API
===============

Este projeto é uma interface para a nossa API. A documentação está detalhada em [aqui][1]

Uso
---

Todos os exemplos aqui citados estão em example.php:

### Instanciar objeto:
É necessário instanciar a nossa classe para fazer qualquer chamada:
```
<?php
require_once("fretalaAPI.php");

$settings = array(
  "token" => "uvXTwX7Ub/t7aCGxDR3VTVO/GNBxHykhQC03DTjmvIY=",
  "environment" => "sandbox"
);
```
### Inserir Cartão:
```
<?php
$card = array(
 "name" => "234",
 "number" => "4111111111111111",
 "cvv" => "123",
 "expDate" => "201812"
);
$insertCardRtn  = $freta->insertCard($card);
```

### Deletar Cartão:
```
<?php
$deleteCardRtn = $freta->deleteCard('car_2cc2750e0e6172cc24be429ee8e4e24af9a89973');
```

### Listar cartões:
```
<?php
$getCardsRtn = $freta->getCards();
```

### Calcular rota:
```
<?php
$route = array(
 "from" => array(
   "number" => "234",
   "street" => "Rua Rio de Janeiro 653",
   "city" => "Belo Horizonte", 
   "state" => "Minas Gerais"
 ),
 "to" => "30140-122"
);
$costRtn = $freta->cost($route);
```

### Pedir frete:
```
<?php
$frete = array(
 "id" => "MM8513110213",
 "productValue" => "6000",
 "ccToken" => "car_d27f413bc5ba5acdcaed319838d3b971cd33478f",
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
$insertCardRtn  = $freta->insertCard($card);
```

[aqui]:http://freta.la/apidocs/

