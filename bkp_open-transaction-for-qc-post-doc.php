<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list')
{
    $getAllData=$obj->get_OTFSI_Data($INWARDQCPOSTDOC_API);
    $count=count($getAllData);
// print_r($count);
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
                        <th>GRPO No</th>
                        <th>GRPO DocEntry</th> 
                        <th>Supplier Code</th>
                        <th>Supplier Name</th>
                        <th>Bp Ref Nc</th>
                        <th>LineNum</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Unit</th>
                        <th>GRN Qty</th>
                        <th>Batch No</th>
                        <th>Batch Qty</th>
                        <th>Mfg Date</th>
                        <th>Expiry Date</th>
                        <th>Sample Intimation No</th>
                        <th>Sample Collection No</th>
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
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".retest-qc-check" onclick="OT_PoPup_SampleCollection(\''.$getAllData[$i]->GRPODocEntry.'\',\''.$getAllData[$i]->BatchNo.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->LineNum.'\')">
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
                                    <td class="desabled">'.$getAllData[$i]->GRNQty.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                    <td class="desabled">'.$MfgDate.'</td>
                                    <td class="desabled">'.$ExpiryDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->SampleIntimationNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->SampleCollectionNo.'</td>
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
<?php include 'models/qc-post-doc-model.php' ?>

        <!-- gridjs css -->
        <link rel="stylesheet" href="assets/libs/gridjs/theme/mermaid.min.css">

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    
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
                                    <h4 class="mb-0">Open Transaction For QC Post Document</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Open Transaction For QC Post Document</li>
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
                                        <h4 class="card-title mb-0">Open Transaction For QC Post Document</h4>  
                                       
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

     function OT_PoPup_SampleCollection(DocEntry,BatchNo,ItemCode,LineNum)
    {

        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'DocEntry':DocEntry,'BatchNo':BatchNo,'ItemCode':ItemCode,'LineNum':LineNum,'action':"OT_QC_PD_popup"},

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                             
                $(`#GRPONo`).val(JSONObject[0]['GRPONo']);
                $(`#GRPODocEntry`).val(JSONObject[0]['GRPODocEntry']);
                $(`#SupplierCode`).val(JSONObject[0]['SupplierCode']);
                $(`#SupplierName`).val(JSONObject[0]['SupplierName']);
                $(`#ItemCode`).val(JSONObject[0]['ItemCode']);
                $(`#ItemName`).val(JSONObject[0]['ItemName']);
                $(`#GenericName`).val(JSONObject[0]['FrgnName']);
                $(`#LabelClaim`).val(JSONObject[0]['LabelClaim']);
                $(`#LabelClaimUOM`).val(JSONObject[0]['LabelClaimUOM']);
                $(`#GRNQty`).val(JSONObject[0]['GRNQty']);
                $(`#MfgBy`).val(JSONObject[0]['MfgBy']);
                $(`#BatchNo`).val(JSONObject[0]['BatchNo']);
                $(`#BatchQty`).val(JSONObject[0]['BatchQty']);

                // <!-- ----------- Mfg Date Start Here ----------------------- -->
                    var mfgDateOG = JSONObject[0]['MfgDate'];
                    if(mfgDateOG!=''){
                        mfgDate = mfgDateOG.split(' ')[0];
                        $(`#MfgDate`).val(mfgDate);
                    }
                // <!-- ----------- Mfg Date End Here ------------------------- -->

                // <!-- ----------- Mfg Date Start Here ----------------------- -->
                    var expiryDateOG = JSONObject[0]['ExpiryDate'];
                    if(expiryDateOG!=''){
                        ExpiryDate = expiryDateOG.split(' ')[0];
                        $(`#ExpiryDate`).val(ExpiryDate);
                    }
                // <!-- ----------- Mfg Date End Here ------------------------- -->

                    $(`#SampleIntimationNo`).val(JSONObject[0]['SampleIntimationNo']);
                    $(`#SampleCollectionNo`).val(JSONObject[0]['SampleCollectionNo']);
                    $(`#SampleQty`).val(JSONObject[0]['SampleQty']);
                    $(`#PackSize`).val(JSONObject[0]['PackSize']);
                    $(`#MaterialType`).val(JSONObject[0]['MaterialType']);
                    $(`#SpecfNo`).val(JSONObject[0]['SpecfNo']);
                    $(`#BranchName`).val(JSONObject[0]['BranchName']);
                    $(`#ARNo`).val(JSONObject[0]['ARNo']);
                    $(`#TNCont`).val(JSONObject[0]['TNCont']);
                    $(`#Location`).val(JSONObject[0]['Location']);
                // -------------------------------Unmapped colume -----------------------
                    // BPLId: "1"
                    // FCont: "1"
                    // Factor: ""
                    // LineNum: "0"
                    // LocCode: "4"
                    // Qty: "790.000000"
                    // SrNo: "1"
                    // TCont: "8"

                getSeriesDropdown() // DocName By using API to get dropdown 
                SampleTypeDropdown(); //Sample Type API to Get Dropdown
                QC_TestTypeDropdown(); // QC Test Type Dropdown Mastre JavaScript Function Called.

                // <!-- --------- Tab Layout Data Mapping here ------------------------ -->
                getGeneratDataTable(JSONObject[0]['ItemCode']);
                // <!-- --------- Tab Layout Data Mapping here ------------------------ -->
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function getGeneratDataTable(ItemCode){
        var dataString ='ItemCode='+ItemCode+'&action=OTFQCPD_Table_Ajax';

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
                 // console.log(JSONObject['tr']);
                $('#generateDataTable-list').html(JSONObject['tr']);


                QC_StatusByAnalystDropdown(JSONObject['count']); // QC status By analyst dropdown Function

                getResultOutputDropdown(JSONObject['count']); // General Data Result Output dropdown Function

                // selectedSeries(); // call Selected Series Single data function
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function getResultOutputDropdown(trcount){
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'action':"ResultOutputDropdown_ajax"},

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                console.log(result);

                // var JSONObject = JSON.parse(result);

                for (let i = 0; i < trcount; i++) {
                    $('#ResultOut'+i).html(result); // dropdown set using Id                            
                }
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        });         
    }

    function getSeriesDropdown()
    {
        var dataString ='ObjectCode=SCS_QCPD&action=getSeriesDropdown_ajax';

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
                $('#DocNoName').html(SeriesDropdown);
                selectedSeries(); // call Selected Series Single data function
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function selectedSeries(){

        var Series=document.getElementById('DocNoName').value;
        var dataString ='Series='+Series+'&ObjectCode=SCS_QCPD&action=getSeriesSingleData_ajax';

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

                $('#DocNo').val(Series);
                $('#NextNumber').val(NextNumber);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function QC_StatusByAnalystDropdown(trcount){

        // alert(trcount);
        var dataString ='TableId=@SCS_QCPD1&Alias=QCStatus&action=dropdownMaster_ajax';

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

                for (let i = 0; i < trcount; i++) {
                    $('#QC_StatusByAnalyst'+i).html(JSONObject); // dropdown set using Class                            
                }
                
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        });
    }

    function QC_TestTypeDropdown(){

        var dataString ='TableId=@SCS_QCPD&Alias=QCTType&action=dropdownMaster_ajax';

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

                $('#QCTestType').html(JSONObject);
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
                // console.log(result);
                var SampleTypeDrop = JSON.parse(result);
                $('#SampleType').html(SampleTypeDrop);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function CalculateResultOut(un_id){

        var lowMin=document.getElementById('LowMin'+un_id).value;
        var uppMax=document.getElementById('UppMax'+un_id).value;
        var UOM=document.getElementById('UOM'+un_id).value;

        var lowMinResOG=document.getElementById('LowMinRes'+un_id).value; // this value enter by user

        var lowMinRes=parseFloat(lowMinResOG).toFixed(6); // this value enter by user

        if(lowMinRes!=''){
            $('#LowMinRes'+un_id).val(lowMinRes);

            $('#Remarks'+un_id).val(lowMinResOG+' '+UOM);
              // $('#Remarks1').val('9.99 '+'KG');

            if(parseFloat(lowMinRes)>=parseFloat(lowMin) && parseFloat(lowMinRes)<=parseFloat(uppMax)){
                // console.log('PASS');
                $('#ResultOut'+un_id).val('PASS');    
                $('#ResultOutTd'+un_id).attr('style', 'background-color: #c7f3c7');
                $('#ResultOut'+un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
                // setSelectedIndex(un_id, 'PASS');
            
                setSelectedIndex(document.getElementById("ResultOut"+un_id),"PASS");
            }else{
                // console.log('FAIL');
                $('#ResultOut'+un_id).val('FAIL');
                $('#ResultOutTd'+un_id).attr('style', 'background-color: #f8a4a4');
                $('#ResultOut'+un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
                // setSelectedIndex(un_id, 'FAIL');
                setSelectedIndex(document.getElementById("ResultOut"+un_id),"FAIL");
            }
        }
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

    function CalculatePotency(){

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

        // getResultOutputDropdown();
    }
</script>
<!-- Total Line 177 static data end  -->