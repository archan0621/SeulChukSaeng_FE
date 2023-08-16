<?php
    unset( $_SESSION['member_id']);
    unset( $_SESSION['token']);
    header("Location: /");
?>