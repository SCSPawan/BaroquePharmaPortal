<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
    header("Location:login.php");
    exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list'){
    $getAllData=$obj->get_OTFSI_Data($RETESTQCSAMPLEINTIMATIONVIEW_API);
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
                        <th>GRPO No</th>
                        <th>GRPO DocEntry</th>
                        <th>Supplier Code</th>
                        <th>Supplier Name</th>
                        <th>BP Ref No</th>
                        <th>LineNum</th>
                        <th>Item Code</th> 
                        <th>Item Name</th>
                        <th>Unit</th>
                        <th>Batch No</th>
                        <th>Batch Qty</th>
                        <th>Mfg Date</th>
                        <th>Expiry Date</th>
                        <th>Location</th>
                        <th>Branch Name</th>
                        <th>Whse Code</th>
                        <th>Retest Date</th>
                        <th>MFG By</th>
                        <th>Make By</th>
                    </tr>
                </thead>
                <tbody>';
 
                if(count($getAllData)!='0'){
                    for ($i=$r_start; $i <$r_end ; $i++) { 
                        if(!empty($getAllData[$i]->SrNo)){   //  this condition save to extra blank loop

                            // --------------- Convert String code Start Here ---------------------------
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
                                
                                if(empty($getAllData[$i]->RetestDate)){
                                    $RetestDate='';
                                }else{
                                    $RetestDate=date("d-m-Y", strtotime($getAllData[$i]->RetestDate));
                                }

                                
                            // --------------- Convert String code End Here-- ---------------------------

                            $option.='
                                <tr>
                                    <td class="desabled">'.($i+1).'</td>

                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".sample-intimation" onclick="Retest_sample_intimation(\''.$getAllData[$i]->GRPODocEntry.'\',\''.$getAllData[$i]->BatchNo.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->LineNum.'\')">

                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </td>

                                    <td class="desabled">'.$getAllData[$i]->GRPONo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->GRPODocEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->SupplierCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->SupplierName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BpRefNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->LineNum.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Unit.'</td>     
                                    <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                    <td class="desabled">'.$MfgDate.'</td>
                                    <td class="desabled">'.$ExpiryDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Location.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BranchName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WhsCode.'</td>
                                    <td class="desabled">'.$RetestDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->MfgBy.'</td>
                                    <td class="desabled">'.$getAllData[$i]->MakeBy.'</td>
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
    <?php include 'models/retest_qc/sample_intimation_retest_qc_modal.php' ?>


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
                            <h4 class="mb-0">Sample Collection</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Sample Collection</li>
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
                                <h4 class="card-title mb-0">Open Transaction for Sample Intimation-Retest QC</h4> 
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

        <style type="text/css">
            body[data-layout=horizontal] .page-content {
                padding: 20px 0 0 0;
                padding: 40px 0 60px 0;
            }
        </style>

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

    function Retest_sample_intimation(DocEntry,BatchNo,ItemCode,LineNum)
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'DocEntry':DocEntry,'BatchNo':BatchNo,'ItemCode':ItemCode,'LineNum':LineNum,'action':"Retest_sample_intimation_popup"},

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                // console.log(JSONObject)

                $('#SIRT_GRPONo').val(JSONObject[0]['GRPONo']);
                $('#SIRT_GRPODocEntry').val(JSONObject[0]['GRPODocEntry']);
                $('#SIRT_VenderCode').val(JSONObject[0]['SupplierCode']);
                $('#SIRT_VenderName').val(JSONObject[0]['SupplierName']);
                $('#SIRT_BpRefNo').val(JSONObject[0]['BpRefNo']);
                $('#SIRT_SampleType').val('Retest'); // Fix Value
                $('#SIRT_ItemCode').val(JSONObject[0]['ItemCode']);
                $('#SIRT_ItemName').val(JSONObject[0]['ItemName']);
                $('#SIRT_GRPO_Qty').val(JSONObject[0]['GRPOQty']);
                $('#SIRT_SQty').val(JSONObject[0]['SQty']);
                $('#SIRT_UOM').val(JSONObject[0]['Unit']);
                $('#SIRT_RQty').val(JSONObject[0]['RQty']);
                $('#SIRT_MfgBy').val(JSONObject[0]['MfgBy']);
                $('#SIRT_NoOfcontainer').val(JSONObject[0]['TotNoCont']);
                $('#SIRT_FromContainer').val(JSONObject[0]['FromCont']);
                $('#SIRT_ToContainer').val(JSONObject[0]['ToCont']);
                $('#SIRT_Status').val(JSONObject[0]['Status']);
                $('#SIRT_BranchName').val(JSONObject[0]['BranchName']);
                $('#SIRT_ContainerNos').val(JSONObject[0]['ContainerNos']);
                $('#SIRT_Container').val(JSONObject[0]['Container']);
                $('#SIRT_BatchNo').val(JSONObject[0]['BatchNo']);
                $('#SIRT_BatchQty').val(JSONObject[0]['BatchQty']);
                $('#SIRT_Location').val(JSONObject[0]['Location']);

                $('#SIRT_MakeBy').val(JSONObject[0]['MakeBy']);
                $('#SIRT_QtyPerContainer').val(JSONObject[0]['QtyPerContainer']);
                
                

                //  <!-- --------------- Cancelled Checkbox Set Value Start Here ---------------- -->
                    var Canceled=JSONObject[0]['Canceled'];

                    if(Canceled=='N'){
                        document.getElementById("SIRT_StatusChekBox").checked = false; // Uncheck
                    }else{
                        document.getElementById("SIRT_StatusChekBox").checked = true; // Check
                    }
                //  <!-- --------------- Cancelled Checkbox Set Value end Here ---------------- -->

                // <!-- ----------- MfgDate Start Here ----------------------- -->
                    var mfgDateOG = JSONObject[0]['MfgDate'];
                    if(mfgDateOG!=''){
                        MfgDate = mfgDateOG.split(' ')[0];
                        $(`#SIRT_MfgDate`).val(MfgDate);
                    }
                // <!-- ----------- MfgDate End Here ------------------------- -->

                // <!-- ----------- Expiry Date Start Here ----------------------- -->
                    var expiryDateOG = JSONObject[0]['ExpiryDate'];
                    if(expiryDateOG!=''){
                        ExpiryDate = expiryDateOG.split(' ')[0];
                        $(`#SIRT_ExpiryDate`).val(ExpiryDate);
                    }
                // <!-- ----------- Expiry Date End Here ------------------------- -->

                // <!-- ----------- Retest Date Start Here ----------------------- -->
                    var retestDateOG = JSONObject[0]['RetestDate'];
                    if(retestDateOG!=''){
                        retestDate = retestDateOG.split(' ')[0];
                        $(`#SIRT_RetestDate`).val(retestDate);
                    }
                // <!-- ----------- Retest Date End Here ------------------------- -->

                // <!-- --------------- Hidden Field define start  here ---------------------------------- -->
                    $('#SIRT_LineNum').val(JSONObject[0]['LineNum']);
                    $('#SIRT_LocID').val(JSONObject[0]['LocID']);
                    $('#SIRT_BranchID').val(JSONObject[0]['BranchID']);
                    $('#SIRT_WhsCode').val(JSONObject[0]['WhsCode']);
                    // $('#SIRT_QtyPerContainer').val(JSONObject[0]['QtyPerContainer']);
                // <!-- --------------- Hidden Field define end  here ------------------------------------ -->

                TR_ByDropdown() //TR By API to Get Dropdown
                getSeriesDropdown() // DocName By using API to get dropdown 
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function getSeriesDropdown()
    {
        var TrDate=$('#SIRT_TrDate').val();
        var dataString ='TrDate='+TrDate+'&ObjectCode=SCS_SIRETEST&action=getSeriesDropdown_ajax';

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
                $('#SIRT_DocNoName').html(SeriesDropdown);
                selectedSeries(); // call Selected Series Single data function
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function selectedSeries(){

        var TrDate=$('#SIRT_TrDate').val();
        var Series=document.getElementById('SIRT_DocNoName').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=SCS_SIRETEST&action=getSeriesSingleData_ajax';

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
                // console.log(result);
                var JSONObject = JSON.parse(result);

                var NextNumber=JSONObject[0]['NextNumber'];
                var Series=JSONObject[0]['Series'];

                $('#SIRT_DocNo').val(Series);
                $('#SIRT_NextNumber').val(NextNumber);
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
                $('#SIRT_TrType').html(SampleTypeDrop);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function SendSampleIntimationRetestQC_Data(){

        var formData = new FormData($('#SampleIntimationRetestQCForm')[0]);  // Form Id
        formData.append("SampleIntimationRetestQCBtn",'SampleIntimationRetestQCBtn');  // Button Id
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
            }
            ,complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        });
    }
</script>
<!-- 929 total no. of line -->