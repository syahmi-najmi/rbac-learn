<?php
session_start();

if (!isset($_SESSION['id'], $_SESSION['user_role_id'])) {
    header('location:index.php?lmsg=true');
    exit;
}

require_once('inc/config.php');
require_once('layouts/header.php');
require_once('layouts/left_sidebar.php');


?>

<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>

        </ol>
        <h1>Welcome to Dashboard</h1>
        <hr>
        <p>You are login as <strong><?php echo getUserAccessRoleByID($_SESSION['user_role_id']); ?></strong></p>

        <ul>
            <li><strong>John Doe</strong> has <strong>Administrator</strong> rights so all the left bar items are
                visible to him</li>
            <li><strong>Ahsan</strong> has <strong>Editor</strong> rights and he doesn't have access to Settings</li>
            <li><strong>Sarah</strong> has <strong>Author</strong> rights and she can't have access to Appearance,
                Components and Settings</li>
            <li><strong>Salman</strong> has <strong>Contributor</strong> rights and he has only access Posts</li>
        </ul>

        <div style="height: 1000px;"></div>
    </div>
    <!-- /.container-fluid-->

    <?php require_once('layouts/footer.php'); ?>