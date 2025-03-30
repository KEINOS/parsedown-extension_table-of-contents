# =============================================================================
#  Dockerfile for Testing
#
#  Note: To run the container, DO NOT forget to mount the current directory
#        to /app in the container.
# =============================================================================
# Use the latest PHP on Alpine Linux by default
ARG PHP_VERSION="cli-alpine"

# -----------------------------------------------------------------------------
#  First stage: preparation
# -----------------------------------------------------------------------------
FROM php:${PHP_VERSION} AS prepare

WORKDIR /app

# Create composer installer script
COPY --chmod=755 <<'HEREDOC' /app/installer.sh
    #!/bin/sh

    EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

    if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]
    then
        >&2 echo 'ERROR: Invalid installer checksum'
        rm composer-setup.php
        exit 1
    fi

    php composer-setup.php ---quiet
    RESULT=$?
    rm composer-setup.php
    exit $RESULT
HEREDOC

RUN /app/installer.sh

# -----------------------------------------------------------------------------
#  Final stage
# -----------------------------------------------------------------------------

FROM php:${PHP_VERSION}

ENV PATH="~/.composer/vendor/bin:${PATH}"

# Stay up-to-date and install git
RUN apk --no-cache add \
    git \
    jq \
    bash \
    curl \
    && apk --no-cache upgrade

COPY --from=prepare /app/composer.phar /usr/local/bin/composer

WORKDIR /app

ENTRYPOINT ["/bin/bash", "-c"]
CMD ["./tests/run-tests.sh"]
