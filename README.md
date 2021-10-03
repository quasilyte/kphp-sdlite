# kphp-sdlite

Simple SDL framework for KPHP

## Installation

```
$ composer require quasilyte/kphp-sdlite:dev-master
```

## Basic usage

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Quasilyte\SDLite\SDL;

// Perform a FFI::load() for the libraries.
// For KPHP you can do it anywhere, for PHP you need to do it in your preaload.php file.
SDL::loadCoreLib();
SDL::loadImageLib();
SDL::loadMixerLib();
SDL::loadTTFLib();

$sdl = new SDL();
$ok = $sdl->init() && $sdl->initTTF());
if (!$ok) {
  die('SDL init error: ' . $sdl->getError());
}

$window = $sdl->createWindow("Main", SDL::WINDOWPOS_CENTERED, SDL::WINDOWPOS_CENTERED, 1000, 1000);
sleep(2);
```
