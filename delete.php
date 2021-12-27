<?php
include 'db.php';

if (count($_POST) > 0) {
	// Л/С
	if ($_POST['type'] == 3) {

		$id = $_POST['id'];

		$sql = "DELETE FROM `tb_ls` WHERE id = $id ";

		if (mysqli_query($conn, $sql)) {
			echo '<script>alert("Л/С успешно удален !"); </script>';
		} else {
			echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
	}
	// Начисления
	if ($_POST['type'] == 23) {

		$idls = $_POST['idls'];
		$smonth = $_POST['smonth'];
		$syear = $_POST['syear'];

		$sql = "DELETE FROM `tb_charges` WHERE id_ls = $idls and smonth  = $smonth and syear = $syear";

		if (mysqli_query($conn, $sql)) {
			echo '<script>alert("Начисления успешно удалены !"); </script>';
		} else {
			echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
	}	

	// Платежи
	if ($_POST['type'] == 33) {

		$idls = $_POST['idls'];
		$smonth = $_POST['smonth'];
		$syear = $_POST['syear'];

		$sql = "DELETE FROM `tb_payments` WHERE id_ls = $idls and smonth  = $smonth and syear = $syear";

		if (mysqli_query($conn, $sql)) {
			echo '<script>alert("Платеж успешно удален !"); </script>';
		} else {
			echo "Ошибка: " . $sql . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
	}
}
