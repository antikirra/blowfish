<?php

declare(strict_types=1);

namespace Antikirra\Blowfish;

class BasicBlowfish implements BlowfishInterface
{
    private string $algorithm = 'bf-cbc';
    private int $vectorLength;
    private string $encryptionKey;

    public function __construct(string $encryptionKey)
    {
        $this->vectorLength = openssl_cipher_iv_length($this->algorithm);
        $this->encryptionKey = $encryptionKey;
    }

    public function encrypt(string $content): string
    {
        $vector = random_bytes($this->vectorLength);
        $encrypted = openssl_encrypt(serialize($content), $this->algorithm, $this->encryptionKey, OPENSSL_RAW_DATA, $vector);

        return $vector . $encrypted;
    }

    public function decrypt(string $content): string
    {
        $vector = mb_substr($content, 0, $this->vectorLength, '8bit');
        $content = mb_substr($content, $this->vectorLength, null, '8bit');

        return unserialize(openssl_decrypt($content, $this->algorithm, $this->encryptionKey, OPENSSL_RAW_DATA, $vector));
    }
}