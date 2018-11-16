<?php

require_once('config.php');

$id = intval($_GET['id']);

if (!$id) die();

$dbh = new PDO('mysql:host=localhost;dbname=out', $user, $pass);

$tests = array();
foreach ( $dbh->query('SELECT value FROM test_log WHERE test_id = ' . $id . ' ORDER BY created_on DESC LIMIT 100') as $row )
{
   $tests[] = $row['value'];
}

echo json_encode($tests);