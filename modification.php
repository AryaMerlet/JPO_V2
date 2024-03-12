<?php

header('Content-type: text/html; charset=UTF-8');

include ("session_start.php");

// script de connexion
require_once('base_donnee.php');

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Récupérer les données de l'étudiant avec l'ID spécifié
    $query = "SELECT * FROM prospect WHERE id_prospect = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $prospect = $stmt->fetch(PDO::FETCH_ASSOC);

    // Assigner les valeurs à des variables
    $nom = $prospect['nom'];
    $prenom = $prospect['prenom'];
    $mail = $prospect['email']; 
    $tel = $prospect['tel'];
    $adresse = $prospect['adresse'];
    $ville = $prospect['ville'];
    $code_postal = $prospect['code_postal'];
    $projet = $prospect['projet'];
    $note_prv = $prospect['note_prive'];
    $pre_inscrit = $prospect['pre_inscrit'];
    $niveau_etude = $prospect['niveau_etude'];
    $decouverte_IIA =  $prospect['decouverte_IIA'];
    $formation_envisagee = $prospect['formation'];
    $formation_option = $prospect['formation_option'];
    $formation_alternance = $prospect['formation_alternance'];
    

    // Vérifier si le bouton submit est pressé
    if (isset($_POST['soumettre'])) {

        //on récupère les nouvelles valeurs
        $nom_updated = htmlentities($_POST['nom']);
        $prenom_updated = htmlentities($_POST['prenom']);
        $mail_updated = htmlentities($_POST['email']);
        $tel_updated = htmlentities($_POST['tel']);
        $adresse_updated = htmlentities($_POST['adresse']);
        $ville_updated = htmlentities($_POST['ville']);
        $code_postal_updated = htmlentities($_POST['code_postal']);
        $projet_updated = htmlentities($_POST['projet']);
        $note_prv_updated = htmlentities($_POST['note_prv']);
        $pre_inscrit_updated = htmlentities($_POST['pre_inscrit']);
        $niveau_etude_updated = htmlentities($_POST['niveau_etude']);
        $decouverte_IIA_updated = htmlentities($_POST['decouverte_IIA']);
        $formation_envisagee_updated = htmlentities($_POST['formation_envisagee']);
        $formation_option_updated = htmlentities($_POST['formation_option']);
        $formation_alternance_updated = htmlentities($_POST['formation_alternance']);

        //on ajoute les valeurs dans la db
        $sql = "UPDATE prospect
        SET nom = :nom, 
            prenom = :prenom, 
            email = :email, 
            tel = :tel, 
            adresse = :adresse,
            ville = :ville,
            code_postal = :cp,
            projet = :projet,
            note_prive = :note_prv,
            pre_inscrit = :inscrit,
            niveau_etude = :etude,
            decouverte_IIA = :iia,
            formation = :formenv,
            formation_option = :formeop,
            formation_alternance = :formeal
        WHERE id_prospect = :id";
        $temp=$pdo->prepare($sql);
        $temp->Bindparam(":nom",$nom_updated,PDO::PARAM_STR);
        $temp->Bindparam(":prenom",$prenom_updated,PDO::PARAM_STR);
        $temp->Bindparam(":email",$mail_updated,PDO::PARAM_STR);
        $temp->Bindparam(":tel",$tel_updated,PDO::PARAM_STR);
        $temp->Bindparam(":adresse",$adresse_updated,PDO::PARAM_STR);
        $temp->Bindparam(":ville",$ville_updated,PDO::PARAM_STR);
        $temp->Bindparam(":cp",$code_postal_updated,PDO::PARAM_INT);
        $temp->Bindparam(":projet",$projet_updated,PDO::PARAM_STR);
        $temp->Bindparam(":note_prv",$note_prv_updated,PDO::PARAM_STR);
        $temp->Bindparam(":inscrit",$pre_inscrit_updated,PDO::PARAM_STR);
        $temp->Bindparam(":etude",$niveau_etude_updated,PDO::PARAM_STR);
        $temp->Bindparam(":iia",$decouverte_IIA_updated,PDO::PARAM_STR);
        $temp->Bindparam(":formenv",$formation_envisagee_updated,PDO::PARAM_STR);
        $temp->Bindparam(":formeop",$formation_option_updated,PDO::PARAM_STR);
        $temp->Bindparam(":formeal",$formation_alternance_updated,PDO::PARAM_INT);
        $temp->bindParam(':id', $id);
        $temp->execute();

        // Si la requête a bien été effectuée alors on redirige vers une page qui nous le confirme sinon, on echo une erreur
        if ($temp->execute()) {
            header('Location: modification_validée.php');
            exit();
        } else {
            echo 'Modification failed';
        }
    }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;700&display=swap" rel="stylesheet">

    <?php
        include ("css.php");
    ?>
</head>
<body>

<!-- Menu de navigation -->
<div class="nav_hitbox">
<nav>
        <div class="nav_container">
            <a href="index.php">
                <div class="button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                        <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                    </svg>
                </div>
            </a>
             </div>
        <div>
            <div class="button_active">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M16.5 7.5h-9v9h9v-9Z" />
                    <path fill-rule="evenodd" d="M8.25 2.25A.75.75 0 0 1 9 3v.75h2.25V3a.75.75 0 0 1 1.5 0v.75H15V3a.75.75 0 0 1 1.5 0v.75h.75a3 3 0 0 1 3 3v.75H21A.75.75 0 0 1 21 9h-.75v2.25H21a.75.75 0 0 1 0 1.5h-.75V15H21a.75.75 0 0 1 0 1.5h-.75v.75a3 3 0 0 1-3 3h-.75V21a.75.75 0 0 1-1.5 0v-.75h-2.25V21a.75.75 0 0 1-1.5 0v-.75H9V21a.75.75 0 0 1-1.5 0v-.75h-.75a3 3 0 0 1-3-3v-.75H3A.75.75 0 0 1 3 15h.75v-2.25H3a.75.75 0 0 1 0-1.5h.75V9H3a.75.75 0 0 1 0-1.5h.75v-.75a3 3 0 0 1 3-3h.75V3a.75.75 0 0 1 .75-.75ZM6 6.75A.75.75 0 0 1 6.75 6h10.5a.75.75 0 0 1 .75.75v10.5a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V6.75Z" clip-rule="evenodd" />
                </svg>
            </div>

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
        
        <!-- Le formulaire contenant les valeurs que l'on a récupéré depuis la base de données correspondant à l'id présent dans l'url -->
        <form action="modification.php?id=<?php echo $id; ?>" method="post">
<div class="label_box"></div>
            <div class="label_box">
            <label for="prenom">Prénom : </label>
            <input type="text" name="prenom" id="prenom" value="<?php echo $prenom; ?>"  />
</div>
            <div class="label_box">
        <label for="nom">Nom : </label>
            <input type="text" name="nom" id="nom" value="<?php echo $nom; ?>"  />
</div>
            <div class="label_box">
        <label for="email">Email : </label> 
            <input type="text" name="email" id="email" value="<?php echo $mail; ?>"  />
</div>
            <div class="label_box">
        <label for="telephone">Téléphone : </label>
            <input type="tel" name="tel" id="tel" minlength="10" maxlength="10" value="<?php echo $tel; ?>"  />
</div>
            <div class="label_box">
        <label for="adresse">Adresse : </label>
            <input type="text" name="adresse" id="adresse" value="<?php echo $adresse; ?>"  />
</div>
            <div class="label_box">
        <label for="ville">Ville : </label>
            <input type="text" name="ville" id="ville" value="<?php echo $ville; ?>"  />
</div>
            <div class="label_box">
            <label for="code-postal">Code postal : </label>
            <input type="text" name="code_postal" id="code-postal" value="<?php echo $code_postal; ?>"  />
</div>
            
            <div class="label_box select_box">
            <label for="pre-inscrit">Pré inscrit : </label>
            <select name="pre_inscrit" id="pre_inscrit" >
                <?php
                $preInscritOptions = array(1 => 'Oui', 0 => 'Non');
                foreach ($preInscritOptions as $value => $label) {
                    echo "<option value='$value' " . ($pre_inscrit == $value ? 'selected' : '') . ">$label</option>";
                }
                ?>
            </select>
        <label for="niveau-etude">Niveau d'étude : </label>
            <select name="niveau_etude" id="niveau_etude" >

            <!-- Pour les select on récupère depuis la db directement puis on selectionne celui qui est déja sélectionné dans la db -->
            <?php
                $sql = "SELECT * FROM niveau_etude";
                $temp = $pdo->prepare($sql);
                $temp->execute();
                while($resultat = $temp->fetch()){
                    $selected = ($resultat['equivalent'] == $niveau_etude) ? 'selected' : '';
                    echo '<option value="'.$resultat['equivalent'].'" '.$selected.'>'.$resultat['equivalent'].'</option>';
                }
            ?>
        </select>
</div>
        <div class="label_box select_box">
        <label for="decouverte_IIA">Comment nous avez vous découvert ? : </label>
        <?php echo $decouverte_IIA;
        ?>   
        <select name="decouverte_IIA" id="decouverte_IIA" >
        <?php
            $sql = "SELECT * FROM connaissance";
            $temp = $pdo->prepare($sql);
            $temp->execute();
            while($resultat = $temp->fetch()){
                $selected = ($resultat['moyen'] == html_entity_decode($decouverte_IIA)) ? 'selected' : '';
                echo '<option value="'.$resultat['moyen'].'" '.$selected.'>'.$resultat['moyen'].'</option>';
            }
        ?>
        </select>
    </div>
    <div class="label_box select_box">
        <label for="formation_envisagee">Formation envisagée : </label>
        <select name="formation_envisagee" id="formation_envisagee">
            <?php
            $sql = "SELECT DISTINCT nom FROM formation";
            $temp = $pdo->prepare($sql);
            $temp->execute(); 
            while($resultat = $temp->fetch()){
                $selected = ($resultat['nom'] == $formation_envisagee) ? 'selected' : '';
                echo '<option value="'.$resultat['nom'].'"'.$selected.'>'.$resultat['nom'].'</option>';
            }
            ?>
            <option value="Ne sait pas">Ne sait pas</option>
        </select>
    </div>
    <div class="label_box select_box">
        <label for="projet">Option : </label>
        <select name="formation_option" id="formation_option">
        <?php
            $sql = "SELECT DISTINCT option_formation FROM formation";
            $temp = $pdo->prepare($sql);
            $temp->execute();
            foreach($temp as $t){
                $selected = ($t['option_formation'] == $formation_option) ? 'selected' : '';
                echo '<option value="'.$t['option_formation'].'"'.$selected.'>'.$t['option_formation'].'</option>';
            }
            ?>
            <option value="Ne sait pas">Ne sait pas</option>
        </select>
    </div>
    <div class="label_box select_box">
        <label for="formation_alternance">Alternance : </label>
        <select name="formation_alternance" id="formation_alternance">
            <?php
            $sql = "SELECT formation_alternance FROM prospect";
            $temp = $pdo->prepare($sql);
            $temp->execute(); 
            ?>
            <option value="1" <?php  ?>>Oui</option>
            <option value="-1" <?php ?>>Non</option>
            <option value="0" <?php  ?>>Je ne sais pas</option>
        </select>
    </div>
    <br>
    <br>
    <br>
    <div class="label_box_projet">
                <label for="projet">Notes : </label>
                <textarea type="text" name="projet" id="projet"><?php echo $projet; ?></textarea>
</div>
<div class="label_box_projet">
                <label for="note_prv">Note privée : </label>
                <textarea type="text" name="note_prv" id="note_prv" placeholder="Insérez une note privée"><?php echo $note_prv; ?></textarea>
</div>
        <input type="submit" name="soumettre" onclick="myFunction()" value="modifier" />
    </form>
        <div class="retour-modif">
            <a href="admin.php">Retour</a>
        </div>
    </div>
</div>
</body>
</html>