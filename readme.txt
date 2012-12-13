=== Clear-StatPress ===
Contributors: leniy
Donate link: http://leniy.info/
Tags: comments,stat,statpress,clear
Requires at least: 3.0.1
Tested up to: 3.5
Stable tag: trunk
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl.html

Clear-StatPress:Clear statpress spider mysql log data

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
3. screenshot-3.png

== Changelog ==

=1.0=
Final Release

=0.0.3=
2012.12.13 优化查询语句的变量，减少代码量；修改table的css样式，防止窗口调整大小后无法全部显示；对查询的每一行前添加序列号。

=0.0.2=
2012.12.11 对mysql查询函数做了更新，加入其它一些agent的分析

=0.0.1=
2012.12.11 First version after start learned how to write a plugin.

== Frequently Asked Questions ==

这是对statpress的附加功能

== Upgrade Notice ==

安装或升级前，请确保安装了statpress。