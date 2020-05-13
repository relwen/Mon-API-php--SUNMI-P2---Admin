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
    
    $priceCoti=$json['priceCoti'];
    $idClient = $json['idClient'];
    $datePaye = $json['date_paye'];
    $methPaye = $json['meth_paye'];
    $refPaye = $json['ref_paye'];
    
    $response_array = array();


            
        // $req=$bdd->prepare('SELECT SUM(priceCoti) as value_som FROM cotisation WHERE client_id=:idClient');
        
        // $req->execute(array(
        //     'idClient'=>$idClient
        //     ));
            
        // $row = $req->fetchAll();
        
        // $solde = $row->value_som;
        
        
        
        $reqSolde=$bdd->prepare('SELECT * FROM cotisation WHERE client_id = :idClient');
        
        
        
        $test=(int)306;
        sprintf("%06d", $test);

        $reqSolde->execute(array(
            'idClient'=>$test,
            ));

        while ($soldeClient=$reqSolde->fetch())  
              { 
                $value = $soldeClient['priceCoti'];
                
                $sommeTotal += $value;
              }
        

        echo $sommeTotal;

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
            
            
            

            
        $response_array["status"] = "SUCCESS";
        
        $response_array["solde"] = $solde;
        

    } catch (Exception $e) {

        // Erreur lors de l'enregistrement
        // $response_array["status"] = "FAILURE";
        $response_array["status"] = $e->getMessage();
    
    }



echo json_encode($response_array);

exit();




