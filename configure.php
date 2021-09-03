#!/usr/bin/env php
<?php

function ask(string $question, string $default = ''): string {
    $answer = readline($question . ($default ? " ({$default})" : null) . ': ');

    if (! $answer) {
        return $default;
    }

    return $answer;
}

function confirm(string $question, bool $default = false): bool {
    $answer = ask($question . ' (' . ($default ? 'Y/n' : 'y/N') . ')');

    if (! $answer) {
        return $default;
    }

    return strtolower($answer) === 'y';
}

function writeln(string $line): void {
    echo $line . PHP_EOL;
}

function run(string $command): string {
    return trim(shell_exec($command));
}

function str_after(string $subject, string $search): string {
    $pos = strrpos($subject, $search);

    if ($pos === false) {
        return $subject;
    }

    return substr($subject, $pos + strlen($search));
}

function slugify(string $subject): string {
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $subject), '-'));
}

function title_case(string $subject): string {
    return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $subject)));
}

function replace_in_file(string $file, array $replacements): void {
    $contents = file_get_contents($file);

    file_put_contents(
        $file,
        str_replace(
            array_keys($replacements),
            array_values($replacements),
            $contents
        )
    );
}

$gitName = run('git config user.name');
$authorName = ask('Author name', $gitName);

$gitEmail = run('git config user.email');
$authorEmail = ask('Author email', $gitEmail);

$usernameGuess = explode(':', run('git config remote.origin.url'))[1];
$usernameGuess = dirname($usernameGuess);
$usernameGuess = basename($usernameGuess);
$authorUsername = ask('Author username', $usernameGuess);

$vendorName = ask('Vendor name', $authorUsername);
$vendorSlug = slugify($vendorName);
$vendorNamespace = ucwords($vendorName);
$vendorNamespace = ask('Vendor namespace', $vendorNamespace);

$currentDirectory = getcwd();
$folderName = basename($currentDirectory);

$packageName = ask('Package name', $folderName);
$packageSlug = slugify($packageName);

$className = title_case($packageName);
$className = ask('Class name', $className);
$description = ask('Package description', "This is my package {$packageSlug}");

writeln('------');
writeln("Author     : {$authorName} ({$authorUsername}, {$authorEmail})");
writeln("Vendor     : {$vendorName} ({$vendorSlug})");
writeln("Package    : {$packageSlug} <{$description}>");
writeln("Namespace  : {$vendorNamespace}\\{$className}");
writeln("Class name : {$className}");
writeln('------');

writeln('This script will replace the above values in all relevant files in the project directory.');

if (! confirm('Modify files?', true)) {
    exit(1);
}

$files = explode(PHP_EOL, run('grep -E -r -l -i ":author|:vendor|:package|VendorName|skeleton|vendor_name|vendor_slug|author@domain.com" --exclude-dir=vendor ./* ./.github/* | grep -v ' . basename(__FILE__)));

foreach ($files as $file) {
    replace_in_file($file, [
        ':author_name' => $authorName,
        ':author_username' => $authorUsername,
        'author@domain.com' => $authorEmail,
        ':vendor_name' => $vendorName,
        ':vendor_slug' => $vendorSlug,
        'VendorName' => $vendorNamespace,
        ':package_name' => $packageName,
        ':package_slug' => $packageSlug,
        'Skeleton' => $className,
        ':package_description' => $description,
    ]);

    match (true) {
        str_contains($file, 'src/Skeleton.php') => rename($file, './src/' . $className . '.php'),
        str_contains($file, 'src/SkeletonServiceProvider.php') => rename($file, './src/' . $className . 'ServiceProvider.php'),
        str_contains($file, 'src/SkeletonFacade.php') => rename($file, './src/' . $className . 'Facade.php'),
        str_contains($file, 'src/Commands/SkeletonCommand.php') => rename($file, './src/Commands/' . $className . 'Command.php'),
        default => [],
    };
}

confirm('Execute `composer install` and run tests?') && run('composer install && composer test');

confirm('Let this script delete itself?', true) && unlink(__FILE__);
