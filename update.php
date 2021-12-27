<?php
include $_SERVER['DOCUMENT_ROOT'] . "/db.php";

if (count($_POST) > 0) {
	// Л/C
	if ($_POST['type'] == 12) {

		$id  			= 	$_POST['id'];
		$address  		= 	$_POST['address'];
		$owner  		= 	$_POST['owner'];

		$sql = "UPDATE `tb_ls` SET `address`='$address', `owner`='$owner' WHERE id=$id";

		if (mysqli_query($conn, $sql)) {
			echo json_encode(array("statusCode" => 200));
		} else {
			echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
	}
	// Начисления
	if ($_POST['type'] == 22) {

		$idls = $_POST['idls'];
		$smonth = $_POST['smonth'];
		$syear = $_POST['syear'];
		$scount = $_POST['scount'];

		$sql = "UPDATE `tb_charges` SET `scount` = $scount WHERE id_ls = $idls and smonth = $smonth and syear = $syear";

		if (mysqli_query($conn, $sql)) {
			echo json_encode(array("statusCode" => 200));
		} else {
			echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
	}
	if ($_POST['type'] == 32) {

		$idls = $_POST['idls'];
		$smonth = $_POST['smonth'];
		$syear = $_POST['syear'];
		$scount = $_POST['scount'];

		$sql = "UPDATE `tb_payments` SET `scount` = $scount WHERE id_ls = $idls and smonth = $smonth and syear = $syear";

		if (mysqli_query($conn, $sql)) {
			echo json_encode(array("statusCode" => 200));
		} else {
			echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
	}
}
