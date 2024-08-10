<?php
    session_start();
    unset($_SESSION['pat_id']);
    unset($_SESSION['pat_number']);
    session_destroy();

    header("Location: his_doc_logout.php");
    exit;
?>