<?php

namespace spec\Hank\Domain\Service;

use Doctrine\DBAL\Query\QueryBuilder;
use Hank\Domain\Service\Exception\NotAbleToDownloadImageException;
use Hank\Domain\Service\Exception\NotImageException;
use Hank\Domain\Service\ChangeAvatarService;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\Uuid;

class ChangeAvatarServiceSpec extends ObjectBehavior
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

        $queryBuilder->set("avatar", ":newAvatar")
            ->willReturn($queryBuilder);

        $queryBuilder->where("id = :id")
            ->willReturn($queryBuilder);

        $queryBuilder->setParameter("newAvatar", "https://www.google.de/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png")
            ->willReturn($queryBuilder);

        $queryBuilder->setParameter("id", $this->userId)
            ->willReturn($queryBuilder);

        $queryBuilder->execute()
            ->willReturn(null);

        $this->beConstructedWith($queryBuilder->getWrappedObject());
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(ChangeAvatarService::class);
    }

    function it_allows_us_to_change_avatar(): void
    {
        $this->change('https://www.google.de/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png', $this->userId);
    }

    function it_throws_exception_when_content_type_is_not_image(): void
    {
        $this->shouldThrow(NotImageException::class)
            ->during('change', ['https://google.com', $this->userId]);
    }

    function it_throws_exception_when_content_type_is_null(): void
    {
        $this->shouldThrow(NotAbleToDownloadImageException::class)
        ->during('change', ['data:image/jpeg;base64,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'
            , $this->userId]);
    }
}