<?php

namespace App\MajorMinorsApi;

use Zttp\Zttp;

class MajorMinorsApiClient
{
    protected $endpoint = '';
    protected $token = '';

    public function __construct(string $endpoint = null, string $token = null)
    {
        if (isset($endpoint)) {
            $this->endpoint($endpoint);
        }

        if (isset($token)) {
            $this->token($token);
        }
    }

    public function endpoint(string $endpoint) : MajorMinorsApiClient
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function token(string $token) : MajorMinorsApiClient
    {
        $this->token = $token;

        return $this;
    }

    public function get(string $student_id) : array
    {
        $query = http_build_query([
            '1' => $student_id,
        ]);

        $url = "{$this->endpoint}?$query";

        return (Zttp::withHeaders([
            'X-Password' => "{$this->token}",
        ])->get($url))->json();
    }
}
