RotorCMS 5.0 dev
=========

[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/visavi/rotorcms?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Latest Stable Version](https://poser.pugx.org/visavi/rotorcms/v/stable)](https://packagist.org/packages/visavi/rotorcms)
[![Total Downloads](https://poser.pugx.org/visavi/rotorcms/downloads)](https://packagist.org/packages/visavi/rotorcms)
[![Latest Unstable Version](https://poser.pugx.org/visavi/rotorcms/v/unstable)](https://packagist.org/packages/visavi/rotorcms)
[![License](https://poser.pugx.org/visavi/rotorcms/license)](https://packagist.org/packages/visavi/rotorcms)
[![Build Status](https://travis-ci.org/visavi/rotorcms.svg)](https://travis-ci.org/visavi/rotorcms)

Добро пожаловать!
Мы благодарим Вас за то, что Вы решили использовать наш скрипт для своего сайта. RotorCMS - функционально законченная система управления контентом с открытым кодом написанная на PHP. Она использует базу данных MySQL для хранения содержимого вашего сайта.

**RotorCMS** является гибкой, мощной и интуитивно понятной системой с минимальными требованиями к хостингу, высоким уровнем защиты и является превосходным выбором для построения сайта любой степени сложности

Главной особенностью RotorCMS является низкая нагрузка на системные ресурсы и высокая скорость работы, даже при очень большой аудитории сайта нагрузка на сервер будет минимальной, и вы не будете испытывать каких-либо проблем с отображением информации.

###Действия при первой установке движка RotorCMS

1. Настройте сайт с учетом того что корневая директория `public`, а все остальное лежит ниже корня сайта и недоступно по прямому пути

2. Установите и настройте менеджер зависимостей [Composer](https://getcomposer.org/). Его можно установить глобально и выполнить из консоли команду `composer update` или скачать архив composer.phar и выполнить команду php composer.phar update

3. Установите rotorcms выполнив команду в консоле `composer create-project visavi/rotorcms .`

4. Создайте базу данных и пользователя для нее из панели управления на вашем сервере, во время установки скрипта необходимо будет вписать эти данные для соединения в файл .env

5. Настройте конфигурационный файл .env, окружение, данные для доступа к БД, логин и email администратора и данные для отправки писем, sendmail или smtp

6. Если устанавливаете движое вручную, то переименуйте конфигурационный файл .env.example в .env (Файл не отслеживается git'ом, поэтому на сервере и на локальном сайте могут находится 2 разных файла с разными окружениями APP_ENV=production, development или local)

7. Выполните миграции с помощью консольной команды `php rotor migrate`

8. Вручную залейте данные из файла app/database/data.sql

9. Зарегистрируйтесь и назначьте права `admin` в таблице users поле level

После завершения установки вы сможете посмотреть работу скрипта на главной странице вашего сайта

### Требования

Минимальная версия PHP необходимая для работы движка PHP 5.4 и MySQL 5.6

MySQL 5.6 необходим для полнотектового поиска в БД, поэтому если поиск не нужен, необходимую версию можно понизить путем удаления индексов Fulltext из файлов миграций

### Миграции

Создание миграций `php rotor create CreateTestTable`

Выполнение миграций `php rotor migrate`

Откат последней миграции `php rotor rollback`

### License

The RotorCMS is open-sourced software licensed under the [GPL-3.0 license](http://opensource.org/licenses/GPL-3.0)
