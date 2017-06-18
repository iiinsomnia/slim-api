# slim-api

基于Slim3封装，用于API开发

### 特点

* 使用Laravel/Database、MongoDB、Predis
* 支持CLI-Command，用于crontab
* 支持.env环境配置
* 全部操作均使用依赖注入
* 支持邮件推送系统错误日志
* 内置登录和验签模块

### 使用：

```sh
# get the framework and dependency libraries
composer update
```

```sh
# cli-command
php cli greet IIInsomnia

# output
Hello IIInsomnia
```

```sh
# display help message
php cli greet -h
```

### 备注

* 服务器虚拟目录指向 `public` 目录
* 确保 `logs` 目录可写
* 内置MySQL、Mongo、Redis使用示例
* 签名规则：请求URL(不包括域名) + 用户登录token + 请求时间戳，取md5值

### 参考

* [Slim](http://www.slimphp.net/)
* [Laravel/Database](https://laravel.com/docs/5.4/database)
* [MongoDB](https://docs.mongodb.com/php-library/master/tutorial/)
* [Predis](https://packagist.org/packages/predis/predis)
* [CLI-Command](http://symfony.com/doc/current/components/console.html)