# [请注意：33号铺停止更新了！](http://yuguo.us/weblog/33pu-stop-update/),最主要的原因是根据[淘宝新规](http://club.alimama.com/read-htm-tid-4369390.html) #

但是cuzy网站利用cuzy发布的WebSDK完善了数据采集的部分，使它继续使用，并正式改名为66号铺

# 66号铺介绍 #
66号铺是一个简单好用的淘宝客瀑布流发布、管理系统。demo：[66号铺](http://66pu.net)

## 联系 ##
遇到问题先看[wiki](http://cuzy2.com/index/show_download_66pu)，再更新到最新版看看问题有无解决，如果还有问题请加QQ群。大家有解决过的问题也可以编辑wiki页，活跃用户提升权限。

代码还在不断完善中，有任何意见和建议：

- 商务QQ：1263572458   QQ群：322622433
- 意见反馈及技术支持邮箱：support@theindex.com   aa@theindex.com
- 新浪微博：[http://weibo.com/cuzysdk?from=profile&wvr=5&loc=infdomain]

## 下载 ##
33pu https://github.com/yuguo/33pu
66pu https://github.com/Jnnnh/66pu 或者 http://cuzy2.com/index/show_download_66pu

或者下载最新的ZIP

## 安装 ##
1. 去cuzy网站(www.cuzy.com) 创建自己的web应用，将得到appkey和appsecret
2. 配置 `application/config/config.php` 为你的站点url，配置 `application/config/site_info.php` 中的站点名称、cuzy的appkey和secretkey
3. 首先自己在数据库中创建一个数据库（比如使用phpmyadmin之类的可视化工具），然后配置 `application/config/database.php` 中的 `username`，`password`，`database`
4. 访问 `站点url/index.php/login/install` ，输入管理员的email和密码
5. 访问 `站点url/index.php/login` 登录
6. 访问 `站点url/index.php/admin/cat` 新增你的站点的商品类别（类别会出现在首页tab中）
7. 访问 `站点url/index.php/admin/cat` 修改类别slug为英文（中文url目前有bug，而且不优雅）
8. 访问 `站点url/index.php/admin` ，选择类别之后搜索关键词，点击某个条目之后再选择图片，条目就会出现在首页（请选择类别之后再搜索关键词，这样条目会自动添加到该类别）
9. 请修改 `application/views/home.php` 底部的统计代码为你自己的百度统计或者Google Analytics.
10.上线后修改index.php 中define('ENVIRONMENT', 'development'); 改成 define('ENVIRONMENT', 'production'); 及生产环境模式，不会报php错误。

## 系统依赖 ##
- php+mysql+webserver(nginx/apache). 其中php要有curl的扩展

## 说明 ##
- 为了帮助更多人，希望你能保留底部的版权，声明站点是由66号铺构建，但这并不是必须的

## 系统架构 ##

- 整站大部分代码是PHP，基于[CodeIgniter](http://codeigniter.org.cn/)构建，CodeIgniter是一个非常适合快速开发的PHP框架。
- 后台UI基于[Bootstrap](http://twitter.github.com/bootstrap/)构建。
- 整站的JS都是基于[jQuery](http://jquery.com/)构建。
- 数据来源于[cuzy](http://www.cuzy.com)。
