<?php

namespace spec\Hank\Infrastructure\Service;

use Doctrine\DBAL\Query\QueryBuilder;
use Hank\Infrastructure\Service\ChangeBackgroundService;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

class ChangeBackgroundServiceSpec extends ObjectBehavior
{
    public $userId;

    public function __construct()
    {
        $this->userId = Uuid::uuid4();
    }

    function let(QueryBuilder $queryBuilder): void
    {
        $queryBuilder->update("client")
            ->willReturn($queryBuilder);

        $queryBuilder->set("background", ":newBackground")
            ->willReturn($queryBuilder);

        $queryBuilder->where("id = :id")
            ->willReturn($queryBuilder);

        $queryBuilder->setParameter("newBackground", "https://www.google.de/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png")
            ->willReturn($queryBuilder);

        $queryBuilder->setParameter("id", $this->userId)
            ->willReturn($queryBuilder);

        $queryBuilder->execute()
            ->willReturn(null);

        $this->beConstructedWith($queryBuilder->getWrappedObject());
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ChangeBackgroundService::class);
    }

    function it_allows_us_to_change_background(): void
    {
        $this->change('https://www.google.de/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png', $this->userId);
    }

    function it_throws_exception_when_website_have_not_content_type_of_image(): void
    {
        $this->shouldThrow(\Exception::class)
            ->during('change', ['https://static.pexels.com/photos/531880/pexels-photo-531880.jpeg', $this->userId]);
    }

    function it_throws_exception_when_content_type_is_not_image(): void
    {
        $this->shouldThrow(\InvalidArgumentException::class)
            ->during('change', ['https://google.com', $this->userId]);
    }
}
