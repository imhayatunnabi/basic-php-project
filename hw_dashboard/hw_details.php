<?php 
	$queryHW    = "SELECT * FROM house_owner WHERE id = {$_SESSION['house_owner_id']}";
    $stmtHW     = $db->prepare($queryHW);
    $resultHW   = $stmtHW->execute();
    $rowHW      = $stmtHW->fetch();
 ?>