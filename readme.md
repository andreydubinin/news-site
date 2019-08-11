#Установка
1) git clone
2) composer install
3) копирование .env в .env.local
4) прописать доступы к бд в .env.local
5) bin/console doctrine:schema:create
6) bin/console doctrine:fixtures:load
7) bin/console server:run