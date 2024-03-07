FROM dunglas/frankenphp

RUN install-php-extensions pcntl

RUN apt update && apt install -y supervisor

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && \
   php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
   rm composer-setup.php


COPY . /app

COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /app

EXPOSE 80 443

CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
