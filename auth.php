<?php
    require "auth_vk.php";
    $o = new Auth_Vk();

    if(!$_GET['code']) {

        $query = "client_id=".APP_ID."&scope=friends&redirect_uri=".REDIRECT_URI."&response+type=code";
        $o->redirect(URL_AUTH."?".$query);
    }

    if($_GET['code']) {
        $o->set_code($_GET['code']);
        $res = $o->get_token();

        if($res) {
            $o->get_data();
        }
        else {
            exit($_SESSION['error']);
        }
    }
    if($_GET['error']) {
        exit($_GET['error_description']);
    }
?>