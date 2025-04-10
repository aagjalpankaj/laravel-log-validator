<?php

declare(strict_types=1);

arch('commands')
    ->expect('src\Commands')
    ->toHaveSuffix('Command');

arch('formatters')
    ->expect('src\Commands')
    ->toHaveSuffix('Formatter');
