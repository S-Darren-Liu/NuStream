<?php

	// Start Session
	session_start();

	/*
	Template Name: Admin Supplier Info
	*/

?>
<?php
	// Set Navigation URL
	$filesURL = get_home_url() . '/admin-files-management/';
	$createSupplierURL = get_home_url() . '/admin-create-supplier';
	$createMemberURL = get_home_url() . '/admin-create-agent-account';
	$memberInfoURL = get_home_url() . '/admin-member-info';
	$supplierInfoURL = get_home_url() . '/admin-supplier-info';

	// Check Session Exist
	if(!isset($_SESSION['AccountID'])){
		redirectToLogin();
	}

	// Logout User
	if(isset($_GET['logout'])) {
		logoutUser();
	}

	$UserName = $_SESSION['FirstName'] . " " . $_SESSION['LastName'];

	// Set URL
	$homeURL = get_home_url();
	$mainPath = $homeURL . "/wp-content/themes/NuStream/";
	$logo1ImagePath = $mainPath . "img/logo1.png";

	// Get Supplier Type
	$supplierType = $_GET['SType'];
	if($supplierType === null)
		$supplierType = "STAGING";


	$homeURL = get_home_url();
	echo '<table cellpadding="0" cellspacing="0" class="admin-info-centre-temp-table">';
		echo '<tr>';
		echo '<td>', '<a href="' . $homeURL . '/admin-info-centre/?SType=' . "STAGING" . '" />', 'Stage</td>';
		echo '<td>', '<a href="' . $homeURL . '/admin-info-centre/?SType=' . "PHOTOGRAPHY" . '" />', 'Photography</td>';
		echo '<td>', '<a href="' . $homeURL . '/admin-info-centre/?SType=' . "CLEANUP" . '" />', 'Clean Up</td>';
		echo '<td>', '<a href="' . $homeURL . '/admin-info-centre/?SType=' . "RELOCATEHOME" . '" />', 'Relocate Home</td>';
		echo '<td>', '<a href="' . $homeURL . '/admin-info-centre/?SType=' . "TOUCHUP" . '" />', 'Touch Up</td>';
		echo '<td>', '<a href="' . $homeURL . '/admin-info-centre/?SType=' . "INSPECTION" . '" />', 'Inspection</td>';
		echo '<td>', '<a href="' . $homeURL . '/admin-info-centre/?SType=' . "YARDWORK" . '" />', 'Yard Work</td>';
		echo '<td>', '<a href="' . $homeURL . '/admin-info-centre/?SType=' . "STORAGE" . '" />', 'Storage</td>';
		echo '</tr>';
	echo '</table><br />';

	// Get All Member Brief Info
	create_supplier_brief_table($supplierType);

	function create_supplier_brief_table($supplierType){
		$result = get_supplier_brief_info($supplierType);
		if($result === null)
			echo 'result is null';
		$result_rows = [];
		while($row = mysqli_fetch_array($result))
		{
			$result_rows[] = $row;
		}
		$homeURL = get_home_url();
		echo '<table cellpadding="0" cellspacing="0" class="admin-info-centre-temp-table">';
		echo '<tr><th class="primary-title">Supplier Name</th><th class="primary-title">Price Per Unit</th><th class="primary-title">Primary Contact Name</th><th class="primary-title">Primary Contact Number</th><th class="primary-title">Support Location</th></tr>';
		for($i = 0; $i < count($result_rows); $i++) {
			$supplierID = $result_rows[$i]["SupplierID"];
			echo '<form method="post">';
			echo '<tr>';
			echo '<td >', '<a href="' . $homeURL . '/edit-supplier/?SID=' . $supplierID . '" />', $result_rows[$i]["SupplierName"], '</td>';
			echo '<td>', $result_rows[$i]["PricePerUnit"], '</td>';
			echo '<td>', $result_rows[$i]["FirstContactName"], '</td>';
			echo '<td>', $result_rows[$i]["FirstContactNumber"], '</td>';
			echo '<td>', $result_rows[$i]["SupportLocation"], '</td>';
			echo '</tr>';
			echo '</form>';
		}
		echo '</table><br />';
	}
?>