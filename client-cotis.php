<?php


    function bdd()
    {
        try
        {
            $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
            $bdd=new PDO('mysql:host=localhost;dbname=u909898786_microstart','u909898786_microstart226','microstart226',$pdo_options);
        }
        
        catch (Exception $e)
        {
            die('Erreur: ' . $e->getMessage());
        }
        
        return $bdd;
        

    }
    
    
    $bdd=bdd();
    
    $json = json_decode(file_get_contents('php://input'), true);
    
    $priceCoti=$json['priceCoti'];
    $idClient = $json['idClient'];
    $datePaye = $json['date_paye'];
    $methPaye = $json['meth_paye'];
    $refPaye = $json['ref_paye'];
    
    $response_array = array();
    
        // echo $sommeTotal;

    try {


        $requete=$bdd->prepare(
            'INSERT INTO cotisation (client_id,priceCoti,methPaye,refPaye,datePaye) VALUES ( :id_client,:priceCoti, :methPaye,:refPaye,:datePaye)'
        );
        

        $ok=$requete->execute(array(
            'id_client'=>$idClient,
            'priceCoti'=>$priceCoti,
            'methPaye'=> $methPaye,
            'refPaye'=> $refPage,
            'datePaye'=> $datePaye
            ));
            
            
        
        $reqSolde=$bdd->prepare('SELECT * FROM cotisation WHERE client_id = :idClient');
        
        // $idClient=(int)306;
        
        $idClient=sprintf("%06d", $idClient);
        
        $reqSolde->execute(array(
            'idClient'=>$idClient,
            ));

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




