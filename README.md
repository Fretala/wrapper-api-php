Freta la - API
===============

Este projeto é uma interface para a nossa API. A documentação da API está detalhada [neste link][apidocs].

Uso
---

Todos os exemplos aqui citados estão em example.php:

### Instanciar objeto:
É necessário instanciar a nossa classe para fazer qualquer chamada:
```php
<?php
require_once("fretalaAPI.php");

$auth = array(
  "clientId" => "ecommerce",
  "clientSecret" => "Q6eH4nxD",
  "username" => "YOUR_EMAIL_HERE",
  "password" => "YOUR_PASSWORD_HERE"
);

$freta = new FretalaAPI("sandbox", $auth);

```
### Inserir Cartão:
**Observação:** Recomendamos que esta operação seja feita diretamente do browser, utilizando nosso [wrapper em javascript]

```php
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
**Observação:** Recomendamos que esta operação seja feita diretamente do browser, utilizando nosso [wrapper em javascript]
```php
<?php
$deleteCardRtn = $freta->deleteCard('car_2cc2750e0e6172cc24be429ee8e4e24af9a89973');
```

### Listar cartões:
**Observação:** Recomendamos que esta operação seja feita diretamente do browser, utilizando nosso [wrapper em javascript]
```php
<?php
$getCardsRtn = $freta->getCards();
```

### Calcular rota:
```php
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
```php
<?php
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
$insertCardRtn  = $freta->insertCard($card);
```

[apidocs]:http://freta.la/apidocs/
[wrapper em javascript]:https://github.com/Fretala/wrapper-api-javascript
