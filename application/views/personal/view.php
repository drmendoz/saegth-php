<?php
    $user = new UserController('User','user','view',0,true,true); 
    $user->view($id); 
    $user->ar_destruct();       
    unset($user);
?>