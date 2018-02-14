Doctrine UTC Date Time [![На Русском](https://img.shields.io/badge/Перейти_на-Русский-green.svg?style=flat-square)](./README.RU.md)
======================

Introduction
------------

Component contains `DBAL` types for date and time and can be registered as `Doctrine` types. `DBAL` types provides
functionality for storing date and time into database in the `UTC`. List of the available types:

 * [UtcDateTimeType.php](DBAL/Types/UtcDateTimeType.php)
 * [UtcDateType.php](DBAL/Types/UtcDateType.php)
 * [UtcTimeType.php](DBAL/Types/UtcTimeType.php)

Installation
------------

Open a command console, enter your project directory and execute the following command to download the latest stable
version of this component:
```text
    composer require adrenalinkin/doctrine-utc-date-time
```
*This command requires you to have [Composer](https://getcomposer.org) install globally.*

Usage
-----

For registration new `Doctrine` type use official instruction 
[How to Use Doctrine DBAL](https://symfony.com/doc/current/doctrine/dbal.html).

For registration new separate UTC types:

```yaml
# app/config/config.yml
doctrine:
    dbal:
        types:
            utcdate:     Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcDateType
            utcdatetime: Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcDateTimeType
            utctime:     Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcTimeType
```

Also, you can overwrite standard types:

```yaml
# app/config/config.yml
doctrine:
    dbal:
        types:
            date:     Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcDateType
            datetime: Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcDateTimeType
            time:     Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcTimeType
```

License
-------

[![license](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](./LICENSE)
