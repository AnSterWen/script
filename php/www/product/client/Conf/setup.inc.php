<?php
/**
 * ------------------------------环境设置 与 文件加载 ------------------------
 */
session_start();

ini_set("memory_limit","80M");
set_include_path(get_include_path() . PATH_SEPARATOR . APP_PATH);
require_once APP_CONF_PATH . 'common.inc.php';

require_once APP_CONF_PATH . 'defines.inc.php';

require_once TAOMEE_PATH . 'taomee.php';
require_once APP_PATH . 'user.class.php';
require_once APP_PATH . 'base_controller.php';
require_once APP_PATH . 'item_model.php';
require_once APP_PATH . 'item_view.php';
require_once APP_CONF_PATH . 'functions.php';
require_once APP_CONF_PATH . 'data.inc.php';
require_once APP_CONF_PATH . 'admin.inc.php';
require_once APP_CONF_PATH . 'config.inc.php';
?>
