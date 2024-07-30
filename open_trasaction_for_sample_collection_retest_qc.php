
<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list')
{
    $getAllData=$obj->get_OTFSI_Data($RETESTQCSAMPLECOLLVIEW_API);
    // echo '<pre>';
    // print_r($getAllData[0]);
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
                        <th>GRN Line No</th>
                        <th>Supplier Code</th>
                        <th>Supplier Name</th>
                        <th>Bp Ref No</th>
                        <th>LineNum</th>
                        <th>Item Code</th> 
                        <th>Item Name</th>
                        <th>Unit</th>
                        <th>GRPO Qty</th>
                        <th>Batch No</th>
                        <th>Batch Qty</th>
                        <th>Mfg Date</th>
                        <th>Expiry Date</th>
                        <th>Sample Intimation</th>
                        <th>Location</th>
                        <th>Branch Name</th>
                        <th>Whse Code</th>
                        <th>MakeBy</th>
                        <th>Retest Date</th>
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
                                    $ExpDate='';
                                }else{
                                    $ExpDate=date("d-m-Y", strtotime($getAllData[$i]->ExpDate));
                                }

                                if(empty($getAllData[$i]->RetestDate)){
                                    $RetestDate='';
                                }else{
                                    $RetestDate=date("d-m-Y", strtotime($getAllData[$i]->RetestDate));
                                }

                                
                            // --------------- Convert String code End Here-- ---------------------------

                            $option.='
                                <tr>
                                    <td class="desabled" style="text-align: center;">'.$getAllData[$i]->SrNo.'.</td>

                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".open-sample-collection" onclick="OTSCRTQC_PoPup(\''.$getAllData[$i]->GRNEntry.'\',\''.$getAllData[$i]->BatchNum.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->GRNLineNo.'\')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </td>

                                    <td class="desabled">'.$getAllData[$i]->GRNNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->GRNEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->GRNLineNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->SupplierCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->SupplierName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BPRefNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->GRNLineNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                    <td class="desabled">'.$getAllData[$i]->GRNQty.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchNum.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                    <td class="desabled">'.$MfgDate.'</td>
                                    <td class="desabled">'.$ExpDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->SampleIntimationNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Loaction.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Branch.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WhsCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->MakeBy.'</td>
                                    <td class="desabled">'.$RetestDate.'</td>

                                </tr>';
                        }
                    }
                }else{
                     $option.='<tr><td colspan="19" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
                }
        $option.='</tbody> 
    </table>'; 

    $option.=$pagination;        
    echo $option;
    exit(0);
}
?>

<?php include 'include/header.php' ?>
<?php include 'models/retest_qc/sample_collection_retest_qc_modal.php' ?>

<!-- ---------- loader start here---------------------- -->
    <div class="loader-top" style="height: 100%;width: 100%;background: #cccccc73;">
        <div class="loader123" style="text-align: center;z-index: 10000;position: fixed;top: 0; left: 0;bottom: 0;right: 0;background: #cccccc73;">
            <img src="loader/loader2.gif" style="width: 5%;padding-top: 288px !important;">
        </div>
    </div>
<!-- ---------- loader end here---------------------- -->

<div class="main-content">

    <div class="page-content" style="margin-top: 20px !important;">
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
                            <h4 class="card-title mb-0">Open Transaction For Sample Collection-Retest QC</h4> 
                        </div><!-- end card header -->

                        <div class="card-body">

                            <div class="table-responsive" id="list-append">
                                <!-- // page record appned here -->
                            </div> 

                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <br><br>
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
            });
        });

        function change_page(page_id){ 
            var dataString ='page_id='+page_id+'&action=list';
            $.ajax({
                type: "POST",
                url: window.location.href,  
                data: dataString,
                cache: false,
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    $('#list-append').html(result);
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            });
        }

        function OTSCRTQC_PoPup(DocEntry,BatchNo,ItemCode,LineNum){
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data:{'DocEntry':DocEntry,'BatchNo':BatchNo,'ItemCode':ItemCode,'LineNum':LineNum,'action':"OPSCRTQC_popup_data"},
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    var JSONObject = JSON.parse(result);
                    // console.log(JSONObject);

                        $(`#SCRTP_GRNNo`).val(JSONObject[0]['GRNNo']);
                        $(`#SCRTP_GRNDocEntry`).val(JSONObject[0]['GRNEntry']);
                        $(`#SCRTP_Location`).val(JSONObject[0]['Loaction']);

                        // $(`#SCRTP_MaterialType`).val(JSONObject[0]['TypeofMaterial']);
                        $(`#SCRTP_MakeBy`).val(JSONObject[0]['MakeBy']);
                        $(`#SCRTP_SupplierCode`).val(JSONObject[0]['SupplierCode']);
                        $(`#SCRTP_SupplierName`).val(JSONObject[0]['SupplierName']);
                    // 1st Row End --------------------------------------------------------------------------------

                        $(`#SCRTP_IntimatedBy`).val(JSONObject[0]['TRBy']);
                        $(`#SCRTP_SampleQty`).val(JSONObject[0]['SampleQty']);
                        $(`#SCRTP_UoM`).val(JSONObject[0]['Unit']);

                        // <!-- ----------- Intimat Date Start Here ----------------------- -->
                            var intimatdateOG = JSONObject[0]['TRDate'];
                            if(intimatdateOG!=''){
                                intimatdate = intimatdateOG.split(' ')[0];
                                $(`#SCRTP_IntimatedDate`).val(intimatdate);
                            }
                        // <!-- ----------- Intimat Date End Here ------------------------- -->
                    // 2nd Row End --------------------------------------------------------------------------------

                        $(`#SCRTP_ARNo`).val(JSONObject[0]['ARNo']);
                        $(`#SCRTP_TRNo`).val(JSONObject[0]['TRNo']);
                    // 3rd Row End--------------------------------------------------------------------------------

                        $(`#SCRTP_Branch`).val(JSONObject[0]['Branch']);
                        $(`#SCRTP_ItemCode`).val(JSONObject[0]['ItemCode']);
                        $(`#SCRTP_ItemName`).val(JSONObject[0]['ItemName']);
                        $(`#SCRTP_BatchNo`).val(JSONObject[0]['BatchNum']);
                    // 4th Row End--------------------------------------------------------------------------------

                        $(`#SCRTP_NoOfCont`).val(JSONObject[0]['TotalNoContainer']);
                        $(`#SCRTP_BatchQty`).val(JSONObject[0]['BatchQty']);
                    // 5th Row End--------------------------------------------------------------------------------

                        $(`#SCRTP_GRNLineNo`).val(JSONObject[0]['GRNLineNo']);
                        $(`#SCRTP_BPLId`).val(JSONObject[0]['BPLId']);
                        $(`#SCRTP_LocCode`).val(JSONObject[0]['LocCode']);
                        $(`#SCRTP_UnderTransferNo`).val(JSONObject[0]['UnderTransferNo']);
                    // Hidden Field 5th Row End-------------------------------------------------------------------

                    IngrediantTypeDropdown() // Ingrediant Type API to Get Dropdown
                    getSeriesDropdown() // DocName By using API to get dropdown 
                    TR_ByDropdown() //TR By API to Get Dropdown
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            }); 
        }

        function TR_ByDropdown(){
            $.ajax({ 
                type: "POST",
                url: 'ajax/common-ajax.php',
                data:{'action':"TR_ByDropdown_ajax"},
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    var SampleTypeDrop = JSON.parse(result);
                    $('#SCRTP_SampleCollectBy').html(SampleTypeDrop);
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            }); 
        }
        
        function getSeriesDropdown(){
            var TrDate=$('#SCRTP_DocDate').val();
            var dataString ='TrDate='+TrDate+'&ObjectCode=SCS_SCRETEST&action=getSeriesDropdown_ajax';
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    var SeriesDropdown = JSON.parse(result);
                    $('#SCRTP_DocNoName').html(SeriesDropdown);
                    selectedSeries(); // call Selected Series Single data function
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            }); 
        }

        function selectedSeries(){
            var TrDate=$('#SCRTP_DocDate').val();
            var Series=document.getElementById('SCRTP_DocNoName').value;
            var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=SCS_SCRETEST&action=getSeriesSingleData_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    var JSONObject = JSON.parse(result);

                    var NextNumber=JSONObject[0]['NextNumber'];
                    var Series=JSONObject[0]['Series'];

                    $('#SCRTP_DocNo').val(Series);
                    $('#SCRTP_NextNumber').val(NextNumber);
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            }); 
        }

        function IngrediantTypeDropdown(){
            $.ajax({ 
                type: "POST",
                url: 'ajax/common-ajax.php',
                data:{'action':"IngrediantTypeDropdown_ajax"},
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    $('#SCRTP_IngrediantType').html(result);
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            }); 
        }

        function OTSCRTQC_P_Submit(){
            var formData = new FormData($('#OTSCRTQC_P_Form')[0]);  // Form Id
            formData.append("OTSCRTQC_P_Btn",'OTSCRTQC_P_Btn');  // Button Id

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
                success: function(result){
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