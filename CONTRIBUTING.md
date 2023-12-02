# Contributing Guide

This project does not have formalized or rigid contribution processes. We keep it simple and subscribe to a "see something, say something" philosophy with a "if it's broken, figure out where and fix it". Due to the simple architecture, it's likely that any problems encountered can be fixed within a single method or with a find and replace of a repeated line of code.

Please consider these to be guidelines. If in doubt, please create an issue or pull request and tag the [maintainers](README.md#maintainers) to discuss.

## Feature Requests and Ideas

> **Disclaimer:** This is not an official package maintained by any company. Please use at your own risk and create pull requests to fix any bugs that you encounter.

We have a "contribute the code to fix your own problem" approach and do not maintain a roadmap of feature requests. In other words, we do not have the time to write code based on issues that you create.

The maintainers add features as they encounter a need for them in their own projects that use this package. We invite you to to do the same, and will gladly review your pull requests. Feel free to fork this package if needed.

## Code Contributions

You can start contributing by creating a new `feature/*` or `hotfix/*` branch and create a pull request.

Please review the pipeline CI job outputs for any errors and fix anything that appears.

All pull requests can be assigned to one or all of the maintainers at your discretion. It is helpful to add a comment with any context that the maintainer/reviewer should know or be on the look out for.

### Laravel Test Application

You can create a new Laravel application for a specific version to perform local testing with. This allows you to easily use Tinkerwell for each
respective Laravel version.

```bash
# Set temporary environment variable
export PROVISIONESTA_LARAVEL_VERSION=10
cd ~/Code
# Create new Laravel projects
composer create-project laravel/laravel:^${PROVISIONESTA_LARAVEL_VERSION}.0 laravel${PROVISIONESTA_LARAVEL_VERSION}-pkg-test
# Create sylinks in directory
mkdir -p laravel${PROVISIONESTA_LARAVEL_VERSION}-pkg-test/packages/provisionesta
ln -s ~/Code/:package_slug ~/Code/laravel${PROVISIONESTA_LARAVEL_VERSION}-pkg-test/packages/provisionesta/:package_slug
# Custom repository location configuration
cd ~/Code/laravel${PROVISIONESTA_LARAVEL_VERSION}-pkg-test
sed -i '.bak' -e 's/seeders\/"/&,\n            "Provisionesta\\\\Skeleton\\\\": "packages\/provisionesta\/:package_slug\/src"/g' composer.json
composer config repositories.:package_slug '{"type": "path", "url": "packages/provisionesta/:package_slug"}' --file composer.json
composer require provisionesta/:package_slug:dev-main
php artisan vendor:publish --tag=:package_slug
# Unset temporary environment variable
unset PROVISIONESTA_LARAVEL_VERSION
```

## Custom Application Configuration

### Configuring Your Application with Working Copies of Packages

When you run `composer install`, you will get the latest copy of the packages from the GitHub and GitLab repositories. However, you won't be able to see real-time changes if you change any code in the packages.

You can mitigate this problem by creating a local symlink (with resolved namespaces) for the package inside of your application that you're using for development and testing. By symlinking the packages into the newly created `packages` directory, you'll be able to preview and test your work without doing any Git commits (bad practice).

```bash
# Pre-Requisite (you should already have this)
# You can use any directory you want (if not using ~/Code)
cd ~/Code
git clone https://github.com/provisionesta/:package_slug.git
```

```bash
cd ~/Code/{my-laravel-app}
mkdir -p packages/provisionesta
cd packages/provisionesta
ln -s ~/Code/:package_slug :package_slug
```

### Application Composer

Update the `composer.json` file in your testing application (not the package) to add the package to the `autoload.psr-4` array (append the array, don't replace anything).

```json
# ~/Code/{my-laravel-app}/composer.json

"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Provisionesta\\Skeleton\\": "packages/provisionsta/:package_slug/src",
    }
},
```

### Configure Local Composer Repository

```bash
cd ~/Code/{my-laravel-app}

composer config repositories.:package_slug '{"type": "path", "url": "packages/provisionesta/:package_slug"}' --file composer.json

composer require provisionesta/:package_slug:dev-main

# Package operations: 1 install, 0 updates, 0 removals
#  - Installing provisionesta/:package_slug (dev-main): Symlinking from packages/provisionesta/:package_slug
```

Credit: https://laravel-news.com/developing-laravel-packages-with-local-composer-dependencies

### Validation and Config Copy

```bash
php artisan vendor:publish --tag=:package_slug

# Copied File [/Users/dmurphy/Code/:package_slug/src/Config/:package_slug.php] To [/config/:package_slug.php]
# Publishing complete.
```

### Caching Problems

If you run into any classes or files that are renamed and are throwing `Not Found` errors, you may need to use the `composer dump-autoload` command.
