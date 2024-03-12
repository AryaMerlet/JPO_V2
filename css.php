<?php




        // SI LA CONFIG EST ENVOYEE
        if(isset($_REQUEST['config'])) {

            if(isset($_REQUEST['Mode'])) {  
                $_SESSION["Mode"]="jour";
            } else {
                $_SESSION["Mode"]="nuit";
            }
        }
        
        
?>

<link rel="stylesheet" href="CSS/<?php echo $_SESSION['Mode']; ?>.css">