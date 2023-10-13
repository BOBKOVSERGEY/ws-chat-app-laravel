# Breeze
composer require laravel/breeze --dev
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

# create migration m:m
sail artisan make:migration create_chat_user_table
# lesson 
17 Подписка веб сокета в данном чате и альтернатива is_owner

# clone
git clone git@github.com:BOBKOVSERGEY/ws-chat-app-laravel.git
create .env
docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php82-composer:latest \
composer install --ignore-platform-reqs


ctrl alt l format 

# Pusher
composer require pusher/pusher-php-server
npm install --save-dev laravel-echo pusher-js
