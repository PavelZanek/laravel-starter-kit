# Laravel Starter Kit

A robust starter kit for Laravel projects that accelerates your development process with pre-configured features and quality tools. This repository offers multiple branches tailored to different use cases, all built on top of a clean Laravel installation.

---

## Branches Overview

### `main`
- **Clean installation of Laravel**  
  Provides a basic Laravel setup without additional scaffolding.

### `jetstream`
- **Based on main branch**  
  Extends the clean installation with further enhancements.
- **Livewire stack**  
  Jetstream is configured to use the Livewire stack.
- **Enabled dark mode**  
  Dark mode support is activated.
- **Enabled multi tenancy (Teams)**  
  Multi tenancy is enabled with Teams support.

### `jetstream-custom`
- **Based on jetstream branch**  
  Builds upon the Jetstream configuration.
- **Multilang - language switcher (en, cs)**  
  Includes a language switcher for English and Czech.
- **Dark mode switcher**  
  Provides a dynamic dark mode toggle.
- **Custom layout (single layout for guest and app section)**  
  Utilizes a unified layout for both guest and authenticated areas.

---

## Common Features (All Branches)

- **Code Quality & Testing:**
    - Tests are written using [Pest](https://pestphp.com/).
    - Code coverage and type coverage are configured.
    - Code styling is enforced with [Laravel Pint](https://github.com/laravel/pint).
    - Automated refactoring is supported by [Rector PHP](https://github.com/rectorphp/rector).
    - Static analysis is performed using [PHPStan](https://phpstan.org/).

- **Basic Application Settings:**  
  The `AppServiceProvider.php` configures several key settings to ensure consistent, secure, and optimized behavior across all environments:
    - **Command Safety:** Prohibits destructive database commands in production.
    - **Strict Models:** Enforces strict mode for Eloquent models.
    - **Secure URLs:** Forces HTTPS when in production.
    - **Immutable Dates:** Uses immutable date objects (via CarbonImmutable) for predictable date handling.
    - **Optimized Vite Integration:** Enables aggressive asset prefetching for improved performance.

- **Preinstalled Packages:**  
  Includes several essential packages for development and monitoring:
    - [Laravel Telescope](https://laravel.com/docs/telescope)
    - [Laravel Horizon](https://laravel.com/docs/horizon)
    - [Debugbar](https://github.com/barryvdh/laravel-debugbar)
    - [Sentry](https://sentry.io/)

- **Seeders:**  
  Prepared seeders are available to quickly bootstrap initial data.

- **GitHub Actions:**  
  CI/CD workflows are in place for automated testing, code style checks, and static analysis.

---

## Installation

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/PavelZanek/laravel-starter-kit.git
    cd laravel-starter-kit
    ```

2. **Checkout the Desired Branch:**

    **For a clean Laravel installation:**
    ```bash
    git checkout jetstream-custom
    ```

    **For a Jetstream installation:**
    ```bash
    git checkout jetstream
    ```

    **For a custom Jetstream installation:**
    ```bash
    git checkout jetstream-custom
    ```

3. **Install Dependencies:**

   ```bash
   composer install
   npm install && npm run dev
   ```

4. **Configure the Environment:**

    Copy the example environment file and generate an application key:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Setup database:**

   Update the database credentials in the `.env` file and run the migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

6. **Run the Application:**

    ```bash
    php artisan serve
    ```

### Using Laravel Sail (Docker)

[Laravel Sail](https://laravel.com/docs/11.x/sail) is preinstalled for a Docker-based development environment. Sail provides a simple command-line interface for interacting with your Docker containers. Ensure you have [Docker installed](https://docs.docker.com/get-started/get-docker/) on your system, then run:

```bash
./vendor/bin/sail up
```

This command starts all necessary containers (e.g., the web server, database, Redis, mail service) as configured. You can also prefix common Artisan commands with ./vendor/bin/sail to run them inside the Docker container. For example:

```bash
./vendor/bin/sail artisan migrate --seed
```

For convenience, consider creating an alias for Sail in your shell configuration:

```bash
alias sail='./vendor/bin/sail'
```

This alias allows you to run Sail commands more easily:

```bash
sail up -d
sail artisan migrate --seed
sail composer test
...
```

### Project Configuration

The project configuration is managed via the .env file. Key settings include:

- **Application Settings:** `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_DEBUG`, `APP_URL`, and `APP_PORT`.
- **Locale Settings:** `APP_LOCALE` and `APP_FALLBACK_LOCALE`.
- **Database Settings:** `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.
- **Session & Cache:** Configurations for session and cache drivers.
- **Third-Party Services:** Settings for Redis, mail (e.g., Mailpit), AWS, and others.
- **Docker Port Forwarding:** Environment variables such as `FORWARD_DB_PORT`, `FORWARD_REDIS_PORT`, etc., help map container ports to your host machine.

Review the provided .env.example file for complete details and adjust as needed.

---

## Composer Scripts Explanation

- **Refactoring:**
    - **`composer refactor`**  
      Runs [Rector](https://github.com/rectorphp/rector) to automatically refactor your code based on defined rules.
    - **`composer test:refactor`**  
      Executes Rector in dry-run mode (`--dry-run --ansi`) to preview the potential refactoring changes without modifying any files.

- **Linting:**
    - **`composer lint`**  
      Runs [Laravel Pint](https://github.com/laravel/pint) to automatically fix code style issues.
    - **`composer test:lint`**  
      Executes Pint in test mode (`--test`) to verify that the code adheres to the project's style guidelines without making changes.

- **Static Analysis & Type Checking:**
    - **`composer test:types`**  
      Runs [PHPStan](https://phpstan.org/) with a memory limit of 2G, using a table error format and ANSI output. This command analyzes your code to ensure proper type usage and to catch potential errors early.

- **Test Coverage:**
    - **`composer test:type-coverage`**  
      Uses [Pest](https://pestphp.com/) with the `--type-coverage` flag to enforce a minimum of 100% type coverage.
    - **`composer test:unit`**  
      Runs unit tests with Pest in parallel mode (`--parallel`) and CI mode (`--ci`), with colored output (`--colors=always`), generating a coverage report and enforcing a minimum of 100% test coverage.

- **Comprehensive Testing:**
    - **`composer test`**  
      A composite command that sequentially executes:
        1. `composer test:refactor`
        2. `composer test:lint`
        3. `composer test:types`
        4. `composer test:type-coverage`
        5. `composer test:unit`  
           This ensures that code refactoring suggestions, code style, static analysis, type coverage, and unit tests all pass successfully.

---

**Using Laravel Sail:**

If you are using Laravel Sail (Docker), simply prefix these commands with `sail` to run them inside the Docker container. For example:

```bash
./vendor/bin/sail composer test
```

This will execute the comprehensive testing command within the Docker environment.

---

## Running Tests and Code Quality Tools

- **Run Tests:**

   ```bash
   ./vendor/bin/pest
   ```
  
- **Static Analysis & Type Checks:**

    ```bash
    ./vendor/bin/phpstan analyse
    ```
  
- **Code Styling Fixes:**

    ```bash
    ./vendor/bin/pint
    ```

- **Automated Refactoring:**

    ```bash
    ./vendor/bin/rector process
    ```

---

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

---

## Security

If you discover any security-related issues, please email zanek.pavel@gmail.com instead of using the issue tracker.

---

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---

## Support the Developer

If you find this package helpful and would like to support its ongoing development, consider leaving a tip. Your support is greatly appreciated!

[Leave a Tip](https://streamelements.com/pavelzanek/tip)

Thank you for your generosity!

### About the Developer

This package is developed and maintained by [Pavel Zaněk](https://www.pavelzanek.com/en), a passionate developer with extensive experience in Laravel and PHP development.
