<?php

namespace Hank\Application\Authorization;

use Hank\Domain\Client\Exception\ClientNotFoundException;
use Hank\Infrastructure\Domain\Adapters\Db\Dbal\ClientDbalAdapter;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SignIn
{
    private $username;
    private $password;
    private $client;
    private $session;

    public function __construct(string $username, string $password, ClientDbalAdapter $client, SessionInterface $session)
    {
        $this->username = $username;
        $this->password = $password;
        $this->client = $client;
        $this->session = $session;
    }

    public function validateData(): bool
    {
        $username = filter_var($this->username, FILTER_SANITIZE_STRING);
        $password = filter_var($this->password, FILTER_SANITIZE_STRING);

        try {
            $client = $this->client->getByClientName($username);
        } catch (ClientNotFoundException $clientNotFoundException) {
            return false;
        }

        if (password_verify($password, $client->password())) {
            return true;
        }

        return false;
    }

    public function setClientSession(): void
    {
        if ($this->session->has('client')) {
            $this->session->remove('client');
        }

        $this->session->set('client', $this->client->getByClientName($this->username));
    }
}