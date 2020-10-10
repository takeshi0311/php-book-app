# PHPの公式イメージを指定
FROM php:7.2-apache

# APACHE_DOCUMENT_ROOTという環境変数に/var/www/html/app/webrootを代入。
# 後続命令の環境において、環境変数の値は維持される。
ENV APACHE_DOCUMENT_ROOT /var/www/html/app/webroot

# sedコマンドを使ってApacheのwebrootを/var/www/html/app/webrootに変更している。CakePHPを動作させるために必要。
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
&& sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
&& a2enmod rewrite

#LinuxパッケージやPHPモジュールをインストールしている。CakePHPを動かすのに必要。
#libicu-dev：Unicode 用の国際化コンポーネントの開発用ファイル。ICU は、堅牢で多機能な Unicode およびロケールへの対応を提供する C++ および C のライブラリ。
RUN apt-get update && apt-get install -y \
    libicu-dev \
    zip \
    unzip \
&& docker-php-ext-install -j$(nproc) intl \
&& docker-php-ext-install -j$(nproc) pdo_mysql

#日付を正しく使うためにLinuxのタイムゾーンを日本標準時に変更。
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

#ホスト側カレントディレクトリ配下のファイル群を、ゲスト側の/var/www/html配下にコピーする。
#こうすることででホスト側でgit cloneしてきたファイル群をゲストのコンテナ群にもコピーコピーして配置することができる
COPY . /var/www/html

#composer:1.7というcomposerのイメージから直接composerのバイナリファイルをコピーしています。
#composerはこの後のCakePHPのインストールで使用する。
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer:1.7 /usr/bin/composer /usr/bin/composer

RUN cd ./app && \ 
    composer install --no-dev -o