<?php

require_once "_pdo.php";

$pageId = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);

$stmtDelete = $pdo->prepare("DELETE FROM todos WHERE todoId = $pageId");
$stmtDelete->execute();
header("location:/");