<?php
require_once './classes/function.php';
require_once './classes/kri_function.php';
$obj = new web();
$objKri = new webKri();

if (empty($_SESSION['Baroque_EmployeeID'])) {
    header("Location:login.php");
    exit(0);
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'list') {
    $tdata = array();

    $getAllData = $objKri->getQcPostDocumentRetestQc($RETESTQCPOSTDOC);
    $count = count($getAllData);

    $adjacents = 1;

    $records_per_page = 20;
    $page = (int) (isset($_POST['page_id']) ? $_POST['page_id'] : 1);

    // =========================================================================================
    if ($page == '1') {
        $r_start = '0';   // 0
        $r_end = $records_per_page;    // 20
    } else {
        $r_start = ($page * $records_per_page) - ($records_per_page);   // 20
        $r_end = ($records_per_page * $page);   // 40
    }
    // =========================================================================================

    $page = ($page == 0 ? 1 : $page);
    $start = ($page - 1) * $records_per_page;
    $i = (($page * $records_per_page) - ($records_per_page - 1)); // used for serial number.

    $next = $page + 1;
    $prev = $page - 1;
    $last_page = ceil($count / $records_per_page);
    $second_last = $last_page - 1;
    $pagination = "";

    if ($last_page > 1) {
        $pagination .= "<div class='pagination' style='float: right;'>";

        if ($page > 1)
            $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($prev) . ");'>&laquo; Previous&nbsp;&nbsp;</a>";
        else
            $pagination .= "<spn class='disabled'>&laquo; Previous&nbsp;&nbsp;</spn>";

        if ($last_page < 7 + ($adjacents * 2)) {
            for ($counter = 1; $counter <= $last_page; $counter++) {
                if ($counter == $page)
                    $pagination .= "<spn class='current'>$counter</spn>";
                else
                    $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($counter) . ");'>$counter</a>";
            }
        } elseif ($last_page > 5 + ($adjacents * 2)) {
            if ($page < 1 + ($adjacents * 2)) {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page)
                        $pagination .= "<spn class='current'>$counter</spn>";
                    else
                        $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($counter) . ");'>$counter</a>";
                }
                $pagination .= "...";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($second_last) . ");'> $second_last</a>";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($last_page) . ");'>$last_page</a>";
            } elseif ($last_page - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(1);'>1</a>";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(2);'>2</a>";
                $pagination .= "...";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<spn class='current'>$counter</spn>";
                    else
                        $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($counter) . ");'>$counter</a>";
                }

                $pagination .= "..";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($second_last) . ");'>$second_last</a>";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($last_page) . ");'>$last_page</a>";
            } else {
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(1);'>1</a>";
                $pagination .= "<a href='javascript:void(0);' onClick='change_page(2);'>2</a>";
                $pagination .= "..";

                for ($counter = $last_page - (2 + ($adjacents * 2)); $counter <= $last_page; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<spn class='current'>$counter</spn>";
                    else
                        $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($counter) . ");'>$counter</a>";
                }
            }
        }

        if ($page < $counter - 1)
            $pagination .= "<a href='javascript:void(0);' onClick='change_page(" . ($next) . ");'>Next &raquo;</a>";
        else

            $pagination .= "<spn class='disabled'>Next &raquo;</spn>";
        $pagination .= "</div>";
    }


    $option .= '<table id="tblItemRecord" class="table sample-table-responsive table_inline table-bordered" style="">
                <thead class="fixedHeader1">
                   <tr>
                    <th>Item View</th>
                    <th>Sr.No </th>  
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
                    <th>Location</th>
                    <th>Branch Name</th>
                </tr>
                <tbody>';

    if (count($getAllData) != '0') {
        for ($i = $r_start; $i < $r_end; $i++) {
            if (!empty($getAllData[$i]->GRPODocEntry)) {   //  this condition save to extra blank loop
                $SrNo = $i + 1;
                // --------------- Convert String code Start Here ---------------------------
                if (empty($getAllData[$i]->MfgDate)) {
                    $MfgDate = '';
                } else {
                    $MfgDate = str_replace('/', '-', $getAllData[$i]->MfgDate);
                    $MfgDate = date("d-m-Y", strtotime($MfgDate));
                }

                if (empty($getAllData[$i]->ExpiryDate)) {
                    $ExpiryDate = '';
                } else {
                    $ExpiryDate = str_replace('/', '-', $getAllData[$i]->ExpiryDate);
                    $ExpiryDate = date("d-m-Y", strtotime($ExpiryDate));
                }
                // --------------- Convert String code End Here-- ---------------------------
                $option .= '
                            <tr>
                                <td style="text-align: center;">
                                    <a href="" class="" data-bs-toggle="modal" data-bs-target=".retest-qc-check" onclick="qc_for_doc_retest(\'' . $getAllData[$i]->GRPODocEntry . '\',\'' . $getAllData[$i]->BatchNo . '\',\'' . $getAllData[$i]->ItemCode . '\',\'' . $getAllData[$i]->LineNum . '\')">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="desabled">' . $SrNo . '</td>
                                <td class="desabled">' . $getAllData[$i]->GRPONo . '</td>
                                <td class="desabled">' . $getAllData[$i]->GRPODocEntry . '</td>
                                <td class="desabled">' . $getAllData[$i]->SupplierCode . '</td>
                                <td class="desabled">' . $getAllData[$i]->SupplierName . '</td>
                                <td class="desabled">' . $getAllData[$i]->BpRefNo . '</td>
                                <td class="desabled">' . $getAllData[$i]->LineNum . '</td>
                                <td class="desabled">' . $getAllData[$i]->ItemCode . '</td>
                                <td class="desabled">' . $getAllData[$i]->ItemName . '</td>
                                <td class="desabled">' . $getAllData[$i]->Unit . '</td>  
                                <td class="desabled">' . $getAllData[$i]->GRNQty . '</td>
                                <td class="desabled">' . $getAllData[$i]->BatchNo . '</td>
                                <td class="desabled">' . $getAllData[$i]->BatchQty . '</td>
                                <td class="desabled">' . $MfgDate . '</td>
                                <td class="desabled">' . $ExpiryDate . '</td>
                                <td class="desabled">' . $getAllData[$i]->SampleIntimationNo . '</td>
                                <td class="desabled">' . $getAllData[$i]->SampleCollectionNo . '</td>
                                <td class="desabled">' . $getAllData[$i]->Location . '</td>
                                <td class="desabled">' . $getAllData[$i]->BranchName . '</td>
                            </tr>';
            }
        }
    } else {
        $option .= '<tr><td colspan="20" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
    }
    $option .= '</tbody> 
    </table>';

    $option .= $pagination;
    echo $option;
    exit(0);
}
?>

<?php include 'include/header.php' ?>
<?php include 'models/retest_qc/qc_post_doc_retest_qc_modal.php' ?>
<style type="text/css">
    body[data-layout=horizontal] .page-content {
        padding: 20px 0 0 0;
        padding: 40px 0 60px 0;
    }
</style>

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Open Transaction For QC Post Document-Retest QC</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Open Transaction For QC Post Document-Retest QC</li>
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
                            <h4 class="card-title mb-0">Open Transaction For QC Post Document-Retest QC</h4>

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
        $(document).ready(function() {
            var dataString = 'action=list';
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: dataString,
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    $('#list-append').html(result);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        });





        function GetRowLevelAnalysisByDropdown(trcount) {


            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: {
                    'action': "GetRowLevelAnalysisByDropdown_Ajax"
                },

                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var dropdown = JSON.parse(result);
                    //console.log("dropdown",dropdown)
                    for (let i = 0; i < trcount; i++) {
                        $('#AnalysisBy' + i).html(dropdown); // dropdown set using Id
                    }

                    $('#checked_by').html(dropdown); // Bottom dropdown set using Id
                    $('#analysis_by').html(dropdown); // Bottom dropdown set using Id
                    // $('#AnalysisBy'+i).html(dropdown); // dropdown set using Id

                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }







        function qc_for_doc_retest(DocEntry, BatchNo, ItemCode, LineNum) {
            $.ajax({
                type: "POST",
                url: 'ajax/kri_common-ajax.php',
                data: {
                    'DocEntry': DocEntry,
                    'BatchNo': BatchNo,
                    'ItemCode': ItemCode,
                    'LineNum': LineNum,
                    'action': "QcForDocRetest_popup"
                },

                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);
                    //console.log('JSON-> ', JSONObject);
                    // ExpiryDate
                    

                
                    $(`#GRPONo`).val(JSONObject[0]['GRPONo']);
                    $(`#GRPODocEntry`).val(JSONObject[0]['GRPODocEntry']);
                    $(`#SupplierCode`).val(JSONObject[0]['SupplierCode']);
                    $(`#SupplierName`).val(JSONObject[0]['SupplierName']);
                    $(`#ItemCode`).val(JSONObject[0]['ItemCode']);
                    $(`#ItemName`).val(JSONObject[0]['ItemName']);
                    $(`#ItemName`).val(JSONObject[0]['ItemName']);
                    $(`#Location`).val(JSONObject[0]['Location']);
                    $(`#LabelClaim`).val(JSONObject[0]['LabelClaim']);
                    $(`#LabelClaimUOM`).val(JSONObject[0]['LabelClaimUOM']);
                    $(`#RQty`).val(JSONObject[0]['GRNQty']);
                    $(`#MfgBy`).val(JSONObject[0]['MfgBy']);
                    $(`#BpRefNo`).val(JSONObject[0]['BpRefNo']);
                    $(`#BatchNo`).val(JSONObject[0]['BatchNo']);
                    $(`#BatchQty`).val(JSONObject[0]['BatchQty']);

                    $(`#SampleIntimationNo`).val(JSONObject[0]['SampleIntimationNo']);
                    $(`#SampleCollectionNo`).val(JSONObject[0]['SampleCollectionNo']);

                    $(`#SampleQty`).val(JSONObject[0]['SampleQty']);
                    $(`#PackSize`).val(JSONObject[0]['PackSize']);
                    $(`#MaterialType`).val(JSONObject[0]['MaterialType']);
                    $(`#SpecfNo`).val(JSONObject[0]['SpecfNo']);
                    $(`#AnalysisDate`).val(JSONObject[0]['AnalysisDate']); //--
                    $(`#Container`).val(JSONObject[0]['NoofContainer']);
                    $(`#noOfCont2`).val(JSONObject[0]['NoofContainer']);

                    $(`#ShelfLife`).val(JSONObject[0]['ShelfLife']);
                    $(`#Assaypotencyreq`).val(JSONObject[0]['AssayPotencyReq']);
                    $(`#MakeBy`).val(JSONObject[0]['MakeBy']);
                    $(`#Stage`).val(JSONObject[0]['Stage']); //--- 
                    $(`#BranchName`).val(JSONObject[0]['BranchName']);
                    $(`#ValidUpTo`).val(JSONObject[0]['ValidUpTo']);
                    $(`#ARNo`).val(JSONObject[0]['ARNo']);
                    $(`#GateENo`).val(JSONObject[0]['GateENo']);

                    $(`#Factor`).val(JSONObject[0]['Factor']);

                    $(`#U_PC_Loc`).val(JSONObject[0]['Location']);
                    $(`#U_PC_LocCode`).val(JSONObject[0]['LocCode']);
                    $(`#U_PC_BPLId`).val(JSONObject[0]['BPLId']);

                    // <!-- ----------- Hidden Field Start Here ----------------------- -->
                    $(`#LineNum`).val(JSONObject[0]['LineNum']);
                    $(`#Unit`).val(JSONObject[0]['Unit']);
                    $(`#TNCont`).val(JSONObject[0]['TNCont']);
                    $(`#TCont`).val(JSONObject[0]['TCont']);
                    $(`#LocCode`).val(JSONObject[0]['LocCode']);

                    // <!-- ----------- Challan Field Start Here ----------------------- -->

                    // <!-- ----------- Expiry Date Start Here ----------------------- -->
                    var expiryDateOG = JSONObject[0]['ExpiryDate'];
                    ExpiryDate = expiryDateOG.split(' ')[0];
                    $(`#ExpiryDate`).val(ExpiryDate);
                    // <!-- ----------- Expiry Date End Here ------------------------- -->

                    // <!-- ----------- MfgDate Start Here ----------------------- -->
                    var mfgDateOG = JSONObject[0]['MfgDate'];
                    MfgDate = mfgDateOG.split(' ')[0];
                    $(`#MfgDate`).val(MfgDate);
                    // <!-- ----------- MfgDate End Here ------------------------- -->

                    // <!-- ----------- Posting Date Start Here ----------------------- -->
                    // var postingDateOG = JSONObject[0]['PostingDate'];
                    // $(`#PostingDate`).val('');
                    // <!-- ----------- Posting Date End Here ------------------------- -->
                    
                // <!-- ----------- Create Retest date with adding shelflife Start here ---------- -->
                    var ShelfLife = JSONObject[0]['ShelfLife']; 

                    if(ShelfLife!=''){
                          // Convert ShelfLife to an integer
                    ShelfLife = parseInt(ShelfLife, 10);

                    // Get the current date
                    var currentDate = new Date();

                    // Add ShelfLife months to the current date
                    var futureDate = new Date(currentDate);
                    var newMonth = futureDate.getMonth() + ShelfLife;
                    futureDate.setMonth(newMonth);

                    // Adjust if the day overflows the month
                    if (futureDate.getMonth() !== newMonth % 12) {
                        futureDate.setDate(0); // Set to the last day of the previous month
                    }

                    // Format the dates to YYYY-MM-DD
                    var currentFormattedDate = formatDate(currentDate);
                    var futureFormattedDate = formatDate(futureDate);

                    // Display the formatted dates
                    // console.log('Current Date:', currentFormattedDate);
                    // console.log('Date after adding ' + ShelfLife + ' months:', futureFormattedDate);

                    // Set Value in Retest date
                    $(`#RetestDate`).val(futureFormattedDate);
                    }
                    // Convert ShelfLife to an integer
                    ShelfLife = parseInt(ShelfLife, 10);

                    // Get the current date
                    var currentDate = new Date();

                    // Add ShelfLife months to the current date
                    var futureDate = new Date(currentDate);
                    var newMonth = futureDate.getMonth() + ShelfLife;
                    futureDate.setMonth(newMonth);

                    // Adjust if the day overflows the month
                    if (futureDate.getMonth() !== newMonth % 12) {
                        futureDate.setDate(0); // Set to the last day of the previous month
                    }

                    // Format the dates to YYYY-MM-DD
                    var currentFormattedDate = formatDate(currentDate);
                    var futureFormattedDate = formatDate(futureDate);

                    // Display the formatted dates
                    // console.log('Current Date:', currentFormattedDate);
                    // console.log('Date after adding ' + ShelfLife + ' months:', futureFormattedDate);

                    // Set Value in Retest date
                    $(`#RetestDate`).val(futureFormattedDate);
                // <!-- ----------- Create Retest date with adding shelflife End here ------------ -->
                    getstageDropdown();
                    SampleTypeDropdown(); //Sample Type API to Get Dropdown
                    QC_TestTypeDropdown();
                    qc_assay_Calculation();
                    getSeriesDropdown(); // DocName By using API to get dropdown 
                    selectedRecord(JSONObject[0]['ItemCode']);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }



        function qc_assay_Calculation() {
            var dataString = 'action=qc_assay_Calculation_Based_On_ajax';
            $.ajax({
                type: "POST",
                url: 'ajax/kri_common-ajax.php',
                data: dataString,
                success: function(result) {
                    $('#assay-append').html(result);
                }
            });
        }

        function SampleTypeDropdown() {

            var dataString = 'TableId=@SCS_QCPD&Alias=SamType&action=dropdownMaster_ajax';
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);
                    $('#SampleType').html(JSONObject);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }

        function getstageDropdown() {

            var dataString = 'action=getstageDropdown_ajax';
            //alert("hiii");
            $.ajax({

                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);

                    //console.log("JSONObject=>",JSONObject);
                    $('#Stage').html(JSONObject);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }








        function QC_TestTypeDropdown() {

            var dataString = 'TableId=@SCS_QCPD&Alias=QCTType&action=dropdownMaster_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);
                    $('#QCTestType').html(JSONObject);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }

        function CalculatePotency() {
            // <!-- -----------  LoD / Water Value Preparing Start Here ------------------------------- -->
            var lod_waterOG = document.getElementById('LoD_Water').value;

            if ((parseFloat(lod_waterOG).toFixed(6)) <= '0.000000' || lod_waterOG == '' || lod_waterOG == null) {
                var lod_water = '0.000000';
                $('#LoD_Water').val(lod_water);
            } else {
                var lod_water = parseFloat(lod_waterOG).toFixed(6);
                $('#LoD_Water').val(lod_water);
            }
            // <!-- -----------  LoD / Water Value Preparing End Here --------------------------------- -->

            // <!-- -----------  AssayPotency Value Preparing Start Here ------------------------------- -->
            var assayPotencyOG = document.getElementById('AssayPotency').value;

            if ((parseFloat(assayPotencyOG).toFixed(6)) <= '0.000000' || assayPotencyOG == '' || assayPotencyOG == null) {
                var assayPotency = '0.000000';
                $('#AssayPotency').val(assayPotency);
            } else {
                var assayPotency = parseFloat(assayPotencyOG).toFixed(6);
                $('#AssayPotency').val(assayPotency);
            }
            // <!-- -----------  AssayPotency Value Preparing End Here --------------------------------- -->

            var Potency = ((100 - parseFloat(lod_water)) / 100) * parseFloat(assayPotency); // Calculation
            $('#potency').val(parseFloat(Potency).toFixed(6)); // Set Potency calculated val
        }

        $(document).ready(function() {
            var dataString = 'action=qc_get_SAMINTTRBY_ajax';
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: 'ajax/kri_common-ajax.php',
                data: dataString,
                success: function(result) {

                    //console.log("result", result);

                    // $('#ApprovedBy').val(result[0]['TRBy']);
                    // $('#checked_by').val(result[0]['TRBy']);
                    // $('#analysis_by').val(result[0]['TRBy']);

                    var html = "";
                    result.forEach(function(value, index) {

                        html += '<option value="' + value.TRBy + '">' + value.TRBy + '</option>';
                    });

                    $('.done-by-mo').html(html);
                }
            });
        });

        function getDoneByDroopdown(n) {
            var dataString = 'action=qc_get_SAMINTTRBY_ajax';
            $.ajax({
                type: "POST",
                dataType: 'JSON',
                url: 'ajax/kri_common-ajax.php',
                data: dataString,
                success: function(result) {

                    var html = "";
                    result.forEach(function(value, index) {
                        if (value.TRBy != "") {
                            html += '<option value="' + value.TRBy + '">' + value.TRBy + '</option>';
                        }
                    });

                    $('.done-by-mo' + n).html(html);
                }
            });
        }

        function selectedRecord(ItemCode) {

            var dataString = 'ItemCode=' + ItemCode + '&action=qc_general_data_tab';

            $.ajax({
                type: "POST",
                url: 'ajax/kri_common-ajax.php',
                data: dataString,
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    $("#footerProcess").show(); // footer section Show script
                    var JSONObjectAll = JSON.parse(result);
                    //console.log('selectedRecord->', JSONObjectAll);
                    $(`#retest-general-data-list-append`).html(JSONObjectAll['general_data']); // general data Table Tr tag append here
                    $(`#retest-status-list-append`).html(JSONObjectAll['qcStatus']); // External Issue Table Tr tag append here
                    $(`#retest-attach-list-append`).html(JSONObjectAll['qcAttach']); // External Issue Table Tr tag append here

                    QC_StatusByAnalystDropdown(JSONObjectAll.count);
                    getResultOutputDropdown(JSONObjectAll.count);

                    GetRowLevelAnalysisByDropdown(JSONObjectAll.count);
                    getQcStatusDropodwn(1);
                    getDoneByDroopdown(1);
                    GetBottomApprovedBy(); // Get Bottom level Approved By and Done By Dropdown.
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }

        function getQcStatusDropodwn(n) {
            var dataString = 'action=qc_api_OQCSTATUS_ajax';
            $.ajax({
                type: "POST",
                url: 'ajax/kri_common-ajax.php',
                data: dataString,
                success: function(result) {
                    $('.qc_status_selecte' + n).html(result);
                }
            });
        }


        function GetBottomApprovedBy() {
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: {
                    'action': "GetBottomApprovedBy_Ajax"
                },
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var dropdown = JSON.parse(result);

                    $('#ApprovedBy').html(dropdown.ApprovedBy); // Bottom Approved By dropdown set using Id
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }




        // function OnChangeResultOutputByQCDept(un_id) {

        //     var ResultOut = document.getElementById('result_output' + un_id).value;

        //     if (ResultOut == '-') {

        //         $('#ResultOutTd' + un_id).attr('style', 'background-color: #ffffff');
        //         $('#result_output' + un_id).attr('style', 'background-color: #ffffff;border:1px solid #ffffff !important;');

        //     } else if (ResultOut == 'FAIL') {

        //         $('#ResultOutTd' + un_id).attr('style', 'background-color: #f8a4a4');
        //         $('#result_output' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');

        //     } else {

        //         $('#ResultOutTd' + un_id).attr('style', 'background-color: #c7f3c7');
        //         $('#result_output' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');

        //     }
        // }

        function getResultOutputDropdown(trcount) {

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: {
                    'action': "ResultOutputDropdown_ajax"
                },

                beforeSend: function() {
                    $(".loader123").show();
                },



                success: function(result) {
                    for (let i = 0; i < trcount; i++) {
                        $('#ResultOutputByQCDept' + i).html(result); // dropdown set using Id                            
                    }
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }



        function SelectedQCStatus(un_id) {

            var QC_StatusByAnalyst = document.getElementById('QC_StatusByAnalyst' + un_id).value;

            if (QC_StatusByAnalyst == 'Complies') {

                $('#QC_StatusByAnalystTd' + un_id).attr('style', 'background-color: #c7f3c7');
                $('#QC_StatusByAnalyst' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');

            } else if (QC_StatusByAnalyst == 'Non Complies') {

                $('#QC_StatusByAnalystTd' + un_id).attr('style', 'background-color: #f8a4a4');
                $('#QC_StatusByAnalyst' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');

            } else {

                $('#QC_StatusByAnalystTd' + un_id).attr('style', 'background-color: #ffffff');
                $('#QC_StatusByAnalyst' + un_id).attr('style', 'background-color: #ffffff;border:1px solid #ffffff !important;');

            }

        }















        function QC_StatusByAnalystDropdown(trcount) {

            console.log('trcount',trcount);

            var dataString = 'TableId=@SCS_QCPD1&Alias=QCStatus&action=dropdownMaster_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);

                    
                    //console.log('JSONObject111',JSONObject);
                    for (let i = 0; i < trcount; i++) {
                        $('#QC_StatusByAnalyst' + i).html(JSONObject); // dropdown set using Class                            
                    }
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }

        // function addMore(num) {

        //     var tr_count = $('#tr-count').val();
        //     $.ajax({
        //         type: "POST",
        //         url: 'ajax/kri_common-ajax.php',
        //         data: ({
        //             index: tr_count,
        //             action: 'add_qc_status_retest_input_more'
        //         }),
        //         success: function(result) {
        //             var qc_Status_ = $('#qc_Status_' + tr_count).val();
        //             var qCStsQty_ = $('#qCStsQty_' + tr_count).val();

        //             if (qc_Status_ == "" || qCStsQty_ == "") {} else {
        //                 $('#add-more_' + tr_count).after(result);
        //                 tr_count++;
        //                 $('#tr-count').val(tr_count);
        //                 getQcStatusDropodwn(tr_count);
        //                 getDoneByDroopdown(tr_count);
        //             }
        //         }
        //     });
        // }




        function add_qc_post_document_retest_qc() {

            var formData = new FormData($('#qcPostDocumentRetestForm')[0]); // Form Id
            formData.append("addQcPostDocumentRetestBtn", 'addQcPostDocumentRetestBtn'); // Button Id
            var error = true;

            $.ajax({
                url: 'ajax/kri_common-ajax.php',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    // $(".loader123").show();
                },
                success: function(result) {
                    console.log('result',result);
                    var JSONObject = JSON.parse(result);

                    var status = JSONObject['status'];
                    var message = JSONObject['message'];
                    var DocEntry = JSONObject['DocEntry'];
                    if (status == 'True') {
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
                                } else {
                                    location.replace(window.location.href); // cancel btn
                                }
                            });
                    } else {
                        swal("Oops!", `${message}`, "error");
                    }
                },
                complete: function(data) {
                    // $(".loader123").hide();
                }
            });
        }

        function getSeriesDropdown() {

            var TrDate = $('#PostingDate').val();
            var Series = document.getElementById('DocNo').value;
            var dataString = 'TrDate=' + TrDate + '&Series=' + Series + '&ObjectCode=SCS_QCRETEST&action=getSeriesDropdown_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    $(".loader123").show();
                },


                success: function(result) {


                    var SeriesDropdown = JSON.parse(result);

                    //console.log('SeriesDropdown-------',SeriesDropdown);
                    $('#DocNo').html(SeriesDropdown);

                    selectedSeries(); // call Selected Series Single data function
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }

        function selectedSeries() {

            var TrDate = $('#PostingDate').val();
            var Series = document.getElementById('DocNo').value;
            var dataString = 'TrDate=' + TrDate + '&Series=' + Series + '&ObjectCode=SCS_QCRETEST&action=getSeriesSingleData_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result)

                {
                    var JSONObject = JSON.parse(result);

                    // var NextNumber=JSONObject[0]['NextNumber'];
                    //var Series=JSONObject[0]['Series'];

                    console.log('selectedSeries=>', JSONObject);

                    $('#DocNo1').val(Series);
                    //    $('#it_Series').val(Series);

                        // $('#NextNumber').val(NextNumber);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }

        function TransToUnder() {
            var GRPODocEntry = document.getElementById('GRPODocEntry').value;
            var BatchNo = document.getElementById('BatchNo').value;
            var ItemCode = document.getElementById('ItemCode').value;
            var LineNum = document.getElementById('LineNum').value;

            $.ajax({
                type: "POST",
                url: 'ajax/kri_common-ajax.php',
                data: {
                    'DocEntry': GRPODocEntry,
                    'BatchNo': BatchNo,
                    'ItemCode': ItemCode,
                    'LineNum': LineNum,
                    'action': "QcForDocRetest_popup"
                },
                cache: false,
                dataType: 'JSON',
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    $('#it_SupplierCode').val(result[0].SupplierCode);
                    $('#it_SupplierName').val(result[0].SupplierName);
                    $('#it_BranchName').val(result[0].BranchName);
                    $('#it_DocEntry').val(result[0].GRPODocEntry);
                    $('#it_postingDate').val('');
                    $('#it_documentDate').val('');
                    $('#it_BAseDocNum').val('SCS_SCOL');

                    $('#tb_itme_code').val(result[0].ItemCode);
                    $('#tb_item_name').val(result[0].ItemName);
                    $('#tb_quality').val(result[0].Qty);
                    $('#from_whs').val('');
                    $('#to_whs').val('');

                    $('#tb_location').val(result[0].Location);
                    $('#tb_UOM').val('');

                    var SampleQuantity = document.getElementById('SampleQty').value;

                    // //Item Quantity Recalculate according sample quantity start here -------------------
                    var itP_BQty = document.getElementById('qCStsQty_1').value;
                    var calculated_itP_BQty = parseFloat(itP_BQty - SampleQuantity).toFixed(6);
                    $('#tb_quality').val(calculated_itP_BQty);
                    // //Item Quantity Recalculate according sample quantity end here --------------------- 

                    getSeriesDropdown(); // DocName By using API to get dropdown 
                    ContainerSelection() // get Container Selection Table List
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }

        function ContainerSelection() {

            var BatchNo = document.getElementById('BatchNo').value;
            var ItemCode = document.getElementById('ItemCode').value;

            var dataString = 'ItemCode=' + ItemCode + '&WareHouse=QCUT-GEN&BatchNo=' + BatchNo + '&action=getInventoryTrsf_cotainerSelection_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/kri_common-ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }









        function CalculateResultOut(un_id) {
            var lowMin = document.getElementById('LowMin' + un_id).value;
            var uppMax = document.getElementById('UppMax' + un_id).value;
            var UOM = document.getElementById('UOM' + un_id).value;

            var ComparisonResultOG = document.getElementById('ComparisonResult' + un_id).value; // this value enter by user

            if (ComparisonResultOG != '') {

                $('#ResultOut' + un_id).val(ComparisonResultOG + ' ' + UOM);

                if (parseFloat(uppMax) === 0) {
                    if (parseFloat(ComparisonResultOG) >= parseFloat(lowMin)) {

                        $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #c7f3c7');
                        $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
                        setSelectedIndex(document.getElementById("ResultOutputByQCDept" + un_id), "PASS");
                    } else {

                        $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #f8a4a4');
                        $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
                        setSelectedIndex(document.getElementById("ResultOutputByQCDept" + un_id), "FAIL");
                    }
                } else {
                    if (parseFloat(ComparisonResultOG) >= parseFloat(lowMin) && parseFloat(ComparisonResultOG) <= parseFloat(uppMax)) {

                        $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #c7f3c7');
                        $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
                        setSelectedIndex(document.getElementById("ResultOutputByQCDept" + un_id), "PASS");
                    } else {

                        $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #f8a4a4');
                        $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
                        setSelectedIndex(document.getElementById("ResultOutputByQCDept" + un_id), "FAIL");
                    }
                }
            } else {

                $('#ResultOut' + un_id).val('');
                $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #FFFFFF');
                $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #FFFFFF;border:1px solid #FFFFFF !important;');

                setSelectedIndex(document.getElementById("ResultOutputByQCDept" + un_id), "-");
            }
        }

        function setSelectedIndex(s, valsearch) {
            for (i = 0; i < s.options.length; i++) {
                if (s.options[i].value == valsearch) {
                    // Item is found. Set its property and exit
                    s.options[i].selected = true;
                    break;
                }
            }
            return;

        }

        // function OnChangeResultOutputByQCDept(un_id) {
        //     var ResultOutputByQCDept = $('#ResultOutputByQCDept' + un_id).val();

        //     if (ResultOutputByQCDept == 'FAIL') {
        //         $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #f8a4a4');
        //         $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
        //     } else if (ResultOutputByQCDept == 'PASS') {
        //         $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #c7f3c7');
        //         $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
        //     } else {
        //         $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #FFFFFF');
        //         $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #FFFFFF;border:1px solid #FFFFFF !important;');
        //     }
        // }


        function OpenInstrmentModal(un_id) {
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: {
                    'un_id': un_id,
                    'action': "OpenInstrmentModal_Ajax"
                },

                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var Table = JSON.parse(result);
                    $('#append_instrument_table').html(Table);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }


        let favorite = [];
        let total_uid = 0;

        function GetSelectedInstumentdata(un_id) {
            const ids_new_radio = [];

            $("input[name='InstrumentId[]']:checked").each(function() {
                const uid = parseInt($(this).val()); // Parse the value to integer
                favorite.push(uid);
                total_uid += uid;
                ids_new_radio.push(uid);
            });

            const InstrumentCode = $('#Html_InstrumentCode' + ids_new_radio[0]).text(); // Assuming you want the first element's text
            const InstrumentName = $('#Html_InstrumentName' + ids_new_radio[0]).text(); // Assuming you want the first element's text

            $('#InstrumentCode' + un_id).val(InstrumentCode);
            $('#InstrumentName' + un_id).val(InstrumentName);
        }


     function SelectionOfQC_Status(un_id) {  

    var tr_count = parseInt($('#tr-count').val());
    var now = new Date();
    var year = now.getFullYear();
    var month = (now.getMonth() + 1).toString().padStart(2, '0');
    var day = now.getDate().toString().padStart(2, '0');
    var formattedDate = `${day}-${month}-${year}`;
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    var formattedTime = `${hours}:${minutes}`;

    $('#qCReleaseDate_' + un_id).val(formattedDate);
    $('#qCReleaseTime_' + un_id).val(formattedTime);

    if (tr_count !== 1) {
        var rows = $('#retest-status-list-append tr');
        var Selected_QC_Status = $('#qc_Status_' + un_id).val();
        var valid = true;
        var message = "";

        rows.each(function(index) {
            if (index < rows.length - 1) {
                var qcStatusDropdown = $('#qc_Status_' + (index + 1)).val();
                if (qcStatusDropdown === Selected_QC_Status) {
                    valid = false;
                    message += `Row ${index + 1} has '${Selected_QC_Status}' selected.\n`;
                }
            }
        });

        if (valid) {
            if (!$('#qCStsQty_' + un_id).val()) {
                $('#qCStsQty_' + un_id).val(AutocalculateQC_Qty());
            }
        } else {
            $('#qCStsQty_' + un_id).val('');
            $('#qc_Status_' + un_id).val('');
            swal("Oops!", "Repeated QC Status failed:\n" + message, "error");
        }
    } else {
        $('#qCStsQty_' + un_id).val($('#BatchQty').val());
    }
}

function addMore(num){
    // Formate manula enter Quantity
    var QC_Quantity = $('#qCStsQty_'+num).val();
    $('#qCStsQty_'+num).val(parseFloat(QC_Quantity).toFixed(3));
    
    var tr_count=$('#tr-count').val();

    //console.log('tr_count=>',tr_count);

    var QCS_Qty = AutocalculateQC_Qty();

    //console.log('QCS_Qty=>',QCS_Qty)
    $.ajax({
        type: "POST",
        url: 'ajax/kri_common-ajax.php',  
        data: ({index:tr_count,action:'add_qc_status_input_more'}),  
        success: function(result){
            $('#add-more_'+tr_count).after(result);
            tr_count++;
            $('#tr-count').val(tr_count);
            $('#qCStsQty_'+tr_count).val(QCS_Qty);

            getQcStatusDropodwn(tr_count);
            getDoneByDroopdown(tr_count);
        }
    });
}

function AutocalculateQC_Qty(){
    // <!-- calculate Quantity for QC status tab start ------------------------------ -->
        var rows = document.querySelectorAll('#retest-status-list-append tr');
        
        // Get the count of tr elements
        var rowCount = rows.length;

        // Initialize sum
        var sum = 0;

        // Loop through each row and sum the values of the inputs named 'qCStsQty[]'
        rows.forEach(function(row) {
            var input = row.querySelector('input[name="qCStsQty[]"]');
            if (input) {
                sum += parseFloat(input.value) || 0;
            }
        });

        var BatchQty = $('#BatchQty').val();
        var QCS_Qty=parseFloat(parseFloat(BatchQty)- parseFloat(sum)).toFixed(3);
        return QCS_Qty;
    // <!-- calculate Quantity for QC status tab end -------------------------------- -->
}

function formatDate(date) {
        var year = date.getFullYear();
        var month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
        var day = date.getDate().toString().padStart(2, '0');
        return `${year}-${month}-${day}`;
    }


    </script>