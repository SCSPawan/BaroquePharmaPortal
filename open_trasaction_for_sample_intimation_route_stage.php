<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list')
{
    $getAllData=$obj->get_OTFSI_Data($ROUTESTAGEOPENTRANS_API);
    $count=count($getAllData);
    // echo '<pre>';
    // print_r($ROUTESTAGEOPENTRANS_API);echo '<br>';
    // print_r($getAllData);
    // die();
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
                        <th>Sr. No </th>  
                        <th>Item View</th>
                        <th>WO No</th>
                        <th>WOEntry</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Stage Name</th>
                        <th>Batch No</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Warehouse</th>
                        <th>WO Date</th>
                        <th>MFG Date</th>
                        <th>Expiry Date</th>
                        <th>Location</th>
                        <th>Branch Name</th>
                    </tr>
                </thead>
                <tbody>';
 
                if(count($getAllData)!='0'){
                    for ($i=$r_start; $i <$r_end ; $i++) { 
                        if(!empty($getAllData[$i]->WONo)){   //  this condition save to extra blank loop
                            $un_id=$i+1;

                            // --------------- Convert String code Start Here ---------------------------
                                if(empty($getAllData[$i]->WODate)){
                                    $WODate='';
                                }else{
                                    $WODate=date("d-m-Y", strtotime($getAllData[$i]->WODate));
                                }

                                if(empty($getAllData[$i]->MfgDate)){
                                    $MfgDate='';
                                }else{
                                    $MfgDate=date("d-m-Y", strtotime($getAllData[$i]->MfgDate));
                                }

                                if(empty($getAllData[$i]->ExpDate)){
                                    $ExpiryDate='';
                                }else{
                                    $ExpiryDate=date("d-m-Y", strtotime($getAllData[$i]->ExpDate));
                                }
                            // --------------- Convert String code End Here-- ---------------------------

                            $option.='
                                <tr>
                                    <td class="desabled">'.$un_id.'</td>

                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".sample-intimation-route-stage" onclick="sample_intimation(\''.$getAllData[$i]->WOEntry.'\',\''.$getAllData[$i]->BatchNo.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->StageName.'\')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td class="desabled">'.$getAllData[$i]->WONo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WOEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StageName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Quantity.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WareHouse.'</td>
                                    <td class="desabled">'.$WODate.'</td>
                                    <td class="desabled">'.$MfgDate.'</td>
                                    <td class="desabled">'.$ExpiryDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Location.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BranchName.'</td>
                                </tr>';
                        }
                    }
                }else{
                     $option.='<tr><td colspan="16" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
                }
        $option.='</tbody> 
    </table>'; 

    $option.=$pagination;        
    echo $option;
    exit(0);
}
?>

<?php include 'include/header.php' ?>
<?php include 'models/qc_process/sample_intimation_route_stage_model.php' ?>
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
                                <h4 class="mb-0">Open Transactions for Sample Intimation - Route Stage</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Open Transactions for Sample Intimation - Route Stage</li>
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
                                    <h4 class="card-title mb-0">Open Transactions for Sample Intimation - Route Stage</h4>  
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

    function sample_intimation(DocEntry,BatchNo,ItemCode,StageName)
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'DocEntry':DocEntry,'BatchNo':BatchNo,'ItemCode':ItemCode,'StageName':StageName,'action':"sample_intimation_RS_popup"},

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                // console.log(result);
                var JSONObject = JSON.parse(result);

                $(`#SIRS_ReceiptNo`).val(JSONObject[0]['ReceiptNo']);
                $(`#SIRS_WONo`).val(JSONObject[0]['WONo']);
                $(`#SIRS_RouteStage`).val(JSONObject[0]['StageName']);
                $(`#SIRS_ItemCode`).val(JSONObject[0]['ItemCode']);
                $(`#SIRS_ItemName`).val(JSONObject[0]['ItemName']);
                $(`#SIRS_WoQty`).val(JSONObject[0]['WOQty']);
                $(`#SIRS_WOEntry`).val(JSONObject[0]['WOEntry']);
                $(`#SIRS_SampleQty`).val(JSONObject[0]['SampleQty']);
                $(`#SIRS_RetainQty`).val(JSONObject[0]['RetainQty']);
                $(`#SIRS_Unit`).val(JSONObject[0]['Unit']);
                $(`#SIRS_BatchNo`).val(JSONObject[0]['BatchNo']);
                $(`#SIRS_BatchQty`).val(JSONObject[0]['BatchQty']);
                $(`#SIRS_TotNoCont`).val(JSONObject[0]['TotNoCont']);
                $(`#SIRS_FromCont`).val(JSONObject[0]['FromCont']);
                $(`#SIRS_ToCont`).val(JSONObject[0]['ToCont']);
                $(`#SIRS_Status`).val(JSONObject[0]['Status']);
                $(`#SIRS_Branch`).val(JSONObject[0]['BranchName']);
                $(`#SIRS_Location`).val(JSONObject[0]['Location']);
                $(`#SIRS_Container`).val(JSONObject[0]['Container']);
                $(`#SIRS_ContainerNos`).val(JSONObject[0]['ContainerNos']);
                $(`#SIRS_GateEntryNo`).val(JSONObject[0]['GateEntryNo']);

                // <!-- ----------- MfgDate Start Here ----------------------- -->
                    var mfgDateOG = JSONObject[0]['MfgDate'];
                    if(mfgDateOG!=''){
                        MfgDate = mfgDateOG.split(' ')[0];
                        $(`#SIRS_MfgDate`).val(MfgDate);
                    }
                // <!-- ----------- MfgDate End Here ------------------------- -->

                // <!-- ----------- Expiry Date Start Here ----------------------- -->
                    var expiryDateOG = JSONObject[0]['ExpDate'];
                    if(mfgDateOG!=''){
                        ExpiryDate = expiryDateOG.split(' ')[0];
                        $(`#SIRS_ExpiryDate`).val(ExpiryDate);
                    }
                // <!-- ----------- Expiry Date End Here --------------------------- -->

                // <!-- ----------- WO Date Start Here ----------------------- -->
                    var woDateOG = JSONObject[0]['WODate'];
                    if(woDateOG!=null){
                        woDate = woDateOG.split(' ')[0];
                        $(`#SIRS_WoDate`).val(woDate);
                    }
                // <!-- ----------- WO Date End Here --------------------------- -->

                //  <!-- --------------- Cancelled Checkbox Set Value Start Here ---------------- -->
                    var Canceled=JSONObject[0]['Cancelled'];

                    if(Canceled=='N'){
                        document.getElementById("SIRS_StatusChekBox").checked = false; // Uncheck
                        $(`#SIRS_StatusChekBox_val`).val(Canceled);
                    }else{
                        document.getElementById("SIRS_StatusChekBox").checked = true; // Check
                        $(`#SIRS_StatusChekBox_val`).val(Canceled);
                    }
                //  <!-- --------------- Cancelled Checkbox Set Value end Here ---------------- -->

                // <!-- ----------- Challan Date Start Here ----------------------- -->
                    var challanDateOG = JSONObject[0]['ChallanDate'];
                    if(challanDateOG!=null){
                        challanDate = challanDateOG.split(' ')[0];
                        $(`#SIRS_ChallanDate`).val(challanDate);
                    }
                // <!-- ----------- Challan Date End Here --------------------------- -->

                // <!-- ----------- Gate Entry Date Start Here ----------------------- -->
                    var gateEntryDateOG = JSONObject[0]['GateEntryDate'];
                    if(gateEntryDateOG!=null){
                        gateEntryDate = gateEntryDateOG.split(' ')[0];
                        $(`#SIRS_GateEntryDate`).val(gateEntryDate);
                    }
                // <!-- ----------- Gate Entry Date End Here --------------------------- -->

                // <!-- --------------------- Hidden Field Start Here ------------------------- -->
                    $(`#SIRS_BPLId`).val(JSONObject[0]['BPLId']);
                    $(`#SIRS_DocNum`).val(JSONObject[0]['DocNum']);
                    $(`#SIRS_LineNum`).val(JSONObject[0]['LineNum']);
                    $(`#SIRS_LocId`).val(JSONObject[0]['LocId']);
                    $(`#SIRS_Quantity`).val(JSONObject[0]['Quantity']);
                    $(`#SIRS_ReceiptQty`).val(JSONObject[0]['ReceiptQty']);
                    $(`#SIRS_WareHouse`).val(JSONObject[0]['WareHouse']);
                // <!-- --------------------- Hidden Field End Here --------------------------- -->

                SampleTypeDropdown(); //Sample Type API to Get Dropdown
                TR_ByDropdown() //TR By API to Get Dropdown
                getSeriesDropdown() // DocName By using API to get dropdown 
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function getSeriesDropdown()
    {   
        var TrDate= $('#SIRS_TrDate').val();
        var dataString ='TrDate='+TrDate+'&ObjectCode=SCS_SIRSTAGE&action=getSeriesDropdown_ajax';

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
                var SeriesDropdown = JSON.parse(result);
                $('#SIRS_DocNoName').html(SeriesDropdown);
                selectedSeries(); // call Selected Series Single data function
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function selectedSeries(){

        var TrDate= $('#SIRS_TrDate').val();
        var Series=document.getElementById('SIRS_DocNoName').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=SCS_SIRSTAGE&action=getSeriesSingleData_ajax';

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

                var NextNumber=JSONObject[0]['NextNumber'];
                var Series=JSONObject[0]['Series'];

                $('#SIRS_DocNo').val(Series);
                $('#SIRS_NextNumber').val(NextNumber);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function SampleTypeDropdown()
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'action':"SampleTypeDropdown_ajax"},

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                var SampleTypeDrop = JSON.parse(result);
                $('#SIRS_SampleType').html(SampleTypeDrop);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
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
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                var SampleTypeDrop = JSON.parse(result);
                $('#SIRS_TrBy').html(SampleTypeDrop);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function SendSampleIntimationRouteStageData(){

        var formData = new FormData($('#SampleIntimationRouteStageForm')[0]);  // Form Id
        formData.append("SampleIntimationRouteStageBtn",'SampleIntimationRouteStageBtn');  // Button Id
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
                // console.log(result);
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