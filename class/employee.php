<?php 

	class Employee extends Db{
		//select all data from database

		public function select(){
			$sql = "SELECT * from kyc_user";

			$result = $this->connect()->query($sql);
			//print_r($result);

			if ($result->rowCount() > 0) {
				while ($row = $result->fetch()) {
					$data[] = $row;
				}
				return $data;
			}
		}

		public function insert($fields){

			//"INSERT INTO kyc_user (name,city,designation) VALUES (:name,:city,:designation)";
			$imploadeColumn = implode(', ', array_keys($fields));
			$imploadPlaceholder = implode(", :", array_keys($fields));


			$sql = "INSERT INTO kyc_user ($imploadeColumn) VALUES (:".$imploadPlaceholder.")";
			$stmt = $this->connect()->prepare($sql);
			print_r($stmt);
			foreach ($fields as $key => $value) {
				$stmt->bindValue(':'.$key, $value);
			}

			$stmtExec = $stmt->execute();
			if ($stmtExec) {
				header('Location: index.php');
			}
		}


		public function editOne($id)
		{
			$sql = "SELECT * FROM kyc_user WHERE id = :id";
			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(':id', $id);
			$stmt->execute();
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		}


		public function update($fields, $id)
		{
			//$sql = "UPDATE kyc_user SET name=:name,city=:city,designation=:designation";
			$st = "";
			$counter = 1;
			$total_fields = count($fields);
			foreach ($fields as $key => $value) {
				if ($counter === $total_fields) {
					$set = "$key = :".$key;
					$st = $st.$set;
				}else{
					$set = "$key = :".$key.", ";
					$st = $st.$set;
					$counter++;
				}
			}

			$sql = "";
			$sql.="UPDATE kyc_user SET ".$st;
			$sql.=" WHERE id = ".$id;

			$stmt = $this->connect()->prepare($sql);

			foreach ($fields as $key => $value) {
				$stmt->bindValue(':'.$key, $value);
			}

			$stmtExec = $stmt->execute();

			if ($stmtExec) {
				header('Location:index.php');
			}
		}

		public function delete($id){
			$sql = "DELETE FROM kyc_user WHERE id = $id";

			$stmt = $this->connect()->prepare($sql);
			$stmt->bindValue(":id", $id);
			$stmt->execute();
		}


		public function handlError(){
			if (empty($first_name)) {
				$_SESSION['error["first_name"]'] = "First Name is required";
			}

			if (empty($last_name)) {
				$_SESSION['error["last_name"]'] = "Last Name is required";
			}

			if (empty($mobile)) {
				$_SESSION['error["mobile"]'] = "Mobile Number is required";
			}
			if (empty($dob)) {
				$_SESSION['error["dob"]'] = "DOB is required";
			}

			if (empty($image)) {
				$_SESSION['error["image"]'] = "Image is required";
			}

			header('Location:create.php');
			exit();
		}
	}
 ?>