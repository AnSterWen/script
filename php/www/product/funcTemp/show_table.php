<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title><? echo $doctitle ?></title>
		<style type="text/css">
			table {
				margin-left: auto;
				margin-right: auto;
				font-family: verdana,arial,sans-serif;
				font-size:11px;
				color:#333333;
				border-width: 1px;
				border-color: #666666;
				border-collapse: collapse;
			}
			table th {
				border-width: 1px;
				padding: 8px;
				border-style: solid;
				border-color: #666666;
				background-color: #ccc;
			}
			table td {
				border-width: 1px;
				padding: 8px;
				border-style: solid;
				border-color: #666666;
			}
			table tbody tr:nth-child(even) {
				background-color: #eee;
			}


			table tbody tr:nth-child(odd) {
				background-color: #fff;
			}
			.center-text {
				text-align: center;
			}
			.timerange {
				margin-top: 10px;
				font-size: 20;
				color: #ec9393;
			}
			.app-titles {
				position: fixed;
				top: 0;
				left: 0;
				padding: 20px 7px 50px 60px;
				border-right: 1px solid #888;
			}
			.app-title {
				text-align: right;
				list-style-type: none;
			}
			.app-title a {
				text-align: right;
				text-decoration: none;
				list-style-type: none;
			}
			.app-title.active {
				border-radius: 4px;
				background-color: #ccc;
			}
			.view-all {
				width: 70px;
				margin-left: auto;
				margin-right: auto;
			}
		</style>
	</head>
	<body>
		<?
			if (is_null($fields)) {
				$row = $rows[0];

				$fields = array();
				foreach ($row as $field=>$value) {
					$fields[] = $field;
				}
			}
			echo "<ul class=\"app-titles\">";
			foreach ($doctitles as $dbname1=>$appname) {
				$url = $_SERVER['SCRIPT_NAME'] . "?db=$dbname1&type=$type&stime=$stime_str&etime=$etime_str&stat=";
				$active = strcmp($dbname1, $dbname)==0 ? ' active' : '';
				echo "<li class=\"app-title$active\"><a href=\"$url\">$appname</a></li>";
			}
			echo "</ul>";
		?>
		<table>
			<thead>
				<tr>
					<?
						foreach ($fields as $field) {
							if (is_array($field)) {
								$field = $field[0];
							}
							echo "<th>$field</th>";
						}
					?>
				</tr>
			</thead>
			<tbody>
					<?
						foreach ($rows as $row) {
							echo "<tr>";
							foreach ($fields as $field) {
								if (is_array($field)) {
									$fmt = $field[1];
									$field = $field[0];
									$value = $fmt($row[$field]);
								} else {
									$value = $row[$field];
								}
								echo "<td>$value</td>\n";
							}
							echo "</tr>\n";
						}
					?>
			</tbody>
		</table>
		<?
			if ($stat) {
				$url = $_SERVER['SCRIPT_NAME'] . "?db=$dbname&type=$type&stime=$stime_str&etime=$etime_str";
				echo "<div class=\"view-all\"><a href=\"$url\" target=\"_blank\">查看全部</a></div>";
			}
		?>
		<div class='timerange center-text'>
			[
			<?
				echo format_date($stime);
			?>
			,
			<?
				echo format_date($etime);
			?>
			)
		</div>
	</body>
</html>
