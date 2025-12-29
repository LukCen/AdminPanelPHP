<?php

namespace Acme;

use RuntimeException;

class RawgService
{
  private $base_link = "https://api.rawg.io/api/";
  private $api_key;

  public function __construct(string $api_key)
  {
    $this->api_key = $api_key;
  }

  function fetchData($endpoint, $params = null)
  {
    $parameter_list = "";

    // concatenate the params array into a string
    if (!empty($params)) {
      foreach ($params as $key => $value):
        $parameter_list .= "&$key=$value";
      endforeach;
    }
    $init = curl_init();
    curl_setopt_array($init, [
      CURLOPT_URL => $this->base_link . $endpoint . "?key=" . $this->api_key . $parameter_list,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 10,
      CURLOPT_HTTPHEADER => ["Accept: application/json"]
    ]);

    $response = curl_exec($init);

    if ($response === false || $response === null || empty($response)) {
      throw new RuntimeException(curl_error($init));
    }

    curl_close($init);

    $data = json_decode($response, true);

    if ($data === null) {
      throw new RuntimeException("Failed to decode the data, returned : [$data ] instead.");
    }
    return $data;
  }


  // fetchData for game pages, with extra param
  function fetchDataGamePage($endpoint, $gameId)
  {
    $parameter_list = "";
    $init = curl_init();
    curl_setopt_array($init, [
      CURLOPT_URL => $this->base_link . $endpoint . '/' . $gameId . "?key=" . $this->api_key . $parameter_list,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 10,
      CURLOPT_HTTPHEADER => ["Accept: application/json"]

    ]);

    $response = curl_exec($init);

    if ($response === false || $response === null || empty($response)) {
      throw new RuntimeException(curl_error($init));
    }

    curl_close($init);
    // var_dump(curl_getinfo($init));
    $data = json_decode($response, true);

    if ($data === null) {
      throw new RuntimeException("Failed to decode the data, returned : [$data ] instead.");
    }
    return $data;
  }
}


