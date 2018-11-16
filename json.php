<?php

require_once('config.php');

$dbh = new PDO('mysql:host=localhost;dbname=out', $user, $pass);

$tests = array();
foreach ( $dbh->query('SELECT * FROM tests') as $row )
{
   $tests[] = $row;
}

echo json_encode($tests);