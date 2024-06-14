<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list'){
    $getAllData=$obj->get_OTFSI_Data($RSSAMPLECOLLECTIONVIEW_API);
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
                        <th>WOEntry</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Stage Name</th>
                        <th>Batch No</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Warehouse</th>
                        <th>WO Date</th>
                        <th>Mfg Date</th>
                        <th>Expiry Date</th>
                        <th>Sapmle Intimation No</th>
                        <th>Location</th>
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

                                if(empty($getAllData[$i]->ExpDate)){
                                    $ExpiryDate='';
                                }else{
                                    $ExpiryDate=date("d-m-Y", strtotime($getAllData[$i]->ExpDate));
                                }

                                if(empty($getAllData[$i]->WODate)){
                                    $WODate='';
                                }else{
                                    $WODate=date("d-m-Y", strtotime($getAllData[$i]->WODate));
                                }
                                
                            // --------------- Convert String code End Here-- ---------------------------

                            $option.='<tr>
                                    <td class="desabled" style="text-align: center;">'.$getAllData[$i]->SrNo.'.</td>

                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".sample-collection-route-stage" onclick="OT_PoPup_SampleCollectionRoute_Stage(\''.$getAllData[$i]->WOEntry.'\',\''.$getAllData[$i]->BatchNum.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->StageName.'\')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </td>

                                    <td class="desabled">'.$getAllData[$i]->WONo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WOEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->StageName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchNum.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WareHouse.'</td>
                                    <td class="desabled">'.$WODate.'</td>
                                    <td class="desabled">'.$MfgDate.'</td>
                                    <td class="desabled">'.$ExpiryDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->SampleIntimationNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Loaction.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Branch.'</td>
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
<?php include 'models/qc_process/sample_collection_route_stage_model.php' ?>

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

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Open Transactions for Sample Collection - Route Stage</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Open Transactions for Sample Collection - Route Stage</li>
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
                                <h4 class="card-title mb-0">Open Transactions for Sample Collection - Route Stage</h4>  
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" id="list-append"></div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

    function OT_PoPup_SampleCollectionRoute_Stage(WOEntry,BatchNum,ItemCode,StageName){
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'WOEntry':WOEntry,'BatchNum':BatchNum,'ItemCode':ItemCode,'StageName':StageName,'action':"OT_Sample_CollectionRouteStage_popup"},
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){
                var JSONObject = JSON.parse(result);
                console.log(JSONObject);

                $(`#OTSCRSP_WONo`).val(JSONObject[0]['WONo']);
                $(`#OTSCRSP_WOEntry`).val(JSONObject[0]['WOEntry']);
                $(`#OTSCRSP_DocNum`).val(JSONObject[0]['DocNum']);
                $(`#OTSCRSP_StageName`).val(JSONObject[0]['StageName']);
                $(`#OTSCRSP_IntimatedBy`).val(JSONObject[0]['TRBy']);
                $(`#OTSCRSP_SampleQty`).val(JSONObject[0]['SampleQty']);
                $(`#OTSCRSP_SampleQtyUOM`).val(JSONObject[0]['SampleQtyUOM']);
                $(`#OTSCRSP_ARNo`).val(JSONObject[0]['ARNo']);
                $(`#OTSCRSP_TRNo`).val(JSONObject[0]['TRNo']);
                $(`#OTSCRSP_Branch`).val(JSONObject[0]['Branch']);
                $(`#OTSCRSP_Loaction`).val(JSONObject[0]['Loaction']);
                $(`#OTSCRSP_ItemCode`).val(JSONObject[0]['ItemCode']);
                $(`#OTSCRSP_ItemName`).val(JSONObject[0]['ItemName']);
                $(`#OTSCRSP_BatchNum`).val(JSONObject[0]['BatchNum']);
                $(`#OTSCRSP_BatchQty`).val(JSONObject[0]['BatchQty']);
                $(`#OTSCRSP_TotalNoContainer`).val(JSONObject[0]['TotalNoContainer']);

                // <!-- ---------- hidden field Start here ---------------- -->
                    $(`#OTSCRSP_BPLId`).val(JSONObject[0]['BPLId']);
                    $(`#OTSCRSP_LineNo`).val(JSONObject[0]['LineNo']);
                    $(`#OTSCRSP_LocCode`).val(JSONObject[0]['LocCode']);
                    $(`#OTSCRSP_SampleIntimationNo`).val(JSONObject[0]['SampleIntimationNo']);
                    $(`#OTSCRSP_WareHouse`).val(JSONObject[0]['WareHouse']);
                // <!-- ---------- hidden field End here ------------------ -->

                // <!-- ----------- Intimat Date Start Here ----------------------- -->
                    var intimatdateOG = JSONObject[0]['IntimationDate'];
                    if(intimatdateOG!=''){
                        intimatdate = intimatdateOG.split(' ')[0];
                        $(`#OTSCRSP_IntimatedDate`).val(intimatdate);
                    }
                // <!-- ----------- Intimat Date End Here ------------------------- -->
            },
            complete:function(data){
                IngrediantTypeDropdown() // Ingrediant Type API to Get Dropdown
            }
        }); 
    }

    function IngrediantTypeDropdown(){
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'action':"IngrediantTypeDropdown_ajax"},
            beforeSend: function(){
            },
            success: function(result){
                $('#OTSCRSP_IngredientsType').html(result);
            },
            complete:function(data){
                getSeriesDropdown() // DocName By using API to get dropdown 
            }
        }); 
    }

    function getSeriesDropdown(){   
        var TrDate = $('#OTSCRSP_DocDate').val();
        var dataString ='TrDate='+TrDate+'&ObjectCode=SCS_SCRSTAGE&action=getSeriesDropdown_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
            },
            success: function(result){
                var SeriesDropdown = JSON.parse(result);
                $('#OTSCRSP_DocNoName').html(SeriesDropdown);
            },
            complete:function(data){
                selectedSeries(); // call Selected Series Single data function
            }
        }); 
    }

    function selectedSeries(){
        var TrDate = $('#OTSCRSP_DocDate').val();
        var Series=document.getElementById('OTSCRSP_DocNoName').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=SCS_SCRSTAGE&action=getSeriesSingleData_ajax';
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

                $('#OTSCRSP_DocNo').val(Series);
                $('#OTSCRSP_NextNumber').val(NextNumber);
            },
            complete:function(data){
                TR_ByDropdown() //TR By API to Get Dropdown
            }
        }); 
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
                $('#OTSCRSP_SampleCollectBy').html(SampleTypeDrop);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function OTSCRSP_Submit(){
        var formData = new FormData($('#OTSCRSP_Form')[0]);  // Form Id
        formData.append("OTSCRSP_Btn",'OTSCRSP_Btn');  // Button Id
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