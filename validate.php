<?php

require_once "_pdo.php";

$pageId = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);

$stmtValidate = $pdo->prepare("UPDATE todos SET todoStatement = 1 WHERE todoId = $pageId");
$stmtValidate->execute();
header("location:/");