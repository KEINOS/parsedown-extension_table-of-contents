# Contributing to Parsedown ToC Extension

## Getting Started Contributing

The basics of creating the table of contents (ToC) in this extension are simple.

1. It uses the Parsedown's `blockHeader()` method to retrieve the header block element.
2. Then it extracs the header text and level from the block element.
3. Finally, it stores the header information in an array as a ToC item.

Most of the prosesing is done in the `blockHeader()` method, which overrides the default `blockHeader()` method in Parsedown.

So, looking at the `blockHeader()` method is a good starting point for understanding how the ToC is created.

## Contributing

Any contributions to this project are welcome. If you have suggestions for improvements such as: typo, bug fixes, or new features, please open an issue or submit a pull request (PR).

- Branch to PR: `master`
  - **Note** that your PR after merge may be changed/refactored/improved by the other contributors or the maintainer. But your contribution will be acknowledged.

### Basic Rules

- Coding Standards:
  - PHP Scripts: [PSR-2](https://www.php-fig.org/psr/psr-2/)
  - Shell Scripts: Bash and [ShellCheck](https://www.shellcheck.net/) passes

### Regulations

- Code reviews begings only after the CI tests are passed.
  - Unit tests for basic functionality including bug fixes
  - Psalm for static analysis

### Testing

Currently we do not care about full code coverage. But for bug fixes and new features, please add tests to the `tests/issues` directory to keep your efforts functional.

- Bug Fixes: Add a test to reproduce the bug.
- New Features: Add a test to verify the new feature. If possible, add error cases as well.
