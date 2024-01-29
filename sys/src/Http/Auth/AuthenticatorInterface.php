<?php

declare(strict_types=1);

namespace Sys\Http\Auth;

interface AuthenticatorInterface
{
    public function attempt(string $username, string $password): ?Identifiable;
}
