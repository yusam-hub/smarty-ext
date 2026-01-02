#### dockers

    docker exec -it dev-php74 sh -c "cd /var/www/php74/yusam-hub/smarty-ext && exec bash"

    docker exec -it dev-php74 sh -c "cd /var/www/php74/yusam-hub/smarty-ext && composer update"
    docker exec -it dev-php74 sh -c "cd /var/www/php74/yusam-hub/smarty-ext && composer install"
    docker exec -it dev-php74 sh -c "cd /var/www/php74/yusam-hub/smarty-ext && sh phpunit"
    docker exec -it dev-php74 sh -c "cd /var/www/php74/yusam-hub/smarty-ext && git status"
    docker exec -it dev-php74 sh -c "cd /var/www/php74/yusam-hub/smarty-ext && git pull"


    docker exec -it dev-php74 sh -c "cd /var/www/php74/yusam-hub/smarty-ext/public && php index.php"
