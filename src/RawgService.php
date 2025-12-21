<?php

namespace Acme;

use RuntimeException;
class RawgService
{
  private $base_link = "https://api.rawg.io/api/games";
  private $api_key;

  public function __construct(string $api_key)
  {
    $this->api_key = $api_key;
  }
  function fetchGames()
  {
    $init = curl_init();

    curl_setopt_array($init, [
      CURLOPT_URL => $this->base_link . "?key=" . $this->api_key,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 10,
      CURLOPT_HTTPHEADER => ["Accept: application/json"]
    ]);

    $response = curl_exec($init);

    if ($response === false) {
      throw
        new RuntimeException(curl_error($init));
    }

    curl_close($init);

    $data = json_decode($response, true);

    if ($data === NULL) {
      throw new RuntimeException("Failed to decode the data, returned " . $data . " instead.");
    }
    return $data;
  }

  function fetchGamesWithParam($param)
  {
    $init = curl_init();

    curl_setopt_array($init, [
      CURLOPT_URL => $this->base_link . "?key=" . $this->api_key . "&" . $param,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 10,
      CURLOPT_HTTPHEADER => ["Accept: application/json"]
    ]);

    $response = curl_exec($init);

    if ($response === false) {
      throw new RuntimeException(curl_error($init));
    }

    curl_close($init);

    $data = json_decode($response, true);

    if ($data === null) {
      throw new RuntimeException("Failed to decode the data, returned " . $data . "instead.");
    }
    return $data;
  }
}
