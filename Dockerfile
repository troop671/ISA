FROM ubuntu:24.04 AS certificates
RUN apt-get update && apt-get install -y --no-install-recommends openssl && rm -rf /var/lib/apt/lists/*
WORKDIR /certificates
RUN openssl req -x509 -newkey rsa:3072 -sha256 -days 3650 -nodes -subj "/CN=Troop671 Local CA" -keyout ca.key -out ca.crt \
 && openssl req -newkey rsa:3072 -sha256 -nodes -subj "/CN=smtp.dreamhost.com" -keyout smtp.key -out smtp.csr \
 && printf "subjectAltName=DNS:smtp.dreamhost.com\nextendedKeyUsage=serverAuth\n" > smtp.ext \
 && openssl x509 -req -in smtp.csr -CA ca.crt -CAkey ca.key -CAcreateserial -days 3650 -sha256 -extfile smtp.ext -out smtp.crt

FROM axllent/mailpit:v1.31.5 AS smtp
COPY --from=certificates /certificates/smtp.crt /certificates/smtp.key /etc/mailpit/

FROM ubuntu:24.04 AS application
ENV DEBIAN_FRONTEND=noninteractive TZ=America/Los_Angeles
ARG PHP_VERSION=8.3.30
ARG PHP_SHA256=67f084d36852daab6809561a7c8023d130ca07fc6af8fb040684dd1414934d48
ARG IMAGICK_VERSION=3.8.1
ARG IMAGICK_SHA256=3a3587c0a524c17d0dad9673a160b90cd776e836838474e173b549ed864352ee
RUN apt-get update && apt-get install -y --no-install-recommends \
    apache2=2.4.58-1ubuntu8.* libapache2-mod-fcgid=1:2.3.9-4 ca-certificates curl tzdata unzip xz-utils \
    build-essential pkg-config autoconf bison re2c \
    libxml2-dev libssl-dev libsqlite3-dev zlib1g-dev libbz2-dev libcurl4-openssl-dev \
    libpng-dev libjpeg-dev libfreetype-dev libwebp-dev libavif-dev libxpm-dev libgmp-dev libicu-dev libonig-dev \
    libpq-dev libreadline-dev libtidy-dev libxslt1-dev libsodium-dev libargon2-dev libzip-dev \
    libc-client2007e-dev libkrb5-dev libpspell-dev libmagickwand-dev \
 && rm -rf /var/lib/apt/lists/*
WORKDIR /usr/src
RUN curl -fsSL -o php.tar.xz "https://www.php.net/distributions/php-${PHP_VERSION}.tar.xz" \
 && echo "${PHP_SHA256}  php.tar.xz" | sha256sum -c - \
 && tar -xf php.tar.xz && cd "php-${PHP_VERSION}" \
 && ./configure --prefix=/usr/local/php83 --datadir=/usr/local/php83/share --localstatedir=/usr/local/php83/var \
    --disable-gcc-global-regs --without-pear --with-config-file-path=/etc/php83 --with-config-file-scan-dir=/etc/php83/conf.d \
    --with-zend-vm=GOTO --enable-cgi --enable-fpm --enable-hash --enable-intl --enable-json --enable-libxml=shared \
    --enable-bcmath=shared --enable-calendar=shared --enable-ctype=shared --enable-dom=shared --enable-exif=shared \
    --enable-fileinfo=shared --enable-filter --enable-ftp=shared --enable-gd=shared --with-jpeg --with-xpm --with-freetype \
    --with-avif --enable-mbstring --enable-mbregex --enable-mbregex-backtrack --enable-opcache --enable-pcntl=shared \
    --enable-pdo --enable-phar=shared --enable-posix=shared --enable-session=shared --enable-shmop=shared \
    --enable-simplexml=shared --enable-soap=shared --enable-sockets=shared --enable-sysvmsg=shared --enable-sysvsem=shared \
    --enable-sysvshm=shared --enable-tokenizer=shared --enable-wddx=shared --enable-xml=shared --enable-xmlreader=shared \
    --enable-xmlwriter=shared --with-gd=shared --with-jpeg-dir=/usr --with-png-dir=/usr --with-zlib-dir=/usr \
    --with-xpm-dir=/usr --with-freetype-dir=/usr --with-webp --with-openssl=shared --with-kerberos --with-pcre-regex \
    --with-pcre-jit --with-sqlite3 --with-zlib=shared --with-bz2=shared --with-curl=shared --with-gettext=shared \
    --with-gmp=shared --with-mhash=shared --with-iconv=shared --with-imap=shared --with-imap-ssl \
    --with-mysql-sock=/No-MySQL-hostname-was-specified --with-mysqli=shared,mysqlnd --with-pdo-mysql=shared,mysqlnd \
    --with-pdo-pgsql=shared --with-pdo-sqlite --with-pgsql=shared --with-pspell=shared --with-readline=shared \
    --with-tidy=shared --with-xsl=shared --with-sodium --with-password-argon2=/usr --with-zip=shared \
 && make -j"$(nproc)" && make install \
 && curl -fsSL -o /usr/src/imagick.tgz "https://pecl.php.net/get/imagick-${IMAGICK_VERSION}.tgz" \
 && echo "${IMAGICK_SHA256}  /usr/src/imagick.tgz" | sha256sum -c - \
 && mkdir /usr/src/imagick && tar -xzf /usr/src/imagick.tgz -C /usr/src/imagick --strip-components=1 \
 && cd /usr/src/imagick && /usr/local/php83/bin/phpize && ./configure --with-php-config=/usr/local/php83/bin/php-config \
 && make -j"$(nproc)" && make install \
 && rm -rf /usr/src/*
COPY Docker/Php/php.ini /etc/php83/php.ini
COPY Docker/Php/imagick.ini /etc/php83/conf.d/imagick.ini
COPY --from=certificates /certificates/ca.crt /usr/local/share/ca-certificates/troop671-local-ca.crt
RUN update-ca-certificates \
 && useradd --create-home --home-dir /home/dh_vpjbmy --shell /bin/bash dh_vpjbmy \
 && install -d -o dh_vpjbmy -g dh_vpjbmy /home/dh_vpjbmy/.php/8.3/scan /home/dh_vpjbmy/phperrlogs /home/dh_vpjbmy/troop671.com/ISA \
 && ln -s /usr/local/php83/bin/php /usr/local/bin/php
COPY --chown=dh_vpjbmy:dh_vpjbmy Docker/Php/phprc /home/dh_vpjbmy/.php/8.3/phprc
RUN ln -s ../phprc /home/dh_vpjbmy/.php/8.3/scan/phprc.ini
COPY --chmod=0755 Docker/Php/php83-cgi /usr/local/bin/php83-cgi
COPY --chmod=0755 Docker/Php/start-application /usr/local/bin/start-application
COPY Docker/Apache/troop671.com.conf /etc/apache2/sites-available/troop671.com.conf
RUN a2enmod fcgid rewrite headers && a2dissite 000-default && a2ensite troop671.com \
 && sed -i -e 's/^export APACHE_RUN_USER=.*/export APACHE_RUN_USER=dh_vpjbmy/' -e 's/^export APACHE_RUN_GROUP=.*/export APACHE_RUN_GROUP=dh_vpjbmy/' /etc/apache2/envvars \
 && sed -i 's#^ErrorLog .*#ErrorLog /proc/self/fd/2#' /etc/apache2/apache2.conf \
 && chown -R dh_vpjbmy:dh_vpjbmy /var/lib/apache2/fcgid
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
WORKDIR /home/dh_vpjbmy/troop671.com/ISA
COPY --chown=dh_vpjbmy:dh_vpjbmy composer.json composer.lock ./
RUN su dh_vpjbmy -c "php /usr/local/bin/composer install --no-dev --no-interaction --no-progress --classmap-authoritative --no-autoloader" 
COPY --chown=dh_vpjbmy:dh_vpjbmy . .
RUN su dh_vpjbmy -c "php /usr/local/bin/composer dump-autoload --no-dev --classmap-authoritative"
EXPOSE 80
CMD ["/usr/local/bin/start-application"]

FROM mysql:8.0.41 AS database
ENV TZ=America/Los_Angeles
COPY Docker/Mysql/ /docker-entrypoint-initdb.d/
