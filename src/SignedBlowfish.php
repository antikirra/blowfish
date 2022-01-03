<?php

declare(strict_types=1);

namespace Antikirra\Blowfish;

use Exception;

class SignedBlowfish implements BlowfishInterface
{
    private BlowfishInterface $blowfish;

    private string $salt;

    private int $hashPrefixLength;

    public function __construct(BlowfishInterface $blowfish, string $salt)
    {
        $this->blowfish = $blowfish;
        $this->salt = $salt;
        $this->hashPrefixLength = 16;
    }

    private function calculate(string $content): string
    {
        $hash = hash_hmac('sha3-384', $content, $this->salt, true);
        return mb_substr($hash, 0, $this->hashPrefixLength, '8bit');
    }

    public function encrypt(string $content): string
    {
        $encrypted = $this->blowfish->encrypt($content);
        $hash = $this->calculate($encrypted);

        return $hash . $encrypted;
    }

    public function decrypt(string $content): string
    {
        $hash = mb_substr($content, 0, $this->hashPrefixLength, '8bit');
        $encrypted = mb_substr($content, $this->hashPrefixLength, null, '8bit');

        $calculated = $this->calculate($encrypted);

        if (!hash_equals($hash, $calculated)) {
            throw new Exception();
        }

        return $this->blowfish->decrypt($encrypted);
    }
}