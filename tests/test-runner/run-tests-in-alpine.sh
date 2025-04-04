#!/bin/bash
# =============================================================================
#  Basic setup for Alpine Linux before running the tests.
# =============================================================================

# Move working directory to the parrent
PATH_DIR_CURRENT=$(cd "$(dirname "${BASH_SOURCE:-$0}")" && pwd)
PATH_DIR_PARENT=$(cd "$(dirname "${PATH_DIR_CURRENT}")" && pwd)

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
indentStdin < /etc/os-release

echo '- Checking: php ...'
which php > /dev/null 2>&1 || {
    echo '- ERROR: PHP not found.'
    exit 1
}
printf "%s" '  php installed: '
php --version | indentStdin

echo '- Checkging: apk ...'
which apk> /dev/null 2>&1 || {
    echo '* ERROR: This script requires apk'
    echo 'Please run on Alpine Linux OS'
    exit 1
}
printf "%s" '  apk installed: '
apk --version | head -1

echo '- Checking: jq ...'
which jq > /dev/null 2>&1 || {
    echo '* WARNING: jq command missing'
    printf "%s" '- INSTALL: Installing jq ... '
    apk --no-cache add jq > /dev/null 2>&1 && {
        echo 'OK'
    } || {
        echo 'NG'
    }
}
printf "%s" '  jq installed: '
jq --version

echo '- Checking: curl ...'
which curl > /dev/null 2>&1 || {
    echo '* WARNING: curl command missing'
    printf "%s" '- INSTALL: Installing curl ... '
    apk --no-cache add curl > /dev/null 2>&1 && {
        echo 'OK'
    } || {
        echo 'NG'
    }
}
printf "%s" '  curl installed: '
curl --version | head -1

echo '- Checking: bash ...'
which bash > /dev/null 2>&1 || {
    echo '* WARNING: bash shell missing'
    printf "%s" '- INSTALL: Installing bash ... '
    apk --no-cache add bash > /dev/null 2>&1 && {
        echo 'OK'
    } || {
        echo 'NG'
    }
}
printf "%s" '  bash installed: '
bash --version | head -1

# -----------------------------------------------------------------------------
#  Run Actual Tests
# -----------------------------------------------------------------------------
/bin/bash "${PATH_DIR_CURRENT}/common-tests.sh"

exit $?
