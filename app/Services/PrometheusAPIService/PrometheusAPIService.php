<?php

namespace App\Services\PrometheusAPIService;

use App\Services\PrometheusAPIService\DTO\Configuration\Configuration;
use App\Services\PrometheusAPIService\Exceptions\GraphQLRequestException;
use App\Services\PrometheusAPIService\Exceptions\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Promises\LazyPromise;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PrometheusAPIService implements IPrometheusAPIService
{
    protected Configuration $configuration;

    public function __construct()
    {
        $this->configuration = new Configuration;
    }

    protected function getAccessToken(): string
    {
        return Cache::has($this->configuration->cache->oauthAccessTokenKey)
            ? 'Bearer '.Cache::get($this->configuration->cache->oauthAccessTokenKey)
            : '';
    }

    protected function createUnauthenticatedPendingRequest(): PendingRequest
    {
        return Http::createPendingRequest()
            ->withUrlParameters(['host' => $this->configuration->api->host])
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Accept', 'application/json');
    }

    protected function authenticate(): void
    {
        $tokenResponse = $this->createUnauthenticatedPendingRequest()->asForm()->post('{+host}/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $this->configuration->api->oauthClientID,
            'client_secret' => $this->configuration->api->oauthClientSecret,
        ]);

        if ($tokenResponse->ok()) {
            $tokenResponse = $tokenResponse->json();
            Cache::put(
                $this->configuration->cache->oauthAccessTokenKey,
                $tokenResponse['access_token'],
                now()->addSeconds($tokenResponse['expires_in']),
            );
        }
    }

    protected function createAuthenticatedPendingRequest(): PendingRequest
    {
        if (empty($this->getAccessToken())) {
            $this->authenticate();
        }

        return $this->createUnauthenticatedPendingRequest()
            ->withHeader('Authorization', $this->getAccessToken());
    }

    /**
     * @throws RequestException
     */
    protected function validateResponse(PromiseInterface|LazyPromise|Response $response, bool $isGraphQL = false): void
    {
        if (! $response->ok()) {
            throw new RequestException($response->json()['message'], $response->getStatusCode());
        }

        if ($isGraphQL && ! empty($response->json()['errors'])) {
            throw new GraphQLRequestException($response->json()['errors'][0]['message']);
        }
    }

    public function sendGraphQLRequest(string $query, ?array $variables = null): array
    {
        $response = $this->createAuthenticatedPendingRequest()
            ->asJson()
            ->post('{+host}/graphql', ['query' => $query, 'variables' => $variables]);

        $this->validateResponse($response, isGraphQL: true);

        return $response->json();
    }
}
