<?php

class Constants
{
    //DATABASE DETAILS
    static $DB_SERVER="localhost";
    static $DB_NAME="u909898786_microstart";
    static $USERNAME="u909898786_microstart226";
    static $PASSWORD="microstart226";

    //STATEMENTS
    static $SQL_SELECT_ALL="SELECT * FROM clients";
}

class Spacecrafts
{
    /*******************************************************************************************************************************************/
    /*
       1.CONNECT TO DATABASE.
       2. RETURN CONNECTION OBJECT
    */
    public function connect()
    {
        try
        {
            $pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
            
            $con=new PDO('mysql:host=localhost;dbname=u909898786_microstart','u909898786_microstart226','microstart226',$pdo_options);
            

        }
        
        catch (Exception $e)
        {
            die('Erreur: ' . $e->getMessage());
        }
        
        return $con;
        
    }
    /*******************************************************************************************************************************************/
    /*
       1.SELECT FROM DATABASE.
    */
    public function search($query)
    {
        
        $con=$this->connect();
            
            $requete=$con->prepare('SELECT * FROM agents WHERE phone=:phone');
            
            # Execution de la fonction
            $requete->execute(array('phone'=>"5756351"));
            $reponse=$requete->fetch();
            
            /*Récupérer l'ID de l'agent connecté*/
            $agent_id=$reponse['id'];

        // $sql="SELECT * FROM clients WHERE agent_id=$agent_id ";
        
        
            // $result=$con->query("SELECT * FROM clients WHERE agent_id=$agent_id");
            
            $result=$con->prepare("SELECT * FROM clients WHERE agent_id=:ag and memdate=:date");
            
            // $result->execute(array('ag'=>1));
            
            
            if($result->execute(array('ag'=>$agent_id)))
            {
                $spacecrafts=array();
                
                while($row=$result->fetch())
                {
                    array_push($spacecrafts, array(
                        "id"=>$row['id'],
                        "clcode"=>$row['clcode'],
                        "name"=>$row['name'],
                        "surname"=>$row['surname'],
                        "cnib"=>$row['cnib'],
                        "photo"=>$row['photo']
                        ));
                }
                print(json_encode(array_reverse($spacecrafts)));
            }else
            {
                print(json_encode(array("Aucune réponse trouvée: ".$query)));
            }
            // $con->close();

        
    }
    public function handleRequest() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $query=$_POST['query'];
            $this->search($query);    
        } 
        else{
            $this->search("");
        }
    
    }
}
$spacecrafts=new Spacecrafts();
$spacecrafts->handleRequest();
//end
