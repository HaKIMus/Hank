<?php
/**
 * Created by PhpStorm.
 * User: hakim
 * Date: 10.12.17
 * Time: 16:54
 */

namespace App\Application\Authorization;


use App\Application\Query\View\Client\ClientView;
use App\Domain\Client\Exception\ClientNotFoundException;
use App\Infrastructure\Domain\Dbal\Client\ClientDbal;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SignIn
{
    private $username;
    private $password;
    private $client;
    private $session;

    public function __construct(string $username, string $password, ClientDbal $client, SessionInterface $session)
    {
        $this->username = $username;
        $this->password = $password;
        $this->client = $client;
        $this->session = $session;
    }

    public function signIn(): bool
    {
        $username = filter_var($this->username, FILTER_SANITIZE_STRING);
        $password = filter_var($this->password, FILTER_SANITIZE_STRING);

        try {
            $client = $this->client->getByUsername($username);
        } catch (ClientNotFoundException $clientNotFoundException) {
            return false;
        }

        if (password_verify($password, $client->getPassword())) {
            $this->setClientSession($client);

            return true;
        } else {
            return false;
        }
    }

    public function setClientSession(ClientView $client): void
    {
        if ($this->session->has('client')) {
            $this->session->remove('client');
        }

        $this->session->set('client', $client);
    }
}