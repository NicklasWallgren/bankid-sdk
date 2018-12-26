<?php

namespace BankID\SDK\Http;

use BankID\SDK\Configuration\Config;
use BankID\SDK\Http\Handlers\ConfigHandler;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Throwable;
use function GuzzleHttp\Promise\rejection_for;

/**
 * Class RequestClient
 *
 * @package            BankID\SDK\Http
 * @internal
 * @phan-file-suppress PhanAccessMethodInternal
 */
class RequestClient
{

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * Client constructor.
     *
     * @param Config               $config
     * @param ClientInterface|null $client
     */
    public function __construct(Config $config, ?ClientInterface $client = null)
    {
        $this->config = $config;
        $this->client = $client ?? new Client();
    }

    /**
     * Sends the HTTP request.
     *
     * @param RequestInterface $request
     * @return PromiseInterface
     */
    public function requestAsync(RequestInterface $request): PromiseInterface
    {
        $response = null;

        try {
            $response = $this->client->sendAsync($request, $this->options());
        } catch (ClientException | Throwable $e) {
            $response = rejection_for($e);
        }

        return $response;
    }

    /**
     * Returns the config.
     *
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * Returns the curl options.
     *
     * @return array
     */
    protected function options(): array
    {
        $default = ['http_errors' => false];

        // TODO, typehint array

        return array_merge((new ConfigHandler())->asArray($this->config), $default);
    }
}
