<?php

declare(strict_types=1);

namespace Antikirra\Blowfish;

class CompressedBlowfish implements BlowfishInterface
{
    private BlowfishInterface $blowfish;

    public function __construct(BlowfishInterface $blowfish)
    {
        $this->blowfish = $blowfish;
    }

    public function encrypt(string $content): string
    {
        return gzdeflate($this->blowfish->encrypt($content), 9);
    }

    public function decrypt(string $content): string
    {
        return $this->blowfish->decrypt(gzinflate($content));
    }
}