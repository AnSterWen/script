<?php
/* 用户ID转换配置 */
// define('UID_CHANGE_URL','http://192.168.68.225/platform/accountMap/account_map.php');
// define('UID_CHANGE_SIGN','7af1ebd05e55fd2bbf196d40db01cedb');
// define('UID_CHANGE_KEY','Qd3GcDvVKj4YuLbX');
// define('IGG_GAMELOG_URL', 'http://192.168.68.225/platform/webserver/igg_gamelog.php');
// define('IGG_GAMELOG_KEY','cdfef1d6d6119a51aa0c950eaaf3ee19');

/* 日志目录 */
define ('LOGGER_DIR',           dirname(dirname(__FILE__)) . '/log');

/* 统计日志路径 */
define ('MSGLOG_PATH',          dirname(__FILE__) . '/../stat/service.bin');

define('ACCOUNT_DEFAULT_KEY','7b6ded9322c8d56768a4245ea4684523');
$g_allow_games = array(
        'ahero'  =>  '7b6ded9322c8d56768a4245ea4684523',
        );

$g_game_xml = array(
    'ahero' => './xml/ahero_login_param.xml',
);

?>
