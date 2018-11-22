<?php

declare(strict_types=1);

namespace App;

use Nette\Security\User;

class UserContextProcessor
{
    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param mixed[] $record
     * @return mixed[]
     */
    public function __invoke(array $record) : array
    {
        $identity = $this->user->getIdentity();

        $record['context']['user'] = [
            'id' => $identity->getId(),
        ];

        return $record;
    }
}
