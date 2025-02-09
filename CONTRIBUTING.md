# Contributing to Laravel Deepl

First off, thank you for considering contributing to this project! Your support and contributions are greatly appreciated.

## How Can I Contribute?

### Reporting Bugs

If you find a bug, please create an issue on GitHub with the following details:
- A clear and descriptive title.
- A detailed description of the bug, including the steps to reproduce it.
- The version of Laravel, PHP, and this package that you're using.
- Any relevant log output or screenshots.

### Feature Requests

If you have an idea for a new feature or improvement, feel free to submit a feature request:
- Explain your idea in detail.
- Describe how it would benefit users of the package.
- Provide any examples or use cases where this feature would be helpful.

### Submitting Pull Requests

If you'd like to submit a pull request, please follow these steps:

1. **Fork the repository** to your own GitHub account.

2. **Clone the forked repository** to your local machine:
    ```bash
    git clone https://github.com/your-username/laravel-deepl.git
    cd laravel-deepl
    ```

3. **Create a new branch** for your feature or fix:
    ```bash
    git checkout -b your-feature-branch
    ```

4. **Make your changes**. Make sure to follow the project's coding standards and include tests where necessary.

5. **Commit your changes** with a clear and descriptive commit message:
    ```bash
    git commit -m "Added feature X"
    ```

6. **Push your changes** to your forked repository:
    ```bash
    git push origin your-feature-branch
    ```

7. **Submit a pull request** to the main repository:
    - Go to the original repository on GitHub.
    - Click on the "Pull Requests" tab, and then click "New Pull Request".
    - Select your branch, provide a descriptive title and detailed description of your changes.

### Coding Standards

Please ensure your code adheres to the following standards:

- Follow the `Laravel` coding style.
- Write clear and concise PHPDoc comments.
- Ensure all public methods and properties are type-hinted.
- Use meaningful variable and method names.
- Write tests for any new features or bug fixes.

### Running Tests

Please ensure that all tests pass before submitting a pull request. To run tests locally, use:

```bash
composer test
```

This will execute the full test suite.

### Linting

Before submitting your code, ensure it adheres to the coding standards by running PHPStan:

```bash
composer lint
```

### Documentation

If your contribution changes or adds new functionality, please update the documentation accordingly. This could include modifying the [README.md](README.md) or adding new documentation files.

## Code of Conduct

This project adheres to a code of conduct to ensure a positive environment for everyone. Please be respectful and considerate in your interactions with others.

## License

By contributing, you agree that your contributions will be licensed under the [MIT License](LICENSE.md).

Thank you for your time and effort in contributing to this project. Your contributions help make this project better for everyone!
