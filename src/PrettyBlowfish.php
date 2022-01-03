<?php

declare(strict_types=1);

namespace Antikirra\Blowfish;

use Antikirra\Encoder\EncoderInterface;

class PrettyBlowfish implements BlowfishInterface
{
    private BlowfishInterface $blowfish;

    private EncoderInterface $encoder;

    public function __construct(BlowfishInterface $blowfish, EncoderInterface $encoder)
    {
        $this->blowfish = $blowfish;
        $this->encoder = $encoder;
    }

    public function encrypt(string $content): string
    {
        return $this->encoder->encode($this->blowfish->encrypt($content));
    }

    public function decrypt(string $content): string
    {
        return $this->blowfish->decrypt($this->encoder->decode($content));
    }
}