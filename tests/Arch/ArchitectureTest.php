<?php

declare(strict_types=1);

arch('naming > commands')
    ->expect('Aagjalpankaj\Lalo\Commands')
    ->toHaveSuffix('Command');

arch('naming > formatters')
    ->expect('Aagjalpankaj\Lalo\Formatters')
    ->toHaveSuffix('Formatter');

arch('naming > middlewares')
    ->expect('Aagjalpankaj\Lalo\Middlewares')
    ->toHaveSuffix('Middleware');

arch('naming > processors')
    ->expect('Aagjalpankaj\Lalo\Processors')
    ->toHaveSuffix('Processor');

arch('naming > validators')
    ->expect('Aagjalpankaj\Lalo\Validators')
    ->toHaveSuffix('Validator');

arch('implements > validators')
    ->expect('Aagjalpankaj\Lalo\Formatters')
    ->toImplement('Monolog\Formatter\FormatterInterface');
