<?php
session_start();
require 'db-connect.php';

$pdo = new PDO($connect, USER, PASS);

$filter = $_GET['filter'] ?? 'user'; 
$sort = $_GET['sort'] ?? 'date';

// まずベースSQL（顧客）
$sql_user = "
    SELECT 
        ul.user_log_id AS log_id,
        u.user_name AS user_name,
        u.user_id AS user_id,
        CONCAT(ul.target_table, ' (ID:', ul.target_id, ')') AS target,
        ul.user_action AS action,
        ul.log_date
    FROM user_logs ul
    LEFT JOIN users u ON ul.user_id = u.user_id
";

// 管理者
$sql_admin = "
    SELECT
        al.admin_log_id AS log_id,
        a.admin_name AS user_name,
        a.admin_id AS user_id,
        CONCAT(al.target_table, ' (ID:', al.target_id, ')') AS target,
        al.admin_action AS action,
        al.log_date
    FROM admin_logs al
    LEFT JOIN admins a ON al.admin_id = a.admin_id
";

// フィルター処理
if ($filter === 'user') {
    $sql = $sql_user;
} elseif ($filter === 'admin') {
    $sql = $sql_admin;
} else {
    $sql = "($sql_user) UNION ALL ($sql_admin)";
}

// ソート
switch($sort){
    case 'user':
        $sql .= " ORDER BY user_name ASC";
        break;
    case 'action':
        $sql .= " ORDER BY action ASC";
        break;
    case 'id':
        $sql .= " ORDER BY log_id DESC";
        break;
    default:
        $sql .= " ORDER BY log_date DESC";
}

function displayUserName($user_name, $log_id) {
    if ($user_name === null || $user_name === '未登録') {
        return '未登録 (user ID:' . $log_id . ')';
    }
    return $user_name;
}

$stmt = $pdo->query($sql);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
