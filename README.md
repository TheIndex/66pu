Last update 2013.8.21


![alt tag](https://raw.github.com/TheIndex/66pu/master/pic/1.png)
# 66号铺介绍 #
66号铺是基于33号铺的代码和cuzysdk（购物导航sdk）的数据的一个导购系统。关于33号铺（33pu）的更多信息可以到https://github.com/yuguo/33pu 中查看。


33号铺由于淘宝的政策原因停止更新

但是cuzy网站利用cuzy发布的WebSDK完善了数据采集的部分，使它继续使用，并正式改名为66号铺，在这里感谢33pu的创建者yuguo

demo：[66号铺](http://66pu.net)

cuzysdk（www.cuzy.com） 是一个手机淘宝客sdk，通过使用cuzy，可以获取taobao平台的推广商品数据，移动开发者把推广的商品数据呈现给用户，用户完成商品的购买，开发者从中获取推广费用，从而达到将流量变现的目的。
cuzySDK是一个移动开发者提供淘宝客模块的平台。开发者通过使用cuzy，可以便捷的集成到各移动平台，方便的删选推荐物品，高效的转换流量。
   




## 联系 ##
遇到问题先看[wiki](http://cuzy.com/index/show_download_66pu)，再更新到最新版看看问题有无解决，如果还有问题请加QQ群。大家有解决过的问题也可以编辑wiki页，活跃用户提升权限。

代码还在不断完善中，有任何意见和建议：

- 商务QQ：1263572458   QQ群：322622433
- 意见反馈及技术支持邮箱：support@theindex.com   aa@theindex.com
- 新浪微博：[http://weibo.com/cuzysdk?from=profile&wvr=5&loc=infdomain]

## 下载 ##

33pu https://github.com/yuguo/33pu

66pu https://github.com/TheIndex/66pu 

或者 

http://cuzy.com/index/show_download_66pu

或者下载最新的ZIP

## 安装 ##
1. 去cuzy网站(www.cuzy.com) 创建自己的web应用，将得到appkey和appsecret
2. 配置 `application/config/config.php` 为你的站点url，配置 `application/config/site_info.php` 中的站点名称、cuzy的appkey和secretkey
3. 首先自己在数据库中创建一个数据库（比如使用phpmyadmin之类的可视化工具），然后配置 `application/database` 中的 `username`，`password`，`database`
4. 访问 `站点url/index.php/login/install` ，输入管理员的email和密码
5. 访问 `站点url/index.php/login` 登录
6. 访问 `站点url/index.php/admin/cat` 新增你的站点的商品类别（类别会出现在首页tab中）
7. 访问 `站点url/index.php/admin/cat` 修改类别slug为英文（中文url目前有bug，而且不优雅）
8. 访问 `站点url/index.php/admin` ，选择类别之后搜索关键词，点击某个条目之后再选择图片，条目就会出现在首页（请选择类别之后再搜索关键词，这样条目会自动添加到该类别）
9. 请修改 `application/views/home.php` 底部的统计代码为你自己的百度统计或者Google Analytics.

## 说明 ##
- 为了帮助更多人，希望你能保留底部的版权，声明站点是由66号铺构建，但这并不是必须的

## 系统架构 ##

- 整站大部分代码是PHP，基于[CodeIgniter](http://codeigniter.org.cn/)构建，CodeIgniter是一个非常适合快速开发的PHP框架。
- 后台UI基于[Bootstrap](http://twitter.github.com/bootstrap/)构建。
- 整站的JS都是基于[jQuery](http://jquery.com/)构建。
- 数据来源于[cuzy](http://www.cuzy.com)。

