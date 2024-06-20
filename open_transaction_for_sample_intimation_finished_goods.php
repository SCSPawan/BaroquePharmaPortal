<?php 
require_once './classes/function.php';
require_once './classes/kri_function.php';
$obj= new web();
$objKri=new webKri();

if(empty($_SESSION['Baroque_EmployeeID'])) {
    header("Location:login.php");
    exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list'){
    $getAllData=$obj->get_OTFSI_Data($FGOPENTRANSSAMINTIMATION);
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
                        <th>Sr. No </th>
                        <th>Item View</th>
                        <th>WO No</th>
                        <th>RFP Entry</th>
                        <th>Material Type</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Unit</th>
                        <th>WO Qty</th> 
                        <th>Batch No</th>
                        <th>Mfg Date</th>
                        <th>Expiry Date</th>
                        <th>Batch Qty</th>
                        <th>Branch Name</th>
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
                            // --------------- Convert String code End Here-- ---------------------------

                            $option.='
                                <tr>
                                    <td class="desabled" style="text-align: center;">'.$getAllData[$i]->SrNo.'.</td>
                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".sample-intimation-finished-goods" onclick="OT_PoPup_SampleCollection_in_process(\''.$getAllData[$i]->RFPODocEntry.'\',\''.$getAllData[$i]->BatchNo.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->LineNum.'\')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td class="desabled">'.$getAllData[$i]->WONo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->RFPODocEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->MaterialType.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WOQty.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                    <td class="desabled">'.$MfgDate.'</td>
                                    <td class="desabled">'.$ExpiryDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BranchName.'</td>
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
<?php include 'models/qc_process/sample_intimation_finished_goods_model.php' ?>

<style type="text/css">
    body[data-layout=horizontal] .page-content {padding: 20px 0 0 0;padding: 40px 0 60px 0;}
</style>

         <div class="loader-top" style="height: 100%;width: 100%;background: #cccccc73;">
                <div class="loader123" style="text-align: center;z-index: 10000;position: fixed;top: 0; left: 0;bottom: 0;right: 0;background: #cccccc73;">
                    <img src="loader/loader2.gif" style="width: 5%;padding-top: 288px !important;">
                </div>
            </div>
            
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Open Transaction for Sample Intimation - Finished Goods</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Open Transaction for Sample Intimation - Finished Goods</li>
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
                                        <h4 class="card-title mb-0">Open Transaction for Sample Intimation - Finished Goods</h4>  
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

           <?php include 'include/footer.php' ?>

<script type="text/javascript">
    $(".loader123").hide(); // loader default hide script

    $(document).ready(function(){
        var dataString ='action=list';

        $.ajax({  
            type: "POST",  
            url: window.location.href,  
            data: dataString,  
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){  
                $('#list-append').html(result);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        })
    });

    function OT_PoPup_SampleCollection_in_process(DocEntry,BatchNo,ItemCode,LineNum){
        $.ajax({ 
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data:{'DocEntry':DocEntry,'BatchNo':BatchNo,'ItemCode':ItemCode,'LineNum':LineNum,'action':"OT_Open_Transaction_For_Sample_Intimation_FG_popup_in_process"},

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){
                var JSONObject = JSON.parse(result);
                // console.log('JSONObject=>', JSONObject);

                $(`#finished_good_RFPNo`).val(JSONObject[0].RFPNo);
                $(`#finished_good_RFPODocEntry`).val(JSONObject[0].RFPODocEntry);
                $(`#finished_good_WOEntry`).val(JSONObject[0].WOEntry);
                $(`#finished_good_WONo`).val(JSONObject[0].WONo);
                $(`#finished_good_BPRefNo`).val(JSONObject[0].BpRefNo);
                $(`#finished_good_ItemCode`).val(JSONObject[0].ItemCode);
                $(`#finished_good_ItemName`).val(JSONObject[0].ItemName);
                $(`#finished_good_GRPOQty`).val(JSONObject[0].WOQty);
                $(`#finished_good_SampleQty`).val(JSONObject[0].SQty);
                $(`#finished_good_RetainQty`).val(JSONObject[0].RQty);
                // $(`#finished_good_ReceiptQty`).val(JSONObject[0].WOQty);
                
                $(`#finished_good_MFGBy`).val(JSONObject[0].MfgBy);
                $(`#finished_good_TotalNoofcontainer`).val(JSONObject[0].TotNoCont);
                $(`#finished_good_FromContainer`).val(JSONObject[0].FromCont);
                $(`#finished_good_ToContainer`).val(JSONObject[0].ToCont);
                $(`#finished_good_BatchNo`).val(JSONObject[0].BatchNo);
                $(`#finished_good_BatchQty`).val(JSONObject[0].BatchQty);

                $(`#finished_good_MFGDate`).val(DateFormatingDMY(JSONObject[0].MfgDate));
                $(`#finished_good_ExpiryDate`).val(DateFormatingDMY(JSONObject[0].ExpiryDate));
                $(`#finished_good_RetestDate`).val(DateFormatingDMY(JSONObject[0].RetestDate));

                $(`#finished_good_Status`).val(JSONObject[0].Status);
                $(`#finished_good_Branch`).val(JSONObject[0].BranchName);
                $(`#finished_good_ChallanNo`).val(JSONObject[0].ChNo);
                $(`#finished_good_ChallanDate`).val(JSONObject[0].ChDate);
                $(`#finished_good_GateEntryNo`).val(JSONObject[0].GateEntryNo);
                $(`#finished_good_GateEntryDate`).val(JSONObject[0].GateEntryDate);
                $(`#finished_good_ContainersNo`).val(JSONObject[0].ContainerNos);
                $(`#finished_good_Container`).val(JSONObject[0].Container);
                $(`#finished_good_LineNum`).val(JSONObject[0].LineNum);
                $(`#finished_good_Unit`).val(JSONObject[0].Unit);
                $(`#finished_good_FromCont`).val(JSONObject[0].FromCont);
                $(`#finished_good_Location`).val(JSONObject[0].Location);
                $(`#finished_good_MakeBy`).val(JSONObject[0].MakeBy);

                var Canceled=JSONObject[0]['Canceled'];
                if(Canceled=='N'){
                    document.getElementById("flexCheckDefault").checked = true; // Check
                }else{
                    document.getElementById("flexCheckDefault").checked = false; // Uncheck
                }
            },
            complete:function(data){
                SampleTypeDropdown();
            }
        })
    }

    function SampleTypeDropdown(){
        var dataString ='action=SampleTypeDropdown_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
            },
            success: function(result){
                var JSONObject = JSON.parse(result);
                $('#finished_good_SampleType').html(JSONObject);
            },
            complete:function(data){
                getSeriesDropdown();
            }
        })
    }

    function getSeriesDropdown(){
        var TrDate= $('#finished_good_TRDate').val();
        var dataString ='TrDate='+TrDate+'&ObjectCode=SCS_SINTIFG&action=getSeriesDropdown_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
            },
            success: function(result){
                var SeriesDropdown = JSON.parse(result);
                $('#finished_good_DocName').html(SeriesDropdown);
            },
            complete:function(data){
                selectedSeries(); // call Selected Series Single data function
            }
        })
    }

    function selectedSeries(){
        var TrDate= $('#finished_good_TRDate').val();
        var Series=document.getElementById('finished_good_DocName').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=SCS_SINTIFG&action=getSeriesSingleData_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
            },
            success: function(result){
                var JSONObject = JSON.parse(result);

                var NextNumber=JSONObject[0]['NextNumber'];
                var Series=JSONObject[0]['Series'];

                $('#finished_good_DocNo').val(NextNumber);
                $('#finished_good_Series').val(Series);
            },
            complete:function(data){
                TR_ByDropdown();
            }
        })
    }   

    function TR_ByDropdown(){
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'action':"TR_ByDropdown_ajax"},
            beforeSend: function(){
            },
            success: function(result){
                var SampleTypeDrop = JSON.parse(result);
                $('#finished_good_TRBy').html(SampleTypeDrop);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        })
    }

    function DateFormatingDMY(DateOG){
        alert(DateOG);
        if(DateOG!=''){
            let [day, month, year] = DateOG.split(" ")[0].split("-");
            let Date = `${day}-${month}-${year}`;
            return Date;
        }
    }

    function SendSampleIntimationRetestQC_Data(){
        var formData = new FormData($('#SampleIntimationFinishedGoods_Form')[0]);  // Form Id
        formData.append("SampleIntimationfinishedGoodBtn",'SampleIntimationfinishedGoodBtn');  // Button Id
        var error = true;

        $.ajax({
            url: 'ajax/kri_production_common_ajax.php',
            type: "POST",
            data:formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){
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
        })
    }
</script>