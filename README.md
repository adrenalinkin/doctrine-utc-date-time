Doctrine UTC Date Time
======================

Компонент предоставляет набор типов времени и даты, которы можно зарегистрировать как тип `Doctrine` и всегда хранить
данные даты и времени в БД в формате `UTC`. В состав входят три типа:

 * [UtcDateTimeType.php](DBAL/Types/UtcDateTimeType.php) - для хранения в `UTC` формате даты и времени.
 * [UtcDateType.php](DBAL/Types/UtcDateType.php) - для хранения в `UTC` формате даты.
 * [UtcTimeType.php](DBAL/Types/UtcTimeType.php) - для хранения в `UTC` формате времени.

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
            utcdate:     Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcDateType
            utcdatetime: Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcDateTimeType
            utctime:     Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcTimeType
```

Также можно переопределить существующие типы храниения времени и даты, добившись автоматического храниения всех дат в
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
