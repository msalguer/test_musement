FROM kirschbaumdevelopment/laravel-test-runner

RUN apt-get update && apt-get upgrade -y

RUN apt-get install git -y

WORKDIR /app
RUN git clone https://github.com/msalguer/test_musement.git
WORKDIR /app/test_musement

RUN apt install wget \
    && wget https://getcomposer.org/composer.phar \
    && chmod +x ./composer.phar \
    && mv ./composer.phar /usr/bin/composer \
    && composer --version

RUN  wget https://get.symfony.com/cli/installer -O - | bash \
	&& export PATH="$HOME/.symfony/bin:$PATH" \
	&& mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN composer install #--no-plugins --no-scripts

RUN composer require symfony/web-server-bundle

EXPOSE 8000
CMD symfony server:start
