<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['id'], $_SESSION['user_role_id'])) {
    header('location:index.php?lmsg=true');
    exit;
}

// Include required files
require_once('inc/config.php');
require_once('layouts/header.php');
require_once('layouts/left_sidebar.php');

// Fetch user role dynamically
$userRole = getUserAccessRoleByID($_SESSION['user_role_id']);
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
        </ol>
        <h1>Welcome to Dashboard</h1>
        <hr>
        <p>You are logged in as <strong><?php echo htmlspecialchars($userRole, ENT_QUOTES, 'UTF-8'); ?></strong></p>
        <ul>
            <li>Administrators can access all features.</li>
            <li>Editors cannot access Settings.</li>
            <li>Authors cannot access Appearance, Components, or Settings.</li>
            <li>Contributors only have access to Posts.</li>
        </ul>
    </div>
</div>
<?php
require_once('layouts/footer.php');
?>