FROM debian:buster-slim
# ставим необходимые для нормальной работы модули
RUN apt update && apt install -y \
        wget \
        gcc \
        make
# устанавливаем рабочую директорию
WORKDIR /tmp

# Устанавливаем REDIS
RUN wget http://download.redis.io/redis-stable.tar.gz \
	&& tar xvzf redis-stable.tar.gz \
	&& cd redis-stable \
	&& make \
	&& make install

WORKDIR /usr/local
CMD ["redis-server", "./etc/redis/redis.conf"]