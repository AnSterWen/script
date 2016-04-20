<!DOCTYPE html>
<html>
  <head>
    <title>支付失败</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<style type="text/css">
	  .action {
		margin-left:5%;
		height: auto;
		overflow: hidden;	
	  }
	  .button {
		background-color: #eeeeee;
		background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #eeeeee), color-stop(100%, #cccccc));
		background-image: -webkit-linear-gradient(top, #eeeeee, #cccccc);
		background-image: linear-gradient(top, #eeeeee, #cccccc);
		border: 1px solid #ccc;
		border-bottom: 1px solid #bbb;
		border-radius: 3px;
		color: #333;
		padding: 8px 0;
		text-align: center;
		text-shadow: 0 1px 0 #eee;
		width: 95%;
	  }
	</style>
  </head>
  <body>
	<div style="color: #333;font-size: 14px;font:12px/1.125 Arial,Helvetica,sans-serif">
	    <div class="header">
			<h1 style="margin:0px;padding:0px;height:54px;width:127px;background:url(logo.png);overflow:hidden;" title="淘米网络"></h1>
		</div>
		<div class="conent">
<?php
	require_once "../header.php";

	$msg = '支付成功点击返回';
	if (isset($_GET['ErrMsg'])) {
		$msg = $_GET['ErrMsg'];
	} else {
		$mycard = new MycardIngame();
		$post = array();
		$post[] = $_POST['facId'];
		$post[] = $_POST['facMemId'];
		$post[] = $_POST['facTradeSeq'];
		$post[] = $_POST['tradeSeq'];
		$post[] = $_POST['CardId'];
		$post[] = $_POST['oProjNo'];
		$post[] = $_POST['CardKind'];
		$post[] = $_POST['CardPoint'];
		$post[] = $_POST['ReturnMsgNo'];
		$post[] = $_POST['ErrorMsgNo'];
		$post[] = $_POST['ErrorMsg'];

		Log::write($_POST);


		if ($mycard->checkHash($post, $_POST['hash'])) {
			if ($_POST['ReturnMsgNo'] == 1) {
				itemModel::commitTrade($_POST['facTradeSeq'], $_POST['CardPoint']/5.0, 'MYCARD', $_POST['tradeSeq'],$_POST['CardId']);
			} else {
				$msg = 'MyCard支付失败, 错误码为1204，请返回重新支付';
			}
			$cmd = substr($_POST['facTradeSeq'], 0, 2);
		} else {
			$msg = 'MyCard支付失败, 错误码为1204，请返回重新支付';
		}
	}
	echo "<p style=\"margin-bottom:16px;padding-top:2px;text-indent: 2em;\">$msg</p>";
	echo "<div class=\"action\"><button class=\"button\" id=\"click_button\">返回</button></div>";
?>
		</div>
		<div class="footer">
			<center><p style="text-algin=">© 2012 Taomee Inc. All rights reserved.</p></center>
		</div>
	  </div>
  </body>
  <script type="text/javascript">
    function onButtonClickDown() {
	    Mycard.onButtonClickDown();
	}
	function $(id) {
		var obj = null;
		if (id != undefined) {
			obj = document.getElementById(id)
		}
		return obj;
	}
	$("click_button").addEventListener("click", onButtonClickDown);
  </script>
</html>
<?php

