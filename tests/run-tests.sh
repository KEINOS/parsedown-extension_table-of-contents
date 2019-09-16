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

# -----------------------------------------------------------------------------
#  Check Basic requirements
# -----------------------------------------------------------------------------
which php > /dev/null 2>&1 || {
    echo '- ERROR: PHP not found.'
    exit 1
}
which jq > /dev/null 2>&1 || {
    echo '- WARNING: jq command missing'
    echo -n '- INSTALL: Installing jq command ... '
    apt-get -y update > /dev/null 2>&1 && \
    apt-get -y -q install jq --force-yes > /dev/null 2>&1 && {
        echo 'OK'
    } || {
        echo 'NG'
    }
}

# -----------------------------------------------------------------------------
#  Download Latest Parsedown from releases page
# -----------------------------------------------------------------------------
[ -f './Parsedown.php' ] || {
    # Get URL of latest tarball
    url_download_tarboll=$(curl -s https://api.github.com/repos/erusev/parsedown/releases/latest | jq -r '.tarball_url')

    # Get Name of the archive
    name_file_archive=$(basename "$url_download_tarboll")

    # Download Latest Parsedown
    echo '- Downloading Parsedown.php'
    curl --location -O $url_download_tarboll && \
    tar -xf $name_file_archive && \
    rm $name_file_archive && \
    mv erusev-parsedown* src && \
    mv src/Parsedown.php ./Parsedown.php && \
    rm -rf ./src
}

# -----------------------------------------------------------------------------
#  Run tests
# -----------------------------------------------------------------------------
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
    echo '- SOURCE:'
    echo "${SOURCE}"
    echo '- RESULT:'
    echo "${RESULT}"
    echo '- EXPECT:'
    echo "${EXPECT}"
    exit 1

done
