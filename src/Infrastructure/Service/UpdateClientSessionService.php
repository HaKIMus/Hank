<?php

namespace Hank\Infrastructure\Service;

use Hank\Infrastructure\Domain\Adapters\Db\Dbal\ClientDbalAdapter;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class UpdateClientSessionService
{
    private $session;
    private $clientDbalAdapter;

    public function __construct(SessionInterface $session, ClientDbalAdapter $clientDbalAdapter)
    {
        $this->session = $session;
        $this->clientDbalAdapter = $clientDbalAdapter;
    }

    public function update(): void
    {
        if ($this->session->has('client')) {
            $this->session->set('client', $this->clientDbalAdapter->getByClientName($this->session->get('client')->name()));
        }
    }
}