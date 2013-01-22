<?php
/*
	Plugin Name: Clear StatPress
	Plugin URI: http://blog.leniy.info/clear-statpress.html
	Description: 我安装的statpress插件，虽然设置了不记录蜘蛛访问记录，但有些不表明身份的蜘蛛的访问数据仍然会保存，严重占用数据库空间。登陆后台phpmyadmin太麻烦了，刚刚粗略的学习了下插件制作，写了个简单的插件，执行清理作业。
	Version: 1.3.1
	Author: leniy
	Author URI: http://blog.leniy.info/
*/

/*  Copyright 2012 Leniy (m@leniy.info)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$thisplugin_author = "Leniy";
$thisplugin_url = "http://blog.leniy.info/clear-statpress.html";
$thisplugin_name = "Clear StatPress";
$thisplugin_version = "1.3";

add_action('admin_menu', 'qw_CSP_menu');

function qw_CSP_menu() {
	add_options_page('Clear-StatPress', 'Clear-StatPress', 'administrator', 'Clear-StatPress.php', 'qw_CSP_page');
}

function qw_CSP_page() {
	echo "<div id=\"CSPbutton\"></div><h2>Clear-StatPress</h2>";
	CSP_sql_del();
}

function CSP_sql_del() {
	global $wpdb;
//下面的是查询规则，及sql语句where后面的部分
	$query_temp = "
	`agent` LIKE  '%bot%'
	OR (
		`search` =  ''
		AND (
			`urlrequested` LIKE  '%/page%'
		OR  `urlrequested` LIKE  '%/tag%'
		OR  `urlrequested` LIKE  '%/category%'
		OR  `urlrequested` LIKE  '%/2006%'
		OR  `urlrequested` LIKE  '%/2007%'
		OR  `urlrequested` LIKE  '%/2008%'
		OR  `urlrequested` LIKE  '%/2009%'
		OR  `urlrequested` LIKE  '%/2010%'
		OR  `urlrequested` LIKE  '%/2011%'
		OR  `urlrequested` LIKE  '%/2012%'
		OR  `urlrequested` LIKE  '%/2013%'
			)
		)
	OR  `agent` LIKE  '%PHP/%'
	OR (
			`agent` LIKE  '%http%'
		AND `agent` NOT LIKE  '%liferea%'
		AND `agent` NOT LIKE  '%google%'
		AND `agent` NOT LIKE  '%sixxs%'
		AND `agent` NOT LIKE  '%bsalsa%'
		)
	OR  `agent` LIKE  '%spide%'
	OR (
			`urlrequested` =  ''
		AND `statuscode` =  ''
		AND `referrer` =  ''
		)
	OR (
			`urlrequested` =  ''
		AND `referrer` =  ''
		AND `browser` =  ''
		AND `os` =  ''
		)
";
//然后生成查询和删除的完整语句
	$query_sel = "SELECT* FROM " . $wpdb->prefix . 'statpress '." WHERE " . $query_temp;
	$query_del = "DELETE  FROM " . $wpdb->prefix . 'statpress '." WHERE " . $query_temp;

	$output = $wpdb->get_results($query_sel);

//首先加载css样式
echo '<link type="text/css" rel="stylesheet" href="' . plugins_url('clear-statpress/css/leniy_csp.css') . '" />';

//然后开始显示确认删除按钮
global $thisplugin_author;
global $thisplugin_url;
	echo "
	<table>
		<td>找到如下待删除项目：</td>
		<td><form method=\"post\"><input type=\"submit\" name=\"confirmdel\" value=\"确认删除\" class=\"button-primary\" /></form></td>
		<td>联系作者：<a href=\"" . $thisplugin_url . "\" target=\"_blank\">" . $thisplugin_author . "</a></td>
	</table>
	<br>";

//下面是查询到的详细数据
	echo "<div class=\"datagrid\"><table>
	<colgroup>
		<col class=\"colno\" />
		<col class=\"colid\" />
		<col class=\"coldate\" />
		<col class=\"coltime\" />
		<col class=\"colip\" />
		<col class=\"colurlrequested\" />
		<col class=\"colstatuscode\" />
		<col class=\"colagent\" />
		<col class=\"colreferrer\" />
		<col class=\"colsearch\" />
		<col class=\"colnation\" />
	</colgroup>
	<thead><tr>
		<th>No.</th>
		<th>id</th>
		<th>date</th>
		<th>time</th>
		<th>ip</th>
		<th>urlrequested</th>
		<th>statuscode</th>
		<th>agent</th>
		<th>referrer</th>
		<th>search</th>
		<th>nation</th>
	</tr></thead>

	<tbody>";
	$tempcolor = 0;//用来使表格两行背景颜色不同
	$tempNo = 1;//用来记录第几行
	foreach ($output as $o) {
		if($tempcolor == 0) { echo "<tr>"; $tempcolor = 1;}
		else { echo "<tr class=\"alt\">"; $tempcolor = 0;}
		echo "<td>" . $tempNo . "</td>";
		$tempNo = $tempNo + 1;
		echo "<td style=\"word-break:break-all;\">" . $o->id . "</td>";
		echo "<td style=\"word-break:break-all;\">" . $o->date . "</td>";
		echo "<td style=\"word-break:break-all;\">" . $o->time . "</td>";
		echo "<td style=\"word-break:break-all;\">" . $o->ip . "</td>";
		echo "<td style=\"word-break:break-all;max-width:200px;\">" . $o->urlrequested . "</td>";
		echo "<td style=\"word-break:break-all;\">" . $o->statuscode . "</td>";
		echo "<td style=\"word-break:break-all;max-width:200px;\">" . $o->agent . "</td>";
		echo "<td style=\"word-break:break-all;max-width:200px;\">" . $o->referrer . "</td>";
		echo "<td style=\"word-break:break-all;\">" . $o->search . "</td>";
		echo "<td style=\"word-break:break-all;\">" . $o->nation . "</td>";
		echo "</tr>";
	}
	echo "</tbody></table></div>";


	//这儿开始执行删除操作
	if($_POST['confirmdel'] != "") {
		$wpdb->query($query_del);
		echo "<br>删除成功";
	}
	else {
		echo "<br>请确认是否执行删除操作，删除按钮位于页面最顶端：<a href=\"#CSPbutton\">点击跳转到按钮位置</a>";
	}
}

?>
