<?php 
require_once './classes/function.php';
$obj= new web();
if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list')
{
    $getAllData=$obj->get_OTFSI_Data($OPENTRANSQCDOCSTABILITY_API);
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
                        <th>Batch No</th>
                        <th>Batch Qty</th>
                        <th>Unit</th>
                        <th>Warehouse</th>
                        <th>WO Qty</th>
                        <th>Stability Check Date</th>
                        <th>Mfg Date</th>
                        <th>Expiry Date</th>
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

                                if(empty($getAllData[$i]->StabilityLoadingDate)){
                                    $StabilityLoadingDate='';
                                }else{
                                    $StabilityLoadingDate=date("d-m-Y", strtotime($getAllData[$i]->StabilityLoadingDate));
                                }
                            // --------------- Convert String code End Here-- ---------------------------

                            $option.='
                                <tr>
                                    <td class="desabled" style="text-align: center;">'.($i+1).'.</td>

                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".stability-qc-check" onclick="Stability_QC_Check_PoPUP(\''.$getAllData[$i]->StabilityPlanDocEntry.'\',\''.$getAllData[$i]->BatchNo.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->SampleCollectionNo.'\')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </td>

                                    <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                    <td class="desabled">'.$getAllData[$i]->RouteStageRecoUOM.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WhsCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->PlannedQuantity.'</td>
                                    <td class="desabled" style="color: red;">'.$StabilityLoadingDate.'</td>
                                    <td class="desabled">'.$MfgDate.'</td>
                                    <td class="desabled">'.$ExpiryDate.'</td>
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
<?php include 'models/qc_process/stability-qc-check-model.php' ?>

<style type="text/css">
    .modal-body{padding: 1 !important;}
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
                            <h4 class="mb-0">Open Items For Stability Check</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Open Items For Stability Check</li>
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
                                <h4 class="card-title mb-0">Open Items For Stability Check</h4>  
                               
                            </div><!-- end card header -->
                                <div class="card-body">

                                        <div class="table-responsive" id="list-append">
                                            <!-- <table id="tblItemRecord" class="table sample-table-responsive table_inline table-bordered" style="">
                                                <thead class="fixedHeader1">
                                                    <tr>
                                                        <th>Item View</th>
                                                        <th>Sr.No </th>
                                                        <th>Item Code</th> 
                                                        <th>Item Name</th>
                                                        <th>Batch No</th>
                                                        <th>Batch Qty</th>
                                                        <th>Unit</th>
                                                        <th>Warehouse</th>
                                                        <th>WO Qty</th>
                                                        <th>Stability Check Date</th>
                                                        <th>Mfg Date</th>
                                                        <th>Expiry Date</th>
                                                        <th>Branch Name</th>
                                                    </tr>
                                                </thead>
                                             <tbody>
                                                <tr>
                                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".stability-qc-check">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                    <td class="desabled">1</td>
                                                    <td class="desabled">SFG001</td>
                                                    <td class="desabled">ACILIOUR OILMENT</td>
                                                    <td class="desabled">20210709</td>
                                                    <td class="desabled">30,000</td>
                                                    <td class="desabled">Kgs</td>
                                                    <td class="desabled">FG Store</td>
                                                    <td class="desabled">30,000</td>
                                                    <td class="desabled">08-10-2021</td>
                                                    <td class="desabled">08-11-2021</td>
                                                    <td class="desabled">08-11-2021</td>
                                                    <td class="desabled">ABC Company Pvt. Ltd</td>
                                                 </tr>
                                                 <tr>
                                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".stability-qc-check">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                    <td class="desabled">1</td>
                                                    <td class="desabled">SFG001</td>
                                                    <td class="desabled">ACILIOUR OILMENT</td>
                                                    <td class="desabled">20210709</td>
                                                    <td class="desabled">30,000</td>
                                                    <td class="desabled">Kgs</td>
                                                    <td class="desabled">FG Store</td>
                                                    <td class="desabled">30,000</td>
                                                    <td class="desabled">08-10-2021</td>
                                                    <td class="desabled">08-11-2021</td>
                                                    <td class="desabled">08-11-2021</td>
                                                    <td class="desabled">ABC Company Pvt. Ltd</td>
                                                 </tr>
                                                  <tr>
                                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".stability-qc-check">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                    <td class="desabled">1</td>
                                                    <td class="desabled">SFG001</td>
                                                    <td class="desabled">ACILIOUR OILMENT</td>
                                                    <td class="desabled">20210709</td>
                                                    <td class="desabled">30,000</td>
                                                    <td class="desabled">Kgs</td>
                                                    <td class="desabled">FG Store</td>
                                                    <td class="desabled">30,000</td>
                                                    <td class="desabled">08-10-2021</td>
                                                    <td class="desabled">08-11-2021</td>
                                                    <td class="desabled">08-11-2021</td>
                                                    <td class="desabled">ABC Company Pvt. Ltd</td>
                                                 </tr>

                                             </tbody> 
                                           </table> -->
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

// <!-- ------------------------------ POPUP FUNCTION START HERE ------------------------------------------------------------ -->
    function Stability_QC_Check_PoPUP(DocEntry,BatchNo,ItemCode,SampleCollectionNo)
    {

        // console.log('DocEntry=>',DocEntry);
        // console.log('BatchNo=>',BatchNo);
        // console.log('ItemCode=>',ItemCode);
        // console.log('SampleCollectionNo=>',SampleCollectionNo);

        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'DocEntry':DocEntry,'BatchNo':BatchNo,'ItemCode':ItemCode,'SampleCollectionNo':SampleCollectionNo,'action':"OT_SC_popup"},

            // beforeSend: function(){
            //     // Show image container
            //     $(".loader123").show();
            // },
            success: function(result)
            {

                var JSONObject = JSON.parse(result);
                console.log(JSONObject[0]);
                // $(`#GRPONo`).val(JSONObject[0]['GRPONo']);
                // $(`#GRPODocEntry`).val(JSONObject[0]['GRPODocEntry']);
                // $(`#SupplierCode`).val(JSONObject[0]['SupplierCode']);
                // $(`#SupplierName`).val(JSONObject[0]['SupplierName']);
                // $(`#ItemCode`).val(JSONObject[0]['ItemCode']);
                // $(`#ItemName`).val(JSONObject[0]['ItemName']);
                // $(`#GenericName`).val(JSONObject[0]['FrgnName']);
                // $(`#LabelClaim`).val(JSONObject[0]['LabelClaim']);
                // $(`#LabelClaimUOM`).val(JSONObject[0]['LabelClaimUOM']);
                // $(`#GRNQty`).val(JSONObject[0]['GRNQty']);
                // $(`#MfgBy`).val(JSONObject[0]['MfgBy']);
                // $(`#BatchNo`).val(JSONObject[0]['BatchNo']);
                // $(`#BatchQty`).val(JSONObject[0]['BatchQty']);

                // // <!-- ----------- Mfg Date Start Here ----------------------- -->
                //     var mfgDateOG = JSONObject[0]['MfgDate'];
                //     if(mfgDateOG!=''){
                //         mfgDate = mfgDateOG.split(' ')[0];
                //         $(`#MfgDate`).val(mfgDate);
                //     }
                // // <!-- ----------- Mfg Date End Here ------------------------- -->

                // // <!-- ----------- Mfg Date Start Here ----------------------- -->
                //     var expiryDateOG = JSONObject[0]['ExpiryDate'];
                //     if(expiryDateOG!=''){
                //         ExpiryDate = expiryDateOG.split(' ')[0];
                //         $(`#ExpiryDate`).val(ExpiryDate);
                //     }
                // // <!-- ----------- Mfg Date End Here ------------------------- -->

                //     $(`#SampleIntimationNo`).val(JSONObject[0]['SampleIntimationNo']);
                //     $(`#SampleCollectionNo`).val(JSONObject[0]['SampleCollectionNo']);
                //     $(`#SampleQty`).val(JSONObject[0]['SampleQty']);
                //     $(`#PackSize`).val(JSONObject[0]['PackSize']);
                //     $(`#MaterialType`).val(JSONObject[0]['MaterialType']);
                //     $(`#SpecfNo`).val(JSONObject[0]['SpecfNo']);
                //     $(`#BranchName`).val(JSONObject[0]['BranchName']);
                //     $(`#ARNo`).val(JSONObject[0]['ARNo']);
                //     $(`#TNCont`).val(JSONObject[0]['TNCont']);
                //     $(`#Location`).val(JSONObject[0]['Location']);
                // // -------------------------------Unmapped colume -----------------------
                //     // BPLId: "1"
                //     // FCont: "1"
                //     // Factor: ""
                //     // LineNum: "0"
                //     // LocCode: "4"
                //     // Qty: "790.000000"
                //     // SrNo: "1"
                //     // TCont: "8"

                // getSeriesDropdown() // DocName By using API to get dropdown 
                // SampleTypeDropdown(); //Sample Type API to Get Dropdown
                // QC_TestTypeDropdown(); // QC Test Type Dropdown Mastre JavaScript Function Called.

                // // <!-- --------- Tab Layout Data Mapping here ------------------------ -->
                // getGeneratDataTable(JSONObject[0]['ItemCode']);
                // // <!-- --------- Tab Layout Data Mapping here ------------------------ -->
            }
            // ,
            // complete:function(data){
            //     // Hide image container
            //     $(".loader123").hide();
            // }
        }); 
    }
// <!-- ------------------------------ POPUP FUNCTION END HERE -------------------------------------------------------------- -->

// (function ($) {

//   $.fn.enableCellNavigation = function () {

//     var arrow = {
//       left: 37,
//       up: 38,
//       right: 39,
//       down: 40
//     };

//     // select all on focus
//     // works for input elements, and will put focus into
//     // adjacent input or textarea. once in a textarea,
//     // however, it will not attempt to break out because
//     // that just seems too messy imho.
//     this.find('input').keydown(function (e) {

//       // shortcut for key other than arrow keys
//       if ($.inArray(e.which, [arrow.left, arrow.up, arrow.right, arrow.down]) < 0) {
//         return;
//       }

//       var input = e.target;
//       var td = $(e.target).closest('td');
//       var moveTo = null;

//       switch (e.which) {

//         case arrow.left:
//           {
//             if (input.selectionStart == 0) {
//               moveTo = td.prev('td:has(input,textarea)');
//             }
//             break;
//           }
//         case arrow.right:
//           {
//             if (input.selectionEnd == input.value.length) {
//               moveTo = td.next('td:has(input,textarea)');
//             }
//             break;
//           }

//         case arrow.up:
//         case arrow.down:
//           {

//             var tr = td.closest('tr');
//             var pos = td[0].cellIndex;

//             var moveToRow = null;
//             if (e.which == arrow.down) {
//               moveToRow = tr.next('tr');
//             } else if (e.which == arrow.up) {
//               moveToRow = tr.prev('tr');
//             }

//             if (moveToRow.length) {
//               moveTo = $(moveToRow[0].cells[pos]);
//             }

//             break;
//           }

//       }

//       if (moveTo && moveTo.length) {

//         e.preventDefault();

//         moveTo.find('input,textarea').each(function (i, input) {
//           input.focus();
//           input.select();
//         });

//       }

//     });

//   };

// })(jQuery);


// // use the plugin
// $(function () {
//   $('#list').enableCellNavigation();
// });


</script>
<!-- 440 -->