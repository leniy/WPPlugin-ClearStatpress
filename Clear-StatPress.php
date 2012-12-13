<?php
/*
	Plugin Name: Clear-StatPress
	Plugin URI: http://leniy.info/clear-statpress.html
	Description: 我安装的statpress插件，虽然设置了不记录蜘蛛访问记录，但有些不表明身份的蜘蛛的访问数据仍然会保存，严重占用数据库空间。登陆后台phpmyadmin太麻烦了，刚刚粗略的学习了下插件制作，写了个简单的插件，执行清理作业。
	Version: 1.0
	Author: leniy
	Author URI: http://leniy.info/
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

add_action('admin_menu', 'qw_CSP_menu');

function qw_CSP_menu() {
	add_options_page('Clear-StatPress', 'Clear-StatPress', 'administrator', 'Clear-StatPress.php', 'qw_CSP_page');
}

function qw_CSP_page() {
	echo "<h2>Clear-StatPress</h2>";
	CSP_sql_del();
}

function CSP_sql_del() {
	global $wpdb;
	$query_temp = "
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
OR  `agent` LIKE  '%bot%'
OR  `agent` LIKE  '%http%'
OR ( `urlrequested` =  '' AND  `statuscode` =  '' AND  `referrer` =  '')
OR ( `urlrequested` =  '' AND  `referrer` =  ''  AND  `browser` =  '' AND  `os` =  '')
";
	$query_sel = "SELECT* FROM " . $wpdb->prefix . 'statpress '." WHERE " . $query_temp;
	$query_del = "DELETE  FROM " . $wpdb->prefix . 'statpress '." WHERE " . $query_temp;

	$output = $wpdb->get_results($query_sel);
	echo "找到如下待删除项目：<br>";
	echo "<div class=\"datagrid\"><table>
<!--	<colgroup>
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
-->	<thead><tr>
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
?>
<style text="text/css">
.datagrid table {
	border-collapse: collapse;
	text-align: left;
	width: 100%;
}
.datagrid {
	width: 99%;
/*	overflow-x: scroll；*/
	font: normal 12px/150% Arial, Helvetica, sans-serif;
	background: #fff;
	overflow: hidden;
	border: 1px solid #006699;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}
.datagrid table td, .datagrid table th {
	padding: 0px 5px;
}
.datagrid table thead th {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #006699), color-stop(1, #00557F) );
	background:-moz-linear-gradient( center top, #006699 5%, #00557F 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#006699', endColorstr='#00557F');
	background-color:#006699;
	color:#FFFFFF;
	font-size: 15px;
	font-weight: bold;
	border-left: 1px solid #0070A8;
}
.datagrid table thead th:first-child {
	border: none;
}
.datagrid table tbody td {
	color: #00557F;
	border-left: 2px solid #E1EEF4;
	font-size: 12px;font-weight: normal;
}
.datagrid table tbody .alt td {
	background: #E1EEF4;
	color: #00557F;
}
.datagrid table tbody td:first-child {
	border-left: none;
}
.datagrid table tbody tr:last-child td {
	border-bottom: none;
}
/*.colno{width: 100%;};
.colid{width: 100%;};
.coldate{width: 100%;};
.coltime{width: 100%;};
.colip{width: 100%;};
.colurlrequested{width: 100%;};
.colstatuscode{width: 100%;};
.colagent{width: 100%;};
.colreferrer{width: 100px;};
.colsearch{width: 100%;};
.colnation{width: 100%;};*/
</style>
<?php
	//这儿开始执行删除操作
	$wpdb->query($query_del);
	echo "<br>删除成功";

}

?>