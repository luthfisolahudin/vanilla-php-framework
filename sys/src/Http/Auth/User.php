<?php

declare(strict_types=1);

namespace Sys\Http\Auth;

use Sys\Database\Mappable;

class User implements Mappable, Identifiable
{
    protected string $username;

    public function identity(): string
    {
        return $this->username;
    }

    public static function fromDatabase(array $values): static
    {
        $user = new static();

        $user->username = $values['username'];

        return $user;
    }
}
