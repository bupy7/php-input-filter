FROM php:8.3-cli-alpine

ARG GITHUB_OAUTH_TOKEN=""
ARG USER_UID=""
ARG USER_GID=""

RUN apk add --no-cache $PHPIZE_DEPS && apk add --update linux-headers

RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN rm -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY 50_xdebug.ini /usr/local/etc/php/conf.d/

RUN addgroup -g $USER_GID php-cli \
    && adduser -u $USER_UID -G php-cli -s /bin/sh -D php-cli

USER php-cli

ENV PATH="/home/php-cli/.local/bin:/home/php-cli/.composer/vendor/bin:${PATH}"

RUN mkdir -p /home/php-cli/.local/bin && \
    curl -sS https://getcomposer.org/installer | \
    /usr/local/bin/php -- --2 --install-dir=/home/php-cli/.local/bin --filename=composer

RUN if [ -n "${GITHUB_OAUTH_TOKEN}" ]; then \
    composer config -g github-oauth.github.com ${GITHUB_OAUTH_TOKEN} \
;fi

CMD ["php", "-a"]
