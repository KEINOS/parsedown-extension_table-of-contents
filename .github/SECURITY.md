# Security Policy

As a minimum security measure, we use the following tools to be checked in our repository.
Any PR or push to the main (`master`) branch must pass all the checks.

- Unit tests
  - Currently, we do not use PHPUnit, but we use our home-made test scripts to test its basic functionality.
  - To simplify the test and ease testing is our top priority.
- Integration tests
  - The "examples" directory contains a set of examples that are used to test the extension.
  - We use the examples as an integration test to check the extension's functionality.
- [Psalm](https://psalm.dev/)
  - Static analysis

## Reporting a Vulnerability

- [Report security issues](https://github.com/KEINOS/parsedown-extension_table-of-contents/issues)
  - Please provide a simple example to reproduce the issue. It will help us a lot to fix the issue.

## Preferred Languages

- English, Spanish, Japanese
