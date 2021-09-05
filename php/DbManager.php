<?php
function getDb() : PDO {
  $dsn = 'mysql:dbname=****; host=****; charset=utf8';
  $usr = '****';
  $passwd = '****';

  //データベースへの接続を確立
  $db = new PDO($dsn, $usr, $passwd);
  return $db;
}
