<?php

require_once('config.php');

$dbh = new PDO('mysql:host=localhost;dbname=out', $user, $pass);

$tests = array();
foreach ( $dbh->query('SELECT * FROM tests') as $row )
{
   $results = $dbh->query($row['query'])->fetch(PDO::FETCH_NUM);
   $results[] = $row['id'];

   $i = $dbh->prepare('UPDATE `tests` SET result = ?, value = ? WHERE id = ?');
   $i->execute($results);

   $i = $dbh->prepare('INSERT INTO `test_log` VALUES(?,?,NULL)');
   $i->execute([$results[1],$results[2]]);

}
