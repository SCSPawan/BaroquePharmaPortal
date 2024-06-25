<?php 
require_once './classes/function.php';
$obj= new web();
if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list')
{
    $getAllData=$obj->get_OTFSI_Data($FGQCPOSTDOC_API);
    $count=count($getAllData);
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
                        <th>Sr.No </th>  
                        <th>Item View</th>
                        <th>WO No</th>
                        <th>RFP Entry</th>
                        <th>Material Type</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Unit</th>
                        <th>WO Qty</th> 
                        <th>Batch No</th>
                        <th>MFG Date</th>
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
                                    <td class="desabled" style="text-align: center;">'.($i+1).'.</td>

                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".qc-check-finished-goods" onclick="OT_PoPup_SampleCollection(\''.$getAllData[$i]->RFPDocEntry.'\',\''.$getAllData[$i]->BatchNo.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->LineNum.'\')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </td>

                                    <td class="desabled">'.$getAllData[$i]->WONo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->RFPDocEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->MaterialType.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WOQty.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                    <td class="desabled">'.$MfgDate.'</td>
                                    <td class="desabled">'.$ExpiryDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
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

<?php

// require_once './classes/function.php';
// require_once './classes/kri_function.php';
// $obj= new web();
// $objKri=new webKri();

// if(empty($_SESSION['Baroque_EmployeeID'])) {
//   header("Location:login.php");
//   exit(0);
// }
?>

<?php include 'include/header.php' ?>
<?php include 'models/qc_process/qc_check_finished_goods_model.php' ?>
<style type="text/css">
    body[data-layout=horizontal] .page-content {
        padding: 20px 0 0 0;
        padding: 40px 0 60px 0;
    }
    .form-control[readonly] {
        background-color: #efefef;
        opacity: 1;
        border: 1px solid #efefef !important;
    }
    .form-select:focus {
    border-color: #cbced1;
    outline: 0;
     /*-webkit-box-shadow: 0 0 0 0.15rem rgb(57 128 192 / 25%); */
     box-shadow: none; 
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
                            <h4 class="mb-0">Open Transaction For QC Check - Finished Goods</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Open Transaction For QC Check - Finished Goods</li>
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
                                <h4 class="card-title mb-0">Open Transaction For QC Check - Finished Goods</h4>  
                            </div>

                            <div class="card-body">

                                <div class="table-responsive" id="list-append"></div>

                               <!--  <div class="table-responsive" id="list">
                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                        <thead class="fixedHeader1">
                                            <tr>
                                                <th>Item View</th>
                                                <th>Sr.No </th>  
                                                <th>WO No</th>
                                                <th>RFP Entry</th>
                                                <th>Material Type</th>
                                                <th>Item Code</th>
                                                <th>Item Name</th>
                                                <th>Unit</th>
                                                <th>WO Qty</th> 
                                                <th>Batch No</th>
                                                <th>MFG Date</th>
                                                <th>Expiry Date</th>
                                                <th>Batch Qty</th>
                                                <th>Branch Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="width: 100px;vertical-align: middle; text-align: center;">
                                                    <a href="" class="" data-bs-toggle="modal" data-bs-target=".qc-check-finished-goods">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                                <td class="desabled">1</td>
                                                <td class="desabled">1001</td>
                                                <td class="desabled">1001</td>
                                                <td class="desabled">FG</td>
                                                <td class="desabled"><input class="desabled border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97" readonly></td>
                                                <td class="desabled"><input class="desabled border_hide" type="text" id="" name="" class="form-control" value="AIDES MARKETTI" readonly></td>
                                                <td class="desabled">Kgs</td>
                                                <td class="desabled">30,000</td>
                                                <td class="desabled"><input class="desabled border_hide" type="text" id="" name="" class="form-control" value="20210709" readonly></td>
                                                <td class="desabled">08-10-2021</td>
                                                <td class="desabled">08-10-2021</td>
                                                <td class="desabled">30,000</td>
                                                <td class="desabled">ABS Company Pvt. Ltd</td>
                                            </tr>

                                            <tr>
                                                <td style="width: 100px;vertical-align: middle; text-align: center;">
                                                    <a href="" class="" data-bs-toggle="modal" data-bs-target=".qc-check-finished-goods">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                                <td class="desabled">1</td>
                                                <td class="desabled">1001</td>
                                                <td class="desabled">1001</td>
                                                <td class="desabled">FG</td>
                                                <td class="desabled"><input class="desabled border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97" readonly></td>
                                                <td class="desabled"><input class="desabled border_hide" type="text" id="" name="" class="form-control" value="AIDES MARKETTI" readonly></td>
                                                <td class="desabled">Kgs</td>
                                                <td class="desabled">30,000</td>
                                                <td class="desabled"><input class="desabled border_hide" type="text" id="" name="" class="form-control" value="20210709" readonly></td>
                                                <td class="desabled">08-10-2021</td>
                                                <td class="desabled">08-10-2021</td>
                                                <td class="desabled">30,000</td>
                                                <td class="desabled">ABS Company Pvt. Ltd</td>
                                            </tr>

                                            <tr>
                                                <td style="width: 100px;vertical-align: middle; text-align: center;">
                                                    <a href="" class="" data-bs-toggle="modal" data-bs-target=".qc-check-finished-goods">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                                <td class="desabled">1</td>
                                                <td class="desabled">1001</td>
                                                <td class="desabled">1001</td>
                                                <td class="desabled">FG</td>
                                                <td class="desabled"><input class="desabled border_hide" type="text" id="" name="" class="form-control" value="FG_DR_97" readonly></td>
                                                <td class="desabled"><input class="desabled border_hide" type="text" id="" name="" class="form-control" value="AIDES MARKETTI" readonly></td>
                                                <td class="desabled">Kgs</td>
                                                <td class="desabled">30,000</td>
                                                <td class="desabled"><input class="desabled border_hide" type="text" id="" name="" class="form-control" value="20210709" readonly></td>
                                                <td class="desabled">08-10-2021</td>
                                                <td class="desabled">08-10-2021</td>
                                                <td class="desabled">30,000</td>
                                                <td class="desabled">ABS Company Pvt. Ltd</td>
                                            </tr>

                                        </tbody> 
                                    </table>
                                </div>  -->

                            </div>
                        </div>
                    </div>
                </div>

            </div>
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

    function OT_PoPup_SampleCollection(DocEntry,BatchNo,ItemCode,LineNum)
    {
        // console.log('DocEntry=>', DocEntry);
        // console.log('BatchNo=>', BatchNo);
        // console.log('ItemCode=>', ItemCode);
        // console.log('LineNum=>', LineNum);
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'DocEntry':DocEntry,'BatchNo':BatchNo,'ItemCode':ItemCode,'LineNum':LineNum,'action':"OT_QC_check_FG_ajax"},

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObjectAll = JSON.parse(result);

                var JSONObject=JSONObjectAll['AllData'];
                // console.log(JSONObject);
                $(`#Qc_Post_FG_GD_list_append`).html(JSONObjectAll['general_data']); // General Data Append here

                // 1st Line
                    $(`#OTFQCCFG_WONo`).val(JSONObject[0]['WONo']);
                    $(`#OTFQCCFG_WODocEntry`).val(JSONObject[0]['WODocEntry']);
                    $(`#OTFQCCFG_ItemCode`).val(JSONObject[0]['ItemCode']);
                    $(`#OTFQCCFG_ItemName`).val(JSONObject[0]['ItemName']);
                    $(`#OTFQCCFG_GenericName`).val('*****'); // -------------------------------------------------- Missing

                // 2nd Line
                    $(`#OTFQCCFG_LabelClaim`).val(JSONObject[0]['LabelClaim']);
                    $(`#OTFQCCFG_RecievedQty`).val('*****'); // -------------------------------------------------- Missing
                    $(`#OTFQCCFG_MfgBy`).val(JSONObject[0]['MfgBy']);
                    $(`#OTFQCCFG_RFPNo`).val(JSONObject[0]['RFPNo']);

                // 3rd Line
                    $(`#OTFQCCFG_BatchNo`).val(JSONObject[0]['BatchNo']);
                    $(`#OTFQCCFG_BatchQty`).val(JSONObject[0]['BatchQty']);
                    $(`#OTFQCCFG_PackSize`).val(JSONObject[0]['PackSize']);

                // 4th Line
                    $(`#OTFQCCFG_MaterialType`).val(JSONObject[0]['MaterialType']);
                    $(`#OTFQCCFG_BranchName`).val(JSONObject[0]['BranchName']);
                    $(`#OTFQCCFG_ARNo`).val(JSONObject[0]['ARNo']);

                // <!-- --------------- footer section data mapping start here ----------------- -->
                    $(`#OTFQCCFG_Factor`).val(JSONObject[0]['Factor']);

                    $(`#OTFQCCFG_TNCont`).val(JSONObject[0]['TNCont']);
                    $(`#OTFQCCFG_FCont`).val(JSONObject[0]['FCont']);
                    $(`#OTFQCCFG_TCont`).val(JSONObject[0]['TCont']);
                // <!-- --------------- footer section data mapping end here ------------------- -->

                // <!-- --------------- Hidden data mapping Start here ------------------------- -->
                    $(`#OTFQCCFG_BPLId`).val(JSONObject[0]['BPLId']);
                    $(`#OTFQCCFG_BpRefNo`).val(JSONObject[0]['BpRefNo']);
                    $(`#OTFQCCFG_ExpiryDate`).val(JSONObject[0]['ExpiryDate']);
                    $(`#OTFQCCFG_FrgnName`).val(JSONObject[0]['FrgnName']);
                    $(`#OTFQCCFG_GEDate`).val(JSONObject[0]['GEDate']);
                    $(`#OTFQCCFG_GateENo`).val(JSONObject[0]['GateENo']);
                    $(`#OTFQCCFG_LabelClaimUOM`).val(JSONObject[0]['LabelClaimUOM']);
                    $(`#OTFQCCFG_LineNum`).val(JSONObject[0]['LineNum']);
                    $(`#OTFQCCFG_LocCode`).val(JSONObject[0]['LocCode']);
                    $(`#OTFQCCFG_Location`).val(JSONObject[0]['Location']);
                    $(`#OTFQCCFG_MfgDate`).val(JSONObject[0]['MfgDate']);
                    $(`#OTFQCCFG_Qty`).val(JSONObject[0]['Qty']);
                    $(`#OTFQCCFG_RFPDocEntry`).val(JSONObject[0]['RFPDocEntry']);
                    $(`#OTFQCCFG_RetestDate`).val(JSONObject[0]['RetestDate']);
                    $(`#OTFQCCFG_SampleCollectionNo`).val(JSONObject[0]['SampleCollectionNo']);
                    $(`#OTFQCCFG_SampleIntimationNo`).val(JSONObject[0]['SampleIntimationNo']);
                    $(`#OTFQCCFG_SampleQty`).val(JSONObject[0]['SampleQty']);
                    $(`#OTFQCCFG_SpecfNo`).val(JSONObject[0]['SpecfNo']);
                    $(`#OTFQCCFG_SrNo`).val(JSONObject[0]['SrNo']);
                    $(`#OTFQCCFG_SupplierCode`).val(JSONObject[0]['SupplierCode']);
                    $(`#OTFQCCFG_SupplierName`).val(JSONObject[0]['SupplierName']);
                    $(`#OTFQCCFG_Unit`).val(JSONObject[0]['Unit']);
                    $(`#OTFQCCFG_WOQty`).val(JSONObject[0]['WOQty']);
                // <!-- --------------- Hidden data mapping End here --------------------------- -->
            },
            complete:function(data){
                SampleTypeDropdown(); //Sample Type API to Get Dropdown
            }
        }); 
    }

     function SampleTypeDropdown(){

        var dataString ='TableId=@SCS_QCPD&Alias=SamType&action=dropdownMaster_ajax';
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
                $('#OTFQCCFG_SampleType').html(JSONObject);
            },
            complete:function(data){
                getSeriesDropdown();
            }
        });
    }

    function getSeriesDropdown()
    {
        var dataString ='ObjectCode=SCS_QCPDFG&action=getSeriesDropdown_ajax';

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
                $('#OTFQCCFG_DocName').html(SeriesDropdown);
            },
            complete:function(data){
                selectedSeries(); // call Selected Series Single data function
            }
        }); 
    }

    function selectedSeries(){

        var Series=document.getElementById('OTFQCCFG_DocName').value;
        var dataString ='Series='+Series+'&ObjectCode=SCS_QCPDFG&action=getSeriesSingleData_ajax';

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
                //var NextNumber=JSONObject[0]['NextNumber'];
               
               // $('#OTFQCCFG_DocNo').val(NextNumber);
            },
            complete:function(data){
                AssayCalculationBasedOn();
            }
        }); 
    }

     function AssayCalculationBasedOn(){
        var dataString ='action=qc_assay_Calculation_Based_On_ajax';
        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_common-ajax.php',  
            data: dataString,  
            beforeSend: function(){
            },
            success: function(result){ 
                $('#assay_CalBasedOn').html(result);
            },
            complete:function(data){
                getResultOutputDropdown();
            }
       });
    }

    function getResultOutputDropdown(){

        var table = document.getElementById("tblQCCFG_GD");
        var trcount = table.tBodies[0].rows.length;

        $.ajax({ 
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data:{'action':"ResultOutputDropdown_ajax"},

            beforeSend: function(){
            },
            success: function(result)
            {
                for (let i = 0; i < trcount; i++) {
                    $('.dropdownResutl'+i).html(result); // dropdown set using class                            
                }
            },
            complete:function(data){
                QC_StatusByAnalystDropdown(trcount);
            }
        });         
    }

    function QC_StatusByAnalystDropdown(trcount){

        var dataString ='TableId=@SCS_QCPD1&Alias=QCStatus&action=dropdownMaster_ajax';

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
                for (let i = 0; i < trcount; i++) {
                    $('.qc_statusbyab'+i).html(JSONObject); // dropdown set using Class                            
                }
            },
            complete:function(data){
                // $(".loader123").hide();
                getQcStatusDropodwn();
            }
        });
    }

    function getQcStatusDropodwn(){
        var dataString ='action=qc_api_OQCSTATUS_ajax';
        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_common-ajax.php',  
            data: dataString,
            beforeSend: function(){
            },  
            success: function(result){ 
                $('.qc_status_selecte1').html(result);
            },
            complete:function(data){
                // $(".loader123").hide();
                getDoneByDroopdown();
            }
       });
    }

    function getDoneByDroopdown(){
        var dataString ='action=qc_get_SAMINTTRBY_ajax';
        $.ajax({  
            type: "POST",  
            dataType:'JSON',
            url: 'ajax/kri_common-ajax.php',  
            data: dataString,
            beforeSend: function(){
            }, 
            success: function(result){ 

                var html="";
                result.forEach(function(value,index){
                    if(value.TRBy!=""){
                        html +='<option value="'+value.TRBy+'">'+value.TRBy+'</option>';
                    }
                });

                $('.done-by-mo1').html(html);
            },
            complete:function(data){
                $(".loader123").hide();
                // getDoneByDroopdown();
            }
        });
    }
</script>


<script type="text/javascript">
    // indipandent function

    function CalculatePotency()
    {
        // <!-- -----------  LoD / Water Value Preparing Start Here ------------------------------- -->
            var lod_waterOG=document.getElementById('LoD_Water').value;

            if((parseFloat(lod_waterOG).toFixed(6))<='0.000000' || lod_waterOG=='' || lod_waterOG==null){
                var lod_water='0.000000';
                $('#LoD_Water').val(lod_water);
            }else{
                var lod_water=parseFloat(lod_waterOG).toFixed(6);
                $('#LoD_Water').val(lod_water);
            }
        // <!-- -----------  LoD / Water Value Preparing End Here --------------------------------- -->

        // <!-- -----------  AssayPotency Value Preparing Start Here ------------------------------- -->
            var assayPotencyOG=document.getElementById('AssayPotency').value;

            if((parseFloat(assayPotencyOG).toFixed(6))<='0.000000' || assayPotencyOG=='' || assayPotencyOG==null){
                var assayPotency='0.000000';
                $('#AssayPotency').val(assayPotency);
            }else{
                var assayPotency=parseFloat(assayPotencyOG).toFixed(6);
                $('#AssayPotency').val(assayPotency);
            }
        // <!-- -----------  AssayPotency Value Preparing End Here --------------------------------- -->

        var Potency=((100- parseFloat(lod_water))/100)*parseFloat(assayPotency); // Calculation

        $('#Potency').val(parseFloat(Potency).toFixed(6)); // Set Potency calculated val
    }

    function ManualSelectedTResultOut(un_id){
        var ResultOut=document.getElementById('result_output'+un_id).value;

        if(ResultOut=='-'){
            // BLANK
            $('#ResultOutTd'+un_id).attr('style', 'background-color: #ffffff');
            $('.dropdownResutl'+un_id).attr('style', 'background-color: #ffffff;border:1px solid #ffffff !important;');

        }else if(ResultOut=='FAIL'){
            // FAIL
            $('#ResultOutTd'+un_id).attr('style', 'background-color: #f8a4a4');
            $('.dropdownResutl'+un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');

        }else{

            $('#ResultOutTd'+un_id).attr('style', 'background-color: #c7f3c7');
            $('.dropdownResutl'+un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
        }
    }

    function SelectedQCStatus(un_id){

        var QC_StatusByAnalyst=document.getElementById('qC_status_by_analyst'+un_id).value;
        
        if(QC_StatusByAnalyst=='Complies'){

            $('#QC_StatusByAnalystTd'+un_id).attr('style', 'background-color: #c7f3c7');
            $('.qc_statusbyab'+un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
        
        }else if(QC_StatusByAnalyst=='Non Complies'){

            $('#QC_StatusByAnalystTd'+un_id).attr('style', 'background-color: #f8a4a4');
            $('.qc_statusbyab'+un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
        
        }else {

            $('#QC_StatusByAnalystTd'+un_id).attr('style', 'background-color: #ffffff');
            $('.qc_statusbyab'+un_id).attr('style', 'background-color: #ffffff;border:1px solid #ffffff !important;');
        }
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
            
            }else{

                $('.dropdownResutl'+un_id).val('FAIL');
                $('#ResultOutTd'+un_id).attr('style', 'background-color: #f8a4a4');
                $('.dropdownResutl'+un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');

            }
        }
    }

    function AddOTFQCCFG_Fun(){

        var formData = new FormData($('#OTFQCCFG_FORM')[0]);  // Form Id
        formData.append("OTFQCCFG_Btn",'OTFQCCFG_Btn');  // Button Id
        var error = true;

        $.ajax({
            url: 'ajax/common-ajax.php',
            type: "POST",
            data:formData,
            processData: false,
            contentType: false,
            // beforeSend: function(){
            //     $(".loader123").show();
            // },
            success: function(result)
            {     
            console.log(result);           
                // var JSONObject = JSON.parse(result);

                // var status = JSONObject['status'];
                // var message = JSONObject['message'];
                // var DocEntry = JSONObject['DocEntry'];
                // if(status=='True'){
                //     swal({
                //       title: `${message}`,
                //       text: `${DocEntry}`,
                //       icon: "success",
                //       buttons: true,
                //       dangerMode: false,
                //     })
                //     .then((willDelete) => {
                //         if (willDelete) {
                //             location.replace(window.location.href); //ok btn
                //         }else{
                //             location.replace(window.location.href); // cancel btn
                //         }
                //     });
                // }else{
                //     swal("Oops!", `${message}`, "error");
                // }

            }
            // ,complete:function(data){
            //    $(".loader123").hide();
            // }
        });
    }

</script>

<!-- 152 OG line -->
<!-- 846 current total line -->