<?php

define("FRETALA_SANDBOX_URL", "https://sandbox.freta.la");
define("FRETALA_PRODUCTION_URL", "https://api.freta.la");

class FretalaAPI {
  private $token;
  private $environment; 
  private $postfields;
  private $getfield;
  public $url;

  public function __construct(array $settings) {

    if (!in_array("curl", get_loaded_extensions())) {
      throw new Exception("You need to install cURL, see: http://curl.haxx.se/docs/install.html");
    }
    
    if (!isset($settings["token"])) {
      throw new Exception("Token wasn\"t set");
    }

    if(!isset($settings["environment"])) {
      throw new Exception("environment wasn\"t set");
    }

    if(!in_array($settings["environment"], array("sandbox", "production"))) {
      throw new Exception("environment must be production or sandbox");
    }

    $this->token = $settings["token"];
    $this->environment = $settings["environment"];
    if($settings["environment"] == "production") {
      $this->url = FRETALA_PRODUCTION_URL;
    } else {
      $this->url = FRETALA_SANDBOX_URL;
    }
  }

  public function getCards() {
    return $this->performRequest("GET", "/cards");
  }
  
  public function insertCard($card) {
    return $this->performRequest("POST", "/cards", json_encode($card));
  }

  public function deleteCard($cardToken) {
    return $this->performRequest("DELETE", "/cards/".$cardToken);
  }

  public function insertFrete($frete) {
    return $this->performRequest("POST", "/fretes", json_encode($frete));
  }

  public function cost($cost) {
    return $this->performRequest("POST", "/fretes/cost", json_encode($cost));
  }
  
  private function buildHeaders() {
    $header = array();
    $headers[] = "Authorization: Bearer " . $this->token;
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
  private function performRequest($type, $path, $data=null) {
    print_r($path);
    $options = array(
      CURLOPT_HTTPHEADER => $this->buildHeaders(),
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
    print_r($json);
    echo($status);
    if($status == 200) {
    } else {
      throw new Exception($json->message);
    }
    curl_close($feed);
    return $json;
  }
}
