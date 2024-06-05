<?php 
require_once './classes/function.php';
require_once './classes/kri_function.php';
$obj= new web();
$objKri=new webKri();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}


if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list')
{
    $getAllData=$obj->get_OTFSI_Data($FGSAMPLECOLLECTIONVIEW);
    $count=count($getAllData);

    // echo "<pre>";
    // print_r($getAllData);
    // echo "</pre>";
    // exit;

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

                                if(empty($getAllData[$i]->ExpDate)){
                                    $ExpiryDate='';
                                }else{
                                    $ExpiryDate=date("d-m-Y", strtotime($getAllData[$i]->ExpDate));
                                }
                            // --------------- Convert String code End Here-- ---------------------------

                            $option.='
                                <tr>
                                    <td class="desabled" style="text-align: center;">'.$getAllData[$i]->SrNo.'.</td>
                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".sample-collection-finished-goods" onclick="OT_PoPup_SampleCollection_in_process(\''.$getAllData[$i]->RFPEntry.'\',\''.$getAllData[$i]->BatchNum.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->LineNo.'\')">
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
<?php include 'models/qc_process/sample_collection_finished_goods_model.php' ?>

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
                                    <h4 class="mb-0">Open Transaction for Sample Collection - Finished Goods</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Open Transaction for Sample Collection - Finished Goods</li>
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
                                        <h4 class="card-title mb-0">Open Transaction for Sample Collection - Finished Goods</h4> 
                                    </div><!-- end card header -->
                                        <div class="card-body">

                                                <div class="table-responsive" id="list-append">
                                                     
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



function OT_PoPup_SampleCollection_in_process(DocEntry,BatchNo,ItemCode,LineNum) 
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data:{'DocEntry':DocEntry,'action':"OT_Open_Transaction_For_Sample_collection_FG_popup_in_process"},

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                console.log(JSONObject);

                $(`#SC_finished_good_RFPNo`).val(JSONObject[0].RFPNo);
                $(`#SC_finished_good_RFPODocEntry`).val(JSONObject[0].RFPEntry);
                $(`#SC_finished_good_WOEntry`).val(JSONObject[0].WOEntry);
                $(`#SC_finished_good_WONo`).val(JSONObject[0].WONo);
                $(`#SC_finished_good_IntimatedBy`).val('');
                
                $(`#SC_finished_good_IntimatedDate`).val(JSONObject[0].IntimationDate);
                $(`#SC_finished_good_SampleQty`).val(JSONObject[0].SampleQty);

                $(`#SC_finished_good_SampleQtyUOM`).val(JSONObject[0].SampleQtyUOM);

                $(`#SC_finished_good_SampleCollectBy`).val('');

                $(`#SC_finished_good_ARNo`).val(JSONObject[0].ARNo);

                $(`#SC_finished_good_Branch`).val(JSONObject[0].Branch);

                $(`#SC_finished_good_ItemCode`).val(JSONObject[0].ItemCode);
                $(`#SC_finished_good_ItemName`).val(JSONObject[0].ItemName);
                $(`#SC_finished_good_NoOfContainer`).val(JSONObject[0].TotalNoContainer);

                $(`#SC_finished_good_BatchNo`).val(JSONObject[0].BatchNum);
                $(`#SC_finished_good_DocDate`).val('');
                $(`#SC_finished_good_TRNo`).val(JSONObject[0].TRNo);
                $(`#SC_finished_good_Location`).val(JSONObject[0].Loaction);
                $(`#SC_finished_good_IntimatedBy`).val(JSONObject[0].TRBy);
                
                $(`#SC_finished_good_IntimatedBy`).val(JSONObject[0].TRBy);
                $(`#SC_finished_good_LineNo`).val(JSONObject[0].LineNo);

                $(`#SC_finished_good_BPLId`).val(JSONObject[0].BPLId);
                $(`#SC_finished_good_LocCode`).val(JSONObject[0].LocCode);
               
                $(`#SC_finished_good_Unit`).val(JSONObject[0].Unit);
                $(`#SC_finished_good_BatchQty`).val(JSONObject[0].BatchQty);
                $(`#SC_finished_good_UnderTransferNo`).val(JSONObject[0].UnderTransferNo);

                $(`#SC_finished_good_Dateofreversal`).val(JSONObject[0].Dateofreversal);
                $(`#SC_finished_good_RetainQty`).val(JSONObject[0].RetainQty);
                $(`#SC_finished_good_RetainQtyUOM`).val(JSONObject[0].RetainQtyUOM);

                $(`#SC_finished_good_Cont1`).val(JSONObject[0].Cont1);
                $(`#SC_finished_good_Cont2`).val(JSONObject[0].Cont2);
                $(`#SC_finished_good_Cont3`).val(JSONObject[0].Cont3);
               $(`#SC_finished_good_QtyforLabel`).val(JSONObject[0].QtyforLabel);

                

            //     $(`#finished_good_SampleQty`).val(JSONObject[0].SQty);
            //     $(`#finished_good_RetainQty`).val(JSONObject[0].RQty);
            //     $(`#finished_good_FromContainer`).val(JSONObject[0].FromCont);
            //     $(`#finished_good_ToContainer`).val(JSONObject[0].ToCont);
            //     $(`#finished_good_BatchQty`).val(JSONObject[0].BatchQty); 
            //     $(`#finished_good_Status`).val(JSONObject[0].Status);
            // //     // const date = new Date();
            // //     // let day = date.getDate();
            // //     // let month = date.getMonth() + 1;
            // //     // let year = date.getFullYear();
            // //     // let currentDate = `${day}-${month}-${year}`;
            // //     // console.log(currentDate);
            //     $(`#finished_good_Branch`).val(JSONObject[0].BranchName);
            //     $(`#finished_good_ChallanNo`).val(JSONObject[0].ChNo);
            //     $(`#finished_good_ChallanDate`).val(JSONObject[0].ChDate);
            //     $(`#finished_good_GateEntryNo`).val(JSONObject[0].GateEntryNo);
            //     $(`#finished_good_GateEntryDate`).val(JSONObject[0].GateEntryDate);
            //     $(`#finished_good_ContainersNo`).val(JSONObject[0].ContainerNos);
            //     $(`#finished_good_Container`).val(JSONObject[0].Container);
            //     $(`#finished_good_LineNum`).val(JSONObject[0].LineNum);
            //     $(`#finished_good_Unit`).val(JSONObject[0].Unit);
            //     $(`#finished_good_FromCont`).val(JSONObject[0].FromCont);
            //     $(`#finished_good_BatchQty`).val(JSONObject[0].BatchQt);
            //     $(`#finished_good_RetestDate`).val(JSONObject[0].RetestDate);
            //     $(`#Location`).val(JSONObject[0].Location);
            //     $(`#RetestDate`).val(JSONObject[0].RetestDate);
            //     $(`#QtyPerContainer`).val(JSONObject[0].QtyPerContainer);
            //     $(`#LocCode`).val(JSONObject[0].LocCode);
            //     $(`#BPLId`).val(JSONObject[0].BPLId);
                //  var Canceled=JSONObject[0]['Canceled'];
                // if(Canceled=='N'){
                //     document.getElementById("flexCheckDefault").checked = false; // Uncheck
                // }else{
                //     document.getElementById("flexCheckDefault").checked = true; // Check
                // }

            // // <!-- ----------- Intimat Date Start Here ----------------------- -->
            //     // var intimatdateOG = JSONObject[0]['Intimatdate'];
            //     // if(intimatdateOG!=''){
            //     //     intimatdate = intimatdateOG.split(' ')[0];
            //     //     $(`#OTSCP_IntimatedDate`).val(intimatdate);
            //     // }
            //     // <!-- ----------- Intimat Date End Here ------------------------- -->
                  IngrediantTypeDropdown();
                 // SampleTypeDropdown();
                  getSeriesDropdown(); // DocName By using API to get dropdown 
                  TR_ByDropdown(); //TR By API to Get Dropdown
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
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
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                $('#SC_IngredientsType').html(result);
            }
            ,
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
                $('#SC_finished_good_SampleCollectBy').html(SampleTypeDrop);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }



     function getSeriesDropdown()
    {
        var dataString ='ObjectCode=SCS_SCOLFG&action=getSeriesDropdown_ajax';

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
                $('#SC_finished_good_DocName').html(SeriesDropdown);
                selectedSeries(); // call Selected Series Single data function
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }

    function selectedSeries(){

        var Series=document.getElementById('SC_finished_good_DocName').value;
        var dataString ='Series='+Series+'&ObjectCode=SCS_SCOLFG&action=getSeriesSingleData_ajax';

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

                // var NextNumber=JSONObject[0]['NextNumber'];
                var Series=JSONObject[0]['Series'];

                $('#SC_finished_good_DocNo').val(Series);
                // $('#OTSCP_NextNumber').val(NextNumber);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        }); 
    }



   function OTSCP_Submit(){

        var formData = new FormData($('#OTSCP_Form')[0]);  // Form Id
        formData.append("samplecollectFinishedGood_Btn",'samplecollectFinishedGood_Btn');  // Button Id
        var error = true;

        $.ajax({
            url: 'ajax/kri_production_common_ajax.php',
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
                      title: "Sample Collection finished good Add Successfully.!",
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
                // Hide image container
                $(".loader123").hide();
            }
        });
    }


   </script>


           <script type="text/javascript">
(function ($) {

  $.fn.enableCellNavigation = function () {

    var arrow = {
      left: 37,
      up: 38,
      right: 39,
      down: 40
    };

    // select all on focus
    // works for input elements, and will put focus into
    // adjacent input or textarea. once in a textarea,
    // however, it will not attempt to break out because
    // that just seems too messy imho.
    this.find('input').keydown(function (e) {

      // shortcut for key other than arrow keys
      if ($.inArray(e.which, [arrow.left, arrow.up, arrow.right, arrow.down]) < 0) {
        return;
      }

      var input = e.target;
      var td = $(e.target).closest('td');
      var moveTo = null;

      switch (e.which) {

        case arrow.left:
          {
            if (input.selectionStart == 0) {
              moveTo = td.prev('td:has(input,textarea)');
            }
            break;
          }
        case arrow.right:
          {
            if (input.selectionEnd == input.value.length) {
              moveTo = td.next('td:has(input,textarea)');
            }
            break;
          }

        case arrow.up:
        case arrow.down:
          {

            var tr = td.closest('tr');
            var pos = td[0].cellIndex;

            var moveToRow = null;
            if (e.which == arrow.down) {
              moveToRow = tr.next('tr');
            } else if (e.which == arrow.up) {
              moveToRow = tr.prev('tr');
            }

            if (moveToRow.length) {
              moveTo = $(moveToRow[0].cells[pos]);
            }

            break;
          }

      }

      if (moveTo && moveTo.length) {

        e.preventDefault();

        moveTo.find('input,textarea').each(function (i, input) {
          input.focus();
          input.select();
        });

      }

    });

  };

})(jQuery);


// use the plugin
$(function () {
  $('#list').enableCellNavigation();
});


</script>