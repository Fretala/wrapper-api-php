<?php

define("FRETALA_SANDBOX_URL", "https://sandbox.freta.la");
define("FRETALA_PRODUCTION_URL", "https://api.freta.la");

class ValidationException extends Exception{}
class BadRequestException extends Exception{}
class InternalErrorException extends Exception{}

class FretalaAPI {
  private $token;
  private $environment; 
  private $postfields;
  private $getfield;
  private $clientId;
  private $clientSecret;
  private $username;
  private $password;
  public $url;

  public function __construct($environment, array $settings) {

    if (!in_array("curl", get_loaded_extensions())) {
      throw new Exception("You need to install cURL, see: http://curl.haxx.se/docs/install.html");
    }
    
    if(!isset($environment)) {
      throw new Exception("environment wasn\"t set");
    }

    if(!in_array($environment, array("sandbox", "production"))) {
      throw new Exception("environment must be production or sandbox");
    }

    $this->environment = $environment;
    if($environment == "production") {
      $this->url = FRETALA_PRODUCTION_URL;
    } else {
      $this->url = FRETALA_SANDBOX_URL;
    }

    $this->clientId = $settings["clientId"];
    $this->clientSecret = $settings["clientSecret"];
    $this->username = $settings["username"];
    $this->password = $settings["password"];

    $this->token = '';
  }

  public function authenticate() {
    $data = array(
      "grant_type" => "password",
      "username" => $this->username,
      "password" => $this->password
    );
    $res = $this->performRequest("POST", "/authenticate", json_encode($data), true);
    $this->token = $res->access_token;
    return $res->access_token;
  }

  public function getCards() {
    $this->authenticate();
    return $this->performRequest("GET", "/cards");
  }
  
  public function insertCard($card) {
    $this->authenticate();
    return $this->performRequest("POST", "/cards", json_encode($card));
  }

  public function deleteCard($cardToken) {
    $this->authenticate();
    return $this->performRequest("DELETE", "/cards/".$cardToken);
  }

  public function insertFrete($frete) {
    $this->authenticate();
    return $this->performRequest("POST", "/fretes", json_encode($frete));
  }

  public function cost($cost) {
    return $this->performRequest("POST", "/fretes/cost", json_encode($cost));
  }
  
  private function buildHeaders($auth = false) {
    $headers = array();
    if($auth) {
      $headers[] = "Authorization: Basic " . base64_encode($this->clientId.':'.$this->clientSecret);
    } else if($this->token != "") {
      $headers[] = "Authorization: Bearer " . $this->token;
    }
    $headers[] = "Content-Type: application/json";
    return $headers;
  }

/**
* Perform the actual data retrieval from the API
*
* @param string $type GET, POST, PUT or DELETE
* @param string $path endpoint path
* @param string $path data to be send in POST or PUT requests
*
* @return string json If $return param is true, returns json data.
*/
  private function performRequest($type, $path, $data=null, $auth=false) {
    $options = array(
      CURLOPT_HTTPHEADER => $this->buildHeaders($auth),
      CURLOPT_HEADER => false,
      CURLOPT_URL => $this->url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 10,
      CURLOPT_URL => $this->url . $path
    );

    if ($type == "POST") {
      $options[CURLOPT_POSTFIELDS] = $data;
    } else if($type == "DELETE") {
      $options[CURLOPT_CUSTOMREQUEST] = "DELETE";
    } else if($type == "PUT") {
      $options[CURLOPT_CUSTOMREQUEST] = "PUT";
      $options[CURLOPT_POSTFIELDS] = $data;
    }

    $feed = curl_init();
    curl_setopt_array($feed, $options);
    $json = json_decode(curl_exec($feed));
    $status = curl_getinfo($feed, CURLINFO_HTTP_CODE);
    if($status != 200 && $status != 204) {
      $err_msg = property_exists($json, 'message') ? $json->message : $json->error_description;
      if($status == 422) {
        throw new ValidationException($err_msg);
      } else if($status = 400) {
        throw new BadRequestException($err_msg);
      } else if($status = 500) {
        throw new InternalErrorException($err_msg);
      } else {
        throw new Exception($err_msg);
      }
    }
    curl_close($feed);
    $this->token = '';
    return $json;
  }
}
