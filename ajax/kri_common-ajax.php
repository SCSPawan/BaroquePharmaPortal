<?php 
require_once '../classes/function.php';
require_once '../classes/kri_function.php';
$obj= new web();
$objKri=new webKri();

if(isset($_POST['action']) && $_POST['action'] =='qc_post_document_ajax'){
	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));

	// <!-- ------- Replace blank space to %20 start here -------- -->
		$API=$INWARDQCPOSTDOCUMENTDETAILS.'?DocEntry='.$DocEntry;
		// print_r($API);
		// die();
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	   $response=$objKri->get_QcPostDocument_SingleData($FinalAPI);

	// <!-- ------ Array declaration Start Here --------------------------------- -->
		$FinalResponce=array();
		$FinalResponce['SampleCollDetails']=$response;
	// <!-- ------ Array declaration End Here  --------------------------------- -->

		$general_data=(!empty($response[0]->QCPOSTDOCGENERALDATA))?$response[0]->QCPOSTDOCGENERALDATA:array(); 
		$qcStatus=(!empty($response[0]->QCPOSTDOCQCSTATUS))?$response[0]->QCPOSTDOCQCSTATUS:array(); // Etra issue response seperate here 
		$qcAttach=(!empty($response[0]->QCPOSTDOCATTACH)) ? $response[0]->QCPOSTDOCATTACH:array(); //External issue reponce seperate here

	// <!-- ----------- General Data Tab Start here --------------------------------- -->
		if(!empty($general_data)){
			for ($i=0; $i <count($general_data) ; $i++) { 
				$SrNo=$i;
				$index=$i+1;

				$FinalResponce['general_data'].='<tr>
					<td class="desabled">'.$index.'</td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="parameter_code'.$SrNo.'" name="parameter_code[]" value="'.$general_data[$i]->PCode.'" readonly></td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="PName'.$SrNo.'" name="PName[]" value="'.$general_data[$i]->PName.'" readonly></td>

					<td class="desabled" style="cursor: pointer;"><input  type="text" class="form-control textbox_bg" id="Standard'.$SrNo.'" name="Standard[]" value="'.$general_data[$i]->Standard.'" readonly class="form-control textbox_bg" style="border: 1px solid #efefef !important;width:400px;"></td>
                    
					<td><input type="text" id="ResultOut'.$SrNo.'" name="ResultOut[]" value="'.$general_data[$i]->GDRemarks.'" class="form-control" style="width:200px;"></td>';
					                     
				if($general_data[$i]->PDType=='Range'){
					$FinalResponce['general_data'].='<td>
						<input type="text" id="ComparisonResult'.$SrNo.'" name="ComparisonResult[]" value="'.$general_data[$i]->LowMin1.'" class="form-control" style="width:100px;" onfocusout="CalculateResultOut('.$SrNo.')">
					</td>';
				}else{
					$FinalResponce['general_data'].='<td class="desabled">
						<input type="text" id="ComparisonResult'.$SrNo.'" name="ComparisonResult[]" value="'.$general_data[$i]->LowMin1.'" class="form-control textbox_bg" style="width:100px;">
					</td>';
				}
                   
				
				$FinalResponce['general_data'].='
					<td id="ResultOutputByQCDeptTd'.$SrNo.'">
						<input type="hidden" id="ResultOutputByQCDept_Old'.$SrNo.'" name="ResultOutputByQCDept_Old[]" value="'.$general_data[$i]->ROutput.'">

						<select id="ResultOutputByQCDept'.$SrNo.'" name="ResultOutputByQCDept[]" class="form-select" style="border: 1px solid #ffffff !important;" onchange="OnChangeResultOutputByQCDept('.$SrNo.')"></select>
					</td>

					<td class="desabled">
						<input type="text" id="PDType'.$SrNo.'" name="PDType[]" value="'.$general_data[$i]->PDType.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="logical'.$SrNo.'" name="logical[]" value="'.$general_data[$i]->Logical.'" readonly></td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="LowMin'.$SrNo.'" name="LowMin[]" value="'.$general_data[$i]->LowMin.'" readonly></td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="UppMax'.$SrNo.'" name="UppMax[]" value="'.$general_data[$i]->UppMax.'" readonly></td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="Min'.$SrNo.'" name="Min[]" value="'.$general_data[$i]->Min.'" readonly></td>
                    
					<td id="QC_StatusByAnalystTd'.$SrNo.'">
						<input type="hidden" id="qC_status_by_analyst_Old'.$SrNo.'" name="qC_status_by_analyst_Old[]" value="'.$general_data[$i]->GDQCStatus.'">

						<select id="qC_status_by_analyst'.$SrNo.'" name="qC_status_by_analyst[]" class="form-select qc_statusbyab'.$SrNo.'" onchange="SelectedQCStatus('.$SrNo.')">
						</select>
					</td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="TMethod'.$SrNo.'" name="TMethod[]" value="'.$general_data[$i]->TMethod.'" readonly></td>
					
					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="MType'.$SrNo.'" name="MType[]" value="'.$general_data[$i]->MType.'" readonly></td>
                    <td class="desabled">
						<input type="text" id="PharmacopeiasStandard'.$i.'" name="PharmacopeiasStandard[]" value="'.$general_data[$i]->PharmacopeiasStandard.'"" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled"><input type="text" id="UOM'.$SrNo.'" name="UOM[]" class="form-control textbox_bg" value="'.$general_data[$i]->GDUOM.'" readonly></td>

					<td class="desabled"><input type="text" id="Retest'.$SrNo.'" name="Retest[]" class="form-control textbox_bg" value="'.$general_data[$i]->Retest.'" readonly></td>
                    
					<td class="desabled"><input type="text" id="ExSample'.$SrNo.'" name="ExSample[]" class="form-control textbox_bg" value="'.$general_data[$i]->ExSample.'" readonly></td>

					<td>
						<input type="hidden" id="AnalysisBy_Old'.$SrNo.'" name="AnalysisBy_Old[]" value="'.$general_data[$i]->AnyBy.'">

						<select id="AnalysisBy'.$SrNo.'" name="AnalysisBy[]" class="form-select" style="width: 140px;"></select>
					</td>

					<td><input  type="text" id="analyst_remark'.$SrNo.'" name="analyst_remark[]" class="form-control" value="'.$general_data[$i]->ARRemark.'"></td>
                   
					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="LowMax'.$SrNo.'" name="LowMax[]" value="'.$general_data[$i]->LowMax.'" readonly></td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="Release'.$SrNo.'" name="Release[]" value="'.$general_data[$i]->Release.'" readonly></td>
                    
					<td><input  type="text" class="form-control" id="descriptive_details'.$SrNo.'" name="descriptive_details[]" value="'.$general_data[$i]->DesDetils.'"></td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="UppMin'.$SrNo.'" name="UppMin[]" value="'.$general_data[$i]->UppMin.'" readonly></td>
                    
					<td><input  type="number" id="lower_min_result'.$SrNo.'" name="lower_min_result[]" class="form-control" value="'.$general_data[$i]->LowMax1.'"></td>
					
					<td><input  type="number" id="UppMinRes'.$SrNo.'" name="UppMinRes[]" class="form-control"></td>
                    
					<td><input  type="number" id="upper_max_result'.$SrNo.'" name="upper_max_result[]" class="form-control" value="'.$general_data[$i]->UppMax1.'"></td>

					<td>
						<input type="number" id="MeanRes'.$SrNo.'" name="MeanRes[]" class="form-control">
					</td>

					<td><input type="text" id="user_text1_'.$SrNo.'" name="user_text1_[]" class="form-control" value="'.$general_data[$i]->UText1.'"></td>

					<td><input type="text" id="user_text2_'.$SrNo.'" name="user_text2_[]" class="form-control" value="'.$general_data[$i]->UText2.'"></td>

					<td><input type="text" id="user_text3_'.$SrNo.'" name="user_text3_[]" class="form-control" value="'.$general_data[$i]->UText3.'"></td>

					<td><input type="text" id="user_text4_'.$SrNo.'" name="user_text4_[]" class="form-control" value="'.$general_data[$i]->UText4.'"></td>

					<td ><input type="text" id="user_text5_'.$SrNo.'" name="user_text5_[]" class="form-control" value="'.$general_data[$i]->UText5.'"></td>
                    
					<td class="desabled">
						<input type="text" id="QC_StatusResult'.$SrNo.'" name="QC_StatusResult[]" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled"><input type="text" id="GDStab'.$SrNo.'" name="GDStab[]" class="form-control textbox_bg" value="'.$general_data[$i]->GDStab.'" readonly></td>
                    
					<td class="desabled"><input type="text" id="Appassay'.$SrNo.'" name="Appassay[]" class="form-control textbox_bg" value="'.$general_data[$i]->Appassay.'" readonly></td>

					<td class="desabled"><input type="text" id="AppLOD'.$SrNo.'" name="AppLOD[]" class="form-control textbox_bg" value="'.$general_data[$i]->AppLOD.'" readonly></td>
                   
					<td><input type="text" id="InstrumentCode'.$SrNo.'" name="InstrumentCode[]" class="form-control" data-bs-toggle="modal" data-bs-target=".instrument_modal" value="'.$general_data[$i]->Inscode.'" onclick="OpenInstrmentModal('.$SrNo.')"></td>

					<td class="desabled"><input type="text" id="InstrumentName'.$SrNo.'" name="InstrumentName[]" class="form-control textbox_bg" value="'.$general_data[$i]->InsName.'" readonly style="border: 1px solid #efefef !important;"></td>

					<td><input  type="date" id="start_date'.$SrNo.'" name="start_date[]" class="form-control" value="'.(!empty($general_data[$i]->SDate)? date("Y-m-d", strtotime($general_data[$i]->SDate)) : '').'"></td>

					<td><input  type="time" id="start_time'.$SrNo.'" name="start_time[]" class="form-control" value="'.(!empty($general_data[$i]->STime)? date("H:i", strtotime($general_data[$i]->STime)) : '').'"></td>

					<td ><input type="date" id="end_date'.$SrNo.'" name="end_date[]" class="form-control" value="'.(!empty($general_data[$i]->EDate)? date("Y-m-d", strtotime($general_data[$i]->EDate)) : '').'"></td>


					<td ><input type="time" id="end_time'.$SrNo.'" name="end_time[]" class="form-control" value="'.(!empty($general_data[$i]->ETime)? date("H:i", strtotime($general_data[$i]->ETime)) : '').'"></td>
				</tr>';
			}
		}else{
			$FinalResponce['general_data'].='<tr><td colspan="7" style="color:red;text-align: center;">No Record Found</td></tr>';
		}

		$FinalResponce['count']=count($general_data);
	// <!-- ----------- General Data Tab End here --------------------------------- -->
	
	// <!-- ----------- External Issue Start Here ---------------------------- -->
		if(!empty($qcStatus)){
			for ($j=0; $j <count($qcStatus) ; $j++) { 
				$SrNo=$j+1;

				$FinalResponce['qcStatus'].='<tr id="add-more_'.$SrNo.'">';


					if(!empty($qcStatus[$j]->ItNo)){
						$FinalResponce['qcStatus'].='<td class="desabled">'.$SrNo.'</td>';
					}else{
						$FinalResponce['qcStatus'].='
							<td style="text-align: center;">
								<input type="radio" id="list'.$SrNo.'" name="listRado[]" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;">
							</td>';
					}
                $FinalResponce['qcStatus'].='

                    <td class="desabled">
	                    <input type="hidden" id="QCS_LineId'.$SrNo.'" name="QCS_LineId[]" value="'.$qcStatus[$j]->LineID.'">

	                    <input class="form-control border_hide desabled" type="text" id="qc_Status'.$SrNo.'" name="qc_Status[]" value="'.$qcStatus[$j]->QCStsStatus.'" readonly>
                    </td>

                    <td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsQty'.$SrNo.'" name="qCStsQty[]"  value="'.$qcStatus[$j]->QCStsQty.'" readonly></td>

					<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCReleaseDate_'.$SrNo.'" name="qCReleaseDate[]" value="'.((!empty($qcStatus[$j]->RelDate))? date("d-m-Y", strtotime($qcStatus[$j]->RelDate)):"").'" class="form-control" readonly></td>

					<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCReleaseTime_'.$SrNo.'" name="qCReleaseTime[]" value="'.((!empty($qcStatus[$j]->RelTime))? date("H:i", strtotime($qcStatus[$j]->RelTime)):"").'" class="form-control" readonly></td>

                    <td class="desabled"><input  type="text" class="form-control border_hide desabled" id="qCitNo'.$SrNo.'" name="qCitNo[]"  value="'.$qcStatus[$j]->ItNo.'" readonly></td>

                    <td class="desabled"><input class="form-control border_hide desabled" type="text" id="doneBy'.$SrNo.'" name="doneBy[]"  value="'.$qcStatus[$j]->DBy.'" readonly></td>

					<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCAttache1_'.$SrNo.'" name="qCAttache1[]" value="'.$qcStatus[$j]->QCStsAttach1.'" class="form-control"></td>

					<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCAttache2_'.$SrNo.'" name="qCAttache2[]" value="'.$qcStatus[$j]->QCStsAttach2.'" class="form-control"></td>

					<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCAttache3_'.$SrNo.'" name="qCAttache3[]" value="'.$qcStatus[$j]->QCStsAttach3.'" class="form-control"></td>

					<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCDeviationDate_'.$SrNo.'" name="qCDeviationDate[]" value="'.((!empty($qcStatus[$j]->DevDate))? date("d-m-Y", strtotime($qcStatus[$j]->DevDate)):"").'" class="form-control"></td>

					<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCDeviationNo_'.$SrNo.'" name="qCDeviationNo[]" value="'.$qcStatus[$j]->DevNo.'" class="form-control"></td>

					<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCDeviationResion_'.$SrNo.'" name="qCDeviationResion[]" value="'.$qcStatus[$j]->DevRsn.'" class="form-control"></td>

                    <td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsRemark1'.$SrNo.'" name="qCStsRemark1[]"  value="'.$qcStatus[$j]->QCStsRemark1.'" readonly></td>

				</tr>';
			}
		}else{
			// $FinalResponce['qcStatus'].='<tr><td colspan="12" style="color:red;text-align: center;">No Record Found</td></tr>';
			
		}

		$QCS_un_id=(count($qcStatus)+1);
		$FinalResponce['qcStatus'] .='<tr id="add-more_'.$QCS_un_id.'">
			<td>'.$QCS_un_id.'</td>
			<td><select id="qc_Status_'.$QCS_un_id.'" name="qc_Status[]" class="form-select qc_status_selecte1" onchange="SelectionOfQC_Status('.$QCS_un_id.')"></select></td>

			<td><input class="border_hide" type="text"  id="qCStsQty_'.$QCS_un_id.'" name="qCStsQty[]" class="form-control" value="" onfocusout="addMore('.$QCS_un_id.');"></td>


			<td><input class="border_hide" type="text"  id="qCReleaseDate_'.$QCS_un_id.'" name="qCReleaseDate[]" class="form-control" readonly></td>

			<td><input class="border_hide" type="text"  id="qCReleaseTime_'.$QCS_un_id.'" name="qCReleaseTime[]" class="form-control" readonly></td>

			<td><input class="border_hide" type="text"  id="qCitNo_'.$QCS_un_id.'" name="qCitNo[]" class="form-control" value=""></td>

			<td>
			<select id="doneBy_'.$QCS_un_id.'" name="doneBy[]" class="form-select done-by-mo1"></select>
			</td>

			<td><input class="border_hide" type="file"  id="qCAttache1_'.$QCS_un_id.'" name="qCAttache1[]" class="form-control"></td>


			<td><input class="border_hide" type="file"  id="qCAttache2_'.$QCS_un_id.'" name="qCAttache2[]" class="form-control"></td>

			<td><input class="border_hide" type="file"  id="qCAttache3_'.$QCS_un_id.'" name="qCAttache3[]" class="form-control"></td>

			<td><input class="border_hide" type="date"  id="qCDeviationDate_'.$QCS_un_id.'" name="qCDeviationDate[]" class="form-control"></td>

			<td><input class="border_hide" type="text"  id="qCDeviationNo_'.$QCS_un_id.'" name="qCDeviationNo[]" class="form-control"></td>

			<td><input class="border_hide" type="text"  id="qCDeviationResion_'.$QCS_un_id.'" name="qCDeviationResion[]" class="form-control"></td>

			<td><input class="border_hide" type="text"  id="qCStsRemark1_'.$QCS_un_id.'" name="qCStsRemark1[]" class="form-control"></td>
			
		</tr>';
			
		// $FinalResponce['qcStatus'] .='<tr">
		// 	<td>'.(count($qcStatus)+1).'</td>
		// 	<td><select id="qc_Status_1" name="qc_Status[]" class="form-select qc_status_selecte1"></select></td>
		// 	<td><input class="border_hide" type="text"  id="qCStsQty_1" name="qCStsQty[]" class="form-control" value=""></td>
		// 	<td><input class="border_hide" type="text"  id="qCitNo_1" name="qCitNo[]" class="form-control" value=""></td>
		// 	<td>
		// 	<select id="doneBy_1" name="doneBy[]" class="form-select done-by-mo1"></select>
		// 	</td>
		// 	<td><input class="border_hide" type="text"  id="qCStsRemark1_1" name="qCStsRemark1[]" class="form-control" value=""></td>
		// </tr>';


      
	   
		if(!empty($qcAttach)){
			for ($j=0; $j <count($qcAttach) ; $j++) { 
				$SrNo=$j+1;
				// <tr>
			$FinalResponce['qcAttach'].='<tr>
					<td class="desabled">'.$SrNo.'</td>
					<td class="desabled"><input class="border_hide desabled" type="text" id="targetPath'.$SrNo.'" name="targetPath[]" class="form-control" value="'.$qcAttach[$j]->TargetPath.'" readonly>
					</td>
					<td class="desabled"><input class="border_hide desabled" type="text" id="fileName'.$SrNo.'" name="fileName[]"  class="form-control" value="'.$qcAttach[$j]->FileName.'" readonly></td>
					<td class="desabled"><input class="border_hide desabled" type="text" id="attachDate'.$SrNo.'" name="attachDate[]"  class="form-control" value="'.$qcAttach[$j]->AttachDate.'" readonly></td>
					<td><input class="border_hide" type="text" id="freeText'.$SrNo.'" name="freeText[]"  class="form-control" value="'.$qcAttach[$j]->FreeText.'"></td>
				</tr>';
			}
		}
		else{
			$FinalResponce['qcAttach'].='<tr>
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
	// <!-- ----------- External Issue End Here   ---------------------------- -->
	echo json_encode($FinalResponce);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action']=='add_qc_status_input_more'){
    $index=$_POST['index'] + 1;

	$qcStatus ='<tr id="add-more_'.$index.'">
	    <td>'.$index.'</td>

		<td><select id="qc_Status_'.$index.'" name="qc_Status[]" class="form-select qc_status_selecte'.$index.'" onchange="SelectionOfQC_Status('.$index.')"></select></td>

		<td><input class="border_hide" type="text"  id="qCStsQty_'.$index.'" name="qCStsQty[]" class="form-control" onfocusout="addMore('.$index.');"></td>

		<td><input class="border_hide" type="text"  id="qCReleaseDate_'.$index.'" name="qCReleaseDate[]" class="form-control" readonly></td>

		<td><input class="border_hide" type="text"  id="qCReleaseTime_'.$index.'" name="qCReleaseTime[]" class="form-control" readonly></td>

		<td><input class="border_hide" type="text"  id="qCitNo_'.$index.'" name="qCitNo[]" class="form-control"></td>

		<td><select id="doneBy_'.$index.'" name="doneBy[]" class="form-select done-by-mo'.$index.'"></select></td>

		<td><input class="border_hide" type="file"  id="qCAttache1_'.$index.'" name="qCAttache1[]" class="form-control"></td>

		<td><input class="border_hide" type="file"  id="qCAttache2_'.$index.'" name="qCAttache2[]" class="form-control"></td>

		<td><input class="border_hide" type="file"  id="qCAttache3_'.$index.'" name="qCAttache3[]" class="form-control"></td>

		<td><input class="border_hide" type="date"  id="qCDeviationDate_'.$index.'" name="qCDeviationDate[]" class="form-control"></td>

		<td><input class="border_hide" type="text"  id="qCDeviationNo_'.$index.'" name="qCDeviationNo[]" class="form-control"></td>

		<td><input class="border_hide" type="text"  id="qCDeviationResion_'.$index.'" name="qCDeviationResion[]" class="form-control"></td>

		<td><input class="border_hide" type="text"  id="qCStsRemark1_'.$index.'" name="qCStsRemark1[]" class="form-control"></td>
	</tr>';

	echo $qcStatus;
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='qc_assay_Calculation_Based_On_ajax'){
	$getDropdown_assay=$objKri->get_assay_Calculation_Based_On_dropdown($assay_Calculation_Based_On);
	$html="";
	foreach($getDropdown_assay as $value){
		$html .='<option value="'.$value->FldValue.'">'.$value->FldValue.'</option>';
	}
	echo $html;
}

if(isset($_POST['action']) && $_POST['action'] =='qc_get_SAMINTTRBY_ajax'){
	$getDropdown_assay=$objKri->get_SAMINTTRBY($SAMINTTRBY_APIURL);
	echo json_encode($getDropdown_assay);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='GetRowLevelAnalysisByDropdown_Ajax'){
	$select_id=$_POST['value_id'];
	$Final_API=$QCPOSTQSDONEBYDROPDOWN_APi;
	$response=$objKri->GetRowLevelAnalysisByDropdown($Final_API);
	$option.='<option value="">Select</option>';
	foreach ($response as $key => $value) {
		$selected= ($select_id==$value->UserCode) ? 'selected':'';
		$option.='<option value="'.$value->UserCode.'" '.$selected.'>'.$value->UserName.'</option>';
	}
	echo json_encode($option);
	exit(0);
}

if(isset($_POST['action']) && $_POST['action'] =='GetRowLevelAnalysisByDropdownWithSelectedOption_Ajax'){
	$select_id=$_POST['value_id'];
	$Final_API=$QCPOSTQSDONEBYDROPDOWN_APi;
	$response=$objKri->GetRowLevelAnalysisByDropdown($Final_API);

	echo json_encode($response);
	exit(0);
}


if(isset($_POST['addQcPostDocumentBtn'])){
	$tdata=array(); // This array send to AP Standalone Invoice process 
 	
	// $tdata['U_BLine']=trim(addslashes(strip_tags($_POST['LineNum'])));
	// $tdata['U_BPLId']=trim(addslashes(strip_tags($_POST['U_BPLId'])));
	// $tdata['U_LocCode']=trim(addslashes(strip_tags($_POST['U_LocCode'])));

	// $tdata['U_GRPONo']=trim(addslashes(strip_tags($_POST['qcD_GRPONo'])));
	// $tdata['U_GRPODEnt']=trim(addslashes(strip_tags($_POST['U_GRPODEnt']))); //U_GRPODEnt

	// $tdata['U_SCode']=trim(addslashes(strip_tags($_POST['qcD_SupplierCode'])));
	// $tdata['U_SName']=trim(addslashes(strip_tags($_POST['qcD_SupplierName'])));
	// $tdata['U_ICode']=trim(addslashes(strip_tags($_POST['qcD_ItemCode'])));
	// $tdata['U_IName']=trim(addslashes(strip_tags($_POST['qcD_ItemName'])));
	// $tdata['U_GName']=trim(addslashes(strip_tags($_POST['qcD_GenericName'])));
	// $tdata['U_LClaim']=trim(addslashes(strip_tags($_POST['qcD_LabelClaim'])));
	// $tdata['U_LClmUom']=trim(addslashes(strip_tags($_POST['qcD_LabelClaimUOM'])));
	// $tdata['U_RQty']=trim(addslashes(strip_tags($_POST['qcD_RetainQty'])));
	// $tdata['U_MBy']=trim(addslashes(strip_tags($_POST['qcD_MfgBy'])));
	// $tdata['U_RBy']=trim(addslashes(strip_tags($_POST['qcD_RefNo'])));
	// $tdata['U_BNo']=trim(addslashes(strip_tags($_POST['qcD_BatchNo'])));
	// $tdata['U_BSize']=trim(addslashes(strip_tags($_POST['qcD_BatchQty'])));

	// $tdata['U_MfgDate']=(!empty($_POST['qcD_MfgDate']))? date("Y-m-d", strtotime($_POST['qcD_MfgDate'])) : null;
	// $tdata['U_ExpDate']=(!empty($_POST['qcD_ExpiryDate']))? date("Y-m-d", strtotime($_POST['qcD_ExpiryDate'])) : null;

	// $tdata['U_SIntNo']=trim(addslashes(strip_tags($_POST['qcD_SampleIntimationNo'])));
	// $tdata['U_SColNo']=trim(addslashes(strip_tags($_POST['qcD_SampleCollectionNo'])));
	// $tdata['U_SQty']=trim(addslashes(strip_tags($_POST['qcD_SampleQty'])));
	// $tdata['U_SamType']=trim(addslashes(strip_tags($_POST['qcD_SamType'])));
	// $tdata['U_MType']=trim(addslashes(strip_tags($_POST['qcD_MatType'])));
	// $tdata['U_PDate']=trim(addslashes(strip_tags($_POST['qcD_PostingDate'])));
	// $tdata['U_ADate']=trim(addslashes(strip_tags($_POST['qcD_ADate'])));
	// $tdata['U_NoCont']=trim(addslashes(strip_tags($_POST['qcD_NoCont'])));
	// $tdata['U_QCTType']=trim(addslashes(strip_tags($_POST['qcD_QCTType'])));
	// $tdata['U_Branch']=trim(addslashes(strip_tags($_POST['qcD_Branch'])));
	// $tdata['U_ValUp']=trim(addslashes(strip_tags($_POST['qcD_ValidUpto'])));
	// $tdata['U_ArNo']=trim(addslashes(strip_tags($_POST['qcD_ARNo'])));
	// $tdata['U_GENo']=trim(addslashes(strip_tags($_POST['qcD_GateENo'])));
	// $tdata['U_GDEntry']=trim(addslashes(strip_tags($_POST['U_GDEntry'])));
	// $tdata['U_SpcNo']=trim(addslashes(strip_tags($_POST['qcD_SpecfNo'])));
	// $tdata['U_GRQty']=trim(addslashes(strip_tags($_POST['U_GRQty'])));
	// $tdata['U_PckSize']=trim(addslashes(strip_tags($_POST['qcD_PckSize'])));
	// $tdata['U_RelDt']=trim(addslashes(strip_tags($_POST['U_RelDt'])));
	// $tdata['U_RetstDt']=trim(addslashes(strip_tags($_POST['U_RetstDt'])));
	// $tdata['U_Loc']=trim(addslashes(strip_tags($_POST['U_Loc'])));

	$tdata['U_RMQC']=trim(addslashes(strip_tags($_POST['RelMaterialWithoutQC'])));
	$tdata['U_APot']=trim(addslashes(strip_tags($_POST['AssayPotency_xyz'])));
	$tdata['U_LODWater']=trim(addslashes(strip_tags($_POST['LoD_Water_xyz'])));
	$tdata['U_AsyCal']=trim(addslashes(strip_tags($_POST['assay_append'])));
	$tdata['U_Potency']=trim(addslashes(strip_tags($_POST['potency_xyz'])));
	$tdata['U_Factor']=trim(addslashes(strip_tags($_POST['factor'])));
	$tdata['U_ChkBy']=trim(addslashes(strip_tags($_POST['checked_by'])));
	$tdata['U_NoCont1']=trim(addslashes(strip_tags($_POST['noOfCont1'])));
	$tdata['U_NoCont2']=trim(addslashes(strip_tags($_POST['noOfCont2'])));
	$tdata['U_CompBy']=trim(addslashes(strip_tags($_POST['ApprovedBy'])));
	$tdata['U_AnlBy']=trim(addslashes(strip_tags($_POST['analysis_by'])));
	$tdata['U_Remarks']=trim(addslashes(strip_tags($_POST['qc_remarks'])));

	$ganaralData=array();
	for ($i=0; $i <count($_POST['parameter_code']) ; $i++) {
		$ganaralData['U_PCode']=trim(addslashes(strip_tags($_POST['parameter_code'][$i])));
		$ganaralData['U_PName']=trim(addslashes(strip_tags($_POST['PName'][$i])));
		$ganaralData['U_Standard']=trim(addslashes(strip_tags($_POST['Standard'][$i])));
        $ganaralData['U_Remarks']=trim(addslashes(strip_tags($_POST['ResultOut'][$i])));
        $ganaralData['U_LowMin1']=trim(addslashes(strip_tags($_POST['ComparisonResult'][$i])));           
		$ganaralData['U_ROutput']=trim(addslashes(strip_tags($_POST['ResultOutputByQCDept'][$i])));
		$ganaralData['U_PDType']=trim(addslashes(strip_tags($_POST['PDType'][$i])));
        $ganaralData['U_Logical']=trim(addslashes(strip_tags($_POST['logical'][$i])));
		$ganaralData['U_LowMin']=trim(addslashes(strip_tags($_POST['LowMin'][$i])));
		$ganaralData['U_UppMax']=trim(addslashes(strip_tags($_POST['UppMax'][$i])));
		$ganaralData['U_Min1']=trim(addslashes(strip_tags($_POST['Min'][$i])));
		$ganaralData['U_QCStatus']=trim(addslashes(strip_tags($_POST['qC_status_by_analyst'][$i])));          
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
		$ganaralData['U_DDetail']=trim(addslashes(strip_tags($_POST['descriptive_details'][$i])));
        $ganaralData['U_UppMin']=trim(addslashes(strip_tags($_POST['UppMin'][$i])));
		$ganaralData['U_LowMax1']=trim(addslashes(strip_tags($_POST['lower_min_result'][$i])));
		$ganaralData['U_UppMin1']=trim(addslashes(strip_tags($_POST['UppMinRes'][$i])));
		$ganaralData['U_UppMax1']=trim(addslashes(strip_tags($_POST['upper_max_result'][$i])));
        $ganaralData['U_Min']=trim(addslashes(strip_tags($_POST['MeanRes'][$i])));
        $ganaralData['U_UText1']=trim(addslashes(strip_tags($_POST['user_text1_'][$i])));
		$ganaralData['U_UText2']=trim(addslashes(strip_tags($_POST['user_text2_'][$i])));
		$ganaralData['U_UText3']=trim(addslashes(strip_tags($_POST['user_text3_'][$i])));
		$ganaralData['U_UText4']=trim(addslashes(strip_tags($_POST['user_text4_'][$i])));
		$ganaralData['U_UText5']=trim(addslashes(strip_tags($_POST['user_text5_'][$i])));
		$ganaralData['U_QCRemark']=trim(addslashes(strip_tags($_POST['QC_StatusResult'][$i])));
		$ganaralData['U_Stab']=trim(addslashes(strip_tags($_POST['GDStab'][$i])));
		$ganaralData['U_AppAssay']=trim(addslashes(strip_tags($_POST['Appassay'][$i])));
		$ganaralData['U_AppLOD']=trim(addslashes(strip_tags($_POST['AppLOD'][$i])));
		$ganaralData['U_InsCode']=trim(addslashes(strip_tags($_POST['InstrumentCode'][$i])));
		$ganaralData['U_InsName']=trim(addslashes(strip_tags($_POST['InstrumentName'][$i])));
		$ganaralData['U_SDate']=trim(addslashes(strip_tags($_POST['start_date'][$i])));			
		$ganaralData['U_STime']=trim(addslashes(strip_tags($_POST['start_time'][$i])));
		$ganaralData['U_EDate']=trim(addslashes(strip_tags($_POST['end_date'][$i])));
		$ganaralData['U_ETime']=trim(addslashes(strip_tags($_POST['end_time'][$i])));

		$tdata['SCS_QCPD1Collection'][]=$ganaralData; // row data append on this array
	}

	$qcStatus=array();
	for ($j=0; $j <count($_POST['qc_Status']) ; $j++) {
		if(!empty($_POST['qc_Status'][$j])){
			$qcStatus['U_Status']=trim(addslashes(strip_tags($_POST['qc_Status'][$j])));
			$qcStatus['U_Quantity']=trim(addslashes(strip_tags($_POST['qCStsQty'][$j])));
			
			if(!empty($_POST['qCitNo'][$j])){
				$qcStatus['U_ITNo']=trim(addslashes(strip_tags($_POST['qCitNo'][$j])));
			}

			$qcStatus['U_DBy']=trim(addslashes(strip_tags($_POST['doneBy'][$j])));
			$qcStatus['U_Remarks1']=trim(addslashes(strip_tags($_POST['qCStsRemark1'][$j])));

			$qcStatus['U_RelDt']=(!empty($_POST['qCReleaseDate'][$j]))? date("Y-m-d",strtotime($_POST['qCReleaseDate'][$j])) : null;

			$qcStatus['U_RelTime']=(!empty($_POST['qCReleaseTime'][$j]))? date("Hi",strtotime($_POST['qCReleaseTime'][$j])) : null;

			$qcStatus['U_Attch1']=(!empty($_FILES['qCAttache1']['name'][$j]))? $_FILES['qCAttache1']['name'][$j]:$_POST['qCAttache1'][$j];

			$qcStatus['U_Attch2']=(!empty($_FILES['qCAttache2']['name'][$j]))? $_FILES['qCAttache2']['name'][$j]:$_POST['qCAttache2'][$j];

			$qcStatus['U_Attch3']=(!empty($_FILES['qCAttache3']['name'][$j]))? $_FILES['qCAttache3']['name'][$j]:$_POST['qCAttache3'][$j];

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

			$tdata['SCS_QCPD2Collection'][]=$qcStatus;// row data append on this array
		}
	}

	if(array_key_exists('targetPath',$_POST)){
		$qcAttech=array();

		for ($k=0; $k <count($_POST['targetPath']) ; $k++) {
			$qcAttech['U_TrgtPath']=trim(addslashes(strip_tags($_POST['targetPath'][$k])));
			$qcAttech['U_FileName']=trim(addslashes(strip_tags($_POST['fileName'][$k])));
			$qcAttech['U_AtchDate']=trim(addslashes(strip_tags($_POST['attachDate'][$k])));
			$qcAttech['U_FreeText']=trim(addslashes(strip_tags($_POST['freeText'][$k])));

			$tdata['SCS_QCPD3Collection'][]=$qcAttech;// row data append on this array
		}
	}

	$mainArray=$tdata; // all child array append in main array define here
	// echo '<pre>';
	// print_r($mainArray);
	// // print_r(json_encode($mainArray));
	// die();
	// service laye function and SAP loin & logout function define start here -------------------------------------
        $res=$obj->SAP_Login();

        if(!empty($res)){
			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$api_SCS_QCPD.'('.$_POST['U_DocEntry'].')';

			$responce_encode=$obj->PATCH_ServiceLayerMasterFunctionWithB1Replace($mainArray,$Final_API);
			// $responce_encode=$objKri->SampleIntimationUnderTestUpdateFromInventoryTransfer_kri($mainArray,$Final_API);
			$responce=json_decode($responce_encode);
			//  <!-- ------- service layer function responce manage Start Here ------------ -->
				if(array_key_exists('error', (array)$responce)){
					$data['status']='False';
					$data['DocEntry']='';
					$data['message']=$responce->error->message->value;
					echo json_encode($data);
				}else{
					$data['status']='True';
					$data['DocEntry']=$_POST['U_DocEntry'];
					$data['message']='QC Post Document Update Successfully';
					echo json_encode($data);
				}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}

		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
	// service laye function and SAP loin & logout function define end here -------------------------------------
}

if(isset($_POST['action']) && $_POST['action'] =='qc_api_OQCSTATUS_ajax')
{
	// <!-- =============== get supplier dropdown start here ========================================== -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){

			$responce_encode_BP=$obj->getFunctionServiceLayer($api_OQCSTATUS);
			$responce_BP=json_decode($responce_encode_BP);
	     
	     	$option .= '<option value="">-</option>';
			for ($i=0; $i <count($responce_BP->value) ; $i++) {
				
				$option .= '<option value="'.$responce_BP->value[$i]->Code.'">'.$responce_BP->value[$i]->Code.'</option>';
			}
		}
		
		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
	// <!-- =============== get supplier dropdown end here ============================================ -->
		echo $option;
	exit(0);
}

// if(isset($_POST['action']) && $_POST['action'] =='qc_attachment_browser_ajax')
// {
if(isset($_POST['qc_attachment_browser_ajax']))
{  
	// echo '<pre>';
	// print_r($_FILES);
	// die();
	$getFile=$_FILES['uploadFile']['name'];
	if($getFile!=""){
		$fileUrl='../include/uploads/'.$getFile;
		$tmp_name = $_FILES["uploadFile"]["tmp_name"];
		move_uploaded_file($tmp_name, $fileUrl);
	}

	$aRra=array(
		'fileName'=>$getFile,
		'targetPath'=>$fileUrl,
		'attatchment_date'=>date('Y-m-d')
	);

	echo json_encode($aRra);
	exit(0);
}





if(isset($_POST['action']) && $_POST['action'] =='QcForDocRetest_popup'){
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$API=$RETESTQCPOSTDOC.'&DocEntry='.$_POST['DocEntry'].'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&LineNum='.$_POST['LineNum'];

		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->

	$response=$objKri->get_QcRetest_SingleData($FinalAPI);

	echo json_encode($response);
	exit(0);
}



if(isset($_POST['action']) && $_POST['action'] =='qc_general_data_tab')
{
	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));

	// <!-- ------- Replace blank space to %20 start here -------- -->
		$API=$RETESTQCPOSTROWDETAILS.'?ItemCode='.$ItemCode;
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	   $response=$objKri->get_RetestGeneralData_SingleData($FinalAPI);


	  
	
	// <!-- ------ Array declaration Start Here --------------------------------- -->
		$FinalResponce=array();
		// $FinalResponce['SampleCollDetails']=$response;
	// <!-- ------ Array declaration End Here  --------------------------------- -->

		$general_data=$response; 

		// print_r($general_data);

		// die();
		// $qcStatus=$response[0]->QCPOSTDOCQCSTATUS; // Etra issue response seperate here 
		// $qcAttach=$response[0]->QCPOSTDOCATTACH; //External issue reponce seperate here

	// <!-- ----------- Extra Issue Start here --------------------------------- -->

		// if(!empty($general_data)){

		// 	for ($i=0; $i <count($general_data) ; $i++) { 
		// 		$SrNo=$i;
		// 		$index=$i+1;



		// 		$FinalResponce['general_data'].='<tr>
		// 			<td class="desabled">'.$index.'</td>

		// 			<td><input  type="text" class="form-control" id="parameter_code'.$SrNo.'" name="parameter_code[]" value="'.$general_data[$i]->PCode.'" readonly></td>

		// 			<td class="desabled"><input  type="text" class="form-control" id="PName'.$SrNo.'" name="PName[]" value="'.$general_data[$i]->PName.'" readonly></td>

		// 			<td class="desabled"><input  type="text" class="form-control" id="Standard'.$SrNo.'" name="Standard[]" value="'.$general_data[$i]->Standard.'" readonly></td>

		// 			<td class="desabled"><input  type="text" class="form-control" id="Release'.$SrNo.'" name="Release[]" value="'.$general_data[$i]->Release.'" readonly></td>

		// 			<td class="desabled"><input  type="text" class="form-control" id="PDType'.$SrNo.'" name="PDType[]" value="'.$general_data[$i]->PDType.'" readonly></td>

		// 			<td><input  type="text" class="form-control" id="descriptive_details'.$SrNo.'" name="descriptive_details[]" value="'.$general_data[$i]->DesDetils.'"></td>

		// 			<td><input  type="text" class="form-control" id="logical'.$SrNo.'" name="logical[]" value="'.$general_data[$i]->Logical.'"></td>

		// 			<td class="desabled"><input  type="text" class="form-control" id="LowMin'.$SrNo.'" name="LowMin[]" value="'.$general_data[$i]->LowMin.'" readonly></td>

		// 			<td class="desabled"><input  type="text" class="form-control" id="LowMax'.$SrNo.'" name="LowMax[]" value="'.$general_data[$i]->LowMax.'" readonly></td>

		// 			<td class="desabled"><input  type="text" class="form-control" id="UppMin'.$SrNo.'" name="UppMin[]" value="'.$general_data[$i]->UppMin.'" readonly></td>

		// 			<td class="desabled"><input  type="text" class="form-control" id="UppMax'.$SrNo.'" name="UppMax[]" value="'.$general_data[$i]->UppMax.'" readonly></td>

		// 			<td class="desabled"><input  type="text" class="form-control" id="Min'.$SrNo.'" name="Min[]" value="'.$general_data[$i]->Min.'" readonly></td>



		// 			<td><input  type="text" id="lower_min_result'.$SrNo.'" name="lower_min_result[]" onfocusout="CalculateResultOut('.$SrNo.')" class="form-control" value=""></td>

		// 			<td><input  type="text" id="lower_max_result'.$SrNo.'" name="lower_max_result[]" class="form-control" value=""></td>

		// 			<td><input type="text" id="upper_min_result'.$SrNo.'" name="upper_min_result[]" class="form-control" value=""></td>

		// 			<td><input  type="text" id="upper_max_result'.$SrNo.'" name="upper_max_result[]" class="form-control" value=""></td>

		// 			<td ><input type="text" id="mean'.$SrNo.'" name="mean[]" class="form-control" value=""></td>


		// 			<td id="ResultOutTd'.$SrNo.'">
		// 				<select id="result_output'.$SrNo.'" name="result_output[]" class="form-select dropdownResutl'.$SrNo.'" onchange="ManualSelectedTResultOut('.$SrNo.')"></select>
		// 			</td>

		// 			<td ><input type="text" id="remarks'.$SrNo.'" name="remarks[]" class="form-control" value="'.$general_data[$i]->Remarks.'"></td>

		// 			<td id="QC_StatusByAnalystTd'.$SrNo.'">
		// 				<select id="qC_status_by_analyst'.$SrNo.'" name="qC_status_by_analyst[]" class="form-select qc_statusbyab'.$SrNo.'" onchange="SelectedQCStatus('.$SrNo.')">
		// 				</select>
		// 			</td>

		// 			<td class="desabled"><input  type="text" class="form-control" id="TMethod'.$SrNo.'" name="TMethod[]" value="'.$general_data[$i]->TMethod.'" readonly></td>

		// 			<td class="desabled"><input  type="text" class="form-control" id="MType'.$SrNo.'" name="MType[]" value="'.$general_data[$i]->MType.'" readonly></td>




		// 			<td><input type="text" id="user_text1_'.$SrNo.'" name="user_text1_[]" class="form-control" value=""></td>

		// 			<td><input type="text" id="user_text2_'.$SrNo.'" name="user_text2_[]" class="form-control" value=""></td>

		// 			<td><input type="text" id="user_text3_'.$SrNo.'" name="user_text3_[]" class="form-control" value=""></td>

		// 			<td><input type="text" id="user_text4_'.$SrNo.'" name="user_text4_[]" class="form-control" value=""></td>

		// 			<td ><input type="text" id="user_text5_'.$SrNo.'" name="user_text5_[]" class="form-control" value=""></td>



		// 		<td class="desabled"><input type="text" id="GDQCStatus'.$SrNo.'" name="GDQCStatus[]" class="form-control" value="" readonly></td>

		// 			<td class="desabled"><input type="text" id="GDUOM'.$SrNo.'" name="GDUOM[]" class="form-control" value="'.$general_data[$i]->UOM.'" readonly></td>

		// 			<td class="desabled"><input type="text" id="Retest'.$SrNo.'" name="Retest[]" class="form-control" value="'.$general_data[$i]->Retest.'" readonly></td>

		// 			<td class="desabled"><input type="text" id="GDStab'.$SrNo.'" name="GDStab[]" class="form-control" value="" readonly></td>

		// 			<td class="desabled"><input type="text" id="ExSample'.$SrNo.'" name="ExSample[]" class="form-control" value="'.$general_data[$i]->ExSample.'" readonly></td>

		// 			<td class="desabled"><input type="text" id="Appassay'.$SrNo.'" name="Appassay[]" class="form-control" value="'.$general_data[$i]->Appassay.'" readonly></td>

		// 			<td class="desabled"><input type="text" id="AppLOD'.$SrNo.'" name="AppLOD[]" class="form-control" value="'.$general_data[$i]->AppLOD.'" readonly></td>

		// 			<td><input  type="text" id="qc_analysis_by'.$SrNo.'" name="qc_analysis_by[]" class="form-control" value=""></td>

		// 			<td><input  type="text" id="analyst_remark'.$SrNo.'" name="analyst_remark[]" class="form-control" value=""></td>

		// 			<td ><input type="text" id="instrument_code'.$SrNo.'" name="instrument_code[]" class="form-control" value=""></td>

		// 			<td class="desabled"><input type="text" id="InsName'.$SrNo.'" name="InsName[]" class="form-control" value="" readonly></td>

		// 			<td><input  type="text" id="star_date'.$SrNo.'" name="star_date[]" class="form-control" value=""></td>

		// 			<td><input  type="text" id="start_time'.$SrNo.'" name="start_time[]" class="form-control" value=""></td>

		// 			<td ><input type="text" id="end_date'.$SrNo.'" name="end_date[]" class="form-control" value=""></td>

		// 			<td ><input type="text" id="end_time'.$SrNo.'" name="end_time[]" class="form-control" value=""></td>

		// 		</tr>';
		// 	}
		// }else{
		// 	$FinalResponce['general_data'].='<tr><td colspan="7" style="color:red;text-align: center;">No Record Found</td></tr>';
		// }

		if(!empty($general_data)){
			// CalculateResultOut
			for ($i=0; $i <count($general_data) ; $i++) { 
				$FinalResponce['general_data'].='<tr>
					<td class="desabled">'.($i+1).'</td>

					<td>
						<input type="text" id="pCode'.$i.'" name="pCode[]" value="'.$general_data[$i]->PCode.'" class="form-control">
					</td>

					<td class="desabled">
					
						<input type="text" id="PName'.$i.'" name="PName[]" value="'.htmlspecialchars($general_data[$i]->PName, ENT_QUOTES, 'UTF-8').'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled" title="'.$general_data[$i]->Standard.'" style="cursor: pointer;">
						<input type="text" id="Standard'.$i.'" name="Standard[]" value="'.htmlspecialchars($general_data[$i]->Standard, ENT_QUOTES, 'UTF-8').'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;width:400px;">
					</td>

					<td>
						<input type="text" id="ResultOut'.$i.'" name="ResultOut[]" value="" class="form-control" style="width:200px;">
					</td>';

					// onfocusout="SetComparisonResultValTOResOutput('.$i.')"
					if($general_data[$i]->PDType=='Range'){
						$FinalResponce['general_data'].='<td>
							<input type="text" id="ComparisonResult'.$i.'" name="ComparisonResult[]" value="" class="form-control" style="width:100px;" onfocusout="CalculateResultOut('.$i.')">
						</td>';
					}else{
						$FinalResponce['general_data'].='<td class="desabled">
							<input type="text" id="ComparisonResult'.$i.'" name="ComparisonResult[]" value="" class="form-control textbox_bg" style="width:100px;">
						</td>';
					}
	

					$FinalResponce['general_data'].='<td id="ResultOutputByQCDeptTd'.$i.'">
						<select id="ResultOutputByQCDept'.$i.'" name="ResultOutputByQCDept[]" class="form-select" style="border: 1px solid #ffffff !important;" onchange="OnChangeResultOutputByQCDept('.$i.')"></select>
					</td>

					<td class="desabled">
						<input type="text" id="PDType'.$i.'" name="PDType[]" value="'.$general_data[$i]->PDType.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled">
						<input type="text" id="Logical'.$i.'" name="Logical[]" value="'.$general_data[$i]->Logical.'" class="form-control textbox_bg" style="width: 100px;">
					</td>

					<td class="desabled">
						<input type="text" id="LowMin'.$i.'" name="LowMin[]" value="'.$general_data[$i]->LowMin.'" class="form-control textbox_bg" style="width:100px;">
					</td>

					<td class="desabled">
						<input type="text" id="UppMax'.$i.'" name="UppMax[]" value="'.$general_data[$i]->UppMax.'" class="form-control textbox_bg" style="width:100px;">
					</td>

					<td class="desabled">
						<input type="text" id="Min'.$i.'" name="Min[]" value="'.$general_data[$i]->Min.'" class="form-control textbox_bg" style="width:100px;">
					</td>

					<td id="QC_StatusByAnalystTd'.$i.'">
						<select id="QC_StatusByAnalyst'.$i.'" name="QC_StatusByAnalyst[]" class="form-select" onchange="SelectedQCStatus('.$i.')">
						</select>
					</td>

					<td class="desabled">
						<input type="text" id="TMethod'.$i.'" name="TMethod[]" value="'.$general_data[$i]->TMethod.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled">
						<input type="text" id="MType'.$i.'" name="MType[]" value="'.$general_data[$i]->MType.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled">
						<input type="text" id="PharmacopeiasStandard'.$i.'" name="PharmacopeiasStandard[]" value="'.$general_data[$i]->PharmacopeiasStandard.'"" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled">
						<input type="text" id="UOM'.$i.'" name="UOM[]" value="'.$general_data[$i]->UOM.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled">
						<input type="text" id="Retest'.$i.'" name="Retest[]" value="'.$general_data[$i]->Retest.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled">
						<input type="text" id="ExSample'.$i.'" name="ExSample[]" value="'.$general_data[$i]->ExSample.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>


					<td>
						<select id="AnalysisBy'.$i.'" name="AnalysisBy[]" class="form-select" style="width: 140px;"></select>
					</td>

					<td>
						<input type="text" id="analyst_remark'.$i.'" name="analyst_remark[]" class="form-control">
					</td>

					<td class="desabled">
						<input type="text" id="LowMax'.$i.'" name="LowMax[]" value="'.$general_data[$i]->LowMax.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled">
						<input type="text" id="Release'.$i.'" name="Release[]" value="'.$general_data[$i]->Release.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td>
						<input type="text" id="DescriptiveDetails'.$i.'" name="DescriptiveDetails[]" class="form-control">
					</td>

					<td class="desabled">
						<input type="text" id="UppMin'.$i.'" name="UppMin[]" value="'.$general_data[$i]->UppMin.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
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
						<input type="text" id="Appassay'.$i.'" name="Appassay[]" value="'.$general_data[$i]->Appassay.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled">
						<input type="text" id="AppLOD'.$i.'" name="AppLOD[]" value="'.$general_data[$i]->AppLOD.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
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
			$FinalResponce['general_data']='<tr><td colspan="41" style="text-align: center;color:red;">Record Not Found</td></tr>';
		}

		$FinalResponce['count']=count($general_data);
		
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

		// $FinalResponce['qcStatus'] .='<tr id="add-more_1">
		// 	<td></td>
		// 	<td><select id="qc_Status_1" name="qc_Status[]" class="form-select qc_status_selecte1"  onfocusout="addMore(1);"></select></td>
		// 	<td><input class="border_hide" type="text"  id="qCStsQty_1" name="qCStsQty[]" class="form-control" onfocusout="addMore(1);"></td>
		// 	<td><input class="border_hide" type="text"  id="qCitNo_1" name="qCitNo[]" class="form-control"></td>
		// 	<td>
		// 	<select id="doneBy_1" name="doneBy[]" class="form-select done-by-mo1"></select>
		// 	</td>
		// 	<td><input class="border_hide" type="text"  id="qCStsRemark1_1" name="qCStsRemark1[]" class="form-control" value=""></td>
		// </tr>';



		$FinalResponce['qcStatus'] ='<tr id="add-more_1">
					<td>1</td>
					<td><select id="qc_Status_1" name="qc_Status[]" class="form-select qc_status_selecte1" onchange="SelectionOfQC_Status(1)"></select></td>

					<td><input class="border_hide" type="text"  id="qCStsQty_1" name="qCStsQty[]" class="form-control" onfocusout="addMore(1);"></td>

					<td><input class="border_hide" type="text"  id="qCReleaseDate_1" name="qCReleaseDate[]" class="form-control" readonly></td>

					<td><input class="border_hide" type="text"  id="qCReleaseTime_1" name="qCReleaseTime[]" class="form-control" readonly></td>

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




		// if(!empty($qcAttach)){
		// 	for ($j=0; $j <count($qcAttach) ; $j++) { 
		// 		$SrNo=$j+1;
				// <tr>
		$FinalResponce['qcAttach'].='<tr>
			<td class="desabled"></td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="targetPath" name="targetPath[]" class="form-control" value="" readonly>
			</td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="fileName" name="fileName[]"  class="form-control" value="" readonly></td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="attachDate" name="attachDate[]"  class="form-control" value="" readonly></td>
			<td><input class="border_hide" type="text" id="remark" name="remark[]"  class="form-control" value=""></td>
		</tr>';
		// 	}
		// }else{
		// 	$FinalResponce['qcAttach'].='<tr><td colspan="12" style="color:red;text-align: center;">No Record Found</td></tr>';
		// }
	// <!-- ----------- External Issue End Here   ---------------------------- -->
	echo json_encode($FinalResponce);
	exit(0);
}




if(isset($_POST['action']) && $_POST['action']=='add_qc_status_retest_input_more'){
    $index=$_POST['index'] + 1;

	 $qcStatus ='<tr id="add-more_'.$index.'">
	    <td></td>
        <td><select id="qc_Status_'.$index.'" name="qc_Status[]" class="form-select qc_status_selecte'.$index.'" onfocusout="addMore('.$index.');"></select></td>
        <td><input class="border_hide" type="text"  id="qCStsQty_'.$index.'" name="qCStsQty[]" class="form-control" onfocusout="addMore('.$index.');"></td>
        <td><input class="border_hide" type="text"  id="qCitNo_'.$index.'" name="qCitNo[]" class="form-control"></td>
        <td><select id="doneBy_'.$index.'" name="doneBy[]" class="form-select done-by-mo'.$index.'"></select></td>
        <td><input class="border_hide" type="text"  id="qCStsRemark1_'.$index.'" name="qCStsRemark1[]" class="form-control"></td>
	</tr>';

	echo $qcStatus;
	exit(0);
}






if (isset($_POST['addQcPostDocumentRetestBtn'])) {
	//<!-- ------ valdiation start --------------------------------- --> 
		// if($_POST['RelMaterialWithoutQC']=='No'){
		// 	if($_POST['Assaypotencyreq']=='Yes'){
		// 		// <!-- AssayPotency validation start --------------- -->
		// 			$AssayPotency =trim(addslashes(strip_tags($_POST['AssayPotency'])));

		// 			// Check if AssayPotency is empty
		// 			if ($AssayPotency === '' || $AssayPotency === null) {
		// 				$data['status']='False';
		// 				$data['DocEntry']='';
		// 				$data['message']=' Please Enter value in AssayPotency % is empty';
		// 				echo json_encode($data);
		// 				exit();
		// 			} else {
		// 				// Convert AssayPotency to a float
		// 				$AssayPotency = floatval($AssayPotency);
					
		// 				// Check if AssayPotency is equal to 0 or not less than 0 and not greater than 100
		// 					if ($AssayPotency > 100){
		// 						$data['status']='False';
		// 						$data['DocEntry']='';
		// 						$data['message']='AssayPotency %  not greater than 100';
		// 						echo json_encode($data);
		// 						exit();
		// 					}

		// 					if ($AssayPotency <= 0) {
		// 						$data['status']='False';
		// 						$data['DocEntry']='';
		// 						$data['message']='AssayPotency % is not equal to 0 or not less than 0';
		// 						echo json_encode($data);
		// 						exit();
		// 					}
		// 			}
		// 		// <!-- AssayPotency validation end ----------------- -->

		// 		// <!-- Factor validation start --------------------- -->
		// 			$Factor = trim(addslashes(strip_tags($_POST['factor'])));
		// 			if(empty($Factor)){
		// 				$data['status']='False';
		// 				$data['DocEntry']='';
		// 				$data['message']=' Please Enter value in Factor.';
		// 				echo json_encode($data);
		// 				exit();
		// 			}
		// 		// <!-- Factor validation end ----------------------- -->	
		// 	}
		// }
	//<!-- ------ valdiation end ----------------------------------- --> 
	
	$tdata = array(); // This array send to AP Standalone Invoice process 

	$tdata['Series'] = trim(addslashes(strip_tags($_POST['DocNo1'])));
	$tdata['U_PC_BLin'] = trim(addslashes(strip_tags($_POST['LineNum'])));
	$tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['U_PC_BPLId'])));
	$tdata['U_PC_LocCode'] = trim(addslashes(strip_tags($_POST['U_PC_LocCode'])));
	$tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['U_PC_Loc'])));
	$tdata['U_PC_GRNNo'] = trim(addslashes(strip_tags($_POST['GRPONo'])));
	$tdata['U_PC_GRNEnt'] = trim(addslashes(strip_tags($_POST['GRPODocEntry'])));
	$tdata['U_PC_SCode'] = trim(addslashes(strip_tags($_POST['SupplierCode'])));
	$tdata['U_PC_SName'] = trim(addslashes(strip_tags($_POST['SupplierName'])));
	$tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['ItemCode'])));
	$tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['ItemName'])));
	$tdata['U_PC_GName'] = trim(addslashes(strip_tags($_POST['GenericName'])));
	$tdata['U_PC_LClaim'] = trim(addslashes(strip_tags($_POST['LabelClaim'])));
	$tdata['U_PC_LClmUom'] = trim(addslashes(strip_tags($_POST['LabelClaimUOM'])));
	$tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['RQty'])));
	$tdata['U_PC_MfgBy'] = trim(addslashes(strip_tags($_POST['MfgBy'])));
	$tdata['U_PC_RfBy'] = trim(addslashes(strip_tags($_POST['BpRefNo'])));
	$tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['BatchNo'])));
	$tdata['U_PC_BSize'] = trim(addslashes(strip_tags($_POST['BatchQty'])));
	$tdata['U_PC_SIntNo'] = trim(addslashes(strip_tags($_POST['SampleIntimationNo'])));
	$tdata['U_PC_SColNo'] = trim(addslashes(strip_tags($_POST['SampleCollectionNo'])));
	$tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['SampleQty'])));
	$tdata['U_PC_PckSize'] = trim(addslashes(strip_tags($_POST['PackSize'])));
	$tdata['U_PC_SType'] = trim(addslashes(strip_tags($_POST['SampleType'])));
	$tdata['U_PC_MType'] = trim(addslashes(strip_tags($_POST['MaterialType'])));
	$tdata['U_PC_NoCont'] = trim(addslashes(strip_tags($_POST['Container'])));
	$tdata['U_PC_QCTType'] = trim(addslashes(strip_tags($_POST['QCTestType'])));
	$tdata['U_PC_Stage'] = trim(addslashes(strip_tags($_POST['Stage'])));
	$tdata['U_PC_Remarks'] = trim(addslashes(strip_tags($_POST['qc_remarks'])));
	$tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['BranchName'])));
	$tdata['U_PC_ValUp'] = trim(addslashes(strip_tags($_POST['ValidUpTo'])));
	$tdata['U_PC_ArNo'] = trim(addslashes(strip_tags($_POST['ARNo'])));
	$tdata['U_PC_GENo'] = trim(addslashes(strip_tags($_POST['GateENo'])));
	$tdata['U_PC_GDEntry'] = trim(addslashes(strip_tags($_POST['U_PC_GDEntry'])));
	$tdata['U_PC_APot'] = trim(addslashes(strip_tags($_POST['AssayPotency'])));
	$tdata['U_PC_LODWater'] = trim(addslashes(strip_tags($_POST['LoD_Water'])));
	$tdata['U_PC_Potency'] = trim(addslashes(strip_tags($_POST['potency'])));
	$tdata['U_PC_CompBy'] = trim(addslashes(strip_tags($_POST['qc_post_compiled_by'])));
	$tdata['U_PC_NoCont1'] = trim(addslashes(strip_tags($_POST['noOfCont1'])));
	$tdata['U_PC_NoCont2'] = trim(addslashes(strip_tags($_POST['noOfCont2'])));
	$tdata['U_PC_ChkBy'] = trim(addslashes(strip_tags($_POST['checked_by'])));
	$tdata['U_PC_AnlBy'] = trim(addslashes(strip_tags($_POST['analysis_by'])));
	$tdata['U_PC_AsyCal'] = trim(addslashes(strip_tags($_POST['assay_append'])));
	$tdata['U_PC_Factor'] = trim(addslashes(strip_tags($_POST['factor'])));
	$tdata['U_PC_SpcNo'] = trim(addslashes(strip_tags($_POST['SpecfNo'])));
	$tdata['U_PC_GRQty'] = trim(addslashes(strip_tags($_POST['U_PC_GRQty'])));
	$tdata['U_PC_RecQty'] = trim(addslashes(strip_tags($_POST['RQty'])));
	$tdata['U_PC_SType'] = trim(addslashes(strip_tags($_POST['SampleType'])));
	$tdata['U_PC_MakeBy'] = trim(addslashes(strip_tags($_POST['MakeBy'])));
	$tdata['U_PC_RelDt'] = (!empty($_POST['ReleaseDate'])) ? date("Y-m-d", strtotime($_POST['ReleaseDate'])) : null;
	$tdata['U_PC_RetstDt'] = (!empty($_POST['RetestDate'])) ? date("Y-m-d", strtotime($_POST['RetestDate'])) : null;
	$tdata['U_PC_PDate'] = (!empty($_POST['ReleaseDate'])) ? date("Y-m-d", strtotime($_POST['PostingDate'])) : null;
	$tdata['U_PC_ADate'] = (!empty($_POST['ReleaseDate'])) ? date("Y-m-d", strtotime($_POST['AnalysisDate'])) : null;
	$tdata['U_PC_MfgDt'] = (!empty($_POST['ReleaseDate'])) ? date("Y-m-d", strtotime($_POST['MfgDate'])) : null;
	$tdata['U_PC_ExpDt'] = (!empty($_POST['ReleaseDate'])) ? date("Y-m-d", strtotime($_POST['ExpiryDate'])) : null;
	$tdata['U_PC_MfgBy'] = (!empty($_POST['ReleaseDate'])) ? date("Y-m-d", strtotime($_POST['MfgBy'])) : null;
	
	if ($tdata['U_PC_PDate'] == "") {
		$data['status'] = 'False';$data['DocEntry'] = '';
		$data['message'] = 'Posting Date is required.';
		echo json_encode($data);
		exit;
	}

	if ($tdata['U_PC_ADate'] == "") {
		$data['status'] = 'False';$data['DocEntry'] = '';
		$data['message'] = 'Analysis Date is required.';
		echo json_encode($data);
		exit;
	}

	$ganaralData = array();
	if (!empty($_POST['pCode'])) {
		for ($i = 0;$i < count($_POST['pCode']);$i++) {
			$ganaralData['U_PC_PCode'] = trim(addslashes(strip_tags($_POST['pCode'][$i])));
			$ganaralData['U_PC_PName'] = trim(addslashes(strip_tags($_POST['PName'][$i])));
			$ganaralData['U_PC_Std'] = trim(addslashes(strip_tags($_POST['Standard'][$i])));
			$ganaralData['U_PC_Rotpt'] = trim(addslashes(strip_tags($_POST['ResultOut'][$i])));
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
			$ganaralData['U_PC_Min'] = trim(addslashes(strip_tags($_POST['UppMin'][$i])));
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

			$tdata['SCS_QCRETEST1Collection'][] = $ganaralData;
		}
	}

	$qcStatus = array();
	for ($j = 0; $j < count($_POST['qc_Status']); $j++) {
		if(!empty($_POST['qc_Status'][$j])){
			$qcStatus['U_PC_Stus'] = trim(addslashes(strip_tags($_POST['qc_Status'][$j])));
			$qcStatus['U_PC_Qty'] = trim(addslashes(strip_tags($_POST['qCStsQty'][$j])));
			$qcStatus['U_PC_DBy'] = trim(addslashes(strip_tags($_POST['doneBy'][$j])));
			$qcStatus['U_PC_Rmrk1'] = trim(addslashes(strip_tags($_POST['qCStsRemark1'][$j])));
	
			$qcStatus['U_PC_RelDt'] = (!empty($_POST['qCReleaseDate'][$j])) ? date("Y-m-d", strtotime($_POST['qCReleaseDate'][$j])) : null;
			$qcStatus['U_PC_RelTm'] = (!empty($_POST['qCReleaseTime'][$j])) ? date("Hi", strtotime($_POST['qCReleaseTime'][$j])) : null;
	
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
	
			$tdata['SCS_QCRETEST2Collection'][] = $qcStatus;

		}
	}

	$qcAttech = array();
	if (!empty($_POST['targetPath'])) {
		for ($k = 0;$k < count($_POST['targetPath']);$k++) {
			if (!empty($_POST['fileName'][$k])) {
				$qcAttech['U_TrgtPath'] = trim(addslashes(strip_tags($_POST['targetPath'][$k])));
				$qcAttech['U_FileName'] = trim(addslashes(strip_tags($_POST['fileName'][$k])));
				$qcAttech['U_AtchDate'] = trim(addslashes(strip_tags($_POST['attachDate'][$k])));
				$qcAttech['U_FreeText'] = trim(addslashes(strip_tags($_POST['freeText'][$k])));

				$tdata['SCS_QCPD3Collection'][] = $qcAttech;
			}
		}
	
	}
	
	// echo '<pre>';
	// print_r($tdata);
	// die();
	//<!-- ------------- function & function responce code Start Here ---- -->
		$res = $obj->SAP_Login();  // SAP Service Layer Login Here

		if (!empty($res)) {
			$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_QCRETEST;
			$responce_encode = $objKri->qcPostDocument($tdata, $Final_API);
			$responce = json_decode($responce_encode);

			//  <!-- ------- service layer function responce manage Start Here ------------ -->
			$data = array();

			if (!empty($responce->DocNum)) {
				if(!empty($responce->U_PC_SName)){
					// Purchase Delivery Notes
					$SIntiMainArray = [
						'DocEntry' => $_POST['GRPODocEntry'],
						'DocumentLines' => [
							[
								'LineNum' => $responce->U_PC_BLin,
								'U_PC_QCRtest' => $responce->DocEntry
							]
						]
					];
					
					$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $API_PurchaseDeliveryNotes . '(' . $_POST['GRPODocEntry'] . ')';

					// <!-- -------- Service Layer Function start here --------- -->
					$res11 = $obj->SAP_Login();  // SAP Service Layer Login Here
					if (!empty($res)) {
						$responce_encode1 = $obj->PATCH_ServiceLayerMasterFunction($SIntiMainArray, $Final_API);
						$responce1 = json_decode($responce_encode1);
					}
					$res12 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
					// <!-- -------- Service Layer Function end here ----------- -->

					if (empty($responce1)) {
						$data['status'] = 'True';
						$data['DocEntry'] = $responce->DocEntry;
						$data['message'] = "QC Post Document Added Successfully";
						echo json_encode($data);
					} else {
						if (array_key_exists('error', (array)$responce1)) {
							$data['status'] = 'False';
							$data['DocEntry'] = 'DocEntry PATCH Process';
							//$data['DocEntry']='PayLoad SL=> '.json_encode($SIntiMainArray).'<== API ==>'.$Final_API;
							$data['message'] = $responce1->error->message->value;
							echo json_encode($data);
						}
					}
				}else{
					// Inventory Gen Entries
					$InventoryGenEntries=array();
					$InventoryGenEntries['SIDocEntry']=trim($responce->DocEntry);
					$InventoryGenEntries['GRDocEntry']=trim($_POST['U_PC_GDEntry']);
					$InventoryGenEntries['ItemCode']=trim($responce->U_PC_ICode);
					$InventoryGenEntries['LineNum']=trim($responce->U_PC_BLin);

					$Final_API=$RETESTQCUPDATEGRN;
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
			} else {
				if (array_key_exists('error', (array)$responce)) {
					$data['status'] = 'False';
					$data['DocEntry'] = 'Main Doc POST';
					$data['message'] = $responce->error->message->value;
					$data['mainOP'] = $responce;
					echo json_encode($data);
				}
			}
			//  <!-- ------- service layer function responce manage End Here -------------- -->	
		}

		$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
		exit(0);
    //<!-- ------------- function & function responce code end Here ---- -->
}

















if (isset($_POST['updateQcPostDocumentRetestBtn'])) {
	$tdata = array(); // This array send to AP Standalone Invoice process 

	$tdata['DocEntry'] = trim(addslashes(strip_tags($_POST['qcD_DocEntry'])));
	$tdata['U_PC_LODWater'] = trim(addslashes(strip_tags($_POST['LoD_Water_xyz'])));
	$tdata['U_PC_Potency'] = trim(addslashes(strip_tags($_POST['potency_xyz'])));
	$tdata['U_PC_CompBy'] = trim(addslashes(strip_tags($_POST['qc_post_compiled_by'])));
	$tdata['U_PC_NoCont1'] = trim(addslashes(strip_tags($_POST['noOfCont1'])));
	$tdata['U_PC_NoCont2'] = trim(addslashes(strip_tags($_POST['noOfCont2'])));
	$tdata['U_PC_ChkBy'] = trim(addslashes(strip_tags($_POST['checked_by'])));
	$tdata['U_PC_AnlBy'] = trim(addslashes(strip_tags($_POST['analysis_by'])));
	$tdata['U_PC_Remarks'] = trim(addslashes(strip_tags($_POST['qc_remarks'])));
	$tdata['U_PC_AsyCal'] = trim(addslashes(strip_tags($_POST['assay_append'])));
	$tdata['U_PC_Factor'] = trim(addslashes(strip_tags($_POST['factor'])));
	$tdata['U_PC_SpcNo'] = trim(addslashes(strip_tags($_POST['qcD_SpecfNo'])));
	$tdata['U_PC_APot'] = trim(addslashes(strip_tags($_POST['AssayPotency_xyz'])));

	// $tdata['Series']=trim(addslashes(strip_tags($_POST['DocNo1'])));
	// $tdata['U_PC_BLin'] = trim(addslashes(strip_tags($_POST['LineNum'])));
	// $tdata['U_PC_BPLId'] = trim(addslashes(strip_tags($_POST['U_PC_BPLId'])));
	// $tdata['U_PC_LocCode'] = trim(addslashes(strip_tags($_POST['U_PC_LocCode'])));
	// $tdata['U_PC_Loc'] = trim(addslashes(strip_tags($_POST['U_PC_Loc'])));
	// $tdata['U_PC_GRNNo'] = trim(addslashes(strip_tags($_POST['qcD_GRPONo'])));
	// $tdata['U_PC_GRNEnt'] = trim(addslashes(strip_tags($_POST['GRPODocEntry'])));
	// $tdata['U_PC_SCode'] = trim(addslashes(strip_tags($_POST['qcD_SupplierCode'])));
	// $tdata['U_PC_SName'] = trim(addslashes(strip_tags($_POST['qcD_SupplierName'])));
	// $tdata['U_PC_ICode'] = trim(addslashes(strip_tags($_POST['qcD_ItemCode'])));
	// $tdata['U_PC_IName'] = trim(addslashes(strip_tags($_POST['qcD_ItemName'])));
	// $tdata['U_PC_GName'] = trim(addslashes(strip_tags($_POST['qcD_GenericName'])));
	// $tdata['U_PC_LClaim'] = trim(addslashes(strip_tags($_POST['qcD_LabelClaim'])));
	// $tdata['U_PC_LClmUom'] = trim(addslashes(strip_tags($_POST['qcD_LabelClaimUOM'])));
	// $tdata['U_PC_RQty'] = trim(addslashes(strip_tags($_POST['qcD_RetainQty'])));
	// $tdata['U_PC_MfgBy'] = trim(addslashes(strip_tags($_POST['qcD_MfgBy'])));
	// $tdata['U_PC_RfBy'] = trim(addslashes(strip_tags($_POST['qcD_RefNo'])));
	// $tdata['U_PC_BNo'] = trim(addslashes(strip_tags($_POST['qcD_BatchNo'])));
	// $tdata['U_PC_BSize'] = trim(addslashes(strip_tags($_POST['qcD_BatchQty'])));
	// $tdata['U_PC_MfgDt'] = trim(addslashes(strip_tags($_POST['qcD_MfgDate'])));
	// $tdata['U_PC_ExpDt'] = trim(addslashes(strip_tags($_POST['qcD_ExpiryDate'])));
	// $tdata['U_PC_SIntNo'] = trim(addslashes(strip_tags($_POST['qcD_SampleIntimationNo'])));
	// $tdata['U_PC_SColNo'] = trim(addslashes(strip_tags($_POST['qcD_SampleCollectionNo'])));
	// $tdata['U_PC_SQty'] = trim(addslashes(strip_tags($_POST['qcD_SampleQty'])));
	// $tdata['U_PC_PckSize'] = trim(addslashes(strip_tags($_POST['qcD_PckSize'])));
	// $tdata['U_PC_SamType'] = trim(addslashes(strip_tags($_POST['qcD_SamType'])));
	// $tdata['U_PC_MType'] = trim(addslashes(strip_tags($_POST['qcD_MatType'])));
	// $tdata['U_PC_PDate'] = trim(addslashes(strip_tags($_POST['qcD_PostingDate'])));
	// $tdata['U_PC_ADate'] = trim(addslashes(strip_tags($_POST['qcD_ADate'])));
	// $tdata['U_PC_NoCont'] = trim(addslashes(strip_tags($_POST['qcD_NoCont'])));
	// $tdata['U_PC_QCTType'] = trim(addslashes(strip_tags($_POST['qcD_QCTType'])));
	// $tdata['U_PC_Stage'] = trim(addslashes(strip_tags($_POST['qcD_Stage'])));
	// $tdata['U_PC_Branch'] = trim(addslashes(strip_tags($_POST['qcD_Branch'])));
	// $tdata['U_PC_ValUp'] = trim(addslashes(strip_tags($_POST['qcD_ValidUpto'])));
	// $tdata['U_PC_ArNo'] = trim(addslashes(strip_tags($_POST['qcD_ARNo'])));
	// $tdata['U_PC_GENo'] = trim(addslashes(strip_tags($_POST['qcD_GateENo'])));
	// $tdata['U_PC_GDEntry'] = trim(addslashes(strip_tags($_POST['U_PC_GDEntry'])));
	// $tdata['U_GRPONo']=trim(addslashes(strip_tags($_POST['qcD_GRPONo'])));
	// $tdata['U_GRPODEnt']=trim(addslashes(strip_tags($_POST['U_GRPODEnt'])));
	// $tdata['U_PC_GRQty'] = trim(addslashes(strip_tags($_POST['U_PC_GRQty'])));
	// $tdata['U_PC_RelDt']=trim(addslashes(strip_tags($_POST['U_PC_RelDt'])));
	// $tdata['U_PC_RetstDt']=trim(addslashes(strip_tags($_POST['U_PC_RetstDt'])));
	// $tdata['U_PC_RMQC'] = trim(addslashes(strip_tags($_POST['U_PC_RMQC'])));
	// $tdata['U_PC_RecQty'] = trim(addslashes(strip_tags($_POST['U_PC_RecQty'])));
	// $tdata['U_PC_SType'] = trim(addslashes(strip_tags($_POST['U_PC_SType'])));
	// $tdata['U_PC_MakeBy'] = trim(addslashes(strip_tags($_POST['qcD_MakeBy'])));

	$ganaralData = array();
	// $BL=0; //skip array avoid and count continue
	for ($i = 0; $i < count($_POST['parameter_code']); $i++) {


		$ganaralData['LineId'] = ($i + 1);
		$ganaralData['Object'] = 'SCS_QCRETEST';

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
		$ganaralData['U_PC_QCSts'] = trim(addslashes(strip_tags($_POST['qC_status_by_analyst'][$i])));
		$ganaralData['U_PC_Rotpt'] = trim(addslashes(strip_tags($_POST['result_output'][$i])));

		$tdata['SCS_QCRETEST1Collection'][] = $ganaralData; // row data append on this array
		// $BL++; // increment variable define here	
	}

	$qcStatus = array();
	// $qcS=0; //skip array avoid and count continue
	for ($j = 0; $j < count($_POST['qc_Status']); $j++) {

		$qcStatus['LineId'] = ($j + 1);
		$qcStatus['Object'] = 'SCS_QCRETEST';
		$qcStatus['U_PC_Stus'] = trim(addslashes(strip_tags($_POST['qc_Status'][$j])));
		$qcStatus['U_PC_Qty'] = trim(addslashes(strip_tags($_POST['qCStsQty'][$j])));
		$qcStatus['U_PC_ITNo'] = null;  //trim(addslashes(strip_tags($_POST['qCitNo'][$j])))
		$qcStatus['U_PC_DBy'] = trim(addslashes(strip_tags($_POST['doneBy'][$j])));
		$qcStatus['U_PC_Rmrk1'] = trim(addslashes(strip_tags($_POST['qCStsRemark1'][$j])));
		$qcStatus['U_PC_RelDt'] = (!empty($_POST['qCReleaseDate'][$j]))? date("Y-m-d",strtotime($_POST['qCReleaseDate'][$j])) : null;
		$qcStatus['U_PC_Atch1'] = (!empty($_FILES['qCAttache1']['name'][$j]))? $_FILES['qCAttache1']['name'][$j]:$_POST['qCAttache1'][$j];
		$qcStatus['U_PC_Atch2'] = (!empty($_FILES['qCAttache2']['name'][$j]))? $_FILES['qCAttache2']['name'][$j]:$_POST['qCAttache2'][$j];
		$qcStatus['U_PC_Atch3'] = (!empty($_FILES['qCAttache3']['name'][$j]))? $_FILES['qCAttache3']['name'][$j]:$_POST['qCAttache3'][$j];
		$qcStatus['U_PC_DvDt'] = (!empty($_POST['qCDeviationDate'][$j]))? date("Y-m-d",strtotime($_POST['qCDeviationDate'][$j])) : null;
		$qcStatus['U_PC_DvNo'] = trim(addslashes(strip_tags($_POST['qCDeviationNo'][$j])));
		$qcStatus['U_PC_DvRsn'] = trim(addslashes(strip_tags($_POST['qCDeviationResion'][$j])));

		$tdata['SCS_QCRETEST2Collection'][] = $qcStatus; // row data append on this array
		// $qcS++;
	}

	$qcAttech = array();
	// $qcatt=0; //skip array avoid and count continue
	for ($k = 0; $k < count($_POST['targetPath']); $k++) {
		$qcAttech['LineId'] = ($k + 1);
		$qcAttech['Object'] = 'SCS_QCRETEST';
		$qcAttech['U_PC_TrgPt'] = trim(addslashes(strip_tags($_POST['targetPath'][$k])));
		$qcAttech['U_PC_FName'] = trim(addslashes(strip_tags($_POST['fileName'][$k])));
		$qcAttech['U_PC_AtcDt'] = trim(addslashes(strip_tags($_POST['attachDate'][$k])));
		$qcAttech['U_PC_FText'] = trim(addslashes(strip_tags($_POST['freeText'][$k])));

		$tdata['SCS_QCRETEST3Collection'][] = $qcAttech; // row data append on this array
		// $qcatt++;
	}

	$mainArray = $tdata; // all child array append in main array define here

	// echo "<pre>";
	// print_r($mainArray);
	// echo "</pre>";
	// exit;

	// service laye function and SAP loin & logout function define start here -------------------------------------------------------
	$res = $obj->SAP_Login();

	if (!empty($res)) {

		$Final_API = $SAP_URL . ":" . $SAP_Port . "/b1s/v1/" . $SCS_QCRETEST . '(' . $_POST['qcD_DocEntry'] . ')';

		// $responce_encode=$objKri->qcPostDocumentRetestQc($mainArray,$Final_API);
		$responce_encode = $obj->PATCH_ServiceLayerMasterFunctionWithB1Replace($mainArray, $Final_API);
		$responce = json_decode($responce_encode);

		//  <!-- ------- service layer function responce manage Start Here ------------ -->
		if (array_key_exists('error', (array)$responce)) {
			$data['status'] = 'False';
			$data['DocEntry'] = '';
			$data['message'] = $responce->error->message->value;
			echo json_encode($data);
		} else {
			$data['status'] = 'True';
			$data['DocEntry'] = $_POST['qcD_DocEntry'];
			$data['message'] = 'QC Post Document retest qc updated Successfully';
			echo json_encode($data);
		}
		//  <!-- ------- service layer function responce manage End Here -------------- -->	
	}

	$res1 = $obj->SAP_Logout();  // SAP Service Layer Logout Here	
	exit(0);
	// service laye function and SAP loin & logout function define end here -------------------------------------------------------
}










if(isset($_POST['action']) && $_POST['action'] =='getInventoryRetestQccotainerSelection_ajax'){

	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs=trim(addslashes(strip_tags($_POST['WareHouse'])));
	// $GRPODEnt=trim(addslashes(strip_tags($_POST['GRPODEnt'])));
	$BNo=trim(addslashes(strip_tags($_POST['BatchNo'])));
// ItemCode=A00116&WareHouse=QCUT-GEN&BatchNo=BT2106-2
// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API=$RETESTQCPOSTDOCUMENTCONTSEL.'?ItemCode='.$ItemCode.'&WareHouse='.$FromWhs.'&BatchNo='.$BNo;
    $FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
// <!--------------- Preparing API End Here ------------------------------------------ -->
     // print_r($API);
// die();
	$response=$objKri->get_RetestQcContainer_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "<pre>";
	// exit;

// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if(!empty($response)){

		for ($i=0; $i <count($response) ; $i++) { 

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
					<input class="border_hide textbox_bg" type="text" id="itp_Batche'.$i.'" name="itp_Batch[]" class="form-control" value="'.$response[$i]->BatchNum.'" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty'.$i.'" name="itp_BatchQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" readonly>


				</td>

				
				<td style="text-align: center;">
				   <input class="border_hide" type="text" id="SelectedQty'.$i.'" name="SelectedQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" onfocusout="EnterQtyValidation_GI('.$i.')">

				  
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


if(isset($_POST['SC_SubIT_Btn']))
{
	$mainArray=array(); // This array hold all type of declare array
	$tdata=array(); //This array hold header data
	$item=array(); //This array hold item data
	$batch=array(); //This array hold batch data

	$tdata['Series']=trim(addslashes(strip_tags($_POST['it_SeriesId'])));
	$tdata['DocDate']=date("Y-m-d", strtotime($_POST['it_postingDate']));
	$tdata['DueDate']=date("Y-m-d", strtotime($_POST['it_documentDate']));
	$tdata['CardCode']=trim(addslashes(strip_tags($_POST['it_SupplierCode'])));
	$tdata['Comments']=null;
	$tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['from_whs'])));
	$tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['to_whs'])));
	$tdata['TaxDate']=date("Y-m-d", strtotime($_POST['it_documentDate']));
	$tdata['DocObjectCode']=trim(addslashes(strip_tags('67')));
    $tdata['BPLID']=trim(addslashes(strip_tags($_POST['BranchId'])));
	$tdata['U_PC_QCRtest']=trim(addslashes(strip_tags($_POST['_DocEntry'])));
	$tdata['U_BFType']=trim(addslashes(strip_tags($_POST['it_BaseDocEntry'])));

	$mainArray=$tdata;

	// --------------------- Item and batch row data preparing start here -------------------------------- -->
		$item['LineNum']=trim(addslashes(strip_tags('0')));
		$item['ItemCode']=trim(addslashes(strip_tags($_POST['tb_itme_code'])));
		$item['WarehouseCode']=trim(addslashes(strip_tags($_POST['to_whs'])));
		$item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST['from_whs'])));
		$item['Quantity']=trim(addslashes(strip_tags($_POST['tb_quality'])));
		
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

	// echo "<pre>";
	// print_r($mainArray);
	// echo "</pre>";
	// exit;
	// echo json_encode($mainArray);
	//<!-- ------------- function & function responce code Start Here ---- -->
	$res=$obj->SAP_Login();  // SAP Service Layer Login Here

	if(!empty($res)){
		$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_StockTransfers;

		$responce_encode=$objKri->SaveSampleIntimation_kris($mainArray,$Final_API);
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
					$UT_data = [
						'DocEntry' =>$_POST['_DocEntry'],
						'SCS_QCRETEST2Collection' => [
							[
								'LineId' =>$_POST['qc_status_LineId'],
								'U_PC_ITNo' => $responce->DocEntry
							]
						]
					];

				// <!-- ------- row data preparing end here ----------------------- -->
				
				$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_QCRETEST.'('.$_POST['_DocEntry'].')';
				$underTestNumber=$objKri->SampleIntimationUnderTestUpdateFromInventoryTransfer_kri($UT_data,$Final_API2);
				$underTestNumber_decode=json_decode($underTestNumber);

				if(empty($underTestNumber_decode)){
					$data['status']='True';
					$data['DocEntry']=$responce->DocEntry;
					$data['message']="Sample Collection Inventory Transfer Successfully Added.";
					echo json_encode($data);
				}else{
					// $data['status']='False';
					// $data['DocEntry']='';
					// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
					// echo json_encode($data);

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



// <td class="desabled">
// 					<input class="border_hide textbox_bg" type="text" id="gip_BatchQty'.$i.'" name="gip_BatchQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" readonly>
// 				</td>
// 				<td>
// 					<input class="border_hide" type="text" id="gip_SelectedQty'.$i.'" name="gip_SelectedQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" onfocusout="EnterQtyValidation_GI('.$i.')">
// 				</td>


// <td class="desabled">
// 					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty'.$i.'" name="itp_BatchQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" readonly>
// 				</td>
// 				<td>
// 					<input class="border_hide" type="text" id="SelectedQty'.$i.'" name="SelectedQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" onfocusout="EnterQtyValidation('.$i.')">
// 				</td>


if(isset($_POST['action']) && $_POST['action'] =='qc_post_document_retest_qc_pupup_ajax')
{
	// $API=$RETESTQCPOSTDOCUMENTDETAILS.'?DocEntry='.$_POST['DocEntry'].'&BatchNo='.$_POST['BatchNo'].'&ItemCode='.$_POST['ItemCode'].'&LineNum='.$_POST['LineNum'];
    $API=$RETESTQCPOSTDOCUMENTDETAILS.'?DocEntry='.$_POST['DocEntry'].'&Status='.$_POST['QC_Status'];
	// $API=$RETESTQCPOSTDOC.'?DocEntry='.$_POST['DocEntry'];
	
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20

		// print_r($FinalAPI);
		// die();
	// <!-- ------- Replace blank space to %20 End here -------- -->
	$response=$objKri->get_QcPostDocument_RetestQcSingleData($FinalAPI);
    //    echo "<pre>";
	   // print_r($response);
	   // echo "<pre>";
	   // exit;
	echo json_encode($response);
	exit(0);

}





if(isset($_POST['action']) && $_POST['action'] =='qc_post_document_retest_qc_ajax')
{
	$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));
	// ------- Replace blank space to %20 start here --------
	$API = $RETESTQCPOSTDOCUMENTDETAILS . '?DocEntry=' . $DocEntry;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// ------- Replace blank space to %20 End here --------

	// print_r($FinalAPI);
	// die();

	$response = $objKri->get_QcPostDocument_RetestQcSingleData($FinalAPI);


// ------ Array declaration Start Here ---------------------------------
$FinalResponce = array();
$FinalResponce['SampleCollDetails'] = $response;
// ------ Array declaration End Here  ---------------------------------

$general_data = $response[0]->RETESTQCPOSTDOCGENERALDATA;
$qcStatus = $response[0]->RETESTQCPOSTDOCQCSTATUS; // Extra issue response separate here

// Debugging: print the qcStatus to check its value
// echo "<pre>";
// echo "qcStatus: ";
// print_r($general_data);
// echo "</pre>";

// Optionally, you might want to add exit here if you want to stop execution after checking the value
// exit;


		$qcAttach=$response[0]->RETESTQCPOSTDOCATTACH; //External issue reponce seperate here

	// <!-- ----------- Extra Issue Start here --------------------------------- -->

		if(!empty($general_data)){
			for ($i=0; $i <count($general_data) ; $i++) { 
				$SrNo=$i;
				$index=$i+1;

				$FinalResponce['general_data'].='<tr>
					<td class="desabled">'.$index.'</td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="parameter_code'.$SrNo.'" name="parameter_code[]" value="'.$general_data[$i]->PCode.'" readonly></td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="PName'.$SrNo.'" name="PName[]" value="'.$general_data[$i]->PName.'" readonly></td>

					<td class="desabled" style="cursor: pointer;"><input  type="text" class="form-control textbox_bg" id="Standard'.$SrNo.'" name="Standard[]" value="'.$general_data[$i]->Standard.'" readonly class="form-control textbox_bg" style="border: 1px solid #efefef !important;width:400px;"></td>
					
					<td><input type="text" id="ResultOut'.$SrNo.'" name="ResultOut[]" value="'.$general_data[$i]->GDRemarks.'" class="form-control" style="width:200px;"></td>';
										
				if($general_data[$i]->PDType=='Range'){
					$FinalResponce['general_data'].='<td>
						<input type="text" id="ComparisonResult'.$SrNo.'" name="ComparisonResult[]" value="'.$general_data[$i]->LowMin1.'" class="form-control" style="width:100px;" onfocusout="CalculateResultOut('.$SrNo.')">
					</td>';
				}else{
					$FinalResponce['general_data'].='<td class="desabled">
						<input type="text" id="ComparisonResult'.$SrNo.'" name="ComparisonResult[]" value="'.$general_data[$i]->LowMin1.'" class="form-control textbox_bg" style="width:100px;">
					</td>';
				}
				
				
				$FinalResponce['general_data'].='
					<td id="ResultOutputByQCDeptTd'.$SrNo.'">
						<input type="hidden" id="ResultOutputByQCDept_Old'.$SrNo.'" name="ResultOutputByQCDept_Old[]" value="'.$general_data[$i]->ROutput.'">

						<select id="ResultOutputByQCDept'.$SrNo.'" name="ResultOutputByQCDept[]" class="form-select" style="border: 1px solid #ffffff !important;" onchange="OnChangeResultOutputByQCDept('.$SrNo.')"></select>
					</td>

					<td class="desabled">
						<input type="text" id="PDType'.$SrNo.'" name="PDType[]" value="'.$general_data[$i]->PDType.'" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="logical'.$SrNo.'" name="logical[]" value="'.$general_data[$i]->Logical.'" readonly></td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="LowMin'.$SrNo.'" name="LowMin[]" value="'.$general_data[$i]->LowMin.'" readonly></td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="UppMax'.$SrNo.'" name="UppMax[]" value="'.$general_data[$i]->UppMax.'" readonly></td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="Min'.$SrNo.'" name="Min[]" value="'.$general_data[$i]->Min.'" readonly></td>
					
					<td id="QC_StatusByAnalystTd'.$SrNo.'">
						<input type="hidden" id="qC_status_by_analyst_Old'.$SrNo.'" name="qC_status_by_analyst_Old[]" value="'.$general_data[$i]->GDQCStatus.'">

						<select id="qC_status_by_analyst'.$SrNo.'" name="qC_status_by_analyst[]" class="form-select qc_statusbyab'.$SrNo.'" onchange="SelectedQCStatus('.$SrNo.')">
						</select>
					</td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="TMethod'.$SrNo.'" name="TMethod[]" value="'.$general_data[$i]->TMethod.'" readonly></td>
					
					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="MType'.$SrNo.'" name="MType[]" value="'.$general_data[$i]->MType.'" readonly></td>
					<td class="desabled">
						<input type="text" id="PharmacopeiasStandard'.$i.'" name="PharmacopeiasStandard[]" value="'.$general_data[$i]->PharmacopeiasStandard.'"" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled"><input type="text" id="UOM'.$SrNo.'" name="UOM[]" class="form-control textbox_bg" value="'.$general_data[$i]->GDUOM.'" readonly></td>

					<td class="desabled"><input type="text" id="Retest'.$SrNo.'" name="Retest[]" class="form-control textbox_bg" value="'.$general_data[$i]->Retest.'" readonly></td>
					
					<td class="desabled"><input type="text" id="ExSample'.$SrNo.'" name="ExSample[]" class="form-control textbox_bg" value="'.$general_data[$i]->ExSample.'" readonly></td>

					<td>
						<input type="hidden" id="AnalysisBy_Old'.$SrNo.'" name="AnalysisBy_Old[]" value="'.$general_data[$i]->AnyBy.'">

						<select id="AnalysisBy'.$SrNo.'" name="AnalysisBy[]" class="form-select" style="width: 140px;"></select>
					</td>

					<td><input  type="text" id="analyst_remark'.$SrNo.'" name="analyst_remark[]" class="form-control" value="'.$general_data[$i]->ARRemark.'"></td>
				
					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="LowMax'.$SrNo.'" name="LowMax[]" value="'.$general_data[$i]->LowMax.'" readonly></td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="Release'.$SrNo.'" name="Release[]" value="'.$general_data[$i]->Release.'" readonly></td>
					
					<td><input  type="text" class="form-control" id="descriptive_details'.$SrNo.'" name="descriptive_details[]" value="'.$general_data[$i]->DesDetils.'"></td>

					<td class="desabled"><input  type="text" class="form-control textbox_bg" id="UppMin'.$SrNo.'" name="UppMin[]" value="'.$general_data[$i]->UppMin.'" readonly></td>
					
					<td><input  type="number" id="lower_min_result'.$SrNo.'" name="lower_min_result[]" class="form-control" value="'.$general_data[$i]->LowMax1.'"></td>
					
					<td><input  type="number" id="UppMinRes'.$SrNo.'" name="UppMinRes[]" class="form-control"></td>
					
					<td><input  type="number" id="upper_max_result'.$SrNo.'" name="upper_max_result[]" class="form-control" value="'.$general_data[$i]->UppMax1.'"></td>

					<td>
						<input type="number" id="MeanRes'.$SrNo.'" name="MeanRes[]" class="form-control">
					</td>

					<td><input type="text" id="user_text1_'.$SrNo.'" name="user_text1_[]" class="form-control" value="'.$general_data[$i]->UText1.'"></td>

					<td><input type="text" id="user_text2_'.$SrNo.'" name="user_text2_[]" class="form-control" value="'.$general_data[$i]->UText2.'"></td>

					<td><input type="text" id="user_text3_'.$SrNo.'" name="user_text3_[]" class="form-control" value="'.$general_data[$i]->UText3.'"></td>

					<td><input type="text" id="user_text4_'.$SrNo.'" name="user_text4_[]" class="form-control" value="'.$general_data[$i]->UText4.'"></td>

					<td ><input type="text" id="user_text5_'.$SrNo.'" name="user_text5_[]" class="form-control" value="'.$general_data[$i]->UText5.'"></td>
					
					<td class="desabled">
						<input type="text" id="QC_StatusResult'.$SrNo.'" name="QC_StatusResult[]" class="form-control textbox_bg" style="border: 1px solid #efefef !important;">
					</td>

					<td class="desabled"><input type="text" id="GDStab'.$SrNo.'" name="GDStab[]" class="form-control textbox_bg" value="'.$general_data[$i]->GDStab.'" readonly></td>
					
					<td class="desabled"><input type="text" id="Appassay'.$SrNo.'" name="Appassay[]" class="form-control textbox_bg" value="'.$general_data[$i]->Appassay.'" readonly></td>

					<td class="desabled"><input type="text" id="AppLOD'.$SrNo.'" name="AppLOD[]" class="form-control textbox_bg" value="'.$general_data[$i]->AppLOD.'" readonly></td>
				
					<td><input type="text" id="InstrumentCode'.$SrNo.'" name="InstrumentCode[]" class="form-control" data-bs-toggle="modal" data-bs-target=".instrument_modal" value="'.$general_data[$i]->Inscode.'" onclick="OpenInstrmentModal('.$SrNo.')"></td>

					<td class="desabled"><input type="text" id="InstrumentName'.$SrNo.'" name="InstrumentName[]" class="form-control textbox_bg" value="'.$general_data[$i]->InsName.'" readonly style="border: 1px solid #efefef !important;"></td>

					<td><input  type="date" id="start_date'.$SrNo.'" name="start_date[]" class="form-control" value="'.(!empty($general_data[$i]->SDate)? date("Y-m-d", strtotime($general_data[$i]->SDate)) : '').'"></td>

					<td><input  type="time" id="start_time'.$SrNo.'" name="start_time[]" class="form-control" value="'.(!empty($general_data[$i]->STime)? date("H:i", strtotime($general_data[$i]->STime)) : '').'"></td>

					<td ><input type="date" id="end_date'.$SrNo.'" name="end_date[]" class="form-control" value="'.(!empty($general_data[$i]->EDate)? date("Y-m-d", strtotime($general_data[$i]->EDate)) : '').'"></td>


					<td ><input type="time" id="end_time'.$SrNo.'" name="end_time[]" class="form-control" value="'.(!empty($general_data[$i]->ETime)? date("H:i", strtotime($general_data[$i]->ETime)) : '').'"></td>
				</tr>';
			}
		}else{
			$FinalResponce['general_data'].='<tr><td colspan="7" style="color:red;text-align: center;">No Record Found</td></tr>';
		}

		$FinalResponce['count']=count($general_data);

// <!-- ----------- External Issue Start Here ---------------------------- -->
if(!empty($qcStatus)){
	for ($j=0; $j <count($qcStatus) ; $j++) { 
		$SrNo=$j+1;

		$FinalResponce['qcStatus'].='<tr id="add-more_'.$SrNo.'">';


			if(!empty($qcStatus[$j]->ItNo)){
				$FinalResponce['qcStatus'].='<td class="desabled">'.$SrNo.'</td>';
			}else{
				$FinalResponce['qcStatus'].='
					<td style="text-align: center;">
						<input type="radio" id="list'.$SrNo.'" name="listRado[]" value="'.$SrNo.'" class="form-check-input" style="width: 17px;height: 17px;">
					</td>';
			}
		$FinalResponce['qcStatus'].='

			<td class="desabled">
				<input type="hidden" id="QCS_LineId'.$SrNo.'" name="QCS_LineId[]" value="'.$qcStatus[$j]->LineID.'">

				<input class="form-control border_hide desabled" type="text" id="qc_Status'.$SrNo.'" name="qc_Status[]" value="'.$qcStatus[$j]->QCStsStatus.'" readonly>
			</td>

			<td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsQty'.$SrNo.'" name="qCStsQty[]"  value="'.$qcStatus[$j]->QCStsQty.'" readonly></td>

			<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCReleaseDate_'.$SrNo.'" name="qCReleaseDate[]" value="'.((!empty($qcStatus[$j]->QCRelDt))? date("d-m-Y", strtotime($qcStatus[$j]->QCRelDt)):"").'" class="form-control" readonly></td>

			<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCReleaseTime_'.$SrNo.'" name="qCReleaseTime[]" value="'.((!empty($qcStatus[$j]->QCRelTime))? date("H:i", strtotime($qcStatus[$j]->QCRelTime)):"").'" class="form-control" readonly></td>

			<td class="desabled"><input  type="text" class="form-control border_hide desabled" id="qCitNo'.$SrNo.'" name="qCitNo[]"  value="'.$qcStatus[$j]->ItNo.'" readonly></td>

			<td class="desabled"><input class="form-control border_hide desabled" type="text" id="doneBy'.$SrNo.'" name="doneBy[]"  value="'.$qcStatus[$j]->DBy.'" readonly></td>

			<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCAttache1_'.$SrNo.'" name="qCAttache1[]" value="'.$qcStatus[$j]->QCStsAttach1.'" class="form-control"></td>

			<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCAttache2_'.$SrNo.'" name="qCAttache2[]" value="'.$qcStatus[$j]->QCStsAttach2.'" class="form-control"></td>

			<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCAttache3_'.$SrNo.'" name="qCAttache3[]" value="'.$qcStatus[$j]->QCStsAttach3.'" class="form-control"></td>

			<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCDeviationDate_'.$SrNo.'" name="qCDeviationDate[]" value="'.((!empty($qcStatus[$j]->DevDate))? date("d-m-Y", strtotime($qcStatus[$j]->DevDate)):"").'" class="form-control"></td>

			<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCDeviationNo_'.$SrNo.'" name="qCDeviationNo[]" value="'.$qcStatus[$j]->DevNo.'" class="form-control"></td>

			<td class="desabled"><input class="form-control border_hide desabled" type="text"  id="qCDeviationResion_'.$SrNo.'" name="qCDeviationResion[]" value="'.$qcStatus[$j]->DevRsn.'" class="form-control"></td>

			<td class="desabled"><input class="form-control border_hide desabled" type="text" id="qCStsRemark1'.$SrNo.'" name="qCStsRemark1[]"  value="'.$qcStatus[$j]->QCStsRemark1.'" readonly></td>

		</tr>';
	}
}else{
	// $FinalResponce['qcStatus'].='<tr><td colspan="12" style="color:red;text-align: center;">No Record Found</td></tr>';
	
}

$QCS_un_id=(count($qcStatus)+1);
$FinalResponce['qcStatus'] .='<tr id="add-more_'.$QCS_un_id.'">
	<td>'.$QCS_un_id.'</td>
	<td><select id="qc_Status_'.$QCS_un_id.'" name="qc_Status[]" class="form-select qc_status_selecte1" onchange="SelectionOfQC_Status('.$QCS_un_id.')"></select></td>

	<td><input class="border_hide" type="text"  id="qCStsQty_'.$QCS_un_id.'" name="qCStsQty[]" class="form-control" value="" onfocusout="addMore('.$QCS_un_id.');"></td>


	<td><input class="border_hide" type="text"  id="qCReleaseDate_'.$QCS_un_id.'" name="qCReleaseDate[]" class="form-control" readonly></td>

	<td><input class="border_hide" type="text"  id="qCReleaseTime_'.$QCS_un_id.'" name="qCReleaseTime[]" class="form-control" readonly></td>

	<td><input class="border_hide" type="text"  id="qCitNo_'.$QCS_un_id.'" name="qCitNo[]" class="form-control" value=""></td>

	<td>
	<select id="doneBy_'.$QCS_un_id.'" name="doneBy[]" class="form-select done-by-mo1"></select>
	</td>

	<td><input class="border_hide" type="file"  id="qCAttache1_'.$QCS_un_id.'" name="qCAttache1[]" class="form-control"></td>


	<td><input class="border_hide" type="file"  id="qCAttache2_'.$QCS_un_id.'" name="qCAttache2[]" class="form-control"></td>

	<td><input class="border_hide" type="file"  id="qCAttache3_'.$QCS_un_id.'" name="qCAttache3[]" class="form-control"></td>

	<td><input class="border_hide" type="date"  id="qCDeviationDate_'.$QCS_un_id.'" name="qCDeviationDate[]" class="form-control"></td>

	<td><input class="border_hide" type="text"  id="qCDeviationNo_'.$QCS_un_id.'" name="qCDeviationNo[]" class="form-control"></td>

	<td><input class="border_hide" type="text"  id="qCDeviationResion_'.$QCS_un_id.'" name="qCDeviationResion[]" class="form-control"></td>

	<td><input class="border_hide" type="text"  id="qCStsRemark1_'.$QCS_un_id.'" name="qCStsRemark1[]" class="form-control"></td>
	
</tr>';
	
// $FinalResponce['qcStatus'] .='<tr">
// 	<td>'.(count($qcStatus)+1).'</td>
// 	<td><select id="qc_Status_1" name="qc_Status[]" class="form-select qc_status_selecte1"></select></td>
// 	<td><input class="border_hide" type="text"  id="qCStsQty_1" name="qCStsQty[]" class="form-control" value=""></td>
// 	<td><input class="border_hide" type="text"  id="qCitNo_1" name="qCitNo[]" class="form-control" value=""></td>
// 	<td>
// 	<select id="doneBy_1" name="doneBy[]" class="form-select done-by-mo1"></select>
// 	</td>
// 	<td><input class="border_hide" type="text"  id="qCStsRemark1_1" name="qCStsRemark1[]" class="form-control" value=""></td>
// </tr>';




if(!empty($qcAttach)){
	for ($j=0; $j <count($qcAttach) ; $j++) { 
		$SrNo=$j+1;
		// <tr>
	$FinalResponce['qcAttach'].='<tr>
			<td class="desabled">'.$SrNo.'</td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="targetPath'.$SrNo.'" name="targetPath[]" class="form-control" value="'.$qcAttach[$j]->TargetPath.'" readonly>
			</td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="fileName'.$SrNo.'" name="fileName[]"  class="form-control" value="'.$qcAttach[$j]->FileName.'" readonly></td>
			<td class="desabled"><input class="border_hide desabled" type="text" id="attachDate'.$SrNo.'" name="attachDate[]"  class="form-control" value="'.$qcAttach[$j]->AttachDate.'" readonly></td>
			<td><input class="border_hide" type="text" id="freeText'.$SrNo.'" name="freeText[]"  class="form-control" value="'.$qcAttach[$j]->FreeText.'"></td>
		</tr>';
	}
}
else{
	$FinalResponce['qcAttach'].='<tr>
				<td class="desabled">1</td>
				<td class="desabled"><input class="border_hide desabled" type="text" id="targetPath1" name="targetPath[]" class="form-control" value="" readonly></td>
				<td class="desabled"><input class="border_hide desabled" type="text" id="fileName1" name="fileName[]"  class="form-control" value="" readonly></td>
				<td class="desabled"><input class="border_hide desabled" type="text" id="attachDate1" name="attachDate[]"  class="form-control" value="" readonly></td>
				<td><input class="border_hide" type="text" id="freeText1" name="freeText[]"  class="form-control" value=""></td>
			</tr>';
// $FinalResponce['qcAttach'].='<tr><td colspan="12" style="color:red;text-align: center;">No Record Found</td></tr>';
}















	
	// <!-- ----------- External Issue End Here   ---------------------------- -->
	echo json_encode($FinalResponce);
	exit(0);
}




if(isset($_POST['SubIT_Btn_SCRT']))
{	
	$mainArray=array(); // This array hold all type of declare array
	$tdata=array(); //This array hold header data
	$item=array(); //This array hold item data
	$batch=array(); //This array hold batch data
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;

	$tdata['Series']=trim(addslashes(strip_tags($_POST['SCRTQC_it_DocNo'])));
	$tdata['DocDate']=date("Y-m-d", strtotime($_POST['it_PostingDate']));
	$tdata['DueDate']=date("Y-m-d", strtotime($_POST['it_DocDate']));
	$tdata['CardCode']=trim(addslashes(strip_tags($_POST['SCRTQC_it_supplierCode'])));
	$tdata['Comments']=null;
	$tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['SCRTQC_it_IL_FromWhs'])));
	$tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['SCRTQC_it_IL_ToWhs'])));
	$tdata['TaxDate']=date("Y-m-d", strtotime($_POST['it_DocDate']));
	$tdata['DocObjectCode']=trim(addslashes(strip_tags('67')));
	$tdata['BPLID']=trim(addslashes(strip_tags($_POST['_SCRTQCB_BPLId'])));
    $tdata['U_PC_SCRtest']=trim(addslashes(strip_tags($_POST['SCRTQC_it_SCRTQCB_DocEntry'])));
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$tdata['U_BFType']=trim(addslashes(strip_tags($_POST['SCRTQC_it_BaseDocType'])));

	$mainArray=$tdata;

// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum']=trim(addslashes(strip_tags('0')));
	$item['ItemCode']=trim(addslashes(strip_tags($_POST['SCRTQC_ItemCode'])));
	$item['WarehouseCode']=trim(addslashes(strip_tags($_POST['SCRTQC_it_IL_ToWhs'])));
	$item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST['SCRTQC_it_IL_FromWhs'])));
	$item['Quantity']=trim(addslashes(strip_tags($_POST['SCRTQC_it_IL_Quantity'])));
	
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

	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
// echo json_encode($mainArray);
// exit;
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
				$data['message']=$responce->error->message->value;
				echo json_encode($data);
			}else{

				// <!-- ------- row data preparing start here --------------------- -->
					$UT_data=array();
					$UT_data['DocEntry']=trim(addslashes(strip_tags($_POST['SCRTQC_it_SCRTQCB_DocEntry'])));
					$UT_data['U_UTTrans']=trim(addslashes(strip_tags($responce->DocEntry)));
				// <!-- ------- row data preparing end here ----------------------- -->

				$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SCS_SINTIMATION.'('.$UT_data['DocEntry'].')';
				$underTestNumber=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data,$Final_API2);
				$underTestNumber_decode=json_decode($underTestNumber);

				if($underTestNumber_decode==''){
					$data['status']='True';
					$data['DocEntry']=$responce->DocEntry;
					$data['message']="Inventory Transfer Successfully Added.";
					echo json_encode($data);
				}else{
					// $data['status']='False';
					// $data['DocEntry']='';
					// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
					// echo json_encode($data);

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


if(isset($_POST['SubIT_Btn_SCRT_sample_issue']))
{	
	$mainArray=array(); // This array hold all type of declare array
	$tdata=array(); //This array hold header data
	$item=array(); //This array hold item data
	$batch=array(); //This array hold batch data
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;
	$tdata['DocType']='dDocument_Items';
	$tdata['DocDate']=date("Y-m-d", strtotime($_POST['GI_postingDate']));
	$tdata['DocDueDate']=date("Y-m-d", strtotime($_POST['GI_DocumentDate']));
    $tdata['Series']=trim(addslashes(strip_tags($_POST['GI_series'])));
    $tdata['TaxDate']=date("Y-m-d", strtotime($_POST['GI_DocumentDate']));
    $tdata['DocObjectCode']='oInventoryGenExit';
    $tdata['U_PC_SCRtest']=trim(addslashes(strip_tags($_POST['SCRTQC_GI_SCRTQCB_DocEntry'])));
    $tdata['U_BFType']=trim(addslashes(strip_tags($_POST['GI_baseDocType'])));
    $tdata['BPL_IDAssignedToInvoice']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId_samIss'])));
	// Series
	// $tdata['CardCode']=trim(addslashes(strip_tags($_POST['GI_supplierCode'])));
	// $tdata['Comments']=null;
	// $tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
	// $tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['GI_to_whs'])));
	// $tdata['BPLID']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId_samIss'])));
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$mainArray=$tdata;
// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum']=trim(addslashes(strip_tags('0')));
	$item['ItemCode']=trim(addslashes(strip_tags($_POST['GI_item_code'])));
	$item['Quantity']=trim(addslashes(strip_tags($_POST['GI_quatility'])));
	$item['WarehouseCode']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
	// $item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
	// <!-- Item Batch row data prepare start here ----------- -->
		// $BL=0;
		for ($i=0; $i <count($_POST['usercheckList']) ; $i++) { 

			if($_POST['usercheckList'][$i]=='1'){

				$batch['BatchNumber']=trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
				$batch['Quantity']=trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
				$batch['BaseLineNumber']=trim(addslashes(strip_tags('0')));
				$batch['ItemCode']=trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));
				$item['BatchNumbers'][]=$batch;
				// $BL++;
			}
		}
	// <!-- Item Batch row data prepare end here ------------- -->
	$mainArray['DocumentLines'][]=$item;
// --------------------- Item and batch row data preparing end here ---------------------------------- -->
	// echo json_encode($mainArray);
	// exit;
	// echo "<pre>";
	// print_r($_POST['usercheckList']);
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
	// echo json_encode($mainArray);
	// exit;
//<!-- ------------- function & function responce code Start Here ---- -->
	$res=$obj->SAP_Login();  // SAP Service Layer Login Here

	if(!empty($res)){
		$Final_API=$InventoryGenExits;

		$responce_encode=$obj->SaveSampleIntimation($mainArray,$Final_API);
		$responce=json_decode($responce_encode);



		//  <!-- ------- service layer function responce manage Start Here ------------ -->
			$data=array();
			if(array_key_exists('error', (array)$responce)){
				$data['status']='False';
				$data['DocEntry']='111111111';
				$data['message']=$responce->error->message->value;
				echo json_encode($data);
			}else{

				// <!-- ------- row data preparing start here --------------------- -->
					$UT_data=array();
					$UT_data['DocEntry']=trim(addslashes(strip_tags($_POST['SCRTQC_GI_SCRTQCB_DocEntry'])));
					$UT_data['U_PC_SIssue']=trim(addslashes(strip_tags($responce->DocEntry)));
				// <!-- ------- row data preparing end here ----------------------- -->

				$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SCRETEST_API.'('.$UT_data['DocEntry'].')';
				$underTestNumber=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data,$Final_API2);
				$underTestNumber_decode=json_decode($underTestNumber);

				if($underTestNumber_decode==''){
					$data['status']='True';
					$data['DocEntry']=$responce->DocEntry;
					$data['message']="Inventory Transfer Successfully Added.";
					echo json_encode($data);
				}else{
					// $data['status']='False';
					// $data['DocEntry']='';
					// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
					// echo json_encode($data);

					if(array_key_exists('error', (array)$underTestNumber_decode)){
						$data['status']='False';
						$data['DocEntry']='2222222222222';
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


if(isset($_POST['action']) && $_POST['action'] =='SC_OpenInventoryTransferCS_ajax_trnsfer'){

	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs=trim(addslashes(strip_tags($_POST['FromWhs'])));
	$GRPODEnt=trim(addslashes(strip_tags($_POST['GRPODEnt'])));
	$BNo=trim(addslashes(strip_tags($_POST['BNo'])));

// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API=$CONTCOLLSEL_API.'?ItemCode='.$ItemCode.'&WhsCode='.$FromWhs.'&LotNo='.$BNo;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
// <!--------------- Preparing API End Here ------------------------------------------ -->
// print_r($FinalAPI);
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
					<input class="border_hide" type="text" id="SelectedQty'.$i.'" name="SelectedQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" onfocusout="EnterQtyValidation_transfer('.$i.')">
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







if(isset($_POST['SubIT_Btn_SCRT_transfer']))
{	
	$mainArray=array(); // This array hold all type of declare array
	$tdata=array(); //This array hold header data
	$item=array(); //This array hold item data
	$batch=array(); //This array hold batch data
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;

	$tdata['Series']=trim(addslashes(strip_tags($_POST['transfer_it_DocNo'])));
	$tdata['DocDate']=date("Y-m-d", strtotime($_POST['it_PostingDate_tras']));
	$tdata['DueDate']=date("Y-m-d", strtotime($_POST['it_DocDate_trans']));
	$tdata['CardCode']=trim(addslashes(strip_tags($_POST['transfer_it_supplierCode'])));
	$tdata['Comments']=null;
	$tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['transfer_it_IL_FromWhs'])));
	$tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['transfer_it_IL_ToWhs'])));
	$tdata['TaxDate']=date("Y-m-d", strtotime($_POST['it_DocDate']));
	$tdata['DocObjectCode']=trim(addslashes(strip_tags('67')));
	$tdata['BPLID']=trim(addslashes(strip_tags($_POST['_transfer_BPLId'])));
    $tdata['U_PC_SCRtest']=trim(addslashes(strip_tags($_POST['transfer_it_SCRTQCB_DocEntry'])));
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$tdata['U_BFType']=trim(addslashes(strip_tags($_POST['transfer_it_BaseDocType'])));
// SCS_SCRETEST
	$mainArray=$tdata;

// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum']=trim(addslashes(strip_tags('0')));
	$item['ItemCode']=trim(addslashes(strip_tags($_POST['transfer_it_IL_ItemCode'])));
	$item['WarehouseCode']=trim(addslashes(strip_tags($_POST['transfer_it_IL_ToWhs'])));
	$item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST['transfer_it_IL_FromWhs'])));
	$item['Quantity']=trim(addslashes(strip_tags($_POST['transfer_it_IL_Quantity'])));
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
	// echo "<pre>";
	// print_r($mainArray);
	// echo "<pre>";
	// exit;
// echo json_encode($mainArray);
// exit;
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
				$data['message']=$responce->error->message->value;
				echo json_encode($data);
			}else{

				// <!-- ------- row data preparing start here --------------------- -->
					$UT_data=array();
					$UT_data['DocEntry']=trim(addslashes(strip_tags($_POST['transfer_it_SCRTQCB_DocEntry'])));
					$UT_data['U_UTTrans']=trim(addslashes(strip_tags($responce->DocEntry)));
				// <!-- ------- row data preparing end here ----------------------- -->
					$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SCS_SINTIMATION.'('.$UT_data['DocEntry'].')';
					$underTestNumber=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data,$Final_API2);
					$underTestNumber_decode=json_decode($underTestNumber);

						if($underTestNumber_decode==''){
							$data['status']='True';
							$data['DocEntry']=$responce->DocEntry;
							$data['message']="Inventory Transfer Successfully Added.";
							echo json_encode($data);
						}else{
							// $data['status']='False';
							// $data['DocEntry']='';
							// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
							// echo json_encode($data);
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



if(isset($_POST['SubIT_Btn_SCRT_extrA_issue']))
{	
	$mainArray=array(); // This array hold all type of declare array
	$tdata=array(); //This array hold header data
	$item=array(); //This array hold item data
	$batch=array(); //This array hold batch data
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	// exit;


	
	$tdata['DocType']='dDocument_Items';
	$tdata['DocDate']=date("Y-m-d", strtotime($_POST['extraIssue_postingDate']));
	$tdata['DocDueDate']=date("Y-m-d", strtotime($_POST['extraIssue_DocumentDate']));
    $tdata['Series']=trim(addslashes(strip_tags($_POST['extraIssue_series'])));
    $tdata['TaxDate']=date("Y-m-d", strtotime($_POST['extraIssue_DocumentDate']));
    $tdata['DocObjectCode']='oInventoryGenExit';
    $tdata['U_PC_SCRtest']=trim(addslashes(strip_tags($_POST['extraIssue_GI_SCRTQCB_DocEntry'])));
    $tdata['U_BFType']=trim(addslashes(strip_tags($_POST['extraIssue_baseDocType'])));
    $tdata['BPL_IDAssignedToInvoice']=trim(addslashes(strip_tags($_POST['extraIssue_BPLId_samIss'])));

	// $tdata['CardCode']=trim(addslashes(strip_tags($_POST['GI_supplierCode'])));
	// $tdata['Comments']=null;
	// $tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
	// $tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['GI_to_whs'])));
	// $tdata['BPLID']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId_samIss'])));
	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
	$mainArray=$tdata;
// --------------------- Item and batch row data preparing start here -------------------------------- -->
	$item['LineNum']=trim(addslashes(strip_tags('0')));
	$item['ItemCode']=trim(addslashes(strip_tags($_POST['extraIssue_item_code'])));
	$item['Quantity']=trim(addslashes(strip_tags($_POST['extraIssue_quatility'])));
	$item['WarehouseCode']=trim(addslashes(strip_tags($_POST['extraIssue_from_whs'])));
	// $item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
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
	$mainArray['DocumentLines'][]=$item;
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
	$res=$obj->SAP_Login();  // SAP Service Layer Login Here

	if(!empty($res)){
		$Final_API=$InventoryGenExits;

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
					$UT_data['DocEntry']=trim(addslashes(strip_tags($_POST['extraIssue_GI_SCRTQCB_DocEntry'])));
					$UT_data['U_PC_SIssue']=trim(addslashes(strip_tags($responce->DocEntry)));
				// <!-- ------- row data preparing end here ----------------------- -->

				$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SCRETEST_API.'('.$UT_data['DocEntry'].')';
				$underTestNumber=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data,$Final_API2);
				$underTestNumber_decode=json_decode($underTestNumber);
				

				if($underTestNumber_decode==''){
					$data['status']='True';
					$data['DocEntry']=$UT_data['DocEntry'];
					$data['message']="Post Extra Issue Successfully Added.";
					echo json_encode($data);
				}else{
					// $data['status']='False';
					// $data['DocEntry']='';
					// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
					// echo json_encode($data);

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

// if(isset($_POST['SubIT_Btn_SCRT_sample_issue']))
// {	
// 	$mainArray=array(); // This array hold all type of declare array
// 	$tdata=array(); //This array hold header data
// 	$item=array(); //This array hold item data
// 	$batch=array(); //This array hold batch data
// 	// echo "<pre>";
// 	// print_r($_POST);
// 	// echo "</pre>";
// 	// exit;

// 	$tdata['Series']=trim(addslashes(strip_tags($_POST['GI_series'])));
// 	$tdata['DocDate']=date("Y-m-d", strtotime($_POST['GI_postingDate']));
// 	$tdata['DueDate']=date("Y-m-d", strtotime($_POST['GI_DocumentDate']));
// 	$tdata['CardCode']=trim(addslashes(strip_tags($_POST['GI_supplierCode'])));
// 	$tdata['Comments']=null;
// 	$tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
// 	$tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['GI_to_whs'])));

// 	$tdata['TaxDate']=date("Y-m-d", strtotime($_POST['GI_DocumentDate']));
// 	$tdata['DocObjectCode']=trim(addslashes(strip_tags('67')));
// 	$tdata['BPLID']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId_samIss'])));
//     $tdata['U_PC_SCRtest']=trim(addslashes(strip_tags($_POST['SCRTQC_GI_SCRTQCB_DocEntry'])));
// 	// $tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['it_DocEntry'])));
// 	$tdata['U_BFType']=trim(addslashes(strip_tags($_POST['GI_baseDocType'])));

// 	$mainArray=$tdata;

// // --------------------- Item and batch row data preparing start here -------------------------------- -->
// 	$item['LineNum']=trim(addslashes(strip_tags('0')));
// 	$item['ItemCode']=trim(addslashes(strip_tags($_POST['GI_item_code'])));
// 	$item['WarehouseCode']=trim(addslashes(strip_tags($_POST['GI_to_whs'])));
// 	$item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST['GI_from_whs'])));
// 	$item['Quantity']=trim(addslashes(strip_tags($_POST['GI_quatility'])));
	
// 	// <!-- Item Batch row data prepare start here ----------- -->
// 		$BL=0;
// 		for ($i=0; $i <count($_POST['usercheckList']) ; $i++) { 

// 			if($_POST['usercheckList'][$i]=='1'){

// 				$batch['BatchNumber']=trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
// 				$batch['Quantity']=trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
// 				$batch['BaseLineNumber']=trim(addslashes(strip_tags('0')));
// 				$batch['ItemCode']=trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));

// 				$item['BatchNumbers'][]=$batch;
// 				$BL++;
// 			}
// 		}
// 	// <!-- Item Batch row data prepare end here ------------- -->
// 	$mainArray['StockTransferLines'][]=$item;
// // --------------------- Item and batch row data preparing end here ---------------------------------- -->

// 	// echo "<pre>";
// 	// print_r(json_encode($mainArray));
// 	// echo "<pre>";
// 	// exit;
// // echo json_encode($mainArray);
// // exit;
// //<!-- ------------- function & function responce code Start Here ---- -->
// 	$res=$obj->SAP_Login();  // SAP Service Layer Login Here

// 	if(!empty($res)){
// 		$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_StockTransfers;

// 		$responce_encode=$obj->SaveSampleIntimation($mainArray,$Final_API);
// 		$responce=json_decode($responce_encode);



// 		//  <!-- ------- service layer function responce manage Start Here ------------ -->
// 			$data=array();
// 			if(array_key_exists('error', (array)$responce)){
// 				$data['status']='False';
// 				$data['DocEntry']='';
// 				$data['message']=$responce->error->message->value;
// 				echo json_encode($data);
// 			}else{

// 				// <!-- ------- row data preparing start here --------------------- -->
// 					$UT_data=array();
// 					$UT_data['DocEntry']=trim(addslashes(strip_tags($_POST['SCRTQC_GI_SCRTQCB_DocEntry'])));
// 					$UT_data['U_UTTrans']=trim(addslashes(strip_tags($responce->DocEntry)));
// 				// <!-- ------- row data preparing end here ----------------------- -->

// 				$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_SCS_SINTIMATION.'('.$UT_data['DocEntry'].')';
// 				$underTestNumber=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data,$Final_API2);
// 				$underTestNumber_decode=json_decode($underTestNumber);

// 				if($underTestNumber_decode==''){
// 					$data['status']='True';
// 					$data['DocEntry']=$responce->DocEntry;
// 					$data['message']="Inventory Transfer Successfully Added.";
// 					echo json_encode($data);
// 				}else{
// 					// $data['status']='False';
// 					// $data['DocEntry']='';
// 					// $data['message']='Sample Intimation Under Test Update From Inventory Transfer Failed';
// 					// echo json_encode($data);

// 					if(array_key_exists('error', (array)$underTestNumber_decode)){
// 						$data['status']='False';
// 						$data['DocEntry']='';
// 						$data['message']=$responce->error->message->value;
// 						echo json_encode($data);
// 					}
// 				}
// 			}
// 		//  <!-- ------- service layer function responce manage End Here -------------- -->	
// 	}
	
// 	$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
// 	exit(0);
// //<!-- ------------- function & function responce code end Here ---- -->
// }


// if(isset($_POST['SCRTQCB_SCD_RevSampleIssue_Btn'])){

//    echo "<pre>";
//    print_r($_POST);
//    echo "</pre>";
// }


if(isset($_POST['action']) && $_POST['action'] =='SCRetestQcReverseSampleIsuue_ajax')
{

	$res=$obj->SAP_Login();
	// <!--------------- Get Reverse Sample issue data start here ------------------------------------------ -->
		$DocEntry=trim(addslashes(strip_tags($_POST['DocEntry'])));
        $SCRTQCB_DocEntry=trim(addslashes(strip_tags($_POST['SCRTQCB_DocEntry'])));
		
		// echo $SCRTQCB_DocEntry;
		// exit;
       // https://10.80.4.35:5 0000/b1s/v1/InventoryGenEntries
		// exit;
       // https://10.80.4.35:50000/b1s/v1/InventoryGenExits(233)
		$API=$InventoryGenExits.'('.$DocEntry.')';

		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
		$response=$objKri->getReverseSampleIssuess($FinalAPI); // get Function called here
	// <!--------------- Get Reverse Sample issue data End here -------------------------------------------- -->
        // $Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_StockTransfers;
         $response=json_decode($response);
         // echo "<pre>";
		 // print_r($response);
	  	 // echo "</pre>";

		 // exit;
	     // <!--------------- Get Series Data using Object code start here -------------------------------------- -->
		$Series_API=$INWARDQCSERIES_API.'59'; // Object Code Hardcore write
		$Series_response=$obj->get_OTFSI_SingleData($Series_API); // get Function called here
	     // <!--------------- Get Series Data using Object code end here ---------------------------------------- -->
		 // 	echo "<pre>";
		// print_r($Series_response);
		// echo "</pre>";
		// exit;
	    //  <!-- ---------- Preparing row data start here ------------------------------------------------------ -->
			$mainArray=array(); // This array hold all type of declare array
			$tdata=array(); //This array hold header data
			$item=array(); //This array hold item data
			$batch=array(); //This array hold batch data

			// <!-- --------- Header level data perparing start here ---------------- -->
				$tdata['DocType']=$response->DocType;
				$tdata['DocDate']=date("Y-m-d");
				$tdata['DocDueDate']=date("Y-m-d");
				$tdata['Series']=trim(addslashes(strip_tags($Series_response[0]->Series)));
				$tdata['TaxDate']=date("Y-m-d");
				$tdata['DocObjectCode']='oInventoryGenEntries';
				$tdata['U_PC_SCRtest']=trim(addslashes(strip_tags($SCRTQCB_DocEntry)));
				$tdata['U_BFType']='SCS_SCRETEST';
				$tdata['BPL_IDAssignedToInvoice']=trim(addslashes(strip_tags($response->BPL_IDAssignedToInvoice)));

				$mainArray=$tdata; // header level data append in this array
			// <!-- --------- Header level data perparing end here ------------------ -->
			// <!-- --------- Item Batch row data prepare start here ----------------- -->
				$item['ItemCode']=trim(addslashes(strip_tags($response->DocumentLines[0]->ItemCode)));
				$item['Quantity']=trim(addslashes(strip_tags($response->DocumentLines[0]->Quantity)));
				$item['BaseType']='60';
				$item['BaseEntry']=trim(addslashes(strip_tags($DocEntry)));
				$item['BaseLine']='0';

				$BatchNumbersArrayData=$response->DocumentLines[0]->BatchNumbers;
				// echo "<pre>";
				// echo print_r($BatchNumbersArrayData);
				// echo "</pre>";
				// exit;
				$API_batchDetals=$BATCHDETAILS.'?BaseEntry='.trim(addslashes(strip_tags($DocEntry))).'&BaseType=60';
		        $FinalAPI_batch = str_replace(' ', '%20', $API_batchDetals);
                $batch_response=$objKri->get_batchDetailsData($FinalAPI_batch);
		        // echo "<pre>";
		        // print_r($batch_response);
		        // echo "</pre>";
		        // exit
				for ($i=0; $i <count($batch_response) ; $i++) { 

					$batch['BatchNumber']=trim(addslashes(strip_tags($batch_response[$i]->BatchNum)));
					// $batch['Quantity']=trim(addslashes(strip_tags($BatchNumbersArrayData[$i]->BatchQty)));
					$batch['Quantity'] = (int)trim(addslashes(strip_tags($batch_response[$i]->Quantity))); 
					$batch['ItemCode']=trim(addslashes(strip_tags($batch_response[$i]->ItemCode)));
					$item['BatchNumbers'][]=$batch; // Batch data append in this array
				}
			// <!-- --------- Item Batch row data prepare end here ------------------- -->
			$mainArray['DocumentLines'][]=$item; // Item data append in this array
	//  <!-- ---------- Preparing row data end here -------------------------------------------------------- -->
            // echo "<pre>";
			// echo json_encode($mainArray);
			// echo "</pre>";
			// exit;
			
	//<!-- ------------- function & function responce code Start Here ---- -->
	  // SAP Service Layer Login Here
// https://10.80.4.35:50000/b1s/v1/InventoryGenEntries
	if(!empty($res)){
		$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$API_InventoryGenEntries;

		$responce_encode=$obj->SaveSampleIntimation($mainArray,$Final_API);
		$responce=json_decode($responce_encode);

		     // echo "<pre>";
			 // echo print_r($responce);
			 // echo "</pre>";
			 // exit;

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
					$UT_data['DocEntry']=trim(addslashes(strip_tags($DocEntry)));
					$UT_data['U_PC_RSIssue']=trim(addslashes(strip_tags($responce->DocEntry)));
				// <!-- ------- row data preparing end here ----------------------- -->

				$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SCRETEST_API.'('.$UT_data['DocEntry'].')';
				$underTestNumber=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data,$Final_API2);
				$underTestNumber_decode=json_decode($underTestNumber);

				 // echo "<pre>";
				 // echo "hiii";
			     // echo print_r($underTestNumber_decode);
			     // echo "</pre>";
			     // exit;

				if($underTestNumber_decode==''){
					$data['status']='True';
					$data['DocEntry']=$responce->DocEntry;
					$data['message']="Reverse Sample Issue Successfully.";
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


// ===============================================



if(isset($_POST['action']) && $_POST['action'] =='kri_SC_OpenInventoryTransferCS_sample_issue_ajax'){

	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs=trim(addslashes(strip_tags($_POST['FromWhs'])));
	$GRPODEnt=trim(addslashes(strip_tags($_POST['GRPODEnt'])));
	$BNo=trim(addslashes(strip_tags($_POST['BNo'])));

// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API=$RETESTQCSAMPLECOLLCONTSEL.'?ItemCode='.$ItemCode.'&WareHouse='.$FromWhs.'&BatchNo='.$BNo;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
// <!--------------- Preparing API End Here ------------------------------------------ -->
		// print_r($FinalAPI);
		// echo "hiii";
		// die();


	$response=$objKri->get_container_SingleData($FinalAPI);

	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;

// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if(!empty($response)){

		for ($i=0; $i <count($response) ; $i++) { 

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


			$option.='
			<tr>
				<td style="text-align: center;">
					<input type="hidden" id="usercheckList'.$i.'" name="usercheckList[]" value="0">
					<input class="form-check-input" type="checkbox" value="'.$response[$i]->BatchQty.'" id="itp_CS'.$i.'" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener_goodsIssue('.$i.')">
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





if(isset($_POST['action']) && $_POST['action'] =='kri_SC_OpenInventoryTransferCS_extra_issue_ajax'){

	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs=trim(addslashes(strip_tags($_POST['FromWhs'])));
	$GRPODEnt=trim(addslashes(strip_tags($_POST['GRPODEnt'])));
	$BNo=trim(addslashes(strip_tags($_POST['BNo'])));

// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API=$RETESTQCSAMPLECOLLCONTSEL.'?ItemCode='.$ItemCode.'&WareHouse='.$FromWhs.'&BatchNo='.$BNo;
	$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
// <!--------------- Preparing API End Here ------------------------------------------ -->
		// print_r($FinalAPI);
		// echo "hiii";
		// die();


	$response=$objKri->get_container_SingleData($FinalAPI);

	// echo "<pre>";
	// print_r($response);
	// echo "</pre>";
	// exit;

// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if(!empty($response)){

		for ($i=0; $i <count($response) ; $i++) { 

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


			$option.='
			<tr>
				<td style="text-align: center;">
					<input type="text" id="usercheckList'.$i.'" name="usercheckList[]" value="0">
					<input class="form-check-input" type="checkbox" value="'.$response[$i]->BatchQty.'" id="itp_CS'.$i.'" name="itp_CS[]" style="width: 17px;height: 17px;" onclick="getSelectedContener_extraIssue('.$i.')">
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
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty'.$i.'" name="itp_BatchQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" readonly>
				</td>
				<td>
					<input class="border_hide" type="text" id="SelectedQty'.$i.'" name="SelectedQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" onfocusout="EnterQtyValidation_extraIssue('.$i.')">
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



// --

if(isset($_POST['SampleCollectionRetestQCUpdateForm_Btn']))
{
	// <!-- ------------ array declare Here ------------- -->
		$mainArray=array();
		$ExternalIssue=array();
		$ExtraIssue=array();
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		// exit;
	// <!-- ------------ array declare Here ------------- -->

		$tdata['Series']=trim(addslashes(strip_tags($_POST['SCRTQCB_Series'])));
		$tdata['U_PC_BLin']=trim(addslashes(strip_tags($_POST['SCRTQCB_GRNLineNo'])));
		$tdata['U_PC_InTyp']=trim(addslashes(strip_tags($_POST['SCRTQCB_IngrediantType'])));
		$tdata['U_PC_GRNNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_GRNNo'])));
		$tdata['U_PC_GRNEnt']=trim(addslashes(strip_tags($_POST['SCRTQCB_GRNDocEntry'])));
		$tdata['U_PC_Loc']=trim(addslashes(strip_tags($_POST['SCRTQCB_Location'])));
		$tdata['U_PC_InBy']=trim(addslashes(strip_tags($_POST['SCRTQCB_IntimatedBy'])));

		if(!empty($_POST['SCRTQCB_IntimationDate'])){
			$tdata['U_PC_InDt']=date("Y-m-d", strtotime($_POST['SCRTQCB_IntimationDate']));	
		}else{
			$tdata['U_PC_InDt']=null;
		}
		
		$tdata['U_PC_SQty']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleQty'])));
		$tdata['U_PC_SUnit']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleQtyUnit'])));

		$tdata['U_PC_SCBy']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleCollBy'])));
		$tdata['U_PC_ARNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_ARNo'])));
		if(!empty($_POST['SCRTQCB_DocDate'])){
			$tdata['U_PC_DDt']=date("Y-m-d", strtotime($_POST['SCRTQCB_DocDate']));
		}else{
			$tdata['U_PC_DDt']=null;
		}

		$tdata['U_PC_TrNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_TRNo'])));
		$tdata['U_PC_Branch']=trim(addslashes(strip_tags($_POST['SCRTQCB_Branch'])));
		$tdata['U_PC_ICode']=trim(addslashes(strip_tags($_POST['SCRTQCB_ItemCode'])));
		$tdata['U_PC_IName']=trim(addslashes(strip_tags($_POST['SCRTQCB_ItemName'])));
		$tdata['U_PC_BNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_BatchNo'])));
		$tdata['U_PC_BtchQty']=trim(addslashes(strip_tags($_POST['SCRTQCB_BatchQty'])));
		$tdata['U_PC_NoCont']=trim(addslashes(strip_tags($_POST['SCRTQCB_NoOfContainer'])));
		$tdata['U_PC_UTNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_UTTNo'])));

		if(!empty($_POST['SCRTQCB_SCD_DateOfRever'])){
			$tdata['U_PC_DRev']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_DateOfRever'])));
		}else{
			$tdata['U_PC_DRev']=null;
		}
	
		
       if(!empty($_POST['SCRTQCB_SCD_SampleIssue'])){
			$tdata['U_PC_SIssue']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_SampleIssue'])));
		}else{
			$tdata['U_PC_SIssue']=null;
		}


        if(!empty($_POST['SCRTQCB_SCD_RevSampleIssue'])){
			$tdata['U_PC_RSIssue']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_RevSampleIssue'])));
		}else{
			$tdata['U_PC_RSIssue']=null;
		}


		if(!empty($_POST['SCRTQCB_SCD_RetainIssue'])){
			$tdata['U_PC_RIssue']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_RetainIssue'])));
		}else{
			$tdata['U_PC_RIssue']=null;
		}



		$tdata['U_PC_RQty']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_RetQty'])));
		$tdata['U_PC_RQtUom']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_RetUoM'])));
		$tdata['U_PC_CntNo1']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_Cont1'])));
		$tdata['U_PC_CntNo2']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_Cont2'])));
		$tdata['U_PC_CntNo3']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_Cont3'])));

		$tdata['U_PC_QtyLab']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_QtyForLabel'])));
		$tdata['U_PC_Trans']=null;

		$tdata['U_PC_BPLId']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId'])));
		$tdata['U_PC_LocCode']=trim(addslashes(strip_tags($_POST['SCRTQCB_LocCode'])));
		//$tdata['U_PC_SRSep']=trim(addslashes(strip_tags('No')));  //'No' value
// $_POST['SCRTQCB_SampleReSep']

   //      if($_POST['SCRTQCB_SampleReSep']==""){
	  //       $data['status']='False';
			// $data['DocEntry']='';
			// $data['message']="Sample Recieved Sepretly required";
			// echo json_encode($data);
			// exit;
   //      }


		$tdata['U_PC_SType']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleType'])));
		$mainArray=$tdata; // header data append on main array
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit;
	// <!-- ------------------------ External Issue row data preparing start here ----------------------- --> 
		for ($i=0; $i <=count($_POST['SC_FEXI_SupplierName']) ; $i++) { 
			// SC_ExternalI_SupplierCode
			// SC_FEXI_SupplierCode
			
			$ExternalIssue['LineId']=trim(addslashes(strip_tags(($i+1))));
			$ExternalIssue['U_PC_SCode']=trim(addslashes(strip_tags($_POST['SC_FEXI_SupplierCode'][$i]))); 
			$ExternalIssue['U_PC_SName']=trim(addslashes(strip_tags($_POST['SC_FEXI_SupplierName'][$i])));
			$ExternalIssue['U_PC_UOM']=trim(addslashes(strip_tags($_POST['SC_FEXI_UOM'][$i])));
			
			$ExternalIssue['U_PC_SDate']=(!empty($_POST['SC_FEXI_SampleDate'][$i]))? date("Y-m-d", strtotime($_POST['SC_FEXI_SampleDate'][$i])) : null;;

			

			$ExternalIssue['U_PC_Whs']=trim(addslashes(strip_tags($_POST['SC_FEXI_Warehouse'][$i])));
			$ExternalIssue['U_PC_SQty1']=trim(addslashes(strip_tags($_POST['SC_FEXI_SampleQuantity'][$i])));
			$ExternalIssue['U_PC_Attch']=trim(addslashes(strip_tags($_POST['SC_FEXI_Attachment'][$i])));
			$ExternalIssue['U_PC_UTxt1']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText1'][$i])));
			$ExternalIssue['U_PC_UTxt2']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText2'][$i])));
			$ExternalIssue['U_PC_UTxt3']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText3'][$i])));
			// $ExternalIssue['U_PC_Trans']=trim(addslashes(strip_tags($_POST['SC_FEXI_InventoryTransfer'][$i])));

			if(!empty($_POST['SC_FEXI_InventoryTransfer'][$i])){
				$ExternalIssue['U_PC_Trans']=trim(addslashes(strip_tags($_POST['SC_FEXI_InventoryTransfer'][$i])));

			}else{
				$ExternalIssue['U_PC_Trans']=null;	
			}

			
			// if(!empty($_POST['SC_FEXI_SampleDate'][$i])){
			// 	$ExternalIssue['U_PC_SD']=date("Y-m-d", strtotime($_POST['SC_FEXI_SampleDate'][$i]));
			// }else{
			// 	$ExternalIssue['U_PC_SD']=null;	
			// }

			$mainArray['SCS_SCRETEST1Collection'][]=$ExternalIssue;
		}
	// <!-- ------------------------ External Issue row data preparing start here ----------------------- --> 

	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 
		for ($j=0; $j <count($_POST['SC_FEI_SampleQuantity']) ; $j++) { 
			if(!empty($_POST['SC_FEI_SampleQuantity'][$j])){
				$ExtraIssue['LineId']=trim(addslashes(strip_tags(($j+1))));
				$ExtraIssue['U_PC_SQty2']=trim(addslashes(strip_tags($_POST['SC_FEI_SampleQuantity'][$j])));
				$ExtraIssue['U_PC_UOM']=trim(addslashes(strip_tags($_POST['SC_FEI_UOM'][$j])));
				$ExtraIssue['U_PC_Whs']=trim(addslashes(strip_tags($_POST['SC_FEI_Warehouse'][$j])));
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
			}else{
				$mainArray['SCS_SCRETEST2Collection']=array();
			}
			
		}
	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 
	//print_r(json_encode($mainArray));die();
	// echo "<pre>";
	// print_r($mainArray);
	// echo "</pre>";
	// exit;
		
	//<!-- ------------- function & function responce code Start Here ---- -->
		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

		if(!empty($res)){

			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SCRETEST_API.'('.$_POST['SCRTQCB_DocEntry'].')';
			$responce_encode=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($mainArray,$Final_API);
			$responce=json_decode($responce_encode);
			// echo "<pre>";
		    // print_r($responce_encode);
		    // echo "</pre>";
		    // exit;
		    // die();
			if($responce==''){
				$data['status']='True';
				$data['DocEntry']=$_POST['SCRTQCB_DocEntry'];
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



if(isset($_POST['action']) && $_POST['action'] =='qc_post_document_pupup_ajax'){
	// <!-- ------- Replace blank space to %20 start here -------- -->
		$QCstatus=trim(addslashes(strip_tags($_POST['QCstatus'])));
		$API=$INWARDQCPOSTDOCUMENTDETAILS.'?DocEntry='.$_POST['DocEntry'].'&Status='.$QCstatus;

		$FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
	// <!-- ------- Replace blank space to %20 End here -------- -->
	// print_r($API);
	// die();
	$response=$objKri->get_QcPostDocument_SingleData($FinalAPI);
	echo json_encode($response);
	exit(0);
}


if(isset($_POST['action']) && $_POST['action'] =='getInventorycotainerSelection_ajax'){

	$ItemCode=trim(addslashes(strip_tags($_POST['ItemCode'])));
	$FromWhs=trim(addslashes(strip_tags($_POST['WareHouse'])));
	// $GRPODEnt=trim(addslashes(strip_tags($_POST['GRPODEnt'])));
	$BNo=trim(addslashes(strip_tags($_POST['BatchNo'])));
// ItemCode=A00116&WareHouse=QCUT-GEN&BatchNo=BT2106-2
// <!--------------- Preparing API Start Here ------------------------------------------ -->
	$API=$RETESTQCPOSTDOCUMENTCONTSEL.'?ItemCode='.$ItemCode.'&WareHouse='.$FromWhs.'&BatchNo='.$BNo;
    $FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
// <!--------------- Preparing API End Here ------------------------------------------ -->
	// print_r($API);
	// die();
	$response=$objKri->get_QCContainer_SingleData($FinalAPI);
	// echo "<pre>";
	// print_r($response);
	// echo "<pre>";
	// exit;

// <!-- --------- Item HTML Table Body Prepare Start Here ------------------------------ --> 
	if(!empty($response)){

		for ($i=0; $i <count($response) ; $i++) { 

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
					<input class="border_hide textbox_bg" type="text" id="itp_Batche'.$i.'" name="itp_Batch[]" class="form-control" value="'.$response[$i]->BatchNum.'" readonly>
				</td>

				<td class="desabled">
					<input class="border_hide textbox_bg" type="text" id="itp_BatchQty'.$i.'" name="itp_BatchQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" readonly>


				</td>

				
				<td style="text-align: center;">
				   <input class="border_hide" type="text" id="SelectedQty'.$i.'" name="SelectedQty[]" class="form-control" value="'.number_format((float)$response[$i]->BatchQty, 6, '.', '').'" onfocusout="EnterQtyValidation_GI('.$i.')" style="border: transparent !important;">

				  
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

if(isset($_POST['SC_SubIT_Btn_post_doc'])){
	$mainArray=array(); // This array hold all type of declare array
	$tdata=array(); //This array hold header data
	$item=array(); //This array hold item data
	$batch=array(); //This array hold batch data

	$tdata['Series']=trim(addslashes(strip_tags($_POST['it_Series'])));
	$tdata['DocDate']=date("Y-m-d", strtotime($_POST['it_postingDate']));
	$tdata['DueDate']=date("Y-m-d", strtotime($_POST['it_documentDate']));
	$tdata['CardCode']=trim(addslashes(strip_tags($_POST['it_SupplierCode'])));
	$tdata['Comments']=null;
	$tdata['FromWarehouse']=trim(addslashes(strip_tags($_POST['from_whs'])));
	$tdata['ToWarehouse']=trim(addslashes(strip_tags($_POST['to_whs'])));
	$tdata['TaxDate']=date("Y-m-d", strtotime($_POST['it_documentDate']));
	$tdata['DocObjectCode']=trim(addslashes(strip_tags('67')));
	$tdata['BPLID']=trim(addslashes(strip_tags($_POST['BranchId'])));
	$tdata['U_PC_SIntiNo']=trim(addslashes(strip_tags($_POST['_DocEntry'])));
	$tdata['U_BFType']='SCS_QCPD'; // HardCoded for QC POST Document Inventory transfer form

	$mainArray=$tdata;

	// --------------------- Item and batch row data preparing start here -------------------------------- -->
		$item['LineNum']=trim(addslashes(strip_tags('0')));
		$item['ItemCode']=trim(addslashes(strip_tags($_POST['tb_itme_code'])));
		$item['WarehouseCode']=trim(addslashes(strip_tags($_POST['to_whs'])));
		$item['FromWarehouseCode']=trim(addslashes(strip_tags($_POST['from_whs'])));
		$item['Quantity']=trim(addslashes(strip_tags($_POST['tb_quality'])));

		// <!-- Item Batch row data prepare start here ----------- -->
			for ($i=0; $i <count($_POST['usercheckList']) ; $i++){
				if($_POST['usercheckList'][$i]=='1'){
					$batch['BatchNumber']=trim(addslashes(strip_tags($_POST['itp_ContainerNo'][$i])));
					$batch['Quantity']=trim(addslashes(strip_tags($_POST['SelectedQty'][$i])));
					$batch['BaseLineNumber']=trim(addslashes(strip_tags('0')));
					$batch['ItemCode']=trim(addslashes(strip_tags($_POST['itp_ItemCode'][$i])));

					$batch['U_PC_APot']=trim(addslashes(strip_tags($_POST['QC_IT_AssayPotency'])));
					$batch['U_PC_LODWater']=trim(addslashes(strip_tags($_POST['QC_IT_LoD_Water'])));
					$batch['U_PC_Potency']=trim(addslashes(strip_tags($_POST['QC_IT_potency'])));
					$batch['U_PC_AsyCal']=trim(addslashes(strip_tags($_POST['QC_IT_assay_append'])));
					$batch['U_PC_Factor']=trim(addslashes(strip_tags($_POST['QC_IT_factor'])));
					$batch['U_PC_RDate']=(!empty($_POST['QC_IT_RetestDate'])? date("Y-m-d", strtotime($_POST['QC_IT_RetestDate'])):null);
					$batch['U_PC_ARNo']=trim(addslashes(strip_tags($_POST['QC_IT_ARNo'])));

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

			$responce_encode=$objKri->SaveSampleIntimation_kris($mainArray,$Final_API);
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
						$UT_data = [
							'DocEntry' => $_POST['_DocEntry'],
							'SCS_QCPD2Collection' => [
								[	
									'LineId' => $_POST['QC_Status_LineId'],
									'DocEntry' => $_POST['_DocEntry'],
									'U_ITNo' => $responce->DocEntry
								]
							]
						];
					// <!-- ------- row data preparing end here ----------------------- -->

					$Final_API2=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$api_SCS_QCPD.'('.$_POST['_DocEntry'].')';
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
	//<!-- ------------- function & function responce code end Here ------ -->
}


// if(isset($_POST['SampleCollectionRetestQCUpdateForm_Btn']))
// {
// 	// <!-- ------------ array declare Here ------------- -->
// 		$mainArray=array();
// 		$ExternalIssue=array();
// 		$ExtraIssue=array();
// 	// <!-- ------------ array declare Here ------------- -->

// 		$tdata['Series']=trim(addslashes(strip_tags($_POST['SCRTQCB_Series'])));
// 		$tdata['U_PC_BLin']=trim(addslashes(strip_tags($_POST['SCRTQCB_GRNLineNo'])));
// 		$tdata['U_PC_InTyp']=trim(addslashes(strip_tags($_POST['SCRTQCB_IngrediantType'])));
// 		$tdata['U_PC_GRNNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_GRNNo'])));
// 		$tdata['U_PC_GRNEnt']=trim(addslashes(strip_tags($_POST['SCRTQCB_GRNDocEntry'])));
// 		$tdata['U_PC_Loc']=trim(addslashes(strip_tags($_POST['SCRTQCB_Location'])));
// 		$tdata['U_PC_InBy']=trim(addslashes(strip_tags($_POST['SCRTQCB_IntimatedBy'])));
// 		$tdata['U_PC_SQty']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleQty'])));
// 		$tdata['U_PC_SCBy']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleCollBy'])));
// 		$tdata['U_PC_ARNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_ARNo'])));
// 		$tdata['U_PC_TrNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_TRNo'])));
// 		$tdata['U_PC_Branch']=trim(addslashes(strip_tags($_POST['SCRTQCB_Branch'])));
// 		$tdata['U_PC_ICode']=trim(addslashes(strip_tags($_POST['SCRTQCB_ItemCode'])));
// 		$tdata['U_PC_IName']=trim(addslashes(strip_tags($_POST['SCRTQCB_ItemName'])));
// 		$tdata['U_PC_BNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_BatchNo'])));
// 		$tdata['U_PC_BtchQty']=trim(addslashes(strip_tags($_POST['SCRTQCB_BatchQty'])));
// 		$tdata['U_PC_NoCont']=trim(addslashes(strip_tags($_POST['SCRTQCB_NoOfContainer'])));
// 		$tdata['U_PC_UTNo']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_UTTNo'])));
// 		$tdata['U_PC_SIssue']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_SampleIssue'])));
// 		$tdata['U_PC_RSIssue']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_RevSampleIssue'])));
// 		$tdata['U_PC_RIssue']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_RetainIssue'])));
// 		$tdata['U_PC_RQty']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_RetQty'])));
// 		$tdata['U_PC_RQtUom']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_RetUoM'])));
// 		$tdata['U_PC_CntNo1']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_Cont1'])));
// 		$tdata['U_PC_CntNo2']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_Cont2'])));
// 		$tdata['U_PC_CntNo3']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_Cont3'])));
// 		$tdata['U_PC_QtyLab']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_QtyForLabel'])));
// 		$tdata['U_PC_BPLId']=trim(addslashes(strip_tags($_POST['SCRTQCB_BPLId'])));
// 		$tdata['U_PC_LocCode']=trim(addslashes(strip_tags($_POST['SCRTQCB_LocCode'])));
// 		$tdata['U_PC_SRSep']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleReSep'])));

// 		if(!empty($_POST['SCRTQCB_IntimationDate'])){
// 			$tdata['U_PC_InDt']=date("Y-m-d", strtotime($_POST['SCRTQCB_IntimationDate']));	
// 		}else{
// 			$tdata['U_PC_InDt']=null;
// 		}

// 		if(!empty($_POST['SCRTQCB_DocDate'])){
// 			$tdata['U_PC_DDt']=date("Y-m-d", strtotime($_POST['SCRTQCB_DocDate']));
// 		}else{
// 			$tdata['U_PC_DDt']=null;
// 		}

// 		if(!empty($_POST['SCRTQCB_SCD_DateOfRever'])){
// 			$tdata['U_PC_DRev']=trim(addslashes(strip_tags($_POST['SCRTQCB_SCD_DateOfRever'])));
// 		}else{
// 			$tdata['U_PC_DRev']=null;
// 		}

// 		$tdata['U_PC_SUnit']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleQtyUnit'])));
// 		$tdata['U_PC_Trans']=null;
// 		$tdata['U_PC_SType']=trim(addslashes(strip_tags($_POST['SCRTQCB_SampleType'])));


// 		$mainArray=$tdata; // header data append on main array

// 	// <!-- ------------------------ External Issue row data preparing start here ----------------------- --> 
// 		for ($i=0; $i <count($_POST['SC_FEXI_SupplierName']) ; $i++) { 

// 			$ExternalIssue['LineId']=trim(addslashes(strip_tags(($i+1))));
// 			$ExternalIssue['U_PC_SCode']=trim(addslashes(strip_tags($_POST['SC_ExternalI_SupplierCode'][$i]))); 
// 			$ExternalIssue['U_PC_SName']=trim(addslashes(strip_tags($_POST['SC_FEXI_SupplierName'][$i])));
// 			$ExternalIssue['U_PC_UOM']=trim(addslashes(strip_tags($_POST['SC_FEXI_UOM'][$i])));
// 			$ExternalIssue['U_PC_Whs']=trim(addslashes(strip_tags($_POST['SC_ExternalI_Warehouse'][$i])));
// 			$ExternalIssue['U_PC_SQty1']=trim(addslashes(strip_tags($_POST['SC_FEXI_SampleQuantity'][$i])));
// 			$ExternalIssue['U_PC_Attch']=trim(addslashes(strip_tags($_POST['SC_FEXI_Attachment'][$i])));
// 			$ExternalIssue['U_PC_UTxt1']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText1'][$i])));
// 			$ExternalIssue['U_PC_UTxt2']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText2'][$i])));
// 			$ExternalIssue['U_PC_UTxt3']=trim(addslashes(strip_tags($_POST['SC_FEXI_UserText3'][$i])));

// 			if(!empty($_POST['SC_FEXI_SampleDate'][$i])){
// 				$ExternalIssue['U_PC_SD']=date("Y-m-d", strtotime($_POST['SC_FEXI_SampleDate'][$i]));
// 			}else{
// 				$ExternalIssue['U_PC_SD']=null;	
// 			}

// 			$mainArray['SCS_SCRETEST1Collection'][]=$ExternalIssue;
// 		}
// 	// <!-- ------------------------ External Issue row data preparing start here ----------------------- --> 

// 	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 
// 		for ($j=0; $j <count($_POST['SC_FEI_SampleQuantity']) ; $j++) { 

// 			$ExtraIssue['LineId']=trim(addslashes(strip_tags(($j+1))));
// 			$ExtraIssue['U_PC_SQty2']=trim(addslashes(strip_tags($_POST['SC_FEI_SampleQuantity'][$j])));
// 			$ExtraIssue['U_PC_UOM']=trim(addslashes(strip_tags($_POST['SC_FEI_UOM'][$j])));
// 			$ExtraIssue['U_PC_Whs']=trim(addslashes(strip_tags($_POST['SC_ExternalI_SupplierCode'][$j])));
// 			$ExtraIssue['U_PC_SBy']=trim(addslashes(strip_tags($_POST['SC_FEI_SampleBy'][$j])));

// 			if(!empty($_POST['SC_FEI_IssueDate'][$j])){
// 				$ExtraIssue['U_PC_IDate']=date("Y-m-d", strtotime($_POST['SC_FEI_IssueDate'][$j]));
// 			}else{
// 				$ExtraIssue['U_PC_IDate']=null;	
// 			}

// 			if(!empty($_POST['SC_FEI_PostExtraIssue'][$j])){
// 				$ExtraIssue['U_PC_PEIsu']=trim(addslashes(strip_tags($_POST['SC_FEI_PostExtraIssue'][$j])));
// 			}else{
// 				$ExtraIssue['U_PC_PEIsu']=null;
// 			}

// 			$mainArray['SCS_SCRETEST2Collection'][]=$ExtraIssue;
// 		}
// 	// <!-- ------------------------ Extra Issue row data preparing start here ----------------------- --> 
// // print_r(json_encode($mainArray));die();

// 		// echo "<pre>";
// 		// print_r($mainArray);
// 		// echo "</pre>";
// 		// exit;
// 	//<!-- ------------- function & function responce code Start Here ---- -->
// 		$res=$obj->SAP_Login();  // SAP Service Layer Login Here

// 		if(!empty($res)){

// 			$Final_API=$SAP_URL . ":" . $SAP_Port . "/b1s/v1/".$SCS_SCRETEST_API.'('.$_POST['SCRTQCB_DocEntry'].')';
// 			$responce_encode=$obj->SampleIntimationUnderTestUpdateFromInventoryTransfer($mainArray,$Final_API);
// 			$responce=json_decode($responce_encode);

// 			if($responce==''){
// 				$data['status']='True';
// 				$data['DocEntry']=$responce->DocEntry;
// 				$data['message']="Sample Collection - Retest QC Successfully Update.";
// 				echo json_encode($data);
// 			}else{

// 				if(array_key_exists('error', (array)$responce)){
// 					$data['status']='False';
// 					$data['DocEntry']='';
// 					$data['message']=$responce->error->message->value;
// 					echo json_encode($data);
// 				}
// 			}
// 		}
		
// 		$res1=$obj->SAP_Logout();  // SAP Service Layer Logout Here	
		
// 	//<!-- ------------- function & function responce code end Here ---- -->

// 	exit(0);
// }

