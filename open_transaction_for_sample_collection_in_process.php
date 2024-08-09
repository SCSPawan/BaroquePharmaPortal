<?php 
require_once './classes/function.php';
require_once './classes/kri_function.php';
$obj= new web();
$objKri=new webKri();

// $str="Hellow world. it's a beutiful day";
// $array = explode(' ', $str);

// // echo '<pre>';
// print_r($array);
// die();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list'){
    $getAllData=$obj->get_OTFSI_Data($INPROCESSSAMPLECOLLECTIONVIEW);
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
                        <th>WO No</th>
                        <th>RFP Entry</th>
                        <th>Material Type</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Unit</th>
                        <th>Sample Qty</th> 
                        <th>Batch No</th>
                        <th>Batch Qty</th>
                        <th>MFG Date</th>
                        <th>Expiry Date</th>
                        <th>Doc Date</th>
                        <th>Branch Name</th>
                        <th>Sample Intimation No</th>
                        <th>Loaction</th>
                        <th>MakeBy</th>
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

                                if(empty($getAllData[$i]->ExpDate)){
                                    $ExpiryDate='';
                                }else{
                                    $ExpiryDate=date("d-m-Y", strtotime($getAllData[$i]->ExpDate));
                                }

                                if(empty($getAllData[$i]->DocDate)){
                                    $DocumentDate='';
                                }else{
                                    $DocumentDate=date("d-m-Y", strtotime($getAllData[$i]->DocDate));
                                }
                            // --------------- Convert String code End Here-- ---------------------------

                            $option.='
                                <tr>
                                    <td class="desabled" style="text-align: center;">'.$getAllData[$i]->SrNo.'.</td>
                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".sample-collection-in-process" onclick="OT_PoPup_SampleCollection_in_process(\''.$getAllData[$i]->RFPEntry.'\',\''.$getAllData[$i]->BatchNum.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->LineNo.'\')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td class="desabled">'.$getAllData[$i]->WONo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->RFPEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->MaterialType.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WOQty.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchNum.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                    <td class="desabled">'.$MfgDate.'</td>
                                    <td class="desabled">'.$ExpiryDate.'</td>
                                    <td class="desabled">'.$DocumentDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Branch.'</td>
                                    <td class="desabled">'.$getAllData[$i]->SampleIntimationNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Loaction.'</td>
                                    <td class="desabled">'.$getAllData[$i]->MakeBy.'</td>
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
<?php include 'models/qc_process/sample_collection_in_process_model.php' ?>

<style type="text/css">
    body[data-layout=horizontal] .page-content {padding: 20px 0 0 0;padding: 40px 0 60px 0;}
</style>
<!-- ---------- loader start here---------------------- -->
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
                                    <h4 class="mb-0">Open Transaction for Sample Collection - In Process</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Open Transaction for Sample Collection - In Process</li>
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
                                        <h4 class="card-title mb-0">Open Transaction for Sample Collection - In Process</h4> 
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
            data:{'DocEntry':DocEntry,'action':"Open_Transaction_For_Sample_collection_in_process_popup_in_process"},

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){
                var JSONObject = JSON.parse(result);
                
                // console.log('OT_PoPup_SampleCollection_in_process=>', JSONObject);
                
                $(`#IP_SC_RFPNo`).val(JSONObject[0].RFPNo);
                $(`#IP_SC_RFPEntry`).val(JSONObject[0].RFPEntry);
                $(`#IP_SC_WOEntry`).val(JSONObject[0].WOEntry);
                $(`#IP_SC_WONo`).val(JSONObject[0].WONo);
                $(`#IP_SC_Location`).val(JSONObject[0].Loaction);
                $(`#IP_SC_IntimatedBy`).val(JSONObject[0].IntimatedBy);
                $(`#IP_SC_ItemCode`).val(JSONObject[0].ItemCode);
                $(`#IP_SC_ItemName`).val(JSONObject[0].ItemName);
                $(`#IP_SC_BatchNo`).val(JSONObject[0].BatchNum);
                $(`#IP_SC_BatchQty`).val(JSONObject[0].BatchQty);
                $(`#IP_SC_MakeBy`).val(JSONObject[0].MakeBy);
                $(`#IP_SC_SampleQty`).val(JSONObject[0].SampleQty);
                $(`#IP_SC_SampleQtyUOM`).val(JSONObject[0].SampleQtyUOM);
                $(`#IP_SC_ARNo`).val(JSONObject[0].ARNo);
                $(`#IP_SC_NoOfContainer`).val(JSONObject[0].TotalNoContainer);
                $(`#IP_SC_UnderTestTransferNo`).val(JSONObject[0].UnderTransferNo);
                $(`#IP_SC_DateofReversal`).val(JSONObject[0].Dateofreversal);
                $(`#IP_SC_SampleIssue`).val('');
                $(`#IP_SC_ReverseSampleIssue`).val('');
                $(`#IP_SC_RetainQty`).val(JSONObject[0].RetainQty);
                $(`#IP_SC_RetainIssue`).val('');
                $(`#IP_SC_CntNo1`).val('');
                $(`#IP_SC_CntNo2`).val('');
                $(`#IP_SC_CntNo3`).val('');
                $(`#IP_SC_QtyForLabel`).val('');
                $(`#IP_SC_RetainQtyUOM`).val(JSONObject[0].RetainQtyUOM);
                $(`#IP_SC_LineNum`).val(JSONObject[0].LineNo);
                $(`#IP_SC_BPLId`).val(JSONObject[0].BPLId);
                $(`#IP_SC_LocCode`).val(JSONObject[0].LocCode);
                $(`#IP_SC_TRNo`).val(JSONObject[0].TRNo);
                $(`#IP_SC_Branch`).val(JSONObject[0].Branch);

                // <!-- ------------ IntimationDate Start Here --------------------- -->
                    var IntimationDateOG = JSONObject[0]['IntimationDate'];
                    if(IntimationDateOG!=''){
                        let [day, month, year] = IntimationDateOG.split(" ")[0].split("-");
                        let IntimationDate = `${day}-${month}-${year}`;
                        $(`#IP_SC_IntimatedDate`).val(IntimationDate);
                    }
                // <!-- ------------ IntimationDate End Here ----------------------- -->
            },
            complete:function(data){
                IngrediantTypeDropdown();
                TR_ByDropdown();
            }
        })
    }

    function IngrediantTypeDropdown(){
        $.ajax({ 
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data:{'action':"IngrediantTypeDropdown_SampleCollection_ajax"},
            beforeSend: function(){
            },
            success: function(result){
                // console.log(result);
                $('#IP_SC_IngediantType').html(result);
                IP_SC_IngediantType
            },
            complete:function(data){
                getSeriesDropdown(); // DocName By using API to get dropdown 
            }
        })
    }
    // SCS_SCINPROC
    function getSeriesDropdown(){
        var TrDate = $(`#IP_SC_DocDate`).val();
        var dataString ='TrDate='+TrDate+'&ObjectCode=SCS_SCINPROC&action=getSeriesDropdown_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
            },
            success: function(result){
                var SeriesDropdown = JSON.parse(result);
                $('#IP_SC_DocName').html(SeriesDropdown);
            },
            complete:function(data){
                selectedSeries(); // call Selected Series Single data function
            }
        })
    }

    function selectedSeries(){
        var TrDate = $(`#IP_SC_DocDate`).val();
        var Series=document.getElementById('IP_SC_DocName').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=SCS_SCINPROC&action=getSeriesSingleData_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
            },
            success: function(result){
                var JSONObject = JSON.parse(result);
                
                var NextNumber=JSONObject[0]['NextNumber'];
                var Series=JSONObject[0]['Series'];
                $('#IP_SC_DocNo').val(NextNumber);
                $('#IP_Series').val(Series);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }) 
    }

    function TR_ByDropdown(){
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'action':"TR_ByDropdown_ajax"},
            beforeSend: function(){
                // $(".loader123").show();
            },
            success: function(result){
                var SampleTypeDrop = JSON.parse(result);
                $('#IP_SC_smpleCollectBy').html(SampleTypeDrop);
            },
            complete:function(data){
                // $(".loader123").hide();
            }
        })
    }

    function SampleCollectionInProcess_Submit(){
        var formData = new FormData($('#OTSCP_Form')[0]);  // Form Id
        formData.append("SampleCollectionInProcess_Btn",'SampleCollectionInProcess_Btn');  // Button Id
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
                $(".loader123").hide();
            }
        })
    }
</script>