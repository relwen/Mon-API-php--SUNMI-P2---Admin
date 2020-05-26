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
    
    
    
    		$requete=$bdd->prepare('SELECT * FROM agents WHERE phone=:phone');
    		
    		# Execution de la fonction
    		$requete->execute(array('phone'=>"5756351"));
    		$reponse=$requete->fetch();
    		
    		/*Récupérer l'ID de l'agent connecté*/
    		$agent_id=$reponse['id'];
    		
    		$req_rapp=$bdd->prepare('SELECT * FROM clients inner join agents on clients.agent_id=:agentId ');
    		
    		$req_rapp->execute(array('agentId'=>$agent_id));
    		
    		$allRapport=$req_rapp->fetch();
    		
    		var_dump($allRapport);
    
    $json = json_decode(file_get_contents('php://input'), true);
    
    $phone = $json['phone'];
    $response_array = array();

    try {

    
                            
            $req_id=$bdd->query('SELECT id FROM clients ORDER BY id DESC LIMIT 1');
            $id=$req_id->fetch();
            $nocompte=$id['id'] + 1;
            
            $nocompte = sprintf("%06d", $nocompte);
            
            
            $response_array["status"] = "SUCCESS";
            $response_array["noCompte"]=$nocompte;

        

    } catch (Exception $e) {

        $response_array["status"] = $e->getMessage();
    
    }



echo json_encode($response_array);

exit();




