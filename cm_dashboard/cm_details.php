<?php 
	$queryCM    = "SELECT * FROM customer WHERE id = {$_SESSION['customer_id']}";
    $stmtCM     = $db->prepare($queryCM);
    $resultCM   = $stmtCM->execute();
    $rowCM      = $stmtCM->fetch();
 ?>