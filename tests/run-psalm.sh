#!/bin/bash

# -----------------------------------------------------------------------------
#  Constants
# -----------------------------------------------------------------------------
YES=0
NO=1
STATUS_SUCCESS=0
STATUS_FAILURE=1
PATH_DIR_CURRENT=$(cd "$(dirname "${BASH_SOURCE:-$0}")" && pwd)
PATH_DIR_PARENT=$(cd "$(dirname "${PATH_DIR_CURRENT}")" && pwd)
PATH_DIR_ROOT=$(dirname "${PATH_DIR_PARENT}")
[ -z "$PATH_DIR_ROOT" ] || [ "$PATH_DIR_ROOT" = "/" ] && PATH_DIR_ROOT="/app"

cd "$PATH_DIR_PARENT" || exit $STATUS_FAILURE

# -------------------------------------------------------------------------------
#  Functions
# -------------------------------------------------------------------------------

# Echoes the URL to download the tarball of the latest release from GitHub.
#
# @param  string $1  GitHub API endpoint URL of the target repository.
# @return string     Echoes the URL of the latest tarball to download.
# @execption         On error exits the script as 1.
function getUrlTarbollFromEndpoint() {
    url_api_to_request="${1}"

    # Loop until it gets the tarball URL.
    # Since we run several PHP versions in Travis CI, many requests will be sent
    # at once. Therefore the GitHub API sometimes returns the 503 status error.
    #
    # Note: DO NOT "echo" anything here exept the URL. In case you need to echo
    #       something for debugging then "exit 1" after that echo.
    count_iterate_max=3
    count_iterate_cur=0
    while :; do
        count_iterate_cur=$((count_iterate_cur + 1))
        [ $count_iterate_cur -eq $count_iterate_max ] && {
            echo ' NG'
            echo '- Max retry exceeded. Plese check your internet connection or the destination URL below.'
            echo "  Target URL: ${url_api_to_request}"
            exit $STATUS_FAILURE
        }

        # Sleep random seconds before request (Avoid 503 server error)
        time_sleep=$((RANDOM % 10 + 1))
        sleep "${time_sleep}s"

        # Check if HTTP status code is 200
        header_result=$(curl --silent --head "$url_api_to_request")
        echo "${header_result}" | grep HTTP | grep 200 >/dev/null 2>&1 || {
            continue
        }

        # Fetch download URL of
        url_download_tarboll=$(curl -s "$url_api_to_request" | jq -r '.tarball_url')

        [ "${url_download_tarboll:+undefined}" ] || {
            continue
        }

        [ "${url_download_tarboll}" = "null" ] && {
            continue
        }

        echo "$url_download_tarboll"
        break
    done
}

# Checks if the GitHub API request quota is not exceeded.
#
# @param  string $1  GitHub API Endpoint URL of the target repository.
# @return int        Returns 0 if the request quota is not exceeded.
# @execption         If exceeded or any error exits the script as 1.
function isAvailableGitHubAPI() {
    echo -n '- Checking if GitHub API is available ... '
    url_api_to_request="${1}"
    header_result=$(curl --silent --head "$url_api_to_request")
    echo "${header_result}" | grep HTTP | grep 403 >/dev/null 2>&1 && {
        # Exit as 1 when GitHub API returns 403 status error.
        #   GitHub API has a quota/limitation rate of access per IP address.
        #   Once this error is shown, you need an hour or more of cool down time.
        echo 'ERROR'
        time_reset_ratelimit=$(echo "$header_result" | grep X-Ratelimit-Reset | awk '{print $2}' | sed -e 's/[^0-9]//g')
        time_current=$(date +%s)
        time_diff_secs=$((time_reset_ratelimit - time_current))
        time_remain=$(date -d@$time_diff_secs -u +%H:%M:%S)

        echo '- Request rate limit exceeded: GitHub API returned 403 error. Please wait until the limitation resets.'
        echo "  Time remaining: ${time_diff_secs} seconds (${time_remain}/h:m:s)"

        exit $STATUS_FAILURE
    }
    echo 'OK'
    return $STATUS_SUCCESS
}

# -----------------------------------------------------------------------------
#  Requirement check
# -----------------------------------------------------------------------------
# Check Parsedown
name_file_script_parsedown='Parsedown.php'
path_file_script_parsedown="${PATH_DIR_ROOT}/${name_file_script_parsedown}"
flag_found_parsedown=$NO
echo -n "- Searching Parsedown ... "
if [ -f "$path_file_script_parsedown" ]; then
    flag_found_parsedown=$YES
    echo "Found @ ${path_file_script_parsedown}"
else
    echo 'Not found'
fi

# Check Parsedown Extra
name_file_script_parsedown_extra='ParsedownExtra.php'
path_file_script_parsedown_extra="${PATH_DIR_ROOT}/${name_file_script_parsedown_extra}"
flag_found_parsedown_extra=$NO
echo -n "- Searching Parsedown Extra ... "
if [ -f "$path_file_script_parsedown_extra" ]; then
    flag_found_parsedown_extra=$YES
    echo "Found @ ${flag_found_parsedown_extra}"
else
    echo 'Not found'
fi

# -------------------------------------------------------------------------------
#  Download Parsedown Vanilla
# -------------------------------------------------------------------------------
url_api_github='https://api.github.com/repos/erusev/parsedown/releases/latest'

[ "$flag_found_parsedown" -eq "$NO" ] && {
    # Get URL to download released archive
    isAvailableGitHubAPI "${url_api_github}" &&
        url_download_tarboll=$(getUrlTarbollFromEndpoint "${url_api_github}")

    # Get Name of the archive
    name_file_target='Parsedown.php'
    name_file_archive='archive-vanilla.tar.gz'
    path_file_archive="${PATH_DIR_ROOT}/${name_file_archive}"
    name_dir_extract='tmp_extract'

    # Download Latest Parsedown
    echo "- Downloading Parsedown.php from: ${url_download_tarboll}"
    if ! (curl --silent --show-error --location "$url_download_tarboll" --output "$path_file_archive" &&
        tar -xf "$path_file_archive" &&
        mv erusev-parsedown* "$name_dir_extract" &&
        mv "${name_dir_extract}/${name_file_target}" "$path_file_script_parsedown" &&
        rm -rf "$name_dir_extract" &&
        rm "$path_file_archive")
    then
        echo 'Failed to download Parsedown'

        exit $STATUS_FAILURE
    fi

    echo "- PATH: ${path_file_script_parsedown}"
}

# -------------------------------------------------------------------------------
#  Download Parsedown Extra
# -------------------------------------------------------------------------------
url_api_github='https://api.github.com/repos/erusev/parsedown-extra/releases/latest'

[ "$flag_found_parsedown_extra" -eq "$NO" ] && {
    # Get URL to download released archive
    isAvailableGitHubAPI "${url_api_github}" &&
        url_download_tarboll=$(getUrlTarbollFromEndpoint "${url_api_github}")

    # Get Name of the archive
    name_file_target='ParsedownExtra.php'
    name_file_archive='archive-extra.tar.gz'
    path_file_archive="${PATH_DIR_ROOT}/${name_file_archive}"
    name_dir_extract='tmp_extract'

    # Download Latest Parsedown Extra
    echo "- Downloading ParsedownExtra.php from: ${url_download_tarboll}"
    if ! (curl --silent --show-error --location "$url_download_tarboll" --output "$path_file_archive" &&
        tar -xf "$path_file_archive" &&
        mv erusev-parsedown* "$name_dir_extract" &&
        mv "${name_dir_extract}/${name_file_target}" "$path_file_script_parsedown_extra" &&
        rm -rf "$name_dir_extract" &&
        rm "$path_file_archive")
    then
        echo 'Failed to download Parsedown'

        exit $STATUS_FAILURE
    fi

    echo "- PATH: ${path_file_script_parsedown_extra}"
}

# -----------------------------------------------------------------------------
#  Run tests
# -----------------------------------------------------------------------------

composer install --no-dev || exit $STATUS_FAILURE

echo '================================'
echo ' Running Psalm (static analysis)'
echo '================================'

psalm ./Extension.php || exit $STATUS_FAILURE
