# Tests for Issues/Features

Unlike other tests, each file placed in this directory must be a complete PHP file.

The test runner will run each one separately, and will consider a status code of “0” to be an expected result, and a non-zero status code to be a test failure.

> [!IMPORTANT]
> Be sure that the PHP version is 8.3 or lower (PHP: >=5.3.0 <8.4). The current stable Parsedown v1.7.4 is not compatible with PHP 8.4 or higher.
>
> - See the upstream issue: [#889: Stable release with PHP 8.4 support](https://github.com/erusev/parsedown/issues/889) | issues | parsedown @ GitHub

## Requirements

- File naming convention:
  - The test file name must begin with "test_" and end with ".php". It should also contain a simple description of the test that is recognizable.
    - E.g.:
      - test_issue_1234.php
      - test_feat_5678_do_something_cool.php
      - test_body_golden_cases.php
- The test file must be able to run independently as follow:

    ```shellsession
    $ php test_issue_1234.php
    issue #1234: X should be Y ... OK

    $ echo $?
    0
    ```

    ```shellsession
    $ php test_feat_22_omit_toc_tag.php
    feature #22: option arg to exclude ToC tag in `body`
    - test #1: enable to omit the ToC tag in the body of the document ... OK
    - test #2: disable to omit the ToC tag in the body of the document (default) ... OK

    $ echo $?
    0
    ````

- The test must be a complete PHP file.
- The test must return a status code of 0 to be considered successful.
- The test must output to stdout what the test is doing and its result in the following format:
  - E.g. :
    - Success: "`issue #1234: X should be Y ... OK`"
    - Failure: "`issue #1234: X should be Y ... NG (X is not Y got Z)`"
- If the result needs more than one line, the results should be indented at least 2 spaces for readability.
