#!/bin/bash
# =============================================================================
#  Basic setup for macOS before running the tests.
# =============================================================================

# Move working directory to the parrent
PATH_DIR_CURRENT=$(cd "$(dirname "${BASH_SOURCE:-$0}")" && pwd)
PATH_DIR_PARENT=$(cd "$(dirname "${PATH_DIR_CURRENT}")" && pwd)
PATH_DIR_ROOT=$(dirname "${PATH_DIR_PARENT}")

cd "$PATH_DIR_PARENT"

set -eu

# -----------------------------------------------------------------------------
#  Functions
# -----------------------------------------------------------------------------

INDENT='  ' # Indentation depth for multiline output

function indentStdin() {
    while read -r line; do
        echo "${INDENT}${line}"
    done
    echo
}

# -----------------------------------------------------------------------------
#  Check Basic requirements
# -----------------------------------------------------------------------------
echo '================================'
echo ' Env checks before testing'
echo '================================'

echo '- Info: OS ...'
sw_vers | indentStdin

echo '- Checking: php ...'
which php > /dev/null 2>&1 || {
    echo '- ERROR: PHP not found.'
    exit 1
}
echo -n '  php installed: '
php --version | indentStdin

echo '- Checking: jq ...'
which jq > /dev/null 2>&1 || {
    echo '* WARNING: jq command missing'
    echo '* "jq" command is required for testing. Try: $ brew install jq'
    exit 1
}
echo -n '  jq installed: '
jq --version

echo '- Checking: curl ...'
which curl > /dev/null 2>&1 || {
    echo '* WARNING: curl command missing'
    echo '* "curl" command is required for testing. Try: $ brew install curl'
    exit 1
}
echo -n '  curl installed: '
curl --version | head -1

echo '- Checking: tar ...'
which tar > /dev/null 2>&1 || {
    echo '* WARNING: tar command missing'
    echo '* "tar" command is required for testing. Try: $ brew install tar'
    exit 1
}
echo -n '  tar installed: '
tar --version

# -----------------------------------------------------------------------------
#  Run Actual Tests
# -----------------------------------------------------------------------------
/bin/bash "${PATH_DIR_CURRENT}/common-tests.sh"

exit $?
