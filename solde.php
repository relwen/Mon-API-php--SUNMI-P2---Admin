<?php


    function bdd()
    {
        try
        {
            $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
            $bdd=new PDO('mysql:host=localhost;dbname=u924511662_microstart','u924511662_microstart226','microstart226',$pdo_options);
        }
        
        catch (Exception $e)
        {
            die('Erreur: ' . $e->getMessage());
        }
        
        return $bdd;
        

    }
    
    
    $bdd=bdd();
    
    $json = json_decode(file_get_contents('php://input'), true);
    
    $idClient = $json['idClient'];
    $response_array = array();
    
        // echo $sommeTotal;

    try {
        // Trouvé la cotisation
        $reqSolde=$bdd->prepare('SELECT * FROM cotisation WHERE client_id = :idClient');
        
        $idClient=sprintf("%06d", $idClient);
        
        $reqSolde->execute(array(
            'idClient'=>$idClient,
            ));

        /*Somme de la cotisation du client sélectionné*/
        while ($soldeClient=$reqSolde->fetch())  
              { 
                $value = $soldeClient['priceCoti'];
                
                $sommeTotal += $value;
              }

        
        // Status de la sauvegarde
        $response_array["status"] = "SUCCESS";
        
        // Retourner le nouveau solde du client total du client
        $response_array["solde"] = $sommeTotal;
        

    } catch (Exception $e) {

        // Erreur lors de l'enregistrement
        // $response_array["status"] = "FAILURE";
        $response_array["status"] = $e->getMessage();
    
    }



echo json_encode($response_array);

exit();




