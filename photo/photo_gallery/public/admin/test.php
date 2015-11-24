<?php
require_once('../../includes/initialize.php');
require_once('../../includes/session.php');


if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>

<?php include_layout_template('admin_header.php'); ?>

<?php

    $user =  new User();
    $user->username = "huahua";
    $user->password = "123456";
    $user->first_name = "Hua";
    $user->last_name = "Hua";
    $user->create();

/*
    $user = User::find_by_id(2);
    $user->password = "54321xyz";
    $user->save();
 * 
 */
    $user = User::find_by_id(3);
    $user->delete();
    echo $user->first_name. " was deleted!";
?>
    
<?php include_layout_template('admin_footer.php'); ?>

