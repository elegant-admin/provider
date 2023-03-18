# Based on the upgraded version of [laravel-admin](https://github.com/z-song/laravel-admin), various problems have been fixed and new features have been added,Any questions are welcome[issues](https://github.com/elegant-admin/provider/issues)

# 基于[laravel-admin](https://github.com/z-song/laravel-admin) 的升级版，修复了各种问题，新增功能，有任何问题，欢迎[issues](https://github.com/elegant-admin/provider/issues)

## The changes are as follows 改动如下

- Automatically generate permission controls that are entirely route-based
- 自动生成完全基于路由的权限控制
  

- When an administrator selects a role, they can configure the maximum number of roles
- 管理员选择角色时，可配置最大角色数量
  

- Localization support is more friendly
- 本地化支持更友好
  

- Optimize configuration files (custom configurationMore )
- 优化配置文件（自定义配置更多）
  

- Optimize styling and user experience
- 优化样式和用户体验
  

- Support for soft delete (added restore and force delete operations)
- 对软删除的支持（增加恢复和强制删除操作）
  

- Implement the Model Tree action buttons as in tables (icon configuration required)
- 实现模型树操作按钮与表格一样（需要图标配置）
  

- When you implement model tree editing, you can edit specified fields, configure the maximum hierarchical relationship, and configure the default collapse
- 实现模型树编辑时可只编辑指定字段，可配置最大层级关系，可配置默认折叠
  

- Implement the same pattern as the head navigation bar action button as the table button (icon configuration required)
- 实现头部导航条操作按钮与表格按钮相同模式（需要图标配置）
  

- The editor has been restored to usability and resolved errors in relational mode
- 编辑器已恢复可使用且解决了关系模式下的错误
  

- Optimized file upload, multiple files can be deleted, sorted, and added simultaneous operations
- 优化文件上传，多文件可以删除，排序，新增同时操作
  

- Form switch component, radio component, multi-select component supports post-action script '->change after()'
- 表单开关组件，单选组件，多选组件支持操作后脚本`->changeAfter()`
  

- Forms implement complex layouts, and the 'form->horizontal()' method restores the original layout
- 表单实现复杂布局，`$form->horizontal()`方法可恢复原来的布局
  

- Forms implement both narrow and widescreen, and the 'form->disable Container()' method enables widescreen
- 表单实现窄屏和宽屏，`$form->disableContainer()`方法可实现宽屏

## 复杂表单配置

```php
use Elegant\Admin\Form;


$form->row(function (Form\Layout\Row $row) {
    $row->text('text', 'Text');
    $row->column(3, function (Form\Layout\Column $column) {
        $column->text('text1', 'Text1');
        $column->radio('text2', 'Text2')->options([0 => '0', 1 => '1'])
            ->when(1, function () use ($column) {
                $column->text('text3', 'Text3');
            });
    });
});
```

## 关于action配置

## 用户复制action配置示例

## 一，设置路由，开启授权控制

```php
$router->post('users/{user}/replicate', 'UserController@replicate')->name('users.replicate');
```

## 二，设置方法

```php
namespace App\Admin\Controllers;
use Elegant\Admin\Controllers\AdminController;
use App\Models\User;

class UserController  extends AdminController
{
  public function replicate($id)
  {
      // 方法一，在这里执行逻辑（推荐使用，安全性高）
      try {
          $model = User::find($id);
          DB::transaction(function () use ($model) {
              $model->replicate()->save();
          });
      } catch (\Exception $exception) {
          return $this->response()->error("复制失败: {$exception->getMessage()}")->send();
      }

      return $this->response()->success('复制成功')->refresh()->send();

      // 方法二，去操作类中执行逻辑（存在安全风险，可未授权执行逻辑）
      return $this->handleAction();
  }
}
```

## 三，设置操作类

```php
namespace App\Admin\Actions;
    
use Elegant\Admin\Actions\RowAction;
//use Elegant\Admin\Actions\TreeAction;// 模型树操作请继承此类
//use Elegant\Admin\Actions\NavAction;// 头部导航条操作请继承此类
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
    
class Replicate extends RowAction
{
    /**
     * @var string
     */
    protected $method = 'POST';

    /**
     * @return array|null|string
     */
    public function name()
    {
        return '复制';
    }

    /**
     * 如果是模型树和头部导航条操作，需要此方法
     * @return string
     */
    //protected function icon()
    //{
    //    return 'fa-bars';
    //}

    /**
     * 如果没有此方法，将不会有权限的控制
     * @return string
     */
    public function getHandleRoute()
    {
        // 这里配置路由的路径
        return "{$this->getResource()}/{$this->getKey()}/replicate";
    }

    /**
     * 这是方法二的逻辑
     * @param Model $model
     *
     * @return \Elegant\Admin\Actions\Response
     */
    //public function handle(Model $model)
    //{
    //    try {
    //        DB::transaction(function () use ($model) {
    //            $model->replicate()->save();
    //        });
    //    } catch (\Exception $exception) {
    //        return $this->response()->error("复制失败: {$exception->getMessage()}");
    //    }
    //
    //    return $this->response()->success("复制成功")->refresh();
    //}

    /**
     * @return void
     */
    public function dialog()
    {
        $this->question('确认复制？', '', ['confirmButtonColor' => '#d33']);
    }
}
```

<p align="center">⛵<code>elegant-admin</code> is administrative interface builder for laravel which can help you build CRUD backends just with few lines of code.</p>

<p align="center">
<a href="https://elegant-admin.github.io/docs-en">Documentation</a> |
<a href="https://elegant-admin.github.io/docs-cn">中文文档（GitHub）</a> |
<a href="https://elegant-admin.gitee.io/docs-cn">中文文档（码云）</a>
</p>

## Requirements

 - PHP >= 7.0.0
 - Laravel >= 8.*
 - Fileinfo PHP Extension

## Installation

> This package requires PHP 7+ and Laravel 8.*

First, install laravel 8.*, and make sure that the database connection settings are correct.

```shell
composer require explore/elegant-admin:1.*
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
