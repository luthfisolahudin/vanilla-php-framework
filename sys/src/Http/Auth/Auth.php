<?php

declare(strict_types=1);

namespace Sys\Http\Auth;

use Sys\Http\Session\SessionInterface;

class Auth implements AuthInterface
{
    protected ?Identifiable $user = null;

    public function __construct(
        protected SessionInterface $session,
        protected AuthenticatorInterface $authenticator,
    ) {}

    public function attempt(string $username, string $password): bool
    {
        $user = $this->authenticator->attempt($username, $password);

        if (null === $user) {
            return false;
        }

        $this->login($user);

        return true;
    }

    public function user(): ?Identifiable
    {
        return $this->user;
    }

    public function login(Identifiable $user): void
    {
        $this->user = $user;
    }

    public function logout(): void
    {
        $this->session->destroy();
    }
}
