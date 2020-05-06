#!/bin/bash
# =============================================================================
#  Actual tests running via Bash
# =============================================================================

# -----------------------------------------------------------------------------
#  Constants
# -----------------------------------------------------------------------------
YES=0
NO=1
PATH_DIR_CURRENT=$(cd "$(dirname "${BASH_SOURCE:-$0}")" && pwd)
PATH_DIR_PARENT=$(cd "$(dirname "${PATH_DIR_CURRENT}")" && pwd)
PATH_DIR_ROOT=$(dirname "${PATH_DIR_PARENT}")

cd "$PATH_DIR_PARENT"

# -------------------------------------------------------------------------------
#  Functions
# -------------------------------------------------------------------------------
function getUrlTarbollFromEndpoint () {
    url_api_to_request="${1}"

    # Loop until getting the tarball URL.
    # Since Travis CI requests many times at once, the GitHub API sometimes
    # returns 503 status error.
    # Also DO NOT "echo" anything here exept the URL. Otherwise "exit 1" after echo.
    count_iterate_max=3
    count_iterate_cur=0
    while :
    do
        count_iterate_cur=$((count_iterate_cur+1))
        [ $count_iterate_cur -eq $count_iterate_max ] && {
            echo ' NG'
            echo '- Max retry exceeded. Plese check your internet connection or the destination URL below.'
            echo "  Target URL: ${url_api_to_request}"
            exit 1
        }

        # Sleep random seconds before request (Avoid 503 server error)
        time_sleep=$(( $RANDOM % 10 + 1 ))
        sleep "${time_sleep}s"

        header_result=$(curl --silent --head $url_api_to_request)
        echo "${header_result}" | grep HTTP | grep 200 > /dev/null 2>&1 || {
            continue
        }

        # Fetch download URL of
        url_download_tarboll=$(curl -s $url_api_to_request | jq -r '.tarball_url')

        [ "${url_download_tarboll:+undefined}" ] || {
            continue
        }

        [ "${url_download_tarboll}" = "null" ] && {
            continue
        }

        echo $url_download_tarboll
        break;
    done
}

function isAvailableGitHubAPI () {
    echo -n '- Checking if GitHub API is available ... '
    # Exit when GitHub API  returns 403 status error.
    # Once this error is shown, you need a cool down time about an hour.
    url_api_to_request="${1}"
    header_result=$(curl --silent --head $url_api_to_request)
    echo "${header_result}" | grep HTTP | grep 403 > /dev/null 2>&1 && {
        echo 'ERROR'
        time_reset_ratelimit=$(echo "$header_result" | grep X-Ratelimit-Reset | awk '{print $2}' | sed -e 's/[^0-9]//g')
        time_current=$(date +%s)
        time_diff_secs=$((time_reset_ratelimit-time_current))
        time_remain=$(date -d@$time_diff_secs -u +%H:%M:%S)

        echo '- Request rate limit exceeded: GitHub API returned 403 error. Please wait until the limitation resets.'
        echo "  Time remaining: ${time_diff_secs} seconds (${time_remain})"

        exit 1
    }
    echo 'OK'
    return 0
}

# -----------------------------------------------------------------------------
#  Lint check of Extension.php
# -----------------------------------------------------------------------------
name_file_script_extension='Extension.php'
path_file_script_extension="${PATH_DIR_ROOT}/${name_file_script_extension}"
echo -n '- Lint Check: Extension.php ... '
result=$(php -l "${path_file_script_extension}")
[ $? -ne 0 ] && {
    echo 'NG'
    echo $result
    exit 1
}
echo 'OK'
echo "  ${result}"

# -----------------------------------------------------------------------------
#  Requirement check
# -----------------------------------------------------------------------------
# Check Parsedown
name_file_script_parsedown='Parsedown.php'
path_file_script_parsedown="${PATH_DIR_ROOT}/${name_file_script_parsedown}"
flag_found_parsedown=$NO
echo -n "- Searching Parsedown ... "
[ -f "$path_file_script_parsedown" ] && {
    flag_found_parsedown=$YES
    echo 'Found'
} || {
    echo 'Not found'
}

# Check Parsedown Extra
name_file_script_parsedown_extra='ParsedownExtra.php'
path_file_script_parsedown_extra="${PATH_DIR_ROOT}/${name_file_script_parsedown_extra}"
flag_found_parsedown_extra=$NO
echo -n "- Searching Parsedown Extra ... "
[ -f "$path_file_script_parsedown_extra" ] && {
    flag_found_parsedown_extra=$YES
    echo 'Found'
} || {
    echo 'Not found'
}

# -------------------------------------------------------------------------------
#  Download Parsedown Vanilla
# -------------------------------------------------------------------------------
url_api_github='https://api.github.com/repos/erusev/parsedown/releases/latest'

[ "$flag_found_parsedown" -eq "$NO" ] && {
    # Get URL to download released archive
    isAvailableGitHubAPI "${url_api_github}" && \
    url_download_tarboll=$(getUrlTarbollFromEndpoint "${url_api_github}")

    # Get Name of the archive
    name_file_target='Parsedown.php'
    name_file_archive='archive-vanilla.tar.gz'
    path_file_archive="${PATH_DIR_ROOT}/${name_file_archive}"
    name_dir_extract='tmp_extract'

    # Download Latest Parsedown
    echo "- Downloading Parsedown.php from: ${url_download_tarboll}"
    curl --silent --show-error --location $url_download_tarboll --output $path_file_archive && \
    tar -xf $path_file_archive && \
    mv erusev-parsedown* $name_dir_extract && \
    mv "${name_dir_extract}/${name_file_target}" $path_file_script_parsedown && \
    rm -rf $name_dir_extract && \
    rm $path_file_archive
    [ $? -ne 0 ] && {
        echo 'Failed to download Parsedown'
        exit 1
    }
}

# -------------------------------------------------------------------------------
#  Download Parsedown Extra
# -------------------------------------------------------------------------------
url_api_github='https://api.github.com/repos/erusev/parsedown-extra/releases/latest'

[ "$flag_found_parsedown_extra" -eq "$NO" ] && {
    # Get URL to download released archive
    isAvailableGitHubAPI "${url_api_github}" && \
    url_download_tarboll=$(getUrlTarbollFromEndpoint "${url_api_github}")

    # Get Name of the archive
    name_file_target='ParsedownExtra.php'
    name_file_archive='archive-extra.tar.gz'
    path_file_archive="${PATH_DIR_ROOT}/${name_file_archive}"
    name_dir_extract='tmp_extract'

    # Download Latest Parsedown Extra
    echo "- Downloading ParsedownExtra.php from: ${url_download_tarboll}"
    curl --silent --show-error --location $url_download_tarboll --output $path_file_archive && \
    tar -xf $path_file_archive && \
    mv erusev-parsedown* $name_dir_extract && \
    mv "${name_dir_extract}/${name_file_target}" $path_file_script_parsedown_extra && \
    rm -rf $name_dir_extract && \
    rm $path_file_archive
    [ $? -ne 0 ] && {
        echo 'Failed to download Parsedown'
        exit 1
    }
}

function runTest () {
    PATH_FILE_TEST="${1}"
    PATH_FILE_PARSER="${2}"
    SOURCE=''
    EXPECT=''
    RESULT=''
    DIFF=''

    # Load test case
    source $PATH_FILE_TEST

    echo -n "- TESTING: ${PATH_FILE_TEST}  ... "

    RESULT=$(echo "${SOURCE}" | php $PATH_FILE_PARSER)

    [ "${RESULT}" = "${EXPECT}" ] && [ $EXPECT_EQUAL -eq $YES ] && {
        echo "OK (Parser: ${PATH_FILE_PARSER})"
        return 0
    }

    [ "${RESULT}" != "${EXPECT}" ] && [ $EXPECT_EQUAL -eq $NO ] && {
        echo "OK (Parser: ${PATH_FILE_PARSER})"
        return 0
    }
    echo "NG (Parser: ${PATH_FILE_PARSER})"

    DIFF=$(diff  <(echo "${RESULT}") <(echo "${EXPECT}"))

cat << HEREDOC
[ERROR LOG]
- SOURCE:
${SOURCE}

- RESULT:
${RESULT}

- EXPECT:
${EXPECT}

- DIFF:
${DIFF}

HEREDOC

    return 1
}

# -----------------------------------------------------------------------------
#  Run tests
# -----------------------------------------------------------------------------
echo '================================'
echo ' Running tests'
echo '================================'

echo 'Parsedown Vanilla'
for file in $(ls test_*.sh); do
    runTest "${file}" './parser-vanilla.php'
done

echo 'Parsedown Extra'

for file in $(ls test_*.sh); do
    runTest "${file}" './parser-extra.php'
done
