<?php
function build_dsn($_db_name, $_host = 'localhost', $_port = 3306, $_db_source = "mysql")
{   
    $dsn = sprintf("%s:host=%s;port=%s;dbname=%s", $_db_source, $_host, $_port, $_db_name);
    return $dsn;
}
$dsn = sprintf("%s:host=%s;port=%s;dbname=%s",'mysql','localhost',3306,'RU');
echo $dsn;

echo "\n";
?>
