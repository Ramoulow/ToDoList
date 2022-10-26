<?php

require_once "_pdo.php";

$pageId = filter_var($_GET["id"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$stmtDelete = $pdo->prepare("DELETE FROM todos WHERE todoId = $pageId");
$stmtDelete->execute();
header("location:/");