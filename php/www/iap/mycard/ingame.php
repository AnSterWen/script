<?
require_once ("../header.php");
require_once ("wdb_pdo.class.php");
$mycard = new MycardIngame();
$cardId = $_REQUEST['CardId'];
$cardPwd = $_REQUEST['CardPwd'];
$authCode = $_REQUEST['AuthCode'];
$facMemId = $_REQUEST['userid'];
$ret = $mycard->confirm($cardId, $cardPwd, $authCode, $facMemId);
Log::write($ret);
if ($ret['ReturnMsgNo'] == 1) {
	itemModel::commitTrade($ret['facTradeSeq'], $ret['CardPoint']/5, 'MYCARD', $ret['SaveSeq'], $cardId);

	$dsn = WDB_PDO::build_dsn('token_conf', '192.168.21.134', 3306);
	$db = new WDB_PDO($dsn, 'wireless', 'wireless@pwd$ta0mee', 'latin1');

	$cardId = mysql_escape_string($cardId);
	$trade_time = time();
	$logid = intval(substr($ret['facTradeSeq'], 8, 8), 16);
	$product_id = intval(substr($ret['facTradeSeq'], 0, 8), 16);
	$mycard_no = mysql_escape_string($ret['SaveSeq']);
	$sql = "insert into t_mycard_ingame_history(cardid,trade_time,logid, product_id, mycard_no, mycard_custid) values(\"$cardId\", $trade_time, $logid, $product_id, \"$mycard_no\", \"$facMemId\");";
	$db->execute($sql, WDB_PDO::SQL_RETURN_TYPE_EXEC, array());
}

echo json_encode($ret);
