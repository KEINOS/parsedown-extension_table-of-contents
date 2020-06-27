# Test Scripts to check the basic function

In order to run the tests in PHP5 as well, we decided NOT to use PHPUnit and do the foolishly naive tests instead.

- To run the tests locally on Linux/macOS:

  ```bash
  $ composer test
  ...
  ```

- To run the tests on Docker:

  ```bash
  $ # For those who want to run the tests in PHP ^7.4 (Debian)
  $ composer test-docker
  ...
  ```

  ```bash
  $ # For those who want to run the tests in PHP 5.3.26 (Debian)
  $ composer test-docker-php5.3
  ...
  ```

  ```bash
  $ # For those who want to run the tests in PHP 5.6.40 (Alpine)
  $ composer test-docker-php5
  ...
  ```

  ```bash
  $ # For those who want to run the tests in PHP 8.0-dev (Alpine)
  $ composer test-docker-php8
  ...
  ```

- To run the tests on Windows 10:
  - Currently we DO NOT support tests that run on Windows10 locally. Please consider testing on Docker.

---

- **NOTE:** These tests won't be included to the [Packagist](https://packagist.org/packages/keinos/parsedown-toc) archive.
  - For the reason see: https://github.com/KEINOS/parsedown-extension_table-of-contents/issues/9
