<?php

declare(strict_types=1);

namespace ZondaPhpApi;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\ContentTypePlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Psr\Http\Client\ClientInterface;
use ZondaPhpApi\Api\Trading;
use ZondaPhpApi\HttpClient\Builder;
use ZondaPhpApi\HttpClient\Plugin\Authentication;

class Client
{
    private const BASE_URL = 'https://api.zonda.exchange';
    private const USER_AGENT = 'zonda-php-api/0.2';

    private Builder $httpClientBuilder;

    public function __construct(Builder $httpClientBuilder = new Builder())
    {
        $this->httpClientBuilder = $httpClientBuilder;

        $this->httpClientBuilder
            ->addPlugin(new HeaderDefaultsPlugin([
                'User-Agent' => self::USER_AGENT,
            ]))
            ->addPlugin(new ContentTypePlugin())
        ;

        $this->setUrl(self::BASE_URL);
    }

    public static function create(Builder $httpClientBuilder = new Builder()): self
    {
        return new self($httpClientBuilder);
    }

    public function setUrl(string $url): void
    {
        $uri = $this->getHttpClientBuilder()->getUriFactory()->createUri($url);

        $this->getHttpClientBuilder()
            ->removePlugin(AddHostPlugin::class)
            ->addPlugin(new AddHostPlugin($uri))
        ;
    }

    public static function createWithHttpClient(ClientInterface $httpClient): self
    {
        $builder = new Builder($httpClient);

        return new self($builder);
    }

    public function authenticate(string $publicApiKey, string $privateApiKey): self
    {
        $authentication = new Authentication($publicApiKey, $privateApiKey);

        $this->getHttpClientBuilder()
            ->removePlugin(AuthenticationPlugin::class)
            ->addPlugin(new AuthenticationPlugin($authentication))
        ;

        return $this;
    }

    public function trading(): Trading
    {
        return new Trading($this);
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    protected function getHttpClientBuilder(): Builder
    {
        return $this->httpClientBuilder;
    }
}
