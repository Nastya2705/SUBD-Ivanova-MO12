<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db.php";

if (count($_POST) > 0) {
	// Л/C
	if ($_POST['type'] == 1) {
		$flat_number  	= 	$_POST['flat_number'];
		$address  		= 	$_POST['address'];
		$owner  		= 	$_POST['owner'];
		$sql = "INSERT INTO `tb_ls`(`flat_number`, `address`, `owner`) 
		VALUES ('$flat_number', '$address', '$owner')";
		if (mysqli_query($conn, $sql)) {
			echo json_encode(array("statusCode" => 200));
		} else {
			echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}

	// Начисления
	if ($_POST['type'] == 21) {
		$id_ls  		= 	$_POST['id_ls'];
		$month   		= 	$_POST['smonth'];
		$syear  		= 	$_POST['syear'];
		$scount  		= 	$_POST['scount'];

		$sql = "INSERT INTO `tb_charges` (`id_ls`, `smonth`, `syear`, `scount`) 
			VALUES ('$id_ls', '$month', '$syear', '$scount') ";
		if (mysqli_query($conn, $sql)) {
			echo json_encode(array("statusCode" => 200));
		} else {
			echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
		}


		mysqli_close($conn);
	}

	// Платеж
	if ($_POST['type'] == 31) {
		$id_ls  		= 	$_POST['id_ls'];
		$month   		= 	$_POST['smonth'];
		$syear  		= 	$_POST['syear'];
		$scount  		= 	$_POST['scount'];

		$sql = "INSERT INTO `tb_payments` (`id_ls`, `smonth`, `syear`, `scount`) 
			VALUES ('$id_ls', '$month', '$syear', '$scount') ";
		if (mysqli_query($conn, $sql)) {
			echo json_encode(array("statusCode" => 200));
		} else {
			echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
		}


		mysqli_close($conn);
	}
}
