<?php

require_once "_pdo.php";

$pageId = filter_var($_GET["id"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$stmtValidate = $pdo->prepare("UPDATE todos SET todoStatement = 0 WHERE todoId = $pageId");
$stmtValidate->execute();
header("location:/");