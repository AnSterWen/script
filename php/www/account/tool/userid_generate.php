#!/usr/bin/php5
<?php
date_default_timezone_set('Asia/Taipei');

require_once(dirname(dirname(__FILE__)) . "/model/userid.gen.class.php");

define("ACCOUNT_MAX_USER_COUNT", 1000000);


if ($argc != 3) {
    echo "Usage: {$argv[0]}\tchannel_id\tgen_user_count\n";
    return;
}
$channel_id = $argv[1];
$user_count = $argv[2];
$channel_name = "";
$security_code = "";

global $g_logger;
$g_logger = new Log("account_userid_gen_", LOG_DIR);
write_log("info", __FILE__, __FUNCTION__, __LINE__, "[userid generate start]");

$gen_handler = new c_userid_generator($channel_id, $channel_name, $security_code, $user_count);

$result = $gen_handler->start_generate_userid();
if ($result != ACCOUNT_ERR_OK) {
    echo "start_generate_userid failed\n";
    write_log("info", __FILE__, __FUNCTION__, __LINE__, "start_generate_userid() failed");
}

write_log("info", __FILE__, __FUNCTION__, __LINE__, "[userid generate end]");

?>
