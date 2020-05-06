#!/bin/bash
# =============================================================================
#  Basic setup for Debian-like OSs before running the tests.
# =============================================================================

# Move working directory to the parrent
PATH_DIR_CURRENT=$(cd "$(dirname "${BASH_SOURCE:-$0}")" && pwd)
PATH_DIR_PARENT=$(cd "$(dirname "${PATH_DIR_CURRENT}")" && pwd)
PATH_DIR_ROOT=$(dirname "${PATH_DIR_PARENT}")

cd $PATH_DIR_PARENT

set -eu

# -----------------------------------------------------------------------------
#  Check Basic requirements
# -----------------------------------------------------------------------------
echo '================================'
echo ' Env checks before testing'
echo '================================'

echo '- Info: OS ...'
cat /etc/os-release

echo '- Checking: php ...'
which php > /dev/null 2>&1 || {
    echo '* ERROR: PHP not found.'
    exit 1
}
echo -n '  php installed: '
php --version

echo '- Checkging: apt-get ...'
which apt-get > /dev/null 2>&1 || {
    echo '* ERROR: This script requires apt-get'
    echo 'Please run on Debian-like OS'
    exit 1
}
echo -n '  apt-get installed: '
apt-get --version | head -1

echo '- Checking: jq ...'
which jq > /dev/null 2>&1 || {
    echo '* WARNING: jq command missing'
    echo -n '- INSTALL: Installing jq ... '
    apt-get -y update > /dev/null 2>&1 && \
    apt-get -y -q install jq --force-yes > /dev/null 2>&1 && {
        echo 'OK'
    } || {
        echo 'NG'
    }
}
echo -n '  jq installed: '
jq --version

echo '- Checking: curl ...'
which curl > /dev/null 2>&1 || {
    echo '* WARNING: curl command missing'
    echo -n '- INSTALL: Installing curl ... '
    apt-get -y update > /dev/null 2>&1 && \
    apt-get -y -q install curl --force-yes > /dev/null 2>&1 && {
        echo 'OK'
    } || {
        echo 'NG'
    }
}
echo -n '  curl installed: '
curl --version | head -1

# -----------------------------------------------------------------------------
#  Run Actual Tests
# -----------------------------------------------------------------------------
/bin/bash $PATH_DIR_CURRENT/common-tests.sh

exit $?
