<?php 
require_once './classes/function.php';
$obj= new web();
if(empty($_SESSION['Baroque_EmployeeID'])) {
    header("Location:login.php");
    exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list'){
    $FilterItemName = (!empty($_POST['FilterItemName'])) ? trim(addslashes(strip_tags($_POST['FilterItemName']))) : null;
    $FilterBatchNo = (!empty($_POST['FilterBatchNo'])) ? trim(addslashes(strip_tags($_POST['FilterBatchNo']))) : null;

    $API = $INWARDQCPOSTDOC_API.'&ItemCode='.$FilterItemName.'&BatchNo='.$FilterBatchNo;
    $FinalAPI = str_replace(' ', '%20', $API); // All blank space replace to %20
    
    $getAllData=$obj->get_OTFSI_Data($FinalAPI);
    $count=count($getAllData);

    // <!-- ----- Item Name Dropdown Start -------------------------- -->
        $item_dropdown=$obj->PrepareUniqueItemDropdown($getAllData);
    // <!-- ----- Item Name Dropdown End -------------------------- -->
    
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
                        <th>Doc Date</th>
                        <th>Type of Material</th>
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
                        <th>Make By</th>
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

                                    <td class="desabled">'.(!empty($getAllData[$i]->DocDate)? date("d-m-Y", strtotime($getAllData[$i]->DocDate)):'').'</td>

                                    <td class="desabled">'.$getAllData[$i]->TypeofMaterial.'</td>
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
                                    <td class="desabled">'.$getAllData[$i]->Location.'</td>
                                    <td class="desabled">'.$getAllData[$i]->MakeBy.'</td>
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
    
    $responce = array();
    $responce['list'] = $option;
    $responce['item_dropdown'] = $item_dropdown;
    echo json_encode($responce);
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
                                <div class="top_filter">
                                    <div class="row">
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label" for="val-skill" style="margin-top: -6px;">Item Name</label>
                                                <div class="col-lg-8">
                                                    <select class="form-select" id="FilterItemName" name="FilterItemName">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label" for="val-skill" style="margin-top: -6px;">Batch No</label>
                                                <div class="col-lg-8">
                                                    <input type="text" id="FilterBatchNo" name="FilterBatchNo" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row">
                                                <div class="col-lg-4">
                                                    <div class="">
                                                        <button type="button" style="top: 0px;" id="SearchBlock" class="btn btn-primary waves-effect" onclick="SearchData()">Search <i class="bx bx-search-alt align-middle"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive" id="list-append"></div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
    </div>
    <br>
    
    <?php include 'include/footer.php' ?>
    
    <script type="text/javascript">
        $(".loader123").hide(); // loader default hide script

        // $(document).ready(function(){
        //     var dataString ='action=list';

        //     $.ajax({  
        //         type: "POST",  
        //         url: window.location.href,  
        //         data: dataString,  
        //         beforeSend: function(){
        //             $(".loader123").show();
        //         },
        //         success: function(result){ 
        //             console.log(result);
        //             var responce = JSON.parse(result);
        //             console.log(responce);
        //             $('#list-append').html(responce.list);
        //             $('#FilterItemName').html(responce.item_dropdown);
                    
        //         },
        //         complete:function(data){
        //             $(".loader123").hide();
        //         }
        //     })
        // });

        // function change_page(page_id){ 
        //     var dataString ='page_id='+page_id+'&action=list';
        //     $.ajax({
        //         type: "POST",
        //         url: window.location.href,  
        //         data: dataString,
        //         cache: false,
        //         beforeSend: function(){
        //             $(".loader123").show();
        //         },
        //         success: function(result){
        //             $('#list-append').html(result);
        //         },
        //         complete:function(data){
        //             $(".loader123").hide();
        //         }
        //     })
        // }

        $(document).ready(function(){
            var FilterItemName = $('#FilterItemName').val();
            var FilterBatchNo = $('#FilterBatchNo').val();
            
            var dataString ='FilterItemName='+FilterItemName+'&FilterBatchNo='+FilterBatchNo+'&action=list';
            $.ajax({  
                type: "POST",  
                url: window.location.href,  
                data: dataString,  
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    var responce = JSON.parse(result);
                    
                    $('#list-append').html(responce.list);
                    $('#FilterItemName').html(responce.item_dropdown);
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            });
        });
        
        function change_page(page_id){
            var FilterItemName = $('#FilterItemName').val();
            var FilterBatchNo = $('#FilterBatchNo').val();
            
            var dataString ='FilterItemName='+FilterItemName+'&FilterBatchNo='+FilterBatchNo+'&page_id='+page_id+'&action=list';
            $.ajax({
                type: "POST",
                url: window.location.href,  
                data: dataString,
                cache: false,
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    var responce = JSON.parse(result);
                    
                    $('#list-append').html(responce.list);
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            })
        }

        function SearchData(){
            var FilterItemName = $('#FilterItemName').val();
            var FilterBatchNo = $('#FilterBatchNo').val();
            
            var dataString ='FilterItemName='+FilterItemName+'&FilterBatchNo='+FilterBatchNo+'&action=list';
            $.ajax({
                type: "POST",
                url: window.location.href,  
                data: dataString,
                cache: false,
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    var responce = JSON.parse(result);
                    
                    $('#list-append').html(responce.list);
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            })
        }

        function OnChangeReleaseDate(){
            var ShelfLife = $(`#ShelfLife`).val();
            // Convert ShelfLife to an integer
            ShelfLife = parseInt(ShelfLife, 10);

            var ReleaseDate = $(`#ReleaseDate`).val();

            // Initial date string in YYYY-MM-DD format
            var initialDateStr = ReleaseDate; // Example date

            // Parse initial date string to Date object
            var initialDate = new Date(initialDateStr);

            // Add months to the initial date
            var futureDate = addMonths(initialDate, ShelfLife);

            // Format the future date to YYYY-MM-DD
            var futureFormattedDate = formatDate(futureDate);

            // Display the result
            // console.log('Initial Date:', initialDateStr);
            // console.log('Date after adding 10 months111:', futureFormattedDate);

            // Set Value in Retest date
            $(`#RetestDate`).val(futureFormattedDate);
        }

        function formatDate(date) {
            var year = date.getFullYear();
            var month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
            var day = date.getDate().toString().padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function addMonths(date, months) {
            var newDate = new Date(date);
            var newMonth = newDate.getMonth() + months;
            newDate.setMonth(newMonth);

            // Adjust for overflow
            if (newDate.getMonth() !== newMonth % 12) {
                newDate.setDate(0); // Set to the last day of the previous month
            }
            return newDate;
        }

        function OT_PoPup_SampleCollection(DocEntry,BatchNo,ItemCode,LineNum){
            $.ajax({ 
                type: "POST",
                url: 'ajax/common-ajax.php',
                data:{'DocEntry':DocEntry,'BatchNo':BatchNo,'ItemCode':ItemCode,'LineNum':LineNum,'action':"OT_QC_PD_popup"},

                beforeSend: function(){
                    $(".loader123").show(); 
                },
                success: function(result){
                    var JSONObject = JSON.parse(result);

                    $(`#GRPONo`).val(JSONObject[0]['GRPONo']);
                    $(`#GRPODocEntry`).val(JSONObject[0]['GRPODocEntry']);
                    $(`#supplierCode`).val(JSONObject[0]['SupplierCode']);
                    $(`#supplierName`).val(JSONObject[0]['SupplierName']);
                    $(`#ItemCode`).val(JSONObject[0]['ItemCode']);
                    $(`#ItemName`).val(JSONObject[0]['ItemName']);
                    $(`#GenericName`).val(JSONObject[0]['FrgnName']);
                    $(`#LabelClaim`).val(JSONObject[0]['LabelClaim']);
                    $(`#LabelClaimUOM`).val(JSONObject[0]['LabelClaimUOM']);
                    $(`#GRNQty`).val(JSONObject[0]['GRNQty']); // Recieved Qty
                    $(`#MfgBy`).val(JSONObject[0]['MfgBy']);
                    $(`#BatchNo`).val(JSONObject[0]['BatchNo']);
                    $(`#BatchQty`).val(JSONObject[0]['BatchQty']); // Batch Size
                    $(`#MakeBy`).val(JSONObject[0]['MakeBy']);
                    $(`#TypeofMaterial`).val(JSONObject[0]['TypeofMaterial']);
                    $(`#RetainQty`).val(JSONObject[0]['RQty']);
                    $(`#ShelfLife`).val(JSONObject[0]['ShelfLife']);
                    $(`#Assaypotencyreq`).val(JSONObject[0]['Assaypotencyreq']);

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
                    // <!-- ----------- Create Retest date with adding shelflife End here ------------ -->

                    // <!-- ----------- Mfg Date Start Here ----------------------- -->
                        var mfgDateOG = JSONObject[0]['MfgDate'];
                        if(mfgDateOG!=''){
                            mfgDate = mfgDateOG.split(' ')[0];
                            $(`#MfgDate`).val(mfgDate);
                        }
                    // <!-- ----------- Mfg Date End Here ------------------------- -->

                    // <!-- ----------- Expiry Date Start Here ----------------------- -->
                        var expiryDateOG = JSONObject[0]['ExpiryDate'];
                        if(expiryDateOG!=''){
                            ExpiryDate = expiryDateOG.split(' ')[0];
                            $(`#ExpiryDate`).val(ExpiryDate);
                        }
                    // <!-- ----------- Expiry Date End Here ------------------------- -->

                        $(`#SampleIntimationNo`).val(JSONObject[0]['SampleIntimationNo']);
                        $(`#SampleCollectionNo`).val(JSONObject[0]['SampleCollectionNo']);
                        $(`#SampleQty`).val(JSONObject[0]['SampleQty']);
                        $(`#PackSize`).val(JSONObject[0]['PackSize']);
                        $(`#MaterialType`).val(JSONObject[0]['MaterialType']);
                        $(`#SpecfNo`).val(JSONObject[0]['SpecfNo']);
                        $(`#BranchName`).val(JSONObject[0]['BranchName']);
                        $(`#ARNo`).val(JSONObject[0]['ARNo']);
                        $(`#TNCont`).val(JSONObject[0]['TNCont']);
                        $(`#noOfCont1`).val('1');
                        $(`#noOfCont2`).val(JSONObject[0]['TNCont']);
                        $(`#Location`).val(JSONObject[0]['Location']);
                    // -------------------------------Unmapped colume -----------------------

                    // <!-- -------------  hidden filed mapping start herer --------- -->
                        $(`#LineNum`).val(JSONObject[0]['LineNum']);
                        $(`#U_BPLId`).val(JSONObject[0]['BPLId']);
                        $(`#U_LocCode`).val(JSONObject[0]['LocCode']);
                        $(`#U_GRPODEnt`).val(JSONObject[0]['GRPODocEntry']);
                        $(`#U_GRQty`).val(JSONObject[0]['GRNQty']);
                        $(`#U_Loc`).val(JSONObject[0]['Location']);
                    // <!-- -------------  hidden filed mapping start herer --------- -->

                    getSeriesDropdown() // DocName By using API to get dropdown 
                    SampleTypeDropdown(); //Sample Type API to Get Dropdown
                    QC_TestTypeDropdown(); // QC Test Type Dropdown Mastre JavaScript Function Called.

                    // <!-- --------- Tab Layout Data Mapping here ------------------------ -->
                        getGeneratDataTable(JSONObject[0]['ItemCode']);
                    // <!-- --------- Tab Layout Data Mapping here ------------------------ -->
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            })
        }

        function getGeneratDataTable(ItemCode){
            var dataString ='ItemCode='+ItemCode+'&action=OTFQCPD_Table_Ajax';
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

                    $('#generateDataTable-list').html(JSONObject['tr']);
                    $('#qc-status-list-append').html(JSONObject['qcStatus']);
                    $('#qcAttach-list-append').html(JSONObject['qcAttach']);

                    QC_StatusByAnalystDropdown(JSONObject['count']); // QC status By analyst dropdown Function
                    getResultOutputDropdown(JSONObject['count']); // General Data Result Output dropdown Function

                    GetRowLevelAnalysisByDropdown(JSONObject['count']); // Get Row Level AnalysisBy Dropdown JavaScript Function Called.

                    GetBottomApprovedBy(); // Get Bottom level Approved By and Done By Dropdown.

                    getQcStatusDropodwn(1);
                    getDoneByDroopdown(1);
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            })
        }

        function getQcStatusDropodwn(n){
            var dataString ='action=qc_api_OQCSTATUS_ajax';
            $.ajax({  
                type: "POST",  
                url: 'ajax/kri_common-ajax.php',  
                data: dataString,  
                success: function(result){ 
                    $('.qc_status_selecte'+n).html(result);
                }
            })
        }

        function getDoneByDroopdown(n){
            var dataString ='action=qc_get_SAMINTTRBY_ajax';
            $.ajax({  
                type: "POST",  
                dataType:'JSON',
                url: 'ajax/kri_common-ajax.php',  
                data: dataString,  
                success: function(result){ 
                    var html="";
                    result.forEach(function(value,index){
                        if(value.TRBy!=""){
                            html +='<option value="'+value.TRBy+'">'+value.TRBy+'</option>';
                        }
                    });

                    $('.done-by-mo'+n).html(html);
                }
            })
        }   

        function getResultOutputDropdown(trcount){
            $.ajax({ 
                type: "POST",
                url: 'ajax/common-ajax.php',
                data:{'action':"ResultOutputDropdown_ajax"},
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    for (let i = 0; i < trcount; i++) {
                        $('#ResultOutputByQCDept'+i).html(result); // dropdown set using Id                            
                    }
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            })         
        }

        function GetRowLevelAnalysisByDropdown(trcount){
            $.ajax({ 
                type: "POST",
                url: 'ajax/common-ajax.php',
                data:{'action':"GetRowLevelAnalysisByDropdown_Ajax"},
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    var dropdown = JSON.parse(result);
                    for (let i = 0; i < trcount; i++) {
                        $('#AnalysisBy'+i).html(dropdown); // dropdown set using Id
                    }

                    $('#checked_by').html(dropdown); // Bottom dropdown set using Id
                    $('#analysis_by').html(dropdown); // Bottom dropdown set using Id
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            })         
        }

        function GetBottomApprovedBy(){
            $.ajax({ 
                type: "POST",
                url: 'ajax/common-ajax.php',
                data:{'action':"GetBottomApprovedBy_Ajax"},
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    var dropdown = JSON.parse(result);
                    $('#ApprovedBy').html(dropdown.ApprovedBy); // Bottom Approved By dropdown set using Id
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            })         
        }

        function getSeriesDropdown(){
            var TrDate= $('#PostingDate').val();
            var dataString ='TrDate='+TrDate+'&ObjectCode=SCS_QCPD&action=getSeriesDropdown_ajax';
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
                    $('#DocNoName').html(SeriesDropdown);
                    selectedSeries(); // call Selected Series Single data function
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            })
        }

        function selectedSeries(){
            var TrDate= $('#PostingDate').val();
            var Series=document.getElementById('DocNoName').value;
            var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=SCS_QCPD&action=getSeriesSingleData_ajax';
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

                    $('#DocNo').val(Series);
                    $('#NextNumber').val(NextNumber);
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            })
        }

        function QC_StatusByAnalystDropdown(trcount){
            var dataString ='TableId=@SCS_QCPD1&Alias=QCStatus&action=dropdownMaster_ajax';
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

                    for (let i = 0; i < trcount; i++) {
                        $('#QC_StatusByAnalyst'+i).html(JSONObject); // dropdown set using Class                            
                    }
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            })
        }

        function QC_TestTypeDropdown(){
            $('#QCTestType').html('<option value="Regular">Regular</option>');
            // 👇 --> Get QC Tets Type Dropdown API throw
            // var dataString ='TableId=@SCS_QCPD&Alias=QCTType&action=dropdownMaster_ajax';
        }

        function SampleTypeDropdown(){
            $('#SampleType').html('<option value="Regular">Regular</option>');
            // 👇 --> Get SampleTypeDropdown API throw
            // var dataString ='TableId=@SCS_QCPD&Alias=SamType&action=dropdownMaster_ajax';
        }

        function OnChangeResultOutputByQCDept(un_id) {
            var ResultOutputByQCDept=$('#ResultOutputByQCDept'+un_id).val();

            if(ResultOutputByQCDept=='FAIL'){
                $('#ResultOutputByQCDeptTd'+un_id).attr('style', 'background-color: #f8a4a4');
                $('#ResultOutputByQCDept'+un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
            }else if(ResultOutputByQCDept=='PASS'){
                $('#ResultOutputByQCDeptTd'+un_id).attr('style', 'background-color: #c7f3c7');
                $('#ResultOutputByQCDept'+un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
            }else {
                $('#ResultOutputByQCDeptTd'+un_id).attr('style', 'background-color: #FFFFFF');
                $('#ResultOutputByQCDept'+un_id).attr('style', 'background-color: #FFFFFF;border:1px solid #FFFFFF !important;');
            }
        }

        function CalculateResultOut(un_id){
            var lowMin=document.getElementById('LowMin'+un_id).value;
            var uppMax=document.getElementById('UppMax'+un_id).value;
            var UOM=document.getElementById('UOM'+un_id).value;

            var ComparisonResultOG=document.getElementById('ComparisonResult'+un_id).value; // this value enter by user

            if(ComparisonResultOG!=''){

                $('#ResultOut'+un_id).val(ComparisonResultOG+' '+UOM);
                
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
            }else{

                $('#ResultOut'+un_id).val('');
                $('#ResultOutputByQCDeptTd'+un_id).attr('style', 'background-color: #FFFFFF');
                $('#ResultOutputByQCDept'+un_id).attr('style', 'background-color: #FFFFFF;border:1px solid #FFFFFF !important;');

                setSelectedIndex(document.getElementById("ResultOutputByQCDept"+un_id),"-");
            }
        }

        function setSelectedIndex(s, valsearch){
            for (i = 0; i< s.options.length; i++){ 
                if (s.options[i].value == valsearch){
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
        }

        $(document).ready(function(){
            var dataString ='action=qc_assay_Calculation_Based_On_ajax';
            $.ajax({  
                type: "POST",  
                url: 'ajax/kri_common-ajax.php',  
                data: dataString,  
                success: function(result){ 
                    $('#assay-append').html(result);
                }
            })
        });

        $(document).ready(function(){
            var dataString ='action=qc_get_SAMINTTRBY_ajax';
            $.ajax({  
                type: "POST",  
                dataType:'JSON',
                url: 'ajax/kri_common-ajax.php',  
                data: dataString,  
                success: function(result){ 
                    var html="";
                    result.forEach(function(value,index){
                        html +='<option value="'+value.TRBy+'">'+value.TRBy+'</option>';
                    });

                    $('#doneBy_1').html(html);
                }
            })
        });

        $(document).on('change','#browse-file',function(){
            var formData = new FormData($('#mform')[0]);  // Form Id
            formData.append("action",'qc_attachment_browser_ajax');  // Button Id
            var error = true;

            $.ajax({
                url: 'ajax/kri_common-ajax.php',
                type: "POST",
                data:formData,
                processData: false,
                contentType: false,
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    var JSONObject = JSON.parse(result);

                    $('#targetPath_1').val(JSONObject.targetPath);
                    $('#fileName_1').val(JSONObject.fileName);
                    $('#attachDate_1').val(JSONObject.attatchment_date);
                },complete:function(data){
                    $(".loader123").hide();
                }
            })
        })

        function add_qc_post_document_open_trans(){
            var formData = new FormData($('#qcPostDocumentForm_open_trans')[0]);  // Form Id
            formData.append("addQcPostDocumentBtn_open_trans",'addQcPostDocumentBtn_open_trans');  // Button Id

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

        function AutocalculateQC_Qty(){
            // <!-- calculate Quantity for QC status tab start ------------------------------ -->
                var rows = document.querySelectorAll('#qc-status-list-append tr');

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

        function addMore(num){
            var QC_Quantity = $('#qCStsQty_'+num).val();
            $('#qCStsQty_'+num).val(parseFloat(QC_Quantity).toFixed(3));

            var tr_count=$('#tr-count').val();
            var QCS_Qty = AutocalculateQC_Qty();

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
            })
        }

        function SelectionOfQC_Status(un_id) {
            var tr_count = parseInt($('#tr-count').val());

            var now = new Date();
            var year = now.getFullYear();
            var month = (now.getMonth() + 1).toString().padStart(2, '0');
            var day = now.getDate().toString().padStart(2, '0');
            // var formattedDate = `${day}-${month}-${year}`;
            var formattedDate = `${year}-${month}-${day}`;

            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var formattedTime = `${hours}:${minutes}`;

            $('#qCReleaseDate_' + un_id).val(formattedDate);
            $('#qCReleaseTime_' + un_id).val(formattedTime);

            if (tr_count !== 1) {
                var rows = $('#qc-status-list-append tr');
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

        function OpenInstrmentModal(un_id){
            $.ajax({ 
                type: "POST",
                url: 'ajax/common-ajax.php',
                data:{'un_id':un_id,'action':"OpenInstrmentModal_Ajax"},
                beforeSend: function(){
                    $(".loader123").show();
                },
                success: function(result){
                    var Table = JSON.parse(result);
                    $('#append_instrument_table').html(Table);
                },
                complete:function(data){
                    $(".loader123").hide();
                }
            })         
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
    </script>