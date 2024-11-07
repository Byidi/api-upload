FROM composer:2 AS composer_base
FROM dunglas/frankenphp:1-php8.3 AS base

WORKDIR /app

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install --no-install-recommends -y \
	acl=2.3.* \
	file=1:5.* \
	gettext=0.21* \
	git=1:2.*\
	&& apt-get clean \
	&& rm -rf /var/lib/apt/lists/* \
;

RUN install-php-extensions \
    @composer \
    apcu \
	intl \
	zip \
	opcache \
    pdo_pgsql \
;

COPY ./ /app/

COPY --from=composer_base /usr/bin/composer /usr/local/bin/composer

RUN composer install


FROM base AS dev

ENV SERVER_NAME=http://localhost
ENV MERCURE_PUBLIC_URL=http://localhost/.well-known/mercure

SHELL ["/bin/bash", "-o", "pipefail", "-c"]
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony


FROM base AS prod

ENV APP_RUNTIME=Runtime\\FrankenPhpSymfony\\Runtime
ENV FRANKENPHP_CONFIG="worker ./public/index.php"

ENV SERVER_NAME=http://todo.byidi.fr
ENV MERCURE_PUBLIC_URL=http://todo.byidi.fr/.well-known/mercure