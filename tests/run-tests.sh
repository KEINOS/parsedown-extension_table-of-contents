#!/bin/sh
# =============================================================================
#  Note: To run the test, see the README.md in this directory.
#
#  This test script will:
#    1. Read the files "test_*.sh" and gets the below 2 strings.
#      - SOURCE -> Markdown sample
#      - EXPECT -> Expected result in HTML
#    2. Pipes the "SOURCE" to the STDIN of the below parser scripts.
#      - ./parser/parser-vanilla.php
#      - ./parser/parser-extra.php
#    3. The parser script receives the markdown from the STDIN and parses to
#       HTML then echoes/outputs the result to STDOUT. (="ACTUAL")
#    4. Finally this script compares the "ACTUAL" and "EXPECT".
# =============================================================================

path_dir_current=$(cd "$(dirname "${BASH_SOURCE:-$0}")" && pwd)

# For author's local env
which sw_vers > /dev/null 2>&1 && {
    echo '--------------------------------'
    echo 'Running tests in macOS'
    echo '--------------------------------'
    /bin/bash "${path_dir_current}/test-runner/run-tests-in-darwin.sh"
    exit $?
}

# For TravisCI
which apt-get > /dev/null 2>&1 && {
    echo '--------------------------------'
    echo 'Running tests in Debian-like OS'
    echo '--------------------------------'
    /bin/bash "${path_dir_current}/test-runner/run-tests-in-debian.sh"
    exit $?
}

# For Docker Alpine Container
which apk > /dev/null 2>&1 && {
    echo '--------------------------------'
    echo 'Running tests in Alpine Linux OS'
    echo '--------------------------------'
    /bin/sh "${path_dir_current}/test-runner/run-tests-in-alpine.sh"
    exit $?
}

echo 'This script currently runs only on Debian-like OS / Alpine Linux / macOS only.'
exit 1
