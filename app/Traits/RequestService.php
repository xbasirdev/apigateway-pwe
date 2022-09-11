<?php

declare(strict_types = 1);

namespace App\Traits;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

trait RequestService
{
    /**
     * @param       $method
     * @param       $requestUrl
     * @param array $formParams
     * @param array $headers
     *
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $requestUrl, $formParams = [], $headers = []) : string
    {
        $client = new Client([
            'base_uri' => $this->baseUri
        ]);

        if (isset($this->secret)) {
            $headers['Authorization'] = $this->secret;
        }

        $response = $client->request($method, $requestUrl,
            [
                'form_params' => $formParams,
                'headers' => $headers,
            ]
        );

        return $response->getBody()->getContents();
    }

    public function requestFile($method, $requestUrl,Request $request, $headers = []) : string
    {
        $client = new Client([
            'base_uri' => $this->baseUri
        ]);

        if (isset($this->secret)) {
            $headers['Authorization'] = $this->secret;
        }

        $response = $client->request($method, $requestUrl,
            [
                'headers' => $headers,
                'form_params'=>$request->all()
                
            ]
        );

        return $response->getBody()->getContents();
    }
}
