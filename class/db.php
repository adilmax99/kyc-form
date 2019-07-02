<?php 

	class Db{
		protected function connect(){
			try {
		    $conn = new PDO("mysql:host=localhost;dbname=kyc_form", "root", "");
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    return $conn;
		    //echo "Connected successfully"; 
		    }
		catch(PDOException $e)
		    {
		    echo "Connection failed: " . $e->getMessage();
		    }
		}
	}
 ?>