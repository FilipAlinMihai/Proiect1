<?php
	session_start();
    $coment=$_POST["coment"];
	$id=$_POST["id"];
	$tip=$_POST["tip"];
	$b=mysqli_connect( "localhost", "root",'',"FlyTrip");
    if (mysqli_connect_errno()) {
		exit('Connect failed: '. mysqli_connect_error());
	}
	$com="SELECT * FROM `postare`";
		$info=$b->query($com);

		$codul=1;
		$verif=1;
		while($codul<100000 && $verif==1)
		{
			$comanda="select * from `comentarii`";
			$info1=$b->query($comanda);
			$verif=0;
			while($row1=$info1->fetch_assoc())
			{
				if($row1['ID']==$codul)
				$verif=1;	
			}
			if($verif==0 )
				break;
			$codul=$codul+1;
		}
    if(strlen($coment)>0)
	{
    	$adauga="Insert into `comentarii` values (".$codul.",'".$coment."','".$id."','".$_SESSION['email']."')";
	if(mysqli_query($b,$adauga)){
		if($tip=='1')
			header("Location: AfisarePostari.php#".$id."");
			else if($tip=='2')
				header("Location: PostariApreciate.php#".$id."");
				else if ($tip=='3') 
					header("Location: PostariComentate.php#".$id."");
					else if($tip=='4')
						header("Location: PostariPropri.php#".$id."");
						else if($tip=='5')
						header("Location: cautarelocatie1.php#".$id."");
						else if($tip=='6')
						header("Location: AfisareRecP.php#".$id."");
	}
	 	else
			echo  'Esuare la introducere';
}
else
			echo  'Comentariul nu trebuie sa fie gol';
    
    
$b->close();
?>