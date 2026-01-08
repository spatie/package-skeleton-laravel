# Contributing

Thank you for considering contributing to the PayChangu Laravel SDK! The contribution guide can be found in the [PayChangu Laravel SDK documentation](https://github.com/Mzati1/PaychanguLaravelSDK).

## Development Setup

1.  Clone the repository:
    ```bash
    git clone https://github.com/Mzati1/PaychanguLaravelSDK.git
    cd PaychanguLaravelSDK
    ```

2.  Install dependencies:
    ```bash
    composer install
    ```

3.  Setup pre-commit hooks (optional but recommended):
    ```bash
    composer run prepare
    ```

## Testing

We use [Pest](https://pestphp.com/) for testing.

To run the test suite:

```bash
composer test
```

To run tests with coverage:

```bash
composer test-coverage
```

## Static Analysis

We use [PHPStan](https://phpstan.org/) for static analysis.

To run static analysis:

```bash
composer analyse
```

## Code Formatting

We use [Laravel Pint](https://laravel.com/docs/pint) to fix code style issues.

To format the code:

```bash
composer format
```

## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to Mzati Tembo via [mzatitembo01@gmail.com](mailto:mzatitembo01@gmail.com). All security vulnerabilities will be promptly addressed.
