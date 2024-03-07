FROM dunglas/frankenphp

RUN install-php-extensions pcntl

RUN apt update && apt install -y supervisor

COPY . /app

COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /app

EXPOSE 80 443

CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
