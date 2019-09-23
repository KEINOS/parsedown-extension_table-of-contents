#!/bin/bash
# =============================================================================
#  Test Script to check basic function.
# =============================================================================

set -eu
cd $(cd $(dirname $0); pwd)

# -----------------------------------------------------------------------------
#  Constants
# -----------------------------------------------------------------------------
YES=0
NO=1
URL_API_GITHUB='https://api.github.com/repos/erusev/parsedown/releases/latest'

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
    echo '- ERROR: PHP not found.'
    exit 1
}
echo -n 'php installed: '
php --version

echo '- Checkging: apt-get ...'
which apt-get > /dev/null 2>&1 || {
    echo '- ERROR: This script requires apt-get'
    echo 'Please run on Debian-like OS'
    exit 1
}
echo -n 'apt-get installed: '
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
echo -n 'jq installed: '
jq --version

echo '- Checking: curl ...'
which curl > /dev/null 2>&1 || {
    echo '- WARNING: curl command missing'
    echo -n '- INSTALL: Installing curl ... '
    apt-get -y update > /dev/null 2>&1 && \
    apt-get -y -q install curl --force-yes > /dev/null 2>&1 && {
        echo 'OK'
    } || {
        echo 'NG'
    }
}
echo -n 'curl installed: '
curl --version | head -1

# -----------------------------------------------------------------------------
#  Lint check of Extension.php
# -----------------------------------------------------------------------------
echo '- Lint Check: Extension.php ...'
php -l ../Extension.php

# -----------------------------------------------------------------------------
#  Download Latest Parsedown from releases page
# -----------------------------------------------------------------------------
[ -f './Parsedown.php' ] || {
    echo -n '- Searching URL of Parsedown archive .'
    # Loop here until getting the tarball URL, since Travis CI requests many
    # times at once, the GitHub API sometimes returns 503 status error.
    while :
    do
        echo -n '.'
        sleep $[ ( $RANDOM % 10 )  + 1 ]s

        curl --silent --head $URL_API_GITHUB | grep Status | grep 200 > /dev/null 2>&1 || {
            continue
        }

        url_download_tarboll=$(curl -s $URL_API_GITHUB | jq -r '.tarball_url')

        if [ -z "${url_download_tarboll}" ]; then
            continue
        elif [ "${url_download_tarboll}" = "null" ]; then
            continue
        else
            echo '. OK'
            echo '- URL of tarball found:' $url_download_tarboll
            break;
        fi
    done

    # Get Name of the archive
    #name_file_archive=$(basename "$url_download_tarboll")
    name_file_archive='./archive.tar.gz'

    # Download Latest Parsedown
    echo "- Downloading Parsedown.php from: ${url_download_tarboll}"
    curl --silent --show-error --location $url_download_tarboll --output $name_file_archive && \
    tar -xf $name_file_archive && \
    rm $name_file_archive && \
    mv erusev-parsedown* src && \
    mv src/Parsedown.php ./Parsedown.php && \
    rm -rf ./src
}

# -----------------------------------------------------------------------------
#  Run tests
# -----------------------------------------------------------------------------
echo '================================'
echo ' Running tests'
echo '================================'

for file in $(ls test_*.sh); do
    SOURCE=''
    EXPECT=''
    RESULT=''

    # Load test case
    source $file

    echo -n "- TESTING: ${file} ... "

    RESULT=$(echo "${SOURCE}" | php ./parser.php)

    [ "${RESULT}" = "${EXPECT}" ] && [ $EXPECT_EQUAL -eq $YES ] && {
        echo 'OK'
        continue
    }

    [ "${RESULT}" != "${EXPECT}" ] && [ $EXPECT_EQUAL -eq $NO ] && {
        echo 'OK'
        continue
    }
    echo 'NG'

    echo '[LOG]:'
    echo '- SOURCE:'
    echo "${SOURCE}"
    echo '- RESULT:'
    echo "${RESULT}"
    echo '- EXPECT:'
    echo "${EXPECT}"
    exit 1

done
