# slim-api

SlimFramework整合NotORM、MongoDB、Predis，用于API开发，支持CLI-Command

### 使用：

```sh
#get the framework and dependency libraries
composer update
```

```sh
#cli-command
php cli greet IIInsomnia

#output
Hello IIInsomnia
```

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writeable.

### 参考
* [NotORM](http://www.notorm.com/)
* [MongoDB](https://docs.mongodb.com/php-library/master/tutorial/)
* [Predis](https://packagist.org/packages/predis/predis)
* [CLI-Command](http://symfony.com/doc/current/components/console.html)


