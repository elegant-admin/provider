<p align="center">⛵<code>elegant-admin</code> is administrative interface builder for laravel which can help you build CRUD backends just with few lines of code.</p>

<p align="center">
<a href="https://elegant-admin.github.io/docs-en">Documentation</a> |
<a href="https://elegant-admin.github.io/docs-cn">中文文档（GitHub）</a> |
<a href="https://elegant-admin.gitee.io/docs-cn">中文文档（码云）</a>
</p>

Based on the upgraded version of [laravel-admin](https://github.com/z-song/laravel-admin), various problems have been fixed and new features have been added,Any questions are welcome[issues](https://github.com/elegant-admin/provider/issues)

基于[laravel-admin](https://github.com/z-song/laravel-admin) 的升级版，修复了各种问题，新增功能，有任何问题，欢迎[issues](https://github.com/elegant-admin/provider/issues)

For upgrades, see the Release Discovery Notes [releases](https://github.com/elegant-admin/provider/releases)

升级内容请查看版本发现说明 [releases](https://github.com/elegant-admin/provider/releases)

## Requirements

 - PHP >= 7.0.0
 - Laravel >= 8.*
 - Fileinfo PHP Extension

## Installation

First, install laravel 8.*, and make sure that the database connection settings are correct.

```shell
composer require elegant-admin/provider:1.*
```

Then run these commands to publish assets and config：

```shell
php artisan vendor:publish --provider="Elegant\Admin\AdminServiceProvider"
```
After run command you can find config file in `config/admin.php`, in this file you can change the install directory,db connection or table names.

At last run following command to finish install.

```shell
php artisan admin:install
```

Open `http://localhost/admin/` in browser,use username `admin` and password `admin` to login.

## Configurations

The file `config/admin.php` contains an array of configurations, you can find the default configurations in there.

## License

`elegant-admin` is licensed under [The MIT License (MIT)](LICENSE).
