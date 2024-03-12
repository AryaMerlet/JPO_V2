<?php
// script de connexion
require_once('base_donnee.php');

include ("session_start.php");

if(isset($_REQUEST['Mode'])) {
    if ($_REQUEST['Mode'] == 'nuit'){
        $_SESSION["Mode"]="nuit";
    }
    else{
        $_SESSION["Mode"]="jour";
    }
}

if (isset($_POST['soumettre'])) {


    $prenom = htmlentities($_POST['prenom']);
    $nom = htmlentities($_POST['nom']);
    $mail = htmlentities($_POST['email']);
    $tel = htmlentities($_POST['tel']);
    $adresse = htmlentities($_POST['adresse']);
    $ville = htmlentities($_POST['ville']);
    $code_postal = htmlentities($_POST['code-postal']);
    $projet = htmlentities($_POST['projet']);
    $pre_inscrit = htmlentities($_POST['pre_inscrit']);
    $niveau_etude = htmlentities($_POST['niveau_etude']);
    $connaissance = htmlentities($_POST['decouverte_IIA']);
    $formation_souhaitee = htmlentities($_POST['formation_envisagee']);
    $formation_option = htmlentities($_POST['formation_option']);
    $formation_alternance = htmlentities($_POST['formation_alternance']);

    // Add logic to determine and display the appropriate content based on the selected formation
    $formation_selectionnee = isset($_POST['formation_envisagee']) ? $_POST['formation_envisagee'] : '';
    $chemins_fichiers = array(
        'BTS SIO SLAM' => 'Fiches formations/bts-services-informatiques-aux-organisations-sio-option-slam.pdf',
        'BTS SIO SISR' => 'Fiches formations/bts-services-informatiques-aux-organisations-sio-option-sisr.pdf',
        'LIC SIO SLAM' => 'Fiches formations/licence-informatique-en-alternance-developpement.pdf',
        'LIC SIO SISR' => 'Fiches formations/licence-informatique-en-alternance-cybersecurite.pdf',
        'MASTER LEAD DEVELOPEUR' => 'Fiches formations/lead-dev-bac5.pdf',
        'MASTER MANAGER CYBERSECURITE' => 'Fiches formations/manager-cybersecurite-bac5.pdf',
    );
    
    $_SESSION['chemin_fichier'] = isset($chemins_fichiers[$formation_selectionnee]) ? $chemins_fichiers[$formation_selectionnee] : '';

    //On définit la requête sql qui va envoyer toutes les données a la base de données
    $sql = 'INSERT INTO prospect (prenom, nom, email, tel, adresse, ville, code_postal, projet, pre_inscrit, niveau_etude, decouverte_IIA, formation, formation_option, formation_alternance, heure_enregistrement) 
            VALUES (:prenom, :nom, :mail, :tel, :adresse, :ville, :code_postal, :projet, :pre_inscrit, :niveau_etude, :connaissance, :formation_envisagee, :formation_option , :formation_alternance, NOW())';
    try {
        $temp = $pdo->prepare($sql);
        $temp->Bindparam(":prenom", $prenom, PDO::PARAM_STR);
        $temp->Bindparam(":nom", $nom, PDO::PARAM_STR);
        $temp->Bindparam(":mail", $mail, PDO::PARAM_STR);
        $temp->Bindparam(":tel", $tel, PDO::PARAM_STR);
        $temp->Bindparam(":adresse", $adresse, PDO::PARAM_STR);
        $temp->Bindparam(":ville", $ville, PDO::PARAM_STR);
        $temp->Bindparam(":code_postal", $code_postal, PDO::PARAM_INT);
        $temp->Bindparam(":projet", $projet, PDO::PARAM_STR);
        $temp->Bindparam(":pre_inscrit", $pre_inscrit, PDO::PARAM_INT);
        $temp->Bindparam(":niveau_etude", $niveau_etude, PDO::PARAM_INT);
        $temp->Bindparam(":connaissance", $connaissance, PDO::PARAM_STR);
        $temp->Bindparam(":formation_envisagee", $formation_souhaitee, PDO::PARAM_STR);
        $temp->Bindparam(":formation_option", $formation_option, PDO::PARAM_STR);
        $temp->Bindparam(":formation_alternance", $formation_alternance, PDO::PARAM_INT);
        $temp->execute();

        if (isset($_POST['send_mail']) && $_POST['send_mail'] == 'on') {
            // Redirection explicite
            header("Location: fichier-formation.php");
            exit();
        }
        else 
            header("Location: enregistrement_reussie.php");
            exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/<?php echo $_SESSION['Mode'] ?>.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;700&display=swap" rel="stylesheet">

</head>
<body>
    <div class="nav_hitbox">
<nav>
        <div>
             <div class="button_active">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                    <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                  </svg>
                  
             </div>
        </div>
        <div class="nav_container">
            <a href="admin.php">
                <div class="button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M16.5 7.5h-9v9h9v-9Z" />
                        <path fill-rule="evenodd" d="M8.25 2.25A.75.75 0 0 1 9 3v.75h2.25V3a.75.75 0 0 1 1.5 0v.75H15V3a.75.75 0 0 1 1.5 0v.75h.75a3 3 0 0 1 3 3v.75H21A.75.75 0 0 1 21 9h-.75v2.25H21a.75.75 0 0 1 0 1.5h-.75V15H21a.75.75 0 0 1 0 1.5h-.75v.75a3 3 0 0 1-3 3h-.75V21a.75.75 0 0 1-1.5 0v-.75h-2.25V21a.75.75 0 0 1-1.5 0v-.75H9V21a.75.75 0 0 1-1.5 0v-.75h-.75a3 3 0 0 1-3-3v-.75H3A.75.75 0 0 1 3 15h.75v-2.25H3a.75.75 0 0 1 0-1.5h.75V9H3a.75.75 0 0 1 0-1.5h.75v-.75a3 3 0 0 1 3-3h.75V3a.75.75 0 0 1 .75-.75ZM6 6.75A.75.75 0 0 1 6.75 6h10.5a.75.75 0 0 1 .75.75v10.5a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V6.75Z" clip-rule="evenodd" />
                    </svg>
                </div>
            </a>
        </div>
        <div class="nav_container">
        <a href="MentionsLegales.php">
            <div class="button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v.756a49.106 49.106 0 0 1 9.152 1 .75.75 0 0 1-.152 1.485h-1.918l2.474 10.124a.75.75 0 0 1-.375.84A6.723 6.723 0 0 1 18.75 18a6.723 6.723 0 0 1-3.181-.795.75.75 0 0 1-.375-.84l2.474-10.124H12.75v13.28c1.293.076 2.534.343 3.697.776a.75.75 0 0 1-.262 1.453h-8.37a.75.75 0 0 1-.262-1.453c1.162-.433 2.404-.7 3.697-.775V6.24H6.332l2.474 10.124a.75.75 0 0 1-.375.84A6.723 6.723 0 0 1 5.25 18a6.723 6.723 0 0 1-3.181-.795.75.75 0 0 1-.375-.84L4.168 6.241H2.25a.75.75 0 0 1-.152-1.485 49.105 49.105 0 0 1 9.152-1V3a.75.75 0 0 1 .75-.75Zm4.878 13.543 1.872-7.662 1.872 7.662h-3.744Zm-9.756 0L5.25 8.131l-1.872 7.662h3.744Z" clip-rule="evenodd" />
                  </svg>
            </div>
        </a>
        </div>
        <div class="nav_container">
            <a href="reglage.php">
                <div class="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
            </a>
        </div>
        <div class="nav_container">
            <a href="configuration.php">
                <div class="button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M12 2.25a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75ZM7.5 12a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM18.894 6.166a.75.75 0 0 0-1.06-1.06l-1.591 1.59a.75.75 0 1 0 1.06 1.061l1.591-1.59ZM21.75 12a.75.75 0 0 1-.75.75h-2.25a.75.75 0 0 1 0-1.5H21a.75.75 0 0 1 .75.75ZM17.834 18.894a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 1 0-1.061 1.06l1.59 1.591ZM12 18a.75.75 0 0 1 .75.75V21a.75.75 0 0 1-1.5 0v-2.25A.75.75 0 0 1 12 18ZM7.758 17.303a.75.75 0 0 0-1.061-1.06l-1.591 1.59a.75.75 0 0 0 1.06 1.061l1.591-1.59ZM6 12a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h2.25A.75.75 0 0 1 6 12ZM6.697 7.757a.75.75 0 0 0 1.06-1.06l-1.59-1.591a.75.75 0 0 0-1.061 1.06l1.59 1.591Z" />
                    </svg>
                    
                </div>
            </a>
        </div>
    </nav>
    </div>
    <div class="content_home">
    <div class="sun">
        <div class="line"></div>
    </div>
        <div class="label_home">
        <form action="index.php" method="post">
            <div class="label_box">
        <label for="prenom">Prénom : </label>
        <input type="text" name="prenom" id="prenom" placeholder="Prenom"  />
    </div>
    <div class="label_box">
        <label for="nom">Nom : </label>
        <input type="text" name="nom" id="nom" placeholder="Nom"  />
    </div>
    <div class="label_box">
        <label for="email">Email : </label> 
        <input type="text" name="email" id="email" placeholder="exemple@gmail.com"  />
    </div>
    <div class="label_box">
        <label for="telephone">Téléphone : </label>
        <input type="numbers" name="tel" id="tel" placeholder="telephone"  />
    </div>
    <div class="label_box">
        <label for="adresse">Adresse : </label>
        <input type="text" name="adresse" id="adresse" placeholder="adresse"  />
    </div>
    <div class="label_box">
        <label for="code-postal">Code postal : </label>
        <input type="text" name="code-postal" id="code-postal" placeholder="code postal"  />
    </div>
    <div class="label_box">
        <label for="ville">Ville : </label>
        <input type="text" name="ville" id="ville" placeholder="ville"  />
    </div>

    <div class="label_box select_box">
        <label for="pre_inscrit">Pré inscrit : </label>
        <select name="pre_inscrit" id="pre_inscrit" >
            <option value="0">Non</option>
            <option value="1">Oui</option>
        </select>
   
        <label for="niveau_etude">Niveau d'étude : </label>
        <select name="niveau_etude" id="niveau_etude" >
            <option value="4">BAC</option>
            <option value="3">Bac +2</option>
            <option value="2">Licence</option>
            <option value="1">Master</option>
            <option value="5">CAP</option>
            <option value="6">Autre</option>
        </select>
    </div>
    <div class="label_box select_box">
        <label for="decouverte_IIA">Comment nous avez-vous découvert ? : </label>
        <select name="decouverte_IIA" id="decouverte_IIA" >
            <?php
            $sql = "SELECT * FROM connaissance";
            $temp = $pdo->prepare($sql);
            $temp->execute(); 
            while($resultat = $temp->fetch()){
                echo '<option value="'.$resultat['moyen'].'">'.$resultat['moyen'].'</option>';
            }
            ?>
        </select>
    </div>
    <div class="label_box select_box">
        <label for="formation_envisagee">Formation envisagée : </label>
        <select name="formation_envisagee" id="formation_envisagee" >
            <?php
            $sql = "SELECT DISTINCT nom AS formation FROM formation";
            $temp = $pdo->prepare($sql);
            $temp->execute(); 
            while($resultat = $temp->fetch()){
                echo '<option value="'.$resultat['formation'].'">'.$resultat['formation'].'</option>';
            }
            ?>
            <option value="Ne sait pas">Ne sait pas</option>
        </select>
    </div>
    <div class="label_box select_box">
        <label for="formation_option">Option : </label>
        <select name="formation_option" id="formation_option">
        <?php
            $sql = "SELECT DISTINCT option_formation FROM formation";
            $temp = $pdo->prepare($sql);
            $temp->execute();
            foreach($temp as $t){
                echo '<option value="'.$t['option_formation'].'">'.$t['option_formation'].'</option>';
            }
            ?>
            <option value="Ne sait pas">Ne sait pas</option>
        </select>
    </div>
    <div class="label_box select_box">
        <label for="formation_alternance">Alternance : </label>
        <select name="formation_alternance" id="formation_alternance">
            <option value="1">Oui</option>
            <option value="-1">Non</option>
            <option value="0">Je ne sais pas</option>
        </select>
    </div>
    <div class="label_box_projet">
        <label for="projet">Notes : </label>
        <textarea name="projet" id="projet" placeholder="Ajouter une note"></textarea>
    </div>
    <!-- <div class="label_box">
                <input type="checkbox" name="send_mail" id="send_mail" />
                <label for="send_mail" >Envoyer la fiche formation par mail : </label>
    </div> -->
    <div class="label_box">
                <input type="checkbox" name="RGPD" id="RPGD" />
                <label for="RGPD" required>J'ai lu et signé la feuille RGPD </label>
    </div>
        <input type="submit" href="enregistrement_reussie.php" name="soumettre" value="enregistrer" />
    </form>
        </div>
    </div>
</div>
</body>
</html>