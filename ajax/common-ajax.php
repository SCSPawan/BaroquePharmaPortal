<?php 
require_once '../classes/function.php';
require_once '../classes/kri_function.php';
$obj= new web();
$objKri=new webKri();

if(isset($_POST['action']) && $_POST['action'] =='sample_intimation_popup'){
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$API=$OPNTRANSAMPINTMTN_API.$_POST['DocEntry'].'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&LineNum='.$_POST['LineNum'];
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['SampleIntimationBtn'])){
	$tdata=array(); // This array send to AP Standalone Invoice process 

	// $tdata['odata.metadata']=trim(addslashes(strip_tags('https://10.80.4.35:50000/b1s/v1/$metadata#SCS_SINTIMATION/@Element')));
	
	$tdata['U_BLine']=trim(addslashes(strip_tags($_POST['LineNum'])));

	if(!empty($_POST['SupplierName'])){
		$tdata['U_GRPONo']=trim(addslashes(strip_tags($_POST['GRPONo'])));
		$tdata['U_GRPODEnt']=trim(addslashes(strip_tags($_POST['GRPODocEntry'])));
	}else{
		$tdata['U_GRNo']=trim(addslashes(strip_tags($_POST['GRPONo'])));
		$tdata['U_GRDEnt']=trim(addslashes(strip_tags($_POST['GRPODocEntry'])));
	}

	$tdata['U_VCode']=trim(addslashes(strip_tags($_POST['SupplierCode'])));
	$tdata['U_VName']=trim(addslashes(strip_tags($_POST['SupplierName'])));
	$tdata['U_BPRefNo']=trim(addslashes(strip_tags($_POST['BpRefNo'])));
	$tdata['U_ICode']=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$tdata['U_IName']=trim(addslashes(strip_tags($_POST['ItemName'])));
	$tdata['U_GRPOQty']=trim(addslashes(strip_tags($_POST['GRPO_Qty'])));
	$tdata['U_SQty']=trim(addslashes(strip_tags($_POST['SQty'])));
	$tdata['U_RQty']=trim(addslashes(strip_tags($_POST['RQty'])));
	$tdata['U_MfgBy']=trim(addslashes(strip_tags($_POST['MfgBy'])));
	$tdata['U_BNo']=trim(addslashes(strip_tags($_POST['BatchNo'])));
	$tdata['U_BQty']=trim(addslashes(strip_tags($_POST['BatchQty'])));
	$tdata['U_PC_MakeBy']=trim(addslashes(strip_tags($_POST['MakeBy'])));
	$tdata['U_TypMaterial']=trim(addslashes(strip_tags($_POST['TypeofMaterial'])));
	$tdata['U_BPLId']=trim(addslashes(strip_tags($_POST['BPLId'])));
	$tdata['U_LocCode']=trim(addslashes(strip_tags($_POST['LocCode'])));

	if(!empty($_POST['ChNo'])){
		$tdata['U_ChNo']=trim(addslashes(strip_tags($_POST['ChNo'])));
	}else{
		$tdata['U_ChNo']=null;
	}

	$tdata['U_Branch']=trim(addslashes(strip_tags($_POST['BranchName'])));
	$tdata['U_SType']=trim(addslashes(strip_tags($_POST['SampleType'])));
	$tdata['U_TRBy']=trim(addslashes(strip_tags($_POST['TrType'])));

	$tdata['U_FCont'] = $_POST['FromContainer'] !='' ? $_POST['FromContainer'] : 0;
	$tdata['U_TCont'] = $_POST['ToContainer'] !='' ? $_POST['ToContainer'] : 0;
	$tdata['U_TNCont'] = $_POST['NoOfcontainer'] !='' ? $_POST['NoOfcontainer'] : 0;
	$tdata['U_Cont'] = $_POST['Container'] !='' ? $_POST['Container'] : 0;
	$tdata['U_TNCont1'] = $_POST['QtyPerContainer'] !='' ? $_POST['QtyPerContainer'] : 0;

	if(!empty($_POST['GateEntryNo'])){
		$tdata['U_GEntNo']=trim(addslashes(strip_tags($_POST['GateEntryNo'])));
	}else{
		$tdata['U_GEntNo']=null;
	}

	$tdata['U_UTTrans']=null;
	$tdata['U_DType']=trim(addslashes(strip_tags('Batch')));
	$tdata['U_CNos']=trim($_POST['ContainerNOS']);
	$tdata['U_Loc']=trim($_POST['Location']);
	// ---------------------------------Date Var Prepare Start Here ------------------------------------
		if(!empty($_POST['PostingDate'])){
			$tdata['U_GEntDate']=date('Y-m-d', strtotime($_POST['PostingDate']));
		}else{
			$tdata['U_GEntDate']='';
		}

		if(!empty($_POST['ExpiryDate'])){
			$tdata['U_ExpDate']=date('Y-m-d', strtotime($_POST['ExpiryDate']));
		}else{
			$tdata['U_ExpDate']='';
		}

		if(!empty($_POST['MfgDate'])){
			$tdata['U_MfgDate']=date('Y-m-d', strtotime($_POST['MfgDate']));
		}else{
			$tdata['U_MfgDate']='';
		}

		if(!empty($_POST['ChDate'])){
			$tdata['U_ChDate']=date('Y-m-d', strtotime($_POST['ChDate']));
		}else{
			$tdata['U_ChDate']='';
		}

		if(!empty($_POST['TrDate'])){
			$tdata['U_TRDate']=date('Y-m-d', strtotime($_POST['TrDate']));
		}else{
			$tdata['U_TRDate']='';
		}
	// ---------------------------------Date Var Prepare End Here   ------------------------------------

	// <!-- ---------------------- sample Intimation popup validation start Here ------------------ -->
		if($_POST['SampleType']==''){
			$data['status']='False';
			$data['DocEntry']='';
			$data['message']="Sample Type Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if($_POST['TrType']==''){
			$data['status']='False';
			$data['DocEntry']='';
			$data['message']="TR Type Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if($_POST['TrDate']==''){
			$data['status']='False';
			$data['DocEntry']='';
			$data['message']="TR Date Mandatory.";
			echo json_encode($data);
			exit(0);
		}
	// <!-- ---------------------- sample Intimation popup validation end Here -------------------- -->
	
	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here
	
		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SINTIMATION;
			
			$responce_encode=$obj->SaveSampleIntimation($tdata,$Final_API); // sample intimation save here
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();

				if($responce->DocNum!=""){

					$SIntiMainArray = [
						'DocumentLines' => [
							[
								'LineNum' => $responce->U_BLine,
								'U_PC_SInti' => $responce->DocEntry
							]
						]
					];

					if(!empty($responce->U_VName)){

						// Purchase Delivery Notes
						$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_PurchaseDeliveryNotes.'('.$responce->U_GRPODEnt.')';

						// <!-- -------- Service Layer Function start here --------- -->
							$res11=$obj->SAP_Login();  // SAP Service Layer Login Here
							if(!empty($res)){
								$responce_encode1=$obj->PATCH_ServiceLayerMasterFunction($SIntiMainArray,$Final_API);
								$responce1=json_decode($responce_encode1);
							}
							$res12=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
						// <!-- -------- Service Layer Function end here ----------- -->

						if(empty($responce1)){
							$data['status']='True';
							$data['DocEntry']=$responce->DocEntry;
							$data['message']="Sample Intimation Add Successfully.";
							echo json_encode($data);
						}else{
							if(array_key_exists('error', (array)$responce1)){
								$data['status']='False';
								$data['DocEntry']='';
								$data['message']=$responce1->error->message->value;
								echo json_encode($data);
							}
						}
					}else{

						$InventoryGenEntries=array();
						$InventoryGenEntries['SIDocEntry']=trim($responce->DocEntry);
						$InventoryGenEntries['GRDocEntry']=trim($_POST['GRPODocEntry']);
						$InventoryGenEntries['ItemCode']=trim($tdata['U_ICode']);
						$InventoryGenEntries['LineNum']=trim($responce->U_BLine);

						// Inventory Gen Entries

							// $Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_InventoryGenEntries.'('.$responce->U_GRPODEnt.')';

							// // <!-- -------- Service Layer Function start here --------- -->
							// 	$res11=$obj->SAP_Login();  // SAP Service Layer Login Here
							// 	if(!empty($res)){
							// 		$responce_encode1=$obj->PATCH_ServiceLayerMasterFunction($SIntiMainArray,$Final_API); 
							// 		$responce1=json_decode($responce_encode1);
							// 	}
							// 	$res12=$obj->SAP_Logout();  // SAP Service Layer Logout Here
							// // <!-- -------- Service Layer Function end here ----------- -->

						$Final_API=$GRSAMPLEINTIINWARD_APi;
						$responce_encode1=$obj->POST_QuerryBasedMasterFunction($InventoryGenEntries,$Final_API);
						$responce1=json_decode($responce_encode1);

						if(empty($responce1)){
							$data['status']='True';
							$data['DocEntry']=$responce->DocEntry;
							$data['message']="Sample Intimation Add Successfully.";
							echo json_encode($data);
						}else{

							if(array_key_exists('error', (array)$responce1)){
								$data['status']='False';
								$data['DocEntry']='';
								$data['message']=$responce1->error->message->value;
								echo json_encode($data);
							}
						}
					}
				}else{
					if(array_key_exists('error', (array)$responce)){
						$data['status']='False';
						$data['DocEntry']='';
						$data['message']=$responce->error->message->value;
						echo json_encode($data);
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='getSeriesSingleData_ajax'){		
	// $TrDate=date('Ymd', strtotime($_POST['TrDate']));
	$TrDate=date('Ymd', strtotime(str_replace('/', '-',$_POST['TrDate'])));
	$ObjectCode=trim(addslashes(strip_tags($_POST['ObjectCode'])));
	$Series=trim(addslashes(strip_tags($_POST['Series'])));

	$Final_API=$INWARDQCSERIES_API.$ObjectCode.'&Series='.$Series.'&TRDate='.$TrDate.'&UserName='.$_SESSION['Baroque_eMail'];

	// print_r($Final_API);
	// die();

	$response=$obj->GetSeriesSingleData($Final_API);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='getSeriesDropdown_ajax')
{	
	// print_r($_POST);
	// die();
	$TrDate=date('Ymd', strtotime(str_replace('/', '-',$_POST['TrDate'])));
	$ObjectCode=trim(addslashes(strip_tags($_POST['ObjectCode'])));
	$Final_API=$INWARDQCSERIES_API.$ObjectCode.'&TRDate='.$TrDate.'&UserName='.$_SESSION['Baroque_eMail'];
	
// print_r($Final_API);
// die();

	$response=$obj->GetSeriesDropdown($Final_API);
	echo json_encode($response);
	exit(0);
}




if(isset($_POST['action']) && $_POST['action'] =='SampleTypeDropdown_ajax')
{
	$response=$obj->GetSampleTypeDropdown($SAMINTSTYPE_API);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='TR_ByDropdown_ajax')
{
	$response=$obj->GetTR_ByDropdown($SAMINTTRBY_API);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='sample_intimation_ajax')
{
	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API=$SAMPLEINTMUNDERTEST_API.'?DocEntry='.$DocEntry;

	// <!-- ------- Replace blank space to %20 start here -------- -->
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	// print_r($FinalAPI);
	// die();
	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='AfterInventoryTransfer_ajax'){
	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API=$INVENTRANSFER_API.$DocEntry;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// print_r($FinalAPI);
	// die();
	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	echo json_encode($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='SC_OpenInventoryTransfer_ajax'){
	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));
	
	$API=$SAMPLECOLL_API.'?DocEntry='.$DocEntry;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// print_r($FinalAPI);
	// die();
	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
		if(!empty($response)){
		$option='<tr>
					<td class="desabled">
						<input type="hidden" id="U_GRPODEnt" name="U_GRPODEnt" value="'.$response[0]->DocEntry.'">
						<input type="hidden" id="U_BNo" name="U_BNo" value="'.$response[0]->BatchNo.'">
						1
					</td>
					
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itP_ItemCode" name="itP_ItemCode" class="form-control" value="'.$response[0]->ItemCode.'" readonly>
					</td>

					<td class="desabled">'.$response[0]->ItemName.'</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itP_BQty" name="itP_BQty" class="form-control" value="'.$response[0]->BatchQty.'" readonly>
					</td>
					
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itP_FromWhs" name="itP_FromWhs" class="form-control" value="'.$response[0]->RISSFromWhs.'" readonly>
					</td>

					<td class="desabled"  id="hideToWhsTd">
						<input class="border_hide textbox_bg" type="text" id="itP_ToWhs" name="itP_ToWhs" class="form-control" value="'.$response[0]->RISSToWhs.'" readonly>
					</td>
					
					<td class="desabled">'.$response[0]->Location.'</td>
					<td class="desabled">'.$response[0]->SampleUnit.'</td>
				</tr>';
		}else{
			$option='<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
		}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='OpenInventoryTransfer_ajax'){
	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API=$SAMPLEINTMUNDERTEST_API.'?DocEntry='.$DocEntry;
	
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
		if(!empty($response)){
			$option='<tr>
					<td class="desabled">
						<input type="hidden" id="U_GRPODEnt" name="U_GRPODEnt" value="'.$response[0]->U_GRPODEnt.'">
						<input type="hidden" id="U_BNo" name="U_BNo" value="'.$response[0]->U_BNo.'">

						1
					</td>
					
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itP_ItemCode" name="itP_ItemCode" class="form-control" value="'.$response[0]->U_ICode.'" readonly>
					</td>

					<td class="desabled">'.$response[0]->U_IName.'</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itP_BQty" name="itP_BQty" class="form-control" value="'.$response[0]->U_BQty.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itP_FromWhs" name="itP_FromWhs" class="form-control" value="'.$response[0]->FromWhs.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itP_ToWhs" name="itP_ToWhs" class="form-control" value="'.$response[0]->ToWhs.'" readonly>
					</td>
					<td class="desabled">'.$response[0]->Location.'</td>
					<td class="desabled">'.$response[0]->Unit.'</td>
				</tr>';
		}else{
			$option='<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
		}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='AfterOpenInventoryTransferCS_ajax'){

	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));
	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$LineNum=trim(addslashes(strip_tags($_POST['LineNum'])));
	$WareHouse=trim(addslashes(strip_tags($_POST['WareHouse'])));

	// <!--------------- Preparing API Start Here ------------------------------------------ -->
		$API=$INVTRANSBATCH_API.'?DocEntry='.$DocEntry.'&ItemCode='.$ItemCode.'&LineNum='.$LineNum;
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->
		// print_r(json_encode($API));
		// die();
	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
		if(!empty($response)){

			$BatchQtySum = 0;
			for ($i=0; $i <count($response) ; $i++) { 
				$option.='
				<tr>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" class="form-control" value="'.$response[$i]->ItemCode.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" class="form-control" value="'.$response[$i]->ItemName.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" class="form-control" value="'.$response[$i]->ContainerNo.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" class="form-control" value="'.$response[$i]->BatchNum.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" class="form-control" value="'.$response[$i]->BatchQty.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" class="form-control" value="'.date("d-m-Y", strtotime($response[$i]->MfgDate)).'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" class="form-control" value="'.date("d-m-Y", strtotime($response[$i]->ExpiryDate)).'" readonly>
					</td>
				</tr>';

				$BatchQtySum += $response[$i]->BatchQty;
			}

			$option.='<tr>
				<td colspan="4"></td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" class="form-control" value="'.number_format((float)$BatchQtySum, 6, '.', '').'" readonly></td>
				<td colspan="2"></td>
			</tr>';
		}else{
			$option='<tr><td colspan="7" style="text-align: center;color:red;">Record Not Found</td></tr>';
		}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='SC_OpenInventoryTransferGI_ajax'){

	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs=trim(addslashes(strip_tags($_POST['FromWhs'])));
	$GRPODEnt=trim(addslashes(strip_tags($_POST['GRPODEnt'])));
	$BNo=trim(addslashes(strip_tags($_POST['BNo'])));

	// <!--------------- Preparing API Start Here ------------------------------------------ -->
		$API=$CONTCOLLSEL_API.'?ItemCode='.$ItemCode.'&WhsCode='.$FromWhs.'&LotNo='.$BNo;
		// echo json_encode($API);
		// die();
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
		if(!empty($response)){

			for ($i=0; $i <count($response) ; $i++) { 

				if(!empty($response[$i]->MfgDate)){
					$MfgDate=date("d-m-Y", strtotime($response[$i]->MfgDate));
				}else{
					$MfgDate='';
				}

				if(!empty($response[$i]->ExpiryDate)){
					$ExpiryDate=date("d-m-Y", strtotime($response[$i]->ExpiryDate));
				}else{
					$ExpiryDate='';
				}

			$option.='<tr>
					<td style="text-align: center;">
						<input type="hidden" id="gi_usercheckList'.$i.'" name="gi_usercheckList[]" value="0">
						<input class="form-check-input" type="checkbox" value="'.$response[$i]->BatchQty.'" id="gip_CS'.$i.'" name="gip_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContenerGI('.$i.')">
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="gip_ItemCode'.$i.'" name="gip_ItemCode[]" class="form-control" value="'.$response[$i]->ItemCode.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="gip_ItemName'.$i.'" name="gip_ItemName[]" class="form-control" value="'.$response[$i]->ItemName.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="gip_ContainerNo'.$i.'" name="gip_ContainerNo[]" class="form-control" value="'.$response[$i]->ContainerNo.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="gip_Batche'.$i.'" name="gip_Batch[]" class="form-control" value="'.$response[$i]->Batch.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="gip_BatchQty'.$i.'" name="gip_BatchQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" readonly>
					</td>
					<td>
						<input class="border_hide" type="text" id="gip_SelectedQty'.$i.'" name="gip_SelectedQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" onfocusout="EnterQtyValidation_GI('.$i.')">
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="gip_MfgDate'.$i.'" name="gip_MfgDate[]" class="form-control" value="'.$MfgDate.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="gip_ExpiryDate'.$i.'" name="gip_ExpiryDate[]" class="form-control" value="'.$ExpiryDate.'" readonly>
					</td>
				</tr>';
			}

			$option.='<tr>
				<td colspan="6"></td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="csgi_selectedQtySum" name="csgi_selectedQtySum" class="form-control" value="0.000000" readonly></td>
				<td colspan="2"></td>
			</tr>';
		}else{
			$option='<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
		}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='SC_OpenInventoryTransferCS_ajax'){

	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs=trim(addslashes(strip_tags($_POST['FromWhs'])));
	$GRPODEnt=trim(addslashes(strip_tags($_POST['GRPODEnt'])));
	$BNo=trim(addslashes(strip_tags($_POST['BNo'])));

	// <!--------------- Preparing API Start Here ------------------------------------------ -->
		$API=$CONTCOLLSEL_API.'?ItemCode='.$ItemCode.'&WhsCode='.$FromWhs.'&LotNo='.$BNo;
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->
		// print_r($API);
		// die();
	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
		if(!empty($response)){

			for ($i=0; $i <count($response) ; $i++) { 

				if(!empty($response[$i]->MfgDate)){
					$MfgDate=date("d-m-Y", strtotime($response[$i]->MfgDate));
				}else{
					$MfgDate='';
				}

				if(!empty($response[$i]->ExpiryDate)){
					$ExpiryDate=date("d-m-Y", strtotime($response[$i]->ExpiryDate));
				}else{
					$ExpiryDate='';
				}


				$option.='
				<tr>
					<td style="text-align: center;">
						<input type="hidden" id="usercheckList'.$i.'" name="usercheckList[]" value="0">
						<input class="form-check-input" type="checkbox" value="'.$response[$i]->BatchQty.'" id="itp_CS'.$i.'" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener('.$i.')">
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ItemCode'.$i.'" name="itp_ItemCode[]" class="form-control" value="'.$response[$i]->ItemCode.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ItemName'.$i.'" name="itp_ItemName[]" class="form-control" value="'.$response[$i]->ItemName.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo'.$i.'" name="itp_ContainerNo[]" class="form-control" value="'.$response[$i]->ContainerNo.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_Batche'.$i.'" name="itp_Batch[]" class="form-control" value="'.$response[$i]->Batch.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_BatchQty'.$i.'" name="itp_BatchQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" readonly>
					</td>
					<td>
						<input class="border_hide" type="text" id="SelectedQty'.$i.'" name="SelectedQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" onfocusout="EnterQtyValidation('.$i.')">
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_MfgDate'.$i.'" name="itp_MfgDate[]" class="form-control" value="'.$MfgDate.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate'.$i.'" name="itp_ExpiryDate[]" class="form-control" value="'.$ExpiryDate.'" readonly>
					</td>
				</tr>';
			}

			$option.='<tr>
				<td colspan="6"></td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum" name="cs_selectedQtySum" class="form-control" value="0.000000" readonly></td>
				<td colspan="2"></td>
			</tr>';
		}else{
			$option='<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
		}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='OpenInventoryTransferCS_ajax'){

	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs=trim(addslashes(strip_tags($_POST['FromWhs'])));
	$GRPODEnt=trim(addslashes(strip_tags($_POST['GRPODEnt'])));
	$BNo=trim(addslashes(strip_tags($_POST['BNo'])));

	// <!--------------- Preparing API Start Here ------------------------------------------ -->
		$API=$SAMINTCONTAINERSELECTION_API.'?ItemCode='.$ItemCode.'&WhsCode='.$FromWhs.'&DocEntry='.$GRPODEnt.'&LotNo='.$BNo;
		// print_r(json_encode($API));
		// die();
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
		if(!empty($response)){

			for ($i=0; $i <count($response) ; $i++) { 
				$option.='
				<tr>
					<td style="text-align: center;">
						<input type="hidden" id="usercheckList'.$i.'" name="usercheckList[]" value="0">
						<input class="form-check-input" type="checkbox" value="'.$response[$i]->BatchQty.'" id="itp_CS'.$i.'" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener('.$i.')">
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ItemCode'.$i.'" name="itp_ItemCode[]" class="form-control" value="'.$response[$i]->ItemCode.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ItemName'.$i.'" name="itp_ItemName[]" class="form-control" value="'.$response[$i]->ItemName.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo'.$i.'" name="itp_ContainerNo[]" class="form-control" value="'.$response[$i]->ContainerNo.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_Batche'.$i.'" name="itp_Batch[]" class="form-control" value="'.$response[$i]->Batch.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_BatchQty'.$i.'" name="itp_BatchQty[]" class="form-control" value="'.$response[$i]->BatchQty.'" readonly>
					</td>
					<td>
						<input class="border_hide" type="text" id="SelectedQty'.$i.'" name="SelectedQty[]" class="form-control" value="'.$response[$i]->BatchQty.'" onfocusout="EnterQtyValidation('.$i.')">
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_MfgDate'.$i.'" name="itp_MfgDate[]" class="form-control" value="'.date("d-m-Y", strtotime($response[$i]->MfgDate)).'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate'.$i.'" name="itp_ExpiryDate[]" class="form-control" value="'.date("d-m-Y", strtotime($response[$i]->ExpiryDate)).'" readonly>
					</td>
				</tr>';
			}

			$option.='<tr>
				<td colspan="6"></td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum" name="cs_selectedQtySum" class="form-control" value="0.000000" readonly></td>
				<td colspan="2"></td>
			</tr>';
		}else{
			$option='<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
		}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}

if(isset($_POST['SC_SubIT_Btn']))
{
	$mainArray=array(); // This array hold all type of declare array
	$tdata=array(); //This array hold header data
	$item=array(); //This array hold item data
	$batch=array(); //This array hold batch data

	$tdata['Series']=trim(addslashes(strip_tags($_POST['it_DocNoName'])));
	$tdata['DocDate']=date("Y-m-d", strtotime($_POST['it_PostingDate']));
	$tdata['DueDate']=date("Y-m-d", strtotime($_POST['it_DocDate']));
	$tdata['CardCode']=trim(addslashes(strip_tags($_POST['it_SupplierCode'])));
	$tdata['Comments']=null;
	$tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
	$tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
	$tdata['TaxDate']=date("Y-m-d", strtotime($_POST['it_DocDate']));
	$tdata['DocObjectCode']=trim(addslashes(strip_tags('67')));
	$tdata['U_PC_SColl']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$tdata['U_BFType']=trim(addslashes(strip_tags($_POST['it_BaseDocType'])));

	$mainArray=$tdata;

	// --------------------- Item and batch row data preparing start here -------------------------------- -->
		$item['LineNum']=trim(addslashes(strip_tags('0')));
		$item['ItemCode']=trim(addslashes(strip_tags($_POST['itP_ItemCode'])));
		$item['WarehouseCode']=trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
		$item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
		$item['Quantity']=trim(addslashes(strip_tags($_POST['itP_BQty'])));
		
		// <!-- Item Batch row data prepare start here ----------- -->
			$BL=0; //skip array avoid and count continue
			for ($i=0; $i <count($_POST['usercheckList']) ; $i++) { 

				if($_POST['usercheckList'][$i]=='1'){
					// $batch['usercheckList']=$_POST['usercheckList'][$i];
					$batch['BatchNumber']=trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
					$batch['Quantity']=trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
					$batch['BaseLineNumber']=trim(addslashes(strip_tags('0')));
					$batch['ItemCode']=trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));

					$item['BatchNumbers'][]=$batch;
					$BL++; // increment variable define here
				}
			}
		// <!-- Item Batch row data prepare end here ------------- -->
		$mainArray['StockTransferLines'][]=$item;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->
	// echo '<pre>';
	// print_r($_POST['it_DocEntry']);	
	// print_r(json_encode($mainArray));
	// die();
	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_StockTransfers;

			$responce_encode=$obj->SaveSampleIntimation($mainArray,$Final_API);
			$responce=json_decode($responce_encode);
			// echo '<pre>';
			// print_r($responce);
			// die();
			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();
				if(array_key_exists('error', (array)$responce)){
					$data['status']='False';
					$data['DocEntry']='';
					$data['message']=$responce->error->message->value;
					echo json_encode($data);
				}else{

					// <!-- ------- row data preparing start here --------------------- -->
					if(!empty($_POST['it_DocFlagForWeb'])){
						// Sample collection page -> sample collection details tab -> Retain issue - Inventory Transfer 
						$Fdata = array();	
						$Fdata['DocEntry'] = trim(addslashes(strip_tags($_POST['it_DocEntry'])));
						$Fdata['U_RIssue'] = trim(addslashes(strip_tags($responce->DocEntry)));
					}else{
						$Fdata = [
	                        'SCS_SCOL1Collection' => [
	                            [
	                            	'LineId' =>1,
	                                'DocEntry' => trim(addslashes(strip_tags($_POST['it_DocEntry']))),
	                                'U_Trans' => trim(addslashes(strip_tags($responce->DocEntry)))
	                            ]
	                        ]
	                    ];
					}



					

					// echo '<pre>';
					// print_r($SCS_SCOL1Collection);
					// print_r(json_encode($SCS_SCOL1Collection));
					// die();
					// SCS_SCOL1Collection
					// 	$UT_data=array();
					// 	$UT_data['DocEntry']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
					// 	$UT_data['U_Trans']=trim(addslashes(strip_tags($responce->DocEntry)));
					// <!-- ------- row data preparing end here ----------------------- -->

					$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SCS_SCOL.'('.$_POST['it_DocEntry'].')';
					$underTestNumber=$obj->PATCH_ServiceLayerMasterFunction($Fdata,$Final_API2);
					$underTestNumber_decode=json_decode($underTestNumber);

					if($underTestNumber_decode==''){
						$data['status']='True';
						$data['DocEntry']=$responce->DocEntry;
						$data['message']="Sample Collection Inventory Transfer Successfully Added.";
						echo json_encode($data);
					}else{
						
						if(array_key_exists('error', (array)$underTestNumber_decode)){
							$data['status']='False';
							$data['DocEntry']='';
							$data['message']=$responce->error->message->value;
							echo json_encode($data);
						}
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->

}


if(isset($_POST['SubGI_Btn']))
{
	

	$mainArray=array(); // This array hold all type of declare array
	$tdata=array(); //This array hold header data
	$item=array(); //This array hold item data
	$batch=array(); //This array hold batch data
	
	$tdata['DocType']='dDocument_Items';
	$tdata['DocDate']=date("Y-m-d", strtotime($_POST['gi_PostingDate']));
	$tdata['DocDueDate']=date("Y-m-d", strtotime($_POST['gi_DocDate']));
	$tdata['Series']=trim(addslashes(strip_tags($_POST['gi_DocNoName'])));
	$tdata['TaxDate']=date("Y-m-d", strtotime($_POST['gi_DocDate']));
	$tdata['DocObjectCode']=trim(addslashes(strip_tags('oInventoryGenExit')));
	$tdata['U_PC_SColl']=trim(addslashes(strip_tags($_POST['gi_DocEntry'])));
	$tdata['U_BFType']=trim(addslashes(strip_tags($_POST['gi_BaseDocType'])));
	$tdata['BPL_IDAssignedToInvoice']=trim(addslashes(strip_tags($_POST['gi_BPL_Id'])));

	$mainArray=$tdata;

	// --------------------- Item and batch row data preparing start here -------------------------------- -->
		$item['LineNum']=trim(addslashes(strip_tags('0')));
		$item['ItemCode']=trim(addslashes(strip_tags($_POST['itP_ItemCode'])));
		$item['WarehouseCode']=trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
		$item['Quantity']=trim(addslashes(strip_tags($_POST['itP_BQty'])));

		// <!-- Item Batch row data prepare start here ----------- -->
			$BL=0; //skip array avoid and count continue
			for ($i=0; $i <count($_POST['gi_usercheckList']) ; $i++) { 

				if($_POST['gi_usercheckList'][$i]=='1'){

					$batch['BatchNumber']=trim(addslashes(strip_tags($_POST['gip_ContainerNo'][$i])));
					$batch['Quantity']=trim(addslashes(strip_tags($_POST['gip_SelectedQty'][$i])));
					$batch['BaseLineNumber']=trim(addslashes(strip_tags('0')));
					$batch['ItemCode']=trim(addslashes(strip_tags($_POST['gip_ItemCode'][$i])));

					$item['BatchNumbers'][]=$batch;
					$BL++; // increment variable define here
				}
			}
		// <!-- Item Batch row data prepare end here ------------- -->
		$mainArray['DocumentLines'][]=$item;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->
	// echo '<pre>';
	// print_r($_POST['gi_DocEntry']);
	// die();
	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_InventoryGenExits;

			$responce_encode=$obj->SaveSampleIntimation($mainArray,$Final_API);
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();
				if(array_key_exists('error', (array)$responce)){
					$data['status']='False';
					$data['DocEntry']='1';
					$data['message']=$responce->error->message->value;
					echo json_encode($data);
				}else{

					// <!-- ------- row data preparing start here --------------------- -->
						$UT_data = array();

						if ($_POST['DocumentType'] == 'SampleIssueGoodsIssue') {
						    $UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['gi_DocEntry'])));
						    $UT_data['U_SIssue'] = trim(addslashes(strip_tags($responce->DocEntry)));
						} elseif ($_POST['DocumentType'] == 'ExtraIssueTabGoodsIssue') {
						    $UT_data = [
						        'SCS_SCOL2Collection' => [
						            [
						                'LineId' => 1,
						                'DocEntry' => trim(addslashes(strip_tags($_POST['gi_DocEntry']))),
						                'U_PEIssue' => trim(addslashes(strip_tags($responce->DocEntry)))
						            ]
						        ]
						    ];
						} else {
						    $UT_data['DocEntry'] = trim(addslashes(strip_tags($_POST['gi_DocEntry'])));
						    $UT_data['U_RIssue'] = trim(addslashes(strip_tags($responce->DocEntry)));
						}				
					// <!-- ------- row data preparing end here ----------------------- -->

					$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SCS_SCOL.'('.$_POST['gi_DocEntry'].')';
					// $underTestNumber=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data,$Final_API2);
					$underTestNumber=$obj->PATCH_ServiceLayerMasterFunction($UT_data,$Final_API2);
					$underTestNumber_decode=json_decode($underTestNumber);

					if($underTestNumber_decode==''){
						$data['status']='True';
						$data['DocEntry']=$responce->DocEntry;
						if($_POST['DocumentType']=='SampleIssueGoodsIssue'){
							$data['message']="Sample Collection Goods Issue Successfully Added.";
						}else if($_POST['DocumentType']=='ExtraIssueTabGoodsIssue'){
							$data['message']="Sample Collection Extra Issue (Goods Issue) Successfully Added.";
						}else{
							$data['message']="Sample Collection Retain Issue (Goods Issue) Successfully Added.";
						}
						
						echo json_encode($data);
					}else{
						if(array_key_exists('error', (array)$underTestNumber_decode)){
							$data['status']='False';
							$data['DocEntry']='';							
							$data['message']=$responce->error->message->value;
							echo json_encode($data);
						}
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->

}


if(isset($_POST['SubIT_Btn']))
{	
	$mainArray=array(); // This array hold all type of declare array
	$tdata=array(); //This array hold header data
	$item=array(); //This array hold item data
	$batch=array(); //This array hold batch data

	$tdata['Series']=trim(addslashes(strip_tags($_POST['it_DocNoName'])));
	$tdata['DocDate']=date("Y-m-d", strtotime($_POST['it_PostingDate']));
	$tdata['DueDate']=date("Y-m-d", strtotime($_POST['it_DocDate']));
	$tdata['CardCode']=trim(addslashes(strip_tags($_POST['it_SupplierCode'])));
	$tdata['Comments']=null;
	$tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
	$tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
	$tdata['TaxDate']=date("Y-m-d", strtotime($_POST['it_DocDate']));
	$tdata['DocObjectCode']=trim(addslashes(strip_tags('67')));
	$tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$tdata['U_BFType']=trim(addslashes(strip_tags($_POST['it_BaseDocType'])));

	$mainArray=$tdata;

	// --------------------- Item and batch row data preparing start here -------------------------------- -->
		$item['LineNum']=trim(addslashes(strip_tags('0')));
		$item['ItemCode']=trim(addslashes(strip_tags($_POST['itP_ItemCode'])));
		$item['WarehouseCode']=trim(addslashes(strip_tags($_POST['itP_ToWhs'])));
		$item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST['itP_FromWhs'])));
		$item['Quantity']=trim(addslashes(strip_tags($_POST['itP_BQty'])));
		
		// <!-- Item Batch row data prepare start here ----------- -->
			$BL=0;
			for ($i=0; $i <count($_POST['usercheckList']) ; $i++) {

				if($_POST['usercheckList'][$i]=='1'){

					$batch['BatchNumber']=trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
					$batch['Quantity']=trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
					$batch['BaseLineNumber']=trim(addslashes(strip_tags('0')));
					$batch['ItemCode']=trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));

					$item['BatchNumbers'][]=$batch;
					$BL++;
				}
			}
		// <!-- Item Batch row data prepare end here ------------- -->
		$mainArray['StockTransferLines'][]=$item;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->

	// print_r($Final_API);
	// die();
	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_StockTransfers;
			// print_r($Final_API);
			// print_r(json_encode($mainArray));
			// die();
			$responce_encode=$obj->SaveSampleIntimation($mainArray,$Final_API);
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();
				if(array_key_exists('error', (array)$responce)){
					$data['status']='False';
					$data['DocEntry']='';
					$data['message']=$responce->error->message->value;
					echo json_encode($data);
				}else{

					// <!-- ------- row data preparing start here --------------------- -->
						$UT_data=array();
						$UT_data['DocEntry']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
						$UT_data['U_UTTrans']=trim(addslashes(strip_tags($responce->DocEntry)));
					// <!-- ------- row data preparing end here ----------------------- -->

					$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SCS_SINTIMATION.'('.$UT_data['DocEntry'].')';
					// $underTestNumber=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data,$Final_API2);
					$underTestNumber=$obj->PATCH_ServiceLayerMasterFunction($UT_data,$Final_API2);
					$underTestNumber_decode=json_decode($underTestNumber);

					if($underTestNumber_decode==''){
						$data['status']='True';
						$data['DocEntry']=$responce->DocEntry;
						$data['message']="Inventory Transfer Successfully Added.";
						echo json_encode($data);
					}else{
						
						if(array_key_exists('error', (array)$underTestNumber_decode)){
							$data['status']='False';
							$data['DocEntry']='';
							$data['message']=$responce->error->message->value;
							echo json_encode($data);
						}
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='OT_Sample_Collection_popup')
{
	$API=$SAMPLECOLLECTION_API.'&DocEntry='.$_POST['DocEntry'].'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&LineNum='.$_POST['LineNum'];
	// print_r($API);
	// die();
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
		
	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='IngrediantTypeDropdown_ajax')
{
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res=$obj->SAP_Login();  // SAP Service Layer Login Here

	if(!empty($res)){
		$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SCS_INGREDIENT;

		$responce_encode=$obj->getFunctionServiceLayer($Final_API);
		$responce=json_decode($responce_encode);

		for ($i=0; $i <count($responce->value) ; $i++) { 
			
			if($responce->value[$i]->Name=='None'){
				$option .= '<option value="'.$responce->value[$i]->Name.'" selected>'.$responce->value[$i]->Name.'</option>';
			}else{
				$option .= '<option value="'.$responce->value[$i]->Name.'">'.$responce->value[$i]->Name.'</option>';
			}
		}
	}
	
	$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	print_r($option);
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['OTSCP_Btn'])){
	$tdata=array(); // This array send to AP Standalone Invoice process 

	$tdata['U_BLine']=trim(addslashes(strip_tags($_POST['OTSCP_LineNum'])));
	$tdata['U_InType']=trim(addslashes(strip_tags($_POST['OTSCP_IngredientsType'])));

	if(!empty($_POST['OTSCP_SupplierName'])){
		$tdata['U_GRPONo']=trim(addslashes(strip_tags($_POST['OTSCP_GRPONo'])));
		$tdata['U_GRPODEnt']=trim(addslashes(strip_tags($_POST['OTSCP_GRPODocEntry'])));
	}else{
		$tdata['U_GRNo']=trim(addslashes(strip_tags($_POST['OTSCP_GRPONo'])));
		$tdata['U_GRDEnt']=trim(addslashes(strip_tags($_POST['OTSCP_GRPODocEntry'])));
	}

	$tdata['U_Loc']=trim(addslashes(strip_tags($_POST['OTSCP_Location'])));
	$tdata['U_InBy']=trim(addslashes(strip_tags($_POST['OTSCP_IntimatedBy'])));
	$tdata['U_SQty']=trim(addslashes(strip_tags($_POST['OTSCP_SQty'])));
	$tdata['U_SUnit']=trim(addslashes(strip_tags($_POST['OTSCP_SQtyUOM'])));
	$tdata['U_SColBy']=trim(addslashes(strip_tags($_POST['OTSCP_SampleCollectBy'])));
	$tdata['U_ARNo']=trim(addslashes(strip_tags($_POST['OTSCP_ARNo'])));
	$tdata['U_TrNo']=trim(addslashes(strip_tags($_POST['OTSCP_TRNo'])));
	$tdata['U_Branch']=trim(addslashes(strip_tags($_POST['OTSCP_BranchName'])));
	$tdata['U_ICode']=trim(addslashes(strip_tags($_POST['OTSCP_ItemCode'])));
	$tdata['U_IName']=trim(addslashes(strip_tags($_POST['OTSCP_ItemName'])));
	$tdata['U_BNo']=trim(addslashes(strip_tags($_POST['OTSCP_BatchNo'])));
	$tdata['U_NoCont']=trim(addslashes(strip_tags($_POST['OTSCP_NoOfCont'])));
	$tdata['U_RQty']=trim(addslashes(strip_tags($_POST['OTSCP_RetainQty'])));
	$tdata['U_RQtyUom']=trim(addslashes(strip_tags($_POST['OTSCP_RQtyUom'])));
	$tdata['U_ContNo1']=trim(addslashes(strip_tags($_POST['OTSCP_ContNo1'])));
	$tdata['U_ContNo2']=trim(addslashes(strip_tags($_POST['OTSCP_ContNo2'])));
	$tdata['U_ContNo3']=trim(addslashes(strip_tags($_POST['OTSCP_ContNo3'])));
	$tdata['U_QtyLab']=trim(addslashes(strip_tags($_POST['OTSCP_QtyLab'])));
	$tdata['U_SRSep']=trim(addslashes(strip_tags($_POST['OTSCP_SampleRecievedSepretly'])));
	$tdata['U_BtchQty']=trim(addslashes(strip_tags($_POST['OTSCP_BatchQty'])));
	$tdata['U_DDate']=trim(addslashes(strip_tags(date('Y-m-d', strtotime($_POST['OTSCP_DocDate'])))));
	$tdata['U_InDate']=trim(addslashes(strip_tags(date('Y-m-d', strtotime($_POST['OTSCP_IntimatedDate'])))));
	$tdata['U_UTNo']=trim(addslashes(strip_tags($_POST['OTSCP_UTNo'])));
	$tdata['U_BPLId']=trim(addslashes(strip_tags($_POST['OTSCP_BPLId'])));
	$tdata['U_LocCode']=trim(addslashes(strip_tags($_POST['OTSCP_LocCode'])));
	$tdata['U_PC_MakeBy']=trim(addslashes(strip_tags($_POST['OTSCP_MakeBy'])));
	$tdata['U_TypMaterial']=trim(addslashes(strip_tags($_POST['OTSCP_MaterialType'])));

	// echo '<pre>';
	// print_r($tdata);
	// die();
	
	// <!-- ---------------------- sample Intimation popup validation start Here ------------------ -->
		if(empty($_POST['OTSCP_SampleCollectBy'])){
			$data['status']='False';$data['DocEntry']='';
			$data['message']="Sample Collect By Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if(empty($_POST['OTSCP_DocDate'])){
			$data['status']='False';$data['DocEntry']='';
			$data['message']="Document Date Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if ($_POST['OTSCP_SQty'] <= 0) {
			$data['status']='False';$data['DocEntry']='';
			$data['message']="Sample Qty less then 0";
			echo json_encode($data);
			exit(0);
		}
	// <!-- ---------------------- sample Intimation popup validation end Here -------------------- -->

	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SCS_SCOL;

			$responce_encode=$obj->SaveSampleIntimation($tdata,$Final_API); // sample intimation save here
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();

				if($responce->DocNum!=""){
					// Update ARNo document number start here ------------------------------ -->
						// Sanitize input data
						$ItemCode = trim(addslashes(strip_tags($_POST['OTSCP_ItemCode'])));
						$Location = trim(addslashes(strip_tags($_POST['OTSCP_Location'])));
						$DocDate = !empty($_POST['OTSCP_DocDate']) ? date("Ymd", strtotime($_POST['OTSCP_DocDate'])) : null;

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

						if(array_key_exists('error', (array)$response_encode12)){
							$data['status']='False';
							$data['DocEntry']='';
							$data['message']=$response_encode12->error->message->value;
							echo json_encode($data);
						}else{
							if(!empty($_POST['OTSCP_SupplierName'])){
								// Purchase Delivery Notes

								$SIntiMainArray = [
									'DocumentLines' => [
										[
											'LineNum' => $responce->U_BLine,
											'U_PC_SCol' => $responce->DocEntry
										]
									]
								];

								$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_PurchaseDeliveryNotes.'('.$responce->U_GRPODEnt.')';

								// <!-- -------- Service Layer Function start here --------- -->
									$res11=$obj->SAP_Login();  // SAP Service Layer Login Here
									if(!empty($res)){
										$responce_encode1=$obj->PATCH_ServiceLayerMasterFunction($SIntiMainArray,$Final_API);
										$responce1=json_decode($responce_encode1);
									}
									$res12=$obj->SAP_Logout();  // SAP Service Layer Logout Here    
								// <!-- -------- Service Layer Function end here ----------- -->

								if(empty($responce1)){
									$data['status']='True';
									$data['DocEntry']=$responce->DocEntry;
									$data['message']="Open Transaction For Sample Collection Successfully Added.";
									echo json_encode($data);
								}else{
									if(array_key_exists('error', (array)$responce1)){
										$data['status']='False';
										$data['DocEntry']='';
										$data['message']=$responce1->error->message->value;
										echo json_encode($data);
									}
								}
							}else{
								// Inventory Gen Entries
								$InventoryGenEntries=array();
								$InventoryGenEntries['SIDocEntry']=trim($responce->DocEntry);
								$InventoryGenEntries['GRDocEntry']=trim($_POST['OTSCP_GRPODocEntry']);
								$InventoryGenEntries['ItemCode']=trim($tdata['U_ICode']);
								$InventoryGenEntries['LineNum']=trim($responce->U_BLine);

								$Final_API=$GRSAMPLECOLINWARD_APi;
								$responce_encode1=$obj->POST_QuerryBasedMasterFunction($InventoryGenEntries,$Final_API);
								$responce1=json_decode($responce_encode1);

								if(empty($responce1)){
									$data['status']='True';
									$data['DocEntry']=$responce->DocEntry;
									$data['message']="Open Transaction For Sample Collection Successfully Added.";
									echo json_encode($data);
								}else{
									if(array_key_exists('error', (array)$responce1)){
										$data['status']='False';
										$data['DocEntry']='';
										$data['message']=$responce1->error->message->value;
										echo json_encode($data);
									}
								}
							}
						}
					// Update ARNo document number end here -------------------------------- -->
				}else{
					if(array_key_exists('error', (array)$responce)){
						$data['status']='False';
						$data['DocEntry']='';
						$data['message']=$responce->error->message->value;
						echo json_encode($data);
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}

		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

// if(isset($_POST['action']) && $_POST['action'] =='sample_collection_ajax')
// {	

// 	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));
// 	$rowCount=trim(addslashes(strip_tags($_POST['rowCount'])));
// 	$rowCount_N=trim(addslashes(strip_tags($_POST['rowCount_N'])));

// 	// <!-- ------- Replace blank space to %20 start here -------- -->
// 		$API=$SAMPLECOLL_API.'?DocEntry='.$DocEntry;
// 		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
// 	// <!-- ------- Replace blank space to %20 End here -------- -->

// 	$response=$obj->get_OTFSI_SingleData($FinalAPI);

// 	// <!-- ------ Array declaration Start Here --------------------------------- -->
// 		$FinalResponce=array();
// 		$FinalResponce['SampleCollDetails']=$response;
// 	// <!-- ------ Array declaration End Here  --------------------------------- -->

// 	$ExtraIssue=$response[0]->SAMPLECOLLEXTRA; // Etra issue response seperate here 
// 	$ExternalIssue=$response[0]->SAMPLECOLLEXTERNAL; //External issue reponce seperate here

// 	// =================================================================================================================
// 		// <!-- ----------- Extra Issue Start here --------------------------------- -->
// 			if(!empty($ExtraIssue)){
// 				for ($i=0; $i <count($ExtraIssue) ; $i++) {
// 					$SrNo=$rowCount_N+1;

// 					$IssueDate=(!empty($ExtraIssue[$i]->IssueDate)) ? date("d-m-Y", strtotime($ExtraIssue[$i]->IssueDate)) : '';

// 					$FinalResponce['ExtraIssue'].='<tr>
// 						<td>
// 							<input type="radio" id="ExtraIslist'.$SrNo.'" name="ExtraIslistRado" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExtraIssue('.$SrNo.')">
// 						</td>

// 						<td class="desabled">
// 							<input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control desabled" readonly>

// 							<input class="border_hide desabled" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->SampleQuantity.'" class="form-control desabled" readonly>
// 						</td>

// 						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM.'" class="form-control desabled" readonly></td>

// 						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_FEI_Warehouse[]" value="'.$ExtraIssue[$i]->Warehouse.'" class="form-control desabled" readonly></td>

// 						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control desabled" readonly></td>

// 						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control desabled" readonly></td>

// 						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control desabled" readonly></td>
// 					</tr>';
// 				}
// 				// when table data come then default add one manual row start --------------------------------------

// 				$SrNo=(count($ExtraIssue)+1);
// 				$FinalResponce['ExtraIssue'].='<tr>
// 					<td class="desabled"></td>

// 					<td>
// 						<input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control" readonly>

// 						<input class="border_hide" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->SampleQuantity.'" class="form-control">
// 					</td>

// 					<td><input class="border_hide" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM.'" class="form-control"></td>

// 					<td>
// 						<select class="form-control SC_FEI_WarehouseWithData" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;"></select>
// 					</td>

// 					<td><input class="border_hide" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control"></td>

// 					<td><input class="border_hide" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control"></td>

// 					<td><input class="border_hide" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control"></td>
// 				</tr>';
// 			}else{
// 				$SrNo=$rowCount_N+1;
// 				$FinalResponce['ExtraIssue'].='<tr>
// 					<td class="desabled"></td>

// 					<td>
// 						<input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control" readonly>

// 						<input class="border_hide" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->SampleQuantity.'" class="form-control">
// 					</td>

// 					<td><input class="border_hide" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM.'" class="form-control"></td>

// 					<td>
// 						<select class="form-control SC_FEI_WarehouseWithData" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;"></select>
// 					</td>

// 					<td><input class="border_hide" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control"></td>

// 					<td><input class="border_hide" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control"></td>

// 					<td><input class="border_hide" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control"></td>
// 				</tr>';
// 			}
// 		// <!-- ----------- Extra Issue End here ----------------------------------- -->
// 	// =================================================================================================================

// 	// <!-- ----------- External Issue Start Here ------------------------------------------------------------------ -->
// 		if(!empty($ExternalIssue)){
// 			for ($j=0; $j <count($ExternalIssue) ; $j++) {
// 				$SrNo=$rowCount+1;
// 				$SampleDate=(!empty($ExternalIssue[$j]->SampleDate)) ? date("d-m-Y", strtotime($ExternalIssue[$j]->SampleDate)) : '';

// 				$FinalResponce['ExternalIssue'].='<tr>
// 					<td style="text-align: center;">
// 						<input class="border_hide" type="hidden" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="'.$ExternalIssue[$j]->Linenum.'" class="form-control desabled" readonly>

// 						<input type="radio" id="list'.$SrNo.'" name="listRado" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExternalIssue('.$SrNo.')">
// 					</td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierCode'.$SrNo.'" name="SC_FEXI_SupplierCode[]" value="'.$ExternalIssue[$j]->SupplierCode.'" class="form-control desabled" readonly></td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" value="'.$ExternalIssue[$j]->SupplierName.'" class="form-control desabled" readonly></td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" value="'.$ExternalIssue[$j]->UOM.'" class="form-control desabled" readonly></td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" value="'.$SampleDate.'" class="form-control desabled" readonly></td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Warehouse'.$SrNo.'" name="SC_FEXI_Warehouse[]" value="'.$ExternalIssue[$j]->Warehouse.'" class="form-control desabled" readonly></td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" value="'.$ExternalIssue[$j]->SampleQuantity.'" class="form-control desabled" readonly></td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" value="'.$ExternalIssue[$j]->InventoryTransfer.'" class="form-control desabled" readonly></td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" value="'.$ExternalIssue[$j]->UserText1.'" class="form-control desabled" readonly></td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" value="'.$ExternalIssue[$j]->UserText2.'" class="form-control desabled" readonly></td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" value="'.$ExternalIssue[$j]->UserText3.'" class="form-control desabled" readonly></td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" value="'.$ExternalIssue[$j]->Attachment.'" class="form-control"></td>
// 				</tr>';
// 			}

// 			// when table data come then default add one manual row start --------------------------------------------------
// 				$SrNo=(count($ExternalIssue)+1);

// 				$FinalResponce['ExternalIssue'].='<tr>
// 					<td></td>

// 					<td>
// 						<input class="border_hide" type="hidden" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="" class="form-control desabled" readonly>

// 						<select class="form-control ExternalIssueSelectedBPWithData" id="SC_ExternalI_SupplierCode'.$SrNo.'" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;"></select>
// 					</td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>

// 					<td><input class="border_hide" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" class="form-control desabled"></td>

// 					<td><input class="border_hide" type="date" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>

// 					<td><select class="form-control ExternalIssueWareHouseWithData" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_ExternalI_Warehouse[]" style="width: 200px;"></select></td>

// 					<td><input class="border_hide" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

// 					<td><input class="border_hide" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" class="form-control"></td>

// 					<td><input class="border_hide" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" class="form-control"></td>

// 					<td><input class="border_hide" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" class="form-control"></td>

// 					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" class="form-control"></td>
// 				</tr>';
// 			// when table data come then default add one manual row end ----------------------------------------------------
// 		}else{
// 			// if user not added External issue recored then show default blank row
// 			$SrNo=$rowCount+1;

// 			$FinalResponce['ExternalIssue'].='<tr>
// 				<td><input class="border_hide" type="text" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="'.$SrNo.'" class="form-control desabled" readonly></td>

// 				<td><select class="form-control ExternalIssueDefault" id="SC_ExternalI_SupplierCode'.$SrNo.'" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;"></select></td>

// 				<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>

// 				<td><input class="border_hide" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" class="form-control desabled"></td>

// 				<td><input class="border_hide" type="date" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>

// 				<td><select class="form-control ExternalIssueWareHouseDefault" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_ExternalI_Warehouse[]" style="width: 200px;"></select></td>

// 				<td><input class="border_hide" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>

// 				<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

// 				<td><input class="border_hide" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" class="form-control"></td>

// 				<td><input class="border_hide" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" class="form-control"></td>

// 				<td><input class="border_hide" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" class="form-control"></td>

// 				<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" class="form-control"></td>
// 			</tr>';
// 		}
// 	// <!-- ----------- External Issue End Here -------------------------------------------------------------------- -->

// 	echo json_encode($FinalResponce);
// 	exit(0);
// }

if(isset($_POST['action']) && $_POST['action'] =='sample_collection_ajax')
{	

	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));
	$rowCount=trim(addslashes(strip_tags($_POST['rowCount'])));
	$rowCount_N=trim(addslashes(strip_tags($_POST['rowCount_N'])));

	// <!-- ------- Replace blank space to %20 start here -------- -->
		$API=$SAMPLECOLL_API.'?DocEntry='.$DocEntry;
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	// <!-- ------ Array declaration Start Here --------------------------------- -->
		$FinalResponce=array();
		$FinalResponce['SampleCollDetails']=$response;
	// <!-- ------ Array declaration End Here  --------------------------------- -->

	$ExtraIssue=$response[0]->SAMPLECOLLEXTRA; // Etra issue response seperate here 
	$ExternalIssue=$response[0]->SAMPLECOLLEXTERNAL; //External issue reponce seperate here

	// =================================================================================================================
		// <!-- ----------- Extra Issue Start here --------------------------------- -->
			if(!empty($ExtraIssue)){
				for ($i=0; $i <count($ExtraIssue) ; $i++) {
					if(!empty($ExtraIssue[$i]->SampleBy)){
						$SrNo=$rowCount_N+1;

						$IssueDate=(!empty($ExtraIssue[$i]->IssueDate)) ? date("d-m-Y", strtotime($ExtraIssue[$i]->IssueDate)) : '';

						$FinalResponce['ExtraIssue'].='<tr>';
							if(!empty($ExtraIssue[$i]->PostExtraIssue)){
								$FinalResponce['ExtraIssue'].='<td class="desabled">
										<input type="radio" id="ExtraIslist'.$SrNo.'" name="ExtraIslistRado" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;display: none;" onclick="selectedExtraIssue('.$SrNo.')">
										1.
									</td>';
							}else{
								$FinalResponce['ExtraIssue'].='<td>
										<input type="radio" id="ExtraIslist'.$SrNo.'" name="ExtraIslistRado" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExtraIssue('.$SrNo.')">
									</td>';
							}
							
						$FinalResponce['ExtraIssue'].='<td class="desabled">
								<input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control desabled" readonly>

								<input class="border_hide desabled" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->SampleQuantity.'" class="form-control desabled" readonly>
							</td>

							<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM.'" class="form-control desabled" readonly></td>

							<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_FEI_Warehouse[]" value="'.$ExtraIssue[$i]->Warehouse.'" class="form-control desabled" readonly></td>

							<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control desabled" readonly></td>

							<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control desabled" readonly></td>

							<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control desabled" readonly></td>
						</tr>';
					}else{
						$SrNo=$rowCount_N+1;
						$FinalResponce['ExtraIssue'].='<tr>
							<td class="desabled">1.</td>

							<td>
								<input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control" readonly>

								<input class="form-control border_hide" type="number" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->SampleQuantity.'" onfocusout="GetExtraIuuseWhs('.$SrNo.')">
							</td>

							<td class="desabled"><input class="form-control border_hide desabled" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM.'" readonly></td>


							<td class="desabled"><input class="form-control border_hide desabled" type="text" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_FEI_Warehouse[]" value="'.$ExtraIssue[$i]->Warehouse.'" readonly></td>

							<td class="desabled"><input class="form-control border_hide desabled" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" readonly></td>

							<td class="desabled"><input class="form-control border_hide desabled" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" readonly></td>

							<td class="desabled"><input class="form-control border_hide desabled" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" readonly></td>
						</tr>';
					}
					
				}
				// when table data come then default add one manual row start --------------------------------------


				// // <td>
				// // 	<select class="form-control SC_FEI_WarehouseWithData" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;"></select>
				// // </td>
				// $SrNo=(count($ExtraIssue)+1);
				// $FinalResponce['ExtraIssue'].='<tr>
				// 	<td class="desabled">1</td>

				// 	<td>
				// 		<input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control" readonly>

				// 		<input class="border_hide" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->SampleQuantity.'" class="form-control">
				// 	</td>

				// 	<td><input class="border_hide" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM.'" class="form-control"></td>


				// 	<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_FEI_Warehouse[]" value="'.$ExtraIssue[$i]->Warehouse.'" class="form-control desabled" readonly></td>

				// 	<td><input class="border_hide" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control"></td>

				// 	<td><input class="border_hide" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control"></td>

				// 	<td><input class="border_hide" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control"></td>
				// </tr>';
			}else{
				$SrNo=$rowCount_N+1;
				$FinalResponce['ExtraIssue'].='<tr>
					<td class="desabled">1.</td>

					<td>
						<input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control" readonly>

						<input class="form-control border_hide" type="number" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->SampleQuantity.'" onfocusout="GetExtraIuuseWhs('.$SrNo.')">
					</td>

					<td class="desabled"><input class="form-control border_hide desabled" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM.'" readonly></td>


					<td class="desabled"><input class="form-control border_hide desabled" type="text" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_FEI_Warehouse[]" value="'.$ExtraIssue[$i]->Warehouse.'" readonly></td>

					<td class="desabled"><input class="form-control border_hide desabled" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" readonly></td>

					<td class="desabled"><input class="form-control border_hide desabled" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" readonly></td>

					<td class="desabled"><input class="form-control border_hide desabled" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" readonly></td>
				</tr>';
			}
		// <!-- ----------- Extra Issue End here ----------------------------------- -->
	// =================================================================================================================

	// <!-- ----------- External Issue Start Here ------------------------------------------------------------------ -->
		if(!empty($ExternalIssue)){
			for ($j=0; $j <count($ExternalIssue) ; $j++) {

				if(!empty($ExternalIssue[$j]->UOM)){
					$SrNo=$rowCount+1;
					$SampleDate=(!empty($ExternalIssue[$j]->SampleDate)) ? date("d-m-Y", strtotime($ExternalIssue[$j]->SampleDate)) : '';

					$FinalResponce['ExternalIssue'].='<tr>';

						if(!empty($ExternalIssue[$j]->InventoryTransfer)){
							$FinalResponce['ExternalIssue'].='<td  class="desabled" style="text-align: center;">
								<input class="border_hide" type="hidden" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="'.$ExternalIssue[$j]->Linenum.'" class="form-control desabled" readonly>

								<input type="radio" id="list'.$SrNo.'" name="listRado" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;display: none;" onclick="selectedExternalIssue('.$SrNo.')">
								1.
							</td>';
						}else{
							$FinalResponce['ExternalIssue'].='<td  class="desabled" style="text-align: center;">
								<input class="border_hide" type="hidden" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="'.$ExternalIssue[$j]->Linenum.'" class="form-control desabled" readonly>

								<input type="radio" id="list'.$SrNo.'" name="listRado" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExternalIssue('.$SrNo.')">
							</td>';
						}

					$FinalResponce['ExternalIssue'].='
						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierCode'.$SrNo.'" name="SC_FEXI_SupplierCode[]" value="'.$ExternalIssue[$j]->SupplierCode.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" value="'.$ExternalIssue[$j]->SupplierName.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" value="'.$ExternalIssue[$j]->UOM.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" value="'.$SampleDate.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_ExternalI_Warehouse[]" value="'.$ExternalIssue[$j]->Warehouse.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" value="'.$ExternalIssue[$j]->SampleQuantity.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" value="'.$ExternalIssue[$j]->InventoryTransfer.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" value="'.$ExternalIssue[$j]->UserText1.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" value="'.$ExternalIssue[$j]->UserText2.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" value="'.$ExternalIssue[$j]->UserText3.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" value="'.$ExternalIssue[$j]->Attachment.'" class="form-control"></td>
					</tr>';
				}else{

					$SrNo=$rowCount+1;

					$FinalResponce['ExternalIssue'].='<tr>
						<td><input class="border_hide" type="text" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="'.$SrNo.'" class="form-control desabled" readonly></td>

						<td><select class="form-control ExternalIssueDefault" id="SC_ExternalI_SupplierCode'.$SrNo.'" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;"></select></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" class="form-control desabled" readonly></td>

						<td><input class="border_hide" type="date" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_ExternalI_Warehouse[]" class="form-control desabled" readonly></td>

						<td><input class="border_hide" type="number" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

						<td><input class="border_hide" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" class="form-control"></td>

						<td><input class="border_hide" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" class="form-control"></td>

						<td><input class="border_hide" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" class="form-control"></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" class="form-control"></td>
					</tr>';
				}
			}

			// when table data come then default add one manual row start --------------------------------------------------
				// $SrNo=(count($ExternalIssue)+1);

				// // <td><select class="form-control ExternalIssueWareHouseWithData" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_ExternalI_Warehouse[]" style="width: 200px;"></select></td>

				// $FinalResponce['ExternalIssue'].='<tr>
				// 	<td></td>

				// 	<td>
				// 		<input class="border_hide" type="hidden" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="" class="form-control desabled" readonly>

				// 		<select class="form-control ExternalIssueSelectedBPWithData" id="SC_ExternalI_SupplierCode'.$SrNo.'" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;"></select>
				// 	</td>

				// 	<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>

				// 	<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" class="form-control desabled" readonly></td>

				// 	<td><input class="border_hide" type="date" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>

				// 	<td class="desabled"><input class="border_hide desabled" type="text" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_ExternalI_Warehouse[]" class="form-control desabled" readonly></td>

				// 	<td><input class="border_hide" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>

				// 	<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

				// 	<td><input class="border_hide" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" class="form-control"></td>

				// 	<td><input class="border_hide" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" class="form-control"></td>

				// 	<td><input class="border_hide" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" class="form-control"></td>

				// 	<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" class="form-control"></td>
				// </tr>';
			// when table data come then default add one manual row end ----------------------------------------------------
		}else{
			// if user not added External issue recored then show default blank row

				// <td><select class="form-control ExternalIssueWareHouseDefault" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_ExternalI_Warehouse[]" style="width: 200px;"></select></td>

			$SrNo=$rowCount+1;

			$FinalResponce['ExternalIssue'].='<tr>
				<td><input class="border_hide" type="text" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="'.$SrNo.'" class="form-control desabled" readonly></td>

				<td><select class="form-control ExternalIssueDefault" id="SC_ExternalI_SupplierCode'.$SrNo.'" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;"></select></td>

				<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>

				<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" class="form-control desabled" readonly></td>

				<td><input class="border_hide" type="date" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>

				<td class="desabled"><input class="border_hide desabled" type="text" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_ExternalI_Warehouse[]" class="form-control desabled" readonly></td>

				<td><input class="border_hide" type="number" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>

				<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

				<td><input class="border_hide" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" class="form-control"></td>

				<td><input class="border_hide" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" class="form-control"></td>

				<td><input class="border_hide" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" class="form-control"></td>

				<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" class="form-control"></td>
			</tr>';
		}
	// <!-- ----------- External Issue End Here -------------------------------------------------------------------- -->

	echo json_encode($FinalResponce);
	exit(0);
}



if(isset($_POST['action']) && $_POST['action'] =='OT_QC_PD_popup')
{
	$API=$INWARDQCPOSTDOC_API.'&DocEntry='.$_POST['DocEntry'].'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&LineNum='.$_POST['LineNum'];

	// <!-- ------- Replace blank space to %20 start here -------- -->
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20

		
	// <!-- ------- Replace blank space to %20 End here -------- -->
	// print_r($API);
	// die();
	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}




		if(isset($_POST['action']) && $_POST['action'] =='OTFQCPD_Table_Ajax'){

			$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
			// <!--------------- Preparing API Start Here ------------------------------------------ -->
				$API=$INWARDQCPOSTROWDETAILS_API.'?ItemCode='.$ItemCode;
				
				$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
				// print_r($FinalAPI);
				// die();
			// <!--------------- Preparing API End Here ------------------------------------------ -->
			$response=$obj->get_OTFSI_SingleData($FinalAPI);

			

			// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
			// '.$response[$i]->PName.'
				$option=array();
				if(!empty($response)){
					// CalculateResultOut
					for ($i=0; $i <count($response) ; $i++) { 
						$option['tr'].='<tr>
						    <td class="desabled">'.($i+1).'</td>

						    <td class="desabled">
						    	<input type="text" id="pCode'.$i.'" name="pCode[]" value="'.$response[$i]->PCode.'" class="form-control textbox_bg">
						    </td>

						    <td class="desabled">
						    
						    	<input type="text" id="PName'.$i.'" name="PName[]" value="'.htmlspecialchars($response[$i]->PName, ENT_QUOTES, 'UTF-8').'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
						    </td>

						    <td class="desabled" title="'.$response[$i]->Standard.'" style="cursor: pointer;">
						    	<input type="text" id="Standard'.$i.'" name="Standard[]" value="'.htmlspecialchars($response[$i]->Standard, ENT_QUOTES, 'UTF-8').'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;width:400px;">
						    </td>

							<td>
								<input type="text" id="ResultOut'.$i.'" name="ResultOut[]" value="" class="form-control" style="width:200px;">
							</td>';

							// onfocusout="SetComparisonResultValTOResOutput('.$i.')"
							if($response[$i]->PDType=='Range'){
								$option['tr'].='<td>
									<input type="text" id="ComparisonResult'.$i.'" name="ComparisonResult[]" value="" class="form-control" style="width:100px;" onfocusout="CalculateResultOut('.$i.')">
								</td>';
							}else{
								$option['tr'].='<td class="desabled">
									<input type="text" id="ComparisonResult'.$i.'" name="ComparisonResult[]" value="" class="form-control textbox_bg" style="width:100px;">
								</td>';
							}
			

							$option['tr'].='<td id="ResultOutputByQCDeptTd'.$i.'">
								<select id="ResultOutputByQCDept'.$i.'" name="ResultOutputByQCDept[]" class="form-select" style="border: 1px solid #ffffff !important;" onchange="OnChangeResultOutputByQCDept('.$i.')"></select>
							</td>

						    <td class="desabled">
						    	<input type="text" id="PDType'.$i.'" name="PDType[]" value="'.$response[$i]->PDType.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
						    </td>

						    <td class="desabled">
						    	<input type="text" id="Logical'.$i.'" name="Logical[]" value="'.$response[$i]->Logical.'" class="form-control textbox_bg" style="width: 100px;">
						    </td>

							<td class="desabled">
						    	<input type="text" id="LowMin'.$i.'" name="LowMin[]" value="'.$response[$i]->LowMin.'" class="form-control textbox_bg" style="width:100px;">
						    </td>

						    <td class="desabled">
						    	<input type="text" id="UppMax'.$i.'" name="UppMax[]" value="'.$response[$i]->UppMax.'" class="form-control textbox_bg" style="width:100px;">
						    </td>

							<td class="desabled">
								<input type="text" id="Min'.$i.'" name="Min[]" value="'.$response[$i]->Min.'" class="form-control textbox_bg" style="width:100px;">
							</td>

							<td id="QC_StatusByAnalystTd'.$i.'">
								<select id="QC_StatusByAnalyst'.$i.'" name="QC_StatusByAnalyst[]" class="form-select" onchange="SelectedQCStatus('.$i.')">
								</select>
							</td>

							<td class="desabled">
								<input type="text" id="TMethod'.$i.'" name="TMethod[]" value="'.$response[$i]->TMethod.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>

							<td class="desabled">
								<input type="text" id="MType'.$i.'" name="MType[]" value="'.$response[$i]->MType.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>

							<td class="desabled">
								<input type="text" id="PharmacopeiasStandard'.$i.'" name="PharmacopeiasStandard[]" value="'.$response[$i]->PharmacopeiasStandard.'"" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>

							<td class="desabled">
								<input type="text" id="UOM'.$i.'" name="UOM[]" value="'.$response[$i]->UOM.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>

							<td class="desabled">
								<input type="text" id="Retest'.$i.'" name="Retest[]" value="'.$response[$i]->Retest.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>

							<td class="desabled">
								<input type="text" id="ExSample'.$i.'" name="ExSample[]" value="'.$response[$i]->ExSample.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>


							<td>
								<select id="AnalysisBy'.$i.'" name="AnalysisBy[]" class="form-select" style="width: 140px;"></select>
							</td>

							<td>
								<input type="text" id="analyst_remark'.$i.'" name="analyst_remark[]" class="form-control">
							</td>

							<td class="desabled">
								<input type="text" id="LowMax'.$i.'" name="LowMax[]" value="'.$response[$i]->LowMax.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>

							<td class="desabled">
								<input type="text" id="Release'.$i.'" name="Release[]" value="'.$response[$i]->Release.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>

							<td>
								<input type="text" id="DescriptiveDetails'.$i.'" name="DescriptiveDetails[]" class="form-control">
							</td>

							<td class="desabled">
								<input type="text" id="UppMin'.$i.'" name="UppMin[]" value="'.$response[$i]->UppMin.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>

							<td>
								<input  type="number" id="LowMinRes'.$i.'" name="LowMinRes[]" class="form-control">
							</td>

							<td>
								<input  type="number" id="UppMinRes'.$i.'" name="UppMinRes[]" class="form-control">
							</td>

							<td>
								<input  type="number" id="UppMaxRes'.$i.'" name="UppMaxRes[]" class="form-control">
							</td>

							<td>
								<input type="number" id="MeanRes'.$i.'" name="MeanRes[]" class="form-control">
							</td>

							<td>
								<input  type="text" id="UserText1'.$i.'" name="UserText1[]" class="form-control">
							</td>

							<td>
								<input  type="text" id="UserText2'.$i.'" name="UserText2[]" class="form-control">
							</td>

							<td>
								<input type="text" id="UserText3'.$i.'" name="UserText3[]" class="form-control">
							</td>

							<td>
								<input type="text" id="UserText4'.$i.'" name="UserText4[]" class="form-control">
							</td>

							<td>
								<input type="text" id="UserText5'.$i.'" name="UserText5[]" class="form-control">
							</td>

							<td class="desabled">
								<input type="text" id="QC_StatusResult'.$i.'" name="QC_StatusResult[]" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>

							<td class="desabled">
								<input type="text" id="Stability'.$i.'" name="Stability[]" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>

							<td class="desabled">
								<input type="text" id="Appassay'.$i.'" name="Appassay[]" value="'.$response[$i]->Appassay.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>

							<td class="desabled">
								<input type="text" id="AppLOD'.$i.'" name="AppLOD[]" value="'.$response[$i]->AppLOD.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>

							<td>
								<input type="text" id="InstrumentCode'.$i.'" name="InstrumentCode[]" class="form-control" data-bs-toggle="modal" data-bs-target=".instrument_modal" onclick="OpenInstrmentModal('.$i.')">
							</td>

							<td class="desabled">
								<input type="text" id="InstrumentName'.$i.'" name="InstrumentName[]" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
							</td>

							<td>
								<input type="date" id="StartDate'.$i.'" name="StartDate[]" class="form-control">
							</td>

							<td>
								<input type="time" id="StartTime'.$i.'" name="StartTime[]" class="form-control">
							</td>

							<td>
								<input type="date" id="EndDate'.$i.'" name="EndDate[]" class="form-control">
							</td>

							<td>
								<input type="time" id="EndTime'.$i.'" name="EndTime[]" class="form-control">
							</td>

						</tr>';
					}

					// <td>
					// 	<input type="text" id="DesDetils'.$i.'" name="DesDetils[]" value="'.$response[$i]->DesDetils.'" class="form-control">
					// </td>

					// <td>
					// 	<input type="text" id="Remarks'.$i.'" name="Remarks[]" value="'.$response[$i]->Remarks.'" class="form-control">
					// </td>

				}else{
					$option['tr']='<tr><td colspan="41" style="text-align: center;color:red;">Record Not Found</td></tr>';
				}

			  
			  	$option['qcStatus'] ='<tr id="add-more_1">
					<td>1</td>
					<td><select id="qc_Status_1" name="qc_Status[]" class="form-select qc_status_selecte1" onchange="SelectionOfQC_Status(1)"></select></td>

					<td><input class="border_hide" type="text"  id="qCStsQty_1" name="qCStsQty[]" class="form-control" onfocusout="addMore(1);"></td>

					<td><input class="border_hide" type="date"  id="qCReleaseDate_1" name="qCReleaseDate[]" class="form-control"></td>

					<td><input class="border_hide" type="time"  id="qCReleaseTime_1" name="qCReleaseTime[]" class="form-control"></td>

					<td><input class="border_hide" type="text"  id="qCitNo_1" name="qCitNo[]" class="form-control" value=""></td>

					<td><select id="doneBy_1" name="doneBy[]" class="form-select done-by-mo1"></select></td>

					<td><input class="border_hide" type="file"  id="qCAttache1_1" name="qCAttache1[]" class="form-control"></td>

					<td><input class="border_hide" type="file"  id="qCAttache2_1" name="qCAttache2[]" class="form-control"></td>

					<td><input class="border_hide" type="file"  id="qCAttache3_1" name="qCAttache3[]" class="form-control"></td>

					<td><input class="border_hide" type="date"  id="qCDeviationDate_1" name="qCDeviationDate[]" class="form-control"></td>

					<td><input class="border_hide" type="text"  id="qCDeviationNo_1" name="qCDeviationNo[]" class="form-control"></td>

					<td><input class="border_hide" type="text"  id="qCDeviationResion_1" name="qCDeviationResion[]" class="form-control"></td>

					<td><input class="border_hide" type="text"  id="qCStsRemark1_1" name="qCStsRemark1[]" class="form-control" value=""></td>
				</tr>';



				$option['qcAttach'].='
				               <tr>
				                <td class="desabled">1</td>
				                <td class="desabled"><input class="border_hide desabled" type="text" id="targetPath_1" name="targetPath[]" class="form-control" readonly>
				                </td>
				                <td class="desabled"><input class="border_hide desabled" type="text" id="fileName_1" name="fileName[]"  class="form-control" readonly></td>
				                <td class="desabled"><input class="border_hide desabled" type="text" id="attachDate_1" name="attachDate[]"  class="form-control" readonly></td>
				                <td><input class="border_hide" type="text" id="freeText_1" name="freeText[]"  class="form-control"></td>
							</tr>';


			// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
			$option['count']=count($response);
			echo json_encode($option);
			exit(0);
		}













if(isset($_POST['action']) && $_POST['action'] =='QC_StatusByAnalystDropdownWithSelectedOption_Ajax')
{
	$TableId=trim(addslashes(strip_tags($_POST['TableId'])));
	$Alias=trim(addslashes(strip_tags($_POST['Alias'])));

	$Final_API=$dropdownMaster_API.'?TableId='.$TableId.'&Alias='.$Alias;
	$response=$obj->GetMethodQuerryBasedAPI($Final_API);

	// $option .= '<option value="Regular">Regular -> '.$Final_API.'</option>';
	echo $response;
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='dropdownMaster_ajax')
{
	$TableId=trim(addslashes(strip_tags($_POST['TableId'])));
	$Alias=trim(addslashes(strip_tags($_POST['Alias'])));

	$Final_API=$dropdownMaster_API.'?TableId='.$TableId.'&Alias='.$Alias;
	$response=$obj->getAnyDorpDownMasterFun($Final_API);

	// $option .= '<option value="Regular">Regular -> '.$Final_API.'</option>';
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='ResultOutputDropdown_ajax')
{
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res=$obj->SAP_Login();  // SAP Service Layer Login Here

	if(!empty($res)){
		$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SCS_OROUTPUT;


		// print_r($Final_API);

		// die();

		$responce_encode=$obj->getFunctionServiceLayer($Final_API);
		$responce=json_decode($responce_encode);

		for ($i=0; $i <count($responce->value) ; $i++) { 
			
			$option .= '<option value="'.$responce->value[$i]->Code.'">'.$responce->value[$i]->Name.'</option>';
		}
	}
	
	$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	print_r($option);
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='getResultOutputDropdownWithSelectedOption_Ajax')
{
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res=$obj->SAP_Login();  // SAP Service Layer Login Here

	if(!empty($res)){
		$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SCS_OROUTPUT;

		

		// print_r($Final_API);
		// die();

		$responce_encode=$obj->getFunctionServiceLayer($Final_API);
		$responce=json_decode($responce_encode);

		$responce1=$responce->value;
	}
	
	$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	print_r(json_encode($responce1));
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='GetRowLevelAnalysisByDropdown_Ajax'){
	$Final_API=$QCPOSTQSDONEBYDROPDOWN_APi;
	$response_json_decode=$obj->GetMethodQuerryBasedAPI($Final_API);
	$response=json_decode($response_json_decode);

	$option.='<option value="">Select</option>';
	foreach ($response as $key => $value) {
		$option.='<option value="'.$value->UserCode.'">'.$value->UserName.'</option>';
	}

	echo json_encode($option);
	exit(0);
}


if(isset($_POST['action']) && $_POST['action'] =='GetBottomApprovedBy_Ajax'){
	$option=array();
	   $value_id=$_POST['value_id'];
	// <!-- ----- Approved By dropdown prepare start here ------------------------- -->
		$Final_API=$QCPOSTDOCAPPROVEDBYDROPDOWN_APi;
		$response_json_decode=$obj->GetMethodQuerryBasedAPI($Final_API);
		$response=json_decode($response_json_decode);

		$option['ApprovedBy'].='<option value="">Select</option>';
		foreach ($response as $key => $value) {
			$selected = ($value_id==$value->UserCode)?'selected':'';
			$option['ApprovedBy'].='<option value="'.$value->UserCode.'" '.$selected.'>'.$value->UserName.'</option>';
		}

	// <!-- ----- Approved By dropdown prepare end here --------------------------- -->
	
	echo json_encode($option);
	exit(0);
}


if(isset($_POST['action']) && $_POST['action'] =='OpenInstrmentModal_Ajax'){
	$un_id=trim(addslashes(strip_tags($_POST['un_id'])));

	$Final_API=$QCPOSTGDINSTRUMENTDROPDOWN_APi;
	$response_json_decode=$obj->GetMethodQuerryBasedAPI($Final_API);
	$response=json_decode($response_json_decode);

	$option.='<table class="table sample-table-responsive table-bordered">
	    <thead class="fixedHeader1">
	        <tr>
	            <th>Sr. No</th>
	            <th></th>
	            <th>Instrument Code</th>
	            <th>Instrument Name</th>
	        </tr>
	    </thead>
	    <tbody>';
	    if(!empty($response)){
			foreach ($response as $key => $value) {
			    $option.='<tr>
			        <td class="desabled">'.($key+1).'.</td>
			        <td class="desabled">
			        	<input type="radio" class="custom-control-input" id="InstrumentId'.$key.'" value="'.$key.'" name="InstrumentId[]">
			        </td>
			        <td class="desabled" id="Html_InstrumentCode'.$key.'">'.$value->Code.'</td>
			        <td class="desabled" id="Html_InstrumentName'.$key.'">'.$value->Name.'</td>
			    </tr>';
			}
	    }else{
	    	 $option.='<tr>
			        <td class="desabled text-danger" colspan="4">Data Not Found</td>
			    </tr>';
	    }
		    
	    $option.='</tbody>
	</table>
	<button data-bs-dismiss="modal" class="btn btn-primary" onclick="GetSelectedInstumentdata('.$un_id.')">Submit</button>';

	echo json_encode($option);
	exit(0);
}

if(isset($_POST['addQcPostDocumentBtn_open_trans'])){

	//<!-- ------ valdiation start --------------------------------- --> 
		if($_POST['RelMaterialWithoutQC']=='No'){
			if($_POST['Assaypotencyreq']=='Yes'){
				// <!-- AssayPotency validation start --------------- -->
					$AssayPotency =trim(addslashes(strip_tags($_POST['AssayPotency'])));

					// Check if AssayPotency is empty
					if ($AssayPotency === '' || $AssayPotency === null) {
						$data['status']='False';
						$data['DocEntry']='';
						$data['message']=' Please Enter value in AssayPotency % is empty';
						echo json_encode($data);
						exit();
					} else {
					    // Convert AssayPotency to a float
					    $AssayPotency = floatval($AssayPotency);
					   
					    // Check if AssayPotency is equal to 0 or not less than 0 and not greater than 100
							if ($AssayPotency > 100){
								$data['status']='False';
								$data['DocEntry']='';
								$data['message']='AssayPotency %  not greater than 100';
								echo json_encode($data);
								exit();
						    }

						    if ($AssayPotency <= 0) {
								$data['status']='False';
								$data['DocEntry']='';
								$data['message']='AssayPotency % is not equal to 0 or not less than 0';
								echo json_encode($data);
								exit();
						    }
					}
				// <!-- AssayPotency validation end ----------------- -->

				// <!-- Factor validation start --------------------- -->
					$Factor = trim(addslashes(strip_tags($_POST['factor'])));
					if(empty($Factor)){
						$data['status']='False';
						$data['DocEntry']='';
						$data['message']=' Please Enter value in Factor.';
						echo json_encode($data);
						exit();
					}
				// <!-- Factor validation end ----------------------- -->	
			}
		}
	//<!-- ------ valdiation end ----------------------------------- --> 

	$tdata=array(); // This array send to AP Standalone Invoice process 

	$tdata['U_BLine']=trim(addslashes(strip_tags($_POST['LineNum'])));
	$tdata['U_BPLId']=trim(addslashes(strip_tags($_POST['U_BPLId'])));
	$tdata['U_LocCode']=trim(addslashes(strip_tags($_POST['U_LocCode'])));

	if(!empty($_POST['supplierName'])){
		$tdata['U_GRPONo']=trim(addslashes(strip_tags($_POST['GRPONo'])));
		$tdata['U_GRPODEnt']=trim(addslashes(strip_tags($_POST['GRPODocEntry'])));
	}else{
		$tdata['U_GRNo']=trim(addslashes(strip_tags($_POST['GRPONo'])));
		$tdata['U_GRDEnt']=trim(addslashes(strip_tags($_POST['GRPODocEntry'])));
	}

	$tdata['U_SCode']=trim(addslashes(strip_tags($_POST['supplierCode'])));
	$tdata['U_SName']=trim(addslashes(strip_tags($_POST['supplierName'])));
	$tdata['U_ICode']=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$tdata['U_IName']=trim(addslashes(strip_tags($_POST['ItemName'])));
	$tdata['U_GName']=trim(addslashes(strip_tags($_POST['GenericName'])));
	$tdata['U_LClaim']=trim(addslashes(strip_tags($_POST['LabelClaim'])));
	$tdata['U_LClmUom']=trim(addslashes(strip_tags($_POST['LabelClaimUOM'])));
	$tdata['U_RecQty']=trim(addslashes(strip_tags($_POST['GRNQty'])));
	$tdata['U_MBy']=trim(addslashes(strip_tags($_POST['MfgBy'])));
	$tdata['U_RBy']=trim(addslashes(strip_tags($_POST['RefNo'])));
	$tdata['U_BNo']=trim(addslashes(strip_tags($_POST['BatchNo'])));
	$tdata['U_BSize']=trim(addslashes(strip_tags($_POST['BatchQty'])));
	$tdata['U_MfgDate']=(!empty($_POST['MfgDate']))? date("Y-m-d", strtotime($_POST['MfgDate'])) : null;
	$tdata['U_ExpDate']=(!empty($_POST['ExpiryDate']))? date("Y-m-d", strtotime($_POST['ExpiryDate'])) : null;
	$tdata['U_SIntNo']=trim(addslashes(strip_tags($_POST['SampleIntimationNo'])));
	$tdata['U_SColNo']=trim(addslashes(strip_tags($_POST['SampleCollectionNo'])));
	$tdata['U_SQty']=trim(addslashes(strip_tags($_POST['SampleQty'])));
	$tdata['U_SamType']=trim(addslashes(strip_tags($_POST['SampleType'])));
	$tdata['U_MType']=trim(addslashes(strip_tags($_POST['MaterialType'])));
	$tdata['U_PDate']=trim(addslashes(strip_tags($_POST['PostingDate'])));
	$tdata['U_ADate']=trim(addslashes(strip_tags($_POST['AnalysisDate'])));
	$tdata['U_NoCont']=trim(addslashes(strip_tags($_POST['TNCont'])));
	$tdata['U_QCTType']=trim(addslashes(strip_tags($_POST['QCTestType'])));
	$tdata['U_Branch']=trim(addslashes(strip_tags($_POST['BranchName'])));
	$tdata['U_ValUp']=trim(addslashes(strip_tags($_POST['validUpTo'])));
	$tdata['U_ArNo']=trim(addslashes(strip_tags($_POST['ARNo'])));
	$tdata['U_GENo']=trim(addslashes(strip_tags($_POST['gate_entry_no'])));
	$tdata['U_GDEntry']=trim(addslashes(strip_tags($_POST['U_GDEntry'])));
	$tdata['U_APot']=trim(addslashes(strip_tags($_POST['AssayPotency'])));
	$tdata['U_LODWater']=trim(addslashes(strip_tags($_POST['LoD_Water'])));
	$tdata['U_CompBy']=trim(addslashes(strip_tags($_POST['ApprovedBy'])));
	$tdata['U_NoCont1']=trim(addslashes(strip_tags($_POST['noOfCont1'])));
	$tdata['U_NoCont2']=trim(addslashes(strip_tags($_POST['noOfCont2'])));
	$tdata['U_ChkBy']=trim(addslashes(strip_tags($_POST['checked_by'])));
	$tdata['U_AnlBy']=trim(addslashes(strip_tags($_POST['analysis_by'])));
	$tdata['U_Remarks']=trim(addslashes(strip_tags($_POST['qc_remarks'])));
	$tdata['U_AsyCal']=trim(addslashes(strip_tags($_POST['assay_append'])));
	$tdata['U_Factor']=trim(addslashes(strip_tags($_POST['factor'])));
	$tdata['U_SpcNo']=trim(addslashes(strip_tags($_POST['SpecfNo'])));
	$tdata['U_GRQty']=trim(addslashes(strip_tags($_POST['U_GRQty'])));
	$tdata['U_PckSize']=trim(addslashes(strip_tags($_POST['PackSize'])));
	$tdata['U_Potency']=trim(addslashes(strip_tags($_POST['Potency'])));
	// $tdata['U_RelDt']=trim(addslashes(strip_tags($_POST['U_RelDt'])));
	// $tdata['U_RetstDt']=trim(addslashes(strip_tags($_POST['U_RetstDt'])));
	$tdata['U_Loc']=trim(addslashes(strip_tags($_POST['Location'])));
	$tdata['U_RMQC']=trim(addslashes(strip_tags($_POST['U_RMQC'])));
	$tdata['U_PC_MakeBy']=trim(addslashes(strip_tags($_POST['MakeBy'])));
	$tdata['U_TypMaterial']=trim(addslashes(strip_tags($_POST['TypeofMaterial'])));
	$tdata['U_RMQC']=trim(addslashes(strip_tags($_POST['RelMaterialWithoutQC'])));
	$tdata['U_RQty'] = trim(addslashes(strip_tags($_POST['RetainQty'])));
	$tdata['U_RelDt']=(!empty($_POST['ReleaseDate']))? date("Y-m-d", strtotime($_POST['ReleaseDate'])) : null;
	$tdata['U_RetstDt']=(!empty($_POST['RetestDate']))? date("Y-m-d", strtotime($_POST['RetestDate'])) : null;

	if(!empty($_POST['pCode'])){
		$ganaralData=array();
		for ($i=0; $i <count($_POST['pCode']) ; $i++) {
			$ganaralData['U_PCode']=trim(addslashes(strip_tags($_POST['pCode'][$i])));
			// $ganaralData['U_PName']=trim(addslashes(strip_tags($_POST['PName'][$i])));
			// $ganaralData['U_Standard']=trim(addslashes(strip_tags($_POST['Standard'][$i])));

			$ganaralData['U_PName']=trim($_POST['PName'][$i], '"');
			$ganaralData['U_Standard']=trim($_POST['Standard'][$i], '"');
			
			$ganaralData['U_Remarks']=trim(addslashes(strip_tags($_POST['ResultOut'][$i])));
			$ganaralData['U_LowMin1']=trim(addslashes(strip_tags($_POST['ComparisonResult'][$i])));
			$ganaralData['U_ROutput']=trim(addslashes(strip_tags($_POST['ResultOutputByQCDept'][$i])));
			$ganaralData['U_PDType']=trim(addslashes(strip_tags($_POST['PDType'][$i])));
			$ganaralData['U_Logical']=trim(addslashes(strip_tags($_POST['Logical'][$i])));
			$ganaralData['U_LowMin']=trim(addslashes(strip_tags($_POST['LowMin'][$i])));
			$ganaralData['U_UppMax']=trim(addslashes(strip_tags($_POST['UppMax'][$i])));
			$ganaralData['U_Min']=trim(addslashes(strip_tags($_POST['Min'][$i])));
			$ganaralData['U_QCStatus']=trim(addslashes(strip_tags($_POST['QC_StatusByAnalyst'][$i])));
			$ganaralData['U_TMethod']=trim(addslashes(strip_tags($_POST['TMethod'][$i])));
			$ganaralData['U_MType']=trim(addslashes(strip_tags($_POST['MType'][$i])));
			$ganaralData['U_PC_PhStd']=trim(addslashes(strip_tags($_POST['PharmacopeiasStandard'][$i])));
			$ganaralData['U_UOM']=trim(addslashes(strip_tags($_POST['UOM'][$i])));
			$ganaralData['U_Retest']=trim(addslashes(strip_tags($_POST['Retest'][$i])));
			$ganaralData['U_ExtrS']=trim(addslashes(strip_tags($_POST['ExSample'][$i])));
			$ganaralData['U_AnyBy']=trim(addslashes(strip_tags($_POST['AnalysisBy'][$i])));
			$ganaralData['U_ARemark']=trim(addslashes(strip_tags($_POST['analyst_remark'][$i])));
			$ganaralData['U_LowMax']=trim(addslashes(strip_tags($_POST['LowMax'][$i])));
			$ganaralData['U_Release']=trim(addslashes(strip_tags($_POST['Release'][$i])));
			$ganaralData['U_DDetail']=trim(addslashes(strip_tags($_POST['DescriptiveDetails'][$i])));
			$ganaralData['U_UppMin']=trim(addslashes(strip_tags($_POST['UppMin'][$i])));
			$ganaralData['U_LowMax1']=trim(addslashes(strip_tags($_POST['LowMinRes'][$i])));
			$ganaralData['U_UppMin1']=trim(addslashes(strip_tags($_POST['UppMinRes'][$i])));
			$ganaralData['U_UppMax1']=trim(addslashes(strip_tags($_POST['UppMaxRes'][$i])));
			$ganaralData['U_Min1']=trim(addslashes(strip_tags($_POST['MeanRes'][$i])));
			$ganaralData['U_UText1']=trim(addslashes(strip_tags($_POST['UserText1'][$i])));
			$ganaralData['U_UText2']=trim(addslashes(strip_tags($_POST['UserText2'][$i])));
			$ganaralData['U_UText3']=trim(addslashes(strip_tags($_POST['UserText3'][$i])));
			$ganaralData['U_UText4']=trim(addslashes(strip_tags($_POST['UserText4'][$i])));
			$ganaralData['U_UText5']=trim(addslashes(strip_tags($_POST['UserText5'][$i])));
			$ganaralData['U_QCRemark']=trim(addslashes(strip_tags($_POST['QC_StatusResult'][$i])));
			$ganaralData['U_Stab']=trim(addslashes(strip_tags($_POST['Stability'][$i])));
			$ganaralData['U_AppAssay']=trim(addslashes(strip_tags($_POST['Appassay'][$i])));
			$ganaralData['U_AppLOD']=trim(addslashes(strip_tags($_POST['AppLOD'][$i])));
			$ganaralData['U_InsCode']=trim(addslashes(strip_tags($_POST['InstrumentCode'][$i])));
			$ganaralData['U_InsName']=trim(addslashes(strip_tags($_POST['InstrumentName'][$i])));
			$ganaralData['U_SDate']=trim(addslashes(strip_tags($_POST['StartDate'][$i])));
			$ganaralData['U_STime']=trim(addslashes(strip_tags($_POST['StartTime'][$i])));
			$ganaralData['U_EDate']=trim(addslashes(strip_tags($_POST['EndDate'][$i])));
			$ganaralData['U_ETime']=trim(addslashes(strip_tags($_POST['EndTime'][$i])));

			$tdata['SCS_QCPD1Collection'][]=$ganaralData;
		}
	}

	if(!empty($_POST['qc_Status'])){
		$qcStatus=array();
		for ($j=0; $j <count($_POST['qc_Status']) ; $j++) { 
			if(!empty($_POST['qc_Status'][$j])){
				$qcStatus['U_Status']=trim(addslashes(strip_tags($_POST['qc_Status'][$j])));
				$qcStatus['U_Quantity']=trim(addslashes(strip_tags($_POST['qCStsQty'][$j])));
				// $qcStatus['U_ITNo']=trim(addslashes(strip_tags($_POST['qCitNo'][$j])));
				$qcStatus['U_DBy']=trim(addslashes(strip_tags($_POST['doneBy'][$j])));
				$qcStatus['U_Remarks1']=trim(addslashes(strip_tags($_POST['qCStsRemark1'][$j])));

				$qcStatus['U_RelDt']=(!empty($_POST['qCReleaseDate'][$j]))? date("Y-m-d",strtotime($_POST['qCReleaseDate'][$j])) : null;

				$qcStatus['U_RelTime']=(!empty($_POST['qCReleaseTime'][$j]))? date("Hi",strtotime($_POST['qCReleaseTime'][$j])) : null;

				$qcStatus['U_Attch1']=(!empty($_FILES['qCAttache1']['name'][$j]))? $_FILES['qCAttache1']['name'][$j]:null;
				$qcStatus['U_Attch2']=(!empty($_FILES['qCAttache2']['name'][$j]))? $_FILES['qCAttache2']['name'][$j]:null;
				$qcStatus['U_Attch3']=(!empty($_FILES['qCAttache3']['name'][$j]))? $_FILES['qCAttache3']['name'][$j]:null;

				$qcStatus['U_DevDt']=(!empty($_POST['qCDeviationDate'][$j]))? date("Y-m-d",strtotime($_POST['qCDeviationDate'][$j])) : null;

				$qcStatus['U_DevNo']=trim(addslashes(strip_tags($_POST['qCDeviationNo'][$j])));
				$qcStatus['U_DevRsn']=trim(addslashes(strip_tags($_POST['qCDeviationResion'][$j])));

				// <!-- ------ File upload code start here ----------------------------- -->
					$uploadDir = '../include/uploads/';

					$uploadFile = $uploadDir . basename($_FILES['qCAttache1']['name'][$j]);
					move_uploaded_file($_FILES['qCAttache1']['tmp_name'][$j], $uploadFile);


					$uploadFile2 = $uploadDir . basename($_FILES['qCAttache2']['name'][$j]);
					move_uploaded_file($_FILES['qCAttache2']['tmp_name'][$j], $uploadFile2);


					$uploadFile3 = $uploadDir . basename($_FILES['qCAttache3']['name'][$j]);
					move_uploaded_file($_FILES['qCAttache3']['tmp_name'][$j], $uploadFile3);
				// <!-- ------ File upload code start here ----------------------------- -->

				$tdata['SCS_QCPD2Collection'][]=$qcStatus;
			}
		}
	}

	if(!empty($_POST['targetPath'])){
		$qcAttech=array();
		for ($k=0; $k <count($_POST['targetPath']) ; $k++) {
			if(!empty($_POST['fileName'][$k])){
				$qcAttech['U_TrgtPath']=trim(addslashes(strip_tags($_POST['targetPath'][$k])));
				$qcAttech['U_FileName']=trim(addslashes(strip_tags($_POST['fileName'][$k])));
				$qcAttech['U_AtchDate']=trim(addslashes(strip_tags($_POST['attachDate'][$k])));
				$qcAttech['U_FreeText']=trim(addslashes(strip_tags($_POST['freeText'][$k])));

				$tdata['SCS_QCPD3Collection'][]=$qcAttech;
			}
		}
	}

	$mainArray=$tdata;

	// echo '<pre>';
	// print_r(json_encode($mainArray));
	// die();


	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$api_SCS_QCPD;
			$responce_encode=$objKri->qcPostDocument($mainArray,$Final_API);
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();

				if(!empty($responce->DocNum)){
					if(!empty($responce->U_SName)){
						// Purchase Delivery Notes
						$SIntiMainArray = [
							'DocEntry' => $_POST['GRPODocEntry'],
							'DocumentLines' => [
								[
									'LineNum' => $responce->U_BLine,
									'U_PC_QCPD' => $responce->DocEntry
								]
							]
						];

						$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_PurchaseDeliveryNotes.'('.$responce->U_GRPODEnt.')';

						// <!-- -------- Service Layer Function start here --------- -->
							$res11=$obj->SAP_Login();  // SAP Service Layer Login Here
							if(!empty($res)){
								$responce_encode1=$obj->PATCH_ServiceLayerMasterFunction($SIntiMainArray,$Final_API);
								$responce1=json_decode($responce_encode1);
							}
							$res12=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
						// <!-- -------- Service Layer Function end here ----------- -->

						if(empty($responce1)){
							$data['status']='True';
							$data['DocEntry']=$responce->DocEntry;
							$data['message']="QC Post Document Added Successfully";
							echo json_encode($data);
						}else{
							if(array_key_exists('error', (array)$responce1)){
								$data['status']='False';
								$data['DocEntry']='';
								$data['message']=$responce1->error->message->value;
								echo json_encode($data);
							}
						}
					}else{
						// Inventory Gen Entries
						$InventoryGenEntries=array();
						$InventoryGenEntries['SIDocEntry']=trim($responce->DocEntry);
						$InventoryGenEntries['GRDocEntry']=trim($_POST['GRPODocEntry']);
						$InventoryGenEntries['ItemCode']=trim($responce->U_ICode);
						$InventoryGenEntries['LineNum']=trim($responce->U_BLine);

						$Final_API=$GRQCPOSTINWARD_APi;
						$responce_encode1=$obj->POST_QuerryBasedMasterFunction($InventoryGenEntries,$Final_API);
						$responce1=json_decode($responce_encode1);

						if(empty($responce1)){
							$data['status']='True';
							$data['DocEntry']=$responce->DocEntry;
							$data['message']="QC Post Document Added Successfully.";
							echo json_encode($data);
						}else{

							// if(array_key_exists('error', (array)$responce1)){
								$data['status']='False';
								$data['DocEntry']='';
								$data['message']=$responce1;
								echo json_encode($data);
							// }
						}
					}
				}else{
					if(array_key_exists('error', (array)$responce)){
						$data['status']='False';
						$data['DocEntry']='';
						$data['message']=$responce->error->message->value;
						$data['mainOP']=$responce;
						echo json_encode($data);
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}








if(isset($_POST['action']) && $_POST['action'] =='SCReverseSampleIsuue_ajax')
{
	// <!--------------- Get Reverse Sample issue data start here ------------------------------------------ -->
		$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));

		$API=$SAMPLECOLLGOODSISSUE_API.$DocEntry;
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
		$response=$obj->get_OTFSI_SingleData($FinalAPI); // get Function called here
	// <!--------------- Get Reverse Sample issue data End here -------------------------------------------- -->

	// <!--------------- Get Series Data using Object code start here -------------------------------------- -->
		$Series_API=$INWARDQCSERIES_API.'59'; // Object Code Hardcore write
		$Series_response=$obj->get_OTFSI_SingleData($Series_API); // get Function called here
	// <!--------------- Get Series Data using Object code end here ---------------------------------------- -->
	
	//  <!-- ---------- Preparing row data start here ------------------------------------------------------ -->
			$mainArray=array(); // This array hold all type of declare array
			$tdata=array(); //This array hold header data
			$item=array(); //This array hold item data
			$batch=array(); //This array hold batch data

			// <!-- --------- Header level data perparing start here ---------------- -->
				$tdata['DocType']='dDocument_Items';
				$tdata['DocDate']=date("Y-m-d", strtotime($response[0]->DocDate));
				$tdata['DocDueDate']=date("Y-m-d", strtotime($response[0]->TaxDate));
				$tdata['Series']=trim(addslashes(strip_tags($Series_response[0]->Series)));
				$tdata['TaxDate']=date("Y-m-d");
				$tdata['DocObjectCode']=trim(addslashes(strip_tags('oInventoryGenEntries')));
				$tdata['U_PC_SColl']=trim(addslashes(strip_tags($response[0]->DocNum)));
				$tdata['U_BFType']='SCS_SCOL';
				$tdata['BPL_IDAssignedToInvoice']=trim(addslashes(strip_tags($response[0]->BPLId)));

				$mainArray=$tdata; // header level data append in this array
			// <!-- --------- Header level data perparing end here ------------------ -->

			// <!-- --------- Item Batch row data prepare start here ----------------- -->
				$item['ItemCode']=trim(addslashes(strip_tags($response[0]->ItemCode)));
				$item['Quantity']=trim(addslashes(strip_tags($response[0]->Quantity)));
				$item['BaseType']='60';
				$item['BaseEntry']=trim(addslashes(strip_tags($response[0]->DocEntry)));
				$item['BaseLine']=trim(addslashes(strip_tags($response[0]->LineNum)));

				$BatchNumbersArrayData=$response[0]->SAMPLECOLLBATCH;

				for ($i=0; $i <count($BatchNumbersArrayData) ; $i++) { 

					$batch['BatchNumber']=trim(addslashes(strip_tags($BatchNumbersArrayData[$i]->BatchNo)));
					$batch['Quantity'] = (int)trim(addslashes(strip_tags($BatchNumbersArrayData[$i]->BatchQty))); // 252
					$batch['ItemCode']=trim(addslashes(strip_tags($response[0]->ItemCode)));

					$item['BatchNumbers'][]=$batch; // Batch data append in this array
				}
			// <!-- --------- Item Batch row data prepare end here ------------------- -->

			$mainArray['DocumentLines'][]=$item; // Item data append in this array
	//  <!-- ---------- Preparing row data end here -------------------------------------------------------- -->

	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_InventoryGenEntries;

			$responce_encode=$obj->SaveSampleIntimation($mainArray,$Final_API);
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();
				if(array_key_exists('error', (array)$responce)){
					$data['status']='False';
					$data['DocEntry']='';
					$data['message']=$responce->error->message->value;
					echo json_encode($data);
				}else{

					// <!-- ------- row data preparing start here --------------------- -->
						$UT_data=array();
						$UT_data['DocEntry']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
						$UT_data['U_RSIssue']=trim(addslashes(strip_tags($responce->DocEntry)));
					// <!-- ------- row data preparing end here ----------------------- -->

					$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SCS_SCOL.'('.$UT_data['DocEntry'].')';
					$underTestNumber=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data,$Final_API2);
					$underTestNumber_decode=json_decode($underTestNumber);

					if($underTestNumber_decode==''){
						$data['status']='True';
						$data['DocEntry']=$responce->DocEntry;
						$data['message']="Reverse Sample Issue Added Successfully.";
						echo json_encode($data);
					}else{
						if(array_key_exists('error', (array)$underTestNumber_decode)){
							$data['status']='False';
							$data['DocEntry']='';
							$data['message']=$responce->error->message->value;
							echo json_encode($data);
						}
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='GetUserCodeUsingEmpId_Ajax')
{	
	$Final_API=$USERID_APi.$_SESSION['Baroque_EmployeeCode'];

	$response_encoded=$obj->GET_QuerryBasedMasterFunction($Final_API);
	echo $response_encoded;
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='SupplierDropdown_ajax')
{
	// <!-- =============== get supplier dropdown start here ========================================== -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$BP_Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_BusinessPartners.'?$select=CardCode,CardName';

			$responce_encode_BP=$obj->getFunctionServiceLayer($BP_Final_API);
			$responce_BP=json_decode($responce_encode_BP);

			$option .= '<option value="">-</option>';
			for ($i=0; $i <count($responce_BP->value) ; $i++) {
				$Name=$responce_BP->value[$i]->CardCode.' ('.$responce_BP->value[$i]->CardName.')';
				$option .= '<option value="'.$responce_BP->value[$i]->CardCode.'">'.$Name.'</option>';
			}
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	// <!-- =============== get supplier dropdown end here ============================================ -->

	echo json_encode($option);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='getstageDropdown_ajax')
{

	// <!-- =============== get supplier dropdown start here ========================================== -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$BP_Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$RouteStages_API;

			
			$responce_encode_BP=$obj->getFunctionServiceLayer($BP_Final_API);
			$responce_BP=json_decode($responce_encode_BP);


			

			//$option .= '<option value="">-</option>';
			for ($i=0; $i <count($responce_BP->value) ; $i++) {
				// $Name=$responce_BP->value[$i]->CardCode.' ('.$responce_BP->value[$i]->CardName.')';
				$option .= '<option value="'.$responce_BP->value[$i]->Code.'">'.$responce_BP->value[$i]->Description.'</option>';
			}
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	// <!-- =============== get supplier dropdown end here ============================================ -->

	echo json_encode($option);
	exit(0);
}




if(isset($_POST['action']) && $_POST['action'] =='SupplierSingleData_ajax')
{
	$CardCode=trim(addslashes(strip_tags($_POST['CardCode'])));
	$Loc=trim(addslashes(strip_tags($_POST['Loc'])));
	$Branch=trim(addslashes(strip_tags($_POST['Branch'])));
	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$MakeBy=trim(addslashes(strip_tags($_POST['MakeBy'])));

	$API=$SAMPLECOLLEXTENALINWARD_APi.'?CardCode='.$CardCode.'&Loc='.$Loc.'&Branch='.$Branch.'&ItemCode='.$ItemCode.'&MakeBy='.$MakeBy;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20

	// print_r($FinalAPI);
	// die();
	$responce_encode=$obj->GetMethodQuerryBasedAPI($FinalAPI);
	$responce=json_decode($responce_encode);

	// print_r($responce);
	// die();
	$tdata=array();
	$tdata['CardName']=trim(addslashes(strip_tags($responce[0]->CardName)));
	$tdata['Whse']=trim(addslashes(strip_tags($responce[0]->Whse)));
	$tdata['Uom']=trim(addslashes(strip_tags($responce[0]->UOM)));
	$tdata['SampleDate']=date("Y-m-d");

	echo json_encode($tdata);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='GetCardNameAndWhs_Ajax'){
	$CardCode=trim(addslashes(strip_tags($_POST['CardCode'])));
	$Loc=trim(addslashes(strip_tags($_POST['Loc'])));
	$Branch=trim(addslashes(strip_tags($_POST['Branch'])));
	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$MakeBy=trim(addslashes(strip_tags($_POST['MakeBy'])));

	$API=$SAMPLECOLLEXTENALINWARD_APi.'?CardCode='.$CardCode.'&Loc='.$Loc.'&Branch='.$Branch.'&ItemCode='.$ItemCode.'&MakeBy='.$MakeBy;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20


	// print_r($FinalAPI);

	// die();

	$responce_encode=$obj->GetMethodQuerryBasedAPI($FinalAPI);
	$responce=json_decode($responce_encode);

	// print_r($responce);

	// die();

	$tdata=array();
	$tdata['CardName']=trim(addslashes(strip_tags($responce[0]->CardName)));
	$tdata['UOM']=trim(addslashes(strip_tags($responce[0]->UOM)));
	$tdata['Whse']=trim(addslashes(strip_tags($responce[0]->Whse)));
	$tdata['SampleDate']=date("Y-m-d");

	echo json_encode($tdata);
	exit(0);
}


if(isset($_POST['action']) && $_POST['action'] =='GetExtraIuuseWhs_Ajax'){
	$Loc=trim(addslashes(strip_tags($_POST['Loc'])));
	$Branch=trim(addslashes(strip_tags($_POST['Branch'])));
	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$MakeBy=trim(addslashes(strip_tags($_POST['MakeBy'])));

	$API=$SAMPLECOLLEXTRAINWARD_APi.'?Loc='.$Loc.'&Branch='.$Branch.'&ItemCode='.$ItemCode.'&MakeBy='.$MakeBy;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20


	// print_r($FinalAPI);

	// die();

	$responce_encode=$obj->GetMethodQuerryBasedAPI($FinalAPI);
	$responce=json_decode($responce_encode);

	$tdata=array();
	$tdata['UOM']=trim(addslashes(strip_tags($_POST['UOM'])));
	$tdata['Whse']=trim(addslashes(strip_tags($responce[0]->Whse)));
	$tdata['SampleBy']=$_SESSION['Baroque_FirstName'].' '.$_SESSION['Baroque_LastName'];
	$tdata['IssueDate']=date("d-m-Y");

	echo json_encode($tdata);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='WareHouseDropdown_ajax')
{
	// <!-- ------------------ get supplier dropdown start here ---------------------------------------- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_Warehouses;

			$responce_encode=$obj->getFunctionServiceLayer($Final_API);
			$responce=json_decode($responce_encode);

			$option .= '<option value="">-</option>';
			for ($i=0; $i <count($responce->value) ; $i++) {
				
				$option .= '<option value="'.$responce->value[$i]->WarehouseCode.'">'.$responce->value[$i]->WarehouseCode.'</option>';
			}
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	// <!-- ------------------ get supplier dropdown end here ------------------------------------------ -->

	echo json_encode($option);
	exit(0);
}


if(isset($_POST['SampleCollectionRetestQCUpdateForm_Btn']))
{
	// <!-- ------------ array declare Here ------------- -->
		$mainArray=array();
		$ExternalIssue=array();
		$ExtraIssue=array();
	// <!-- ------------ array declare Here ------------- -->

		$tdata['Series']=trim(addslashes(strip_tags($_POST['SCRTQCB_Series'])));
		$tdata['U_PC_BLin']=trim(addslashes(strip_tags($_POST['SCRTQCB_GRNLineNo'])));
		$tdata['U_PC_InTyp']=trim(addslashes(strip_tags($_POST['SCRTQCB_IngrediantType'])));
		$tdata['U_PC_GRNNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_GRNNo'])));
		$tdata['U_PC_GRNEnt']=trim(addslashes(strip_tags($_POST['SCRTQCB_GRNDocEntry'])));
		$tdata['U_PC_Loc']=trim(addslashes(strip_tags($_POST['SCRTQCB_Location'])));
		$tdata['U_PC_InBy']=trim(addslashes(strip_tags($_POST['SCRTQCB_IntimatedBy'])));
		$tdata['U_PC_SQty']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleQty'])));
		$tdata['U_PC_SCBy']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleCollBy'])));
		$tdata['U_PC_ARNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_ARNo'])));
		$tdata['U_PC_TrNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_TRNo'])));
		$tdata['U_PC_Branch']=trim(addslashes(strip_tags($_POST['SCRTQCB_Branch'])));
		$tdata['U_PC_ICode']=trim(addslashes(strip_tags($_POST['SCRTQCB_ItemCode'])));
		$tdata['U_PC_IName']=trim(addslashes(strip_tags($_POST['SCRTQCB_ItemName'])));
		$tdata['U_PC_BNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_BatchNo'])));
		$tdata['U_PC_BtchQty']=trim(addslashes(strip_tags($_POST['SCRTQCB_BatchQty'])));
		$tdata['U_PC_NoCont']=trim(addslashes(strip_tags($_POST['SCRTQCB_NoOfContainer'])));
		$tdata['U_PC_UTNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_UTTNo'])));
		$tdata['U_PC_SIssue']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_SampleIssue'])));
		$tdata['U_PC_RSIssue']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_RevSampleIssue'])));
		$tdata['U_PC_RIssue']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_RetainIssue'])));
		$tdata['U_PC_RQty']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_RetQty'])));
		$tdata['U_PC_RQtUom']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_RetUoM'])));
		$tdata['U_PC_CntNo1']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_Cont1'])));
		$tdata['U_PC_CntNo2']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_Cont2'])));
		$tdata['U_PC_CntNo3']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_Cont3'])));
		$tdata['U_PC_QtyLab']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_QtyForLabel'])));
		$tdata['U_PC_BPLId']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId'])));
		$tdata['U_PC_LocCode']=trim(addslashes(strip_tags($_POST['SCRTQCB_LocCode'])));
		$tdata['U_PC_SRSep']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleReSep'])));

		if(!empty($_POST['SCRTQCB_IntimationDate'])){
			$tdata['U_PC_InDt']=date("Y-m-d", strtotime($_POST['SCRTQCB_IntimationDate']));	
		}else{
			$tdata['U_PC_InDt']=null;
		}

		if(!empty($_POST['SCRTQCB_DocDate'])){
			$tdata['U_PC_DDt']=date("Y-m-d", strtotime($_POST['SCRTQCB_DocDate']));
		}else{
			$tdata['U_PC_DDt']=null;
		}

		if(!empty($_POST['SCRTQCB_SCD_DateOfRever'])){
			$tdata['U_PC_DRev']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_DateOfRever'])));
		}else{
			$tdata['U_PC_DRev']=null;
		}

		$tdata['U_PC_SUnit']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleQtyUnit'])));
		$tdata['U_PC_Trans']=null;
		$tdata['U_PC_SType']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleType'])));

		$mainArray=$tdata; // header data append on main array
// echo "<pre>";
// print_r($mainArray);
// die();
	// <!-- ------------------------ External Issue row data preparing start here ----------------------- --> 



		for ($i=0; $i <count($_POST['SC_FEXI_SupplierName']) ; $i++) { 

			$ExternalIssue['LineId']=trim(addslashes(strip_tags(($i+1))));
			$ExternalIssue['U_PC_SCode']=trim(addslashes(strip_tags($_POST['SC_ExternalI_SupplierCode'][$i]))); 
			$ExternalIssue['U_PC_SName']=trim(addslashes(strip_tags($_POST['SC_FEXI_SupplierName'][$i])));
			$ExternalIssue['U_PC_UOM']=trim(addslashes(strip_tags($_POST['SC_FEXI_UOM'][$i])));
			$ExternalIssue['U_PC_Whs']=trim(addslashes(strip_tags($_POST['SC_ExternalI_Warehouse'][$i])));
			$ExternalIssue['U_PC_SQty1']=trim(addslashes(strip_tags($_POST['SC_FEXI_SampleQuantity'][$i])));
			$ExternalIssue['U_PC_Attch']=trim(addslashes(strip_tags($_POST['SC_FEXI_Attachment'][$i])));
			$ExternalIssue['U_PC_UTxt1']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText1'][$i])));
			$ExternalIssue['U_PC_UTxt2']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText2'][$i])));
			$ExternalIssue['U_PC_UTxt3']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText3'][$i])));

			if(!empty($_POST['SC_FEXI_SampleDate'][$i])){
				$ExternalIssue['U_PC_SD']=date("Y-m-d", strtotime($_POST['SC_FEXI_SampleDate'][$i]));
			}else{
				$ExternalIssue['U_PC_SD']=null;	
			}

			$mainArray['SCS_SCRETEST1Collection'][]=$ExternalIssue;
		}
		




	// <!-- ------------------------ External Issue row data preparing start here ----------------------- --> 

	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 
		for ($j=0; $j <count($_POST['SC_FEI_SampleQuantity']) ; $j++) { 

			$ExtraIssue['LineId']=trim(addslashes(strip_tags(($j+1))));
			$ExtraIssue['U_PC_SQty2']=trim(addslashes(strip_tags($_POST['SC_FEI_SampleQuantity'][$j])));
			$ExtraIssue['U_PC_UOM']=trim(addslashes(strip_tags($_POST['SC_FEI_UOM'][$j])));
			$ExtraIssue['U_PC_Whs']=trim(addslashes(strip_tags($_POST['SC_ExternalI_SupplierCode'][$j])));
			$ExtraIssue['U_PC_SBy']=trim(addslashes(strip_tags($_POST['SC_FEI_SampleBy'][$j])));

			if(!empty($_POST['SC_FEI_IssueDate'][$j])){
				$ExtraIssue['U_PC_IDate']=date("Y-m-d", strtotime($_POST['SC_FEI_IssueDate'][$j]));
			}else{
				$ExtraIssue['U_PC_IDate']=null;	
			}

			if(!empty($_POST['SC_FEI_PostExtraIssue'][$j])){
				$ExtraIssue['U_PC_PEIsu']=trim(addslashes(strip_tags($_POST['SC_FEI_PostExtraIssue'][$j])));
			}else{
				$ExtraIssue['U_PC_PEIsu']=null;
			}

			$mainArray['SCS_SCRETEST2Collection'][]=$ExtraIssue;
		}
	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 

	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){

			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SCRETEST_API.'('.$_POST['SCRTQCB_DocEntry'].')';

			$responce_encode=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($mainArray,$Final_API);
			$responce=json_decode($responce_encode);

			if($responce==''){
				$data['status']='True';
				$data['DocEntry']=$responce->DocEntry;
				$data['message']="Sample Collection - Retest QC Successfully Update.";
				echo json_encode($data);
			}else{

				if(array_key_exists('error', (array)$responce)){
					$data['status']='False';
					$data['DocEntry']='';
					$data['message']=$responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	//<!-- ------------- function & function responce code end Here ---- -->
	exit(0);
}




if(isset($_POST['SampleCollectionUpdateForm_Btn']))
{
	// <!-- ------------ array declare Here ------------- -->
		$mainArray=array();
		$ExternalIssue=array();
		$ExtraIssue=array();
		$tdata=array();
	// <!-- ------------ array declare Here ------------- -->

	$tdata['U_BLine']=trim(addslashes(strip_tags($_POST['SCF_GRPO_BaseLine'])));
	$tdata['U_InType']=trim(addslashes(strip_tags($_POST['SCF_IngrediantType'])));
	$tdata['U_GRPONo']=trim(addslashes(strip_tags($_POST['SCF_GRNNo'])));
	$tdata['U_GRPODEnt']=trim(addslashes(strip_tags($_POST['SCF_GRPO_DocEntry'])));
	$tdata['U_Loc']=trim(addslashes(strip_tags($_POST['SCF_Location'])));
	$tdata['U_InBy']=trim(addslashes(strip_tags($_POST['SCF_IntimatedBy'])));
	$tdata['U_InDate']=date("Y-m-d", strtotime($_POST['SCF_IntimatedDate']));
	$tdata['U_SQty']=trim(addslashes(strip_tags($_POST['SCF_SampleQty'])));
	$tdata['U_SUnit']=trim(addslashes(strip_tags($_POST['SC_SCD_RQtyUOM'])));
	$tdata['U_SColBy']=trim(addslashes(strip_tags($_POST['SCF_SampleCollectBy'])));
	$tdata['U_ARNo']=trim(addslashes(strip_tags($_POST['SCF_ARNo'])));
	$tdata['U_DDate']=date("Y-m-d", strtotime($_POST['SCF_DocDate']));
	$tdata['U_TrNo']=trim(addslashes(strip_tags($_POST['SCF_TRNo'])));
	$tdata['U_Branch']=trim(addslashes(strip_tags($_POST['SCF_Branch'])));
	$tdata['U_ICode']=trim(addslashes(strip_tags($_POST['SCF_ItemCode'])));
	$tdata['U_IName']=trim(addslashes(strip_tags($_POST['SCF_ItemName'])));
	$tdata['U_BNo']=trim(addslashes(strip_tags($_POST['SCF_BatchNo'])));
	$tdata['U_NoCont']=trim(addslashes(strip_tags($_POST['SCF_NoOfContainer'])));

	if(!empty($_POST['SC_SCD_DateOfReversal'])){
		$tdata['U_DRev']=date("Y-m-d", strtotime($_POST['SC_SCD_DateOfReversal']));	
	}else{
		$tdata['U_DRev']=null;
	}

	$tdata['U_ContNo1']=trim(addslashes(strip_tags($_POST['SC_SCD_ContainerNo1'])));
	$tdata['U_ContNo2']=trim(addslashes(strip_tags($_POST['SC_SCD_ContainerNo2'])));
	$tdata['U_ContNo3']=trim(addslashes(strip_tags($_POST['SC_SCD_ContainerNo3'])));
	$tdata['U_QtyLab']=trim(addslashes(strip_tags($_POST['SC_SCD_QtyForLabel'])));
	$tdata['U_UTNo']=trim(addslashes(strip_tags($_POST['SC_SCD_UTTransNo'])));
	$tdata['U_BPLId']=trim(addslashes(strip_tags($_POST['SCF_BPLId'])));
	$tdata['U_LocCode']=trim(addslashes(strip_tags($_POST['SCF_GRPO_LocCode'])));
	$tdata['U_SRSep']=trim(addslashes(strip_tags($_POST['SCF_SampleReSep'])));
	$tdata['U_BtchQty']=trim(addslashes(strip_tags($_POST['SCF_GRPO_BatchQty'])));

	$mainArray=$tdata;

	// <!-- External & Extra Issue validation start here ----------------- -->
		// if(count($_POST['SC_FEXI_UOM'])<= 2){
		// 	$data['status']='False';
		// 	$data['DocEntry']='';
		// 	$data['message']='You are not allowed to add more than one external issue.';
		// 	echo json_encode($data);
		// 	exit(0);
		// }

		// if(count($_POST['SC_FEI_SampleQuantity'])<= 2){
		// 	$data['status']='False';
		// 	$data['DocEntry']='';
		// 	$data['message']='You are not allowed to add more than one extra issue.';
		// 	echo json_encode($data);
		// 	exit(0);
		// }
	// <!-- External & Extra Issue validation end here ----------------- -->




	// <!-- ------------------------ External Issue row data preparing start here ----------------------- --> 
		for ($i=0; $i <(count($_POST['SC_FEXI_UOM'])) ; $i++) { 
			if(!empty($_POST['SC_ExternalI_Warehouse'][$i])){
				$ExternalIssue['LineId']=trim(addslashes(strip_tags(($i+1))));

				$ExternalIssue['U_SCode']=trim(addslashes(strip_tags($_POST['SC_ExternalI_SupplierCode'][$i]))); 
				
				$ExternalIssue['U_SName']=trim(addslashes(strip_tags($_POST['SC_FEXI_SupplierName'][$i])));
				$ExternalIssue['U_UOM']=trim(addslashes(strip_tags($_POST['SC_FEXI_UOM'][$i])));

				if(!empty($_POST['SC_FEXI_SampleDate'][$i])){
					$ExternalIssue['U_SDate']=date("Y-m-d", strtotime($_POST['SC_FEXI_SampleDate'][$i]));
				}else{
					$ExternalIssue['U_SDate']=null;	
				}
				
				$ExternalIssue['U_Whs']=trim(addslashes(strip_tags($_POST['SC_ExternalI_Warehouse'][$i])));
				$ExternalIssue['U_SQty1']=trim(addslashes(strip_tags($_POST['SC_FEXI_SampleQuantity'][$i])));
				
				$ExternalIssue['U_UText1']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText1'][$i])));
				$ExternalIssue['U_UText2']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText2'][$i])));
				$ExternalIssue['U_UText3']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText3'][$i])));
				//there is missing some colume like textBox1,textBox2 and textBox3

				if(empty($_POST['SC_FEXI_SampleQuantity'][$i])){
					$data['status']='False';
					$data['DocEntry']='';
					$data['message']='Pls. Enter External Issue Sample Qty.';
					echo json_encode($data);
					exit(0);
				}

				$mainArray['SCS_SCOL1Collection'][]=$ExternalIssue;
			}else{
				$ExternalIssue['LineId']='1';
				$mainArray['SCS_SCOL1Collection'][]=$ExternalIssue;
			}			
		}
	// <!-- ------------------------ External Issue row data preparing start here ----------------------- -->

	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 
		for ($j=0; $j <count($_POST['SC_FEI_SampleQuantity']) ; $j++) { 
			if(!empty($_POST['SC_FEI_SampleQuantity'][$j])){
				$ExtraIssue['LineId']=trim(addslashes(strip_tags(($j+1))));
				$ExtraIssue['U_SQty2']=trim(addslashes(strip_tags($_POST['SC_FEI_SampleQuantity'][$j])));
				$ExtraIssue['U_UOM']=trim(addslashes(strip_tags($_POST['SC_FEI_UOM'][$j])));
				$ExtraIssue['U_Whs']=trim(addslashes(strip_tags($_POST['SC_FEI_Warehouse'][$j])));
				$ExtraIssue['U_SBy']=trim(addslashes(strip_tags($_POST['SC_FEI_SampleBy'][$j])));

				if(!empty($_POST['SC_FEI_IssueDate'][$j])){
					$ExtraIssue['U_IDate']=date("Y-m-d", strtotime($_POST['SC_FEI_IssueDate'][$j]));
				}else{
					$ExtraIssue['U_IDate']=null;	
				}

				if(!empty($_POST['SC_FEI_PostExtraIssue'][$j])){
					$ExtraIssue['U_PEIssue']=trim(addslashes(strip_tags($_POST['SC_FEI_PostExtraIssue'][$j])));
				}else{
					$ExtraIssue['U_PEIssue']=null;
				}
				$mainArray['SCS_SCOL2Collection'][]=$ExtraIssue;
			}else{
				$ExtraIssue['LineId']='1';
				$mainArray['SCS_SCOL2Collection'][]=$ExtraIssue;
			}
			
		}
	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 
		// echo '<pre>';
		// print_r(json_encode($mainArray));
		// die();
	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){

			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SCS_SCOL.'('.$_POST['SCF_CollDocEntry'].')';

			$responce_encode=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($mainArray,$Final_API);
			$responce=json_decode($responce_encode);

			if($responce==''){
				$data['status']='True';
				$data['DocEntry']=$_POST['SCF_CollDocEntry'];
				$data['message']="Sample Collection Inventory Transfer Successfully Added.";
				echo json_encode($data);
			}else{

				if(array_key_exists('error', (array)$responce)){
					$data['status']='False';
					$data['DocEntry']='';
					$data['message']=$responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	//<!-- ------------- function & function responce code end Here ---- -->
	exit(0);
}




if(isset($_POST['action']) && $_POST['action'] =='loginform_ajax')
{	
	$data=array(); // error responce manage in this array
	$tdata=array();
	$tdata['username']=trim(addslashes(strip_tags($_POST['username'])));
	$tdata['userpassword']=trim(addslashes(strip_tags($_POST['userpassword'])));

	if(empty($tdata['username'])){
		$data['status']='False';
		$data['DocEntry']='';
		$data['message']='A required parametre (Username) was missing.';
		echo json_encode($data);
		exit(0);
	}

	if(empty($tdata['userpassword'])){
		$data['status']='False';
		$data['DocEntry']='';
		$data['message']='A required parametre (Password) was missing.';
		echo json_encode($data);
		exit(0);
	}

	
	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here
// echo '<pre>';
// print_r($res);
// die();
		if(!empty($res)){
			$API=$SAP_URL.":".$SAP_Port."/b1s/v1/".$API_Login.'?$filter= eMail eq \''.$tdata['username'].'\' and Pager eq \''.$tdata['userpassword'].'\'';
			$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
			// print_r($API);
			// die();
			$responce_encode=$obj->getFunctionServiceLayer($FinalAPI);
			$responce=json_decode($responce_encode);

			if(!empty($responce->value)){
				// <!-- ---------- session set start here --------------------------- -->
					$_SESSION['Baroque_EmployeeID'] =$responce->value[0]->EmployeeID;
					$_SESSION['Baroque_LastName'] =$responce->value[0]->LastName;
					$_SESSION['Baroque_FirstName'] =$responce->value[0]->FirstName;
					$_SESSION['Baroque_MobilePhone'] =$responce->value[0]->MobilePhone;
					$_SESSION['Baroque_eMail'] =$responce->value[0]->eMail;
					$_SESSION['Baroque_EmployeeCode'] =$responce->value[0]->EmployeeCode;
				// <!-- ---------- session set end here ----------------------------- -->

				$data['status']='True';
				$data['DocEntry']='';
				$data['message']="Login Successfully.";
				echo json_encode($data);
				exit(0);
			}else{
				$data['status']='False';
				$data['DocEntry']='';
				$data['message']='Your Username or password is incorrect';
				echo json_encode($data);
				exit(0);
			}
			// echo '<pre>';
			// print_r($responce);
			// die();

			// for ($i=0; $i <count($responce->value) ; $i++) {

			// 	$Username=$responce->value[$i]->eMail;
			// 	$Password=$responce->value[$i]->Pager;

			// 	if ($Username ==$tdata['username'] && $Password==$tdata['userpassword']) {
			// 		// <!-- ---------- session set start here --------------------------- -->
			// 			$_SESSION['Baroque_EmployeeID'] =$responce->value[$i]->EmployeeID;
			// 			$_SESSION['Baroque_LastName'] =$responce->value[$i]->LastName;
			// 			$_SESSION['Baroque_FirstName'] =$responce->value[$i]->FirstName;
			// 			$_SESSION['Baroque_MobilePhone'] =$responce->value[$i]->MobilePhone;
			// 			$_SESSION['Baroque_eMail'] =$responce->value[$i]->eMail;
			// 		// <!-- ---------- session set end here ----------------------------- -->

			// 		$data['status']='True';
			// 		$data['DocEntry']='';
			// 		$data['message']="Login Successfully.";
			// 		echo json_encode($data);
			// 		exit(0);
			// 	}else {
			// 		if($i==(count($responce->value)-1)){ // this condition work is when user not match till last loop then show error msg
			// 			$data['status']='False';
			// 			$data['DocEntry']='';
			// 			$data['message']='Your Username or password is incorrect';
			// 			echo json_encode($data);
			// 			exit(0);
			// 		}
					
			// 	} 
			// }
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	//<!-- ------------- function & function responce code end Here ---- -->
}

// =================================================== ReTest QC Code Start Here ====================================

if(isset($_POST['action']) && $_POST['action'] =='Retest_sample_intimation_popup')
{
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$API=$RETESTQCSAMPLEINTIMATIONVIEW_API.'&DocEntry='.$_POST['DocEntry'].'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&LineNum='.$_POST['LineNum'];

		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	// print_r($API);
	// die();
	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['SampleIntimationRetestQCBtn'])){
	// SIRT_BatchNo
	$tdata=array();
	$data=array(); // this array handel validation responce

	$tdata['Series']=trim(addslashes(strip_tags($_POST['SIRT_DocNo'])));
	$tdata['Remark']=null;
	$tdata['Object']='SCS_SIRETEST';
	$tdata['U_PC_BLin']=trim(addslashes(strip_tags($_POST['SIRT_LineNum'])));
	$tdata['U_PC_GRNNo']=trim(addslashes(strip_tags($_POST['SIRT_GRPONo'])));
	$tdata['U_PC_GRNEnt']=trim(addslashes(strip_tags($_POST['SIRT_GRPODocEntry'])));
	$tdata['U_PC_VCode']=trim(addslashes(strip_tags($_POST['SIRT_VenderCode'])));
	$tdata['U_PC_VName']=trim(addslashes(strip_tags($_POST['SIRT_VenderName'])));
	$tdata['U_PC_BPRfNo']=trim(addslashes(strip_tags($_POST['SIRT_BpRefNo'])));
	$tdata['U_PC_SType']=trim(addslashes(strip_tags($_POST['SIRT_SampleType'])));
	$tdata['U_PC_TRBy']=trim(addslashes(strip_tags($_POST['SIRT_TrType'])));
	$tdata['U_PC_ICode']=trim(addslashes(strip_tags($_POST['SIRT_ItemCode'])));
	$tdata['U_PC_IName']=trim(addslashes(strip_tags($_POST['SIRT_ItemName'])));
	$tdata['U_PC_GRNQty']=trim(addslashes(strip_tags($_POST['SIRT_GRPO_Qty'])));
	$tdata['U_PC_SQty']=trim(addslashes(strip_tags($_POST['SIRT_SQty'])));
	$tdata['U_PC_RQty']=trim(addslashes(strip_tags($_POST['SIRT_RQty'])));
	$tdata['U_PC_MfgBy']=trim(addslashes(strip_tags($_POST['SIRT_MfgBy'])));
	$tdata['U_PC_Unit']=trim(addslashes(strip_tags($_POST['SIRT_UOM'])));
	$tdata['U_PC_TNCont']=trim(addslashes(strip_tags($_POST['SIRT_NoOfcontainer'])));
	$tdata['U_PC_FCont']=trim(addslashes(strip_tags($_POST['SIRT_FromContainer'])));
	$tdata['U_PC_TCont']=trim(addslashes(strip_tags($_POST['SIRT_ToContainer'])));
	$tdata['U_PC_Branch']=trim(addslashes(strip_tags($_POST['SIRT_BranchName'])));
	$tdata['U_PC_Loc']=trim(addslashes(strip_tags($_POST['SIRT_Location'])));
	$tdata['U_PC_CNos']=trim(addslashes(strip_tags($_POST['SIRT_ContainerNos'])));
	// $tdata['U_PC_Cont']=trim(addslashes(strip_tags($_POST['SIRT_Container'])));
	$tdata['U_PC_BNo']=trim(addslashes(strip_tags($_POST['SIRT_BatchNo'])));
	$tdata['U_PC_BQty']=trim(addslashes(strip_tags($_POST['SIRT_BatchQty'])));
	$tdata['U_PC_BPLId']=trim(addslashes(strip_tags($_POST['SIRT_BranchID'])));
	$tdata['U_PC_LCode']=trim(addslashes(strip_tags($_POST['SIRT_LocID'])));
	$tdata['U_PC_Whs']=trim(addslashes(strip_tags($_POST['SIRT_WhsCode'])));
	$tdata['U_PC_NCnt1']=trim(addslashes(strip_tags($_POST['SIRT_QtyPerContainer'])));
	$tdata['U_PC_MakeBy']=trim(addslashes(strip_tags($_POST['SIRT_MakeBy'])));
	// $tdata['U_PC_ChNo']=null;
	// $tdata['U_PC_ChDt']=null;
	// $tdata['U_PC_GENo']=null;
	// $tdata['U_PC_GEDte']=null;
	$tdata['U_PC_UTTrans']=null;

	if(!empty($_POST['SIRT_MfgDate'])){
		$tdata['U_PC_MfgDt']=date("Y-m-d", strtotime($_POST['SIRT_MfgDate']));
	}else{
		$tdata['U_PC_MfgDt']=null;
	}

	if(!empty($_POST['SIRT_ExpiryDate'])){
		$tdata['U_PC_ExpDt']=date("Y-m-d", strtotime($_POST['SIRT_ExpiryDate']));
	}else{
		$tdata['U_PC_ExpDt']=null;
	}

	if(!empty($_POST['SIRT_RetestDate'])){
		$tdata['U_PC_RDt']=date("Y-m-d", strtotime($_POST['SIRT_RetestDate']));
	}else{
		$tdata['U_PC_RDt']=null;
	}

	if(!empty($_POST['SIRT_TrDate'])){
		$tdata['U_PC_TRDte']=date("Y-m-d", strtotime($_POST['SIRT_TrDate']));
	}else{
		$tdata['U_PC_TRDte']=null;
	}
	
	// <!-- ---------------------- sample Intimation popup validation start Here ------------------ -->
		if($_POST['SIRT_TrType']==''){
			$data['status']='False';$data['DocEntry']='';
			$data['message']="TR Type Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if($_POST['SIRT_TrDate']==''){
			$data['status']='False';$data['DocEntry']='';
			$data['message']="TR Date Mandatory.";
			echo json_encode($data);
			exit(0);
		}
	// <!-- ---------------------- sample Intimation popup validation end Here -------------------- -->
// echo '<pre>';
// print_r($tdata);
// die();
	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SIRETEST_API;

			$responce_encode=$obj->SaveSampleIntimation($tdata,$Final_API); // sample intimation save here
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();

				if($responce->DocNum!=""){
					if(!empty($responce->U_PC_VName)){
						$SIntiMainArray = [
							'DocEntry' => $responce->DocEntry,
							'DocumentLines' => [
								[
									'LineNum' => $responce->U_PC_BLin,
									"ItemCode" => $responce->U_PC_ICode,
									'U_PC_SIRtest' => $responce->DocEntry
								]
							]
						];

						// Purchase Delivery Notes
						$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_PurchaseDeliveryNotes.'('.$_POST['SIRT_GRPODocEntry'].')';

						// <!-- -------- Service Layer Function start here --------- -->
							$res11=$obj->SAP_Login();  // SAP Service Layer Login Here
							if(!empty($res)){
								$responce_encode1=$obj->PATCH_ServiceLayerMasterFunction($SIntiMainArray,$Final_API);
								$responce1=json_decode($responce_encode1);
							}
							$res12=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
						// <!-- -------- Service Layer Function end here ----------- -->

						if(empty($responce1)){
							$data['status']='True';
							$data['DocEntry']=$responce->DocEntry;
							$data['message']="Open Transaction for sample intimation Retest QC Successfully Added.";
							echo json_encode($data);
						}else{
							if(array_key_exists('error', (array)$responce1)){
								$data['status']='False';
								$data['DocEntry']='';
								$data['message']=$responce1->error->message->value;
								echo json_encode($data);
							}
						}
					}else{
						$InventoryGenEntries=array();
						$InventoryGenEntries['SIDocEntry']=trim($responce->DocEntry);
						$InventoryGenEntries['GRDocEntry']=trim($_POST['SIRT_GRPODocEntry']);
						$InventoryGenEntries['ItemCode']=trim($responce->U_PC_ICode);
						$InventoryGenEntries['LineNum']=trim($responce->U_BLine);

						$Final_API=$GRSAMPLEINTIRETEST_APi;
						$responce_encode1=$obj->POST_QuerryBasedMasterFunction($InventoryGenEntries,$Final_API);
						$responce1=json_decode($responce_encode1);

						if(empty($responce1)){
							$data['status']='True';
							$data['DocEntry']=$responce->DocEntry;
							$data['message']="Open Transaction for sample intimation Retest QC Successfully Added.";
							echo json_encode($data);
						}else{
							if(array_key_exists('error', (array)$responce1)){
								$data['status']='False';
								$data['DocEntry']='';
								$data['message']=$responce1->error->message->value;
								echo json_encode($data);
							}
						}
					}
				}else{
					if(array_key_exists('error', (array)$responce)){
						$data['status']='False';
						$data['DocEntry']='';
						$data['message']=$responce->error->message->value;
						echo json_encode($data);
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}

		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='sample_intimation_Retest_QC_ajax')
{
	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API=$RETESTQCSAMPLEINTIMATIONAFTERADD_API.'?DocEntry='.$DocEntry;
	// print_r($API);
	// die();
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='OpenSampleIntimationRetestInventoryTransfer_ajax'){

	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API=$RETESTQCSAMPLEINTIMATIONAFTERADD_API.'?DocEntry='.$DocEntry;	
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// print_r($API);
	// die();
	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
		if(!empty($response)){
			$option='<tr>
					<td class="desabled">
							
						<input type="hidden" id="SIRTIT_i_GRNEntry" name="SIRTIT_i_GRNEntry" value="'.$response[0]->GRNEntry.'">
						<input type="hidden" id="SIRTIT_i_BatchNo" name="SIRTIT_i_BatchNo" value="'.$response[0]->BatchNo.'">

						1
					</td>
					
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="SIRTIT_i_ItemCode" name="SIRTIT_i_ItemCode" class="form-control" value="'.$response[0]->ItemCode.'" readonly>
					</td>

					<td class="desabled">'.$response[0]->ItemName.'</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="SIRTIT_i_BQty" name="SIRTIT_i_BQty" class="form-control" value="'.sprintf("%.4f", $response[0]->BatchQty).'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="SIRTIT_i_FromWhs" name="SIRTIT_i_FromWhs" class="form-control" value="'.$response[0]->FrmWhse.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="SIRTIT_i_ToWhs" name="SIRTIT_i_ToWhs" class="form-control" value="'.$response[0]->ToWhse.'" readonly>
					</td>
					<td class="desabled">'.$response[0]->Location.'</td>
					<td class="desabled">'.$response[0]->Unit.'</td>
				</tr>';
		}else{
			$option='<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
		}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='sample_intimation_Retest_QC_ContainerList_ajax'){

	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs=trim(addslashes(strip_tags($_POST['FromWhs'])));
	$GRPODEnt=trim(addslashes(strip_tags($_POST['GRPODEnt'])));
	$BNo=trim(addslashes(strip_tags($_POST['BNo'])));

	// <!--------------- Preparing API Start Here ------------------------------------------ -->
		$API=$RETESTQCSAMPLEINTIMATIONCONTSEL_API.'?ItemCode='.$ItemCode.'&WareHouse='.$FromWhs.'&BatchNo='.$BNo;
		// echo json_encode($API);
		// exit;
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
		if(!empty($response)){

			for ($i=0; $i <count($response) ; $i++) { 

				// ----------- Date formating condition definr start here---------------------------
				if(!empty($response[$i]->MfgDate)){
					$MfgDate=date("d-m-Y", strtotime($response[$i]->MfgDate));
				}else{
					$MfgDate='';
				}

				if(!empty($response[$i]->ExpDate)){
					$ExpiryDate=date("d-m-Y", strtotime($response[$i]->ExpDate));
				}else{
					$ExpiryDate='';
				}

				// ----------- Date formating condition definr end here-----------------------------
				$option.='<tr>
					<td style="text-align: center;">
						<input type="hidden" id="usercheckList'.$i.'" name="usercheckList[]" value="0">
						<input class="form-check-input" type="checkbox" value="'.sprintf("%.4f", $response[$i]->BatchQty).'" id="itp_CS'.$i.'" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener('.$i.')">
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ItemCode'.$i.'" name="itp_ItemCode[]" class="form-control" value="'.$response[$i]->ItemCode.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ItemName'.$i.'" name="itp_ItemName[]" class="form-control" value="'.$response[$i]->ItemName.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo'.$i.'" name="itp_ContainerNo[]" class="form-control" value="'.$response[$i]->ContainerNo.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_Batche'.$i.'" name="itp_Batch[]" class="form-control" value="'.$response[$i]->Batch.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_BatchQty'.$i.'" name="itp_BatchQty[]" class="form-control" value="'.sprintf("%.4f", $response[$i]->BatchQty).'" readonly>
					</td>
					<td>
						<input class="border_hide" type="text" id="SelectedQty'.$i.'" name="SelectedQty[]" class="form-control" value="'.sprintf("%.4f", $response[$i]->BatchQty).'" onfocusout="EnterQtyValidation('.$i.')">
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_MfgDate'.$i.'" name="itp_MfgDate[]" class="form-control" value="'.$MfgDate.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate'.$i.'" name="itp_ExpiryDate[]" class="form-control" value="'.$ExpiryDate.'" readonly>
					</td>
				</tr>';
			}

			$option.='<tr>
				<td colspan="6"></td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum" name="cs_selectedQtySum" class="form-control" value="0.000" readonly></td>
				<td colspan="2"></td>
			</tr>';
		}else{
			$option='<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
		}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}

if(isset($_POST['SIRTIT_SubBtn'])){	
	$mainArray=array(); // This array hold all type of declare array
	$tdata=array(); //This array hold header data
	$item=array(); //This array hold item data
	$batch=array(); //This array hold batch data

	$tdata['Series']=trim(addslashes(strip_tags($_POST['SIRTIT_DocNoName'])));
	$tdata['DocDate']=date("Y-m-d", strtotime($_POST['SIRTIT_PostingDate']));
	$tdata['DueDate']=date("Y-m-d", strtotime($_POST['SIRTIT_DocDate']));
	$tdata['CardCode']=trim(addslashes(strip_tags($_POST['SIRTIT_SupplierCode'])));
	$tdata['Comments']=null;
	$tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['SIRTIT_i_FromWhs'])));
	$tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['SIRTIT_i_ToWhs'])));
	$tdata['TaxDate']=date("Y-m-d", strtotime($_POST['SIRTIT_DocDate']));
	$tdata['DocObjectCode']='67';
	$tdata['BPLID']=trim(addslashes(strip_tags($_POST['SIRTIT_BPL_Id'])));
	$tdata['U_PC_SIRtest']=trim(addslashes(strip_tags($_POST['SIRTIT_DocEntry'])));
	$tdata['U_BFType']=trim(addslashes(strip_tags($_POST['SIRTIT_BaseDocType'])));

	$mainArray=$tdata; // Header data merge here....

	// --------------------- Item and batch row data preparing start here -------------------------------- -->
		$item['LineNum']=trim(addslashes(strip_tags('0')));
		$item['ItemCode']=trim(addslashes(strip_tags($_POST['SIRTIT_i_ItemCode'])));
		$item['WarehouseCode']=trim(addslashes(strip_tags($_POST['SIRTIT_i_ToWhs'])));
		$item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST['SIRTIT_i_FromWhs'])));
		$item['Quantity']=trim(addslashes(strip_tags($_POST['SIRTIT_i_BQty'])));

			// <!-- Item Batch row data prepare start here ----------- -->
				for ($i=0; $i <count($_POST['usercheckList']) ; $i++) { 
					if($_POST['usercheckList'][$i]=='1'){
						$batch['BatchNumber']=trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
						$batch['Quantity']=trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
						$batch['BaseLineNumber']=trim(addslashes(strip_tags('0')));
						$batch['ItemCode']=trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));

						$item['BatchNumbers'][]=$batch;
					}
				}
			// <!-- Item Batch row data prepare end here ------------- -->
		$mainArray['StockTransferLines'][]=$item;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->

	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_StockTransfers;
			$responce_encode=$obj->SaveSampleIntimation($mainArray,$Final_API);
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();
				if(array_key_exists('error', (array)$responce)){
					$data['status']='False';
					$data['DocEntry']='';
					$data['message']=$responce->error->message->value.'Main POST Doc';
					echo json_encode($data);
				}else{
					// <!-- ------- row data preparing start here --------------------- -->
						$UT_data=array();
						$UT_data['DocEntry']=trim(addslashes(strip_tags($_POST['SIRTIT_DocEntry'])));
						$UT_data['U_PC_UTTrans']=trim(addslashes(strip_tags($responce->DocEntry)));
					// <!-- ------- row data preparing end here ----------------------- -->

					$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SIRETEST_API.'('.$UT_data['DocEntry'].')';
					$underTestNumber=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data,$Final_API2);
					$underTestNumber_decode=json_decode($underTestNumber);

					if($underTestNumber_decode==''){
						$data['status']='True';
						$data['DocEntry']=$responce->DocEntry;
						$data['message']="Sample Intimation Retest QC Inventory Transfer Successfully Added.";
						echo json_encode($data);
					}else{
						if(array_key_exists('error', (array)$underTestNumber_decode)){
							$data['status']='False';
							$data['DocEntry']='';
							$data['message']=$responce->error->message->value;
							echo json_encode($data);
						}
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}

		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='SIRTIT_View_ajax'){
	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));

	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here
		$option='';
		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_StockTransfers.'('.$DocEntry.')';

			$responce_encode=$obj->getFunctionServiceLayer($Final_API);
			$responce=json_decode($responce_encode);

			$ItemAllData=$responce->StockTransferLines; // Item All Data Variable define
			$ContainerData=$ItemAllData[0]->BatchNumbers; // Container All Data Variable define

			$option.=' <div class="row">
				<input class="form-control desabled" type="hidden" id="SIRTIT_View_Series" name="SIRTIT_View_Series" value="'.$responce->Series.'" readonly>

				<div class="col-xl-3 col-md-6">
					<div class="form-group row mb-2">
						<label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
						<div class="col-lg-8">
							<input class="form-control desabled" type="text" value="'.$responce->CardCode.'" readonly>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-6">
					<div class="form-group row mb-2">
						<label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
						<div class="col-lg-8">
							<input class="form-control desabled" type="text" value="'.$responce->CardName.'" readonly>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-6">
					<div class="form-group row mb-2">
						<label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
						<div class="col-lg-8">
							<input class="form-control desabled" type="text" value="'.$responce->BPLName.'" readonly>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-6">
					<div class="form-group row mb-2">
						<label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
						<div class="col-lg-6">
							<input class="form-control desabled" type="text" id="SIRTIT_View_Series_Name" name="SIRTIT_View_Series_Name"  readonly>
						</div>
						<div class="col-lg-2">
							<input class="form-control desabled" type="text" value="'.$responce->DocNum.'" readonly>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-6">
					<div class="form-group row mb-2">
						<label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocType</label>
						<div class="col-lg-8">
							<input class="form-control desabled" type="text" value="'.$responce->U_BFType.'"readonly>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-6">
					<div class="form-group row mb-2">
						<label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
						<div class="col-lg-8">
							<input class="form-control desabled" type="text" id="PostingDate_ViewMode" name="PostingDate_ViewMode" value="'.date("d-m-Y", strtotime($responce->DocDate)).'" readonly>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-6">
					<div class="form-group row mb-2">
						<label class="col-lg-4 col-form-label mt-6" for="val-skill">Document Date</label>
						<div class="col-lg-8">
							<input class="form-control desabled" type="text" value="'.date("d-m-Y", strtotime($responce->DueDate)).'" readonly>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-6">
					<div class="form-group row mb-2">
						<label class="col-lg-4 col-form-label mt-6" for="val-skill">Base DocNum</label>
						<div class="col-lg-8">
							<input class="form-control desabled" type="text" value="'.$responce->DocEntry.'" readonly>
						</div>
					</div>
				</div>
			</div>

			<div class="table-responsive" id="list">
				<table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
					<thead class="fixedHeader1">
						<tr>
							<th>Sr. No </th>  
							<th>Item Code</th>
							<th>Item Name</th>
							<th>Quality</th>
							<th>From Whs</th>
							<th>To Whs</th>
							<th>Location</th>
							<th>UOM</th>
						</tr>
					</thead>
					<tbody>';
						for ($i=0; $i <count($ItemAllData) ; $i++) { 
							$option.='<tr>
								<td class="desabled">1</td>
								<td class="desabled">'.$ItemAllData[$i]->ItemCode.'</td>
								<td class="desabled">'.$ItemAllData[$i]->ItemDescription.'</td>
								<td class="desabled">'.number_format((float)$ItemAllData[$i]->Quantity, 6, '.', '').'</td>
								<td class="desabled">'.$responce->FromWarehouse.'</td>
								<td class="desabled">'.$responce->ToWarehouse.'</td>
								<td class="desabled" id="SIRTIT_View_Locatio"></td>
								<td class="desabled">'.$ItemAllData[$i]->MeasureUnit.'</td>
							</tr>';
						}
					$option.='</tbody> 
				</table>
			</div>

			<h5 class="modal-title" id="myLargeModalLabel">Container Selection</h5>
			<div class="table-responsive mt-2" id="list">
				<table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
					<thead class="fixedHeader1">
						<tr>
							<th>Item Code</th>
							<th>Item Name</th>
							<th>Container No</th>
							<th>Batch</th>
							<th>Batch Qty</th>
							<th>Mfg Date</th> 
							<th>Expiry Date</th>
						</tr>
					</thead>
					<tbody>';
						$sum=0;
						for ($j=0; $j <count($ContainerData) ; $j++) { 
							//  Date condition define start here -------------------------------------------
								$ManufacturingDate = (!empty($ContainerData[$j]->ManufacturingDate)) ? date("d-m-Y", strtotime($ContainerData[$j]->ManufacturingDate)) : null;

								$ExpiryDate = (!empty($ContainerData[$j]->ExpiryDate)) ? date("d-m-Y", strtotime($ContainerData[$j]->ExpiryDate)) : null;
							//  Date condition define end here ---------------------------------------------

							$option.='<tr>
								<td class="desabled">'.$ContainerData[$j]->ItemCode.'</td>
								<td class="desabled">'.$ItemAllData[0]->ItemDescription.'</td>
								<td class="desabled">'.$ContainerData[$j]->BatchNumber.'</td>
								<td class="desabled">'.number_format((float)$ContainerData[$j]->Quantity, 6, '.', '').'</td>
								<td class="desabled">'.number_format((float)$ContainerData[$j]->Quantity, 6, '.', '').'</td>
								<td class="desabled">'.$ManufacturingDate.'</td>
								<td class="desabled">'.$ExpiryDate.'</td>
							</tr>';

							$sum+=$ContainerData[$j]->Quantity;
						}
						$option.='<tr>
							<td colspan="4"></td>
							<td class="desabled">
							<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum" name="cs_selectedQtySum" value="'.number_format((float)$sum, 6, '.', '').'" readonly="">
							</td>
							<td colspan="2"></td>
						</tr>
					</tbody> 
				</table>
			</div>

            <button type="button" class="btn active btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>';
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		echo json_encode($option);
		exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='OPSCRTQC_popup_data')
{
	$API=$RETESTQCSAMPLECOLLVIEW_API.'&DocEntry='.$_POST['DocEntry'].'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&LineNum='.$_POST['LineNum'];
	// print_r($API);
	// die();
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['OTSCRTQC_P_Btn'])){
	$tdata=array(); // This array send to AP Standalone Invoice process 

	$tada['Series']=trim(addslashes(strip_tags($_POST['SCRTP_DocNo'])));
	$tdata['U_PC_BLin']=trim(addslashes(strip_tags($_POST['SCRTP_GRNLineNo'])));
	$tdata['U_PC_InTyp']=trim(addslashes(strip_tags($_POST['SCRTP_IngrediantType'])));
	$tdata['U_PC_GRNNo']=trim(addslashes(strip_tags($_POST['SCRTP_GRNNo'])));
	$tdata['U_PC_GRNEnt']=trim(addslashes(strip_tags($_POST['SCRTP_GRNDocEntry'])));
	$tdata['U_PC_Loc']=trim(addslashes(strip_tags($_POST['SCRTP_Location'])));
	$tdata['U_PC_InBy']=trim(addslashes(strip_tags($_POST['SCRTP_IntimatedBy'])));
	$tdata['U_PC_InDt']=date("Y-m-d", strtotime($_POST['SCRTP_IntimatedDate']));
	$tdata['U_PC_SQty']=trim(addslashes(strip_tags($_POST['SCRTP_SampleQty'])));
	$tdata['U_PC_SUnit']=trim(addslashes(strip_tags($_POST['SCRTP_UoM'])));
	$tdata['U_PC_SCBy']=trim(addslashes(strip_tags($_POST['SCRTP_SampleCollectBy'])));
	$tdata['U_PC_ARNo']=trim(addslashes(strip_tags($_POST['SCRTP_ARNo'])));
	$tdata['U_PC_DDt']=date("Y-m-d", strtotime($_POST['SCRTP_DocDate']));
	$tdata['U_PC_TrNo']=trim(addslashes(strip_tags($_POST['SCRTP_TRNo'])));
	$tdata['U_PC_Branch']=trim(addslashes(strip_tags($_POST['SCRTP_Branch'])));
	$tdata['U_PC_ICode']=trim(addslashes(strip_tags($_POST['SCRTP_ItemCode'])));
	$tdata['U_PC_IName']=trim(addslashes(strip_tags($_POST['SCRTP_ItemName'])));
	$tdata['U_PC_BNo']=trim(addslashes(strip_tags($_POST['SCRTP_BatchNo'])));
	$tdata['U_PC_NoCont']=trim(addslashes(strip_tags($_POST['SCRTP_NoOfCont'])));
	$tdata['U_PC_UTNo']=null;
	$tdata['U_PC_SIssue']=null;
	$tdata['U_PC_RSIssue']=null;
	$tdata['U_PC_BPLId']=trim(addslashes(strip_tags($_POST['SCRTP_BPLId'])));
	$tdata['U_PC_LocCode']=trim(addslashes(strip_tags($_POST['SCRTP_LocCode'])));
	$tdata['U_PC_BtchQty']=trim(addslashes(strip_tags($_POST['SCRTP_BatchQty'])));
	$tdata['U_PC_MakeBy']=trim(addslashes(strip_tags($_POST['SCRTP_MakeBy'])));

	// <!-- ------- Open transaction for sample Collection Retest QC popup validation start Here ------------------ -->
		if(empty($_POST['SCRTP_SampleCollectBy'])){
			$data['status']='False';$data['DocEntry']='';
			$data['message']="Sample Collect By Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if(empty($_POST['SCRTP_DocDate'])){
			$data['status']='False';$data['DocEntry']='';
			$data['message']="Document Date Mandatory.";
			echo json_encode($data);
			exit(0);
		}
	// <!-- ------- Open transaction for sample Collection Retest QC popup validation end Here -------------------- -->

	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SCRETEST_API;

			$responce_encode=$obj->SaveSampleIntimation($tdata,$Final_API); // sample intimation save here
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();

				if($responce->DocNum!=""){
					// Update ARNo document number start here ------------------------------ -->
						// Sanitize input data
						$ItemCode = trim(addslashes(strip_tags($_POST['SCRTP_ItemCode'])));
						$Location = trim(addslashes(strip_tags($_POST['SCRTP_Location'])));
						$DocDate = !empty($_POST['SCRTP_DocDate']) ? date("Ymd", strtotime($_POST['SCRTP_DocDate'])) : null;

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

						if(array_key_exists('error', (array)$response_encode12)){
							$data['status']='False';
							$data['DocEntry']='';
							$data['message']=$response_encode12->error->message->value;
							echo json_encode($data);
						}else{
							if(!empty($_POST['SCRTP_SupplierName'])){
								// Purchase Delivery Notes
								$SIntiMainArray = [
									'DocumentLines' => [
										[
											'LineNum' => $responce->U_PC_BLin,
											'U_PC_SCRtest' => $responce->DocEntry
										]
									]
								];

								$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_PurchaseDeliveryNotes.'('.$responce->U_PC_GRNEnt.')';

								// <!-- -------- Service Layer Function start here --------- -->
									$res11=$obj->SAP_Login();  // SAP Service Layer Login Here
									if(!empty($res)){
										$responce_encode1=$obj->PATCH_ServiceLayerMasterFunction($SIntiMainArray,$Final_API);
										$responce1=json_decode($responce_encode1);
									}
									$res12=$obj->SAP_Logout();  // SAP Service Layer Logout Here    
								// <!-- -------- Service Layer Function end here ----------- -->

								if(empty($responce1)){
									$data['status']='True';
									$data['DocEntry']=$responce->DocEntry;
									$data['message']="Open Transaction For Sample Collection-Retest QC Successfully Added.";
									echo json_encode($data);
								}else{
									if(array_key_exists('error', (array)$responce1)){
										$data['status']='False';
										$data['DocEntry']='';
										$data['message']=$responce1->error->message->value;
										echo json_encode($data);
									}
								}
							}else{
								// Inventory Gen Entries
								$InventoryGenEntries=array();
								$InventoryGenEntries['SIDocEntry']=trim($responce->DocEntry);
								$InventoryGenEntries['GRDocEntry']=trim($_POST['SCRTP_GRNDocEntry']);
								$InventoryGenEntries['ItemCode']=trim($_POST['SCRTP_ItemCode']);
								$InventoryGenEntries['LineNum']=trim($responce->U_PC_BLin);

								$Final_API=$GRSAMPLECOLLRETEST_APi;
								$responce_encode1=$obj->POST_QuerryBasedMasterFunction($InventoryGenEntries,$Final_API);
								$responce1=json_decode($responce_encode1);

								if(empty($responce1)){
									$data['status']='True';$data['DocEntry']=$responce->DocEntry;
									$data['message']="Open Transaction For Sample Collection-Retest QC Successfully Added.";
									echo json_encode($data);
								}else{
									if(array_key_exists('error', (array)$responce1)){
										$data['status']='False';$data['DocEntry']='';
										$data['message']=$responce1->error->message->value;
										echo json_encode($data);
									}
								}
							}
						}
					// Update ARNo document number end here -------------------------------- -->
				}else{
					if(array_key_exists('error', (array)$responce)){
						$data['status']='False';
						$data['DocEntry']='';
						$data['message']=$responce->error->message->value;
						echo json_encode($data);
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}

		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}



if(isset($_POST['action']) && $_POST['action'] =='sample_collection_RTQC_ajax')

{	


	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));
	$rowCount=trim(addslashes(strip_tags($_POST['rowCount'])));
	$rowCount_N=trim(addslashes(strip_tags($_POST['rowCount_N'])));

	//print_r($rowCount);
	
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$API=$RETESTQCSAMPCOLLADD_API.'?DocEntry='.$DocEntry;
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	


	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	// echo "<pre>";
	// print_r($response);
	// // <!-- ------ Array declaration Start Here --------------------------------- -->
		$FinalResponce=array();
		$FinalResponce['SampleCollDetails']=$response;
	// // <!-- ------ Array declaration End Here  --------------------------------- -->
	
	$ExtraIssue=$response[0]->RETESTQCSAMCOLLEXTRA; // Etra issue response seperate here 

	$ExternalIssue=$response[0]->RETESTQCSAMCOLLEXTERNAL; //External issue reponce seperate here
	// echo '<pre>';
	// print_r($ExternalIssue);
	// die();
	// var_dump($response);

    // =======================================================================================================
		// <!-- ----------- Extra Issue Start here --------------------------------- -->
			if(!empty($ExtraIssue)){
				for ($i=0; $i <count($ExtraIssue) ; $i++) { 
					
					$SrNo=$rowCount_N+1;

					if(!empty($ExtraIssue[$i]->IssueDate)){
						$IssueDate=date("d-m-Y", strtotime($ExtraIssue[$i]->IssueDate));
					}else{
						$IssueDate='';
					}

					$FinalResponce['ExtraIssue'].='<tr>
					    <td>
					    	<input type="radio" id="ExtraIslist'.$SrNo.'" name="ExtraIslistRado" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExtraIssue('.$SrNo.')">
					    </td>

					    <td class="desabled">
					    	<input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control desabled" >

					    	<input class="border_hide  form-control desabled" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->sampleQty2.'" onfocusout="GetExtraIuuseWhs('.$SrNo.')" readonly >

				    	</td>

					    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM2.'" class="form-control desabled" readonly></td>

					    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_FEI_Warehouse[]" value="'.$ExtraIssue[$i]->Whs2.'" class="form-control desabled" readonly></td>

					    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control desabled" readonly></td>

					    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control desabled" readonly></td>

					    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control desabled" readonly></td>
					 </tr>';
				}
				// when table data come then default add one manual row start ---------------------------------------------------------
				$SrNo=(count($ExtraIssue)+1);
				$FinalResponce['ExtraIssue'].='<tr>
				    <td class="desabled">
				    	
				    </td>

				    <td>
					    <input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control" >

					    <input class="border_hide  form-control" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->sampleQty2.'" onfocusout="GetExtraIuuseWhs('.$SrNo.')" >

				    </td>

				    <td class="desabled">
				    	<input class="border_hide desabled" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM2.'" class="form-control" readonly >
			    	</td>

				   
					
					    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_FEI_Warehouse[]" value="'.$ExtraIssue[$i]->Whs2.'" class="form-control desabled" readonly></td>



				    <td class="desabled">
					
				    	<input class="border_hide desabled" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control">
			    	</td>

				    <td>
				    	<input class="border_hide" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control">
			    	</td>

				    <td>
				    	<input class="border_hide" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control">
			    	</td>
				 </tr>';

					// onchange="ExternalIssueSelectedBP('.$SrNo.')"  ---->  warehouse selection onchange function
			}else{
				$SrNo=$rowCount_N+1;
				$FinalResponce['ExtraIssue'].='<tr>
				    <td class="desabled">
				    	'.$SrNo.'
				    </td>

				    <td>
					    <input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control" >

						<input class="border_hide  form-control" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->sampleQty2.'" onfocusout="GetExtraIuuseWhs('.$SrNo.')" >

				    </td>

				    <td class="desabled">
				    	<input class="border_hide desabled " type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM2.'" class="form-control" readonly>
			    	</td>

				    
					<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_ExternalI_SupplierCode[]" value="'.$ExtraIssue[$i]->Whs2.'" class="form-control desabled" readonly></td>

				    <td class="desabled">
				    	<input class="border_hide desabled" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control">
			    	</td>

				    <td class="desabled">
				    	<input class="border_hide desabled" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control">
			    	</td>

				    <td>
				    	<input class="border_hide" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control">
			    	</td>
				 </tr>';
			}
			
		// <!-- ----------- Extra Issue End here --------------------------------- -->
	// =======================================================================================================


	// <!-- ----------- External Issue Start Here ---------------------------- -->
	

		if(!empty($ExternalIssue)){

			
			for ($j=0; $j <(count($ExternalIssue)-1) ; $j++) { 

				$SrNo=$rowCount+1;
				// if(count($ExternalIssue)==$SrNo){
					if(!empty($ExternalIssue[$j]->SampleDate)){
					$SampleDate=date("d-m-Y", strtotime($ExternalIssue[$j]->SampleDate));
					}else{
						$SampleDate='';
					}


					$FinalResponce['ExternalIssue'].='<tr>
						
						<td style="text-align: center;">
							<input class="border_hide" type="hidden" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="'.$ExternalIssue[$j]->Linenum.'" class="form-control desabled" readonly>

							<input type="radio" id="list'.$SrNo.'" name="listRado" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExternalIssue('.$SrNo.')">
						</td>
						
						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierCode'.$SrNo.'" name="SC_FEXI_SupplierCode[]" value="'.$ExternalIssue[$j]->SupplierCode.'" class="form-control desabled" readonly></td>
						
						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" value="'.$ExternalIssue[$j]->SupplierName.'" class="form-control desabled" readonly></td>
						
						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" value="'.$ExternalIssue[$j]->UOM1.'" class="form-control desabled" readonly></td>
						
						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" value="'.$SampleDate.'" class="form-control desabled" readonly></td>
						
						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Warehouse'.$SrNo.'" name="SC_FEXI_Warehouse[]" value="'.$ExternalIssue[$j]->Whs1.'" class="form-control desabled" readonly></td>
						
						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" value="'.$ExternalIssue[$j]->SampleQuantity.'" class="form-control desabled" readonly></td>
						
						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" value="'.$ExternalIssue[$j]->InventoryTransfer.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" value="'.$ExternalIssue[$j]->UserText1.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" value="'.$ExternalIssue[$j]->UserText2.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" value="'.$ExternalIssue[$j]->UserText3.'" class="form-control desabled" readonly></td>

						<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" value="'.$ExternalIssue[$j]->Attachment.'" class="form-control"></td>
					</tr>';
				//}
			}

			// when table data come then default add one manual row start ---------------------------------------------------------
			$SrNo=(count($ExternalIssue));

			$FinalResponce['ExternalIssue'].='<tr>
			    <td></td>
			 	
			 	<td>
			 		<input class="border_hide" type="hidden" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="" class="form-control desabled" readonly>

					<select class="form-control ExternalIssueSelectedBPWithData" id="SC_ExternalI_SupplierCode'.$SrNo.'" name="SC_FEXI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;">
					</select>
				</td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>
			    
			    <td class="desabled" ><input class="border_hide desabled" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" class="form-control desabled" readonly></td>
			    
			    <td><input class="border_hide" type="date" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_FEXI_Warehouse[]" class="form-control desabled" readonly></td>
			    
			    <td><input class="border_hide" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" class="form-control"></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" class="form-control"></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" class="form-control"></td>

			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" class="form-control"></td>
			</tr>';
			// when table data come then default add one manual row end -----------------------------------------------------------
		}else{
			// if user not added External issue recored then show default blank row
			$SrNo=$rowCount+1;

			$FinalResponce['ExternalIssue'].='<tr>
			    <td>
			    	<input class="border_hide" type="text" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="'.$SrNo.'" class="form-control desabled" readonly>
			    </td>
			 	
			 	<td>
					<select class="form-control ExternalIssueDefault" id="SC_ExternalI_SupplierCode'.$SrNo.'" name="SC_FEXI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;">
						 
					</select>
				</td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" class="form-control desabled" readonly></td>
			    
			    <td><input class="border_hide" type="date" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>
			    
				
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_FEXI_Warehouse[]" class="form-control desabled" readonly></td>
			    
			    <td><input class="border_hide" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" class="form-control"></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" class="form-control"></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" class="form-control"></td>

			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" class="form-control"></td>
			</tr>';
		}
	// <!-- ----------- External Issue End Here   ---------------------------- -->

	echo json_encode($FinalResponce);
	exit(0);
}
























// ================================================== ReTest QC Code End Here ======================================

// ========================================= Production QC - Route Stage Code start Here ============================
if(isset($_POST['action']) && $_POST['action'] =='sample_intimation_RS_popup')
{
	$API=$ROUTESTAGEOPENTRANS_API.'&DocEntry='.$_POST['DocEntry'].'&BatchN='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&StageName='.$_POST['StageName'];

	// <!-- ------- Replace blank space to %20 start here -------- -->
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
		// print_r($API);
		// die();
	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['SampleIntimationRouteStageBtn'])){
	$tadat=array();

	$tdata['Series']=trim(addslashes(strip_tags($_POST['SIRS_DocNoName'])));
	$tdata['Object']='SCS_SIRSTAGE';
	
	if(!empty($_POST['SIRS_ReceiptNo'])){
		$tdata['U_PC_RNo']=trim(addslashes(strip_tags($_POST['SIRS_ReceiptNo'])));
	}else{
		$tdata['U_PC_RNo']=null;
	}

	$tdata['Canceled']=(empty($_POST['SIRS_StatusChekBox_val']))? 'N': 'Y';
	$tdata['U_PC_WoNo']=trim(addslashes(strip_tags($_POST['SIRS_WONo'])));
	$tdata['U_PC_WoEnt']=trim(addslashes(strip_tags($_POST['SIRS_WOEntry'])));
	$tdata['U_PC_RStg']=trim(addslashes(strip_tags($_POST['SIRS_RouteStage'])));
	$tdata['U_PC_SType']=trim(addslashes(strip_tags($_POST['SIRS_SampleType'])));
	$tdata['U_PC_TRBy']=trim(addslashes(strip_tags($_POST['SIRS_TrBy'])));
	$tdata['U_PC_ICode']=trim(addslashes(strip_tags($_POST['SIRS_ItemCode'])));
	$tdata['U_PC_IName']=trim(addslashes(strip_tags($_POST['SIRS_ItemName'])));
	$tdata['U_PC_SQty']=trim(addslashes(strip_tags($_POST['SIRS_SampleQty'])));
	$tdata['U_PC_RQty']=trim(addslashes(strip_tags($_POST['SIRS_RetainQty'])));
	$tdata['U_PC_BNo']=trim(addslashes(strip_tags($_POST['SIRS_BatchNo'])));
	$tdata['U_PC_BQty']=trim(addslashes(strip_tags($_POST['SIRS_BatchQty'])));
	$tdata['U_PC_Unit']=trim(addslashes(strip_tags($_POST['SIRS_Unit'])));
	$tdata['U_PC_TNCont1']=trim(addslashes(strip_tags($_POST['SIRS_TotNoCont'])));
	$tdata['U_PC_FCont']=trim(addslashes(strip_tags($_POST['SIRS_FromCont'])));
	$tdata['U_PC_TCont']=trim(addslashes(strip_tags($_POST['SIRS_ToCont'])));
	$tdata['U_PC_Branch']=trim(addslashes(strip_tags($_POST['SIRS_Branch'])));
	$tdata['U_PC_Loc']=trim(addslashes(strip_tags($_POST['SIRS_Location'])));
	$tdata['U_PC_ChNo']=trim(addslashes(strip_tags($_POST['SIRS_ChallanNo'])));
	$tdata['U_PC_GENo']=trim(addslashes(strip_tags($_POST['SIRS_GateEntryNo'])));
	$tdata['U_PC_CNos']=trim(addslashes(strip_tags($_POST['SIRS_ContainerNos'])));
	$tdata['U_PC_Cont']=trim(addslashes(strip_tags($_POST['SIRS_Container'])));
	$tdata['U_PC_Cancle']=trim(addslashes(strip_tags($_POST['SIRS_StatusChekBox'])));

	
	if(!empty($_POST['SIRS_BPLId'])){
		$tdata['U_PC_BPLId']=trim(addslashes(strip_tags($_POST['SIRS_BPLId'])));
	}else{
		$tdata['U_PC_BPLId']=null;
	}

	if(!empty($_POST['SIRS_LocId'])){
		$tdata['U_PC_LCode']=trim(addslashes(strip_tags($_POST['SIRS_LocId'])));
	}else{
		$tdata['U_PC_LCode']=null;
	}

	$tdata['U_PC_REnt']=null;
	$tdata['U_PC_RcQty']=null;
	$tdata['U_PC_TNCont']=null;
	$tdata['U_PC_UTTrans']=null;
	$tdata['U_PC_BLin']=null;

	// ---------------------------------Date Var Prepare Start Here ------------------------------------
		if(!empty($_POST['SIRS_MfgDate'])){
			$tdata['U_PC_MfgDt']=date('Y-m-d', strtotime($_POST['SIRS_MfgDate']));
		}else{
			$tdata['U_PC_MfgDt']=null;
		}

		if(!empty($_POST['SIRS_ExpiryDate'])){
			$tdata['U_PC_ExpDt']=date('Y-m-d', strtotime($_POST['SIRS_ExpiryDate']));
		}else{
			$tdata['U_PC_ExpDt']=null;
		}

		if(!empty($_POST['SIRS_GateEntryDate'])){
			$tdata['U_PC_GEDte']=date('Y-m-d', strtotime($_POST['SIRS_GateEntryDate']));
		}else{
			$tdata['U_PC_GEDte']=null;
		}

		if(!empty($_POST['SIRS_ChallanDate'])){
			$tdata['U_PC_ChDate']=date('Y-m-d', strtotime($_POST['SIRS_ChallanDate']));
		}else{
			$tdata['U_PC_ChDate']=null;
		}

		if(!empty($_POST['SIRS_TrDate'])){
			$tdata['U_PC_TRDte']=date('Y-m-d', strtotime($_POST['SIRS_TrDate']));
		}else{
			$tdata['U_PC_TRDte']=null;
		}

		if(!empty($_POST['SIRS_WoDate'])){
			$tdata['U_PC_RDt']=date('Y-m-d', strtotime($_POST['SIRS_WoDate']));
		}else{
			$tdata['U_PC_RDt']=null;
		}
		
	// ---------------------------------Date Var Prepare End Here   ------------------------------------

	// <!-- ---------------------- sample Intimation popup validation start Here ------------------ -->
		if($_POST['SIRS_SampleType']==''){
			$data['status']='False';
			$data['DocEntry']='';
			$data['message']="Sample Type Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if($_POST['SIRS_TrBy']==''){
			$data['status']='False';
			$data['DocEntry']='';
			$data['message']="TR Type Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if($_POST['SIRS_TrDate']==''){
			$data['status']='False';
			$data['DocEntry']='';
			$data['message']="TR Date Mandatory.";
			echo json_encode($data);
			exit(0);
		}
	// <!-- ---------------------- sample Intimation popup validation end Here -------------------- -->

	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SIRSTAGE_API;
			
			$responce_encode=$obj->SaveSampleIntimation($tdata,$Final_API); // sample intimation save here
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();

				if($responce->DocNum!=""){

					$data['status']='True';
					$data['DocEntry']=$responce->DocEntry;
					$data['message']="Sample Intimation (Transfer Request) - Route Stage Successfully Added.";
					echo json_encode($data);
				}else{
					if(array_key_exists('error', (array)$responce)){
						$data['status']='False';
						$data['DocEntry']='';
						$data['message']=$responce->error->message->value;
						echo json_encode($data);
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='sample_intimation_RS_Selected_row')
{
	$API=$ROUTESTAGESAMPLEINTIMATIONADD_API.'?DocEntry='.$_POST['DocEntry'];
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['SampleIntimationRouteStageUpdateBtn']))
{
	
	$tadat=array();

	$tdata['Object']='SCS_SIRSTAGE';

	if(!empty($_POST['SIRSU_ReceiptNo'])){
		$tdata['U_PC_RNo']=trim(addslashes(strip_tags($_POST['SIRSU_ReceiptNo'])));
	}else{
		$tdata['U_PC_RNo']=null;
	}

	$tdata['Canceled']=(empty($_POST['SIRSU_StatusChekBox_val']))? 'N': 'Y';
	$tdata['U_PC_WoNo']=trim(addslashes(strip_tags($_POST['SIRSU_WONo'])));
	$tdata['U_PC_WoEnt']=trim(addslashes(strip_tags($_POST['SIRSU_WOEntry'])));
	$tdata['U_PC_RStg']=trim(addslashes(strip_tags($_POST['SIRSU_RouteStage'])));
	$tdata['U_PC_SType']=trim(addslashes(strip_tags($_POST['SIRSU_SampleType'])));
	$tdata['U_PC_TRBy']=trim(addslashes(strip_tags($_POST['SIRSU_TrBy'])));
	$tdata['U_PC_ICode']=trim(addslashes(strip_tags($_POST['SIRSU_ItemCode'])));
	$tdata['U_PC_IName']=trim(addslashes(strip_tags($_POST['SIRSU_ItemName'])));
	$tdata['U_PC_SQty']=trim(addslashes(strip_tags($_POST['SIRSU_SampleQty'])));
	$tdata['U_PC_RQty']=trim(addslashes(strip_tags($_POST['SIRSU_RetainQty'])));
	$tdata['U_PC_BNo']=trim(addslashes(strip_tags($_POST['SIRSU_BatchNo'])));
	$tdata['U_PC_BQty']=trim(addslashes(strip_tags($_POST['SIRSU_BatchQty'])));
	$tdata['U_PC_Unit']=trim(addslashes(strip_tags($_POST['SIRSU_Unit'])));
	$tdata['U_PC_TNCont1']=trim(addslashes(strip_tags($_POST['SIRSU_TotNoCont'])));
	$tdata['U_PC_FCont']=trim(addslashes(strip_tags($_POST['SIRSU_FromCont'])));
	$tdata['U_PC_TCont']=trim(addslashes(strip_tags($_POST['SIRSU_ToCont'])));
	$tdata['U_PC_Branch']=trim(addslashes(strip_tags($_POST['SIRSU_Branch'])));
	$tdata['U_PC_Loc']=trim(addslashes(strip_tags($_POST['SIRSU_Location'])));
	// $tdata['U_PC_ChNo']=trim(addslashes(strip_tags($_POST['SIRSU_ChallanNo'])));
	// $tdata['U_PC_GENo']=trim(addslashes(strip_tags($_POST['SIRSU_GateEntryNo'])));
	$tdata['U_PC_CNos']=trim(addslashes(strip_tags($_POST['SIRSU_ContainerNos'])));
	// $tdata['U_PC_Cont']=trim(addslashes(strip_tags($_POST['SIRSU_Container'])));
	$tdata['U_PC_Cancle']=trim(addslashes(strip_tags($_POST['SIRSU_StatusChekBox'])));

	if(!empty($_POST['SIRSU_BPLId'])){
		$tdata['U_PC_BPLId']=trim(addslashes(strip_tags($_POST['SIRSU_BPLId'])));
	}else{
		$tdata['U_PC_BPLId']=null;
	}

	if(!empty($_POST['SIRSU_LocId'])){
		$tdata['U_PC_LCode']=trim(addslashes(strip_tags($_POST['SIRSU_LocId'])));
	}else{
		$tdata['U_PC_LCode']=null;
	}

	$tdata['U_PC_REnt']=null;
	$tdata['U_PC_RcQty']=''; // discussion
	$tdata['U_PC_TNCont']=null;
	$tdata['U_PC_UTTrans']=null;
	$tdata['U_PC_BLin']=null;

	// ---------------------------------Date Var Prepare Start Here ------------------------------------
		if(!empty($_POST['SIRSU_MfgDate'])){
			$tdata['U_PC_MfgDt']=date('Y-m-d', strtotime($_POST['SIRSU_MfgDate']));
		}else{
			$tdata['U_PC_MfgDt']='';
		}

		if(!empty($_POST['SIRSU_ExpiryDate'])){
			$tdata['U_PC_ExpDt']=date('Y-m-d', strtotime($_POST['SIRSU_ExpiryDate']));
		}else{
			$tdata['U_PC_ExpDt']='';
		}

		if(!empty($_POST['SIRSU_GateEntryDate'])){
			$tdata['U_PC_GEDte']=date('Y-m-d', strtotime($_POST['SIRSU_GateEntryDate']));
		}else{
			$tdata['U_PC_GEDte']='';
		}

		// if(!empty($_POST['SIRSU_ChallanDate'])){
		// 	$tdata['U_PC_ChDate']=date('Y-m-d', strtotime($_POST['SIRSU_ChallanDate']));
		// }else{
		// 	$tdata['U_PC_ChDate']='';
		// }

		if(!empty($_POST['SIRSU_TrDate'])){
			$tdata['U_PC_TRDte']=date('Y-m-d', strtotime($_POST['SIRSU_TrDate']));
		}else{
			$tdata['U_PC_TRDte']='';
		}

		if(!empty($_POST['SIRSU_WoDate'])){
			$tdata['U_PC_RDt']=date('Y-m-d', strtotime($_POST['SIRSU_WoDate']));
		}else{
			$tdata['U_PC_RDt']='';
		}
	// ---------------------------------Date Var Prepare End Here   ------------------------------------
	
	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){

			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SIRSTAGE_API.'('.$_POST['SIRSU_DocEntry'].')';
			$underTestNumber=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($tdata,$Final_API);
			$responce=json_decode($underTestNumber);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();

				if($responce==''){
					$data['status']='True';
					$data['DocEntry']=$_POST['SIRSU_DocEntry'];
					$data['message']="Sample Intimation (Transfer Request) - Route Stage Successfully Updated.";
					echo json_encode($data);
				}else{
					if(array_key_exists('error', (array)$responce)){
						$data['status']='False';
						$data['DocEntry']='';
						$data['message']=$responce->error->message->value;
						echo json_encode($data);
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='OT_Sample_CollectionRouteStage_popup')
{
	$API=$RSSAMPLECOLLECTIONVIEW_API.'&DocEntry='.$_POST['WOEntry'].'&BatchNo='.$_POST['BatchNum'].'&ItemCode='.$_POST['ItemCode'].'&StageName='.$_POST['StageName'];
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	// print_r($API);
	// die();
	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['OTSCRSP_Btn'])){
	$tdata=array(); // This array send to AP Standalone Invoice process 

	$tdata['Series']=trim(addslashes(strip_tags($_POST['OTSCRSP_DocNo'])));
	$tdata['Remark']=null;
	$tdata['Object']='SCS_SCRSTAGE';
	$tdata['U_PC_InTyp']=trim(addslashes(strip_tags($_POST['OTSCRSP_IngredientsType'])));
	$tdata['U_PC_WoNo']=trim(addslashes(strip_tags($_POST['OTSCRSP_WONo'])));
	$tdata['U_PC_WoEnt']=trim(addslashes(strip_tags($_POST['OTSCRSP_WOEntry'])));
	$tdata['U_PC_RStg']=trim(addslashes(strip_tags($_POST['OTSCRSP_StageName'])));
	$tdata['U_PC_InBy']=trim(addslashes(strip_tags($_POST['OTSCRSP_IntimatedBy'])));
	$tdata['U_PC_SQty']=trim(addslashes(strip_tags($_POST['OTSCRSP_SampleQty'])));
	$tdata['U_PC_SUnit']=trim(addslashes(strip_tags($_POST['OTSCRSP_SampleQtyUOM'])));
	$tdata['U_PC_SClBy']=trim(addslashes(strip_tags($_POST['OTSCRSP_SampleCollectBy'])));
	$tdata['U_PC_ARNo']=trim(addslashes(strip_tags($_POST['OTSCRSP_ARNo'])));
	$tdata['U_PC_TrNo']=trim(addslashes(strip_tags($_POST['OTSCRSP_TRNo'])));
	$tdata['U_PC_Branch']=trim(addslashes(strip_tags($_POST['OTSCRSP_Branch'])));
	$tdata['U_PC_Loc']=trim(addslashes(strip_tags($_POST['OTSCRSP_Loaction'])));
	$tdata['U_PC_ICode']=trim(addslashes(strip_tags($_POST['OTSCRSP_ItemCode'])));
	$tdata['U_PC_IName']=trim(addslashes(strip_tags($_POST['OTSCRSP_ItemName'])));
	$tdata['U_PC_BNo']=trim(addslashes(strip_tags($_POST['OTSCRSP_BatchNum'])));
	$tdata['U_PC_BtchQty']=trim(addslashes(strip_tags($_POST['OTSCRSP_BatchQty'])));
	$tdata['U_PC_NCont']=trim(addslashes(strip_tags($_POST['OTSCRSP_TotalNoContainer'])));
	$tdata['U_PC_BLin']=trim(addslashes(strip_tags($_POST['OTSCRSP_LineNo'])));
	$tdata['U_PC_BPLId']=trim(addslashes(strip_tags($_POST['OTSCRSP_BPLId'])));
	$tdata['U_PC_LocCode']=trim(addslashes(strip_tags($_POST['OTSCRSP_LocCode'])));
	$tdata['U_PC_UTNo']=null;
	$tdata['U_PC_DRev']=null;
	$tdata['U_PC_SIssue']=null;
	$tdata['U_PC_RSIssue']=null;
	$tdata['U_PC_RIssue']=null;
	$tdata['U_PC_RQty']='';
	$tdata['U_PC_RQtyUom']='';
	$tdata['U_PC_CntNo1']='';
	$tdata['U_PC_CntNo2']='';
	$tdata['U_PC_CntNo3']='';
	$tdata['U_PC_QtyLab']='';
	$tdata['U_PC_Trans']='';

	if(!empty($_POST['OTSCRSP_DocDate'])){
		$tdata['U_PC_DDt']=date("Y-m-d", strtotime($_POST['OTSCRSP_DocDate']));
	}else{
		$tdata['U_PC_DDt']=null;
	}

	if(!empty($_POST['OTSCRSP_IntimatedDate'])){
		$tdata['U_PC_InDt']=date("Y-m-d", strtotime($_POST['OTSCRSP_IntimatedDate']));
	}else{
		$tdata['U_PC_InDt']=null;
	}

	// <!-- --- Open Transaction for sample Collection Route Stage popup validation start Here ------------ -->
		if(empty($_POST['OTSCRSP_SampleCollectBy'])){
			$data['status']='False';$data['DocEntry']='';
			$data['message']="Sample Collect By Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if(empty($_POST['OTSCRSP_DocDate'])){
			$data['status']='False';$data['DocEntry']='';
			$data['message']="Document Date Mandatory.";
			echo json_encode($data);
			exit(0);
		}
	// <!-- --- Open Transaction for sample Collection Route Stage popup validation end Here -------------- -->

	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SCRSTAGE_API;

			$responce_encode=$obj->SaveSampleIntimation($tdata,$Final_API); // sample intimation save here
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();

				if($responce->DocNum!=""){
					// Update ARNo document number start here ------------------------------ -->
						// Sanitize input data
						$ItemCode = trim(addslashes(strip_tags($_POST['OTSCRSP_ItemCode'])));
						$Location = trim(addslashes(strip_tags($_POST['OTSCRSP_Loaction'])));
						$DocDate = !empty($_POST['OTSCRSP_DocDate']) ? date("Ymd", strtotime($_POST['OTSCRSP_DocDate'])) : null;

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

						if(array_key_exists('error', (array)$response_encode12)){
							$data['status']='False';
							$data['DocEntry']='';
							$data['message']=$response_encode12->error->message->value;
							echo json_encode($data);
						}else{
							$data['status']='True';
							$data['DocEntry']=$responce->DocEntry;
							$data['message']="Sample Collection - Route/Stage Successfully Added.";
							echo json_encode($data);
						}
					// Update ARNo document number end here -------------------------------- -->
				}else{
					if(array_key_exists('error', (array)$responce)){
						$data['status']='False';
						$data['DocEntry']='';
						$data['message']=$responce->error->message->value;
						echo json_encode($data);
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}

		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ------ -->
}

if(isset($_POST['action']) && $_POST['action'] =='sample_collection_route_stage_ajax')
{	

	

	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));
	$rowCount=trim(addslashes(strip_tags($_POST['rowCount'])));
	$rowCount_N=trim(addslashes(strip_tags($_POST['rowCount_N'])));

	// <!-- ------- Replace blank space to %20 start here -------- -->
		$API=$RSSAMPCOLLADD_API.'?DocEntry='.$DocEntry;
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
		// print_r($FinalAPI);
		// die();
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	// echo $Final_API;

	// <!-- ------ Array declaration Start Here --------------------------------- -->
		$FinalResponce=array();
		$FinalResponce['SampleCollDetails']=$response;
	// <!-- ------ Array declaration End Here  --------------------------------- -->

	$ExtraIssue=$response[0]->SAMPLECOLLEXTRA; // Etra issue response seperate here 
	$ExternalIssue=$response[0]->SAMPLECOLLEXTERNAL; //External issue reponce seperate here
	// print_r($response);

	// ===============================================================================================================
		// <!-- ----------- Extra Issue Start here --------------------------------- -->
			if(!empty($ExtraIssue)){
				for ($i=0; $i <count($ExtraIssue) ; $i++) { 
					
					$SrNo=$rowCount_N+1;

					if(!empty($ExtraIssue[$i]->IssueDate)){
						$IssueDate=date("d-m-Y", strtotime($ExtraIssue[$i]->IssueDate));
					}else{
						$IssueDate='';
					}

					$FinalResponce['ExtraIssue'].='<tr>
					    <td>
					    	<input type="radio" id="ExtraIslist'.$SrNo.'" name="ExtraIslistRado" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExtraIssue('.$SrNo.')">
					    </td>

					    <td class="desabled">
					    	<input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control desabled" readonly>

					    	<input class="border_hide desabled" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->SampleQuantity.'" class="form-control desabled" readonly>
				    	</td>

					    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM.'" class="form-control desabled" readonly></td>

					    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_FEI_Warehouse[]" value="'.$ExtraIssue[$i]->Warehouse.'" class="form-control desabled" readonly></td>

					    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control desabled" readonly></td>

					    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control desabled" readonly></td>

					    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control desabled" readonly></td>
					 </tr>';
				}
				// when table data come then default add one manual row start ---------------------------------------------------------
				$SrNo=(count($ExtraIssue)+1);
				$FinalResponce['ExtraIssue'].='<tr>
				    <td class="desabled"></td>

				    <td>
					    <input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control" readonly>

					    <input class="border_hide" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->SampleQuantity.'" class="form-control">
				    </td>

				    <td>
				    	<input class="border_hide" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM.'" class="form-control">
			    	</td>

				    <td>
				    	<select class="form-control SC_FEI_WarehouseWithData" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_FEI_Warehouse[]"  style="width: 200px;">
						</select>
			    	</td>

				    <td>
				    	<input class="border_hide" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control">
			    	</td>

				    <td>
				    	<input class="border_hide" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control">
			    	</td>

				    <td>
				    	<input class="border_hide" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control">
			    	</td>
				 </tr>';

			}else{
				$SrNo=$rowCount_N+1;
				$FinalResponce['ExtraIssue'].='<tr>
				    <td class="desabled"></td>

				    <td>
					    <input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control" readonly>

					    <input class="border_hide" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->SampleQuantity.'" class="form-control">
				    </td>

				    <td>
				    	<input class="border_hide" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM.'" class="form-control">
			    	</td>

				    <td>
				    	<select class="form-control SC_FEI_WarehouseWithData" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_FEI_Warehouse[]" style="width: 200px;">
						</select>
			    	</td>

				    <td>
				    	<input class="border_hide" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control">
			    	</td>

				    <td>
				    	<input class="border_hide" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control">
			    	</td>

				    <td>
				    	<input class="border_hide" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control">
			    	</td>
				 </tr>';
			}
			
		// <!-- ----------- Extra Issue End here --------------------------------- -->
	// ===============================================================================================================

	// <!-- ----------- External Issue Start Here ---------------------------- -->
		if(!empty($ExternalIssue)){
			for ($j=0; $j <count($ExternalIssue) ; $j++) { 

				$SrNo=$rowCount+1;
				if(count($ExternalIssue)==$SrNo){
					if(!empty($ExternalIssue[$j]->SampleDate)){
					$SampleDate=date("d-m-Y", strtotime($ExternalIssue[$j]->SampleDate));
				}else{
					$SampleDate='';
				}

				$FinalResponce['ExternalIssue'].='<tr>
				    
					<td style="text-align: center;">
						<input class="border_hide" type="hidden" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="'.$ExternalIssue[$j]->Linenum.'" class="form-control desabled" readonly>

					    <input type="radio" id="list'.$SrNo.'" name="listRado" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExternalIssue('.$SrNo.')">
					</td>
				 	
				 	<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierCode'.$SrNo.'" name="SC_FEXI_SupplierCode[]" value="'.$ExternalIssue[$j]->SupplierCode.'" class="form-control desabled" readonly></td>
				    
				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" value="'.$ExternalIssue[$j]->SupplierName.'" class="form-control desabled" readonly></td>
				    
				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" value="'.$ExternalIssue[$j]->UOM.'" class="form-control desabled" readonly></td>
				    
				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" value="'.$SampleDate.'" class="form-control desabled" readonly></td>
				    
				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Warehouse'.$SrNo.'" name="SC_FEXI_Warehouse[]" value="'.$ExternalIssue[$j]->Warehouse.'" class="form-control desabled" readonly></td>
				    
				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" value="'.$ExternalIssue[$j]->SampleQuantity.'" class="form-control desabled" readonly></td>
				    
				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" value="'.$ExternalIssue[$j]->InventoryTransfer.'" class="form-control desabled" readonly></td>

				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" value="'.$ExternalIssue[$j]->UserText1.'" class="form-control desabled" readonly></td>

				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" value="'.$ExternalIssue[$j]->UserText2.'" class="form-control desabled" readonly></td>

				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" value="'.$ExternalIssue[$j]->UserText3.'" class="form-control desabled" readonly></td>

				    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" value="'.$ExternalIssue[$j]->Attachment.'" class="form-control"></td>
				</tr>';
				}
			}

			// when table data come then default add one manual row start ---------------------------------------------------------
			$SrNo=(count($ExternalIssue)+1);

			$FinalResponce['ExternalIssue'].='<tr>
			    <td></td>
			 	
			 	<td>
			 		<input class="border_hide" type="hidden" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="" class="form-control desabled" readonly>

					
					<select class="form-control ExternalIssueSelectedBPWithData" id="SC_ExternalI_SupplierCode'.$SrNo.'" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;">
					</select>
				</td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>
			    
			    <td><input class="border_hide" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" class="form-control desabled"></td>
			    
			    <td><input class="border_hide" type="date" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>
			    
			    <td>
					<select class="form-control ExternalIssueWareHouseWithData" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_ExternalI_Warehouse[]" style="width: 200px;"></select>
				</td>
			    
			    <td><input class="border_hide" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" class="form-control"></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" class="form-control"></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" class="form-control"></td>

			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" class="form-control"></td>
			</tr>';
			// when table data come then default add one manual row end -----------------------------------------------------------
		}else{
			// if user not added External issue recored then show default blank row
			$SrNo=$rowCount+1;

			$FinalResponce['ExternalIssue'].='<tr>
			    <td>
			    	<input class="border_hide" type="text" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="'.$SrNo.'" class="form-control desabled" readonly>
			    </td>
			 	
			 	<td>
					<select class="form-control ExternalIssueDefault" id="SC_ExternalI_SupplierCode'.$SrNo.'" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;">
						 
					</select>
				</td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>
			    
			    <td><input class="border_hide" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" class="form-control desabled"></td>
			    
			    <td><input class="border_hide" type="date" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>
			    
			    <td>
					<select class="form-control ExternalIssueWareHouseDefault" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_ExternalI_Warehouse[]" style="width: 200px;"></select>
				</td>
			    
			    <td><input class="border_hide" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>
			    
			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" class="form-control"></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" class="form-control"></td>

			    <td><input class="border_hide" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" class="form-control"></td>

			    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" class="form-control"></td>
			</tr>';
		}
	// <!-- ----------- External Issue End Here   ---------------------------- -->
	echo json_encode($FinalResponce);
	exit(0);
}

if(isset($_POST['SampleCollectionRouteStageUpdateForm_Btn']))
{
	// <!-- ------------ array declare Here ------------- -->
		$mainArray=array();
		$ExternalIssue=array();
		$ExtraIssue=array();
		$tdata=array();
	// <!-- ------------ array declare Here ------------- -->

		$tdata['Remark']=null;
		$tdata['Object']='SCS_SCRSTAGE';
		$tdata['U_PC_InTyp']=trim(addslashes(strip_tags($_POST['SCRS_IngrediantType'])));
		$tdata['U_PC_WoNo']=trim(addslashes(strip_tags($_POST['SCRS_WONo'])));
		$tdata['U_PC_WoEnt']=trim(addslashes(strip_tags($_POST['SCRS_WOEntry'])));
		$tdata['U_PC_RStg']=trim(addslashes(strip_tags($_POST['SCRS_StageName'])));
		$tdata['U_PC_InBy']=trim(addslashes(strip_tags($_POST['SCRS_IntimatedBy'])));

		if(!empty($_POST['SCRS_IntimatedDate'])){
			$tdata['U_PC_InDt']=date("Y-m-d", strtotime($_POST['SCRS_IntimatedDate']));	
		}else{
			$tdata['U_PC_InDt']=null;
		}

		$tdata['U_PC_SQty']=trim(addslashes(strip_tags($_POST['SCRS_SampleQty'])));
		$tdata['U_PC_SUnit']=trim(addslashes(strip_tags($_POST['SCRS_SampleQtyUOM'])));
		$tdata['U_PC_SClBy']=trim(addslashes(strip_tags($_POST['SCRS_SampleCollectBy'])));
		$tdata['U_PC_ARNo']=trim(addslashes(strip_tags($_POST['SCRS_ARNo'])));

		if(!empty($_POST['SCRS_DocDate'])){
			$tdata['U_PC_DDt']=date("Y-m-d", strtotime($_POST['SCRS_DocDate']));	
		}else{
			$tdata['U_PC_DDt']=null;
		}

		$tdata['U_PC_TrNo']=trim(addslashes(strip_tags($_POST['SCRS_TRNo'])));
		$tdata['U_PC_Branch']=trim(addslashes(strip_tags($_POST['SCRS_Branch'])));
		$tdata['U_PC_Loc']=trim(addslashes(strip_tags($_POST['SCRS_Location'])));
		$tdata['U_PC_ICode']=trim(addslashes(strip_tags($_POST['SCRS_ItemCode'])));
		$tdata['U_PC_IName']=trim(addslashes(strip_tags($_POST['SCRS_ItemName'])));
		$tdata['U_PC_BNo']=trim(addslashes(strip_tags($_POST['SCRS_BatchNo'])));
		$tdata['U_PC_BtchQty']=trim(addslashes(strip_tags($_POST['SCRS_BatchQty'])));
		$tdata['U_PC_NCont']=trim(addslashes(strip_tags($_POST['SCRS_TotalNoContainer'])));
		$tdata['U_PC_UTNo']=null;
		$tdata['U_PC_DRev']=null;
		$tdata['U_PC_SIssue']=null;
		$tdata['U_PC_RSIssue']=null;
		$tdata['U_PC_RIssue']=null;
		$tdata['U_PC_RQty']=trim(addslashes(strip_tags($_POST['SCRS_SCD_RetainQty'])));
		$tdata['U_PC_RQtyUom']=trim(addslashes(strip_tags($_POST['SCRS_SCD_RetainQtyUom'])));
		$tdata['U_PC_CntNo1']=trim(addslashes(strip_tags($_POST['SCRS_SCD_Cont1'])));
		$tdata['U_PC_CntNo2']=trim(addslashes(strip_tags($_POST['SCRS_SCD_Cont2'])));
		$tdata['U_PC_CntNo3']=trim(addslashes(strip_tags($_POST['SCRS_SCD_Cont3'])));
		$tdata['U_PC_QtyLab']=trim(addslashes(strip_tags($_POST['SCTS_SCD_QtyforLabel'])));
		$tdata['U_PC_Trans']=null;
		$tdata['U_PC_BLin']=null;
		$tdata['U_PC_BPLId']=trim(addslashes(strip_tags($_POST['SCRS_BPLId'])));
		$tdata['U_PC_LocCode']=trim(addslashes(strip_tags($_POST['SCRS_LocCode'])));

		$mainArray=$tdata;

	// <!-- ------------------------ External Issue row data preparing start here ----------------------- --> 
		for ($i=0; $i <count($_POST['SC_FEXI_SupplierName']) ; $i++) { 

			$ExternalIssue['LineId']=trim(addslashes(strip_tags(($i+1))));
			$ExternalIssue['Object']='SCS_SCRSTAGE';
			$ExternalIssue['U_PC_SCode']=trim(addslashes(strip_tags($_POST['SC_ExternalI_SupplierCode'][$i]))); 
			$ExternalIssue['U_PC_SName']=trim(addslashes(strip_tags($_POST['SC_FEXI_SupplierName'][$i])));
			$ExternalIssue['U_PC_UOM']=trim(addslashes(strip_tags($_POST['SC_FEXI_UOM'][$i])));

			if(!empty($_POST['SC_FEXI_SampleDate'][$i])){
				$ExternalIssue['U_PC_SDt']=date("Y-m-d", strtotime($_POST['SC_FEXI_SampleDate'][$i]));
			}else{
				$ExternalIssue['U_PC_SDt']=null;	
			}
			
			$ExternalIssue['U_PC_Whs']=trim(addslashes(strip_tags($_POST['SC_ExternalI_Warehouse'][$i])));
			$ExternalIssue['U_PC_SQty1']=trim(addslashes(strip_tags($_POST['SC_FEXI_SampleQuantity'][$i])));

			$ExternalIssue['U_PC_Trans']=null;
			$ExternalIssue['U_PC_Attch']=null;

			$ExternalIssue['U_PC_UTxt1']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText1'][$i])));
			$ExternalIssue['U_PC_UTxt2']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText2'][$i])));
			$ExternalIssue['U_PC_UTxt3']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText3'][$i])));

			$mainArray['SCS_SCRSTAGE1Collection'][]=$ExternalIssue;
		}
	// <!-- ------------------------ External Issue row data preparing start here ----------------------- --> 

	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 
		for ($j=0; $j <count($_POST['SC_FEI_SampleQuantity']) ; $j++) { 

			$ExtraIssue['LineId']=trim(addslashes(strip_tags(($j+1))));
			$ExtraIssue['Object']='SCS_SCRSTAGE';
			$ExtraIssue['U_PC_SQty2']=trim(addslashes(strip_tags($_POST['SC_FEI_SampleQuantity'][$j])));
			$ExtraIssue['U_PC_UOM']=trim(addslashes(strip_tags($_POST['SC_FEI_UOM'][$j])));
			$ExtraIssue['U_PC_Whs']=trim(addslashes(strip_tags($_POST['SC_FEI_Warehouse'][$j])));
			$ExtraIssue['U_PC_SBy']=trim(addslashes(strip_tags($_POST['SC_FEI_SampleBy'][$j])));

			if(!empty($_POST['SC_FEI_IssueDate'][$j])){
				$ExtraIssue['U_PC_IDt']=date("Y-m-d", strtotime($_POST['SC_FEI_IssueDate'][$j]));
			}else{
				$ExtraIssue['U_PC_IDt']=null;	
			}

			if(!empty($_POST['SC_FEI_PostExtraIssue'][$j])){
				$ExtraIssue['U_PC_PEIs']=trim(addslashes(strip_tags($_POST['SC_FEI_PostExtraIssue'][$j])));
			}else{
				$ExtraIssue['U_PC_PEIs']=null;
			}
			
			$mainArray['SCS_SCRSTAGE2Collection'][]=$ExtraIssue;
		}
	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 

	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){

			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SCRSTAGE_API.'('.$_POST['SCRS_DocEntry'].')';

			$responce_encode=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($mainArray,$Final_API);
			$responce=json_decode($responce_encode);

			if($responce==''){
				$data['status']='True';
				$data['DocEntry']=$_POST['SCRS_DocEntry'];
				$data['message']="Sample Collection Route Stage Successfully Update.";
				echo json_encode($data);
			}else{

				if(array_key_exists('error', (array)$responce)){
					$data['status']='False';
					$data['DocEntry']='';
					$data['message']=$responce->error->message->value;
					echo json_encode($data);
				}
			}
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	//<!-- ------------- function & function responce code end Here ---- -->
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='getItemDropdown_ajax')
{
	$Final_API=$STABILITYITEMLIST_API;

	$response=$obj->GetItemDropdown($Final_API);
	echo ($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='getItemSingleData_ajax')
{
	$itemCode=trim(addslashes(strip_tags($_POST['itemCode'])));
	$Final_API=$STABILITYITEMLIST_API.'?ItemCode='.$itemCode;
	// print_r($Final_API);
	// die();
	$response=$obj->get_OTFSI_SingleData($Final_API);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='getStabilityTypeDropdown_ajax')
{
	$Final_API=$STABILITYPLANSTYPE_API;

	$response=$obj->GetStabilityTypeDropdown($Final_API);
	echo ($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='getStabilityConditionAndTimePeriodDropdown_ajax')
{
	$StabilityType=trim(addslashes(strip_tags($_POST['StabilityType'])));
	$Final_API1=$STABILITYPLANSCONDITION_API.'?StabType='.$StabilityType;
	$Final_API = str_replace(' ', '%20', $Final_API1); // All blank space replace to %20

	$response=$obj->get_OTFSI_SingleData($Final_API);
	sort($response);
	$output=array();

		$output['StabilityCondition'].='<option value="">Select Stability Condition</option>';
		for ($i=0; $i <count($response) ; $i++) { 
			$output['StabilityCondition'].='<option value="'.$response[$i]->Condition.'">'.$response[$i]->Condition.'</option>';
		}
	
		// <!-- -------------------  TimePeriod dropdown prepare start here ------------------------ -->

			$array_unique = array();
			for ($a=0; $a <count($response) ; $a++) { 
				$array_unique[]=$response[$a]->TimePeriod;
			}

			$unique_randum=array_unique($array_unique);
			$unique = array_values($unique_randum);
			sort($unique);

			$output['TimePeriod'].='<option value="">Select Time Period</option>';
			for ($i=0; $i < count($unique) ; $i++) { 
				$output['TimePeriod'] .= '<option value="'.$unique[$i].'">'.$unique[$i].'</option>';
			} 
		// <!-- -------------------  TimePeriod dropdown prepare start here ------------------------ -->

	echo json_encode($output);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='getBatchDropdown_ajax')
{
	$itemCode=trim(addslashes(strip_tags($_POST['itemCode'])));
	$Final_API=$STABILITYBATCHNOLIST_API.'?ItemCode='.$itemCode;
	
	$response=$obj->get_OTFSI_SingleData($Final_API);

	$option.='<option value="">Select Batch</option>';
	if(!empty($response)){
		for ($i=0; $i <count($response) ; $i++) { 
			$option.='<option value="'.$response[$i]->LotNo.'">'.$response[$i]->LotNo.'</option>';
		}
	}
	
	echo $option;
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='getBatchAllData_ajax')
{
	$itemCode=trim(addslashes(strip_tags($_POST['itemCode'])));
	$batchNo=trim(addslashes(strip_tags($_POST['batchNo'])));
	$Final_API=$STABILITYBATCHNOLIST_API.'?ItemCode='.$itemCode.'&BatchNo='.$batchNo;

	$response=$obj->get_OTFSI_SingleData($Final_API);

	echo json_encode($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='getStationNoDropdown_ajax')
{
	$Final_API=$STABILITYPLANSSTATION_API;

	$response=$obj->get_OTFSI_SingleData($Final_API);

	$option.='<option value="">Select Station No</option>';
	for ($i=0; $i <count($response) ; $i++) { 
		if(!empty($response[$i]->Name)){
			$option.='<option value="'.$response[$i]->Name.'">'.$response[$i]->Name.'</option>';
		}
	}
	
	echo $option;
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='getTypeOfAnalysis_ajax')
{
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res=$obj->SAP_Login();  // SAP Service Layer Login Here

	if(!empty($res)){
		$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_ANALYSIS_API;

		$responce_encode=$obj->getFunctionServiceLayer($Final_API);
		$responce=json_decode($responce_encode);

		$option.='<option value="">Select Type of Analysis</option>';
		for ($i=0; $i <count($responce->value) ; $i++) { 
			$option .= '<option value="'.$responce->value[$i]->Code.'">'.$responce->value[$i]->Name.'</option>';
		}
	}
	
	$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	print_r($option);
	exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='addStabilityPlanNewRow_ajax'){
	$un_id=(trim(addslashes(strip_tags($_POST['un_id']))))+1;

	$option.='<tr id="'.$un_id.'">
        <td class="desabled"><input  type="text" id="" name="" class="form-control desabled" value="'.$un_id.'." readonly style="border:1px solid #efefef !important;"></td>
        <td class=""><select class="form-select focusCSS" id="StationNo'.$un_id.'" name="StationNo[]" onchange="selectSationNo('.$un_id.');" style="width: 140px;border: 1px solid white;"></select></td>
        <td class=""><input type="text" id="SampleQty'.$un_id.'" name="SampleQty[]" class="form-control" ></td>
        <td class=""><input type="text" id="SampleQtyUOM'.$un_id.'" name="SampleQtyUOM[]" class="form-control" ></td>
        <td class=""><input type="text" id="SampleQtyAsPerOrgBatchUOM'.$un_id.'" name="SampleQtyAsPerOrgBatchUOM[]" class="form-control" ></td>
        <td class=""><select class="form-select focusCSS" id="TypeOfAnalysis'.$un_id.'" name="TypeOfAnalysis[]" style="width: 170px;border: 1px solid white;"></select></td>
        <td class=""><input type="text" id="RefPageNO'.$un_id.'" name="RefPageNO[]" class="form-control" ></td>
        <td class=""><input type="text" id="RefProtocolNo'.$un_id.'" name="RefProtocolNo[]" class="form-control" ></td>
        <td class=""><input type="date" id="StabilityDate'.$un_id.'" name="StabilityDate[]" class="form-control" ></td>

		<td class=""><input type="text" id="LoadingAnalyst'.$un_id.'" name="LoadingAnalyst[]" class="form-control" ></td>
		<td class=""><input type="date" id="WithdrawalDate1'.$un_id.'" name="WithdrawalDate[]" value="'.date('Y-m-d').'" class="form-control" ></td>
		<td class=""><input type="text" id="WithdrawalAnalyst'.$un_id.'" name="WithdrawalAnalyst[]" class="form-control" ></td>
		<td class=""><input type="text" id="ChamberID'.$un_id.'" name="ChamberID[]" class="form-control" ></td>
		<td class=""><input type="text" id="TrayID'.$un_id.'" name="TrayID[]" class="form-control" ></td>
		<td class=""><input type="text" id="UserText5'.$un_id.'" name="UserText5[]" class="form-control" ></td>

    </tr>';
	echo $option;
	exit(0);
}

if(isset($_POST['StabilityPlanBtn'])){
	$mainArray=array();
	$tadat=array();
	$RowLevel=array();
	$data=array(); // function and validation responce hold on this array

	// <!-- ---------------------- Stability Plan All Validation Start Here ------------------------------------------ -->
		if($_POST['ItemCode']==''){
			$data['status']='False';$data['DocEntry']='';$data['message']="Item Code Selection Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if($_POST['BatchNo']==''){
			$data['status']='False';$data['DocEntry']='';$data['message']="Batch No Selection Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if($_POST['ExtraSampleQty']==''){
			$data['status']='False';$data['DocEntry']='';$data['message']="Extra Sample Qty Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if($_POST['UOM']==''){
			$data['status']='False';$data['DocEntry']='';$data['message']="UOM Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if($_POST['StabilityType']==''){
			$data['status']='False';$data['DocEntry']='';$data['message']="Stability Type Selection Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if($_POST['StabilityCondition']==''){
			$data['status']='False';$data['DocEntry']='';$data['message']="Stability Condition Selection Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if($_POST['TimePeriod']==''){
			$data['status']='False';$data['DocEntry']='';$data['message']="Time Period Selection Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if(count($_POST['StationNo'])==1){
			$data['status']='False';$data['DocEntry']='';$data['message']="Pls. Fill Row Level Data.";
			echo json_encode($data);
			exit(0);
		}
	// <!-- ---------------------- Stability Plan All Validation End Here -------------------------------------------- -->
	
	$tdata['Object']='SCS_STAB';
	$tdata['Series']=trim(addslashes(strip_tags($_POST['DocNoName'])));
	$tdata['U_PC_ICode']=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$tdata['U_PC_IName']=trim(addslashes(strip_tags($_POST['ItemName'])));
	$tdata['U_PC_ESQty']=trim(addslashes(strip_tags($_POST['ExtraSampleQty'])));
	$tdata['U_PC_ESUoM']=trim(addslashes(strip_tags($_POST['UOM'])));
	$tdata['U_PC_StbTyp']=trim(addslashes(strip_tags($_POST['StabilityType'])));
	$tdata['U_PC_StbCon']=trim(addslashes(strip_tags($_POST['StabilityCondition'])));
	$tdata['U_PC_TPer']=trim(addslashes(strip_tags($_POST['TimePeriod'])));
	$tdata['U_PC_BtchQty']=trim(addslashes(strip_tags($_POST['b_qty'])));
	$tdata['U_PC_LDate']=trim(addslashes(strip_tags($_POST['LoadingDate'])));
	$tdata['U_PC_InvUoM']=trim(addslashes(strip_tags($_POST['InventoryUom'])));
	$tdata['U_PC_UTxt2']=trim(addslashes(strip_tags($_POST['BatchNo'])));
	$tdata['Remark']=trim(addslashes(strip_tags($_POST['Remarks'])));

	$mainArray=$tdata;

	// <!-- ------------------------ Row Level Data Preparing Start Here --------------------------------------------------------- --> 
		for ($i=0; $i <(count($_POST['StationNo'])-1) ; $i++) { 
			$RowLevel['LineId']=trim(addslashes(strip_tags(($i+1))));

			if($_POST['StationNo'][$i]==''){
				$data['status']='False';
				$data['DocEntry']='';
				$data['message']="Station No Mandatory - Line Number ".($i+1).".";
				echo json_encode($data);
				exit(0);
			}else{
				$RowLevel['U_PC_StNo']=trim(addslashes(strip_tags($_POST['StationNo'][$i]))); 
			}

			$RowLevel['U_PC_SQty']=trim(addslashes(strip_tags($_POST['SampleQty'][$i])));
			$RowLevel['U_PC_SQUom']=trim(addslashes(strip_tags($_POST['SampleQtyUOM'][$i])));
			$RowLevel['U_PC_SBQty']=trim(addslashes(strip_tags($_POST['SampleQtyAsPerOrgBatchUOM'][$i])));
			$RowLevel['U_PC_TAna']=trim(addslashes(strip_tags($_POST['TypeOfAnalysis'][$i]))); 
			$RowLevel['U_PC_RPge']=trim(addslashes(strip_tags($_POST['RefPageNO'][$i])));
			$RowLevel['U_PC_RPrNo']=trim(addslashes(strip_tags($_POST['RefProtocolNo'][$i])));
			$RowLevel['U_PC_StDt']=(!empty($_POST['StabilityDate'][$i])) ? date('Y-m-d', strtotime($_POST['StabilityDate'][$i])) : null;
			$RowLevel['U_PC_UTxt1']=trim(addslashes(strip_tags($_POST['LoadingAnalyst'][$i])));
			$RowLevel['U_PC_UTxt2']=trim(addslashes(strip_tags($_POST['WithdrawalAnalyst'][$i])));
			$RowLevel['U_PC_UTxt3']=trim(addslashes(strip_tags($_POST['ChamberID'][$i])));
			$RowLevel['U_PC_UTxt4']=trim(addslashes(strip_tags($_POST['TrayID'][$i])));
			$RowLevel['U_PC_UTxt5']=trim(addslashes(strip_tags($_POST['UserText5'][$i])));
			$RowLevel['U_WtDate']=(!empty($_POST['WithdrawalDate'][$i])) ? date('Y-m-d', strtotime($_POST['WithdrawalDate'][$i])) : null;

			$mainArray['SCS_STAB1Collection'][]=$RowLevel;
		}
	// <!-- ------------------------ Row Level Data Preparing End Here ----------------------------------------------------------- -->

	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_STAB_API;
			
			$responce_encode=$obj->SaveSampleIntimation($mainArray,$Final_API); // sample intimation save here
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();

				if($responce->DocNum!=""){
					$data['status']='True';
					$data['DocEntry']=$responce->DocEntry;
					$data['message']="Stability Plan Successfully Added.";
					echo json_encode($data);
				}else{
					if(array_key_exists('error', (array)$responce)){
						$data['status']='False';
						$data['DocEntry']='';
						$data['message']=$responce->error->message->value;
						echo json_encode($data);
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='OT_SC_popup')
{
	$API=$OPENTRANSQCDOCSTABILITY_API.'&DocEntry='.$_POST['DocEntry'].'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&SampleColNo='.$_POST['SampleCollectionNo'];

	// <!-- ------- Replace blank space to %20 start here -------- -->
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='OT_sample_intimationStability_popup'){
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$API=$OPENTRANSSAMPINTSTABILITY_API.'&DocEntry='.$_POST['DocEntry'].'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'];
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['OP_SampleIntimationBtn'])){
	$tdata=array(); // This array send to AP Standalone Invoice process 

	$tdata['Series']=trim(addslashes(strip_tags($_POST['SIS_P_DocNoName'])));
	$tdata['Remark']=null;
	$tdata['Object']='SCS_SISTAB';
	$tdata['U_PC_BLin']=null;
	$tdata['U_PC_BPLId']=trim(addslashes(strip_tags($_POST['SIS_P_BPLId'])));
	$tdata['U_PC_LCode']=trim(addslashes(strip_tags($_POST['SIS_P_LocCode'])));
	$tdata['U_PC_RNo']=trim(addslashes(strip_tags($_POST['SIS_P_ReceiptNo'])));
	$tdata['U_PC_REnt']=trim(addslashes(strip_tags($_POST['SIS_P_ReceiptEntry'])));
	$tdata['U_PC_WoNo']=trim(addslashes(strip_tags($_POST['SIS_P_WONo'])));
	$tdata['U_PC_WoEnt']=trim(addslashes(strip_tags($_POST['SIS_P_WODocEntry'])));
	$tdata['U_PC_SType']=trim(addslashes(strip_tags($_POST['SIS_P_SampleType'])));
	$tdata['U_PC_TRBy']=trim(addslashes(strip_tags($_POST['SIS_P_TrBy'])));
	$tdata['U_PC_ICode']=trim(addslashes(strip_tags($_POST['SIS_P_ItemCode'])));
	$tdata['U_PC_IName']=trim(addslashes(strip_tags($_POST['SIS_P_ItemName'])));
	$tdata['U_PC_RcQty']=trim(addslashes(strip_tags($_POST['SIS_P_ReciptNo'])));
	$tdata['U_PC_Unit']=trim(addslashes(strip_tags($_POST['SIS_P_Unit'])));
	$tdata['U_PC_TNCont']=trim(addslashes(strip_tags($_POST['SIS_P_TotalNoofContainer'])));
	$tdata['U_PC_TNCont1']=trim(addslashes(strip_tags($_POST['SIS_P_QtyPerContainer'])));
	$tdata['U_PC_FCont']=trim(addslashes(strip_tags($_POST['SIS_P_FromContainer'])));
	$tdata['U_PC_TCont']=trim(addslashes(strip_tags($_POST['SIS_P_ToContainer'])));
	$tdata['U_PC_BNo']=trim(addslashes(strip_tags($_POST['SIS_P_BatchNo'])));
	$tdata['U_PC_BQty']=trim(addslashes(strip_tags($_POST['SIS_P_BatchQty'])));
	$tdata['U_PC_Branch']=trim(addslashes(strip_tags($_POST['SIS_P_Branch'])));
	$tdata['U_PC_Loc']=trim(addslashes(strip_tags($_POST['SIS_P_Location'])));
	$tdata['U_PC_StType']=trim(addslashes(strip_tags($_POST['SIS_P_StabilityType'])));
	$tdata['U_PC_StCon']=trim(addslashes(strip_tags($_POST['SIS_P_StabilityCondition'])));
	$tdata['U_PC_StTPer']=trim(addslashes(strip_tags($_POST['SIS_P_StabilityTimePeriod'])));
	$tdata['U_PC_AnType']=trim(addslashes(strip_tags($_POST['SIS_P_AnalysisType'])));
	$tdata['U_PC_CNos']=trim(addslashes(strip_tags($_POST['SIS_P_ContainerNos'])));
	$tdata['U_PC_Cont']=trim(addslashes(strip_tags($_POST['SIS_P_Container'])));
	$tdata['U_PC_UTTrans']=null;
	$tdata['U_PC_WhsCode']=trim(addslashes(strip_tags($_POST['SIS_P_WhsCode'])));
	$tdata['U_PC_BEnt']=trim(addslashes(strip_tags($_POST['SIS_P_BaseEntry'])));
	$tdata['U_PC_BNum']=trim(addslashes(strip_tags($_POST['SIS_P_BaseNum'])));
	$tdata['U_PC_StDNo']=trim(addslashes(strip_tags($_POST['SIS_P_StabilityPlanDocNum'])));
	$tdata['U_PC_StDEnt']=trim(addslashes(strip_tags($_POST['SIS_P_StabilityPlanDocEntry'])));
	$tdata['U_PC_StQty']=trim(addslashes(strip_tags($_POST['SIS_P_StabilityPlanQuantity'])));
	$tdata['U_PC_MakeBy']=trim(addslashes(strip_tags($_POST['SIS_P_MakeBy'])));

	// ---------------------------------Date Var Prepare Start Here ------------------------------------
		if(!empty($_POST['SIS_P_MfgDate'])){
			$tdata['U_PC_MfgDt']=date('Y-m-d', strtotime($_POST['SIS_P_MfgDate']));
		}else{
			$tdata['U_PC_MfgDt']='';
		}

		if(!empty($_POST['SIS_P_ExpiryDate'])){
			$tdata['U_PC_ExpDt']=date('Y-m-d', strtotime($_POST['SIS_P_ExpiryDate']));
		}else{
			$tdata['U_PC_ExpDt']='';
		}

		if(!empty($_POST['SIS_P_TrDate'])){
			$tdata['U_PC_TRDte']=date('Y-m-d', strtotime($_POST['SIS_P_TrDate']));
		}else{
			$tdata['U_PC_TRDte']='';
		}

		if(!empty($_POST['SIS_P_StabilityLoadingDate'])){
			$tdata['U_PC_StDt']=date('Y-m-d', strtotime($_POST['SIS_P_StabilityLoadingDate']));
		}else{
			$tdata['U_PC_StDt']='';
		}
	// ---------------------------------Date Var Prepare End Here   ------------------------------------

	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SISTAB_API;
			
			$responce_encode=$obj->SaveSampleIntimation($tdata,$Final_API); // sample intimation save here
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();

				if($responce->DocNum!=""){

					$data['status']='True';
					$data['DocEntry']=$responce->DocEntry;
					$data['message']="Sample Intimation (Transfer Request) - Stability Successfully Added.";
					echo json_encode($data);
				}else{
					if(array_key_exists('error', (array)$responce)){
						$data['status']='False';
						$data['DocEntry']='';
						$data['message']=$responce->error->message->value;
						echo json_encode($data);
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='sample_intimation_stability_ajax')
{
	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));

	$API=$STABSAMPINTIAFTERADD_API.'?DocEntry='.$DocEntry;

	// <!-- ------- Replace blank space to %20 start here -------- -->
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='OpenInventoryTransferSIS_ajax'){

	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$WareHouse=trim(addslashes(strip_tags($_POST['WareHouse'])));
	$BatchNo=trim(addslashes(strip_tags($_POST['BatchNo'])));
	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));

	// <!--------------- Preparing API Start Here ------------------------------------------ -->
		$API=$STABILITYSAMINTICONTSEL_API.'?ItemCode='.$ItemCode.'&WareHouse='.$WareHouse.'&BatchNo='.$BatchNo.'&DocEntry='.$DocEntry;
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!--------------- Preparing API End Here ------------------------------------------ -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
		if(!empty($response)){

			for ($i=0; $i <count($response) ; $i++) { 

				if(!empty($response[$i]->ExpDate)){
					$ExpiryDate=date("d-m-Y", strtotime($response[$i]->ExpDate));
				}else{
					$ExpiryDate='';
				}

				if(!empty($response[$i]->MfgDate)){
					$MfgDate=date("d-m-Y", strtotime($response[$i]->MfgDate));
				}else{
					$MfgDate='';
				}

				$option.='<tr>
					<td style="text-align: center;">
						<input type="hidden" id="usercheckList'.$i.'" name="usercheckList[]" value="0">
						<input class="form-check-input" type="checkbox" value="'.$response[$i]->BatchQty.'" id="itp_CS'.$i.'" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener('.$i.')">
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ItemCode'.$i.'" name="itp_ItemCode[]" class="form-control" value="'.$response[$i]->ItemCode.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ItemName'.$i.'" name="itp_ItemName[]" class="form-control" value="'.$response[$i]->ItemName.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ContainerNo'.$i.'" name="itp_ContainerNo[]" class="form-control" value="'.$response[$i]->ContainerNo.'" readonly>
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_Batche'.$i.'" name="itp_Batch[]" class="form-control" value="'.$response[$i]->BatchNum.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_BatchQty'.$i.'" name="itp_BatchQty[]" class="form-control" value="'.$response[$i]->BatchQty.'" readonly>
					</td>
					<td>
						<input class="border_hide" type="text" id="SelectedQty'.$i.'" name="SelectedQty[]" class="form-control" value="'.$response[$i]->BatchQty.'" onfocusout="EnterQtyValidation('.$i.')">
					</td>
					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_MfgDate'.$i.'" name="itp_MfgDate[]" class="form-control" value="'.$MfgDate.'" readonly>
					</td>

					<td class="desabled">
						<input class="border_hide textbox_bg" type="text" id="itp_ExpiryDate'.$i.'" name="itp_ExpiryDate[]" class="form-control" value="'.$ExpiryDate.'" readonly>
					</td>
				</tr>';
			}

			$option.='<tr>
				<td colspan="6"></td>
				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="cs_selectedQtySum" name="cs_selectedQtySum" class="form-control" value="0.000000" readonly></td>
				<td colspan="2"></td>
			</tr>';
		}else{
			$option='<tr><td colspan="9" style="text-align: center;color:red;">Record Not Found</td></tr>';
		}
	// <!-- --------- Item HTML Table Body Prepare End Here -------------------------------- --> 
	echo json_encode($option);
	exit(0);
}


if(isset($_POST['SubSIS_IT_Btn']))
{	
	$mainArray=array(); // This array hold all type of declare array
	$tdata=array(); //This array hold header data
	$item=array(); //This array hold item data
	$batch=array(); //This array hold batch data

	$tdata['Series']=trim(addslashes(strip_tags($_POST['SIS_IT_SeriesName'])));
	$tdata['DocDate']=date("Y-m-d", strtotime($_POST['SIS_IT_PostingDate']));
	$tdata['DueDate']=date("Y-m-d", strtotime($_POST['SIS_IT_DocumentDate']));
	$tdata['CardCode']=trim(addslashes(strip_tags($_POST['SIS_IT_SupplierCode'])));
	$tdata['Comments']=null;
	$tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['SIS_ITI_FromWhs'])));
	$tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['SIS_ITI_ToWhs'])));
	$tdata['TaxDate']=date("Y-m-d", strtotime($_POST['SIS_IT_DocumentDate']));
	$tdata['DocObjectCode']=trim(addslashes(strip_tags('67')));
	$tdata['BPLID']=trim(addslashes(strip_tags($_POST['SIS_IT_BPLId'])));
	$tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['SIS_IT_DocEntry'])));
	$tdata['U_BFType']=trim(addslashes(strip_tags($_POST['SIS_IT_BaseDocType'])));

	$mainArray=$tdata;

	// --------------------- Item and batch row data preparing start here -------------------------------- -->
		$item['LineNum']=trim(addslashes(strip_tags('0')));
		$item['ItemCode']=trim(addslashes(strip_tags($_POST['SIS_ITI_ItemCode'])));
		$item['WarehouseCode']=trim(addslashes(strip_tags($_POST['SIS_ITI_ToWhs'])));
		$item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST['SIS_ITI_FromWhs'])));
		$item['Quantity']=trim(addslashes(strip_tags($_POST['SIS_ITI_Quality'])));

		// <!-- Item Batch row data prepare start here ----------- -->
			$BL=0;
			for ($i=0; $i <count($_POST['usercheckList']) ; $i++) { 

				if($_POST['usercheckList'][$i]=='1'){

					$batch['BatchNumber']=trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
					$batch['Quantity']=trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
					$batch['BaseLineNumber']=trim(addslashes(strip_tags('0')));
					$batch['ItemCode']=trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));

					$item['BatchNumbers'][]=$batch;
					$BL++;
				}
			}
		// <!-- Item Batch row data prepare end here ------------- -->
		$mainArray['StockTransferLines'][]=$item;
	// --------------------- Item and batch row data preparing end here ---------------------------------- -->

	// echo '<pre>';
	// print_r(json_encode($mainArray));
	// die();

	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_StockTransfers;

			$responce_encode=$obj->SaveSampleIntimation($mainArray,$Final_API);
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();
				if(array_key_exists('error', (array)$responce)){
					$data['status']='False-1';
					$data['DocEntry']='';
					$data['message']=$responce->error->message->value;
					echo json_encode($data);
				}else{

					// <!-- ------- row data preparing start here --------------------- -->
						$UT_data=array();
						$UT_data['U_PC_UTTrans']=trim(addslashes(strip_tags($responce->DocEntry)));
					// <!-- ------- row data preparing end here ----------------------- -->

					$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SISTAB_API.'('.$_POST['SIS_IT_DocEntry'].')';
					$underTestNumber=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data,$Final_API2);
					$underTestNumber_decode=json_decode($underTestNumber);

					if($underTestNumber_decode==''){
						$data['status']='True';
						$data['DocEntry']=$responce->DocEntry;
						$data['message']="Sample Intimation Stability Inventory Transfer Successfully Added.";
						echo json_encode($data);
					}else{
						
						if(array_key_exists('error', (array)$underTestNumber_decode)){
							$data['status']='False-2';
							$data['DocEntry']='';
							$data['message']=$responce->error->message->value;
							$data['error_abc']=$underTestNumber_decode;
							echo json_encode($data);
						}
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='OTS_Sample_Collection_popup')
{
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$API=$OPENTRANSSAMPCOLSTABILITY_API.'&DocEntry='.$_POST['DocEntry'].'&ItemCode='.$_POST['ItemCode'].'&BatchNo='.$_POST['BatchNo'];
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}

if(isset($_POST['OTSCSP_Btn'])){
	$tdata=array(); // This array send to AP Standalone Invoice process 

	$tdata['Remark']=null;
	$tdata['U_PC_BLin']=null;
	$tdata['U_PC_TrNo']=null;
	$tdata['U_PC_DRev']=null;
	$tdata['U_PC_SIssue']=null;
	$tdata['U_PC_RSIssue']=null;
	$tdata['U_PC_RIssue']=null;
	$tdata['U_PC_RQty']=null;
	$tdata['U_PC_RQtyUom']=null;
	$tdata['U_PC_CntNo1']=null;
	$tdata['U_PC_CntNo2']=null;
	$tdata['U_PC_CntNo3']=null;
	$tdata['U_PC_QtyLab']=null;
	$tdata['U_PC_Trans']=null;
	$tdata['U_PC_StDt']=null;

	$tdata['Object']='SCS_SCOLSTAB';
	$tdata['Series']=trim(addslashes(strip_tags($_POST['OTSCP_DocNoName'])));
	$tdata['U_PC_BPLId']=trim(addslashes(strip_tags($_POST['OTSCP_BPLId'])));
	$tdata['U_PC_LocCode']=trim(addslashes(strip_tags($_POST['OTSCP_LocCode'])));
	$tdata['U_PC_InType']=trim(addslashes(strip_tags($_POST['OTSCP_IngredientsType'])));
	$tdata['U_PC_WoNo']=trim(addslashes(strip_tags($_POST['OTSCP_WONo'])));
	$tdata['U_PC_WoEnt']=trim(addslashes(strip_tags($_POST['OTSCP_WODocEntry'])));
	$tdata['U_PC_RNo']=trim(addslashes(strip_tags($_POST['OTSCP_ReceiptNo'])));
	$tdata['U_PC_REnt']=trim(addslashes(strip_tags($_POST['OTSCP_ReceiptEntry'])));
	$tdata['U_PC_Loc']=trim(addslashes(strip_tags($_POST['OTSCP_Location'])));
	$tdata['U_PC_Branch']=trim(addslashes(strip_tags($_POST['OTSCP_Branch'])));
	$tdata['U_PC_InBy']=trim(addslashes(strip_tags($_POST['OTSCP_IntimatedBy'])));
	$tdata['U_PC_SUnit']=trim(addslashes(strip_tags($_POST['OTSCP_Unit'])));
	$tdata['U_PC_SClBy']=trim(addslashes(strip_tags($_POST['OTSCP_SampleCollectBy'])));
	$tdata['U_PC_ARNo']=trim(addslashes(strip_tags($_POST['OTSCP_ARNo'])));
	$tdata['U_PC_ICode']=trim(addslashes(strip_tags($_POST['OTSCP_ItemCode'])));
	$tdata['U_PC_IName']=trim(addslashes(strip_tags($_POST['OTSCP_ItemName'])));
	$tdata['U_PC_BNo']=trim(addslashes(strip_tags($_POST['OTSCP_BatchNo'])));
	$tdata['U_PC_BtchQty']=trim(addslashes(strip_tags($_POST['OTSCP_BatchQty'])));
	$tdata['U_PC_NCont']=trim(addslashes(strip_tags($_POST['OTSCP_TotalNoofContainer'])));
	$tdata['U_PC_UTNo']=trim(addslashes(strip_tags($_POST['OTSCP_UnderTestTransferNo'])));
	$tdata['U_PC_StType']=trim(addslashes(strip_tags($_POST['OTSCP_StabilityType'])));
	$tdata['U_PC_StCon']=trim(addslashes(strip_tags($_POST['OTSCP_StabilityCondition'])));
	$tdata['U_PC_StTPer']=trim(addslashes(strip_tags($_POST['OTSCP_StabilityTimePeriod'])));
	$tdata['U_PC_AnType']=trim(addslashes(strip_tags($_POST['OTSCP_AnalysisType'])));
	$tdata['U_PC_WhsCode']=trim(addslashes(strip_tags($_POST['OTSCP_WhsCode'])));
	$tdata['U_PC_BEnt']=trim(addslashes(strip_tags($_POST['OTSCP_BaseEntry'])));
	$tdata['U_PC_BNum']=trim(addslashes(strip_tags($_POST['OTSCP_BaseNum'])));
	$tdata['U_PC_StDNo']=trim(addslashes(strip_tags($_POST['OTSCP_StabilityPlanDocNum'])));
	$tdata['U_PC_StDEnt']=trim(addslashes(strip_tags($_POST['OTSCP_StabilityPlanDocEntry'])));
	$tdata['U_PC_StQty']=trim(addslashes(strip_tags($_POST['OTSCP_StabilityPlanQuantity'])));
	$tdata['U_PC_MakeBy']=trim(addslashes(strip_tags($_POST['OTSCP_MakeBy'])));
	$tdata['U_PC_DDt']=(!empty($_POST['OTSCP_DocDate'])) ? trim(addslashes(strip_tags($_POST['OTSCP_DocDate']))) : null;
	$tdata['U_PC_InDt']=(!empty($_POST['OTSCP_IntimatedDate'])) ? date("Y-m-d", strtotime($_POST['OTSCP_IntimatedDate'])) : null;
	$tdata['U_PC_MnfDt']=(!empty($_POST['OTSCP_MfgDate'])) ? trim(addslashes(strip_tags($_POST['OTSCP_MfgDate']))) : null;
	$tdata['U_PC_ExpDt']=(!empty($_POST['OTSCP_ExpiryDate'])) ? trim(addslashes(strip_tags($_POST['OTSCP_ExpiryDate']))) : null;

	// <!-- ---------------------- Open transaction for sample collection stability popup validation start Here ------------------ -->
		if(empty($_POST['OTSCP_SampleCollectBy'])){
			$data['status']='False';$data['DocEntry']='';
			$data['message']="Sample Collect By Mandatory.";
			echo json_encode($data);
			exit(0);
		}

		if(empty($_POST['OTSCP_DocDate'])){
			$data['status']='False';$data['DocEntry']='';
			$data['message']="Document Date Mandatory.";
			echo json_encode($data);
			exit(0);
		}
	// <!-- ---------------------- Open transaction for sample collection stability popup validation end Here -------------------- -->

	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SCOLSTAB_API;

			$responce_encode=$obj->SaveSampleIntimation($tdata,$Final_API); // sample intimation save here
			$responce=json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				$data=array();

				if($responce->DocNum!=""){
					$data['status']='True';
					$data['DocEntry']=$responce->DocEntry;
					$data['message']="Open Transaction For Sample Collection Stability Successfully Added.";
					echo json_encode($data);
				}else{
					if(array_key_exists('error', (array)$responce)){
						$data['status']='False';
						$data['DocEntry']='';
						$data['message']=$responce->error->message->value;
						echo json_encode($data);
					}
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	//<!-- ------------- function & function responce code end Here ---- -->
}

if(isset($_POST['action']) && $_POST['action'] =='sample_collection_stability_ajax')
{	

	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));
	// $rowCount=trim(addslashes(strip_tags($_POST['rowCount'])));
	// $rowCount_N=trim(addslashes(strip_tags($_POST['rowCount_N'])));

	// <!-- ------- Replace blank space to %20 start here -------- -->
		$API=$STABSAMPCOLAFTERADD_API.'?DocEntry='.$DocEntry;
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);

	// <!-- ------ Array declaration Start Here --------------------------------- -->
		$FinalResponce=array();
		$FinalResponce['SampleCollDetails']=$response;
	// <!-- ------ Array declaration End Here  --------------------------------- -->

	// $ExtraIssue=$response[0]->StabSampColExtraDetails; // Etra issue response seperate here 
	// $ExternalIssue=$response[0]->StabSampColExternalDetails; //External issue reponce seperate here
	
	// =============================================================================================================
		// <!-- ----------- Extra Issue Start here --------------------------------- -->
			// if(!empty($ExtraIssue)){
			// 	for ($i=0; $i <count($ExtraIssue) ; $i++) { 
			// 		// $SrNo=$i+1;
			// 		$SrNo=$rowCount_N+1+$i;

			// 		if(!empty($ExtraIssue[$i]->IssueDate)){
			// 			$IssueDate=date("d-m-Y", strtotime($ExtraIssue[$i]->IssueDate));
			// 		}else{
			// 			$IssueDate='';
			// 		}

			// 		$FinalResponce['ExtraIssue'].='<tr>
			// 		    <td>
			// 		    	<input type="radio" id="ExtraIslist'.$SrNo.'" name="ExtraIslistRado" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExtraIssue('.$SrNo.')">
			// 		    </td>

			// 		    <td class="desabled">
			// 		    	<input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control desabled" readonly>

			// 		    	<input class="border_hide desabled" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->SampleQuantity.'" class="form-control desabled" readonly>
			// 	    	</td>

			// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM.'" class="form-control desabled" readonly></td>

			// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_FEI_Warehouse[]" value="'.$ExtraIssue[$i]->Warehouse.'" class="form-control desabled" readonly></td>

			// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control desabled" readonly></td>

			// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control desabled" readonly></td>

			// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control desabled" readonly></td>
			// 		 </tr>';
			// 	}
			// 	// when table data come then default add one manual row start ---------------------------------------------------------
			// 	$SrNo=(count($ExtraIssue)+1);
			// 	$FinalResponce['ExtraIssue'].='<tr>
			// 	    <td class="desabled"></td>

			// 	    <td>
			// 		    <input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control" readonly>

			// 		    <input class="border_hide" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->SampleQuantity.'" class="form-control">
			// 	    </td>

			// 	    <td>
			// 	    	<input class="border_hide" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM.'" class="form-control">
			//     	</td>

			// 	    <td>
			// 	    	<select class="form-control SC_FEI_WarehouseWithData" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_FEI_Warehouse[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;">
			// 			</select>
			//     	</td>

			// 	    <td>
			// 	    	<input class="border_hide" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control">
			//     	</td>

			// 	    <td>
			// 	    	<input class="border_hide" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control">
			//     	</td>

			// 	    <td>
			// 	    	<input class="border_hide" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control">
			//     	</td>
			// 	 </tr>';


			// }else{
			// 	$SrNo=$rowCount_N+1;
			// 	$FinalResponce['ExtraIssue'].='<tr>
			// 	    <td class="desabled"></td>

			// 	    <td>
			// 		    <input class="border_hide" type="hidden" id="SC_FEI_Linenum'.$SrNo.'" name="SC_FEI_Linenum[]" value="'.$ExtraIssue[$i]->LineNum.'" class="form-control" readonly>

			// 		    <input class="border_hide" type="text" id="SC_FEI_SampleQuantity'.$SrNo.'" name="SC_FEI_SampleQuantity[]" value="'.$ExtraIssue[$i]->SampleQuantity.'" class="form-control">
			// 	    </td>

			// 	    <td>
			// 	    	<input class="border_hide" type="text" id="SC_FEI_UOM'.$SrNo.'" name="SC_FEI_UOM[]" value="'.$ExtraIssue[$i]->UOM.'" class="form-control">
			//     	</td>

			// 	    <td>
			// 	    	<select class="form-control SC_FEI_WarehouseWithData" id="SC_FEI_Warehouse'.$SrNo.'" name="SC_FEI_Warehouse[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;">
			// 			</select>
			//     	</td>

			// 	    <td>
			// 	    	<input class="border_hide" type="text" id="SC_FEI_SampleBy'.$SrNo.'" name="SC_FEI_SampleBy[]" value="'.$ExtraIssue[$i]->SampleBy.'" class="form-control">
			//     	</td>

			// 	    <td>
			// 	    	<input class="border_hide" type="text" id="SC_FEI_IssueDate'.$SrNo.'" name="SC_FEI_IssueDate[]" value="'.$IssueDate.'" class="form-control">
			//     	</td>

			// 	    <td>
			// 	    	<input class="border_hide" type="text" id="SC_FEI_PostExtraIssue'.$SrNo.'" name="SC_FEI_PostExtraIssue[]" value="'.$ExtraIssue[$i]->PostExtraIssue.'" class="form-control">
			//     	</td>
			// 	 </tr>';
			// }
			
		// <!-- ----------- Extra Issue End here --------------------------------- -->
	// =============================================================================================================

	// <!-- ----------- External Issue Start Here ---------------------------- -->
		// if(!empty($ExternalIssue)){
		// 	for ($j=0; $j <count($ExternalIssue) ; $j++) { 

		// 		$SrNo=$rowCount+1+$j;

		// 		if(!empty($ExternalIssue[$j]->SampleDate)){
		// 			$SampleDate=date("d-m-Y", strtotime($ExternalIssue[$j]->SampleDate));
		// 		}else{
		// 			$SampleDate='';
		// 		}

		// 		$FinalResponce['ExternalIssue'].='<tr>
				    
		// 			<td style="text-align: center;">
		// 				<input class="border_hide" type="hidden" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="'.$ExternalIssue[$j]->Linenum.'" class="form-control desabled" readonly>

		// 			    <input type="radio" id="list'.$SrNo.'" name="listRado[]" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedExternalIssue('.$SrNo.')">
		// 			</td>
				 	
		// 		 	<td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierCode'.$SrNo.'" name="SC_FEXI_SupplierCode[]" value="'.$ExternalIssue[$j]->SupplierCode.'" class="form-control desabled" readonly></td>
				    
		// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" value="'.$ExternalIssue[$j]->SupplierName.'" class="form-control desabled" readonly></td>
				    
		// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" value="'.$ExternalIssue[$j]->UOM.'" class="form-control desabled" readonly></td>
				    
		// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" value="'.$SampleDate.'" class="form-control desabled" readonly></td>
				    
		// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Warehouse'.$SrNo.'" name="SC_FEXI_Warehouse[]" value="'.$ExternalIssue[$j]->Warehouse.'" class="form-control desabled" readonly></td>
				    
		// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" value="'.$ExternalIssue[$j]->SampleQuantity.'" class="form-control desabled" readonly></td>
				    
		// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" value="'.$ExternalIssue[$j]->InventoryTransfer.'" class="form-control desabled" readonly></td>

		// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" value="'.$ExternalIssue[$j]->UserText1.'" class="form-control desabled" readonly></td>

		// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" value="'.$ExternalIssue[$j]->UserText2.'" class="form-control desabled" readonly></td>

		// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" value="'.$ExternalIssue[$j]->UserText3.'" class="form-control desabled" readonly></td>

		// 		    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" value="'.$ExternalIssue[$j]->Attachment.'" class="form-control"></td>
		// 		</tr>';
		// 	}

		// 	// when table data come then default add one manual row start ---------------------------------------------------------
		// 	$SrNo=(count($ExternalIssue)+1);

		// 	$FinalResponce['ExternalIssue'].='<tr>
		// 	    <td></td>
			 	
		// 	 	<td>
		// 	 		<input class="border_hide" type="hidden" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="" class="form-control desabled" readonly>

		// 			<select class="form-control ExternalIssueSelectedBPWithData" id="SC_ExternalI_SupplierCode'.$SrNo.'" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;">
		// 			</select>
		// 		</td>
			    
		// 	    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>
			    
		// 	    <td><input class="border_hide" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" class="form-control desabled"></td>
			    
		// 	    <td><input class="border_hide" type="date" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>
			    
		// 	    <td>
		// 			<select class="form-control ExternalIssueWareHouseWithData" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_ExternalI_Warehouse[]" style="width: 200px;"></select>
		// 		</td>
			    
		// 	    <td><input class="border_hide" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>
			    
		// 	    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

		// 	    <td><input class="border_hide" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" class="form-control"></td>

		// 	    <td><input class="border_hide" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" class="form-control"></td>

		// 	    <td><input class="border_hide" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" class="form-control"></td>

		// 	    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" class="form-control"></td>
		// 	</tr>';
		// 	// when table data come then default add one manual row end -----------------------------------------------------------
		// }else{
		// 	// if user not added External issue recored then show default blank row
		// 	$SrNo=$rowCount+1;

		// 	$FinalResponce['ExternalIssue'].='<tr>
		// 	    <td>
		// 	    	<input class="border_hide" type="text" id="SC_FEXI_Linenum'.$SrNo.'" name="SC_FEXI_Linenum[]" value="'.$SrNo.'" class="form-control desabled" readonly>
		// 	    </td>
			 	
		// 	 	<td>
		// 			<select class="form-control ExternalIssueDefault" id="SC_ExternalI_SupplierCode'.$SrNo.'" name="SC_ExternalI_SupplierCode[]" onchange="ExternalIssueSelectedBP('.$SrNo.')" style="width: 200px;">
		// 			</select>
		// 		</td>
			    
		// 	    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_SupplierName'.$SrNo.'" name="SC_FEXI_SupplierName[]" class="form-control desabled" readonly></td>
			    
		// 	    <td><input class="border_hide" type="text" id="SC_FEXI_UOM'.$SrNo.'" name="SC_FEXI_UOM[]" class="form-control desabled"></td>
			    
		// 	    <td><input class="border_hide" type="date" id="SC_FEXI_SampleDate'.$SrNo.'" name="SC_FEXI_SampleDate[]" class="form-control desabled"></td>
			    
		// 	    <td>
		// 			<select class="form-control ExternalIssueWareHouseDefault" id="SC_ExternalI_Warehouse'.$SrNo.'" name="SC_ExternalI_Warehouse[]" style="width: 200px;"></select>
		// 		</td>
			    
		// 	    <td><input class="border_hide" type="text" id="SC_FEXI_SampleQuantity'.$SrNo.'" name="SC_FEXI_SampleQuantity[]" class="form-control desabled"></td>
			    
		// 	    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_InventoryTransfer'.$SrNo.'" name="SC_FEXI_InventoryTransfer[]" class="form-control desabled" readonly></td>

		// 	    <td><input class="border_hide" type="text" id="SC_FEXI_UserText1'.$SrNo.'" name="SC_FEXI_UserText1[]" class="form-control"></td>

		// 	    <td><input class="border_hide" type="text" id="SC_FEXI_UserText2'.$SrNo.'" name="SC_FEXI_UserText2[]" class="form-control"></td>

		// 	    <td><input class="border_hide" type="text" id="SC_FEXI_UserText3'.$SrNo.'" name="SC_FEXI_UserText3[]" class="form-control"></td>

		// 	    <td class="desabled"><input class="border_hide desabled" type="text" id="SC_FEXI_Attachment'.$SrNo.'" name="SC_FEXI_Attachment[]" class="form-control"></td>
		// 	</tr>';
		// }
	// <!-- ----------- External Issue End Here   ---------------------------- -->
	echo json_encode($FinalResponce);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='OT_QC_check_FG_ajax'){
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$API=$FGQCPOSTDOC_API.'&DocEntry='.$_POST['DocEntry'].'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&LineNum='.$_POST['LineNum'];

		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response=$obj->get_OTFSI_SingleData($FinalAPI);
	$general_data=$response[0]->FGQCPOSTROWDETAILS;

	$FinalResponce['AllData']=$response;

	if (!empty($general_data)) {
		for ($i = 0; $i < count($general_data); $i++) {
			$SrNo = $i;
			$index = $i + 1;

			$FinalResponce['general_data'] .= '<tr>
				<td class="desabled">' . $index . '</td>

				<td class="desabled"><input  type="text" class="form-control" id="parameter_code' . $SrNo . '" name="parameter_code[]" value="' . $general_data[$i]->PCode . '" readonly></td>

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

	// QC Status Tab start here --------------------------------------------------
		$FinalResponce['qcStatus'] .= '<tr id="add-more_1">
			<td>' . (($qcStatusCount) + 1) . '</td>

			<td><select id="qc_Status_1" name="qc_Status[]" class="form-select qc_status_selecte1" onchange="SelectionOfQC_Status(' . (($qcStatusCount) + 1) . ')"></select></td>

			<td><input class="border_hide" type="text"  id="qCStsQty_1" name="qCStsQty[]" class="form-control" value="" onfocusout="addMore(1)"></td>

			<td><input class="border_hide" type="text"  id="qCReleaseDate_1" name="qCReleaseDate[]" class="form-control" ></td>

			<td><input class="border_hide" type="text"  id="qCReleaseTime_1" name="qCReleaseTime[]" class="form-control" ></td>

			<td><input class="border_hide" type="text"  id="qCitNo_1" name="qCitNo[]" class="form-control" value=""></td>

			<td><select id="doneBy_1" name="doneBy[]" class="form-select done-by-mo1"></select></td>

			<td><input class="border_hide" type="file"  id="qCAttache1_1" name="qCAttache1[]" class="form-control"></td>

			<td><input class="border_hide" type="file"  id="qCAttache2_1" name="qCAttache2[]" class="form-control"></td>

			<td><input class="border_hide" type="file"  id="qCAttache3_1" name="qCAttache3[]" class="form-control"></td>

			<td><input class="border_hide" type="date"  id="qCDeviationDate_1" name="qCDeviationDate[]" class="form-control"></td>

			<td><input class="border_hide" type="text"  id="qCDeviationNo_1" name="qCDeviationNo[]" class="form-control"></td>

			<td><input class="border_hide" type="text"  id="qCDeviationResion_1" name="qCDeviationResion[]" class="form-control"></td>

			<td><input class="border_hide" type="text"  id="qCStsRemark1_1" name="qCStsRemark1[]" class="form-control" value=""></td>
		</tr>';
	// QC Status Tab start here --------------------------------------------------

	// QC Status Tab start here --------------------------------------------------
		$FinalResponce['qcAttach'] .= '<tr>
			<td class="desabled">1.</td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="targetPath" name="targetPath[]" class="form-control" value="" readonly></td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="fileName" name="fileName[]"  class="form-control" value="" readonly></td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="attachDate" name="attachDate[]"  class="form-control" value="" readonly></td>
			<td><input class="border_hide" type="text" id="remark" name="remark[]"  class="form-control" value=""></td>
		</tr>';
	// QC Status Tab start here --------------------------------------------------

	echo json_encode($FinalResponce);
	exit(0);
}

if(isset($_POST['OTFQCCFG_Btn'])){  
	$tdata=array(); // This array send to AP Standalone Invoice process 
	
	$tdata['U_PC_BLin']=trim(addslashes(strip_tags($_POST['OTFQCCFG_LineNum'])));
	$tdata['U_PC_BPLId']=trim(addslashes(strip_tags($_POST['OTFQCCFG_BPLId'])));
	$tdata['U_PC_LocCode']=trim(addslashes(strip_tags($_POST['OTFQCCFG_LocCode'])));
	$tdata['U_PC_Loc']=trim(addslashes(strip_tags($_POST['OTFQCCFG_Location'])));
	$tdata['U_PC_Branch']=trim(addslashes(strip_tags($_POST['OTFQCCFG_BranchName'])));
	$tdata['U_PC_RNo']=trim(addslashes(strip_tags($_POST['OTFQCCFG_RFPNo'])));
	$tdata['U_PC_REnt']=trim(addslashes(strip_tags($_POST['OTFQCCFG_RFPDocEntry'])));
	$tdata['U_PC_WoNo']=trim(addslashes(strip_tags($_POST['OTFQCCFG_WONo'])));
	$tdata['U_PC_WoEnt']=trim(addslashes(strip_tags($_POST['OTFQCCFG_WODocEntry'])));
	$tdata['U_PC_ICode']=trim(addslashes(strip_tags($_POST['OTFQCCFG_ItemCode'])));
	$tdata['U_PC_IName']=trim(addslashes(strip_tags($_POST['OTFQCCFG_ItemName'])));
	$tdata['U_PC_GName']=trim(addslashes(strip_tags($_POST['OTFQCCFG_GenericName'])));
	$tdata['U_PC_LClaim']=trim(addslashes(strip_tags($_POST['OTFQCCFG_LabelClaim'])));
	$tdata['U_PC_LClmUom']=trim(addslashes(strip_tags($_POST['OTFQCCFG_LabelClaimUOM'])));
	$tdata['U_PC_RecQty']=trim(addslashes(strip_tags($_POST['OTFQCCFG_RecievedQty'])));
	$tdata['U_PC_MfgBy']=trim(addslashes(strip_tags($_POST['OTFQCCFG_MfgBy'])));
	$tdata['U_PC_SType']=trim(addslashes(strip_tags($_POST['OTFQCCFG_SampleType'])));
	$tdata['U_PC_BNo']=trim(addslashes(strip_tags($_POST['OTFQCCFG_BatchNo'])));
	$tdata['U_PC_BSize']=trim(addslashes(strip_tags($_POST['OTFQCCFG_BatchSize'])));
	$tdata['U_PC_SIntNo']=trim(addslashes(strip_tags($_POST['OTFQCCFG_SampleIntimationNo'])));
	$tdata['U_PC_SQty']=trim(addslashes(strip_tags($_POST['OTFQCCFG_SampleQty'])));
	$tdata['U_PC_PckSize']=trim(addslashes(strip_tags($_POST['OTFQCCFG_PackSize'])));
	$tdata['U_PC_SamType']=trim(addslashes(strip_tags($_POST['OTFQCCFG_SampleType'])));
	$tdata['U_PC_MType']=trim(addslashes(strip_tags($_POST['OTFQCCFG_MaterialType'])));
	$tdata['U_PC_NoCont']=trim(addslashes(strip_tags($_POST['OTFQCCFG_TNCont'])));
	$tdata['U_PC_QCTType']=trim(addslashes(strip_tags($_POST['OTFQCCFG_QcTestType'])));
	$tdata['U_PC_Stage']=trim(addslashes(strip_tags($_POST['OTFQCCFG_Stage'])));
	$tdata['U_PC_ArNo']=trim(addslashes(strip_tags($_POST['OTFQCCFG_ARNo'])));
	$tdata['U_PC_GENo']=trim(addslashes(strip_tags($_POST['OTFQCCFG_GateENo'])));
	$tdata['U_PC_LODWater']=trim(addslashes(strip_tags($_POST['LoD_Water'])));
	$tdata['U_PC_Potency']=trim(addslashes(strip_tags($_POST['Potency'])));
	$tdata['U_PC_CompBy']=trim(addslashes(strip_tags($_POST['OTFQCCFG_ComplitedBy'])));
	$tdata['U_PC_NoCont1']=trim(addslashes(strip_tags($_POST['OTFQCCFG_FCont'])));
	$tdata['U_PC_NoCont2']=trim(addslashes(strip_tags($_POST['OTFQCCFG_TCont'])));
	$tdata['U_PC_ChkBy']=trim(addslashes(strip_tags($_POST['OTFQCCFG_CheckedBy'])));
	$tdata['U_PC_AnlBy']=trim(addslashes(strip_tags($_POST['OTFQCCFG_AnalysisBy'])));
	$tdata['U_PC_Remarks']=trim(addslashes(strip_tags($_POST['OTFQCCFG_Remark'])));
	$tdata['U_PC_AsyCal']=trim(addslashes(strip_tags($_POST['assay_CalBasedOn'])));
	$tdata['U_PC_Factor']=trim(addslashes(strip_tags($_POST['OTFQCCFG_Factor'])));
	$tdata['U_PC_SpcNo']=trim(addslashes(strip_tags($_POST['OTFQCCFG_SpecfNo'])));
	$tdata['U_PC_MakeBy']=trim(addslashes(strip_tags($_POST['OTFQCCFG_MakeBy'])));
	$tdata['U_PC_RMQC']=trim(addslashes(strip_tags($_POST['OTFQCCFG_RelMaterialWithoutQC'])));
	$tdata['U_PC_APot']=trim(addslashes(strip_tags($_POST['AssayPotency'])));
	$tdata['U_PC_RfBy']=trim(addslashes(strip_tags($_POST['OTFQCCFG_RefNo'])));
	$tdata['U_PC_SColNo']=trim(addslashes(strip_tags($_POST['OTFQCCFG_SampleCollectionNo'])));

	$tdata['U_PC_MfgDt']=(!empty($_POST['OTFQCCFG_MfgDate'])) ? date('Y-m-d', strtotime($_POST['OTFQCCFG_MfgDate'])) : '';
	$tdata['U_PC_ExpDt']=(!empty($_POST['OTFQCCFG_ExpiryDate'])) ? date('Y-m-d', strtotime($_POST['OTFQCCFG_ExpiryDate'])) : '';
	$tdata['U_PC_PDate']=(!empty($_POST['OTFQCCFG_PostingDate'])) ? date('Y-m-d', strtotime($_POST['OTFQCCFG_PostingDate'])) : '';
	$tdata['U_PC_ADate']=(!empty($_POST['OTFQCCFG_AnalysisDate'])) ? date('Y-m-d', strtotime($_POST['OTFQCCFG_AnalysisDate'])) : '';
	$tdata['U_PC_RetstDt']=(!empty($_POST['OTFQCCFG_RetestDate'])) ? date('Y-m-d', strtotime($_POST['OTFQCCFG_RetestDate'])) : '';
	$tdata['U_PC_ValUp']=(!empty($_POST['OTFQCCFG_ValidUpTo'])) ? date('Y-m-d', strtotime($_POST['OTFQCCFG_ValidUpTo'])) : '';
	$tdata['U_PC_RelDt']=(!empty($_POST['OTFQCCFG_ReleaseDate'])) ? date('Y-m-d', strtotime($_POST['OTFQCCFG_ReleaseDate'])) : '';

	$tdata['U_PC_GRQty']='';   //-------------------------------------------------------------- missing
	$tdata['U_PC_GDEntry']=''; //-------------------------------------------------------------- missing
	$tdata['U_PC_RQty']='';    //-------------------------------------------------------------- missing

	// 'U_PC_RQty-Retain Qty
	// 'U_PC_GDEntry-Gate Entry DocEntry

	// $tdata['Series']=trim(addslashes(strip_tags($_POST['OTFQCCFG_DocName'])));
	// $tdata['Status']='';  //-------------------------------------------------------------- missing
	// $tdata['Object']='SCS_QCPDFG';

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

		$tdata['SCS_QCPDFG1Collection'][] = $ganaralData; // row data append on this array
	}

	$qcStatus = array();
	for ($j = 0; $j < count($_POST['qc_Status']); $j++) {
		$qcStatus['LineId'] = trim(addslashes(strip_tags($j)));
		$qcStatus['U_PC_Stus'] = trim(addslashes(strip_tags($_POST['qc_Status'][$j])));
		$qcStatus['U_PC_Qty'] = trim(addslashes(strip_tags($_POST['qCStsQty'][$j])));

		$qcStatus['U_PC_RelDt']=(!empty($_POST['qCReleaseDate'][$j])) ? date('Y-m-d', strtotime($_POST['qCReleaseDate'][$j])) : '';
		$qcStatus['U_PC_RelTm'] =  (!empty($_POST['qCReleaseTime'][$j])) ? date("H:i:s", strtotime($_POST['qCReleaseTime'][$j])) : null;

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

		$tdata['SCS_QCPDFG2Collection'][] = $qcStatus; // row data append on this array
	}

	$qcAttech = array();
	for ($k = 0; $k < count($_POST['targetPath']); $k++) {
		if (!empty($_POST['fileName'][$k])) {
			$qcAttech['LineId'] = trim(addslashes(strip_tags($k)));
			$qcAttech['Object'] = trim(addslashes(strip_tags('SCS_QCPDFG')));
			$qcAttech['U_PC_TrgPt'] = trim(addslashes(strip_tags($_POST['targetPath'][$k])));
			$qcAttech['U_PC_FName'] = trim(addslashes(strip_tags($_POST['fileName'][$k])));
			$qcAttech['U_PC_AtcDt'] = trim(addslashes(strip_tags($_POST['attachDate'][$k])));
			$qcAttech['U_PC_FText'] = trim(addslashes(strip_tags($_POST['freeText'][$k])));

			$tdata['SCS_QCPDFG3Collection'][] = $qcAttech; // row data append on this array
		} else {
			// $tdata['SCS_QCPDFG3Collection'][] = array();
		}
	}

	$mainArray = $tdata; // all child array append in main array define here

	// <!-- --------- Validation Start Here ----------------------------------------- -->
		if ($_POST['OTFQCCFG_SampleType'] == "") {
			$data['status'] = 'False';$data['DocEntry'] = '';
			$data['message'] = 'Sample Type is required.';
			echo json_encode($data);
			exit;
		}

		if ($_POST['OTFQCCFG_PostingDate'] == "") {
			$data['status'] = 'False';$data['DocEntry'] = '';
			$data['message'] = 'Posting Date is required.';
			echo json_encode($data);
			exit;
		}

		if ($_POST['OTFQCCFG_AnalysisDate'] == "") {
			$data['status'] = 'False';$data['DocEntry'] = '';
			$data['message'] = 'Analysis Date is required.';
			echo json_encode($data);
			exit;
		}

		if ($_POST['OTFQCCFG_ValidUpTo'] == "") {
			$data['status'] = 'False';$data['DocEntry'] = '';
			$data['message'] = 'ValidUpTo Date is required.';
			echo json_encode($data);
			exit;
		}
	// <!-- --------- Validation End Here ------------------------------------------- -->

	// service laye function and SAP loin & logout function define start here -------------------------------------------------------
		$res = $obj->SAP_Login();
		if (!empty($res)) {
			$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_QCPDFG_API;

			$responce_encode = $objKri->qcPostDocument($mainArray, $Final_API);
			$responce = json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				if (array_key_exists('error', (array)$responce)) {
					$data['status'] = 'False';
					$data['DocEntry'] = '1111111111111';
					$data['message'] = $responce->error->message->value;
					echo json_encode($data);
				} else {
					// GRN Process Start

					$InventoryGenEntries = array();
					$InventoryGenEntries['SIDocEntry'] = trim($responce->DocEntry);
					$InventoryGenEntries['GRDocEntry'] = trim($_POST['OTFQCCFG_RFPDocEntry']);
					$InventoryGenEntries['ItemCode'] = trim($responce->U_PC_ICode);
					$InventoryGenEntries['LineNum'] = trim($responce->U_PC_BLin);

					$Final_API = $GRQCPOSTFG_API;
					$responce_encode1 = $obj->POST_QuerryBasedMasterFunction($InventoryGenEntries, $Final_API);
					$responce1 = json_decode($responce_encode1);

					if (empty($responce1)) {
						$data['status'] = 'True';
						$data['DocEntry'] = $responce->DocEntry;
						$data['message'] = "QC Post Document (FG) Added Successfully.";
						echo json_encode($data);
					} else {
						if (array_key_exists('error', (array)$responce1)) {
							$data['status'] = 'False';
							$data['DocEntry'] = '22222222222222';
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
?>