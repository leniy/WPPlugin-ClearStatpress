=== Clear StatPress ===
Contributors: leniy
Tags: comments,stat,statpress,clear,statpresscn,mysql,sql,clean
Requires at least: 3.0
Tested up to: 3.5
Stable tag: trunk
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl.html

Clear statpress mysql log data etc.

== Description ==

我安装的statpress插件，虽然设置了不记录蜘蛛访问记录，但有些不表明身份的蜘蛛的访问数据仍然会保存，严重占用数据库空间。
登陆后台phpmyadmin太麻烦了，刚刚粗略的学习了下插件制作，写了个简单的插件，执行清理作业。

== Installation ==

1. Copy Clear-StatPress.zip to your Wordpress plugins directory, usually `wp-content/plugins/` and unzip the file.  It will create a `wp-content/plugins/Clear-StatPress/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Follow the Clear-StatPress page under options.
4. Then, just follow the Clear-StatPress page under options.

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png

== Changelog ==

= 1.2 =

* 2012.12.24
* 修正sql查询语句，避免由搜索引擎直接跳转到tag等页面时，会被误删的情况。
* 在页面最下方的“请确认是否执行删除操作，删除按钮位于页面最顶端”，增加跳转链接，点击直接跳转到页面顶端按钮处，方便用户操作。
* 首先加载css，避免数据较多时页面的美观

= 1.1 =

* 2012.12.18
* 不再直接删除数据库中符合条件的数据。增加确认按钮，由用户确认是否删除。
* Fix bug: Miss ")" after "OR ( `agent` LIKE  '%http%' AND `agent` NOT LIKE  '%liferea%'"

= 1.0.1 =

* 2012.12.17
* 添加UserAgent包含"spide"的记录检索
* 添加UserAgent包含"PHP/"的记录检索
* 对于虽然UA包含http，但同时包含"liferea"的记录，取消检索。因为liferea是一款rss阅读器，不算是蜘蛛机器人
* Change "statpress" to "statpresscn"

= 1.0 =

* 2012.12.13
* Final Release
* 优化查询语句的变量，减少代码量；修改table的css样式，防止窗口调整大小后无法全部显示；对查询的每一行前添加序列号。

= 0.0.1 =

* 2012.12.11
* First version after start learned how to write a plugin.
* 对mysql查询函数做了更新，加入其它一些agent的分析

== Frequently Asked Questions ==

这是对statpress的附加功能

== Upgrade Notice ==

安装或升级前，请确保安装了statpress。