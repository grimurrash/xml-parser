## Настройка

Для запуска необходимо иметь на компьютере PHP выше 7.3 и composer.

Устанавливаем через composer библиотеки:

```
composer install
```

Создаём в корневой папке файл .env, вставляем туда данные для подключения к базе данных:

```
DB_CONNECTION=mysql
DB_HOST={host}
DB_PORT={port}
DB_DATABASE={database_name}
DB_USERNAME={username}
DB_PASSWORD={password}
```

Вместо ```{host}```, ```{port}```, ``{database_name}``, ``{username}``, ``{password}`` указываем свои данные.

Запускаем миграцию:

```
php artisan migrate 
```

## Добавление файла по умолчанию

Для работы команды без указания пути до файла закидываем в папку ``./storage/app/public/`` файл по умолчанию.
Переименовываем его в ``default_parser_data.xml``.


## Использование парсера

Без указания пути до файла

```
php artisan vehicle:parse 
```

С указанием пути до файла

```
php artisan vehicle:parse "path"
```
