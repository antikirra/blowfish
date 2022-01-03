<?php

declare(strict_types=1);

namespace Antikirra\Blowfish;

interface BlowfishInterface
{
    public function encrypt(string $content): string;

    public function decrypt(string $content): string;
}