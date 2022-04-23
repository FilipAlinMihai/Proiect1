<?php
	
	session_start();
	echo "<style>
	body 
	{  
		background-image: url('../imagini/background1.jpg');
		background-size: 1700px 2000px;
	} 
	.centrat
	{
		width: 300px;
		text-align: center;
		margin: auto;
		padding: 10px 15px;
		background-color: lightblue;
		border-radius: 30px;
	}
	.centrat1
	{
		text-align: center;
	}
	.grid-container
	{
		
		display: grid;
		grid-template-columns: auto auto;
		
	}
	
	div.grid-item:hover 
	{
		border: 5px solid #0066cc;
	}
	.grid-item 
	{
		margin: 7px;
		border: 4px solid #00BFFF;
		text-align: center;
	}
	.button
		{
			border-radius: 50%;
		background-color: #00BFFF;
		padding: 10px 15px;
			font-size: 19x;
			box-shadow: 0 9px #999;
			font-family: Arial, Helvetica, sans-serif;
		font-weight: bold;
		}
	#apreciere
	{
		border-radius: 50%;
		background-color: #00BFFF;
		padding: 10px 15px;
			font-size: 19x;
			box-shadow: 0 9px #999;
	}
	.continut{

		width: 600px;
		text-align: center;
		margin: auto;
	}
	p {
		font-family: Arial, Helvetica, sans-serif;
		font-weight: bold;
	  }
	.textinput{
		width: 100%;
		box-sizing: border-box;
		border: 2px solid #ccc;
		border-radius: 4px;
		font-size:110%;
		background-color: white;
		background-position: 10px 10px; 
		background-repeat: no-repeat;
		padding:3px;
	}
	#imagine{
		padding:15px;
	}
	</style>
	";

	
	$b = new mysqli('localhost', 'root', '', 'FlyTrip');

	if (mysqli_connect_errno()) {
		exit('Connect failed: '. mysqli_connect_error());
	}
	$com = "SELECT count(Persoana),Numar,Imagine1,Email,Tip,Descriere,Locatie FROM `postare`,`apreciere` WHERE Postare=Numar GROUP BY Numar ORDER BY count(Persoana) DESC;"; 
	
	$numar=0;
	$info = $b->query($com);
	echo '<div class="centrat"></br><h1>Cele mai apreciate postari</h1></br></br></div>';
	echo '<div class="grid-container">';
	if ($info->num_rows > 0) {
		
	while($row = $info->fetch_assoc()) {
		echo '<div class="grid-item">';
		echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['Imagine1'] ).'" width="350" height="200" id="imagine" name="imgs"/>';
		echo '<p style="font-size:18"> Locatie: '. $row['Locatie']."</p>";
		echo '<p style="font-size:18"> -- Email : '. $row['Email']."</p>";
		echo '<p style="font-size:18"> -- Tip: '. $row['Tip']."</p>";
		echo '<div class="continut">';
		echo '<p style="font-size:18"> -- Descriere: '.$row['Descriere']."</p>";
		echo '</div>';
		echo '<p style="font-size:18"> --ID: '.$row['Numar']."</p>";
		echo '<p style="font-size:18"> --Lasa un comentariu</p> </br> 
		<form action="Com.php" method="post" enctype="multipart/form-data">
		<table>
		<tr> <td><p>Comentariu</p></td>  <td><input type="text" name="coment" class="textinput" value=""/></td></tr>
		<tr> <td></td>  <td><input type="hidden" name="id" value="'.$row['Numar'].'"/></td></tr>
		<tr> <td><input type="submit" value="Adauga" class="button"></td>  </tr>
		</table>
		</form>';
		echo '<form action="AfisareCom.php" method="post" enctype="multipart/form-data">
		<table>
		<tr> <td></td>  <td><input type="hidden" name="id" value="'.$row['Numar'].'"/></td></tr>
		<tr> <td><input type="submit" value="Comentarii" class="button"></td>  </tr>
		</table>
		</form>';
		
		echo '</br><form action="Poze.php" method="post" enctype="multipart/form-data">
		<table>
		<tr> <td></td>  <td><input type="hidden" name="poze" value="'.$row['Numar'].'"/></td></tr>
		<tr> <td><input type="submit" value="Pozele" id="pozele" class="button"></td>  </tr>
		</table>
		</form></br>';
		$com = "SELECT count(Postare) FROM `apreciere` where Postare=".$row['Numar']."";

		$numar = $b->query($com);
		$rand=$numar->fetch_assoc();
		

		$interogare= "SELECT * from `apreciere` where Postare='".$row['Numar']."' and Persoana='".$_SESSION['email']."'";
		$aprec= $b->query($interogare);
		if($aprec->num_rows>0)
			echo '<p>Apreciata</p></br>';
		echo '<p>Aprecieri:'.$rand['count(Postare)'].'</p>';

		echo '</div>';
	}

	echo '</div>';
	echo "<div class='centrat1'>";
	echo '<br><a href="../PaginaP.html"><button class="button">Pagina Principală</button></a>';
	echo '</div>';
	echo '</br></br></br></br>';
	}
	else {
	echo 'Nu au fost gasite rezultate';
	}	
	
	$b->close();

?>