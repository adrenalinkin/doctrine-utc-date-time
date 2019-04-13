Doctrine UTC Date Time [![In English](https://img.shields.io/badge/Switch_To-English-green.svg?style=flat-square)](./README.md)
======================

[![Latest Stable Version](https://poser.pugx.org/adrenalinkin/doctrine-utc-date-time/v/stable)](https://packagist.org/packages/adrenalinkin/doctrine-utc-date-time)
[![Total Downloads](https://poser.pugx.org/adrenalinkin/doctrine-utc-date-time/downloads)](https://packagist.org/packages/adrenalinkin/doctrine-utc-date-time)

Введение
--------

Компонент содержит набор `DBAL` типов времени и даты, которые регистрируются как тип данных `Doctrine`.
Зарегистрированные типы `DBAL` обеспечивают хранение данных даты и времени в базе данных в формате `UTC`.
В состав входят три типа:

 * [UtcDateTimeType.php](DBAL/Types/UtcDateTimeType.php) - для хранения в `UTC` формате даты и времени.
 * [UtcDateType.php](DBAL/Types/UtcDateType.php) - для хранения в `UTC` формате даты.
 * [UtcTimeType.php](DBAL/Types/UtcTimeType.php) - для хранения в `UTC` формате времени.

Установка
---------

Откройте консоль и, перейдя в директорию проекта, выполните следующую команду для загрузки наиболее подходящей
стабильной версии этого компонента:
```bash
    composer require adrenalinkin/doctrine-utc-date-time
```
*Эта команда подразумевает что [Composer](https://getcomposer.org) установлен и доступен глобально.*

Пример использования
--------------------

Для регистрации нового типа данных `Doctrine` необходимо воспользоваться инструкцией, описанной в официальной
документации Symfony [How to Use Doctrine DBAL](https://symfony.com/doc/current/doctrine/dbal.html).

Таким образом, чтобы зарегистрировать новые типы, которые хранят дату и время в `UTC` необходимо добавить
следующую конфигурацию:

```yaml
# app/config/config.yml
doctrine:
    dbal:
        types:
            utc_date:     Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcDateType
            utc_datetime: Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcDateTimeType
            utc_time:     Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcTimeType
```

Также можно переопределить существующие типы хранения времени и даты, добившись автоматического хранения всех дат в
формате `UTC`. Для этого нужно добавить следующие строки в конфигурацию проекта:

```yaml
# app/config/config.yml
doctrine:
    dbal:
        types:
            date:     Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcDateType
            datetime: Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcDateTimeType
            time:     Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcTimeType
```

Лицензия
--------

[![license](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](./LICENSE)
