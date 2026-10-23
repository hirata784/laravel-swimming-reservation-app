FROM php:8.3-fpm

COPY php.ini /usr/local/etc/php/

# 最新のインストール基準に合わせて libpng-dev などを追加しています
RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev unzip \
  && docker-php-ext-install pdo_mysql zip

# Composerのインストール方法をよりシンプルでエラーの起きにくい公式推奨の書き方に変更しました
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www
