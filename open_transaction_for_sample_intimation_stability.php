<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list')
{
    $getAllData=$obj->get_OTFSI_Data($OPENTRANSSAMPINTSTABILITY_API);
    $count=count($getAllData);

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
                        <th>Period in Months</th>
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
                                    <td class="desabled">'.($i+1).'</td>

                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".stability-qc-check" onclick="sample_intimation(\''.$getAllData[$i]->StabilityPlanDocEntry.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->BatchNo.'\')">

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
                                    <td class="desabled">'.$getAllData[$i]->WONo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WODocEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->PlannedQty.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ReceiptNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ReceiptEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ReceiptQty.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityType.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityCondition.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityTimePeriod.'</td>
                                    <td class="desabled">'.$getAllData[$i]->AnalysisType.'</td>
                                    <td class="desabled">'.$getAllData[$i]->PeriodInMonths.'</td>
                                    <td class="desabled">'.$getAllData[$i]->PeriodType.'</td>
                                    <td class="desabled">'.$getAllData[$i]->AdditionalYear.'</td>
                                    <td class="desabled">'.$EndDate.'</td>
                                </tr>';
                        }
                    }
                }else{
                     $option.='<tr><td colspan="17" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
                }
        $option.='</tbody> 
    </table>'; 

    $option.=$pagination;        
    echo $option;
    exit(0);
}
?>

<?php include 'include/header.php' ?>
<?php include 'models/qc_process/sample_intimation_stability_model.php' ?>

<style type="text/css">
    body[data-layout=horizontal] .page-content {
        padding: 20px 0 0 0;
        padding: 40px 0 60px 0;
    }
</style>

<!-- ---------- loader start here---------------------- -->
    <div class="loader-top" style="height: 100%;width: 100%;background: #cccccc73;">
        <div class="loader123" style="text-align: center;z-index: 10000;position: fixed;top: 0; left: 0;bottom: 0;right: 0;background: #cccccc73;">
            <img src="loader/loader2.gif" style="width: 5%;padding-top: 288px !important;">
        </div>
    </div>
<!-- ---------- loader end here---------------------- -->

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">Open transaction For Sample Intimation - Stability</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Open transaction For Sample Intimation - Stability</li>
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
                                <h4 class="card-title mb-0">Open Transaction For Sample Intimation - Stability</h4>  
                            </div><!-- end card header -->
                                
                            <div class="card-body">
                                <div class="table-responsive" id="list-append"></div>                 
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

    // <!-- -------------- Direct called function diclear Start Here --------------------------------
        $(".loader123").hide(); // loader default hide script
    // <!-- -------------- Direct called function diclear End Here ----------------------------------

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

    function sample_intimation(DocEntry,ItemCode,BatchNo)
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'DocEntry':DocEntry,'BatchNo':BatchNo,'ItemCode':ItemCode,'action':"OT_sample_intimationStability_popup"},

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);

                // 1st Line-------------------------------------------------------------------------------------
                    $(`#SIS_P_ReceiptNo`).val(JSONObject[0]['ReceiptNo']);
                    $(`#SIS_P_ReceiptEntry`).val(JSONObject[0]['ReceiptEntry']);
                    $(`#SIS_P_WONo`).val(JSONObject[0]['WONo']);
                    $(`#SIS_P_WODocEntry`).val(JSONObject[0]['WODocEntry']);
                    $(`#SIS_P_SampleType`).val(JSONObject[0]['SampleType']);

                // 2nd Line-------------------------------------------------------------------------------------
                    $(`#SIS_P_ItemCode`).val(JSONObject[0]['ItemCode']);
                    $(`#SIS_P_ItemName`).val(JSONObject[0]['ItemName']);
                    $(`#SIS_P_ReciptNo`).val(JSONObject[0]['ReceiptQty']);

                // 3rd Line-------------------------------------------------------------------------------------
                    $(`#SIS_P_StabilityPlanQuantity`).val(JSONObject[0]['StabilityPlanQuantity']);
                    $(`#SIS_P_WhsCode`).val(JSONObject[0]['WhsCode']);
                    $(`#SIS_P_StabilityPlanDocNum`).val(JSONObject[0]['StabilityPlanDocNum']);
                    $(`#SIS_P_StabilityPlanDocEntry`).val(JSONObject[0]['StabilityPlanDocEntry']);

                // 4th Line-------------------------------------------------------------------------------------
                    $(`#SIS_P_Unit`).val(JSONObject[0]['Unit']);
                    $(`#SIS_P_TotalNoofContainer`).val(JSONObject[0]['TotalNoofContainer']);
                    $(`#SIS_P_QtyPerContainer`).val(JSONObject[0]['QtyPerContainer']);
                    $(`#SIS_P_FromContainer`).val(JSONObject[0]['FromContainer']);
                    $(`#SIS_P_ToContainer`).val(JSONObject[0]['ToContainer']);

                // 5th Line-------------------------------------------------------------------------------------
                    $(`#SIS_P_BatchNo`).val(JSONObject[0]['BatchNo']);
                    $(`#SIS_P_BatchQty`).val(JSONObject[0]['BatchQty']);

                    // <!-- ----------- MfgDate Start Here ---------------------------- -->
                        var mfgDateOG = JSONObject[0]['MfgDate'];
                        mfgDate = mfgDateOG.split(' ')[0];
                        $(`#SIS_P_MfgDate`).val(mfgDate);
                    // <!-- ----------- MfgDate End Here ------------------------------ -->

                    // <!-- ----------- Expiry Date Start Here ----------------------- -->
                        var expiryDateOG = JSONObject[0]['ExpiryDate'];
                        ExpiryDate = expiryDateOG.split(' ')[0];
                        $(`#SIS_P_ExpiryDate`).val(ExpiryDate);
                    // <!-- ----------- Expiry Date End Here ------------------------- -->

                // 6th Line-------------------------------------------------------------------------------------
                    $(`#SIS_P_StabilityTransferNoFromWo`).val(JSONObject[0]['StabilityTransferNoFromWo']);
                    $(`#SIS_P_StabilityTransferEntryFromWo`).val(JSONObject[0]['StabilityTransferEntryFromWo']);

                    // <!-- ----------- Retest Date Start Here ---------------------------------- -->
                        var retestDateOG = JSONObject[0]['RetestDate'];
                        retestDate = retestDateOG.split(' ')[0];
                        $(`#SIS_P_RetestDate`).val(retestDate);
                    // <!-- ----------- Retest Date End Here ------------------------------------ -->

                    // <!-- ----------- Stability Loading Date Start Here ----------------------- -->
                        var stabilityLoadingDateOG = JSONObject[0]['StabilityLoadingDate'];
                        StabilityLoadingDate = stabilityLoadingDateOG.split(' ')[0];
                        $(`#SIS_P_StabilityLoadingDate`).val(StabilityLoadingDate);
                    // <!-- ----------- Stability Loading Date End Here ------------------------- -->

                // 7th Line-------------------------------------------------------------------------------------
                    $(`#SIS_P_Status`).val(JSONObject[0]['Status']);
                    $(`#SIS_P_Branch`).val(JSONObject[0]['Branch']);
                    $(`#SIS_P_Location`).val(JSONObject[0]['Location']);

                    //  <!-- --------------- Cancelled Checkbox Set Value Start Here ---------------- -->
                        var Canceled=JSONObject[0]['Canceled'];

                        if(Canceled=='N'){
                            $(`#SIS_P_StatusChekBoxValue`).val(Canceled);
                            document.getElementById("SIS_P_StatusChekBox").checked = false; // Uncheck
                        }else{
                            $(`#SIS_P_StatusChekBoxValue`).val(Canceled);
                            document.getElementById("SIS_P_StatusChekBox").checked = true; // Check
                        }
                    //  <!-- --------------- Cancelled Checkbox Set Value end Here ---------------- -->

                // 8th Line-------------------------------------------------------------------------------------
                    $(`#SIS_P_StabilityType`).val(JSONObject[0]['StabilityType']);
                    $(`#SIS_P_StabilityCondition`).val(JSONObject[0]['StabilityCondition']);
                    $(`#SIS_P_StabilityTimePeriod`).val(JSONObject[0]['StabilityTimePeriod']);
                    $(`#SIS_P_AnalysisType`).val(JSONObject[0]['AnalysisType']);

                // 9th Line-------------------------------------------------------------------------------------
                    $(`#SIS_P_ContainerNos`).val(JSONObject[0]['ContainerNos']);
                    $(`#SIS_P_Container`).val(JSONObject[0]['Container']);

                // Hidden field mapped Start Here --------------------------------------------------------------
                    $(`#SIS_P_BPLId`).val(JSONObject[0]['BPLId']);
                    $(`#SIS_P_LocCode`).val(JSONObject[0]['LocCode']);
                    $(`#SIS_P_WhsTotal`).val(JSONObject[0]['WhsTotal']);
                    $(`#SIS_P_BaseType`).val(JSONObject[0]['BaseType']);
                    $(`#SIS_P_BaseEntry`).val(JSONObject[0]['BaseEntry']);
                    $(`#SIS_P_BaseNum`).val(JSONObject[0]['BaseNum']);
                    $(`#SIS_P_DocDate`).val(JSONObject[0]['DocDate']);
                    $(`#SIS_P_Quantity`).val(JSONObject[0]['Quantity']);
                    $(`#SIS_P_AdditionalYear`).val(JSONObject[0]['AdditionalYear']);
                    $(`#SIS_P_EndDate`).val(JSONObject[0]['EndDate']);
                    $(`#SIS_P_PeriodType`).val(JSONObject[0]['PeriodType']);
                    $(`#SIS_P_PeriodInMonths`).val(JSONObject[0]['PeriodInMonths']);
                    $(`#SIS_P_PlannedQty`).val(JSONObject[0]['PlannedQty']);
                // Hidden field mapped End Here ---------------------------------------------------------------- 
            },
            complete:function(data){
                getSeriesDropdown() // DocName By using API to get dropdown 
            }
        }); 
    }

    function getSeriesDropdown()
    {
        var dataString ='ObjectCode=SCS_SISTAB&action=getSeriesDropdown_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
            },
            success: function(result)
            {
                var SeriesDropdown = JSON.parse(result);
                $('#SIS_P_DocNoName').html(SeriesDropdown);
            },
            complete:function(data){
                selectedSeries(); // call Selected Series Single data function
            }
        }); 
    }

    function selectedSeries(){

        var Series=document.getElementById('SIS_P_DocNoName').value;
        var dataString ='Series='+Series+'&ObjectCode=SCS_SISTAB&action=getSeriesSingleData_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                var NextNumber=JSONObject[0]['NextNumber'];
                $('#SIS_P_DocNo').val(NextNumber);
            },
            complete:function(data){
                TR_ByDropdown() //TR By API to Get Dropdown
            }
        }); 
    }

    function TR_ByDropdown()
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'action':"TR_ByDropdown_ajax"},

            beforeSend: function(){
            },
            success: function(result)
            {
                var SampleTypeDrop = JSON.parse(result);
                $('#SIS_P_TrBy').html(SampleTypeDrop);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function SendOT_SampleIntimationData(){

        var formData = new FormData($('#OT_SampleIntimationForm')[0]);  // Form Id
        formData.append("OP_SampleIntimationBtn",'OP_SampleIntimationBtn');  // Button Id
        var error = true;

        $.ajax({
            url: 'ajax/common-ajax.php',
            type: "POST",
            data:formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
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
                      title: `${DocEntry}`,
                      text: `${message}`,
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
                $(".loader123").hide();
            }
        });
    }
</script>