<?php 
	$queryAdmin    = "SELECT * FROM admin WHERE id = {$_SESSION['admin_id']}";
    $stmtAdmin     = $db->prepare($queryAdmin);
    $resultAdmin   = $stmtAdmin->execute();
    $rowAdmin      = $stmtAdmin->fetch();
 ?>