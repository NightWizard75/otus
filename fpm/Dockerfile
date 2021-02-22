FROM php:8.0-fpm
# ставим необходимые для нормальной работы модули
RUN apt update && apt install -y \
	# в php 8.0 вроде бы уже установлен pecl
	# pecl && docker-php-ext-enable \
    curl \
    wget \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmcrypt-dev \
	# нужен для memprof
    libjudy-dev \
    # для memcached
    libmemcached11 \
    libmemcachedutil2 \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    # не работают с php =>8.0
    # && pecl install mcrypt-1.0.3 \
	# && docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd \
	# устанавливаем расширение для работы с postgresql
	&& docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql \
    # копируем настройки для работы при разработке (куча нотисов и ванингов)
    && mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
# устанавливаем расширения PhpRedis, memprof, memcached
RUN pecl install xdebug \
        redis \
        memcached \
        memprof \
	    && docker-php-ext-enable xdebug \
	# пока все настройки прописаны в php.ini. Потом надо будет все расскомментировать здесь. А php.ini отключить в .yaml - убрать проброс папки для конфигурации
        && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        # && echo "xdebug.mode=develop" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.client_port = 9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	# след. строкой пытаемся установить возможность через ссылку попадать сразу в место ошибки
	    && echo "xdebug.file_link_format = phpstorm://open?%f:%l" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        # && echo "xdebug.log = /var/www/html/otus.loc/log/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.force_display_errors = on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "max_execution_time = 1000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "max_input_time = 1000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    # устанавливаем файл настроек для redis
       	&& docker-php-ext-enable redis \
       	&& echo "extension=redis.so" >> $PHP_INI_DIR/php.ini \
        && docker-php-ext-enable memcached \
        && docker-php-ext-enable memprof
# создаем файл для профилирования памяти. Без него отказывается работать memprof
RUN touch /tmp/profile.heap

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# оставил, чтобы не забыть как создавать папки
# RUN ["mkdir", "../tmp"]
# RUN ["mkdir", "/app"]

# при пробросе папок в форме записи соответсвия сначала идет папка из хоста, потом из контейнера
# в данном случае устанавливается соответсвие между папкой code, находящейся на уровень выше,
# чем Dockerfile  и /var/www/html/otus.loc в конейнере
# при использовании docker-compose все пробросы лучше прописать в docker-compose.yaml
# так же надо учесть, что папка из хоста сделается основной и заместит ту, что находится в докере
# какая-то шняга с пробросом надо бы разобраться. Не видит папку источник. Только если настраивать в docker-compose.yaml
# там видит
# VOLUME ./code:/var/www/html/otus.loc
# VOLUME C:\MyWork\Docker\Otus\fpm\conf\php\:/var/www/html/otus.loc
# пробрасываем файл конфигурации php.ini (по умолчанию его нужно скопировать в php.ini-production)
# VOLUME ./conf/php:/usr/local/etc/php

# устанавливаем рабочую директорию
WORKDIR /var/www/html

CMD ["php-fpm"]