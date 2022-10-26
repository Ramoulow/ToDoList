<?php

require_once "_pdo.php";

const ERROR1 = "Veuillez saisir une ToDo";

const ERROR2 = "Votre ToDo doit contenir au moins 5 caractères";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $saisie = $_POST["saisie"];

    if ($saisie === "") {
        $error = ERROR1;
    } elseif (strlen($saisie) < 5) {
        $error = ERROR2;
    } else {
        $saisie = filter_var($_POST["saisie"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $todos = ["content" => $saisie, "todoStatement" => 0];
        $stmt = $pdo->prepare("INSERT INTO todos (content, todoStatement) VALUES (:content, :todoStatement)");
        $stmt->execute($todos);
        $saisie = "vide";
    }
    // $saisie = filter_var($saisie, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $saisie = filter_var($_POST["saisie"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $todos = ["content" => $saisie];
}

// $done = $_POST["applyButton"];
// $todone = ["done" => $done];
// $stmt2 = $pdo->prepare("INSERT INTO todos (done) VALUES (todo)");
// $stmt3 = $pdo->prepare("INSERT INTO todos (done) VALUES (done)");
// $stmt2->execute();






$stmt = $pdo->prepare("SELECT * FROM todos");
$stmt->execute();

$datas = $stmt->fetchAll();




// if (isset($datas)) {
//     $stmt2 = $pdo->prepare("INSERT INTO todos (done) VALUES (todo)");
//     $stmt2->execute();
// }





// ====================================================================


require_once "_head.php";
?>

<title>ToDo List</title>

<?php
require_once "_header.php";
?>

<body class="d-flex flex-column">

    <div class="main-container d-flex x-center y-center">

        <div class="container d-flex flex-column shadow">

            <h1 class="d-flex x-center">Ma ToDo</h1>

            <form action="" method="post" id="form" class="d-flex x-center">

                <input type="text" name="saisie" id="saisie" class="d-flex x-center " value="<?= $saisie ?? "" ?>">

                <button type="submit" value="Valider" id="addButton" class="d-flex x-center">Ajouter</button>

            </form>

            <p class="t-center"><?= $error; ?></p>

            <?php

            foreach ($datas as $value) {
                if ($value["todoStatement"] == 0) {
                ?>
                <div class="container">
                    <div class="row d-flex toggleBackground">
                        <div class="col1 d-flex">
                            <p class="d-flex"> <?= $value["content"] ?> </p>
                        </div>
                        <div class="col2 d-flex x-center">
                            <a class="d-flex" href="/validate.php?id=<?= $value['todoId'] ?>">Valider</a>
                     </div>
                        <div class="col3 d-flex x-center">
                            <a class="d-flex" href="/delete.php?id=<?= $value['todoId'] ?>">Supprimer</a>
                        </div>
                    </div>
                </div>
                <?php
                } else {
                ?>
                <div class="container">
                    <div class="row d-flex toggleBackground">
                        <div class="col1 d-flex">
                            <p class='cancel d-flex'><?= $value["content"] ?></p>
                        </div>
                        <div class="col2 d-flex">
                            <a href="/cancel.php?id=<?= $value['todoId'] ?>">Annuler</a>
                        </div>
                        <div class="col3 d-flex">
                            <a href="/delete.php?id=<?= $value['todoId'] ?>">Supprimer</a>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>

            <?php
            };
            ?>

        </div>

    </div>

    <?php
    require_once "_footer.php";
    ?>