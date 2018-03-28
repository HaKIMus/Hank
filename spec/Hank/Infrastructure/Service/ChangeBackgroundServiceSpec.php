<?php

namespace spec\Hank\Infrastructure\Service;

use Doctrine\DBAL\Connection;
use Hank\Infrastructure\Service\ChangeBackgroundService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ChangeBackgroundServiceSpec extends ObjectBehavior
{
    function let(Connection $connection): void
    {
        $this->beConstructedWith($connection->getWrappedObject());
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ChangeBackgroundService::class);
    }

    function it_throws_exception_when_website_have_not_content_type_of_image(): void
    {
        $this->shouldThrow(\Exception::class)
            ->during('change', ['https://static.pexels.com/photos/531880/pexels-photo-531880.jpeg', Uuid::uuid4()]);
    }

    function it_throws_exception_when_content_type_is_not_image(): void
    {
        $this->shouldThrow(\InvalidArgumentException::class)
            ->during('change', ['https://google.com', Uuid::uuid4()]);
    }
}
