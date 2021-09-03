#!/usr/bin/env php
<?php

function run(string $command): string {
    return trim(shell_exec($command));
}

run('git reset head --hard');
run('git clean -f -d');
run('rm -fr vendor');
run('rm composer.lock');
