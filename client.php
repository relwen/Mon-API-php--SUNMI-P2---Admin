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
    
    $req_id=$bdd->query('SELECT id FROM clients ORDER BY id DESC LIMIT 1');
    $id=$req_id->fetch();
    $compte=$id['id'] + 1;
    
    $id_compte = sprintf("%06d", $compte);
    

$json = json_decode(file_get_contents('php://input'), true);

$agence=$json['agence'];

$no_compte=$agence . $id_compte;

$client_name = $json['name'];
$sexe=$json['client_sexe'];
$localize = $json['localize'];
$client_surname = $json['surname'];
$client_mobile_number = $json['phone'];
$client_phone2 = $json['phone2'];
$client_cnib = $json['cnib'];
$client_name_ay = $json['name_ay_droit'];
$client_phone_ay = $json['phone_ay_droit'];

$client_email = $json['email'];
$client_date_inscr = $json['date'];
$client_profile_picture = $json['profile_picture'];
$client_profile_name = $json['file_name'];

$response_array = array();

$server_path = "https://microstart226-com.preview-domain.com/images/upload/";

// this path is going to be with respect to utilities.php

$absolute_path = "../images/upload/";

// $checkUserExistsQuery = $bdd->prepare("SELECT accnr FROM clients WHERE accnr =:client_name");

// $checkUserExistsQuery->execute(array('client_name'=>$client_name));

// $existe=$checkUserExistsQuery->rowCount();

// Fake

$existe=0;


    $file_path = $server_path . $client_surname . $client_profile_name;

    try {


        $requete=$bdd->prepare(
        	'INSERT INTO clients (id,clcode,name,surname,cnib,name_ay_dr,phone_ay_dr,localize,memdate,mail,sex,phone,phone2,photo, allow) VALUES ( :id,:clcode, :name,:surname,:cnib,:name_ay_dr,:phone_ay_dr,:localize,:memdate,:email,:sex,:phone,:phone2,:photo,:allow)'

        );

        $ok=$requete->execute(array(
            'id'=>$id_compte,
            'clcode'=> "$no_compte",
            'name'=> $client_name,
            'surname'=>$client_surname,
            'cnib'=>$client_cnib,
            'name_ay_dr'=>$client_name_ay,
            'phone_ay_dr'=>$client_phone_ay,
            'localize'=>$localize,
            'memdate'=>$client_date_inscr,
            'email'=>$client_email,
            'sex'=>$sexe,
            'phone'=>$client_mobile_number,
            'phone2'=>$client_phone2,
            'photo'=>"default.jpg",
            'allow'=>0,
            ));

        // base64_to_jpeg($client_profile_picture, $absolute_path . $client_surname . $client_profile_name);

        

        $response_array["status"] = "SUCCESS";


    } catch (Exception $e) {

        // unexpected error
        
        $response_array["status"] = "FAILURE";
        $response_array["error"] = $e->getMessage();
    
        // rollback_transaction($conn);
    
    }



echo json_encode($response_array);

exit();




