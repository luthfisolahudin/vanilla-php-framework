<?php

declare(strict_types=1);

namespace Sys\Http\Auth;

use Sys\Config\ConfigInterface;
use Sys\Database\DatabaseInterface;

class UserAuthenticator implements AuthenticatorInterface
{
    public function __construct(
        protected ConfigInterface $config,
        protected DatabaseInterface $database,
    ) {}

    public function attempt(string $username, string $password): ?Identifiable
    {
        return $this->database
            ->query(
                'select * from users where username = :username and password = :password',
                [':username' => $username, ':password' => password_hash($password, \PASSWORD_BCRYPT)],
            )
            ->setMap($this->config->get('user', User::class))
            ->fetch();
    }
}
