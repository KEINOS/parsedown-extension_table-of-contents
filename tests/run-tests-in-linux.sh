#!/bin/sh
# =============================================================================
#  Test Script to check basic function.
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
