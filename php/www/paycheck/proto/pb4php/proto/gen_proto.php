#!/usr/bin/php5
<?php
require_once('../parser/pb_parser.php');
if ($argc != 2) {
    echo "Usage: {$argv[0]} file_name\n";
    return;
}
$file_name = $argv[1];

$proto = new PBParser();

$proto->parse($file_name);

?>
