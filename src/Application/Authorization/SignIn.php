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

class SignIn
{
    private $username;
    private $password;
    private $client;

    public function __construct(string $username, string $password, ClientDbal $client)
    {
        $this->username = $username;
        $this->password = $password;
        $this->client = $client;
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
        if (isset($_SESSION['client'])) {
            unset($_SESSION['client']);
        }

        $_SESSION['client']['id'] = $client->getId();
        $_SESSION['client']['username'] = $client->getUsername();
        $_SESSION['client']['email'] = $client->getEmail();
    }
}