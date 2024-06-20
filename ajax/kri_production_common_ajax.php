<?php
require_once '../classes/function.php';
require_once '../classes/kri_function.php';
$obj = new web();
$objKri = new webKri();


if (isset($_POST['action']) && $_POST['action'] == 'OT_Sample_Collection_popup') {
	$API = $INPROCESSOPENSAMPLEINTIMATION . '&DocEntry=' . $_POST['DocEntry'] . '&BatchNo=' . $_POST['BatchNo'] . '&ItemCode=' . $_POST['ItemCode'] . '&LineNum=' . $_POST['LineNum'];

	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;
	echo json_encode($response);
	exit(0);
}

if (isset($_POST['action']) && $_POST['action'] == 'OT_OpenTransactionForQCPostDocumentRouteStagen_popup') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $API_RSQCPOSTDOC . '&DocEntry=' . $_POST['DocEntry'] . '&BatchNo=' . $_POST['BatchNo'] . '&ItemCode=' . $_POST['ItemCode'] . '&LineNum=' . $_POST['LineNum'];
	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	// print_r($API);die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	$FinalResponce['SampleCollDetails'] = $response;

	$general_data = $response[0]->RSQCPOSTROWDETAILS;

	if (empty($qcStatus)) {
		$qcStatusCount = 0;
	} else {
		$qcStatusCount = count($qcStatus);
	}

	if (empty($qcAttach)) {
		$qcqcAttachCount = 0;
	} else {
		$qcqcAttachCount = count($qcStatus);
	}

	if (!empty($general_data)) {
		for ($i = 0; $i < count($general_data); $i++) {
			$SrNo = $i;
			$index = $i + 1;

			$FinalResponce['general_data'] .= '<tr>
				<td class="desabled">' . $index . '</td>

				<td><input  type="text" class="form-control" id="parameter_code' . $SrNo . '" name="parameter_code[]" value="' . $general_data[$i]->PCode . '"></td>

				<td class="desabled"><input  type="text" class="form-control" id="PName' . $SrNo . '" name="PName[]" value="' . $general_data[$i]->PName . '" readonly></td>

				<td class="desabled" title="' . $general_data[$i]->Standard . '" style="cursor: pointer;">
					<input  type="text" class="form-control" id="Standard' . $SrNo . '" name="Standard[]" value="' . $general_data[$i]->Standard . '" readonly style="width:400px;">
				</td>

				<td>
					<input type="text" id="ResultOut' . $SrNo . '" name="ResultOut[]" value="" class="form-control" style="width:200px;">
				</td>';

			if ($general_data[$i]->PDType == 'Range') {
				$FinalResponce['general_data'] .= '<td>
						<input type="text" id="ComparisonResult' . $i . '" name="ComparisonResult[]" value="" class="form-control" style="width:100px;" onfocusout="CalculateResultOut(' . $i . ')">
					</td>';
			} else {
				$FinalResponce['general_data'] .= '<td class="desabled">
						<input type="text" id="ComparisonResult' . $i . '" name="ComparisonResult[]" value="" class="form-control textbox_bg" style="width:100px;" readonly>
					</td>';
			}

			$FinalResponce['general_data'] .= '<td id="ResultOutputByQCDeptTd' . $i . '">
					<select id="ResultOutputByQCDept' . $i . '" name="ResultOutputByQCDept[]" class="form-select" style="border: 1px solid #ffffff !important;" onchange="OnChangeResultOutputByQCDept(' . $i . ')"></select>
				</td>

				<td class="desabled">
					<input type="text" id="PDType' . $i . '" name="PDType[]" value="' . $general_data[$i]->PDType . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="Logical' . $i . '" name="Logical[]" value="' . $general_data[$i]->Logical . '" class="form-control textbox_bg" style="width: 100px;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="LowMin' . $i . '" name="LowMin[]" value="' . $general_data[$i]->LowMin . '" class="form-control textbox_bg" style="width:100px;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="UppMax' . $i . '" name="UppMax[]" value="' . $general_data[$i]->UppMax . '" class="form-control textbox_bg" style="width:100px;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="Min' . $i . '" name="Min[]" value="' . $general_data[$i]->Min . '" class="form-control textbox_bg" style="width:100px;" readonly>
				</td>

				<td id="QC_StatusByAnalystTd' . $i . '">
					<select id="QC_StatusByAnalyst' . $i . '" name="QC_StatusByAnalyst[]" class="form-select" onchange="SelectedQCStatus(' . $i . ')" style="border: transparent;"></select>
				</td>

				<td class="desabled">
					<input type="text" id="TMethod' . $i . '" name="TMethod[]" value="' . $general_data[$i]->TMethod . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="MType' . $i . '" name="MType[]" value="' . $general_data[$i]->MType . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="PharmacopeiasStandard' . $i . '" name="PharmacopeiasStandard[]" value="' . $general_data[$i]->PharmacopeiasStandard . '"" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="UOM' . $i . '" name="UOM[]" value="' . $general_data[$i]->UOM . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="Retest' . $i . '" name="Retest[]" value="' . $general_data[$i]->Retest . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="ExSample' . $i . '" name="ExSample[]" value="' . $general_data[$i]->ExSample . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td>
					<select id="AnalysisBy' . $i . '" name="AnalysisBy[]" class="form-select" style="width: 140px;"></select>
				</td>

				<td>
					<input type="text" id="analyst_remark' . $i . '" name="analyst_remark[]" class="form-control">
				</td>

				<td class="desabled">
					<input type="text" id="LowMax' . $i . '" name="LowMax[]" value="' . $general_data[$i]->LowMax . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="Release' . $i . '" name="Release[]" value="' . $general_data[$i]->Release . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td>
					<input type="text" id="DescriptiveDetails' . $i . '" name="DescriptiveDetails[]" class="form-control">
				</td>

				<td class="desabled">
					<input type="text" id="UppMin' . $i . '" name="UppMin[]" value="' . $general_data[$i]->UppMin . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td>
					<input type="number" id="LowMinRes' . $i . '" name="LowMinRes[]" class="form-control">
				</td>

				<td>
					<input type="number" id="UppMinRes' . $i . '" name="UppMinRes[]" class="form-control">
				</td>

				<td>
					<input type="number" id="UppMaxRes' . $i . '" name="UppMaxRes[]" class="form-control">
				</td>

				<td>
					<input type="number" id="MeanRes' . $i . '" name="MeanRes[]" class="form-control">
				</td>

				<td>
					<input type="text" id="UserText1' . $i . '" name="UserText1[]" class="form-control">
				</td>

				<td>
					<input type="text" id="UserText2' . $i . '" name="UserText2[]" class="form-control">
				</td>

				<td>
					<input type="text" id="UserText3' . $i . '" name="UserText3[]" class="form-control">
				</td>

				<td>
					<input type="text" id="UserText4' . $i . '" name="UserText4[]" class="form-control">
				</td>

				<td>
					<input type="text" id="UserText5' . $i . '" name="UserText5[]" class="form-control">
				</td>

				<td class="desabled">
					<input type="text" id="QC_StatusResult' . $i . '" name="QC_StatusResult[]" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="Stability' . $i . '" name="Stability[]" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="Appassay' . $i . '" name="Appassay[]" value="' . $general_data[$i]->Appassay . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="AppLOD' . $i . '" name="AppLOD[]" value="' . $general_data[$i]->AppLOD . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td>
					<input type="text" id="InstrumentCode' . $i . '" name="InstrumentCode[]" class="form-control" data-bs-toggle="modal" data-bs-target=".instrument_modal" onclick="OpenInstrmentModal(' . $i . ')">
				</td>

				<td class="desabled">
					<input type="text" id="InstrumentName' . $i . '" name="InstrumentName[]" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td>
					<input type="date" id="StartDate' . $i . '" name="StartDate[]" class="form-control">
				</td>

				<td>
					<input type="time" id="StartTime' . $i . '" name="StartTime[]" class="form-control">
				</td>

				<td>
					<input type="date" id="EndDate' . $i . '" name="EndDate[]" class="form-control">
				</td>

				<td>
					<input type="time" id="EndTime' . $i . '" name="EndTime[]" class="form-control">
				</td>
			</tr>';
		}
	} else {
		$FinalResponce['general_data'] .= '<tr><td colspan="41" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}

	$FinalResponce['count'] = count($general_data);

	$FinalResponce['qcStatus'] .= '<tr id="add-more_1">
		<td>' . (($qcStatusCount) + 1) . '</td>

		<td><select id="qc_Status_1" name="qc_Status[]" class="form-select qc_status_selecte1" onchange="SelectionOfQC_Status(' . (($qcStatusCount) + 1) . ')"></select></td>

		<td><input class="border_hide" type="text"  id="qCStsQty_1" name="qCStsQty[]" class="form-control" value="" onfocusout="addMore(1)"></td>

			<td><input class="border_hide" type="text"  id="qCReleaseDate_1" name="qCReleaseDate[]" class="form-control" readonly></td>

			<td><input class="border_hide" type="text"  id="qCReleaseTime_1" name="qCReleaseTime[]" class="form-control" readonly></td>

		<td><input class="border_hide" type="text"  id="qCitNo_1" name="qCitNo[]" class="form-control" value=""></td>

		<td>
			<select id="doneBy_1" name="doneBy[]" class="form-select done-by-mo1"></select>
		</td>

			<td><input class="border_hide" type="file"  id="qCAttache1_1" name="qCAttache1[]" class="form-control"></td>

			<td><input class="border_hide" type="file"  id="qCAttache2_1" name="qCAttache2[]" class="form-control"></td>

			<td><input class="border_hide" type="file"  id="qCAttache3_1" name="qCAttache3[]" class="form-control"></td>

			<td><input class="border_hide" type="date"  id="qCDeviationDate_1" name="qCDeviationDate[]" class="form-control"></td>

			<td><input class="border_hide" type="text"  id="qCDeviationNo_1" name="qCDeviationNo[]" class="form-control"></td>

			<td><input class="border_hide" type="text"  id="qCDeviationResion_1" name="qCDeviationResion[]" class="form-control"></td>

		<td><input class="border_hide" type="text"  id="qCStsRemark1_1" name="qCStsRemark1[]" class="form-control" value=""></td>
	</tr>';


	$FinalResponce['qcAttach'] .= '<tr>
		<td class="desabled"></td>
		<td class="desabled"><input class="border_hide desabled" type="text" id="targetPath" name="targetPath[]" class="form-control" value="" readonly></td>
		<td class="desabled"><input class="border_hide desabled" type="text" id="fileName" name="fileName[]"  class="form-control" value="" readonly></td>
		<td class="desabled"><input class="border_hide desabled" type="text" id="attachDate" name="attachDate[]"  class="form-control" value="" readonly></td>
		<td><input class="border_hide" type="text" id="remark" name="remark[]"  class="form-control" value=""></td>
	</tr>';

	echo json_encode($FinalResponce);
	exit(0);
}



if (isset($_POST['action']) && $_POST['action'] == 'getSeriesDropdown_ajax') {
	$TrDate = date('Ymd', strtotime(str_replace('/', '-', $_POST['TrDate'])));
	$ObjectCode = trim(addslashes(strip_tags($_POST['ObjectCode'])));
	$Final_API = $INWARDQCSERIES_API . $ObjectCode . '&TRDate=' . $TrDate . '&UserName=' . $_SESSION['Baroque_eMail'];

	$response = $obj->GetSeriesDropdown($Final_API);
	echo json_encode($response);
	exit(0);
}

if (isset($_POST['action']) && $_POST['action'] == 'getSeriesSingleData_ajax') {
	$TrDate = date('Ymd', strtotime(str_replace('/', '-', $_POST['TrDate'])));
	$ObjectCode = trim(addslashes(strip_tags($_POST['ObjectCode'])));
	$Series = trim(addslashes(strip_tags($_POST['Series'])));

	$Final_API = $INWARDQCSERIES_API . $ObjectCode . '&Series=' . $Series . '&TRDate=' . $TrDate . '&UserName=' . $_SESSION['Baroque_eMail'];
	$response = $obj->GetSeriesSingleData($Final_API);

	echo json_encode($response);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'dropdownMaster_ajax') {
	$TableId = trim(addslashes(strip_tags($_POST['TableId'])));
	$Alias = trim(addslashes(strip_tags($_POST['Alias'])));
	$Final_API = $VALIDVALUES . '?TableId=' . $TableId . '&Alias=' . $Alias;

	$response = $objKri->getAnyDorpDownMasterFun_kri($Final_API);

	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";

	// exit;

	echo json_encode($response);
	exit(0);
}

if (isset($_POST['action']) && $_POST['action'] == 'releaseMaterial_dropdownMaster_ajax') {
	// $TableId=trim(addslashes(strip_tags($_POST['TableId'])));
	// $Alias=trim(addslashes(strip_tags($_POST['Alias'])));
	$Final_API = $SAMINTSTYPE_API;
	// print_r($Final_API);
	// die();
	$response = $objKri->getreleaseMaterialDorpDownMasterFun_kri($Final_API);


	echo json_encode($response);
	exit(0);
}

if (isset($_POST['action']) && $_POST['action'] == 'TR_ByDropdown_ajax') {
	$response = $obj->GetTR_ByDropdown($INPROCESSSAMINTTRBY);
	echo json_encode($response);
	exit(0);
}

if (isset($_POST['action']) && $_POST['action'] == 'SampleTypeDropdown_ajax') {
	$response = $obj->GetSampleTypeDropdown($SAMINTSTYPE_API);
	echo json_encode($response);
	exit(0);
}

if (isset($_POST['SampleIntimationInProcessBtn'])) {
	$tdata = array(); // This array send to AP Standalone Invoice process 

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['DocNo'])));
	$tdata['Remark'] = trim(addslashes(strip_tags($_POST['Remark'])));
	$tdata['Object'] = trim(addslashes(strip_tags('SCS_SINPROCESS')));
	$tdata['U_PC_BLin'] = trim(addslashes(strip_tags($_POST['LineNum'])));
	$tdata['U_PC_RNo'] = trim(addslashes(strip_tags($_POST['ReceiptNo'])));
	$tdata['U_PC_REnt'] = trim(addslashes(strip_tags($_POST['ReceiptNo1'])));
	$tdata['U_PC_WoNo'] = trim(addslashes(strip_tags($_POST['woNo'])));
	$tdata['U_PC_WoEnt'] = trim(addslashes(strip_tags($_POST['woEntry'])));
	$tdata['U_PC_SType'] = trim(addslashes(strip_tags($_POST['sampleType'])));
	$tdata['U_PC_TRBy'] = trim(addslashes(strip_tags($_POST['TrBy'])));
	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['itemCode'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['itemName'])));
	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['sampleQty'])));
	$tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['RetainQty'])));
	$tdata['U_PC_Unit'] = trim(addslashes(strip_tags($_POST['Unit'])));
	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['Branch'])));
	$tdata['U_PC_ChNo'] = trim(addslashes(strip_tags($_POST['ChallanNo'])));
	$tdata['U_PC_ChDate'] = trim(addslashes(strip_tags($_POST['ChallanDate'])));
	$tdata['U_PC_GENo'] = trim(addslashes(strip_tags($_POST['GateEntryNo'])));
	$tdata['U_PC_CNos'] = trim(addslashes(strip_tags($_POST['ContainerNo'])));
	$tdata['U_PC_Cont'] = $_POST['Container'] != '' ? $_POST['Container'] : 0;
	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['BatchNo'])));
	$tdata['U_PC_BQty'] = trim(addslashes(strip_tags($_POST['BatchQty'])));
	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['BPLId'])));
	$tdata['U_PC_LCode'] = trim(addslashes(strip_tags($_POST['LocCode'])));
	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['Location'])));
	$tdata['U_PC_RDt'] = trim(addslashes(strip_tags($_POST['RetestDate'])));
	$tdata['U_PC_MakeBy'] = trim(addslashes(strip_tags($_POST['MakeBy'])));

	$tdata['U_PC_TNCont'] = $_POST['totalNoOfContainer'] != '' ? $_POST['totalNoOfContainer'] : 0;
	$tdata['U_PC_TNCont1'] = $_POST['QtyPerContainer'] != '' ? $_POST['QtyPerContainer'] : 0;
	$tdata['U_PC_FCont'] = $_POST['fromContainer'] != '' ? $_POST['fromContainer'] : 0;
	$tdata['U_PC_TCont'] = $_POST['ToContainer'] != '' ? $_POST['ToContainer'] : 0;

	$tdata['U_PC_UTTrans'] = null;
	$tdata['U_PC_RcQty'] = trim(addslashes(strip_tags($_POST['wOQty'])));

	if (!empty($_POST['TrDate'])) {
		$tdata['U_PC_TRDte'] = date('Y-m-d', strtotime($_POST['TrDate']));
	} else {
		$tdata['U_PC_TRDte'] = '';
	}

	if (!empty($_POST['GateEntryDate'])) {
		$tdata['U_PC_GEDte'] = date('Y-m-d', strtotime($_POST['GateEntryDate']));
	} else {
		$tdata['U_PC_GEDte'] = '';
	}

	if (!empty($_POST['MFGDate'])) {
		$tdata['U_PC_MfgDt'] = date('Y-m-d', strtotime($_POST['MFGDate']));
	} else {
		$tdata['U_PC_MfgDt'] = '';
	}

	if (!empty($_POST['ExpiryDate'])) {
		$tdata['U_PC_ExpDt'] = date('Y-m-d', strtotime($_POST['ExpiryDate']));
	} else {
		$tdata['U_PC_ExpDt'] = '';
	}

	// <!-- ---------------------- sample Intimation popup validation start Here ------------------ -->
	if ($_POST['sampleType'] == '') {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = "Sample Type Mandatory.";
		echo json_encode($data);
		exit(0);
	}

	if ($_POST['TrBy'] == '') {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = "TR Type Mandatory.";
		echo json_encode($data);
		exit(0);
	}

	if ($_POST['TrDate'] == '') {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = "TR Date Mandatory.";
		echo json_encode($data);
		exit(0);
	}
	// <!-- ---------------------- sample Intimation popup validation end Here -------------------- -->

	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SINPROCESS;

		$responce_encode = $obj->SaveSampleIntimation($tdata, $Final_API); // sample intimation save here
		$responce = json_decode($responce_encode);

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();

		if ($responce->DocNum != "") {
			$InventoryGenEntries = array();
			$InventoryGenEntries['SIDocEntry'] = trim($responce->DocEntry);
			$InventoryGenEntries['GRDocEntry'] = trim($_POST['ReceiptNo1']);
			$InventoryGenEntries['ItemCode'] = trim($responce->U_PC_ICode);
			$InventoryGenEntries['LineNum'] = trim($responce->U_PC_BLin);

			$Final_API = $GRSAMPLEINTIINPROCESS_APi;
			$responce_encode1 = $obj->POST_QuerryBasedMasterFunction($InventoryGenEntries, $Final_API);
			$responce1 = json_decode($responce_encode1);

			if (empty($responce1)) {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Sample Intimation - In Process Add Successfully.";
				echo json_encode($data);
			} else {
				if (array_key_exists('error', (array)$responce1)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce1->error->message->value;
					echo json_encode($data);
				}
			}
		} else {
			if (array_key_exists('error', (array)$responce)) {
				$data['status'] = 'False';
				$data['DocEntry'] = '';
				$data['message'] = $responce->error->message->value;
				echo json_encode($data);
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}



if (isset($_POST['action']) && $_POST['action'] == 'sample_intimation_in_process_ajax') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $INPROCESSSAMPLEINTIMATIONADD . '?DocEntry=' . $DocEntry;

	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	// print_r($FinalAPI);die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);

	echo json_encode($response);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'sample_collecton_in_process_ajax') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));
	$rowCount_N = trim(addslashes(strip_tags($_POST['rowCount_N'])));
	$rowCount = trim(addslashes(strip_tags($_POST['rowCount'])));

	$API = $INPROCESSSAMPCOLLADD . '?DocEntry=' . $DocEntry;

	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->


	// print_r($FinalAPI);
	// die();

	$response = $obj->get_OTFSI_SingleData($FinalAPI);

	$FinalResponce = array();
	$FinalResponce['SampleCollDetails'] = $response;

	$ExternalIssue = $response[0]->INPROCESSSAMCOLLEXTERNAL; //External issue reponce seperate here
	//  print_r(($ExternalIssue));die();

	$ExtraIssue = $response[0]->INPROCESSSAMCOLLEXTRA; // Etra issue response seperate here 

	// ===================================================================================================================================
	// =======================================================================================================
	// <!-- ----------- Extra Issue Start here --------------------------------- -->
	if (!empty($ExtraIssue)) {
		for ($i = 0; $i < count($ExtraIssue); $i++) {

			$SrNo = $rowCount_N + 1;

			if (!empty($ExtraIssue[$i]->IssueDate)) {
				$IssueDate = date("d-m-Y", strtotime($ExtraIssue[$i]->IssueDate));
			} else {
				$IssueDate = '';
			}

			$FinalResponce['ExtraIssue'] .= '<tr>
					<td>
						<input type="radio" id="ExtraIslist' . $SrNo . '" name="ExtraIslistRado" value="' . $SrNo . '" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExtraIssue(' . $SrNo . ')">
					</td>

					<td class="desabled">
						<input class="border_hide" type="hidden" id="SC_FEI_Linenum' . $SrNo . '" name="SC_FEI_Linenum[]" value="' . $ExtraIssue[$i]->LineNum . '" class="form-control desabled" >

						<input class="border_hide  form-control desabled" type="text" id="SC_FEI_SampleQuantity' . $SrNo . '" name="SC_FEI_SampleQuantity[]" value="' . $ExtraIssue[$i]->sampleQty2 . '" onfocusout="GetExtraIuuseWhs(' . $SrNo . ')" readonly >

					</td>

					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_UOM' . $SrNo . '" name="SC_FEI_UOM[]" value="' . $ExtraIssue[$i]->UOM2 . '" class="form-control desabled" readonly></td>

					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_Warehouse' . $SrNo . '" name="SC_FEI_Warehouse[]" value="' . $ExtraIssue[$i]->Whs2 . '" class="form-control desabled" readonly></td>

					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_SampleBy' . $SrNo . '" name="SC_FEI_SampleBy[]" value="' . $ExtraIssue[$i]->SampleBy . '" class="form-control desabled" readonly></td>

					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_IssueDate' . $SrNo . '" name="SC_FEI_IssueDate[]" value="' . $IssueDate . '" class="form-control desabled" readonly></td>

					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_PostExtraIssue' . $SrNo . '" name="SC_FEI_PostExtraIssue[]" value="' . $ExtraIssue[$i]->PostExtraIssue . '" class="form-control desabled" readonly></td>
				 </tr>';
		}
		// when table data come then default add one manual row start ---------------------------------------------------------
		$SrNo = (count($ExtraIssue) + 1);
		$FinalResponce['ExtraIssue'] .= '<tr>
				<td class="desabled">
					
				</td>

				<td>
					<input class="border_hide" type="hidden" id="SC_FEI_Linenum' . $SrNo . '" name="SC_FEI_Linenum[]" value="' . $ExtraIssue[$i]->LineNum . '" class="form-control" >

					<input class="border_hide  form-control" type="text" id="SC_FEI_SampleQuantity' . $SrNo . '" name="SC_FEI_SampleQuantity[]" value="' . $ExtraIssue[$i]->sampleQty2 . '" onfocusout="GetExtraIuuseWhs(' . $SrNo . ')" >

				</td>

				<td class="desabled">
					<input class="border_hide desabled" type="text" id="SC_FEI_UOM' . $SrNo . '" name="SC_FEI_UOM[]" value="' . $ExtraIssue[$i]->UOM2 . '" class="form-control" readonly >
				</td>

			   
				
					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_Warehouse' . $SrNo . '" name="SC_FEI_Warehouse[]" value="' . $ExtraIssue[$i]->Whs2 . '" class="form-control desabled" readonly></td>



				<td class="desabled">
				
					<input class="border_hide desabled" type="text" id="SC_FEI_SampleBy' . $SrNo . '" name="SC_FEI_SampleBy[]" value="' . $ExtraIssue[$i]->SampleBy . '" class="form-control">
				</td>

				<td>
					<input class="border_hide" type="text" id="SC_FEI_IssueDate' . $SrNo . '" name="SC_FEI_IssueDate[]" value="' . $IssueDate . '" class="form-control">
				</td>

				<td>
					<input class="border_hide" type="text" id="SC_FEI_PostExtraIssue' . $SrNo . '" name="SC_FEI_PostExtraIssue[]" value="' . $ExtraIssue[$i]->PostExtraIssue . '" class="form-control">
				</td>
			 </tr>';

		// onchange="ExternalIssueSelectedBP('.$SrNo.')"  ---->  warehouse selection onchange function
	} else {
		$SrNo = $rowCount_N + 1;
		$FinalResponce['ExtraIssue'] .= '<tr>
				<td class="desabled">
					' . $SrNo . '
				</td>

				<td>
					<input class="border_hide" type="hidden" id="SC_FEI_Linenum' . $SrNo . '" name="SC_FEI_Linenum[]" value="' . $ExtraIssue[$i]->LineNum . '" class="form-control" >

					<input class="border_hide  form-control" type="text" id="SC_FEI_SampleQuantity' . $SrNo . '" name="SC_FEI_SampleQuantity[]" value="' . $ExtraIssue[$i]->sampleQty2 . '" onfocusout="GetExtraIuuseWhs(' . $SrNo . ')" >

				</td>

				<td class="desabled">
					<input class="border_hide desabled " type="text" id="SC_FEI_UOM' . $SrNo . '" name="SC_FEI_UOM[]" value="' . $ExtraIssue[$i]->UOM2 . '" class="form-control" readonly>
				</td>

				
				<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_Warehouse' . $SrNo . '" name="SC_ExternalI_SupplierCode[]" value="' . $ExtraIssue[$i]->Whs2 . '" class="form-control desabled" readonly></td>

				<td class="desabled">
					<input class="border_hide desabled" type="text" id="SC_FEI_SampleBy' . $SrNo . '" name="SC_FEI_SampleBy[]" value="' . $ExtraIssue[$i]->SampleBy . '" class="form-control">
				</td>

				<td class="desabled">
					<input class="border_hide desabled" type="text" id="SC_FEI_IssueDate' . $SrNo . '" name="SC_FEI_IssueDate[]" value="' . $IssueDate . '" class="form-control">
				</td>

				<td>
					<input class="border_hide" type="text" id="SC_FEI_PostExtraIssue' . $SrNo . '" name="SC_FEI_PostExtraIssue[]" value="' . $ExtraIssue[$i]->PostExtraIssue . '" class="form-control">
				</td>
			 </tr>';
	}

	// <!-- ----------- Extra Issue End here --------------------------------- -->
	// =======================================================================================================


	// <!-- ----------- External Issue Start Here ---------------------------- -->


	if (!empty($ExternalIssue)) {


		for ($j = 0; $j < (count($ExternalIssue)); $j++) {

			$SrNo = $rowCount + 1;
			// if(count($ExternalIssue)==$SrNo){
			if (!empty($ExternalIssue[$j]->SampleDate)) {
				$SampleDate = date("d-m-Y", strtotime($ExternalIssue[$j]->SampleDate));
			} else {
				$SampleDate = '';
			}


			$FinalResponce['ExternalIssue'] .= '<tr class="1111">
					
					<td style="text-align: center;">
						<input class="border_hide" type="hidden" id="SC_FEXI_Linenum' . $SrNo . '" name="SC_FEXI_Linenum[]" value="' . $ExternalIssue[$j]->Linenum . '" class="form-control desabled" readonly>

						<input type="radio" id="list' . $SrNo . '" name="listRado" value="' . $SrNo . '" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExternalIssue(' . $SrNo . ')">
					</td>
					
					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierCode' . $SrNo . '" name="SC_FEXI_SupplierCode[]" value="' . $ExternalIssue[$j]->SupplierCode . '" class="form-control desabled" readonly></td>
					
					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName' . $SrNo . '" name="SC_FEXI_SupplierName[]" value="' . $ExternalIssue[$j]->SupplierName . '" class="form-control desabled" readonly></td>
					
					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UOM' . $SrNo . '" name="SC_FEXI_UOM[]" value="' . $ExternalIssue[$j]->UOM1 . '" class="form-control desabled" readonly></td>
					
					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleDate' . $SrNo . '" name="SC_FEXI_SampleDate[]" value="' . $SampleDate . '" class="form-control desabled" readonly></td>
					
					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Warehouse' . $SrNo . '" name="SC_FEXI_Warehouse[]" value="' . $ExternalIssue[$j]->Whs1 . '" class="form-control desabled" readonly></td>
					
					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleQuantity' . $SrNo . '" name="SC_FEXI_SampleQuantity[]" value="' . $ExternalIssue[$j]->SampleQuantity . '" class="form-control desabled" readonly></td>
					
					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer' . $SrNo . '" name="SC_FEXI_InventoryTransfer[]" value="' . $ExternalIssue[$j]->InventoryTransfer . '" class="form-control desabled" readonly></td>

					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText1' . $SrNo . '" name="SC_FEXI_UserText1[]" value="' . $ExternalIssue[$j]->UserText1 . '" class="form-control desabled" readonly></td>

					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText2' . $SrNo . '" name="SC_FEXI_UserText2[]" value="' . $ExternalIssue[$j]->UserText2 . '" class="form-control desabled" readonly></td>

					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText3' . $SrNo . '" name="SC_FEXI_UserText3[]" value="' . $ExternalIssue[$j]->UserText3 . '" class="form-control desabled" readonly></td>

					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment' . $SrNo . '" name="SC_FEXI_Attachment[]" value="' . $ExternalIssue[$j]->Attachment . '" class="form-control"></td>
				</tr>';
			//}
		}

		// when table data come then default add one manual row start ---------------------------------------------------------
		$SrNo = (count($ExternalIssue));

		$FinalResponce['ExternalIssue'] .= '<tr class="2222">
			<td></td>
			 
			 <td>
				 <input class="border_hide" type="hidden" id="SC_FEXI_Linenum' . $SrNo . '" name="SC_FEXI_Linenum[]" value="" class="form-control desabled" readonly>

				<select class="form-control ExternalIssueSelectedBPWithData" id="SC_ExternalI_SupplierCode' . $SrNo . '" name="SC_FEXI_SupplierCode[]" onchange="ExternalIssueSelectedBP(' . $SrNo . ')" style="width: 200px;">
				</select>
			</td>
			
			<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName' . $SrNo . '" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>
			
			<td class="desabled" ><input class="border_hide desabled" type="text" id="SC_FEXI_UOM' . $SrNo . '" name="SC_FEXI_UOM[]" class="form-control desabled" readonly></td>
			
			<td><input class="border_hide" type="date" id="SC_FEXI_SampleDate' . $SrNo . '" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>
			
			<td class="desabled"><input class="border_hide desabled" type="text" id="SC_ExternalI_Warehouse' . $SrNo . '" name="SC_FEXI_Warehouse[]" class="form-control desabled" readonly></td>
			
			<td><input class="border_hide" type="text" id="SC_FEXI_SampleQuantity' . $SrNo . '" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>
			
			<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer' . $SrNo . '" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

			<td><input class="border_hide" type="text" id="SC_FEXI_UserText1' . $SrNo . '" name="SC_FEXI_UserText1[]" class="form-control"></td>

			<td><input class="border_hide" type="text" id="SC_FEXI_UserText2' . $SrNo . '" name="SC_FEXI_UserText2[]" class="form-control"></td>

			<td><input class="border_hide" type="text" id="SC_FEXI_UserText3' . $SrNo . '" name="SC_FEXI_UserText3[]" class="form-control"></td>

			<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment' . $SrNo . '" name="SC_FEXI_Attachment[]" class="form-control"></td>
		</tr>';
		// when table data come then default add one manual row end -----------------------------------------------------------
	} else {
		// if user not added External issue recored then show default blank row
		$SrNo = $rowCount + 1;

		$FinalResponce['ExternalIssue'] .= '<tr class="3333">
			<td>
				<input class="border_hide" type="text" id="SC_FEXI_Linenum' . $SrNo . '" name="SC_FEXI_Linenum[]" value="' . $SrNo . '" class="form-control desabled" readonly>
			</td>
			 
			 <td>
				<select class="form-control ExternalIssueDefault" id="SC_ExternalI_SupplierCode' . $SrNo . '" name="SC_FEXI_SupplierCode[]" onchange="ExternalIssueSelectedBP(' . $SrNo . ')" style="width: 200px;">
					 
				</select>
			</td>
			
			<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName' . $SrNo . '" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>
			
			<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UOM' . $SrNo . '" name="SC_FEXI_UOM[]" class="form-control desabled" readonly></td>
			
			<td><input class="border_hide" type="date" id="SC_FEXI_SampleDate' . $SrNo . '" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>
			
			
			<td class="desabled"><input class="border_hide desabled" type="text" id="SC_ExternalI_Warehouse' . $SrNo . '" name="SC_FEXI_Warehouse[]" class="form-control desabled" readonly></td>
			
			<td><input class="border_hide" type="text" id="SC_FEXI_SampleQuantity' . $SrNo . '" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>
			
			<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer' . $SrNo . '" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

			<td><input class="border_hide" type="text" id="SC_FEXI_UserText1' . $SrNo . '" name="SC_FEXI_UserText1[]" class="form-control"></td>

			<td><input class="border_hide" type="text" id="SC_FEXI_UserText2' . $SrNo . '" name="SC_FEXI_UserText2[]" class="form-control"></td>

			<td><input class="border_hide" type="text" id="SC_FEXI_UserText3' . $SrNo . '" name="SC_FEXI_UserText3[]" class="form-control"></td>

			<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment' . $SrNo . '" name="SC_FEXI_Attachment[]" class="form-control"></td>
		</tr>';
	}

	echo json_encode($FinalResponce);
	exit(0);

	// echo json_encode($response);
	// exit(0);
}






if (isset($_POST['action']) && $_POST['action'] == 'SupplierSingleData_ajax') {
	$SupplierCode = trim(addslashes(strip_tags($_POST['SupplierCode'])));
	// <!-- =============== get supplier dropdown start here ========================================== -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$BP_Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_BusinessPartners;
		// print_r($BP_Final_API);die();
		$responce_encode_BP = $obj->getFunctionServiceLayer($BP_Final_API);
		$responce_BP = json_decode($responce_encode_BP);

		$option .= '<option value="">-</option>';
		for ($i = 0; $i < count($responce_BP->value); $i++) {

			if ($responce_BP->value[$i]->CardCode == $SupplierCode) {
				$SupplierName = $responce_BP->value[$i]->CardName;
			}
		}
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	// <!-- =============== get supplier dropdown end here ============================================ -->

	echo json_encode($SupplierName);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'SupplierDropdown_ajax') {
	// SAP Service Layer Login
	$res = $obj->SAP_Login();

	if (!empty($res)) {
		$BP_Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_BusinessPartners . '?$select=CardCode,CardName';

		$response_encode_BP = $obj->getFunctionServiceLayer($BP_Final_API);

		$response_BP = json_decode($response_encode_BP);

		// Check if the response contains data
		if (isset($response_BP->value) && is_array($response_BP->value)) {
			// Using a buffer for efficient string concatenation
			$options = '<option value="">-</option>';
			foreach ($response_BP->value as $bp) {
				$options .= '<option value="' . htmlspecialchars($bp->CardCode) . '">' . htmlspecialchars($bp->CardCode) . '</option>';
			}

			// Send the options as a JSON response
			echo json_encode($options);
		} else {
			echo json_encode('<option value="">No suppliers found</option>');
		}

		// SAP Service Layer Logout
		$obj->SAP_Logout();
	} else {
		// Handle login failure
		echo json_encode('<option value="">Failed to login to SAP</option>');
	}

	exit(0);
}




if (isset($_POST['action']) && $_POST['action'] == 'WareHouseDropdown_ajax') {
	// <!-- =============== get supplier dropdown start here ========================================== -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_Warehouses . '?$select=WarehouseCode,WarehouseName';
		$responce_encode = $obj->getFunctionServiceLayer($Final_API);
		$responce = json_decode($responce_encode);

		$option .= '<option value="">-</option>';
		for ($i = 0; $i < count($responce->value); $i++) {

			$option .= '<option value="' . $responce->value[$i]->WarehouseCode . '">' . $responce->value[$i]->WarehouseCode . '</option>';
		}
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	// <!-- =============== get supplier dropdown end here ============================================ -->

	echo json_encode($option);
	exit(0);
}

if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransfer_ajax') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $INPROCESSSAMPLEINTIMATIONADD . '?DocEntry=' . $DocEntry;

	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// print_r($FinalAPI);die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($API);
	// echo "</pre>";
	// exit;

	// $ExtraIssue=$response[0]->SAMPLECOLLEXTRA; // Etra issue response seperate here 
	// $ExternalIssue=$response[0]->SAMPLECOLLEXTERNAL; //External issue reponce seperate here


	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {
		$option = '<tr>
				<td class="desabled">
					<input type="hidden" id="it_RFPODocEntry" name="it_RFPODocEntry" value="' . $response[0]->RFPODocEntry . '">
					<input type="hidden" id="it_BatchNo" name="it_BatchNo" value="' . $response[0]->BatchNo . '">

					1
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_ItemCode" name="itP_ItemCode" class="form-control" value="' . $response[0]->ItemCode . '" readonly>
				</td>

				<td class="desabled">' . $response[0]->ItemName . '</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_BQty" name="itP_BQty" class="form-control" value="' . $response[0]->BatchQty . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_FromWhs" name="itP_FromWhs" class="form-control" value="' . $response[0]->FromWhse . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_ToWhs" name="itP_ToWhs" class="form-control" value="' . $response[0]->ToWhse . '" readonly>
				</td>
				<td class="desabled">' . $response[0]->Location . '</td>
				<td class="desabled">' . $response[0]->Unit . '</td>
			</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}



if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransfer_process_in_ajax') {

	$ItemCode = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs = trim(addslashes(strip_tags($_POST['FromWhs'])));
	$GRPODEnt = trim(addslashes(strip_tags($_POST['DocEntry'])));
	$BNo = trim(addslashes(strip_tags($_POST['BNo'])));

	$afterSet = trim(addslashes(strip_tags($_POST['afterSet'])));

	// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API = $INPROCESSSAMINTICONTSEL . '?ItemCode=' . $ItemCode . '&WareHouse=' . $FromWhs . '&DocEntry=' . $GRPODEnt . '&BatchNo=' . $BNo;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here -------------------------------------------- -->
	// print_r($API);
	// die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 

	$option .= ' <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style=""> <thead class="fixedHeader1">
                    <tr>';
	if ($afterSet == "") {
		$option .= '<th>Select</th>';
	}

	$option .= '<th>Item Code</th>
		                        <th>Item Name</th>
		                        <th>Container No</th>
		                        <th>Batch</th>
		                        <th>Batch Qty</th>';
	if ($afterSet == "") {
		$option .= '<th>Select Qty</th>';
	}
	$option .= '<th>Mfg Date</th> 
							<th>Expiry Date</th>
                    </tr>
                </thead>';
	$option .= '<tbody>';

	if (!empty($response)) {
		for ($i = 0; $i < count($response); $i++) {

			$MfgDate = (!empty($response[$i]->MfgDate)) ? date("d-m-Y", strtotime($response[$i]->MfgDate)) : null;
			$ExpiryDate = (!empty($response[$i]->ExpiryDate)) ? date("d-m-Y", strtotime($response[$i]->ExpiryDate)) : null;
			$option .= '
			<tr>';

			if ($afterSet == "") {
				$option .= '<td style="text-align: center;">
					<input type="hidden" id="usercheckList' . $i . '" name="usercheckList[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response[$i]->BatchQty . '" id="itp_CS' . $i . '" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener(' . $i . ')">
				</td>';
			}

			$option .= '<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode' . $i . '" name="itp_ItemCode[]" class="form-control" value="' . $response[$i]->ItemCode . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName' . $i . '" name="itp_ItemName[]" class="form-control" value="' . $response[$i]->ItemName . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo' . $i . '" name="itp_ContainerNo[]" class="form-control" value="' . $response[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche' . $i . '" name="itp_Batch[]" class="form-control" value="' . $response[$i]->Batch . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty' . $i . '" name="itp_BatchQty[]" class="form-control" value="' . $response[$i]->BatchQty . '" readonly>
				</td>';

			if ($afterSet == "") {
				$option .= '<td>
					<input class="border_hide" type="text" id="SelectedQty' . $i . '" name="SelectedQty[]" class="form-control" value="' . $response[$i]->BatchQty . '" onfocusout="EnterQtyValidation(' . $i . ')">
				</td>';
			}

			$option .= '<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate' . $i . '" name="itp_MfgDate[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate' . $i . '" name="itp_ExpiryDate[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$option .= '<tr>';

		if ($afterSet == "") {
			$option .= '<td colspan="6"></td>';

			$option .= '<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum" name="cs_selectedQtySum" class="form-control" value="0.000000" readonly></td>
				<td colspan="2"></td>';
		} else {
			$option .= '<td colspan="5"></td>';
		}

		$option .= '</tr>';
	} else {
		$option .= '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}

	$option .= '</tbody></table>';
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}

if (isset($_POST['SC_SubIT_Btn_post_doc'])) {
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['it_Series'])));
	$tdata['DocDate'] = date("Y-m-d", strtotime($_POST['it_PostingDate']));
	$tdata['DueDate'] = date("Y-m-d", strtotime($_POST['it_DocumentDate']));
	$tdata['CardCode'] = trim(addslashes(strip_tags($_POST['it_SupplierCode'])));
	$tdata['Comments'] = null;
	$tdata['FromWarehouse'] = trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
	$tdata['ToWarehouse'] = trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
	$tdata['TaxDate'] = date("Y-m-d", strtotime($_POST['it_DocumentDate']));
	$tdata['DocObjectCode'] = trim(addslashes(strip_tags('67')));
	$tdata['BPLID'] = trim(addslashes(strip_tags($_POST['it_BPLId'])));
	$tdata['U_PC_SIIProc'] = trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$tdata['U_BFType'] = trim(addslashes(strip_tags($_POST['it_BaseDocType'])));

	$mainArray = $tdata;
	// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum'] = trim(addslashes(strip_tags('0')));
	$item['ItemCode'] = trim(addslashes(strip_tags($_POST['itP_ItemCode'])));
	$item['WarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
	$item['FromWarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
	$item['Quantity'] = trim(addslashes(strip_tags($_POST['itP_BQty'])));

	// <!-- Item Batch row data prepare start here ----------- -->
	for ($i = 0; $i < count($_POST['usercheckList']); $i++) {
		if ($_POST['usercheckList'][$i] == '1') {
			$batch['BatchNumber'] = trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
			$batch['Quantity'] = trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
			$batch['BaseLineNumber'] = trim(addslashes(strip_tags('0')));
			$batch['ItemCode'] = trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));

			$item['BatchNumbers'][] = $batch;
		}
	}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['StockTransferLines'][] = $item;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->

	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_StockTransfers;

		$responce_encode = $objKri->SaveSampleIntimation_kris($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {
			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['it_DocEntry'])));
			$UT_data['U_PC_UTTrans'] = trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SCINPROCESS_SL . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $objKri->SampleIntimationUnderTestUpdateFromInventoryTransfer_kri($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			if (empty($underTestNumber_decode)) {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Inventory Transfer Successfully Added.";
				echo json_encode($data);
			} else {
				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $underTestNumber_decode->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if (isset($_POST['SampleIntimationUpdateForm_Btn'])) {


	$tdata = array(); // This array send to AP Standalone Invoice process 


	// $tdata['Series']=trim(addslashes(strip_tags($_POST['DocNo'])));
	$tdata['Remark'] = trim(addslashes(strip_tags($_POST['Remark'])));
	$tdata['Object'] = trim(addslashes(strip_tags('SCS_SINPROCESS')));
	$tdata['U_PC_BLin'] = trim(addslashes(strip_tags($_POST['LineNum'])));
	$tdata['U_PC_RNo'] = trim(addslashes(strip_tags($_POST['ReceiptNo'])));

	$tdata['U_PC_REnt'] = trim(addslashes(strip_tags($_POST['ReceiptNo1'])));

	$tdata['U_PC_WoNo'] = trim(addslashes(strip_tags($_POST['woNo'])));

	$tdata['U_PC_WoEnt'] = trim(addslashes(strip_tags($_POST['woEntry'])));

	$tdata['U_PC_SType'] = trim(addslashes(strip_tags($_POST['sampleType'])));

	$tdata['U_PC_TRBy'] = trim(addslashes(strip_tags($_POST['TrBy'])));

	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['itemCode'])));

	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['itemName'])));

	$tdata['U_PC_RcQty'] = null;

	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['sampleQty'])));

	$tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['RetainQty'])));

	$tdata['U_PC_Unit'] = trim(addslashes(strip_tags($_POST['U_PC_Unit'])));

	$tdata['U_PC_TNCont'] = $_POST['totalNoOfContainer'] != '' ? $_POST['totalNoOfContainer'] : 0;

	$tdata['U_PC_TNCont1'] = $_POST['QtyPerContainer'] != '' ? $_POST['QtyPerContainer'] : 0;

	$tdata['U_PC_FCont'] = $_POST['fromContainer'] != '' ? $_POST['fromContainer'] : 0;
	$tdata['U_PC_TCont'] = $_POST['ToContainer'] != '' ? $_POST['ToContainer'] : 0;

	if (!empty($_POST['TrDate'])) {
		$tdata['U_PC_TRDte'] = date('Y-m-d', strtotime($_POST['TrDate']));
	} else {
		$tdata['U_PC_TRDte'] = '';
	}

	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['Branch'])));

	$tdata['U_PC_ChNo'] = trim(addslashes(strip_tags($_POST['ChallanNo'])));
	$tdata['U_PC_ChDate'] = trim(addslashes(strip_tags($_POST['ChallanDate'])));
	$tdata['U_PC_GENo'] = trim(addslashes(strip_tags($_POST['GateEntryNo'])));

	if (!empty($_POST['GateEntryDate'])) {
		$tdata['U_PC_GEDte'] = date('Y-m-d', strtotime($_POST['GateEntryDate']));
	} else {
		$tdata['U_PC_GEDte'] = '';
	}

	$tdata['U_PC_CNos'] = trim(addslashes(strip_tags($_POST['ContainerNo'])));
	$tdata['U_PC_Cont'] = $_POST['Container'] != '' ? $_POST['Container'] : 0;

	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['BatchNo'])));
	$tdata['U_PC_BQty'] = trim(addslashes(strip_tags($_POST['BatchQty'])));

	if (!empty($_POST['MFGDate'])) {
		$tdata['U_PC_MfgDt'] = date('Y-m-d', strtotime($_POST['MFGDate']));
	} else {
		$tdata['U_PC_MfgDt'] = '';
	}


	if (!empty($_POST['ExpiryDate'])) {
		$tdata['U_PC_ExpDt'] = date('Y-m-d', strtotime($_POST['ExpiryDate']));
	} else {
		$tdata['U_PC_ExpDt'] = '';
	}

	if (!empty($_POST['RetestDate'])) {
		$tdata['U_PC_RDt'] = date('Y-m-d', strtotime($_POST['RetestDate']));
	} else {
		$tdata['U_PC_RDt'] = '';
	}

	// $tdata['U_PC_RDt']=trim(addslashes(strip_tags($_POST['RetestDate'])));

	$tdata['U_PC_UTTrans'] = null;
	$tdata['U_PC_DType'] = null;

	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['BPLId'])));
	$tdata['U_PC_LCode'] = trim(addslashes(strip_tags($_POST['LocCode'])));
	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['Location'])));
	// echo "<pre>";
	// 	print_r($tdata);
	// 	echo "</pre>";
	// 	exit;
	// ---------------------------------------
	// $tdata['U_ChNo']=trim(addslashes(strip_tags($_POST['ChNo'])));
	// if(!empty($_POST['ChNo'])){
	// 	$tdata['U_ChNo']=trim(addslashes(strip_tags($_POST['ChNo'])));
	// }else{
	// 	$tdata['U_ChNo']=null;
	// }



	// $tdata['U_FCont'] = $_POST['FromContainer'] !='' ? $_POST['FromContainer'] : 0;
	// $tdata['U_TCont'] = $_POST['ToContainer'] !='' ? $_POST['ToContainer'] : 0;
	// $tdata['U_TNCont'] = $_POST['NoOfcontainer'] !='' ? $_POST['NoOfcontainer'] : 0;
	// $tdata['U_Cont'] = $_POST['Container'] !='' ? $_POST['Container'] : 0;
	// $tdata['U_TNCont1'] = $_POST['QtyPerContainer'] !='' ? $_POST['QtyPerContainer'] : 0;

	// if(!empty($_POST['GateEntryNo'])){
	// 	$tdata['U_GEntNo']=trim(addslashes(strip_tags($_POST['GateEntryNo'])));
	// }else{
	// 	$tdata['U_GEntNo']=null;
	// }
	// $tdata['U_GEntDate']=trim(addslashes(strip_tags('null'))); // missing field date on screen
	// $tdata['U_Cont']=trim(addslashes(strip_tags('0')));

	// $tdata['U_UTTrans']=null;
	// $tdata['U_DType']=trim(addslashes(strip_tags('Batch')));
	// $tdata['U_CNos']=trim($_POST['ContainerNOS']);
	// $tdata['U_Loc']=trim($_POST['Location']);
	// ---------------------------------Date Var Prepare Start Here ------------------------------------
	// if(!empty($_POST['PostingDate'])){
	// 	$tdata['U_GEntDate']=date('Y-m-d', strtotime($_POST['PostingDate']));
	// }else{
	// 	$tdata['U_GEntDate']='';
	// }

	// if(!empty($_POST['ExpiryDate'])){
	// 	$tdata['U_MfgDate']=date('Y-m-d', strtotime($_POST['ExpiryDate']));
	// }else{
	// 	$tdata['U_MfgDate']='';
	// }

	// if(!empty($_POST['MfgDate'])){
	// 	$tdata['U_ExpDate']=date('Y-m-d', strtotime($_POST['MfgDate']));
	// }else{
	// 	$tdata['U_ExpDate']='';
	// }

	// if(!empty($_POST['ChDate'])){
	// 	$tdata['U_ChDate']=date('Y-m-d', strtotime($_POST['ChDate']));
	// }else{
	// 	$tdata['U_ChDate']='';
	// }

	// if(!empty($_POST['TrDate'])){
	// 	$tdata['U_TRDate']=date('Y-m-d', strtotime($_POST['TrDate']));
	// }else{
	// 	$tdata['U_TRDate']='';
	// }
	// ---------------------------------Date Var Prepare End Here   ------------------------------------

	// if(!empty($_POST['Container'])){
	// 	$Container=$_POST['Container'];
	// }else{
	// 	$Container=0;
	// }
	// print_r($tdata);
	// die();
	// <!-- ---------------------- sample Intimation popup validation start Here ------------------ -->
	if ($_POST['sampleType'] == '') {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = "Sample Type Mandatory.";
		echo json_encode($data);
		exit(0);
	}

	if ($_POST['TrBy'] == '') {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = "TR Type Mandatory.";
		echo json_encode($data);
		exit(0);
	}

	if ($_POST['TrDate'] == '') {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = "TR Date Mandatory.";
		echo json_encode($data);
		exit(0);
	}


	$mainArray = $tdata;

	// 	echo "<pre>";
	// print_r($mainArray);
	// echo "</pre>";
	// exit;

	// <!-- ---------------------- sample Intimation popup validation end Here -------------------- -->

	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {

		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SINPROCESS . '(' . $_POST['it_DocEntry'] . ')';

		$responce_encode = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($mainArray, $Final_API);
		$responce = json_decode($responce_encode);
		// $Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SINPROCESS;

		// $responce_encode=$obj->SaveSampleIntimation($tdata,$Final_API); // sample intimation save here
		// $responce=json_decode($responce_encode);

		//    echo "<pre>";
		// print_r($responce);
		// echo "</pre>";
		// exit;

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();

		if ($responce == '') {
			$data['status'] = 'True';
			$data['DocEntry'] = $_POST['it_DocEntry'];
			$data['message'] = "Inventory Transfer Successfully Updated.";
			echo json_encode($data);
		} else {
			if (array_key_exists('error', (array)$responce)) {
				$data['status'] = 'False';
				$data['DocEntry'] = '';
				$data['message'] = $responce->error->message->value;
				echo json_encode($data);
			}
		}



		// if($responce->DocNum!=""){

		// 	$data['status']='True';
		// 	$data['DocEntry']=$responce->DocEntry;
		// 	$data['message']="Inventory Transfer Successfully Updated.";
		// 	echo json_encode($data);
		// }else{
		// 	if(array_key_exists('error', (array)$responce)){
		// 		$data['status']='False';
		// 		$data['DocEntry']='';
		// 		$data['message']=$responce->error->message->value;
		// 		echo json_encode($data);
		// 	}
		// }
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);

	// ========================================================================		
}

if (isset($_POST['action']) && $_POST['action'] == 'IngrediantTypeDropdown_SampleCollection_ajax') {
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_SCS_INGREDIENT;

		$responce_encode = $obj->getFunctionServiceLayer($Final_API);
		$responce = json_decode($responce_encode);

		for ($i = 0; $i < count($responce->value); $i++) {

			if ($responce->value[$i]->Name == 'None') {
				$option .= '<option value="' . $responce->value[$i]->Name . '" selected>' . $responce->value[$i]->Name . '</option>';
			} else {
				$option .= '<option value="' . $responce->value[$i]->Name . '">' . $responce->value[$i]->Name . '</option>';
			}
		}
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	print_r($option);
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}



if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransferSamplessue_In_ajax') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $INPROCESSSAMPCOLLADD . '?DocEntry=' . $DocEntry;

	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20

	$response = $obj->get_OTFSI_SingleData($FinalAPI);

	$BatchQty = ($response[0]->BatchQty) - ($response[0]->SampleQty);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {
		$option = '<tr>
				<td class="desabled">
					<input type="hidden" id="_tRFPEntry" name="_tRFPEntry" value="' . $response[0]->RFPEntry . '">
					<input type="hidden" id="it_BatchNo" name="it_BatchNo" value="' . $response[0]->BatchNo . '">

					1
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_ItemCode" name="itP_ItemCode" class="form-control" value="' . $response[0]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
				 <input class="border_hide textbox_bg" type="text" id="itP_ItemName" name="itP_ItemName" class="form-control" value="' . $response[0]->ItemName . '" readonly>
				
				</td>
				<td>
					<input class="border_hide textbox_bg1" type="text" id="itP_BQty" name="itP_BQty" class="form-control" value="' . $BatchQty . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_FromWhs" name="itP_FromWhs" class="form-control" value="' . $response[0]->RISSFromWhs . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_ToWhs" name="itP_ToWhs" class="form-control" value="' . $response[0]->RISSToWhs . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_Loction" name="itP_Loction" class="form-control" value="' . $response[0]->Loction . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_RetainQtyUom" name="itP_RetainQtyUom" class="form-control" value="' . $response[0]->RetainQtyUom . '" readonly>
				</td>
			</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}



if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransferExtraIssue_In_ajax') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $INPROCESSSAMPCOLLADD . '?DocEntry=' . $DocEntry;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20

	$response = $obj->get_OTFSI_SingleData($FinalAPI);

	// 	echo "<pre>";
	// 	print_r($response);
	// 	echo "</pre>";
	// exit;
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {
		$option = '<tr>
				<td class="desabled">
					<input type="hidden" id="_tRFPEntry_extra" name="_tRFPEntry_extra" value="' . $response[0]->RFPEntry . '">
					<input type="hidden" id="it_BatchNo_extra" name="it_BatchNo_extra" value="' . $response[0]->BatchNo . '">

					1
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_ItemCode_extra" name="itP_ItemCode_extra" class="form-control" value="' . $response[0]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
				 <input class="border_hide textbox_bg" type="text" id="itP_ItemName_extra" name="itP_ItemName_extra" class="form-control" value="' . $response[0]->ItemName . '" readonly>
				
				</td>
				<td>
					<input class="border_hide textbox_bg1" type="text" id="itP_BQty_extra" name="itP_BQty_extra" class="form-control" value="' . $response[0]->BatchQty . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_FromWhs_extra" name="itP_FromWhs_extra" class="form-control" value="' . $response[0]->RISSFromWhs . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_ToWhs_extra" name="itP_ToWhs_extra" class="form-control" value="' . $response[0]->RISSToWhs . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_Loction_extra" name="itP_Loction_extra" class="form-control" value="' . $response[0]->Loction . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_RetainQtyUom_extra" name="itP_RetainQtyUom_extra" class="form-control" value="' . $response[0]->RetainQtyUom . '" readonly>
				</td>
			</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}




if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransfer_Simple_issue_process_in_ajax') {

	$ItemCode = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs = trim(addslashes(strip_tags($_POST['WareHouse'])));
	$GRPODEnt = trim(addslashes(strip_tags($_POST['DocEntry'])));
	$BNo = trim(addslashes(strip_tags($_POST['BatchNo'])));

	$afterSet = trim(addslashes(strip_tags($_POST['afterSet'])));

	// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API = $INPROCESSSAMCOLLCONTSEL . '?ItemCode=' . $ItemCode . '&WareHouse=' . $FromWhs . '&DocEntry=' . $GRPODEnt . '&BatchNo=' . $BNo;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here -------------------------------------------- -->

	$response = $obj->get_OTFSI_SingleData($FinalAPI);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {

		for ($i = 0; $i < count($response); $i++) {

			if (!empty($response[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response[$i]->ExpDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response[$i]->ExpDate));
			} else {
				$ExpiryDate = '';
			}


			$option .= '
			<tr>
                
                <td style="text-align: center;">
					<input type="hidden" id="usercheckList' . $i . '" name="usercheckList[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response[$i]->BatchQty . '" id="itp_CS' . $i . '" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener(' . $i . ')">
				</td>

                <td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode' . $i . '" name="itp_ItemCode[]" class="form-control" value="' . $response[$i]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName' . $i . '" name="itp_ItemName[]" class="form-control" value="' . $response[$i]->ItemName . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo' . $i . '" name="itp_ContainerNo[]" class="form-control" value="' . $response[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche' . $i . '" name="itp_Batch[]" class="form-control" value="' . $response[$i]->BatchNum . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty' . $i . '" name="itp_BatchQty[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" readonly>


				</td>

				
				<td style="text-align: center;">
				   <input class="border_hide" type="text" id="SelectedQty' . $i . '" name="SelectedQty[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" onfocusout="EnterQtyValidation(' . $i . ')">

				  
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate' . $i . '" name="itp_MfgDate[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate' . $i . '" name="itp_ExpiryDate[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$option .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum" name="cs_selectedQtySum" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}



if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransfer_ExtraIssueProcess_in_ajax') {

	$ItemCode = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs = trim(addslashes(strip_tags($_POST['WareHouse'])));
	$GRPODEnt = trim(addslashes(strip_tags($_POST['DocEntry'])));
	$BNo = trim(addslashes(strip_tags($_POST['BatchNo'])));

	$afterSet = trim(addslashes(strip_tags($_POST['afterSet'])));

	// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API = $INPROCESSSAMCOLLCONTSEL . '?ItemCode=' . $ItemCode . '&WareHouse=' . $FromWhs . '&DocEntry=' . $GRPODEnt . '&BatchNo=' . $BNo;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here -------------------------------------------- -->

	$response = $obj->get_OTFSI_SingleData($FinalAPI);

	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {

		for ($i = 0; $i < count($response); $i++) {

			if (!empty($response[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response[$i]->ExpDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response[$i]->ExpDate));
			} else {
				$ExpiryDate = '';
			}


			$option .= '
			<tr>
                
                <td style="text-align: center;">
					<input type="hidden" id="usercheckList_extra' . $i . '" name="usercheckList_extra[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response[$i]->BatchQty . '" id="itp_CS_extra' . $i . '" name="itp_CS_extra[]" style="width: 17px;height: 17px;" onclick="getSelectedContener_extra(' . $i . ')">
				</td>

                <td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode_extra' . $i . '" name="itp_ItemCode_extra[]" class="form-control" value="' . $response[$i]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName_extra' . $i . '" name="itp_ItemName_extra[]" class="form-control" value="' . $response[$i]->ItemName . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo_extra' . $i . '" name="itp_ContainerNo_extra[]" class="form-control" value="' . $response[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche_extra' . $i . '" name="itp_Batch_extra[]" class="form-control" value="' . $response[$i]->BatchNum . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty_extra' . $i . '" name="itp_BatchQty_extra[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" readonly>


				</td>

				
				<td style="text-align: center;">
				   <input class="border_hide" type="text" id="SelectedQty_extra' . $i . '" name="SelectedQty_extra[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" onfocusout="EnterQtyValidation_extra(' . $i . ')">

				  
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate_extra' . $i . '" name="itp_MfgDate_extra[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate_extra' . $i . '" name="itp_ExpiryDate_extra[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$option .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum_extra" name="cs_selectedQtySum_extra" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransfer_Retails_issue_process_in_ajax') {

	$ItemCode = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs = trim(addslashes(strip_tags($_POST['WareHouse'])));
	$GRPODEnt = trim(addslashes(strip_tags($_POST['DocEntry'])));
	$BNo = trim(addslashes(strip_tags($_POST['BatchNo'])));

	$afterSet = trim(addslashes(strip_tags($_POST['afterSet'])));

	// ItemCode=P00003&WareHouse=RETN-WHS&DocEntry=297&BatchNo=BQ13
	// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API = $INPROCESSSAMCOLLCONTSEL . '?ItemCode=' . $ItemCode . '&WareHouse=' . $FromWhs . '&DocEntry=' . $GRPODEnt . '&BatchNo=' . $BNo;

	// $API='http://10.80.4.55:8081/API/SAP/INPROCESSSAMINTICONTSEL?ItemCode=SFG00001&WareHouse=QCUT-GEN&DocEntry=359&BatchNo=asd';
	// 
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "<pre>";
	// exit;
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {

		for ($i = 0; $i < count($response); $i++) {

			if (!empty($response[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response[$i]->ExpDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response[$i]->ExpDate));
			} else {
				$ExpiryDate = '';
			}


			$option .= '
			<tr>
                
                <td style="text-align: center;">
					<input type="hidden" id="usercheckList_retails' . $i . '" name="usercheckList_retails[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response[$i]->BatchQty . '" id="itp_CS_retails' . $i . '" name="itp_CS_retails[]" style="width: 17px;height: 17px;" onclick="getSelectedContener_retails(' . $i . ')">
				</td>

                <td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode_retails' . $i . '" name="itp_ItemCode_retails[]" class="form-control" value="' . $response[$i]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName_retails' . $i . '" name="itp_ItemName_retails[]" class="form-control" value="' . $response[$i]->ItemName . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo_retails' . $i . '" name="itp_ContainerNo_retails[]" class="form-control" value="' . $response[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche_retails' . $i . '" name="itp_Batch_retails[]" class="form-control" value="' . $response[$i]->BatchNum . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty_retails' . $i . '" name="itp_BatchQty_retails[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" readonly>


				</td>

				
				<td style="text-align: center;">
				   <input class="border_hide" type="text" id="SelectedQty_retails' . $i . '" name="SelectedQty_retails[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" onfocusout="EnterQtyValidation_retails(' . $i . ')">

				  
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate_retails' . $i . '" name="itp_MfgDate_retails[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate_retails' . $i . '" name="itp_ExpiryDate_retails[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$option .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum_retails" name="cs_selectedQtySum_retails" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}



if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransfer_external_process_in_ajax') {

	$ItemCode = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs = trim(addslashes(strip_tags($_POST['WareHouse'])));
	$GRPODEnt = trim(addslashes(strip_tags($_POST['DocEntry'])));
	$BNo = trim(addslashes(strip_tags($_POST['BatchNo'])));

	$afterSet = trim(addslashes(strip_tags($_POST['afterSet'])));

	// ItemCode=P00003&WareHouse=RETN-WHS&DocEntry=297&BatchNo=BQ13
	// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API = $INPROCESSSAMCOLLCONTSEL . '?ItemCode=' . $ItemCode . '&WareHouse=' . $FromWhs . '&DocEntry=' . $GRPODEnt . '&BatchNo=' . $BNo;

	// $API='http://10.80.4.55:8081/API/SAP/INPROCESSSAMINTICONTSEL?ItemCode=SFG00001&WareHouse=QCUT-GEN&DocEntry=359&BatchNo=asd';
	// 
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "<pre>";
	// exit;
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {

		for ($i = 0; $i < count($response); $i++) {

			if (!empty($response[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response[$i]->ExpDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response[$i]->ExpDate));
			} else {
				$ExpiryDate = '';
			}


			$option .= '
			<tr>
                
                <td style="text-align: center;">
					<input type="hidden" id="usercheckList_external' . $i . '" name="usercheckList_external[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response[$i]->BatchQty . '" id="itp_CS_external' . $i . '" name="itp_CS_external[]" style="width: 17px;height: 17px;" onclick="getSelectedContener_extenal(' . $i . ')">
				</td>

                <td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode_external' . $i . '" name="itp_ItemCode_external[]" class="form-control" value="' . $response[$i]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName_external' . $i . '" name="itp_ItemName_external[]" class="form-control" value="' . $response[$i]->ItemName . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo_external' . $i . '" name="itp_ContainerNo_external[]" class="form-control" value="' . $response[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche_external' . $i . '" name="itp_Batch_external[]" class="form-control" value="' . $response[$i]->BatchNum . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty_external' . $i . '" name="itp_BatchQty_external[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" readonly>


				</td>

				
				<td style="text-align: center;">
				   <input class="border_hide" type="text" id="SelectedQty_external' . $i . '" name="SelectedQty_external[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" onfocusout="EnterQtyValidation_external(' . $i . ')">

				  
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate_external' . $i . '" name="itp_MfgDate_external[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate_external' . $i . '" name="itp_ExpiryDate_external[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$option .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum_external" name="cs_selectedQtySum_external" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}








if (isset($_POST['action']) && $_POST['action'] == 'getSempleCSeriesDropdown_ajax') {
	$ObjectCode = trim(addslashes(strip_tags($_POST['ObjectCode'])));

	$Final_API = $INWARDQCSERIES . $ObjectCode .$TrDate;

	$response = $obj->GetSeriesDropdown($Final_API);
	echo json_encode($response);
	exit(0);
}



if (isset($_POST['SubIT_Btn_S_sample_issue'])) {
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;
	$tdata['DocType'] = 'dDocument_Items';
	$tdata['DocDate'] = date("Y-m-d", strtotime($_POST['gd_PostingDate']));
	$tdata['DocDueDate'] = date("Y-m-d", strtotime($_POST['gd_DocumentDate']));
	$tdata['Series'] = trim(addslashes(strip_tags($_POST['gd_SeriesName'])));
	$tdata['TaxDate'] = date("Y-m-d", strtotime($_POST['gd_DocumentDate']));
	$tdata['DocObjectCode'] = 'oInventoryGenExit';


	$tdata['U_PC_SCIProc'] = trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	// $tdata['U_PC_SCRtest']=trim(addslashes(strip_tags($_POST['SCRTQC_GI_SCRTQCB_DocEntry'])));
	$tdata['U_BFType'] = trim(addslashes(strip_tags($_POST['gd_BaseDocType'])));
	$tdata['BPL_IDAssignedToInvoice'] = trim(addslashes(strip_tags($_POST['it_BPLId'])));

	// $tdata['CardCode']=trim(addslashes(strip_tags($_POST['GI_supplierCode'])));
	// $tdata['Comments']=null;
	// $tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
	// $tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['GI_to_whs'])));
	// $tdata['BPLID']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId_samIss'])));
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$mainArray = $tdata;
	// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum'] = trim(addslashes(strip_tags('0')));
	$item['ItemCode'] = trim(addslashes(strip_tags($_POST['itP_ItemCode'])));
	$item['Quantity'] = trim(addslashes(strip_tags($_POST['itP_BQty'])));
	$item['WarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
	// $item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
	// <!-- Item Batch row data prepare start here ----------- -->
	// $BL = 0;
	for ($i = 0; $i < count($_POST['usercheckList']); $i++) {

		if ($_POST['usercheckList'][$i] == '1') {

			$batch['BatchNumber'] = trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
			$batch['Quantity'] = trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
			$batch['BaseLineNumber'] = trim(addslashes(strip_tags('0')));
			$batch['ItemCode'] = trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));
			$item['BatchNumbers'][] = $batch;
			// $BL++;
		}
	}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['DocumentLines'][] = $item;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->
	// echo json_encode($mainArray);
	// exit;
	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
	// echo json_encode($mainArray);
	// exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $InventoryGenExits;

		$responce_encode = $obj->SaveSampleIntimation($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		// echo "<pre>";
		// 	print_r($Final_API);
		// 	echo "<pre>";
		// 	exit;

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '1111111';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {

			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['it_DocEntry'])));
			$UT_data['U_PC_SIssue'] = trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_SCS_SCOL . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			if ($underTestNumber_decode == '') {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Sample Issue Successfully Added.";
				echo json_encode($data);
			} else {
				// $data['status']='False';
				// $data['DocEntry']='';
				// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
				// echo json_encode($data);

				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '22222222222';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}






if (isset($_POST['SubIT_Btn_Retails_issue'])) {
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data

	// echo "h";
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['iT_InventoryTransfer_series'])));
	$tdata['DocDate'] = date("Y-m-d", strtotime($_POST['iT_InventoryTransfer_PostingDate']));
	$tdata['DueDate'] = date("Y-m-d", strtotime($_POST['iT_InventoryTransfer_DocumentDate']));
	$tdata['CardCode'] = null;
	$tdata['Comments'] = null;
	$tdata['FromWarehouse'] = trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
	$tdata['ToWarehouse'] = trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
	$tdata['TaxDate'] = trim(addslashes(strip_tags($_POST['iT_InventoryTransfer_DocumentDate'])));
	$tdata['DocObjectCode'] = '67';
	$tdata['BPLID'] = trim(addslashes(strip_tags($_POST['it_InventoryTransfer_BPLId'])));
	$tdata['U_PC_SCIProc'] = trim(addslashes(strip_tags($_POST['it_InventoryTransfer_DocEntry'])));
	$tdata['U_BFType'] = trim(addslashes(strip_tags('SCS_SCINPROC')));
	// $tdata['CardCode']=trim(addslashes(strip_tags($_POST['GI_supplierCode'])));
	// $tdata['Comments']=null;
	// $tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
	// $tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['GI_to_whs'])));
	// $tdata['BPLID']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId_samIss'])));
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$mainArray = $tdata;
	// --------------------- Item and batch row data preparing start here   -------------------------------- -->
	$item['LineNum'] = trim(addslashes(strip_tags('0')));
	$item['ItemCode'] = trim(addslashes(strip_tags($_POST['itP_ItemCode'])));
	$item['Quantity'] = trim(addslashes(strip_tags($_POST['itP_BQty'])));
	$item['WarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
	$item['FromWarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
	// <!-- Item Batch row data prepare start here ----------- -->
	$BL = 0;
	for ($i = 0; $i < count($_POST['usercheckList_retails']); $i++) {

		if ($_POST['usercheckList_retails'][$i] == '1') {

			$batch['BatchNumber'] = trim(addslashes(strip_tags($_POST['itp_ContainerNo_retails'][$i])));
			$batch['Quantity'] = trim(addslashes(strip_tags($_POST['SelectedQty_retails'][$i])));
			$batch['BaseLineNumber'] = trim(addslashes(strip_tags('0')));
			$batch['ItemCode'] = trim(addslashes(strip_tags($_POST['itp_ItemCode_retails'][$i])));
			$item['BatchNumbers'][] = $batch;
			$BL++;
		}
	}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['StockTransferLines'][] = $item;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->
	// echo json_encode($mainArray);
	// exit;
	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
	// echo json_encode($mainArray);
	// exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_StockTransfers;

		$responce_encode = $objKri->SaveSampleIntimation_kris($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		// echo "<pre>";
		// 	print_r($responce);
		// 	echo "<pre>";
		// 	exit;

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {

			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['it_InventoryTransfer_DocEntry'])));
			$UT_data['U_PC_RIssue'] = trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SCINPROC . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			if ($underTestNumber_decode == '') {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Inventory Transfer Successfully Added.";
				echo json_encode($data);
			} else {
				// $data['status']='False';
				// $data['DocEntry']='';
				// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
				// echo json_encode($data);

				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

// ====================================================================================================

if (isset($_POST['action']) && $_POST['action'] == 'PrpcessInReverseSampleIsuue_ajax') {
	// <!--------------- Get Reverse Sample issue data start here ------------------------------------------ -->
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	// echo "<pre>";
	// print_r($DocEntry);
	// echo "</pre>";
	// exit;

	$API = $InventoryGenExits . '(' . $DocEntry . ')';

	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	$response = $objKri->getReverseSampleIssuess($FinalAPI); // get Function called here
	// <!--------------- Get Reverse Sample issue data End here -------------------------------------------- -->
	// $Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_StockTransfers;
	$response = json_decode($response);
	// echo $API=$INPROCESSSAMPCOLLADD.'?DocEntry='.$DocEntry;
	// $FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// $response=$obj->get_OTFSI_SingleData($FinalAPI); // get Function called here
	// <!--------------- Get Reverse Sample issue data End here -------------------------------------------- -->

	// echo "<pre>";
	// print_r($response);
	//       echo "</pre>";



	// <!--------------- Get Series Data using Object code start here -------------------------------------- -->
	$Series_API = $INWARDQCSERIES . '59'; // Object Code Hardcore write
	$Series_response = $obj->get_OTFSI_SingleData($Series_API); // get Function called here
	// <!--------------- Get Series Data using Object code end here ---------------------------------------- -->

	// echo "<pre>";
	// print_r($Series_response);
	//       echo "</pre>";
	// exit;
	//  <!-- ---------- Preparing row data start here ------------------------------------------------------ -->
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data

	// <!-- --------- Header level data perparing start here ---------------- -->
	$tdata['DocType'] = 'dDocument_Items';
	$tdata['DocDate'] = date("Y-m-d", strtotime($response->DocDate));
	$tdata['DocDueDate'] = date("Y-m-d", strtotime($response->DocDueDate));
	$tdata['Series'] = trim(addslashes(strip_tags($Series_response[0]->Series)));
	$tdata['TaxDate'] = date("Y-m-d", strtotime($response->TaxDate));
	$tdata['DocObjectCode'] = trim(addslashes(strip_tags('oInventoryGenEntries')));
	$tdata['U_PC_SCIProc'] = trim(addslashes(strip_tags($response->U_PC_SCIProc)));
	$tdata['U_BFType'] = trim(addslashes(strip_tags($response->U_BFType)));
	$tdata['BPL_IDAssignedToInvoice'] = trim(addslashes(strip_tags($response->BPL_IDAssignedToInvoice)));

	$mainArray = $tdata; // header level data append in this array
	// <!-- --------- Header level data perparing end here ------------------ -->

	// <!-- --------- Item Batch row data prepare start here ----------------- -->
	// $item['ItemCode']=trim(addslashes(strip_tags($response[0]->ItemCode)));
	// $item['Quantity']=trim(addslashes(strip_tags($response[0]->BatchQty)));
	// $item['BaseType']='60';
	// $item['BaseEntry']=trim(addslashes(strip_tags($response[0]->DocEntry)));
	// $item['BaseLine']=trim(addslashes(strip_tags($response[0]->LineNo)));
	$item['ItemCode'] = trim(addslashes(strip_tags($response->DocumentLines[0]->ItemCode)));
	$item['Quantity'] = trim(addslashes(strip_tags($response->DocumentLines[0]->Quantity)));
	$item['BaseType'] = '60';
	$item['BaseEntry'] = trim(addslashes(strip_tags($DocEntry)));
	$item['BaseLine'] = '0';



	// $BatchNumbersArrayData=$response[0]->SAMPLECOLLBATCH;
	$BatchNumbersArrayData = $response->DocumentLines[0]->BatchNumbers;

	//       $API_batchDetals=$BATCHDETAILS.'?BaseEntry='.trim(addslashes(strip_tags($DocEntry))).'&BaseType=60';
	// $FinalAPI_batch = str_replace(' ', '%20', $API_batchDetals);
	//       $batch_response=$objKri->get_batchDetailsData($FinalAPI_batch);

	//      echo "<pre>";
	// print_r($BatchNumbersArrayData);
	//       echo "</pre>";
	//   exit;

	for ($i = 0; $i < count($BatchNumbersArrayData); $i++) {

		$batch['BatchNumber'] = trim(addslashes(strip_tags($BatchNumbersArrayData[$i]->BatchNumber)));
		// $batch['Quantity']=trim(addslashes(strip_tags($BatchNumbersArrayData[$i]->BatchQty)));
		$batch['Quantity'] = (int)trim(addslashes(strip_tags($BatchNumbersArrayData[$i]->Quantity))); // 252
		$batch['ItemCode'] = trim(addslashes(strip_tags($BatchNumbersArrayData[$i]->ItemCode)));

		$item['BatchNumbers'][] = $batch; // Batch data append in this array
	}
	// <!-- --------- Item Batch row data prepare end here ------------------- -->
	$mainArray['DocumentLines'][] = $item; // Item data append in this array
	//  <!-- ---------- Preparing row data end here -------------------------------------------------------- -->
	// echo json_encode($mainArray);

	// echo "<pre>";
	// print_r($mainArray);
	// echo "</pre>";
	// exit;

	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here
	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_InventoryGenEntries;

		$responce_encode = $obj->SaveSampleIntimation($mainArray, $Final_API);
		$responce = json_decode($responce_encode);



		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {



			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['DocEntry'])));
			$UT_data['U_PC_RSIssue'] = trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SCINPROC . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			// echo "<pre>";
			// print_r($responce);
			// echo "</pre>";
			// exit;

			// 	echo "<pre>";
			// print_r($underTestNumber_decode);
			// echo "</pre>";
			// exit;

			if ($underTestNumber_decode == '') {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Reverse Sample Issue Added Successfully.";
				echo json_encode($data);
			} else {
				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}


if (isset($_POST['SampleCollectionProcessInUpdateForm_Btn'])) {
	// <!-- ------------ array declare Here ------------- -->
	$mainArray = array();
	$ExternalIssue = array();
	$ExtraIssue = array();
	// <!-- ------------ array declare Here ------------- -->
	$tdata['Series'] = trim(addslashes(strip_tags($_POST['si_Series'])));
	$tdata['Object'] = 'SCS_SCINPROC';
	$tdata['U_PC_BLin'] = 0;
	$tdata['U_PC_InType'] = 'Active';
	$tdata['U_PC_WoNo'] = trim(addslashes(strip_tags($_POST['woNo'])));
	$tdata['U_PC_WoEnt'] = trim(addslashes(strip_tags($_POST['WoEntry'])));
	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['Location'])));
	$tdata['U_PC_InBy'] = trim(addslashes(strip_tags($_POST['IntimatedBy'])));

	if (!empty($_POST['SCRTQCB_IntimationDate'])) {
		$tdata['U_PC_InDt'] = date("Y-m-d", strtotime($_POST['IntimatedDate']));
	} else {
		$tdata['U_PC_InDt'] = null;
	}

	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['SampleQty'])));
	$tdata['U_PC_SUnit'] = trim(addslashes(strip_tags($_POST['SampleQtyUnit'])));
	$tdata['U_PC_SClBy'] = trim(addslashes(strip_tags($_POST['SampleCollectBy'])));
	$tdata['U_PC_ARNo'] = trim(addslashes(strip_tags($_POST['ARNo'])));
	//$tdata['U_PC_SRSep'] = trim(addslashes(strip_tags('No')));  //'No' value
	if (!empty($_POST['DocDate'])) {
		$tdata['U_PC_DDt'] = date("Y-m-d", strtotime($_POST['DocDate']));
	} else {
		$tdata['U_PC_DDt'] = null;
	}
	$tdata['U_PC_TrNo'] = trim(addslashes(strip_tags($_POST['TRNo'])));
	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['Branch'])));
	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['ItemName'])));
	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['BatchNo'])));
	$tdata['U_PC_BtchQty'] =  trim(addslashes(strip_tags($_POST['BatchQty'])));
	$tdata['U_PC_NCont'] = trim(addslashes(strip_tags($_POST['NoofCont'])));
	$tdata['U_PC_UTNo'] = trim(addslashes(strip_tags($_POST['UnderTestTransferNo'])));
	$tdata['U_PC_CntNo1'] = trim(addslashes(strip_tags($_POST['ContainerNo1'])));
	$tdata['U_PC_CntNo2'] = trim(addslashes(strip_tags($_POST['ContainerNo2'])));
	$tdata['U_PC_CntNo3'] = trim(addslashes(strip_tags($_POST['ContainerNo3'])));
	$tdata['U_PC_QtyLab'] = trim(addslashes(strip_tags($_POST['QtyForLabel'])));
	// $tdata['U_PC_Trans'] = null;
	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['BPLId'])));
	$tdata['U_PC_LocCode'] = null;
	$tdata['U_PC_RNo'] = trim(addslashes(strip_tags($_POST['ReceiptNo'])));
	$tdata['U_PC_REnt'] = trim(addslashes(strip_tags($_POST['ReceiptNo1'])));
	$tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['RetainQty'])));
	$tdata['U_PC_RQtyUom'] = trim(addslashes(strip_tags($_POST['RetainQtyUom'])));

	$mainArray = $tdata; // header data append on main array

	// <!-- ------------------------ External Issue row data preparing start here ----------------------- --> 
	for ($i = 0; $i < count($_POST['SC_FEXI_SupplierName']); $i++) {

		$ExternalIssue['LineId'] = trim(addslashes(strip_tags(($i + 1))));
		$ExternalIssue['Object'] = 'SCS_SCINPROC';
		$ExternalIssue['U_PC_SCode'] = trim(addslashes(strip_tags($_POST['SC_FEXI_SupplierCode'][$i])));
		$ExternalIssue['U_PC_SName'] = trim(addslashes(strip_tags($_POST['SC_FEXI_SupplierName'][$i])));
		$ExternalIssue['U_PC_UOM'] = trim(addslashes(strip_tags($_POST['SC_FEXI_UOM'][$i])));
		$ExternalIssue['U_PC_SDt'] = trim(addslashes(strip_tags($_POST['SC_FEXI_SampleDate'][$i])));
		$ExternalIssue['U_PC_Whs'] = trim(addslashes(strip_tags($_POST['SC_FEXI_Warehouse'][$i])));
		$ExternalIssue['U_PC_SQty1'] = trim(addslashes(strip_tags($_POST['SC_FEXI_SampleQuantity'][$i])));
		$ExternalIssue['U_PC_Attch'] = trim(addslashes(strip_tags($_POST['SC_FEXI_Attachment'][$i])));
		$ExternalIssue['U_PC_UTxt1'] = trim(addslashes(strip_tags($_POST['SC_FEXI_UserText1'][$i])));
		$ExternalIssue['U_PC_UTxt2'] = trim(addslashes(strip_tags($_POST['SC_FEXI_UserText2'][$i])));
		$ExternalIssue['U_PC_UTxt3'] = trim(addslashes(strip_tags($_POST['SC_FEXI_UserText3'][$i])));
		if (!empty($_POST['SC_FEXI_InventoryTransfer'][$i])) {
			$ExternalIssue['U_PC_Trans'] = trim(addslashes(strip_tags($_POST['SC_FEXI_InventoryTransfer'][$i])));
		} else {
			$ExternalIssue['U_PC_Trans'] = null;
		}
		$mainArray['SCS_SCINPROC1Collection'][] = $ExternalIssue;
	}
	// <!-- ------------------------ External Issue row data preparing start here ----------------------- --> 

	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 
	for ($j = 0; $j < count($_POST['SC_FEI_SampleQuantity']); $j++) {

		$ExtraIssue['LineId'] = trim(addslashes(strip_tags(($j + 1))));
		$ExtraIssue['U_PC_SQty2'] = trim(addslashes(strip_tags($_POST['SC_FEI_SampleQuantity'][$j])));
		$ExtraIssue['U_PC_UOM'] = trim(addslashes(strip_tags($_POST['SC_FEI_UOM'][$j])));
		$ExtraIssue['U_PC_Whs'] = trim(addslashes(strip_tags($_POST['SC_FEXI_Warehouse'][$j])));
		$ExtraIssue['U_PC_SBy'] = trim(addslashes(strip_tags($_POST['SC_FEI_SampleBy'][$j])));

		if (!empty($_POST['SC_FEI_IssueDate'][$j])) {
			$ExtraIssue['U_PC_IDt'] = date("Y-m-d", strtotime($_POST['SC_FEI_IssueDate'][$j]));
		} else {
			$ExtraIssue['U_PC_IDt'] = null;
		}

		if (!empty($_POST['SC_FEI_PostExtraIssue'][$j])) {
			$ExtraIssue['U_PC_PEIs'] = trim(addslashes(strip_tags($_POST['SC_FEI_PostExtraIssue'][$j])));
		} else {
			$ExtraIssue['U_PC_PEIs'] = null;
		}

		$mainArray['SCS_SCINPROC2Collection'][] = $ExtraIssue;
	}
	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 
	
	// echo "<pre>";
	// print_r($mainArray);
	// echo "</pre>";
	// die();

	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {

		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SCINPROC . '(' . $_POST['it__DocEntry'] . ')';
		$responce_encode = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($mainArray, $Final_API);
		$responce = json_decode($responce_encode);
		if ($responce == '') {
			$data['status'] = 'True';
			$data['DocEntry'] = $responce->DocEntry;
			$data['message'] = "Sample Collection - Process In Successfully Update.";
			echo json_encode($data);
		} else {

			if (array_key_exists('error', (array)$responce)) {
				$data['status'] = 'False';
				$data['DocEntry'] = '';
				$data['message'] = $responce->error->message->value;
				echo json_encode($data);
			}
		}
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	

	//<!-- ------------- function & function responce code end Here ---- -->

	exit(0);
}















// ===========================================================================================================

if (isset($_POST['action']) && $_POST['action'] == 'OT_Open_Transaction_For_QC_popup_in_process')  // API Ser No 40 somthing wrong
{
	$API = $INPROCESSQCPOSTDOC . '&DocEntry=' . $_POST['DocEntry'] . '&BatchNo=' . $_POST['BatchNo'] . '&ItemCode=' . $_POST['ItemCode'] . '&LineNum=' . $_POST['LineNum'];

	// .'&ItemCode='.$_POST['ItemCode'].'&LineNum='.$_POST['LineNum']
	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->



	// print_r($FinalAPI);

	// die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);


	// echo "<pre>";
	// print_r($API);
	// echo "</pre>";
	// exit;
	// <!-- ------ Array declaration Start Here --------------------------------- -->
	$FinalResponce = array();
	// $FinalResponce['SampleCollDetails']=$response;
	// <!-- ------ Array declaration End Here  --------------------------------- -->
	$FinalResponce['SampleCollDetails'] = $response;
	$general_data = (!empty($response[0]->RETESTQCPOSTROWDETAILS)) ? $response[0]->RETESTQCPOSTROWDETAILS : array();
	// $qcStatus=$response[0]->QCPOSTDOCQCSTATUS; // Etra issue response seperate here 
	// $qcAttach=$response[0]->QCPOSTDOCATTACH; //External issue reponce seperate here
	// echo "<pre>";
	//    print_r($general_data);
	//    	echo "</pre>";
	//    	exit;
	// <!-- ----------- Extra Issue Start here --------------------------------- -->

	if (!empty($general_data)) {
		for ($i = 0; $i < count($general_data); $i++) {
			$SrNo = $i;
			$index = $i + 1;

			$FinalResponce['general_data'] .= '<tr>
				<td class="desabled">' . $index . '</td>

				<td><input  type="text" class="form-control" id="parameter_code' . $SrNo . '" name="parameter_code[]" value="' . $general_data[$i]->PCode . '"></td>

				<td class="desabled"><input  type="text" class="form-control" id="PName' . $SrNo . '" name="PName[]" value="' . $general_data[$i]->PName . '" readonly></td>

				<td class="desabled" title="' . $general_data[$i]->Standard . '" style="cursor: pointer;">
					<input  type="text" class="form-control" id="Standard' . $SrNo . '" name="Standard[]" value="' . $general_data[$i]->Standard . '" readonly style="width:400px;">
				</td>

				<td>
					<input type="text" id="ResultOut' . $SrNo . '" name="ResultOut[]" value="" class="form-control" style="width:200px;">
				</td>';

			if ($general_data[$i]->PDType == 'Range') {
				$FinalResponce['general_data'] .= '<td>
						<input type="text" id="ComparisonResult' . $i . '" name="ComparisonResult[]" value="" class="form-control" style="width:100px;" onfocusout="CalculateResultOut(' . $i . ')">
					</td>';
			} else {
				$FinalResponce['general_data'] .= '<td class="desabled">
						<input type="text" id="ComparisonResult' . $i . '" name="ComparisonResult[]" value="" class="form-control textbox_bg" style="width:100px;" readonly>
					</td>';
			}

			$FinalResponce['general_data'] .= '<td id="ResultOutputByQCDeptTd' . $i . '">
					<select id="ResultOutputByQCDept' . $i . '" name="ResultOutputByQCDept[]" class="form-select" style="border: 1px solid #ffffff !important;" onchange="OnChangeResultOutputByQCDept(' . $i . ')"></select>
				</td>

				<td class="desabled">
					<input type="text" id="PDType' . $i . '" name="PDType[]" value="' . $general_data[$i]->PDType . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="Logical' . $i . '" name="Logical[]" value="' . $general_data[$i]->Logical . '" class="form-control textbox_bg" style="width: 100px;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="LowMin' . $i . '" name="LowMin[]" value="' . $general_data[$i]->LowMin . '" class="form-control textbox_bg" style="width:100px;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="UppMax' . $i . '" name="UppMax[]" value="' . $general_data[$i]->UppMax . '" class="form-control textbox_bg" style="width:100px;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="Min' . $i . '" name="Min[]" value="' . $general_data[$i]->Min . '" class="form-control textbox_bg" style="width:100px;" readonly>
				</td>

				<td id="QC_StatusByAnalystTd' . $i . '">
					<select id="QC_StatusByAnalyst' . $i . '" name="QC_StatusByAnalyst[]" class="form-select" onchange="SelectedQCStatus(' . $i . ')" style="border: transparent;"></select>
				</td>

				<td class="desabled">
					<input type="text" id="TMethod' . $i . '" name="TMethod[]" value="' . $general_data[$i]->TMethod . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="MType' . $i . '" name="MType[]" value="' . $general_data[$i]->MType . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="PharmacopeiasStandard' . $i . '" name="PharmacopeiasStandard[]" value="' . $general_data[$i]->PharmacopeiasStandard . '"" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="UOM' . $i . '" name="UOM[]" value="' . $general_data[$i]->UOM . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="Retest' . $i . '" name="Retest[]" value="' . $general_data[$i]->Retest . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="ExSample' . $i . '" name="ExSample[]" value="' . $general_data[$i]->ExSample . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td>
					<select id="AnalysisBy' . $i . '" name="AnalysisBy[]" class="form-select" style="width: 140px;"></select>
				</td>

				<td>
					<input type="text" id="analyst_remark' . $i . '" name="analyst_remark[]" class="form-control">
				</td>

				<td class="desabled">
					<input type="text" id="LowMax' . $i . '" name="LowMax[]" value="' . $general_data[$i]->LowMax . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="Release' . $i . '" name="Release[]" value="' . $general_data[$i]->Release . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td>
					<input type="text" id="DescriptiveDetails' . $i . '" name="DescriptiveDetails[]" class="form-control">
				</td>

				<td class="desabled">
					<input type="text" id="UppMin' . $i . '" name="UppMin[]" value="' . $general_data[$i]->UppMin . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td>
					<input type="number" id="LowMinRes' . $i . '" name="LowMinRes[]" class="form-control">
				</td>

				<td>
					<input type="number" id="UppMinRes' . $i . '" name="UppMinRes[]" class="form-control">
				</td>

				<td>
					<input type="number" id="UppMaxRes' . $i . '" name="UppMaxRes[]" class="form-control">
				</td>

				<td>
					<input type="number" id="MeanRes' . $i . '" name="MeanRes[]" class="form-control">
				</td>

				<td>
					<input type="text" id="UserText1' . $i . '" name="UserText1[]" class="form-control">
				</td>

				<td>
					<input type="text" id="UserText2' . $i . '" name="UserText2[]" class="form-control">
				</td>

				<td>
					<input type="text" id="UserText3' . $i . '" name="UserText3[]" class="form-control">
				</td>

				<td>
					<input type="text" id="UserText4' . $i . '" name="UserText4[]" class="form-control">
				</td>

				<td>
					<input type="text" id="UserText5' . $i . '" name="UserText5[]" class="form-control">
				</td>

				<td class="desabled">
					<input type="text" id="QC_StatusResult' . $i . '" name="QC_StatusResult[]" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="Stability' . $i . '" name="Stability[]" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="Appassay' . $i . '" name="Appassay[]" value="' . $general_data[$i]->Appassay . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td class="desabled">
					<input type="text" id="AppLOD' . $i . '" name="AppLOD[]" value="' . $general_data[$i]->AppLOD . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td>
					<input type="text" id="InstrumentCode' . $i . '" name="InstrumentCode[]" class="form-control" data-bs-toggle="modal" data-bs-target=".instrument_modal" onclick="OpenInstrmentModal(' . $i . ')">
				</td>

				<td class="desabled">
					<input type="text" id="InstrumentName' . $i . '" name="InstrumentName[]" class="form-control textbox_bg" style="border: 1px solid #efefef !important;" readonly>
				</td>

				<td>
					<input type="date" id="StartDate' . $i . '" name="StartDate[]" class="form-control">
				</td>

				<td>
					<input type="time" id="StartTime' . $i . '" name="StartTime[]" class="form-control">
				</td>

				<td>
					<input type="date" id="EndDate' . $i . '" name="EndDate[]" class="form-control">
				</td>

				<td>
					<input type="time" id="EndTime' . $i . '" name="EndTime[]" class="form-control">
				</td>
			</tr>';
		}
	} else {
		$FinalResponce['general_data'] .= '<tr><td colspan="41" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}

	$FinalResponce['count'] = count($general_data);

	// <!-- ----------- Extra Issue End here --------------------------------- -->
	// exit;
	// <!-- ----------- External Issue Start Here ---------------------------- -->
	// if(!empty($qcStatus)){
	// 	for ($j=0; $j <count($qcStatus) ; $j++) { 
	// 		$SrNo=$j+1;

	// 		$FinalResponce['qcStatus'].='<tr>

	//                   <td class="desabled">'.$SrNo.'</td>

	//                   <td class="desabled"><input class="form-control border_hide desabled" type="text" id="qc_Status'.$SrNo.'" name="qc_Status[]" value="'.$qcStatus[$j]->QCStsStatus.'" readonly></td>

	//                   <td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsQty'.$SrNo.'" name="qCStsQty[]"  value="'.$qcStatus[$j]->QCStsQty.'" readonly></td>

	//                   <td class="desabled"><input  type="text" class="form-control border_hide desabled" id="qCitNo'.$SrNo.'" name="qCitNo[]"  value="'.$qcStatus[$j]->ItNo.'" readonly></td>

	//                   <td class="desabled"><input class="form-control border_hide desabled" type="text" id="doneBy'.$SrNo.'" name="doneBy[]"  value="'.$qcStatus[$j]->DBy.'" readonly></td>

	//                   <td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsRemark1'.$SrNo.'" name="qCStsRemark1[]"  value="'.$qcStatus[$j]->QCStsRemark1.'" readonly></td>

	// 		</tr>';
	// 	}
	// }else{
	// 	// $FinalResponce['qcStatus'].='<tr><td colspan="12" style="color:red;text-align: center;">No Record Found</td></tr>';
	// }

	// $FinalResponce['qcStatus'] .= '<tr id="add-more_1">
	// 		<td></td>
	// 		<td><select id="qc_Status_1" name="qc_Status[]" class="form-select qc_status_selecte1"  onfocusout="addMore(1);"></select></td>
	// 		<td><input class="border_hide" type="text"  id="qCStsQty_1" name="qCStsQty[]" class="form-control" onfocusout="addMore(1);"></td>
	// 		<td><input class="border_hide" type="text"  id="qCitNo_1" name="qCitNo[]" class="form-control"></td>
	// 		<td>
	// 		<select id="doneBy_1" name="doneBy[]" class="form-select done-by-mo1"></select>
	// 		</td>
	// 		<td><input class="border_hide" type="text"  id="qCStsRemark1_1" name="qCStsRemark1[]" class="form-control" value=""></td>
	// 	</tr>';



	// if(!empty($qcAttach)){
	// 	for ($j=0; $j <count($qcAttach) ; $j++) { 
	// 		$SrNo=$j+1;
	// <tr>

	$FinalResponce['qcStatus'] .= '<tr id="add-more_1">
		<td>' . (($qcStatusCount) + 1) . '</td>

		<td><select id="qc_Status_1" name="qc_Status[]" class="form-select qc_status_selecte1" onchange="SelectionOfQC_Status(' . (($qcStatusCount) + 1) . ')"></select></td>

		<td><input class="border_hide" type="text"  id="qCStsQty_1" name="qCStsQty[]" class="form-control" value="" onfocusout="addMore(1)"></td>

			<td><input class="border_hide" type="text"  id="qCReleaseDate_1" name="qCReleaseDate[]" class="form-control" ></td>

			<td><input class="border_hide" type="text"  id="qCReleaseTime_1" name="qCReleaseTime[]" class="form-control" ></td>

		<td><input class="border_hide" type="text"  id="qCitNo_1" name="qCitNo[]" class="form-control" value=""></td>

		<td>
			<select id="doneBy_1" name="doneBy[]" class="form-select done-by-mo1"></select>
		</td>

			<td><input class="border_hide" type="file"  id="qCAttache1_1" name="qCAttache1[]" class="form-control"></td>

			<td><input class="border_hide" type="file"  id="qCAttache2_1" name="qCAttache2[]" class="form-control"></td>

			<td><input class="border_hide" type="file"  id="qCAttache3_1" name="qCAttache3[]" class="form-control"></td>

			<td><input class="border_hide" type="date"  id="qCDeviationDate_1" name="qCDeviationDate[]" class="form-control"></td>

			<td><input class="border_hide" type="text"  id="qCDeviationNo_1" name="qCDeviationNo[]" class="form-control"></td>

			<td><input class="border_hide" type="text"  id="qCDeviationResion_1" name="qCDeviationResion[]" class="form-control"></td>

		<td><input class="border_hide" type="text"  id="qCStsRemark1_1" name="qCStsRemark1[]" class="form-control" value=""></td>
	</tr>';




	$FinalResponce['qcAttach'] .= '<tr>
		<td class="desabled"></td>
		<td class="desabled"><input class="border_hide desabled" type="text" id="targetPath" name="targetPath[]" class="form-control" value="" readonly></td>
		<td class="desabled"><input class="border_hide desabled" type="text" id="fileName" name="fileName[]"  class="form-control" value="" readonly></td>
		<td class="desabled"><input class="border_hide desabled" type="text" id="attachDate" name="attachDate[]"  class="form-control" value="" readonly></td>
		<td><input class="border_hide" type="text" id="remark" name="remark[]"  class="form-control" value=""></td>
	</tr>';


	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;
	echo json_encode($FinalResponce);
	exit(0);
}
// OpenTransaction for Sample Intimation - FG  







if (isset($_POST['action']) && $_POST['action'] == 'OT_Open_Transaction_For_Sample_Intimation_FG_popup_in_process') {
	// <!-- ------- Replace blank space to %20 start here -------- -->
	$API = $FGOPENTRANSSAMINTIMATION . '&DocEntry=' . $_POST['DocEntry'] . '&BatchNo=' . $_POST['BatchNo'] . '&ItemCode=' . $_POST['ItemCode'] . '&LineNum=' . $_POST['LineNum'];

	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if (isset($_POST['action']) && $_POST['action'] == 'OT_Open_Transaction_For_Sample_collection_FG_popup_in_process') {
	$API = $FGSAMPLECOLLECTIONVIEW . '&DocEntry=' . $_POST['DocEntry'];

	// .'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&LineNum='.$_POST['LineNum']
	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;
	echo json_encode($response);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'Open_Transaction_For_Sample_collection_in_process_popup_in_process') {
	// <!-- ------- Replace blank space to %20 start here -------- -->
	$API = $INPROCESSSAMPLECOLLECTIONVIEW . '&DocEntry=' . $_POST['DocEntry'];
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// print_r($FinalAPI);
	// die();
	// <!-- ------- Replace blank space to %20 End here -------- -->
	$response = $obj->get_OTFSI_SingleData($FinalAPI);

	echo json_encode($response);
	exit(0);
}




if (isset($_POST['action']) && $_POST['action'] == 'QC_Post_document_QC_Check_In_Process') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $INPROCESSQCPOSTDOCUMENTDETAILS . '?DocEntry=' . $DocEntry;

	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20

	// print_r($FinalAPI);
	// <!-- ------- Replace blank space to %20 End here -------- -->

	//print_r($FinalAPI);die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);

	$FinalResponce['SampleCollDetails'] = $response;
	// <!-- ------ Array declaration End Here  --------------------------------- -->
	$general_data = $response[0]->INPROCESSQCPOSTDOCGENERALDATA;
	$qcStatus = $response[0]->INPROCESSQCPOSTDOCQCSTATUS; // Etra issue response seperate here 
	$qcAttach = $response[0]->INPROCESSQCPOSTDOCATTACH; //External issue reponce seperate here

	//    echo "<pre>";
	// print_r($general_data);
	// echo "</pre>";
	// exit;

















	if (!empty($general_data)) {
		for ($i = 0; $i < count($general_data); $i++) {
			$SrNo = $i;
			$index = $i + 1;

			$FinalResponce['general_data'] .= '<tr>
			<td class="desabled">' . $index . '</td>

			<td class="desabled"><input  type="text" class="form-control textbox_bg" id="parameter_code' . $SrNo . '" name="parameter_code[]" value="' . $general_data[$i]->PCode . '" readonly></td>

			<td class="desabled"><input  type="text" class="form-control textbox_bg" id="PName' . $SrNo . '" name="PName[]" value="' . $general_data[$i]->PName . '" readonly></td>

			<td class="desabled" style="cursor: pointer;"><input  type="text" class="form-control textbox_bg" id="Standard' . $SrNo . '" name="Standard[]" value="' . $general_data[$i]->Standard . '" readonly class="form-control textbox_bg" style="border: 1px solid #efefef !important;width:400px;"></td>
			
			<td><input type="text" id="ResultOut' . $SrNo . '" name="ResultOut[]" value="' . $general_data[$i]->GDRemarks . '" class="form-control" style="width:200px;"></td>';

			if ($general_data[$i]->PDType == 'Range') {
				$FinalResponce['general_data'] .= '<td>
				<input type="text" id="ComparisonResult' . $SrNo . '" name="ComparisonResult[]" value="' . $general_data[$i]->LowMin1 . '" class="form-control" style="width:100px;" onfocusout="CalculateResultOut(' . $SrNo . ')">
			</td>';
			} else {
				$FinalResponce['general_data'] .= '<td class="desabled">
				<input type="text" id="ComparisonResult' . $SrNo . '" name="ComparisonResult[]" value="' . $general_data[$i]->LowMin1 . '" class="form-control textbox_bg" style="width:100px;">
			</td>';
			}


			$FinalResponce['general_data'] .= '
			<td id="ResultOutputByQCDeptTd' . $SrNo . '">
				<input type="hidden" id="ResultOutputByQCDept_Old' . $SrNo . '" name="ResultOutputByQCDept_Old[]" value="' . $general_data[$i]->ROutput . '">

				<select id="ResultOutputByQCDept' . $SrNo . '" name="ResultOutputByQCDept[]" class="form-select" style="border: 1px solid #ffffff !important;" onchange="OnChangeResultOutputByQCDept(' . $SrNo . ')"></select>
			</td>

			<td class="desabled">
				<input type="text" id="PDType' . $SrNo . '" name="PDType[]" value="' . $general_data[$i]->PDType . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
			</td>

			<td class="desabled"><input  type="text" class="form-control textbox_bg" id="logical' . $SrNo . '" name="logical[]" value="' . $general_data[$i]->Logical . '" readonly></td>

			<td class="desabled"><input  type="text" class="form-control textbox_bg" id="LowMin' . $SrNo . '" name="LowMin[]" value="' . $general_data[$i]->LowMin . '" readonly></td>

			<td class="desabled"><input  type="text" class="form-control textbox_bg" id="UppMax' . $SrNo . '" name="UppMax[]" value="' . $general_data[$i]->UppMax . '" readonly></td>

			<td class="desabled"><input  type="text" class="form-control textbox_bg" id="Min' . $SrNo . '" name="Min[]" value="' . $general_data[$i]->Min . '" readonly></td>
			
			<td id="QC_StatusByAnalystTd' . $SrNo . '">
				<input type="hidden" id="qC_status_by_analyst_Old' . $SrNo . '" name="qC_status_by_analyst_Old[]" value="' . $general_data[$i]->GDQCStatus . '">

				<select id="qC_status_by_analyst' . $SrNo . '" name="qC_status_by_analyst[]" class="form-select qc_statusbyab' . $SrNo . '" onchange="SelectedQCStatus(' . $SrNo . ')">
				</select>
			</td>

			<td class="desabled"><input  type="text" class="form-control textbox_bg" id="TMethod' . $SrNo . '" name="TMethod[]" value="' . $general_data[$i]->TMethod . '" readonly></td>
			
			<td class="desabled"><input  type="text" class="form-control textbox_bg" id="MType' . $SrNo . '" name="MType[]" value="' . $general_data[$i]->MType . '" readonly></td>
			<td class="desabled">
				<input type="text" id="PharmacopeiasStandard' . $i . '" name="PharmacopeiasStandard[]" value="' . $general_data[$i]->PharmacopeiasStandard . '"" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
			</td>

			<td class="desabled"><input type="text" id="UOM' . $SrNo . '" name="UOM[]" class="form-control textbox_bg" value="' . $general_data[$i]->GDUOM . '" readonly></td>

			<td class="desabled"><input type="text" id="Retest' . $SrNo . '" name="Retest[]" class="form-control textbox_bg" value="' . $general_data[$i]->Retest . '" readonly></td>
			
			<td class="desabled"><input type="text" id="ExSample' . $SrNo . '" name="ExSample[]" class="form-control textbox_bg" value="' . $general_data[$i]->ExSample . '" readonly></td>

			<td>
				<input type="hidden" id="AnalysisBy_Old' . $SrNo . '" name="AnalysisBy_Old[]" value="' . $general_data[$i]->AnyBy . '">

				<select id="AnalysisBy' . $SrNo . '" name="AnalysisBy[]" class="form-select" style="width: 140px;"></select>
			</td>

			<td><input  type="text" id="analyst_remark' . $SrNo . '" name="analyst_remark[]" class="form-control" value="' . $general_data[$i]->ARRemark . '"></td>
		
			<td class="desabled"><input  type="text" class="form-control textbox_bg" id="LowMax' . $SrNo . '" name="LowMax[]" value="' . $general_data[$i]->LowMax . '" readonly></td>

			<td class="desabled"><input  type="text" class="form-control textbox_bg" id="Release' . $SrNo . '" name="Release[]" value="' . $general_data[$i]->Release . '" readonly></td>
			
			<td><input  type="text" class="form-control" id="descriptive_details' . $SrNo . '" name="descriptive_details[]" value="' . $general_data[$i]->DesDetils . '"></td>

			<td class="desabled"><input  type="text" class="form-control textbox_bg" id="UppMin' . $SrNo . '" name="UppMin[]" value="' . $general_data[$i]->UppMin . '" readonly></td>
			
			<td><input  type="number" id="lower_min_result' . $SrNo . '" name="lower_min_result[]" class="form-control" value="' . $general_data[$i]->LowMax1 . '"></td>
			
			<td><input  type="number" id="UppMinRes' . $SrNo . '" name="UppMinRes[]" class="form-control"></td>
			
			<td><input  type="number" id="upper_max_result' . $SrNo . '" name="upper_max_result[]" class="form-control" value="' . $general_data[$i]->UppMax1 . '"></td>

			<td>
				<input type="number" id="MeanRes' . $SrNo . '" name="MeanRes[]" class="form-control">
			</td>

			<td><input type="text" id="user_text1_' . $SrNo . '" name="user_text1_[]" class="form-control" value="' . $general_data[$i]->UText1 . '"></td>

			<td><input type="text" id="user_text2_' . $SrNo . '" name="user_text2_[]" class="form-control" value="' . $general_data[$i]->UText2 . '"></td>

			<td><input type="text" id="user_text3_' . $SrNo . '" name="user_text3_[]" class="form-control" value="' . $general_data[$i]->UText3 . '"></td>

			<td><input type="text" id="user_text4_' . $SrNo . '" name="user_text4_[]" class="form-control" value="' . $general_data[$i]->UText4 . '"></td>

			<td ><input type="text" id="user_text5_' . $SrNo . '" name="user_text5_[]" class="form-control" value="' . $general_data[$i]->UText5 . '"></td>
			
			<td class="desabled">
				<input type="text" id="QC_StatusResult' . $SrNo . '" name="QC_StatusResult[]" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
			</td>

			<td class="desabled"><input type="text" id="GDStab' . $SrNo . '" name="GDStab[]" class="form-control textbox_bg" value="' . $general_data[$i]->GDStab . '" readonly></td>
			
			<td class="desabled"><input type="text" id="Appassay' . $SrNo . '" name="Appassay[]" class="form-control textbox_bg" value="' . $general_data[$i]->Appassay . '" readonly></td>

			<td class="desabled"><input type="text" id="AppLOD' . $SrNo . '" name="AppLOD[]" class="form-control textbox_bg" value="' . $general_data[$i]->AppLOD . '" readonly></td>
		
			<td><input type="text" id="InstrumentCode' . $SrNo . '" name="InstrumentCode[]" class="form-control" data-bs-toggle="modal" data-bs-target=".instrument_modal" value="' . $general_data[$i]->Inscode . '" onclick="OpenInstrmentModal(' . $SrNo . ')"></td>

			<td class="desabled"><input type="text" id="InstrumentName' . $SrNo . '" name="InstrumentName[]" class="form-control textbox_bg" value="' . $general_data[$i]->InsName . '" readonly style="border: 1px solid #efefef !important;"></td>

			<td><input  type="date" id="start_date' . $SrNo . '" name="start_date[]" class="form-control" value="' . (!empty($general_data[$i]->SDate) ? date("Y-m-d", strtotime($general_data[$i]->SDate)) : '') . '"></td>

			<td><input  type="time" id="start_time' . $SrNo . '" name="start_time[]" class="form-control" value="' . (!empty($general_data[$i]->STime) ? date("H:i", strtotime($general_data[$i]->STime)) : '') . '"></td>

			<td ><input type="date" id="end_date' . $SrNo . '" name="end_date[]" class="form-control" value="' . (!empty($general_data[$i]->EDate) ? date("Y-m-d", strtotime($general_data[$i]->EDate)) : '') . '"></td>


			<td ><input type="time" id="end_time' . $SrNo . '" name="end_time[]" class="form-control" value="' . (!empty($general_data[$i]->ETime) ? date("H:i", strtotime($general_data[$i]->ETime)) : '') . '"></td>
		</tr>';
		}
	} else {
		$FinalResponce['general_data'] .= '<tr><td colspan="7" style="color:red;text-align: center;">No Record Found</td></tr>';
	}

	$FinalResponce['count'] = count($general_data);


	// <!-- ----------- External Issue Start Here ---------------------------- -->
	if (!empty($qcStatus)) {
		for ($j = 0; $j < count($qcStatus); $j++) {
			if (!empty($qcStatus[$j]->QCStsStatus)) {
				$SrNo = $j + 1;

				$FinalResponce['qcStatus'] .= '<tr id="add-more_' . $SrNo . '">';
				if (!empty($qcStatus[$j]->ItNo)) {
					$FinalResponce['qcStatus'] .= '<td class="desabled">' . $SrNo . '</td>';
				} else {
					$FinalResponce['qcStatus'] .= '<td style="text-align: center;">
					<input type="radio" id="list' . $SrNo . '" name="listRado[]" value="' . $SrNo . '" class="form-check-input" style="width: 17px;height: 17px;">
				</td>';
				}
				$FinalResponce['qcStatus'] .= '

				<td class="desabled">
					<input type="hidden" id="QCS_LineId' . $SrNo . '" name="QCS_LineId[]" value="' . $qcStatus[$j]->LineId . '">

					<input class="form-control border_hide desabled" type="text" id="qc_Status' . $SrNo . '" name="qc_Status[]" value="' . $qcStatus[$j]->QCStsStatus . '" readonly>
				</td>

				<td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsQty' . $SrNo . '" name="qCStsQty[]"  value="' . $qcStatus[$j]->QCStsQty . '" readonly></td>

				<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCReleaseDate_' . $SrNo . '" name="qCReleaseDate[]" value="' . ((!empty($qcStatus[$j]->QCStsRelDate)) ? date("d-m-Y", strtotime($qcStatus[$j]->QCStsRelDate)) : "") . '" class="form-control" readonly></td>

				<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCReleaseTime_' . $SrNo . '" name="qCReleaseTime[]" value="' . ((!empty($qcStatus[$j]->QCStsRelTime)) ? date("H:i", strtotime($qcStatus[$j]->QCStsRelTime)) : "") . '" class="form-control" readonly></td>

				<td class="desabled"><input  type="text" class="form-control border_hide desabled" id="qCitNo' . $SrNo . '" name="qCitNo[]"  value="' . $qcStatus[$j]->ItNo . '" readonly></td>

				<td class="desabled"><input class="form-control border_hide desabled" type="text" id="doneBy' . $SrNo . '" name="doneBy[]"  value="' . $qcStatus[$j]->DBy . '" readonly></td>

				<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCAttache1_' . $SrNo . '" name="qCAttache1[]" value="' . $qcStatus[$j]->QCStsAttach1 . '" class="form-control"></td>

				<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCAttache2_' . $SrNo . '" name="qCAttache2[]" value="' . $qcStatus[$j]->QCStsAttach2 . '" class="form-control"></td>

				<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCAttache3_' . $SrNo . '" name="qCAttache3[]" value="' . $qcStatus[$j]->QCStsAttach3 . '" class="form-control"></td>

				<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCDeviationDate_' . $SrNo . '" name="qCDeviationDate[]" value="' . ((!empty($qcStatus[$j]->DevDate)) ? date("d-m-Y", strtotime($qcStatus[$j]->DevDate)) : "") . '" class="form-control"></td>

				<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCDeviationNo_' . $SrNo . '" name="qCDeviationNo[]" value="' . $qcStatus[$j]->DevNo . '" class="form-control"></td>

				<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCDeviationResion_' . $SrNo . '" name="qCDeviationResion[]" value="' . $qcStatus[$j]->DevRsn . '" class="form-control"></td>

				<td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsRemark1' . $SrNo . '" name="qCStsRemark1[]"  value="' . $qcStatus[$j]->QCStsRemark1 . '" readonly></td>

			</tr>';
			}
		}
		$QCS_un_id = (count($qcStatus) + 1);
		$FinalResponce['qcStatus'] .= '<tr id="add-more_' . $QCS_un_id . '">
		<td>' . $QCS_un_id . '</td>
		<td><select id="qc_Status_' . $QCS_un_id . '" name="qc_Status[]" class="form-select qc_status_selecte1" onchange="SelectionOfQC_Status(' . $QCS_un_id . ')"></select></td>

		<td><input class="border_hide" type="text"  id="qCStsQty_' . $QCS_un_id . '" name="qCStsQty[]" class="form-control" value="" onfocusout="addMore(' . $QCS_un_id . ');"></td>


		<td><input class="border_hide" type="text"  id="qCReleaseDate_' . $QCS_un_id . '" name="qCReleaseDate[]" class="form-control" readonly></td>

		<td><input class="border_hide" type="text"  id="qCReleaseTime_' . $QCS_un_id . '" name="qCReleaseTime[]" class="form-control" readonly></td>

		<td><input class="border_hide" type="text"  id="qCitNo_' . $QCS_un_id . '" name="qCitNo[]" class="form-control" value=""></td>

		<td>
		<select id="doneBy_' . $QCS_un_id . '" name="doneBy[]" class="form-select done-by-mo1"></select>
		</td>

		<td><input class="border_hide" type="file"  id="qCAttache1_' . $QCS_un_id . '" name="qCAttache1[]" class="form-control"></td>


		<td><input class="border_hide" type="file"  id="qCAttache2_' . $QCS_un_id . '" name="qCAttache2[]" class="form-control"></td>

		<td><input class="border_hide" type="file"  id="qCAttache3_' . $QCS_un_id . '" name="qCAttache3[]" class="form-control"></td>

		<td><input class="border_hide" type="date"  id="qCDeviationDate_' . $QCS_un_id . '" name="qCDeviationDate[]" class="form-control"></td>

		<td><input class="border_hide" type="text"  id="qCDeviationNo_' . $QCS_un_id . '" name="qCDeviationNo[]" class="form-control"></td>

		<td><input class="border_hide" type="text"  id="qCDeviationResion_' . $QCS_un_id . '" name="qCDeviationResion[]" class="form-control"></td>

		<td><input class="border_hide" type="text"  id="qCStsRemark1_' . $QCS_un_id . '" name="qCStsRemark1[]" class="form-control"></td>
		
	</tr>';
	} else {
		// $FinalResponce['qcStatus'].='<tr><td colspan="12" style="color:red;text-align: center;">No Record Found</td></tr>';
		$QCS_un_id = (count($qcStatus) + 1);
		$FinalResponce['qcStatus'] .= '<tr id="add-more_' . $QCS_un_id . '">
		<td>' . $QCS_un_id . '</td>
		<td><select id="qc_Status_' . $QCS_un_id . '" name="qc_Status[]" class="form-select qc_status_selecte1" onchange="SelectionOfQC_Status(' . $QCS_un_id . ')"></select></td>

		<td><input class="border_hide" type="text"  id="qCStsQty_' . $QCS_un_id . '" name="qCStsQty[]" class="form-control" value="" onfocusout="addMore(' . $QCS_un_id . ');"></td>


		<td><input class="border_hide" type="text"  id="qCReleaseDate_' . $QCS_un_id . '" name="qCReleaseDate[]" class="form-control" readonly></td>

		<td><input class="border_hide" type="text"  id="qCReleaseTime_' . $QCS_un_id . '" name="qCReleaseTime[]" class="form-control" readonly></td>

		<td><input class="border_hide" type="text"  id="qCitNo_' . $QCS_un_id . '" name="qCitNo[]" class="form-control" value=""></td>

		<td>
		<select id="doneBy_' . $QCS_un_id . '" name="doneBy[]" class="form-select done-by-mo1"></select>
		</td>

		<td><input class="border_hide" type="file"  id="qCAttache1_' . $QCS_un_id . '" name="qCAttache1[]" class="form-control"></td>


		<td><input class="border_hide" type="file"  id="qCAttache2_' . $QCS_un_id . '" name="qCAttache2[]" class="form-control"></td>

		<td><input class="border_hide" type="file"  id="qCAttache3_' . $QCS_un_id . '" name="qCAttache3[]" class="form-control"></td>

		<td><input class="border_hide" type="date"  id="qCDeviationDate_' . $QCS_un_id . '" name="qCDeviationDate[]" class="form-control"></td>

		<td><input class="border_hide" type="text"  id="qCDeviationNo_' . $QCS_un_id . '" name="qCDeviationNo[]" class="form-control"></td>

		<td><input class="border_hide" type="text"  id="qCDeviationResion_' . $QCS_un_id . '" name="qCDeviationResion[]" class="form-control"></td>

		<td><input class="border_hide" type="text"  id="qCStsRemark1_' . $QCS_un_id . '" name="qCStsRemark1[]" class="form-control"></td>
		
	</tr>';
	}






	if (!empty($qcAttach)) {
		for ($j = 0; $j < count($qcAttach); $j++) {
			$SrNo = $j + 1;
			// <tr>
			$FinalResponce['qcAttach'] .= '<tr>
			<td class="desabled">' . $SrNo . '</td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="targetPath' . $SrNo . '" name="targetPath[]" class="form-control" value="' . $qcAttach[$j]->TargetPath . '" readonly>
			</td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="fileName' . $SrNo . '" name="fileName[]"  class="form-control" value="' . $qcAttach[$j]->FileName . '" readonly></td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="attachDate' . $SrNo . '" name="attachDate[]"  class="form-control" value="' . $qcAttach[$j]->AttachDate . '" readonly></td>
			<td><input class="border_hide" type="text" id="freeText' . $SrNo . '" name="freeText[]"  class="form-control" value="' . $qcAttach[$j]->FreeText . '"></td>
		</tr>';
		}
	} else {
		$FinalResponce['qcAttach'] .= '<tr>
				<td class="desabled">1</td>
				<td class="desabled"><input class="border_hide desabled" type="text" id="targetPath1" name="targetPath[]" class="form-control" value="" readonly></td>
				<td class="desabled"><input class="border_hide desabled" type="text" id="fileName1" name="fileName[]"  class="form-control" value="" readonly></td>
				<td class="desabled"><input class="border_hide desabled" type="text" id="attachDate1" name="attachDate[]"  class="form-control" value="" readonly></td>
				<td><input class="border_hide" type="text" id="freeText1" name="freeText[]"  class="form-control" value=""></td>
			</tr>';
		// $FinalResponce['qcAttach'].='<tr><td colspan="12" style="color:red;text-align: center;">No Record Found</td></tr>';
	}



	// echo "<pre>";
	// print_r($FinalResponce);
	// echo "</pre>";
	// exit;
	echo json_encode($FinalResponce);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'qc_assay_Calculation_Based_On_ajax') {
	$getDropdown_assay = $objKri->get_assay_Calculation_Based_On_dropdown($assay_Calculation_VALIDVALUES_On);
	$html = "";
	foreach ($getDropdown_assay as $value) {
		$html .= '<option value="' . $value->FldValue . '">' . $value->FldValue . '</option>';
	}
	echo $html;
}

if (isset($_POST['action']) && $_POST['action'] == 'qc_assay_Calculation_Based_stability_ajax') {
	$getDropdown_assay = $objKri->get_assay_Calculation_Based_On_dropdown($assay_Calculation_VALIDVALUES_On_Stability);
	$html = "";
	foreach ($getDropdown_assay as $value) {
		$html .= '<option value="' . $value->FldValue . '">' . $value->FldValue . '</option>';
	}
	echo $html;
}

if (isset($_POST['action']) && $_POST['action'] == 'qc_FGassay_Calculation_Based_On_ajax') {
	$getDropdown_assay = $objKri->get_assay_Calculation_Based_On_dropdown($assay_Calculation_FG_VALIDVALUES_On);
	$html = "";
	foreach ($getDropdown_assay as $value) {
		$html .= '<option value="' . $value->FldValue . '">' . $value->FldValue . '</option>';
	}
	echo $html;
}

if (isset($_POST['action']) && $_POST['action'] == 'qc_FGassay_Calculation_Based_On_routStage_ajax') {
	$getDropdown_assay = $objKri->get_assay_Calculation_Based_On_dropdown($assay_Calculation_FG_VALIDVALUES_On_routeStage);
	$html = "";
	foreach ($getDropdown_assay as $value) {
		$html .= '<option value="' . $value->FldValue . '">' . $value->FldValue . '</option>';
	}
	echo $html;
}



if (isset($_POST['action']) && $_POST['action'] == 'Compiled_By_dropdown_ajax') {
	$getDropdown_assay = $objKri->get_SAMINTTRBY($SAMINTTRBY_API);
	$html = "";
	foreach ($getDropdown_assay as $value) {
		if ($value->TRBy != "") {
			$html .= '<option value="' . $value->TRBy . '">' . $value->TRBy . '</option>';
		}
	}
	echo $html;
}




if (isset($_POST['action']) && $_POST['action'] == 'ResultOutputDropdown_ajax') {
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_SCS_OROUTPUT;

		$responce_encode = $obj->getFunctionServiceLayer($Final_API);
		$responce = json_decode($responce_encode);

		for ($i = 0; $i < count($responce->value); $i++) {

			$option .= '<option value="' . $responce->value[$i]->Code . '">' . $responce->value[$i]->Name . '</option>';
		}
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	print_r($option);
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}


if (isset($_POST['action']) && $_POST['action'] == 'qc_post_document_in_process_pupup_ajax') {
	// $API=$RETESTQCPOSTDOCUMENTDETAILS.'?DocEntry='.$_POST['DocEntry'].'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&LineNum='.$_POST['LineNum'];
	$API = $INPROCESSQCPOSTDOCUMENTDETAILS . '?DocEntry=' . $_POST['DocEntry'] . '&Status=' . $_POST['QC_Status'];
	// $API=$RETESTQCPOSTDOC.'?DocEntry='.$_POST['DocEntry'];
	// echo $API;
	// exit;
	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20

	// 	print_r($FinalAPI);
	//    die();
	// 	// <!-- ------- Replace blank space to %20 End here -------- -->
	$response = $objKri->get_QcPostDocument_RetestQcSingleData($FinalAPI);
	//    echo "<pre>";
	// print_r($response);
	// echo "<pre>";
	// exit;
	echo json_encode($response);
	exit(0);
}




if (isset($_POST['action']) && $_POST['action'] == 'Sample_Collection_Finished_Goods_In_Process') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $FGSAMPCOLLADD . '?DocEntry=' . $DocEntry;
	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	// print_r($FinalAPI);die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	//    echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;

	$FinalResponce['SampleCollDetails'] = $response;
	// <!-- ------ Array declaration End Here  --------------------------------- -->
	$ExternalIssue = $response[0]->FGSAMCOLLEXTERNAL; //External issue reponce seperate here
	$ExtraIssue = $response[0]->FGSAMCOLLEXTRA; // Etra issue response seperate here 


	// ===================================================================================================================================
	// <!-- ----------- Extra Issue Start here --------------------------------- -->
	if (!empty($ExtraIssue)) {
		for ($i = 0; $i < count($ExtraIssue); $i++) {
			// $SrNo=$i+1;
			$SrNo = $rowCount_N + 1;

			if (!empty($ExtraIssue[$i]->IssueDate)) {
				$IssueDate = date("d-m-Y", strtotime($ExtraIssue[$i]->IssueDate));
			} else {
				$IssueDate = '';
			}

			$FinalResponce['ExtraIssue'] .= '<tr>
				    <td>
				    	<input type="radio" id="ExtraIslist' . $SrNo . '" name="ExtraIslistRado" value="' . $SrNo . '" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExtraIssue(' . $SrNo . ')">
				    </td>

				    <td class="desabled">
				    	<input class="border_hide" type="hidden" id="SC_FEI_Linenum' . $SrNo . '" name="SC_FEI_Linenum[]" value="' . $ExtraIssue[$i]->LineNum . '" class="form-control desabled" readonly>

				    	<input class="border_hide desabled" type="text" id="SC_FEI_SampleQuantity' . $SrNo . '" name="SC_FEI_SampleQuantity[]" value="' . $ExtraIssue[$i]->sampleQty2 . '" class="form-control desabled" readonly>
			    	</td>

				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_UOM' . $SrNo . '" name="SC_FEI_UOM[]" value="' . $ExtraIssue[$i]->UOM2 . '" class="form-control desabled" readonly></td>

				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_Warehouse' . $SrNo . '" name="SC_FEI_Warehouse[]" value="' . $ExtraIssue[$i]->Whs2 . '" class="form-control desabled" readonly></td>

				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_SampleBy' . $SrNo . '" name="SC_FEI_SampleBy[]" value="' . $ExtraIssue[$i]->SampleBy . '" class="form-control desabled" readonly></td>

				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_IssueDate' . $SrNo . '" name="SC_FEI_IssueDate[]" value="' . $IssueDate . '" class="form-control desabled" readonly></td>

				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_PostExtraIssue' . $SrNo . '" name="SC_FEI_PostExtraIssue[]" value="' . $ExtraIssue[$i]->PostExtraIssue . '" class="form-control desabled" readonly></td>
				 </tr>';
		}
		// when table data come then default add one manual row start ---------------------------------------------------------
		$SrNo = (count($ExtraIssue) + 1);
		$FinalResponce['ExtraIssue'] .= '<tr>
			    <td class="desabled">
			    	
			    </td>

			    <td>
				    <input class="border_hide" type="hidden" id="SC_FEI_Linenum' . $SrNo . '" name="SC_FEI_Linenum[]" value="' . $ExtraIssue[$i]->LineNum . '" class="form-control" readonly>

				    <input class="border_hide" type="text" id="SC_FEI_SampleQuantity' . $SrNo . '" name="SC_FEI_SampleQuantity[]" value="' . $ExtraIssue[$i]->sampleQty2 . '" class="form-control">
			    </td>

			    <td>
			    	<input class="border_hide" type="text" id="SC_FEI_UOM' . $SrNo . '" name="SC_FEI_UOM[]" value="' . $ExtraIssue[$i]->UOM2 . '" class="form-control">
		    	</td>

			    <td>
			    	<select class="form-control SC_FEI_WarehouseWithData" id="SC_FEI_Warehouse' . $SrNo . '" name="SC_FEI_Warehouse[]" style="width: 200px;">
					</select>
		    	</td>

			    <td>
			    	<input class="border_hide" type="text" id="SC_FEI_SampleBy' . $SrNo . '" name="SC_FEI_SampleBy[]" value="' . $ExtraIssue[$i]->SampleBy . '" class="form-control">
		    	</td>

			    <td>
			    	<input class="border_hide" type="date" id="SC_FEI_IssueDate' . $SrNo . '" name="SC_FEI_IssueDate[]" value="' . $IssueDate . '" class="form-control">
		    	</td>

			    <td>
			    	<input class="border_hide" type="text" id="SC_FEI_PostExtraIssue' . $SrNo . '" name="SC_FEI_PostExtraIssue[]" value="' . $ExtraIssue[$i]->PostExtraIssue . '" class="form-control">
		    	</td>
			 </tr>';

		// onchange="ExternalIssueSelectedBP('.$SrNo.')"  ---->  warehouse selection onchange function
	} else {
		$SrNo = $rowCount_N + 1;
		$FinalResponce['ExtraIssue'] .= '<tr>
			    <td class="desabled">
			    	
			    </td>

			    <td>
				    <input class="border_hide" type="hidden" id="SC_FEI_Linenum' . $SrNo . '" name="SC_FEI_Linenum[]" value="' . $ExtraIssue[$i]->LineNum . '" class="form-control" readonly>

				    <input class="border_hide" type="text" id="SC_FEI_SampleQuantity' . $SrNo . '" name="SC_FEI_SampleQuantity[]" value="' . $ExtraIssue[$i]->SampleQuantity . '" class="form-control">
			    </td>

			    <td>
			    	<input class="border_hide" type="text" id="SC_FEI_UOM' . $SrNo . '" name="SC_FEI_UOM[]" value="' . $ExtraIssue[$i]->UOM . '" class="form-control">
		    	</td>

			    <td>
			    	<select class="form-control SC_FEI_WarehouseWithData" id="SC_FEI_Warehouse' . $SrNo . '" name="SC_FEI_Warehouse[]" style="width: 200px;">
					</select>
		    	</td>

			    <td>
			    	<input class="border_hide" type="text" id="SC_FEI_SampleBy' . $SrNo . '" name="SC_FEI_SampleBy[]" value="' . $ExtraIssue[$i]->SampleBy . '" class="form-control">
		    	</td>

			    <td>
			    	<input class="border_hide" type="date" id="SC_FEI_IssueDate' . $SrNo . '" name="SC_FEI_IssueDate[]" value="' . $IssueDate . '" class="form-control">
		    	</td>

			    <td>
			    	<input class="border_hide" type="text" id="SC_FEI_PostExtraIssue' . $SrNo . '" name="SC_FEI_PostExtraIssue[]" value="' . $ExtraIssue[$i]->PostExtraIssue . '" class="form-control">
		    	</td>
			 </tr>';

		// onchange="ExternalIssueSelectedBP('.$SrNo.')"  ---->  warehouse selection onchange function
	}


	// <!-- ----------- External Issue Start Here ---------------------------- -->
	if (!empty($ExternalIssue)) {
		for ($j = 0; $j < count($ExternalIssue); $j++) {

			$SrNo = $rowCount + 1;
			if (count($ExternalIssue) == $SrNo) {
				if (!empty($ExternalIssue[$j]->SampleDate)) {
					$SampleDate = date("d-m-Y", strtotime($ExternalIssue[$j]->SampleDate));
				} else {
					$SampleDate = '';
				}

				$FinalResponce['ExternalIssue'] .= '<tr>
				    
					<td style="text-align: center;">
						<input class="border_hide" type="hidden" id="SC_FEXI_Linenum' . $SrNo . '" name="SC_FEXI_Linenum[]" value="' . $ExternalIssue[$j]->LineNum . '" class="form-control desabled" readonly>

					    <input type="radio" id="list' . $SrNo . '" name="listRado" value="' . $SrNo . '" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExternalIssue(' . $SrNo . ')">
					</td>
				 	
				 	<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierCode' . $SrNo . '" name="SC_FEXI_SupplierCode[]" value="' . $ExternalIssue[$j]->SupplierCode . '" class="form-control desabled" readonly></td>
				    
				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName' . $SrNo . '" name="SC_FEXI_SupplierName[]" value="' . $ExternalIssue[$j]->SupplierName . '" class="form-control desabled" readonly></td>
				    
				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UOM' . $SrNo . '" name="SC_FEXI_UOM[]" value="' . $ExternalIssue[$j]->UOM1 . '" class="form-control desabled" readonly></td>
				    
				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleDate' . $SrNo . '" name="SC_FEXI_SampleDate[]" value="' . $SampleDate . '" class="form-control desabled" readonly></td>
				    
				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Warehouse' . $SrNo . '" name="SC_FEXI_Warehouse[]" value="' . $ExternalIssue[$j]->Whs1 . '" class="form-control desabled" readonly></td>
				    
				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleQuantity' . $SrNo . '" name="SC_FEXI_SampleQuantity[]" value="' . $ExternalIssue[$j]->sampleQty1 . '" class="form-control desabled" readonly></td>
				    
				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer' . $SrNo . '" name="SC_FEXI_InventoryTransfer[]" value="' . $ExternalIssue[$j]->InventoryTransfer . '" class="form-control desabled" readonly></td>

				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText1' . $SrNo . '" name="SC_FEXI_UserText1[]" value="' . $ExternalIssue[$j]->UText1 . '" class="form-control desabled" readonly></td>

				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText2' . $SrNo . '" name="SC_FEXI_UserText2[]" value="' . $ExternalIssue[$j]->UText2 . '" class="form-control desabled" readonly></td>

				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText3' . $SrNo . '" name="SC_FEXI_UserText3[]" value="' . $ExternalIssue[$j]->UText3 . '" class="form-control desabled" readonly></td>

				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment' . $SrNo . '" name="SC_FEXI_Attachment[]" value="' . $ExternalIssue[$j]->Attach . '" class="form-control"></td>
				</tr>';
			}
		}

		// when table data come then default add one manual row start ---------------------------------------------------------
		$SrNo = (count($ExternalIssue) + 1);

		$FinalResponce['ExternalIssue'] .= '<tr>
			    <td>
			    	
			    </td>
			 	
			 	<td>
			 		<input class="border_hide" type="hidden" id="SC_FEXI_Linenum' . $SrNo . '" name="SC_FEXI_Linenum[]" value="" class="form-control desabled" readonly>

					
					<select class="form-control ExternalIssueSelectedBPWithData" id="SC_ExternalI_SupplierCode' . $SrNo . '" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP(' . $SrNo . ')" style="width: 200px;">
					</select>
				</td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName' . $SrNo . '" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>
			    
			    <td><input class="border_hide" type="text" id="SC_FEXI_UOM' . $SrNo . '" name="SC_FEXI_UOM[]" class="form-control desabled"></td>
			    
			    <td><input class="border_hide" type="date" id="SC_FEXI_SampleDate' . $SrNo . '" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>
			    
			    <td>
					<select class="form-control ExternalIssueWareHouseWithData" id="SC_ExternalI_Warehouse' . $SrNo . '" name="SC_ExternalI_Warehouse[]" style="width: 200px;"></select>
				</td>
			    
			    <td><input class="border_hide" type="text" id="SC_FEXI_SampleQuantity' . $SrNo . '" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer' . $SrNo . '" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText1' . $SrNo . '" name="SC_FEXI_UserText1[]" class="form-control"></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText2' . $SrNo . '" name="SC_FEXI_UserText2[]" class="form-control"></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText3' . $SrNo . '" name="SC_FEXI_UserText3[]" class="form-control"></td>

			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment' . $SrNo . '" name="SC_FEXI_Attachment[]" class="form-control"></td>
			</tr>';
		// when table data come then default add one manual row end -----------------------------------------------------------
	} else {
		// if user not added External issue recored then show default blank row
		$SrNo = $rowCount + 1;

		$FinalResponce['ExternalIssue'] .= '<tr>
			    <td>
			    	<input class="border_hide" type="text" id="SC_FEXI_Linenum' . $SrNo . '" name="SC_FEXI_Linenum[]" value="' . $SrNo . '" class="form-control desabled" readonly>
			    </td>
			 	
			 	<td>
					<select class="form-control ExternalIssueDefault" id="SC_ExternalI_SupplierCode' . $SrNo . '" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP(' . $SrNo . ')" style="width: 200px;">
						 
					</select>
				</td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName' . $SrNo . '" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>
			    
			    <td><input class="border_hide" type="text" id="SC_FEXI_UOM' . $SrNo . '" name="SC_FEXI_UOM[]" class="form-control desabled"></td>
			    
			    <td><input class="border_hide" type="date" id="SC_FEXI_SampleDate' . $SrNo . '" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>
			    
			    <td>
					<select class="form-control ExternalIssueWareHouseDefault" id="SC_ExternalI_Warehouse' . $SrNo . '" name="SC_ExternalI_Warehouse[]" style="width: 200px;"></select>
				</td>
			    
			    <td><input class="border_hide" type="text" id="SC_FEXI_SampleQuantity' . $SrNo . '" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer' . $SrNo . '" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText1' . $SrNo . '" name="SC_FEXI_UserText1[]" class="form-control"></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText2' . $SrNo . '" name="SC_FEXI_UserText2[]" class="form-control"></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText3' . $SrNo . '" name="SC_FEXI_UserText3[]" class="form-control"></td>

			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment' . $SrNo . '" name="SC_FEXI_Attachment[]" class="form-control"></td>
			</tr>';
		// }
	}


	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;
	echo json_encode($FinalResponce);
	exit(0);
}




if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransferSamplessue_finied_good_In_ajax') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $FGSAMPCOLLADD . '?DocEntry=' . $DocEntry;

	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// print_r($FinalAPI);die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {
		$option = '<tr>
				<td class="desabled">
					<input type="text" id="_tRFPEntry" name="_tRFPEntry" value="' . $response[0]->RFPEntry . '">
					<input type="text" id="it_BatchNo" name="it_BatchNo" value="' . $response[0]->BatchNo . '">
					1
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_ItemCode" name="itP_ItemCode" class="form-control" value="' . $response[0]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
				 <input class="border_hide textbox_bg" type="text" id="itP_ItemName" name="itP_ItemName" class="form-control" value="' . $response[0]->ItemName . '" readonly>
				
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg1" type="text" id="itP_BQty" name="itP_BQty" class="form-control" value="' . $response[0]->BatchQty . '" >
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_FromWhs" name="itP_FromWhs" class="form-control" value="' . $response[0]->RISSFromWhs . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_ToWhs" name="itP_ToWhs" class="form-control" value="' . $response[0]->RISSToWhs . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_Loction" name="itP_Loction" class="form-control" value="' . $response[0]->Loction . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_RetainQtyUom" name="itP_RetainQtyUom" class="form-control" value="' . $response[0]->RetainQtyUom . '" readonly>
				</td>
			</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransferRetails_issue_finied_good_In_ajax') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $FGSAMPCOLLADD . '?DocEntry=' . $DocEntry;

	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// print_r($FinalAPI);die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {
		$option = '<tr>
				<td class="desabled">
					<input type="text" id="__tRFPEntry" name="__tRFPEntry" value="' . $response[0]->RFPEntry . '">
					<input type="text" id="it__BatchNo" name="it__BatchNo" value="' . $response[0]->BatchNo . '">
					1
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_retails_ItemCode" name="itP_retails_ItemCode" class="form-control" value="' . $response[0]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
				 <input class="border_hide textbox_bg" type="text" id="itP_retails_ItemName" name="itP_retails_ItemName" class="form-control" value="' . $response[0]->ItemName . '" readonly>
				
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg1" type="text" id="itP_retails_BQty" name="itP_retails_BQty" class="form-control" value="' . $response[0]->BatchQty . '" >
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_retails_FromWhs" name="itP_retails_FromWhs" class="form-control" value="' . $response[0]->RISSFromWhs . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_retails_ToWhs" name="itP_retails_ToWhs" class="form-control" value="' . $response[0]->RISSToWhs . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_retails_Loction" name="itP_retails_Loction" class="form-control" value="' . $response[0]->Loction . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_retails_RetainQtyUom" name="itP_retails_RetainQtyUom" class="form-control" value="' . $response[0]->RetainQtyUom . '" readonly>
				</td>
			</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}


// --

if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransfer_Simple_issue_finied_good_ajax') {

	$ItemCode = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs = trim(addslashes(strip_tags($_POST['WareHouse'])));
	$GRPODEnt = trim(addslashes(strip_tags($_POST['DocEntry'])));
	$BNo = trim(addslashes(strip_tags($_POST['BatchNo'])));

	$afterSet = trim(addslashes(strip_tags($_POST['afterSet'])));

	http: //10.80.4.55:8081/API/SAP/FGSAMCOLLCONTSEL?ItemCode=&WareHouse=&BatchNo=

	// ItemCode=P00003&WareHouse=RETN-WHS&DocEntry=297&BatchNo=BQ13
	// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API = $FGSAMCOLLCONTSEL . '?ItemCode=' . $ItemCode . '&WareHouse=' . $FromWhs . '&BatchNo=' . $BNo;

	// exit(0k);

	// $API='http://10.80.4.55:8081/API/SAP/INPROCESSSAMINTICONTSEL?ItemCode=SFG00001&WareHouse=QCUT-GEN&DocEntry=359&BatchNo=asd';
	// 
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "<pre>";
	// exit;
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {

		for ($i = 0; $i < count($response); $i++) {

			if (!empty($response[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response[$i]->ExpDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response[$i]->ExpDate));
			} else {
				$ExpiryDate = '';
			}


			$option .= '
			<tr>
                
                <td style="text-align: center;">
					<input type="text" id="usercheckList' . $i . '" name="usercheckList[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response[$i]->BatchQty . '" id="itp_CS' . $i . '" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener(' . $i . ')">
				</td>

                <td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode' . $i . '" name="itp_ItemCode[]" class="form-control" value="' . $response[$i]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName' . $i . '" name="itp_ItemName[]" class="form-control" value="' . $response[$i]->ItemName . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo' . $i . '" name="itp_ContainerNo[]" class="form-control" value="' . $response[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche' . $i . '" name="itp_Batch[]" class="form-control" value="' . $response[$i]->BatchNum . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty' . $i . '" name="itp_BatchQty[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" readonly>


				</td>

				
				<td style="text-align: center;">
				   <input class="border_hide" type="text" id="SelectedQty' . $i . '" name="SelectedQty[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" onfocusout="EnterQtyValidation(' . $i . ')">

				  
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate' . $i . '" name="itp_MfgDate[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate' . $i . '" name="itp_ExpiryDate[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$option .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum" name="cs_selectedQtySum" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}



if (isset($_POST['SubIT_Btn_finied_goods_sample_issue'])) {
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;
	$tdata['DocType'] = "dDocument_Items";
	$tdata['DocDate'] = date("Y-m-d", strtotime($_POST['sample_issue_PostingDate']));
	$tdata['DocDueDate'] = date("Y-m-d", strtotime($_POST['sample_issue_DocumentDate']));
	// $tdata['Comments']=null;
	$tdata['Series'] = trim(addslashes(strip_tags($_POST['sample_issue_DocNo'])));
	$tdata['DocObjectCode'] = 'oInventoryGenExit';
	$tdata['BPL_IDAssignedToInvoice'] = trim(addslashes(strip_tags($_POST['sample_issue_BPLId'])));
	// $tdata['U_PC_SCFG']=trim(addslashes(strip_tags($_POST['sample_issue_DocEntry'])));
	$tdata['U_PC_SCIProc'] = trim(addslashes(strip_tags($_POST['sample_issue_DocEntry'])));

	// $tdata['Document_ApprovalRequests']=array();
	$tdata['TaxDate'] = date("Y-m-d", strtotime($_POST['sample_issue_DocumentDate']));
	$tdata['U_BFType'] = trim(addslashes(strip_tags('SCS_SCINPROC')));
	// $tdata['DocType']='dDocument_Items';
	// $tdata['U_PC_SCRtest']=trim(addslashes(strip_tags($_POST['SCRTQC_GI_SCRTQCB_DocEntry'])));
	// $tdata['CardCode']=trim(addslashes(strip_tags($_POST['GI_supplierCode'])));
	// $tdata['Comments']=null;
	// $tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
	// $tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['GI_to_whs'])));
	// $tdata['BPLID']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId_samIss'])));
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$mainArray = $tdata;
	// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum'] = trim(addslashes(strip_tags('0')));
	$item['ItemCode'] = trim(addslashes(strip_tags($_POST['itP_ItemCode'])));
	$item['Quantity'] = trim(addslashes(strip_tags($_POST['itP_BQty'])));
	$item['WarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
	// $item['LineTaxJurisdictions']=array();
	// $item['SerialNumbers']=array();
	// $item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
	// <!-- Item Batch row data prepare start here ----------- -->
	$BL = 0;
	for ($i = 0; $i < count($_POST['usercheckList']); $i++) {

		if ($_POST['usercheckList'][$i] == '1') {

			$batch['BatchNumber'] = trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
			$batch['Quantity'] = trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
			$batch['BaseLineNumber'] = trim(addslashes(strip_tags('0')));
			$batch['ItemCode'] = trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));
			$item['BatchNumbers'][] = $batch;
			$BL++;
		}
	}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['DocumentLines'][] = $item;

	// --------------------- Item and batch row data preparing end here ---------------------------------- -->
	// echo json_encode($mainArray);
	// exit;
	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
	// echo json_encode($mainArray);
	// exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $InventoryGenExits;

		$responce_encode = $obj->SaveSampleIntimation($mainArray, $Final_API);
		$responce = json_decode($responce_encode);
		// echo "<pre>";
		// 	print_r($responce);
		// 	echo "<pre>";
		// 	exit;
		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {

			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['sample_issue_DocEntry'])));
			$UT_data['U_PC_UTNo'] = trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SCOLFG . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			if ($underTestNumber_decode == '') {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Inventory Transfer Successfully Added.";
				echo json_encode($data);
			} else {
				// $data['status']='False';
				// $data['DocEntry']='';
				// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
				// echo json_encode($data);

				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}



if (isset($_POST['SubIT_Btn_finied_goods_retails_issue'])) {
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['iT_InventoryTransfer_DocNo'])));
	$tdata['DocDate'] = date("Y-m-d", strtotime($_POST['iT_InventoryTransfer_PostingDate']));
	$tdata['DueDate'] = date("Y-m-d", strtotime($_POST['iT_InventoryTransfer_DocumentDate']));
	$tdata['CardCode'] = null;
	$tdata['Comments'] = null;
	$tdata['FromWarehouse'] = trim(addslashes(strip_tags($_POST['itP_retails_FromWhs'])));
	$tdata['ToWarehouse'] = trim(addslashes(strip_tags($_POST['itP_retails_ToWhs'])));
	$tdata['TaxDate'] = trim(addslashes(strip_tags($_POST['iT_InventoryTransfer_DocumentDate'])));
	$tdata['DocObjectCode'] = '67';
	$tdata['BPLID'] = trim(addslashes(strip_tags($_POST['it_InventoryTransfer_BPLId'])));
	$tdata['U_PC_SIFG'] = trim(addslashes(strip_tags($_POST['it_InventoryTransfer_DocEntry'])));
	$tdata['U_BFType'] = trim(addslashes(strip_tags('SCS_SINTIFG')));

	// $tdata['BPL_IDAssignedToInvoice']=trim(addslashes(strip_tags($_POST['sample_issue_BPLId'])));
	// $tdata['Document_ApprovalRequests']=array();
	// $tdata['DocType']='dDocument_Items';
	// $tdata['U_PC_SCRtest']=trim(addslashes(strip_tags($_POST['SCRTQC_GI_SCRTQCB_DocEntry'])));
	// 
	// 
	// $tdata['Comments']=null;
	//
	// 
	//
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$mainArray = $tdata;
	// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum'] = trim(addslashes(strip_tags('0')));
	$item['ItemCode'] = trim(addslashes(strip_tags($_POST['itP_retails_ItemCode'])));
	$item['WarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_retails_FromWhs'])));
	// $item['LineTaxJurisdictions']=array();
	// $item['SerialNumbers']=array();
	$item['FromWarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_retails_ToWhs'])));
	$item['Quantity'] = trim(addslashes(strip_tags($_POST['itP_retails_BQty'])));
	// <!-- Item Batch row data prepare start here ----------- -->
	$BL = 0;
	for ($i = 0; $i < count($_POST['usercheckList_retails']); $i++) {

		if ($_POST['usercheckList_retails'][$i] == '1') {

			$batch['BatchNumber'] = trim(addslashes(strip_tags($_POST['itp_ContainerNo_retails'][$i])));
			$batch['Quantity'] = trim(addslashes(strip_tags($_POST['SelectedQty_retails'][$i])));
			$batch['BaseLineNumber'] = trim(addslashes(strip_tags('0')));
			$batch['ItemCode'] = trim(addslashes(strip_tags($_POST['itp_ItemCode_retails'][$i])));
			$item['BatchNumbers'][] = $batch;
			$BL++;
		}
	}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['StockTransferLines'][] = $item;

	// --------------------- Item and batch row data preparing end here ---------------------------------- -->
	// echo json_encode($mainArray);
	// exit;
	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
	// echo json_encode($mainArray);
	// exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here
	// https://10.80.4.35:50000/b1s/v1/StockTransfers
	if (!empty($res)) {

		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_StockTransfers;
		$responce_encode = $objKri->SaveSampleIntimation_kris($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		// $Final_API=$API_StockTransfers;

		// $responce_encode=$obj->SaveSampleIntimation($mainArray,$Final_API);
		// $responce=json_decode($responce_encode);
		// echo "<pre>";
		// 	print_r($Final_API);
		// 	echo "<pre>";
		// 	exit;
		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {

			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['it_InventoryTransfer_DocEntry'])));
			$UT_data['U_PC_UTTrans'] = trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SINTIFG . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			if ($underTestNumber_decode == '') {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Inventory Transfer Successfully Added.";
				echo json_encode($data);
			} else {
				// $data['status']='False';
				// $data['DocEntry']='';
				// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
				// echo json_encode($data);

				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}





if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransfer_Retails_issue_Finished_Goods_ajax') {

	$ItemCode = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs = trim(addslashes(strip_tags($_POST['WareHouse'])));
	$GRPODEnt = trim(addslashes(strip_tags($_POST['DocEntry'])));
	$BNo = trim(addslashes(strip_tags($_POST['BatchNo'])));

	// $afterSet=trim(addslashes(strip_tags($_POST['afterSet'])));

	// ItemCode=P00003&WareHouse=RETN-WHS&DocEntry=297&BatchNo=BQ13
	// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API = $FGSAMCOLLCONTSEL . '?ItemCode=' . $ItemCode . '&WareHouse=' . $FromWhs . '&DocEntry=' . $GRPODEnt . '&BatchNo=' . $BNo;

	// $API='http://10.80.4.55:8081/API/SAP/INPROCESSSAMINTICONTSEL?ItemCode=SFG00001&WareHouse=QCUT-GEN&DocEntry=359&BatchNo=asd';
	// 
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "<pre>";
	// exit;
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {

		for ($i = 0; $i < count($response); $i++) {

			if (!empty($response[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response[$i]->ExpDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response[$i]->ExpDate));
			} else {
				$ExpiryDate = '';
			}


			$option .= '
			<tr>
                
                <td style="text-align: center;">
					<input type="text" id="usercheckList_retails' . $i . '" name="usercheckList_retails[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response[$i]->BatchQty . '" id="itp_CS_retails' . $i . '" name="itp_CS_retails[]" style="width: 17px;height: 17px;" onclick="getSelectedContener_retails(' . $i . ')">
				</td>

                <td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode_retails' . $i . '" name="itp_ItemCode_retails[]" class="form-control" value="' . $response[$i]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName_retails' . $i . '" name="itp_ItemName_retails[]" class="form-control" value="' . $response[$i]->ItemName . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo_retails' . $i . '" name="itp_ContainerNo_retails[]" class="form-control" value="' . $response[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche_retails' . $i . '" name="itp_Batch_retails[]" class="form-control" value="' . $response[$i]->BatchNum . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty_retails' . $i . '" name="itp_BatchQty_retails[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" readonly>


				</td>

				
				<td style="text-align: center;">
				   <input class="border_hide" type="text" id="SelectedQty_retails' . $i . '" name="SelectedQty_retails[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" onfocusout="EnterQtyValidation_retails(' . $i . ')">

				  
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate_retails' . $i . '" name="itp_MfgDate_retails[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate_retails' . $i . '" name="itp_ExpiryDate_retails[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$option .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum_retails" name="cs_selectedQtySum_retails" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}




if (isset($_POST['action']) && $_POST['action'] == 'SCReverseSampleIsuue_ajax') {
	// <!--------------- Get Reverse Sample issue data start here ------------------------------------------ -->
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));
	// $API=$SAMPLECOLLGOODSISSUE_API.$DocEntry;
	$API = $FGSAMPCOLLADD . '?DocEntry=' . $DocEntry;
	// print_r($API);
	// die();
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	$response = $obj->get_OTFSI_SingleData($FinalAPI); // get Function called here
	// <!--------------- Get Reverse Sample issue data End here -------------------------------------------- -->

	// <!--------------- Get Series Data using Object code start here -------------------------------------- -->
	$Series_API = $INWARDQCSERIES_API . '60'; // Object Code Hardcore write
	$Series_response = $obj->get_OTFSI_SingleData($Series_API); // get Function called here
	// <!--------------- Get Series Data using Object code end here ---------------------------------------- -->
	//        echo "<pre>";
	// print_r($Series_response);
	// echo "<pre>";
	// exit;
	//  <!-- ---------- Preparing row data start here ------------------------------------------------------ -->
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data

	// <!-- --------- Header level data perparing start here ---------------- -->
	$tdata['DocType'] = 'dDocument_Items';
	$tdata['DocDate'] = date("Y-m-d", strtotime($response[0]->DocDate));
	$tdata['DocDueDate'] = date("Y-m-d", strtotime($response[0]->DocDate));
	$tdata['Series'] = trim(addslashes(strip_tags($Series_response[0]->Series)));
	$tdata['TaxDate'] = date("Y-m-d");
	$tdata['DocObjectCode'] = trim(addslashes(strip_tags('oInventoryGenEntries')));
	$tdata['U_PC_SCIProc'] = trim(addslashes(strip_tags($response[0]->DocNum)));
	// $tdata['U_PC_SColl']=trim(addslashes(strip_tags($response[0]->DocNum)));
	$tdata['U_BFType'] = 'SCS_SCINPROC';
	$tdata['BPL_IDAssignedToInvoice'] = trim(addslashes(strip_tags($response[0]->BPLId)));

	$mainArray = $tdata; // header level data append in this array
	// <!-- --------- Header level data perparing end here ------------------ -->

	// <!-- --------- Item Batch row data prepare start here ----------------- -->
	$item['ItemCode'] = trim(addslashes(strip_tags($response[0]->ItemCode)));
	$item['Quantity'] = trim(addslashes(strip_tags($response[0]->BatchQty)));
	$item['BaseType'] = '60';
	$item['BaseEntry'] = trim(addslashes(strip_tags($response[0]->DocEntry)));
	$item['BaseLine'] = trim(addslashes(strip_tags($response[0]->LineNo)));

	// echo "<pre>";
	// print_r($response);
	// echo "<pre>";


	//    echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;

	// $BatchNumbersArrayData=$response[0]->SAMPLECOLLBATCH;
	// for ($i=0; $i <count($BatchNumbersArrayData) ; $i++) { 

	// 	$batch['BatchNumber']=trim(addslashes(strip_tags($BatchNumbersArrayData[$i]->BatchNo)));
	// 	$batch['Quantity']=trim(addslashes(strip_tags($BatchNumbersArrayData[$i]->BatchQty)));
	// 	// $batch['Quantity'] = (int)trim(addslashes(strip_tags($BatchNumbersArrayData[$i]->Quantity))); // 252
	// 	$batch['ItemCode']=trim(addslashes(strip_tags($response[0]->ItemCode)));
	// 	$item['BatchNumbers'][]=$batch; // Batch data append in this array
	// }
	// <!-- --------- Item Batch row data prepare end here ------------------- -->

	$mainArray['DocumentLines'][] = $item; // Item data append in this array
	//  <!-- ---------- Preparing row data end here -------------------------------------------------------- -->
	//          echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {

		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_InventoryGenEntries;
		$responce_encode = $obj->SaveSampleIntimation($mainArray, $Final_API);
		$responce = json_decode($responce_encode);
		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {

			// <!-- ------- row data preparing start here --------------------- -->
			// $UT_data=array();
			// $UT_data['DocEntry']=trim(addslashes(strip_tags($_POST['DocEntry'])));
			// $UT_data['U_PC_RIssue']=trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			// $Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SCS_SCOL.'('.$UT_data['DocEntry'].')';
			// $underTestNumber=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data,$Final_API2);
			// $underTestNumber_decode=json_decode($underTestNumber);

			// if($underTestNumber_decode==''){
			$data['status'] = 'True';
			$data['DocEntry'] = $responce->DocEntry;
			$data['message'] = "Reverse Sample Issue Added Successfully.";
			echo json_encode($data);
			// }else{
			// 	if(array_key_exists('error', (array)$underTestNumber_decode)){
			// 		$data['status']='False';
			// 		$data['DocEntry']='';
			// 		$data['message']=$responce->error->message->value;
			// 		echo json_encode($data);
			// 	}
			// }
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}




if (isset($_POST['action']) && $_POST['action'] == 'sample_intimation_finished_good_ajax') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $FGSAMPLEINTIMATIONDETAILS . '?DocEntry=' . $DocEntry;
	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	// print_r($FinalAPI);die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);


	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit(0);
	echo json_encode($response);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'OpenSampleIntimationFinishedGoodInventoryTransfer_ajax') {

	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $FGSAMPLEINTIMATIONDETAILS . '?DocEntry=' . $DocEntry;


	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// print_r($FinalAPI);die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);

	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit(0);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {
		$option = '<tr>
				<td class="desabled">
						
					<input type="text" id="TransferToUndertest_i_GRNEntry" name="TransferToUndertest_i_GRNEntry" value="' . $response[0]->RFPODocEntry . '">
					<input type="text" id="TransferToUndertest_i_BatchNo" name="TransferToUndertest_i_BatchNo" value="' . $response[0]->BatchNo . '">

					1
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="TransferToUndertest_i_ItemCode" name="TransferToUndertest_i_ItemCode" class="form-control" value="' . $response[0]->ItemCode . '" readonly>
				</td>

				<td class="desabled">' . $response[0]->ItemName . '</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="TransferToUndertest_i_BQty" name="TransferToUndertest_i_BQty" class="form-control" value="' . $response[0]->BatchQty . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="TransferToUndertest_i_FromWhs" name="TransferToUndertest_i_FromWhs" class="form-control" value="' . $response[0]->FromWhse . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="TransferToUndertest_i_ToWhs" name="TransferToUndertest_i_ToWhs" class="form-control" value="' . $response[0]->ToWhse . '" readonly>
				</td>
				<td class="desabled">' . $response[0]->Location . '</td>
				<td class="desabled">' . $response[0]->Unit . '</td>
			</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'OpenSampleIntimationFinishedGoodInventoryTransferAfter_ajax') {

	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $FGSAMPLEINTIMATIONDETAILS . '?DocEntry=' . $DocEntry;


	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// print_r($FinalAPI);die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);

	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit(0);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {
		$option = '<tr>
				<td class="desabled">
						
					<input type="hidden" id="after_TransferToUndertest_i_GRNEntry" name="after_TransferToUndertest_i_GRNEntry" value="' . $response[0]->RFPODocEntry . '">
					<input type="hidden" id="after_TransferToUndertest_i_BatchNo" name="after_TransferToUndertest_i_BatchNo" value="' . $response[0]->BatchNo . '">

					1
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="after_TransferToUndertest_i_ItemCode" name="after_TransferToUndertest_i_ItemCode" class="form-control" value="' . $response[0]->ItemCode . '" readonly>
				</td>

				<td class="desabled">' . $response[0]->ItemName . '</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="after_TransferToUndertest_i_BQty" name="after_TransferToUndertest_i_BQty" class="form-control" value="' . $response[0]->BatchQty . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="after_TransferToUndertest_i_FromWhs" name="after_TransferToUndertest_i_FromWhs" class="form-control" value="' . $response[0]->FromWhse . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="after_TransferToUndertest_i_ToWhs" name="after_TransferToUndertest_i_ToWhs" class="form-control" value="' . $response[0]->ToWhse . '" readonly>
				</td>
				<td class="desabled">' . $response[0]->Location . '</td>
				<td class="desabled">' . $response[0]->Unit . '</td>
			</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'sample_intimation_Finished_Good_ContainerList_ajax') {

	$ItemCode = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs = trim(addslashes(strip_tags($_POST['FromWhs'])));
	$GRPODEnt = trim(addslashes(strip_tags($_POST['GRPODEnt'])));
	$BNo = trim(addslashes(strip_tags($_POST['BNo'])));
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API = $FGSAMINTICONTSEL . '?ItemCode=' . $ItemCode . '&WareHouse=' . $FromWhs . '&BatchNo=' . $BNo . '&DocEntry=' . $DocEntry;

	// $API='http://10.80.4.55:8081/API/SAP/FGSAMINTICONTSEL?ItemCode=SFG00001&WareHouse=STBL-GEN&DocEntry=297&BatchNo=C0121167';

	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->
	// http://10.80.4.55:8081/API/SAP/FGSAMINTICONTSEL?ItemCode=FG00001&WareHouse=QCUT-GEN&BatchNo=C0121197&DocEntry=14
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit(0);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {

		for ($i = 0; $i < count($response); $i++) {

			// ----------- Date formating condition definr start here---------------------------
			if (!empty($response[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response[$i]->ExpDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response[$i]->ExpDate));
			} else {
				$ExpiryDate = '';
			}


			// ----------- Date formating condition definr end here-----------------------------
			$option .= '
			<tr>
				<td style="text-align: center;">
					<input type="hidden" id="usercheckList' . $i . '" name="usercheckList[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response[$i]->BatchQty . '" id="itp_CS' . $i . '" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener(' . $i . ')">
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode' . $i . '" name="itp_ItemCode[]" class="form-control" value="' . $response[$i]->ItemCode . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName' . $i . '" name="itp_ItemName[]" class="form-control" value="' . $response[$i]->ItemName . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo' . $i . '" name="itp_ContainerNo[]" class="form-control" value="' . $response[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche' . $i . '" name="itp_Batch[]" class="form-control" value="' . $response[$i]->Batch . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty' . $i . '" name="itp_BatchQty[]" class="form-control" value="' . $response[$i]->BatchQty . '" readonly>
				</td>
				<td>
					<input class="border_hide" type="text" id="SelectedQty' . $i . '" name="SelectedQty[]" class="form-control" value="' . $response[$i]->BatchQty . '" onfocusout="EnterQtyValidation(' . $i . ')">
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate' . $i . '" name="itp_MfgDate[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate' . $i . '" name="itp_ExpiryDate[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$option .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum" name="cs_selectedQtySum" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'sample_intimation_Finished_Good_ContainerList_after_ajax') {

	$ItemCode = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs = trim(addslashes(strip_tags($_POST['FromWhs'])));
	$GRPODEnt = trim(addslashes(strip_tags($_POST['GRPODEnt'])));
	$BNo = trim(addslashes(strip_tags($_POST['BNo'])));
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API = $FGSAMINTICONTSEL . '?ItemCode=' . $ItemCode . '&WareHouse=' . $FromWhs . '&BatchNo=' . $BNo . '&DocEntry=' . $DocEntry;

	// $API='http://10.80.4.55:8081/API/SAP/FGSAMINTICONTSEL?ItemCode=SFG00001&WareHouse=STBL-GEN&DocEntry=297&BatchNo=C0121167';

	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->
	// http://10.80.4.55:8081/API/SAP/FGSAMINTICONTSEL?ItemCode=FG00001&WareHouse=QCUT-GEN&BatchNo=C0121197&DocEntry=14
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit(0);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {

		for ($i = 0; $i < count($response); $i++) {

			// ----------- Date formating condition definr start here---------------------------
			if (!empty($response[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response[$i]->ExpDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response[$i]->ExpDate));
			} else {
				$ExpiryDate = '';
			}

			// <td style="text-align: center;">
			// 		<input type="hidden" id="after_usercheckList'.$i.'" name="after_usercheckList[]" value="0">
			// 		<input class="form-check-input" type="checkbox" value="'.$response[$i]->BatchQty.'" id="after_itp_CS'.$i.'" name="after_itp_CS[]" style="width: 17px;height: 17px;" onclick="after_getSelectedContener('.$i.')">
			// 	</td>
			// ----------- Date formating condition definr end here-----------------------------
			$option .= '
			<tr>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="after_itp_ItemCode' . $i . '" name="after_itp_ItemCode[]" class="form-control" value="' . $response[$i]->ItemCode . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="after_itp_ItemName' . $i . '" name="after_itp_ItemName[]" class="form-control" value="' . $response[$i]->ItemName . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="after_itp_ContainerNo' . $i . '" name="after_itp_ContainerNo[]" class="form-control" value="' . $response[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="after_itp_Batche' . $i . '" name="after_itp_Batch[]" class="form-control" value="' . $response[$i]->Batch . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="after_itp_BatchQty' . $i . '" name="after_itp_BatchQty[]" class="form-control" value="' . $response[$i]->BatchQty . '" readonly>
				</td>
				<td>
					<input class="border_hide" type="text" id="after_SelectedQty' . $i . '" name="after_SelectedQty[]" class="form-control" value="' . $response[$i]->BatchQty . '" onfocusout="after_EnterQtyValidation(' . $i . ')">
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="after_itp_MfgDate' . $i . '" name="after_itp_MfgDate[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="after_itp_ExpiryDate' . $i . '" name="after_itp_ExpiryDate[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$option .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="after_cs_selectedQtySum" name="after_cs_selectedQtySum" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'QC_Post_document_QC_Check_Finished_Goods_ajax') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $FGQCPOSTDOCUMENTDETAILS . '?DocEntry=' . $DocEntry;
	// exit;
	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	// print_r($FinalAPI);die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);

	$FinalResponce['SampleCollDetails'] = $response;
	// <!-- ------ Array declaration End Here  --------------------------------- -->
	$general_data = $response[0]->FGQCPOSTDOCGENERALDATA;
	$qcStatus = $response[0]->FGQCPOSTDOCQCSTATUS; // Etra issue response seperate here 
	$qcAttach = $response[0]->FGQCPOSTDOCATTACH; //External issue reponce seperate here

	if (empty($qcStatus)) {
		$qcStatusCount = 0;
	} else {
		$qcStatusCount = count($qcStatus);
	}
	// echo "<pre>";
	// print_r($qcStatus1);
	// echo "</pre>";
	// // exit;
	// $a='';
	// echo count($qcStatus1);
	// exit();
	//    echo "<pre>";
	// print_r(count($qcStatus));
	// echo "</pre>";
	// exit;

	if (!empty($general_data)) {
		for ($i = 0; $i < count($general_data); $i++) {
			$SrNo = $i;
			$index = $i + 1;

			$FinalResponce['general_data'] .= '<tr>
					<td class="desabled">' . $index . '</td>

					<td><input  type="text" class="form-control" id="parameter_code' . $SrNo . '" name="parameter_code[]" value="' . $general_data[$i]->PCode . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="PName' . $SrNo . '" name="PName[]" value="' . $general_data[$i]->PName . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="Standard' . $SrNo . '" name="Standard[]" value="' . $general_data[$i]->Standard . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="Release' . $SrNo . '" name="Release[]" value="' . $general_data[$i]->Release . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="PDType' . $SrNo . '" name="PDType[]" value="' . $general_data[$i]->PDType . '" readonly></td>

					<td><input  type="text" class="form-control" id="descriptive_details' . $SrNo . '" name="descriptive_details[]" value="' . $general_data[$i]->DesDetils . '"></td>

					<td><input  type="text" class="form-control" id="logical' . $SrNo . '" name="logical[]" value="' . $general_data[$i]->Logical . '"></td>

					<td class="desabled"><input  type="text" class="form-control" id="LowMin' . $SrNo . '" name="LowMin[]" value="' . $general_data[$i]->LowMin . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="LowMax' . $SrNo . '" name="LowMax[]" value="' . $general_data[$i]->LowMax . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="UppMin' . $SrNo . '" name="UppMin[]" value="' . $general_data[$i]->UppMin . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="UppMax' . $SrNo . '" name="UppMax[]" value="' . $general_data[$i]->UppMax . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="Min' . $SrNo . '" name="Min[]" value="' . $general_data[$i]->Min . '" readonly></td>

					<td><input  type="text" id="lower_min_result' . $SrNo . '" name="lower_min_result[]" onfocusout="CalculateResultOut(' . $SrNo . ')" class="form-control" value="' . $general_data[$i]->LowMin1 . '"></td>

					<td><input  type="text" id="lower_max_result' . $SrNo . '" name="lower_max_result[]" class="form-control" value="' . $general_data[$i]->LowMax1 . '"></td>

					<td><input  type="text" id="upper_min_result' . $SrNo . '" name="upper_min_result[]" class="form-control" value="' . $general_data[$i]->UppMin1 . '"></td>

					<td><input  type="text" id="upper_max_result' . $SrNo . '" name="upper_max_result[]" class="form-control" value="' . $general_data[$i]->UppMax1 . '"></td>

					<td ><input type="text" id="mean' . $SrNo . '" name="mean[]" class="form-control" value="' . $general_data[$i]->Min1 . '"></td>

					<td id="ResultOutTd' . $SrNo . '">
						<select id="result_output' . $SrNo . '" name="result_output[]" class="form-select dropdownResutl' . $SrNo . '" onchange="ManualSelectedTResultOut(' . $SrNo . ')"><option value="' . $general_data[$i]->ROutput . '">' . $general_data[$i]->ROutput . '</option></select>
					</td>

					<td ><input type="text" id="remarks' . $SrNo . '" name="remarks[]" class="form-control" value="' . $general_data[$i]->Remarks . '"></td>

					<td id="QC_StatusByAnalystTd' . $SrNo . '">
						<select id="qC_status_by_analyst' . $SrNo . '" name="qC_status_by_analyst[]" class="form-select qc_statusbyab' . $SrNo . '" onchange="SelectedQCStatus(' . $SrNo . ')">
						</select>
					</td>

					<td class="desabled"><input  type="text" class="form-control" id="TMethod' . $SrNo . '" name="TMethod[]" value="' . $general_data[$i]->TMethod . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="MType' . $SrNo . '" name="MType[]" value="' . $general_data[$i]->MType . '" readonly></td>

					<td><input type="text" id="user_text1_' . $SrNo . '" name="user_text1_[]" class="form-control" value="' . $general_data[$i]->UText1 . '"></td>

					<td><input type="text" id="user_text2_' . $SrNo . '" name="user_text2_[]" class="form-control" value="' . $general_data[$i]->UText2 . '"></td>

					<td><input type="text" id="user_text3_' . $SrNo . '" name="user_text3_[]" class="form-control" value="' . $general_data[$i]->UText3 . '"></td>

					<td><input type="text" id="user_text4_' . $SrNo . '" name="user_text4_[]" class="form-control" value="' . $general_data[$i]->UText4 . '"></td>

					<td ><input type="text" id="user_text5_' . $SrNo . '" name="user_text5_[]" class="form-control" value="' . $general_data[$i]->UText5 . '"></td>

					<td class="desabled"><input type="text" id="GDQCStatus' . $SrNo . '" name="GDQCStatus[]" class="form-control" value="' . $general_data[$i]->GDQCStatus . '" readonly></td>

					<td class="desabled"><input type="text" id="GDUOM' . $SrNo . '" name="GDUOM[]" class="form-control" value="' . $general_data[$i]->GDUOM . '" readonly></td>

					<td class="desabled"><input type="text" id="Retest' . $SrNo . '" name="Retest[]" class="form-control" value="' . $general_data[$i]->Retest . '" readonly></td>

					<td class="desabled"><input type="text" id="GDStab' . $SrNo . '" name="GDStab[]" class="form-control" value="' . $general_data[$i]->GDStab . '" readonly></td>

					<td class="desabled"><input type="text" id="ExSample' . $SrNo . '" name="ExSample[]" class="form-control" value="' . $general_data[$i]->ExSample . '" readonly></td>

					<td class="desabled"><input type="text" id="Appassay' . $SrNo . '" name="Appassay[]" class="form-control" value="' . $general_data[$i]->Appassay . '" readonly></td>

					<td class="desabled"><input type="text" id="AppLOD' . $SrNo . '" name="AppLOD[]" class="form-control" value="' . $general_data[$i]->AppLOD . '" readonly></td>

					<td><input  type="text" id="qc_analysis_by' . $SrNo . '" name="qc_analysis_by[]" class="form-control" value="' . $general_data[$i]->AnlBy . '"></td>

					<td><input  type="text" id="analyst_remark' . $SrNo . '" name="analyst_remark[]" class="form-control" value="' . $general_data[$i]->ARRemark . '"></td>

					<td ><input type="text" id="instrument_code' . $SrNo . '" name="instrument_code[]" class="form-control" value="' . $general_data[$i]->Inscode . '"></td>

					<td class="desabled"><input type="text" id="InsName' . $SrNo . '" name="InsName[]" class="form-control" value="' . $general_data[$i]->InsName . '" readonly></td>

					<td><input  type="text" id="star_date' . $SrNo . '" name="star_date[]" class="form-control" value="' . $general_data[$i]->SDate . '"></td>

					<td><input  type="text" id="start_time' . $SrNo . '" name="start_time[]" class="form-control" value="' . $general_data[$i]->STime . '"></td>

					<td ><input type="text" id="end_date' . $SrNo . '" name="end_date[]" class="form-control" value="' . $general_data[$i]->EDate . '"></td>

					<td ><input type="text" id="end_time' . $SrNo . '" name="end_time[]" class="form-control" value="' . $general_data[$i]->ETime . '"></td>

				</tr>';
		}
	} else {
		$FinalResponce['general_data'] .= '<tr><td colspan="7" style="color:red;text-align: center;">No Record Found</td></tr>';
	}

	$FinalResponce['count'] = count($general_data);


	if (!empty($qcStatus)) {
		for ($j = 0; $j < count($qcStatus); $j++) {
			$SrNo = $j + 1;

			$FinalResponce['qcStatus'] .= '<tr>
                    
                    <td class="desabled">' . $SrNo . '</td>

                    <td class="desabled"><input class="form-control border_hide desabled" type="text" id="qc_Status' . $SrNo . '" name="qc_Status[]" value="' . $qcStatus[$j]->QCStsStatus . '" readonly></td>

                    <td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsQty' . $SrNo . '" name="qCStsQty[]"  value="' . $qcStatus[$j]->QCStsQty . '" readonly></td>

                    <td class="desabled"><input  type="text" class="form-control border_hide desabled" id="qCitNo' . $SrNo . '" name="qCitNo[]"  value="' . $qcStatus[$j]->ItNo . '" readonly></td>

                    <td class="desabled"><input class="form-control border_hide desabled" type="text" id="doneBy' . $SrNo . '" name="doneBy[]"  value="' . $qcStatus[$j]->DBy . '" readonly></td>

                    <td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsRemark1' . $SrNo . '" name="qCStsRemark1[]"  value="' . $qcStatus[$j]->QCStsRemark1 . '" readonly></td>

				</tr>';
		}
	} else {
		// $FinalResponce['qcStatus'].='<tr><td colspan="12" style="color:red;text-align: center;">No Record Found</td></tr>';
	}

	$FinalResponce['qcStatus'] .= '<tr">
			<td>' . (($qcStatusCount) + 1) . '</td>
			<td><select id="qc_Status_1" name="qc_Status[]" class="form-select qc_status_selecte1"></select></td>
			<td><input class="border_hide" type="text"  id="qCStsQty_1" name="qCStsQty[]" class="form-control" value=""></td>
			<td><input class="border_hide" type="text"  id="qCitNo_1" name="qCitNo[]" class="form-control" value=""></td>
			<td>
			<select id="doneBy_1" name="doneBy[]" class="form-select done-by-mo1"></select>
			</td>
			<td><input class="border_hide" type="text"  id="qCStsRemark1_1" name="qCStsRemark1[]" class="form-control" value=""></td>
		</tr>';


	if (!empty($qcAttach)) {
		for ($j = 0; $j < count($qcAttach); $j++) {
			$SrNo = $j + 1;
			// <tr>
			$FinalResponce['qcAttach'] .= '<tr>
					<td class="desabled">' . $SrNo . '</td>
					<td class="desabled"><input class="border_hide desabled" type="text" id="targetPath' . $SrNo . '" name="targetPath[]" class="form-control" value="' . $qcAttach[$j]->TargetPath . '" readonly>
					</td>
					<td class="desabled"><input class="border_hide desabled" type="text" id="fileName' . $SrNo . '" name="fileName[]"  class="form-control" value="' . $qcAttach[$j]->FileName . '" readonly></td>
					<td class="desabled"><input class="border_hide desabled" type="text" id="attachDate' . $SrNo . '" name="attachDate[]"  class="form-control" value="' . $qcAttach[$j]->AttachDate . '" readonly></td>
					<td><input class="border_hide" type="text" id="freeText' . $SrNo . '" name="freeText[]"  class="form-control" value="' . $qcAttach[$j]->FreeText . '"></td>
				</tr>';
		}
	} else {
		$FinalResponce['qcAttach'] .= '<tr><td colspan="12" style="color:red;text-align: center;">No Record Found</td></tr>';
	}



	// echo "<pre>";
	// print_r($FinalResponce);
	// echo "</pre>";
	// exit(0);
	echo json_encode($FinalResponce);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'StageDropdown_ajax') {
	// <!-- =============== get supplier dropdown start here ========================================== -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$BP_Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $RouteStages;

		$responce_encode_BP = $obj->getFunctionServiceLayer($BP_Final_API);
		$responce_BP = json_decode($responce_encode_BP);
		// echo "<pre>";
		// print_r($responce_BP);
		// echo "</pre>";
		// exit;
		$option .= '<option value="">-</option>';
		for ($i = 0; $i < count($responce_BP->value); $i++) {

			$option .= '<option value="' . $responce_BP->value[$i]->Code . '">' . $responce_BP->value[$i]->Code . '</option>';
		}
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	// <!-- =============== get supplier dropdown end here ============================================ -->

	echo json_encode($option);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'qc_post_document_QC_Check_Finished_Goods_pupup_ajax') {
	// $API=$RETESTQCPOSTDOCUMENTDETAILS.'?DocEntry='.$_POST['DocEntry'].'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&LineNum='.$_POST['LineNum'];
	$API = $FGQCPOSTDOCUMENTDETAILS . '?DocEntry=' . $_POST['DocEntry'];
	// $API=$RETESTQCPOSTDOC.'?DocEntry='.$_POST['DocEntry'];
	// echo $API;
	// exit;
	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// die();
	// <!-- ------- Replace blank space to %20 End here -------- -->
	$response = $objKri->get_QcPostDocument_RetestQcSingleData($FinalAPI);

	$FinalResponce['DataDetails'] = $response;

	//    echo "<pre>";
	// print_r($response);
	// echo "<pre>";
	// exit;

	if (!empty($response)) {
		$FinalResponce['options'] = '<tr>
				<td class="desabled">
						
					<input type="text" id="inventoryTransferFG_i_DocEntry" name="inventoryTransferFG_i_DocEntry" value="' . $response[0]->DocEntry . '">
					<input type="text" id="inventoryTransferFG_i_BatchNo" name="inventoryTransferFG_i_BatchNo" value="' . $response[0]->BatchNo . '">

					1
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="inventoryTransferFG_i_ItemCode" name="inventoryTransferFG_i_ItemCode" class="form-control" value="' . $response[0]->ItemCode . '" readonly>
				</td>

				<td class="desabled">' . $response[0]->ItemName . '</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="inventoryTransferFG_i_BQty" name="inventoryTransferFG_i_BQty" class="form-control" value="' . $response[0]->BatchQty . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="inventoryTransferFG_i_FromWhs" name="inventoryTransferFG_i_FromWhs" class="form-control" value="' . $response[0]->FrmWhse . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="inventoryTransferFG_i_ToWhs" name="inventoryTransferFG_i_ToWhs" class="form-control" value="' . $response[0]->ToWhse . '" readonly>
				</td>
				<td class="desabled">' . $response[0]->Location . '</td>
				<td class="desabled">' . $response[0]->Unit . '</td>
			</tr>';
	} else {
		$FinalResponce['options'] = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}



	echo json_encode($FinalResponce);
	exit(0);
}


if (isset($_POST['action']) && $_POST['action'] == 'getInventoryFinishedGoodsQccotainerSelection_ajax') {

	$ItemCode = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs = trim(addslashes(strip_tags($_POST['WareHouse'])));
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));
	$BNo = trim(addslashes(strip_tags($_POST['BatchNo'])));
	// ItemCode=A00116&WareHouse=QCUT-GEN&BatchNo=BT2106-2
	// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API = $FGQCCHECKCONTSEL . '?ItemCode=' . $ItemCode . '&WareHouse=' . $FromWhs . '&BatchNo=' . $BNo . '&DocEntry=' . $DocEntry;

	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->
	// print_r($API);
	// die();
	$response = $objKri->get_RetestQcContainer_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "<pre>";
	// exit;

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {

		for ($i = 0; $i < count($response); $i++) {

			if (!empty($response[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response[$i]->ExpDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response[$i]->ExpDate));
			} else {
				$ExpiryDate = '';
			}


			$option .= '
			<tr>
                
                <td style="text-align: center;">
					<input type="hidden" id="usercheckList' . $i . '" name="usercheckList[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response[$i]->BatchQty . '" id="itp_CS' . $i . '" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener(' . $i . ')">
				</td>

                <td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode' . $i . '" name="itp_ItemCode[]" class="form-control" value="' . $response[$i]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName' . $i . '" name="itp_ItemName[]" class="form-control" value="' . $response[$i]->ItemName . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo' . $i . '" name="itp_ContainerNo[]" class="form-control" value="' . $response[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche' . $i . '" name="itp_Batch[]" class="form-control" value="' . $response[$i]->BatchNum . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty' . $i . '" name="itp_BatchQty[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" readonly>


				</td>

				
				<td style="text-align: center;">
				   <input class="border_hide" type="text" id="SelectedQty' . $i . '" name="SelectedQty[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" onfocusout="EnterQtyValidation_GI(' . $i . ')">

				  
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate' . $i . '" name="itp_MfgDate[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate' . $i . '" name="itp_ExpiryDate[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$option .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum" name="cs_selectedQtySum" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}



if (isset($_POST['SampleIntimationfinishedGoodBtn'])) {
	$tdata = array();
	$data = array(); // this array handel validation responce

	$tdata['Object'] = 'SCS_SINTIFG';
	$tdata['Series'] = trim(addslashes(strip_tags($_POST['finished_good_Series'])));
	$tdata['U_PC_BLin'] = trim(addslashes(strip_tags($_POST['finished_good_LineNum'])));
	$tdata['U_PC_RNo'] = trim(addslashes(strip_tags($_POST['finished_good_RFPNo'])));
	$tdata['U_PC_REnt'] = trim(addslashes(strip_tags($_POST['finished_good_RFPODocEntry'])));
	$tdata['U_PC_WoNo'] = trim(addslashes(strip_tags($_POST['finished_good_WONo'])));
	$tdata['U_PC_WoEnt'] = trim(addslashes(strip_tags($_POST['finished_good_WOEntry'])));
	$tdata['U_PC_SType'] = trim(addslashes(strip_tags($_POST['finished_good_SampleType'])));
	$tdata['U_PC_TRBy'] = trim(addslashes(strip_tags($_POST['finished_good_TRBy'])));
	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['finished_good_ItemCode'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['finished_good_ItemName'])));
	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['finished_good_SampleQty'])));
	$tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['finished_good_RetainQty'])));
	$tdata['U_PC_Unit'] = trim(addslashes(strip_tags($_POST['finished_good_Unit'])));
	$tdata['U_PC_TNCont'] = trim(addslashes(strip_tags($_POST['finished_good_TotalNoofcontainer'])));
	$tdata['U_PC_FCont'] = trim(addslashes(strip_tags($_POST['finished_good_FromCont'])));
	$tdata['U_PC_TCont'] = trim(addslashes(strip_tags($_POST['finished_good_ToContainer'])));
	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['finished_good_Branch'])));
	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['finished_good_Location'])));
	$tdata['U_PC_ChNo'] = trim(addslashes(strip_tags($_POST['finished_good_ChallanNo'])));
	$tdata['U_PC_GENo'] = trim(addslashes(strip_tags($_POST['finished_good_GateEntryNo'])));
	$tdata['U_PC_GEDte'] = trim(addslashes(strip_tags($_POST['finished_good_GateEntryDate'])));
	$tdata['U_PC_CNos'] = trim(addslashes(strip_tags($_POST['finished_good_ContainersNo'])));
	$tdata['U_PC_Cont'] = trim(addslashes(strip_tags($_POST['finished_good_Container'])));
	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['finished_good_BatchNo'])));
	$tdata['U_PC_BQty'] = trim(addslashes(strip_tags($_POST['finished_good_BatchQty'])));
	$tdata['U_PC_MakeBy'] = trim(addslashes(strip_tags(($_POST['finished_good_MakeBy']))));

	$tdata['U_PC_MfgDt'] = (!empty($_POST['finished_good_MFGDate'])) ? date("Y-m-d", strtotime($_POST['finished_good_MFGDate'])) : null;

	$tdata['U_PC_ExpDt'] = (!empty($_POST['finished_good_ExpiryDate'])) ? date("Y-m-d", strtotime($_POST['finished_good_ExpiryDate'])) : null;

	$tdata['U_PC_RDt'] = (!empty($_POST['finished_good_RetestDate'])) ? date("Y-m-d", strtotime($_POST['finished_good_RetestDate'])) : null;

	$tdata['U_PC_TRDte'] = (!empty($_POST['finished_good_TRDate'])) ? date("Y-m-d", strtotime($_POST['finished_good_TRDate'])) : null;

	$tdata['U_PC_ChDate'] = (!empty($_POST['finished_good_ChallanDate'])) ? date("Y-m-d", strtotime($_POST['finished_good_ChallanDate'])) : null;

	$tdata['U_PC_UTTrans'] = null;
	$tdata['U_PC_BPLId'] = null;
	$tdata['U_PC_LCode'] = null;
	$tdata['U_PC_TNCont1'] = null;
	$tdata['U_PC_RcQty'] = null;

	// <!-- ---------------------- sample Intimation popup validation start Here -------------------- -->
	if ($_POST['finished_good_SampleType'] == '') {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = "Sample Type Mandatory.";
		echo json_encode($data);
		exit(0);
	}

	if ($_POST['finished_good_TRBy'] == '') {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = "TR by mandatory.";
		echo json_encode($data);
		exit(0);
	}

	if ($_POST['finished_good_TRDate'] == '') {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = "TR Date mandatory.";
		echo json_encode($data);
		exit(0);
	}
	// <!-- ---------------------- sample Intimation popup validation end Here ---------------------- -->

	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SINTIFG_API;

		$responce_encode = $obj->SaveSampleIntimation($tdata, $Final_API); // sample intimation save here
		$responce = json_decode($responce_encode);

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();

		if (!empty($responce->DocNum)) {
			$InventoryGenEntries = array();
			$InventoryGenEntries['SIDocEntry'] = trim($responce->DocEntry);
			$InventoryGenEntries['GRDocEntry'] = trim($_POST['finished_good_RFPODocEntry']);
			$InventoryGenEntries['ItemCode'] = trim($responce->U_PC_ICode);
			$InventoryGenEntries['LineNum'] = trim($responce->U_PC_BLin);

			$Final_API = $GRSAMPLEINTIFG_APi;
			$responce_encode1 = $obj->POST_QuerryBasedMasterFunction($InventoryGenEntries, $Final_API);
			$responce1 = json_decode($responce_encode1);

			if (empty($responce1)) {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Open Transaction for sample intimation finished Good Successfully Added.";
				echo json_encode($data);
			} else {
				if (array_key_exists('error', (array)$responce1)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '22222222222222';
					$data['message'] = $responce1->error->message->value;
					echo json_encode($data);
				}
			}
		} else {
			if (array_key_exists('error', (array)$responce)) {
				$data['status'] = 'False';
				$data['DocEntry'] = '1111111111111';
				$data['message'] = $responce->error->message->value;
				echo json_encode($data);
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- --> 
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here   
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if (isset($_POST['SampleCollectionInProcess_Btn'])) {
	// <!-- ---------------------- sample Intimation popup validation start Here ------------------ -->
	if (empty($_POST['IP_SC_mpleCollectBy'])) {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = "Sample Collect By Mandatory.";
		echo json_encode($data);
		exit(0);
	}

	if (empty($_POST['IP_SC_DocDate'])) {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = "Document Date Mandatory.";
		echo json_encode($data);
		exit(0);
	}
	// <!-- ---------------------- sample Intimation popup validation end Here -------------------- -->

	$tdata = array(); // This array send to AP Standalone Invoice process 

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['IP_Series'])));
	$tdata['Object'] = trim(addslashes(strip_tags('SCS_SCINPROC')));
	$tdata['U_PC_BLin'] = trim(addslashes(strip_tags($_POST['IP_SC_LineNum'])));
	$tdata['U_PC_InType'] = trim(addslashes(strip_tags($_POST['IP_SC_IngediantType'])));
	$tdata['U_PC_WoNo'] = trim(addslashes(strip_tags($_POST['IP_SC_WONo'])));
	$tdata['U_PC_WoEnt'] = trim(addslashes(strip_tags($_POST['IP_SC_WOEntry'])));
	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['IP_SC_Location'])));
	$tdata['U_PC_InBy'] = trim(addslashes(strip_tags($_POST['IP_SC_IntimatedBy'])));
	$tdata['U_PC_InDt'] = trim(addslashes(strip_tags($_POST['IP_SC_IntimatedDate'])));
	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['IP_SC_SampleQty'])));
	$tdata['U_PC_SUnit'] = trim(addslashes(strip_tags($_POST['IP_SC_SampleQtyUOM'])));
	$tdata['U_PC_SClBy'] = trim(addslashes(strip_tags($_POST['IP_SC_mpleCollectBy'])));
	$tdata['U_PC_ARNo'] = trim(addslashes(strip_tags($_POST['IP_SC_ARNo'])));
	$tdata['U_PC_DDt'] = trim(addslashes(strip_tags(date('Y-m-d', strtotime($_POST['IP_SC_DocDate'])))));
	$tdata['U_PC_TrNo'] = trim(addslashes(strip_tags($_POST['IP_SC_TRNo'])));
	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['IP_SC_Branch'])));
	$tdata['U_PC_MakeBy'] = trim(addslashes(strip_tags($_POST['IP_SC_MakeBy'])));
	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['IP_SC_ItemCode'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['IP_SC_ItemName'])));
	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['IP_SC_BatchNo'])));
	$tdata['U_PC_BtchQty'] = trim(addslashes(strip_tags($_POST['IP_SC_BatchQty'])));
	$tdata['U_PC_NCont'] = trim(addslashes(strip_tags($_POST['IP_SC_NoOfContainer'])));
	$tdata['U_PC_UTNo'] = trim(addslashes(strip_tags($_POST['IP_SC_UnderTestTransferNo'])));
	$tdata['U_PC_DRev'] = trim(addslashes(strip_tags($_POST['IP_SC_DateofReversal'])));
	$tdata['U_PC_SIssue'] = trim(addslashes(strip_tags($_POST['IP_SC_SampleIssue'])));
	$tdata['U_PC_RSIssue'] = trim(addslashes(strip_tags($_POST['IP_SC_ReverseSampleIssue'])));
	$tdata['U_PC_CntNo1'] = trim(addslashes(strip_tags($_POST['IP_SC_CntNo1'])));
	$tdata['U_PC_CntNo2'] = trim(addslashes(strip_tags($_POST['IP_SC_CntNo2'])));
	$tdata['U_PC_CntNo3'] = trim(addslashes(strip_tags($_POST['IP_SC_CntNo3'])));
	$tdata['U_PC_QtyLab'] = trim(addslashes(strip_tags($_POST['IP_SC_QtyForLabel'])));
	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['IP_SC_BPLId'])));
	$tdata['U_PC_LocCode'] = trim(addslashes(strip_tags($_POST['IP_SC_LocCode'])));
	$tdata['U_PC_RNo'] = trim(addslashes(strip_tags($_POST['IP_SC_RFPNo'])));
	$tdata['U_PC_REnt'] = trim(addslashes(strip_tags($_POST['IP_SC_RFPEntry'])));
	$tdata['U_PC_RIssue'] = trim(addslashes(strip_tags($_POST['IP_SC_RetainIssue'])));
	$tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['IP_SC_RetainQty'])));
	$tdata['U_PC_RQtyUom'] = trim(addslashes(strip_tags($_POST['IP_SC_RetainQtyUOM'])));
	$tdata['U_PC_Trans'] = null;

	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here
	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SCINPROC;

		$responce_encode = $obj->SaveSampleIntimation($tdata, $Final_API); // sample intimation save here
		$responce = json_decode($responce_encode);

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();

		if ($responce->DocNum != "") {


			// Update ARNo document number start here ------------------------------ -->
			// Sanitize input data
			$ItemCode = trim(addslashes(strip_tags($_POST['IP_SC_ItemCode'])));
			$Location = trim(addslashes(strip_tags($_POST['IP_SC_Location'])));
			$DocDate = !empty($_POST['OTSCP_DocDate']) ? date("Ymd", strtotime($_POST['IP_SC_DocDate'])) : null;

			// Construct the API URL
			$FinalAPI_ARDocNum = $INWARDSAMPCOLARNOUPDATE_APi . '?ItemCode=' . $ItemCode . '&Location=' . $Location . '&DocDate=' . $DocDate;

			// Fetch data from the API
			$response_encode_Series = $obj->GET_QuerryBasedMasterFunction($FinalAPI_ARDocNum);
			$Series_decode = json_decode($response_encode_Series);

			// Prepare data for SAP Service Layer
			$ARNo = array();
			$ARNo['Series'] = $Series_decode[0]->Series;

			// SAP Service Layer interaction
			$res112 = $obj->SAP_Login(); // SAP Service Layer Login
			if (!empty($res112)) {
				$Final_API_12 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_ARSE_APi;
				$response_encode12 = $obj->POST_ServiceLayerMasterFunction($ARNo, $Final_API_12);
			}
			$res122 = $obj->SAP_Logout(); // SAP Service Layer Logout

			if (array_key_exists('error', (array)$response_encode12)) {
				$data['status'] = 'False';
				$data['DocEntry'] = '';
				$data['message'] = $response_encode12->error->message->value;
				echo json_encode($data);
			} else {
				// Inventory Gen Entries
				$InventoryGenEntries = array();
				$InventoryGenEntries['SIDocEntry'] = trim($responce->DocEntry);
				$InventoryGenEntries['GRDocEntry'] = trim($_POST['OTSCP_GRPODocEntry']);
				$InventoryGenEntries['ItemCode'] = trim($_POST['IP_SC_ItemCode']);
				$InventoryGenEntries['LineNum'] = trim($responce->U_PC_BLin);

				$Final_API = $GRSAMPLECOLINWARD_APi;
				$responce_encode1 = $obj->POST_QuerryBasedMasterFunction($InventoryGenEntries, $Final_API);
				$responce1 = json_decode($responce_encode1);

				if (empty($responce1)) {
					$data['status'] = 'True';
					$data['DocEntry'] = $responce->DocEntry;
					$data['message'] = "Open Transaction For Sample Collection Successfully Added.";
					echo json_encode($data);
				} else {
					if (array_key_exists('error', (array)$responce1)) {
						$data['status'] = 'False';
						$data['DocEntry'] = '';
						$data['message'] = $responce1->error->message->value;
						echo json_encode($data);
					}
				}
			}
			// Update ARNo document number end here -------------------------------- -->
		} else {
			if (array_key_exists('error', (array)$responce)) {
				$data['status'] = 'False';
				$data['DocEntry'] = '';
				$data['message'] = $responce->error->message->value;
				echo json_encode($data);
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}
	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if (isset($_POST['addQcPostDocumentQCCheckBtn'])) {
	$tdata = array(); // This array send to AP Standalone Invoice process 

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['QC_CK_D_series'])));
	$tdata['Object'] = trim(addslashes(strip_tags('SCS_QCINPROC')));
	$tdata['U_PC_BLin'] = trim(addslashes(strip_tags($_POST['QC_CK_D_LineNum'])));
	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['QC_CK_D_BPLId'])));
	$tdata['U_PC_LocCode'] = trim(addslashes(strip_tags($_POST['QC_CK_D_LocCode'])));
	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['QC_CK_D_ItemCode'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['QC_CK_D_ItemName'])));
	$tdata['U_PC_GName'] = trim(addslashes(strip_tags($_POST['QC_CK_D_GenericName'])));
	$tdata['U_PC_LClaim'] = trim(addslashes(strip_tags($_POST['QC_CK_D_LabelCliam'])));
	$tdata['U_PC_RecQty'] = trim(addslashes(strip_tags($_POST['QC_CK_D_RecievedQty'])));
	$tdata['U_PC_MfgBy'] = trim(addslashes(strip_tags($_POST['QC_CK_D_MfgBy'])));
	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['QC_CK_D_BatchNo'])));
	$tdata['U_PC_BSize'] = trim(addslashes(strip_tags($_POST['QC_CK_D_BatchSize'])));
	$tdata['U_PC_MfgDt'] = trim(addslashes(strip_tags($_POST['QC_CK_D_MfgDate'])));
	$tdata['U_PC_ExpDt'] = trim(addslashes(strip_tags($_POST['QC_CK_D_ExpiryDate'])));
	$tdata['U_PC_SIntNo'] = trim(addslashes(strip_tags($_POST['QC_CK_D_SampleIntimationNo'])));
	$tdata['U_PC_SColNo'] = trim(addslashes(strip_tags($_POST['QC_CK_D_SampleCollectionNo'])));
	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['QC_CK_D_SampleQty'])));
	$tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['QC_CK_D_RecievedQty'])));
	$tdata['U_PC_PckSize'] = trim(addslashes(strip_tags($_POST['QC_CK_D_PackSize'])));
	$tdata['U_PC_SamType'] = trim(addslashes(strip_tags($_POST['QC_CK_D_SampleType'])));
	$tdata['U_PC_MType'] = trim(addslashes(strip_tags($_POST['QC_CK_D_MaterialType'])));
	$tdata['U_PC_PDate'] = trim(addslashes(strip_tags($_POST['QC_CK_D_PostingDate'])));
	$tdata['U_PC_ADate'] = trim(addslashes(strip_tags($_POST['QC_CK_D_AnalysisDate'])));
	$tdata['U_PC_QCTType'] = trim(addslashes(strip_tags($_POST['QC_CK_D_QCTesttype'])));
	$tdata['U_PC_ValUp'] = trim(addslashes(strip_tags($_POST['QC_CK_D_ValidUpTo'])));
	$tdata['U_PC_ArNo'] = trim(addslashes(strip_tags($_POST['QC_CK_D_ARNo'])));
	$tdata['U_PC_GENo'] = trim(addslashes(strip_tags($_POST['QC_CK_D_GateENo'])));
	$tdata['U_PC_APot'] = trim(addslashes(strip_tags($_POST['QC_CK_D_AssayPotency'])));
	$tdata['U_PC_LODWater'] = trim(addslashes(strip_tags($_POST['QC_CK_D_LODWater'])));
	$tdata['U_PC_Potency'] = trim(addslashes(strip_tags($_POST['QC_CK_D_Potency'])));
	$tdata['U_PC_CompBy'] = trim(addslashes(strip_tags($_POST['QC_CK_D_CompiledBy'])));
	$tdata['U_PC_ChkBy'] = trim(addslashes(strip_tags($_POST['CheckedBy'])));
	$tdata['U_PC_AnlBy'] = trim(addslashes(strip_tags($_POST['QC_CK_D_AnalysisBy'])));
	$tdata['U_PC_Remarks'] = trim(addslashes(strip_tags($_POST['QC_CK_D_Remarks'])));
	$tdata['U_PC_AsyCal'] = trim(addslashes(strip_tags($_POST['QC_CK_D_Assay'])));
	$tdata['U_PC_Factor'] = trim(addslashes(strip_tags($_POST['QC_CK_D_Factor'])));
	$tdata['U_PC_SpcNo'] = trim(addslashes(strip_tags($_POST['QC_CK_D_SpecfNo'])));
	$tdata['U_PC_RelDt'] = trim(addslashes(strip_tags($_POST['QC_CK_D_ReleaseDate'])));
	$tdata['U_PC_RetstDt'] = trim(addslashes(strip_tags($_POST['QC_CK_D_RetestDate'])));
	$tdata['U_PC_RMQC'] = trim(addslashes(strip_tags($_POST['QC_CK_D_RelMaterialWithoutQC'])));
	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['QC_CK_D_Loc'])));
	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['QC_CK_D_Branch'])));
	$tdata['U_PC_WoNo'] = trim(addslashes(strip_tags($_POST['QC_CK_D_WoNo'])));
	$tdata['U_PC_WoEnt'] = trim(addslashes(strip_tags($_POST['QC_CK_D_WODocEntry'])));
	$tdata['U_PC_MfgBy'] = trim(addslashes(strip_tags($_POST['QC_CK_D_MfgBy'])));
	$tdata['U_PC_SType'] = trim(addslashes(strip_tags($_POST['QC_CK_D_SampleType'])));
	$tdata['U_PC_NoCont'] = trim(addslashes(strip_tags($_POST['QC_CK_D_NoOfContainer'])));
	$tdata['U_PC_QCTType'] = trim(addslashes(strip_tags($_POST['QC_CK_D_QCTesttype'])));
	$tdata['U_PC_Stage'] = trim(addslashes(strip_tags($_POST['QC_CK_D_Stage'])));
	$tdata['U_PC_NoCont1'] = trim(addslashes(strip_tags($_POST['QC_CK_D_FromContainer'])));
	$tdata['U_PC_NoCont2'] = trim(addslashes(strip_tags($_POST['QC_CK_D_ToContainer'])));
	$tdata['U_PC_RNo'] = trim(addslashes(strip_tags($_POST['QC_CK_D_ReceiptNo'])));
	$tdata['U_PC_REnt'] = trim(addslashes(strip_tags($_POST['QC_CK_D_ReceiptDocEntry'])));
	$tdata['U_PC_MakeBy'] = trim(addslashes(strip_tags($_POST['QC_CK_D_MakeBy'])));
	$tdata['U_PC_GRQty'] = 0.0;






	// print_r($tdata);
	// die();
	// $tdata['U_PC_RfBy'] = null;
	// $tdata['U_PC_RNo'] = null;
	// $tdata['U_PC_REnt'] = null;
	// $tdata['U_PC_GDEntry'] = null;
	// $tdata['U_PC_RBy'] = null;
	// $tdata['U_PC_LClmUom'] = null;
	// $tdata['U_PC_GRNNo'] = null;
	// $tdata['U_PC_GRNEnt'] = null;
	// $tdata['U_PC_SCode'] = null;
	// $tdata['U_PC_SName'] = null;
	// $tdata['U_PC_NoCont']=trim(addslashes(strip_tags($_POST['noOfCont1'])));
	// $tdata['U_PckSize']=trim(addslashes(strip_tags($_POST['qcD_PckSize'])));


	$ganaralData = array();
	for ($i = 0; $i < count($_POST['parameter_code']); $i++) {
		$ganaralData['LineId'] = trim(addslashes(strip_tags($i)));
		$ganaralData['U_PC_PCode'] = trim(addslashes(strip_tags($_POST['parameter_code'][$i])));
		$ganaralData['U_PC_PName'] = trim(addslashes(strip_tags($_POST['PName'][$i])));
		$ganaralData['U_PC_Std'] = trim(addslashes(strip_tags($_POST['Standard'][$i])));
		$ganaralData['U_PC_Rel'] = trim(addslashes(strip_tags($_POST['Release'][$i])));
		$ganaralData['U_PC_PDTyp'] = trim(addslashes(strip_tags($_POST['PDType'][$i])));
		$ganaralData['U_PC_DDtl'] = trim(addslashes(strip_tags($_POST['DescriptiveDetails'][$i])));
		$ganaralData['U_PC_Logi'] = trim(addslashes(strip_tags($_POST['Logical'][$i])));
		$ganaralData['U_PC_LwMin'] = trim(addslashes(strip_tags($_POST['LowMin'][$i])));
		$ganaralData['U_PC_LwMax'] = trim(addslashes(strip_tags($_POST['LowMax'][$i])));
		$ganaralData['U_PC_UpMin'] = trim(addslashes(strip_tags($_POST['UppMin'][$i])));
		$ganaralData['U_PC_UpMax'] = trim(addslashes(strip_tags($_POST['UppMax'][$i])));
		$ganaralData['U_PC_Min'] = trim(addslashes(strip_tags($_POST['Min'][$i])));
		$ganaralData['U_PC_LMin1'] = trim(addslashes(strip_tags($_POST['ComparisonResult'][$i])));
		$ganaralData['U_PC_LMax1'] = trim(addslashes(strip_tags($_POST['LowMinRes'][$i])));
		$ganaralData['U_PC_UMin1'] = trim(addslashes(strip_tags($_POST['UppMinRes'][$i])));
		$ganaralData['U_PC_UMax1'] = trim(addslashes(strip_tags($_POST['UppMaxRes'][$i])));
		$ganaralData['U_PC_Min1'] = trim(addslashes(strip_tags($_POST['MeanRes'][$i])));
		$ganaralData['U_PC_Rotpt'] = trim(addslashes(strip_tags($_POST['ResultOutputByQCDept'][$i])));
		$ganaralData['U_PC_Rmrks'] = trim(addslashes(strip_tags($_POST['ResultOut'][$i])));
		$ganaralData['U_PC_QCSts'] = trim(addslashes(strip_tags($_POST['QC_StatusByAnalyst'][$i])));
		$ganaralData['U_PC_TMeth'] = trim(addslashes(strip_tags($_POST['TMethod'][$i])));
		$ganaralData['U_PC_MType'] = trim(addslashes(strip_tags($_POST['MType'][$i])));
		$ganaralData['U_PC_PhStd'] = trim(addslashes(strip_tags($_POST['PharmacopeiasStandard'][$i])));
		$ganaralData['U_PC_UTxt1'] = trim(addslashes(strip_tags($_POST['UserText1'][$i])));
		$ganaralData['U_PC_UTxt2'] = trim(addslashes(strip_tags($_POST['UserText1'][$i])));
		$ganaralData['U_PC_UTxt3'] = trim(addslashes(strip_tags($_POST['UserText1'][$i])));
		$ganaralData['U_PC_UTxt4'] = trim(addslashes(strip_tags($_POST['UserText1'][$i])));
		$ganaralData['U_PC_UTxt5'] = trim(addslashes(strip_tags($_POST['UserText1'][$i])));
		$ganaralData['U_PC_QCRmk'] = trim(addslashes(strip_tags($_POST['QC_CK_D_Remarks'][$i])));
		$ganaralData['U_PC_UOM'] = trim(addslashes(strip_tags($_POST['UOM'][$i])));
		$ganaralData['U_PC_Rtst'] = trim(addslashes(strip_tags($_POST['Retest'][$i])));
		$ganaralData['U_PC_Stab'] = trim(addslashes(strip_tags($_POST['Stability'][$i])));
		$ganaralData['U_PC_ExtrS'] = trim(addslashes(strip_tags($_POST['ExSample'][$i])));
		$ganaralData['U_PC_ApAsy'] = trim(addslashes(strip_tags($_POST['Appassay'][$i])));
		$ganaralData['U_PC_ApLOD'] = trim(addslashes(strip_tags($_POST['AppLOD'][$i])));
		$ganaralData['U_PC_AnyBy'] = trim(addslashes(strip_tags($_POST['qc_analysis_by'][$i])));
		$ganaralData['U_PC_ARmrk'] = trim(addslashes(strip_tags($_POST['analyst_remark'][$i])));
		$ganaralData['U_PC_InCod'] = trim(addslashes(strip_tags($_POST['InstrumentCode'][$i])));
		$ganaralData['U_PC_InNam'] = trim(addslashes(strip_tags($_POST['InsName'][$i])));
		$ganaralData['U_PC_SDt'] = trim(addslashes(strip_tags($_POST['StartDate'][$i])));
		$ganaralData['U_PC_STime'] = trim(addslashes(strip_tags($_POST['StartTime'][$i])));
		$ganaralData['U_PC_EDate'] = trim(addslashes(strip_tags($_POST['EndDate'][$i])));
		$ganaralData['U_PC_ETime'] = trim(addslashes(strip_tags($_POST['EndTime'][$i])));

		$tdata['SCS_QCINPROC1Collection'][] = $ganaralData; // row data append on this array
	}

	$qcStatus = array();
	for ($j = 0; $j < count($_POST['qc_Status']); $j++) {
		$qcStatus['LineId'] = trim(addslashes(strip_tags($j)));
		$qcStatus['Object'] = trim(addslashes(strip_tags('SCS_QCINPROC')));
		$qcStatus['U_PC_Stus'] = trim(addslashes(strip_tags($_POST['qc_Status'][$j])));
		$qcStatus['U_PC_Qty'] = trim(addslashes(strip_tags($_POST['qCStsQty'][$j])));
		$qcStatus['U_PC_RelDt'] =  trim(addslashes(strip_tags($_POST['qCReleaseDate'][$j])));
		// $qcStatus['U_PC_ITNo'] = trim(addslashes(strip_tags($_POST['qCitNo'][$j])));
		$qcStatus['U_PC_DBy'] = trim(addslashes(strip_tags($_POST['doneBy'][$j])));
		$qcStatus['U_PC_Rmrk1'] = trim(addslashes(strip_tags($_POST['qCStsRemark1'][$j])));
		$qcStatus['U_PC_Atch1'] = (!empty($_FILES['qCAttache1']['name'][$j])) ? $_FILES['qCAttache1']['name'][$j] : null;
		$qcStatus['U_PC_Atch2'] = (!empty($_FILES['qCAttache2']['name'][$j])) ? $_FILES['qCAttache2']['name'][$j] : null;
		$qcStatus['U_PC_Atch3'] = (!empty($_FILES['qCAttache3']['name'][$j])) ? $_FILES['qCAttache3']['name'][$j] : null;
		$qcStatus['U_PC_DvDt'] = (!empty($_POST['qCDeviationDate'][$j])) ? date("Y-m-d", strtotime($_POST['qCDeviationDate'][$j])) : null;
		$qcStatus['U_PC_DvNo'] = trim(addslashes(strip_tags($_POST['qCDeviationNo'][$j])));
		$qcStatus['U_PC_DvRsn'] = trim(addslashes(strip_tags($_POST['qCDeviationResion'][$j])));

		// <!-- ------ File upload code start here ----------------------------- -->
		$uploadDir = '../include/uploads/';

		$uploadFile = $uploadDir . basename($_FILES['qCAttache1']['name'][$j]);
		move_uploaded_file($_FILES['qCAttache1']['tmp_name'][$j], $uploadFile);

		$uploadFile2 = $uploadDir . basename($_FILES['qCAttache2']['name'][$j]);
		move_uploaded_file($_FILES['qCAttache2']['tmp_name'][$j], $uploadFile2);

		$uploadFile3 = $uploadDir . basename($_FILES['qCAttache3']['name'][$j]);
		move_uploaded_file($_FILES['qCAttache3']['tmp_name'][$j], $uploadFile3);
		// <!-- ------ File upload code start here ----------------------------- -->

		$tdata['SCS_QCINPROC2Collection'][] = $qcStatus; // row data append on this array
	}


	$qcAttech = array();
	for ($k = 0; $k < count($_POST['targetPath']); $k++) {
		if (!empty($_POST['fileName'][$k])) {
			$qcAttech['LineId'] = trim(addslashes(strip_tags($k)));
			$qcAttech['Object'] = trim(addslashes(strip_tags('SCS_QCINPROC')));

			$qcAttech['U_PC_TrgPt'] = trim(addslashes(strip_tags($_POST['targetPath'][$k])));
			$qcAttech['U_PC_FName'] = trim(addslashes(strip_tags($_POST['fileName'][$k])));
			$qcAttech['U_PC_AtcDt'] = trim(addslashes(strip_tags($_POST['attachDate'][$k])));
			$qcAttech['U_PC_FText'] = trim(addslashes(strip_tags($_POST['freeText'][$k])));

			$tdata['SCS_QCINPROC3Collection'][] = $qcAttech; // row data append on this array

		} else {
			// $tdata['SCS_QCINPROC3Collection'][] = array();
		}
	}

	$mainArray = $tdata; // all child array append in main array define here

	// echo '<pre>';
	// print_r($mainArray);
	// die();

	if ($_POST['QC_CK_D_SampleType'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Sample Type is required.';
		echo json_encode($data);
		exit;
	}


	if ($_POST['QC_CK_D_PostingDate'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Posting Date is required.';
		echo json_encode($data);
		exit;
	}

	if ($_POST['QC_CK_D_AnalysisDate'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Analysis Date is required.';
		echo json_encode($data);
		exit;
	}

	if ($_POST['QC_CK_D_ValidUpTo'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'ValidUpTo Date is required.';
		echo json_encode($data);
		exit;
	}

	// service laye function and SAP loin & logout function define start here -------------------------------------------------------
	$res = $obj->SAP_Login();
	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_QCINPROC;

		$responce_encode = $objKri->qcPostDocument($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {
			// GRN Process Start

			$InventoryGenEntries = array();
			$InventoryGenEntries['SIDocEntry'] = trim($responce->DocEntry);
			$InventoryGenEntries['GRDocEntry'] = trim($_POST['QC_CK_D_ReceiptDocEntry']);
			$InventoryGenEntries['ItemCode'] = trim($responce->U_PC_ICode);
			$InventoryGenEntries['LineNum'] = trim($responce->U_PC_BLin);

			$Final_API = $GRQCPOSTINPROCESS_APi;
			$responce_encode1 = $obj->POST_QuerryBasedMasterFunction($InventoryGenEntries, $Final_API);
			$responce1 = json_decode($responce_encode1);

			if (empty($responce1)) {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "QC Post Document Added Successfully.";
				echo json_encode($data);
			} else {
				if (array_key_exists('error', (array)$responce1)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce1->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	// service laye function and SAP loin & logout function define end here -------------------------------------------------------
}












if (isset($_POST['samplecollectFinishedGood_Btn'])) {
	$tdata = array(); // This array send to AP Standalone Invoice process 

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;
	$tdata['Series'] = trim(addslashes(strip_tags($_POST['SC_finished_good_DocNo'])));
	$tdata['Object'] = 'SCS_SCOLFG';

	$tdata['U_PC_BLin'] = trim(addslashes(strip_tags($_POST['SC_finished_good_LineNo'])));

	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['SC_finished_good_BPLId'])));

	$tdata['U_PC_LocCode'] = trim(addslashes(strip_tags($_POST['SC_finished_good_LocCode'])));

	$tdata['U_PC_InType'] = trim(addslashes(strip_tags($_POST['SC_IngredientsType'])));

	$tdata['U_PC_WoNo'] = trim(addslashes(strip_tags($_POST['SC_finished_good_WONo'])));

	$tdata['U_PC_WoEnt'] = trim(addslashes(strip_tags($_POST['SC_finished_good_WOEntry'])));

	$tdata['U_PC_RNo'] = trim(addslashes(strip_tags($_POST['SC_finished_good_RFPNo'])));
	$tdata['U_PC_REnt'] = trim(addslashes(strip_tags($_POST['SC_finished_good_RFPODocEntry'])));

	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['SC_finished_good_Location'])));

	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['SC_finished_good_Branch'])));

	$tdata['U_PC_InBy'] = trim(addslashes(strip_tags($_POST['SC_finished_good_IntimatedBy'])));
	// $tdata['U_PC_InDt']=trim(addslashes(strip_tags($_POST['OTSCP_GRPONo'])));
	$tdata['U_PC_InDt'] = trim(addslashes(strip_tags(date('Y-m-d', strtotime($_POST['SC_finished_good_IntimatedDate'])))));

	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['SC_finished_good_SampleQty'])));

	$tdata['U_PC_SUnit'] = trim(addslashes(strip_tags($_POST['SC_finished_good_Unit'])));

	$tdata['U_PC_SClBy'] = trim(addslashes(strip_tags($_POST['SC_finished_good_SampleCollectBy'])));

	$tdata['U_PC_ARNo'] = trim(addslashes(strip_tags($_POST['SC_finished_good_ARNo'])));

	$tdata['U_PC_DDt'] = trim(addslashes(strip_tags(date('Y-m-d', strtotime($_POST['SC_finished_good_DocDate'])))));

	$tdata['U_PC_TrNo'] = trim(addslashes(strip_tags($_POST['SC_finished_good_TRNo'])));

	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['SC_finished_good_ItemCode'])));

	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['SC_finished_good_ItemName'])));

	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['SC_finished_good_BatchNo'])));

	$tdata['U_PC_BtchQty'] = trim(addslashes(strip_tags($_POST['SC_finished_good_BatchQty'])));

	$tdata['U_PC_NCont'] = trim(addslashes(strip_tags($_POST['SC_finished_good_NoOfContainer'])));

	$tdata['U_PC_UTNo'] = trim(addslashes(strip_tags($_POST['SC_finished_good_UnderTransferNo'])));

	$tdata['U_PC_DRev'] = trim(addslashes(strip_tags($_POST['SC_finished_good_Dateofreversal'])));


	$tdata['U_PC_SIssue'] = null;
	$tdata['U_PC_RSIssue'] = null;
	$tdata['U_PC_RIssue'] = null;

	$tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['SC_finished_good_RetainQty'])));


	$tdata['U_PC_RQtyUom'] = trim(addslashes(strip_tags($_POST['SC_finished_good_RetainQtyUOM'])));

	$tdata['U_PC_CntNo1'] = trim(addslashes(strip_tags($_POST['SC_finished_good_Cont1'])));
	$tdata['U_PC_CntNo2'] = trim(addslashes(strip_tags($_POST['SC_finished_good_Cont2'])));
	$tdata['U_PC_CntNo3'] = trim(addslashes(strip_tags($_POST['SC_finished_good_Cont3'])));

	$tdata['U_PC_QtyLab'] = trim(addslashes(strip_tags($_POST['SC_finished_good_QtyforLabel'])));

	$tdata['U_PC_Trans'] = null;








	// <!-- ---------------------- sample Intimation popup validation start Here ------------------ -->
	if (empty($_POST['SC_finished_good_SampleCollectBy'])) {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = "Sample Collect By Mandatory.";
		echo json_encode($data);
		exit(0);
	}

	if (empty($_POST['SC_finished_good_DocDate'])) {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = "Document Date Mandatory.";
		echo json_encode($data);
		exit(0);
	}
	// <!-- ---------------------- sample Intimation popup validation end Here -------------------- -->
	//     echo "<pre>";
	// print_r($tdata);
	// echo "</pre>";
	// exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SCOLFG_API;

		$responce_encode = $obj->SaveSampleIntimation($tdata, $Final_API); // sample intimation save here
		$responce = json_decode($responce_encode);

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();

		if ($responce->DocNum != "") {

			$data['status'] = 'True';
			$data['DocEntry'] = $responce->DocEntry;
			$data['message'] = "Open Transaction For Sample Collection finished good Successfully Added.";
			echo json_encode($data);
		} else {
			if (array_key_exists('error', (array)$responce)) {
				$data['status'] = 'False';
				$data['DocEntry'] = '';
				$data['message'] = $responce->error->message->value;
				echo json_encode($data);
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}



if (isset($_POST['action']) && $_POST['action'] == 'QC_Post_document_QC_Check_ContainerList_ajax') {

	$ItemCode = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs = trim(addslashes(strip_tags($_POST['FromWhs'])));
	// $GRPODEnt=trim(addslashes(strip_tags($_POST['GRPODEnt'])));
	$BNo = trim(addslashes(strip_tags($_POST['BNo'])));

	// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API = $INPROCESSQCPOSTDOCUMENTCONTSEL . '?ItemCode=' . $ItemCode . '&WareHouse=' . $FromWhs . '&BatchNo=' . $BNo;

	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->

	$response = $obj->get_OTFSI_SingleData($FinalAPI);


	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {

		for ($i = 0; $i < count($response); $i++) {

			// ----------- Date formating condition definr start here---------------------------
			if (!empty($response[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response[$i]->ExpDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response[$i]->ExpDate));
			} else {
				$ExpiryDate = '';
			}


			// ----------- Date formating condition definr end here-----------------------------
			$option .= '
			<tr>
				<td style="text-align: center;">
					<input type="text" id="usercheckList' . $i . '" name="usercheckList[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response[$i]->BatchQty . '" id="itp_CS' . $i . '" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener(' . $i . ')">
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode' . $i . '" name="itp_ItemCode[]" class="form-control" value="' . $response[$i]->ItemCode . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName' . $i . '" name="itp_ItemName[]" class="form-control" value="' . $response[$i]->ItemName . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo' . $i . '" name="itp_ContainerNo[]" class="form-control" value="' . $response[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche' . $i . '" name="itp_Batch[]" class="form-control" value="' . $response[$i]->BatchNum . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty' . $i . '" name="itp_BatchQty[]" class="form-control" value="' . $response[$i]->BatchQty . '" readonly>
				</td>
				<td>
					<input class="border_hide" type="text" id="SelectedQty' . $i . '" name="SelectedQty[]" class="form-control" value="' . $response[$i]->BatchQty . '" onfocusout="EnterQtyValidation_GI(' . $i . ')">
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate' . $i . '" name="itp_MfgDate[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate' . $i . '" name="itp_ExpiryDate[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$option .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum" name="cs_selectedQtySum" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}

// QC Post document (QC Check)44 - In Process
if (isset($_POST['SubIT_Btn_In_process_QC_check_sample_issue'])) {
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['qc_check_SeriesId'])));
	$tdata['DocDate'] = date("Y-m-d", strtotime($_POST['qc_check_posting_date']));
	$tdata['DueDate'] = date("Y-m-d", strtotime($_POST['qc_check_document_date']));
	$tdata['CardCode'] = trim(addslashes(strip_tags($_POST['qc_check_supplier_code'])));
	$tdata['Comments'] = null;
	$tdata['FromWarehouse'] = trim(addslashes(strip_tags($_POST['qc_check_FromWhs'])));
	$tdata['ToWarehouse'] = trim(addslashes(strip_tags($_POST['qc_check_ToWhs'])));
	$tdata['TaxDate'] = date("Y-m-d", strtotime($_POST['qc_check_document_date']));
	$tdata['DocObjectCode'] = '67';
	$tdata['BPLID'] = trim(addslashes(strip_tags($_POST['qc_check_branchID'])));
	$tdata['U_PC_QCIProc'] = trim(addslashes(strip_tags($_POST['qc_check_DocEntry'])));
	$tdata['U_BFType'] = trim(addslashes(strip_tags('SCS_QCINPROC')));

	$mainArray = $tdata;
	// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum'] = trim(addslashes(strip_tags('0')));
	$item['ItemCode'] = trim(addslashes(strip_tags($_POST['qc_check_itemCode'])));
	$item['Quantity'] = trim(addslashes(strip_tags($_POST['qc_check_Quality'])));
	$item['WarehouseCode'] = trim(addslashes(strip_tags($_POST['qc_check_ToWhs'])));
	$item['FromWarehouseCode'] = trim(addslashes(strip_tags($_POST['qc_check_FromWhs'])));
	// <!-- Item Batch row data prepare start here ----------- -->
	for ($i = 0; $i < count($_POST['usercheckList']); $i++) {
		if ($_POST['usercheckList'][$i] == '1') {
			$batch['BatchNumber'] = trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
			$batch['Quantity'] = trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
			$batch['BaseLineNumber'] = trim(addslashes(strip_tags('0')));
			$batch['ItemCode'] = trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));
			$item['BatchNumbers'][] = $batch;
		}
	}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['StockTransferLines'][] = $item;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->

	echo "<pre>";
	print_r($mainArray);
	echo "<pre>";
	exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_StockTransfers;

		$responce_encode = $obj->SaveSampleIntimation($mainArray, $Final_API);
		$responce = json_decode($responce_encode);
		// echo "<pre>";
		// 	print_r($responce);
		// 	echo "<pre>";
		// 	exit;
		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {

			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$itme = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['qc_check_DocEntry'])));
			$UT_data['Object'] = 'SCS_QCINPROC';

			// $itme=array();
			$itme['LineId'] = trim(addslashes(strip_tags($_POST['qc_check_LineID'])));
			$itme['Object'] = 'SCS_QCINPROC';
			$itme['U_PC_ITNo'] = trim(addslashes(strip_tags($responce->DocEntry)));

			$UT_data['SCS_QCINPROC2Collection'] = $itme;

			// $UT_data['U_PC_UTNo']=trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_QCINPROC . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			if ($underTestNumber_decode == '') {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Inventory Transfer Successfully Added.";
				echo json_encode($data);
			} else {
				// $data['status']='False';
				// $data['DocEntry']='';
				// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
				// echo json_encode($data);

				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}


// =========


if (isset($_POST['addQcPostDocumentSubmitQCCheckBtn'])) {


	$tdata = array(); // This array send to AP Standalone Invoice process 

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['itP_series'])));
	$tdata['Object'] = trim(addslashes(strip_tags('SCS_QCINPROC')));
	$tdata['U_PC_BLin'] = trim(addslashes(strip_tags($_POST['qc_Check_LineNum'])));
	//$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['qc_Check_Branch'])));
	//$tdata['U_PC_LocCode'] = trim(addslashes(strip_tags($_POST['QC_CK_D_LocCode'])));
	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['qc_Check_Item_Code'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['qc_Check_Item_Name'])));
	$tdata['U_PC_GName'] = trim(addslashes(strip_tags($_POST['qc_Check_Generic_Name'])));
	$tdata['U_PC_LClaim'] = trim(addslashes(strip_tags($_POST['qc_Check_Label_Cliam'])));
	$tdata['U_PC_RecQty'] = trim(addslashes(strip_tags($_POST['qc_Check_Recieved_Qty'])));
	$tdata['U_PC_MfgBy'] = trim(addslashes(strip_tags($_POST['qc_Check_Mfg_By'])));
	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['qc_Check_BatchNo'])));
	$tdata['U_PC_BSize'] = trim(addslashes(strip_tags($_POST['qc_Check_BatchSize'])));
	$tdata['U_PC_MfgDt'] = trim(addslashes(strip_tags($_POST['qc_Check_MfgDate'])));
	$tdata['U_PC_ExpDt'] = trim(addslashes(strip_tags($_POST['qc_Check_ExpiryDate'])));
	$tdata['U_PC_SIntNo'] = trim(addslashes(strip_tags($_POST['qc_Check_SampleIntimationNo'])));
	$tdata['U_PC_SColNo'] = trim(addslashes(strip_tags($_POST['qc_Check_SampleCollectionNo'])));
	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['qc_Check_SampleQty'])));
	$tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['qc_Check_RecievedQty'])));
	$tdata['U_PC_PckSize'] = trim(addslashes(strip_tags($_POST['qc_Check_PackSize'])));
	$tdata['U_PC_SamType'] = trim(addslashes(strip_tags($_POST['qc_Check_Sample_Type'])));
	$tdata['U_PC_MType'] = trim(addslashes(strip_tags($_POST['qc_Check_Material_Type'])));
	$tdata['U_PC_PDate'] = trim(addslashes(strip_tags($_POST['qc_Check_PostingDate'])));
	$tdata['U_PC_ADate'] = trim(addslashes(strip_tags($_POST['qc_Check_AnalysisDate'])));
	$tdata['U_PC_QCTType'] = trim(addslashes(strip_tags($_POST['qc_Check_QCTesttype'])));
	$tdata['U_PC_ValUp'] = trim(addslashes(strip_tags($_POST['qc_Check_ValidUpTo'])));
	$tdata['U_PC_ArNo'] = trim(addslashes(strip_tags($_POST['qc_Check_ARNo'])));
	$tdata['U_PC_GENo'] = trim(addslashes(strip_tags($_POST['qc_Check_GateENo'])));
	$tdata['U_PC_APot'] = trim(addslashes(strip_tags($_POST['qc_Check_AssayPotency'])));
	$tdata['U_PC_LODWater'] = trim(addslashes(strip_tags($_POST['qc_Check_LODWater'])));
	$tdata['U_PC_Potency'] = trim(addslashes(strip_tags($_POST['qc_Check_Potency'])));
	$tdata['U_PC_CompBy'] = trim(addslashes(strip_tags($_POST['qc_Check_CompiledBy'])));
	$tdata['U_PC_ChkBy'] = trim(addslashes(strip_tags($_POST['qc_Check_CheckedBy'])));
	$tdata['U_PC_AnlBy'] = trim(addslashes(strip_tags($_POST['qc_Check_AnalysisBy'])));
	$tdata['U_PC_Remarks'] = trim(addslashes(strip_tags($_POST['qc_Check_Remarks'])));
	//$tdata['U_PC_AsyCal'] = trim(addslashes(strip_tags($_POST['qc_Check_Assay'])));
	$tdata['U_PC_Factor'] = trim(addslashes(strip_tags($_POST['qc_Check_Factor'])));
	$tdata['U_PC_SpcNo'] = trim(addslashes(strip_tags($_POST['qc_Check_SpecfNo'])));
	$tdata['U_PC_RelDt'] = trim(addslashes(strip_tags($_POST['qc_Check_ReleaseDate'])));
	$tdata['U_PC_RetstDt'] = trim(addslashes(strip_tags($_POST['qc_Check_RetestDate'])));
	$tdata['U_PC_RMQC'] = trim(addslashes(strip_tags($_POST['QC_CK_D_RelMaterialWithoutQC'])));
	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['qc_Check_Loc'])));
	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['qc_Check_Branch'])));
	$tdata['U_PC_WoNo'] = trim(addslashes(strip_tags($_POST['qc_Check_WoNo'])));
	$tdata['U_PC_WoEnt'] = trim(addslashes(strip_tags($_POST['qc_Check_WODocEntry'])));
	$tdata['U_PC_MfgBy'] = trim(addslashes(strip_tags($_POST['qc_Check_MfgBy'])));
	$tdata['U_PC_SType'] = trim(addslashes(strip_tags($_POST['qc_Check_SampleType'])));
	$tdata['U_PC_NoCont'] = trim(addslashes(strip_tags($_POST['qc_Check_NoOfContainer'])));
	$tdata['U_PC_QCTType'] = trim(addslashes(strip_tags($_POST['qc_Check_QCTesttype'])));
	$tdata['U_PC_Stage'] = trim(addslashes(strip_tags($_POST['qc_Check_Stage'])));
	$tdata['U_PC_NoCont1'] = trim(addslashes(strip_tags($_POST['qc_Check_FromContainer'])));
	$tdata['U_PC_NoCont2'] = trim(addslashes(strip_tags($_POST['qc_Check_ToContainer'])));
	$tdata['U_PC_RNo'] = trim(addslashes(strip_tags($_POST['qc_Check_ReceiptNo'])));
	$tdata['U_PC_REnt'] = trim(addslashes(strip_tags($_POST['qc_Check_ReceiptDocEntry'])));
	$tdata['U_PC_GRQty'] = 0.0;








	// $tdata['U_PckSize']=trim(addslashes(strip_tags($_POST['qcD_PckSize'])));
	$ganaralData = array();
	$BL = 0; //skip array avoid and count continue
	for ($i = 0; $i < count($_POST['parameter_code']); $i++) {
		$ganaralData['LineId'] = trim(addslashes(strip_tags($i)));
		$ganaralData['U_PC_PCode'] = trim(addslashes(strip_tags($_POST['parameter_code'][$i])));
		$ganaralData['U_PC_PName'] = trim(addslashes(strip_tags($_POST['PName'][$i])));
		$ganaralData['U_PC_Std'] = trim(addslashes(strip_tags($_POST['Standard'][$i])));
		$ganaralData['U_PC_Rel'] = trim(addslashes(strip_tags($_POST['Release'][$i])));
		$ganaralData['U_PC_PDTyp'] = trim(addslashes(strip_tags($_POST['PDType'][$i])));
		$ganaralData['U_PC_DDtl'] = trim(addslashes(strip_tags($_POST['DescriptiveDetails'][$i])));
		$ganaralData['U_PC_Logi'] = trim(addslashes(strip_tags($_POST['Logical'][$i])));
		$ganaralData['U_PC_LwMin'] = trim(addslashes(strip_tags($_POST['LowMin'][$i])));
		$ganaralData['U_PC_LwMax'] = trim(addslashes(strip_tags($_POST['LowMax'][$i])));
		$ganaralData['U_PC_UpMin'] = trim(addslashes(strip_tags($_POST['UppMin'][$i])));
		$ganaralData['U_PC_UpMax'] = trim(addslashes(strip_tags($_POST['UppMax'][$i])));
		$ganaralData['U_PC_Min'] = trim(addslashes(strip_tags($_POST['Min'][$i])));
		$ganaralData['U_PC_LMin1'] = trim(addslashes(strip_tags($_POST['ComparisonResult'][$i])));
		$ganaralData['U_PC_LMax1'] = trim(addslashes(strip_tags($_POST['LowMinRes'][$i])));
		$ganaralData['U_PC_UMin1'] = trim(addslashes(strip_tags($_POST['UppMinRes'][$i])));
		$ganaralData['U_PC_UMax1'] = trim(addslashes(strip_tags($_POST['UppMaxRes'][$i])));
		$ganaralData['U_PC_Min1'] = trim(addslashes(strip_tags($_POST['MeanRes'][$i])));
		$ganaralData['U_PC_Rotpt'] = trim(addslashes(strip_tags($_POST['ResultOutputByQCDept'][$i])));
		$ganaralData['U_PC_Rmrks'] = trim(addslashes(strip_tags($_POST['ResultOut'][$i])));
		$ganaralData['U_PC_QCSts'] = trim(addslashes(strip_tags($_POST['QC_StatusByAnalyst'][$i])));
		$ganaralData['U_PC_TMeth'] = trim(addslashes(strip_tags($_POST['TMethod'][$i])));
		$ganaralData['U_PC_MType'] = trim(addslashes(strip_tags($_POST['MType'][$i])));
		$ganaralData['U_PC_PhStd'] = trim(addslashes(strip_tags($_POST['PharmacopeiasStandard'][$i])));
		$ganaralData['U_PC_UTxt1'] = trim(addslashes(strip_tags($_POST['UserText1'][$i])));
		$ganaralData['U_PC_UTxt2'] = trim(addslashes(strip_tags($_POST['UserText1'][$i])));
		$ganaralData['U_PC_UTxt3'] = trim(addslashes(strip_tags($_POST['UserText1'][$i])));
		$ganaralData['U_PC_UTxt4'] = trim(addslashes(strip_tags($_POST['UserText1'][$i])));
		$ganaralData['U_PC_UTxt5'] = trim(addslashes(strip_tags($_POST['UserText1'][$i])));
		$ganaralData['U_PC_QCRmk'] = trim(addslashes(strip_tags($_POST['QC_CK_D_Remarks'][$i])));
		$ganaralData['U_PC_UOM'] = trim(addslashes(strip_tags($_POST['UOM'][$i])));
		$ganaralData['U_PC_Rtst'] = trim(addslashes(strip_tags($_POST['Retest'][$i])));
		$ganaralData['U_PC_Stab'] = trim(addslashes(strip_tags($_POST['Stability'][$i])));
		$ganaralData['U_PC_ExtrS'] = trim(addslashes(strip_tags($_POST['ExSample'][$i])));
		$ganaralData['U_PC_ApAsy'] = trim(addslashes(strip_tags($_POST['Appassay'][$i])));
		$ganaralData['U_PC_ApLOD'] = trim(addslashes(strip_tags($_POST['AppLOD'][$i])));
		$ganaralData['U_PC_AnyBy'] = trim(addslashes(strip_tags($_POST['qc_analysis_by'][$i])));
		$ganaralData['U_PC_ARmrk'] = trim(addslashes(strip_tags($_POST['analyst_remark'][$i])));
		$ganaralData['U_PC_InCod'] = trim(addslashes(strip_tags($_POST['InstrumentCode'][$i])));
		$ganaralData['U_PC_InNam'] = trim(addslashes(strip_tags($_POST['InsName'][$i])));
		$ganaralData['U_PC_SDt'] = trim(addslashes(strip_tags($_POST['StartDate'][$i])));
		$ganaralData['U_PC_STime'] = trim(addslashes(strip_tags($_POST['StartTime'][$i])));
		$ganaralData['U_PC_EDate'] = trim(addslashes(strip_tags($_POST['EndDate'][$i])));
		$ganaralData['U_PC_ETime'] = trim(addslashes(strip_tags($_POST['EndTime'][$i])));

		$tdata['SCS_QCINPROC1Collection'][] = $ganaralData; // row data append on this array
	}



	$qcStatus = array();
	for ($j = 0; $j < count($_POST['qc_Status']); $j++) {
		$qcStatus['LineId'] = trim(addslashes(strip_tags($j)));
		$qcStatus['Object'] = trim(addslashes(strip_tags('SCS_QCINPROC')));
		$qcStatus['U_PC_Stus'] = trim(addslashes(strip_tags($_POST['qc_Status'][$j])));
		$qcStatus['U_PC_Qty'] = trim(addslashes(strip_tags($_POST['qCStsQty'][$j])));
		$qcStatus['U_PC_RelDt'] =  trim(addslashes(strip_tags($_POST['qCReleaseDate'][$j])));
		$qcStatus['U_PC_RelTm'] = trim(addslashes(strip_tags($_POST['qCReleaseTime'][$j])));
		$qcStatus['U_PC_DBy'] = trim(addslashes(strip_tags($_POST['doneBy'][$j])));
		$qcStatus['U_PC_Rmrk1'] = trim(addslashes(strip_tags($_POST['qCStsRemark1'][$j])));
		$qcStatus['U_PC_Atch1'] = (!empty($_FILES['qCAttache1']['name'][$j])) ? $_FILES['qCAttache1']['name'][$j] : null;
		$qcStatus['U_PC_Atch2'] = (!empty($_FILES['qCAttache2']['name'][$j])) ? $_FILES['qCAttache2']['name'][$j] : null;
		$qcStatus['U_PC_Atch3'] = (!empty($_FILES['qCAttache3']['name'][$j])) ? $_FILES['qCAttache3']['name'][$j] : null;
		$qcStatus['U_PC_DvDt'] = (!empty($_POST['qCDeviationDate'][$j])) ? date("Y-m-d", strtotime($_POST['qCDeviationDate'][$j])) : null;
		$qcStatus['U_PC_DvNo'] = trim(addslashes(strip_tags($_POST['qCDeviationNo'][$j])));
		$qcStatus['U_PC_DvRsn'] = trim(addslashes(strip_tags($_POST['qCDeviationResion'][$j])));

		// <!-- ------ File upload code start here ----------------------------- -->
		$uploadDir = '../include/uploads/';

		$uploadFile = $uploadDir . basename($_FILES['qCAttache1']['name'][$j]);
		move_uploaded_file($_FILES['qCAttache1']['tmp_name'][$j], $uploadFile);

		$uploadFile2 = $uploadDir . basename($_FILES['qCAttache2']['name'][$j]);
		move_uploaded_file($_FILES['qCAttache2']['tmp_name'][$j], $uploadFile2);

		$uploadFile3 = $uploadDir . basename($_FILES['qCAttache3']['name'][$j]);
		move_uploaded_file($_FILES['qCAttache3']['tmp_name'][$j], $uploadFile3);
		// <!-- ------ File upload code start here ----------------------------- -->

		$tdata['SCS_QCINPROC2Collection'][] = $qcStatus; // row data append on this array
	}


	$qcAttech = array();
	for ($k = 0; $k < count($_POST['targetPath']); $k++) {
		if (!empty($_POST['fileName'][$k])) {
			$qcAttech['LineId'] = trim(addslashes(strip_tags($k)));
			$qcAttech['Object'] = trim(addslashes(strip_tags('SCS_QCINPROC')));

			$qcAttech['U_PC_TrgPt'] = trim(addslashes(strip_tags($_POST['targetPath'][$k])));
			$qcAttech['U_PC_FName'] = trim(addslashes(strip_tags($_POST['fileName'][$k])));
			$qcAttech['U_PC_AtcDt'] = trim(addslashes(strip_tags($_POST['attachDate'][$k])));
			$qcAttech['U_PC_FText'] = trim(addslashes(strip_tags($_POST['freeText'][$k])));

			$tdata['SCS_QCINPROC3Collection'][] = $qcAttech; // row data append on this array

		} else {
			// $tdata['SCS_QCINPROC3Collection'][] = array();
		}
	}

	$mainArray = $tdata;

	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;

	if ($_POST['qc_Check_Sample_Type'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Sample Type is required.';
		echo json_encode($data);
		exit;
	}


	if ($_POST['qc_Check_PostingDate'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Posting Date is required.';
		echo json_encode($data);
		exit;
	}

	if ($_POST['qc_Check_AnalysisDate'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Analysis Date is required.';
		echo json_encode($data);
		exit;
	}

	if ($_POST['qc_Check_ValidUpTo'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'ValidUpTo Date is required.';
		echo json_encode($data);
		exit;
	}

	// QC_CK_D_AnalysisDate

	// id="QC_CK_D_PostingDate"


	// service laye function and SAP loin & logout function define start here -------------------------------------------------------
	$res = $obj->SAP_Login();

	if (!empty($res)) {

		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_QCINPROC;

		$responce_encode = $objKri->qcPostDocument($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {
			$data['status'] = 'True';
			$data['DocEntry'] = $responce->DocEntry;
			$data['message'] = 'QC Post Document Added Successfully';
			echo json_encode($data);
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	// service laye function and SAP loin & logout function define end here 
}





if (isset($_POST['SampleCollectionFinishedGoodUpdateForm_Btn'])) {
	// <!-- ------------ array declare Here ------------- -->
	$mainArray = array();
	$ExternalIssue = array();
	$ExtraIssue = array();
	// <!-- ------------ array declare Here ------------- -->
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;
	$tdata['Series'] = trim(addslashes(strip_tags($_POST['si_Series'])));
	$tdata['Object'] = 'SCS_SCOLFG';
	$tdata['U_PC_BLin'] = trim(addslashes(strip_tags($_POST['LineNo'])));

	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['BPLId'])));
	$tdata['U_PC_LocCode'] = trim(addslashes(strip_tags($_POST['LocCode'])));

	$tdata['U_PC_InType'] = trim(addslashes(strip_tags($_POST['fg_IngediantType'])));

	$tdata['U_PC_WoNo'] = trim(addslashes(strip_tags($_POST['fg_WoNo'])));

	$tdata['U_PC_WoEnt'] = trim(addslashes(strip_tags($_POST['fg_WoEntry'])));

	$tdata['U_PC_RNo'] = trim(addslashes(strip_tags($_POST['fg_RFPNo'])));
	$tdata['U_PC_REnt'] = trim(addslashes(strip_tags($_POST['fg_RFPEntry'])));

	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['fg_Loction'])));

	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['fg_Branch'])));

	$tdata['U_PC_InBy'] = trim(addslashes(strip_tags($_POST['fg_IntimatedBy'])));

	$tdata['U_PC_InDt'] = date("Y-m-d", strtotime($_POST['fg_IntimationDate']));

	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['fg_SampleQty'])));

	$tdata['U_PC_SUnit'] = trim(addslashes(strip_tags($_POST['fg_SampleQtyUnit'])));



	$tdata['U_PC_SClBy'] = trim(addslashes(strip_tags($_POST['fg_SampleCollectBy'])));

	$tdata['U_PC_ARNo'] = trim(addslashes(strip_tags($_POST['fg_ARNo'])));

	$tdata['U_PC_DDt'] = date("Y-m-d", strtotime($_POST['fg_DocDate']));


	$tdata['U_PC_TrNo'] = trim(addslashes(strip_tags($_POST['fg_TRNo'])));

	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['fg_ItemCode'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['fg_ItemName'])));

	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['fg_BatchNo'])));

	$tdata['U_PC_BtchQty'] = trim(addslashes(strip_tags($_POST['BatchQty'])));
	$tdata['U_PC_NCont'] = trim(addslashes(strip_tags($_POST['fg_NoofCont'])));
	$tdata['U_PC_UTNo'] = trim(addslashes(strip_tags($_POST['UnderTestTransferNo'])));


	// $tdata['U_GRPODEnt']=trim(addslashes(strip_tags($_POST['SCF_GRPO_DocEntry'])));
	if (!empty($_POST['DateofReversal'])) {
		$tdata['U_PC_DRev'] = date("Y-m-d", strtotime($_POST['DateofReversal']));
	} else {
		$tdata['U_PC_DRev'] = null;
	}

	$tdata['U_PC_SIssue'] = trim(addslashes(strip_tags($_POST['SampleIssue'])));
	$tdata['U_PC_RSIssue'] = trim(addslashes(strip_tags($_POST['SampleIssue'])));
	$tdata['U_PC_RIssue'] = trim(addslashes(strip_tags($_POST['RetainIssue'])));

	$tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['RetainQty'])));
	$tdata['U_PC_RQtyUom'] = trim(addslashes(strip_tags($_POST['RetainQtyUom'])));

	$tdata['U_PC_CntNo1'] = trim(addslashes(strip_tags($_POST['ContainerNo1'])));
	$tdata['U_PC_CntNo2'] = trim(addslashes(strip_tags($_POST['ContainerNo2'])));
	$tdata['U_PC_CntNo3'] = trim(addslashes(strip_tags($_POST['ContainerNo3'])));

	$tdata['U_PC_QtyLab'] = trim(addslashes(strip_tags($_POST['QtyForLabel'])));
	$tdata['U_PC_Trans'] = null;
	$tdata['Remark'] = null;

	// $tdata['U_BPLId']=trim(addslashes(strip_tags($_POST['SCF_BPLId'])));
	// $tdata['U_LocCode']=trim(addslashes(strip_tags($_POST['SCF_GRPO_LocCode'])));
	// $tdata['U_SRSep']=trim(addslashes(strip_tags($_POST['SCF_SampleReSep'])));
	// $tdata['U_BtchQty']=trim(addslashes(strip_tags($_POST['SCF_GRPO_BatchQty'])));

	$mainArray = $tdata;

	// <!-- ------------------------ External Issue row data preparing start here ----------------------- --> 
	for ($i = 0; $i < count($_POST['SC_FEXI_SupplierCode']); $i++) {

		$ExternalIssue['LineId'] = trim(addslashes(strip_tags(($i + 1))));
		$ExternalIssue['Object'] = 'SCS_SCOLFG';
		$ExternalIssue['U_PC_SCode'] = trim(addslashes(strip_tags($_POST['SC_FEXI_SupplierCode'][$i])));
		$ExternalIssue['U_PC_SName'] = trim(addslashes(strip_tags($_POST['SC_FEXI_SupplierName'][$i])));
		$ExternalIssue['U_PC_UOM'] = trim(addslashes(strip_tags($_POST['SC_FEXI_UOM'][$i])));



		$ExternalIssue['U_PC_Whs'] = trim(addslashes(strip_tags($_POST['SC_FEXI_Warehouse'][$i])));
		$ExternalIssue['U_PC_SQty1'] = trim(addslashes(strip_tags($_POST['SC_FEXI_SampleQuantity'][$i])));

		if (!empty($_POST['SC_FEXI_SampleDate'][$i])) {
			$ExternalIssue['U_PC_SDt'] = date("Y-m-d", strtotime($_POST['SC_FEXI_SampleDate'][$i]));
		} else {
			$ExternalIssue['U_PC_SDt'] = null;
		}


		// $ExternalIssue['U_PC_Trans']=trim(addslashes(strip_tags($_POST['SC_SCD_UTTransNo'])));

		// if(!empty($_POST['UnderTestTransferNo'][$i])){
		// 	$ExternalIssue['U_PC_Trans']=trim(addslashes(strip_tags($_POST['UnderTestTransferNo'][$i])));
		// }else{
		// 	$ExternalIssue['U_PC_Trans']=null;
		// }
		$ExternalIssue['U_PC_Trans'] = null;
		$ExternalIssue['U_PC_Attch'] = trim(addslashes(strip_tags($_POST['SC_FEXI_Attachment'][$i])));
		$ExternalIssue['U_PC_UTxt1'] = trim(addslashes(strip_tags($_POST['SC_FEXI_UserText1'][$i])));
		$ExternalIssue['U_PC_UTxt2'] = trim(addslashes(strip_tags($_POST['SC_FEXI_UserText2'][$i])));
		$ExternalIssue['U_PC_UTxt3'] = trim(addslashes(strip_tags($_POST['SC_FEXI_UserText3'][$i])));
		//there is missing some colume like textBox1,textBox2 and textBox3

		$mainArray['SCS_SCOLFG1Collection'][] = $ExternalIssue;
	}
	// <!-- ------------------------ External Issue row data preparing start here ----------------------- --> 

	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 
	for ($j = 0; $j < count($_POST['SC_FEI_SampleQuantity']); $j++) {

		$ExtraIssue['LineId'] = trim(addslashes(strip_tags(($j + 1))));
		$ExtraIssue['Object'] = 'SCS_SCOLFG';
		$ExtraIssue['U_PC_SQty2'] = trim(addslashes(strip_tags($_POST['SC_FEI_SampleQuantity'][$j])));
		$ExtraIssue['U_PC_UOM'] = trim(addslashes(strip_tags($_POST['SC_FEI_UOM'][$j])));
		$ExtraIssue['U_PC_Whs'] = trim(addslashes(strip_tags($_POST['SC_FEI_Warehouse'][$j])));
		$ExtraIssue['U_PC_SBy'] = trim(addslashes(strip_tags($_POST['SC_FEI_SampleBy'][$j])));

		if (!empty($_POST['SC_FEI_IssueDate'][$j])) {
			$ExtraIssue['U_PC_IDt'] = date("Y-m-d", strtotime($_POST['SC_FEI_IssueDate'][$j]));
		} else {
			$ExtraIssue['U_PC_IDt'] = null;
		}

		if (!empty($_POST['SC_FEI_PostExtraIssue'][$j])) {
			$ExtraIssue['U_PC_PEIs'] = trim(addslashes(strip_tags($_POST['SC_FEI_PostExtraIssue'][$j])));
		} else {
			$ExtraIssue['U_PC_PEIs'] = null;
		}


		$mainArray['SCS_SCOLFG2Collection'][] = $ExtraIssue;
	}
	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 
	// echo "<pre>";
	// print_r($mainArray);
	// echo "</pre>";
	// exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {

		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SCOLFG_API . '(' . $_POST['it__DocEntry'] . ')';

		$responce_encode = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		if ($responce == '') {
			$data['status'] = 'True';
			$data['DocEntry'] = $responce->DocEntry;
			$data['message'] = "Sample Collection - Finished Goods Successfully Added.";
			echo json_encode($data);
		} else {

			if (array_key_exists('error', (array)$responce)) {
				$data['status'] = 'False';
				$data['DocEntry'] = '';
				$data['message'] = $responce->error->message->value;
				echo json_encode($data);
			}
		}
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	

	//<!-- ------------- function & function responce code end Here ---- -->

	exit(0);
}




if (isset($_POST['SampleCollectionStabilityUpdateForm_Btn'])) {

	$tdata = array(); // This array send to AP Standalone Invoice process 
	$tdata['Series'] = trim(addslashes(strip_tags($_POST['B_Series'])));
	$tdata['Remark'] = null;
	$tdata['Object'] = 'SCS_SCOLSTAB';
	$tdata['U_PC_BLin'] = null;
	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['B_BPLId'])));
	$tdata['U_PC_LocCode'] = trim(addslashes(strip_tags($_POST['B_LocCode'])));
	$tdata['U_PC_InType'] = trim(addslashes(strip_tags($_POST['B_IngrediantType'])));
	$tdata['U_PC_WoNo'] = trim(addslashes(strip_tags($_POST['B_WoNo'])));
	$tdata['U_PC_WoEnt'] = trim(addslashes(strip_tags($_POST['B_WoEntry'])));
	$tdata['U_PC_RNo'] = trim(addslashes(strip_tags($_POST['B_ReceiptNo'])));
	$tdata['U_PC_REnt'] = trim(addslashes(strip_tags($_POST['B_ReceiptEntry'])));
	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['B_Location'])));
	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['B_Branch'])));
	$tdata['U_PC_InBy'] = trim(addslashes(strip_tags($_POST['B_IntimatedBy'])));
	if (!empty($_POST['B_IntimatedDate'])) {
		$tdata['U_PC_InDt'] = date("Y-m-d", strtotime($_POST['B_IntimatedDate']));
	} else {
		$tdata['U_PC_InDt'] = null;
	}

	$tdata['U_PC_SQty'] = null;
	$tdata['U_PC_SUnit'] = trim(addslashes(strip_tags($_POST['B_Unit'])));
	$tdata['U_PC_SClBy'] = trim(addslashes(strip_tags($_POST['B_SampleCollectBy'])));
	$tdata['U_PC_ARNo'] = trim(addslashes(strip_tags($_POST['B_ARNo'])));
	if (!empty($_POST['B_DocDate'])) {
		$tdata['U_PC_DDt'] = date("Y-m-d", strtotime($_POST['B_DocDate']));
	} else {
		$tdata['U_PC_DDt'] = null;
	}

	$tdata['U_PC_TrNo'] = null;
	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['B_ItemCode'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['B_ItemName'])));
	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['B_BatchNo'])));
	$tdata['U_PC_BtchQty'] = trim(addslashes(strip_tags($_POST['B_BatchQty'])));
	$tdata['U_PC_NCont'] = trim(addslashes(strip_tags($_POST['B_TotalNoOfContainer'])));
	$tdata['U_PC_UTNo'] = trim(addslashes(strip_tags($_POST['SCD_UnderTestTransferNo'])));
	$tdata['U_PC_DRev'] = null;
	$tdata['U_PC_SIssue'] = null;
	$tdata['U_PC_RSIssue'] = null;
	$tdata['U_PC_RIssue'] = null;
	$tdata['U_PC_RQty'] = null;
	$tdata['U_PC_RQtyUom'] = null;
	$tdata['U_PC_CntNo1'] = null;
	$tdata['U_PC_CntNo2'] = null;
	$tdata['U_PC_CntNo3'] = null;
	$tdata['U_PC_QtyLab'] = null;
	$tdata['U_PC_Trans'] = null;
	$tdata['U_PC_StType'] = trim(addslashes(strip_tags($_POST['B_StabilityType'])));
	$tdata['U_PC_StCon'] = trim(addslashes(strip_tags($_POST['B_StabilityCondition'])));
	$tdata['U_PC_StTPer'] = trim(addslashes(strip_tags($_POST['B_StabilityTimePeriod'])));
	$tdata['U_PC_AnType'] = trim(addslashes(strip_tags($_POST['B_AnalysisType'])));
	$tdata['U_PC_WhsCode'] = trim(addslashes(strip_tags($_POST['B_WhsCode'])));
	$tdata['U_PC_BEnt'] = trim(addslashes(strip_tags($_POST['B_BaseEntry'])));
	$tdata['U_PC_BNum'] = trim(addslashes(strip_tags($_POST['B_BaseNum'])));
	$tdata['U_PC_StDNo'] = trim(addslashes(strip_tags($_POST['B_StabilityPlanDocNum'])));
	$tdata['U_PC_StDEnt'] = trim(addslashes(strip_tags($_POST['B_StabilityPlanDocEntry'])));
	$tdata['U_PC_StDt'] = null;
	$tdata['U_PC_StQty'] = trim(addslashes(strip_tags($_POST['B_StabilityPlanQty'])));

	if (!empty($_POST['B_MfgDate'])) {
		$tdata['U_PC_MnfDt'] = date("Y-m-d", strtotime($_POST['B_MfgDate'][$i]));
	} else {
		$tdata['U_PC_MnfDt'] = null;
	}

	if (!empty($_POST['B_ExpDate'])) {
		$tdata['U_PC_ExpDt'] = date("Y-m-d", strtotime($_POST['B_ExpDate'][$i]));
	} else {
		$tdata['U_PC_ExpDt'] = null;
	}

	$mainArray = $tdata; // header data append on main array

	for ($i = 0; $i < count($_POST['SC_ExternalI_SupplierCode']); $i++) {

		$ExternalIssue['LineId'] = trim(addslashes(strip_tags(($i + 1))));
		$ExternalIssue['Object'] = 'SCS_SCOLSTAB';
		$ExternalIssue['U_PC_SCode'] = trim(addslashes(strip_tags($_POST['SC_ExternalI_SupplierCode'][$i])));
		$ExternalIssue['U_PC_SName'] = trim(addslashes(strip_tags($_POST['SC_FEXI_SupplierName'][$i])));
		$ExternalIssue['U_PC_UOM'] = trim(addslashes(strip_tags($_POST['SC_FEXI_UOM'][$i])));
		$ExternalIssue['U_PC_SDt'] = trim(addslashes(strip_tags($_POST['SC_FEXI_SampleDate'][$i])));
		$ExternalIssue['U_PC_Whs'] = trim(addslashes(strip_tags($_POST['SC_ExternalI_Warehouse'][$i])));
		$ExternalIssue['U_PC_SQty1'] = trim(addslashes(strip_tags($_POST['SC_FEXI_SampleQuantity'][$i])));
		// $ExternalIssue['U_PC_Trans']=trim(addslashes(strip_tags($_POST['U_PC_Trans'][$i])));

		$ExternalIssue['U_PC_Attch'] = trim(addslashes(strip_tags($_POST['SC_FEXI_Attachment'][$i])));
		$ExternalIssue['U_PC_UTxt1'] = trim(addslashes(strip_tags($_POST['SC_FEXI_UserText1'][$i])));
		$ExternalIssue['U_PC_UTxt2'] = trim(addslashes(strip_tags($_POST['SC_FEXI_UserText2'][$i])));
		$ExternalIssue['U_PC_UTxt3'] = trim(addslashes(strip_tags($_POST['SC_FEXI_UserText3'][$i])));
		// $ExternalIssue['U_PC_Trans']=trim(addslashes(strip_tags($_POST['SC_FEXI_InventoryTransfer'][$i])));
		if (!empty($_POST['SC_FEXI_InventoryTransfer'][$i])) {
			$ExternalIssue['U_PC_Trans'] = trim(addslashes(strip_tags($_POST['SC_FEXI_InventoryTransfer'][$i])));
		} else {
			$ExternalIssue['U_PC_Trans'] = null;
		}

		$mainArray['SCS_SCOLSTAB1Collection'][] = $ExternalIssue;
	}

	for ($j = 0; $j < count($_POST['SC_FEI_SampleQuantity']); $j++) {

		$ExtraIssue['LineId'] = trim(addslashes(strip_tags(($j + 1))));
		$ExtraIssue['Object'] = 'SCS_SCOLSTAB';
		$ExtraIssue['U_PC_SQty2'] = trim(addslashes(strip_tags($_POST['SC_FEI_SampleQuantity'][$j])));
		$ExtraIssue['U_PC_UOM'] = trim(addslashes(strip_tags($_POST['SC_FEI_UOM'][$j])));
		$ExtraIssue['U_PC_Whs'] = trim(addslashes(strip_tags($_POST['SC_FEI_Warehouse'][$j])));
		$ExtraIssue['U_PC_SBy'] = trim(addslashes(strip_tags($_POST['SC_FEI_SampleBy'][$j])));

		if (!empty($_POST['SC_FEI_IssueDate'][$j])) {
			$ExtraIssue['U_PC_IDt'] = date("Y-m-d", strtotime($_POST['SC_FEI_IssueDate'][$j]));
		} else {
			$ExtraIssue['U_PC_IDt'] = null;
		}

		if (!empty($_POST['SC_FEI_PostExtraIssue'][$j])) {
			$ExtraIssue['U_PC_PEIs'] = trim(addslashes(strip_tags($_POST['SC_FEI_PostExtraIssue'][$j])));
		} else {
			$ExtraIssue['U_PC_PEIs'] = null;
		}

		$mainArray['SCS_SCOLSTAB2Collection'][] = $ExtraIssue;
	}

	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {

		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SCOLSTAB . '(' . $_POST['B_DocEntry'] . ')';

		$responce_encode = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		if ($responce == '') {
			$data['status'] = 'True';
			$data['DocEntry'] = $_POST['B_DocEntry'];
			$data['message'] = "Sample Collection Stability Successfully Updated.";
			echo json_encode($data);
		} else {

			if (array_key_exists('error', (array)$responce)) {
				$data['status'] = 'False';
				$data['DocEntry'] = '';
				$data['message'] = $responce->error->message->value;
				echo json_encode($data);
			}
		}
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	




	//        $res=$obj->SAP_Login();

	//        if(!empty($res)){
	// 		echo $Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SCOLSTAB.'('.$_POST['B_DocEntry'].')';
	// 		$responce_encode=$objKri->SampleIntimationUnderTestUpdateFromInventoryTransfer_kri($mainArray,$Final_API);
	// 		$responce=json_decode($responce_encode);

	// 		// echo "<pre>";
	// 		// print_r($responce);
	// 		// echo "</pre>";

	// 		// exit;

	// 	//  <!-- ------- service layer function responce manage Start Here ------------ -->
	// 		if(array_key_exists('error', (array)$responce)){
	// 			$data['status']='False';
	// 			$data['DocEntry']='';
	// 			$data['message']=$responce->error->message->value;
	// 			echo json_encode($data);
	// 		}else{
	// 			$data['status']='True';
	// 			$data['DocEntry']=$responce->DocEntry;
	// 			$data['message']='Sample Collection - Stability Added Successfully';
	// 			echo json_encode($data);
	// 		}
	// 	//  <!-- ------- service layer function responce manage End Here -------------- -->	
	// }


	// $res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	// exit(0);

	// echo "<pre>";
	// print_r($mainArray);
	// echo "</pre>";

	// exit();
	//    $ganaralData=array();
	//    $BL=0; //skip array avoid and count continue
	// for ($i=0; $i <count($_POST['pCode']) ; $i++) { 

	// 	$ganaralData['U_PCode']=trim(addslashes(strip_tags($_POST['pCode'][$i])));
	// 	$ganaralData['U_PName']=trim(addslashes(strip_tags($_POST['PName'][$i])));
	// 	$ganaralData['U_PDType']=trim(addslashes(strip_tags($_POST['PDType'][$i])));
	// 	$ganaralData['U_DDetail']=trim(addslashes(strip_tags($_POST['DesDetils'][$i])));
	// 	$ganaralData['U_Logical']=trim(addslashes(strip_tags($_POST['logical'][$i])));
	// 	$ganaralData['U_LowMin']=trim(addslashes(strip_tags($_POST['LowMin'][$i])));
	// 	$ganaralData['U_LowMax']=trim(addslashes(strip_tags($_POST['LowMax'][$i])));

	//           $ganaralData['U_UppMin']=trim(addslashes(strip_tags($_POST['UppMin'][$i])));
	//           $ganaralData['U_UppMax']=trim(addslashes(strip_tags($_POST['UppMax'][$i])));

	//           $ganaralData['U_Min']=trim(addslashes(strip_tags($_POST['Min'][$i])));

	// 	$ganaralData['U_LowMin1']=trim(addslashes(strip_tags($_POST['LowMinRes'][$i])));
	// 	// $ganaralData['U_LowMax1']=trim(addslashes(strip_tags($_POST['lower_max_result'][$i])));

	// 	$ganaralData['U_UppMin1']=trim(addslashes(strip_tags($_POST['UppMinRes'][$i])));
	// 	// $ganaralData['U_UppMax1']=trim(addslashes(strip_tags($_POST['UppMaxRes'][$i])));

	// 	$ganaralData['U_Min1']=trim(addslashes(strip_tags($_POST['MeanRes'][$i])));

	// 	$ganaralData['U_Remarks']=trim(addslashes(strip_tags($_POST['Remarks'][$i])));
	// 	$ganaralData['U_TMethod']=trim(addslashes(strip_tags($_POST['TMethod'][$i])));

	// 	$ganaralData['U_MType']=trim(addslashes(strip_tags($_POST['MType'][$i])));

	// 	$ganaralData['U_UText1']=trim(addslashes(strip_tags($_POST['UserText1'][$i])));
	// 	$ganaralData['U_UText2']=trim(addslashes(strip_tags($_POST['UserText2'][$i])));
	// 	$ganaralData['U_UText3']=trim(addslashes(strip_tags($_POST['UserText3'][$i])));
	// 	$ganaralData['U_UText4']=trim(addslashes(strip_tags($_POST['UserText4'][$i])));
	// 	$ganaralData['U_UText5']=trim(addslashes(strip_tags($_POST['UserText5'][$i])));

	// 	$ganaralData['U_QCRemark']=trim(addslashes(strip_tags($_POST['qCStsRemark1'][$i])));
	// 	$ganaralData['U_UOM']=trim(addslashes(strip_tags($_POST['UOM'][$i])));
	// 	$ganaralData['U_Retest']=trim(addslashes(strip_tags($_POST['Retest'][$i])));
	// 	$ganaralData['U_Stab']=trim(addslashes(strip_tags($_POST['Stability'][$i])));
	// 	$ganaralData['U_ExtrS']=trim(addslashes(strip_tags($_POST['ExSample'][$i])));
	// 	$ganaralData['U_AppAssay']=trim(addslashes(strip_tags($_POST['Appassay'][$i])));

	// 	$ganaralData['U_AppLOD']=trim(addslashes(strip_tags($_POST['AppLOD'][$i])));
	// 	$ganaralData['U_AnyBy']=trim(addslashes(strip_tags($_POST['AnalysisBy'][$i])));
	// 	$ganaralData['U_ARemark']=trim(addslashes(strip_tags($_POST['analyst_remark'][$i])));
	// 	$ganaralData['U_InsCode']=trim(addslashes(strip_tags($_POST['InstrumentCode'][$i])));
	// 	$ganaralData['U_InsName']=trim(addslashes(strip_tags($_POST['InstrumentName'][$i])));
	// 	$ganaralData['U_SDate']=trim(addslashes(strip_tags($_POST['StartDate'][$i])));

	// 	$ganaralData['U_STime']=trim(addslashes(strip_tags($_POST['StartTime'][$i])));
	// 	$ganaralData['U_EDate']=trim(addslashes(strip_tags($_POST['EndDate'][$i])));
	// 	$ganaralData['U_ETime']=trim(addslashes(strip_tags($_POST['EndTime'][$i])));
	// 	$ganaralData['U_QCStatus']=trim(addslashes(strip_tags($_POST['QC_StatusByAnalyst'][$i])));

	// 	$ganaralData['U_Standard']=trim(addslashes(strip_tags($_POST['Standard'][$i])));
	// 	$ganaralData['U_Release']=trim(addslashes(strip_tags($_POST['Release'][$i])));
	// 	$ganaralData['U_ROutput']=trim(addslashes(strip_tags($_POST['ResultOut'][$i])));

	// 		$tdata['SCS_QCPD1Collection'][]=$ganaralData;
	// 		$BL++; // increment variable define here

	// }


	// echo '<pre>';
	// print_r($tdata);
	// die();

	// $tdata['U_BLine']=trim(addslashes(strip_tags($_POST['LineNum'])));
	// $tdata['U_BPLId']=trim(addslashes(strip_tags($_POST['U_BPLId'])));
	// $tdata['U_LocCode']=trim(addslashes(strip_tags($_POST['U_LocCode'])));
	// $tdata['U_GRPONo']=trim(addslashes(strip_tags($_POST['GRPONo'])));

	// $tdata['U_GRPODEnt']=trim(addslashes(strip_tags($_POST['GRPODocEntry'])));
	// $tdata['U_SCode']=trim(addslashes(strip_tags($_POST['supplierCode'])));
	// $tdata['U_SName']=trim(addslashes(strip_tags($_POST['supplierName'])));
	// $tdata['U_ICode']=trim(addslashes(strip_tags($_POST['ItemCode'])));

	// $tdata['U_IName']=trim(addslashes(strip_tags($_POST['ItemName'])));
	// $tdata['U_GName']=trim(addslashes(strip_tags($_POST['GenericName'])));
	// $tdata['U_LClaim']=trim(addslashes(strip_tags($_POST['LabelClaim'])));
	// $tdata['U_LClmUom']=trim(addslashes(strip_tags($_POST['LabelClaimUOM'])));
	// $tdata['U_RQty']=trim(addslashes(strip_tags($_POST['GRNQty'])));
	// $tdata['U_MBy']=trim(addslashes(strip_tags($_POST['MfgBy'])));

	// $tdata['U_RBy']=trim(addslashes(strip_tags($_POST['RefNo'])));
	// $tdata['U_BNo']=trim(addslashes(strip_tags($_POST['BatchNo'])));
	// $tdata['U_BSize']=trim(addslashes(strip_tags($_POST['BatchQty'])));
	// $tdata['U_MfgDate']=trim(addslashes(strip_tags($_POST['MfgDate'])));
	// $tdata['U_ExpDate']=trim(addslashes(strip_tags($_POST['ExpiryDate'])));
	// $tdata['U_SIntNo']=trim(addslashes(strip_tags($_POST['SampleIntimationNo'])));
	// $tdata['U_SColNo']=trim(addslashes(strip_tags($_POST['SampleCollectionNo'])));
	// $tdata['U_SQty']=trim(addslashes(strip_tags($_POST['SampleQty'])));

	// $tdata['U_SamType']=trim(addslashes(strip_tags($_POST['SampleType'])));
	// $tdata['U_MType']=trim(addslashes(strip_tags($_POST['MaterialType'])));
	// $tdata['U_PDate']=trim(addslashes(strip_tags($_POST['PostingDate'])));
	// $tdata['U_ADate']=trim(addslashes(strip_tags($_POST['AnalysisDate'])));
	// $tdata['U_NoCont']=trim(addslashes(strip_tags($_POST['TNCont'])));
	// $tdata['U_QCTType']=trim(addslashes(strip_tags($_POST['QCTestType'])));
	// $tdata['U_Stage']=trim(addslashes(strip_tags($_POST['Stage'])));

	// $tdata['U_Branch']=trim(addslashes(strip_tags($_POST['BranchName'])));
	// $tdata['U_ValUp']=trim(addslashes(strip_tags($_POST['validUpTo'])));

	// $tdata['U_ArNo']=trim(addslashes(strip_tags($_POST['ARNo'])));
	// $tdata['U_GENo']=trim(addslashes(strip_tags($_POST['gate_entry_no'])));

	// $tdata['U_GDEntry']=trim(addslashes(strip_tags($_POST['U_GDEntry'])));

	// $tdata['U_APot']=trim(addslashes(strip_tags($_POST['AssayPotency'])));
	// $tdata['U_LODWater']=trim(addslashes(strip_tags($_POST['LoD_Water'])));

	// $tdata['U_CompBy']=trim(addslashes(strip_tags($_POST['qc_post_compiled_by'])));
	// $tdata['U_NoCont1']=trim(addslashes(strip_tags($_POST['noOfCont1'])));
	// $tdata['U_NoCont2']=trim(addslashes(strip_tags($_POST['noOfCont2'])));
	// $tdata['U_ChkBy']=trim(addslashes(strip_tags($_POST['checked_by'])));
	// $tdata['U_AnlBy']=trim(addslashes(strip_tags($_POST['analysis_by'])));

	// $tdata['U_Remarks']=trim(addslashes(strip_tags($_POST['qc_remarks'])));

	// $tdata['U_AsyCal']=trim(addslashes(strip_tags($_POST['assay_append'])));
	// $tdata['U_Factor']=trim(addslashes(strip_tags($_POST['factor'])));

	// $tdata['U_SpcNo']=trim(addslashes(strip_tags($_POST['SpecfNo'])));
	// $tdata['U_GRQty']=trim(addslashes(strip_tags($_POST['U_GRQty'])));
	// $tdata['U_PckSize']=trim(addslashes(strip_tags($_POST['PackSize'])));
	// $tdata['U_Potency']=trim(addslashes(strip_tags($_POST['Potency'])));
	// $tdata['U_RelDt']=trim(addslashes(strip_tags($_POST['U_RelDt'])));
	// $tdata['U_RetstDt']=trim(addslashes(strip_tags($_POST['U_RetstDt'])));
	// $tdata['U_Loc']=trim(addslashes(strip_tags($_POST['Location'])));
	// $tdata['U_RMQC']=trim(addslashes(strip_tags($_POST['U_RMQC'])));

	// //   // $tdata['SCS_QCPD1Collection']=;
	//     $ganaralData=array();
	//     $BL=0; //skip array avoid and count continue
	// 	for ($i=0; $i <count($_POST['pCode']) ; $i++) { 

	// 		$ganaralData['U_PCode']=trim(addslashes(strip_tags($_POST['pCode'][$i])));
	// 		$ganaralData['U_PName']=trim(addslashes(strip_tags($_POST['PName'][$i])));
	// 		$ganaralData['U_PDType']=trim(addslashes(strip_tags($_POST['PDType'][$i])));
	// 		$ganaralData['U_DDetail']=trim(addslashes(strip_tags($_POST['DesDetils'][$i])));
	// 		$ganaralData['U_Logical']=trim(addslashes(strip_tags($_POST['logical'][$i])));
	// 		$ganaralData['U_LowMin']=trim(addslashes(strip_tags($_POST['LowMin'][$i])));
	// 		$ganaralData['U_LowMax']=trim(addslashes(strip_tags($_POST['LowMax'][$i])));

	//            $ganaralData['U_UppMin']=trim(addslashes(strip_tags($_POST['UppMin'][$i])));
	//            $ganaralData['U_UppMax']=trim(addslashes(strip_tags($_POST['UppMax'][$i])));

	//            $ganaralData['U_Min']=trim(addslashes(strip_tags($_POST['Min'][$i])));

	// 		$ganaralData['U_LowMin1']=trim(addslashes(strip_tags($_POST['LowMinRes'][$i])));
	// 		// $ganaralData['U_LowMax1']=trim(addslashes(strip_tags($_POST['lower_max_result'][$i])));

	// 		$ganaralData['U_UppMin1']=trim(addslashes(strip_tags($_POST['UppMinRes'][$i])));
	// 		// $ganaralData['U_UppMax1']=trim(addslashes(strip_tags($_POST['UppMaxRes'][$i])));

	// 		$ganaralData['U_Min1']=trim(addslashes(strip_tags($_POST['MeanRes'][$i])));

	// 		$ganaralData['U_Remarks']=trim(addslashes(strip_tags($_POST['Remarks'][$i])));
	// 		$ganaralData['U_TMethod']=trim(addslashes(strip_tags($_POST['TMethod'][$i])));

	// 		$ganaralData['U_MType']=trim(addslashes(strip_tags($_POST['MType'][$i])));

	// 		$ganaralData['U_UText1']=trim(addslashes(strip_tags($_POST['UserText1'][$i])));
	// 		$ganaralData['U_UText2']=trim(addslashes(strip_tags($_POST['UserText2'][$i])));
	// 		$ganaralData['U_UText3']=trim(addslashes(strip_tags($_POST['UserText3'][$i])));
	// 		$ganaralData['U_UText4']=trim(addslashes(strip_tags($_POST['UserText4'][$i])));
	// 		$ganaralData['U_UText5']=trim(addslashes(strip_tags($_POST['UserText5'][$i])));

	// 		$ganaralData['U_QCRemark']=trim(addslashes(strip_tags($_POST['qCStsRemark1'][$i])));
	// 		$ganaralData['U_UOM']=trim(addslashes(strip_tags($_POST['UOM'][$i])));
	// 		$ganaralData['U_Retest']=trim(addslashes(strip_tags($_POST['Retest'][$i])));
	// 		$ganaralData['U_Stab']=trim(addslashes(strip_tags($_POST['Stability'][$i])));
	// 		$ganaralData['U_ExtrS']=trim(addslashes(strip_tags($_POST['ExSample'][$i])));
	// 		$ganaralData['U_AppAssay']=trim(addslashes(strip_tags($_POST['Appassay'][$i])));

	// 		$ganaralData['U_AppLOD']=trim(addslashes(strip_tags($_POST['AppLOD'][$i])));
	// 		$ganaralData['U_AnyBy']=trim(addslashes(strip_tags($_POST['AnalysisBy'][$i])));
	// 		$ganaralData['U_ARemark']=trim(addslashes(strip_tags($_POST['analyst_remark'][$i])));
	// 		$ganaralData['U_InsCode']=trim(addslashes(strip_tags($_POST['InstrumentCode'][$i])));
	// 		$ganaralData['U_InsName']=trim(addslashes(strip_tags($_POST['InstrumentName'][$i])));
	// 		$ganaralData['U_SDate']=trim(addslashes(strip_tags($_POST['StartDate'][$i])));

	// 		$ganaralData['U_STime']=trim(addslashes(strip_tags($_POST['StartTime'][$i])));
	// 		$ganaralData['U_EDate']=trim(addslashes(strip_tags($_POST['EndDate'][$i])));
	// 		$ganaralData['U_ETime']=trim(addslashes(strip_tags($_POST['EndTime'][$i])));
	// 		$ganaralData['U_QCStatus']=trim(addslashes(strip_tags($_POST['QC_StatusByAnalyst'][$i])));

	// 		$ganaralData['U_Standard']=trim(addslashes(strip_tags($_POST['Standard'][$i])));
	// 		$ganaralData['U_Release']=trim(addslashes(strip_tags($_POST['Release'][$i])));
	// 		$ganaralData['U_ROutput']=trim(addslashes(strip_tags($_POST['ResultOut'][$i])));

	// 			$tdata['SCS_QCPD1Collection'][]=$ganaralData;
	// 			$BL++; // increment variable define here

	// 	}

	//       $qcStatus=array();
	//        $qcS=0; //skip array avoid and count continue
	// 	for ($j=0; $j <count($_POST['qc_Status']) ; $j++) { 

	// 		$qcStatus['U_Status']=trim(addslashes(strip_tags($_POST['qc_Status'][$j])));
	// 		$qcStatus['U_Quantity']=trim(addslashes(strip_tags($_POST['qCStsQty'][$j])));
	// 		$qcStatus['U_ITNo']=trim(addslashes(strip_tags($_POST['qCitNo'][$j])));
	// 		$qcStatus['U_DBy']=trim(addslashes(strip_tags($_POST['doneBy'][$j])));
	// 		$qcStatus['U_Remarks1']=trim(addslashes(strip_tags($_POST['qCStsRemark1'][$j])));

	// 		$qcStatus['U_RelDt']='';
	// 		$qcStatus['U_Attch1']='';
	// 		$qcStatus['U_Attch2']='';
	// 		$qcStatus['U_Attch3']='';
	// 		$qcStatus['U_DevDt']='';
	// 		$qcStatus['U_DevNo']='';
	// 		$qcStatus['U_DevRsn']='';

	// 		$tdata['SCS_QCPD2Collection'][]=$qcStatus;
	//          $qcS++;

	// 	}

	// 	 $qcAttech=array();
	//        $qcatt=0; //skip array avoid and count continue
	// 	for ($k=0; $k <count($_POST['targetPath']) ; $k++) { 

	// 		$qcAttech['U_TrgtPath']=trim(addslashes(strip_tags($_POST['targetPath'][$k])));
	// 		$qcAttech['U_FileName']=trim(addslashes(strip_tags($_POST['fileName'][$k])));
	// 		$qcAttech['U_AtchDate']=trim(addslashes(strip_tags($_POST['attachDate'][$k])));
	// 		$qcAttech['U_FreeText']=trim(addslashes(strip_tags($_POST['freeText'][$k])));


	// 		$tdata['SCS_QCPD3Collection'][]=$qcAttech;
	//          $qcatt++;

	// 	}

	// 	$mainArray=$tdata;

	//        $res=$obj->SAP_Login();

	//        if(!empty($res)){
	// 		$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$api_SCS_QCPD;
	// 		$responce_encode=$objKri->qcPostDocument($mainArray,$Final_API);
	// 		$responce=json_decode($responce_encode);

	// 	//  <!-- ------- service layer function responce manage Start Here ------------ -->
	// 		if(array_key_exists('error', (array)$responce)){
	// 			$data['status']='False';
	// 			$data['DocEntry']='';
	// 			$data['message']=$responce->error->message->value;
	// 			echo json_encode($data);
	// 		}else{
	// 			$data['status']='True';
	// 			$data['DocEntry']=$responce->DocEntry;
	// 			$data['message']='QC Post Document Added Successfully';
	// 			echo json_encode($data);
	// 		}
	// 	//  <!-- ------- service layer function responce manage End Here -------------- -->	
	// }


	// $res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
}



if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransferSamplessue_stability_ajax') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));
	$API = $STABSAMPCOLAFTERADD_API . '?DocEntry=' . $DocEntry;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	$FinalResponce['DataDetails'] = $response;

	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {
		$FinalResponce['option'] = '<tr>
				<td class="desabled">
					<input type="text" id="it_DocEntry" name="it_DocEntry" value="' . $response[0]->DocEntry . '">
					<input type="text" id="it_BatchNo" name="it_BatchNo" value="' . $response[0]->BatchNo . '">
					1
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_ItemCode" name="itP_ItemCode" class="form-control" value="' . $response[0]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
				 <input class="border_hide textbox_bg" type="text" id="itP_ItemName" name="itP_ItemName" class="form-control" value="' . $response[0]->ItemName . '" readonly>
				
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg1" type="text" id="itP_BQty" name="itP_BQty" class="form-control" value="' . $response[0]->BatchQty . '" >
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_FromWhs" name="itP_FromWhs" class="form-control" value="' . $response[0]->FromWhse . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_ToWhs" name="itP_ToWhs" class="form-control" value="' . $response[0]->ToWhse . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_Loction" name="itP_Loction" class="form-control" value="' . $response[0]->Location . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_RetainQtyUom" name="itP_RetainQtyUom" class="form-control" value="' . $response[0]->RetainQtyUom . '" readonly>
				</td>
			</tr>';
	} else {
		$FinalResponce['option'] = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}



	// ============================Container Selection================================================

	$API_container = $STABILITYSAMCOLLCONTSEL . '?ItemCode=' . $response[0]->ItemCode . '&WareHouse=' . $response[0]->ToWhse . '&BatchNo=' . $response[0]->BatchNo;

	// $API_container='http://10.80.4.55:8081/API/SAP/STABILITYSAMCOLLCONTSEL?ItemCode=FG00001&WareHouse=DSPT-GEN&BatchNo=C0121197';

	$FinalAPI_container = str_replace(' ', '%20', $API_container); // All blank space replace to %20

	// <!--------------- Preparing API End Here ------------------------------------------ -->

	$response_container = $obj->get_OTFSI_SingleData($FinalAPI_container);

	// echo "<pre>";
	// print_r($response_container);
	// echo "</pre>";
	// exit;

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response_container)) {
		for ($i = 0; $i < count($response_container); $i++) {
			// ----------- Date formating condition definr start here---------------------------
			if (!empty($response_container[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response_container[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response_container[$i]->ExpDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response_container[$i]->ExpDate));
			} else {
				$ExpiryDate = '';
			}

			// ----------- Date formating condition definr end here-----------------------------
			$FinalResponce['containerSelection'] .= '
			<tr>
				<td style="text-align: center;">
					<input type="text" id="usercheckList' . $i . '" name="usercheckList[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response_container[$i]->BatchQty . '" id="itp_CS' . $i . '" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener(' . $i . ')">
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode' . $i . '" name="itp_ItemCode[]" class="form-control" value="' . $response_container[$i]->ItemCode . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName' . $i . '" name="itp_ItemName[]" class="form-control" value="' . $response_container[$i]->ItemName . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo' . $i . '" name="itp_ContainerNo[]" class="form-control" value="' . $response_container[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche' . $i . '" name="itp_Batch[]" class="form-control" value="' . $response_container[$i]->BatchNum . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty' . $i . '" name="itp_BatchQty[]" class="form-control" value="' . $response_container[$i]->BatchQty . '" readonly>
				</td>
				<td>
					<input class="border_hide" type="text" id="SelectedQty' . $i . '" name="SelectedQty[]" class="form-control" value="' . $response_container[$i]->BatchQty . '" onfocusout="EnterQtyValidation_GI(' . $i . ')">
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate' . $i . '" name="itp_MfgDate[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate' . $i . '" name="itp_ExpiryDate[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$FinalResponce['containerSelection'] .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum" name="cs_selectedQtySum" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$FinalResponce['containerSelection'] = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}

	// 

	// echo "<pre>";
	// print_r($FinalResponce);
	// echo "</pre>";
	// exit;
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($FinalResponce);
	exit(0);
}



if (isset($_POST['SubIT_Btn_S_sample_issue_sampleCollection_stability'])) {
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;
	$tdata['DocType'] = 'dDocument_Items';
	$tdata['DocDate'] = date("Y-m-d", strtotime($_POST['stability_PostingDate']));
	$tdata['DocDueDate'] = date("Y-m-d", strtotime($_POST['stability_DocumentDate']));
	$tdata['Series'] = trim(addslashes(strip_tags($_POST['stability_Series'])));
	$tdata['TaxDate'] = date("Y-m-d", strtotime($_POST['stability_DocumentDate']));
	$tdata['DocObjectCode'] = 'oInventoryGenExit';
	$tdata['U_PC_SCIProc'] = trim(addslashes(strip_tags($_POST['stability_DocEntry'])));
	// $tdata['U_PC_SCRtest']=trim(addslashes(strip_tags($_POST['SCRTQC_GI_SCRTQCB_DocEntry'])));
	$tdata['U_BFType'] = trim(addslashes(strip_tags($_POST['stability_BaseDocType'])));
	$tdata['BPL_IDAssignedToInvoice'] = trim(addslashes(strip_tags($_POST['stability_BPLId'])));

	// $tdata['CardCode']=trim(addslashes(strip_tags($_POST['GI_supplierCode'])));
	// $tdata['Comments']=null;
	// $tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
	// $tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['GI_to_whs'])));
	// $tdata['BPLID']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId_samIss'])));
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$mainArray = $tdata;
	// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum'] = trim(addslashes(strip_tags('0')));
	$item['ItemCode'] = trim(addslashes(strip_tags($_POST['itP_ItemCode'])));
	$item['Quantity'] = trim(addslashes(strip_tags($_POST['itP_BQty'])));
	$item['WarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
	// $item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST[itP_ToWhs'GI_from_whs'])));
	// <!-- Item Batch row data prepare start here ----------- -->
	// $BL = 0;
	for ($i = 0; $i < count($_POST['usercheckList']); $i++) {

		if ($_POST['usercheckList'][$i] == '1') {

			$batch['BatchNumber'] = trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
			$batch['Quantity'] = trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
			$batch['BaseLineNumber'] = trim(addslashes(strip_tags('0')));
			$batch['ItemCode'] = trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));
			$item['BatchNumbers'][] = $batch;
			// $BL++;
		}
	}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['DocumentLines'][] = $item;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->
	// echo json_encode($mainArray);
	// exit;
	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
	// echo json_encode($mainArray);
	// exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here
	if (!empty($res)) {
		$Final_API = $API_InventoryGenExits;

		$responce_encode = $obj->SaveSampleIntimation($mainArray, $Final_API);
		$responce = json_decode($responce_encode);
		// echo "<pre>";
		// 	print_r($Final_API);
		// 	echo "<pre>";
		// 	exit;
		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {

			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['stability_DocEntry'])));
			$UT_data['U_PC_SIssue'] = trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SCOLSTAB . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			if ($underTestNumber_decode == '') {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Inventory Transfer Successfully Added.";
				echo json_encode($data);
			} else {
				// $data['status']='False';
				// $data['DocEntry']='';
				// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
				// echo json_encode($data);

				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if (isset($_POST['action']) && $_POST['action'] == 'SC_OpenInventoryTransfer_stabilitys_ajax') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $STABSAMPCOLAFTERADD_API . '?DocEntry=' . $DocEntry;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// print_r($FinalAPI);die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;
	$FinalResponce['DataDetails'] = $response;
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {
		$FinalResponce['option'] = '<tr>
				<td class="desabled">
					<input type="text" id="U_GRPODEnt" name="U_GRPODEnt" value="' . $response[0]->DocEntry . '">
					<input type="text" id="U_BPLId_t" name="U_BPLId_t" value="' . $response[0]->BPLId . '">
					<input type="text" id="U_BNo" name="U_BNo" value="' . $response[0]->BatchNo . '">

					1
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_ItemCode" name="itP_ItemCode" class="form-control" value="' . $response[0]->ItemCode . '" readonly>
				</td>

				<td class="desabled">' . $response[0]->ItemName . '</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_BQty" name="itP_BQty" class="form-control" value="' . $response[0]->BatchQty . '" readonly>
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_FromWhs" name="itP_FromWhs" class="form-control" value="' . $response[0]->FromWhse . '" readonly>
					
				</td>
               <td class="desabled">
               <input class="border_hide textbox_bg" type="hidden" id="itP_ToWhs" name="itP_ToWhs" class="form-control" value="' . $response[0]->ToWhse . '" readonly>
               </td>

                <td class="desabled">
               <input class="border_hide textbox_bg" type="text" id="itP_location" name="itP_location" class="form-control" value="' . $response[0]->Location . '" readonly>
               </td>

				
				
				<td class="desabled">' . $response[0]->SampleUnit . '</td>
			</tr>';
	} else {
		$FinalResponce['option'] = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}





	$API_container = $STABILITYSAMCOLLCONTSEL . '?ItemCode=' . $response[0]->ItemCode . '&WareHouse=' . $response[0]->ToWhse . '&BatchNo=' . $response[0]->BatchNo;
	// $API_container='http://10.80.4.55:8081/API/SAP/STABILITYSAMCOLLCONTSEL?ItemCode=FG00001&WareHouse=DSPT-GEN&BatchNo=C0121197';
	$FinalAPI_container = str_replace(' ', '%20', $API_container); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->
	$response_container = $obj->get_OTFSI_SingleData($FinalAPI_container);

	// echo "<pre>";
	// print_r($response_container);
	// echo "</pre>";
	// exit;
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response_container)) {
		for ($i = 0; $i < count($response_container); $i++) {
			// ----------- Date formating condition definr start here---------------------------
			if (!empty($response_container[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response_container[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response_container[$i]->ExpDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response_container[$i]->ExpDate));
			} else {
				$ExpiryDate = '';
			}

			// ----------- Date formating condition definr end here-----------------------------
			$FinalResponce['containerSelection'] .= '
			<tr>
				<td style="text-align: center;">
					<input type="text" id="usercheckList' . $i . '" name="usercheckList[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response_container[$i]->BatchQty . '" id="itp_CS' . $i . '" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener_tranfer(' . $i . ')">
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode' . $i . '" name="itp_ItemCode[]" class="form-control" value="' . $response_container[$i]->ItemCode . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName' . $i . '" name="itp_ItemName[]" class="form-control" value="' . $response_container[$i]->ItemName . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo' . $i . '" name="itp_ContainerNo[]" class="form-control" value="' . $response_container[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche' . $i . '" name="itp_Batch[]" class="form-control" value="' . $response_container[$i]->BatchNum . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty' . $i . '" name="itp_BatchQty[]" class="form-control" value="' . $response_container[$i]->BatchQty . '" readonly>
				</td>
				<td>
					<input class="border_hide" type="text" id="SelectedQty' . $i . '" name="SelectedQty[]" class="form-control" value="' . $response_container[$i]->BatchQty . '" onfocusout="EnterQtyValidation_GI_tranfer(' . $i . ')">
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate' . $i . '" name="itp_MfgDate[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate' . $i . '" name="itp_ExpiryDate[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$FinalResponce['containerSelection'] .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum" name="cs_selectedQtySum" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$FinalResponce['containerSelection'] = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}

	// 


	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($FinalResponce);
	exit(0);
}





if (isset($_POST['SubIT_Btn_transfer_sampleCollection_stability'])) {
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data

	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['stabl_Series'])));
	$tdata['DocDate'] = date("Y-m-d", strtotime($_POST['stabl_PostingDate']));
	$tdata['DueDate'] = date("Y-m-d", strtotime($_POST['stabl_DocumentDate']));

	$tdata['CardCode'] = trim(addslashes(strip_tags($_POST['stabl_supplier_code'])));
	$tdata['Comments'] = null;
	$tdata['FromWarehouse'] = trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
	$tdata['ToWarehouse'] = trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
	$tdata['TaxDate'] = date("Y-m-d", strtotime($_POST['stabl_DocumentDate']));
	$tdata['DocObjectCode'] = '67';
	$tdata['BPLID'] = trim(addslashes(strip_tags($_POST['U_BPLId_t'])));
	$tdata['U_PC_SISTAB'] = trim(addslashes(strip_tags($_POST['U_GRPODEnt'])));
	$tdata['U_BFType'] = trim(addslashes(strip_tags($_POST['stabl_BaseDocType'])));
	// $tdata['DocType']='dDocument_Items';
	// $tdata['U_PC_SCIProc']=trim(addslashes(strip_tags($_POST['stability_DocEntry'])));
	// $tdata['U_PC_SCRtest']=trim(addslashes(strip_tags($_POST['SCRTQC_GI_SCRTQCB_DocEntry'])));
	// $tdata['U_BFType']=trim(addslashes(strip_tags($_POST['stability_BaseDocType'])));
	// $tdata['BPL_IDAssignedToInvoice']=trim(addslashes(strip_tags($_POST['stability_BPLId'])));
	// $tdata['CardCode']=trim(addslashes(strip_tags($_POST['GI_supplierCode'])));
	// $tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
	// $tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['GI_to_whs'])));
	// $tdata['BPLID']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId_samIss'])));
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$mainArray = $tdata;
	// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum'] = trim(addslashes(strip_tags('0')));
	$item['ItemCode'] = trim(addslashes(strip_tags($_POST['itP_ItemCode'])));
	$item['Quantity'] = trim(addslashes(strip_tags($_POST['itP_BQty'])));
	$item['WarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
	$item['FromWarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_FromWhs'])));

	// <!-- Item Batch row data prepare start here ----------- -->
	$BL = 0;
	for ($i = 0; $i < count($_POST['usercheckList']); $i++) {

		if ($_POST['usercheckList'][$i] == '1') {

			$batch['BatchNumber'] = trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
			$batch['Quantity'] = trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
			$batch['BaseLineNumber'] = trim(addslashes(strip_tags('0')));
			$batch['ItemCode'] = trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));
			$item['BatchNumbers'][] = $batch;
			$BL++;
		}
	}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['StockTransferLines'][] = $item;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->
	// echo json_encode($mainArray);
	// exit;
	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
	// echo json_encode($mainArray);
	// exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here
	if (!empty($res)) {
		// $Final_API=$API_StockTransfers;
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_StockTransfers;
		$responce_encode = $obj->SaveSampleIntimation($mainArray, $Final_API);
		$responce = json_decode($responce_encode);
		// echo "<pre>";
		// 	print_r($Final_API);
		// 	echo "<pre>";
		// 	exit;
		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {

			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['U_GRPODEnt'])));
			$UT_data['U_PC_UTTrans'] = trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SISTAB_API . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			if ($underTestNumber_decode == '') {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Inventory Transfer Successfully Added.";
				echo json_encode($data);
			} else {
				// $data['status']='False';
				// $data['DocEntry']='';
				// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
				// echo json_encode($data);

				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}




if (isset($_POST['addQcPostDocumentSubmitQCCheckFinishesGoodaBtn'])) {
	$tdata = array(); // This array send to AP Standalone Invoice process 
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;
	$tdata['DocNum'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_DocNum'])));
	$tdata['Remark'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_Remarks'])));

	$tdata['Object'] = trim(addslashes(strip_tags('SCS_QCPDFG')));
	$tdata['U_PC_BLin'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_DocNo'])));

	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_BranchID'])));
	$tdata['U_PC_LocCode'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_LocCode'])));

	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_Loc'])));
	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_Branch'])));
	$tdata['U_PC_RNo'] = null;
	$tdata['U_PC_REnt'] = null;
	$tdata['U_PC_WoNo'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_WONo'])));

	// ---


	$tdata['U_PC_WoEnt'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_WOEntry'])));

	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_ItemCode'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_ItemName'])));

	$tdata['U_PC_GName'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_GenericName'])));
	$tdata['U_PC_LClaim'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_LabelCliam'])));
	$tdata['U_PC_LClmUom'] = null;
	$tdata['U_PC_RecQty'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_RecievedQty'])));

	$tdata['U_PC_MfgBy'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_MfgBy'])));

	$tdata['U_PC_RfBy'] = null;
	$tdata['U_PC_SType'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_SampleType'])));

	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_BatchNo'])));

	$tdata['U_PC_BSize'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_BatchSize'])));

	$tdata['U_PC_MfgDt'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_MfgDate'])));
	$tdata['U_PC_ExpDt'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_ExpiryDate'])));


	$tdata['U_PC_SIntNo'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_SampleIntimationNo'])));
	$tdata['U_PC_SColNo'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_SampleCollectionNo'])));
	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_SampleQty'])));
	$tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_RetainQty'])));


	$tdata['U_PC_PckSize'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_PackSize'])));

	$tdata['U_PC_SamType'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_SampleType'])));

	$tdata['U_PC_MType'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_MaterialType'])));
	// -/-
	$tdata['U_PC_PDate'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_PostingDate'])));

	$tdata['U_PC_ADate'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_AnalysisDate'])));


	$tdata['U_PC_NoCont'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_NoOfContainer'])));

	$tdata['U_PC_QCTType'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_QCTesttype'])));
	$tdata['U_PC_Stage'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_Stage'])));

	$tdata['U_PC_ValUp'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_ValidUpTo'])));

	$tdata['U_PC_ArNo'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_ARNo'])));

	$tdata['U_PC_GENo'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_GateENo'])));
	$tdata['U_PC_GDEntry'] = null;

	$tdata['U_PC_APot'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_AssayPotency'])));

	$tdata['U_PC_LODWater'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_LODWater'])));
	$tdata['U_PC_Potency'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_Potency'])));
	$tdata['U_PC_CompBy'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_CompiledBy'])));
	$tdata['U_PC_NoCont1'] = null;
	$tdata['U_PC_NoCont2'] = null;
	$tdata['U_PC_ChkBy'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_CheckedBy'])));

	$tdata['U_PC_AnlBy'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_AnalysisBy'])));

	$tdata['U_PC_Remarks'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_Remarks'])));

	$tdata['U_PC_AsyCal'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_AssayCalc'])));

	$tdata['U_PC_Factor'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_Factor'])));

	$tdata['U_PC_SpcNo'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_SpecfNo'])));

	$tdata['U_PC_GRQty'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_GRQty'])));

	$tdata['U_PC_RelDt'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_RelDate'])));

	$tdata['U_PC_RetstDt'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_ReTsDt'])));

	$tdata['U_PC_RMQC'] = trim(addslashes(strip_tags($_POST['QC_P_DOC_FG_RMWQC'])));
	// ==
	// $tdata['U_PC_GRNNo']=null;
	// $tdata['U_PC_GRNEnt']=null;
	// $tdata['U_PC_SCode']=null;
	// $tdata['U_PC_SName']=null;
	// $tdata['U_PC_MBy']=trim(addslashes(strip_tags($_POST['qc_Check_Mfg_By'])));
	// $tdata['U_PC_RBy']=null;
	// $tdata['U_PckSize']=trim(addslashes(strip_tags($_POST['qcD_PckSize'])));
	// trim(addslashes(strip_tags($_POST['qc_Check_LineNum'])))
	$ganaralData = array();
	$BL = 0; //skip array avoid and count continue
	for ($i = 0; $i < count($_POST['parameter_code']); $i++) {
		$ganaralData['LineId'] = 0;
		$ganaralData['Object'] = trim(addslashes(strip_tags('SCS_QCINPROC')));

		$ganaralData['U_PC_PCode'] = trim(addslashes(strip_tags($_POST['parameter_code'][$i])));
		$ganaralData['U_PC_PName'] = trim(addslashes(strip_tags($_POST['PName'][$i])));
		$ganaralData['U_PC_Std'] = trim(addslashes(strip_tags($_POST['Standard'][$i])));
		$ganaralData['U_PC_Rel'] = trim(addslashes(strip_tags($_POST['Release'][$i])));


		$ganaralData['U_PC_PDTyp'] = trim(addslashes(strip_tags($_POST['PDType'][$i])));
		$ganaralData['U_PC_DDtl'] = trim(addslashes(strip_tags($_POST['descriptive_details'][$i])));
		$ganaralData['U_PC_Logi'] = trim(addslashes(strip_tags($_POST['logical'][$i])));

		$ganaralData['U_PC_LwMin'] = trim(addslashes(strip_tags($_POST['LowMin'][$i])));

		$ganaralData['U_PC_LwMax'] = trim(addslashes(strip_tags($_POST['LowMax'][$i])));

		$ganaralData['U_PC_UpMin'] = trim(addslashes(strip_tags($_POST['UppMin'][$i])));

		$ganaralData['U_PC_UpMax'] = trim(addslashes(strip_tags($_POST['UppMax'][$i])));

		$ganaralData['U_PC_Min'] = trim(addslashes(strip_tags($_POST['Min'][$i])));

		$ganaralData['U_PC_LMin1'] = trim(addslashes(strip_tags($_POST['lower_min_result'][$i])));

		$ganaralData['U_PC_LMax1'] = trim(addslashes(strip_tags($_POST['lower_max_result'][$i])));

		$ganaralData['U_PC_UMin1'] = trim(addslashes(strip_tags($_POST['upper_min_result'][$i])));

		$ganaralData['U_PC_UMax1'] = trim(addslashes(strip_tags($_POST['upper_max_result'][$i])));

		$ganaralData['U_PC_Min1'] = trim(addslashes(strip_tags($_POST['mean'][$i])));
		$ganaralData['U_PC_Rotpt'] = trim(addslashes(strip_tags($_POST['result_output'][$i])));

		$ganaralData['U_PC_Rmrks'] = trim(addslashes(strip_tags($_POST['remarks'][$i])));
		$ganaralData['U_PC_QCSts'] = trim(addslashes(strip_tags($_POST['GDQCStatus'][$i])));

		$ganaralData['U_PC_TMeth'] = trim(addslashes(strip_tags($_POST['TMethod'][$i])));

		$ganaralData['U_PC_MType'] = trim(addslashes(strip_tags($_POST['MType'][$i])));
		$ganaralData['U_PC_PhStd'] = null;

		$ganaralData['U_PC_UTxt1'] = trim(addslashes(strip_tags($_POST['user_text1_'][$i])));
		$ganaralData['U_PC_UTxt2'] = trim(addslashes(strip_tags($_POST['user_text2_'][$i])));
		$ganaralData['U_PC_UTxt3'] = trim(addslashes(strip_tags($_POST['user_text3_'][$i])));
		$ganaralData['U_PC_UTxt4'] = trim(addslashes(strip_tags($_POST['user_text4_'][$i])));
		$ganaralData['U_PC_UTxt5'] = trim(addslashes(strip_tags($_POST['user_text5_'][$i])));

		$ganaralData['U_PC_QCRmk'] = trim(addslashes(strip_tags($_POST['qCStsRemark1'][$i])));

		$ganaralData['U_PC_UOM'] = trim(addslashes(strip_tags($_POST['GDUOM'][$i])));

		$ganaralData['U_PC_Rtst'] = trim(addslashes(strip_tags($_POST['Retest'][$i])));

		$ganaralData['U_PC_Stab'] = trim(addslashes(strip_tags($_POST['GDStab'][$i])));

		$ganaralData['U_PC_ExtrS'] = trim(addslashes(strip_tags($_POST['ExSample'][$i])));

		$ganaralData['U_PC_ApAsy'] = trim(addslashes(strip_tags($_POST['Appassay'][$i])));

		$ganaralData['U_PC_ApLOD'] = trim(addslashes(strip_tags($_POST['AppLOD'][$i])));

		$ganaralData['U_PC_AnyBy'] = trim(addslashes(strip_tags($_POST['qc_analysis_by'][$i])));

		$ganaralData['U_PC_ARmrk'] = trim(addslashes(strip_tags($_POST['analyst_remark'][$i])));

		$ganaralData['U_PC_InCod'] = trim(addslashes(strip_tags($_POST['instrument_code'][$i])));

		$ganaralData['U_PC_InNam'] = trim(addslashes(strip_tags($_POST['InsName'][$i])));

		$ganaralData['U_PC_SDt'] = trim(addslashes(strip_tags($_POST['star_date'][$i])));

		$ganaralData['U_PC_STime'] = trim(addslashes(strip_tags($_POST['start_time'][$i])));

		$ganaralData['U_PC_EDate'] = trim(addslashes(strip_tags($_POST['end_date'][$i])));
		$ganaralData['U_PC_ETime'] = trim(addslashes(strip_tags($_POST['end_time'][$i])));

		$tdata['SCS_QCPDFG1Collection'][] = $ganaralData; // row data append on this array
		$BL++; // increment variable define here	
	}

	$qcStatus = array();
	$qcS = 0; //skip array avoid and count continue
	for ($j = 0; $j < count($_POST['qc_Status']); $j++) {
		$qcStatus['LineId'] = 0;
		$qcStatus['Object'] = trim(addslashes(strip_tags('SCS_QCINPROC')));

		$qcStatus['U_PC_Stus'] = trim(addslashes(strip_tags($_POST['qc_Status'][$j])));
		$qcStatus['U_PC_Qty'] = trim(addslashes(strip_tags($_POST['qCStsQty'][$j])));
		$qcStatus['U_PC_RelDt'] = '';

		$qcStatus['U_PC_ITNo'] = trim(addslashes(strip_tags($_POST['qCitNo'][$j])));
		$qcStatus['U_PC_DBy'] = trim(addslashes(strip_tags($_POST['doneBy'][$j])));
		$qcStatus['U_PC_Rmrk1'] = trim(addslashes(strip_tags($_POST['qCStsRemark1'][$j])));

		$qcStatus['U_PC_Atch1'] = '';
		$qcStatus['U_PC_Atch2'] = '';
		$qcStatus['U_PC_Atch3'] = '';
		$qcStatus['U_PC_DvDt'] = '';
		$qcStatus['U_PC_DvNo'] = '';
		$qcStatus['U_PC_DvRsn'] = '';


		$tdata['SCS_QCPDFG2Collection'][] = $qcStatus; // row data append on this array
		$qcS++;
	}

	$qcAttech = array();
	$qcatt = 0; //skip array avoid and count continue
	for ($k = 0; $k < count($_POST['targetPath']); $k++) {
		$qcAttech['LineId'] = trim(addslashes(strip_tags($_POST['targetPath'][$k])));
		$qcAttech['Object'] = trim(addslashes(strip_tags('SCS_QCINPROC')));

		$qcAttech['U_PC_TrgPt'] = trim(addslashes(strip_tags($_POST['targetPath'][$k])));
		$qcAttech['U_PC_FName'] = trim(addslashes(strip_tags($_POST['fileName'][$k])));
		$qcAttech['U_PC_AtcDt'] = trim(addslashes(strip_tags($_POST['attachDate'][$k])));
		$qcAttech['U_PC_FText'] = trim(addslashes(strip_tags($_POST['freeText'][$k])));

		$tdata['SCS_QCPDFG3Collection'][] = $qcAttech; // row data append on this array
		$qcatt++;
	}

	$mainArray = $tdata; // all child array append in main array define here

	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;

	if ($_POST['QC_P_DOC_FG_SampleType'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Sample Type is required.';
		echo json_encode($data);
		exit;
	}


	if ($_POST['QC_P_DOC_FG_PostingDate'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Posting Date is required.';
		echo json_encode($data);
		exit;
	}

	if ($_POST['QC_P_DOC_FG_AnalysisDate'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Analysis Date is required.';
		echo json_encode($data);
		exit;
	}

	if ($_POST['QC_P_DOC_FG_ValidUpTo'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'ValidUpTo Date is required.';
		echo json_encode($data);
		exit;
	}

	// QC_CK_D_AnalysisDate
	// id="QC_CK_D_PostingDate"
	// service laye function and SAP loin & logout function define start here -------------------------------------------------------
	$res = $obj->SAP_Login();

	if (!empty($res)) {

		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_QCPDFG_API;

		$responce_encode = $objKri->qcPostDocument($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {
			$data['status'] = 'True';
			$data['DocEntry'] = $responce->DocEntry;
			$data['message'] = 'QC Post Document Added Successfully';
			echo json_encode($data);
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	// service laye function and SAP loin & logout function define end here 
}



if (isset($_POST['btnInventoryTransfeckQCCheckFinishedGoods'])) {
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;
	// $tdata['DocType']= "dDocument_Items";
	$tdata['Series'] = trim(addslashes(strip_tags($_POST['IT_QC_Series'])));
	$tdata['DocDate'] = date("Y-m-d", strtotime($_POST['IT_QC_PostingDate']));
	$tdata['DueDate'] = date("Y-m-d", strtotime($_POST['IT_QC_DocumentDate']));

	$tdata['CardCode'] = trim(addslashes(strip_tags($_POST['IT_QC_supplierCode'])));
	$tdata['Comments'] = null;
	$tdata['FromWarehouse'] = trim(addslashes(strip_tags($_POST['inventoryTransferFG_i_FromWhs'])));
	$tdata['ToWarehouse'] = trim(addslashes(strip_tags($_POST['inventoryTransferFG_i_ToWhs'])));

	$tdata['TaxDate'] = date("Y-m-d", strtotime($_POST['IT_QC_DocumentDate']));
	$tdata['DocObjectCode'] = '67';
	$tdata['BPLID'] = trim(addslashes(strip_tags($_POST['IT_QC_BranchId'])));

	$tdata['U_PC_SIFG'] = trim(addslashes(strip_tags($_POST['inventoryTransferFG_i_DocEntry'])));
	$tdata['U_BFType'] = trim(addslashes(strip_tags('SCS_SINTIFG')));


	// $tdata['BPL_IDAssignedToInvoice']=trim(addslashes(strip_tags($_POST['sample_issue_BPLId'])));
	// $tdata['U_PC_SCFG']=trim(addslashes(strip_tags($_POST['sample_issue_DocEntry'])));


	// $tdata['Document_ApprovalRequests']=array();


	// $tdata['DocType']='dDocument_Items';
	// $tdata['U_PC_SCRtest']=trim(addslashes(strip_tags($_POST['SCRTQC_GI_SCRTQCB_DocEntry'])));
	// 
	// $tdata['Comments']=null;
	// 
	// 
	// 
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$mainArray = $tdata;
	// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum'] = trim(addslashes(strip_tags('0')));
	$item['ItemCode'] = trim(addslashes(strip_tags($_POST['inventoryTransferFG_i_ItemCode'])));
	$item['Quantity'] = trim(addslashes(strip_tags($_POST['inventoryTransferFG_i_BQty'])));
	$item['WarehouseCode'] = trim(addslashes(strip_tags($_POST['inventoryTransferFG_i_ToWhs'])));
	// $item['LineTaxJurisdictions']=array();
	// $item['SerialNumbers']=array();
	$item['FromWarehouseCode'] = trim(addslashes(strip_tags($_POST['inventoryTransferFG_i_FromWhs'])));
	// <!-- Item Batch row data prepare start here ----------- -->
	$BL = 0;
	for ($i = 0; $i < count($_POST['usercheckList']); $i++) {

		if ($_POST['usercheckList'][$i] == '1') {

			$batch['BatchNumber'] = trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
			$batch['Quantity'] = trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
			$batch['BaseLineNumber'] = trim(addslashes(strip_tags('0')));
			$batch['ItemCode'] = trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));
			$item['BatchNumbers'][] = $batch;
			$BL++;
		}
	}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['StockTransferLines'][] = $item;

	// --------------------- Item and batch row data preparing end here ---------------------------------- -->
	// echo json_encode($mainArray);
	// exit;
	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
	// echo json_encode($mainArray);
	// exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_StockTransfers;

		$responce_encode = $obj->SaveSampleIntimation($mainArray, $Final_API);
		$responce = json_decode($responce_encode);
		// echo "<pre>";
		// 	print_r($responce);
		// 	echo "<pre>";
		// 	exit;
		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {

			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$itme = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['qc_check_DocEntry'])));
			// $UT_data['Object']='SCS_SINTIFG';

			// $itme=array();
			// $itme['LineId']=2;
			// $itme['Object']='SCS_SINTIFG';
			$UT_data['U_PC_UTTrans'] = trim(addslashes(strip_tags($responce->DocEntry)));

			// $UT_data['SCS_QCINPROC2Collection']=$itme;

			// $UT_data['U_PC_UTNo']=trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SINTIFG_API . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			if ($underTestNumber_decode == '') {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Inventory Transfer Successfully Added.";
				echo json_encode($data);
			} else {
				// $data['status']='False';
				// $data['DocEntry']='';
				// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
				// echo json_encode($data);

				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}




if (isset($_POST['SubIT_Btn_transfer'])) {
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data

	// echo "h";
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['external_docNo'])));
	$tdata['DocDate'] = date("Y-m-d", strtotime($_POST['iT_InventoryTransfer_external_PostingDate']));
	$tdata['DueDate'] = date("Y-m-d", strtotime($_POST['iT_InventoryTransfer_external_DocumentDate']));
	$tdata['CardCode'] = null;
	$tdata['Comments'] = null;
	$tdata['FromWarehouse'] = trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
	$tdata['ToWarehouse'] = trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
	$tdata['TaxDate'] = trim(addslashes(strip_tags($_POST['iT_InventoryTransfer_external_DocumentDate'])));
	$tdata['DocObjectCode'] = '67';
	$tdata['BPLID'] = trim(addslashes(strip_tags($_POST['it_InventoryTransfer_BPLId'])));
	$tdata['U_PC_SIIProc'] = trim(addslashes(strip_tags($_POST['it_InventoryTransfer_DocEntry'])));
	$tdata['U_BFType'] = trim(addslashes(strip_tags($_POST['iT_InventoryTransfer_external_BaseDocType'])));
	// $tdata['CardCode']=trim(addslashes(strip_tags($_POST['GI_supplierCode'])));
	// $tdata['Comments']=null;
	// $tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
	// $tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['GI_to_whs'])));
	// $tdata['BPLID']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId_samIss'])));
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$mainArray = $tdata;
	// --------------------- Item and batch row data preparing start here   -------------------------------- -->
	$item['LineNum'] = trim(addslashes(strip_tags('0')));
	$item['ItemCode'] = trim(addslashes(strip_tags($_POST['itP_ItemCode'])));
	$item['Quantity'] = trim(addslashes(strip_tags($_POST['itP_BQty'])));
	$item['WarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
	$item['FromWarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
	// <!-- Item Batch row data prepare start here ----------- -->
	$BL = 0;
	for ($i = 0; $i < count($_POST['usercheckList_external']); $i++) {

		if ($_POST['usercheckList_external'][$i] == '1') {

			$batch['BatchNumber'] = trim(addslashes(strip_tags($_POST['itp_ContainerNo_external'][$i])));
			$batch['Quantity'] = trim(addslashes(strip_tags($_POST['itp_BatchQty_external'][$i])));
			$batch['BaseLineNumber'] = trim(addslashes(strip_tags('0')));
			$batch['ItemCode'] = trim(addslashes(strip_tags($_POST['itp_ItemCode_external'][$i])));
			$item['BatchNumbers'][] = $batch;
			$BL++;
		}
	}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['StockTransferLines'][] = $item;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->
	// echo json_encode($mainArray);
	// exit;
	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
	// echo json_encode($mainArray);
	// exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_StockTransfers;

		$responce_encode = $objKri->SaveSampleIntimation_kris($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		// echo "<pre>";
		// 	print_r($responce);
		// 	echo "<pre>";
		// 	exit;

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {

			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['it_InventoryTransfer_DocEntry'])));
			$UT_data['U_PC_UTTrans'] = trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SCINPROCESS . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			if ($underTestNumber_decode == '') {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Inventory Transfer Successfully Added.";
				echo json_encode($data);
			} else {
				// $data['status']='False';
				// $data['DocEntry']='';
				// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
				// echo json_encode($data);

				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}


if (isset($_POST['SubIT_Btn_post_extra_issue'])) {
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data

	// echo "h";
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['extra_docNo'])));
	$tdata['DocDate'] = date("Y-m-d", strtotime($_POST['gd_PostingDate_extra']));
	$tdata['DueDate'] = date("Y-m-d", strtotime($_POST['gd_DocumentDate_extra']));
	$tdata['CardCode'] = null;
	$tdata['Comments'] = null;
	$tdata['FromWarehouse'] = trim(addslashes(strip_tags($_POST['itP_FromWhs_extra'])));
	$tdata['ToWarehouse'] = trim(addslashes(strip_tags($_POST['itP_ToWhs_extra'])));
	$tdata['TaxDate'] = trim(addslashes(strip_tags($_POST['gd_DocumentDate_extra'])));
	$tdata['DocObjectCode'] = '67';
	$tdata['BPLID'] = trim(addslashes(strip_tags($_POST['it_BPLId_extra'])));
	$tdata['U_PC_SIIProc'] = trim(addslashes(strip_tags($_POST['it_DocEntry_extra'])));
	$tdata['U_BFType'] = trim(addslashes(strip_tags($_POST['gd_BaseDocType_extra'])));
	// $tdata['CardCode']=trim(addslashes(strip_tags($_POST['GI_supplierCode'])));
	// $tdata['Comments']=null;
	// $tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
	// $tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['GI_to_whs'])));
	// $tdata['BPLID']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId_samIss'])));
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$mainArray = $tdata;
	// --------------------- Item and batch row data preparing start here   -------------------------------- -->
	$item['LineNum'] = trim(addslashes(strip_tags('0')));
	$item['ItemCode'] = trim(addslashes(strip_tags($_POST['itP_ItemCode_extra'])));
	$item['Quantity'] = trim(addslashes(strip_tags($_POST['itP_BQty_extra'])));
	$item['WarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_ToWhs_extra'])));
	$item['FromWarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_FromWhs_extra'])));
	// <!-- Item Batch row data prepare start here ----------- -->
	$BL = 0;
	for ($i = 0; $i < count($_POST['usercheckList_extra']); $i++) {

		if ($_POST['usercheckList_extra'][$i] == '1') {

			$batch['BatchNumber'] = trim(addslashes(strip_tags($_POST['itp_ContainerNo_extra'][$i])));
			$batch['Quantity'] = trim(addslashes(strip_tags($_POST['itp_BatchQty_extra'][$i])));
			$batch['BaseLineNumber'] = trim(addslashes(strip_tags('0')));
			$batch['ItemCode'] = trim(addslashes(strip_tags($_POST['itp_ItemCode_extra'][$i])));
			$item['BatchNumbers'][] = $batch;
			$BL++;
		}
	}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['StockTransferLines'][] = $item;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->
	// echo json_encode($mainArray);
	// exit;
	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
	// echo json_encode($mainArray);
	// exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_StockTransfers;

		$responce_encode = $objKri->SaveSampleIntimation_kris($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		// echo "<pre>";
		// 	print_r($responce);
		// 	echo "<pre>";
		// 	exit;

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {

			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['it_InventoryTransfer_DocEntry'])));
			$UT_data['U_PC_UTTrans'] = trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_SCINPROCESS . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			if ($underTestNumber_decode == '') {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Inventory Transfer Successfully Added.";
				echo json_encode($data);
			} else {
				// $data['status']='False';
				// $data['DocEntry']='';
				// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
				// echo json_encode($data);

				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if (isset($_POST['addQcPostDocumentSubmitQCCheckRouteStageBtn'])) {

	//<!-- ------ valdiation start --------------------------------- --> 
	// if ($_POST['routStage_Release'] == 'No') {
	// 	if ($_POST['routStage_AssayPotencyReq'] == 'Yes') {
	// 		// <!-- AssayPotency validation start --------------- -->
	// 		$AssayPotency = trim(addslashes(strip_tags($_POST['routStage_AssayPotency'])));

	// 		// Check if AssayPotency is empty
	// 		if ($AssayPotency === '' || $AssayPotency === null) {
	// 			$data['status'] = 'False';
	// 			$data['DocEntry'] = '';
	// 			$data['message'] = ' Please Enter value in AssayPotency % is empty';
	// 			echo json_encode($data);
	// 			exit();
	// 		} else {
	// 			// Convert AssayPotency to a float
	// 			$AssayPotency = floatval($AssayPotency);

	// 			// Check if AssayPotency is equal to 0 or not less than 0 and not greater than 100
	// 			if ($AssayPotency > 100) {
	// 				$data['status'] = 'False';
	// 				$data['DocEntry'] = '';
	// 				$data['message'] = 'AssayPotency %  not greater than 100';
	// 				echo json_encode($data);
	// 				exit();
	// 			}

	// 			if ($AssayPotency <= 0) {
	// 				$data['status'] = 'False';
	// 				$data['DocEntry'] = '';
	// 				$data['message'] = 'AssayPotency % is not equal to 0 or not less than 0';
	// 				echo json_encode($data);
	// 				exit();
	// 			}
	// 		}
	// 		// <!-- AssayPotency validation end ----------------- -->

	// 		// <!-- Factor validation start --------------------- -->
	// 		$Factor = trim(addslashes(strip_tags($_POST['factor'])));
	// 		if (empty($Factor)) {
	// 			$data['status'] = 'False';
	// 			$data['DocEntry'] = '';
	// 			$data['message'] = ' Please Enter value in Factor.';
	// 			echo json_encode($data);
	// 			exit();
	// 		}
	// 		// <!-- Factor validation end ----------------------- -->	
	// 	}
	// }

	if (empty($_POST['routStage_SampleType'])) {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Sample Type is required.';
		echo json_encode($data);
		exit;
	}

	if (empty($_POST['routStage_PostingDate'])) {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Posting Date is required.';
		echo json_encode($data);
		exit;
	}

	// if (empty($_POST['routStage_AnalysisDate'])) {
	// 	$data['status'] = 'False';
	// 	$data['DocEntry'] = '';
	// 	$data['message'] = 'Analysis Date is required.';
	// 	echo json_encode($data);
	// 	exit;
	// }

	// if (empty($_POST['routStage_ValidUpTo'])) {
	// 	$data['status'] = 'False';
	// 	$data['DocEntry'] = '';
	// 	$data['message'] = 'ValidUpTo Date is required.';
	// 	echo json_encode($data);
	// 	exit;
	// }
	//<!-- ------ valdiation end ----------------------------------- --> 

	$tdata = array(); // This array send to AP Standalone Invoice process 

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['routStage_DocNo'])));
	$tdata['Object'] = trim(addslashes(strip_tags('SCS_QCRSTAGE')));
	$tdata['U_PC_BLin'] = trim(addslashes(strip_tags($_POST['routStage_DocNo'])));
	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['routStage_BPLId'])));
	$tdata['U_PC_LocCode'] = trim(addslashes(strip_tags($_POST['routStage_LocCode'])));
	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['routStage_Location'])));
	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['routStage_Branch'])));
	$tdata['U_PC_WONo'] = trim(addslashes(strip_tags($_POST['routStage_woto'])));
	$tdata['U_PC_WOEnt'] = trim(addslashes(strip_tags($_POST['routStage_woEntry'])));
	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['routStage_itemCode'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['routStage_itemName'])));
	$tdata['U_PC_GName'] = trim(addslashes(strip_tags($_POST['routStage_genericName'])));
	$tdata['U_PC_LClaim'] = trim(addslashes(strip_tags($_POST['routStage_LanelCliam'])));
	$tdata['U_PC_LClmUom'] = trim(addslashes(strip_tags($_POST['routStage_LabelCliamUOM'])));
	$tdata['U_PC_RecQty'] = trim(addslashes(strip_tags($_POST['routStage_RecievedQty'])));
	$tdata['U_PC_MfgBy'] = trim(addslashes(strip_tags($_POST['routStage_MfgBy'])));
	$tdata['U_PC_RfBy'] = trim(addslashes(strip_tags($_POST['routStage_RefNo'])));
	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['routStage_BatchNo'])));
	$tdata['U_PC_BSize'] = trim(addslashes(strip_tags($_POST['routStage_BatchSize'])));
	$tdata['U_PC_MfgDt'] = trim(addslashes(strip_tags($_POST['routStage_MfgDate'])));
	$tdata['U_PC_ExpDt'] = trim(addslashes(strip_tags($_POST['routStage_ExpiryDate'])));
	$tdata['U_PC_WoDate'] = trim(addslashes(strip_tags($_POST['routStage_WODate'])));
	$tdata['U_PC_SIntNo'] = trim(addslashes(strip_tags($_POST['routStage_SampleIntimationNo'])));
	$tdata['U_PC_SColNo'] = trim(addslashes(strip_tags($_POST['routStage_SampleCollectionNo'])));
	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['routStage_SampleQty'])));
	// $tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['routStage_RetainQty'])));
	$tdata['U_PC_PckSize'] = trim(addslashes(strip_tags($_POST['routStage_PackSize'])));
	$tdata['U_PC_SamType'] = trim(addslashes(strip_tags($_POST['routStage_SampleType'])));
	$tdata['U_PC_MType'] = trim(addslashes(strip_tags($_POST['routStage_MaterialType'])));
	$tdata['U_PC_PDate'] = trim(addslashes(strip_tags($_POST['routStage_PostingDate'])));
	$tdata['U_PC_ADate'] = trim(addslashes(strip_tags($_POST['routStage_AnalysisDate'])));
	$tdata['U_PC_NoCont'] = trim(addslashes(strip_tags($_POST['routStage_NoContainer'])));
	$tdata['U_PC_QCTType'] = trim(addslashes(strip_tags($_POST['routStage_QCTesttype'])));
	$tdata['U_PC_Stage'] = trim(addslashes(strip_tags($_POST['routStage_Stage'])));
	$tdata['U_PC_ValUp'] = trim(addslashes(strip_tags($_POST['routStage_ValidUpTo'])));
	$tdata['U_PC_ArNo'] = trim(addslashes(strip_tags($_POST['routStage_ARNo'])));
	$tdata['U_PC_GENo'] = trim(addslashes(strip_tags($_POST['routStage_GateEntryNo'])));
	$tdata['U_PC_APot'] = trim(addslashes(strip_tags($_POST['routStage_AssayPotency'])));
	$tdata['U_PC_LODWater'] = trim(addslashes(strip_tags($_POST['routStage_LODWater'])));
	$tdata['U_PC_Potency'] = trim(addslashes(strip_tags($_POST['routStage_Potency'])));
	// $tdata['U_PC_CompBy']=trim(addslashes(strip_tags($_POST['routStage_CompiledBy'])));
	$tdata['U_PC_NoCont1'] = trim(addslashes(strip_tags($_POST['routStage_U_PC_NoCont1'])));
	$tdata['U_PC_NoCont2'] = trim(addslashes(strip_tags($_POST['routStage_U_PC_NoCont2'])));
	$tdata['U_PC_ChkBy'] = trim(addslashes(strip_tags($_POST['routStage_CheckedBy'])));
	$tdata['U_PC_AnlBy'] = trim(addslashes(strip_tags($_POST['routStage_AnalysisBy'])));
	$tdata['U_PC_CompBy'] = trim(addslashes(strip_tags($_POST['routStage_ApprovedBy'])));
	$tdata['U_PC_Remarks'] = trim(addslashes(strip_tags($_POST['routStage_Remarks'])));
	$tdata['U_PC_AsyCal'] = trim(addslashes(strip_tags($_POST['routStage_AssayCalc'])));
	$tdata['U_PC_Factor'] = trim(addslashes(strip_tags($_POST['routStage_Factor'])));
	$tdata['U_PC_SpcNo'] = trim(addslashes(strip_tags($_POST['routStage_SpecificationNo'])));
	$tdata['U_PC_RelDt'] = trim(addslashes(strip_tags($_POST['routStage_ReleaseDate'])));
	$tdata['U_PC_RetstDt'] = trim(addslashes(strip_tags($_POST['routStage_RetestDate'])));
	$tdata['U_PC_RMQC'] = trim(addslashes(strip_tags($_POST['routStage_Release']))); //routStage_RMWQC Old Input File Id

	$tdata['U_PC_GDEntry'] = null;
	$tdata['U_PC_SType'] = null;

	$ganaralData = array();
	for ($i = 0; $i < count($_POST['parameter_code']); $i++) {
		$ganaralData['LineId'] = $i;
		$ganaralData['Object'] = trim(addslashes(strip_tags('SCS_QCRSTAGE')));

		$ganaralData['U_PC_PCode'] = trim(addslashes(strip_tags($_POST['parameter_code'][$i])));
		$ganaralData['U_PC_PName'] = trim(addslashes(strip_tags($_POST['PName'][$i])));
		$ganaralData['U_PC_Std'] = trim(addslashes(strip_tags($_POST['Standard'][$i])));
		$ganaralData['U_PC_Rmrks'] = trim(addslashes(strip_tags($_POST['ResultOut'][$i])));
		$ganaralData['U_PC_LMin1'] = trim(addslashes(strip_tags($_POST['ComparisonResult'][$i])));
		$ganaralData['U_PC_Rotpt'] = trim(addslashes(strip_tags($_POST['ResultOutputByQCDept'][$i])));
		$ganaralData['U_PC_PDTyp'] = trim(addslashes(strip_tags($_POST['PDType'][$i])));
		$ganaralData['U_PC_Logi'] = trim(addslashes(strip_tags($_POST['Logical'][$i])));
		$ganaralData['U_PC_LwMin'] = trim(addslashes(strip_tags($_POST['LowMin'][$i])));
		$ganaralData['U_PC_UpMax'] = trim(addslashes(strip_tags($_POST['UppMax'][$i])));
		$ganaralData['U_PC_Min'] = trim(addslashes(strip_tags($_POST['Min'][$i])));
		$ganaralData['U_PC_QCSts'] = trim(addslashes(strip_tags($_POST['QC_StatusByAnalyst'][$i])));
		$ganaralData['U_PC_TMeth'] = trim(addslashes(strip_tags($_POST['TMethod'][$i])));
		$ganaralData['U_PC_MType'] = trim(addslashes(strip_tags($_POST['MType'][$i])));
		$ganaralData['U_PC_PhStd'] = trim(addslashes(strip_tags($_POST['PharmacopeiasStandard'][$i])));
		$ganaralData['U_PC_UOM'] = trim(addslashes(strip_tags($_POST['UOM'][$i])));
		$ganaralData['U_PC_Rtst'] = trim(addslashes(strip_tags($_POST['Retest'][$i])));
		$ganaralData['U_PC_ExtrS'] = trim(addslashes(strip_tags($_POST['ExSample'][$i])));
		$ganaralData['U_PC_AnyBy'] = trim(addslashes(strip_tags($_POST['AnalysisBy'][$i])));
		$ganaralData['U_PC_ARmrk'] = trim(addslashes(strip_tags($_POST['analyst_remark'][$i])));
		$ganaralData['U_PC_LwMax'] = trim(addslashes(strip_tags($_POST['LowMax'][$i])));
		$ganaralData['U_PC_Rel'] = trim(addslashes(strip_tags($_POST['Release'][$i])));
		$ganaralData['U_PC_DDtl'] = trim(addslashes(strip_tags($_POST['DescriptiveDetails'][$i])));
		$ganaralData['U_PC_UpMin'] = trim(addslashes(strip_tags($_POST['UppMin'][$i])));
		$ganaralData['U_PC_LMax1'] = trim(addslashes(strip_tags($_POST['LowMinRes'][$i])));
		$ganaralData['U_PC_UMin1'] = trim(addslashes(strip_tags($_POST['UppMinRes'][$i])));
		$ganaralData['U_PC_UMax1'] = trim(addslashes(strip_tags($_POST['UppMaxRes'][$i])));
		$ganaralData['U_PC_Min1'] = trim(addslashes(strip_tags($_POST['MeanRes'][$i])));
		$ganaralData['U_PC_UTxt1'] = trim(addslashes(strip_tags($_POST['UserText1'][$i])));
		$ganaralData['U_PC_UTxt2'] = trim(addslashes(strip_tags($_POST['UserText2'][$i])));
		$ganaralData['U_PC_UTxt3'] = trim(addslashes(strip_tags($_POST['UserText3'][$i])));
		$ganaralData['U_PC_UTxt4'] = trim(addslashes(strip_tags($_POST['UserText4'][$i])));
		$ganaralData['U_PC_UTxt5'] = trim(addslashes(strip_tags($_POST['UserText5'][$i])));
		$ganaralData['U_PC_QCRmk'] = trim(addslashes(strip_tags($_POST['QC_StatusResult'][$i])));
		$ganaralData['U_PC_Stab'] = trim(addslashes(strip_tags($_POST['Stability'][$i])));
		$ganaralData['U_PC_ApAsy'] = trim(addslashes(strip_tags($_POST['Appassay'][$i])));
		$ganaralData['U_PC_ApLOD'] = trim(addslashes(strip_tags($_POST['AppLOD'][$i])));
		$ganaralData['U_PC_InCod'] = trim(addslashes(strip_tags($_POST['InstrumentCode'][$i])));
		$ganaralData['U_PC_InNam'] = trim(addslashes(strip_tags($_POST['InstrumentName'][$i])));
		$ganaralData['U_PC_SDt'] = trim(addslashes(strip_tags($_POST['StartDate'][$i])));
		$ganaralData['U_PC_STime'] = trim(addslashes(strip_tags($_POST['StartTime'][$i])));
		$ganaralData['U_PC_EDate'] = trim(addslashes(strip_tags($_POST['EndDate'][$i])));
		$ganaralData['U_PC_ETime'] = trim(addslashes(strip_tags($_POST['EndTime'][$i])));

		$tdata['SCS_QCRSTAGE1Collection'][] = $ganaralData; // row data append on this array
	}

	$qcStatus = array();
	for ($j = 0; $j < count($_POST['qc_Status']); $j++) {
		if (!empty($_POST['qc_Status'][$j])) {
			$qcStatus['LineId'] = $j;
			$qcStatus['Object'] = trim(addslashes(strip_tags('SCS_QCRSTAGE')));
			$qcStatus['U_PC_Stus'] = trim(addslashes(strip_tags($_POST['qc_Status'][$j])));
			$qcStatus['U_PC_Qty'] = trim(addslashes(strip_tags($_POST['qCStsQty'][$j])));
			$qcStatus['U_PC_RelDt'] = (!empty($_POST['qCReleaseDate'][$j])) ? date("Y-m-d", strtotime($_POST['qCReleaseDate'][$j])) : null;
			$qcStatus['U_PC_RelTm'] = (!empty($_POST['qCReleaseTime'][$j])) ? date("Hi", strtotime($_POST['qCReleaseTime'][$j])) : null;
			$qcStatus['U_PC_ITNo'] = trim(addslashes(strip_tags($_POST['qCitNo'][$j])));
			$qcStatus['U_PC_DBy'] = trim(addslashes(strip_tags($_POST['doneBy'][$j])));
			$qcStatus['U_PC_Rmrk1'] = trim(addslashes(strip_tags($_POST['qCStsRemark1'][$j])));
			$qcStatus['U_PC_Atch1'] = (!empty($_FILES['qCAttache1']['name'][$j])) ? $_FILES['qCAttache1']['name'][$j] : null;
			$qcStatus['U_PC_Atch2'] = (!empty($_FILES['qCAttache2']['name'][$j])) ? $_FILES['qCAttache2']['name'][$j] : null;
			$qcStatus['U_PC_Atch3'] = (!empty($_FILES['qCAttache3']['name'][$j])) ? $_FILES['qCAttache3']['name'][$j] : null;
			$qcStatus['U_PC_DvDt'] = (!empty($_POST['qCDeviationDate'][$j])) ? date("Y-m-d", strtotime($_POST['qCDeviationDate'][$j])) : null;
			$qcStatus['U_PC_DvNo'] = trim(addslashes(strip_tags($_POST['qCDeviationNo'][$j])));
			$qcStatus['U_PC_DvRsn'] = trim(addslashes(strip_tags($_POST['qCDeviationResion'][$j])));

			// <!-- ------ File upload code start here ----------------------------- -->
			$uploadDir = '../include/uploads/';

			$uploadFile = $uploadDir . basename($_FILES['qCAttache1']['name'][$j]);
			move_uploaded_file($_FILES['qCAttache1']['tmp_name'][$j], $uploadFile);

			$uploadFile2 = $uploadDir . basename($_FILES['qCAttache2']['name'][$j]);
			move_uploaded_file($_FILES['qCAttache2']['tmp_name'][$j], $uploadFile2);


			$uploadFile3 = $uploadDir . basename($_FILES['qCAttache3']['name'][$j]);
			move_uploaded_file($_FILES['qCAttache3']['tmp_name'][$j], $uploadFile3);
			// <!-- ------ File upload code start here ----------------------------- -->

			$tdata['SCS_QCRSTAGE2Collection'][] = $qcStatus; // row data append on this array
		}
	}

	$qcAttech = array();
	for ($k = 0; $k < count($_POST['targetPath']); $k++) {
		if (!empty($_POST['fileName'][$k])) {
			$qcAttech['LineId'] = trim(addslashes(strip_tags($_POST['targetPath'][$k])));
			$qcAttech['Object'] = trim(addslashes(strip_tags('SCS_QCRSTAGE')));
			$qcAttech['U_PC_TrgPt'] = trim(addslashes(strip_tags($_POST['targetPath'][$k])));
			$qcAttech['U_PC_FName'] = trim(addslashes(strip_tags($_POST['fileName'][$k])));
			$qcAttech['U_PC_AtcDt'] = trim(addslashes(strip_tags($_POST['attachDate'][$k])));
			$qcAttech['U_PC_FText'] = trim(addslashes(strip_tags($_POST['freeText'][$k])));

			$tdata['SCS_QCRSTAGE3Collection'][] = $qcAttech; // row data append on this array
		}
	}

	$mainArray = $tdata; // all child array append in main array define here

	// service laye function loin & logout function define start here ----------------------------------------------------
	$res = $obj->SAP_Login();

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_QCRSTAGE;
		$responce_encode = $objKri->qcPostDocument($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {
			$data['status'] = 'True';
			$data['DocEntry'] = $responce->DocEntry;
			$data['message'] = 'QC Post Document Route Stage Added Successfully';
			echo json_encode($data);
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	// service laye function loin & logout function define end here ------------------------------------------------------
}


if (isset($_POST['action']) && $_POST['action'] == 'QCPostdocumentQCCheckRouteStage_Selected_row') {
	// <!-- ------- Replace blank space to %20 start here -------- -->
	$API = $RSQCPOSTDOCUMENTDETAILS . '?DocEntry=' . $_POST['DocEntry'];
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// print_r($API);
	// die;
	// <!-- ------- Replace blank space to %20 End here -------- -->
	$response = $obj->get_OTFSI_SingleData($FinalAPI);



	$FinalResponce['SampleCollDetails'] = $response;
	// <!-- ------ Array declaration End Here  --------------------------------- -->
	$general_data = $response[0]->RSQCPOSTDOCGENERALDATA;
	$qcStatus = $response[0]->RSQCPOSTDOCQCSTATUS; // Etra issue response seperate here 
	$qcAttach = $response[0]->RSQCPOSTDOCATTACH; //External issue reponce seperate here

	// echo "<pre>";
	// print_r($API);
	// echo "</pre>";
	// exit;

	if (!empty($general_data)) {
		for ($i = 0; $i < count($general_data); $i++) {
			$SrNo = $i;
			$index = $i + 1;

			$FinalResponce['general_data'] .= '<tr>
						<td class="desabled">' . $index . '</td>

						<td class="desabled"><input  type="text" class="form-control textbox_bg" id="parameter_code' . $SrNo . '" name="parameter_code[]" value="' . $general_data[$i]->PCode . '" readonly></td>

						<td class="desabled"><input  type="text" class="form-control textbox_bg" id="PName' . $SrNo . '" name="PName[]" value="' . $general_data[$i]->PName . '" readonly></td>

						<td class="desabled" style="cursor: pointer;"><input  type="text" class="form-control textbox_bg" id="Standard' . $SrNo . '" name="Standard[]" value="' . $general_data[$i]->Standard . '" readonly class="form-control textbox_bg" style="border: 1px solid #efefef !important;width:400px;"></td>
						
						<td><input type="text" id="ResultOut' . $SrNo . '" name="ResultOut[]" value="' . $general_data[$i]->GDRemarks . '" class="form-control" style="width:200px;"></td>';

			if ($general_data[$i]->PDType == 'Range') {
				$FinalResponce['general_data'] .= '<td>
							<input type="text" id="ComparisonResult' . $SrNo . '" name="ComparisonResult[]" value="' . $general_data[$i]->LowMin1 . '" class="form-control" style="width:100px;" onfocusout="CalculateResultOut(' . $SrNo . ')">
						</td>';
			} else {
				$FinalResponce['general_data'] .= '<td class="desabled">
							<input type="text" id="ComparisonResult' . $SrNo . '" name="ComparisonResult[]" value="' . $general_data[$i]->LowMin1 . '" class="form-control textbox_bg" style="width:100px;">
						</td>';
			}


			$FinalResponce['general_data'] .= '
						<td id="ResultOutputByQCDeptTd' . $SrNo . '">
							<input type="hidden" id="ResultOutputByQCDept_Old' . $SrNo . '" name="ResultOutputByQCDept_Old[]" value="' . $general_data[$i]->ROutput . '">

							<select id="ResultOutputByQCDept' . $SrNo . '" name="ResultOutputByQCDept[]" class="form-select" style="border: 1px solid #ffffff !important;" onchange="OnChangeResultOutputByQCDept(' . $SrNo . ')"></select>
						</td>

						<td class="desabled">
							<input type="text" id="PDType' . $SrNo . '" name="PDType[]" value="' . $general_data[$i]->PDType . '" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
						</td>

						<td class="desabled"><input  type="text" class="form-control textbox_bg" id="logical' . $SrNo . '" name="logical[]" value="' . $general_data[$i]->Logical . '" readonly></td>

						<td class="desabled"><input  type="text" class="form-control textbox_bg" id="LowMin' . $SrNo . '" name="LowMin[]" value="' . $general_data[$i]->LowMin . '" readonly></td>

						<td class="desabled"><input  type="text" class="form-control textbox_bg" id="UppMax' . $SrNo . '" name="UppMax[]" value="' . $general_data[$i]->UppMax . '" readonly></td>

						<td class="desabled"><input  type="text" class="form-control textbox_bg" id="Min' . $SrNo . '" name="Min[]" value="' . $general_data[$i]->Min . '" readonly></td>
						
						<td id="QC_StatusByAnalystTd' . $SrNo . '">
							<input type="hidden" id="qC_status_by_analyst_Old' . $SrNo . '" name="qC_status_by_analyst_Old[]" value="' . $general_data[$i]->GDQCStatus . '">

							<select id="qC_status_by_analyst' . $SrNo . '" name="qC_status_by_analyst[]" class="form-select qc_statusbyab' . $SrNo . '" onchange="SelectedQCStatus(' . $SrNo . ')">
							</select>
						</td>

						<td class="desabled"><input  type="text" class="form-control textbox_bg" id="TMethod' . $SrNo . '" name="TMethod[]" value="' . $general_data[$i]->TMethod . '" readonly></td>
						
						<td class="desabled"><input  type="text" class="form-control textbox_bg" id="MType' . $SrNo . '" name="MType[]" value="' . $general_data[$i]->MType . '" readonly></td>
						<td class="desabled">
							<input type="text" id="PharmacopeiasStandard' . $i . '" name="PharmacopeiasStandard[]" value="' . $general_data[$i]->PharmacopeiasStandard . '"" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
						</td>

						<td class="desabled"><input type="text" id="UOM' . $SrNo . '" name="UOM[]" class="form-control textbox_bg" value="' . $general_data[$i]->GDUOM . '" readonly></td>

						<td class="desabled"><input type="text" id="Retest' . $SrNo . '" name="Retest[]" class="form-control textbox_bg" value="' . $general_data[$i]->Retest . '" readonly></td>
						
						<td class="desabled"><input type="text" id="ExSample' . $SrNo . '" name="ExSample[]" class="form-control textbox_bg" value="' . $general_data[$i]->ExSample . '" readonly></td>

						<td>
							<input type="hidden" id="AnalysisBy_Old' . $SrNo . '" name="AnalysisBy_Old[]" value="' . $general_data[$i]->AnyBy . '">

							<select id="AnalysisBy' . $SrNo . '" name="AnalysisBy[]" class="form-select" style="width: 140px;"></select>
						</td>

						<td><input  type="text" id="analyst_remark' . $SrNo . '" name="analyst_remark[]" class="form-control" value="' . $general_data[$i]->ARRemark . '"></td>
					
						<td class="desabled"><input  type="text" class="form-control textbox_bg" id="LowMax' . $SrNo . '" name="LowMax[]" value="' . $general_data[$i]->LowMax . '" readonly></td>

						<td class="desabled"><input  type="text" class="form-control textbox_bg" id="Release' . $SrNo . '" name="Release[]" value="' . $general_data[$i]->Release . '" readonly></td>
						
						<td><input  type="text" class="form-control" id="descriptive_details' . $SrNo . '" name="descriptive_details[]" value="' . $general_data[$i]->DesDetils . '"></td>

						<td class="desabled"><input  type="text" class="form-control textbox_bg" id="UppMin' . $SrNo . '" name="UppMin[]" value="' . $general_data[$i]->UppMin . '" readonly></td>
						
						<td><input  type="number" id="lower_min_result' . $SrNo . '" name="lower_min_result[]" class="form-control" value="' . $general_data[$i]->LowMax1 . '"></td>
						
						<td><input  type="number" id="UppMinRes' . $SrNo . '" name="UppMinRes[]" class="form-control"></td>
						
						<td><input  type="number" id="upper_max_result' . $SrNo . '" name="upper_max_result[]" class="form-control" value="' . $general_data[$i]->UppMax1 . '"></td>

						<td>
							<input type="number" id="MeanRes' . $SrNo . '" name="MeanRes[]" class="form-control">
						</td>

						<td><input type="text" id="user_text1_' . $SrNo . '" name="user_text1_[]" class="form-control" value="' . $general_data[$i]->UText1 . '"></td>

						<td><input type="text" id="user_text2_' . $SrNo . '" name="user_text2_[]" class="form-control" value="' . $general_data[$i]->UText2 . '"></td>

						<td><input type="text" id="user_text3_' . $SrNo . '" name="user_text3_[]" class="form-control" value="' . $general_data[$i]->UText3 . '"></td>

						<td><input type="text" id="user_text4_' . $SrNo . '" name="user_text4_[]" class="form-control" value="' . $general_data[$i]->UText4 . '"></td>

						<td ><input type="text" id="user_text5_' . $SrNo . '" name="user_text5_[]" class="form-control" value="' . $general_data[$i]->UText5 . '"></td>
						
						<td class="desabled">
							<input type="text" id="QC_StatusResult' . $SrNo . '" name="QC_StatusResult[]" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
						</td>

						<td class="desabled"><input type="text" id="GDStab' . $SrNo . '" name="GDStab[]" class="form-control textbox_bg" value="' . $general_data[$i]->GDStab . '" readonly></td>
						
						<td class="desabled"><input type="text" id="Appassay' . $SrNo . '" name="Appassay[]" class="form-control textbox_bg" value="' . $general_data[$i]->Appassay . '" readonly></td>

						<td class="desabled"><input type="text" id="AppLOD' . $SrNo . '" name="AppLOD[]" class="form-control textbox_bg" value="' . $general_data[$i]->AppLOD . '" readonly></td>
					
						<td><input type="text" id="InstrumentCode' . $SrNo . '" name="InstrumentCode[]" class="form-control" data-bs-toggle="modal" data-bs-target=".instrument_modal" value="' . $general_data[$i]->Inscode . '" onclick="OpenInstrmentModal(' . $SrNo . ')"></td>

						<td class="desabled"><input type="text" id="InstrumentName' . $SrNo . '" name="InstrumentName[]" class="form-control textbox_bg" value="' . $general_data[$i]->InsName . '" readonly style="border: 1px solid #efefef !important;"></td>

						<td><input  type="date" id="start_date' . $SrNo . '" name="start_date[]" class="form-control" value="' . (!empty($general_data[$i]->SDate) ? date("Y-m-d", strtotime($general_data[$i]->SDate)) : '') . '"></td>

						<td><input  type="time" id="start_time' . $SrNo . '" name="start_time[]" class="form-control" value="' . (!empty($general_data[$i]->STime) ? date("H:i", strtotime($general_data[$i]->STime)) : '') . '"></td>

						<td ><input type="date" id="end_date' . $SrNo . '" name="end_date[]" class="form-control" value="' . (!empty($general_data[$i]->EDate) ? date("Y-m-d", strtotime($general_data[$i]->EDate)) : '') . '"></td>


						<td ><input type="time" id="end_time' . $SrNo . '" name="end_time[]" class="form-control" value="' . (!empty($general_data[$i]->ETime) ? date("H:i", strtotime($general_data[$i]->ETime)) : '') . '"></td>
					</tr>';
		}
		// for ($i=0; $i <count($general_data) ; $i++) { 
		// 	$SrNo=$i;
		// 	$index=$i+1;

		// 	$FinalResponce['general_data'].='<tr>
		// 		<td class="desabled">'.$index.'</td>

		// 		<td class="desabled"><input  type="text" class="form-control input_disable" id="parameter_code'.$SrNo.'" name="parameter_code[]" value="'.$general_data[$i]->PCode.'" readonly></td>

		// 		<td class="desabled"><input  type="text" class="form-control input_disable" id="PName'.$SrNo.'" name="PName[]" value="'.$general_data[$i]->PName.'" readonly></td>

		// 		<td class="desabled"><input  type="text" class="form-control input_disable" id="Standard'.$SrNo.'" name="Standard[]" value="'.$general_data[$i]->Standard.'" readonly></td>

		// 		<td class="desabled"><input  type="text" class="form-control input_disable" id="Release'.$SrNo.'" name="Release[]" value="'.$general_data[$i]->Release.'" readonly></td>

		// 		<td class="desabled"><input  type="text" class="form-control input_disable" id="PDType'.$SrNo.'" name="PDType[]" value="'.$general_data[$i]->PDType.'" readonly></td>

		// 		<td><input  type="text" class="form-control" id="descriptive_details'.$SrNo.'" name="descriptive_details[]" value="'.$general_data[$i]->DesDetils.'"></td>

		// 		<td><input  type="text" class="form-control" id="logical'.$SrNo.'" name="logical[]" value="'.$general_data[$i]->Logical.'" style="width: 100px;"></td>

		// 		<td class="desabled"><input  type="text" class="form-control input_disable" id="LowMin'.$SrNo.'" name="LowMin[]" value="'.$general_data[$i]->LowMin.'" readonly style="width: 100px;"></td>

		// 		<td class="desabled"><input  type="text" class="form-control input_disable" id="LowMax'.$SrNo.'" name="LowMax[]" value="'.$general_data[$i]->LowMax.'" readonly style="width: 100px;"></td>

		// 		<td class="desabled"><input  type="text" class="form-control input_disable" id="UppMin'.$SrNo.'" name="UppMin[]" value="'.$general_data[$i]->UppMin.'" readonly style="width: 100px;"></td>

		// 		<td class="desabled"><input  type="text" class="form-control input_disable" id="UppMax'.$SrNo.'" name="UppMax[]" value="'.$general_data[$i]->UppMax.'" readonly style="width: 100px;"></td>

		// 		<td class="desabled"><input  type="text" class="form-control input_disable" id="Min'.$SrNo.'" name="Min[]" value="'.$general_data[$i]->Min.'" readonly style="width: 100px;"></td>

		// 		<td><input  type="text" id="lower_min_result'.$SrNo.'" name="lower_min_result[]" onfocusout="CalculateResultOut('.$SrNo.')" class="form-control" value="'.$general_data[$i]->LowMin1.'"></td>

		// 		<td><input  type="text" id="lower_max_result'.$SrNo.'" name="lower_max_result[]" class="form-control" value="'.$general_data[$i]->LowMax1.'"></td>

		// 		<td><input  type="text" id="upper_min_result'.$SrNo.'" name="upper_min_result[]" class="form-control" value="'.$general_data[$i]->UppMin1.'"></td>

		// 		<td><input  type="text" id="upper_max_result'.$SrNo.'" name="upper_max_result[]" class="form-control" value="'.$general_data[$i]->UppMax1.'"></td>

		// 		<td ><input type="text" id="mean'.$SrNo.'" name="mean[]" class="form-control" value="'.$general_data[$i]->Min1.'" style="width: 100px;"></td>

		// 		<td id="ResultOutTd'.$SrNo.'">
		// 			<select id="result_output'.$SrNo.'" name="result_output[]" class="form-select dropdownResutl'.$SrNo.'" onchange="ManualSelectedTResultOut('.$SrNo.')"><option value="'.$general_data[$i]->ROutput.'">'.$general_data[$i]->ROutput.'</option></select>
		// 		</td>

		// 		<td ><input type="text" id="remarks'.$SrNo.'" name="remarks[]" class="form-control" value="'.$general_data[$i]->Remarks.'"></td>

		// 		<td id="QC_StatusByAnalystTd'.$SrNo.'">
		// 			<select id="qC_status_by_analyst'.$SrNo.'" name="qC_status_by_analyst[]" class="form-select qc_statusbyab'.$SrNo.'" onchange="SelectedQCStatus('.$SrNo.')">
		// 			</select>
		// 		</td>

		// 		<td class="desabled"><input  type="text" class="form-control input_disable" id="TMethod'.$SrNo.'" name="TMethod[]" value="'.$general_data[$i]->TMethod.'" readonly></td>

		// 		<td class="desabled"><input  type="text" class="form-control input_disable" id="MType'.$SrNo.'" name="MType[]" value="'.$general_data[$i]->MType.'" readonly></td>

		// 		<td><input type="text" id="user_text1_'.$SrNo.'" name="user_text1_[]" class="form-control" value="'.$general_data[$i]->UText1.'"></td>

		// 		<td><input type="text" id="user_text2_'.$SrNo.'" name="user_text2_[]" class="form-control" value="'.$general_data[$i]->UText2.'"></td>

		// 		<td><input type="text" id="user_text3_'.$SrNo.'" name="user_text3_[]" class="form-control" value="'.$general_data[$i]->UText3.'"></td>

		// 		<td><input type="text" id="user_text4_'.$SrNo.'" name="user_text4_[]" class="form-control" value="'.$general_data[$i]->UText4.'"></td>

		// 		<td ><input type="text" id="user_text5_'.$SrNo.'" name="user_text5_[]" class="form-control" value="'.$general_data[$i]->UText5.'"></td>

		// 		<td class="desabled"><input type="text" id="GDQCStatus'.$SrNo.'" name="GDQCStatus[]" class="form-control input_disable" value="'.$general_data[$i]->GDQCStatus.'" readonly></td>

		// 		<td class="desabled"><input type="text" id="GDUOM'.$SrNo.'" name="GDUOM[]" class="form-control input_disable" value="'.$general_data[$i]->GDUOM.'" readonly></td>

		// 		<td class="desabled"><input type="text" id="Retest'.$SrNo.'" name="Retest[]" class="form-control input_disable" value="'.$general_data[$i]->Retest.'" readonly></td>

		// 		<td class="desabled"><input type="text" id="GDStab'.$SrNo.'" name="GDStab[]" class="form-control input_disable" value="'.$general_data[$i]->GDStab.'" readonly></td>

		// 		<td class="desabled"><input type="text" id="ExSample'.$SrNo.'" name="ExSample[]" class="form-control input_disable" value="'.$general_data[$i]->ExSample.'" readonly></td>

		// 		<td class="desabled"><input type="text" id="Appassay'.$SrNo.'" name="Appassay[]" class="form-control input_disable" value="'.$general_data[$i]->Appassay.'" readonly></td>

		// 		<td class="desabled"><input type="text" id="AppLOD'.$SrNo.'" name="AppLOD[]" class="form-control input_disable" value="'.$general_data[$i]->AppLOD.'" readonly></td>

		// 		<td><input  type="text" id="qc_analysis_by'.$SrNo.'" name="qc_analysis_by[]" class="form-control" value="'.$general_data[$i]->AnlBy.'"></td>

		// 		<td><input  type="text" id="analyst_remark'.$SrNo.'" name="analyst_remark[]" class="form-control" value="'.$general_data[$i]->ARRemark.'"></td>

		// 		<td ><input type="text" id="instrument_code'.$SrNo.'" name="instrument_code[]" class="form-control" value="'.$general_data[$i]->Inscode.'"></td>

		// 		<td class="desabled"><input type="text" id="InsName'.$SrNo.'" name="InsName[]" class="form-control input_disable" value="'.$general_data[$i]->InsName.'" readonly></td>

		// 		<td><input  type="text" id="star_date'.$SrNo.'" name="star_date[]" class="form-control" value="'.$general_data[$i]->SDate.'"></td>

		// 		<td><input  type="text" id="start_time'.$SrNo.'" name="start_time[]" class="form-control" value="'.$general_data[$i]->STime.'"></td>

		// 		<td ><input type="text" id="end_date'.$SrNo.'" name="end_date[]" class="form-control" value="'.$general_data[$i]->EDate.'"></td>

		// 		<td ><input type="text" id="end_time'.$SrNo.'" name="end_time[]" class="form-control" value="'.$general_data[$i]->ETime.'"></td>

		// 	</tr>';
		// }
	} else {
		$FinalResponce['general_data'] .= '<tr><td colspan="7" style="color:red;text-align: center;">No Record Found</td></tr>';
	}

	$FinalResponce['count'] = count($general_data);


	if (!empty($qcStatus)) {
		for ($j = 0; $j < count($qcStatus); $j++) {
			$SrNo = $j + 1;

			$FinalResponce['qcStatus'] .= '<tr>
						
						<td class="desabled">' . $SrNo . '</td>

						<td class="desabled">
							<input type="hidden" id="QCS_LineId' . $SrNo . '" name="QCS_LineId[]" value="' . $qcStatus[$j]->LineID . '">
							
							<input class="form-control border_hide desabled" type="text" id="qc_Status' . $SrNo . '" name="qc_Status[]" value="' . $qcStatus[$j]->QCStsStatus . '" readonly>
						</td>

						<td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsQty' . $SrNo . '" name="qCStsQty[]"  value="' . $qcStatus[$j]->QCStsQty . '" readonly></td>

						<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCReleaseDate_' . $SrNo . '" name="qCReleaseDate[]" value="' . ((!empty($qcStatus[$j]->RelDate)) ? date("d-m-Y", strtotime($qcStatus[$j]->RelDate)) : "") . '" readonly></td>

						<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCReleaseTime_' . $SrNo . '" name="qCReleaseTime[]" value="' . ((!empty($qcStatus[$j]->RelTime)) ? date("H:i", strtotime($qcStatus[$j]->RelTime)) : "") . '" readonly></td>

						<td class="desabled"><input  type="text" class="form-control border_hide desabled" id="qCitNo' . $SrNo . '" name="qCitNo[]"  value="' . $qcStatus[$j]->ItNo . '" readonly></td>

						<td class="desabled"><input class="form-control border_hide desabled" type="text" id="doneBy' . $SrNo . '" name="doneBy[]"  value="' . $qcStatus[$j]->DBy . '" readonly></td>

						<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCAttache1_' . $SrNo . '" name="qCAttache1[]" value="' . $qcStatus[$j]->QCStsAttach1 . '"></td>

						<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCAttache2_' . $SrNo . '" name="qCAttache2[]" value="' . $qcStatus[$j]->QCStsAttach2 . '"></td>

						<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCAttache3_' . $SrNo . '" name="qCAttache3[]" value="' . $qcStatus[$j]->QCStsAttach3 . '"></td>

						<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCDeviationDate_' . $SrNo . '" name="qCDeviationDate[]" value="' . ((!empty($qcStatus[$j]->DevDate)) ? date("d-m-Y", strtotime($qcStatus[$j]->DevDate)) : "") . '"></td>

						<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCDeviationNo_' . $SrNo . '" name="qCDeviationNo[]" value="' . $qcStatus[$j]->DevNo . '"></td>

						<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCDeviationResion_' . $SrNo . '" name="qCDeviationResion[]" value="' . $qcStatus[$j]->DevRsn . '"></td>

						<td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsRemark1' . $SrNo . '" name="qCStsRemark1[]"  value="' . $qcStatus[$j]->QCStsRemark1 . '" readonly></td>

					</tr>';
		}
	} else {
		// $FinalResponce['qcStatus'].='<tr><td colspan="12" style="color:red;text-align: center;">No Record Found</td></tr>';
	}

	$SrNo_Ex = (count($qcStatus) + 1);
	$FinalResponce['qcStatus'] .= '<tr id="add-more_' . $SrNo_Ex . '">
				<td>' . $SrNo_Ex . '</td>

				<td><select id="qc_Status_' . $SrNo_Ex . '" name="qc_Status[]" class="form-select qc_status_selecte1" onchange="SelectionOfQC_Status(' . $SrNo_Ex . ')"></select></td>

				<td><input class="border_hide form-control" type="text"  id="qCStsQty_' . $SrNo_Ex . '" name="qCStsQty[]" onfocusout="addMore(' . $SrNo_Ex . ');"></td>

				<td><input class="form-control border_hide" type="text"  id="qCReleaseDate_' . $SrNo_Ex . '" name="qCReleaseDate[]"></td>

				<td><input class="form-control border_hide" type="text"  id="qCReleaseTime_' . $SrNo_Ex . '" name="qCReleaseTime_[]"></td>

				<td><input class="border_hide form-control" type="text"  id="qCitNo_' . $SrNo_Ex . '" name="qCitNo[]"></td>
				
				<td>
					<select class="form-select done-by-mo1" id="doneBy_' . $SrNo_Ex . '" name="doneBy[]"></select>
				</td>

				<td><input class="form-control border_hide" type="file"  id="qCAttache1_' . $SrNo_Ex . '" name="qCAttache1[]"></td>

				<td><input class="form-control border_hide" type="file"  id="qCAttache2_' . $SrNo_Ex . '" name="qCAttache2[]"></td>

				<td><input class="form-control border_hide" type="file"  id="qCAttache3_' . $SrNo_Ex . '" name="qCAttache3[]"></td>

				<td><input class="form-control border_hide" type="date"  id="qCDeviationDate_' . $SrNo_Ex . '" name="qCDeviationDate[]"></td>

				<td><input class="form-control border_hide" type="text"  id="qCDeviationNo_' . $SrNo_Ex . '" name="qCDeviationNo[]"></td>

				<td><input class="form-control border_hide" type="text"  id="qCDeviationResion_' . $SrNo_Ex . '" name="qCDeviationResion[]"></td>

				<td><input class="border_hide form-control" type="text"  id="qCStsRemark1_' . $SrNo_Ex . '" name="qCStsRemark1[]" class="form-control" value=""></td>
			</tr>';


	if (!empty($qcAttach)) {
		for ($j = 0; $j < count($qcAttach); $j++) {
			$SrNo = $j + 1;
			// <tr>
			$FinalResponce['qcAttach'] .= '<tr>
						<td class="desabled">' . $SrNo . '</td>
						<td class="desabled"><input class="border_hide desabled" type="text" id="targetPath' . $SrNo . '" name="targetPath[]" class="form-control" value="' . $qcAttach[$j]->TargetPath . '" readonly>
						</td>
						<td class="desabled"><input class="border_hide desabled" type="text" id="fileName' . $SrNo . '" name="fileName[]"  class="form-control" value="' . $qcAttach[$j]->FileName . '" readonly></td>
						<td class="desabled"><input class="border_hide desabled" type="text" id="attachDate' . $SrNo . '" name="attachDate[]"  class="form-control" value="' . $qcAttach[$j]->AttachDate . '" readonly></td>
						<td><input class="border_hide" type="text" id="freeText' . $SrNo . '" name="freeText[]"  class="form-control" value="' . $qcAttach[$j]->FreeText . '"></td>
					</tr>';
		}
	} else {
		$FinalResponce['qcAttach'] .= '<tr><td colspan="12" style="color:red;text-align: center;">No Record Found</td></tr>';
	}

	// echo "<pre>";
	// print_r($FinalResponce);
	// echo "</pre>";
	// exit;
	echo json_encode($FinalResponce);
	exit(0);





	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";

	//   exit;
	// echo json_encode($response);
	// exit(0);
}



if (isset($_POST['addQcPostDocumentBtn_RouteStage'])) {

	$tdata = array(); // This array send to AP Standalone Invoice process 

	$tdata['Object'] = trim(addslashes(strip_tags('SCS_QCRSTAGE')));
	$tdata['U_PC_BLin'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_DocNo'])));
	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_BPLId'])));
	$tdata['U_PC_LocCode'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_LocCode'])));
	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_Location'])));
	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_branch'])));
	$tdata['U_PC_WONo'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_wono'])));
	$tdata['U_PC_WOEnt'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_woEntry'])));
	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_ItemCode'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_ItemName'])));
	$tdata['U_PC_GName'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_GenericName'])));
	$tdata['U_PC_LClaim'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_LabelCliam'])));
	$tdata['U_PC_LClmUom'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_LabelCliamUOM'])));
	$tdata['U_PC_RecQty'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_RecievedQty'])));
	$tdata['U_PC_MfgBy'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_MfgBy'])));
	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_BatchNo'])));
	$tdata['U_PC_BSize'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_BatchSize'])));
	$tdata['U_PC_MfgDt'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_MfgDate'])));
	$tdata['U_PC_ExpDt'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_ExpiryDate'])));
	$tdata['U_PC_SIntNo'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_SampleIntima'])));
	$tdata['U_PC_SColNo'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_SampleColl'])));
	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_SampleQty'])));
	$tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_RetainQty'])));
	$tdata['U_PC_PckSize'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_PackSize'])));
	$tdata['U_PC_SamType'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_SampleType'])));
	$tdata['U_PC_MType'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_MaterialType'])));
	$tdata['U_PC_PDate'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_PostingDate'])));
	$tdata['U_PC_ADate'] = trim(addslashes(strip_tags($_POST['name="qc_post_doc_Routestage_AnalysisDate"'])));
	$tdata['U_PC_NoCont'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_NoContainer'])));
	$tdata['U_PC_QCTType'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_QCTesttype'])));
	$tdata['U_PC_Stage'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_stage'])));
	$tdata['U_PC_ValUp'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_ValidUpTo'])));
	$tdata['U_PC_ArNo'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_ARNo'])));
	$tdata['U_PC_GENo'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_GateEntryNo'])));
	$tdata['U_PC_APot'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_AssayPotency'])));
	$tdata['U_PC_LODWater'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_LODWater'])));
	$tdata['U_PC_Potency'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_Potency'])));
	$tdata['U_PC_CompBy'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_CompiledBy'])));
	$tdata['U_PC_ChkBy'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_CheckedBy'])));
	$tdata['U_PC_AnlBy'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_AnalysisBy'])));
	$tdata['U_PC_Remarks'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_Remarks'])));
	$tdata['U_PC_AsyCal'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_AssayCalc'])));
	$tdata['U_PC_Factor'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_Factor'])));
	$tdata['U_PC_SpcNo'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_SpecificationNo'])));
	$tdata['U_PC_RelDt'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_ReleaseDate'])));
	// $tdata['U_PC_RetstDt'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_RetestDate'])));
	$tdata['U_PC_RMQC'] = trim(addslashes(strip_tags($_POST['qc_post_doc_Routestage_RMWQC'])));

	$tdata['U_PC_NoCont1'] = null;
	$tdata['U_PC_NoCont2'] = null;
	$tdata['U_PC_GDEntry'] = null;
	$tdata['U_PC_RfBy'] = null;
	$tdata['U_PC_SType'] = null;
	$tdata['U_PC_WoDate'] = null;

	$ganaralData = array();
	for ($i = 0; $i < count($_POST['parameter_code']); $i++) {
		$ganaralData['LineId'] = 0;
		$ganaralData['Object'] = trim(addslashes(strip_tags('SCS_QCRSTAGE')));
		$ganaralData['U_PC_PCode'] = trim(addslashes(strip_tags($_POST['parameter_code'][$i])));
		$ganaralData['U_PC_PName'] = trim(addslashes(strip_tags($_POST['PName'][$i])));
		$ganaralData['U_PC_Std'] = trim(addslashes(strip_tags($_POST['Standard'][$i])));
		$ganaralData['U_PC_Rel'] = trim(addslashes(strip_tags($_POST['Release'][$i])));
		$ganaralData['U_PC_PDTyp'] = trim(addslashes(strip_tags($_POST['PDType'][$i])));
		$ganaralData['U_PC_DDtl'] = trim(addslashes(strip_tags($_POST['descriptive_details'][$i])));
		$ganaralData['U_PC_Logi'] = trim(addslashes(strip_tags($_POST['logical'][$i])));
		$ganaralData['U_PC_LwMin'] = trim(addslashes(strip_tags($_POST['LowMin'][$i])));
		$ganaralData['U_PC_LwMax'] = trim(addslashes(strip_tags($_POST['LowMax'][$i])));
		$ganaralData['U_PC_UpMin'] = trim(addslashes(strip_tags($_POST['UppMin'][$i])));
		$ganaralData['U_PC_UpMax'] = trim(addslashes(strip_tags($_POST['UppMax'][$i])));
		$ganaralData['U_PC_Min'] = trim(addslashes(strip_tags($_POST['Min'][$i])));
		$ganaralData['U_PC_LMin1'] = trim(addslashes(strip_tags($_POST['lower_min_result'][$i])));
		$ganaralData['U_PC_LMax1'] = trim(addslashes(strip_tags($_POST['lower_max_result'][$i])));
		$ganaralData['U_PC_UMin1'] = trim(addslashes(strip_tags($_POST['upper_min_result'][$i])));
		$ganaralData['U_PC_UMax1'] = trim(addslashes(strip_tags($_POST['upper_max_result'][$i])));
		$ganaralData['U_PC_Min1'] = trim(addslashes(strip_tags($_POST['mean'][$i])));
		$ganaralData['U_PC_Rotpt'] = trim(addslashes(strip_tags($_POST['result_output'][$i])));
		$ganaralData['U_PC_Rmrks'] = trim(addslashes(strip_tags($_POST['remarks'][$i])));
		$ganaralData['U_PC_QCSts'] = trim(addslashes(strip_tags($_POST['qC_status_by_analyst'][$i])));
		$ganaralData['U_PC_TMeth'] = trim(addslashes(strip_tags($_POST['TMethod'][$i])));
		$ganaralData['U_PC_MType'] = trim(addslashes(strip_tags($_POST['MType'][$i])));
		$ganaralData['U_PC_UTxt1'] = trim(addslashes(strip_tags($_POST['user_text1_'][$i])));
		$ganaralData['U_PC_UTxt2'] = trim(addslashes(strip_tags($_POST['user_text2_'][$i])));
		$ganaralData['U_PC_UTxt3'] = trim(addslashes(strip_tags($_POST['user_text3_'][$i])));
		$ganaralData['U_PC_UTxt4'] = trim(addslashes(strip_tags($_POST['user_text4_'][$i])));
		$ganaralData['U_PC_UTxt5'] = trim(addslashes(strip_tags($_POST['user_text5_'][$i])));
		$ganaralData['U_PC_QCRmk'] = trim(addslashes(strip_tags($_POST['qCStsRemark1'][$i])));
		$ganaralData['U_PC_UOM'] = trim(addslashes(strip_tags($_POST['GDUOM'][$i])));
		$ganaralData['U_PC_Rtst'] = trim(addslashes(strip_tags($_POST['Retest'][$i])));
		$ganaralData['U_PC_Stab'] = trim(addslashes(strip_tags($_POST['GDStab'][$i])));
		$ganaralData['U_PC_ExtrS'] = trim(addslashes(strip_tags($_POST['ExSample'][$i])));
		$ganaralData['U_PC_ApAsy'] = trim(addslashes(strip_tags($_POST['Appassay'][$i])));
		$ganaralData['U_PC_ApLOD'] = trim(addslashes(strip_tags($_POST['AppLOD'][$i])));
		$ganaralData['U_PC_AnyBy'] = trim(addslashes(strip_tags($_POST['qc_analysis_by'][$i])));
		$ganaralData['U_PC_ARmrk'] = trim(addslashes(strip_tags($_POST['analyst_remark'][$i])));
		$ganaralData['U_PC_InCod'] = trim(addslashes(strip_tags($_POST['instrument_code'][$i])));
		$ganaralData['U_PC_InNam'] = trim(addslashes(strip_tags($_POST['InsName'][$i])));
		$ganaralData['U_PC_SDt'] = trim(addslashes(strip_tags($_POST['star_date'][$i])));
		$ganaralData['U_PC_STime'] = trim(addslashes(strip_tags($_POST['start_time'][$i])));
		$ganaralData['U_PC_EDate'] = trim(addslashes(strip_tags($_POST['end_date'][$i])));
		$ganaralData['U_PC_ETime'] = trim(addslashes(strip_tags($_POST['end_time'][$i])));
		$ganaralData['U_PC_PhStd'] = null;

		$tdata['SCS_QCRSTAGE1Collection'][] = $ganaralData; // row data append on this array
	}

	$qcStatus = array();
	for ($j = 0; $j < count($_POST['qc_Status']); $j++) {
		$qcStatus['U_PC_Stus'] = trim(addslashes(strip_tags($_POST['qc_Status'][$j])));
		$qcStatus['U_PC_Qty'] = trim(addslashes(strip_tags($_POST['qCStsQty'][$j])));
		$qcStatus['U_PC_RelDt'] = (!empty($_POST['qCReleaseDate'][$j])) ? date("Y-m-d", strtotime($_POST['qCReleaseDate'][$j])) : null;

		if (!empty($_POST['qCitNo'][$j])) {
			$qcStatus['U_PC_ITNo'] = trim(addslashes(strip_tags($_POST['qCitNo'][$j])));
		}

		$qcStatus['U_PC_DBy'] = trim(addslashes(strip_tags($_POST['doneBy'][$j])));
		$qcStatus['U_PC_Rmrk1'] = trim(addslashes(strip_tags($_POST['qCStsRemark1'][$j])));

		$qcStatus['U_PC_Atch1'] = (!empty($_FILES['qCAttache1']['name'][$j])) ? $_FILES['qCAttache1']['name'][$j] : $_POST['qCAttache1'][$j];
		$qcStatus['U_PC_Atch2'] = (!empty($_FILES['qCAttache2']['name'][$j])) ? $_FILES['qCAttache2']['name'][$j] : $_POST['qCAttache2'][$j];
		$qcStatus['U_PC_Atch3'] = (!empty($_FILES['qCAttache3']['name'][$j])) ? $_FILES['qCAttache3']['name'][$j] : $_POST['qCAttache3'][$j];

		$qcStatus['U_PC_DvDt'] = (!empty($_POST['qCDeviationDate'][$j])) ? date("Y-m-d", strtotime($_POST['qCDeviationDate'][$j])) : null;
		$qcStatus['U_PC_DvNo'] = trim(addslashes(strip_tags($_POST['qCDeviationNo'][$j])));
		$qcStatus['U_PC_DvRsn'] = trim(addslashes(strip_tags($_POST['qCDeviationResion'][$j])));

		// <!-- ------ File upload code start here ----------------------------- -->
		$uploadDir = '../include/uploads/';

		$uploadFile = $uploadDir . basename($_FILES['qCAttache1']['name'][$j]);
		move_uploaded_file($_FILES['qCAttache1']['tmp_name'][$j], $uploadFile);

		$uploadFile2 = $uploadDir . basename($_FILES['qCAttache2']['name'][$j]);
		move_uploaded_file($_FILES['qCAttache2']['tmp_name'][$j], $uploadFile2);

		$uploadFile3 = $uploadDir . basename($_FILES['qCAttache3']['name'][$j]);
		move_uploaded_file($_FILES['qCAttache3']['tmp_name'][$j], $uploadFile3);
		// <!-- ------ File upload code start here ----------------------------- -->

		$tdata['SCS_QCRSTAGE2Collection'][] = $qcStatus; // row data append on this array
	}

	$qcAttech = array();
	for ($k = 0; $k < count($_POST['targetPath']); $k++) {
		$qcAttech['LineId'] = trim(addslashes(strip_tags($_POST['targetPath'][$k])));
		$qcAttech['Object'] = trim(addslashes(strip_tags('SCS_QCRSTAGE')));
		$qcAttech['U_PC_TrgPt'] = trim(addslashes(strip_tags($_POST['targetPath'][$k])));
		$qcAttech['U_PC_FName'] = trim(addslashes(strip_tags($_POST['fileName'][$k])));
		$qcAttech['U_PC_AtcDt'] = trim(addslashes(strip_tags($_POST['attachDate'][$k])));
		$qcAttech['U_PC_FText'] = trim(addslashes(strip_tags($_POST['freeText'][$k])));

		$tdata['SCS_QCRSTAGE3Collection'][] = $qcAttech; // row data append on this array
	}

	$mainArray = $tdata; // all child array append in main array define here

	// <!-- ------------- form validation start here -------------------------------------------- -->
	if (empty($_POST['qc_post_doc_Routestage_SampleType'])) {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Sample Type is required.';
		echo json_encode($data);
		exit;
	}

	if (empty($_POST['qc_post_doc_Routestage_PostingDate'])) {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Posting Date is required.';
		echo json_encode($data);
		exit;
	}

	// if (empty($_POST['qc_post_doc_Routestage_AnalysisDate'])){
	// 	$data['status'] = 'False';
	// 	$data['DocEntry'] = '';
	// 	$data['message'] = 'Analysis Date is required.';
	// 	echo json_encode($data);
	// 	exit;
	// }

	// if (empty($_POST['qc_post_doc_Routestage_ValidUpTo'])) {
	// 	$data['status'] = 'False';
	// 	$data['DocEntry'] = '';
	// 	$data['message'] = 'ValidUpTo Date is required.';
	// 	echo json_encode($data);
	// 	exit;
	// }
	// <!-- ------------- form validation end here ---------------------------------------------- -->

	// service laye function and SAP loin & logout function define start here -------------------------------------------------------
	$res = $obj->SAP_Login();
	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_QCRSTAGE . '(' . $_POST['qc_post_doc_Routestage_DocEntry'] . ')';
		$responce_encode = $obj->PATCH_ServiceLayerMasterFunctionWithB1Replace($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		// <!-- ------- service layer function responce manage Start Here ------------ -->
		if (empty($responce)) {
			$data['status'] = 'True';
			$data['DocEntry'] = $_POST['qc_post_doc_Routestage_DocEntry'];
			$data['message'] = "QC Post document (QC Check) - Route Stage Successfully Updated.";
			echo json_encode($data);
		} else {
			if (array_key_exists('error', (array)$responce)) {
				$data['status'] = 'False';
				$data['DocEntry'] = '';
				$data['message'] = $responce->error->message->value;
				echo json_encode($data);
			}
		}
		// <!-- ------- service layer function responce manage End Here -------------- -->
	}
	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	// service laye function and SAP loin & logout function define end here -------------------------------------------------------
}


if (isset($_POST['action']) && $_POST['action'] == 'OT_PoPup_QCPO_Stability_ajax')  // API Ser No 40 somthing wrong
{
	$API = $OPENTRANSQCDOCSTABILITY_API . '&DocEntry=' . $_POST['DocEntry'] . '&ItemCode=' . $_POST['ItemCode'] . '&BatchNo=' . $_POST['BatchNo'] . '&SampleColNo=' . $_POST['SampleColNo'];

	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	$response = $obj->get_OTFSI_SingleData($FinalAPI);

	$FinalResponce['SampleCollDetails'] = $response;


	$general_data = $response[0]->STABQCPOSTROWDETAILS;
	// $qcStatus=$response[0]->QCPOSTDOCQCSTATUS; // Etra issue response seperate here 
	// $qcAttach=$response[0]->QCPOSTDOCATTACH; //External issue reponce seperate here
	// echo "<pre>";
	//    print_r($response);
	//    	echo "</pre>";
	//    	exit;
	// <!-- ----------- Extra Issue Start here --------------------------------- -->

	if (!empty($general_data)) {
		for ($i = 0; $i < count($general_data); $i++) {
			$SrNo = $i;
			$index = $i + 1;

			$FinalResponce['general_data'] .= '<tr>
					<td class="desabled">' . $index . '</td>

					<td><input  type="text" class="form-control" id="parameter_code' . $SrNo . '" name="parameter_code[]" value="' . $general_data[$i]->PCode . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="PName' . $SrNo . '" name="PName[]" value="' . $general_data[$i]->PName . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="Standard' . $SrNo . '" name="Standard[]" value="' . $general_data[$i]->Standard . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="Release' . $SrNo . '" name="Release[]" value="' . $general_data[$i]->Release . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="PDType' . $SrNo . '" name="PDType[]" value="' . $general_data[$i]->PDType . '" readonly></td>

					<td><input  type="text" class="form-control" id="descriptive_details' . $SrNo . '" name="descriptive_details[]" value="' . $general_data[$i]->DesDetils . '"></td>

					<td><input  type="text" class="form-control" id="logical' . $SrNo . '" name="logical[]" value="' . $general_data[$i]->Logical . '"></td>

					<td class="desabled"><input  type="text" class="form-control" id="LowMin' . $SrNo . '" name="LowMin[]" value="' . $general_data[$i]->LowMin . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="LowMax' . $SrNo . '" name="LowMax[]" value="' . $general_data[$i]->LowMax . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="UppMin' . $SrNo . '" name="UppMin[]" value="' . $general_data[$i]->UppMin . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="UppMax' . $SrNo . '" name="UppMax[]" value="' . $general_data[$i]->UppMax . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="Min' . $SrNo . '" name="Min[]" value="' . $general_data[$i]->Min . '" readonly></td>



					<td><input  type="text" id="lower_min_result' . $SrNo . '" name="lower_min_result[]" onfocusout="CalculateResultOut(' . $SrNo . ')" class="form-control" value=""></td>

					<td><input  type="text" id="lower_max_result' . $SrNo . '" name="lower_max_result[]" class="form-control" value=""></td>

					<td><input type="text" id="upper_min_result' . $SrNo . '" name="upper_min_result[]" class="form-control" value=""></td>

					<td><input  type="text" id="upper_max_result' . $SrNo . '" name="upper_max_result[]" class="form-control" value=""></td>

					<td ><input type="text" id="mean' . $SrNo . '" name="mean[]" class="form-control" value=""></td>


					<td id="ResultOutTd' . $SrNo . '">
						<select id="result_output' . $SrNo . '" name="result_output[]" class="form-select dropdownResutl' . $SrNo . '" onchange="ManualSelectedTResultOut(' . $SrNo . ')"></select>
					</td>

					<td ><input type="text" id="remarks' . $SrNo . '" name="remarks[]" class="form-control" value="' . $general_data[$i]->Remarks . '"></td>

					<td id="QC_StatusByAnalystTd' . $SrNo . '">
						<select id="qC_status_by_analyst' . $SrNo . '" name="qC_status_by_analyst[]" class="form-select qc_statusbyab' . $SrNo . '" onchange="SelectedQCStatus(' . $SrNo . ')">
						</select>
					</td>

					<td class="desabled"><input  type="text" class="form-control" id="TMethod' . $SrNo . '" name="TMethod[]" value="' . $general_data[$i]->TMethod . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control" id="MType' . $SrNo . '" name="MType[]" value="' . $general_data[$i]->MType . '" readonly></td>




					<td><input type="text" id="user_text1_' . $SrNo . '" name="user_text1_[]" class="form-control" value=""></td>

					<td><input type="text" id="user_text2_' . $SrNo . '" name="user_text2_[]" class="form-control" value=""></td>

					<td><input type="text" id="user_text3_' . $SrNo . '" name="user_text3_[]" class="form-control" value=""></td>

					<td><input type="text" id="user_text4_' . $SrNo . '" name="user_text4_[]" class="form-control" value=""></td>

					<td ><input type="text" id="user_text5_' . $SrNo . '" name="user_text5_[]" class="form-control" value=""></td>



				<td class="desabled"><input type="text" id="GDQCStatus' . $SrNo . '" name="GDQCStatus[]" class="form-control" value="Complies"></td>

					<td class="desabled"><input type="text" id="GDUOM' . $SrNo . '" name="GDUOM[]" class="form-control" value="' . $general_data[$i]->UOM . '" readonly></td>

					<td class="desabled"><input type="text" id="Retest' . $SrNo . '" name="Retest[]" class="form-control" value="' . $general_data[$i]->Retest . '" readonly></td>

					<td class="desabled"><input type="text" id="GDStab' . $SrNo . '" name="GDStab[]" class="form-control" value="" readonly></td>

					<td class="desabled"><input type="text" id="ExSample' . $SrNo . '" name="ExSample[]" class="form-control" value="' . $general_data[$i]->ExSample . '" readonly></td>

					<td class="desabled"><input type="text" id="Appassay' . $SrNo . '" name="Appassay[]" class="form-control" value="' . $general_data[$i]->Appassay . '" readonly></td>

					<td class="desabled"><input type="text" id="AppLOD' . $SrNo . '" name="AppLOD[]" class="form-control" value="' . $general_data[$i]->AppLOD . '" readonly></td>

					<td><input  type="text" id="qc_analysis_by' . $SrNo . '" name="qc_analysis_by[]" class="form-control" value=""></td>

					<td><input  type="text" id="analyst_remark' . $SrNo . '" name="analyst_remark[]" class="form-control" value=""></td>

					<td ><input type="text" id="instrument_code' . $SrNo . '" name="instrument_code[]" class="form-control" value=""></td>

					<td class="desabled"><input type="text" id="InsName' . $SrNo . '" name="InsName[]" class="form-control" value="" readonly></td>

					<td><input  type="text" id="star_date' . $SrNo . '" name="star_date[]" class="form-control" value=""></td>

					<td><input  type="text" id="start_time' . $SrNo . '" name="start_time[]" class="form-control" value=""></td>

					<td ><input type="text" id="end_date' . $SrNo . '" name="end_date[]" class="form-control" value=""></td>

					<td ><input type="text" id="end_time' . $SrNo . '" name="end_time[]" class="form-control" value=""></td>

				</tr>';
		}
	} else {
		$FinalResponce['general_data'] .= '<tr><td colspan="7" style="color:red;text-align: center;">No Record Found</td></tr>';
	}

	$FinalResponce['count'] = count($general_data);



	$FinalResponce['qcStatus'] .= '<tr id="add-more_1">
			<td></td>
			<td><select id="qc_Status_1" name="qc_Status[]" class="form-select qc_status_selecte1"  onfocusout="addMore(1);"></select></td>
			<td><input class="border_hide" type="text"  id="qCStsQty_1" name="qCStsQty[]" class="form-control" onfocusout="addMore(1);"></td>
			<td><input class="border_hide" type="text"  id="qCitNo_1" name="qCitNo[]" class="form-control"></td>
			<td>
			<select id="doneBy_1" name="doneBy[]" class="form-select done-by-mo1"></select>
			</td>
			<td><input class="border_hide" type="text"  id="qCStsRemark1_1" name="qCStsRemark1[]" class="form-control" value=""></td>
		</tr>';




	$FinalResponce['qcAttach'] .= '<tr>
			<td class="desabled"></td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="targetPath" name="targetPath[]" class="form-control" value="" readonly>
			</td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="fileName" name="fileName[]"  class="form-control" value="" readonly></td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="attachDate" name="attachDate[]"  class="form-control" value="" readonly></td>
			<td><input class="border_hide" type="text" id="remark" name="remark[]"  class="form-control" value=""></td>
		</tr>';





	echo json_encode($FinalResponce);
	exit(0);
}



if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransferQC_Checke_Stability_In_ajax') {
	$DocEntry = trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API = $OPENTRANSQCDOCSTABILITY_API . '&DocEntry=' . $DocEntry;
	// exit;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// print_r($FinalAPI);die();
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {
		$option = '<tr>
				<td class="desabled">
					<input type="hidden" id="__tRFPEntry" name="__tRFPEntry" value="' . $response[0]->RouteStageRecoWODocEntry . '">
					<input type="hidden" id="it__BatchNo" name="it__BatchNo" value="' . $response[0]->BatchNo . '">
					1
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_retails_ItemCode" name="itP_retails_ItemCode" class="form-control" value="' . $response[0]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
				 <input class="border_hide textbox_bg" type="text" id="itP_retails_ItemName" name="itP_retails_ItemName" class="form-control" value="' . $response[0]->ItemName . '" readonly>
				
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg1" type="text" id="itP_retails_BQty" name="itP_retails_BQty" class="form-control" value="' . $response[0]->BatchQty . '" >
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_retails_FromWhs" name="itP_retails_FromWhs" class="form-control" value="' . $response[0]->RISSFromWhs . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_retails_ToWhs" name="itP_retails_ToWhs" class="form-control" value="' . $response[0]->WhsCode . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_retails_Loction" name="itP_retails_Loction" class="form-control" value="' . $response[0]->Loction . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_retails_RetainQtyUom" name="itP_retails_RetainQtyUom" class="form-control" value="' . $response[0]->RetainQtyUom . '" readonly>
				</td>
			</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}



if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransfer_stability_ajax') {

	$ItemCode = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs = trim(addslashes(strip_tags($_POST['WareHouse'])));
	$GRPODEnt = trim(addslashes(strip_tags($_POST['DocEntry'])));
	$BNo = trim(addslashes(strip_tags($_POST['BatchNo'])));

	// $afterSet=trim(addslashes(strip_tags($_POST['afterSet'])));
	// http://10.80.4.55:8081/API/SAP/STABILITYQCPOSTDOCCONTSEL?ItemCode=FG00001&WareHouse=DSPT-GEN&BatchNo=C0121197
	// ItemCode=P00003&WareHouse=RETN-WHS&DocEntry=297&BatchNo=BQ13
	// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API = $STABILITYQCPOSTDOCCONTSEL . '?ItemCode=' . $ItemCode . '&WareHouse=' . $FromWhs . '&BatchNo=' . $BNo;
	// http://10.80.4.55:8081/API/SAP/STABILITYQCPOSTDOCCONTSEL?ItemCode=FG00001&WareHouse=DSPT-GEN&BatchNo=C0121197
	// $API='http://10.80.4.55:8081/API/SAP/INPROCESSSAMINTICONTSEL?ItemCode=SFG00001&WareHouse=QCUT-GEN&DocEntry=359&BatchNo=asd';
	// 
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "<pre>";
	// exit;
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {

		for ($i = 0; $i < count($response); $i++) {

			if (!empty($response[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response[$i]->ExpDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response[$i]->ExpDate));
			} else {
				$ExpiryDate = '';
			}


			$option .= '
			<tr>
                
                <td style="text-align: center;">
					<input type="hidden" id="usercheckList_retails' . $i . '" name="usercheckList_retails[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response[$i]->BatchQty . '" id="itp_CS_retails' . $i . '" name="itp_CS_retails[]" style="width: 17px;height: 17px;" onclick="getSelectedContener_retails(' . $i . ')">
				</td>

                <td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode_retails' . $i . '" name="itp_ItemCode_retails[]" class="form-control" value="' . $response[$i]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName_retails' . $i . '" name="itp_ItemName_retails[]" class="form-control" value="' . $response[$i]->ItemName . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo_retails' . $i . '" name="itp_ContainerNo_retails[]" class="form-control" value="' . $response[$i]->ContainerNo . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche_retails' . $i . '" name="itp_Batch_retails[]" class="form-control" value="' . $response[$i]->BatchNum . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty_retails' . $i . '" name="itp_BatchQty_retails[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" readonly>


				</td>

				
				<td style="text-align: center;">
				   <input class="border_hide" type="text" id="SelectedQty_retails' . $i . '" name="SelectedQty_retails[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" onfocusout="EnterQtyValidation_retails(' . $i . ')">

				  
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate_retails' . $i . '" name="itp_MfgDate_retails[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate_retails' . $i . '" name="itp_ExpiryDate_retails[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$option .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum_retails" name="cs_selectedQtySum_retails" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}


if (isset($_POST['stability_SubIT_Btn_post_doc'])) {

	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['s_InventoryTransfer_series'])));
	$tdata['DocDate'] = date("Y-m-d", strtotime($_POST['s_InventoryTransfer_PostingDate']));
	$tdata['DueDate'] = date("Y-m-d", strtotime($_POST['s_InventoryTransfer_DocumentDate']));
	$tdata['CardCode'] = null; //trim(addslashes(strip_tags($_POST['it_SupplierCode'])));
	$tdata['Comments'] = null;
	$tdata['FromWarehouse'] = trim(addslashes(strip_tags($_POST['itP_retails_FromWhs'])));
	$tdata['ToWarehouse'] = trim(addslashes(strip_tags($_POST['itP_retails_ToWhs'])));
	$tdata['TaxDate'] = date("Y-m-d", strtotime($_POST['s_InventoryTransfer_DocumentDate']));
	$tdata['DocObjectCode'] = trim(addslashes(strip_tags('67')));

	$tdata['BPLID'] = trim(addslashes(strip_tags($_POST['s_InventoryTransfer_BPLId'])));
	$tdata['U_PC_SISTAB'] = trim(addslashes(strip_tags($_POST['s_InventoryTransfer_DocEntry'])));
	$tdata['U_BFType'] = trim(addslashes(strip_tags($_POST['s_InventoryTransfer_BaseDocType'])));  //SCS_SISTAB

	$mainArray = $tdata;
	// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum'] = trim(addslashes(strip_tags('0')));
	$item['ItemCode'] = trim(addslashes(strip_tags($_POST['itP_retails_ItemCode'])));
	$item['WarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_retails_ToWhs'])));
	$item['FromWarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_retails_FromWhs'])));
	$item['Quantity'] = trim(addslashes(strip_tags($_POST['itP_retails_BQty'])));

	// <!-- Item Batch row data prepare start here ----------- -->
	$BL = 0; //skip array avoid and count continue
	for ($i = 0; $i < count($_POST['usercheckList']); $i++) {

		if ($_POST['usercheckList'][$i] == '1') {

			$batch['BatchNumber'] = trim(addslashes(strip_tags($_POST['itp_ContainerNo_retails'][$i])));
			$batch['Quantity'] = trim(addslashes(strip_tags($_POST['SelectedQty_retails[]'][$i])));
			$batch['BaseLineNumber'] = trim(addslashes(strip_tags('0')));
			$batch['ItemCode'] = trim(addslashes(strip_tags($_POST['itp_ItemCode_retails[]'][$i])));

			$item['BatchNumbers'][] = $batch;
			$BL++; // increment variable define here
		}
	}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['StockTransferLines'][] = $item;

	// echo "<pre>";
	// print_r($mainArray);
	// echo "</pre>";
	// exit;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->

	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_StockTransfers;

		$responce_encode = $objKri->SaveSampleIntimation_kris($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {

			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['it_DocEntry'])));
			$UT_data['U_PC_UTTrans'] = trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_QCSTAB . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $objKri->SampleIntimationUnderTestUpdateFromInventoryTransfer_kri($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			if ($underTestNumber_decode == '') {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Inventory Transfer Successfully Added.";
				echo json_encode($data);
			} else {

				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	// <!-- ------------- function & function responce code end Here ---- -->

}




if (isset($_POST['updateQcPostDocumentStabilitytBtn'])) {

	//   // echo "<pre>";
	//   // print_r($_POST);
	//   // echo "</pre>";
	//   // exit;

	$tdata = array(); // This array send to AP Standalone Invoice process 
	$tdata['Series'] = trim(addslashes(strip_tags($_POST['DocNo1'])));
	$tdata['Object'] = 'SCS_QCSTAB';
	// 	$tdata['U_PC_BLin']=trim(addslashes(strip_tags($_POST['LineNum'])));
	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['U_PC_BPLId'])));
	$tdata['U_PC_LocCode'] = trim(addslashes(strip_tags($_POST['U_PC_LocCode'])));
	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['U_PC_Loc'])));
	$tdata['U_PC_RNo'] = trim(addslashes(strip_tags($_POST['U_PC_RNo'])));
	$tdata['U_PC_REnt'] = trim(addslashes(strip_tags($_POST['U_PC_REnt'])));
	$tdata['U_PC_WoNo'] = trim(addslashes(strip_tags($_POST['U_PC_WoNo'])));
	$tdata['U_PC_WoEnt'] = trim(addslashes(strip_tags($_POST['U_PC_WoEnt'])));
	//    $tdata['U_PC_GRNNo']=trim(addslashes(strip_tags($_POST['qcD_GRPONo'])));
	//    $tdata['U_PC_GRNEnt']=trim(addslashes(strip_tags($_POST['GRPODocEntry'])));

	// $tdata['U_PC_SCode']=trim(addslashes(strip_tags($_POST['qcD_SupplierCode'])));
	//    $tdata['U_PC_SName']=trim(addslashes(strip_tags($_POST['qcD_SupplierName'])));
	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['qcD_ItemCode'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['qcD_ItemName'])));

	$tdata['U_PC_GName'] = trim(addslashes(strip_tags($_POST['qcD_GenericName'])));
	$tdata['U_PC_LClaim'] = trim(addslashes(strip_tags($_POST['qcD_LabelClaim'])));
	$tdata['U_PC_LClmUom'] = trim(addslashes(strip_tags($_POST['qcD_LabelClaimUOM'])));
	$tdata['U_PC_RecQty'] = trim(addslashes(strip_tags($_POST['qcD_RetainQty'])));

	$tdata['U_PC_MfgBy'] = trim(addslashes(strip_tags($_POST['qcD_MfgBy'])));
	$tdata['U_PC_RfBy'] = trim(addslashes(strip_tags($_POST['qcD_RefNo'])));
	$tdata['U_PC_SType'] = trim(addslashes(strip_tags($_POST['U_PC_SType'])));

	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['qcD_BatchNo'])));

	$tdata['U_PC_BSize'] = trim(addslashes(strip_tags($_POST['qcD_BatchQty'])));
	$tdata['U_PC_MfgDt'] = trim(addslashes(strip_tags($_POST['qcD_MfgDate'])));
	$tdata['U_PC_ExpDt'] = trim(addslashes(strip_tags($_POST['qcD_ExpiryDate'])));
	$tdata['U_PC_SIntNo'] = trim(addslashes(strip_tags($_POST['qcD_SampleIntimationNo'])));

	$tdata['U_PC_SColNo'] = trim(addslashes(strip_tags($_POST['qcD_SampleCollectionNo'])));
	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['qcD_SampleQty'])));
	$tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['qcD_RQty'])));

	$tdata['U_PC_PckSize'] = trim(addslashes(strip_tags($_POST['qcD_PckSize'])));

	$tdata['U_PC_SamType'] = trim(addslashes(strip_tags($_POST['qcD_SamType'])));
	$tdata['U_PC_MType'] = trim(addslashes(strip_tags($_POST['qcD_MatType'])));
	$tdata['U_PC_PDate'] = trim(addslashes(strip_tags($_POST['qcD_PostingDate'])));

	$tdata['U_PC_ADate'] = trim(addslashes(strip_tags($_POST['qcD_ADate'])));
	$tdata['U_PC_NoCont'] = trim(addslashes(strip_tags($_POST['qcD_NoCont'])));
	// $tdata['U_PC_QCTType']=trim(addslashes(strip_tags($_POST['qcD_QCTType'])));
	$tdata['U_PC_Stage'] = trim(addslashes(strip_tags($_POST['qcD_Stage'])));


	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['qcD_Branch'])));
	$tdata['U_PC_ValUp'] = trim(addslashes(strip_tags($_POST['qcD_ValidUpto'])));
	$tdata['U_PC_ArNo'] = trim(addslashes(strip_tags($_POST['qcD_ARNo'])));
	$tdata['U_PC_GENo'] = trim(addslashes(strip_tags($_POST['qcD_GateENo'])));

	$tdata['U_PC_GDEntry'] = trim(addslashes(strip_tags($_POST['U_PC_GDEntry'])));
	$tdata['U_PC_APot'] = trim(addslashes(strip_tags($_POST['AssayPotency_xyz'])));

	$tdata['U_PC_LODWater'] = trim(addslashes(strip_tags($_POST['LoD_Water_xyz'])));
	$tdata['U_PC_Potency'] = trim(addslashes(strip_tags($_POST['potency_xyz'])));
	$tdata['U_PC_CompBy'] = trim(addslashes(strip_tags($_POST['qc_post_compiled_by'])));
	$tdata['U_PC_NoCont1'] = trim(addslashes(strip_tags($_POST['noOfCont1'])));
	$tdata['U_PC_NoCont2'] = trim(addslashes(strip_tags($_POST['noOfCont2'])));
	$tdata['U_PC_ChkBy'] = trim(addslashes(strip_tags($_POST['checked_by'])));
	$tdata['U_PC_AnlBy'] = trim(addslashes(strip_tags($_POST['analysis_by'])));

	// // $tdata['U_GRPONo']=trim(addslashes(strip_tags($_POST['qcD_GRPONo'])));
	// // $tdata['U_GRPODEnt']=trim(addslashes(strip_tags($_POST['U_GRPODEnt'])));

	$tdata['U_PC_Remarks'] = trim(addslashes(strip_tags($_POST['qc_remarks'])));
	$tdata['U_PC_AsyCal'] = trim(addslashes(strip_tags($_POST['assay_append'])));
	$tdata['U_PC_Factor'] = trim(addslashes(strip_tags($_POST['factor'])));
	$tdata['U_PC_SpcNo'] = trim(addslashes(strip_tags($_POST['qcD_SpecfNo'])));
	$tdata['U_PC_GRQty'] = trim(addslashes(strip_tags($_POST['U_PC_GRQty'])));
	$tdata['U_PC_RelDt'] = trim(addslashes(strip_tags($_POST['U_PC_RelDt'])));
	$tdata['U_PC_RetstDt'] = trim(addslashes(strip_tags($_POST['U_PC_RetstDt'])));
	// $tdata['U_PC_RMQC']=trim(addslashes(strip_tags($_POST['U_PC_RMQC'])));

	$tdata['U_PC_RecQty'] = trim(addslashes(strip_tags($_POST['U_PC_RecQty'])));
	$tdata['U_PC_StType'] = trim(addslashes(strip_tags($_POST['U_PC_SType'])));
	$tdata['U_PC_StCon'] = trim(addslashes(strip_tags($_POST['U_PC_StCon'])));
	$tdata['U_PC_StTPer'] = trim(addslashes(strip_tags($_POST['U_PC_StTPer'])));
	$tdata['U_PC_AnType'] = trim(addslashes(strip_tags($_POST['U_PC_AnType'])));

	$tdata['U_PC_WhsCode'] = trim(addslashes(strip_tags($_POST['U_PC_WhsCode'])));
	$tdata['U_PC_BEnt'] = trim(addslashes(strip_tags($_POST['U_PC_BEnt'])));
	$tdata['U_PC_BNum'] = trim(addslashes(strip_tags($_POST['U_PC_BNum'])));
	$tdata['U_PC_StDNo'] = trim(addslashes(strip_tags($_POST['U_PC_StDNo'])));
	$tdata['U_PC_StDt'] = trim(addslashes(strip_tags($_POST['U_PC_StDt'])));
	$tdata['U_PC_StQty'] = trim(addslashes(strip_tags($_POST['U_PC_StQty'])));
	$tdata['U_PC_Unit'] = trim(addslashes(strip_tags($_POST['U_PC_Unit'])));

	$ganaralData = array();
	$BL = 0; //skip array avoid and count continue
	for ($i = 0; $i < count($_POST['parameter_code']); $i++) {


		$ganaralData['LineId'] = ($i + 1);
		$ganaralData['Object'] = 'SCS_QCSTAB';

		$ganaralData['U_PC_PCode'] = trim(addslashes(strip_tags($_POST['parameter_code'][$i])));
		$ganaralData['U_PC_PName'] = trim(addslashes(strip_tags($_POST['PName'][$i])));
		$ganaralData['U_PC_Std'] = trim(addslashes(strip_tags($_POST['Standard'][$i])));
		$ganaralData['U_PC_Rel'] = trim(addslashes(strip_tags($_POST['Release'][$i])));
		$ganaralData['U_PC_PDTyp'] = trim(addslashes(strip_tags($_POST['PDType'][$i])));
		$ganaralData['U_PC_DDtl'] = trim(addslashes(strip_tags($_POST['descriptive_details'][$i])));
		$ganaralData['U_PC_Logi'] = trim(addslashes(strip_tags($_POST['logical'][$i])));

		$ganaralData['U_PC_LwMin'] = trim(addslashes(strip_tags($_POST['LowMin'][$i])));
		$ganaralData['U_PC_LwMax'] = trim(addslashes(strip_tags($_POST['LowMax'][$i])));
		$ganaralData['U_PC_UpMin'] = trim(addslashes(strip_tags($_POST['UppMin'][$i])));
		$ganaralData['U_PC_UpMax'] = trim(addslashes(strip_tags($_POST['UppMax'][$i])));


		$ganaralData['U_PC_Min'] = trim(addslashes(strip_tags($_POST['Min'][$i])));
		$ganaralData['U_PC_LMin1'] = trim(addslashes(strip_tags($_POST['lower_min_result'][$i])));
		$ganaralData['U_PC_LMax1'] = trim(addslashes(strip_tags($_POST['lower_max_result'][$i])));

		$ganaralData['U_PC_UMin1'] = trim(addslashes(strip_tags($_POST['upper_min_result'][$i])));
		$ganaralData['U_PC_UMax1'] = trim(addslashes(strip_tags($_POST['upper_max_result'][$i])));
		$ganaralData['U_PC_Min1'] = trim(addslashes(strip_tags($_POST['mean'][$i])));
		$ganaralData['U_PC_Rmrks'] = trim(addslashes(strip_tags($_POST['remarks'][$i])));

		$ganaralData['U_PC_TMeth'] = trim(addslashes(strip_tags($_POST['TMethod'][$i])));
		$ganaralData['U_PC_MType'] = trim(addslashes(strip_tags($_POST['MType'][$i])));
		$ganaralData['U_PC_PhStd'] = '';
		$ganaralData['U_PC_UTxt1'] = trim(addslashes(strip_tags($_POST['user_text1_'][$i])));
		$ganaralData['U_PC_UTxt2'] = trim(addslashes(strip_tags($_POST['user_text2_'][$i])));
		$ganaralData['U_PC_UTxt3'] = trim(addslashes(strip_tags($_POST['user_text3_'][$i])));
		$ganaralData['U_PC_UTxt4'] = trim(addslashes(strip_tags($_POST['user_text4_'][$i])));
		$ganaralData['U_PC_UTxt5'] = trim(addslashes(strip_tags($_POST['user_text5_'][$i])));

		$ganaralData['U_PC_QCRmk'] = trim(addslashes(strip_tags($_POST['qCStsRemark1'][$i])));
		$ganaralData['U_PC_UOM'] = trim(addslashes(strip_tags($_POST['GDUOM'][$i])));
		$ganaralData['U_PC_Rtst'] = trim(addslashes(strip_tags($_POST['Retest'][$i])));
		$ganaralData['U_PC_Stab'] = trim(addslashes(strip_tags($_POST['GDStab'][$i])));
		$ganaralData['U_PC_ExtrS'] = trim(addslashes(strip_tags($_POST['ExSample'][$i])));
		$ganaralData['U_PC_ApAsy'] = trim(addslashes(strip_tags($_POST['Appassay'][$i])));
		$ganaralData['U_PC_ApLOD'] = trim(addslashes(strip_tags($_POST['AppLOD'][$i])));
		$ganaralData['U_PC_AnyBy'] = trim(addslashes(strip_tags($_POST['qc_analysis_by'][$i])));
		$ganaralData['U_PC_ARmrk'] = trim(addslashes(strip_tags($_POST['analyst_remark'][$i])));
		$ganaralData['U_PC_InCod'] = trim(addslashes(strip_tags($_POST['instrument_code'][$i])));
		$ganaralData['U_PC_InNam'] = trim(addslashes(strip_tags($_POST['InsName'][$i])));
		$ganaralData['U_PC_SDt'] = trim(addslashes(strip_tags($_POST['star_date'][$i])));
		$ganaralData['U_PC_STime'] = trim(addslashes(strip_tags($_POST['start_time'][$i])));
		$ganaralData['U_PC_EDate'] = trim(addslashes(strip_tags($_POST['end_date'][$i])));
		$ganaralData['U_PC_ETime'] = trim(addslashes(strip_tags($_POST['end_time'][$i])));
		// 		$ganaralData['U_PC_QCSts']=trim(addslashes(strip_tags($_POST['qC_status_by_analyst'][$i])));
		// 		$ganaralData['U_PC_Rotpt']=trim(addslashes(strip_tags($_POST['result_output'][$i])));

		$tdata['SCS_QCSTAB1Collection'][] = $ganaralData; // row data append on this array
		$BL++; // increment variable define here	
	}

	$qcStatus = array();
	$qcS = 0; //skip array avoid and count continue
	for ($j = 0; $j < count($_POST['qc_Status']); $j++) {

		$qcStatus['LineId'] = ($j + 1);
		$qcStatus['Object'] = 'SCS_QCSTAB';
		$qcStatus['U_PC_Stus'] = trim(addslashes(strip_tags($_POST['qc_Status'][$j])));
		$qcStatus['U_PC_Qty'] = trim(addslashes(strip_tags($_POST['qCStsQty'][$j])));
		$qcStatus['U_PC_ITNo'] = null;  //trim(addslashes(strip_tags($_POST['qCitNo'][$j])))
		$qcStatus['U_PC_DBy'] = trim(addslashes(strip_tags($_POST['doneBy'][$j])));
		$qcStatus['U_PC_Rmrk1'] = trim(addslashes(strip_tags($_POST['qCStsRemark1'][$j])));
		$qcStatus['U_PC_RelDt'] = '';
		$qcStatus['U_PC_RelTm'] = '';
		$qcStatus['U_PC_Atch1'] = '';
		$qcStatus['U_PC_Atch2'] = '';
		$qcStatus['U_PC_Atch3'] = '';
		$qcStatus['U_PC_DvDt'] = '';
		$qcStatus['U_PC_DvNo'] = '';
		$qcStatus['U_PC_DvRsn'] = '';

		$tdata['SCS_QCSTAB2Collection'][] = $qcStatus; // row data append on this array
		$qcS++;
	}

	$qcAttech = array();
	$qcatt = 0; //skip array avoid and count continue
	for ($k = 0; $k < count($_POST['targetPath']); $k++) {
		$qcAttech['LineId'] = ($k + 1);
		$qcAttech['Object'] = 'SCS_QCSTAB';
		$qcAttech['U_PC_TrgPt'] = trim(addslashes(strip_tags($_POST['targetPath'][$k])));
		$qcAttech['U_PC_FName'] = trim(addslashes(strip_tags($_POST['fileName'][$k])));
		$qcAttech['U_PC_AtcDt'] = trim(addslashes(strip_tags($_POST['attachDate'][$k])));
		$qcAttech['U_PC_FText'] = trim(addslashes(strip_tags($_POST['freeText'][$k])));

		$tdata['SCS_QCSTAB3Collection'][] = $qcAttech; // row data append on this array
		$qcatt++;
	}

	$mainArray = $tdata; // all child array append in main array define here
	// 	// echo "<pre>";
	// 	// print_r($mainArray);
	// 	// echo "</pre>";
	// 	// exit;
	// // service laye function and SAP loin & logout function define start here -------------------------------------------------------
	$res = $obj->SAP_Login();

	if (!empty($res)) {

		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_QCSTAB;

		$responce_encode = $objKri->qcPostDocumentRetestQc($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {
			$data['status'] = 'True';
			$data['DocEntry'] = $responce->DocEntry;
			$data['message'] = 'QC Post Document stability updated Successfully';
			echo json_encode($data);
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	// service laye function and SAP loin & logout function define end here -------------------------------------------------------
}




if (isset($_POST['action']) && $_POST['action'] == 'QCPostdocumentQCPost_Stability_row') {
	$API = $STABQCPOSTDOCUMENTDETAILS . '?DocEntry=' . $_POST['DocEntry'];
	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	$response = $obj->get_OTFSI_SingleData($FinalAPI);

	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";

	// exit;



	$FinalResponce['SampleCollDetails'] = $response;
	// <!-- ------ Array declaration End Here  --------------------------------- -->
	$general_data = $response[0]->STABQCPOSTDOCGENERALDATA;
	$qcStatus = $response[0]->STABQCPOSTDOCQCSTATUS; // Etra issue response seperate here 
	$qcAttach = $response[0]->STABQCPOSTDOCATTACH; //External issue reponce seperate here

	//    echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;

	if (!empty($general_data)) {
		for ($i = 0; $i < count($general_data); $i++) {
			$SrNo = $i;
			$index = $i + 1;

			$FinalResponce['general_data'] .= '<tr>
					<td class="desabled">' . $index . '</td>

					<td class="desabled"><input  type="text" class="form-control input_disable" id="parameter_code' . $SrNo . '" name="parameter_code[]" value="' . $general_data[$i]->PCode . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control input_disable" id="PName' . $SrNo . '" name="PName[]" value="' . $general_data[$i]->PName . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control input_disable" id="Specifiction' . $SrNo . '" name="Specifiction[]" value="' . $general_data[$i]->Specifiction . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control input_disable" id="Release' . $SrNo . '" name="Release[]" value="' . $general_data[$i]->Release . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control input_disable" id="PDType' . $SrNo . '" name="PDType[]" value="' . $general_data[$i]->PDType . '" readonly></td>

					<td><input  type="text" class="form-control" id="descriptive_details' . $SrNo . '" name="descriptive_details[]" value="' . $general_data[$i]->DesDetils . '"></td>

					<td><input  type="text" class="form-control" id="logical' . $SrNo . '" name="logical[]" value="' . $general_data[$i]->Logical . '" style="width: 100px;"></td>

					<td class="desabled"><input  type="text" class="form-control input_disable" id="LowMin' . $SrNo . '" name="LowMin[]" value="' . $general_data[$i]->LowMin . '" readonly style="width: 100px;"></td>

					<td class="desabled"><input  type="text" class="form-control input_disable" id="LowMax' . $SrNo . '" name="LowMax[]" value="' . $general_data[$i]->LowMax . '" readonly style="width: 100px;"></td>

					<td class="desabled"><input  type="text" class="form-control input_disable" id="UppMin' . $SrNo . '" name="UppMin[]" value="' . $general_data[$i]->UppMin . '" readonly style="width: 100px;"></td>

					<td class="desabled"><input  type="text" class="form-control input_disable" id="UppMax' . $SrNo . '" name="UppMax[]" value="' . $general_data[$i]->UppMax . '" readonly style="width: 100px;"></td>

					<td class="desabled"><input  type="text" class="form-control input_disable" id="Min' . $SrNo . '" name="Min[]" value="' . $general_data[$i]->Min . '" readonly style="width: 100px;"></td>

					<td><input  type="text" id="lower_min_result' . $SrNo . '" name="lower_min_result[]" onfocusout="CalculateResultOut(' . $SrNo . ')" class="form-control" value="' . $general_data[$i]->LowMin1 . '"></td>

					<td><input  type="text" id="lower_max_result' . $SrNo . '" name="lower_max_result[]" class="form-control" value="' . $general_data[$i]->LowMax1 . '"></td>

					<td><input  type="text" id="upper_min_result' . $SrNo . '" name="upper_min_result[]" class="form-control" value="' . $general_data[$i]->UppMin1 . '"></td>

					<td><input  type="text" id="upper_max_result' . $SrNo . '" name="upper_max_result[]" class="form-control" value="' . $general_data[$i]->UppMax1 . '"></td>

					<td ><input type="text" id="mean' . $SrNo . '" name="mean[]" class="form-control" value="' . $general_data[$i]->Min1 . '" style="width: 100px;"></td>

					<td id="ResultOutTd' . $SrNo . '">
						<select id="result_output' . $SrNo . '" name="result_output[]" class="form-select dropdownResutl' . $SrNo . '" onchange="ManualSelectedTResultOut(' . $SrNo . ')"><option value="' . $general_data[$i]->ROutput . '">' . $general_data[$i]->ROutput . '</option></select>
					</td>

					<td ><input type="text" id="remarks' . $SrNo . '" name="remarks[]" class="form-control" value="' . $general_data[$i]->Remarks . '"></td>

					<td id="QC_StatusByAnalystTd' . $SrNo . '">
						<select id="qC_status_by_analyst' . $SrNo . '" name="qC_status_by_analyst[]" class="form-select qc_statusbyab' . $SrNo . '" onchange="SelectedQCStatus(' . $SrNo . ')">
						</select>
					</td>

					<td class="desabled"><input  type="text" class="form-control input_disable" id="TMethod' . $SrNo . '" name="TMethod[]" value="' . $general_data[$i]->TMethod . '" readonly></td>

					<td class="desabled"><input  type="text" class="form-control input_disable" id="MType' . $SrNo . '" name="MType[]" value="' . $general_data[$i]->MType . '" readonly></td>

					<td><input type="text" id="user_text1_' . $SrNo . '" name="user_text1_[]" class="form-control" value="' . $general_data[$i]->UText1 . '"></td>

					<td><input type="text" id="user_text2_' . $SrNo . '" name="user_text2_[]" class="form-control" value="' . $general_data[$i]->UText2 . '"></td>

					<td><input type="text" id="user_text3_' . $SrNo . '" name="user_text3_[]" class="form-control" value="' . $general_data[$i]->UText3 . '"></td>

					<td><input type="text" id="user_text4_' . $SrNo . '" name="user_text4_[]" class="form-control" value="' . $general_data[$i]->UText4 . '"></td>

					<td ><input type="text" id="user_text5_' . $SrNo . '" name="user_text5_[]" class="form-control" value="' . $general_data[$i]->UText5 . '"></td>

					<td class="desabled"><input type="text" id="GDQCStatus' . $SrNo . '" name="GDQCStatus[]" class="form-control input_disable" value="' . $general_data[$i]->GDQCStatus . '" readonly></td>

					<td class="desabled"><input type="text" id="GDUOM' . $SrNo . '" name="GDUOM[]" class="form-control input_disable" value="' . $general_data[$i]->GDUOM . '" readonly></td>

					<td class="desabled"><input type="text" id="Retest' . $SrNo . '" name="Retest[]" class="form-control input_disable" value="' . $general_data[$i]->Retest . '" readonly></td>

					<td class="desabled"><input type="text" id="GDStab' . $SrNo . '" name="GDStab[]" class="form-control input_disable" value="' . $general_data[$i]->GDStab . '" readonly></td>

					<td class="desabled"><input type="text" id="ExSample' . $SrNo . '" name="ExSample[]" class="form-control input_disable" value="' . $general_data[$i]->ExSample . '" readonly></td>

					<td class="desabled"><input type="text" id="Appassay' . $SrNo . '" name="Appassay[]" class="form-control input_disable" value="' . $general_data[$i]->Appassay . '" readonly></td>

					<td class="desabled"><input type="text" id="AppLOD' . $SrNo . '" name="AppLOD[]" class="form-control input_disable" value="' . $general_data[$i]->AppLOD . '" readonly></td>

					<td><input  type="text" id="qc_analysis_by' . $SrNo . '" name="qc_analysis_by[]" class="form-control" value="' . $general_data[$i]->AnlBy . '"></td>

					<td><input  type="text" id="analyst_remark' . $SrNo . '" name="analyst_remark[]" class="form-control" value="' . $general_data[$i]->ARRemark . '"></td>

					<td ><input type="text" id="instrument_code' . $SrNo . '" name="instrument_code[]" class="form-control" value="' . $general_data[$i]->Inscode . '"></td>

					<td class="desabled"><input type="text" id="InsName' . $SrNo . '" name="InsName[]" class="form-control input_disable" value="' . $general_data[$i]->InsName . '" readonly></td>

					<td><input  type="text" id="star_date' . $SrNo . '" name="star_date[]" class="form-control" value="' . $general_data[$i]->SDate . '"></td>

					<td><input  type="text" id="start_time' . $SrNo . '" name="start_time[]" class="form-control" value="' . $general_data[$i]->STime . '"></td>

					<td ><input type="text" id="end_date' . $SrNo . '" name="end_date[]" class="form-control" value="' . $general_data[$i]->EDate . '"></td>

					<td ><input type="text" id="end_time' . $SrNo . '" name="end_time[]" class="form-control" value="' . $general_data[$i]->ETime . '"></td>

				</tr>';
		}
	} else {
		$FinalResponce['general_data'] .= '<tr><td colspan="7" style="color:red;text-align: center;">No Record Found</td></tr>';
	}

	$FinalResponce['count'] = count($general_data);


	if (!empty($qcStatus)) {
		for ($j = 0; $j < count($qcStatus); $j++) {
			$SrNo = $j + 1;

			$FinalResponce['qcStatus'] .= '<tr>
                    
                    <td class="desabled">' . $SrNo . '</td>

                    <td class="desabled"><input class="form-control border_hide desabled" type="text" id="qc_Status' . $SrNo . '" name="qc_Status[]" value="' . $qcStatus[$j]->QCStsStatus . '" readonly></td>

                    <td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsQty' . $SrNo . '" name="qCStsQty[]"  value="' . $qcStatus[$j]->QCStsQty . '" readonly></td>

                    <td class="desabled"><input  type="text" class="form-control border_hide desabled" id="qCitNo' . $SrNo . '" name="qCitNo[]"  value="' . $qcStatus[$j]->ItNo . '" readonly></td>

                    <td class="desabled"><input class="form-control border_hide desabled" type="text" id="doneBy' . $SrNo . '" name="doneBy[]"  value="' . $qcStatus[$j]->DBy . '" readonly></td>

                    <td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsRemark1' . $SrNo . '" name="qCStsRemark1[]"  value="' . $qcStatus[$j]->QCStsRemark1 . '" readonly></td>

				</tr>';
		}
	} else {
		// $FinalResponce['qcStatus'].='<tr><td colspan="12" style="color:red;text-align: center;">No Record Found</td></tr>';
	}

	$FinalResponce['qcStatus'] .= '<tr">
			<td>' . (count($qcStatus) + 1) . '</td>
			<td><select id="qc_Status_1" name="qc_Status[]" class="form-select qc_status_selecte1"></select></td>
			<td><input class="border_hide" type="text"  id="qCStsQty_1" name="qCStsQty[]" class="form-control" value=""></td>
			<td><input class="border_hide" type="text"  id="qCitNo_1" name="qCitNo[]" class="form-control" value=""></td>
			<td>
			<select id="doneBy_1" name="doneBy[]" class="form-select done-by-mo1"></select>
			</td>
			<td><input class="border_hide" type="text"  id="qCStsRemark1_1" name="qCStsRemark1[]" class="form-control" value=""></td>
		</tr>';


	if (!empty($qcAttach)) {
		for ($j = 0; $j < count($qcAttach); $j++) {
			$SrNo = $j + 1;
			// <tr>
			$FinalResponce['qcAttach'] .= '<tr>
					<td class="desabled">' . $SrNo . '</td>
					<td class="desabled"><input class="border_hide desabled" type="text" id="targetPath' . $SrNo . '" name="targetPath[]" class="form-control" value="' . $qcAttach[$j]->TargetPath . '" readonly>
					</td>
					<td class="desabled"><input class="border_hide desabled" type="text" id="fileName' . $SrNo . '" name="fileName[]"  class="form-control" value="' . $qcAttach[$j]->FileName . '" readonly></td>
					<td class="desabled"><input class="border_hide desabled" type="text" id="attachDate' . $SrNo . '" name="attachDate[]"  class="form-control" value="' . $qcAttach[$j]->AttachDate . '" readonly></td>
					<td><input class="border_hide" type="text" id="freeText' . $SrNo . '" name="freeText[]"  class="form-control" value="' . $qcAttach[$j]->FreeText . '"></td>
				</tr>';
		}
	} else {
		$FinalResponce['qcAttach'] .= '<tr><td colspan="12" style="color:red;text-align: center;">No Record Found</td></tr>';
	}

	// echo "<pre>";
	// print_r($FinalResponce);
	// echo "</pre>";
	// exit;
	echo json_encode($FinalResponce);
	exit(0);





	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";

	//   exit;
	// echo json_encode($response);
	// exit(0);
}




if (isset($_POST['addQcPostDocumentSubmitQCCheckBtnStability'])) {
	$tdata = array(); // This array send to AP Standalone Invoice process 
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;
	$tdata['Series'] = trim(addslashes(strip_tags($_POST['stability_Series'])));
	$tdata['Object'] = trim(addslashes(strip_tags('SCS_QCINPROC')));
	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['stability_BPLId'])));
	$tdata['U_PC_LocCode'] = trim(addslashes(strip_tags($_POST['stability_LocCode'])));
	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['stability_Loc'])));

	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['stability_Branch'])));
	$tdata['U_PC_RNo'] = trim(addslashes(strip_tags($_POST['stability_RefNo'])));
	$tdata['U_PC_REnt'] = null;
	$tdata['U_PC_WoNo'] = trim(addslashes(strip_tags($_POST['stability_WONo'])));
	$tdata['U_PC_WoEnt'] = trim(addslashes(strip_tags($_POST['stability_WOEntry'])));

	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['stability_ItemCode'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['stability_ItemName'])));

	$tdata['U_PC_GName'] = trim(addslashes(strip_tags($_POST['stability_GenericName'])));
	$tdata['U_PC_LClaim'] = trim(addslashes(strip_tags($_POST['stability_LabelClaim'])));
	$tdata['U_PC_LClmUom'] = trim(addslashes(strip_tags($_POST['stability_LabelClaimUOM'])));

	$tdata['U_PC_RecQty'] = null;

	$tdata['U_PC_MfgBy'] = trim(addslashes(strip_tags($_POST['stability_MfgBy'])));
	$tdata['U_PC_RfBy'] = null;
	$tdata['U_PC_SType'] = trim(addslashes(strip_tags($_POST['stability_SamType'])));
	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['stability_BatchNo'])));

	$tdata['U_PC_BSize'] = trim(addslashes(strip_tags($_POST['stability_BatchQty'])));

	$tdata['U_PC_MfgDt'] = trim(addslashes(strip_tags($_POST['stability_MfgDate'])));

	$tdata['U_PC_ExpDt'] = trim(addslashes(strip_tags($_POST['stability_ExpiryDate'])));

	$tdata['U_PC_SIntNo'] = trim(addslashes(strip_tags($_POST['stability_SampleIntimationNoStability'])));
	$tdata['U_PC_SColNo'] = trim(addslashes(strip_tags($_POST['stability_SampleCollectionNoStability'])));

	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['stability_SampleCollectionNoStability'])));

	$tdata['U_PC_RQty'] = null;
	$tdata['U_PC_PckSize'] = trim(addslashes(strip_tags($_POST['stability_PackSize'])));
	$tdata['U_PC_SamType'] = trim(addslashes(strip_tags($_POST['stability_SamType'])));
	$tdata['U_PC_MType'] = trim(addslashes(strip_tags($_POST['stability_MatType'])));

	$tdata['U_PC_PDate'] = trim(addslashes(strip_tags($_POST['stability_PostingDate'])));

	$tdata['U_PC_ADate'] = trim(addslashes(strip_tags($_POST['stability_ADate'])));

	$tdata['U_PC_NoCont'] = trim(addslashes(strip_tags($_POST['stability_NoCont'])));

	$tdata['U_PC_Stage'] = null;
	$tdata['U_PC_ValUp'] = trim(addslashes(strip_tags($_POST['stability_ValidUpto'])));

	$tdata['U_PC_ArNo'] = trim(addslashes(strip_tags($_POST['stability_ARNo'])));

	$tdata['U_PC_GENo'] = null;
	$tdata['U_PC_GDEntry'] = null;

	$tdata['U_PC_APot'] = trim(addslashes(strip_tags($_POST['stability_APot'])));

	$tdata['U_PC_LODWater'] = trim(addslashes(strip_tags($_POST['stability_LODWater'])));

	$tdata['U_PC_Potency'] = trim(addslashes(strip_tags($_POST['stability_Potency'])));

	$tdata['U_PC_CompBy'] = trim(addslashes(strip_tags($_POST['stability_CompBy'])));
	$tdata['U_PC_NoCont1'] = trim(addslashes(strip_tags($_POST['stability_NoCont1'])));
	$tdata['U_PC_NoCont2'] = trim(addslashes(strip_tags($_POST['stability_NoCont2'])));

	$tdata['U_PC_ChkBy'] = trim(addslashes(strip_tags($_POST['stability_CheckBy'])));

	$tdata['U_PC_AnlBy'] = trim(addslashes(strip_tags($_POST['stability_AnylBy'])));

	$tdata['U_PC_Remarks'] = trim(addslashes(strip_tags($_POST['stability_Remarks'])));

	$tdata['U_PC_AsyCal'] = trim(addslashes(strip_tags($_POST['stability_AsyCal'])));

	$tdata['U_PC_Factor'] = trim(addslashes(strip_tags($_POST['stability_Factor'])));

	$tdata['U_PC_SpcNo'] = trim(addslashes(strip_tags($_POST['stability_SpecNo'])));

	$tdata['U_PC_GRQty'] = null;
	$tdata['U_PC_RelDt'] = trim(addslashes(strip_tags($_POST['stability_RelDate'])));
	$tdata['U_PC_RetstDt'] = trim(addslashes(strip_tags($_POST['stability_ReTestDate'])));
	$tdata['U_PC_StType'] = null;
	// ===
	$tdata['U_PC_StCon'] = trim(addslashes(strip_tags($_POST['StabilityCondition'])));
	$tdata['U_PC_StTPer'] = trim(addslashes(strip_tags($_POST['StabilityTimePeriod'])));
	$tdata['U_PC_AnType'] = null;
	$tdata['U_PC_WhsCode'] = trim(addslashes(strip_tags($_POST['ToWhse'])));
	$tdata['U_PC_BEnt'] = null;
	$tdata['U_PC_BNum'] = null;
	$tdata['U_PC_StDNo'] = null;
	$tdata['U_PC_StDEnt'] = null;
	$tdata['U_PC_Dt'] = null;
	$tdata['U_PC_StQty'] = null;
	$tdata['U_PC_Unit'] = null;


	// 	$tdata['U_PC_BLin']=trim(addslashes(strip_tags($_POST['qc_Check_LineNum'])));
	// $tdata['U_PC_GRNNo']=null;
	// $tdata['U_PC_GRNEnt']=null;
	// $tdata['U_PC_SCode']=null;
	// $tdata['U_PC_SName']=null;
	// $tdata['U_PC_MBy']=trim(addslashes(strip_tags($_POST['qc_Check_Mfg_By'])));
	// $tdata['U_PC_RBy']=null;
	// $tdata['U_QCTType']=trim(addslashes(strip_tags($_POST['qc_Check_QCTesttype'])));
	//    $tdata['U_PC_RMQC']=trim(addslashes(strip_tags($_POST['qc_Check_RMWQC'])));
	//    $tdata['U_PC_QCTType']=trim(addslashes(strip_tags($_POST['qc_Check_QCTesttype'])));

	// --
	// $tdata['U_PckSize']=trim(addslashes(strip_tags($_POST['qcD_PckSize'])));
	$ganaralData = array();
	$BL = 0; //skip array avoid and count continue
	for ($i = 0; $i < count($_POST['parameter_code']); $i++) {
		$ganaralData['LineId'] = trim(addslashes(strip_tags($_POST['stability_LineNum'])));
		$ganaralData['Object'] = trim(addslashes(strip_tags('SCS_QCSTAB')));

		$ganaralData['U_PC_PCode'] = trim(addslashes(strip_tags($_POST['parameter_code'][$i])));
		$ganaralData['U_PC_PName'] = trim(addslashes(strip_tags($_POST['PName'][$i])));
		$ganaralData['U_PC_Std'] = trim(addslashes(strip_tags($_POST['Standard'][$i])));
		$ganaralData['U_PC_Rel'] = trim(addslashes(strip_tags($_POST['Release'][$i])));


		$ganaralData['U_PC_PDTyp'] = trim(addslashes(strip_tags($_POST['PDType'][$i])));
		$ganaralData['U_PC_DDtl'] = trim(addslashes(strip_tags($_POST['descriptive_details'][$i])));
		$ganaralData['U_PC_Logi'] = trim(addslashes(strip_tags($_POST['logical'][$i])));

		$ganaralData['U_PC_LwMin'] = trim(addslashes(strip_tags($_POST['LowMin'][$i])));

		$ganaralData['U_PC_LwMax'] = trim(addslashes(strip_tags($_POST['LowMax'][$i])));

		$ganaralData['U_PC_UpMin'] = trim(addslashes(strip_tags($_POST['UppMin'][$i])));

		$ganaralData['U_PC_UpMax'] = trim(addslashes(strip_tags($_POST['UppMax'][$i])));

		$ganaralData['U_PC_Min'] = trim(addslashes(strip_tags($_POST['Min'][$i])));

		$ganaralData['U_PC_LMin1'] = trim(addslashes(strip_tags($_POST['lower_min_result'][$i])));

		$ganaralData['U_PC_LMax1'] = trim(addslashes(strip_tags($_POST['lower_max_result'][$i])));

		$ganaralData['U_PC_UMin1'] = trim(addslashes(strip_tags($_POST['upper_min_result'][$i])));

		$ganaralData['U_PC_UMax1'] = trim(addslashes(strip_tags($_POST['upper_max_result'][$i])));

		$ganaralData['U_PC_Min1'] = trim(addslashes(strip_tags($_POST['mean'][$i])));
		$ganaralData['U_PC_Rotpt'] = trim(addslashes(strip_tags($_POST['result_output'][$i])));

		$ganaralData['U_PC_Rmrks'] = trim(addslashes(strip_tags($_POST['remarks'][$i])));
		$ganaralData['U_PC_QCSts'] = trim(addslashes(strip_tags($_POST['GDQCStatus'][$i])));

		$ganaralData['U_PC_TMeth'] = trim(addslashes(strip_tags($_POST['TMethod'][$i])));

		$ganaralData['U_PC_MType'] = trim(addslashes(strip_tags($_POST['MType'][$i])));
		$ganaralData['U_PC_PhStd'] = null;

		$ganaralData['U_PC_UTxt1'] = trim(addslashes(strip_tags($_POST['user_text1_'][$i])));
		$ganaralData['U_PC_UTxt2'] = trim(addslashes(strip_tags($_POST['user_text2_'][$i])));
		$ganaralData['U_PC_UTxt3'] = trim(addslashes(strip_tags($_POST['user_text3_'][$i])));
		$ganaralData['U_PC_UTxt4'] = trim(addslashes(strip_tags($_POST['user_text4_'][$i])));
		$ganaralData['U_PC_UTxt5'] = trim(addslashes(strip_tags($_POST['user_text5_'][$i])));

		$ganaralData['U_PC_QCRmk'] = trim(addslashes(strip_tags($_POST['qCStsRemark1'][$i])));

		$ganaralData['U_PC_UOM'] = trim(addslashes(strip_tags($_POST['GDUOM'][$i])));

		$ganaralData['U_PC_Rtst'] = trim(addslashes(strip_tags($_POST['Retest'][$i])));

		$ganaralData['U_PC_Stab'] = trim(addslashes(strip_tags($_POST['GDStab'][$i])));

		$ganaralData['U_PC_ExtrS'] = trim(addslashes(strip_tags($_POST['ExSample'][$i])));

		$ganaralData['U_PC_ApAsy'] = trim(addslashes(strip_tags($_POST['Appassay'][$i])));

		$ganaralData['U_PC_ApLOD'] = trim(addslashes(strip_tags($_POST['AppLOD'][$i])));

		$ganaralData['U_PC_AnyBy'] = trim(addslashes(strip_tags($_POST['qc_analysis_by'][$i])));

		$ganaralData['U_PC_ARmrk'] = trim(addslashes(strip_tags($_POST['analyst_remark'][$i])));

		$ganaralData['U_PC_InCod'] = trim(addslashes(strip_tags($_POST['instrument_code'][$i])));

		$ganaralData['U_PC_InNam'] = trim(addslashes(strip_tags($_POST['InsName'][$i])));

		$ganaralData['U_PC_SDt'] = trim(addslashes(strip_tags($_POST['star_date'][$i])));

		$ganaralData['U_PC_STime'] = trim(addslashes(strip_tags($_POST['start_time'][$i])));

		$ganaralData['U_PC_EDate'] = trim(addslashes(strip_tags($_POST['end_date'][$i])));
		$ganaralData['U_PC_ETime'] = trim(addslashes(strip_tags($_POST['end_time'][$i])));

		$tdata['SCS_QCSTAB1Collection'][] = $ganaralData; // row data append on this array
		$BL++; // increment variable define here	
	}

	$qcStatus = array();
	$qcS = 0; //skip array avoid and count continue
	for ($j = 0; $j < count($_POST['qc_Status']); $j++) {
		$qcStatus['LineId'] = trim(addslashes(strip_tags($_POST['stability_LineNum'][$j])));
		$qcStatus['Object'] = trim(addslashes(strip_tags('SCS_QCSTAB')));

		$qcStatus['U_PC_Stus'] = trim(addslashes(strip_tags($_POST['qc_Status'][$j])));
		$qcStatus['U_PC_Qty'] = trim(addslashes(strip_tags($_POST['qCStsQty'][$j])));
		$qcStatus['U_PC_RelDt'] = '';
		$qcStatus['U_PC_RelTm'] = '';
		$qcStatus['U_PC_ITNo'] = trim(addslashes(strip_tags($_POST['qCitNo'][$j])));
		$qcStatus['U_PC_DBy'] = trim(addslashes(strip_tags($_POST['doneBy'][$j])));
		$qcStatus['U_PC_Rmrk1'] = trim(addslashes(strip_tags($_POST['qCStsRemark1'][$j])));

		$qcStatus['U_PC_Atch1'] = '';
		$qcStatus['U_PC_Atch2'] = '';
		$qcStatus['U_PC_Atch3'] = '';
		$qcStatus['U_PC_DvDt'] = '';
		$qcStatus['U_PC_DvNo'] = '';
		$qcStatus['U_PC_DvRsn'] = '';


		$tdata['SCS_QCSTAB2Collection'][] = $qcStatus; // row data append on this array
		$qcS++;
	}

	$qcAttech = array();
	$qcatt = 0; //skip array avoid and count continue
	for ($k = 0; $k < count($_POST['targetPath']); $k++) {
		$qcAttech['LineId'] = trim(addslashes(strip_tags($_POST['stability_LineNum'][$k])));
		$qcAttech['Object'] = trim(addslashes(strip_tags('SCS_QCINPROC')));

		$qcAttech['U_PC_TrgPt'] = trim(addslashes(strip_tags($_POST['targetPath'][$k])));
		$qcAttech['U_PC_FName'] = trim(addslashes(strip_tags($_POST['fileName'][$k])));
		$qcAttech['U_PC_AtcDt'] = trim(addslashes(strip_tags($_POST['attachDate'][$k])));
		$qcAttech['U_PC_FText'] = trim(addslashes(strip_tags($_POST['freeText'][$k])));

		$tdata['SCS_QCSTAB3Collection'][] = $qcAttech; // row data append on this array
		$qcatt++;
	}

	$mainArray = $tdata; // all child array append in main array define here

	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;

	if ($_POST['stability_SamType'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Sample Type is required.';
		echo json_encode($data);
		exit;
	}


	if ($_POST['stability_PostingDate'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Posting Date is required.';
		echo json_encode($data);
		exit;
	}

	if ($_POST['stability_ADate'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'Analysis Date is required.';
		echo json_encode($data);
		exit;
	}

	if ($_POST['stability_ValidUpto'] == "") {
		$data['status'] = 'False';
		$data['DocEntry'] = '';
		$data['message'] = 'ValidUpTo Date is required.';
		echo json_encode($data);
		exit;
	}

	// QC_CK_D_AnalysisDate

	// id="QC_CK_D_PostingDate"


	// service laye function and SAP loin & logout function define start here -------------------------------------------------------
	$res = $obj->SAP_Login();

	if (!empty($res)) {

		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_QCSTAB;

		$responce_encode = $objKri->qcPostDocument($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {
			$data['status'] = 'True';
			$data['DocEntry'] = $responce->DocEntry;
			$data['message'] = 'QC Post Document stability Added Successfully';
			echo json_encode($data);
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	// service laye function and SAP loin & logout function define end here 
}


if (isset($_POST['action']) && $_POST['action'] == 'qc_post_document_stability_pupup_ajax') {
	// $API=$RETESTQCPOSTDOCUMENTDETAILS.'?DocEntry='.$_POST['DocEntry'].'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&LineNum='.$_POST['LineNum'];
	$API = $STABQCPOSTDOCUMENTDETAILS . '?DocEntry=' . $_POST['DocEntry'];
	// $API=$RETESTQCPOSTDOC.'?DocEntry='.$_POST['DocEntry'];
	// echo $API;
	// exit;
	// <!-- ------- Replace blank space to %20 start here -------- -->
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// die();
	// <!-- ------- Replace blank space to %20 End here -------- -->
	$response = $objKri->get_QcPostDocument_RetestQcSingleData($FinalAPI);

	$resutls['response'] = $response;

	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {
		$option = '<tr>
				<td class="desabled">
					<input type="hidden" id="_tRFPEntry" name="_tRFPEntry" value="' . $response[0]->DocEntry . '">
					<input type="hidden" id="it_BatchNo" name="it_BatchNo" value="' . $response[0]->BatchNo . '">

					1
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_ItemCode" name="itP_ItemCode" class="form-control" value="' . $response[0]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
				 <input class="border_hide textbox_bg" type="text" id="itP_ItemName" name="itP_ItemName" class="form-control" value="' . $response[0]->ItemName . '" readonly>
				
				</td>
				<td>
					<input class="border_hide textbox_bg1" type="text" id="itP_BQty" name="itP_BQty" class="form-control" value="' . $response[0]->BatchQty . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_FromWhs" name="itP_FromWhs" class="form-control" value="' . $response[0]->FrmWhse . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itP_ToWhs" name="itP_ToWhs" class="form-control" value="' . $response[0]->ToWhse . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_Loction" name="itP_Loction" class="form-control" value="' . $response[0]->Loc . '" readonly>
				</td>
				<td class="desabled">
				   <input class="border_hide textbox_bg" type="text" id="itP_RetainQtyUom" name="itP_RetainQtyUom" class="form-control" value="' . $response[0]->LabelClaimUOM . '" readonly>
				</td>
			</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}

	$resutls['option'] = $option;
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($resutls);
	exit(0);



	//    echo "<pre>";
	// print_r($response);
	// echo "<pre>";
	// exit;
	// echo json_encode($response);
	// exit(0);

}





if (isset($_POST['action']) && $_POST['action'] == 'OpenInventoryTransfer_stability_qcchecked_ajax') {

	$ItemCode = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs = trim(addslashes(strip_tags($_POST['WareHouse'])));
	$GRPODEnt = trim(addslashes(strip_tags($_POST['DocEntry'])));
	$BNo = trim(addslashes(strip_tags($_POST['BatchNo'])));

	// $afterSet=trim(addslashes(strip_tags($_POST['afterSet'])));
	// http://10.80.4.55:8081/API/SAP/STABILITYQCPOSTDOCCONTSEL?ItemCode=FG00001&WareHouse=DSPT-GEN&BatchNo=C0121197
	// ItemCode=P00003&WareHouse=RETN-WHS&DocEntry=297&BatchNo=BQ13
	// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API = $STABILITYQCPOSTDOCCONTSEL . '?ItemCode=' . $ItemCode . '&WareHouse=' . $FromWhs . '&BatchNo=' . $BNo;
	// http://10.80.4.55:8081/API/SAP/STABILITYQCPOSTDOCCONTSEL?ItemCode=FG00001&WareHouse=DSPT-GEN&BatchNo=C0121197
	// $API='http://10.80.4.55:8081/API/SAP/INPROCESSSAMINTICONTSEL?ItemCode=SFG00001&WareHouse=QCUT-GEN&DocEntry=359&BatchNo=asd';
	// 
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->
	$response = $obj->get_OTFSI_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "<pre>";
	// exit;
	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if (!empty($response)) {

		for ($i = 0; $i < count($response); $i++) {

			if (!empty($response[$i]->MfgDate)) {
				$MfgDate = date("d-m-Y", strtotime($response[$i]->MfgDate));
			} else {
				$MfgDate = '';
			}

			if (!empty($response[$i]->ExpiryDate)) {
				$ExpiryDate = date("d-m-Y", strtotime($response[$i]->ExpiryDate));
			} else {
				$ExpiryDate = '';
			}


			$option .= '
			<tr>
                
                <td style="text-align: center;">
					<input type="hidden" id="usercheckList_retails' . $i . '" name="usercheckList_retails[]" value="0">
					<input class="form-check-input" type="checkbox" value="' . $response[$i]->BatchQty . '" id="itp_CS_retails' . $i . '" name="itp_CS_retails[]" style="width: 17px;height: 17px;" onclick="getSelectedContener_retails(' . $i . ')">
				</td>

                <td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemCode_retails' . $i . '" name="itp_ItemCode_retails[]" class="form-control" value="' . $response[$i]->ItemCode . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ItemName_retails' . $i . '" name="itp_ItemName_retails[]" class="form-control" value="' . $response[$i]->ItemName . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo_retails' . $i . '" name="itp_ContainerNo_retails[]" class="form-control" value="' . $response[$i]->NoCont . '" readonly>
				</td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_Batche_retails' . $i . '" name="itp_Batch_retails[]" class="form-control" value="' . $response[$i]->BatchNo . '" readonly>
				</td>

				
				<td style="text-align: center;">
				   <input class="border_hide" type="text" id="SelectedQty_retails' . $i . '" name="SelectedQty_retails[]" class="form-control" value="' . number_format((float)$response[$i]->BatchQty, 6, '.', '') . '" onfocusout="EnterQtyValidation_retails(' . $i . ')">

				  
				</td>
				
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_MfgDate_retails' . $i . '" name="itp_MfgDate_retails[]" class="form-control" value="' . $MfgDate . '" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate_retails' . $i . '" name="itp_ExpiryDate_retails[]" class="form-control" value="' . $ExpiryDate . '" readonly>
				</td>
			</tr>';
		}

		$option .= '<tr>
			<td colspan="6"></td>
			<td class="desabled">
				<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum_stability" name="cs_selectedQtySum_stability" class="form-control" value="0.000000" readonly></td>
			<td colspan="2"></td>
		</tr>';
	} else {
		$option = '<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
	}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}



// QC Post document (QC Check)44 - In Process
if (isset($_POST['SubIT_Btn_stabilitys'])) {
	$mainArray = array(); // This array hold all type of declare array
	$tdata = array(); //This array hold header data
	$item = array(); //This array hold item data
	$batch = array(); //This array hold batch data
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;
	// $tdata['DocType']= "dDocument_Items";
	$tdata['Series'] = trim(addslashes(strip_tags($_POST['s_IT_stability_series'])));
	$tdata['DocDate'] = date("Y-m-d", strtotime($_POST['s_IT_stability_PostingDate']));
	$tdata['DueDate'] = date("Y-m-d", strtotime($_POST['s_IT_stability_DocumentDate']));

	$tdata['CardCode'] = trim(addslashes(strip_tags($_POST['s_IT_stability_Suppliercode'])));
	$tdata['Comments'] = null;
	$tdata['FromWarehouse'] = trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
	$tdata['ToWarehouse'] = trim(addslashes(strip_tags($_POST['itP_ToWhs'])));

	$tdata['TaxDate'] = date("Y-m-d", strtotime($_POST['s_IT_stability_DocumentDate']));
	$tdata['DocObjectCode'] = '67';
	$tdata['BPLID'] = trim(addslashes(strip_tags($_POST['stability_BPLId'])));

	$tdata['U_PC_QCIProc'] = trim(addslashes(strip_tags($_POST['stability_DocEntry'])));
	$tdata['U_BFType'] = trim(addslashes(strip_tags('SCS_QCINPROC')));


	// $tdata['BPL_IDAssignedToInvoice']=trim(addslashes(strip_tags($_POST['sample_issue_BPLId'])));
	// $tdata['U_PC_SCFG']=trim(addslashes(strip_tags($_POST['sample_issue_DocEntry'])));


	// $tdata['Document_ApprovalRequests']=array();


	// $tdata['DocType']='dDocument_Items';
	// $tdata['U_PC_SCRtest']=trim(addslashes(strip_tags($_POST['SCRTQC_GI_SCRTQCB_DocEntry'])));
	// 
	// $tdata['Comments']=null;
	// 
	// 
	// 
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$mainArray = $tdata;
	// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum'] = trim(addslashes(strip_tags('0')));
	$item['ItemCode'] = trim(addslashes(strip_tags($_POST['itP_ItemCode'])));
	$item['Quantity'] = null;
	$item['WarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
	// $item['LineTaxJurisdictions']=array();
	// $item['SerialNumbers']=array();
	$item['FromWarehouseCode'] = trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
	// <!-- Item Batch row data prepare start here ----------- -->
	$BL = 0;
	for ($i = 0; $i < count($_POST['usercheckList']); $i++) {

		if ($_POST['usercheckList'][$i] == '1') {

			$batch['BatchNumber'] = trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
			$batch['Quantity'] = trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
			$batch['BaseLineNumber'] = trim(addslashes(strip_tags('0')));
			$batch['ItemCode'] = trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));
			$item['BatchNumbers'][] = $batch;
			$BL++;
		}
	}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['StockTransferLines'][] = $item;

	// --------------------- Item and batch row data preparing end here ---------------------------------- -->
	// echo json_encode($mainArray);
	// exit;
	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
	// echo json_encode($mainArray);
	// exit;
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res = $obj->SAP_Login();  // SAP Service Layer Login Here

	if (!empty($res)) {
		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_StockTransfers;

		$responce_encode = $obj->SaveSampleIntimation($mainArray, $Final_API);
		$responce = json_decode($responce_encode);
		// echo "<pre>";
		// 	print_r($responce);
		// 	echo "<pre>";
		// 	exit;
		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		$data = array();
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {

			// <!-- ------- row data preparing start here --------------------- -->
			$UT_data = array();
			$itme = array();
			$UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['stability_DocEntry'])));
			$UT_data['Object'] = 'SCS_QCINPROC';

			// $itme=array();
			$itme['LineId'] = 2;
			$itme['Object'] = 'SCS_QCINPROC';
			$itme['U_PC_ITNo'] = trim(addslashes(strip_tags($responce->DocEntry)));

			$UT_data['SCS_QCINPROC2Collection'] = $itme;

			// $UT_data['U_PC_UTNo']=trim(addslashes(strip_tags($responce->DocEntry)));
			// <!-- ------- row data preparing end here ----------------------- -->

			$Final_API2 = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_QCSTAB . '(' . $UT_data['DocEntry'] . ')';
			$underTestNumber = $obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data, $Final_API2);
			$underTestNumber_decode = json_decode($underTestNumber);

			if ($underTestNumber_decode == '') {
				$data['status'] = 'True';
				$data['DocEntry'] = $responce->DocEntry;
				$data['message'] = "Inventory Transfer Successfully Added.";
				echo json_encode($data);
			} else {
				// $data['status']='False';
				// $data['DocEntry']='';
				// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
				// echo json_encode($data);

				if (array_key_exists('error', (array)$underTestNumber_decode)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}
