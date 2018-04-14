<?php

namespace Hank\Application\Query\Authorization;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class ClientStatus
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function isClientSignedIn(): bool
    {
        if ($this->session->has('client')) {
            return true;
        }

        return false;
    }
}