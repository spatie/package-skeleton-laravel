<?php

test('globals')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();
