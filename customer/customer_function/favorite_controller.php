<?php
session_start();
require '../db/db-connect.php';
require 'favorite_model.php';

$pdo = new PDO($connect, USER, PASS);

$user_id = $_SESSION['user_id'] ?? 1;

// モデルからお気に入り一覧取得
$favorites = getFavoriteList($pdo, $user_id);

require '../customer/favorite-add.php'
?>