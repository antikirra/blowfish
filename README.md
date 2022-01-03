# Blowfish

## Install

```bash
composer require antikirra/blowfish
```

## Basic usage

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Antikirra\Blowfish\BasicBlowfish;

$blowfish = new BasicBlowfish($_ENV['BLOWFISH_KEY']);
$encrypted = $blowfish->encrypt('Lorem ipsum dolor sit amet'); // binary output
$decrypted = $blowfish->decrypt($encrypted); // Lorem ipsum dolor sit amet
```

## Best practices

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Antikirra\Blowfish\BasicBlowfish;
use Antikirra\Blowfish\CompressedBlowfish;
use Antikirra\Blowfish\PrettyBlowfish;
use Antikirra\Blowfish\SignedBlowfish;
use Antikirra\Encoder\Base58Encoder;

$basicBlowfish = new BasicBlowfish($_ENV['BLOWFISH_KEY']);
$compressedBlowfish = new CompressedBlowfish($basicBlowfish);
$signedBlowfish = new SignedBlowfish($compressedBlowfish, $_ENV['HASH_SALT']);
$blowfish = new PrettyBlowfish($signedBlowfish, new Base58Encoder());

$encrypted = $blowfish->encrypt('Lorem ipsum dolor sit amet'); // "2z74oTRqeXj52q1twoCaR..."
$decrypted = $blowfish->decrypt($encrypted); // Lorem ipsum dolor sit amet
```