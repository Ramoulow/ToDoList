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
        $saisie = "";
    }

    $saisie = filter_var($_POST["saisie"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $todos = ["content" => $saisie];
}

$stmt = $pdo->prepare("SELECT * FROM todos");
$stmt->execute();

$datas = $stmt->fetchAll();

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

                <button type="submit" value="Valider" id="addButton" class="d-flex x-center y-center">Ajouter</button>

            </form>

            <p class="t-center"><?= $error; ?></p>

            <?php

            foreach ($datas as $value) {
                if ($value["todoStatement"] == 0) {
                ?>
                <div class="listContainer alternateBackground">
                    <div class="row d-flex">
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
                <div class="listContaine alternateBackgroundr">
                    <div class="row d-flex">
                        <div class="col1 d-flex">
                            <p class='cancel d-flex'><?= $value["content"] ?></p>
                        </div>
                        <div class="col2 d-flex x-center">
                            <a href="/cancel.php?id=<?= $value['todoId'] ?>">Annuler</a>
                        </div>
                        <div class="col3 d-flex x-center">
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