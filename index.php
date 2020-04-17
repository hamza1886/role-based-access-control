<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home | Company</title>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css">
</head>
<body class="container">
<?php
require_once 'model/Role.php';
require_once 'model/Permission.php';
require_once 'model/PrivilegedUser.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$u = isset($_SESSION['user']->username) ? PrivilegedUser::getByUsername($_SESSION['user']->username) : false;
if (!$u) {
    header("Location: login.php", true, 302);
    die("<h2>302 Redirected</h2><p><a href='login.php'>Login</a> to continue.</p>");
}

if (!$u->hasPrivilege('view_role')) {
    header("Location: index.php", true, 403);
    die ("<h2>403 Forbidden</h2><p>You are not allowed here. Please contact administrator <a href='mailto:admin@company.com'>admin@company.com</a>.</p>");
}

require_once 'menu.php';
?>

<?php
// insert roles
if ($u->hasPrivilege('add_role')) {
    $roles = ['admin', 'sales', 'marketing', 'finance', 'it', 'staff'];
    $count = 0;
    foreach ($roles as $role) {
        $count += Role::insertRole($role);
    }
//    echo "<div>{$count} role(s) inserted.</div>";
}

// insert permissions
if ($u->hasPrivilege('add_permission')) {
    $perms = [
        'add_user', 'update_user', 'delete_user', 'view_user', // 1-4
        'add_accounts_info', 'update_accounts_info', 'delete_accounts_info', 'view_accounts_info', // 5-8
        'generate_balance_sheet', 'update_balance_sheet', 'delete_balance_sheet', 'view_balance_sheet', // 9-12
        'add_sales_info', 'update_sales_info', 'delete_sales_info', 'view_sales_info', // 13-16
        'add_billing_info', 'update_billing_info', 'delete_billing_info', 'view_billing_info', // 17-20
        'add_marketing_info', 'update_marketing_info', 'delete_marketing_info', 'view_marketing_info', // 21-24
        'generate_reports', 'update_reports', 'delete_reports', 'view_reports', // 25-28
        'generate_system_alert', 'update_system_alert', 'delete_system_alert', 'view_system_alert', // 29-32
        'add_role', 'update_role', 'delete_role', 'view_role', // 33-36
        'add_permission', 'update_permission', 'delete_permission', 'view_permission', // 37-40
    ];
    $count = 0;
    foreach ($perms as $perm_desc) {
        $count += Permission::insertPerm($perm_desc);
    }
//    echo "<div>{$count} permission(s) inserted.</div>";
}

// assign roles to users
if ($u->hasPrivilege('add_role') && $u->hasPrivilege('add_permission')) {
    $role_perms = [
        ['role_id' => 1, 'perm_ids' => [1, 2, 3, 4, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44]],
        ['role_id' => 2, 'perm_ids' => [9, 10, 11, 12, 13, 14, 15, 16, 32, 36]],
        ['role_id' => 3, 'perm_ids' => [21, 22, 23, 24, 32, 36]],
        ['role_id' => 4, 'perm_ids' => [5, 6, 7, 8, 17, 18, 19, 20, 32, 36]],
        ['role_id' => 5, 'perm_ids' => [29, 30, 31, 32, 36]],
        ['role_id' => 6, 'perm_ids' => [25, 26, 27, 28, 32, 36]],
    ];
    $count = 0;
    foreach ($role_perms as $role_perm) {
//        $count += Role::insertRolePerms($role_perm['role_id'], $role_perm['perm_ids']);
    }
//    echo "<div>{$count} permission(s) inserted on " . count($role_perms) . " role(s).</div>";
}

if ($u->hasPrivilege('add_user') && $u->hasPrivilege('add_role')) {
    $count = Role::insertUserRoles(2, [2, 3]);
//    echo "<div>{$count} user role(s) inserted.</div>";
}
?>
<div>
    <pre><?php print_r($u); ?></pre>
</div>

<?php require_once 'script.php'; ?>
<?php require_once 'footer.php'; ?>
</body>
</html>
