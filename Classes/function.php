<?php
require_once 'config.php';
$option ='';
class Web {

    function __construct() {
       
    }

    // ---------------------------- SAP DB CAlled Function Start Here -----------------------------------------
	public function SAP_Login()
    {
        // $params = ["UserName" => "232",
        //     "Password" => "1234",
        //     // "CompanyDB" => "BAROQUE_SCS05092022",  //55 - Server
        //     "CompanyDB" => "BAROQUE_SCS", // 1.30 - Live Test MIS- Baroque server
        // ];

        $params = ["UserName" => "manager",
            "Password" => "Soft@3333",
            "CompanyDB" => "BRQ_LIVE",
        ];

        // $params = ["UserName" => "BAIT01",
        //     "Password" => "Admin@123",
        //     "CompanyDB" => "BRQ_LIVE",
        // ];
        
        // sofT@3333

        $curl = curl_init();
		// curl_setopt($curl, CURLOPT_URL, "https://10.80.4.35:50000/b1s/v1/Login"); // 55 Server - Service SAP layer login 
		curl_setopt($curl, CURLOPT_URL, "https://192.168.1.32:50000/b1s/v1/Login"); // Live -Service SAP layer login 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));

        $response = curl_exec($curl);

        $responce_decode=json_decode($response);
        $_SESSION['BaroqueSAP_SessionId'] =$responce_decode->SessionId;

        curl_close($curl);
        return $responce_decode;
    }
    
	public function SAP_Logout()
    {
        $curl = curl_init();
		// curl_setopt($curl, CURLOPT_URL, "https://10.80.4.35:50000/b1s/v1/Logout"); // 55 Server - Service SAP layer logout 
		curl_setopt($curl, CURLOPT_URL, "https://192.168.1.32:50000/b1s/v1/Logout"); // 55 Server - Service SAP layer logout 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_POST, true);
    
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
// ---------------------------- SAP DB CAlled Function End Here -----------------------------------------

    public function GetMethodQuerryBasedAPI($Final_API){
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

    public function get_OTFSI_Data($OPNTRANSAMPINTMTN_API)
    {
    	$stripped = rtrim($OPNTRANSAMPINTMTN_API, "&"); // URL last & symbole remove
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

    public function get_OTFSI_SingleData($FinalAPI)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FinalAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);
    
		return $reponce;
    }

    public function GetSeriesDropdown($Final_API)
    {
    	// echo '<pre>';
    	// print_r($Final_API);
    	// die();
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$Final_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);

		if(!empty($reponce)){
			$option = '';
			for ($i=0; $i < count($reponce) ; $i++) { 
				if (!empty($reponce[$i]->SeriesName)) {
					$option .= '<option value="'.$reponce[$i]->Series.'">'.$reponce[$i]->SeriesName.'</option>';
				}
			}  
		}
		    
		return $option;
    }

    public function GetSeriesData($Final_API)
    {
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$Final_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$reponce=curl_exec($ch);
		curl_close($ch);
		    
		return $reponce;
    }

    public function getAnyDorpDownMasterFun($Final_API)
    {
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$Final_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);

		if(!empty($reponce)){
			
			$Default=$reponce[0]->Default; // Selection default value store 

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

    public function GetSeriesSingleData($FinalAPI)
    {
    	$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$FinalAPI);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);
    
		return $reponce;
    }

    public function GetSampleTypeDropdown($SAMINTSTYPE_API)
    {
    	// $ch = curl_init();
		// curl_setopt($ch,CURLOPT_URL,$SAMINTSTYPE_API);
		// curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		// $output=curl_exec($ch);
		// $reponce=json_decode($output);
		// curl_close($ch);

		// $option='<option value="">Please Select</option>';

		// if(!empty($reponce)){
		// 	for ($i=0; $i < count($reponce) ; $i++) { 
		// 		if (!empty($reponce[$i]->SType)) {
		// 			$option .= '<option value="'.$reponce[$i]->SType.'">'.$reponce[$i]->STypeDes.'</option>';
		// 		}
		// 	}  
		// }
		$option='';
		$option.='<option value="R">Regular</option>';
		return $option;
    }

    public function GetTR_ByDropdown($SAMINTTRBY_API)
    {
    	// $ch = curl_init();
		// curl_setopt($ch,CURLOPT_URL,$SAMINTTRBY_API);
		// curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		// $output=curl_exec($ch);
		// $reponce=json_decode($output);
		// curl_close($ch);

		// $option='<option value="">Please Select</option>';

		// if(!empty($reponce)){
		// 	for ($i=0; $i < count($reponce) ; $i++) { 
		// 		if (!empty($reponce[$i]->TRBy)) {
		// 			$option .= '<option value="'.$reponce[$i]->TRBy.'">'.$reponce[$i]->TRBy.'</option>';
		// 		}
		// 	}  
		// }

		$EmployeeFullName= $_SESSION['Baroque_FirstName'].' '.$_SESSION['Baroque_LastName'];
		$option = '<option value="'.$EmployeeFullName.'">'.$EmployeeFullName.'</option>';
		return $option;
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

    public function SaveSampleIntimation($tdata,$Final_API)
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
	
// CURL PATCH Method Function satrt here-----------------------------------------------------------------------------------
	public function SampleIntimationUnderTestUpdateFromInventoryTransfer($UT_data,$Final_API2)
    {
		$postdata = json_encode($UT_data);

		$sessionId =$_SESSION['BaroqueSAP_SessionId'];
		$routeId = ".node2";
		$headers[] = "Cookie: B1SESSION=" . $sessionId . "; ROUTEID=" . $routeId . ";";

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
    
    public function PATCH_ServiceLayerMasterFunction($data,$Final_API)
    {
    	$postdata = json_encode($data);
		$sessionId =$_SESSION['BaroqueSAP_SessionId'];

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $Final_API,
			CURLOPT_RETURNTRANSFER => 1, //  -- custom line		
			CURLOPT_SSL_VERIFYPEER=> 0, //  -- custom line
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_SSL_VERIFYHOST => 0, // bypass SSL TO 0 command -- custom line
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'PATCH',
			CURLOPT_POSTFIELDS =>$postdata,
			CURLOPT_HTTPHEADER => array(
				// 'B1S-ReplaceCollectionsOnPatch: true',
				'Content-Type: application/json',
				'Cookie: B1SESSION='.$sessionId.'; ROUTEID=.node4'
			),
		));

		$response = curl_exec($curl);
		return $response;
		curl_close($curl);
    }

    public function PATCH_ServiceLayerMasterFunctionWithB1Replace($data,$Final_API)
    {
    	$postdata = json_encode($data);
		$sessionId =$_SESSION['BaroqueSAP_SessionId'];

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $Final_API,
			CURLOPT_RETURNTRANSFER => 1, //  -- custom line		
			CURLOPT_SSL_VERIFYPEER=> 0, //  -- custom line
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_SSL_VERIFYHOST => 0, // bypass SSL TO 0 command -- custom line
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'PATCH',
			CURLOPT_POSTFIELDS =>$postdata,
			CURLOPT_HTTPHEADER => array(
				'B1S-ReplaceCollectionsOnPatch: true',
				'Content-Type: application/json',
				'Cookie: B1SESSION='.$sessionId.'; ROUTEID=.node4'
			),
		));

		$response = curl_exec($curl);
		return $response;
		curl_close($curl);
    }

    public function POST_ServiceLayerMasterFunction($data,$Final_API){
    	$postdata = json_encode($data);
		$sessionId =$_SESSION['BaroqueSAP_SessionId'];

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $Final_API,
			CURLOPT_RETURNTRANSFER => 1, //  -- custom line	
			CURLOPT_SSL_VERIFYPEER=> 0, //  -- custom line
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_SSL_VERIFYHOST => 0, // bypass SSL TO 0 command -- custom line
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>$postdata,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Cookie: B1SESSION='.$sessionId.'; ROUTEID=.node2'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
    }
// CURL PATCH Method Function End here-------------------------------------------------------------------------------------

    function POST_QuerryBasedMasterFunction($data,$FinalAPI){
    	$PayLoad=json_encode($data);

    	$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $FinalAPI,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>$PayLoad,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
    }

    function GET_QuerryBasedMasterFunction($Final_API){
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


    public function getSimpleIntimation($SAMPLEINTMUNDERTEST_API,$tdata)
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

		$API=$SAMPLEINTMUNDERTEST_API.'?'.$FromDate.$ToDate.$DocEntry;
		

		$removeDoller = rtrim($API, "&"); // URL last & symbole remove
		$stripped = rtrim($removeDoller, "?"); // URL last ? symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
		// print_r($Final_url);
		// die();

		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);
    
		return $reponce;
    }

    public function getSimpleCollection($SAMPLECOLL_API,$tdata)
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

		$API=$SAMPLECOLL_API.'?'.$FromDate.$ToDate.$DocEntry;

		$removeDoller = rtrim($API, "&"); // URL last & symbole remove
		$stripped = rtrim($removeDoller, "?"); // URL last ? symbole remove
		$Final_url = str_replace(' ', '%20', $stripped); // All blank space replace to %20
		// print_r($Final_url);
		// die();
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$Final_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		curl_close($ch);
    
		return $reponce;
    }

    public function DoLogout()
    {
    	$return = true;
		
		$_SESSION['Baroque_EmployeeID'] ='';
		$_SESSION['Baroque_LastName'] ='';
		$_SESSION['Baroque_FirstName'] ='';
		$_SESSION['Baroque_MobilePhone'] ='';
		$_SESSION['Baroque_eMail'] ='';
		$_SESSION['Baroque_EmployeeCode'] ='';

		unset($_SESSION['Baroque_EmployeeID']); 
		unset($_SESSION['Baroque_LastName']); 
		unset($_SESSION['Baroque_FirstName']);     
		unset($_SESSION['Baroque_MobilePhone']);  
		unset($_SESSION['Baroque_eMail']);
		unset($_SESSION['Baroque_EmployeeCode']);
        return $return;
    }

    public function GetItemDropdown($Final_API)
    {
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$Final_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		sort($reponce);
		curl_close($ch);

		$option .= '<option value="">Select Item Code</option>';
		if(!empty($reponce)){
			for ($i=0; $i < count($reponce) ; $i++) { 
				// $option .= '<option value="'.$reponce[$i]->ItemCode.'">'.$reponce[$i]->ItemName.'</option>';
				$option .= '<option value="'.$reponce[$i]->ItemCode.'">'.$reponce[$i]->ItemCode.'</option>';
			}  
		}
		    
		return $option;
    }

    public function GetStabilityTypeDropdown($Final_API)
    {
    	$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$Final_API);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		$output=curl_exec($ch);
		$reponce=json_decode($output);
		sort($reponce);
		curl_close($ch);

		$option .= '<option value="">select</option>';
		if(!empty($reponce)){
			for ($i=0; $i < count($reponce) ; $i++) { 
				$option .= '<option value="'.$reponce[$i]->Code.'">'.$reponce[$i]->Name.'</option>';
			}  
		}
		    
		return $option;
    }

}
?>