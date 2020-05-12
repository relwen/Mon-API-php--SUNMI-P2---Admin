<?php

class Constants
{
    //DATABASE DETAILS
    static $DB_SERVER="localhost";
    static $DB_NAME="u924511662_microstart";
    static $USERNAME="u924511662_microstart226";
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
        $con=new mysqli(Constants::$DB_SERVER,Constants::$USERNAME,Constants::$PASSWORD,Constants::$DB_NAME);
        if($con->connect_error)
        {
            return null;
        }else
        {
            return $con;
        }
    }
    /*******************************************************************************************************************************************/
    /*
       1.SELECT FROM DATABASE.
    */
    public function search($query)
    {

        $sql="SELECT * FROM clients WHERE accnr LIKE '%$query%' OR name LIKE '%$query%' ";
        
		
        $con=$this->connect();
        if($con != null)
        {
            $result=$con->query($sql);
            if($result->num_rows > 0)
            {
                $spacecrafts=array();
                while($row=$result->fetch_array())
                {
                    array_push($spacecrafts, array(
                        "id"=>$row['id'],
                        "client_name"=>$row['client_name'],
                        "client_surname"=>$row['client_surname'],
                        "cnib"=>$row['cnib'],
                        "photo"=>$row['photo'])
                        );
                }
                print(json_encode(array_reverse($spacecrafts)));
            }else
            {
                print(json_encode(array("Aucune réponse trouvée: ".$query)));
            }
            $con->close();

        }else{
            print(json_encode(array(" IMPOSSIBLE DE CE CONNECTER AU SERVEUR .")));
        }
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
