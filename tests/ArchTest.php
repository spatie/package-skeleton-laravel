<?php

it('will not use debugging functions')
    ->group('arch')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();
