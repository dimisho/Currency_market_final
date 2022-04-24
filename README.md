# Currency_market_final

Описание проекта
=====================
Прототип веб-приложения для совершения операций на валютном рынке со следующим функционалом:
1. Регистрация новых пользователей и авторизация. Пользователь вводит имя, почту и пароль. Пароль хешируется и все эти данные хранятся в базе данных вместе с id пользователя (дамп базы данных 'dump.sql' лежит в этом репозитории).
2. Личный кабинет с визуализацией баланса, возможностью его пополнения и возможностью менять имя или почту пользователя.
3. Возможность отслеживать стоимость какой-либо из пяти валют(USD, EUR, UAH, BYN, GBP) в реальном времени с высокой скоростью обновления котировок. Актуальная стоимость валюты берется с официального сайта ЦБ РФ. Стоимость обновляется каждый 5 секунд. Есть возможность посмотреть историю котировок за последние 7 дней и количество имеющихся у пользователя активах.
4. Покупка и продажа валюты по актуальной цене. Покупка и продажа обрабатывается на сервере, а данные о результате операции хранятся в базе данных с id пользователя, который совершал операции.
5. На главном экране "Home" находится раздел "News". В данном разделе две автоматически обновляемые колонки новостей из двух источников "Газета.РУ" и "Ядекс.Новости". Новости обновляются в реальном времени.
6. Если зайти с аккаунта администратора (email: admin@tripled.ru; пароль: bestmarket3D), то станет доступен раздел "Administrator". В данном разделе есть возможность видеть всех зарегистрированных пользователей, блокировать и разблокировать их, менять их статус (only read, client или admin) и создавать новых пользователей.

Условия успешного запуска
-----------------------------------
Проект был сделан при помощи сборки локального веб-сервиса XAMPP. Чтобы запустить корректно работающий веб-сайт на своем сервере, нужно изменить значения в db_conn.php и MySQL.php на свои. Чтобы на вашем сервере были нужные таблицы, в репозитории прикреплен файл "dumpBD.sql" со всеми нужными таблицами и с тестовыми значениями.
Все необходимые файлы, в том числе index.php, db_conn.php и MySQL.php лежат в папке 'final'.
