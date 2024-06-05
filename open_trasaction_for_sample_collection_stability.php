<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list')
{
    $getAllData=$obj->get_OTFSI_Data($OPENTRANSSAMPCOLSTABILITY_API);
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
                        <th>Stability Intimation No</th>
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

                                if(empty($getAllData[$i]->MfgDate)){
                                    $MfgDate='';
                                }else{
                                    $MfgDate=date("d-m-Y", strtotime($getAllData[$i]->MfgDate));
                                }

                                if(empty($getAllData[$i]->ExpiryDate)){
                                    $ExpiryDate='';
                                }else{
                                    $ExpiryDate=date("d-m-Y", strtotime($getAllData[$i]->ExpiryDate));
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
                                    <td class="desabled" style="text-align: center;">'.($i+1).'.</td>

                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".sample-collectoin-stability" onclick="OTS_SampleCollection_popup(\''.$getAllData[$i]->StabilityPlanDocEntry.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->BatchNo.'\')">
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
                                    <td class="desabled">'.$getAllData[$i]->BPLId.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Location.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityPlanDocNum.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityPlanDocEntry.'</td>
                                    <td class="desabled">'.$StabilityLoadingDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityPlanQuantity.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityIntimationNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WONo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WODocEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->PlannedQty.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ReceiptNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ReceiptEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->RouteStageRecoProdReceiptQty.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityType.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityCondition.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StabilityTimePeriod.'</td>
                                    <td class="desabled">'.$getAllData[$i]->AnalysisType.'</td>
                                    <td class="desabled">'.$getAllData[$i]->PeriodinMonth.'</td>
                                    <td class="desabled">'.$getAllData[$i]->PeriodType.'</td>
                                    <td class="desabled">'.$getAllData[$i]->AdditionalYear.'</td>
                                    <td class="desabled">'.$EndDate.'</td>
                                </tr>';
                        }
                    }
                }else{
                     $option.='<tr><td colspan="18" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
                }
        $option.='</tbody> 
    </table>'; 

    $option.=$pagination;        
    echo $option;
    exit(0);
}
?>

<?php include 'include/header.php' ?>
<?php include 'models/qc_process/sample_collection_stability_model.php' ?>

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
                            <h4 class="mb-0">Open Transaction for Sample Collection - Stability</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Open Transaction for Sample Collection - Stability</li>
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
                                <h4 class="card-title mb-0">Open Transaction for Sample Collection - Stability</h4> 
                            </div>
                            <div class="card-body">

                                <div class="table-responsive" id="list-append">
                                    <!-- -----Append table list----- -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <!-- End Page-content -->
  
<?php include 'include/footer.php' ?>

<script type="text/javascript">
    $(".loader123").hide(); // loader default hide script

    $(document).ready(function()
    {
        var dataString ='action=list';
        
        $.ajax({  
            type: "POST",  
            url: window.location.href,  
            data: dataString,  
            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {  
                // console.log(result);
                $('#list-append').html(result);
            },
            complete:function(data){
                // Hide image container
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
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                $('#list-append').html(result);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        });
    }

    function OTS_SampleCollection_popup(DocEntry,ItemCode,BatchNo)
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'DocEntry':DocEntry,'ItemCode':ItemCode,'BatchNo':BatchNo,'action':"OTS_Sample_Collection_popup"},

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                
            // 1st line---------------------------------------------------------------
                    $(`#OTSCP_ReceiptNo`).val(JSONObject[0]['ReceiptNo']);
                    $(`#OTSCP_ReceiptEntry`).val(JSONObject[0]['ReceiptEntry']);
                    $(`#OTSCP_WONo`).val(JSONObject[0]['WONo']);
                    $(`#OTSCP_WODocEntry`).val(JSONObject[0]['WODocEntry']);

            // 2nd line---------------------------------------------------------------
                    $(`#OTSCP_IntimatedBy`).val(JSONObject[0]['IntimatedBy']);
                    $(`#OTSCP_Unit`).val(JSONObject[0]['Unit']);

                    // <!-- ----------- Intimat Date Start Here ----------------------- -->
                        var intimatdateOG = JSONObject[0]['IntimatedDate'];
                        if(intimatdateOG!=''){
                            intimatdate = intimatdateOG.split(' ')[0];
                            $(`#OTSCP_IntimatedDate`).val(intimatdate);
                        }
                    // <!-- ----------- Intimat Date End Here ------------------------- -->

            // 3rd line---------------------------------------------------------------
                    $(`#OTSCP_ARNo`).val(JSONObject[0]['ArNo']);
                    $(`#OTSCP_BatchNo`).val(JSONObject[0]['BatchNo']);
                    $(`#OTSCP_BatchQty`).val(JSONObject[0]['BatchQty']);
                    $(`#OTSCP_StabilityTransferNoFromWo`).val(JSONObject[0]['StabilityTransferNoFromWo']);

            // 4th line---------------------------------------------------------------
                    $(`#OTSCP_StabilityTransferEntryFromWo`).val(JSONObject[0]['StabilityTransferEntryFromWo']);
                    $(`#OTSCP_StabilityPlanDocNum`).val(JSONObject[0]['StabilityPlanDocNum']);
                    $(`#OTSCP_StabilityPlanDocEntry`).val(JSONObject[0]['StabilityPlanDocEntry']);

                    // <!-- ----------- Stability Loading Date Start Here ----------------------- -->
                        var stabilityLoadingDateOG = JSONObject[0]['StabilityLoadingDate'];
                        if(stabilityLoadingDateOG!=''){
                            stabilityLoadingDate = stabilityLoadingDateOG.split(' ')[0];
                            $(`#OTSCP_StabilityLoadingDate`).val(stabilityLoadingDate);
                        }
                    // <!-- ----------- Stability Loading Date End Here ------------------------- -->

            // 5th line---------------------------------------------------------------
                    $(`#OTSCP_StabilityPlanQuantity`).val(JSONObject[0]['StabilityPlanQuantity']);
                    $(`#OTSCP_StabilityIntimationNo`).val(JSONObject[0]['StabilityIntimationNo']);
                    $(`#OTSCP_TotalNoofContainer`).val(JSONObject[0]['TotalNoofContainer']);
                    $(`#OTSCP_WhsCode`).val(JSONObject[0]['WhsCode']);

            // 6th line---------------------------------------------------------------
                   
                    // <!-- ----------- MFG Date Start Here ----------------------- -->
                        var mfgDateOG = JSONObject[0]['MfgDate'];
                        if(mfgDateOG!=''){
                            mfgDate = mfgDateOG.split(' ')[0];
                            $(`#OTSCP_MfgDate`).val(mfgDate);
                        }
                    // <!-- ----------- MFG Date End Here ------------------------- -->

                    // <!-- ----------- Expiry Date Start Here ----------------------- -->
                        var expiryDateOG = JSONObject[0]['ExpiryDate'];
                        if(expiryDateOG!=''){
                            expiryDate = expiryDateOG.split(' ')[0];
                            $(`#OTSCP_ExpiryDate`).val(expiryDate);
                        }
                    // <!-- ----------- Expiry Date End Here ------------------------- -->

                    $(`#OTSCP_Branch`).val(JSONObject[0]['Branch']);

            // 7th line---------------------------------------------------------------
                    $(`#OTSCP_Location`).val(JSONObject[0]['Location']);
                    $(`#OTSCP_ItemCode`).val(JSONObject[0]['ItemCode']);
                    $(`#OTSCP_ItemName`).val(JSONObject[0]['ItemName']);
                    $(`#OTSCP_StabilityType`).val(JSONObject[0]['StabilityType']);

            // 8th line---------------------------------------------------------------
                    $(`#OTSCP_StabilityCondition`).val(JSONObject[0]['StabilityCondition']);
                    $(`#OTSCP_StabilityTimePeriod`).val(JSONObject[0]['StabilityTimePeriod']);
                    $(`#OTSCP_AnalysisType`).val(JSONObject[0]['AnalysisType']);

            // Hidden Field mapping Here ---------------------------------------------------------------
                    $(`#OTSCP_BPLId`).val(JSONObject[0]['BPLId']);
                    $(`#OTSCP_LocCode`).val(JSONObject[0]['LocCode']);
                    $(`#OTSCP_UnderTestTransferNo`).val(JSONObject[0]['UnderTestTransferNo']);
                    $(`#OTSCP_SampleIssue`).val(JSONObject[0]['SampleIssue']);
                    $(`#OTSCP_QtyForLabel`).val(JSONObject[0]['QtyForLabel']);
                    $(`#OTSCP_FromContainer`).val(JSONObject[0]['FromContainer']);
                    $(`#OTSCP_ToContainer`).val(JSONObject[0]['ToContainer']);
                    $(`#OTSCP_QtyPerContainer`).val(JSONObject[0]['QtyPerContainer']);
                    $(`#OTSCP_WhsTotal`).val(JSONObject[0]['WhsTotal']);
                    $(`#OTSCP_BaseType`).val(JSONObject[0]['BaseType']);
                    $(`#OTSCP_BaseEntry`).val(JSONObject[0]['BaseEntry']);
                    $(`#OTSCP_BaseNum`).val(JSONObject[0]['BaseNum']);
                    $(`#OTSCP_Quantity`).val(JSONObject[0]['Quantity']);
                    $(`#OTSCP_AdditionalYear`).val(JSONObject[0]['AdditionalYear']);
                    $(`#OTSCP_EndDate`).val(JSONObject[0]['EndDate']);
                    $(`#OTSCP_PeriodType`).val(JSONObject[0]['PeriodType']);
                    $(`#OTSCP_RouteStageRecoProdReceiptQty`).val(JSONObject[0]['RouteStageRecoProdReceiptQty']);
                    $(`#OTSCP_PlannedQty`).val(JSONObject[0]['PlannedQty']);
                    $(`#OTSCP_PeriodinMonth`).val(JSONObject[0]['PeriodinMonth']);
            },complete:function(data){
                IngrediantTypeDropdown() // Ingrediant Type API to Get Dropdown
            }
        }); 
    }

    function IngrediantTypeDropdown()
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'action':"IngrediantTypeDropdown_ajax"},

            beforeSend: function(){
            },
            success: function(result)
            {
                $('#OTSCP_IngredientsType').html(result);
            }
            ,
            complete:function(data){
                getSeriesDropdown() // DocName By using API to get dropdown 
            }
        }); 
    }

    function getSeriesDropdown()
    {
        var dataString ='ObjectCode=SCS_SCOLSTAB&action=getSeriesDropdown_ajax';

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
                $('#OTSCP_DocNoName').html(SeriesDropdown);
                
            },
            complete:function(data){
                selectedSeries(); // call Selected Series Single data function
            }
        }); 
    }

    function selectedSeries(){

        var Series=document.getElementById('OTSCP_DocNoName').value;
        var dataString ='Series='+Series+'&ObjectCode=SCS_SCOLSTAB&action=getSeriesSingleData_ajax';

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
            
                $('#OTSCP_DocNo').val(NextNumber);
            },
            complete:function(data){
                TR_ByDropdown() //TR & (Sample Collect By) By API to GetDropdown
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
                $('#OTSCP_SampleCollectBy').html(SampleTypeDrop);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function OTSCSP_Submit(){

        var formData = new FormData($('#OTSCSP_Form')[0]);  // Form Id
        formData.append("OTSCSP_Btn",'OTSCSP_Btn');  // Button Id
        var error = true;

        $.ajax({
            url: 'ajax/common-ajax.php',
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
                console.log(result);
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
            }
            ,complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        });
    }
</script>