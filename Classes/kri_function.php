<?php
require_once 'config.php';

class webKri {

	function __construct() {

	}

	public function getInwardQCCollection($INWARDQCPOSTDOCUMENTDETAILS,$tdata)
	{
		if($tdata['FromDate']=='19700101'){
			$FromDate='';
		}else{
			$FromDate='FromDate='.date('Ymd', strtotime($tdata['FromDate'])).'&';
		}

		if($tdata['ToDate']=='19700101'){
			$ToDate='';
		}else{
			$ToDate='ToDate='.date('Ymd', strtotime($tdata['ToDate'])).'&';
		}

		if(empty($tdata['DocEntry'])){
			$DocEntry='';
		}else{
			$DocEntry='DocEntry='.$tdata['DocEntry'].'&';
		}


	$API=$INWARDQCPOSTDOCUMENTDETAILS.'?'.$FromDate.$ToDate.$DocEntry;

		$removeDoller = rtrim($API, "&"); // URL last & symbole remove
		$stripped = rtrim($removeDoller, "?"); // URL last ? symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);die();
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);

		return $reponce;
	}

	public function get_batchDetailsData($FinalAPI)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FinalAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);
    
		return $reponce;
    }


public function getQCREtestCollection($RETESTQCPOSTDOCUMENTDETAILS,$tdata)
	{
		if($tdata['FromDate']=='19700101'){
			$FromDate='';
		}else{
			$FromDate='FromDate='.date('Ymd', strtotime($tdata['FromDate'])).'&';
		}

		if($tdata['ToDate']=='19700101'){
			$ToDate='';
		}else{
			$ToDate='ToDate='.date('Ymd', strtotime($tdata['ToDate'])).'&';
		}

		if(empty($tdata['DocEntry'])){
			$DocEntry='';
		}else{
			$DocEntry='DocEntry='.$tdata['DocEntry'].'&';
		}


		$API=$RETESTQCPOSTDOCUMENTDETAILS.'?'.$FromDate.$ToDate.$DocEntry;

		$removeDoller = rtrim($API, "&"); // URL last & symbole remove
		$stripped = rtrim($removeDoller, "?"); // URL last ? symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);die();
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);

		return $reponce;
	}




  public function get_QcPostDocument_SingleData($FinalAPI)
	{
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FinalAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);

		return $reponce;
	}
  public function get_QcPostDocument_RetestQcSingleData($FinalAPI)
	{
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FinalAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);

		return $reponce;
	}

	public function GetMethodQuerryBasedAPI_($Final_API){
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $Final_API,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
    }

	public function GetRowLevelAnalysisByDropdown($Final_API){
		$response_json_decode=$this->GetMethodQuerryBasedAPI_($Final_API);
		$response=json_decode($response_json_decode);

		return $response;
	}





	public function get_assay_Calculation_Based_On_dropdown($FinalAPI)
	{
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FinalAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);

		return $reponce;
	}


	public function get_SAMINTTRBY($FinalAPI)
	{
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FinalAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);

		return $reponce;
	}

	public function qcPostDocument($tdata,$Final_API)
  {
		$postdata = json_encode($tdata);
		$sessionId =$_SESSION['BaroqueSAP_SessionId'];
		$routeId = ".node2";
		$headers[] = "Cookie: B1SESSION=" . $sessionId . "; ROUTEID=" . $routeId . ";";

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_URL, $Final_API);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($curl);

		return $response;
  }


  public function get_RetestQcContainer_SingleData($FinalAPI)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FinalAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);
    
		return $reponce;
    }

    public function get_QCContainer_SingleData($FinalAPI)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FinalAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);
    
		return $reponce;
    }


  public function getFunctionServiceLayer($Final_API)
  {
		$sessionId =$_SESSION['BaroqueSAP_SessionId'];
		$routeId = ".node2";
		$headers[] = "Cookie: B1SESSION=" . $sessionId . "; ROUTEID=" . $routeId . ";";

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_URL, $Final_API);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($curl);

		return $response;
  }


public function getQcPostDocumentRetestQc($RETESTQCPOSTDOC)
	{
		
		// if(empty($tdata['DocEntry'])){
		// 	$DocEntry='';
		// }else{
		// 	$DocEntry='DocEntry='.$tdata['DocEntry'].'&';
		// }

		// .'?'.$DocEntry

		$API=$RETESTQCPOSTDOC;

		$removeDoller = rtrim($API, "&"); // URL last & symbole remove
		$stripped = rtrim($removeDoller, "?"); // URL last ? symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
// print_r($Final_url);die();
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);

		return $reponce;
	}


  public function get_QcRetest_SingleData($FinalAPI)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FinalAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);
    
		return $reponce;
    }


public function get_RetestGeneralData_SingleData($FinalAPI)
	{
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FinalAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);

		return $reponce;
	}


	public function qcPostDocumentRetestQc($tdata,$Final_API)
  {
		$postdata = json_encode($tdata);
		$sessionId =$_SESSION['BaroqueSAP_SessionId'];
		$routeId = ".node2";
		$headers[] = "Cookie: B1SESSION=" . $sessionId . "; ROUTEID=" . $routeId . ";";

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_URL, $Final_API);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($curl);

		return $response;
  }


  public function SaveSampleIntimation_kris($tdata,$Final_API)
    {
		$postdata = json_encode($tdata);

		$sessionId =$_SESSION['BaroqueSAP_SessionId'];
		$routeId = ".node2";
		$headers[] = "Cookie: B1SESSION=" . $sessionId . "; ROUTEID=" . $routeId . ";";

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_URL, $Final_API);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($curl);

		return $response;
    }

    public function SampleIntimationUnderTestUpdateFromInventoryTransfer_kri($UT_data,$Final_API2)
    {
		$postdata = json_encode($UT_data);

		$sessionId =$_SESSION['BaroqueSAP_SessionId'];
		$routeId = ".node2";
		$headers[] = "Cookie: B1SESSION=" . $sessionId . "; ROUTEID=" . $routeId . "; B1S-ReplaceCollectionsOnPatch= true";

		// B1S-ReplaceCollectionsOnPatch: true'

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_URL, $Final_API2);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($curl);

		return $response;
    }

    public function getReverseSampleIssuess($Final_API)
    {
		$sessionId =$_SESSION['BaroqueSAP_SessionId'];
		$routeId = ".node2";
		$headers[] = "Cookie: B1SESSION=" . $sessionId . "; ROUTEID=" . $routeId . ";";

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_URL, $Final_API);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$response = curl_exec($curl);

		return $response;
    }


    public function get_container_SingleData($FinalAPI)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FinalAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);
    
		return $reponce;
    }



     public function getAnyDorpDownMasterFun_kri($Final_API)
    {
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$Final_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);

		if(!empty($reponce)){
			
			$Default=$reponce[0]->Default; // Selection default value store 
           $option = '<option value="">Select</option>';
			for ($i=0; $i < count($reponce) ; $i++) { 
				if (!empty($reponce[$i]->FldValue)) {

					if($Default==$reponce[$i]->Description){
						$option .= '<option value="'.$reponce[$i]->FldValue.'" selected>'.$reponce[$i]->Description.'</option>';
					}else{
						$option .= '<option value="'.$reponce[$i]->FldValue.'">'.$reponce[$i]->Description.'</option>';
					}
				}
			}  
		}
		    
		return $option;
    }
  
}