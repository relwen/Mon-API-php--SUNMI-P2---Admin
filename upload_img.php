
<?php

		session_start();

		include_once"model/bdd.php";
		$bdd=bdd();


  
		if(!isset($_SESSION['id'])){
			// header('Location:index.php');

			echo "non non";
		}
		else
		{
			
            	$sms=0;
              $cat=0;

              $req_messages=$bdd->query('SELECT * FROM messages');
            
              $req_categorie=$bdd->query('SELECT * FROM categorie');

              while ($ok=$req_messages->fetch())  
              { 
                $sms++;
              }

              while ($ok_cat=$req_categorie->fetch())  
              { 
                $cat++;
              }


		
		// OK
			
			$requser=$bdd->prepare('SELECT * FROM users WHERE id=?');
			
			$requser->execute(array($_SESSION['id']));
			
			$user=$requser->fetch();
			
			
			if(isset($_POST['prod_submit']))
			{
				$nom_prod=$_POST['produit'];
				$price_prod=$_POST['price'];
				$cate_prod=$_POST['cate_prod'];
				$descript_prod=$_POST['descript_prod'];
				 
				 // Mon insertion dans le BDD
			

			}
			
			
			if(isset($_FILES['img1']) AND !empty($_FILES['img1']['name']))
			{
				$tailleMax=2097152;	//2 Mo
				$extensionsValides=array('jpg','jpeg','png','gif');	
				
				
					if($_FILES['img1']['size']<=$tailleMax)
					{
						
						$extensionsUpload=strtolower(substr(strrchr($_FILES['img1']['name'],'.'),1));
						
						if(in_array($extensionsUpload,$extensionsValides))
						{
							$chemin='membres/' .$nom_prod. "." .$extensionsUpload;
						
							$resultat=move_uploaded_file($_FILES['img1']['tmp_name'],$chemin);
							
							
							// Quand le uploading est fait, on rentre dans cette condition
							if($resultat)
							{

								$insert_prod=$bdd->prepare('INSERT INTO  products(nom,nom_cat,prix,img1,descript) VALUES (:nom,:cat,:price,:img1,:description) ');
								
								$result=$insert_prod->execute(array(
									'nom'=>$nom_prod,
									'cat'=>$cate_prod,
									'price'=>$price_prod,
									'img1'=>$nom_prod.".".$extensionsUpload,
									'description'=>$descript_prod
								));




								// $inserer_produit=$bdd->prepare('INSERT INTO products(img1) VALUES(:img1)');
									
								// $inserer_produit->execute(array(
								// 'img1'=>$_SESSION['id'].".".$extensionsUpload
								// 	// 'id'=>$_SESSION['id']
								// ));
								
								// header('Location:index.php?id='.$_SESSION['id']);
							}
							else
							{
								$erreur="Une erreur est survenue lors de l'image de couverture du produit";
							}
							
						}
						else
						{
							$erreur='Votre Photo de Profil doit être au format JPG , PNG ou JPEG';
						}
						
					}
					
					else
					{
						$erreur="Votre Photo de Profil ne doit pas dépasser 2 Mo";
					}
							
			}


	}

?>