<?php

declare(strict_types=1);

namespace Sys\Http\Auth;

interface AuthInterface
{
    public function attempt(string $username, string $password): bool;

    public function user(): ?Identifiable;

    public function login(Identifiable $user): void;

    public function logout(): void;
}
