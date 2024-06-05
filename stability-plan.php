<?php 
require_once './classes/function.php';
$obj= new web();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}
?>

<?php include 'include/header.php' ?>

<style type="text/css">
    .mt-6{margin-top: -6px !important;}
    .FreightInput {width: 100px;border: transparent;}
    .FreightInput:focus {border: transparent;outline: none;}
    body[data-layout=horizontal] .page-content {
        padding: 20px 0 0 0;
        padding: 40px 0 60px 0;
    }
    .required{
        color: red;font-size: 14px;
    }
    .focusCSS:focus{
        box-shadow: none;
    }

    .qc_list_table input {
     border: transparent !important; 
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
                            <h4 class="mb-0">Stability Plan</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Stability Plan</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
<!-- START -->
                        <form role="form" class="form-horizontal" id="StabilityPlanForm" method="post">
                            <div class="card">
                                <div class="card-header justify-content-between d-flex align-items-center">
                                    <h4 class="card-title mb-0">Stability Plan</h4> 
                                </div>

                                <div class="card-body">
                                    <div class="row">

                                        <input type="hidden" id="Admin" name="Admin">
                                        <input type="hidden" id="Cephalosporin" name="Cephalosporin">
                                        <input type="hidden" id="Factor" name="Factor">
                                        <input type="hidden" id="General" name="General">
                                        <input type="hidden" id="InStock" name="InStock">
                                        <input type="hidden" id="ItemGroup" name="ItemGroup">
                                        <input type="hidden" id="ItemNo" name="ItemNo">
                                        <input type="hidden" id="Location" name="Location">
                                        <input type="hidden" id="ManageBatchNo" name="ManageBatchNo">
                                        <input type="hidden" id="Penicillin" name="Penicillin">
                                        <input type="hidden" id="PharmacopialStatus" name="PharmacopialStatus">
                                        <input type="hidden" id="RandD" name="RandD">
                                        <input type="hidden" id="SubGroup" name="SubGroup">
                                        <input type="hidden" id="NextNumber" name="NextNumber">

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code<span class="required">*</span></label>
                                                <div class="col-lg-8">
                                                    <select class="form-select" id="ItemCode" name="ItemCode" onchange="SelectedItem()">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="ItemName" name="ItemName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-5 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                                <div class="col-lg-7">
                                                    <input class="form-control desabled" type="text" id="ExtraSampleQty" name="ExtraSampleQty" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">UOM</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="UOM" name="UOM" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No.<span class="required">*</span></label>
                                                <div class="col-lg-8">
                                                    <select class="form-select" id="BatchNo" name="BatchNo" onchange="SelectBatch();"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc. No</label>
                                                <div class="col-lg-4">
                                                    <select class="form-select" id="DocNoName" name="DocNoName"></select>
                                                </div>
                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="DocNo" name="DocNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stability Type<span class="required">*</span></label>
                                                <div class="col-lg-8">
                                                    <select class="form-select" id="StabilityType" name="StabilityType" onchange="GetStabilityConditionAndTimePeriodDropdown();"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-5 col-form-label mt-6" for="val-skill">Stability Condition<span class="required">*</span></label>
                                                <div class="col-lg-7">
                                                    <select class="form-select" id="StabilityCondition" name="StabilityCondition"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Time Period<span class="required">*</span></label>
                                                <div class="col-lg-8">
                                                    <select class="form-select" id="TimePeriod" name="TimePeriod"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Quantity</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="b_qty" name="b_qty" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="InventoryUom" name="InventoryUom" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Pack Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="PackSize" name="PackSize" readonly>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <br><br>    
                                 
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">                                
                                        <div class="card-body">
                                            
                                            <div class="table-responsive qc_list_table table_item_padding" id="list">
                                                <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="max-height: 220px;">
                                                    <thead class="fixedHeader1">
                                                        <tr>
                                                            <th>Sr. No</th>
                                                            <th>Station No</th>
                                                            <th>Sample Qty</th>  
                                                            <th>Sample Qty UOM</th>
                                                            <th>Type of Analysis</th>
                                                            <th>Ref.Page No.</th>
                                                            <th>Ref.Protocol No.</th>
                                                            <th>Stability Date</th>
                                                            <th>User Text 1</th>
                                                            <th>User Text 2</th>
                                                            <th>User Text 3</th>
                                                            <th>User Text 4</th>
                                                            <th>User Text 5</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr id='1'>
                                                            <td class="desabled"><input  type="text" id="" name="" class="form-control desabled" value="1." readonly style="border:1px solid #efefef !important;"></td>
                                                            
                                                            <td class=""><select class="form-select focusCSS" id="StationNo1" name="StationNo[]" onchange="selectSationNo();" style="width: 140px;border: 1px solid white;"></select></td>

                                                            <td class=""><input type="text" id="SampleQty1" name="SampleQty[]" class="form-control" ></td>
                                                            <td class=""><input type="text" id="SampleQtyUOM1" name="SampleQtyUOM[]" class="form-control" ></td>
                                                            <td class=""><select class="form-select focusCSS" id="TypeOfAnalysis1" name="TypeOfAnalysis[]" style="width: 170px;border: 1px solid white;"></select></td>
                                                            <td class=""><input type="text" id="RefPageNO1" name="RefPageNO[]" class="form-control" ></td>
                                                            <td class=""><input type="text" id="RefProtocolNo1" name="RefProtocolNo[]" class="form-control" ></td>
                                                            <td class=""><input type="date" id="StabilityDate1" name="StabilityDate[]" class="form-control" ></td>

                                                            <td class=""><input type="text" id="UserText11" name="UserText1[]" class="form-control" ></td>
                                                            <td class=""><input type="text" id="UserText21" name="UserText2[]" class="form-control" ></td>
                                                            <td class=""><input type="text" id="UserText31" name="UserText3[]" class="form-control" ></td>
                                                            <td class=""><input type="text" id="UserText41" name="UserText4[]" class="form-control" ></td>
                                                            <td class=""><input type="text" id="UserText51" name="UserText5[]" class="form-control" ></td>
                                                        </tr>                                      
                                                    </tbody> 
                                               </table>
                                           </div> 
                                                   
                                            <!-- -------footer button---- -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-wrap gap-2">
                                                       <button type="button" class="btn btn-primary" id="StabilityPlanBtn" name="StabilityPlanBtn" onclick="SendStabilityPlanData()">Add</button>
                                                    </div>
                                                </div>
                                             </div>
                                            <!-- -------footer button---- -->
                                              
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
<!-- END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

<?php include 'include/footer.php' ?>

<script type="text/javascript">
    $(".loader123").hide(); // loader default hide script
// <!-- ------------- On page load call all this function start here --------------------------------------------------------------------- -->
    $(document).ready(function()
    {
        GetItemDropdown();
    });

    function GetItemDropdown()
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'action':"getItemDropdown_ajax"},

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                $('#ItemCode').html(result);
            },
            complete:function(data){
                GetStabilityTypeDropdown();
            }
        }); 
    }

    function GetStabilityTypeDropdown()
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'action':"getStabilityTypeDropdown_ajax"},

            beforeSend: function(){
            },
            success: function(result)
            {
                $('#StabilityType').html(result);
            },
            complete:function(data){
                getSeriesDropdown();
            }
        }); 
    }

    function getSeriesDropdown()
    {
        var dataString ='ObjectCode=SCS_STAB&action=getSeriesDropdown_ajax';

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
                $('#DocNoName').html(SeriesDropdown);
            },
            complete:function(data){
                selectedSeries(); // call Selected Series Single data function
            }
        }); 
    }

    function selectedSeries(){

        var Series=document.getElementById('DocNoName').value;

        var dataString ='Series='+Series+'&ObjectCode=SCS_STAB&action=getSeriesSingleData_ajax';

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

                var NextNumber=JSONObject[0]['NextNumber'];
                $('#DocNo').val(NextNumber);
            },
            complete:function(data){
                GetStationNoDropdown();
            }
        }); 
    }

    function GetStationNoDropdown(){
        // <!-- -----  get table tr count start here ------------------------ -->
            var allTableData = document.getElementById("tblItemRecord");
            var totalNumbeOfRows = (allTableData.rows.length)-1;
        // <!-- -----  get table tr count end here -------------------------- -->
        
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'action':"getStationNoDropdown_ajax"},

            beforeSend: function(){
            },
            success: function(result)
            {
                // console.log(result);
                $('#StationNo'+totalNumbeOfRows).html(result);
            },
            complete:function(data){
                GetTypeOfAnalysisDropdown();
            }
        }); 
    }

     function GetTypeOfAnalysisDropdown(){
        // <!-- -----  get table tr count start here ------------------------ -->
            var allTableData = document.getElementById("tblItemRecord");
            var totalNumbeOfRows = (allTableData.rows.length)-1;
        // <!-- -----  get table tr count end here -------------------------- -->

        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'action':"getTypeOfAnalysis_ajax"},

            beforeSend: function(){
            },
            success: function(result)
            {
                $('#TypeOfAnalysis'+totalNumbeOfRows).html(result);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function GetStabilityConditionAndTimePeriodDropdown()
    {
        var StabilityType=document.getElementById('StabilityType').value;
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'StabilityType':StabilityType,'action':"getStabilityConditionAndTimePeriodDropdown_ajax"},

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                
                $('#StabilityCondition').html(JSONObject['StabilityCondition']);
                $('#TimePeriod').html(JSONObject['TimePeriod']);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

// <!-- ------------- On page load call all this function end here ----------------------------------------------------------------- -->

    function SelectedItem(){
        var itemCode=document.getElementById('ItemCode').value;

        if(itemCode==''){
            // $(`#Admin`).val('');
            // $(`#Cephalosporin`).val('');
            // $(`#Factor`).val('');
            // $(`#General`).val('');
            // $(`#InStock`).val('');
            $(`#ItemName`).val('');
            // $(`#ItemGroup`).val('');
            // $(`#ItemNo`).val('');
            // $(`#Location`).val('');
            // $(`#ManageBatchNo`).val('');
            // $(`#Penicillin`).val('');
            // $(`#PharmacopialStatus`).val('');
            // $(`#RandD`).val('');
            // $(`#SubGroup`).val('');
        }else{
            $.ajax({ 
                type: "POST",
                url: 'ajax/common-ajax.php',
                data:{'itemCode':itemCode,'action':"getItemSingleData_ajax"},

                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result)
                {
                    var JSONObject = JSON.parse(result);

                    // $(`#Admin`).val(JSONObject['Admin']);
                    // $(`#Cephalosporin`).val(JSONObject['Cephalosporin']);
                    // $(`#Factor`).val(JSONObject['Factor']);
                    // $(`#General`).val(JSONObject['General']);
                    // $(`#InStock`).val(JSONObject['InStock']);
                    $(`#ItemName`).val(JSONObject[0]['ItemName']);
                    // $(`#ItemGroup`).val(JSONObject['ItemGroup']);
                    // $(`#ItemNo`).val(JSONObject['ItemNo']);
                    // $(`#Location`).val(JSONObject['Location']);
                    // $(`#ManageBatchNo`).val(JSONObject['ManageBatchNo']);
                    // $(`#Penicillin`).val(JSONObject['Penicillin']);
                    // $(`#PharmacopialStatus`).val(JSONObject['PharmacopialStatus']);
                    // $(`#RandD`).val(JSONObject['RandD']);
                    // $(`#SubGroup`).val(JSONObject['SubGroup']);
                },
                complete:function(data){
                    GetBatchDropdown();
                }
            }); 
        }
    }

    function GetBatchDropdown(){
        // alert('d');
        var itemCode=document.getElementById('ItemCode').value;
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'itemCode':itemCode,'action':"getBatchDropdown_ajax"},

            beforeSend: function(){
            },
            success: function(result)
            {
                // console.log(result);
                // console.log(result);
                $('#BatchNo').html(result);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function SelectBatch(){
 
        var batchNo=document.getElementById('BatchNo').value;
        if(batchNo==''){
                $(`#Location`).val('');
                $(`#b_qty`).val('');
                $(`#InventoryUom`).val('');
                $(`#PackSize`).val('');
                $(`#ExtraSampleQty`).val('');
                $(`#UOM`).val('');
        }else{
            var itemCode=document.getElementById('ItemCode').value;
            $.ajax({ 
                type: "POST",
                url: 'ajax/common-ajax.php',
                data:{'itemCode':itemCode,'batchNo':batchNo,'action':"getBatchAllData_ajax"},

                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result)
                {   
                    var JSONObject = JSON.parse(result);

                    $(`#Location`).val(JSONObject[0]['Location']);
                    $(`#b_qty`).val(JSONObject[0]['Quantity']);
                    $(`#InventoryUom`).val(JSONObject[0]['InventoryUom']);
                    $(`#PackSize`).val(JSONObject[0]['PackSize']);

                    var SampleQuantity=parseFloat(parseFloat(JSONObject[0]['Quantity'])*parseFloat(JSONObject[0]['PackSize'])).toFixed(3);

                    $(`#ExtraSampleQty`).val(SampleQuantity);
                    $(`#UOM`).val(JSONObject[0]['SampleQtyUom']);

                },
                complete:function(data){
                    $(".loader123").hide();
                }
            }); 
        }
        
    }

    function selectSationNo(){
        // <!-- -----  get table tr count start here ------------------------ -->
            var allTableData = document.getElementById("tblItemRecord");
            var un_id = (allTableData.rows.length)-1;
        // <!-- -----  get table tr count end here -------------------------- -->
        var SationNo=document.getElementById('StationNo'+un_id).value;

        if(SationNo==''){
            // remove tr script write here 
        }else{

            $.ajax({ 
                type: "POST",
                url: 'ajax/common-ajax.php',
                data:{'un_id':un_id,'action':"addStabilityPlanNewRow_ajax"},

                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result)
                {
                    $('#tblItemRecord > tbody:last-child').append(result);   // tr tag append
                },
                complete:function(data){
                    GetStationNoDropdown();
                }
            }); 
        }
    }

    function SendStabilityPlanData(){

        var formData = new FormData($('#StabilityPlanForm')[0]);  // Form Id
        formData.append("StabilityPlanBtn",'StabilityPlanBtn');  // Button Id
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