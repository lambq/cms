# cms

#### 介绍
{**以下是 贸E云基于laravel6.0开发内容管理系统**
贸E云-国内领先的企业级云计算服务提供商。专注公有云技术研发，主要面向广大开发者、政企用户、金融机构等，提供基于智能云服务器的全方位云计算解决方案，为用户提供可信赖的企业级公有云服务。低价云服务器,满足个人/企业站长需求!
[贸E云](https://www.maoeyun.com)}

#### 软件架构
nginx1.22
mysql5.7
php7.2
redis

#### 特地说明

>   联系作者贸E云QQ群:105399710
>   特地说明百度收录效果极佳,尤其是天收录
>   文章采集库,后续开放,希望各位都成为优秀的架构师

#### nginx伪静态

```shell
location = / {
    try_files /page-cache/pc__index__pc.html /index.php?$query_string;
}

location / {
    try_files $uri $uri/ /page-cache/$uri.html /page-cache/$uri.json /page-cache/$uri.xml /index.php?$query_string;
}
```

#### 安装教程

1. 复制.env.example 文件命名成 .env

```shell
cp .env.example .env
```

2.  修改.env文件配置
```php
APP_NAME=中文古今 //网站名称
APP_ENV=local   //不用修改
APP_KEY=base64:w1+fgMokAAc2c6bM8O07NNowdC/3i8/gKVplhdLFpZY= //加密token
APP_DEBUG=true // 可以设置false / true
APP_URL=http://127.0.0.1:8000 // 域名

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cms //数据库名称
DB_USERNAME=cms //数据库用户名
DB_PASSWORD=D7dh4tKK5a4xxXTG  // 数据库密码

BROADCAST_DRIVER=log
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis  // 缓存就用redis 并且seesion cache 分库
SESSION_DRIVER=redis
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

ADMIN_HTTPS=true //后台是否开启 https 访问
IMG_URL=https://imgs.zwgj.com.cn/ //网站图片懒加载设置
IMg_URL_FILE=https://imgs.zwgj.com.cn/files/loading.gif //网站图片懒加载默认图片路径

```
3.  运行生成扩展依赖

```shell
composer update
```

4.  生成数据库表结构
```shell
php artisan admin:install
```

5.  生成laravel框架key
```shell
php artisan key:generate
```
#### 使用说明

1. 数据库填充
```shell
php artisan db:seed
```

2. 数据库回归所有迁移
```shell
php artisan migrate:reset
```

3. 数据库运行迁移
```shell
php artisan migrate
```

#### 脚手架工具箱

1.  任务调度包含生成站点地图txt文件,定时清理缓存html文件,定时获取文章库里面的文章 加入系统定时任务命令如下
```shell
php /www/wwwroot/系统绝对路径/artisan schedule:run >> /dev/null 2>&1
```

2.  手动生成站点地图txt文件命令如下
```shell
php artisan dig:sitetxt
```
3.  tools命令工具  用于批量修改数据库图片,关键词,清空文章内容redis缓存等,命令如下,
```shell
php artisan tools img|tags|cache
```

3.  批量修改文章内容页面关键词,命令如下,
```shell
php artisan queryHtml list|show
```

4.  封装函数库,路径如下
```shell
app/Helpers/function.php
```