<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list')
{
    $getAllData=$obj->get_OTFSI_Data($OPENTRANSQCDOCSTABILITY_API);
    $count=count($getAllData);

    // echo "<pre>";
    // print_r($getAllData);
    // echo "</pre>";

    $adjacents = 1;

    $records_per_page =20;
    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    // =========================================================================================
        if($page=='1'){
            $r_start='0';   // 0
            $r_end=$records_per_page;    // 20
        }else{
            $r_start=($page*$records_per_page)-($records_per_page);   // 20
            $r_end=($records_per_page*$page);   // 40
        }
    // =========================================================================================

    $page = ($page == 0 ? 1 : $page);
    $start = ($page-1) * $records_per_page;
    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.
    
    $next = $page + 1;    
    $prev = $page - 1;
    $last_page = ceil($count/$records_per_page);
    $second_last = $last_page - 1; 
    $pagination = "";

    if($last_page > 1)
    {
            $pagination .= "<div class='pagination' style='float: right;'>";

        if($page > 1)
                $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($prev).");'>&laquo; Previous&nbsp;&nbsp;</a>";
        else
            $pagination.= "<spn class='disabled'>&laquo; Previous&nbsp;&nbsp;</spn>";   

        if($last_page < 7 + ($adjacents * 2))
        {   
        for ($counter = 1; $counter <= $last_page; $counter++)
            {
            if ($counter == $page)
                $pagination.= "<spn class='current'>$counter</spn>";
            else
                $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");'>$counter</a>";     
            }
        }
        elseif($last_page > 5 + ($adjacents * 2))
        {
            if($page < 1 + ($adjacents * 2))
                {
                for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                    if($counter == $page)
                        $pagination.= "<spn class='current'>$counter</spn>";
                    else
                        $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");'>$counter</a>";     
                    }
                    $pagination.= "...";
                    $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($second_last).");'> $second_last</a>";
                    $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($last_page).");'>$last_page</a>";   

                }
            elseif($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2))
            {
                $pagination.= "<a href='javascript:void(0);' onClick='change_page(1);'>1</a>";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page(2);'>2</a>";
                $pagination.= "...";
                for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                    {
                    if($counter == $page)
                           $pagination.= "<spn class='current'>$counter</spn>";
                   else
                           $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");'>$counter</a>";     
                    }

                $pagination.= "..";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($second_last).");'>$second_last</a>";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($last_page).");'>$last_page</a>";   
            }
            else
            {
                $pagination.= "<a href='javascript:void(0);' onClick='change_page(1);'>1</a>";
                $pagination.= "<a href='javascript:void(0);' onClick='change_page(2);'>2</a>";
                $pagination.= "..";

                for($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++)
                {
                    if($counter == $page)
                        $pagination.= "<spn class='current'>$counter</spn>";
                    else
                        $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($counter).");'>$counter</a>";     
                }
            }

        }

        if($page < $counter - 1)
            $pagination.= "<a href='javascript:void(0);' onClick='change_page(".($next).");'>Next &raquo;</a>";
        else

            $pagination.= "<spn class='disabled'>Next &raquo;</spn>";
            $pagination.= "</div>";       
    }

    $option.= '<table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                <thead class="fixedHeader1">
                    <tr>
                        <th>Sr.No </th> 
                        <th>Item View</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Whs Code</th>
                        <th>Whs Total</th>
                        <th>Base Type</th>
                        <th>Base Entry</th>
                        <th>Base Num</th>
                        <th>Doc Date</th>
                        <th>Quantity</th>
                        <th>Lot Number</th>
                        <th>Exp. Date</th>
                        <th>Mnf Date</th>
                        <th>BPL Name</th>
                        <th>Location</th>
                        <th>Stability Plan DocNum</th>
                        <th>Stability Plan DocEntry</th>
                        <th>Stability Loading Date</th>
                        <th>Stability Plan Quantity</th>
                        <th>Stability Intimation No</th>
                        <th>Stability Collection No</th>
                        <th>Route Stage Reco WO No</th>
                        <th>Route Stage Reco WO Entry</th>
                        <th>Planned Qty</th>
                        <th>Route Stage Reco UOM</th>
                        <th>Route Stage Reco Prod Receipt No</th>
                        <th>Route Stage Reco Prod Receipt Entry</th>
                        <th>Route Stage Reco Prod Receipt Qty</th>
                        <th>Stability Type</th>
                        <th>Stability Condition</th>
                        <th>Stability Time Period</th>
                        <th>Type of Analysis</th>
                        <th>Period in months</th>
                        <th>Period Type</th>
                        <th>Additional Year</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>';
 
                if(count($getAllData)!='0'){
                    for ($i=$r_start; $i <$r_end ; $i++) { 
                        if(!empty($getAllData[$i]->SrNo)){   //  this condition save to extra blank loop

                            // --------------- Convert String code Start Here ---------------------------
                                if(empty($getAllData[$i]->DocDate)){
                                    $DocDate='';
                                }else{
                                    $DocDate=date("d-m-Y", strtotime($getAllData[$i]->DocDate));
                                }

                                if(empty($getAllData[$i]->ExpiryDate)){
                                    $ExpiryDate='';
                                }else{
                                    $ExpiryDate=date("d-m-Y", strtotime($getAllData[$i]->ExpiryDate));
                                }

                                if(empty($getAllData[$i]->MfgDate)){
                                    $MfgDate='';
                                }else{
                                    $MfgDate=date("d-m-Y", strtotime($getAllData[$i]->MfgDate));
                                }

                                if(empty($getAllData[$i]->StabilityLoadingDate)){
                                    $StabilityLoadingDate='';
                                }else{
                                    $StabilityLoadingDate=date("d-m-Y", strtotime($getAllData[$i]->StabilityLoadingDate));
                                }

                                if(empty($getAllData[$i]->EndDate)){
                                    $EndDate='';
                                }else{
                                    $EndDate=date("d-m-Y", strtotime($getAllData[$i]->EndDate));
                                }

                            // --------------- Convert String code End Here-- ---------------------------

                            $option.='
                                <tr>
                                    <td class="desabled">'.$getAllData[$i]->SrNo.'</td>

                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".stability-qc-check" onclick="OT_PoPup_QCPO_Stability(\''.$getAllData[$i]->RouteStageRecoReceiptEntry.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->BatchNo.'\',\''.$getAllData[$i]->SampleCollectionNo.'\')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </td>

                                    <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WhsCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WhsTotal.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BaseType.'</td>

                                    <td class="desabled">'.$getAllData[$i]->BaseEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BaseNum.'</td>
                                    <td class="desabled">'.$DocDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Quantity.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>

                                    <td class="desabled">'.$ExpiryDate.'</td>
                                    <td class="desabled">'.$MfgDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Branch.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Location.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityPlanDocNum.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityPlanDocEntry.'</td>
                                    <td class="desabled">'.$StabilityLoadingDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityPlanQuantity.'</td>
                                    <td class="desabled">'.$getAllData[$i]->SampleIntimationNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->SampleCollectionNo.'</td>

                                    <td class="desabled">'.$getAllData[$i]->RouteStageRecoWONo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->RouteStageRecoWODocEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->PlannedQuantity.'</td>
                                    <td class="desabled">'.$getAllData[$i]->RouteStageRecoUOM.'</td>
                                    <td class="desabled">'.$getAllData[$i]->RouteStageRecoReceiptNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->RouteStageRecoReceiptEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->RouteStageRecoReceiptQty.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityType.'</td>

                                    <td class="desabled">'.$getAllData[$i]->StabilityCondition.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityTimePeriod.'</td>
                                    <td class="desabled">'.$getAllData[$i]->AnalysisType.'</td>
                                    <td class="desabled">'.$getAllData[$i]->PeriodinMonths.'</td>
                                    <td class="desabled">'.$getAllData[$i]->PeriodType.'</td>
                                    <td class="desabled">'.$getAllData[$i]->AdditionalYear.'</td>
                                    <td class="desabled">'.$EndDate.'</td>
                                </tr>';
                        }
                    }
                }else{
                     $option.='<tr><td colspan="20" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
                }
        $option.='</tbody> 
    </table>'; 

    $option.=$pagination;        
    echo $option;
    exit(0);
}
?>

<?php include 'include/header.php' ?>
<?php include 'models/qc_process/stability-qc-check-model.php' ?>

    <!-- gridjs css -->
    <link rel="stylesheet" href="assets/libs/gridjs/theme/mermaid.min.css">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <style type="text/css">
        body[data-layout=horizontal] .page-content {padding: 20px 0 0 0;padding: 40px 0 60px 0;}
    </style>
<!-- ---------- loader start here---------------------- -->
    <div class="loader-top" style="height: 100%;width: 100%;background: #cccccc73;">
        <div class="loader123" style="text-align: center;z-index: 10000;position: fixed;top: 0; left: 0;bottom: 0;right: 0;background: #cccccc73;">
            <img src="loader/loader2.gif" style="width: 5%;padding-top: 288px !important;">
        </div>
    </div>
<!-- ---------- loader end here---------------------- -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Open Transaction for QC Post Document - Stability</h4>

                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                                <li class="breadcrumb-item active">Open Transaction for QC Post Document - Stability</li>
                                            </ol>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <!-- end page title -->

                           <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header justify-content-between d-flex align-items-center">
                                        <h4 class="card-title mb-0">Open Transaction for QC Post Document - Stability</h4>  
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                        <div class="table-responsive" id="list-append">
                                            <!-- // page record appned here -->
                                        </div> 
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                <br><br>
           <?php include 'include/footer.php' ?>

        

<script type="text/javascript">
    $(".loader123").hide(); // loader default hide script

// <!-- ----------------- lattest updated code start (11th July 2024) --------------------------------- -->
    $(document).ready(function()
    {
        var dataString ='action=list';
        
        $.ajax({  
            type: "POST",  
            url: window.location.href,  
            data: dataString,  
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {  
                $('#list-append').html(result);
            },
            complete:function(data){
                $(".loader123").hide();
            }
       });
    });

    function change_page(page_id)
    { 
        var dataString ='page_id='+page_id+'&action=list';

        $.ajax({
            type: "POST",
             url: window.location.href,  
            data: dataString,
            cache: false,
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                $('#list-append').html(result);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }

    function OT_PoPup_QCPO_Stability(DocEntry,ItemCode,BatchNo,SampleColNo)  // API Ser No 40 somthing wrong
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data:{'DocEntry':DocEntry,'ItemCode':ItemCode,'BatchNo':BatchNo,'SampleColNo':SampleColNo,'action':"OT_PoPup_QCPO_Stability_ajax"},

            beforeSend: function(){
                // $(".loader123").show();
            },
            success: function(result)
            {
                
                var JSONObjectAll = JSON.parse(result);

                var JSONObject=JSONObjectAll['SampleCollDetails'];
                console.log(JSONObject);
                
                $(`#qc-post-general-data-list-append`).html(JSONObjectAll['general_data']); // Extra Issue Table Tr tag append here
                $(`#qc-status-list-append`).html(JSONObjectAll['qcStatus']); // External Issue Table Tr tag append here
                $(`#qc-attach-list-append`).html(JSONObjectAll['qcAttach']);

                $(`#StabilityPlanDocEntry`).val(JSONObject[0].StabilityPlanDocEntry);
                // console.log(JSONObject);

                // Line 1 start
                    $(`#ReceiptNo`).val(JSONObject[0].RouteStageRecoReceiptNo);
                    $(`#ReceiptEntry`).val(JSONObject[0].RouteStageRecoReceiptEntry);
                    $(`#WoNo`).val(JSONObject[0].RouteStageRecoWONo);
                    $(`#WoEntry`).val(JSONObject[0].RouteStageRecoWODocEntry);

                // alert(JSONObject[0].RouteStageRecoWODocEntry);

                // RouteStageRecoReceiptEntry
                    $(`#ItemCode`).val(JSONObject[0].ItemCode);
                    $(`#ItemName`).val(JSONObject[0].ItemName);

                // Line 2 start
                    $(`#GenericName`).val(JSONObject[0].GenericName);

                    $(`#LabelCliam`).val(JSONObject[0].LabelClaim);
                    $(`#LabelCliamUOM`).val(JSONObject[0].LabelClaimUOM);
                    $(`#MfgBy`).val(JSONObject[0].MfgBy);

                // Line 3 start
                        $(`#ARNo`).val(JSONObject[0].ARNo);
                        $(`#SpecificationNo`).val(JSONObject[0].SpecNo);

                // Line 4 start
                    $(`#SampleType`).val(JSONObject[0].SampleType);
                        $(`#MaterialType`).val(JSONObject[0].MaterialType);
                        $(`#BatchNo`).val(JSONObject[0].BatchNo);

                // Line 5 start
                    $(`#BatchSize`).val(JSONObject[0].BatchQty); //<!-- misssing -------------------------------------------- -->
                    $(`#SampleIntimationStability`).val(JSONObject[0].SampleIntimationNo); //<!-- misssing -------------------------------------------- -->
                    $(`#SampleCollStability`).val(JSONObject[0].SampleCollectionNo);


                // <!-- ----------- Mfg Date Start Here ----------------------- -->
                    var mfgDateOG = JSONObject[0]['MfgDate'];
                    if(mfgDateOG!=''){
                        mfgDate = mfgDateOG.split(' ')[0];
                        $(`#MfgDate`).val(mfgDate);
                    }
                // <!-- ----------- Mfg Date End Here ------------------------- -->

                // <!-- ----------- Mfg Date Start Here ----------------------- -->
                    var expiryDateOG = JSONObject[0].ExpiryDate;
                    if(expiryDateOG!=''){
                        ExpiryDate = expiryDateOG.split(' ')[0];
                        $(`#ExpiryDate`).val(ExpiryDate);
                    }
                // <!-- ----------- Mfg Date End Here ------------------------- -->

                // Line 6 start
                    $(`#SampleCollStability`).val(JSONObject[0].SampleIntimationNo); //<!-- misssing -------------------------------------------- -->
                    $(`#SampleTransferNoFromWO`).val(JSONObject[0].BaseNum); //<!-- misssing -------------------------------------------- -->
                    $(`#SampleCollEntryFromWO`).val(JSONObject[0].BaseEntry); //<!-- misssing -------------------------------------------- -->
                
                $(`#WhsCode`).val(JSONObject[0].WhsCode);

                // Line 7 start
                    $(`#StabilityPlanDocNum`).val(JSONObject[0].StabilityPlanDocNum);
                    $(`#StabilityPlanDocEntry`).val(JSONObject[0].StabilityPlanDocEntry);
                    $(`#StabilityPlanQuantity`).val(JSONObject[0].StabilityPlanQuantity);

                // <!-- ----------- Mfg Date Start Here ----------------------- -->
                    var stabilityLoadingDateOG = JSONObject[0].StabilityLoadingDate;
                    if(stabilityLoadingDateOG!=''){
                        stabilityLoadingDate = stabilityLoadingDateOG.split(' ')[0];
                        $(`#StabilityLoadingDate`).val(stabilityLoadingDate);
                    }
                // <!-- ----------- Mfg Date End Here ------------------------- -->

                // Line 8 start
                    $(`#NoOfContainer`).val(JSONObject[0].NoofContainer);

                // Line 9 start
                    $(`#Branch`).val(JSONObject[0].Branch);
                    $(`#Location`).val(JSONObject[0].Location);
                    $(`#PackSize`).val(JSONObject[0].PackSize);

                    addDaysToDate(JSONObject[0].QCDays);  // add QC Days In Postion Date 



// console.log("Current Date:", currentDate);
// console.log("New Date:", newDate);










                // Line 10 start
                    $(`#StabilityType`).val(JSONObject[0].StabilityType);
                    $(`#AnalysisType`).val(JSONObject[0].AnalysisType);
                    $(`#StabilityCondition`).val(JSONObject[0].StabilityCondition);
                    $(`#StabilityTimePeriod`).val(JSONObject[0].StabilityTimePeriod);
                    $(`#StabilityMakeBy`).val(JSONObject[0].MakeBy);
                    
                    $(`#StabilityQC_CK_D_Factor`).val(JSONObject[0].Factor);
                    $(`#StabilityQC_CK_D_NoOfContainer`).val(JSONObject[0].NoofContainer);
                    $(`#StabilityQC_CK_D_Remarks`).val('');
                    $(`#Stability_BPLId`).val(JSONObject[0].BPLId);
                    $(`#Stability_ItemCode`).val(JSONObject[0].ItemCode);
                    $(`#Stability_FromWhs`).val(JSONObject[0].WhsCode);
                    $(`#Stability_QCDays`).val(JSONObject[0].QCDays);
                    
                    
                

                
                
                QC_StatusByAnalystDropdown(JSONObjectAll.count);
                getResultOutputDropdown(JSONObjectAll.count);
                getQcStatusDropodwn(1);
                getDoneByDroopdown(1);
                assayapp();
                // ===========================================================================================================

                // "SrNo": "1",
                // "WhsTotal": "",
                // "BaseType": "",
                // "BaseEntry": "1167",
                // "BaseNum": "762",
                // "DocDate": "115",
                // "Quantity": "100.000000",
                // "BatchQty": "100.000000",
                // "SampleIntimationNo": "22",
                // "SampleCollectionNo": "17",
                // "RouteStageRecoWONo": "541",
                // "RouteStageRecoWODocEntry": "821",
                // "PlannedQuantity": null,
                // "RouteStageRecoReceiptNo": "115",
                // "RouteStageRecoReceiptEntry": "330",
                // "RouteStageRecoReceiptQty": "",
                // "RouteStageRecoUOM": "SACHET",
                // "PeriodType": "",
                // "AdditionalYear": "",
                // "EndDate": "",
                // "PeriodinMonths": "",
                // "Status": "Open",
                // "Canceled": null,
                // "DocNum": "",
                // "Series": "",
                // "BPLId": "",
                // "LocCode": ""

                // ------------------------------------------------------Done--------------------------------------------------------------------
                // "ItemCode": "FG00020",
                // "ItemName": "COLON FIBER SACHET ( ORANGE FLAVOUR)",

                // "LabelClaim": "0.000000",
                // "LabelClaimUOM": "",
                // "MfgBy": "",

                // "ARNo": "",
                // "SpecNo": "",

                // "SampleType": "Stability",
                // "MaterialType": "FG",
                // "BatchNo": "DEF24092022",

                // "MfgDate": "24-09-2022 00:00:00",
                // "ExpiryDate": "24-07-2025 00:00:00",

                // "WhsCode": "STBL-DEF",

                // "StabilityPlanDocNum": "10",
                // "StabilityPlanDocEntry": "53",
                // "StabilityLoadingDate": "26-08-2022 00:00:00",
                // "StabilityPlanQuantity": "20.000000",

                // "NoofContainer": "10",

                // "PackSize": "1 X 1 SAC",
                // "Branch": "HO",
                // "Location": "GENERAL",

                // "StabilityType": "Accelerated Condition",
                // "StabilityCondition": "40 0 C +- 2 0 C\/ 75+-5%RH",
                // "StabilityTimePeriod": "Up to 6 Months",
                // "AnalysisType": "Physical & Chemical",

                // ===========================================================================================================================




                // var JSONObject=JSONObjectAll['SampleCollDetails'];
                // $(`#qc-post-general-data-list-append`).html(JSONObjectAll['general_data']); // Extra Issue Table Tr tag append here
                // $(`#qc-status-list-append`).html(JSONObjectAll['qcStatus']); // External Issue Table Tr tag append here
                // $(`#qc-attach-list-append`).html(JSONObjectAll['qcAttach']);

                // $(`#QC_CK_D_WODocEntry`).val(JSONObject[0].RFPDocEntry);
                // $(`#QC_CK_D_WoNo`).val(JSONObject[0].WONo);
                // $(`#QC_CK_D_RefNo`).val(JSONObject[0].BpRefNo);

                // $(`#QC_CK_D_ItemCode`).val(JSONObject[0].ItemCode);
                // $(`#QC_CK_D_ItemName`).val(JSONObject[0].ItemName);
                // $(`#QC_CK_D_GenericName`).val('');
                // $(`#QC_CK_D_LabelCliam`).val(JSONObject[0].LabelClaim);
                // $(`#QC_CK_D_RecievedQty`).val('');

                // $(`#QC_CK_D_MfgBy`).val(JSONObject[0].MfgBy);

                // $(`#QC_CK_D_BatchNo`).val(JSONObject[0].BatchNo);
                // $(`#QC_CK_D_BatchSize`).val(JSONObject[0].BatchQty);
                // $(`#QC_CK_D_PackSize`).val(JSONObject[0].PackSize);

                // $(`#QC_CK_D_Branch`).val(JSONObject[0].BranchName);

                // $(`#QC_CK_D_MaterialType`).val(JSONObject[0].MaterialType);
                // $(`#QC_CK_D_ARNo`).val(JSONObject[0].ARNo);

                // $(`#QC_CK_D_QCTesttype`).val(JSONObject[0].GateEntryNo);
                // $(`#QC_CK_D_Stage`).val('');
                // $(`#QC_CK_D_ValidUpTo`).val('');
                // $(`#QC_CK_D_Factor`).val(JSONObject[0].Factor);
                // $(`#QC_CK_D_NoOfContainer`).val(JSONObject[0].TNCont);
                // $(`#QC_CK_D_FromContainer`).val(JSONObject[0].FCont);

                // $(`#QC_CK_D_ToContainer`).val(JSONObject[0].TCont);

                // $(`#QC_CK_D_Remarks`).val('');
                // $(`#QC_CK_D_QtyPerContainer`).val('');

                // $(`#QC_CK_D_BPLId`).val(JSONObject[0].BPLId);
                // $(`#QC_CK_D_BatchQty`).val(JSONObject[0].BatchQty);
                // $(`#QC_CK_D_LineNum`).val(JSONObject[0].LineNum);
                // $(`#QC_CK_D_LocCode`).val(JSONObject[0].LocCode);
                // $(`#QC_CK_D_MfgDate`).val(JSONObject[0].MfgDate);
                // $(`#QC_CK_D_ExpiryDate`).val(JSONObject[0].ExpiryDate);
                // $(`#QC_CK_D_SampleIntimationNo`).val(JSONObject[0].SampleIntimationNo);
                // $(`#QC_CK_D_SampleCollectionNo`).val(JSONObject[0].SampleCollectionNo);
                // $(`#QC_CK_D_SampleQty`).val(JSONObject[0].SampleQty);
                // $(`#QC_CK_D_GateENo`).val(JSONObject[0].GateENo);
                // $(`#QC_CK_D_SpecfNo`).val(JSONObject[0].SpecfNo);
                // $(`#QC_CK_D_RetestDate`).val(JSONObject[0].RetestDate);
                // $(`#QC_CK_D_Loc`).val(JSONObject[0].Location);

                // QC_StatusByAnalystDropdown(JSONObjectAll.count);
                // getResultOutputDropdown(JSONObjectAll.count);
                // getQcStatusDropodwn(1);
                // getDoneByDroopdown(1);
                // assayapp();
            },
            complete:function(data){
                Compiled_ByDropdown();
            }
        }); 
    }

     // Function to add days to a date
 function addDaysToDate(days) {

    let dateString = $('#PostingDate').val();;


    // Parse the input date string to a Date object
    let date = new Date(dateString);

    // Add the specified number of days
    date.setDate(date.getDate() + days);

    // Format the new date as YYYY-MM-DD
    let year = date.getFullYear();
    let month = ('0' + (date.getMonth() + 1)).slice(-2); // Add leading zero if needed
    let day = ('0' + date.getDate()).slice(-2); // Add leading zero if needed

    let newDate =`${year}-${month}-${day}`;
    $(`#ValidUpTo`).val(newDate);

    //   return `${year}-${month}-${day}`;
}
// <!-- ----------------- lattest updated code end (11th July 2024) ----------------------------------- -->

















    

    




   
    function inventoryTransferStability()
    {
        // var SupplierCode=document.getElementById('si_SupplierCode').value;
        // var SupplierName=document.getElementById('si_SupplierName').value;
        var Branch=document.getElementById('Branch').value;
        var Series=document.getElementById('StabilityQC_CK_D_DocName').value;
        var DocEntry=document.getElementById('ReceiptEntry').value;
        var BPLId=document.getElementById('Stability_BPLId').value;
        // var afters=

        // http://192.168.1.30:8082/API/SAP/OPENTRANSQCDOCSTABILITY?DocEntry=9&ItemCode=FG00001&BatchNo=C0121269&SampleColNo=5&UserName=bar@gmail.com

        var dataString ='DocEntry='+DocEntry+'&action=OpenInventoryTransferQC_Checke_Stability_In_ajax';

        // onclick="OT_PoPup_QCPO_Stability('118','FG00001','C0121197','12')"

        // alert(dataString);
        // +'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
               // console.log(JSONObject);
                // console.log(result);
                    // $('#iT_InventoryTransfer_supplier_code').val(SupplierCode);
                    // $('#iT_InventoryTransfer_supplier_name').val(SupplierName);
                    $('#s_InventoryTransfer_BaseDocType').val('SCS_SCOLSTAB');
                    $('#s_InventoryTransfer_BaseDocNum').val(DocEntry);
                    $('#s_InventoryTransfer_branch').val(Branch);
                    $('#s_InventoryTransfer_series').val(Series);
                    $('#s_InventoryTransfer_BPLId').val(BPLId);
                    $('#s_InventoryTransfer_DocEntry').val(DocEntry);
                    $('#s_InventoryTransfer_PostingDate').val();
                    $('#s_InventoryTransfer_DocumentDate').val();

                    $('#InventoryTransferItemAppend_retails').html(JSONObject);

                    // alert(after);
                    // getSeriesDropdown_retails();
                  // getSeriesDropdown() // DocName By using API to get dropdown 
                  ContainerSelection_retails(); // get Container Selection Table List

                  // ContainerSelection
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }


    function ContainerSelection_retails(){

        var DocEntry=document.getElementById('ReceiptEntry').value;
        var BatchNo=document.getElementById('BatchNo').value;
        var ItemCode=document.getElementById('Stability_ItemCode').value;
        var itP_FromWhs=document.getElementById('Stability_FromWhs').value;
       // ItemCode=SFG00001&WareHouse=RETN-WHS&BatchNo=C0121157

        var dataString ='ItemCode='+ItemCode+'&WareHouse='+itP_FromWhs+'&DocEntry='+DocEntry+'&BatchNo='+BatchNo+'&action=OpenInventoryTransfer_stability_ajax';
        // alert(dataString);
       

        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);

                // console.log(JSONObject);
               
                $('#ContainerSelectionItemAppend_retails').html(JSONObject); 
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 

    }



    function getQcStatusDropodwn(n){
        var dataString ='action=qc_api_OQCSTATUS_ajax';
        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_common-ajax.php',  
            data: dataString,  
            success: function(result){ 
                $('.qc_status_selecte'+n).html(result);
            }
       });
    }

    function getDoneByDroopdown(n){
        var dataString ='action=qc_get_SAMINTTRBY_ajax';
        $.ajax({  
            type: "POST",  
            dataType:'JSON',
            url: 'ajax/kri_common-ajax.php',  
            data: dataString,  
            success: function(result){ 

                var html="";
                result.forEach(function(value,index){
                    if(value.TRBy!=""){
                        html +='<option value="'+value.TRBy+'">'+value.TRBy+'</option>';
                    }
                });

                $('.done-by-mo'+n).html(html);
            }
        });
    } 


    function CalculatePotency()
    {
        // <!-- -----------  LoD / Water Value Preparing Start Here ------------------------------- -->
            var lod_waterOG=document.getElementById('QC_CK_D_LODWater').value;

            if((parseFloat(lod_waterOG).toFixed(6))<='0.000000' || lod_waterOG=='' || lod_waterOG==null){
                var lod_water='0.000000';
                $('#QC_CK_D_LODWater').val(lod_water);
            }else{
                var lod_water=parseFloat(lod_waterOG).toFixed(6);
                $('#QC_CK_D_LODWater').val(lod_water);
            }
        // <!-- -----------  LoD / Water Value Preparing End Here --------------------------------- -->

        // <!-- -----------  AssayPotency Value Preparing Start Here ------------------------------- -->
            var assayPotencyOG=document.getElementById('QC_CK_D_AssayPotency').value;

            if((parseFloat(assayPotencyOG).toFixed(6))<='0.000000' || assayPotencyOG=='' || assayPotencyOG==null){
                var assayPotency='0.000000';
                $('#QC_CK_D_AssayPotency').val(assayPotency);
            }else{
                var assayPotency=parseFloat(assayPotencyOG).toFixed(6);
                $('#QC_CK_D_AssayPotency').val(assayPotency);
            }
        // <!-- -----------  AssayPotency Value Preparing End Here --------------------------------- -->

        var Potency=((100- parseFloat(lod_water))/100)*parseFloat(assayPotency); // Calculation
        $('#QC_CK_D_Potency').val(parseFloat(Potency).toFixed(6)); // Set Potency calculated val
    }  

    function assayapp(){

        var dataString ='action=qc_assay_Calculation_Based_stability_ajax';
        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_production_common_ajax.php',  
            data: dataString,  
            success: function(result){ 
                $('#QC_CK_D_Assay').html(result);
            }
        });
    }

function Compiled_ByDropdown(){
    var dataString ='action=Compiled_By_dropdown_ajax';
    $.ajax({  
        type: "POST",  
        url: 'ajax/kri_production_common_ajax.php',  
        data: dataString, 
        beforeSend: function(){
            $(".loader123").show();
        }, 
        success: function(result){ 
            $('#StabilityQC_CK_D_CompiledBy').html(result);
            $('#StabilityQC_CK_D_CheckedBy').html(result);
            $('#StabilityQC_CK_D_AnalysisBy').html(result);
        },
        complete:function(data){
            // QC_TestTypeDropdown();
                getSeriesDropdown();
            $(".loader123").hide();
        }
    });
}


    function getSeriesDropdown(){
        var TrDate= $('#PostingDate').val();

        var dataString ='TrDate='+TrDate+'&ObjectCode=SCS_QCSTAB&action=getSeriesDropdown_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                var SeriesDropdown = JSON.parse(result);
                $('#StabilityQC_CK_D_DocName').html(SeriesDropdown);
                selectedSeries(); // call Selected Series Single data function
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function selectedSeries(){
        var TrDate= $('#PostingDate').val();
        // http://10.80.4.55:8081/API/SAP/INWARDQCSERIES?ObjectCode=SCS_QCSTAB
        var Series=document.getElementById('StabilityQC_CK_D_DocName').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=SCS_QCSTAB&action=getSeriesSingleData_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);

                var NextNumber=JSONObject[0]['NextNumber'];
                var Series=JSONObject[0]['Series'];

                $('#StabilityQC_CK_D_DocNo').val(Series);
            },
            complete:function(data){
            }
        }); 
    }



    function CalculateResultOut(un_id){

        var lowMin=document.getElementById('LowMin'+un_id).value;
        var uppMax=document.getElementById('UppMax'+un_id).value;
        var UOM=document.getElementById('GDUOM'+un_id).value;

        var lowMinResOG=document.getElementById('lower_min_result'+un_id).value; // this value enter by user

        var lowMinRes=parseFloat(lowMinResOG).toFixed(6); // this value enter by user

        if(lowMinRes!=''){
            $('#lower_min_result'+un_id).val(lowMinRes);

            $('#remarks'+un_id).val(lowMinResOG+' '+UOM);

            if(parseFloat(lowMinRes)>=parseFloat(lowMin) && parseFloat(lowMinRes)<=parseFloat(uppMax)){

                $('.dropdownResutl'+un_id).val('PASS');    
                $('#ResultOutTd'+un_id).attr('style', 'background-color: #c7f3c7');
                $('.dropdownResutl'+un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
            
                setSelectedIndex(document.getElementsByClassName("dropdownResutl"+un_id),"PASS");
            }else{

                $('.dropdownResutl'+un_id).val('FAIL');
                $('#ResultOutTd'+un_id).attr('style', 'background-color: #f8a4a4');
                $('.dropdownResutl'+un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');

                setSelectedIndex(document.getElementsByClassName("dropdownResutl"+un_id),"FAIL");
            }
        }
    }

    function setSelectedIndex(s, valsearch)
    {

        console.log('s=>', s);
        console.log('valsearch=>', valsearch);
        // Loop through all the items in drop down list
        for (i = 0; i< s.options.length; i++)
        { 
            if (s.options[i].value == valsearch)
            {
                // Item is found. Set its property and exit
                s.options[i].selected = true;
                break;
            }
        }
        return;
    }


    function ManualSelectedTResultOut(un_id){
        var ResultOut=document.getElementById('ResultOut'+un_id).value;

        if(ResultOut=='-'){
            // BLANK
            $('#ResultOutTd'+un_id).attr('style', 'background-color: #ffffff');
            $('#ResultOut'+un_id).attr('style', 'background-color: #ffffff;border:1px solid #ffffff !important;');

        }else if(ResultOut=='FAIL'){
            // FAIL
            $('#ResultOutTd'+un_id).attr('style', 'background-color: #f8a4a4');
            $('#ResultOut'+un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');

        }else{

            $('#ResultOutTd'+un_id).attr('style', 'background-color: #c7f3c7');
            $('#ResultOut'+un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
        }
    }

    function SelectedQCStatus(un_id){

        var QC_StatusByAnalyst=document.getElementById('QC_StatusByAnalyst'+un_id).value;
        
        if(QC_StatusByAnalyst=='Complies'){

            $('#QC_StatusByAnalystTd'+un_id).attr('style', 'background-color: #c7f3c7');
            $('#QC_StatusByAnalyst'+un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
        
        }else if(QC_StatusByAnalyst=='Non Complies'){

            $('#QC_StatusByAnalystTd'+un_id).attr('style', 'background-color: #f8a4a4');
            $('#QC_StatusByAnalyst'+un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
        
        }else {

            $('#QC_StatusByAnalystTd'+un_id).attr('style', 'background-color: #ffffff');
            $('#QC_StatusByAnalyst'+un_id).attr('style', 'background-color: #ffffff;border:1px solid #ffffff !important;');
        
        }
    }

    function getResultOutputDropdown(trcount){

        $.ajax({ 
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data:{'action':"ResultOutputDropdown_ajax"},

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                for (let i = 0; i < trcount; i++) {
                    $('.dropdownResutl'+i).html(result); // dropdown set using Id                            
                }
            },
            complete:function(data){
            }
        });         
    }
  

    function QC_StatusByAnalystDropdown(trcount){

        var dataString ='TableId=@SCS_QCSTAB1&Alias=QCSts&action=dropdownMaster_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                for (let i = 0; i < trcount; i++) {
                    $('.qc_statusbyab'+i).html(JSONObject); // dropdown set using Class                            
                }
            },
            complete:function(data){
            }
        });
    }

   
    function ContainerSelection(LineNum){

        var DocEntry=document.getElementById('U_UTTrans').value;
        var ItemCode=document.getElementById('it_af_ItemCode').value;
        var WareHouse=document.getElementById('it_af_ToWhse').value;

        var dataString ='DocEntry='+DocEntry+'&ItemCode='+ItemCode+'&LineNum='+LineNum+'&WareHouse='+WareHouse+'&action=AfterOpenInventoryTransferCS_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                $('#AfterContainerSelectionItemAppend').html(JSONObject);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 

    }


    function getSelectedContener_retails(un_id)
    {
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionItemAppend_retails");
 
        //Reference all the CheckBoxes in Table.
        var chks = tblFruits.getElementsByTagName("INPUT");
 
        // Loop and push the checked CheckBox value in Array.
        for (var i = 0; i < chks.length; i++) {
            if (chks[i].checked) {
                selected.push(chks[i].value);
            }
        }
        // console.log('selected=>', selected);

        // <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
            const array = selected;
            let sum = 0;

            for (let i = 0; i < array.length; i++) {
                sum += parseFloat(array[i]);
            }
            // console.log('sum=>', sum);
            document.getElementById("cs_selectedQtySum_retails").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
        // <!-- --------------------- when user select checkbox update flag start here -------------- -->
            var usercheckListVal=document.getElementById('usercheckList_retails'+un_id).value;
            if(usercheckListVal=='0'){
                $(`#usercheckList_retails`+un_id).val('1');
            }else{
                $(`#usercheckList_retails`+un_id).val('0');
            }
        // <!-- --------------------- when user select checkbox update flag End here ---------------- -->
    }


    function EnterQtyValidation_retails(un_id) {
        var BatchQty=document.getElementById('itp_BatchQty_retails'+un_id).value;
        var SelectedQty=document.getElementById('SelectedQty_retails'+un_id).value;

        if(SelectedQty!=''){

            if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){

                $('#SelectedQty_retails'+un_id).val(parseFloat(SelectedQty).toFixed(6));
                $('#itp_CS_retails'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value
            }else{
                $('#SelectedQty_retails'+un_id).val(BatchQty); // if user enter grater than val
                swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
            }

        }else{
            $('#SelectedQty_retails'+un_id).val(BatchQty); // if user enter blank val
            swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error")
        }
        getSelectedContener_num_retails(un_id);
    }

    function getSelectedContener_num_retails(un_id){
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionItemAppend_retails");
 
        //Reference all the CheckBoxes in Table.
        var chks = tblFruits.getElementsByTagName("INPUT");
 
        // Loop and push the checked CheckBox value in Array.
        for (var i = 0; i < chks.length; i++) {
            if (chks[i].checked) {
                selected.push(chks[i].value);
            }
        }
        // console.log('selected=>', selected);
        // <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
            const array = selected;
            let sum = 0;

            for (let i = 0; i < array.length; i++) {
                sum += parseFloat(array[i]);

            }
            // console.log('sum=>', sum);
            document.getElementById("cs_selectedQtySum_retails").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
    }


    function SubmitInventoryTransfer(){

        var selectedQtySum=document.getElementById('cs_selectedQtySum_retails').value; // final Qty sum
        var item_BQty=parseFloat(document.getElementById('itP_retails_BQty').value).toFixed(6);  // item available Qty
        var PostingDate=document.getElementById('s_InventoryTransfer_PostingDate').value;
        var DocDate=document.getElementById('s_InventoryTransfer_DocumentDate').value;
        var ToWhs=document.getElementById('itP_retails_ToWhs').value;

        // console.log(item_BQty);
        // console.log(selectedQtySum);
        if(selectedQtySum==item_BQty){ // Container selection Qty validation

            if(ToWhs!=''){ // Item level To Warehouse validation

                if(PostingDate!=''){ // Posting Date validation

                    if(DocDate!=''){ // Document Date validation

                    // <!-- ---------------- form submit process start here ----------------- -->
                        var formData = new FormData($('#inventoryFormSubmit_stability')[0]); // form Id
                        formData.append("stability_SubIT_Btn_post_doc",'SubIT_Btn'); // submit btn Id
                        var error = true;
                        
                        if(error)
                        {
                            $.ajax({
                                url: 'ajax/kri_production_common_ajax.php',
                                type: "POST",
                                data:formData,
                                processData: false,
                                contentType: false,
                                beforeSend: function(){
                                    // Show image container
                                    $(".loader123").show();
                                },
                                success: function(result){
                                    // console.log(result);
                                    var JSONObject = JSON.parse(result);
                                    // console.log(JSONObject);
                                    var status = JSONObject['status'];
                                    var message = JSONObject['message'];
                                    var DocEntry = JSONObject['DocEntry'];
                                    if(status=='True'){
                                        swal({
                                          title: `${DocEntry}`,
                                          text: `${message}`,
                                          icon: "success",
                                          buttons: true,
                                          dangerMode: false,
                                        })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                location.replace(window.location.href); //ok btn... cuurent URL called
                                            }else{
                                                location.replace(window.location.href); // cancel btn... cuurent URL called
                                            }
                                        });
                                    }else{
                                        swal("Oops!", `${message}`, "error");
                                    }
                                }
                                ,complete:function(data){
                                    // Hide image container
                                    $(".loader123").hide();
                                }
                            });
                        }
                    // <!-- ---------------- form submit process end here ------------------- -->
                    }else{
                        swal("Oops!", "Please Select A Document Date.", "error");
                    }

                }else{
                    swal("Oops!", "Please Select A Posting Date.", "error");
                }
            }else{
                swal("Oops!", "To Warehouse Mandatory.", "error");
            }

        }else{
            swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
        }


    }   



        function update_qc_post_document_stability(){

            var formData = new FormData($('#qcPostDocumentStabilityForm_update')[0]);  // Form Id
            formData.append("updateQcPostDocumentStabilitytBtn",'updateQcPostDocumentStabilityBtn');  // Button Id
            var error = true;

            $.ajax({
                url: 'ajax/kri_production_common_ajax.php',
                type: "POST",
                data:formData,
                processData: false,
                contentType: false,
                beforeSend: function(){
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result)
                {                
                    var JSONObject = JSON.parse(result);

                    var status = JSONObject['status'];
                    var message = JSONObject['message'];
                    var DocEntry = JSONObject['DocEntry'];
                    if(status=='True'){
                        swal({
                          title: `${message}`,
                          text: `${DocEntry}`,
                          icon: "success",
                          buttons: true,
                          dangerMode: false,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                location.replace(window.location.href); //ok btn
                            }else{
                                location.replace(window.location.href); // cancel btn
                            }
                        });
                    }else{
                        swal("Oops!", `${message}`, "error");
                    }
                },complete:function(data){
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        }

    // function sample_intimation(DocEntry,BatchNo,ItemCode,LineNum)
    // {
    //     $.ajax({ 
    //         type: "POST",
    //         url: 'ajax/common-ajax.php',
    //         data:{'DocEntry':DocEntry,'BatchNo':BatchNo,'ItemCode':ItemCode,'LineNum':LineNum,'action':"sample_intimation_popup"},

    //         beforeSend: function(){
    //             $(".loader123").show();
    //         },
    //         success: function(result)
    //         {
    //             var JSONObject = JSON.parse(result);

    //             $(`#GRPONo`).val(JSONObject[0]['GRPONo']);
    //             $(`#BpRefNo`).val(JSONObject[0]['BpRefNo']);
    //             $(`#ItemName`).val(JSONObject[0]['ItemName']);
    //             $(`#MfgBy`).val(JSONObject[0]['MfgBy']);
    //             $(`#SupplierCode`).val(JSONObject[0]['SupplierCode']);
    //             $(`#SupplierName`).val(JSONObject[0]['SupplierName']);
    //             $(`#SQty`).val(JSONObject[0]['SQty']);
    //             $(`#RQty`).val(JSONObject[0]['RQty']);
    //             $(`#ItemCode`).val(JSONObject[0]['ItemCode']);
    //             $(`#BranchName`).val(JSONObject[0]['BranchName']);
    //             $(`#ChNo`).val(JSONObject[0]['ChNo']);
    //             $(`#BatchNo`).val(JSONObject[0]['BatchNo']);
    //             $(`#BatchQty`).val(JSONObject[0]['BatchQty']);
    //             $(`#GRPODocEntry`).val(JSONObject[0]['GRPODocEntry']);
    //             $(`#statusDrop`).val(JSONObject[0]['Status']);
    //             $(`#Location`).val(JSONObject[0]['Location']);
    //             $(`#GRPO_Qty`).val(JSONObject[0]['GRPOQty']);
    //             $(`#ContainerNOS`).val(JSONObject[0]['ContainerNos']);
    //             $(`#TotNoCont`).val(JSONObject[0]['NoOfcontainer']);
    //             $(`#FromCont`).val(JSONObject[0]['FromContainer']);
    //             $(`#ToCont`).val(JSONObject[0]['ToContainer']);
    //             $(`#Container`).val(JSONObject[0]['Container']);
    //             $(`#QtyPerContainer`).val(JSONObject[0]['QtyPerContainer']);

    //             //  <!-- --------------- Cancelled Checkbox Set Value Start Here ---------------- -->
    //                 var Canceled=JSONObject[0]['Canceled'];

    //                 if(Canceled=='N'){
    //                     document.getElementById("StatusChekBox").checked = false; // Uncheck
    //                 }else{
    //                     document.getElementById("StatusChekBox").checked = true; // Check
    //                 }
    //             //  <!-- --------------- Cancelled Checkbox Set Value end Here ---------------- -->

    //             // <!-- ----------- Hidden Field Start Here ----------------------- -->
    //                 $(`#LineNum`).val(JSONObject[0]['LineNum']);
    //                 $(`#Unit`).val(JSONObject[0]['Unit']);
    //             // <!-- ----------- Challan Field Start Here ----------------------- -->

    //             // <!-- ----------- Challan Date Start Here ----------------------- -->
    //                 var chDateOG = JSONObject[0]['ChDate'];
    //                 ChDate = chDateOG.split(' ')[0];
    //                 $(`#ChDate`).val(ChDate);
    //             // <!-- ----------- Challan Date End Here ------------------------- -->

    //             // <!-- ----------- Expiry Date Start Here ----------------------- -->
    //                 var expiryDateOG = JSONObject[0]['ExpiryDate'];
    //                 ExpiryDate = expiryDateOG.split(' ')[0];
    //                 $(`#ExpiryDate`).val(ExpiryDate);
    //             // <!-- ----------- Expiry Date End Here ------------------------- -->

    //             // <!-- ----------- MfgDate Start Here ----------------------- -->
    //                 var mfgDateOG = JSONObject[0]['ExpiryDate'];
    //                 MfgDate = mfgDateOG.split(' ')[0];
    //                 $(`#MfgDate`).val(MfgDate);
    //             // <!-- ----------- MfgDate End Here ------------------------- -->

    //             // <!-- ----------- Posting Date Start Here ----------------------- -->
    //                 var postingDateOG = JSONObject[0]['PostingDate'];
    //                 PostingDate = postingDateOG.split(' ')[0];
    //                 $(`#PostingDate`).val(PostingDate);
    //             // <!-- ----------- Posting Date End Here ------------------------- -->
    //         },
    //         complete:function(data){
    //             getSeriesDropdown() // DocName By using API to get dropdown 
    //         }
    //     }); 
    // }

    // function getSeriesDropdown()
    // {
    //     var dataString ='ObjectCode=SCS_SINTIMATION&action=getSeriesDropdown_ajax';

    //     $.ajax({
    //         type: "POST",
    //         url: 'ajax/common-ajax.php',
    //         data: dataString,
    //         cache: false,

    //         beforeSend: function(){
    //         },
    //         success: function(result)
    //         {
    //             var SeriesDropdown = JSON.parse(result);
    //             $('#DocNoName').html(SeriesDropdown);
    //         },
    //         complete:function(data){
    //             selectedSeries(); // call Selected Series Single data function
    //         }
    //     }); 
    // }

    // function selectedSeries(){

    //     var Series=document.getElementById('DocNoName').value;
    //     var dataString ='Series='+Series+'&ObjectCode=SCS_SINTIMATION&action=getSeriesSingleData_ajax';

    //     $.ajax({
    //         type: "POST",
    //         url: 'ajax/common-ajax.php',
    //         data: dataString,
    //         cache: false,

    //         beforeSend: function(){
    //         },
    //         success: function(result)
    //         {
    //             var JSONObject = JSON.parse(result);

    //             var NextNumber=JSONObject[0]['NextNumber'];
    //             var Series=JSONObject[0]['Series'];

    //             $('#DocNo').val(Series);
    //             $('#NextNumber').val(NextNumber);
    //         },
    //         complete:function(data){
    //             SampleTypeDropdown(); //Sample Type API to Get Dropdown
    //         }
    //     }); 
    // }

    // function SampleTypeDropdown()
    // {
    //     $.ajax({ 
    //         type: "POST",
    //         url: 'ajax/common-ajax.php',
    //         data:{'action':"SampleTypeDropdown_ajax"},

    //         beforeSend: function(){
    //         },
    //         success: function(result)
    //         {
    //             var SampleTypeDrop = JSON.parse(result);
    //             $('#SampleType').html(SampleTypeDrop);
    //         },
    //         complete:function(data){
    //             TR_ByDropdown() //TR By API to Get Dropdown
    //         }
    //     }); 
    // }

    // function TR_ByDropdown()
    // {
    //     $.ajax({ 
    //         type: "POST",
    //         url: 'ajax/common-ajax.php',
    //         data:{'action':"TR_ByDropdown_ajax"},

    //         beforeSend: function(){
    //         },
    //         success: function(result)
    //         {
    //             var SampleTypeDrop = JSON.parse(result);
    //             $('#TrType').html(SampleTypeDrop);
    //         },
    //         complete:function(data){
    //             $(".loader123").hide();
    //         }
    //     }); 
    // }

    // function SendSampleIntimationData(){

    //     var formData = new FormData($('#SampleIntimationForm')[0]);  // Form Id
    //     formData.append("SampleIntimationBtn",'SampleIntimationBtn');  // Button Id
    //     var error = true;

    //     $.ajax({
    //         url: 'ajax/common-ajax.php',
    //         type: "POST",
    //         data:formData,
    //         processData: false,
    //         contentType: false,
    //         beforeSend: function(){
    //             $(".loader123").show();
    //         },
    //         success: function(result)
    //         {
    //             var JSONObject = JSON.parse(result);

    //             var status = JSONObject['status'];
    //             var message = JSONObject['message'];
    //             var DocEntry = JSONObject['DocEntry'];
    //             if(status=='True'){
    //                 swal({
    //                   title: "Sample Intimation Add Successfully.!",
    //                   text: `${DocEntry}`,
    //                   icon: "success",
    //                   buttons: true,
    //                   dangerMode: false,
    //                 })
    //                 .then((willDelete) => {
    //                     if (willDelete) {
    //                         location.replace(window.location.href); //ok btn
    //                     }else{
    //                         location.replace(window.location.href); // cancel btn
    //                     }
    //                 });
    //             }else{
    //                 swal("Oops!", `${message}`, "error");
    //             }
    //         },complete:function(data){
    //             $(".loader123").hide();
    //         }
    //     });
    // }
</script>
<!-- 1532 -->