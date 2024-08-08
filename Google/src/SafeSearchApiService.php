<?php

namespace AIGenerate\Services\Google;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use AIGenerate\Services\Google\Exceptions\GoogleApiException;
use AIGenerate\Services\Google\Exceptions\NotFoundSafeSearchAnnotationException;
use AIGenerate\Services\Google\Exceptions\TokenNotFoundException;
use AIGenerate\Services\Google\Models\GoogleToken;

class SafeSearchApiService
{
    protected string $project;
    private $apiUrl = 'https://vision.googleapis.com/v1/images:annotate';
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->project = config('api.google.project_id');
    }

    /**
     * @throws \Throwable
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function call(string $imageUrl): array
    {
        $response = $this->client->post($this->apiUrl, [
            'headers' => [
                "Authorization"       => "Bearer {$this->getToken()}",
                "x-goog-user-project" => $this->project,
                "Content-Type"        => "application/json; charset=utf-8",
            ],
            'json'    => [
                'requests' => [
                    'image'    => [
                        'source' => [
                            'imageUri' => $imageUrl,
                        ],
                    ],
                    'features' => [
                        [
                            'type' => 'SAFE_SEARCH_DETECTION',
                        ],
                    ],
                ],
            ],
        ]);

        $response = json_decode($response->getBody()->getContents(), true);
        if (isset($response['error'])) {
            throw new Exception($response['error']['message']);
        }
        if (isset($response['responses'][0]['safeSearchAnnotation'])) {
            return $response['responses'][0]['safeSearchAnnotation'];
        } else {
            Log::error('not found safeSearchAnnotation', $response['responses']);
            throw new Exception('not found safeSearchAnnotation');
        }
    }

    /**
     * @throws \Throwable
     */
    public function getToken(): string
    {
        $model = GoogleToken::first();
        throw_unless(isset($model), new TokenNotFoundException());
        return $model->token;
    }

    /**
     * @throws \Throwable
     * @throws NotFoundSafeSearchAnnotationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function callWithByteCode(string $base64Encode)
    {
        $response = $this->client->post($this->apiUrl, [
            'headers' => [
                "Authorization"       => "Bearer {$this->getToken()}",
                "x-goog-user-project" => $this->project,
                "Content-Type"        => "application/json; charset=utf-8",
            ],
            'json'    => [
                'requests' => [
                    'image'    => [
                        'content' => $base64Encode,
                    ],
                    'features' => [
                        [
                            'type' => 'SAFE_SEARCH_DETECTION',
                        ],
                    ],
                ],
            ],
        ]);

        $response = json_decode($response->getBody()->getContents(), true);
        if (isset($response['error'])) {
            throw new GoogleApiException($response['error']['message']);
        }
        if (isset($response['responses'][0]['safeSearchAnnotation'])) {
            return $response['responses'][0]['safeSearchAnnotation'];
        } else {
            Log::error('not found safeSearchAnnotation', $response['responses']);
            throw new NotFoundSafeSearchAnnotationException();
        }
    }
}
