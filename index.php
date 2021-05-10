<?php
session_start();

include "dbconnect.php";

// * HEADER

include "header.php";

// * CONTENU

?>

<h1 class="text-center mt-4 mb-4">Exo json</h1>

<div class="container-fluid">

    <div class="row w-100 justify-content-center">

        <div id="formulaire" class="col-6 p-4">

            <h2>Commandez</h2>

            <form class="" action="" method="POST">

                <select class="custom-select mb-3 mt-3" name="menu" required>
                    <option value="">Choisir un menu</option>

                    <?php 
                    $query = "SELECT * FROM menu";
                    $result = $db->prepare($query);
                    $result->execute();
                    $row = $result->fetchAll(PDO::FETCH_ASSOC);
                    foreach($row as $menu){
                    ?>
                    <option value="<?= $menu['nom_menu'] ?>"><?= $menu['nom_menu'] ?></option>
                    <?php
                    }
                    ?>
                </select>

                <h3>Sauce</h3>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="sauce" id="sauce1" value="ketchup" checked>
                    <label class="form-check-label" for="sauce1">
                        ketchup
                    </label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="sauce" id="sauce2" value="moutarde">
                    <label class="form-check-label" for="sauce2">
                        moutarde
                    </label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="sauce" id="sauce3" value="poivre">
                    <label class="form-check-label" for="sauce3">
                        poivre
                    </label>
                </div>

                <div class="col-12 d-flex justify-content-center mt-3">
                    <input type="submit" name="submit" id="submit" value="Valider Commande" />
                </div>

            </form>

        </div>

    </div>

</div>

<?php

if(isset($_POST['submit'])){

    $menu = !empty($_POST['menu']) ? $_POST['menu'] : NULL;
    $sauce = !empty($_POST['sauce']) ? $_POST['sauce'] : NULL;

    $arr = array('menu' => $menu, 'sauce' => $sauce);

    $infos = json_encode($arr);

    $query = "INSERT INTO commandes (infos_commande) VALUES (?)";
    $result = $db->prepare($query);
    $result->execute([$infos]);

    ?>

    <div class="container-md">

        <div class="row">

            <div class="col-12 d-flex justify-content-center mt-4">

                Résumé de votre commande : 

                <?php 
                
                $commandeId = $db->lastInsertId();

                $query = "SELECT infos_commande FROM commandes WHERE id_commande = :id";
                $result = $db->prepare($query);
                $result->execute(['id' => $commandeId]);
                $row = $result->fetchColumn();

                // echo $row;

                $json = $row;

                $obj = json_decode($json);
                echo "<strong class='ml-2'>" .$obj->{'menu'} ." sauce " .$obj->{'sauce'} ."</strong>";
                
                ?>

            </div>

        </div>

    </div>

    <?php

}

?>

<?php

// * FOOTER

include "footer.php";

?>
