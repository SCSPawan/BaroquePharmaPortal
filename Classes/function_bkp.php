<?php
require_once 'config.php';

class Web {

    function __construct() {
       
    }

    function dateDiff($date1, $date2)
	{
	    $date1_ts = strtotime($date1);
	    $date2_ts = strtotime($date2);
	    $diff = $date2_ts - $date1_ts;
	    return round($diff / 86400);
	}

	// a simple date formatting function
	
// ---------------------------- SAP DB CAlled Function Start Here -----------------------------------------
	public function SAP_Login()
    {
		$host = 'https://192.168.1.34';
		$port = 50000;
		$params = ["UserName" => "manager",
		    "Password" => "soft@3333",
		    "CompanyDB" => "DEPO_DB_LIVE",
		];

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $host . ":" . $port . "/b1s/v1/Login");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

		$response = curl_exec($curl);

		$responce_decode=json_decode($response);
		$_SESSION['SAP_SessionId'] =$responce_decode->SessionId;

		curl_close($ch);
		return $response;
    }
    
    public function SAP_Logout()
    {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://192.168.1.34:50000/b1s/v1/Logout");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_POST, true);
		// curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

		$response = curl_exec($curl);
		curl_close($ch);
		return $response;
    }
// ---------------------------- SAP DB CAlled Function End Here -----------------------------------------

    public function convert_to_excel($filename, $output)
	{	
		ob_clean();
        header('Content-type: application/ms-excel');
        header('Content-Disposition: attachment; filename='.$filename);
        echo $output;
	}

    public function login($url,$post)
	{
		$ch = curl_init();
		$data = http_build_query($post);
		$getUrl = $url."?".$data;

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $getUrl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}else{

			$myresponse = json_decode($response);
			
			if(!empty($myresponse)){
				$return = true;

				$_SESSION['BPLID'] =$myresponse[0]->BPLID;
				$_SESSION['BPLName'] =$myresponse[0]->BPLName;
				$_SESSION['Business'] =$myresponse[0]->Business;
				$_SESSION['DefaultWareHouseId'] =$myresponse[0]->DefaultWareHouseId;
				$_SESSION['State'] =$myresponse[0]->State;
				$_SESSION['PlaceOfSupply'] =$myresponse[0]->PlaceOfSupply;
				$_SESSION['Result'] =$myresponse[0]->Result;
				$_SESSION['GroupNum'] =$myresponse[0]->GroupNum;
				$_SESSION['BillToDef'] =$myresponse[0]->BillToDef;
				$_SESSION['ShipToDef'] =$myresponse[0]->ShipToDef;
				$_SESSION['BillToAddress'] =$myresponse[0]->BillToAddress;
				$_SESSION['ShipToAddress'] =$myresponse[0]->ShipToAddress;
				$_SESSION['SODefaultWareHouseId']=$myresponse[0]->SODefaultWareHouseId;
				$_SESSION['LocationCode']=$myresponse[0]->LocationCode;
				$_SESSION['LocationName']=$myresponse[0]->LocationName;
				$_SESSION['LocationGSTIN']=$myresponse[0]->LocationGSTIN;

				return $return;
			}
		}
		curl_close($ch);
	}

	

	public function DoLogout()
    {
    	$return = true;
		$_SESSION['BPLID'] ='';
		$_SESSION['BPLName'] ='';
        $_SESSION['Business'] ='';
        $_SESSION['DefaultWareHouseId'] ='';
        $_SESSION['State'] ='';
        $_SESSION['PlaceOfSupply'] ='';
		$_SESSION['Result'] ='';
		$_SESSION['GroupNum'] ='';
		$_SESSION['BillToDef'] ='';
		$_SESSION['ShipToDef'] ='';
		$_SESSION['BillToAddress'] ='';
		$_SESSION['ShipToAddress'] ='';
		$_SESSION['SODefaultWareHouseId'] ='';
		$_SESSION['LocationCode'] ='';
		$_SESSION['LocationName'] ='';
		$_SESSION['LocationGSTIN'] ='';

		unset($_SESSION['BPLID']); 
		unset($_SESSION['BPLName']); 
        unset($_SESSION['Business']); 
        unset($_SESSION['DefaultWareHouseId']);     
        unset($_SESSION['State']);  
        unset($_SESSION['PlaceOfSupply']);
		unset($_SESSION['Result']);
		unset($_SESSION['GroupNum']);
		unset($_SESSION['BillToDef']);
		unset($_SESSION['ShipToDef']);
		unset($_SESSION['BillToAddress']);
		unset($_SESSION['ShipToAddress']);
		unset($_SESSION['SODefaultWareHouseId']);
		unset($_SESSION['LocationCode']);
		unset($_SESSION['LocationName']);
		unset($_SESSION['LocationGSTIN']);
        return $return;
    }

    public function getOrderForDropdown($OrderForAIP)
    {
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$OrderForAIP);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$OrderForList=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';
	
		for ($i=0; $i < count($OrderForList) ; $i++) { 
			$option .= '<option value="'.$OrderForList[$i]->OrderForCode.'">'.$OrderForList[$i]->OrderForName.'</option>';
		}      
		return $option;
    }

    public function getPO_OrderFor($OrderForAIP)
    {
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$OrderForAIP);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		// $OrderForList=json_decode($output);
		curl_close($ch);
   
		return $output;
    }

    public function getItemGroupNameDropdown($ItemDetailsAIP)
    {
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$ItemDetailsAIP);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$ItemGroupNameList=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		if(!empty($ItemGroupNameList)){
			$array_unique = array();
			for ($a=0; $a <count($ItemGroupNameList) ; $a++) { 
				$array_unique[]=$ItemGroupNameList[$a]->ItemgroName;
			}

			$unique_randum=array_unique($array_unique);
			$unique = array_values($unique_randum);

			for ($i=0; $i < count($unique) ; $i++) { 
				if (!empty($unique[$i])) {
					$option .= '<option value="'.$unique[$i].'">'.$unique[$i].'</option>';
				}
			}  
		}
		    
		return $option;
    }

 	public function getPartHQListDropdown($CUSTOMERLIST_API)
    {
    	$API_URL=$CUSTOMERLIST_API.'&BPLID='.$_SESSION['BPLID'];
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$API_URL);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$HQList=json_decode($output);
		// $HQList
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		if(!empty($HQList)){
			$array_unique = array();
			for ($a=0; $a <count($HQList) ; $a++) { 
				$array_unique[]=$HQList[$a]->HQ;
			}

			$unique_randum=array_unique($array_unique);
			$unique = array_values($unique_randum);

			for ($i=0; $i < count($unique) ; $i++) { 
				if (!empty($unique[$i])) {
					$option .= '<option value="'.$unique[$i].'">'.$unique[$i].'</option>';
				}
			}  
		}
		    
		return $option;
    }

    public function GetProductWiseHQDropdown($API)
    {
    	//$API_URL=$CUSTOMERLIST_API.'&BPLID='.$_SESSION['BPLID'];
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$HQList=json_decode($output);
		// $HQList
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		if(!empty($HQList)){
			$array_unique = array();
			for ($a=0; $a <count($HQList) ; $a++) { 
				$array_unique[]=$HQList[$a]->HQ;
			}

			$unique_randum=array_unique($array_unique);
			$unique = array_values($unique_randum);

			for ($i=0; $i < count($unique) ; $i++) { 
				if (!empty($unique[$i])) {
					$option .= '<option value="'.$unique[$i].'">'.$unique[$i].'</option>';
				}
			}  
		}
		    
		return $option;
    }

    public function getCategory1Dropdown($ItemDetailsAIP)
    {
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$ItemDetailsAIP);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$Category1List=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		if(!empty($Category1List)){
			$array_unique = array();
			for ($a=0; $a <count($Category1List) ; $a++) { 
				$array_unique[]=$Category1List[$a]->Category1;
			}

			$unique_randum=array_unique($array_unique);
			$unique = array_values($unique_randum);

			for ($i=0; $i < count($unique) ; $i++) { 
				if (!empty($unique[$i])) {
					$option .= '<option value="'.$unique[$i].'">'.$unique[$i].'</option>';
				}
			}
		}      
		return $option;
    }

    public function getCategory2Dropdown($ItemDetailsAIP)
    {
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$ItemDetailsAIP);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$Category2List=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		if(!empty($Category2List)){
			$array_unique = array();
			for ($a=0; $a <count($Category2List) ; $a++) { 
				$array_unique[]=$Category2List[$a]->Category2;
			}

			$unique_randum=array_unique($array_unique);
			$unique = array_values($unique_randum);

			for ($i=0; $i < count($unique) ; $i++) { 
				if (!empty($unique[$i])) {
					$option .= '<option value="'.$unique[$i].'">'.$unique[$i].'</option>';
				}
			} 
		}     
		return $option;
    }

    public function getCategory3Dropdown($ItemDetailsAIP)
    {
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$ItemDetailsAIP);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$Category3List=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		if(!empty($Category3List)){
			$array_unique = array();
			for ($a=0; $a <count($Category3List) ; $a++) { 
				$array_unique[]=$Category3List[$a]->Category3;
			}

			$unique_randum=array_unique($array_unique);
			$unique = array_values($unique_randum);

			for ($i=0; $i < count($unique) ; $i++) { 
				if (!empty($unique[$i])) {
					$option .= '<option value="'.$unique[$i].'">'.$unique[$i].'</option>';
				}
			}  
		}    
		return $option;
    }

    public function getShipToDropdownByOrderFor($ShipToAPI)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$ShipToAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$ShipToList=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($ShipToList) ; $i++) {
			$option .= '<option value="'.$ShipToList[$i]->ShipToCode.'">'.$ShipToList[$i]->ShipToName.'</option>';
		}      
		return $option;
    }

    public function getShipToDataByShipToCoder($ShipToAPI)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$ShipToAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$ShipToData=json_decode($output);
		curl_close($ch);

		$return=array();
		$return['Address']=$ShipToData[0]->Address;
		$return['State']=$ShipToData[0]->State;
		    
		return json_encode($return);
    }
 
    public function getPayToDataByPayToCode($PayToAPI)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$PayToAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PayToData=json_decode($output);
		curl_close($ch);

		$return=array();
		$return['Address'] = str_replace('"', ' ', $PayToData[0]->Address); // All (") - double cot remove
		$return['POS']=$PayToData[0]->POS;
		    
		return $return;
    }

    public function getOrderForCodeToBusiness($OrderFor_API)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$OrderFor_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$CorderForData=json_decode($output);
		curl_close($ch);

		$Business=$CorderForData[0]->Business;
		    
		return $Business;
    }

    public function getDraftInvoiceFreightAllData($DraftInvoiceFREIGHTLIST_API,$InternalNo)
    {
    	$API=$DraftInvoiceFREIGHTLIST_API.$InternalNo;
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$FreightData=json_decode($output);
		curl_close($ch);
		$return=array();
		$option ='';
	// ==========================Freight Data Table Prepare Start Here================================================

		if(!empty($FreightData)){
		// -------------------------------------------------------
			$sum = 0;
			for ($i = 0; $i <count($FreightData); $i++) {
				if($FreightData[$i]->LineTotal!=''){
					$sum += $FreightData[$i]->LineTotal;
				}
			}

			$sum2 = 0;
			for ($j = 0; $j <count($FreightData); $j++) {
				if($FreightData[$j]->TaxAMount!=''){
					$sum2 += $FreightData[$j]->TaxAMount;
				}
			}
		// -------------------------------------------------------

			foreach ($FreightData as $key => $value) {
				if($value->TaxAMount!=''){
					$TaxAMount =$value->TaxAMount;
				}else{
					$TaxAMount ='00';
				}
        	// $FreightTaxOG=ceil($value->TaxRate);
			$option .= '<tr>
				    <td>
				       '.$value->ExpnsName.'
				        <input type="hidden" id="ExpnsName" name="ExpnsName[]"  value="'.$value->ExpnsName.'">
				        <input type="hidden" id="ExpnsCode" name="ExpnsCode[]"  value="'.$value->ExpnsCode.'">
				    </td>
				    <td>
				        <input type="text" id="ExpenseAmount'.$key.'" name="ExpenseAmount[]" class="form-control" placeholder="Expense Amount" style="width: 70%;"  onfocusout="CalculateFreightTax(\'ExpenseAmount'.$key.'\',\'FreightTax'.$key.'\',\'FreightTaxAmt'.$key.'\',\'FreightTaxOG'.$key.'\',\'TaxCodeCust'.$key.'\')" value="'.$value->LineTotal.'">
				    </td>

					<td>
						<input type="hidden" id="FreightTaxOG'.$key.'" name="FreightTaxOG[]" value="'.$value->TaxRate.'">
						<input type="hidden" id="TaxCodeCust'.$key.'" name="TaxCodeCust[]" value="'.$value->TaxCode.'">
						<select class="form-control form-select FreightTaxClass"  id="FreightTax'.$key.'" name="FreightTax[]" onchange="CalculateFreightTax(\'ExpenseAmount'.$key.'\',\'FreightTax'.$key.'\',\'FreightTaxAmt'.$key.'\',\'TaxCodeCust'.$key.'\',\'TaxCodeCust'.$key.'\')" style="width: 130px;">
						</select>
					</td>

				    <td class="text-center">
				    	<input type="text" class="FreightInput" id="FreightTaxAmt'.$key.'" name="FreightTaxAmt[]" value="'.$TaxAMount.'" style="" readonly="">
				    </td>
				</tr>';
        	}
        	$option .= '<tr>
				<td><strong>Total</strong></td>
				<td><strong id="FinalExpenseAmount">'.$sum.'</strong></td>
				<td></td>
				<td class=""><strong id="FinalFreightTax" style="margin-left: 8px;">'.$sum2.'</strong></td>
			</tr>';

		}else{

			$option.= '<span style="text-align: center;color:red;">Record Not Found</span>';
		}
	// ==========================Freight Data Table Prepare End Here============================================

		$return['option']=$option;
		$return['Total']=$sum+$sum2;
		
		return $return;
    }

    public function getFreightAllData($FREIGHT_API)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FREIGHT_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$FreightData=json_decode($output);
		curl_close($ch);

		$option ='';
	// ==========================Freight Data Table Prepare Start Here================================================
		if(!empty($FreightData)){
			
			foreach ($FreightData as $key => $value) {
        	
			$option .= '<tr>
				    <td>
				       '.$value->ExpnsName.'
				        <input type="hidden" id="ExpnsName" name="ExpnsName[]"  value="'.$value->ExpnsName.'">
				        <input type="hidden" id="ExpnsCode" name="ExpnsCode[]"  value="'.$value->ExpnsCode.'">
				    </td>
				    <td>
				        <input type="text" id="ExpenseAmount'.$key.'" name="ExpenseAmount[]" class="form-control" placeholder="Expense Amount" style="width: 70%;"  onfocusout="CalculateFreightTax(\'ExpenseAmount'.$key.'\',\'FreightTax'.$key.'\',\'FreightTaxAmt'.$key.'\',\'TaxCodeCust'.$key.'\',\'TaxCodeCust'.$key.'\')">
				    </td>
				    <td>

<input type="hidden" id="FreightTaxOG'.$key.'" name="FreightTaxOG[]" value="'.$value->TaxRate.'">
<input type="hidden" id="TaxCodeCust'.$key.'" name="TaxCodeCust[]" value="'.$value->TaxCode.'">
				        <select class="form-control form-select FreightTaxClass"  id="FreightTax'.$key.'" name="FreightTax[]" onchange="CalculateFreightTax(\'ExpenseAmount'.$key.'\',\'FreightTax'.$key.'\',\'FreightTaxAmt'.$key.'\',\'TaxCodeCust'.$key.'\',\'TaxCodeCust'.$key.'\')" style="width: 130px;">
				        </select>
				    </td>
				    <td class="text-center"><input type="text" class="FreightInput" id="FreightTaxAmt'.$key.'" name="FreightTaxAmt[]" value="00" style="" readonly=""></td>
				</tr>';
        	}
        	$option .= '<tr>
				<td><strong>Total</strong></td>
				<td><strong id="FinalExpenseAmount">00</strong></td>
				<td></td>
				<td class=""><strong id="FinalFreightTax" style="margin-left: 8px;">00</strong></td>
			</tr>';

		}else{

			$option.= '<span style="text-align: center;color:red;">Record Not Found</span>';
		}
	// ==========================Freight Data Table Prepare End Here============================================

		return $option;
    }

    public function getFreight($FREIGHT_API)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FREIGHT_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$FreightData=json_decode($output);
		curl_close($ch);

		return $FreightData;
    }

    
 	public function getFreightTaxDropdownByTaxCode($FRTAXCODE_API,$TaxCode)
    {
    	// --------------------------------dropdown-----------------------------------------------------
    	$ch = curl_init();  
    	$API=$FRTAXCODE_API.'?TaxCode='.$TaxCode;
		curl_setopt($ch,CURLOPT_URL,$API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$FreightDrp=json_decode($output);
		curl_close($ch);
		// -------------------------------- dropdown end -----------------------------------------------

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($FreightDrp) ; $i++) {
			$option .='<option value="'.$FreightDrp[$i]->TaxRate.'">'.$FreightDrp[$i]->TaxCode.'</option>';
		}      
		return $option;
    }

    public function getFreightTaxDropdownWithTCSByTaxCode($FREIGHTTAX_with_TCS,$TaxCode,$TCS_applicable)
    {
    	// --------------------------------dropdown-----------------------------------------------------
    	if(empty($TCS_applicable)){
    		$TCS_applicable_Code='NO';
    	}else{
			$TCS_applicable_Code='YES';
    	}
    	$ch = curl_init();  
    	$API=$FREIGHTTAX_with_TCS.'?TCS='.$TCS_applicable_Code.'&TaxCode='.$TaxCode;
// print_r($API);
// die();

		curl_setopt($ch,CURLOPT_URL,$API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$FreightDrp=json_decode($output);
		curl_close($ch);
		// -------------------------------- dropdown end -----------------------------------------------

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($FreightDrp) ; $i++) {
			$option .= '<option value="'.$FreightDrp[$i]->TaxRate.'" id="drop'.$FreightDrp[$i]->TaxRate.'">'.$FreightDrp[$i]->TaxCode.'</option>';
		}      
		return $option;
    }

    public function getSeriesNameDetails($SERIESNAME_API,$key)
    {
    	$url=$SERIESNAME_API.'&ObjType='.$key;
    	// print_r($url);die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$output=curl_exec($ch);
		$CorderForData=json_decode($output);
		curl_close($ch);
		return $CorderForData;
    }

    public function getSeriesNameDetailsBySeriesId($Single_SERIESNAME_API,$Series)
    {
    	$url=$Single_SERIESNAME_API.$Series;
    	// print_r($url);die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$output=curl_exec($ch);
		$CorderForData=json_decode($output);
		curl_close($ch);
		return $CorderForData;
    }

    public function getAPCM_DraftDataByDocEntry($DRAFTAPCRSALDLIST_API,$DocEntry)
    {
    	$url=$DRAFTAPCRSALDLIST_API.'?DocEntry='.$DocEntry.'&Type=Draft';
    	// print_r($url);die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$output=curl_exec($ch);
		$CorderForData=json_decode($output);
		curl_close($ch);
		return $CorderForData;
    }

    public function getARCM_List($AR_DocItem_API)
    {
    	// print_r($AR_DocItem_API);die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$AR_DocItem_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$output=curl_exec($ch);
		$responce=json_decode($output);
		curl_close($ch);
		return $responce;
    }

    public function getSeiesByDivisionAndGSTN($FinalAPI)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FinalAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$output=curl_exec($ch);
		$SeariesDetails=json_decode($output);
		curl_close($ch);
		return $SeariesDetails;
    }

    public function getPurchasOrderListDetails($POHEADERLIST_API,$tdata)
    {
    	if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
    		$Date='FromDate=&ToDate=&DocEntry=';
    	}else{
    		$Date='FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
    	}

    	if(!empty($tdata['Status'])){
			$Status='&DocStatus='.$tdata['Status'];
    	}else{
			$Status='&DocStatus=';
    	}

    	$url=$POHEADERLIST_API.$Date.$Status; // All Parameter Eneter Here

		// $stripped = rtrim($url, "&"); // URL last & symbole remove
		// $Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

    public function getPaymentReceiptDetails($INCPAYHDDET_API,$OUTPAYHDDET_API,$tdata)
    {

    	if($tdata['fromDate']=='19700101' || $tdata['toDate']=='19700101'){
    		$Date='';
    	}else{
    		$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
    	}

		if($_POST['Type']=='IP'){
			$url=$INCPAYHDDET_API.$Date; // All Parameter Eneter Here
		}else{
			$url=$OUTPAYHDDET_API.$Date; // All Parameter Eneter Here
		}

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

    public function ARCM_To_APCM_List($APCRBASEDARCRDATA_API,$tdata)
    {
    	if($tdata['FromDate']=='1970-01-01' && $tdata['ToDate']=='1970-01-01'){
    		$Date='';
    	}else{
    		$Date='&FromDate='.$tdata['FromDate'].'&ToDate='.$tdata['ToDate'];
    	}

    	if(!empty($tdata['Status'])){
    		$Status='&Status='.$tdata['Status'];
    	}

    	if(!empty($tdata['CardCode'])){
    		$CardCode='&CardCode='.$tdata['CardCode'];
    	}

    	$url=$APCRBASEDARCRDATA_API.'BPLID='.$tdata['BPLID'].'&Type='.$tdata['Type'].$Date.$Status.$CardCode; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }


    public function getAP_CreditMemoList($DRAFTAPCRSAHDLIST_API,$tdata)
    {
    	if($tdata['fromDate']=='1970-01-01' && $tdata['toDate']=='1970-01-01'){
    		$Date='';
    	}else{
    		$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
    	}

    	if(!empty($tdata['Status'])){
    		$Status='&Status='.$tdata['Status'];
    	}

    	$url=$DRAFTAPCRSAHDLIST_API.'BPLID='.$tdata['BPLID'].'&Type='.$tdata['DocType'].'&TransType='.$tdata['TransType'].$Date.$Status; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20


    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);
    
		return $PurchasOrderLinstData;
    }

     public function getAR_CreditMemoList($DRAFTARCRHDLISTNEW_API,$tdata)
    {
    	if($tdata['fromDate']=='1970-01-01' && $tdata['toDate']=='1970-01-01'){
    		$Date='&FromDate=&ToDate=';
    	}else{
    		$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
    	}

    	if(!empty($tdata['Status'])){
    		$Status='&Status='.$tdata['Status'];
    	}

    	if(!empty($tdata['DocType'])){
    		$Type='&Type='.$tdata['DocType'];
    	}

    	if(!empty($tdata['Division'])){
    		$Division='&Division='.$tdata['Division'];
    	}

    	if(!empty($tdata['TypeOfAPC'])){
    		$TypeOfAPC='&TypeOfAPC='.$tdata['TypeOfAPC'];
    	}

    	if(!empty($tdata['CardCode'])){
    		$CardCode='&CardCode='.$tdata['CardCode'];
    	}

    	$url=$DRAFTARCRHDLISTNEW_API.$Date.$Status.$Type.$Division.$TypeOfAPC.$CardCode; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

 	public function getStockDetailsBatchWiseList($BATCHREPORT_API,$tdata)
    {
    	// if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
    	// 	$Date='';
    	// }else{
    	// 	$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
    	// }

    	if($tdata['toDate']=='19700101'){
    		$Date='';
    	}else{
    		$Date='&ToDate='.$tdata['toDate'];
    	}

    	if($tdata['BatchChk']=='Y'){
    		$Flag='&Flag='.$tdata['BatchChk'];
    	}else{
    		$Flag='&Flag='.$tdata['BatchChk'];
    	}


    	$url=$BATCHREPORT_API.'?WhsCode='.$tdata['WhsCode'].$Flag.$Date; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);
// die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }


    public function getChapterIdByHSNCode($DRAFTARCRLDCHAPTERID_API,$HSNEntry)
    {
    	$url=$DRAFTARCRLDCHAPTERID_API.$HSNEntry; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
		
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$result=json_decode($output);
		
		$ChapterId=$result[0]->ChapterId;
		curl_close($ch);

		return $ChapterId;
    }

    public function getTCS_Amt($TCSAMOUNT_API,$DocEntry,$LineNum)
    {
    	$url=$TCSAMOUNT_API.$DocEntry.'&LineNum='.$LineNum; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
		
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$result=json_decode($output);
		
		$TCS_Amt=$result[0]->TcsAmount;
		curl_close($ch);

		return $TCS_Amt;
    }

    public function getTCS_Rate($TCSAMOUNT_API,$DocEntry,$LineNum)
    {
    	$url=$TCSAMOUNT_API.$DocEntry.'&LineNum='.$LineNum; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
		
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$result=json_decode($output);
		
		$TCS_Rate=$result[0]->TcsRate;
		curl_close($ch);

		return $TCS_Rate;
    }


    public function getSalesDetailsList($SalesDetail_API,$tdata)
    {
    	if($tdata['FromDate']=='19700101' || $tdata['ToDate']=='19700101'){
    		$Date='FromDate=&ToDate=&BPLID='.$tdata['BPLID'];
    	}else{
    		$Date='FromDate='.$tdata['FromDate'].'&ToDate='.$tdata['ToDate'].'&BPLID='.$tdata['BPLID'];
    	}

    	if(!empty($tdata['HQ'])){
    		$HQ='&HQ='.$tdata['HQ'];
    	}

    	if(!empty($tdata['PartyName'])){
    		$PartyName='&PartyName='.$tdata['PartyName'];
    	}

    	if(!empty($tdata['BillNo'])){
    		$BillNo='&BillNo='.$tdata['BillNo'];
    	}
		
		if(!empty($tdata['Division'])){
    		$Division='&Division='.$tdata['Division'];
    	}

    	$url=$SalesDetail_API.$Date.$HQ.$PartyName.$BillNo.$Division;
		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

    public function getSalesStockStatementList($SalesStockStatement_API,$tdata)
    {
    	if($tdata['FromDate']=='19700101' || $tdata['ToDate']=='19700101'){
    		$Date='FromDate=&ToDate=&BPLID='.$tdata['BPLID'];
    	}else{
    		$Date='FromDate='.$tdata['FromDate'].'&ToDate='.$tdata['ToDate'].'&BPLID='.$tdata['BPLID'];
    	}

    	if(!empty($tdata['Division'])){
    		$Division='&Division='.$tdata['Division'];
    	}else{
    		$Division='&Division=';
    	}

    	if(!empty($tdata['HQ'])){
    		$HQ='&HQ='.$tdata['HQ'];
    	}else{
    		$HQ='&HQ=';
    	}

    	$url=$SalesStockStatement_API.$Date.$Division.$HQ;

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);
// die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

    public function getPURESUMMARY_List($PURESUMMARY_API,$tdata)
    {
    	if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
    		$Date='';
    	}else{
    		$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
    	}

    	$url=$PURESUMMARY_API.'?BPLID='.$tdata['BPLID'].$Date; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

    public function getPURE_Detailed_List($APINVDETAILS_API,$tdata)
    {
    	if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
    		$Date='';
    	}else{
    		$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
    	}

    	$url=$APINVDETAILS_API.'?BPLID='.$tdata['BPLID'].$Date; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

    public function getSalesRegisterSummary($ARINVSUMMARY_API,$tdata)
    {


    	if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
    		$Date='';
    	}else{
    		$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
    	}

    	$url=$ARINVSUMMARY_API.'?BPLID='.$tdata['BPLID'].$Date; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);
		return $PurchasOrderLinstData;
    }

    public function getSalesRegisterDetailed($ARINVREGDETAILS_API,$tdata)
    {
    	if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
    		// $Date='';
			$CurrentDate=strtotime(date("Y-m-d"));
			$Date='&FromDate='.date("Ymd", strtotime("-1 month", $CurrentDate)).'&ToDate='.date("Ymd");
    	}else{
    		$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
    	}

    	$url=$ARINVREGDETAILS_API.'?BPLID='.$tdata['BPLID'].$Date; // All Parameter Eneter Here
		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

    public function getGSTR1_GSTR2_List_MasterFunction($Final_url)
    {
    	// print_r($Final_url);
    	// die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$GSTR1_List=json_decode($output);
		curl_close($ch);

		return $GSTR1_List;
    }

  	public function getAllListMasterFunction($Final_url)
    {
    	// print_r($Final_url);
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$GSTR1_List=json_decode($output);
		curl_close($ch);

		return $GSTR1_List;
    }

    public function getAllAPListDetails($APINVOICELIST_API,$tdata)
    {
    	if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
    		$Date='&FromDate=&ToDate=&DocEntry=&CardCode=';
    	}else{
    		$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'].'&DocEntry=&CardCode=';
    	}

    	$url=$APINVOICELIST_API.'BPLID='.$_SESSION['BPLID'].$Date; // All Parameter Eneter Here
// echo $url;die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

     public function getIntimationPO_Cancellation_ListDetails($Intimation_Purchase_order_Cancellation_API,$tdata)
    {
    	if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
    		$API=$Intimation_Purchase_order_Cancellation_API;
    	}else{
    		$API=$Intimation_Purchase_order_Cancellation_API.'?FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
    	}

    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

    public function getMaterialDispatchedfromSupplierDetails($AR_InvoiceList_API,$tdata)
    {
    	if(empty($tdata['DocEntry'])){
    		if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
	    		$API=$AR_InvoiceList_API.'FromDate=&ToDate=&DocEntry=';
	    	}else{
	    		$API=$AR_InvoiceList_API.'FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
	    	}
    	}else{
    		$API=$AR_InvoiceList_API.'FromDate=&ToDate=&DocEntry='.$tdata['DocEntry'];
    	}
// print_r($API);
// die();    

    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

    public function getAR_CreditMemoStandDataByDocEntry($API)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

    public function getPayToDrpdownByBusiness($PayTo_URL)
    {
    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$PayTo_URL);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PayToList=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($PayToList) ; $i++) {
			$option .= '<option value="'.$PayToList[$i]->PayTo.'">'.$PayToList[$i]->PayTo.'</option>';
		}      
		return $option;
    }
    
    public function GetExpenceTypeDropdown_APCRMMS($APCRSEXPACCOUNT_API)
    {
    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$APCRSEXPACCOUNT_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$ExTyList=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($ExTyList) ; $i++) {
			$option .= '<option value="'.$ExTyList[$i]->AccountCode.'">'.$ExTyList[$i]->AccountName.'</option>';
		}      
		return $option;
    }

    public function GetTaxCodeDropdown_APCRMMS($PlaceOfSupply,$APCRSTAXCODE_API)
    {
    	if($PlaceOfSupply==$_SESSION['PlaceOfSupply']){
			$Apply='Yes';
    	}else{
			$Apply='No';
    	}

    	$API_URL=$APCRSTAXCODE_API.$Apply;

    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$API_URL);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$TxCodeList=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($TxCodeList) ; $i++) {
			$option .= '<option value="'.$TxCodeList[$i]->Rate.'" id="innerTaxCode'.$TxCodeList[$i]->Rate.'">'.$TxCodeList[$i]->TaxCode.'</option>';
		}      
		return $option;
    }

 	public function SearchGLData($JEGLACCOUNT_API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $JEGLACCOUNT_API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
			$option .= '<style>.fixedHeader {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006;color: white;}</style>

				<div class="row" >
				    <table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;">
				        <thead class="fixedHeader1">
				            <tr>
				                <th></th>
				                <th>Account Code</th>
				                <th>Account Name</th>
				                <th>Account Type</th>
				            </tr>
				        </thead>
				        <tbody>';
	            		for ($i=0; $i <count($response_json_decode) ; $i++) { 
	            			$un_id=$i+1;
                    		$option .= '

								<td style="width: 50px;vertical-align: middle;">
									<input type="checkbox" class="messageCheckbox" id="'.$response_json_decode[$i]->AccountCode.'" name="selectToAdd[]" value="'.$response_json_decode[$i]->AccountCode.'">
								</td>

								<td>
									<input type="text" class="" id="P_AccountCode'.$un_id.'" name="P_AccountCode[]" value="'.$response_json_decode[$i]->AccountCode.'" style="border: transparent;outline: transparent;width: 120px !important;">
								</td>
								<td>
									<input type="text" class="" id="P_AccountName'.$un_id.'" name="P_AccountName[]" value="'.$response_json_decode[$i]->AccountName.'" style="border: transparent;outline: transparent;width: 200px !important;">
								</td>

								<td style="width: 80px">
									<input type="text" class="" id="P_AccountType'.$un_id.'" name="P_AccountType[]" value="'.$response_json_decode[$i]->AccountType.'" style="border: transparent;outline: transparent;width: 50px !important;">
								</td>
	                        </tr>';
	                    }

            $option .= '</tbody> 
    				</table>
				</div> 
				<button id="btner" type="button" class="btn btn-primary w-md" data-bs-dismiss="modal" aria-label="Close" onclick="SelctectedCHK()">Submit </button>';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

 	public function getGL_List($GENERALLEDGGLLIST_API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $GENERALLEDGGLLIST_API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '
				<style>
					.fixedHeader {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006;color: white;}
				</style>

				<div class="row">

				    <table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;">
				        <thead class="fixedHeader1">
				            <tr>
				                <th></th>
				                <th>Account Name</th>
				                <th>Account Code</th>
				                <th>Account Type</th>
				            </tr>
				        </thead>
				        <tbody>';
	            		for ($i=0; $i <count($response_json_decode) ; $i++) { 
	            			$un_id=$i+1;
                    		$option .= '<tr style="vertical-align: middle;">
							    <td>
							    	<input type="radio" class="messageCheckbox" id="SelectedBP_'.$un_id.'" name="selectToAdd[]" value="'.$un_id.'">
							    </td>
								<td class="ItemTablePadding desabled" id="pop_CardName'.$un_id.'">'.$response_json_decode[$i]->AccountName.'</td>
								<td class="ItemTablePadding desabled" id="pop_CardCode'.$un_id.'">'.$response_json_decode[$i]->AccountCode.'</td>
								<td class="ItemTablePadding desabled" id="pop_Balance'.$un_id.'">'.$response_json_decode[$i]->AccountType.'</td>
							</tr>';
	                    }

	                $option .= '</tbody> 
                    </table>

                </div> 
                <button type="button" id="btner" class="btn btn-primary w-md" data-bs-dismiss="modal" aria-label="Close" onclick="SelctectedCHK()">Submit</button>

                ';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

    public function getAllPartyListByBPLID($API_URL)
    {
    	// print_r($API_URL);die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API_URL);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '
				<style>
					.fixedHeader {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006;color: white;}
				</style>
			
			<div class="row" >
				<table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;font-size: 12px;">
                        <thead class="fixedHeader1">
                            <tr>
                            	<th></th>
                                <th>CardCode</th>
                                <th>CardName</th>
                                <th>Balance</th>
                            </tr>
                        </thead>';
	            		for ($i=0; $i <count($response_json_decode) ; $i++) { 
	            			$un_id=$i+1;
                    		$option .= '


                            <tr style="vertical-align: middle;">
								<td>
									<input type="radio" class="messageCheckbox" id="SelectedParty_'.$un_id.'" name="SelectedParty[]" value="'.$un_id.'">
								</td>
								<td class="ItemTablePadding desabled" id="pop_CardCode'.$un_id.'">'.$response_json_decode[$i]->CardCode.'</td>
								<td class="ItemTablePadding desabled" id="pop_CardName'.$un_id.'">'.$response_json_decode[$i]->CardName.'</td>
								<td class="ItemTablePadding desabled" id="pop_Balance'.$un_id.'">'.$response_json_decode[$i]->Balance.'</td>

	                            </tr>';
	                    }

	                $option .= '</tbody> 
                    </table>

                </div> 
                <button type="button" id="btner" class="btn btn-primary w-md" data-bs-dismiss="modal" aria-label="Close" onclick="SelctectedCHK()">Submit</button>

                ';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

    public function getBP_ReconciliationList($API)
    {
    	// print_r($API);die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
        		for ($i=0; $i <count($response_json_decode) ; $i++) { 
        			$un_id=$i+1;
            		$option .= '
					<tr>
					    <th scope="row" class="text-center">
					        <div class="custom-control custom-checkbox">

								<input type="hidden" id="CardCode'.$un_id.'" name="CardCode[]" value="'.$response_json_decode[$i]->CardCode.'">
								<input type="hidden" id="L_CardName'.$un_id.'" name="L_CardName[]" value="'.$response_json_decode[$i]->CardName.'">
								<input type="hidden" id="TransType'.$un_id.'" name="TransType[]" value="'.$response_json_decode[$i]->TransType.'">
								<input type="hidden" id="OriginNo'.$un_id.'" name="OriginNo[]" value="'.$response_json_decode[$i]->OriginNo.'">
								<input type="hidden" id="TransRowID'.$un_id.'" name="TransRowID[]" value="'.$response_json_decode[$i]->TransRowID.'">
								<input type="hidden" id="DocEntry'.$un_id.'" name="DocEntry[]" value="'.$response_json_decode[$i]->DocEntry.'">
								<input type="hidden" id="usercheckList'.$un_id.'" name="usercheckList[]" value="0">

								<input type="checkbox" class="custom-control-input"  id="SelectedBPRec_'.$un_id.'" name="SelectedBPRec[]" value="'.$response_json_decode[$i]->BalanceDue.'" onclick="BPRecSelected('.$un_id.')"><label class="custom-control-label" for="customCheck1"></label>
					        </div>
					    </th>
					    <td class="desabled ItemTablePadding">
					        <input type="text" id="Origin'.$un_id.'" name="Origin[]" value="'.$response_json_decode[$i]->Origin.'" class="form-control desabled_input inputBorderHide" readonly="">
					    </td>
					    <td class="desabled ItemTablePadding">
					        <input type="hidden" id="TransID'.$un_id.'" name="TransID[]" value="'.$response_json_decode[$i]->TransID.'" class="form-control desabled_input inputBorderHide" readonly="">

					        <input type="text" id="SeriesNameDoc'.$un_id.'" name="SeriesNameDoc[]" value="'.$response_json_decode[$i]->SeriesName.'" class="form-control desabled_input inputBorderHide" readonly="">
					    </td>
					    <td class="desabled ItemTablePadding">
					        <input type="text" id="PostingDate'.$un_id.'" name="PostingDate[]" value="'.date('Y-m-d', strtotime($response_json_decode[$i]->PostingDate)).'" class="form-control desabled_input inputBorderHide" readonly="">
					    </td>
					    <td class="desabled ItemTablePadding">
					        <input type="text" id="Amount'.$un_id.'" name="Amount[]" value="'.$response_json_decode[$i]->Amount.'" class="form-control desabled_input inputBorderHide" readonly="">
					    </td>
					   	<td class="desabled ItemTablePadding">
					        <input type="text" id="BalanceDue'.$un_id.'" name="BalanceDue[]" value="'.$response_json_decode[$i]->BalanceDue.'" class="form-control desabled_input inputBorderHide" readonly="">
					    </td>
					    <td class="ItemTablePadding INR_input">
					        <input type="text" id="AmountOfReconcile'.$un_id.'" name="AmountOfReconcile[]" value="'.$response_json_decode[$i]->BalanceDue.'" onfocusout="RowLevelchangeTotalAmountManual('.$un_id.')" class="form-control inputBorderHide" readonly style="background-color: white;">
					    </td>
						<td class="desabled ItemTablePadding">
							<input type="text" id="Details'.$un_id.'" name="Details[]" value="'.$response_json_decode[$i]->Details.'" class="form-control desabled_input inputBorderHide" readonly="">
						</td>
						<td class="desabled ItemTablePadding">
							<input type="text" id="Branch'.$un_id.'" name="Branch[]" value="'.$response_json_decode[$i]->Branch.'" class="form-control desabled_input inputBorderHide" readonly="">
						</td>
					    <td class="ItemTablePadding">
					        <input type="text" id="" name="" class="form-control inputBorderHide" >
					    </td>
					    <td class="ItemTablePadding">
					        <input type="text" id="" name="" class="form-control inputBorderHide" >
					    </td>
					    <td class="ItemTablePadding">
					        <input type="text" id="" name="" class="form-control inputBorderHide" >
					    </td>
					</tr>';
                }
			}else{
				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

    public function getCustomerForPP_List($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '
				<style>
					.fixedHeader {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006;color: white;}
				</style>

				<div class="row">

				    <table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;">
				        <thead class="fixedHeader1">
				            <tr>
				                <th></th>
				                <th>Card Code</th>
				                <th>Customer Name</th>
				            </tr>
				        </thead>
				        <tbody>';
	            		for ($i=0; $i <count($response_json_decode) ; $i++) { 
	            			$un_id=$i+1;
                    		$option .= '<tr style="vertical-align: middle;">
							    <td>
							    	<input type="radio" class="messageCheckbox" id="SelectedBP_'.$un_id.'" name="selectToAdd[]" value="'.$un_id.'">
							    </td>
							    <td class="ItemTablePadding desabled" id="pop_CardCode'.$un_id.'">'.$response_json_decode[$i]->CardCode.'</td>
								<td class="ItemTablePadding desabled" id="pop_CardName'.$un_id.'">'.$response_json_decode[$i]->CardName.'</td>
								
							</tr>';
	                    }

	                $option .= '</tbody> 
                    </table>

                </div> 
                <button type="button" id="btner" class="btn btn-primary w-md" data-bs-dismiss="modal" aria-label="Close" onclick="SelctectedCustomer_CHK()">Submit</button>

                ';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

    public function getCustomer_List($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '
				<style>
					.fixedHeader {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006;color: white;}
				</style>

				<div class="row">

				    <table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;">
				        <thead class="fixedHeader1">
				            <tr>
				                <th></th>
				                <th>Card Code</th>
				                <th>Customer Name</th>
				            </tr>
				        </thead>
				        <tbody>';
	            		for ($i=0; $i <count($response_json_decode) ; $i++) { 
	            			$un_id=$i+1;
                    		$option .= '<tr style="vertical-align: middle;">
							    <td>
							    	<input type="radio" class="messageCheckbox" id="SelectedBP_'.$un_id.'" name="selectToAdd[]" value="'.$un_id.'">
							    </td>
							    <td class="ItemTablePadding desabled" id="pop_CardCode'.$un_id.'">'.$response_json_decode[$i]->CardCode.'</td>
								<td class="ItemTablePadding desabled" id="pop_CardName'.$un_id.'">'.$response_json_decode[$i]->CardName.'</td>
								
							</tr>';
	                    }

	                $option .= '</tbody> 
                    </table>

                </div> 
                <button type="button" id="btner" class="btn btn-primary w-md" data-bs-dismiss="modal" aria-label="Close" onclick="SelctectedCHK()">Submit</button>

                ';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

    public function GetItemList($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
// echo '<pre>';
// print_r($unique);
// die();
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '
				<style>
					.fixedHeader {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006;color: white;}
				</style>

				<div class="row">

				    <table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;">
				        <thead class="fixedHeader1">
				            <tr>
				                <th></th>
				                <th>Item Code</th>
				                <th>Item Name</th>
				            </tr>
				        </thead>
				        <tbody>';
	            		for ($i=0; $i <count($response_json_decode) ; $i++) { 
	            			$un_id=$i+1;
                    		$option .= '<tr style="vertical-align: middle;">
							    <td>
							    	<input type="radio" class="messageCheckbox" id="SelectedBP_'.$un_id.'" name="selectToAdd[]" value="'.$un_id.'">
							    </td>
							    <td class="ItemTablePadding desabled" id="pop_ItemCode'.$un_id.'">'.$response_json_decode[$i]->ItemCode.'</td>
								<td class="ItemTablePadding desabled" id="pop_ItemName'.$un_id.'">'.$response_json_decode[$i]->ItemName.'</td>
								
							</tr>';
	                    }

	                $option .= '</tbody> 
                    </table>

                </div> 
                <button type="button" id="btner" class="btn btn-primary w-md" data-bs-dismiss="modal" aria-label="Close" onclick="SelctectedCHK()">Submit</button>

                ';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

    public function getBP_List($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '
				<style>
					.fixedHeader {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006;color: white;}
				</style>

				<div class="row">

				    <table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;">
				        <thead class="fixedHeader1">
				            <tr>
				                <th></th>
				                <th>BP Name</th>
				                <th>BP Code</th>
				                <th>BP Balance</th>
				            </tr>
				        </thead>
				        <tbody>';
	            		for ($i=0; $i <count($response_json_decode) ; $i++) { 
	            			$un_id=$i+1;
                    		$option .= '<tr style="vertical-align: middle;">
							    <td>
							    	<input type="radio" class="messageCheckbox" id="SelectedBP_'.$un_id.'" name="selectToAdd[]" value="'.$un_id.'">
							    </td>
								<td class="ItemTablePadding desabled" id="pop_CardName'.$un_id.'">'.$response_json_decode[$i]->CardName.'</td>
								<td class="ItemTablePadding desabled" id="pop_CardCode'.$un_id.'">'.$response_json_decode[$i]->CardCode.'</td>
								<td class="ItemTablePadding desabled" id="pop_Balance'.$un_id.'">'.$response_json_decode[$i]->Balance.'</td>
							</tr>';
	                    }

	                $option .= '</tbody> 
                    </table>

                </div> 
                <button type="button" id="btner" class="btn btn-primary w-md" data-bs-dismiss="modal" aria-label="Close" onclick="SelctectedCHK()">Submit</button>

                ';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

    public function SearchItemData($PO_ItemDetailsAPI,$tdata)
    {
		//<!-- ---------Parameter Prepare start here------------ -->
			$ItemName='';$ItemGroup='';$Category1='';$Category2='';$Category3='';$WhsCode='';$CardCode='';$PSupply='';

			if(!empty($tdata['ItemName'])){
				$ItemName = "&ItemName=".$tdata['ItemName'];
			}
			if(!empty($tdata['ItemGroup'])){
				$ItemGroup = "&ItemGroup=".$tdata['ItemGroup'];
			}
			if(!empty($tdata['Category1'])){
				$Category1 = "&Category1=".$tdata['Category1'];
			}
			if(!empty($tdata['Category2'])){
				$Category2 = "&Category2=".$tdata['Category2'];
			}
			if(!empty($tdata['Category3'])){
				$Category3 = "&Category3=".$tdata['Category3'];
			}
			if(!empty($tdata['WhsCode'])){
				$WhsCode = "&WhsCode=".$tdata['WhsCode'];
			}
			if(!empty($tdata['CardCode'])){
				$CardCode = "&CardCode=".$tdata['CardCode'];
			}
			if(!empty($tdata['PSupply'])){
				$PSupply = "&PSupply=".$tdata['PSupply'];
			}

		//<!-- ---------Parameter Prepare End here------------ -->
	
		$url=$PO_ItemDetailsAPI.$ItemName.$ItemGroup.$Category1.$Category2.$Category3.$WhsCode.$CardCode.$PSupply; // All Parameter Eneter Here

// print_r($url);die();
		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '
				<style>
					.fixedHeader {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006;color: white;}
				</style>

				<div class="col-12">
			        <div class="card">
			            <div class="card-body" style="position: relative;overflow: auto;width: 100%;">

			            <div class="table-responsive">

                     	<div style="display: block;overflow-x: auto;white-space: nowrap;height: 410px;"> 

			                <table id="example" class="table table-bordered" >
			                    <thead class="fixedHeader">
			                        <tr>
			                            <th></th>
										<th>InStock</th>
										<th>Quantity</th>
			                            <th>ItemCode</th>
			                            <th>ItemName</th>
			                            <th>ItemgroCode</th>
			                            <th>ItemgroName</th>
			                            <th>Category1</th>
			                            <th>UnitPrice</th>
			                            <th>HSNCode</th>
			                            <th>HSNEntry</th>
			                            <th>UOM</th>
			                            <th>TaxCode</th>
			                            <th>MRP</th>
			                            <th>BDRate</th>
			                            <th>PTR</th>
			                            <th>PTS</th>
			                           
			                        </tr>
			                    </thead>

			                    <tbody>';
	            		for ($i=0; $i <count($response_json_decode) ; $i++) { 
	            			$un_id=$i+1;
                    		$option .= '<tr>
<td style="width: 100px">
	<input type="checkbox" class="messageCheckbox" id="'.$response_json_decode[$i]->ItemCode.'_'.$un_id.'" name="selectToAdd[]" value="'.$response_json_decode[$i]->ItemCode.'" disabled>
</td>

<td  data-bs-toggle="modal" data-bs-target=".bs-example-modal-popup" onclick="PO_ItemBatch(\''.$response_json_decode[$i]->ItemCode.'\')"><u style="color:#b90006;cursor: pointer;">&nbsp;'.$response_json_decode[$i]->InStock.'&nbsp;</u></td>

<td style="width: 80px">
	<input type="text" class="messageCheckbox'.$un_id.'" id="S_Quantity'.$un_id.'" name="S_Quantity[]" onfocusout="checkBoxVisible(\''.$un_id.'\',\''.$response_json_decode[$i]->ItemCode.'\');" style="border: transparent;outline: transparent;width: 50px !important;" onkeyup="keyPressed_New('.$un_id.',event)">
</td>


								<td>'.$response_json_decode[$i]->ItemCode.'</td>
								<td>'.$response_json_decode[$i]->ItemName.'</td>
								<td>'.$response_json_decode[$i]->ItemgroCode.'</td>
								<td>'.$response_json_decode[$i]->ItemgroName.'</td>
								<td>'.$response_json_decode[$i]->Category1.'</td>
								<td>'.$response_json_decode[$i]->UnitPrice.'</td>
								<td>'.$response_json_decode[$i]->HSNCode.'</td>
								<td>'.$response_json_decode[$i]->HSNEntry.'</td>
								<td>'.$response_json_decode[$i]->UOM.'</td>
								<td>'.$response_json_decode[$i]->TaxCode.'</td>
								<td>'.$response_json_decode[$i]->MRP.'</td>
								<td>'.$response_json_decode[$i]->BDRate.'</td>
								<td>'.$response_json_decode[$i]->PTR.'</td>
								<td>'.$response_json_decode[$i]->PTS.'</td>
								
	                        </tr>';
	                    }

	                $option .= '</tbody>
			                </table>
			                </div>
							</div>
			            </div>
						<div class="col-xl-3 col-md-6" style="padding: 20px;margin-top: -25px;">
							<button id="btn" class="btn btn-primary w-md"  data-bs-dismiss="modal" aria-label="Close" onclick="SelctectedCHK()">Add</button>
						</div>
			        </div>
			    </div>';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

    public function getPO_ItemBatchByItemCode($PO_ItemDetailsAPI,$tdata)
    {
		$url=$PO_ItemDetailsAPI.'CardCode='.$tdata['CardCode'].'&WhsCode='.$tdata['WhsCode'].'&ItemCode='.$tdata['ItemCode'].'&PSupply='.$tdata['PSupply']; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
		
		// ================PO Item Batch Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
	    		for ($i=0; $i <count($response_json_decode) ; $i++) { 

					$option .= '<tr>
							<td>'.$response_json_decode[$i]->BatchNo.'</td>
							<td>'.$response_json_decode[$i]->BatchQty.'</td>
							<td>'.$response_json_decode[$i]->MRP.'</td>
							<td>'.$response_json_decode[$i]->PTR.'</td>
							<td>'.$response_json_decode[$i]->PTS.'</td>
							<td>'.$response_json_decode[$i]->MfgDate.'</td>
							<td>'.$response_json_decode[$i]->ExpDate.'</td>
						</tr>';
	            	}
			}else{
				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// ================PO Item Batch Data Table Prepare End Here============================================

		return $option;
    }

     public function SearchAP_StandItem($API,$tdata)
    {
		//<!-- ---------Parameter Prepare start here------------ -->
			$ItemName='';$ItemGroup='';$Category1='';$Category2='';$Category3='';

			if(!empty($tdata['ItemName'])){
				$ItemName = "&ItemName=".$tdata['ItemName'];
			}
			if(!empty($tdata['ItemGroup'])){
				$ItemGroup = "&ItemGroup=".$tdata['ItemGroup'];
			}
			if(!empty($tdata['Category1'])){
				$Category1 = "&Category1=".$tdata['Category1'];
			}
			if(!empty($tdata['Category2'])){
				$Category2 = "&Category2=".$tdata['Category2'];
			}
			if(!empty($tdata['Category3'])){
				$Category3 = "&Category3=".$tdata['Category3'];
			}
		//<!-- ---------Parameter Prepare End here------------ -->

		$rowCount=$_POST['rowCount'];
	
		$url=$API.$ItemName.$ItemGroup.$Category1.$Category2.$Category3; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
        		for ($i=0; $i <count($response_json_decode) ; $i++) { 

        			$id=$i+1;
                	

                	// if($response_json_decode[$i]->PTS!=''){
        				$option .= '<tr id='.$id.'>';
        			// }else{
        			// 	$option .= '<tr id='.$id.' style="background-color:#CECECE;">';
        			// }
            			
						
						$option .= '<td style="width: 100px" class="ItemTablePadding">
							<input type="checkbox" class="messageCheckbox" id="'.$response_json_decode[$i]->ItemCode.'_'.$response_json_decode[$i]->MRP.'" name="selectToAdd[]" value="'.$response_json_decode[$i]->ItemCode.'_'.$response_json_decode[$i]->MRP.'" disabled style="margin-top:7px;">
						</td>

						<td style="width: 80px">
							<input type="text" class="messageCheckbox'.$id.'" id="in_'.$response_json_decode[$i]->ItemCode.'_'.$response_json_decode[$i]->MRP.'" name="Quantity[]" onfocusout="checkBoxVisible(\''.$response_json_decode[$i]->ItemCode.'_'.$response_json_decode[$i]->MRP.'\','.$id.');" style="border: transparent;outline: transparent;width: 50px !important;" onkeyup="keyPressed('.$id.',event)">
						</td>

						<td>'.$response_json_decode[$i]->ItemCode.'</td>
						<td>'.$response_json_decode[$i]->ItemName.'</td>
						<td>'.$response_json_decode[$i]->ItemgroCode.'</td>
						<td>'.$response_json_decode[$i]->ItemgroName.'</td>
						<td>'.$response_json_decode[$i]->InStock.'</td>
						<td>'.$response_json_decode[$i]->Category1.'</td>
						<td>'.$response_json_decode[$i]->UnitPrice.'</td>
						<td>'.$response_json_decode[$i]->HSNCode.'</td>
						<td>'.$response_json_decode[$i]->HSNEntry.'</td>
						<td>'.$response_json_decode[$i]->UOM.'</td>
						<td>'.$response_json_decode[$i]->TaxRate.'</td>
						<td id="i_MRP'.$id.'">'.$response_json_decode[$i]->MRP.'</td>
						<td>'.$response_json_decode[$i]->BDRate.'</td>
						<td id="i_PTR'.$id.'">'.$response_json_decode[$i]->PTR.'</td>
						<td id="i_PTS'.$id.'">'.$response_json_decode[$i]->PTS.'</td>
						<td>'.$response_json_decode[$i]->TCSRate.'</td>
                    </tr>';
                }

                $option .= '';
			}else{
				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

    public function GetAPCRMMST_ItemBatchData($BatchAPI)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $BatchAPI);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);
		return $response;
    }

    public function get_APCRMMS_SAC_List($APCRSEXPACCOUNT_API,$rowCount)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $APCRSEXPACCOUNT_API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);
		$response_json_decode=json_decode($response);
		
		// ============================= SAC Data Table Prepare start Here============================================

			$option ='';
			if(!empty($response_json_decode)){
					
	    		for ($i=0; $i <count($response_json_decode) ; $i++) { 

				$id=$i+1;
		                    		
					$option .= '<tr id='.$id.'>

						<td style="width: 40px;text-align: center;vertical-align: middle;" class="ItemTablePadding">
							<input type="checkbox" class="messageCheckbox" id="in_'.$response_json_decode[$i]->AccountCode.'" name="selectToAdd[]" value="'.$response_json_decode[$i]->AccountCode.'">
						</td>
						<td id="AccountCode'.$id.'">'.$response_json_decode[$i]->AccountCode.'</td>					
						<td id="AccountName'.$id.'">'.$response_json_decode[$i]->AccountName.'</td>
						<td id="AccountType'.$id.'">'.$response_json_decode[$i]->AccountType.'</td>
	                </tr>';
	            }
			}else{
				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

    public function get_APCRMMS_SAC_List_New($APCRSSACCODE_API,$row_id)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $APCRSSACCODE_API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);
		$response_json_decode=json_decode($response);
		
		// ============================= SAC Data Table Prepare start Here============================================
		$response=array();
			$response['option'] ='';
			if(!empty($response_json_decode)){
					
	    		for ($i=0; $i <count($response_json_decode) ; $i++) { 

				$id=$i+1;
		                    		
					$response['option'] .= '<tr id='.$id.'>

						<td style="width: 40px;text-align: center;vertical-align: middle;" class="ItemTablePadding">
							<input type="radio" class="messageCheckbox" id="in_'.$id.'" name="SAC_selectToAdd[]" value="'.$id.'">

							<input type="hidden" id="new_SACEntry'.$id.'" name="new_SACEntry[]"  value="'.$response_json_decode[$i]->SACEntry.'">
						</td>
						<td id="new_SACCode'.$id.'">'.$response_json_decode[$i]->SACCode.'</td>					
						<td id="new_SACName'.$id.'">'.$response_json_decode[$i]->SACName.'</td>
	                </tr>';
	            }
			}else{
				$response['option'] .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================
			
			$response['row_id']=$row_id;
		return json_encode($response);
    }

    public function SearchItemDataForAPCRMM($API,$tdata)
    {
		//<!-- ---------Parameter Prepare start here------------ -->
			$ItemName='';$ItemGroup='';$Category1='';$Category2='';$Category3='';$formAge='';$ToAge='';$TypeOfBatch='';


			if(!empty($tdata['ItemName'])){
				$ItemName = "&ItemName=".$tdata['ItemName'];
			}
			if(!empty($tdata['ItemGroup'])){
				$ItemGroup = "&ItemGroup=".$tdata['ItemGroup'];
			}
			if(!empty($tdata['Category1'])){
				$Category1 = "&Category1=".$tdata['Category1'];
			}
			if(!empty($tdata['Category2'])){
				$Category2 = "&Category2=".$tdata['Category2'];
			}
			if(!empty($tdata['Category3'])){
				$Category3 = "&Category3=".$tdata['Category3'];
			}

			if(!empty($tdata['formAge'])){
				$formAge = "&formAge=".$tdata['formAge'];
			}
			if(!empty($tdata['ToAge'])){
				$ToAge = "&ToAge=".$tdata['ToAge'];
			}
			if(!empty($tdata['TypeOfBatch'])){
				$TypeOfBatch = "&TypeOfBatch=".$tdata['TypeOfBatch'];
			}


		//<!-- ---------Parameter Prepare End here------------ -->

		$rowCount=$_POST['rowCount'];
	
		$url=$API.$ItemName.$ItemGroup.$Category1.$Category2.$Category3.$formAge.$ToAge.$TypeOfBatch; // All Parameter Eneter Here
// print_r($url);die();
		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
 // print_r($Final_url);die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);
// print_r($response);die();
		$response_json_decode=json_decode($response);
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
				// $option .= '
				// <style>
				// 	.fixedHeader {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006;color: white;}
				// </style>
				// <input type="hidden" name="tbodyRowCount" id="tbodyRowCount" value="'.$tdata['tbodyRowCount'].'">
				// ';
	            		for ($i=0; $i <count($response_json_decode) ; $i++) { 

	            			$id=$i+1;
							// ----------------------------------- tr tag condition start Here ---------------
								$RemainAge=$response_json_decode[$i]->RemainAge;
								// $CurrentDate = date('Y-m-d');
								// $ExpDate = date('Y-m-d', strtotime($response_json_decode[$i]->ExpiryDate));

								// $date1_ts = strtotime($CurrentDate);
								// $date2_ts = strtotime($ExpDate);
								// $diff = $date2_ts - $date1_ts;
								// $dateDiff= round($diff / 86400);
								// $dateDiff = $this->dateDiff($CurrentDate, $ExpDate);

								if ($RemainAge < 0){
								    if ($RemainAge >= -180){
								    	$option .= '<tr id='.$id.' style="background-color: bisque;">';
								    }else{
								    	if($response_json_decode[$i]->PTS!=''){
											$option .= '<tr id='.$id.'>';
										}else{
											$option .= '<tr id='.$id.' style="background-color:#CECECE;">';
										}
								    }
								}else{
									if($response_json_decode[$i]->PTS!=''){
										$option .= '<tr id='.$id.'>';
									}else{
										$option .= '<tr id='.$id.' style="background-color:#CECECE;">';
									}
								}
							// ----------------------------------- tr tag condition end Here ---------------

							$option .= '<td style="width: 100px" class="ItemTablePadding">
								<input type="checkbox" class="messageCheckbox" id="'.$response_json_decode[$i]->ItemCode.'_'.$response_json_decode[$i]->Batch.'" name="selectToAdd[]" value="'.$response_json_decode[$i]->ItemCode.'_'.$response_json_decode[$i]->Batch.'" disabled style="margin-top:8px;">
							</td>

							<td style="width: 80px">
								<input type="text" class="messageCheckbox'.$id.'" id="in_'.$response_json_decode[$i]->ItemCode.'_'.$response_json_decode[$i]->Batch.'" name="Quantity[]" onfocusout="checkBoxVisible(\''.$response_json_decode[$i]->ItemCode.'_'.$response_json_decode[$i]->Batch.'\','.$id.');" style="border: transparent;outline: transparent;width: 50px !important;" onkeyup="keyPressed('.$id.',event)">
							</td>

							<td>'.$response_json_decode[$i]->ItemCode.'</td>
							<td>'.$response_json_decode[$i]->ItemName.'</td>
							<td>'.$response_json_decode[$i]->Batch.'</td>
							<td  id="i_InStock'.$id.'">'.$response_json_decode[$i]->InStock.'</td>
							<td style="display:none;">'.$response_json_decode[$i]->SelectQty.'</td>
							<td>'.$response_json_decode[$i]->WhsCode.'</td>
							<td>'.$response_json_decode[$i]->MfgDate.'</td>
							<td>'.$response_json_decode[$i]->ExpiryDate.'</td>
							<td>'.$response_json_decode[$i]->Discount.'</td>
							<td id="i_MRP'.$id.'">'.$response_json_decode[$i]->MRP.'</td>
							<td id="i_PTR'.$id.'">'.$response_json_decode[$i]->PTR.'</td>
							<td id="i_PTS'.$id.'">'.$response_json_decode[$i]->PTS.'</td>
							<td>'.$response_json_decode[$i]->TaxRate.'</td>
							<td>'.$response_json_decode[$i]->ChapterID.'</td>
							<td>'.$response_json_decode[$i]->TaxCode.'</td>
							<td>'.$response_json_decode[$i]->Division.'</td>
							<td>'.$response_json_decode[$i]->TCSRate.'</td>
							<td>'.$response_json_decode[$i]->RemainAge.'</td>
							<td>'.$response_json_decode[$i]->Type.'</td>
	                        </tr>';
	                    }

	                $option .= '';
			}else{
				$option .= '<td style="text-align: center;color:#b90006;font-weight: bold;" colspan="20">Record Not Found</td>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }



    public function SearchItemDataForARCRMM($API,$tdata)
    {
		//<!-- ---------Parameter Prepare start here------------ -->
			$ItemName='';$ItemGroup='';$Category1='';$Category2='';$Category3='';$formAge='';$ToAge='';$TypeOfBatch='';


			if(!empty($tdata['ItemName'])){
				$ItemName = "&ItemName=".$tdata['ItemName'];
			}
			if(!empty($tdata['ItemGroup'])){
				$ItemGroup = "&ItemGroup=".$tdata['ItemGroup'];
			}
			if(!empty($tdata['Category1'])){
				$Category1 = "&Category1=".$tdata['Category1'];
			}
			if(!empty($tdata['Category2'])){
				$Category2 = "&Category2=".$tdata['Category2'];
			}
			if(!empty($tdata['Category3'])){
				$Category3 = "&Category3=".$tdata['Category3'];
			}

			if(!empty($tdata['formAge'])){
				$formAge = "&formAge=".$tdata['formAge'];
			}
			if(!empty($tdata['ToAge'])){
				$ToAge = "&ToAge=".$tdata['ToAge'];
			}
			if(!empty($tdata['TypeOfBatch'])){
				$TypeOfBatch = "&TypeOfBatch=".$tdata['TypeOfBatch'];
			}

			if(!empty($tdata['FromAge'])){
				$FromAge = "&FromAge=".$tdata['FromAge'];
			}
			
		//<!-- ---------Parameter Prepare End here------------ -->

		$rowCount=$_POST['rowCount'];
	
		$url=$API.$ItemName.$ItemGroup.$Category1.$Category2.$Category3.$formAge.$ToAge.$TypeOfBatch.$FromAge; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);
// print_r($response);die();
		$response_json_decode=json_decode($response);
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
		if(!empty($tdata['TypeOfBatch'])){
			if(!empty($response_json_decode)){
				
				// $option .= '
				// <style>
				// 	.fixedHeader {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006;color: white;}
				// </style>
				// <input type="hidden" name="tbodyRowCount" id="tbodyRowCount" value="'.$tdata['tbodyRowCount'].'">
				// ';
	            		for ($i=0; $i <count($response_json_decode) ; $i++) { 

	            			$id=$i+1;
	                    	

	                    	if($response_json_decode[$i]->PTS!=''){
	            				$option .= '<tr id='.$id.'>';
	            			}else{
	            				$option .= '<tr id='.$id.' style="background-color:#CECECE;">';
	            			}
                    			
							$CustomId = str_replace(' ', '', $response_json_decode[$i]->ItemCode.'_'.$response_json_decode[$i]->Batch.'_'.$response_json_decode[$i]->InStock); // All blank space replace to '_'

						
							$option .= '<td style="width: 100px" class="ItemTablePadding">
								<input type="checkbox" class="messageCheckbox" id="'.$CustomId.'" name="selectToAdd[]" value="'.$CustomId.'" disabled>
							</td>

							<td style="width: 80px">
								<input type="text" class="messageCheckbox'.$id.'" id="in_'.$CustomId.'" name="Quantity[]" onfocusout="checkBoxVisible(\''.$CustomId.'\','.$id.');" style="border: transparent;outline: transparent;width: 50px !important;" onkeyup="keyPressed('.$id.',event)">

									<input type="hidden" id="i_RefNo'.$id.'" name="i_RefNo[]" value="'.$response_json_decode[$i]->RefNo.'">
									<input type="hidden" id="i_OrginalRefDate'.$id.'" name="i_OrginalRefDate[]" value="'.date("Y-m-d", strtotime(trim($response_json_decode[$i]->OrginalRefDate))).'">
							</td>

							<td>'.$response_json_decode[$i]->ItemCode.'</td>
							<td>'.$response_json_decode[$i]->ItemName.'</td>
							<td>'.$response_json_decode[$i]->Batch.'</td>
							<td id="i_InStock'.$id.'">'.$response_json_decode[$i]->InStock.'</td>
							<td>'.$response_json_decode[$i]->WhsCode.'</td>
							<td>'.$response_json_decode[$i]->MfgDate.'</td>
							<td>'.$response_json_decode[$i]->ExpiryDate.'</td>
							<td>'.$response_json_decode[$i]->Discount.'</td>
							<td id="i_MRP'.$id.'">'.$response_json_decode[$i]->MRP.'</td>
							<td id="i_PTR'.$id.'">'.$response_json_decode[$i]->PTR.'</td>
							<td id="i_PTS'.$id.'">'.$response_json_decode[$i]->PTS.'</td>
							<td>'.$response_json_decode[$i]->TaxRate.'</td>
							<td>'.$response_json_decode[$i]->ChapterID.'</td>
							<td>'.$response_json_decode[$i]->TaxCode.'</td>
							<td>'.$response_json_decode[$i]->Division.'</td>
							<td>'.$response_json_decode[$i]->TCSRate.'</td>
							<td>'.$response_json_decode[$i]->RemainAge.'</td>
							<td>'.$response_json_decode[$i]->Type.'</td>
							<td></td>
							<td></td>
	                        </tr>';
	                    }

	                $option .= '';
			}else{
				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		}else{
			$option .= '<span style="text-align: center;color:red;">Select Type Of Batch </span>';
		}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

     public function SearchOldInvoiceListForARCRMM($API,$tdata)
    {
    	//<!-- ---------Parameter Prepare start here------------ -->
			$ItemName='';$ItemGroup='';$Category1='';$Category2='';$Category3='';$formAge='';$ToAge='';$TypeOfBatch='';


			if(!empty($tdata['ItemName'])){
				$ItemName = "&ItemName=".$tdata['ItemName'];
			}
			if(!empty($tdata['ItemGroup'])){
				$ItemGroup = "&ItemGroup=".$tdata['ItemGroup'];
			}
			if(!empty($tdata['Category1'])){
				$Category1 = "&Category1=".$tdata['Category1'];
			}
			if(!empty($tdata['Category2'])){
				$Category2 = "&Category2=".$tdata['Category2'];
			}
			if(!empty($tdata['Category3'])){
				$Category3 = "&Category3=".$tdata['Category3'];
			}

			if(!empty($tdata['formAge'])){
				$formAge = "&formAge=".$tdata['formAge'];
			}
			if(!empty($tdata['ToAge'])){
				$ToAge = "&ToAge=".$tdata['ToAge'];
			}
			if(!empty($tdata['TypeOfBatch'])){
				$TypeOfBatch = "&TypeOfBatch=".$tdata['TypeOfBatch'];
			}

			if(!empty($tdata['FromAge'])){
				$FromAge = "&FromAge=".$tdata['FromAge'];
			}
			
		//<!-- ---------Parameter Prepare End here------------ -->

		$rowCount=$_POST['rowCount'];
	
		$url=$API.$ItemName.$ItemGroup.$Category1.$Category2.$Category3.$formAge.$ToAge.$TypeOfBatch.$FromAge; // All Parameter Eneter Here
// print_r($url);die();
// 		//<!-- ---------Parameter Prepare start here------------ -->
// 			$ItemName='';$ItemGroup='';$Category1='';

// 			if(!empty($tdata['ItemName'])){ $ItemName = "&ItemName=".$tdata['ItemName']; }
// 			if(!empty($tdata['ItemGroup'])){ $ItemGroup = "&ItemGroup=".$tdata['ItemGroup']; }
// 			if(!empty($tdata['Category1'])){ $Category1 = "&Category1=".$tdata['Category1']; }
			
// 		//<!-- ---------Parameter Prepare End here------------ -->

// 		$rowCount=$_POST['rowCount'];
	
// 		$url=$API.$ItemName.$ItemGroup.$Category1; // All Parameter Eneter Here
// // print_r($url);die();
		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);
// print_r($response);die();
		$response_json_decode=json_decode($response);
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
				// $option .= '
				// <style>
				// 	.fixedHeader {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006;color: white;}
				// </style>
				// <input type="hidden" name="tbodyRowCount" id="tbodyRowCount" value="'.$tdata['tbodyRowCount'].'">
				// ';
	            		for ($i=0; $i <count($response_json_decode) ; $i++) { 

	            			$id=$i+1;
	                    	

	                    	if($response_json_decode[$i]->PTS!=''){
	            				$option .= '<tr id='.$id.'>';
	            			}else{
	            				$option .= '<tr id='.$id.' style="background-color:#CECECE;">';
	            			}
                    			
								
$option .= '<td style="width: 100px" class="ItemTablePadding">
	<input type="checkbox" class="messageCheckbox" id="'.$response_json_decode[$i]->Row.'" name="selectToAdd[]" 
	value="'.$response_json_decode[$i]->Row.'" 
	disabled>
</td>

<td style="width: 80px">
	<input type="text" class="messageCheckbox'.$id.'" id="in_'.$response_json_decode[$i]->Row.'" name="Quantity[]" onfocusout="checkBoxVisibleItemMaster(\''.$response_json_decode[$i]->Row.'\','.$id.');" style="border: transparent;outline: transparent;width: 50px !important;" onkeyup="keyPressed('.$id.',event)">
</td>

							<td>'.$response_json_decode[$i]->ItemCode.'</td>
							<td>'.$response_json_decode[$i]->ItemName.'</td>
							<td>'.$response_json_decode[$i]->BatchNo.'</td>
							<td id="i_InStock'.$id.'">'.$response_json_decode[$i]->InStock.'</td>
							
							<td>'.$_SESSION['DefaultWareHouseId'].'</td>
							<td>'.date("d/m/Y", strtotime(trim($response_json_decode[$i]->MfgDate))).'</td>
							<td>'.date("d/m/Y", strtotime(trim($response_json_decode[$i]->ExpDate))).'</td>
							<td>'.$response_json_decode[$i]->Discount.'</td>
							<td id="i_MRP'.$id.'">'.$response_json_decode[$i]->MRP.'</td>
							<td id="i_PTR'.$id.'">'.$response_json_decode[$i]->PTR.'</td>
							<td id="i_PTS'.$id.'">'.$response_json_decode[$i]->PTS.'</td>
							<td>'.$response_json_decode[$i]->TaxRate.'</td>
							<td>'.$response_json_decode[$i]->ChapterID.'</td>
							<td>'.$response_json_decode[$i]->TaxCode.'</td>

							<td>'.$response_json_decode[$i]->Division.'</td>
							<td></td>
							<td>'.$response_json_decode[$i]->RemainAge.'</td>
							<td>'.$response_json_decode[$i]->Type.'</td>
							<td>'.$response_json_decode[$i]->BillNo.'</td>
							<td>'.date("d/m/Y", strtotime(trim($response_json_decode[$i]->BillDate))).'</td>
	                        </tr>';
	                    }

	                $option .= '';
			}else{
				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

    public function SearchItemMasterDataForARCRMM($API,$tdata)
    {

    	//<!-- ---------Parameter Prepare start here------------ -->
			$ItemName='';$ItemGroup='';$Category1='';$Category2='';$Category3='';$formAge='';$ToAge='';$TypeOfBatch='';


			if(!empty($tdata['ItemName'])){
				$ItemName = "&ItemName=".$tdata['ItemName'];
			}
			if(!empty($tdata['ItemGroup'])){
				$ItemGroup = "&ItemGroup=".$tdata['ItemGroup'];
			}
			if(!empty($tdata['Category1'])){
				$Category1 = "&Category1=".$tdata['Category1'];
			}
			if(!empty($tdata['Category2'])){
				$Category2 = "&Category2=".$tdata['Category2'];
			}
			if(!empty($tdata['Category3'])){
				$Category3 = "&Category3=".$tdata['Category3'];
			}

			if(!empty($tdata['formAge'])){
				$formAge = "&formAge=".$tdata['formAge'];
			}
			if(!empty($tdata['ToAge'])){
				$ToAge = "&ToAge=".$tdata['ToAge'];
			}
			if(!empty($tdata['TypeOfBatch'])){
				$TypeOfBatch = "&TypeOfBatch=".$tdata['TypeOfBatch'];
			}

			if(!empty($tdata['FromAge'])){
				$FromAge = "&FromAge=".$tdata['FromAge'];
			}
			
		//<!-- ---------Parameter Prepare End here------------ -->

		$rowCount=$_POST['rowCount'];
	
		$url=$API.$ItemName.$ItemGroup.$Category1.$Category2.$Category3.$formAge.$ToAge.$FromAge; // All Parameter Eneter Here
// print_r($url);die();
// 		//<!-- ---------Parameter Prepare start here------------ -->
// 			$ItemName='';$ItemGroup='';$Category1='';

// 			if(!empty($tdata['ItemName'])){ $ItemName = "&ItemName=".$tdata['ItemName']; }
// 			if(!empty($tdata['ItemGroup'])){ $ItemGroup = "&ItemGroup=".$tdata['ItemGroup']; }
// 			if(!empty($tdata['Category1'])){ $Category1 = "&Category1=".$tdata['Category1']; }
			
// 		//<!-- ---------Parameter Prepare End here------------ -->

// 		$rowCount=$_POST['rowCount'];
	
// 		$url=$API.$ItemName.$ItemGroup.$Category1.$Category2.$Category3.$formAge.$ToAge.$TypeOfBatch.$FromAge; // All Parameter Eneter Here
// // print_r($url);die();
		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);
// print_r($response);die();
		$response_json_decode=json_decode($response);
		
		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
				// $option .= '
				// <style>
				// 	.fixedHeader {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006;color: white;}
				// </style>
				// <input type="hidden" name="tbodyRowCount" id="tbodyRowCount" value="'.$tdata['tbodyRowCount'].'">
				// ';
	            		for ($i=0; $i <count($response_json_decode) ; $i++) { 

	            			$id=$i+1;
	                    	

	                    	if($response_json_decode[$i]->PTS!=''){
	            				$option .= '<tr id='.$id.'>';
	            			}else{
	            				$option .= '<tr id='.$id.' style="background-color:#CECECE;">';
	            			}
                    			
								
$option .= '<td style="width: 100px" class="ItemTablePadding">
	<input type="checkbox" class="messageCheckbox" id="'.$response_json_decode[$i]->ItemCode.'" name="selectToAdd[]" value="'.$response_json_decode[$i]->ItemCode.'" disabled>
</td>

<td style="width: 80px">
	<input type="text" class="messageCheckbox'.$id.'" id="in_'.$response_json_decode[$i]->ItemCode.'" name="Quantity[]" onfocusout="checkBoxVisibleItemMaster(\''.$response_json_decode[$i]->ItemCode.'\','.$id.');" style="border: transparent;outline: transparent;width: 50px !important;" onkeyup="keyPressed('.$id.',event)">
</td>

							<td>'.$response_json_decode[$i]->ItemCode.'</td>
							<td>'.$response_json_decode[$i]->ItemName.'</td>
							<td></td>
							<td id="i_InStock'.$id.'">'.$response_json_decode[$i]->InStock.'</td>
							
							<td>'.$_SESSION['DefaultWareHouseId'].'</td>
							<td></td>
							<td></td>
							<td></td>
							<td id="i_MRP'.$id.'">'.$response_json_decode[$i]->MRP.'</td>
							<td id="i_PTR'.$id.'">'.$response_json_decode[$i]->PTR.'</td>
							<td id="i_PTS'.$id.'">'.$response_json_decode[$i]->PTS.'</td>
							<td>'.$response_json_decode[$i]->TaxRate.'</td>
							<td>'.$response_json_decode[$i]->HSNCode.'</td>
							<td>'.$response_json_decode[$i]->TaxCode.'</td>
							<td>'.$response_json_decode[$i]->Division.'</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
	                        </tr>';
	                    }

	                $option .= '';
			}else{
				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Search Data Table Prepare End Here============================================

		return $option;
    }

    public function getAPCRMM_StandaloneItemInRowLevel($API,$ItemCode,$quantityValGet,$rowCount)
    {
		// print_r($API);
		// die();
    	
    	// ===================================== get All Item List start Here ========================================	

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		
		curl_close($ch);

		$response_json_decode=json_decode($response);

		// ===================================== get All Item List end Here =========================================

		// =============================Selected Data Table Prepare start Here============================================
		
if(!empty($response_json_decode)){
	$selectedItemDataExplode= explode(',', $ItemCode); // item code selected by user
	$quantityValGetDataExplode= explode(',', $quantityValGet); //Item Quantity enter by user
	
	for ($y=0; $y <count($response_json_decode) ; $y++) { 
		$id=$y+1;
		$un_id=$rowCount+$id;  // create unique id with the help of tbody row count
		
		
			for ($x=0; $x <count($response_json_decode) ; $x++) { 
				$itemCode_BatchCode= $response_json_decode[$x]->ItemCode.'_'.$response_json_decode[$x]->Batch;

		if(($selectedItemDataExplode[$y])==($itemCode_BatchCode)){
// echo '<pre>';
// print_r($response_json_decode);
// die();
			// ------------- Calculation start here -----------------------------
			
			$Total =(($quantityValGetDataExplode[$y])*($response_json_decode[$x]->PTS));
			
			$TaxAmt =(($Total)*($response_json_decode[$x]->TaxRate))/100;

			// ------------- Calculation end here -------------------------------

			$option1.='<tr id="'.$un_id.'" style="vertical-align: middle;">

				<td style="width: 100px" class="ItemTablePadding">
					<a class="remove" title="Delete" style="cursor: pointer;" onclick="hideTR(\''.$un_id.'\')">
						<i class="mdi mdi-trash-can" style="padding-left: 4px;"></i>
					</a>
					<input type="hidden" id="RemoveStatus'.$un_id.'" name="RemoveStatus[]" value="0">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ItemName'.$un_id.'" name="ItemName[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ItemName.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:270px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ItemCode'.$un_id.'" name="ItemCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ItemCode.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="Batch'.$un_id.'" name="Batch[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Batch.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="InStock'.$un_id.'" name="InStock[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->InStock.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="SelectQty'.$un_id.'" name="SelectQty[]" class="form-control inputBorderHide" value="'.$quantityValGetDataExplode[$y].'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="UnitPrice'.$un_id.'" name="UnitPrice[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTS.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="Discount'.$un_id.'" name="Discount[]" class="form-control inputBorderHide" value="" style="width:120px;" onfocusout="AP_dis_calculat('.$un_id.')">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="DisMRP'.$un_id.'" name="DisMRP[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTS.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				
				<td class="desabled ItemTablePadding">
				<input type="hidden" id="HSNEntry'.$un_id.'" name="HSNEntry[]" value="'.$response_json_decode[$x]->HSNEntry.'">
					<input type="text" id="HSNCode'.$un_id.'" name="HSNCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ChapterID.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="Type'.$un_id.'" name="Type[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Type.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<input type="hidden" id="TaxRate'.$un_id.'" name="TaxRate[]"  value="'.$response_json_decode[$x]->TaxRate.'">
				<td class="desabled ItemTablePadding">
					<input type="text" id="TaxCode'.$un_id.'" name="TaxCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->TaxCode.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="TaxAmt'.$un_id.'" name="TaxAmt[]" class="form-control inputBorderHide" value="'.$TaxAmt.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="WhsCode'.$un_id.'" name="WhsCode[]" class="form-control inputBorderHide" value="'.$_SESSION['DefaultWareHouseId'].'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="Total'.$un_id.'" name="Total[]" class="form-control inputBorderHide" value="'.$Total.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="ItemRemarks'.$un_id.'" name="ItemRemarks[]" class="form-control inputBorderHide" style="width:120px;">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="MRP'.$un_id.'" name="MRP[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->MRP.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="PTR'.$un_id.'" name="PTR[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTR.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="PTS'.$un_id.'" name="PTS[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTS.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="BatchAge'.$un_id.'" name="BatchAge[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->RemainAge.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>';

				if(!empty($response_json_decode[$x]->MfgDate)){
					$option1 .= '<td class="desabled ItemTablePadding">
						<input type="text" id="MfgDate'.$un_id.'" name="MfgDate[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->MfgDate.'" style="background-color: #F4F4F7;
					    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
					</td>';
				}else{
					$option1 .= '<td class="ItemTablePadding">
						<input type="date" id="MfgDate'.$un_id.'" name="MfgDate[]" class="form-control inputBorderHide" style="background-color: #ffffff;
					    border: 1px solid #ffffff!important;width:120px;">
					</td>';
				}
				

				$option1 .= '<td class="desabled ItemTablePadding">
					<input type="text" id="ExpiryDate'.$un_id.'" name="ExpiryDate[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ExpiryDate.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>


				<td class="ItemTablePadding">
					<input type="text" id="UserTax1'.$un_id.'" name="UserTax1[]" class="form-control inputBorderHide" style="width:120px;">
				</td>
				<td class="ItemTablePadding">
					<input type="text" id="UserTax2'.$un_id.'" name="UserTax2[]" class="form-control inputBorderHide" style="width:120px;">
				</td>

			</tr>';
			
		}
		}
	}
}
else
{
	$option1 .= '<span style="text-align: center;color:red;">Record Null </span>';
}
			
		// =============================Selected Data Table Prepare End Here============================================
		



		return $option1;
    }

     public function getSelectedCustomer_AppendToTable($CardCode,$CardName,$rowCount)
    {
    	$un_id=$rowCount;

		$option.='<tr id="'.$un_id.'">
			<td style="width: 30px;vertical-align: middle; text-align: center;">
			 	<a class="remove" title="Delete" style="cursor: pointer;" onclick="removeTR(\''.$un_id.'\')">
					<i class="mdi mdi-trash-can" style="padding-left: 4px;"></i>
				</a>
				<input type="hidden" id="remove'.$un_id.'"  name="remove[]" value="0">
				<input type="hidden" class="" id="DocType'.$un_id.'" name="DocType[]" value="Customer">

			</td>

		    <td class="desabled ItemTablePadding">
		    	<input type="text" id="r_AccountCode'.$un_id.'" name="r_AccountCode[]" value="'.$CardCode.'" class="form-control  inputhoverborder inputBorderHide" readonly style="width: 100%;border: 1px solid #f4f4f7 !important;">
		    </td>

		    <td class="desabled ItemTablePadding"><input type="text" id="r_AccountName'.$un_id.'" name="r_AccountName[]" value="'.$CardName.'" class="form-control  inputhoverborder inputBorderHide" readonly style="width: 170px;border: 1px solid #f4f4f7 !important;"></td>

			<td><span>INR</span>
			<input type="text" id="Debit'.$un_id.'" name="Debit[]" class="form-control  inputhoverborder inputBorderHide" onkeypress="return isNumberKey(event)" onfocusout="DebitFinalTotal()" onblur="CreditDisabled('.$un_id.')"></td>

			<td><span>INR</span>
			<input type="text" id="Credit'.$un_id.'" name="Credit[]" class="form-control  inputhoverborder inputBorderHide" onkeypress="return isNumberKey(event)" onfocusout="CreditFinalTotal()" onblur="DebitDisabled('.$un_id.')"></td>

			<td>
				<input type="text" id="Remarks'.$un_id.'" name="Remarks[]" class="form-control  inputhoverborder inputBorderHide"  style="width: 210px;vertical-align: middle;">
			</td>

			<td><input type="text" id="Ref1'.$un_id.'" name="Ref1[]" class="form-control  inputhoverborder inputBorderHide" style="width: 100%;vertical-align: middle;"></td>

			<td><input type="text" id="Ref2'.$un_id.'" name="Ref2[]" class="form-control  inputhoverborder inputBorderHide" style="width: 100px;vertical-align: middle;"></td>

			<td><input type="text" id="Ref3'.$un_id.'" name="Ref3[]" class="form-control  inputhoverborder inputBorderHide" style="width: 100%;vertical-align: middle;">
		    </td>

		    <td class="desabled ItemTablePadding"><input type="text" id="Division'.$un_id.'" name="Division[]" class="form-control  inputhoverborder inputBorderHide" readonly style="width: 100%;border: 1px solid #f4f4f7 !important;">
		    </td>
		</tr>';

		return $option;
    }

    public function getSelectedGL_AppendToTable($JEGLACCOUNT_API,$selectedItem,$rowCount)
    {
    	$SelectDataexplode= explode(',', $selectedItem); // array selected data variable
// print_r($SelectDataexplode);die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $JEGLACCOUNT_API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		
		curl_close($ch);

		$response_json_decode=json_decode($response);
		// =============================Selected Data Table Prepare start Here============================================
		
		if(!empty($response_json_decode)){
			for ($j=0; $j <count($SelectDataexplode) ; $j++) { 

				for ($i=0; $i <= count($response_json_decode) ; $i++) { 

					$dt1 = $response_json_decode[$i]->AccountCode;
					$dt2 = $SelectDataexplode[$j];

					if(($dt2 == $dt1)) {
					// $id=$rowCount-1;
					$un_id=$rowCount+$j;

					$option.='<tr id="'.$un_id.'">
						<td style="width: 30px;vertical-align: middle; text-align: center;">
						 	<a class="remove" title="Delete" style="cursor: pointer;" onclick="removeTR(\''.$un_id.'\')">
								<i class="mdi mdi-trash-can" style="padding-left: 4px;"></i>
							</a>
							<input type="hidden" id="remove'.$un_id.'"  name="remove[]" value="0">
							<input type="hidden" class="" id="DocType'.$un_id.'" name="DocType[]" value="Account">

						</td>

					    <td class="desabled ItemTablePadding">
					    	<input type="text" id="r_AccountCode'.$un_id.'" name="r_AccountCode[]" value="'.$response_json_decode[$i]->AccountCode.'" class="form-control  inputhoverborder inputBorderHide" readonly style="width: 100%;border: 1px solid #f4f4f7 !important;">
					    </td>

					    <td class="desabled ItemTablePadding"><input type="text" id="r_AccountName'.$un_id.'" name="r_AccountName[]" value="'.$response_json_decode[$i]->AccountName.'" class="form-control  inputhoverborder inputBorderHide" readonly style="width: 170px;border: 1px solid #f4f4f7 !important;"></td>

						<td><span>INR</span>
						<input type="text" id="Debit'.$un_id.'" name="Debit[]" class="form-control  inputhoverborder inputBorderHide" onkeypress="return isNumberKey(event)" onfocusout="DebitFinalTotal()" onblur="CreditDisabled('.$un_id.')"></td>

						<td><span>INR</span>
						<input type="text" id="Credit'.$un_id.'" name="Credit[]" class="form-control  inputhoverborder inputBorderHide" onkeypress="return isNumberKey(event)" onfocusout="CreditFinalTotal()" onblur="DebitDisabled('.$un_id.')"></td>

						<td>
							<input type="text" id="Remarks'.$un_id.'" name="Remarks[]" class="form-control  inputhoverborder inputBorderHide"  style="width: 210px;vertical-align: middle;">
						</td>

						<td><input type="text" id="Ref1'.$un_id.'" name="Ref1[]" class="form-control  inputhoverborder inputBorderHide" style="width: 100%;vertical-align: middle;"></td>

						<td><input type="text" id="Ref2'.$un_id.'" name="Ref2[]" class="form-control  inputhoverborder inputBorderHide" style="width: 100px;vertical-align: middle;"></td>

						<td><input type="text" id="Ref3'.$un_id.'" name="Ref3[]" class="form-control  inputhoverborder inputBorderHide" style="width: 100%;vertical-align: middle;">
					    </td>

					    <td class="desabled ItemTablePadding"><input type="text" id="Division'.$un_id.'" name="Division[]" class="form-control  inputhoverborder inputBorderHide" readonly style="width: 100%;border: 1px solid #f4f4f7 !important;">
					    </td>
					</tr>';
					}
				}
			}
		}
		else
		{
			$option .= '<span style="text-align: center;color:red;">Record Null </span>';
		}
		// =============================Selected Data Table Prepare End Here============================================



		return $option;
    }


	public function getSelectedItem($PO_ItemDetailsAPI,$selectedItem,$totalRowCount,$WhsCode,$CardCode,$PlaceOfSupply,$itemQuantity)

    {
    	$SelectDataexplode= explode(',', $selectedItem); // array selected data variable
    	$itemQuantityexplode= explode(',', $itemQuantity); // array selected Item qiuantity
    	
	
		$url=$PO_ItemDetailsAPI.'CardCode='.$CardCode.'&WhsCode='.$WhsCode.'&PSupply='.$PlaceOfSupply; // All Parameter Eneter Here
		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		
		curl_close($ch);

		$response_json_decode=json_decode($response);

		// =============================Selected Data Table Prepare start Here============================================
		$option ='';
	// $option.='
	// 	<style>
	// 		.fixedHeader1 {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006 !important;color: white !important;}
	// 	</style>

	// 	<table id="tblItemRecord" class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;">
	// 	    <thead class="fixedHeader1">
	// 	        <tr>
	// 	            <th>Edit</th>
	// 	            <th class="">Item Name </th>
	// 	            <th class="">Item Code</th>
	// 	            <th>Quantity</th>
	// 	            <th class="">Unit Price</th>
	// 	            <th>Dis%</th>
	// 	            <th class="">Dis.Price</th>
	// 	            <th class="">HSN</th>
	// 	            <th class="">Taxcode</th>
	// 	            <th class="">Tax Amt</th>
	// 	            <th class="">UOM</th>
	// 	            <th class="">Whse</th>
	// 	            <th class="">Total</th>
	// 	            <th>Item Remarks </th>
	// 	            <th class="">MRP</th>
	// 				<th>BDRate</th>
	// 				<th>PTR</th>
	// 				<th>PTS</th>
	// 	            <th>User Text1</th>
	// 	            <th>User Text 2</th>
	// 	        </tr>
	// 	    </thead>

	// 	    <tbody>

						// $option.='<style>
						// .ItemTablePadding{
						//     padding: 4px !important;
						//     padding-bottom: 0px !important;
						//     padding-top: 0px !important;
						// }
						// </style>';
		if(!empty($response_json_decode)){
			for ($j=0; $j <count($SelectDataexplode) ; $j++) { 


				for ($i=0; $i <= count($response_json_decode) ; $i++) { 

			
					$dt1 = $response_json_decode[$i]->ItemCode;
					$dt2 = $SelectDataexplode[$j];
					
					if(($dt2 == $dt1)) {
						// $id=$j+'1';
						$id=$totalRowCount+$j;
						$q_un_id=$id-1;

$Total=($response_json_decode[$i]->UnitPrice)*($itemQuantityexplode[$q_un_id]);
$TaxAmtCustom = ($response_json_decode[$i]->TaxRate / 100) * $Total;

						$option.='
						<tr id="'.$id.'" style="vertical-align: middle;">
						     	<td style="width: 100px" class="ItemTablePadding">
                                    <a class="remove" title="Delete" style="cursor: pointer;" onclick="removeTR(\''.$id.'\')">
                                    <i class="mdi mdi-trash-can" style="padding-left: 4px;"></i>
                                    </a>
                                </td>
							   
							    <td class="desabled ItemTablePadding">
									<input type="text" id="ItemName'.$id.'" name="ItemName[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->ItemName.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="ItemCode'.$id.'" name="ItemCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->ItemCode.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td data-field="Quantity" class="ItemTablePadding"><input type="text" id="Quantity'.$id.'" name="Quantity[]" value="'.$itemQuantityexplode[$q_un_id].'"  class="form-control inputBorderHide c1c'.$id.'"  onfocusout="calculateAmt(\'Quantity'.$id.'\',\'DisPrice'.$id.'\',\''.$response_json_decode[$i]->TaxRate.'\',\'TaxAmt'.$id.'\',\'Total'.$id.'\')" onkeyup="keyPressed(\'c1c'.$id.'\',event)"></td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="UnitPrice'.$id.'" name="UnitPrice[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->UnitPrice.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td class="ItemTablePadding"><input type="text" id="Dis'.$id.'" name="Dis[]" class="form-control inputBorderHide c2c'.$id.'" value="0" style="width: 43px !important;" onfocusout="calculateDiscount(\''.$response_json_decode[$i]->UnitPrice.'\',\'Dis'.$id.'\',\'DisPrice'.$id.'\',\'Quantity'.$id.'\',\'DisPrice'.$id.'\',\''.$response_json_decode[$i]->TaxRate.'\',\'TaxAmt'.$id.'\',\'Total'.$id.'\')"  onkeyup="keyPressed(\'c2c'.$id.'\',event)"></td>


								<td class="desabled ItemTablePadding">
									<input type="text" id="DisPrice'.$id.'" name="DisPrice[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->UnitPrice.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

							    <td class="desabled ItemTablePadding">
									<input type="text" id="HSNCode'.$id.'" name="HSNCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->HSNCode.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>


								<input type="hidden" name="TaxRate[]" value="'.$response_json_decode[$i]->TaxRate.'">

								<td class="desabled ItemTablePadding">
									<span class="TaxMood"></span>
									<span id="TaxRate'.$id.'">'.$response_json_decode[$i]->TaxRate.'</span>
								</td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="TaxAmt'.$id.'" name="TaxAmt[]" class="form-control inputBorderHide" value="'.$TaxAmtCustom.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="UOM'.$id.'" name="UOM[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->UOM.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

				    			<td class="desabled ItemTablePadding">'.$_SESSION['DefaultWareHouseId'].'</td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="Total'.$id.'" name="Total[]" class="form-control inputBorderHide" value="'.$Total.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td class="ItemTablePadding" data-field="Quantity"><input type="text" id="ItemRemarks" name="ItemRemarks[]" placeholder="Item Remarks" class="form-control inputBorderHide c3c'.$id.'" style="width: 120px !important;"  onkeyup="keyPressed(\'c3c'.$id.'\',event)"></td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="MRP'.$id.'" name="MRP[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->MRP.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="BDRate'.$id.'" name="BDRate[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->BDRate.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>
								<td class="desabled ItemTablePadding">
									<input type="text" id="PTR'.$id.'" name="PTR[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->PTR.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>
								<td class="desabled ItemTablePadding">
									<input type="text" id="PTS'.$id.'" name="PTS[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->PTS.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td class="ItemTablePadding" data-field="Quantity"><input type="text" id="UserText1" name="UserText1[]" placeholder="User Text1" class="form-control inputBorderHide c4c'.$id.'" style="width: 120px !important;"  onkeyup="keyPressed(\'c4c'.$id.'\',event)"></td>

								<td class="ItemTablePadding" data-field="Quantity"><input type="text" id="UserText2" name="UserText2[]" placeholder="User Text2" class="form-control inputBorderHide c5c'.$id.'" style="width: 120px !important;"  onkeyup="keyPressed(\'c5c'.$id.'\',event)">
								</td>


							</tr>';
					}
				}
			}
		}
		else
		{
			$option .= '<span style="text-align: center;color:red;">Record Null </span>';
		}
		// 	$option .= '</tbody> 
		// </table>';
		// =============================Selected Data Table Prepare End Here============================================

		return $option;
    }

    public function MaterialDispatchedFromSupplierItemListTable($API)
    {
    	// print_r($API);die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode1=json_decode($response);
		$response_json_decode=$response_json_decode1[0]->ItemData;

		// =============================Item Data Table Prepare Start Here============================================
			$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '<table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;font-size:12px;">
                            <thead class="fixedHeader1">
                                <tr>
									<th>InternalNo</th>
									<th>PONo</th>                             
									<th>Object</th>
									<th>ItemCode</th>
									<th>ItemName</th>
									<th>Batch</th>
									<th>Quantity</th>
									<th>UnitPrice</th>
									<th>Dis</th>
									<th>DisPrice</th>
									<th>HSN</th>
									<th>TaxCode</th>
									<th>TaxRate</th>
									<th>TaxAmount</th>
									<th>UOM</th>
									<th>WareHouse</th>
									<th>Total</th>
									<th>ItemRemarks</th>
									<th>MRP</th>
									<th>PTR</th>
									<th>PTS</th>
									<th>Location</th>
									<th>Division</th>
									<th>UserText1</th>
									<th>UserText2</th>
									<th>LineNum</th>
                                </tr>
                            </thead>
                            <tbody>';

        		for ($i=0; $i <count($response_json_decode) ; $i++) 
        		{ 
        		$option .= '<tr style="vertical-align: middle;">
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->InternalNo.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PONo.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Object.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemCode.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemName.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Batch.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Quantity.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UnitPrice.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Dis.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DisPrice.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->HSN.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->TaxCode.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->TaxRate.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->TaxAmount.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UOM.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->WareHouse.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Total.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemRemarks.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->MRP.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PTR.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PTS.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Location.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Division.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UserText1.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UserText2.'</td>
								<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->LineNum.'</td>
							</tr>';
                }

        	$option .= '</tbody> 
            	</table>';
			}else{
				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Item Data Table Prepare End Here============================================

		return $option;
    }

    public function AP_ItemListTable($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode1=json_decode($response);
		$response_json_decode=$response_json_decode1[0]->ItemData;
		
		// =============================Item Data Table Prepare Start Here============================================
			$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '<table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;font-size:12px;">
                            <thead class="fixedHeader1">
                                <tr>
									<th>ItemCode</th>
									<th>ItemName</th>
									<th>Quantity</th>
									<th>UnitPrice</th>
									<th>Dis</th>
									<th>DisPrice</th>
									<th>HSN</th>
									<th>TaxCode</th>
									<th>TaxAmount</th>
									<th>UOM</th>
									<th>WareHouse</th>
									<th>Total</th>
									<th>ItemRemarks</th>
									<th>MRP</th>
									<th>UserText1</th>
									<th>UserText2</th>
									<th>BaseEntry</th>
									<th>BaseNo</th>
									<th>BaseType</th>
									<th>BaseLine</th>
                                </tr>
                            </thead>
                            <tbody>';

        		for ($i=0; $i <count($response_json_decode) ; $i++) 
        		{ 

        			$option .= '<tr style="vertical-align: middle;">
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemCode.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemName.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Quantity.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UnitPrice.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Dis.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DisPrice.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->HSN.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->TaxCode.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->TaxAmount.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UOM.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->WareHouse.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Total.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemRemarks.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->MRP.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UserText1.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UserText2.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->BaseEntry.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->BaseNo.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->BaseType.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->BaseLine.'</td>
                    	</tr>';
                }

            	$option .= '</tbody> 
                	</table>';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Item Data Table Prepare End Here============================================

		return $option;
    }

    public function AP_InvoiceDetailsByDocEntry($API)
    {
    	// echo $API;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);
		return $response;
    }

    public function getSupplierDataByCardCode($SupplierData_API)
    {

		$stripped = rtrim($SupplierData_API, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

    	// echo $API;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);
		return $response;
    }

    public function PO_ItemListTable($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode1=json_decode($response);
		$response_json_decode=$response_json_decode1[0]->ItemData;
		
		// =============================Item Data Table Prepare Start Here============================================
			$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '<table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;font-size:12px;">
                            <thead class="fixedHeader1">
                                <tr>
									<th>ItemCode</th>
									<th>ItemName</th>
									<th>Quantity</th>
									<th>UnitPrice</th>
									<th>Dis</th>
									<th>DisPrice</th>
									<th>HSN</th>
									<th>TaxCode</th>
									<th>TaxAmount</th>
									<th>UOM</th>
									<th>WareHouse</th>
									<th>Total</th>
									<th>ItemRemarks</th>
									<th>MRP</th>
									<th>UserText1</th>
									<th>UserText2</th>
                                </tr>
                            </thead>
                            <tbody>';

        		for ($i=0; $i <count($response_json_decode) ; $i++) 
        		{ 

        			$option .= '<tr style="vertical-align: middle;">
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemCode.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemName.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Quantity.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UnitPrice.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Dis.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DisPrice.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->HSN.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->TaxCode.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->TaxAmount.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UOM.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->WareHouse.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Total.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemRemarks.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->MRP.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UserText1.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UserText2.'</td>
                    	</tr>';
                }

            	$option .= '</tbody> 
                	</table>';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Item Data Table Prepare End Here============================================

		return $option;
    }

    public function STDETBTWISE_ItemListTable($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);

		// =============================Item Data Table Prepare Start Here============================================
			
				for ($i=0; $i <count($response_json_decode) ; $i++) 
				{ 
					if($response_json_decode[$i]->DocType=='A/R Invoice Draft'){
						$option .= '
						<div class="row col-lg-12" style="padding-bottom: 10px;">
							<div class="narration  col-lg-2"></div>
							<div class="col-lg-10" style="width: 90%;">Green Highlighted document is Draft document <b>i.e.</b> Stock is not <b><u>"out"</u></b> from the system physically but it is allocated in respective A/R Invoice.</div>
						</div>';
						break;
					}
				}

				$option .= '<table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;">
                            <thead class="fixedHeader1">
                                <tr>
                                	<th>Date</th>
									<th>Doc Type</th>		
									<th>Party/GL Name</th>				
									<th>WhsCode</th>
									<th>Qty</th>
									<th>Direction</th>	
									<th>Depo Ref. No</th>		
									<th>Base Entry</th>	
									<th>Base Line</th>
                                </tr>
                            </thead>
                            <tbody>';
			if(!empty($response_json_decode)){
        		for ($i=0; $i <count($response_json_decode) ; $i++) 
        		{ 
        			if($response_json_decode[$i]->DocType=='A/R Invoice Draft'){
        				$option .= '<tr style="vertical-align: middle;" class="bg_green">
	        				<td class="ItemTablePadding desabled bg_green">'.date('Y-m-d', strtotime($response_json_decode[$i]->Date)).'</td>
	        				<td class="ItemTablePadding desabled bg_green">'.$response_json_decode[$i]->DocType.'</td>
							<td class="ItemTablePadding desabled bg_green">'.$response_json_decode[$i]->PartyGLName.'</td>
							<td class="ItemTablePadding desabled bg_green">'.$response_json_decode[$i]->WhsCode.'</td>
							<td class="ItemTablePadding desabled bg_green">'.$response_json_decode[$i]->Quantity.'</td>
							<td class="ItemTablePadding desabled bg_green">'.$response_json_decode[$i]->Direction.'</td>
							<td class="ItemTablePadding desabled bg_green">'.$response_json_decode[$i]->DepoRefNo.'</td>
							<td class="ItemTablePadding desabled bg_green">'.$response_json_decode[$i]->BaseEntry.'</td>
							<td class="ItemTablePadding desabled bg_green">'.$response_json_decode[$i]->BaseLine.'</td>
	                	</tr>';
        			}else{
    					$option .= '<tr style="vertical-align: middle;">
	        				<td class="ItemTablePadding desabled">'.date('Y-m-d', strtotime($response_json_decode[$i]->Date)).'</td>
	        				<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DocType.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PartyGLName.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->WhsCode.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Quantity.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Direction.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DepoRefNo.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->BaseEntry.'</td>
							<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->BaseLine.'</td>
	                	</tr>';
        			}
        			
                }

            	$option .= '</tbody> 
                	</table>';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Item Data Table Prepare End Here============================================

		return $option;
    }

    public function ARCN_ItemListTable($API)
    {
    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode1=json_decode($response);
		$response_json_decode=$response_json_decode1->value;

		// =============================Item Data Table Prepare Start Here============================================
			$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '<table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;font-size: 12px;">
                            <thead class="fixedHeader1">
                                <tr>
									<th>ItemCode</th>
									<th>ItemDescription</th>
									<th>Quantity</th>
									<th>UnitPrice</th>
									<th>Price</th>
									<th>DiscountPercent</th>
									<th>WarehouseCode</th>
									<th>AccountCode</th>
									<th>TaxCode</th>
									<th>HSNEntry</th>
									<th>MRP</th>
									<th>PTR</th>
									<th>PTS</th>
									<th>BatchNo</th>
									<th>FRC</th>
									<th>MfgDate</th>
									<th>ExpDate</th>
									<th>CostingCode</th>
                                </tr>
                            </thead>
                            <tbody>';

        		for ($i=0; $i <count($response_json_decode) ; $i++) 
        		{ 
        			$option .= '<tr style="vertical-align: middle;">

						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->ItemCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->ItemDescription.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->Quantity.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->UnitPrice.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->Price.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->DiscountPercent.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->WarehouseCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->AccountCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->TaxCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->HSNEntry.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_MRP.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_PTR.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_PTS.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_BatchNo.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_FRC.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_MfgDate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_ExpDate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->CostingCode.'</td>
                	</tr>';
                }

            	$option .= '</tbody> 
                	</table>';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Item Data Table Prepare End Here============================================

		return $option;
    }

    public function ARCRMML_ItemListTable($API)
    {
    	// print_r($API);die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
		// print_r($response_json_decode[0]->InternalNo);
		// die();
		// $response_json_decode=$response_json_decode1;
		
		// =============================Item Data Table Prepare Start Here============================================
			$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '<table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;">
                            <thead class="fixedHeader1">
                                <tr>
                                	<th>ItemName</th>
									<th>ItemCode</th>  
									<th>Batch</th> 
									<th>InStock</th>
									<th>SelectQty</th> 
									<th>F/R/C </th>
									<th>MRP </th>
									<th>UnitPrice</th>
									<th>Dis. Price</th> 
									<th>PTR </th>
									<th>PTS</th>
									<th>ChapterID</th>
									<th>TaxCode</th>
									<th>TaxAmt</th> 
									<th>Total </th>
									<th>TCS_Rate</th> 
									<th>TCS_Amt</th>  
									<th>Division</th> 
									<th>WhsCode</th> 
									<th>BaseDocNo</th> 
									<th>BaseDocEntry</th>  
									<th>RefNo </th> 
									<th>BaseType</th> 
									<th>MfgDate </th>
									<th>ExpiryDate </th>
									<th>User Text 1</th>
									<th>User Text 2</th>
                                </tr>
                            </thead>
                            <tbody>';

        		for ($i=0; $i <count($response_json_decode) ; $i++) 
        		{ 

        			$option .= '<tr style="vertical-align: middle;">
        				<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemDscription.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemCode.'</td>  
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->BatchNo.'</td> 
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->InStock.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Quantity.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->FRC.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->MRP.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Price.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Discount.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PTR.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PTS.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->HSNCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->TaxCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->TaxAmount.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Total.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->TCSRate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->TCSAmount.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Division.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->WhsCode .'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->BaseNo .'</td>  
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->BaseDocEntry .'</td>  
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->BPRefNo .'</td> 
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->BaseType .'</td> 
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->MfgDate .'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ExpiryDate .'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UserText1.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UserText2.'</td>
                	</tr>';
                }

            	$option .= '</tbody> 
                	</table>';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Item Data Table Prepare End Here============================================

		return $option;
    }

    public function ARCM_BasedOnAPCM_ItemList($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode1=json_decode($response);
		// print_r($response_json_decode1->value);
		// die();
		$response_json_decode=$response_json_decode1->value;
		
		// =============================Item Data Table Prepare Start Here============================================
			$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '<table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;">
                            <thead class="fixedHeader1">
                                <tr>
                                	<th>ItemCode</th>
									<th>ItemDescription</th>
									<th>Quantity</th>
									<th>UnitPrice</th>
									<th>Price</th>
									<th>DiscountPercent</th>
									<th>WarehouseCode</th>
									<th>AccountCode</th>
									<th>TaxCode</th>
									<th>HSNEntry</th>
									<th>MRP</th>
									<th>PTR</th>
									<th>PTS</th>
									<th>BatchNo</th>
									<th>FRC</th>
									<th>MfgDate</th>
									<th>ExpDate</th>
									<th>CostingCode</th>
									<th>LocationCode</th>
                                </tr>
                            </thead>
                            <tbody>';

        		for ($i=0; $i <count($response_json_decode) ; $i++) 
        		{ 

        			$option .= '<tr style="vertical-align: middle;">
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->ItemCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->ItemDescription.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->Quantity.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->UnitPrice.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->Price.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->DiscountPercent.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->WarehouseCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->AccountCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->TaxCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->HSNEntry.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_MRP.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_PTR.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_PTS.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_BatchNo.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_FRC.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_MfgDate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->U_ExpDate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->CostingCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->CreditNotesDocumentLines->LocationCode.'</td>
                	</tr>';
                }

            	$option .= '</tbody> 
                	</table>';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Item Data Table Prepare End Here============================================

		return $option;
    }

    public function APCRMM_Draft_ItemListTable($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode1=json_decode($response);
		// print_r($response_json_decode1->value);
		// die();
		$response_json_decode=$response_json_decode1->value;
		
		// =============================Item Data Table Prepare Start Here============================================
			$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '<table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;">
                            <thead class="fixedHeader1">
                                <tr>
                                	<th>ItemCode</th>
									<th>ItemDescription</th>
									<th>Quantity</th>
									<th>UnitPrice</th>
									<th>Price</th>
									<th>LineTotal</th>
									<th>DiscountPercent</th>
									<th>WarehouseCode</th>
									<th>AccountCode</th>
									<th>TaxCode</th>
									<th>HSNEntry</th>
									<th>MRP</th>
									<th>PTR</th>
									<th>PTS</th>
									<th>BatchNo</th>
									<th>FRC</th>
									<th>MfgDate</th> 
									<th>ExpDate</th> 
									<th>CostingCode</th> 
									<th>LocationCode</th>
									<th>ServiceDes</th> 
									<th>FreeText</th> 
									<th>TaxTotal</th>
									<th>TypeAPC</th>
									<th>BatchAge</th>
                                </tr>
                            </thead>
                            <tbody>';

        		for ($i=0; $i <count($response_json_decode) ; $i++) 
        		{ 

        			$option .= '<tr style="vertical-align: middle;">
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->ItemCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->ItemDescription.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->Quantity.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->UnitPrice.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->Price.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->LineTotal.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->DiscountPercent.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->WarehouseCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->AccountCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->TaxCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->HSNEntry.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->U_MRP.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->U_PTR.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->U_PTS.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->U_BatchNo.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->U_FRC.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->U_MfgDate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->U_ExpDate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->CostingCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->LocationCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->U_ServiceDes.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->FreeText.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->TaxTotal.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->U_TypeAPC.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DraftsDocumentLines->U_BatchAge.'</td>
                	</tr>';
                }

            	$option .= '</tbody> 
                	</table>';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Item Data Table Prepare End Here============================================

		return $option;
    }

    public function APCRMM_Actual_ItemListTable($API)
    {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode1=json_decode($response);
		// print_r($response_json_decode1->value);
		// die();
		$response_json_decode=$response_json_decode1->value;
		
		// =============================Item Data Table Prepare Start Here============================================
			$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '<table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;font-size: 12px;">
                            <thead class="fixedHeader1">
                                <tr>
                                	<th>ItemCode</th>
									<th>ItemDescription</th>
									<th>Quantity</th>
									<th>UnitPrice</th>
									<th>Price</th>
									<th>DiscountPercent</th>
									<th>WarehouseCode</th>
									<th>AccountCode</th>
									<th>TaxCode</th>
									<th>HSNEntry</th>
									<th>MRP</th>
									<th>PTR</th>
									<th>PTS</th>
									<th>BatchNo</th>
									<th>FRC</th>
									<th>MfgDate</th>
									<th>ExpDate</th>
									<th>CostingCode</th>
									<th>LocationCode</th>
                                </tr>
                            </thead>
                            <tbody>';

        		for ($i=0; $i <count($response_json_decode) ; $i++) 
        		{ 

        			$option .= '<tr style="vertical-align: middle;">
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->ItemCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->ItemDescription.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->Quantity.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->UnitPrice.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->Price.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->DiscountPercent.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->WarehouseCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->AccountCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->TaxCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->HSNEntry.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->U_MRP.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->U_PTR.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->U_PTS.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->U_BatchNo.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->U_FRC.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->U_MfgDate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->U_ExpDate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->CostingCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PurchaseCreditNotesDocumentLines->LocationCode.'</td>
                	</tr>';
                }

            	$option .= '</tbody> 
                	</table>';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Item Data Table Prepare End Here============================================

		return $option;
    }

    public function APCRMM_ItemListTable($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
		// print_r($response_json_decode);
		// die();
		// $response_json_decode=$response_json_decode1;
		
		// =============================Item Data Table Prepare Start Here============================================
			$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '<table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;">
                            <thead class="fixedHeader1">
                                <tr>
                                	<th>ItemCode</th>
									<th>OrderRefNo</th>
									<th>HQ/DEPO</th>
									<th>Area</th>
									<th>PTR</th>
									<th>PTS</th>
									<th>MRP</th>
									<th>BatchNo</th>
									<th>MfgDate</th>
									<th>ExpiryDate</th>
									<th>FRC</th>
									<th>Category1</th>
									<th>OpeningRemark</th>
									<th>ClosingRemark</th>
									<th>Comments</th>
									<th>UserText1</th>
									<th>UserText2</th>
                                </tr>
                            </thead>
                            <tbody>';

        		for ($i=0; $i <count($response_json_decode) ; $i++) 
        		{ 

        			$option .= '<tr style="vertical-align: middle;">
        				<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->OrderRefNo.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->HQDEPO.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Area.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PTR.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PTS.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->MRP.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->BatchNo.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->MfgDate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ExpiryDate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->FRC.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Category1.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->OpeningRemark.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ClosingRemark.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Remark.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UserText1.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->UserText2.'</td>
                	</tr>';
                }

            	$option .= '</tbody> 
                	</table>';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Item Data Table Prepare End Here============================================

		return $option;
    }

    public function MaterialDispatchedFromSupplierItemList($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);
		return $response_json_decode;
    }

    public function getOrderForNameById($OrderForAIP,$OrderFor)
    {
    	$url=$OrderForAIP.'?OrderForCode='.$OrderFor; // All Parameter Enter Here
		
		$stripped = rtrim($url, "&"); // URL last (&) symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		$decodeData=json_decode($response);

		$OrderForName=$decodeData[0]->OrderForName;
		curl_close($ch);
		return $OrderForName;
    }

    public function CreatePurchaseOrder($CREATEPO_API,$mainArray)
    {
    	$postdata = json_encode($mainArray);

		$ch = curl_init($CREATEPO_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }

	public function CreateAP_Invoice($CREATEAPINVOICE_API,$Data)
    {
		$ch = curl_init($CREATEAPINVOICE_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $Data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }

    public function CreateDraftToAR_CreditMemo($ARCRSAVEDRAFTTODOCUMENT_API,$tdata)
    {
    	$rowData=json_encode($tdata);

		$ch = curl_init($ARCRSAVEDRAFTTODOCUMENT_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $rowData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }

    public function CreateDraftToAP_CreditMemo($APCRSAVEDRAFTTODOCUMENT_API,$tdata)
    {
    	$rowData=json_encode($tdata);
// print_r($rowData);die();
		$ch = curl_init($APCRSAVEDRAFTTODOCUMENT_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $rowData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }


    public function IntimationPurchaseOrderCancellation($CREATECANCELEDPO_API,$selectedItem)
    {
		$explore=explode(',', $selectedItem);
		$S_array=array();

		for ($i=0; $i <count($explore) ; $i++) { 
			$S_array[]="{'InternalNo':'".$explore[$i]."'}";
		}
		$selection_encoded=json_encode(implode(',', $S_array));
		$Selection = str_replace('"', '', $selection_encoded); // All Right & Left Double Quotation Mark (") replace to blank space

		$Finale_Post='{"CREATEPODATA":['.$Selection.']}';

		$ch = curl_init($CREATECANCELEDPO_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $Finale_Post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
    }

    public function CreateAPCMEMO($CREATEAPCMEMO_API,$finalArray)
    {
    	$postdata = json_encode($finalArray);

		$ch = curl_init($CREATEAPCMEMO_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }

    public function CreateARCM_basedOnARInvoice($CREATEARCRBASEDARINV_API,$mainArray)
    {

    	$postdata = json_encode($mainArray);

		$ch = curl_init($CREATEARCRBASEDARINV_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }

    public function CreateAPCMEMO_Standalone($CREATEAPCMEMO_API,$mainArray)
    {
    	$postdata = json_encode($mainArray);
// print_r(json_encode($postdata));
// die();
		$ch = curl_init($CREATEAPCMEMO_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
    }

    public function getBatchByItemCode_quantity($API,$Quantity)
    {
		$Final_url = str_replace(' ', '%20', $API); // All blank space replace to %20

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		
		curl_close($ch);

		$response_json_decode=json_decode($response);
// print_r($response_json_decode);
// die();
		// =============================Selected Data Table Prepare start Here============================================
		$option ='';
		$option.='<style>
					.ItemTablePadding{
					    padding: 4px !important;
					    padding-bottom: 0px !important;
					    padding-top: 0px !important;
					}
					.fixedHeader1 {position: -webkit-sticky;position: sticky;top: -1px;z-index: 2;background-color: #b90006;color: white;}
				</style>
				<input type="hidden" name="UserQuantity" id="UserQuantity" value="'.$Quantity.'">

		<table id="tblBatchDetails" class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;">
            <thead class="fixedHeader1">

                <tr>
					<th></th>
					<th>Item Code</th>
					<th>Item Name</th>
					<th>WhsCode</th>
					<th>Batch</th>
					<th>InStock</th>
					<th>Quantity</th>
					<th>MRP</th>
					<th>PTR</th>
					<th>PTS</th>
					<th>InDate</th>
					<th>ExpDate</th>
                </tr>
            </thead>

            <tbody>';
		// if(!empty($response_json_decode)){
			for ($i=0; $i < count($response_json_decode) ; $i++) { 

                            // <input type="checkbox" class="messageCheckbox">
				$option.='
				
				<tr id="'.$id.'" style="vertical-align: middle;">
				     	<td style="width: 100px" class="ItemTablePadding">
							<input type="checkbox" class="messageCheckbox" id="'.$response_json_decode[$i]->SrNo.'" name="selectToAdd[]" value="'.$response_json_decode[$i]->SrNo.'">
                        </td>
						<td class="desabled ItemTablePadding">'.$response_json_decode[$i]->ItemCode.'</td>
						<td class="desabled ItemTablePadding">'.$response_json_decode[$i]->ItemName.'</td>
						<td class="desabled ItemTablePadding">'.$response_json_decode[$i]->WhsCode.'</td>
						<td class="desabled ItemTablePadding">'.$response_json_decode[$i]->Batch.'</td>
						<td class="desabled ItemTablePadding">'.$response_json_decode[$i]->InStock.'</td>
						<td class="desabled ItemTablePadding">'.$response_json_decode[$i]->Quantity.'</td>
						<td class="desabled ItemTablePadding">'.$response_json_decode[$i]->MRP.'</td>
						<td class="desabled ItemTablePadding">'.$response_json_decode[$i]->PTR.'</td>
						<td class="desabled ItemTablePadding">'.$response_json_decode[$i]->PTS.'</td>
						<td class="desabled ItemTablePadding">'.$response_json_decode[$i]->InDate.'</td>
						<td class="desabled ItemTablePadding">'.$response_json_decode[$i]->ExpDate.'</td>
				</tr>';
			}
		// }
		// else
		// {
		// 	$option .= '<tr><span style="text-align: center;color:red;">Record Null </span></tr>';
		// }
			$option .= '</tbody> 
		</table>';
		// =============================Selected Data Table Prepare End Here============================================

		return $option;
    }

    public function getItemListWithBatch($ItemDetailsAIP,$BatchDetails_API,$selectedItemReadio,$selectedBatch,$UserQuantity,$tbodyRowCount)
    {
    	$selectedBatchDataExplode= explode(',', $selectedBatch); // array selected data variable
    	$selectedItemReadioExplode= explode(',', $selectedItemReadio); // array selected data variable

    	// ===================================== get All Item List start Here ========================================	
		$url=$ItemDetailsAIP; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		
		curl_close($ch);

		$response_json_decode=json_decode($response);

		// ===================================== get All Item List end Here =========================================


    	// ========================= get BatchData By ItemCode and Quantity start Here ============================
    	
		$API=BASE_URL.'?ItemCode='.$selectedItemReadioExplode[0].'&WhsCode='.$_SESSION['DefaultWareHouseId'].'&Quantity='.$UserQuantity.'&req=0';  // All Parameter Enter here

		$Final_url2 = str_replace(' ', '%20', $API); // All blank space replace to %20

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url2);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response2 = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		
		curl_close($ch);

		$batchData_json_decode=json_decode($response2);
		// ========================= get BatchData By ItemCode and Quantity end Here ============================

		// =============================Selected Data Table Prepare start Here============================================
		$option ='';

		if(!empty($response_json_decode)){
			for ($j=0; $j <count($selectedItemReadioExplode) ; $j++) { 


				for ($i=0; $i <= count($response_json_decode) ; $i++) { 

			
					$dt1 = $response_json_decode[$i]->ItemCode;
					$dt2 = $selectedItemReadioExplode[$j];
					
					if(($dt2 == $dt1)) {
						$id=$j+'1';
						

						for ($x=0; $x <count($selectedBatchDataExplode) ; $x++) {  // Singel Item Looping with multiple ItemBatch Data
							$ids=$x+1;
							$un_id=$tbodyRowCount+1+$x;

							$Total=($batchData_json_decode[$x]->Quantity)*($response_json_decode[$i]->PTS);
							$TaxAmtCustom = ($response_json_decode[$i]->TaxRate / 100) * $Total;
							

								// <td class="desabled ItemTablePadding">
								// 	<input type="text" id="BDRate'.$un_id.'" name="BDRate[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->BDRate.'" style="background-color: #F4F4F7;
								//     border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								// </td>
								
							$option.='
						<tr id="'.$un_id.'" style="vertical-align: middle;">
						     	<td style="width: 100px" class="ItemTablePadding">
								    <a class="remove" title="Delete" style="cursor: pointer;">
								    <i class="mdi mdi-trash-can" style="padding-left: 4px;"></i>
								    </a>
								</td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="ItemName'.$un_id.'" name="ItemName[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->ItemName.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="ItemCode'.$un_id.'" name="ItemCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->ItemCode.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td data-field="Quantity" class="desabled ItemTablePadding">
									<input type="text" id="Batch'.$un_id.'" name="Batch[]" value="'.$batchData_json_decode[$x]->Batch.'" class="form-control inputBorderHide c1c'.$un_id.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>



								<td data-field="Quantity" class="desabled ItemTablePadding"><input type="text" id="Quantity'.$un_id.'" name="Quantity[]" value="'.$batchData_json_decode[$x]->Quantity.'" class="form-control inputBorderHide c1c'.$un_id.'"  onfocusout="calculateAmt(\'Quantity'.$un_id.'\',\'DisPrice'.$un_id.'\',\''.$response_json_decode[$i]->TaxRate.'\',\'TaxAmt'.$un_id.'\',\'Total'.$un_id.'\')" onkeyup="keyPressed(\'c1c'.$un_id.'\',event)" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly=""></td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="UnitPrice'.$un_id.'" name="UnitPrice[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->PTS.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td class="ItemTablePadding"><input type="text" id="Dis'.$un_id.'" name="Dis[]" class="form-control inputBorderHide c2c'.$un_id.'" value="0" style="width: 43px !important;" onfocusout="calculateDiscount(\''.$response_json_decode[$i]->PTS.'\',\'Dis'.$un_id.'\',\'DisPrice'.$un_id.'\',\'Quantity'.$un_id.'\',\'DisPrice'.$un_id.'\',\''.$response_json_decode[$i]->TaxRate.'\',\'TaxAmt'.$un_id.'\',\'Total'.$un_id.'\')"  onkeyup="keyPressed(\'c2c'.$un_id.'\',event)"></td>


								<td class="desabled ItemTablePadding">
									<input type="text" id="DisPrice'.$un_id.'" name="DisPrice[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->PTS.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>


								<td class="desabled ItemTablePadding">
									<input type="hidden" name="HSNEntry[]" id="HSNEntry'.$un_id.'" value="'.$response_json_decode[$i]->HSNEntry.'">
									<input type="text" id="HSNCode'.$un_id.'" name="HSNCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->HSNCode.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<input type="hidden" name="TaxRate[]" value="'.$response_json_decode[$i]->TaxRate.'">

								<td class="desabled ItemTablePadding">
									<span class="TaxMood"></span><span id="TaxRate'.$un_id.'">'.$response_json_decode[$i]->TaxRate.'</span>
								</td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="TaxAmt'.$un_id.'" name="TaxAmt[]" class="form-control inputBorderHide" value="'.$TaxAmtCustom.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="UOM'.$un_id.'" name="UOM[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->UOM.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td class="desabled ItemTablePadding">'.$_SESSION['DefaultWareHouseId'].'</td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="Total'.$un_id.'" name="Total[]" class="form-control inputBorderHide" value="'.$Total.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td class="ItemTablePadding" data-field="Quantity"><input type="text" id="ItemRemarks" name="ItemRemarks[]" placeholder="Item Remarks" class="form-control inputBorderHide c3c'.$un_id.'" style="width: 120px !important;"  onkeyup="keyPressed(\'c3c'.$un_id.'\',event)"></td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="MRP'.$un_id.'" name="MRP[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->MRP.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td class="desabled ItemTablePadding">
									<input type="text" id="PTR'.$un_id.'" name="PTR[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->PTR.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>
								<td class="desabled ItemTablePadding">
									<input type="text" id="PTS'.$un_id.'" name="PTS[]" class="form-control inputBorderHide" value="'.$response_json_decode[$i]->PTS.'" style="background-color: #F4F4F7;
								    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
								</td>

								<td class="ItemTablePadding" data-field="Quantity"><input type="text" id="UserText1" name="UserText1[]" placeholder="User Text1" class="form-control inputBorderHide c4c'.$un_id.'" style="width: 120px !important;"  onkeyup="keyPressed(\'c4c'.$un_id.'\',event)"></td>

								<td class="ItemTablePadding" data-field="Quantity"><input type="text" id="UserText2" name="UserText2[]" placeholder="User Text2" class="form-control inputBorderHide c5c'.$un_id.'" style="width: 120px !important;"  onkeyup="keyPressed(\'c5c'.$un_id.'\',event)">
								</td>


							</tr>';
						}
					}
				}
			}
		}
		else
		{
			$option .= '<span style="text-align: center;color:red;">Record Null </span>';
		}
			// $option .= '';
		// =============================Selected Data Table Prepare End Here============================================
		$option_new .='<tr>
				<td>1</td>
				<td>2</td>
			</tr>';



		return $option;
    }

  	public function GetAR_SingleItem($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		
		curl_close($ch);
		return $response;
    }

    public function getAPCRMM_ServicesInRowLevel($APCRSSACCODE_API,$SACCode,$rowCount,$APCRSEXPACCOUNT_API,$PlaceOfSupply,$APCRSTAXCODE_API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $APCRSEXPACCOUNT_API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		
		curl_close($ch);

		$response_json_decode=json_decode($response);

		// ===================================== get All Item List end Here =========================================

		// =============================Selected Data Table Prepare start Here============================================

if(!empty($response_json_decode)){
	$selectedItemDataExplode= explode(',', $SACCode); // SAC Code selected by user
	
	for ($y=0; $y <count($response_json_decode) ; $y++) { 
		$id=$y+1;
		$un_id=$rowCount+$id;  // create unique id with the help of tbody row count
		

			for ($x=0; $x <count($response_json_decode) ; $x++) { 
				$itemCode_BatchCode= $response_json_decode[$x]->AccountCode;

		if(($selectedItemDataExplode[$y])==($itemCode_BatchCode)){

			$option1.='<tr id="'.$un_id.'" style="vertical-align: middle;">


				<td class="desabled ItemTablePadding">
				    <input type="text" id="ExpenseType'.$un_id.'" name="ExpenseType[]" value="'.$response_json_decode[$x]->AccountName.'"  class="form-control inputBorderHide" value="0" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:160px;" readonly>
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="U_Total'.$un_id.'" name="U_Total[]" class="form-control inputBorderHide" value="0" style="width:100px;"  onfocusout="RowLevelCalculation(\''.$un_id.'\')">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="r_Dis'.$un_id.'" name="r_Dis[]" class="form-control inputBorderHide" value="0" style="width:100px;" onfocusout="RowLevelCalculation(\''.$un_id.'\')">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="Total'.$un_id.'" name="Total[]" value=""  class="form-control inputBorderHide" value="" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:100px;" readonly>
				</td>

				<td class="desabled ItemTablePadding"  data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg_SAC" onclick="ClickOnSAC_Row(\''.$un_id.'\')">
					<input type="hidden" id="SACCode'.$un_id.'" name="SACCode[]">
					<input type="hidden" id="SACEntry'.$un_id.'" name="SACEntry[]">

					<input type="text" id="SACName'.$un_id.'" name="SACName[]" class="form-control inputBorderHide" value="" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:150px;" readonly>
				</td>

				<td class="desabled ItemTablePadding">
					<input type="hidden" id="innerTaxCode'.$un_id.'" name="innerTaxCode[]" >

				    <select id="Taxcode'.$un_id.'" name="Taxcode[]" class="form-control form-select ExpenseType'.$un_id.'" style="width:100px;" onchange="ApplyTaxToTotal(\''.$un_id.'\')">
				 		'.$this->GetTaxCodeDropdown_APCRMMS($PlaceOfSupply,$APCRSTAXCODE_API).'
				    </select>
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="TaxAmt'.$un_id.'" name="TaxAmt[]" class="form-control inputBorderHide" value="0" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:100px;" readonly>
				</td>

				<td class="desabled ItemTablePadding">
					<input type="hidden" id="LocationCode'.$un_id.'" name="LocationCode[]" value="'.$_SESSION['LocationCode'].'">

					<input type="text" id="Loaction'.$un_id.'" name="Loaction[]" class="form-control inputBorderHide" value="'.$_SESSION['LocationName'].'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:150px;" readonly>
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="ServiceRemark'.$un_id.'" name="ServiceRemark[]" class="form-control inputBorderHide" value="">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="UserText1'.$un_id.'" name="UserText1[]" class="form-control inputBorderHide" value="">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="UserText2'.$un_id.'" name="UserText2[]" class="form-control inputBorderHide" value="">
				</td>

			</tr>';
			
		}
		}
	}
}
else
{
	$option1 .= '<span style="text-align: center;color:red;">Record Null </span>';
}
			
		// =============================Selected Data Table Prepare End Here============================================
		



		return $option1;
    }

    public function getApInvoiceStandaloneItemInRowLevel($API,$ItemCode,$quantityValGet,$rowCount)
    {
    	
    	
    	// ===================================== get All Item List start Here ========================================	
// print_r($rowCount);
// die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		
		curl_close($ch);

		$response_json_decode=json_decode($response);

// print_r($response_json_decode);
// die();
		// ===================================== get All Item List end Here =========================================

		// =============================Selected Data Table Prepare start Here============================================

if(!empty($response_json_decode)){
	$selectedItemDataExplode= explode(',', $ItemCode); // item code selected by user
	$quantityValGetDataExplode= explode(',', $quantityValGet); //Item Quantity enter by user

	for ($y=0; $y <count($response_json_decode) ; $y++) { 
		$id=$y+1;
		$un_id=$rowCount+$id;  // create unique id with the help of tbody row count

		
			for ($x=0; $x <count($response_json_decode) ; $x++) { 
				$itemCode_BatchCode= $response_json_decode[$x]->ItemCode.'_'.$response_json_decode[$x]->MRP;

		if(($selectedItemDataExplode[$y])==($itemCode_BatchCode)){


			// ------------- Calculation start here -----------------------------
			
			// $Total =(($quantityValGetDataExplode[$y])*($response_json_decode[$x]->UnitPrice));
			// $TaxAmt =(($Total)*($response_json_decode[$x]->TaxRate))/100;

			$Total ='00.00';
			$TaxAmt ='00.00';

			// ------------- Calculation end here -------------------------------
// '.$response_json_decode[$x]->UnitPrice.'
// dis Price var ->'.$response_json_decode[$x]->UnitPrice.'
			$option1.='<tr id="'.$un_id.'" style="vertical-align: middle;">

				<td style="width: 100px" class="ItemTablePadding">
					<a class="remove" title="Delete" style="cursor: pointer;" onclick="hideTR(\''.$un_id.'\')">
						<i class="mdi mdi-trash-can" style="padding-left: 4px;"></i>
					</a>
					<input type="hidden" id="RemoveStatus'.$un_id.'" name="RemoveStatus[]" value="0">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ItemName'.$un_id.'" name="ItemName[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ItemName.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:270px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ItemCode'.$un_id.'" name="ItemCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ItemCode.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="Batch'.$un_id.'" name="Batch[]" class="form-control inputBorderHide" style="
				    border: 1px solid #ffffff!important;width:120px;" required>
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="InStock'.$un_id.'" name="InStock[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->InStock.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="SelectQty'.$un_id.'" name="SelectQty[]" class="form-control inputBorderHide" value="'.$quantityValGetDataExplode[$y].'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="MRP'.$un_id.'" name="MRP[]" value="'.$response_json_decode[$x]->MRP.'"  class="form-control inputBorderHide" style="border: 1px solid #ffffff!important; width:120px;" onfocusout="MRP_change(\''.$response_json_decode[$x]->MRP.'\','.$un_id.')">
				</td>

<td class="ItemTablePadding">
	<input type="text" id="UnitPrice'.$un_id.'" name="UnitPrice[]" class="form-control inputBorderHide" value="" style="background-color: #ffffff;
    border: 1px solid #ffffff!important;width:120px;"  onfocusout="AP_dis_calculat('.$un_id.')">
</td>

<td class="ItemTablePadding">
	<input type="text" id="Discount'.$un_id.'" name="Discount[]" class="form-control inputBorderHide" value="" style="border: 1px solid #ffffff!important;width:120px;" onfocusout="AP_dis_calculat('.$un_id.')">
</td>

<td class="desabled ItemTablePadding">
	<input type="text" id="DisMRP'.$un_id.'" name="DisMRP[]" class="form-control inputBorderHide" value="" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;">
</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="PTR'.$un_id.'" name="PTR[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTR.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="PTS'.$un_id.'" name="PTS[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTS.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;">
				</td>

				<input type="hidden" id="HSNEntry'.$un_id.'" name="HSNEntry[]"  value="'.$response_json_decode[$x]->HSNEntry.'">
				<td class="desabled ItemTablePadding">
					<input type="text" id="HSNCode'.$un_id.'" name="HSNCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->HSNCode.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;">
				</td>

				<input type="hidden" id="TaxRate'.$un_id.'" name="TaxRate[]"  value="'.$response_json_decode[$x]->TaxRate.'">
				<td class="desabled ItemTablePadding">
					<input type="text" id="TaxCode'.$un_id.'" name="TaxCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->TaxCode.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="TaxAmt'.$un_id.'" name="TaxAmt[]" class="form-control inputBorderHide" value="'.$TaxAmt.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="Total'.$un_id.'" name="Total[]" class="form-control inputBorderHide" value="'.$Total.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="WhsCode'.$un_id.'" name="WhsCode[]" class="form-control inputBorderHide" value="'.$_SESSION['DefaultWareHouseId'].'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;">
				</td>

				<td class="ItemTablePadding">
					<input type="date" id="MfgDate'.$un_id.'" name="MfgDate[]" class="form-control inputBorderHide" value="" style="border: 1px solid #ffffff!important;width:120px;" required>
				</td>

				<td class="ItemTablePadding">
					<input type="date" id="ExpiryDate'.$un_id.'" name="ExpiryDate[]" class="form-control inputBorderHide" value="" style="border: 1px solid #ffffff!important;width:120px;" required>
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="UserTax1'.$un_id.'" name="UserTax1[]" class="form-control inputBorderHide" style="
				    border: 1px solid #ffffff!important;width:120px;">
				</td>
				<td class="ItemTablePadding">
					<input type="text" id="UserTax2'.$un_id.'" name="UserTax2[]" class="form-control inputBorderHide" style="
				    border: 1px solid #ffffff!important;width:120px;">
				</td>

			</tr>';
			
		}
		}
	}
}
else
{
	$option1 .= '<span style="text-align: center;color:red;">Record Null </span>';
}
			
		// =============================Selected Data Table Prepare End Here============================================
		



		return $option1;
    }

public function getARCMM_oldSTockItemInRowLevel($API,$ItemCode,$quantityValGet,$rowCount,$TCSApp)
{
	// ===================================== get All Item List start Here ========================================	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
		echo 'Request Error:' . curl_error($ch);
		}

		curl_close($ch);
		$response_json_decode=json_decode($response);
	// ===================================== get All Item List end Here =========================================

	// =============================Selected Data Table Prepare start Here============================================
		if(!empty($response_json_decode)){
			$selectedItemDataExplode= explode(',', $ItemCode); // item code selected by user
			$quantityValGetDataExplode= explode(',', $quantityValGet); //Item Quantity enter by user

			for ($y=0; $y <count($selectedItemDataExplode) ; $y++) { 
				$id=$y+1;
				$un_id=$rowCount+$id;  // create unique id with the help of tbody row count


				for ($x=0; $x <count($response_json_decode) ; $x++) { 

					$itemCode_BatchCode= $response_json_decode[$x]->Row; // default Item unique RowId

					if(($selectedItemDataExplode[$y])==($itemCode_BatchCode)){ // check user selected item By RowId Match

					// ------------- Calculation start here -----------------------------
						if($response_json_decode[$x]->Discount=='0' && $response_json_decode[$x]->Discount=='0.0'){
							$DicPrice = $response_json_decode[$x]->PTS;
						}else{
							$DicPrice1 = (($response_json_decode[$x]->PTS/100)*($response_json_decode[$x]->Discount));
							$DicPrice = (($response_json_decode[$x]->PTS) - ($DicPrice1));
						}

						$Total =(($quantityValGetDataExplode[$y])*($DicPrice));

						$TaxAmt =(($Total)*($response_json_decode[$x]->TaxRate))/100;

						if($TCSApp=='YES'){
							$TCS_Amt=((($Total)+($TaxAmt))*($response_json_decode[$x]->TCSRate))/100;
						}else{
							$TCS_Amt=0;
						}
					// ------------- Calculation end here -------------------------------

						$option1.='<tr id="'.$un_id.'" style="vertical-align: middle;">

							<td style="width: 100px" class="ItemTablePadding">
								<a class="remove" title="Delete" style="cursor: pointer;" onclick="hideTR(\''.$un_id.'\')">
									<i class="mdi mdi-trash-can" style="padding-left: 4px;"></i>
								</a>
								<input type="hidden" id="RemoveStatus'.$un_id.'" name="RemoveStatus[]" value="0">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="ItemName'.$un_id.'" name="ItemName[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ItemName.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:270px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="ItemCode'.$un_id.'" name="ItemCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ItemCode.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="Batch'.$un_id.'" name="Batch[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->BatchNo.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="InStock'.$un_id.'" name="InStock[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->InStock.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="SelectQty'.$un_id.'" name="SelectQty[]" class="form-control inputBorderHide" value="'.$quantityValGetDataExplode[$y].'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<select name="R_frc[]" id="R_frc'.$un_id.'" class="" onchange="changeFRC('.$un_id.')">
									<option value="REGULAR" selected>REGULAR</option>
									<option value="FREE">FREE</option>
									<option value="REPLACEMENT">REPLACEMENT</option>
									<option value="CLAIMQTY">CLAIMQTY</option>
								</select>
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="MRP'.$un_id.'" name="MRP[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->MRP.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="UnitPrice'.$un_id.'" name="UnitPrice[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTS.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="ItemTablePadding">
								<input type="text" id="Discount'.$un_id.'" name="Discount[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Discount.'" onfocusout="AP_dis_calculat('.$un_id.')" style="background-color: #ffffff;border: 1px solid #ffffff!important;width:120px;">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="DisMRP'.$un_id.'" name="DisMRP[]" class="form-control inputBorderHide" value="'.$DicPrice.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;"  readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="PTR'.$un_id.'" name="PTR[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTR.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="PTS'.$un_id.'" name="PTS[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTS.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="ChapterID'.$un_id.'" name="ChapterID[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ChapterID.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

<td style="width: 100px;" class="ItemTablePadding">
	<input type="checkbox" class="messageCheckbox" id="NoTax'.$un_id.'" name="NoTax[]" value="1" onclick="RowLevelNoTaxClick('.$un_id.')" style="margin: 0px auto;display: block;">
</td>

<td style="width: 100px;" class="ItemTablePadding">
	<input type="checkbox" class="messageCheckbox" id="BreakAge'.$un_id.'" name="BreakAge[]" value="1" onclick="RowLevelBreakAgeClick('.$un_id.')" style="margin: 0px auto;display: block;">
</td>

							<td class="desabled ItemTablePadding">
								<input type="hidden" id="TaxRate'.$un_id.'" name="TaxRate[]"  value="'.$response_json_decode[$x]->TaxRate.'">

								<input type="text" id="TaxCode'.$un_id.'" name="TaxCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->TaxCode.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="TaxAmt'.$un_id.'" name="TaxAmt[]" class="form-control inputBorderHide" value="'.$TaxAmt.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="Total'.$un_id.'" name="Total[]" class="form-control inputBorderHide" value="'.$Total.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="R_TCS_rate'.$un_id.'" name="R_TCS_rate[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->TCSRate.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="R_TCS_Amt'.$un_id.'" name="R_TCS_Amt[]" class="form-control inputBorderHide" value="'.$TCS_Amt.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="R_Division'.$un_id.'" name="R_Division[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Division.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="WhsCode'.$un_id.'" name="WhsCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->WhsCode.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="BillNo'.$un_id.'" name="BillNo[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->BillNo.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="BillDate'.$un_id.'" name="BillDate[]" class="form-control inputBorderHide" value="'.date("d/m/Y", strtotime(trim($response_json_decode[$x]->BillDate))).'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">

								<input type="hidden" id="BaseDocNo'.$un_id.'" name="BaseDocNo[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->BaseDocNo.'">

								<input type="hidden" id="BaseDocEntry'.$un_id.'" name="BaseDocEntry[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->BaseDocEntry.'">

								<input type="hidden" id="RefNo'.$un_id.'" name="RefNo[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->RefNo.'">

								<input type="hidden" id="BaseType'.$un_id.'" name="BaseType[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->BaseType.'">

								<input type="hidden" id="BaseLine'.$un_id.'" name="BaseLine[]" value="'.$response_json_decode[$x]->BaseLine.'">

								<input type="hidden" id="HSNEntry'.$un_id.'" name="HSNEntry[]" value="'.$response_json_decode[$x]->HSNEntry.'">

								<input type="text" id="BatchAge'.$un_id.'" name="BatchAge[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->RemainAge.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="TypeOfAPC'.$un_id.'" name="TypeOfAPC[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Type.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="MfgDate'.$un_id.'" name="MfgDate[]" class="form-control inputBorderHide" value="'.date("d/m/Y", strtotime(trim($response_json_decode[$x]->MfgDate))).'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
							</td>

							<td class="desabled ItemTablePadding">
								<input type="text" id="ExpiryDate'.$un_id.'" name="ExpiryDate[]" class="form-control inputBorderHide" value="'.date("d/m/Y", strtotime(trim($response_json_decode[$x]->ExpDate))).'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
							</td>

							<td class="ItemTablePadding">
								<input type="text" id="UserTax1'.$un_id.'" name="UserTax1[]" class="form-control inputBorderHide" style="border: 1px solid #ffffff!important;width:120px;">
							</td>

							<td class="ItemTablePadding">
								<input type="text" id="UserTax2'.$un_id.'" name="UserTax2[]" class="form-control inputBorderHide" style="border: 1px solid #ffffff!important;width:120px;">
							</td>

						</tr>';

					}
				}
			}
		}
		else
		{
			$option1 .= '<span style="text-align: center;color:red;">Record Null </span>';
		}
	// =============================Selected Data Table Prepare End Here============================================
		return $option1;
    }

    public function getARCMM_ItemInRowLevel($API,$ItemCode,$quantityValGet,$rowCount,$TCSApp)
    {

    	// ===================================== get All Item List start Here ========================================	

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		
		curl_close($ch);

		$response_json_decode=json_decode($response);
		// print_r($response);
		// die();

		// ===================================== get All Item List end Here =========================================

		// =============================Selected Data Table Prepare start Here============================================

if(!empty($response_json_decode)){
	$selectedItemDataExplode= explode(',', $ItemCode); // item code selected by user
	$quantityValGetDataExplode= explode(',', $quantityValGet); //Item Quantity enter by user

	for ($y=0; $y <count($response_json_decode) ; $y++) { 
		$id=$y+1;
		$un_id=$rowCount+$id;  // create unique id with the help of tbody row count

			for ($x=0; $x <count($response_json_decode) ; $x++) { 
			// $itemCode_BatchCode= $response_json_decode[$x]->ItemCode.'_'.$response_json_decode[$x]->Batch;

			$itemCode_BatchCode1=$response_json_decode[$x]->ItemCode.'_'.$response_json_decode[$x]->Batch.'_'.$response_json_decode[$x]->InStock;
			$itemCode_BatchCode_Row = str_replace(' ','', $itemCode_BatchCode1);

				if(($selectedItemDataExplode[$y])==($itemCode_BatchCode_Row)){

			// ------------- Calculation start here -----------------------------
			
			if($response_json_decode[$x]->Discount=='0' && $response_json_decode[$x]->Discount=='0.0'){
				$DicPrice = $response_json_decode[$x]->PTS;
			}else{
				$DicPrice1 = (($response_json_decode[$x]->PTS/100)*($response_json_decode[$x]->Discount));
				$DicPrice = (($response_json_decode[$x]->PTS) - ($DicPrice1));
			}


			$Total =(($quantityValGetDataExplode[$y])*($DicPrice));
			
			$TaxAmt =(($Total)*($response_json_decode[$x]->TaxRate))/100;

			if($TCSApp=='YES'){
				$TCS_Amt=((($Total)+($TaxAmt))*($response_json_decode[$x]->TCSRate))/100;
			}else{
				$TCS_Amt=0;
			}
			

			// ------------- Calculation end here -------------------------------

			$option1.='<tr id="'.$un_id.'" style="vertical-align: middle;">

				<td style="width: 100px" class="ItemTablePadding">
					<a class="remove" title="Delete" style="cursor: pointer;" onclick="hideTR(\''.$un_id.'\')">
						<i class="mdi mdi-trash-can" style="padding-left: 4px;"></i>
					</a>
					<input type="hidden" id="RemoveStatus'.$un_id.'" name="RemoveStatus[]" value="0">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ItemName'.$un_id.'" name="ItemName[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ItemName.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:270px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ItemCode'.$un_id.'" name="ItemCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ItemCode.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="Batch'.$un_id.'" name="Batch[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Batch.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="InStock'.$un_id.'" name="InStock[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->InStock.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="SelectQty'.$un_id.'" name="SelectQty[]" class="form-control inputBorderHide" value="'.$quantityValGetDataExplode[$y].'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<select name="R_frc[]" id="R_frc'.$un_id.'" class="" onchange="changeFRC('.$un_id.')">
						<option value="REGULAR" selected>REGULAR</option>
						<option value="FREE">FREE</option>
						<option value="REPLACEMENT">REPLACEMENT</option>
						<option value="CLAIMQTY">CLAIMQTY</option>
					</select>
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="MRP'.$un_id.'" name="MRP[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->MRP.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="UnitPrice'.$un_id.'" name="UnitPrice[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTS.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="Discount'.$un_id.'" name="Discount[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Discount.'" onfocusout="AP_dis_calculat('.$un_id.')" style="background-color: #ffffff;
				    border: 1px solid #ffffff!important;width:120px;">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="DisMRP'.$un_id.'" name="DisMRP[]" class="form-control inputBorderHide" value="'.$DicPrice.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;"  readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="PTR'.$un_id.'" name="PTR[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTR.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="PTS'.$un_id.'" name="PTS[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTS.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ChapterID'.$un_id.'" name="ChapterID[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ChapterID.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
				</td>

<td style="width: 100px;" class="ItemTablePadding">
	<input type="checkbox" class="messageCheckbox" id="NoTax'.$un_id.'" name="NoTax[]" value="1" onclick="RowLevelNoTaxClick('.$un_id.')" style="margin: 0px auto;display: block;">
</td>

<td style="width: 100px;" class="ItemTablePadding">
	<input type="checkbox" class="messageCheckbox" id="BreakAge'.$un_id.'" name="BreakAge[]" value="1" onclick="RowLevelBreakAgeClick('.$un_id.')" style="margin: 0px auto;display: block;">
</td>

				<input type="hidden" id="TaxRate'.$un_id.'" name="TaxRate[]"  value="'.$response_json_decode[$x]->TaxRate.'">
				<td class="desabled ItemTablePadding">
					<input type="text" id="TaxCode'.$un_id.'" name="TaxCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->TaxCode.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="TaxAmt'.$un_id.'" name="TaxAmt[]" class="form-control inputBorderHide" value="'.$TaxAmt.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="Total'.$un_id.'" name="Total[]" class="form-control inputBorderHide" value="'.$Total.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="R_TCS_rate'.$un_id.'" name="R_TCS_rate[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->TCSRate.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
				</td>
				<td class="desabled ItemTablePadding">
					<input type="text" id="R_TCS_Amt'.$un_id.'" name="R_TCS_Amt[]" class="form-control inputBorderHide" value="'.$TCS_Amt.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="R_Division'.$un_id.'" name="R_Division[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Division.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="WhsCode'.$un_id.'" name="WhsCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->WhsCode.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="BillNo'.$un_id.'" name="BillNo[]" class="form-control inputBorderHide" value="" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="BillDate'.$un_id.'" name="BillDate[]" class="form-control inputBorderHide" value="" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">

					<input type="hidden" id="BaseDocNo'.$un_id.'" name="BaseDocNo[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->BaseDocNo.'">

					<input type="hidden" id="BaseDocEntry'.$un_id.'" name="BaseDocEntry[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->BaseDocEntry.'">

					<input type="hidden" id="RefNo'.$un_id.'" name="RefNo[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->RefNo.'">

					<input type="hidden" id="BaseType'.$un_id.'" name="BaseType[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->BaseType.'">

					<input type="hidden" id="BaseLine'.$un_id.'" name="BaseLine[]" value="'.$response_json_decode[$x]->BaseLine.'">

					<input type="hidden" id="HSNEntry'.$un_id.'" name="HSNEntry[]" value="'.$response_json_decode[$x]->HSNEntry.'">
	
					<input type="text" id="BatchAge'.$un_id.'" name="BatchAge[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->RemainAge.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="TypeOfAPC'.$un_id.'" name="TypeOfAPC[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Type.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>';

				if(!empty($response_json_decode[$x]->MfgDate)){
					$option1 .= '<td class="desabled ItemTablePadding">
						<input type="text" id="MfgDate'.$un_id.'" name="MfgDate[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->MfgDate.'" style="background-color: #F4F4F7;
					    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
					</td>';
				}else{
					$option1 .= '<td class="ItemTablePadding">
						<input type="date" id="MfgDate'.$un_id.'" name="MfgDate[]" class="form-control inputBorderHide" value="" style="background-color: #ffffff;
					    border: 1px solid #ffffff!important;width:120px;">
					</td>';
				}

				$option1 .= '<td class="desabled ItemTablePadding">
					<input type="text" id="ExpiryDate'.$un_id.'" name="ExpiryDate[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ExpiryDate.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="UserTax1'.$un_id.'" name="UserTax1[]" class="form-control inputBorderHide" style="
				    border: 1px solid #ffffff!important;width:120px;">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="UserTax2'.$un_id.'" name="UserTax2[]" class="form-control inputBorderHide" style="
				    border: 1px solid #ffffff!important;width:120px;">
				</td>

			</tr>';
			
		}
		}
	}
}
else
{
	$option1 .= '<span style="text-align: center;color:red;">Record Null </span>';
}
			
		// =============================Selected Data Table Prepare End Here============================================
		



		return $option1;
    }

  	public function getARCMM_ItemMasterInRowLevel($API,$ItemCode,$quantityValGet,$rowCount,$TCSApp)
    {
    	
    	// print_r($API);
    	// die();
    	// ===================================== get All Item List start Here ========================================	

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		
		curl_close($ch);

		$response_json_decode=json_decode($response);
		// print_r($response);
		// die();

		// ===================================== get All Item List end Here =========================================

		// =============================Selected Data Table Prepare start Here============================================

if(!empty($response_json_decode)){
	$selectedItemDataExplode= explode(',', $ItemCode); // item code selected by user
	$quantityValGetDataExplode= explode(',', $quantityValGet); //Item Quantity enter by user
	
	for ($y=0; $y <count($response_json_decode) ; $y++) { 
		$id=$y+1;
		$un_id=$rowCount+$id;  // create unique id with the help of tbody row count
		
		
			for ($x=0; $x <count($response_json_decode) ; $x++) { 
			// $itemCode_BatchCode= $response_json_decode[$x]->ItemCode.'_'.$response_json_decode[$x]->Batch;

			$itemCode_BatchCode= $response_json_decode[$x]->ItemCode;

				if(($selectedItemDataExplode[$y])==($itemCode_BatchCode)){


			// ------------- Calculation start here -----------------------------
			
			// if($response_json_decode[$x]->Discount=='0' && $response_json_decode[$x]->Discount=='0.0'){
			// 	$DicPrice = $response_json_decode[$x]->PTS;
			// }else{
			// 	$DicPrice = ($response_json_decode[$x]->PTS) /($response_json_decode[$x]->Discount);
			// }
			$DicPrice = $response_json_decode[$x]->PTS;

			$Total =(($quantityValGetDataExplode[$y])*($DicPrice));
			
			$TaxAmt =(($Total)*($response_json_decode[$x]->TaxRate))/100;

			if($TCSApp=='YES'){
				$TCS_Amt=((($Total)+($TaxAmt))*($response_json_decode[$x]->TCSRate))/100;
			}else{
				$TCS_Amt=0;
			}
			

			// ------------- Calculation end here -------------------------------

			$option1.='<tr id="'.$un_id.'" style="vertical-align: middle;">

				<td style="width: 100px" class="ItemTablePadding">
					<a class="remove" title="Delete" style="cursor: pointer;" onclick="hideTR(\''.$un_id.'\')">
						<i class="mdi mdi-trash-can" style="padding-left: 4px;"></i>
					</a>
					<input type="hidden" id="RemoveStatus'.$un_id.'" name="RemoveStatus[]" value="0">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ItemName'.$un_id.'" name="ItemName[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ItemName.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:270px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ItemCode'.$un_id.'" name="ItemCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ItemCode.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="Batch'.$un_id.'" name="Batch[]" class="form-control inputBorderHide"  style="background-color: #ffffff;border: 1px solid #ffffff!important;width:120px;">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="InStock'.$un_id.'" name="InStock[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->InStock.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="SelectQty'.$un_id.'" name="SelectQty[]" class="form-control inputBorderHide" value="'.$quantityValGetDataExplode[$y].'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<select name="R_frc[]" id="R_frc'.$un_id.'" class="" onchange="changeFRC('.$un_id.')">
						<option value="REGULAR" selected>REGULAR</option>
						<option value="FREE">FREE</option>
						<option value="REPLACEMENT">REPLACEMENT</option>
						<option value="CLAIMQTY">CLAIMQTY</option>
					</select>
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="MRP'.$un_id.'" name="MRP[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->MRP.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="UnitPrice'.$un_id.'" name="UnitPrice[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTS.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="Discount'.$un_id.'" name="Discount[]" class="form-control inputBorderHide" value="0" onfocusout="AP_dis_calculat('.$un_id.')"style="background-color: #ffffff;border: 1px solid #ffffff!important; width:120px;">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="DisMRP'.$un_id.'" name="DisMRP[]" class="form-control inputBorderHide" value="'.$DicPrice.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="PTR'.$un_id.'" name="PTR[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTR.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="PTS'.$un_id.'" name="PTS[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTS.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ChapterID'.$un_id.'" name="ChapterID[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->HSNCode.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

<td style="width: 100px;" class="ItemTablePadding">
	<input type="checkbox" class="messageCheckbox" id="NoTax'.$un_id.'" name="NoTax[]" value="1" onclick="RowLevelNoTaxClick('.$un_id.')" style="margin: 0px auto;display: block;">
</td>

<td style="width: 100px;" class="ItemTablePadding">
	<input type="checkbox" class="messageCheckbox" id="BreakAge'.$un_id.'" name="BreakAge[]" value="1" onclick="RowLevelBreakAgeClick('.$un_id.')" style="margin: 0px auto;display: block;">
</td>

				<input type="hidden" id="TaxRate'.$un_id.'" name="TaxRate[]"  value="'.$response_json_decode[$x]->TaxRate.'">
				<td class="desabled ItemTablePadding">
					<input type="text" id="TaxCode'.$un_id.'" name="TaxCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->TaxCode.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="TaxAmt'.$un_id.'" name="TaxAmt[]" class="form-control inputBorderHide" value="'.$TaxAmt.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="Total'.$un_id.'" name="Total[]" class="form-control inputBorderHide" value="'.$Total.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="R_TCS_rate'.$un_id.'" name="R_TCS_rate[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->TCSRate.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
				</td>
				<td class="desabled ItemTablePadding">
					<input type="text" id="R_TCS_Amt'.$un_id.'" name="R_TCS_Amt[]" class="form-control inputBorderHide" value="'.$TCS_Amt.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="R_Division'.$un_id.'" name="R_Division[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Division.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="WhsCode'.$un_id.'" name="WhsCode[]" class="form-control inputBorderHide" value="'.$_SESSION['DefaultWareHouseId'].'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
				    <input type="text" id="BillNo'.$un_id.'" name="BillNo[]" class="form-control inputBorderHide" value="" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
				    <input type="text" id="BillDate'.$un_id.'" name="BillDate[]" class="form-control inputBorderHide" value="" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="hidden" id="BaseDocNo'.$un_id.'" name="BaseDocNo[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->BaseDocNo.'">

					<input type="hidden" id="BaseDocEntry'.$un_id.'" name="BaseDocEntry[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->BaseDocEntry.'">

					<input type="hidden" id="RefNo'.$un_id.'" name="RefNo[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->RefNo.'">

					<input type="hidden" id="BaseType'.$un_id.'" name="BaseType[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->BaseType.'">

					<input type="hidden" id="BaseLine'.$un_id.'" name="BaseLine[]" value="'.$response_json_decode[$x]->BaseLine.'">

					<input type="hidden" id="HSNEntry'.$un_id.'" name="HSNEntry[]" value="'.$response_json_decode[$x]->HSNEntry.'">

				    <input type="text" id="BatchAge'.$un_id.'" name="BatchAge[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->RemainAge.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
				    <input type="text" id="TypeOfAPC'.$un_id.'" name="TypeOfAPC[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Type.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:120px;" readonly="">
				</td>

				<td class="ItemTablePadding">
					<input type="date" id="MfgDate'.$un_id.'" name="MfgDate[]" class="form-control inputBorderHide" value="" style="background-color: #ffffff;order: 1px solid #ffffff!important;width:120px;">
				</td>

				<td class="ItemTablePadding">
					<input type="date" id="ExpiryDate'.$un_id.'" name="ExpiryDate[]" class="form-control inputBorderHide" value="" style="date-color: #ffffff;border: 1px solid #ffffff!important;width:120px;" onchange="SelectExpiryDate('.$un_id.')">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="UserTax1'.$un_id.'" name="UserTax1[]" class="form-control inputBorderHide" style="
				    border: 1px solid #ffffff!important;width:120px;">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="UserTax2'.$un_id.'" name="UserTax2[]" class="form-control inputBorderHide" style="
				    border: 1px solid #ffffff!important;width:120px;">
				</td>

			</tr>';
			
		}
		}
	}
}
else
{
	$option1 .= '<span style="text-align: center;color:red;">Record Null </span>';
}
			
		// =============================Selected Data Table Prepare End Here============================================
		



		return $option1;
    }

    public function getARInvoiceItemInRowLevel($API,$ItemCode,$quantityValGet,$rowCount,$TCSApp)
    {
    	
    	
    	// ===================================== get All Item List start Here ========================================	

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		
		curl_close($ch);

		$response_json_decode=json_decode($response);
		// print_r($response);
		// die();

		// ===================================== get All Item List end Here =========================================

		// =============================Selected Data Table Prepare start Here============================================

if(!empty($response_json_decode)){
	$selectedItemDataExplode= explode(',', $ItemCode); // item code selected by user
	$quantityValGetDataExplode= explode(',', $quantityValGet); //Item Quantity enter by user
	
	for ($y=0; $y <count($response_json_decode) ; $y++) { 
		$id=$y+1;
		$un_id=$rowCount+$id;  // create unique id with the help of tbody row count
		
		
			for ($x=0; $x <count($response_json_decode) ; $x++) { 
				$itemCode_BatchCode= $response_json_decode[$x]->ItemCode.'_'.$response_json_decode[$x]->Batch;

				if(($selectedItemDataExplode[$y])==($itemCode_BatchCode)){


				// ------------- Calculation start here -----------------------------
					if($response_json_decode[$x]->Discount=='0' && $response_json_decode[$x]->Discount=='0.0'){
						$DicPrice = $response_json_decode[$x]->PTS;
					}else{
						$DicPrice = ($response_json_decode[$x]->PTS) /($response_json_decode[$x]->Discount);
					}

					$DicP=$UnitPrice[$x]-$DisMRP[$x];
					$Total =(($quantityValGetDataExplode[$y])*($DicPrice));
					
					$TaxAmt =(($Total)*($response_json_decode[$x]->TaxRate))/100;

					if($TCSApp=='YES'){
						$TCS_Amt=((($Total)+($TaxAmt))*($response_json_decode[$x]->TCSRate))/100;
					}else{
						$TCS_Amt=0;
					}
				// ------------- Calculation end here -------------------------------

			$option1.='<tr id="'.$un_id.'" style="vertical-align: middle;">

				<td style="width: 100px" class="ItemTablePadding">
					<a class="remove" title="Delete" style="cursor: pointer;" onclick="hideTR(\''.$un_id.'\')">
						<i class="mdi mdi-trash-can" style="padding-left: 4px;"></i>
					</a>
					<input type="hidden" id="RemoveStatus'.$un_id.'" name="RemoveStatus[]" value="0">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ItemName'.$un_id.'" name="ItemName[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ItemName.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:270px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ItemCode'.$un_id.'" name="ItemCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ItemCode.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:90px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="Batch'.$un_id.'" name="Batch[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Batch.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:60px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="InStock'.$un_id.'" name="InStock[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->InStock.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:60px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="SelectQty'.$un_id.'" name="SelectQty[]" class="form-control inputBorderHide" value="'.$quantityValGetDataExplode[$y].'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:70px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<select name="R_frc[]" id="R_frc'.$un_id.'" class="" onchange="changeFRC('.$un_id.')">
						<option value="REGULAR" selected>REGULAR</option>
						<option value="FREE">FREE</option>
						<option value="REPLACEMENT">REPLACEMENT</option>
						<option value="CLAIMQTY">CLAIMQTY</option>
					</select>
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="MRP'.$un_id.'" name="MRP[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->MRP.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:90px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="UnitPrice'.$un_id.'" name="UnitPrice[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTS.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:90px;" readonly="">
				</td>

<td class="ItemTablePadding">
	<input type="text" id="Discount'.$un_id.'" name="Discount[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Discount.'" style="background-color: #ffffff;border: 1px solid #ffffff!important; width:70px;" onfocusout="rowLevelCal('.$un_id.')" onkeypress="return isNumberKey(event)">
</td>

<td class="ItemTablePadding">
	<input type="text" id="MRPDiscCal'.$un_id.'" name="MRPDiscCal[]" class="form-control inputBorderHide" value="'.$DicP.'" style="background-color: #ffffff;border: 1px solid #ffffff!important; width:90px;" onfocusout="DisAmtToGetPercentage('.$un_id.')" onkeypress="return isNumberKey(event)">
</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="DisMRP'.$un_id.'" name="DisMRP[]" class="form-control inputBorderHide" value="'.$DicPrice.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:90px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="PTR'.$un_id.'" name="PTR[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTR.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:90px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="PTS'.$un_id.'" name="PTS[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->PTS.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:90px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ChapterID'.$un_id.'" name="ChapterID[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ChapterID.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:90px;" readonly="">
				</td>

<td style="width: 100px;" class="ItemTablePadding">
	<input type="checkbox" class="messageCheckbox" id="NoTax'.$un_id.'" name="NoTax[]" value="1" onclick="RowLevelNoTaxClick('.$un_id.')" style="margin: 0px auto;display: block;">
</td>

				<input type="hidden" id="TaxRate'.$un_id.'" name="TaxRate[]"  value="'.$response_json_decode[$x]->TaxRate.'">
				<td class="desabled ItemTablePadding">
					<input type="text" id="TaxCode'.$un_id.'" name="TaxCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->TaxCode.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:90px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="TaxAmt'.$un_id.'" name="TaxAmt[]" class="form-control inputBorderHide" value="'.$TaxAmt.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:90px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="Total'.$un_id.'" name="Total[]" class="form-control inputBorderHide" value="'.$Total.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important;width:90px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="R_TCS_rate'.$un_id.'" name="R_TCS_rate[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->TCSRate.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:90px;" readonly="">
				</td>
				<td class="desabled ItemTablePadding">
					<input type="text" id="R_TCS_Amt'.$un_id.'" name="R_TCS_Amt[]" class="form-control inputBorderHide" value="'.$TCS_Amt.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:90px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="R_Division'.$un_id.'" name="R_Division[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->Division.'" style="background-color: #F4F4F7;border: 1px solid #F4F4F7!important; width:90px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="WhsCode'.$un_id.'" name="WhsCode[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->WhsCode.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:70px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="MfgDate'.$un_id.'" name="MfgDate[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->MfgDate.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:70px;" readonly="">
				</td>

				<td class="desabled ItemTablePadding">
					<input type="text" id="ExpiryDate'.$un_id.'" name="ExpiryDate[]" class="form-control inputBorderHide" value="'.$response_json_decode[$x]->ExpiryDate.'" style="background-color: #F4F4F7;
				    border: 1px solid #F4F4F7!important;width:70px;" readonly="">
				</td>

				<td class="ItemTablePadding">
					<input type="text" id="UserTax1'.$un_id.'" name="UserTax1[]" class="form-control inputBorderHide" style="
				    border: 1px solid #ffffff!important;width:120px;">
				</td>
				<td class="ItemTablePadding">
					<input type="text" id="UserTax2'.$un_id.'" name="UserTax2[]" class="form-control inputBorderHide" style="
				    border: 1px solid #ffffff!important;width:120px;">
				</td>

			</tr>';
			
		}
		}
	}
}
else
{
	$option1 .= '<span style="text-align: center;color:red;">Record Null </span>';
}
			
		// =============================Selected Data Table Prepare End Here============================================
		
		return $option1;
    }

    public function Search_AP_Invoice_Stand_SuppList($APSUPPLIER_API,$CardCode)
    {
		if(!empty($CardCode)){
			$url=$APSUPPLIER_API.'?CardName='.$CardCode; // All Parameter Eneter Here
		}else{
			$url=$APSUPPLIER_API; 
		}

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);

		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
        		for ($i=0; $i <count($response_json_decode) ; $i++) {

        		$option .= '<tr id="'.$i.'">
                            <th scope="row">
                                <div class="custom-control custom-checkbox">
									<input type="radio" class="custom-control-input" id="CustListId'.$i.'" value="'.$i.'" name="custSelected[]"><label class="custom-control-label" for="customCheck1"></label>

									<input type="hidden" id="PayTemCode'.$i.'" name="PayTemCode'.$i.'" value="'.$response_json_decode[$i]->PayTemCode.'">
									<input type="hidden" id="PayTermName'.$i.'" name="PayTermName'.$i.'" value="'.$response_json_decode[$i]->PayTermName.'">
									<input type="hidden" id="ExtrDays'.$i.'" name="ExtrDays'.$i.'" value="'.$response_json_decode[$i]->ExtrDays.'">

                                </div>
                            </th>

                            <td id="CardCode'.$i.'">'.$response_json_decode[$i]->CardCode.'</td>
                            <td id="CardName'.$i.'">'.$response_json_decode[$i]->CardName.'</td>

						</tr>';
                }
			}else{
				$option .= '<tr>
                            <td colspan="3" style="text-align: center;color:red;">Record Not Found</td>
                        </tr>';
			}
		// =============================Search Data Table Prepare End Here============================================
		return $option;
    }


    public function SearchCustomerList($CUSTOMERLIST_API,$CardCode,$BPLID)
    {
		$url=$CUSTOMERLIST_API.$CardCode.'&BPLID='.$BPLID; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);

		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
        		for ($i=0; $i <count($response_json_decode) ; $i++) {

        		$option .= '<tr id="'.$i.'">
                            <th scope="row">
                                <div class="custom-control custom-checkbox">
									<input type="radio" class="custom-control-input" id="CustListId'.$i.'" value="'.$i.'" name="custSelected[]"><label class="custom-control-label" for="customCheck1"></label>

									<input type="hidden" id="PaymentTerm'.$i.'" name="PaymentTerm" value="'.$response_json_decode[$i]->PaymentTerm.'">
									<input type="hidden" id="ExtraDays'.$i.'" name="ExtraDays" value="'.$response_json_decode[$i]->ExtraDays.'">
									<input type="hidden" id="GSTINNo'.$i.'" name="GSTINNo" value="'.$response_json_decode[$i]->GSTINNo.'">
									<input type="hidden" id="GSTStateCode'.$i.'" name="GSTStateCode" value="'.$response_json_decode[$i]->GSTStateCode.'">

                                </div>
                            </th>
                            <td id="CardCode'.$i.'">'.$response_json_decode[$i]->CardCode.'</td>
                            <td id="CardName'.$i.'">'.$response_json_decode[$i]->CardName.'</td>
							<td id="OPTHAL'.$i.'">'.$response_json_decode[$i]->OPTHAL.'</td>
							<td id="RETENT'.$i.'">'.$response_json_decode[$i]->RETENT.'</td>
							<td id="ORIZO'.$i.'">'.$response_json_decode[$i]->ORIZO.'</td>
							<td id="HQ'.$i.'">'.$response_json_decode[$i]->HQ.'</td>
							<td id="City'.$i.'">'.$response_json_decode[$i]->City.'</td>
							<td id="Balance'.$i.'">'.$response_json_decode[$i]->Balance.'</td>
						</tr>';
                }
			}else{
				$option .= '<tr>
                            <td colspan="9" style="text-align: center;color:red;">Record Not Found</td>
                        </tr>';
			}
		// =============================Search Data Table Prepare End Here============================================
		return $option;
    }

    public function getPayToDrpdownByCordCode($PayTo_URL)
    {
    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$PayTo_URL);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PayToList=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($PayToList) ; $i++) {
			$option .= '<option value="'.$PayToList[$i]->PayTo.'">'.$PayToList[$i]->PayTo.'</option>';
		}      
		return $option;
    }

    public function CancelDraftAR_CreditMemo($Final_API)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$result=json_decode($output);
		curl_close($ch);

		return $result;
    }

 	public function GetOtherDeductionDropdown($INCPAYOTHDED_API)
    {
    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$INCPAYOTHDED_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$List=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($List) ; $i++) {
			$option .= '<option value="'.$List[$i]->DeductionType.'">'.$List[$i]->DeductionType.'</option>';
		}      
		return $option;
    }
// INCPAYBANK_API
    public function GetPayBankDropdown($INCPAYBANK_API)
    {
    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$INCPAYBANK_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$List=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($List) ; $i++) {
			$option .= '<option value="'.$List[$i]->Bank.'">'.$List[$i]->Bank.'</option>';
		}      
		return $option;
    }

    public function getPayToDetailsByPatTo($PayToAPI,$PayTo)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$PayToAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PayToData=json_decode($output);

		curl_close($ch);

		// for ($i=0; $i < count($PayToData) ; $i++) {

		// 	if($PayToData[$i]->PayTo == $PayTo){
		// 		$return=array();
		// 		$return['Address'] = str_replace('"', ' ', $PayToData[$i]->Address); // All (") - double cot remove
		// 		$return['POS']=$PayToData[$i]->POS;
		// 	}
		// }   
		return $PayToData;
    }	

    public function getDeductionDetailsByDedType($DedType_API)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$DedType_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$DedType=json_decode($output);
		curl_close($ch);
		
		$return=array();
		$return['DeductionType'] = str_replace('"', ' ', $DedType[0]->DeductionType); // All (") - double cot remove
		$return['GLAccount']=$DedType[0]->GLAccount;
		  
		return $return;
    }	

  	public function getPayBankDetailsByBankName($PayBank_API)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$PayBank_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PayBank=json_decode($output);
		curl_close($ch);
		
		$return=array();
		$return['Branch'] = str_replace('"', ' ', $PayBank[0]->Branch); // All (") - double cot remove
		$return['GLAccount']=$PayBank[0]->GLAccount;
		$return['AccountNum']=$PayBank[0]->AccountNum;
		return $return;
    }	

    public function getCustomerShipTo($ShipToAPI)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$ShipToAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$ShipToList=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($ShipToList) ; $i++) {
				$option .= '<option value="'.$ShipToList[$i]->PayTo.'">'.$ShipToList[$i]->PayTo.'</option>';
		}      
		return $option;
    }

    public function getShipToDetailsByPatTo($ShipToAPI,$ShipTo)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$ShipToAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PayToData=json_decode($output);
		curl_close($ch);
		// for ($i=0; $i < count($PayToData) ; $i++) {
		// 	if($PayToData[$i]->PayTo == $ShipTo){
		// 		$return=array();
		// 		$return['Address'] = str_replace('"', ' ', $PayToData[0]->Address); // All (") - double cot remove
		// 		$return['PlaceOfSupply']=$PayToData[0]->POS;
		// 	}
		// }   
		return $PayToData;
    }

    public function CreateActualAR_Invoce($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		return $response;
	}

	public function ActionMasterFunction($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		return $response;
	}

	public function CancellInvoiveAndDraftDoc($API)
    {
    	// print_r($API);
    	// die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		return $response;
	}

    public function SearchSupplierList($SUPPLIERLIST_API,$SupplierName)
    {
		$url=$SUPPLIERLIST_API.$SupplierName; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);
// die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);

		// =============================Search Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
        		for ($i=0; $i <count($response_json_decode) ; $i++) {

        		$option .= '<tr id="'.$i.'">
                            <th scope="row" class="text-center">
                                <div class="custom-control custom-checkbox">
<input type="radio" class="custom-control-input" id="CustListId'.$i.'" value="'.$i.'" name="custSelected[]"><label class="custom-control-label" for="customCheck1"></label>

                                </div>
                            </th>
                            <td id="CardCode'.$i.'">'.$response_json_decode[$i]->CardCode.'</td>
                            <td id="CardName'.$i.'">'.$response_json_decode[$i]->CardName.'</td>
                        </tr>';
                }
			}else{
				$option .= '<tr>
                            <td colspan="3" style="text-align: center;color:red;">Record Not Found</td>
                        </tr>';
			}

            // <td id="Balance'.$i.'">'.$response_json_decode[$i]->Balance.'</td>
		// =============================Search Data Table Prepare End Here============================================
		return $option;
    }

    public function getAccountDetailsByPaymentmeans($Common_API)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Common_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$responce=json_decode($output);
		curl_close($ch);
    
		return $responce;
    }

    public function getCashPaymentGL($INCPAYCASHACCOUNT_API)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$INCPAYCASHACCOUNT_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$responce=json_decode($output);
		curl_close($ch);
    
		return $responce;
    }

    public function CreateAR_Invoice($CREATEARINVOICE_API,$mainArray)
    {
    	$postdata = json_encode($mainArray);

		$ch = curl_init($CREATEARINVOICE_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
    }

    public function CreateAR_InvoiceDraf($AR_InvoceDraf_API,$mainArray)
    {
    	$postdata = json_encode($mainArray);

		$ch = curl_init($AR_InvoceDraf_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
    }

    public function CreateBP_Reconciliation($CREATEBPRECONCILIATION_API,$mainArray)
    {
    	$postdata = json_encode($mainArray);

		$ch = curl_init($CREATEBPRECONCILIATION_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
    }


    public function CreateARCMM($ARCREDITMEMODRAFT,$mainArray)
    {
    	$postdata = json_encode($mainArray);

		$ch = curl_init($ARCREDITMEMODRAFT); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
    }

    public function UpdateDraftARCMM($ARCREDITMEMODRAFT,$mainArray)
    {
    	$postdata = json_encode($mainArray);

		$ch = curl_init($ARCREDITMEMODRAFT); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
    }

    public function getInVicesListBySupplierWise($API,$h_PostingDate)
    {
		$stripped = rtrim($API, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);
// die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);

		// =============================Invoice Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
        		for ($i=0; $i <count($response_json_decode) ; $i++) {

// <!-- ------------ Overdue Days Calculation start here --------------------------- -->
					$date1=date("Y-m-d", strtotime(trim($response_json_decode[$i]->DueDate)));
					$date2=$h_PostingDate;

					$date1_ts = strtotime($date1);
					$date2_ts = strtotime($date2);
					$diff = $date2_ts - $date1_ts;
					$dateDiff= round($diff / 86400) .' Days';
// <!-- ------------ Overdue Days Calculation end here --------------------------- -->

			$option.='<tr id="'.$i.'">

						<td style="width: 100px;vertical-align: middle; text-align: center;">
							<input type="hidden" name="ObjType[]" id="ObjType'.$i.'" value="'.$response_json_decode[$i]->ObjType.'" >
							<input type="hidden" name="InternalNo[]" id="InternalNo'.$i.'" value="'.$response_json_decode[$i]->InternalNo.'" >

							<input type="hidden" name="ARInternalNo[]" id="ARInternalNo'.$i.'" value="'.$response_json_decode[$i]->ARInternalNo.'" >

							<input type="checkbox" class="messageCheckbox" id="SupListId'.$i.'" name="SuppListSelected[]" value="'.$response_json_decode[$i]->BalanceDue.'" onclick="InvoiceSelected('.$i.')" >

							<input type="hidden" id="usercheckList'.$i.'" name="usercheckList[]" value="0">
						</td>

						<td class="desabled">
						    <input type="text" name="DocNo[]" id="DocNo'.$i.'" value="'.$response_json_decode[$i]->DocNum.'" readonly class="FreightInput">
						</td>

						<td class="desabled">
						<input type="hidden" name="PDocTypeOG[]" id="PDocTypeOG'.$i.'" value="'.$response_json_decode[$i]->PDocType.'" readonly class="FreightInput">
						    <input type="text" name="PDocType[]" id="PDocType'.$i.'" value="'.$response_json_decode[$i]->Type.'" readonly class="FreightInput">
						</td>

						<td class="desabled">
						    <input type="text" name="CustPONo[]" id="CustPONo'.$i.'" value="'.$response_json_decode[$i]->DepoRefNo.'" readonly class="FreightInput" disabled>
						</td> 

						<td class="desabled">
						    <input type="text" name="Date[]" id="Date'.$i.'" value="'.date("d-m-Y", strtotime(trim($response_json_decode[$i]->PostingDate))).'" readonly class="FreightInput">
						</td>
						<td class="desabled">
						    <input type="text" name="DueDate[]" id="DueDate'.$i.'" value="'.date("d-m-Y", strtotime(trim($response_json_decode[$i]->DueDate))).'" readonly class="FreightInput">
						</td>

						<td class="desabled">
						    <input type="text" name="OverdueDays[]" id="OverdueDays'.$i.'" value="'.$dateDiff.'" readonly class="FreightInput">
						</td>

						

						<td class="desabled">
						    <input type="text" name="Total[]" id="Total'.$i.'" value="'.$response_json_decode[$i]->Total.'" readonly class="FreightInput" disabled>
						</td>

						<td class="desabled">
						    <input type="text" name="BalanceDue[]" id="BalanceDue'.$i.'" value="'.$response_json_decode[$i]->BalanceDue.'" readonly class="FreightInput" disabled>
						</td>


						<td>
						    <input type="text" name="TotalPayment[]" id="TotalPayment'.$i.'"  class="FreightInput" value="'.$response_json_decode[$i]->BalanceDue.'" onfocusout="RowLevelchangeTotalAmountManual('.$i.')" style="border: transparent;outline: transparent;">
						</td>
					</tr>';
                }

// <td class="desabled">
//     <input type="text" name="CashDis[]" id="CashDis'.$i.'" value="0" onfocusout="calculateDiscount('.$i.')" class="FreightInput" disabled>
// </td>
// <td class="">
//     <input type="text" name="DocRemarks[]" id="DocRemarks'.$i.'" value="'.$response_json_decode[$i]->Remark1.'" style="border: transparent;outline: transparent;">
// </td>
			}else{
				$option .= '<tr>
                            <td colspan="12" style="text-align: center;color:red;font-weight: bold;">Record Not Found</td>
                        </tr>';
			}
		// =============================Invoice Data Table Prepare End Here============================================
		return $option;
    }


    public function getInVicesListBySupplierWise_OutGoing($API,$h_PostingDate)
    {
		$stripped = rtrim($API, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);
// die();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $Final_url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode=json_decode($response);

		// =============================Invoice Data Table Prepare start Here============================================

		$option ='';
			if(!empty($response_json_decode)){
				
        		for ($i=0; $i <count($response_json_decode) ; $i++) {

// <!-- ------------ Overdue Days Calculation start here --------------------------- -->
					$date1=date("Y-m-d", strtotime(trim($response_json_decode[$i]->DueDate)));
					$date2=$h_PostingDate;

					$date1_ts = strtotime($date1);
					$date2_ts = strtotime($date2);
					$diff = $date2_ts - $date1_ts;
					$dateDiff= round($diff / 86400) .' Days';
// <!-- ------------ Overdue Days Calculation end here --------------------------- -->

			$option.='<tr id="'.$i.'">

						<td style="width: 100px;vertical-align: middle; text-align: center;">
							<input type="hidden" name="ObjType[]" id="ObjType'.$i.'" value="'.$response_json_decode[$i]->ObjType.'" >
							<input type="hidden" name="InternalNo[]" id="InternalNo'.$i.'" value="'.$response_json_decode[$i]->DocEntry.'" >

							<input type="hidden" name="ARInternalNo[]" id="ARInternalNo'.$i.'" value="'.$response_json_decode[$i]->ARInternalNo.'" >

							<input type="checkbox" class="messageCheckbox" id="SupListId'.$i.'" name="SuppListSelected[]" value="'.$response_json_decode[$i]->BalanceDue.'" onclick="InvoiceSelected('.$i.')" >

							<input type="hidden" id="usercheckList'.$i.'" name="usercheckList[]" value="0">
						</td>

						<td class="desabled">
						    <input type="text" name="DocNo[]" id="DocNo'.$i.'" value="'.$response_json_decode[$i]->DocNo.'" readonly class="FreightInput">
						</td>

						<td class="desabled">
						<input type="hidden" name="PDocTypeOG[]" id="PDocTypeOG'.$i.'" value="'.$response_json_decode[$i]->PDocType.'" readonly class="FreightInput">
						    <input type="text" name="PDocType[]" id="PDocType'.$i.'" value="'.$response_json_decode[$i]->Type.'" readonly class="FreightInput">
						</td>

						<td class="desabled">
						    <input type="text" name="CustPONo[]" id="CustPONo'.$i.'" value="'.$response_json_decode[$i]->CustPONo.'" readonly class="FreightInput" disabled>
						</td> 

						<td class="desabled">
						    <input type="text" name="Date[]" id="Date'.$i.'" value="'.date("d-m-Y", strtotime(trim($response_json_decode[$i]->Date))).'" readonly class="FreightInput">
						</td>
						<td class="desabled">
						    <input type="text" name="DueDate[]" id="DueDate'.$i.'" value="'.date("d-m-Y", strtotime(trim($response_json_decode[$i]->DueDate))).'" readonly class="FreightInput">
						</td>

						<td class="desabled">
						    <input type="text" name="OverdueDays[]" id="OverdueDays'.$i.'" value="'.$dateDiff.'" readonly class="FreightInput">
						</td>

						

						<td class="desabled">
						    <input type="text" name="Total[]" id="Total'.$i.'" value="'.$response_json_decode[$i]->Total.'" readonly class="FreightInput" disabled>
						</td>

						<td class="desabled">
						    <input type="text" name="BalanceDue[]" id="BalanceDue'.$i.'" value="'.$response_json_decode[$i]->BalanceDue.'" readonly class="FreightInput" disabled>
						</td>


						<td>
						    <input type="text" name="TotalPayment[]" id="TotalPayment'.$i.'"  class="FreightInput" value="'.$response_json_decode[$i]->BalanceDue.'" onfocusout="RowLevelchangeTotalAmountManual('.$i.')" style="border: transparent;outline: transparent;">
						</td>
					</tr>';
                }

// <td class="desabled">
//     <input type="text" name="CashDis[]" id="CashDis'.$i.'" value="0" onfocusout="calculateDiscount('.$i.')" class="FreightInput" disabled>
// </td>
// <td class="">
//     <input type="text" name="DocRemarks[]" id="DocRemarks'.$i.'" value="'.$response_json_decode[$i]->Remark1.'" style="border: transparent;outline: transparent;">
// </td>
			}else{
				$option .= '<tr>
                            <td colspan="12" style="text-align: center;color:red;font-weight: bold;">Record Not Found</td>
                        </tr>';
			}
		// =============================Invoice Data Table Prepare End Here============================================
		return $option;
    }

    public function CreateOutgoingPayment($CREATEOUTGOINGPAYMENT_API,$tdata)
    {
    	$postdata = json_encode($tdata);

		$ch = curl_init($CREATEOUTGOINGPAYMENT_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }

    public function CreateIncommingPayment($CREATEINCPAY_API,$mainArray)
    {
    	$postdata = json_encode($mainArray);

		$ch = curl_init($CREATEINCPAY_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }

 	public function ARIN_EwayDetailsSave($UPDATEEWAYDETINV_API,$mainArray)
    {
    	$postdata = json_encode($mainArray);

		$ch = curl_init($UPDATEEWAYDETINV_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }

    public function ARCN_EwayDetailsSave($UPDATEEWAYDETARCR_API,$mainArray)
    {
    	$postdata = json_encode($mainArray);

		$ch = curl_init($UPDATEEWAYDETARCR_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }

    public function CreateOutgoingPaymentNew($CREATEOUTPAY_API,$mainArray)
    {
    	$postdata = json_encode($mainArray);

		$ch = curl_init($CREATEOUTPAY_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }

  	public function CreateJE($CREATEJE_API,$mainArray)
    {
    	$postdata = json_encode($mainArray);

		$ch = curl_init($CREATEJE_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }

    public function getDivisionDropdown($CardCode,$DIVISION_API)
    {
    	$API=$DIVISION_API.'?CardCode='.$CardCode;
// print_r($API);die();
    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$DivList=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($DivList) ; $i++) {
			$option .= '<option value="'.$DivList[$i]->Division.'">'.$DivList[$i]->Division.'</option>';
		}      
		return $option;
    }

    public function getDivisionDropdownForARMD($CardCode,$Division,$DIVISION_API)
    {
    	$API=$DIVISION_API.'?CardCode='.$CardCode;
    	// print($API);
    	// die();
    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$DivList=json_decode($output);
		curl_close($ch);

		// if(!empty($Division)){
			for ($i=0; $i < count($DivList) ; $i++) {
				if($Division==$DivList[$i]->Division){
					$option .= '<option value="'.$DivList[$i]->Division.'" selected>'.$DivList[$i]->Division.'</option>';	
				}else{
					$option .= '<option value="'.$DivList[$i]->Division.'">'.$DivList[$i]->Division.'</option>';
				}
			}	
		// }else{
		// 	$option='<option value="">Please Select</option>';
		// 	for ($i=0; $i < count($DivList) ; $i++) {
		// 		$option .= '<option value="'.$DivList[$i]->Division.'">'.$DivList[$i]->Division.'</option>';
		// 	}
		// }
		      
		return $option;
    }
    public function getTranspoterNameDrpdown($TRANSPOTERNAME_API,$TransporterNameOld)
    {
    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$TRANSPOTERNAME_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$TranNameList=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($TranNameList) ; $i++) {
			if($TransporterNameOld==$TranNameList[$i]->TransCode){
				$option .= '<option value="'.$TranNameList[$i]->TransCode.'" selected>'.$TranNameList[$i]->TransName.'</option>';
			}else{
				$option .= '<option value="'.$TranNameList[$i]->TransCode.'">'.$TranNameList[$i]->TransName.'</option>';
			}
		}      
		return $option;
    }

    public function getTranspoterNameDrpdownForARIN($TRANSPOTERNAME_API)
    {
    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$TRANSPOTERNAME_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$TranNameList=json_decode($output);
		curl_close($ch);

		$option='<option value="0">Please Select</option>';

		for ($i=0; $i < count($TranNameList) ; $i++) {
			$option .= '<option value="'.$TranNameList[$i]->TransName.'">'.$TranNameList[$i]->TransName.'</option>';
		}      
		return $option;
    }

 	public function getModeDrpdown_ARIN($MODE_API)
    {
    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$MODE_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$ModeList=json_decode($output);
		curl_close($ch);

		$option='<option value="0">Please Select</option>';

		for ($i=0; $i < count($ModeList) ; $i++) {
			$option .= '<option value="'.$ModeList[$i]->ModeCode.'">'.$ModeList[$i]->ModeName.'</option>';	
		}      
		return $option;
    }

    public function getVEHICLETYPE_ModeDrpdown_ARIN($VEHICLETYPE_API)
    {
    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$VEHICLETYPE_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$ModeList=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($ModeList) ; $i++) {
			$option .= '<option value="'.$ModeList[$i]->TypeCode.'">'.$ModeList[$i]->TypeName.'</option>';	
		}      
		return $option;
    }
    public function getModeNamebyModeCode($MODE_API,$ModeCode)
    {
    	$API_URL=$MODE_API.'?ModeCode='.$ModeCode;

    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$API_URL);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$ModeList=json_decode($output);
		curl_close($ch);

		$ModeName=$ModeList[0]->ModeName;
		   
		return $ModeName;
    }
    public function getVehicleNamebyVehicleCode($VEHICLETYPE_API,$VehicleType)
    {
    	$API_URL=$VEHICLETYPE_API.'?TypeCode='.$VehicleType;

    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$API_URL);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$ModeList=json_decode($output);
		curl_close($ch);

		$ModeName=$ModeList[0]->TypeName;
		   
		return $ModeName;
    }
    

    public function getModeDrpdown($MODE_API,$ModeOld)
    {
    	$ch = curl_init();  
 
		curl_setopt($ch,CURLOPT_URL,$MODE_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$ModeList=json_decode($output);
		curl_close($ch);

		$option='<option value="">Please Select</option>';

		for ($i=0; $i < count($ModeList) ; $i++) {
			if($ModeOld==$ModeList[$i]->ModeCode){
				$option .= '<option value="'.$ModeList[$i]->ModeCode.'" selected>'.$ModeList[$i]->ModeName.'</option>';	
			}else{
				$option .= '<option value="'.$ModeList[$i]->ModeCode.'">'.$ModeList[$i]->ModeName.'</option>';	
			}
		}      
		return $option;
    }

    public function getTCS_ApplicableByCordCode($API)
	{
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$output=curl_exec($ch);
		curl_close($ch);

		return $output;
    }

    public function getAP_HQ($API)
	{
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$output=curl_exec($ch);
		curl_close($ch);

		return $output;
    }

	public function getAR_DraftInvoiceById($New_AR_InvoiceList_API,$InternalNo)
    {
    	$url=$New_AR_InvoiceList_API.'?DocEntry='.$InternalNo.'&BPLID='.$_SESSION['BPLID']; // All Parameter Eneter Here
// print($url);die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

    public function getAR_Credit_memo_DraftById($API_URL)
    {
    	// print_r($API_URL);
    	// die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$API_URL);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

    public function getAR_InvoiceListDetails($New_AR_InvoiceList_API,$tdata)
    {
    	if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
    		//$Date='FromDate=&ToDate=&DocEntry=';
    	}else{
    		$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
    	}

    	if(!empty($tdata['Status'])){
			$Status='&Status='.$tdata['Status'];
    	}else{
			//$Status='&DocStatus=';
    	}

    	if(!empty($tdata['DocType'])){
			$DocType='?Type='.$tdata['DocType'];
    	}else{
			$DocType='?Type=Draft';
    	}


		if(!empty($tdata['Division'])){
    		$Division='&Division='.$tdata['Division'];
    	}

    	if(!empty($tdata['TypeOfAPC'])){
    		$TypeOfAPC='&TypeOfAPC='.$tdata['TypeOfAPC'];
    	}

    	if(!empty($tdata['CardCode'])){
    		$CardCode='&CardCode='.$tdata['CardCode'];
    	}
    	
    	// $url=$DRAFTARCRHDLISTNEW_API.$Date.$Status.$Type.$Division.$TypeOfAPC.$CardCode; // All Parameter Eneter Here


    	$url=$New_AR_InvoiceList_API.$DocType.$Date.$Status.'&BPLID='.$tdata['BPLID'].$Division.$TypeOfAPC.$CardCode; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PurchasOrderLinstData=json_decode($output);
		curl_close($ch);

		return $PurchasOrderLinstData;
    }

    public function getPURE_Detailed_ListExport($APINVDETAILS_API,$tdata)
    {
		if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
			$Date='';
		}else{
			$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
		}

		$url=$APINVDETAILS_API.'?BPLID='.$tdata['BPLID'].$Date; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PURESUMMARY=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}
		.bg{background-color:#f8d483 !important;}
		</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">DocumentType</th>
								<th class="head">InvoiceNo</th> 
								<th class="head">PostingDate</th> 
								<th class="head">Branch</th> 
								<th class="head">DocumentName</th>
								<th class="head">OriginalInvoice</th>
								<th class="head">OriginalInvoiceDate</th> 
								<th class="head">DocType</th> 
								<th class="head">DEPORefNo</th> 
								<th class="head">CustomerCode</th> 
								<th class="head">CustomerName</th>
								<th class="head">VendorCode</th> 
								<th class="head">VendorName</th> 
								<th class="head">LocationName</th> 
								<th class="head">ItemCode</th> 
								<th class="head">ItemDscription</th>
								<th class="head">TotalBeforeTax</th> 
								<th class="head">TaxAmount</th> 
								<th class="head">InvoiceTotal</th> 
								<th class="head">Quantity</th>
								<th class="head">Price</th>
								<th class="head">PaymentTerm</th> 
								<th class="head">TransactionType</th> 
								<th class="head">InternalNo</th> 
								<th class="head">CustomerGroup</th> 
								<th class="head">SalesEmployee</th>
								<th class="head">CustomerGSTIN</th> 
								<th class="head">PlaceOfSupply</th> 
								<th class="head">HSNSACCode</th> 
								<th class="head">ProductGroup</th> 
								<th class="head">TaxCode</th>
								<th class="head">BasicAmount</th> 
								<th class="head">GrossAmountForeignCurrency</th> 
								<th class="head">IGSTRate</th> 
								<th class="head">IGSTAmount</th>
								<th class="head">CGSTRate</th>
								<th class="head">CGSTAmount</th> 
								<th class="head">SGSTRate</th> 
								<th class="head">SGSTAmount</th> 
								<th class="head">UTGSTRate</th> 
								<th class="head">TCSRate</th>
								<th class="head">UTGSTAmount</th> 
								<th class="head">TCSAmount</th> 
								<th class="head">ReverseCharges</th> 
								<th class="head">Discount</th> 
								<th class="head">Rounding</th>
								<th class="head">ROE</th> 
								<th class="head">HSNCode</th> 
								<th class="head">Currency</th> 
								<th class="head">ImportExport</th>
								<th class="head">LocationGSTIN</th>
								<th class="head">AcctCode</th> 
								<th class="head">GLAccountName</th> 
								<th class="head">Division</th> 
								<th class="head">SalesOrderNo</th> 
								<th class="head">ScheduledDeliveryDate</th>
								<th class="head">IRNNo</th> 
								<th class="head">AckNo</th> 
								<th class="head">AckDate</th> 
								<th class="head">TCSApp</th> 
								<th class="head">EWayBillNo</th>
								<th class="head">EWayBillDt</th> 
								<th class="head">StateTypeB</th> 
								<th class="head">StateTypeS</th> 
								<th class="head">PANNo</th>
								<th class="head">City</th>
								<th class="head">State</th> 
								<th class="head">OrderRefNo</th> 
								<th class="head">HQDEPO</th> 
								<th class="head">Area</th> 
								<th class="head">PTR</th>
								<th class="head">PTS</th> 
								<th class="head">MRP</th> 
								<th class="head">BatchNo</th> 
								<th class="head">MfgDate</th> 
								<th class="head">ExpiryDate</th>
								<th class="head">FRC</th> 
								<th class="head">Category1</th> 
								<th class="head">OpeningRemark</th> 
								<th class="head">ClosingRemark</th>
								<th class="head">Remark</th>
								<th class="head">UserText1</th> 
								<th class="head">UserText2</th> 
							</tr>
						</thead>

						<tbody>';

						if(is_array($PURESUMMARY) && count($PURESUMMARY) > 0)
						{
							for ($i=0; $i <count($PURESUMMARY) ; $i++) { 
								
								$output.='<tr style="white-space: nowrap;">
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->DocumentType.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->InvoiceNo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->PostingDate.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Branch.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->DocumentName.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->OriginalInvoice.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->OriginalInvoiceDate.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->DocType.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->DEPORefNo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->CustomerCode.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->CustomerName.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->VendorCode.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->VendorName.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->LocationName.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->ItemCode.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->ItemDscription.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->TotalBeforeTax.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->TaxAmount.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->InvoiceTotal.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Quantity.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Price.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->PaymentTerm.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->TransactionType.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->InternalNo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->CustomerGroup.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->SalesEmployee.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->CustomerGSTIN.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->PlaceOfSupply.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->HSNSACCode.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->ProductGroup.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->TaxCode.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->BasicAmount.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->GrossAmountForeignCurrency.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->IGSTRate.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->IGSTAmount.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->CGSTRate.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->CGSTAmount.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->SGSTRate.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->SGSTAmount.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->UTGSTRate.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->TCSRate.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->UTGSTAmount.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->TCSAmount.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->ReverseCharges.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Discount.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Rounding.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->ROE.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->HSNCode.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Currency.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->ImportExport.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->LocationGSTIN.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->AcctCode.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->GLAccountName.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Division.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->SalesOrderNo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->ScheduledDeliveryDate.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->IRNNo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->AckNo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->AckDate.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->TCSApp.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->EWayBillNo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->EWayBillDt.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->StateTypeB.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->StateTypeS.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->PANNo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->City.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->State.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->OrderRefNo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->HQDEPO.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Area.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->PTR.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->PTS.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->MRP.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->BatchNo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->MfgDate.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->ExpiryDate.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->FRC.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Category1.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->OpeningRemark.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->ClosingRemark.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Remark.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->UserText1.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->UserText2.'</td>
								</tr>';
							}

						}else{
							$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
						}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

     public function dataExportMasterFunction($Final_url)
    {
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$Listing=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}
		.bg{background-color:#f8d483 !important;}
		</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>';
							// <!-- ---------- thead-> tr prepare Start here -------------------- -->                     
		                        $keys = array_keys($Listing);
		                        for($i = 0; $i < count($Listing); $i++) {

		                            foreach($Listing[$keys[$i]] as $key => $value) {
		                                $output.= ' <th class="head">'.$key.'</th>';
		                            }

		                            break;
		                        }
		                    // <!-- ---------- thead-> tr prepare end here -------------------- -->

							$output .= '</tr>
						</thead>

						<tbody>';

						if(is_array($Listing) && count($Listing) > 0)
						{
							for ($i=0; $i <count($Listing) ; $i++) { 
								
								$output.='<tr style="white-space: nowrap;">';

								   	foreach($Listing[$keys[$i]] as $key => $value) {
                                		$output.= '<td class="ItemTablePadding desabled">'.$Listing[$i]->$key.'</td>';
                            		}
								$output.='</tr>';
							}

						}else{
							$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
						}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

    public function getSUAGRE_ListExport($Final_url)
    {
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$Listing=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}
		.bg{background-color:#f8d483 !important;}
		</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">Vendor Code</th>
								<th class="head">Vendor Name</th>
								<th class="head">Branch</th>
								<th class="head">Series</th>
								<th class="head">Ref No</th>
								<th class="head">No</th>
								<th class="head">Payment Terms</th>
								<th class="head">Opening Remarks</th>
								<th class="head">Closing Remarks</th>
								<th class="head">Remark</th>
								<th class="head">Sales Employee</th>
								<th class="head">Posting Date</th>
								<th class="head">Due date</th>
								<th class="head">Document Type</th>
								<th class="head">Origional Amount</th>
								<th class="head">Balance Due Amount</th>
								<th class="head">Number Of Outstanding Days</th>
								<th class="head">0-30 Days</th>
								<th class="head">31-60 Days</th>
								<th class="head">61-90 Days</th>
								<th class="head">91-20 Days</th>
								<th class="head">120-150 Days</th>
								<th class="head">150-190 Days</th>
								<th class="head">181-210 Days</th>
								<th class="head">211>= Days</th>
							</tr>
						</thead>

						<tbody>';
					 	$keys = array_keys($Listing);
						if(is_array($Listing) && count($Listing) > 0)
						{
							for ($i=0; $i <count($Listing) ; $i++) { 
								
								$output.='<tr style="white-space: nowrap;">';

								   	foreach($Listing[$keys[$i]] as $key => $value) {
                                		$output.= '<td class="ItemTablePadding desabled">'.$Listing[$i]->$key.'</td>';
                            		}
								$output.='</tr>';
							}

						}else{
							$output.='<tr><td colspan="26" style="color:red;text-align:center">No record</td></tr>';
						}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

    public function getCUAGRE_ListExport($Final_url)
    {
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$Listing=json_decode($output);
		curl_close($ch);

		if(!empty($Listing)){
			$array_unique = array();
			for ($a=0; $a <count($Listing) ; $a++) { 
				$array_unique[]=$Listing[$a]->CardCode;
			}

			$unique_randum=array_unique($array_unique);
			$unique = array_values($unique_randum);
		}
		
		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}
		.footer{
			background-color: beige !important;
			font-weight: bold !important;
		}
		.GT{
			background-color: cyan !important;
			font-weight: bold !important;
		}
		
		.bg{background-color:#f8d483 !important;}
		</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">Customer Code</th>
								<th class="head">Customer Name</th>
								<th class="head">Branch</th>
								<th class="head">Series</th>
								<th class="head">Ref No</th>
								<th class="head">No</th>
								<th class="head">Payment Terms</th>
								<th class="head">Opening Remarks</th>
								<th class="head">Closing Remarks</th>
								<th class="head">Remark</th>
								<th class="head">Sales Employee</th>
								<th class="head">Posting Date</th>
								<th class="head">Due date</th>
								<th class="head">Document Type</th>
								<th class="head">Origional Amount</th>
								<th class="head">Balance Due Amount</th>
								<th class="head">Number Of Outstanding Days</th>
								<th class="head">0-30 Days</th>
								<th class="head">31-60 Days</th>
								<th class="head">61-90 Days</th>
								<th class="head">91-365 Days</th>
								<th class="head">Control Account</th>
								<th class="head">HQ</th>
								<th class="head">Division</th>
							</tr>
						</thead>

						<tbody>';
					 	$keys = array_keys($Listing);
						if(is_array($Listing) && count($Listing) > 0)
						{

							for ($j=0; $j <count($unique) ; $j++) { 
								$OriginalAmount=0;
								$BalanceDueAmount=0;
								$NumberOfOutstandingDays=0;
								$ZeroToThirtyDays=0;
								$ThityOneToSixty=0;
								$SixtyOneToNinety=0;
								$NinetyOneToThreeSixtyFive=0;

								for ($i=0; $i <count($Listing) ; $i++) { 
									
									if($unique[$j]==$Listing[$i]->CardCode){
										$output.='<tr style="white-space: nowrap;">';

									   	foreach($Listing[$keys[$i]] as $key => $value) {
	                                		$output.= '<td class="ItemTablePadding desabled">'.$Listing[$i]->$key.'</td>';
	                            		}

									
										$output.='</tr>';
										$OriginalAmount +=$Listing[$i]->OriginalAmount;
										$BalanceDueAmount +=$Listing[$i]->BalanceDueAmount;
										$NumberOfOutstandingDays +=$Listing[$i]->NumberOfOutstandingDays;
										$ZeroToThirtyDays +=$Listing[$i]->ZeroToThirtyDays;
										$ThityOneToSixty +=$Listing[$i]->ThityOneToSixty;
										$SixtyOneToNinety +=$Listing[$i]->SixtyOneToNinety;
										$NinetyOneToThreeSixtyFive +=$Listing[$i]->NinetyOneToThreeSixtyFive;
									}
								}
								
								// code...
								$output.='<tr  style="white-space: nowrap;">
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer">'.$OriginalAmount.'</td>
									<td class="footer">'.$BalanceDueAmount.'</td>
									<td class="footer">'.$NumberOfOutstandingDays.'</td>
									<td class="footer">'.$ZeroToThirtyDays.'</td>
									<td class="footer">'.$ThityOneToSixty.'</td>
									<td class="footer">'.$SixtyOneToNinety.'</td>
									<td class="footer">'.$NinetyOneToThreeSixtyFive.'</td>
									<td class="footer"></td>
									<td class="footer"></td>
									<td class="footer"></td>
								</tr>';
							}

						
						// ---------- final grand total Calculation start code here------------------------------
							$GT_OriginalAmount=0;
							$GT_BalanceDueAmount=0;
							$GT_NumberOfOutstandingDays=0;
							$GT_ZeroToThirtyDays=0;
							$GT_ThityOneToSixty=0;
							$GT_SixtyOneToNinety=0;
							$GT_NinetyOneToThreeSixtyFive=0;

							for ($gt=0; $gt <count($Listing) ; $gt++) { 

								$GT_OriginalAmount +=$Listing[$gt]->OriginalAmount;
								$GT_BalanceDueAmount +=$Listing[$gt]->BalanceDueAmount;
								$GT_NumberOfOutstandingDays +=$Listing[$gt]->NumberOfOutstandingDays;
								$GT_ZeroToThirtyDays +=$Listing[$gt]->ZeroToThirtyDays;
								$GT_ThityOneToSixty +=$Listing[$gt]->ThityOneToSixty;
								$GT_SixtyOneToNinety +=$Listing[$gt]->SixtyOneToNinety;
								$GT_NinetyOneToThreeSixtyFive +=$Listing[$gt]->NinetyOneToThreeSixtyFive;

							}
							$output.='<tr  style="white-space: nowrap;">
								<td class="GT" colspan="14">Grand Total</td>
								<td class="GT">'.$GT_OriginalAmount.'</td>
								<td class="GT">'.$GT_BalanceDueAmount.'</td>
								<td class="GT">'.$GT_NumberOfOutstandingDays.'</td>
								<td class="GT">'.$GT_ZeroToThirtyDays.'</td>
								<td class="GT">'.$GT_ThityOneToSixty.'</td>
								<td class="GT">'.$GT_SixtyOneToNinety.'</td>
								<td class="GT">'.$GT_NinetyOneToThreeSixtyFive.'</td>
								<td class="GT"></td>
								<td class="GT"></td>
								<td class="GT"></td>
							</tr>';
						// ---------- final grand total Calculation start code here------------------------------

						}else{
							$output.='<tr><td colspan="26" style="color:red;text-align:center">No record</td></tr>';
						}

	    	$output .='</tbody>
					</table>';
        return $output;
    }

//     public function getGSTR1_GSTR2_AllListExport_MasterFunction($API_Array)
//     {
// $apiArrayCount=(count($API_Array)-1);
// for ($A=0; $A <count($API_Array) ; $A++) { 
// 	// code...
// 	// echo '<pre>';
// 	// print_r($A);



// 		$ch = curl_init();  
// 		curl_setopt($ch,CURLOPT_URL,$API_Array[$A]);
// 		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

// 		$output=curl_exec($ch);
// 		$Listing=json_decode($output);
// 		curl_close($ch);

// 		$output ='<style>.text{
// 			mso-number-format:"\@";/*force text*/
// 		}
// 		.head{
// 			background-color: #b90006 !important;
// 			color: white !important;
// 		}
// 		.bg{background-color:#f8d483 !important;}
// 		</style>';

//         $output .= '<table class="table" border=1 id="tbl'.$A.'">
// 						<thead>
// 							<tr>';
// 							// <!-- ---------- thead-> tr prepare Start here -------------------- -->                     
// 		                        $keys = array_keys($Listing);
// 		                        for($i = 0; $i < count($Listing); $i++) {

// 		                            foreach($Listing[$keys[$i]] as $key => $value) {
// 		                                $output.= ' <th class="head">'.$key.'</th>';
// 		                            }

// 		                            break;
// 		                        }
// 		                    // <!-- ---------- thead-> tr prepare end here -------------------- -->

// 							$output .= '</tr>
// 						</thead>

// 						<tbody>';

// 						if(is_array($Listing) && count($Listing) > 0)
// 						{
// 							for ($i=0; $i <count($Listing) ; $i++) { 
								
// 								$output.='<tr style="white-space: nowrap;">';

// 								   	foreach($Listing[$keys[$i]] as $key => $value) {
//                                 		$output.= '<td class="ItemTablePadding desabled">'.$Listing[$i]->$key.'</td>';
//                             		}
// 								$output.='</tr>';
// 							}

// 						}else{
// 							$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
// 						}

// 	    	$output .='</tbody>
// 	        		</table>';
// if($apiArrayCount==$A){
// 		// return $Listing;
// 	// echo '<script src="exportToExcel.js"></script>'
// 	echo "<script type='text/javascript'>tablesToExcel(['tbl1','tbl2','tbl3','tbl4','tbl5','tbl6','tbl7','tbl8','tbl9','tbl10','tbl11'], ['Sheet1','Sheet2','Sheet3','Sheet4','Sheet5','Sheet6','Sheet7','Sheet8','Sheet9','Sheet10','Sheet11'], 'export.xls', 'Excel');</script>";
// //tablesToExcel(['tbl1','tbl2','tbl3','tbl4','tbl5','tbl6','tbl7','tbl8','tbl9','tbl10','tbl11'], ['Sheet1','Sheet2','Sheet3','Sheet4','Sheet5','Sheet6','Sheet7','Sheet8','Sheet9','Sheet10','Sheet11'], 'export.xls', 'Excel');
// // return $output;
// 		// echo 'last loop'.$A;
// 		// echo '<br>';
// }
			
// 		}
// // return $output;
       
//     }


    public function getGSTR1_GSTR2_ListExport_MasterFunction($Final_url)
    {
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$Listing=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}
		.bg{background-color:#f8d483 !important;}
		</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>';
							// <!-- ---------- thead-> tr prepare Start here -------------------- -->                     
		                        $keys = array_keys($Listing);
		                        for($i = 0; $i < count($Listing); $i++) {

		                            foreach($Listing[$keys[$i]] as $key => $value) {
		                                $output.= ' <th class="head">'.$key.'</th>';
		                            }

		                            break;
		                        }
		                    // <!-- ---------- thead-> tr prepare end here -------------------- -->

							$output .= '</tr>
						</thead>

						<tbody>';

						if(is_array($Listing) && count($Listing) > 0)
						{
							for ($i=0; $i <count($Listing) ; $i++) { 
								
								$output.='<tr style="white-space: nowrap;">';

								   	foreach($Listing[$keys[$i]] as $key => $value) {
                                		$output.= '<td class="ItemTablePadding desabled">'.$Listing[$i]->$key.'</td>';
                            		}
								$output.='</tr>';
							}

						}else{
							$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
						}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

    public function getSalesRegisterDetailedListExport($ARINVREGDETAILS_API,$tdata)
    {
		if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
		    $CurrentDate=strtotime(date("Y-m-d"));
		    $Date='&FromDate='.date("Ymd", strtotime("-1 month", $CurrentDate)).'&ToDate='.date("Ymd");
		}else{
		    $Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
		}

		$url=$ARINVREGDETAILS_API.'?BPLID='.$tdata['BPLID'].$Date; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$Listing=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}
		.bg{background-color:#f8d483 !important;}
		</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">InternalNo</th>
								<th class="head">InvoiceNo</th>
								<th class="head">DocType</th>
								<th class="head">DocumentType</th>
								<th class="head">DocumentName</th>
								<th class="head">BPRefNo</th>
								<th class="head">PlaceOfSupply</th>
								<th class="head">PostingDate</th>
								<th class="head">DeliveryDate</th>
								<th class="head">DocumentDate</th>
								<th class="head">Branch</th>
								<th class="head">OriginalInvoice</th>
								<th class="head">OriginalInvoiceDate</th>
								<th class="head">CustomerCode</th>
								<th class="head">CustomerName</th>
								<th class="head">BillToCode</th>
								<th class="head">ShipToCode</th>
								<th class="head">BillToAddress</th>
								<th class="head">ShipToAddress</th>
								<th class="head">Remarks1</th>
								<th class="head">Remarks2</th>
								<th class="head">Remarks3</th>
								<th class="head">Total</th>
								<th class="head">FinalTotal</th>
								<th class="head">TaxTotal</th>
								<th class="head">FreightTotal</th>
								<th class="head">LocationName</th>
								<th class="head">ItemCode</th>
								<th class="head">ItemDscription</th>
								<th class="head">TotalBeforeTax</th>
								<th class="head">TaxAmount</th>
								<th class="head">InvoiceTotal</th>
								<th class="head">Quantity</th>
								<th class="head">DiscRow</th>
								<th class="head">DiscValue</th>
								<th class="head">Price</th>
								<th class="head">PaymentTerm</th>
								<th class="head">TransactionType</th>
								<th class="head">CustomerGroup</th>
								<th class="head">SalesEmployee</th>
								<th class="head">CustomerGSTIN</th>
								<th class="head">HSNSACCode</th>
								<th class="head">ProductGroup</th>
								<th class="head">TaxCode</th>
								<th class="head">BasicAmount</th>
								<th class="head">GrossAmountForeignCurrency</th>
								<th class="head">IGSTRate</th>
								<th class="head">IGSTAmount</th>
								<th class="head">CGSTRate</th>
								<th class="head">CGSTAmount</th>
								<th class="head">SGSTRate</th>
								<th class="head">SGSTAmount</th>
								<th class="head">UTGSTRate</th>
								<th class="head">TCSRate</th>
								<th class="head">UTGSTAmount</th>
								<th class="head">TCSAmount</th>
								<th class="head">ReverseCharges</th>
								<th class="head">Discount</th>
								<th class="head">Rounding</th>
								<th class="head">ROE</th>
								<th class="head">HSNCode</th>
								<th class="head">Currency</th>
								<th class="head">ImportExport</th>
								<th class="head">LocationGSTIN</th>
								<th class="head">AcctCode</th>
								<th class="head">GLAccountName</th>
								<th class="head">Division</th>
								<th class="head">SalesOrderNo</th>
								<th class="head">ScheduledDeliveryDate</th>
								<th class="head">IRNNo</th>
								<th class="head">AckNo</th>
								<th class="head">AckDate</th>
								<th class="head">TCSApp</th>
								<th class="head">EWayBillNo</th>
								<th class="head">EWayBillDt</th>
								<th class="head">StateTypeB</th>
								<th class="head">StateTypeS</th>
								<th class="head">PANNo</th>
								<th class="head">City</th>
								<th class="head">State</th>
								<th class="head">OrderRefNo</th>
								<th class="head">HQDEPO</th>
								<th class="head">Area</th>
								<th class="head">PTR</th>
								<th class="head">PTS</th>
								<th class="head">MRP</th>
								<th class="head">BatchNo</th>
								<th class="head">MfgDate</th>
								<th class="head">ExpiryDate</th>
								<th class="head">FRC</th>
								<th class="head">Category1</th>
								<th class="head">OpeningRemark</th>
								<th class="head">ClosingRemark</th>
								<th class="head">Remark</th>
								<th class="head">UserText1</th>
								<th class="head">UserText2</th>
								<th class="head">HQ</th>
							</tr>
						</thead>

						<tbody>';

						if(is_array($Listing) && count($Listing) > 0)
						{
							for ($i=0; $i <count($Listing) ; $i++) { 
								
								$output.='<tr style="white-space: nowrap;">
									<td class="ItemTablePadding desabled">'.$Listing[$i]->InternalNo.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->InvoiceNo.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->DocType.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->DocumentType.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->DocumentName.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->BPRefNo.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->PlaceOfSupply.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->PostingDate.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->DeliveryDate.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->DocumentDate.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Branch.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->OriginalInvoice.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->OriginalInvoiceDate.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->CustomerCode.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->CustomerName.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->BillToCode.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->ShipToCode.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->BillToAddress.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->ShipToAddress.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Remarks1.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Remarks2.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Remarks3.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Total.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->FinalTotal.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->TaxTotal.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->FreightTotal.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->LocationName.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->ItemCode.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->ItemDscription.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->TotalBeforeTax.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->TaxAmount.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->InvoiceTotal.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Quantity.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->DiscRow.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->DiscValue.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Price.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->PaymentTerm.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->TransactionType.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->CustomerGroup.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->SalesEmployee.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->CustomerGSTIN.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->HSNSACCode.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->ProductGroup.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->TaxCode.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->BasicAmount.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->GrossAmountForeignCurrency.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->IGSTRate.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->IGSTAmount.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->CGSTRate.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->CGSTAmount.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->SGSTRate.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->SGSTAmount.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->UTGSTRate.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->TCSRate.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->UTGSTAmount.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->TCSAmount.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->ReverseCharges.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Discount.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Rounding.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->ROE.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->HSNCode.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Currency.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->ImportExport.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->LocationGSTIN.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->AcctCode.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->GLAccountName.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Division.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->SalesOrderNo.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->ScheduledDeliveryDate.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->IRNNo.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->AckNo.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->AckDate.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->TCSApp.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->EWayBillNo.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->EWayBillDt.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->StateTypeB.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->StateTypeS.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->PANNo.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->City.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->State.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->OrderRefNo.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->HQDEPO.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Area.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->PTR.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->PTS.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->MRP.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->BatchNo.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->MfgDate.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->ExpiryDate.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->FRC.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Category1.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->OpeningRemark.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->ClosingRemark.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->Remark.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->UserText1.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->UserText2.'</td>
									<td class="ItemTablePadding desabled">'.$Listing[$i]->HQ.'</td>
								</tr>';
							}

						}else{
							$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
						}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

    public function getSalesRegisterSummaryListExport($ARINVSUMMARY_API,$tdata)
    {
		if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
			$Date='';
		}else{
			$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
		}

		$url=$ARINVSUMMARY_API.'?BPLID='.$tdata['BPLID'].$Date; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);
// die();
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$Listing=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}
		.bg{background-color:#f8d483 !important;}
		</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">DocumentType</th>
								<th class="head">InvoiceNo</th>
								<th class="head">PostingDate</th>
								<th class="head">Branch</th>
								<th class="head">DocumentName</th>
								<th class="head">DocType</th>
								<th class="head">InternalNo</th>
								<th class="head">LocationGSTIN</th>
								<th class="head">LocationName</th>
								<th class="head">DEPORefNo</th>
								<th class="head">VendorBillDate</th>
								<th class="head">CustmerCode</th>
								<th class="head">CustomerName</th>
								<th class="head">SalesEmployee</th>
								<th class="head">ShipTo</th>
								<th class="head">BillTo</th>
								<th class="head">GSTIN</th>
								<th class="head">PlaceOfSupply</th>
								<th class="head">FreightAmt</th>
								<th class="head">FreightCGSTTaxAmt</th>
								<th class="head">FreightSGSTTaxAmt</th>
								<th class="head">FreightIGSTTaxAmt</th>
								<th class="head">TotalTaxableValue</th>
								<th class="head">TotalTaxAmt</th>
								<th class="head">IGSTAmount</th>
								<th class="head">CGSTAmount</th>
								<th class="head">SGSTAmount</th>
								<th class="head">UTGSTAmount</th>
								<th class="head">DiscSum</th>
								<th class="head">RoundDif</th>
								<th class="head">ROE</th>
								<th class="head">Currency</th>
								<th class="head">InvoiceTotal</th>
								<th class="head">InvoiceTotalFC</th>
								<th class="head">TDSTaxCode</th>
								<th class="head">TDSTaxName</th>
								<th class="head">TDSAmount</th>
								<th class="head">TDSPercentage</th>
								<th class="head">PAN</th>
								<th class="head">AssesseeType</th>
								<th class="head">GSTType</th>
								<th class="head">Group</th>
								<th class="head">CityPayTo</th>
								<th class="head">CityShipTo</th>
								<th class="head">Email</th>
								<th class="head">Remark</th>
							</tr>
						</thead>

						<tbody>';

						if(is_array($Listing) && count($Listing) > 0)
						{
							for ($i=0; $i <count($Listing) ; $i++) { 
								
								$output.='<tr style="white-space: nowrap;">
									<td class="ItemTablePadding desabled">'.$Listing[$i]->DocumentType.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->InvoiceNo.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->PostingDate.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->Branch.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->DocumentName.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->DocType.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->InternalNo.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->LocationGSTIN.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->LocationName.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->DEPORefNo.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->VendorBillDate.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->CustmerCode.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->CustomerName.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->SalesEmployee.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->ShipTo.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->BillTo.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->GSTIN.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->PlaceOfSupply.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->FreightAmt.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->FreightCGSTTaxAmt.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->FreightSGSTTaxAmt.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->FreightIGSTTaxAmt.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->TotalTaxableValue.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->TotalTaxAmt.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->IGSTAmount.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->CGSTAmount.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->SGSTAmount.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->UTGSTAmount.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->DiscSum.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->RoundDif.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->ROE.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->Currency.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->InvoiceTotal.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->InvoiceTotalFC.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->TDSTaxCode.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->TDSTaxName.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->TDSAmount.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->TDSPercentage.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->PAN.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->AssesseeType.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->GSTType.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->Group.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->CityPayTo.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->CityShipTo.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->Email.'</td>
	                                <td class="ItemTablePadding desabled">'.$Listing[$i]->Remark.'</td>
								</tr>';
							}

						}else{
							$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
						}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

    public function getPURESUMMARY_ListExport($PURESUMMARY_API,$tdata)
    {
		if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
			$Date='';
		}else{
			$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
		}

		$url=$PURESUMMARY_API.'?BPLID='.$tdata['BPLID'].$Date; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$PURESUMMARY=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}
		.bg{background-color:#f8d483 !important;}
		</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">DocumentType</th>  
								<th class="head">InvoiceNo</th>  
								<th class="head">PostingDate</th>  
								<th class="head">Branch</th>  
								<th class="head">DocumentName</th> 
								<th class="head">DocType</th> 
								<th class="head">InternalNo</th>  
								<th class="head">LocationGSTIN</th>  
								<th class="head">LocationName</th> 
								<th class="head">DEPORefNo</th>  
								<th class="head">VendorBillDate</th>  
								<th class="head">VendorCode</th>  
								<th class="head">VendorName</th>  
								<th class="head">SalesEmployee</th>  
								<th class="head">ShipTo</th>  
								<th class="head">BillTo</th>  
								<th class="head">GSTIN</th>  
								<th class="head">PlaceOfSupply</th>  
								<th class="head">FreightAmt</th>  
								<th class="head">FreightCGSTTaxAmt</th>  
								<th class="head">FreightSGSTTaxAmt</th>  
								<th class="head">FreightIGSTTaxAmt</th>  
								<th class="head">TotalTaxableValue</th>  
								<th class="head">TotalTaxAmt</th>  
								<th class="head">IGSTAmount</th>  
								<th class="head">CGSTAmount</th>  
								<th class="head">SGSTAmount</th>  
								<th class="head">UTGSTAmount</th>  
								<th class="head">DiscSum</th>  
								<th class="head">RoundDif</th>  
								<th class="head">ROE</th>  
								<th class="head">Currency</th>  
								<th class="head">InvoiceTotal</th>  
								<th class="head">InvoiceTotalFC</th>  
								<th class="head">TDSTaxCode</th>  
								<th class="head">TDSTaxName</th>  
								<th class="head">TDSAmount</th>  
								<th class="head">TDSPercentage</th>  
								<th class="head">PAN</th>  
								<th class="head">AssesseeType</th>  
								<th class="head">GSTType</th>  
								<th class="head">Group</th>  
								<th class="head">CityPayTo</th>  
								<th class="head">CityShipTo</th>  
								<th class="head">Email</th>  
								<th class="head">Remark</th> 
							</tr>
						</thead>

						<tbody>';

						if(is_array($PURESUMMARY) && count($PURESUMMARY) > 0)
						{
							for ($i=0; $i <count($PURESUMMARY) ; $i++) { 
								
								$output.='<tr style="white-space: nowrap;">
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->DocumentType.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->InvoiceNo.'</td>
									<td class="ItemTablePadding desabled">'.date("d-m-Y", strtotime(trim($PURESUMMARY[$i]->PostingDate))).'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Branch.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->DocumentName.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->DocType.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->InternalNo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->LocationGSTIN.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->LocationName.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->DEPORefNo.'</td>
									<td class="ItemTablePadding desabled">'.date("d-m-Y", strtotime(trim($PURESUMMARY[$i]->VendorBillDate))).'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->VendorCode.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->VendorName.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->SalesEmployee.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->ShipTo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->BillTo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->GSTIN.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->PlaceOfSupply.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->FreightAmt.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->FreightCGSTTaxAmt.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->FreightSGSTTaxAmt.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->FreightIGSTTaxAmt.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->TotalTaxableValue.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->TotalTaxAmt.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->IGSTAmount.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->CGSTAmount.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->SGSTAmount.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->UTGSTAmount.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->DiscSum.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->RoundDif.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->ROE.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Currency.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->InvoiceTotal.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->InvoiceTotalFC.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->TDSTaxCode.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->TDSTaxName.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->TDSAmount.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->TDSPercentage.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->PAN.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->AssesseeType.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->GSTType.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Group.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->CityPayTo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->CityShipTo.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Email.'</td>
									<td class="ItemTablePadding desabled">'.$PURESUMMARY[$i]->Remark.'</td>
								</tr>';
							}

						}else{
							$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
						}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

    public function getSalesDetailsList_ForExport($SalesDetail_API,$tdata)
    {
		if($tdata['FromDate']=='19700101' || $tdata['ToDate']=='19700101'){
    		$Date='FromDate=&ToDate=&BPLID='.$tdata['BPLID'];
    	}else{
    		$Date='FromDate='.$tdata['FromDate'].'&ToDate='.$tdata['ToDate'].'&BPLID='.$tdata['BPLID'];
    	}

    	if(!empty($tdata['HQ'])){
    		$HQ='&HQ='.$tdata['HQ'];
    	}

    	if(!empty($tdata['PartyName'])){
    		$PartyName='&PartyName='.$tdata['PartyName'];
    	}

    	if(!empty($tdata['BillNo'])){
    		$BillNo='&BillNo='.$tdata['BillNo'];
    	}

    	if(!empty($tdata['Division'])){
    		$Division='&Division='.$tdata['Division'];
    	}

    	$url=$SalesDetail_API.$Date.$HQ.$PartyName.$BillNo.$Division;

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);
// die();
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$St_Details=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}
		.footer{
			background-color: beige !important;
			font-weight: bold !important;
		}
		.bg{background-color:#f8d483 !important;}
		</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
	                            <th class="head">DIVISION</th>
								<th class="head">HQ</th>
								<th class="head">POSTING DATE</th>';

								if($tdata['BillNo']=='YES'){
								$output.= '<th class="head">BILL NO</th>';
								}
								$output.= '<th class="head">PARTY NAME</th>
								<th class="head">PRODUCT NAME</th>
								<th class="head">BATCH</th>
								<th class="head">PACK</th>
								<th class="head">MRP</th>
								<th class="head">PUR RATE</th>
								<th class="head">BILLING RATE</th>
								<th class="head">FSBD RATE</th>
								<th class="head">SALE QTY</th>
								<th class="head">FREE QTY</th>
								<th class="head">FREE VALUE</th>
								<th class="head">SALE VALUE</th>
								<th class="head">DISC</th>
								<th class="head">DISCOUNT IN QTY</th>
								<th class="head">DISC VALUE</th>
								<th class="head">BILL RATE SALE VALUE AFTER DISCOUNT</th>
								<th class="head">NET QTY AFTER DIS. IN QTY</th>
								<th class="head">NET SALE VALUE FSBD RATE AFTER DISC. VALUE</th>
								<th class="head">GOODS RETURN  QTY (AR CREDIT NOTE SUMMATION OF ALL RETURN QTY)</th>
								<th class="head">GOODS RETURN QTY AGAINST NON MOVING</th>
								<th class="head">GOODS RETURN QTY AGAINST EXPIRY</th>
								<th class="head">GOODS RETURN FREE QTY</th>
								<th class="head">FREE VALUE</th>
								<th class="head">NET SALES QTY</th>
								<th class="head">SALES BD VALUE</th>
								<th class="head">DISC. VALUE WITH FSBD RATE</th>
								<th class="head">NET SALES QTY VALUE WITH FSBD RATE</th>
								<th class="head">GOODS RETURN VALUE BILLING RATE</th>
								<th class="head">GOODS RETURN VALUE FSBD RATE</th>
								<th class="head">SALES V/S EXPIRY  %</th>
								<th class="head">TARGET QTY</th>
								<th class="head">ACHIVEMENT IN %</th>
							</tr>
						</thead>

						<tbody>';

						if(is_array($St_Details) && count($St_Details) > 0)
						{
							$PACK=0;
							$MRP=0;
							$PURRATE=0;
							$BILLINGRATE=0;
							$FSBDRATE=0;
							$SALEQTY=0;
							$FREEQTY=0;
							$SALEVALUE=0;
							$DISC=0;
							$DISCVALUE=0;
							$DiscValuewithFSBDRATE=0;
							$BILLRATESALEVALUEAFTERDISCOUNT=0;
							$DiscountInQty=0;
							$NETSALESQTYVALUEWITHFSBDRATE=0;
							$GOODSRETURNQTY=0;
							$GOODSRETURNFREEEQTY=0;
							$FreeValue=0;
							$GOODSRETURNVALUEBILL=0;
							$GOODSRETURNFSBD=0;
							$SALEVSEXPIRY=0;
							$NetSalesQty=0;
							$SalesBDValue=0;
							$TARGETQTY=0;
							$ACHIEVEMENTS=0;
							$NetQtyAfterDisInQty=0;
							$NetSaleValueFSBDRATEAfterDisc=0;
							$GoodsReturnQtyAgainstNonMoving=0;
							$GoodsReturnQtyAgainstExpiry=0;

							for ($i=0; $i <count($St_Details) ; $i++) { 
								$output.='<tr style="white-space: nowrap;">
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->DIVISION.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->HQ.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->DocDate.'</td>';
									if($tdata['BillNo']=='YES'){
									    $output.= '<td class="ItemTablePadding desabled">'.$St_Details[$i]->BILLNO.'</td>';
									}
									$output.= '<td class="ItemTablePadding desabled">'.$St_Details[$i]->CardName.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->PRODUCTNAME.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->Batch.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->PACK.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->MRP.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->PURRATE.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->BILLINGRATE.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->FSBDRATE.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->SALEQTY.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->FREEQTY.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->FREEVALUE.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->SALEVALUE.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->DISC.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->DiscountInQty.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->DISCVALUE.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->BILLRATESALEVALUEAFTERDISCOUNT.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->NetQtyAfterDisInQty.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->NetSaleValueFSBDRATEAfterDisc.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->GOODSRETURNQTY.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->GoodsReturnQtyAgainstNonMoving.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->GoodsReturnQtyAgainstExpiry.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->GOODSRETURNFREEEQTY.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->FreeValue.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->NetSalesQty.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->SalesBDValue.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->DiscValuewithFSBDRATE.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->NETSALESQTYVALUEWITHFSBDRATE.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->GOODSRETURNVALUEBILL.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->GOODSRETURNFSBD.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->SALEVSEXPIRY.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->TARGETQTY.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->ACHIEVEMENTS.'</td>
								</tr>';
								
								$PACK += $St_Details[$i]->PACK;
								$MRP += $St_Details[$i]->MRP;
								$PURRATE+= $St_Details[$i]->PURRATE;
								$BILLINGRATE+= $St_Details[$i]->BILLINGRATE;
								$FSBDRATE+= $St_Details[$i]->FSBDRATE;
								$SALEQTY += $St_Details[$i]->SALEQTY;
								$FREEQTY += $St_Details[$i]->FREEQTY;
								$SALEVALUE += $St_Details[$i]->SALEVALUE;
								$DISC += $St_Details[$i]->DISC;
								$DISCVALUE += $St_Details[$i]->DISCVALUE;
								$DiscValuewithFSBDRATE += $St_Details[$i]->DiscValuewithFSBDRATE;
								$BILLRATESALEVALUEAFTERDISCOUNT += $St_Details[$i]->BILLRATESALEVALUEAFTERDISCOUNT;
								$DiscountInQty += $St_Details[$i]->DiscountInQty;
								$NETSALESQTYVALUEWITHFSBDRATE += $St_Details[$i]->NETSALESQTYVALUEWITHFSBDRATE;
								$GOODSRETURNQTY += $St_Details[$i]->GOODSRETURNQTY;
								$GOODSRETURNFREEEQTY += $St_Details[$i]->GOODSRETURNFREEEQTY;
								$FreeValue += $St_Details[$i]->FreeValue;
								$GOODSRETURNVALUEBILL += $St_Details[$i]->GOODSRETURNVALUEBILL;
								$GOODSRETURNFSBD += $St_Details[$i]->GOODSRETURNFSBD;
								$SALEVSEXPIRY += $St_Details[$i]->SALEVSEXPIRY;
								$NetSalesQty += $St_Details[$i]->NetSalesQty;
								$SalesBDValue += $St_Details[$i]->SalesBDValue;
								$TARGETQTY += $St_Details[$i]->TARGETQTY;
								$ACHIEVEMENTS += $St_Details[$i]->ACHIEVEMENTS;
								$NetQtyAfterDisInQty += $St_Details[$i]->NetQtyAfterDisInQty;
								$NetSaleValueFSBDRATEAfterDisc += $St_Details[$i]->NetSaleValueFSBDRATEAfterDisc;
								$GoodsReturnQtyAgainstNonMoving += $St_Details[$i]->GoodsReturnQtyAgainstNonMoving;
								$GoodsReturnQtyAgainstExpiry += $St_Details[$i]->GoodsReturnQtyAgainstExpiry;
							}
						}else{
							$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
						}

	    	$output .='</tbody>';


// =======================================Footer start===========================================================
// if(!empty($tdata['HQ'])){
$output .='<tfoot>
			<tr>
				<td class="footer"></td>
				<td class="footer"></td>
				<td class="footer"></td>';
	if($tdata['BillNo']=='YES'){
	 $output.= '<td class="footer"></td>';
	}
	 $output.= '
				<td class="footer"></td>
				<td class="footer"></td>
				<td class="footer"></td>
				<td class="footer">'.$PACK.'</td>
				<td class="footer">'.$MRP.'</td>
				<td class="footer">'.$PURRATE.'</td>
				<td class="footer">'.$BILLINGRATE.'</td>
				<td class="footer">'.$FSBDRATE.'</td>
				<td class="footer">'.$SALEQTY.'</td>
				<td class="footer">'.$FREEQTY.'</td>
				<td class="footer"></td>
				<td class="footer">'.$SALEVALUE.'</td>
				<td class="footer">'.$DISC.'</td>
				<td class="footer">'.$DiscountInQty.'</td>
				<td class="footer">'.$DISCVALUE.'</td>
				<td class="footer">'.$BILLRATESALEVALUEAFTERDISCOUNT.'</td>
				<td class="footer">'.$NetQtyAfterDisInQty.'</td>
				<td class="footer">'.$NetSaleValueFSBDRATEAfterDisc.'</td>
				<td class="footer">'.$GOODSRETURNQTY.'</td>
				<td class="footer">'.$GoodsReturnQtyAgainstNonMoving.'</td>
				<td class="footer">'.$GoodsReturnQtyAgainstExpiry.'</td>
				<td class="footer">'.$GOODSRETURNFREEEQTY.'</td>
				<td class="footer">'.$FreeValue.'</td>
				<td class="footer">'.$NetSalesQty.'</td>
				<td class="footer">'.$SalesBDValue.'</td>
				<td class="footer">'.$DiscValuewithFSBDRATE.'</td>
				<td class="footer">'.$NETSALESQTYVALUEWITHFSBDRATE.'</td>
				<td class="footer">'.$GOODSRETURNVALUEBILL.'</td>
				<td class="footer">'.$GOODSRETURNFSBD.'</td>
				<td class="footer">'.$SALEVSEXPIRY.'</td>
				<td class="footer">'.$TARGETQTY.'</td>
				<td class="footer">'.$ACHIEVEMENTS.'</td>
			</tr>
		</tfoot>';
// }
						
// =======================================Footer End===========================================================



	        		$output .='</table>';
        return $output;
    }

    public function getSalesStockStatementList_ForExport($SalesStockStatement_API,$tdata)
    {
		if($tdata['FromDate']=='19700101' || $tdata['ToDate']=='19700101'){
    		$Date='FromDate=&ToDate=&BPLID='.$tdata['BPLID'];
    	}else{
    		$Date='FromDate='.$tdata['FromDate'].'&ToDate='.$tdata['ToDate'].'&BPLID='.$tdata['BPLID'];
    	}

		if(!empty($tdata['Division'])){
            $Division='&Division='.$tdata['Division'];
        }else{
            $Division='&Division=';
        }

        if(!empty($tdata['HQ'])){
            $HQ='&HQ='.$tdata['HQ'];
        }else{
            $HQ='&HQ=';
        }

    	$url=$SalesStockStatement_API.$Date.$Division.$HQ;

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$St_Details=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}
		.footer{
			background-color: beige !important;
			font-weight: bold !important;
		}
		.bg{background-color:#f8d483 !important;}
		</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">Division</th>
								<th class="head">Location</th>
								<th class="head">Product Name</th>
								<th class="head">Batch</th>
								<th class="head">Rate</th>
								<th class="head">Opening Stock</th>
								<th class="head">Opening Value</th>
								<th class="head">PurIn Final Stock</th>
								<th class="head">PurIn Final Value</th>
								<th class="head">Total Inward Qty</th>
								<th class="head">Total Inward Value</th>
								<th class="head">Total Outward Qty</th>
								<th class="head">Total Outward Value</th>
								<th class="head">Closing Stock Qty</th>
								<th class="head">Closing Stock Value</th>
								<th class="head">Closing Stock Value As Per BD-Rate</th>
							</tr>
						</thead>

						<tbody>';

						if(is_array($St_Details) && count($St_Details) > 0)
						{
							// $Rate=0;
		                    $Opening_Stock=0;
		                    $Opening_Value=0;
		                    $PurIn_Final_Stock=0;
		                    $PurIn_Final_Value=0;
		                    $Total_Inward_Qty=0;
		                    $Total_Inward_Value=0;
		                    $Total_Outward_Qty=0;
		                    $Total_Outward_Value=0;
		                    $Closing_Stock_Qty=0;
		                    $Closing_Stock_Value=0;
		                    $ClosingStockValueAsBDRate=0;
							for ($i=0; $i <count($St_Details) ; $i++) { 
								$output.='<tr style="white-space: nowrap;">
	                                <td class="ItemTablePadding desabled">'.$St_Details[$i]->DIVISION.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->Location.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->ProductName.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->Batch.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->Rate.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->OpeningStock.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->OpeningValue.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->PurInFinalStock.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->PurInFinalValue.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->TotalInwardQty.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->TotalInwardValue.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->TotalOutwardQty.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->TotalOutwardValue.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->ClosingStockQty.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->ClosingStockValue.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->ClosingStockValueAsBDRate.'</td>
								</tr>';
								// $Rate +=$St_Details[$i]->Rate;
								$Opening_Stock +=$St_Details[$i]->OpeningStock;
								$Opening_Value +=$St_Details[$i]->OpeningValue;
								$PurIn_Final_Stock +=$St_Details[$i]->PurInFinalStock;
								$PurIn_Final_Value +=$St_Details[$i]->PurInFinalValue;
								$Total_Inward_Qty +=$St_Details[$i]->TotalInwardQty;
								$Total_Inward_Value +=$St_Details[$i]->TotalInwardValue;
								$Total_Outward_Qty +=$St_Details[$i]->TotalOutwardQty;
								$Total_Outward_Value +=$St_Details[$i]->TotalOutwardValue;
								$Closing_Stock_Qty +=$St_Details[$i]->ClosingStockQty;
								$Closing_Stock_Value +=$St_Details[$i]->ClosingStockValue;
								$ClosingStockValueAsBDRate +=$St_Details[$i]->ClosingStockValueAsBDRate;
							}
						}else{
							$output.='<tr><td colspan="14" style="color:red;text-align:center">No record</td></tr>';
						}

	    	$output .='</tbody>';

			if(is_array($St_Details) && count($St_Details) > 0)
			{
                $output.=' <tfoot style="background-color: beige;font-weight: bold;">
                    <tr>
						<td class="footer"></td>
						<td class="footer"></td>
						<td class="footer"></td>
						<td class="footer"></td>
						<td class="footer"></td>
						<td class="footer">'.$Opening_Stock.'</td>
						<td class="footer">'.$Opening_Value.'</td>
						<td class="footer">'.$PurIn_Final_Stock.'</td>
						<td class="footer">'.$PurIn_Final_Value.'</td>
						<td class="footer">'.$Total_Inward_Qty.'</td>
						<td class="footer">'.$Total_Inward_Value.'</td>
						<td class="footer">'.$Total_Outward_Qty.'</td>
						<td class="footer">'.$Total_Outward_Value.'</td>
						<td class="footer">'.$Closing_Stock_Qty.'</td>
						<td class="footer">'.$Closing_Stock_Value.'</td>
						<td class="footer">'.$ClosingStockValueAsBDRate.'</td>
                    </tr>
                </tfoot>';
            }
	        		$output.=' </table>';
        return $output;
    }

    public function getSTDETWITHBTTRN_ForExport($BATCHREPORT_API,$tdata)
    {
		// if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
		// 	$Date='';
		// }else{
		// 	$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
		// }

		if($tdata['toDate']=='19700101'){
			$Date='';
		}else{
			$Date='&ToDate='.$tdata['toDate'];
		}

		if($tdata['BatchChk']=='Y'){
			$Flag='&Flag='.$tdata['BatchChk'];
		}else{
			$Flag='&Flag='.$tdata['BatchChk'];
		}

		$url=$BATCHREPORT_API.'?WhsCode='.$tdata['WhsCode'].$Flag.$Date; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);die();
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$St_Details=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}
		.bg{background-color:#f8d483 !important;}
		</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">Opening</th>
								<th class="head">BatchNo</th>
								<th class="head">ItemName</th>
								<th class="head">ItemCode</th>
								<th class="head">InStock</th>
								<th class="head">MRP</th>
								<th class="head">PTR</th>
								<th class="head">PTS</th>
								<th class="head">BDRate</th>
								<th class="head">MfgDate</th>
								<th class="head">ExpiryDate</th>
								<th class="head">WhsCode</th>
								<th class="head">ChapterID</th>
								<th class="head">Closing Stock Value As Per BD-Rate</th>
							</tr>
						</thead>

						<tbody>';

						if(is_array($St_Details) && count($St_Details) > 0)
						{
							for ($i=0; $i <count($St_Details) ; $i++) { 
								if($St_Details[$i]->InStock=='0'){
									$output.='<tr style="white-space: nowrap;" class="bg">
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->Opening.'</td>
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->BatchNo.'</td>
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->ItemName.'</td>
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->ItemCode.'</td>
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->InStock.'</td>
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->MRP.'</td>
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->PTR.'</td>
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->PTS.'</td>
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->BDRate.'</td>
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->MfgDate.'</td>
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->ExpiryDate.'</td>
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->WhsCode.'</td>
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->ChapterID.'</td>
										<td class="ItemTablePadding desabled bg">'.$St_Details[$i]->ClStock.'</td>
									</tr>';
								}else{
									$output.='<tr style="white-space: nowrap;">
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->Opening.'</td>
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->BatchNo.'</td>
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->ItemName.'</td>
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->ItemCode.'</td>
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->InStock.'</td>
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->MRP.'</td>
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->PTR.'</td>
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->PTS.'</td>
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->BDRate.'</td>
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->MfgDate.'</td>
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->ExpiryDate.'</td>
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->WhsCode.'</td>
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->ChapterID.'</td>
										<td class="ItemTablePadding desabled">'.$St_Details[$i]->ClStock.'</td>
									</tr>';
								}
							}

						}else{
							$output.='<tr><td colspan="14" style="color:red;text-align:center">No record</td></tr>';
						}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

    public function getPaymentReceiptDetailsExportXL($INCPAYHDDET_API,$OUTPAYHDDET_API,$tdata)
    {
    	if($tdata['fromDate']=='19700101' || $tdata['toDate']=='19700101'){
		    $Date='';
		}else{
		    $Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
		}

		if($_POST['Type']=='IP'){
		    $url=$INCPAYHDDET_API.$Date; // All Parameter Eneter Here
		}else{
		    $url=$OUTPAYHDDET_API.$Date; // All Parameter Eneter Here
		}

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$St_Details=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}
		.bg{background-color:#f8d483 !important;}
		</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">Branch Name</th> 
								<th class="head">BP Name</th>   
								<th class="head">BP Code</th>
								<th class="head">Voucher No</th> 
								<th class="head">Voucher Entry</th> 
								<th class="head">Voucher Date</th>  
								<th class="head">Due Date</th>  
								<th class="head">Payment Means</th>  
								<th class="head">On Account Amt</th> 
								<th class="head">Total Amt</th>  
								<th class="head">Narration</th> 
								<th class="head">Other Details</th> 
							</tr>
						</thead>

						<tbody>';

						if(is_array($St_Details) && count($St_Details) > 0)
						{
							for ($i=0; $i <count($St_Details) ; $i++) { 
								$output.='<tr style="white-space: nowrap;">
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->BranchName.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->BPName.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->BPCode.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->VoucherNo.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->VourhcerEntry.'</td>
									<td class="ItemTablePadding desabled">'.date("d-m-Y", strtotime(trim($St_Details[$i]->VoucherDate))).'</td>
									<td class="ItemTablePadding desabled">'.date("d-m-Y", strtotime(trim($St_Details[$i]->DueDate))).'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->PaymentMeans.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->OnAccountAmount.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->TotalAmount.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->Narration.'</td>
									<td class="ItemTablePadding desabled">'.$St_Details[$i]->OtherDetails.'</td>
								</tr>';
							}

						}else{
							$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
						}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

    public function getAR_CreditMemoDetailsListForExport($ARCREDITMEMODETAILS_API,$tdata)
    {

    	if($tdata['FromDate']=='19700101' && $tdata['ToDate']=='19700101'){
			$Date='&FromDate=&ToDate=';
		}else{
			$Date='&FromDate='.$tdata['FromDate'].'&ToDate='.$tdata['ToDate'];
		}

		$url=$ARCREDITMEMODETAILS_API.'?BPLID='.$tdata['BPLID'].$Date; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$AllAR_CreditMemoDetails=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">InternalNo</th>
								<th class="head">No</th>
								<th class="head">DocType</th>
								<th class="head">TransactionType</th>
								<th class="head">DocumentName</th>
								<th class="head">DocumentStatus</th>
								<th class="head">BPRefNo</th>
								<th class="head">PlaceOfSupply</th>
								<th class="head">PostingDate</th>
								<th class="head">DeliveryDate</th>
								<th class="head">DocumentDate</th>
								<th class="head">DEPOName</th>
								<th class="head">OriginalRefNo</th>
								<th class="head">OriginalRefDate</th>
								<th class="head">CustomerCode</th>
								<th class="head">CustomerName</th>
								<th class="head">BillToCode</th>
								<th class="head">ShipToCode</th>
								<th class="head">BillToAddress</th>
								<th class="head">ShipToAddress</th>
								<th class="head">Remarks1</th>
								<th class="head">Remarks2</th>
								<th class="head">Remarks3</th>
								<th class="head">Total</th>
								<th class="head">FinalTotal</th>
								<th class="head">TaxTotal</th>
								<th class="head">FreightTotal</th>
								<th class="head">LocationName</th>
								<th class="head">LocationGSTIN</th>
								<th class="head">BPGSTIN</th>
								<th class="head">ItemCode</th>
								<th class="head">ItemDscription</th>
								<th class="head">TotalBeforeTax</th>
								<th class="head">TaxAmount</th>
								<th class="head">InvoiceTotal</th>
								<th class="head">Quantity</th>
								<th class="head">Price</th>
								<th class="head">PaymentTerm</th>
								<th class="head">CustomerGroup</th>
								<th class="head">SalesEmployee</th>
								<th class="head">CustomerGSTIN</th>
								<th class="head">HSNSACCode</th>
								<th class="head">ProductGroup</th>
								<th class="head">TaxCode</th>
								<th class="head">BasicAmount</th>
								<th class="head">GrossAmountForeignCurrency</th>
								<th class="head">IGSTRate</th>
								<th class="head">IGSTAmount</th>
								<th class="head">CGSTRate</th>
								<th class="head">CGSTAmount</th>
								<th class="head">SGSTRate</th>
								<th class="head">SGSTAmount</th>
								<th class="head">UTGSTRate</th>
								<th class="head">TCSRate</th>
								<th class="head">UTGSTAmount</th>
								<th class="head">TCSAmount</th>
								<th class="head">ReverseCharges</th>
								<th class="head">Discount</th>
								<th class="head">Rounding</th>
								<th class="head">ROE</th>
								<th class="head">HSNCode</th>
								<th class="head">Currency</th>
								<th class="head">ImportExport</th>
								<th class="head">AcctCode</th>
								<th class="head">GLAccountName</th>
								<th class="head">Division</th>
								<th class="head">SalesOrderNo</th>
								<th class="head">TCSApp</th>
								<th class="head">StateTypeB</th>
								<th class="head">StateTypeS</th>
								<th class="head">PANNo</th>
								<th class="head">City</th>
								<th class="head">State</th>
								<th class="head">HQDEPO</th>
								<th class="head">Area</th>
								<th class="head">PTR</th>
								<th class="head">PTS</th>
								<th class="head">MRP</th>
								<th class="head">BatchNo</th>
								<th class="head">MfgDate</th>
								<th class="head">ExpiryDate</th>
								<th class="head">FRC</th>
								<th class="head">Category1</th>
								<th class="head">Remark</th>
								<th class="head">UserText1</th>
								<th class="head">UserText2</th>
							</tr>
						</thead>

						<tbody>';

                			if(is_array($AllAR_CreditMemoDetails) && count($AllAR_CreditMemoDetails) > 0)
			                {
								for ($i=0; $i <count($AllAR_CreditMemoDetails) ; $i++) { 
									
									$output.='<tr style="white-space: nowrap;">
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->InternalNo.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->No.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->DocType.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TransactionType.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->DocumentName.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->DocumentStatus.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->BPRefNo.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->PlaceOfSupply.'</td>

										<td class="ItemTablePadding desabled">'.date("d-m-Y", strtotime(trim($AllAR_CreditMemoDetails[$i]->PostingDate))).'</td>
										<td class="ItemTablePadding desabled">'.date("d-m-Y", strtotime(trim($AllAR_CreditMemoDetails[$i]->DeliveryDate))).'</td>
										<td class="ItemTablePadding desabled">'.date("d-m-Y", strtotime(trim($AllAR_CreditMemoDetails[$i]->DocumentDate))).'</td>

										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->DEPOName.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->OriginalRefNo.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->OriginalRefDate.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->CustomerCode.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->CustomerName.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->BillToCode.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->ShipToCode.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->BillToAddress.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->ShipToAddress.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Remarks1.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Remarks2.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Remarks3.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Total.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->FinalTotal.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TaxTotal.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->FreightTotal.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->LocationName.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->LocationGSTIN.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->BPGSTIN.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->ItemCode.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->ItemDscription.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TotalBeforeTax.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TaxAmount.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->InvoiceTotal.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Quantity.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Price.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->PaymentTerm.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->CustomerGroup.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->SalesEmployee.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->CustomerGSTIN.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->HSNSACCode.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->ProductGroup.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TaxCode.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->BasicAmount.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->GrossAmountForeignCurrency.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->IGSTRate.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->IGSTAmount.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->CGSTRate.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->CGSTAmount.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->SGSTRate.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->SGSTAmount.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->UTGSTRate.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TCSRate.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->UTGSTAmount.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TCSAmount.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->ReverseCharges.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Discount.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Rounding.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->ROE.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->HSNCode.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Currency.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->ImportExport.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->AcctCode.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->GLAccountName.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Division.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->SalesOrderNo.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TCSApp.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->StateTypeB.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->StateTypeS.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->PANNo.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->City.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->State.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->HQDEPO.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Area.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->PTR.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->PTS.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->MRP.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->BatchNo.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->MfgDate.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->ExpiryDate.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->FRC.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Category1.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Remark.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->UserText1.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->UserText2.'</td>
									</tr>';
								}

							}else{
								$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
							}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

    public function getAR_CreditMemoSummaryListForExport($ARCREDITMEMOSUMMARY_API,$tdata)
    {

    	if($tdata['FromDate']=='19700101' && $tdata['ToDate']=='19700101'){
			$Date='&FromDate=&ToDate=';
		}else{
			$Date='&FromDate='.$tdata['FromDate'].'&ToDate='.$tdata['ToDate'];
		}

		$url=$ARCREDITMEMOSUMMARY_API.'?BPLID='.$tdata['BPLID'].$Date; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$AllAR_CreditMemoDetails=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">DocumentType</th>
								<th class="head">InvoiceNo</th>
								<th class="head">PostingDate</th>
								<th class="head">Branch</th>
								<th class="head">DocumentName</th>
								<th class="head">DocType</th>
								<th class="head">InternalNo</th>
								<th class="head">LocationGSTIN</th>
								<th class="head">LocationName</th>
								<th class="head">DEPORefNo</th>
								<th class="head">BillDate</th>
								<th class="head">CustomerCode</th>
								<th class="head">CustomerName</th>
								<th class="head">SalesEmployee</th>
								<th class="head">ShipTo</th>
								<th class="head">BillTo</th>
								<th class="head">GSTIN</th>
								<th class="head">PlaceOfSupply</th>
								<th class="head">FreightAmt</th>
								<th class="head">FreightCGSTTaxAmt</th>
								<th class="head">FreightSGSTTaxAmt</th>
								<th class="head">FreightIGSTTaxAmt</th>
								<th class="head">TotalTaxableValue</th>
								<th class="head">TotalTaxAmt</th>
								<th class="head">IGSTAmount</th>
								<th class="head">CGSTAmount</th>
								<th class="head">SGSTAmount</th>
								<th class="head">UTGSTAmount</th>
								<th class="head">DiscSum</th>
								<th class="head">RoundDif</th>
								<th class="head">ROE</th>
								<th class="head">Currency</th>
								<th class="head">InvoiceTotal</th>
								<th class="head">InvoiceTotalFC</th>
								<th class="head">TDSTaxCode</th>
								<th class="head">TDSTaxName</th>
								<th class="head">TDSAmount</th>
								<th class="head">TDSPercentage</th>
								<th class="head">PAN</th>
								<th class="head">AssesseeType</th>
								<th class="head">GSTType</th>
								<th class="head">Group</th>
								<th class="head">CityPayTo</th>
								<th class="head">CityShipTo</th>
								<th class="head">Email</th>
								<th class="head">Remark</th>
							</tr>
						</thead>

						<tbody>';

                			if(is_array($AllAR_CreditMemoDetails) && count($AllAR_CreditMemoDetails) > 0)
			                {
								for ($i=0; $i <count($AllAR_CreditMemoDetails) ; $i++) { 
									// Date Condition start here----------------------------------------
										if(!empty($AllAR_CreditMemoDetails[$i]->PostingDate)){
											$PostingDate=date("d-m-Y", strtotime(trim($AllAR_CreditMemoDetails[$i]->PostingDate)));
										}else{
											$PostingDate='';
										}

										if(!empty($AllAR_CreditMemoDetails[$i]->BillDate)){
											$BillDate=date("d-m-Y", strtotime(trim($AllAR_CreditMemoDetails[$i]->BillDate)));
										}else{
											$BillDate='';
										}
									// Date Condition End here----------------------------------------
									$output.='<tr style="white-space: nowrap;">
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->DocumentType.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->InvoiceNo.'</td>
										<td class="ItemTablePadding desabled">'.$PostingDate.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Branch.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->DocumentName.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->DocType.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->InternalNo.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->LocationGSTIN.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->LocationName.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->DEPORefNo.'</td>
										<td class="ItemTablePadding desabled">'.$BillDate.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->CustomerCode.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->CustomerName.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->SalesEmployee.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->ShipTo.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->BillTo.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->GSTIN.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->PlaceOfSupply.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->FreightAmt.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->FreightCGSTTaxAmt.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->FreightSGSTTaxAmt.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->FreightIGSTTaxAmt.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TotalTaxableValue.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TotalTaxAmt.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->IGSTAmount.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->CGSTAmount.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->SGSTAmount.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->UTGSTAmount.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->DiscSum.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->RoundDif.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->ROE.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Currency.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->InvoiceTotal.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->InvoiceTotalFC.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TDSTaxCode.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TDSTaxName.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TDSAmount.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->TDSPercentage.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->PAN.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->AssesseeType.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->GSTType.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Group.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->CityPayTo.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->CityShipTo.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Email.'</td>
										<td class="ItemTablePadding desabled">'.$AllAR_CreditMemoDetails[$i]->Remark.'</td>
		                                
									</tr>';
								}

							}else{
								$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
							}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

    public function getAP_CreditMemoSummaryForExport($APCREDITMEMOSUMMARY_API,$tdata)
    {
    	if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
			$Date='&FromDate=&ToDate=';
		}else{
			$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
		}

		$url=$APCREDITMEMOSUMMARY_API.'BPLID='.$tdata['BPLID'].$Date.$Status; // All Parameter Eneter Here

		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$AllAP_CreditMemoDetails=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">Branch</th>
								<th class="head">Document Name</th>
								<th class="head">Doc Type</th>
								<th class="head">Document Type</th>
								<th class="head">Location GSTIN</th>
								<th class="head">Location</th>
								<th class="head">Internal No.</th>
								<th class="head">Invoice No</th>
								<th class="head">Invoice date</th>
								<th class="head">DEPO Ref No</th>
								<th class="head">Vendor Bill Date</th>
								<th class="head">Vendor Code</th>
								<th class="head">Vendor Name</th>
								<th class="head">Sales Employee</th>
								<th class="head">Ship To</th>
								<th class="head">Bill To</th>
								<th class="head">GSTIN</th>
								<th class="head">Place Of Supply</th>
								<th class="head">Freight Amt</th>
								<th class="head">Freight CGST Tax Amt</th>
								<th class="head">Freight SGST Tax Amt</th>
								<th class="head">Freight IGST Tax Amt</th>
								<th class="head">Total Taxable Value</th>
								<th class="head">Total Tax Amt</th>
								<th class="head">IGST Amount</th>
								<th class="head">CGST Amount</th>
								<th class="head">SGST Amount</th>
								<th class="head">UTGST Amount</th>
								<th class="head">DiscSum</th>
								<th class="head">RoundDif</th>
								<th class="head">ROE</th>
								<th class="head">Currency</th>
								<th class="head">Invoice Total</th>
								<th class="head">Invoice Total FC</th>
								<th class="head">TDS Tax Code</th>
								<th class="head">TDS Tax Name</th>
								<th class="head">TDS Amount</th>
								<th class="head">TDS %</th>
								<th class="head">PAN</th>
								<th class="head">Assessee Type</th>
								<th class="head">GST Type</th>
								<th class="head">Group</th>
								<th class="head">City Pay To</th>
								<th class="head">City Ship To</th>
								<th class="head">Email</th>
								<th class="head">Remark</th>
							</tr>
						</thead>

						<tbody>';

                			if(is_array($AllAP_CreditMemoDetails) && count($AllAP_CreditMemoDetails) > 0)
			                {
								for ($i=0; $i <count($AllAP_CreditMemoDetails) ; $i++) { 
									// Date Condition start here----------------------------------------
										if(!empty($AllAP_CreditMemoDetails[$i]->Invoicedate)){
											$Invoicedate=date("d-m-Y", strtotime(trim($AllAP_CreditMemoDetails[$i]->Invoicedate)));
										}else{
											$Invoicedate='';
										}

										if(!empty($AllAP_CreditMemoDetails[$i]->VendorBillDate)){
											$VendorBillDate=date("d-m-Y", strtotime(trim($AllAP_CreditMemoDetails[$i]->VendorBillDate)));
										}else{
											$VendorBillDate='';
										}
									// Date Condition End here----------------------------------------
									$output.='<tr style="white-space: nowrap;">
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->Branch.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->DocumentName.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->DocType.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->DocumentType.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->LocationGSTIN.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->LocationName.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->InternalNo.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->InvoiceNo.'</td>
		                                <td class="ItemTablePadding desabled">'.$Invoicedate.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->DEPORefNo.'</td>
		                                <td class="ItemTablePadding desabled">'.$VendorBillDate.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->VendorCode.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->VendorName.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->SalesEmployee.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->ShipTo.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->BillTo.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->GSTIN.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->PlaceOfSupply.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->FreightAmt.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->FreightCGSTTaxAmt.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->FreightSGSTTaxAmt.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->FreightIGSTTaxAmt.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->TotalTaxableValue.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->TotalTaxAmt.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->IGSTAmount.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->CGSTAmount.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->SGSTAmount.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->UTGSTAmount.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->DiscSum.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->RoundDif.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->ROE.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->Currency.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->InvoiceTotal.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->InvoiceTotalFC.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->TDSTaxCode.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->TDSTaxName.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->TDSAmount.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->TDSPercentage.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->PAN.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->AssesseeType.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->GSTType.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->Group.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->CityPayTo.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->CityShipTo.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->Email.'</td>
		                                <td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->Remark.'</td>
									</tr>';
								}

							}else{
								$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
							}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

	public function getAP_CreditMemoDetailsForExport($APCREDITMEMODETAILS_API,$tdata)
    {
    	if($tdata['fromDate']=='19700101' && $tdata['toDate']=='19700101'){
			$Date='&FromDate=&ToDate=';
		}else{
			$Date='&FromDate='.$tdata['fromDate'].'&ToDate='.$tdata['toDate'];
		}

		$url=$APCREDITMEMODETAILS_API.'BPLID='.$tdata['BPLID'].$Date.$Status; // All Parameter Eneter Here
// print_r($url);
// die();
		$stripped = rtrim($url, "&"); // URL last & symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20

		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$AllAP_CreditMemoDetails=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">ItemCode</th>
								<th class="head">OrderRefNo</th>
								<th class="head">HQ/DEPO</th>
								<th class="head">Area</th>
								<th class="head">PTR</th>
								<th class="head">PTS</th>
								<th class="head">MRP</th>
								<th class="head">BatchNo</th>
								<th class="head">MfgDate</th>
								<th class="head">ExpiryDate</th>
								<th class="head">FRC</th>
								<th class="head">Category1</th>
								<th class="head">OpeningRemark</th>
								<th class="head">ClosingRemark</th>
								<th class="head">Comments</th>
								<th class="head">UserText1</th>
								<th class="head">UserText2</th>
							</tr>
						</thead>

						<tbody>';

                			if(is_array($AllAP_CreditMemoDetails) && count($AllAP_CreditMemoDetails) > 0)
			                {
								for ($i=0; $i <count($AllAP_CreditMemoDetails) ; $i++) { 
									
									$output.='<tr style="white-space: nowrap;">

										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->ItemCode.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->OrderRefNo.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->HQDEPO.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->Area.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->PTR.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->PTS.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->MRP.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->BatchNo.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->MfgDate.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->ExpiryDate.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->FRC.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->Category1.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->OpeningRemark.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->ClosingRemark.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->Remark.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->UserText1.'</td>
										<td class="ItemTablePadding desabled">'.$AllAP_CreditMemoDetails[$i]->UserText2.'</td>
									</tr>';
								}

							}else{
								$output.='<tr><td style="color:red;text-align:center">No record</td></tr>';
							}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

    public function getAR_InvoiceListSummartByDocType($New_AR_InvoiceList_API,$DocType)
    {
    	if(!empty($DocType)){
			$DocType='?Type='.$DocType;
    	}else{
			$DocType='';
    	}

    	$url=$New_AR_InvoiceList_API.$DocType.'&BPLID='.$_SESSION['BPLID']; // All Parameter Eneter Here
// print_r($url);die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$AR_List=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">ARItemData</th>
								<th class="head">InternalNo</th>
								<th class="head">CustomerName</th>
								<th class="head">CustomerCode</th>
								<th class="head">HQ</th>
								<th class="head">BPRefNo</th>
								<th class="head">DraftKey</th>
								<th class="head">DocNum</th>
								<th class="head">Series</th>
								<th class="head">PostingDate</th>
								<th class="head">DueDate</th>
								<th class="head">DocDueDate</th>
								<th class="head">Division</th>
								<th class="head">Location</th>
								<th class="head">PlaceofSupply</th>
								<th class="head">PaymentTerms</th>
								<th class="head">Status</th>
								<th class="head">TaxAmt</th>
								<th class="head">Total</th>
								<th class="head">Type</th>
								<th class="head">PayToCode</th>
								<th class="head">ShipToCode</th>
								<th class="head">PayToAddress</th>
								<th class="head">ShipToAddress</th>
								<th class="head">TCSApplicable</th>
								<th class="head">BillToState</th>
								<th class="head">Remark1</th>
								<th class="head">Remark2</th>
								<th class="head">Remark3</th>
								<th class="head">TransporterNo</th>
								<th class="head">TransporterName</th>
								<th class="head">LR_No</th>
								<th class="head">NoOfCases</th>
								<th class="head">E_WayBillNo</th>
								<th class="head">PortNo</th>
								<th class="head">BillEntryNo</th>
								<th class="head">RoadPermitNo</th>
								<th class="head">DeliveryPerson</th>
								<th class="head">UnderExBond</th>
								<th class="head">Mode</th>
								<th class="head">ModeName</th>
								<th class="head">CourierNo</th>
								<th class="head">IRN_No</th>
								<th class="head">AckNo</th>
								<th class="head">ResQR</th>
								<th class="head">Rec_msg</th>
								<th class="head">json</th>
								<th class="head">LR_Date</th>
								<th class="head">E_WayBillDate</th>
								<th class="head">EwayExDate</th>
								<th class="head">BillEntryDate</th>
								<th class="head">VehicleNo</th>
								<th class="head">CourierDate</th>
								<th class="head">E_Invoice_cancelDate</th>
								<th class="head">AckDate</th>
							</tr>
						</thead>

						<tbody>';

                			if(is_array($AR_List) && count($AR_List) > 0)
			                {
								for ($e=0; $e <count($AR_List) ; $e++) { 
									$output.='<tr style="white-space: nowrap;">
										<td>'.$AR_List[$e]->ARItemData.'</td>
										<td>'.$AR_List[$e]->InternalNo.'</td>
										<td>'.$AR_List[$e]->CustomerName.'</td>
										<td>'.$AR_List[$e]->CustomerCode.'</td>
										<td>'.$AR_List[$e]->HQ.'</td>
										<td>'.$AR_List[$e]->BPRefNo.'</td>
										<td>'.$AR_List[$e]->DraftKey.'</td>
										<td>'.$AR_List[$e]->DocNum.'</td>
										<td>'.$AR_List[$e]->Series.'</td>
										<td>'.$AR_List[$e]->PostingDate.'</td>
										<td>'.$AR_List[$e]->DueDate.'</td>
										<td>'.$AR_List[$e]->DocDueDate.'</td>
										<td>'.$AR_List[$e]->Division.'</td>
										<td>'.$AR_List[$e]->Location.'</td>
										<td>'.$AR_List[$e]->PlaceofSupply.'</td>
										<td>'.$AR_List[$e]->PaymentTerms.'</td>
										<td>'.$AR_List[$e]->Status.'</td>
										<td>'.$AR_List[$e]->TaxAmt.'</td>
										<td>'.$AR_List[$e]->Total.'</td>
										<td>'.$AR_List[$e]->Type.'</td>
										<td>'.$AR_List[$e]->PayToCode.'</td>
										<td>'.$AR_List[$e]->ShipToCode.'</td>
										<td>'.$AR_List[$e]->PayToAddress.'</td>
										<td>'.$AR_List[$e]->ShipToAddress.'</td>
										<td>'.$AR_List[$e]->TCSApplicable.'</td>
										<td>'.$AR_List[$e]->BillToState.'</td>
										<td>'.$AR_List[$e]->Remark1.'</td>
										<td>'.$AR_List[$e]->Remark2.'</td>
										<td>'.$AR_List[$e]->Remark3.'</td>
										<td>'.$AR_List[$e]->TransporterNo.'</td>
										<td>'.$AR_List[$e]->TransporterName.'</td>
										<td>'.$AR_List[$e]->LR_No.'</td>
										<td>'.$AR_List[$e]->NoOfCases.'</td>
										<td>'.$AR_List[$e]->E_WayBillNo.'</td>
										<td>'.$AR_List[$e]->PortNo.'</td>
										<td>'.$AR_List[$e]->BillEntryNo.'</td>
										<td>'.$AR_List[$e]->RoadPermitNo.'</td>
										<td>'.$AR_List[$e]->DeliveryPerson.'</td>
										<td>'.$AR_List[$e]->UnderExBond.'</td>
										<td>'.$AR_List[$e]->Mode.'</td>
										<td>'.$AR_List[$e]->ModeName.'</td>
										<td>'.$AR_List[$e]->CourierNo.'</td>
										<td>'.$AR_List[$e]->IRN_No.'</td>
										<td>'.$AR_List[$e]->AckNo.'</td>
										<td>'.$AR_List[$e]->ResQR.'</td>
										<td>'.$AR_List[$e]->Rec_msg.'</td>
										<td>'.$AR_List[$e]->json.'</td>
										<td>'.$AR_List[$e]->LR_Date.'</td>
										<td>'.$AR_List[$e]->E_WayBillDate.'</td>
										<td>'.$AR_List[$e]->EwayExDate.'</td>
										<td>'.$AR_List[$e]->BillEntryDate.'</td>
										<td>'.$AR_List[$e]->VehicleNo.'</td>
										<td>'.$AR_List[$e]->CourierDate.'</td>
										<td>'.$valAR_Listue[$e]->E_Invoice_cancelDate.'</td>
										<td>'.$AR_List[$e]->AckDate.'</td>
									</tr>';
								}

							}else{
								$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
							}

	    	$output .='</tbody>
	        		</table>';
        return $output;
    }

    public function getAR_InvoiceListDetailsByDocType($API)
    {
    	// print_r($API);
    	// die();
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$AR_List=json_decode($output);
		curl_close($ch);

		$output ='<style>.text{
			mso-number-format:"\@";/*force text*/
		}
		.head{
			background-color: #b90006 !important;
			color: white !important;
		}</style>';

        $output .= '<table class="table" border=1>
						<thead>
							<tr>
								<th class="head">InvoiceNo</th>
								<th class="head">PostingDate</th>
								<th class="head">Branch</th>
								<th class="head">DocumentName</th>
								<th class="head">OriginalInvoice</th>
								<th class="head">OriginalInvoiceDate</th>
								<th class="head">DocType</th>
								<th class="head">DEPORefNo</th>
								<th class="head">CustomerCode</th>
								<th class="head">CustomerName</th>
								<th class="head">VendorCode</th>
								<th class="head">VendorName</th>
								<th class="head">LocationName</th>
								<th class="head">ItemCode</th>
								<th class="head">ItemDscription</th>
								<th class="head">TotalBeforeTax</th>
								<th class="head">TaxAmount</th>
								<th class="head">InvoiceTotal</th>							
								<th class="head">Quantity</th>
								<th class="head">Price</th>
								<th class="head">PaymentTerm</th>
								<th class="head">TransactionType</th>
								<th class="head">InternalNo</th>
								<th class="head">CustomerGroup</th>
								<th class="head">SalesEmployee</th>
								<th class="head">CustomerGSTIN</th>
								<th class="head">PlaceOfSupply</th>
								<th class="head">HSNSACCode</th>
								<th class="head">ProductGroup</th>
								<th class="head">TaxCode</th>
								<th class="head">BasicAmount</th>
								<th class="head">GrossAmountForeignCurrency</th>
								<th class="head">IGSTRate</th>
								<th class="head">IGSTAmount</th>
								<th class="head">CGSTRate</th>
								<th class="head">CGSTAmount</th>
								<th class="head">SGSTRate</th>
								<th class="head">SGSTAmount</th>
								<th class="head">UTGSTRate</th>
								<th class="head">TCSRate</th>
								<th class="head">UTGSTAmount</th>
								<th class="head">TCSAmount</th>
								<th class="head">ReverseCharges</th>
								<th class="head">Discount</th>
								<th class="head">Rounding</th>
								<th class="head">ROE</th>
								<th class="head">HSNCode</th>
								<th class="head">Currency</th>
								<th class="head">ImportExport</th>
								<th class="head">LocationGSTIN</th>
								<th class="head">AcctCode</th>
								<th class="head">GLAccountName</th>
								<th class="head">Division</th>
								<th class="head">SalesOrderNo</th>
								<th class="head">ScheduledDeliveryDate</th>
								<th class="head">IRNNo</th>
								<th class="head">AckNo</th>
								<th class="head">AckDate</th>
								<th class="head">TCSApp</th>
								<th class="head">EWayBillNo</th>
								<th class="head">EWayBillDt</th>
								<th class="head">StateTypeB</th>
								<th class="head">StateTypeS</th>
								<th class="head">PANNo</th>
								<th class="head">City</th>
								<th class="head">State</th>
								<th class="head">OrderRefNo</th>
								<th class="head">HQDEPO</th>
								<th class="head">Area</th>
								<th class="head">PTR</th>
								<th class="head">PTS</th>
								<th class="head">MRP</th>
								<th class="head">BatchNo</th>
								<th class="head">MfgDate</th>
								<th class="head">ExpiryDate</th>
								<th class="head">FRC</th>
								<th class="head">Category1</th>
								<th class="head">OpeningRemark</th>
								<th class="head">ClosingRemark</th>
								<th class="head">Remark</th>
								<th class="head">UserText1</th>
								<th class="head">UserText2</th>
							</tr>
						</thead>

						<tbody>';

            			if(is_array($AR_List) && count($AR_List) > 0)
		                {
							for ($e=0; $e <count($AR_List) ; $e++) { 
								$output.='<tr style="white-space: nowrap;">
									<td>'.$AR_List[$e]->InvoiceNo.'</td>
									<td>'.$AR_List[$e]->PostingDate.'</td>
									<td>'.$AR_List[$e]->Branch.'</td>
									<td>'.$AR_List[$e]->DocumentName.'</td>
									<td>'.$AR_List[$e]->OriginalInvoice.'</td>
									<td>'.$AR_List[$e]->OriginalInvoiceDate.'</td>
									<td>'.$AR_List[$e]->DocType.'</td>
									<td>'.$AR_List[$e]->DEPORefNo.'</td>
									<td>'.$AR_List[$e]->CustomerCode.'</td>
									<td>'.$AR_List[$e]->CustomerName.'</td>
									<td>'.$AR_List[$e]->VendorCode.'</td>
									<td>'.$AR_List[$e]->VendorName.'</td>
									<td>'.$AR_List[$e]->LocationName.'</td>
									<td>'.$AR_List[$e]->ItemCode.'</td>
									<td>'.$AR_List[$e]->ItemDscription.'</td>
									<td>'.$AR_List[$e]->TotalBeforeTax.'</td>
									<td>'.$AR_List[$e]->TaxAmount.'</td>
									<td>'.$AR_List[$e]->InvoiceTotal.'</td>
									<td>'.$AR_List[$e]->Quantity.'</td>
									<td>'.$AR_List[$e]->Price.'</td>
									<td>'.$AR_List[$e]->PaymentTerm.'</td>
									<td>'.$AR_List[$e]->TransactionType.'</td>
									<td>'.$AR_List[$e]->InternalNo.'</td>
									<td>'.$AR_List[$e]->CustomerGroup.'</td>
									<td>'.$AR_List[$e]->SalesEmployee.'</td>
									<td>'.$AR_List[$e]->CustomerGSTIN.'</td>
									<td>'.$AR_List[$e]->PlaceOfSupply.'</td>
									<td>'.$AR_List[$e]->HSNSACCode.'</td>
									<td>'.$AR_List[$e]->ProductGroup.'</td>
									<td>'.$AR_List[$e]->TaxCode.'</td>
									<td>'.$AR_List[$e]->BasicAmount.'</td>
									<td>'.$AR_List[$e]->GrossAmountForeignCurrency.'</td>
									<td>'.$AR_List[$e]->IGSTRate.'</td>
									<td>'.$AR_List[$e]->IGSTAmount.'</td>
									<td>'.$AR_List[$e]->CGSTRate.'</td>
									<td>'.$AR_List[$e]->CGSTAmount.'</td>
									<td>'.$AR_List[$e]->SGSTRate.'</td>
									<td>'.$AR_List[$e]->SGSTAmount.'</td>
									<td>'.$AR_List[$e]->UTGSTRate.'</td>
									<td>'.$AR_List[$e]->TCSRate.'</td>
									<td>'.$AR_List[$e]->UTGSTAmount.'</td>
									<td>'.$AR_List[$e]->TCSAmount.'</td>
									<td>'.$AR_List[$e]->ReverseCharges.'</td>
									<td>'.$AR_List[$e]->Discount.'</td>
									<td>'.$AR_List[$e]->Rounding.'</td>
									<td>'.$AR_List[$e]->ROE.'</td>
									<td>'.$AR_List[$e]->HSNCode.'</td>
									<td>'.$AR_List[$e]->Currency.'</td>
									<td>'.$AR_List[$e]->ImportExport.'</td>
									<td>'.$AR_List[$e]->LocationGSTIN.'</td>
									<td>'.$AR_List[$e]->AcctCode.'</td>
									<td>'.$AR_List[$e]->GLAccountName.'</td>
									<td>'.$AR_List[$e]->Division.'</td>
									<td>'.$AR_List[$e]->SalesOrderNo.'</td>
									<td>'.$AR_List[$e]->ScheduledDeliveryDate.'</td>
									<td>'.$AR_List[$e]->IRNNo.'</td>
									<td>'.$AR_List[$e]->AckNo.'</td>
									<td>'.$AR_List[$e]->AckDate.'</td>
									<td>'.$AR_List[$e]->TCSApp.'</td>
									<td>'.$AR_List[$e]->EWayBillNo.'</td>
									<td>'.$AR_List[$e]->EWayBillDt.'</td>
									<td>'.$AR_List[$e]->StateTypeB.'</td>
									<td>'.$AR_List[$e]->StateTypeS.'</td>
									<td>'.$AR_List[$e]->PANNo.'</td>
									<td>'.$AR_List[$e]->City.'</td>
									<td>'.$AR_List[$e]->State.'</td>
									<td>'.$AR_List[$e]->OrderRefNo.'</td>
									<td>'.$AR_List[$e]->HQDEPO.'</td>
									<td>'.$AR_List[$e]->Area.'</td>
									<td>'.$AR_List[$e]->PTR.'</td>
									<td>'.$AR_List[$e]->PTS.'</td>
									<td>'.$AR_List[$e]->MRP.'</td>
									<td>'.$AR_List[$e]->BatchNo.'</td>
									<td>'.$AR_List[$e]->MfgDate.'</td>
									<td>'.$AR_List[$e]->ExpiryDate.'</td>
									<td>'.$AR_List[$e]->FRC.'</td>
									<td>'.$AR_List[$e]->Category1.'</td>
									<td>'.$AR_List[$e]->OpeningRemark.'</td>
									<td>'.$AR_List[$e]->ClosingRemark.'</td>
									<td>'.$AR_List[$e]->Remark.'</td>
									<td>'.$AR_List[$e]->UserText1.'</td>
									<td>'.$AR_List[$e]->UserText2.'</td>
								</tr>';
							}

						}else{
							$output.='<tr><td colspan="13" style="color:red;text-align:center">No record</td></tr>';
						}
	$output .='</tbody>
    		</table>';
        return $output;
    }


    public function AR_Invoice_ItemListTable($API)
    {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $API);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80);

		$response = curl_exec($ch);

		if(curl_error($ch)){
			echo 'Request Error:' . curl_error($ch);
		}
		curl_close($ch);

		$response_json_decode1=json_decode($response);
		$response_json_decode=$response_json_decode1[0]->ARItemData;
		
		// =============================Item Data Table Prepare Start Here============================================
			$option ='';
			if(!empty($response_json_decode)){
				
				$option .= '<table class="table table-bordered" style="display: block;overflow-x: auto;white-space: nowrap;height: 400px;font-size:12px;">
                            <thead class="fixedHeader1">
                                <tr>
                                	<th>Batch No</th>
									<th>ItemCode</th>
									<th>ItemName</th>
									<th>PTR</th>
									<th>PTS</th>
									<th>MRP</th>
									<th>TaxCode</th>
									<th>WareHouse</th>
									<th>Division</th>
									<th>Location</th>
									<th>MfgDate</th>
									<th>ExpDate</th>
									<th>DisPrc</th>
									<th>TaxRate</th>
									<th>ChapterID</th>
									<th>LineTotal</th>
                                </tr>
                            </thead>
                            <tbody>';

        		for ($i=0; $i <count($response_json_decode) ; $i++) 
        		{ 

        			$option .= '<tr style="vertical-align: middle;">
        				<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->BatchNo.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ItemName.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PTR.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->PTS.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->MRP.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->TaxCode.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->WareHouse.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Division.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->Location.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->MfgDate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ExpDate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->DisPrc.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->TaxRate.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->ChapterID.'</td>
						<td class="ItemTablePadding desabled">'.$response_json_decode[$i]->LineTotal.'</td>
                    	</tr>';
                }

            	$option .= '</tbody> 
                	</table>';
			}else{

				$option .= '<span style="text-align: center;color:red;">Record Not Found</span>';
			}
		// =============================Item Data Table Prepare End Here============================================

		return $option;
    }

    public function CreateAP_InvoiceStand_SLSAP($CREATEAPINVOICESA_API,$mainArray)
    {
    	$postdata = json_encode($mainArray);

		$ch = curl_init($CREATEAPINVOICESA_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }

     public function Create_APCRMMST($CREATEAPCRSADRAFT_API,$mainArray)
    {
    	$postdata = json_encode($mainArray);

		$ch = curl_init($CREATEAPCRSADRAFT_API); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
    }

  //   public function Create_APCM_BasedOnARCM_Draft($API_URL,$mainArray)
  //   {
		// $postdata = json_encode($mainArray);

		// $sessionId =$_SESSION['SAP_SessionId'];
		// $routeId = ".node2";
		// $headers[] = "Cookie: B1SESSION=" . $sessionId . "; ROUTEID=" . $routeId . ";";

		// $curl = curl_init();
		// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		// curl_setopt($curl, CURLOPT_URL, $API_URL);
		// curl_setopt($ch, CURLOPT_POST, 1);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		// $response = curl_exec($curl);
    
		// return $response;
  //   }

}
?>