<?php 
require_once './classes/function.php';
require_once './classes/kri_function.php';
$obj= new web();
$objKri=new webKri();

if(empty($_SESSION['Baroque_EmployeeID'])) {
    header("Location:login.php");
    exit(0);
}

if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list'){
    $getAllData=$obj->get_OTFSI_Data($API_RSQCPOSTDOC);
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
                        <th>WOEntry</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Stage Name</th>
                        <th>Batch No</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>WO Date</th>
                        <th>Mfg Date</th>
                        <th>Expiry Date</th>
                        <th>Sample Intimation No</th>
                        <th>Sample Collection No</th>
                        <th>Location</th>
                        <th>Batch Name</th>
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
                                    <td class="desabled" style="text-align: center;">'.$getAllData[$i]->SrNo.'.</td>
                                    <td style="width: 100px;vertical-align: middle; text-align: center;">
                                        <a href="" class="" data-bs-toggle="modal" data-bs-target=".qc_post_doc_route_stage" onclick="OT_PoPup_SampleCollection(\''.$getAllData[$i]->WODocEntry.'\',\''.$getAllData[$i]->BatchNo.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->LineNum.'\')">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                    <td class="desabled">'.$getAllData[$i]->WONo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WODocEntry.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                    <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                    <td class="desabled">'.$getAllData[$i]->RouteStage.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                    <td class="desabled">'.$getAllData[$i]->WoDate.'</td>
                                    <td class="desabled">'.$MfgDate.'</td>
                                    <td class="desabled">'.$ExpiryDate.'</td>
                                    <td class="desabled">'.$getAllData[$i]->SampleIntimationNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->SampleCollectionNo.'</td>
                                    <td class="desabled">'.$getAllData[$i]->Location.'</td>
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
<?php include 'models/qc_process/qc_post_doc_route_stage_model.php' ?>
    <style type="text/css">
        body[data-layout=horizontal] .page-content {padding: 20px 0 0 0;padding: 40px 0 60px 0;}
        .FreightInput {width: 100px;border: transparent;}
        .FreightInput:focus {border: transparent;outline: none;}
    </style>

    <div class="loader-top" style="height: 100%;width: 100%;background: #cccccc73;">
        <div class="loader123" style="text-align: center;z-index: 10000;position: fixed;top: 0; left: 0;bottom: 0;right: 0;background: #cccccc73;">
            <img src="loader/loader2.gif" style="width: 5%;padding-top: 288px !important;">
        </div>
    </div>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">Open Transaction For QC Post Document - Route Stage</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Open Transaction For QC Post Document - Route Stage</li>
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
                                <h4 class="card-title mb-0">Open Transaction For QC Post Document - Route Stage</h4>  
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

    function OnChangeReleaseDate(){
        var ShelfLife = $(`#routStage_ShelfLife`).val();
        // Convert ShelfLife to an integer
        ShelfLife = parseInt(ShelfLife, 10);

        var ReleaseDate = $(`#routStage_ReleaseDate`).val();

        // Initial date string in YYYY-MM-DD format
        var initialDateStr = ReleaseDate; // Example date

        // Parse initial date string to Date object
        var initialDate = new Date(initialDateStr);

        // Add months to the initial date
        var futureDate = addMonths(initialDate, ShelfLife);

        // Format the future date to YYYY-MM-DD
        var futureFormattedDate = formatDate(futureDate);

        // Set Value in Retest date
        $(`#routStage_RetestDate`).val(futureFormattedDate);
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
            url: 'ajax/kri_production_common_ajax.php',
            data:{'DocEntry':DocEntry,'BatchNo':BatchNo,'ItemCode':ItemCode,'LineNum':LineNum,'action':"OT_OpenTransactionForQCPostDocumentRouteStagen_popup"},

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){
                var JSONObjectAll = JSON.parse(result);
                var JSONObject=JSONObjectAll['SampleCollDetails'];

                $(`#qc-post-general-data-list-append`).html(JSONObjectAll['general_data']); // Extra Issue Table Tr tag append here
                $(`#qc-status-list-append`).html(JSONObjectAll['qcStatus']); // External Issue Table Tr tag append here
                $(`#qc-attach-list-append`).html(JSONObjectAll['qcAttach']);

                $(`#routStage_woEntry`).val(JSONObject[0].WODocEntry);
                $(`#routStage_woto`).val(JSONObject[0].WONo);
                $(`#routStage_itemCode`).val(JSONObject[0].ItemCode);
                $(`#routStage_itemName`).val(JSONObject[0].ItemName);
                $(`#routStage_genericName`).val('');
                $(`#routStage_LanelCliam`).val(JSONObject[0].LabelClaim);
                $(`#routStage_LabelCliamUOM`).val(JSONObject[0].LabelClaimUOM);
                $(`#routStage_RecievedQty`).val(JSONObject[0].RecQty);
                $(`#routStage_MfgBy`).val(JSONObject[0].MfgBy);
                $(`#routStage_RefNo`).val(JSONObject[0].BpRefNo);
                $(`#routStage_SpecificationNo`).val(JSONObject[0].SpecfNo);
                $(`#routStage_BatchNo`).val(JSONObject[0].BatchNo);
                $(`#routStage_BatchSize`).val(JSONObject[0].BatchQty);
                $(`#routStage_SampleIntimationNo`).val(JSONObject[0].SampleIntimationNo);
                $(`#routStage_SampleCollectionNo`).val(JSONObject[0].SampleCollectionNo);
                $(`#routStage_SampleQty`).val(JSONObject[0].SampleQty);
                $(`#routStage_RetainQty`).val('');
                $(`#routStage_MaterialType`).val(JSONObject[0].BpRefNo);
                $(`#routStage_PackSize`).val(JSONObject[0].PackSize);
                $(`#routStage_NoContainer`).val(JSONObject[0].TNCont);
                $(`#routStage_Stage`).val(JSONObject[0].RouteStage);
                $(`#routStage_Branch`).val(JSONObject[0].BranchName);
                $(`#routStage_Location`).val(JSONObject[0].Location);
                $(`#routStage_ValidUpTo`).val('');
                $(`#routStage_ARNo`).val('');
                $(`#routStage_GateEntryNo`).val(JSONObject[0].GateENo);
                $(`#routStage_Factor`).val(JSONObject[0].Factor);
                $(`#routStage_U_PC_NoCont1`).val('1');
                $(`#routStage_U_PC_NoCont2`).val(JSONObject[0].TNCont);
                $(`#routStage_BPLId`).val(JSONObject[0].BPLId);
                $(`#routStage_LocCode`).val(JSONObject[0].LocCode);
                $(`#routStage_RMWQC`).val('No');
                $(`#routStage_ShelfLife`).val(JSONObject[0].ShelfLife);
                $(`#routStage_AssayPotencyReq`).val(JSONObject[0].AssayPotencyReq)

                // <!-- ----------- Mfg Date Start Here -------------------------- -->
                    var mfgDateOG = JSONObject[0].MfgDate;
                    if(mfgDateOG!=''){
                        let [day, month, year] = mfgDateOG.split(" ")[0].split("-");
                        let mfgDate = `${year}-${month}-${day}`;

                        $(`#routStage_MfgDate`).val(mfgDate);
                    }
                // <!-- ----------- Mfg Date End Here ---------------------------- -->

                // <!-- ----------- Expiry Date Start Here ----------------------- -->
                    var ExpiryDateOG = JSONObject[0].ExpiryDate;
                    if(ExpiryDateOG!=''){
                        let [day, month, year] = ExpiryDateOG.split(" ")[0].split("-");
                        let ExpiryDate = `${year}-${month}-${day}`;

                        $(`#routStage_ExpiryDate`).val(ExpiryDate);
                    }
                // <!-- ----------- Expiry Date End Here ------------------------- -->

                // <!-- ----------- Wo Date Start Here --------------------------- -->
                    var WoDateOG = JSONObject[0].WoDate;
                    if(WoDateOG!=''){
                        let [day, month, year] = WoDateOG.split(" ")[0].split("-");
                        let WoDate = `${year}-${month}-${day}`;

                        $(`#routStage_WODate`).val(WoDate);
                    }
                // <!-- ----------- Wo Date End Here ----------------------------- -->

                // <!-- ----------- Create Retest date with adding shelflife Start here ---------- -->
                    var ShelfLife = JSONObject[0]['ShelfLife']; 

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

                    // Set Value in Retest date
                    $(`#routStage_RetestDate`).val(futureFormattedDate);
                // <!-- ----------- Create Retest date with adding shelflife End here ------------ -->

                getResultOutputDropdown(JSONObjectAll.count);
                QC_StatusByAnalystDropdown(JSONObjectAll.count);

                GetRowLevelAnalysisByDropdown(JSONObjectAll.count); // Get Row Level AnalysisBy Dropdown JavaScript Function Called.

                GetBottomApprovedBy(); // Get Bottom level Approved By and Done By Dropdown.
            },
            complete:function(data){
                SampleTypeDropdown();
            }
        }); 
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
        });
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
        });
    } 

    function SampleTypeDropdown(){
        var dataString ='TableId=@SCS_QCRSTAGE&Alias=PC_SamType&action=dropdownMaster_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){
                var JSONObject = JSON.parse(result);
                $('#routStage_SampleType').html(JSONObject);
            },
            complete:function(data){
                getSeriesDropdown();
            }
        });
    }

    function getSeriesDropdown(){
        var TrDate= $('#routStage_PostingDate').val();
        var dataString ='TrDate='+TrDate+'&ObjectCode=SCS_QCRSTAGE&action=getSeriesDropdown_ajax';
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
                $('#routStage_DocName').html(SeriesDropdown);
                selectedSeries(); // call Selected Series Single data function
            },
            complete:function(data){
            }
        }); 
    }

    function selectedSeries(){
        var TrDate= $('#routStage_PostingDate').val();
        var Series=document.getElementById('routStage_DocName').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=SCS_QCRSTAGE&action=getSeriesSingleData_ajax';
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
                $('#routStage_DocNo').val(Series);
                $('#NextNumber').val(NextNumber);
            },
            complete:function(data){
                QC_TestTypeDropdown();
            }
        }); 
    }

    function QC_TestTypeDropdown(){
        var dataString ='TableId=@SCS_QCRSTAGE&Alias=PC_QCTType&action=dropdownMaster_ajax';
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
                $('#routStage_QCTesttype').html(JSONObject);
            },
            complete:function(data){
                qc_assayCalculationDropdown();
            }
        });
    }

    function qc_assayCalculationDropdown(){
        var dataString ='action=qc_FGassay_Calculation_Based_On_routStage_ajax';
        $.ajax({  
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result){ 
                $('#routStage_AssayCalc').html(result);
            },
            complete:function(data){
                Compiled_ByDropdown();
            }
        });
    }

    function Compiled_ByDropdown(){
        getQcStatusDropodwn(1);
        getDoneByDroopdown(1);
        $(".loader123").hide();
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
                if(parseFloat(ComparisonResultOG)>=parseFloat(lowMin)){
                    $('#ResultOutputByQCDeptTd'+un_id).attr('style', 'background-color: #c7f3c7');
                    $('#ResultOutputByQCDept'+un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');

                    setSelectedIndex(document.getElementById("ResultOutputByQCDept"+un_id),"PASS");
                }else{
                    $('#ResultOutputByQCDeptTd'+un_id).attr('style', 'background-color: #f8a4a4');
                    $('#ResultOutputByQCDept'+un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');

                    setSelectedIndex(document.getElementById("ResultOutputByQCDept"+un_id),"FAIL");
                }
            } else {
                if(parseFloat(ComparisonResultOG)>=parseFloat(lowMin) && parseFloat(ComparisonResultOG)<=parseFloat(uppMax)){
                    $('#ResultOutputByQCDeptTd'+un_id).attr('style', 'background-color: #c7f3c7');
                    $('#ResultOutputByQCDept'+un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');

                    setSelectedIndex(document.getElementById("ResultOutputByQCDept"+un_id),"PASS");
                }else{
                    $('#ResultOutputByQCDeptTd'+un_id).attr('style', 'background-color: #f8a4a4');
                    $('#ResultOutputByQCDept'+un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');

                    setSelectedIndex(document.getElementById("ResultOutputByQCDept"+un_id),"FAIL");
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
        for (i = 0; i< s.options.length;i++){ 
            if (s.options[i].value == valsearch){
                // Item is found. Set its property and exit
                s.options[i].selected = true;
                break;
            }
        }
        return;
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

    function getResultOutputDropdown(trcount){
        $.ajax({ 
            type: "POST",
            url: 'ajax/common-ajax.php',
            data:{'action':"ResultOutputDropdown_ajax"},
            success: function(result){
                for (let i = 0; i < trcount; i++) {
                    $('#ResultOutputByQCDept'+i).html(result);
                }
            }
        });
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

                $('#routStage_CheckedBy').html(dropdown); // Bottom dropdown set using Id
                $('#routStage_AnalysisBy').html(dropdown); // Bottom dropdown set using Id
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });         
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

                $('#routStage_ApprovedBy').html(dropdown.ApprovedBy); // Bottom Approved By dropdown set using Id
            },
            complete:function(data){
                $(".loader123").hide();
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
            success: function(result){
                var JSONObject = JSON.parse(result);
                for (let i = 0; i < trcount; i++) {
                    $('#QC_StatusByAnalyst'+i).html(JSONObject); // dropdown set using Class
                }
            }
        });
    }

    function CalculatePotency(){
        // <!-- -----------  LoD / Water Value Preparing Start Here ------------------------------- -->
            var lod_waterOG=document.getElementById('routStage_LODWater').value;

            if((parseFloat(lod_waterOG).toFixed(6))<='0.000000' || lod_waterOG=='' || lod_waterOG==null){
                var lod_water='0.000000';
                $('#routStage_LODWater').val(lod_water);
            }else{
                var lod_water=parseFloat(lod_waterOG).toFixed(6);
                $('#routStage_LODWater').val(lod_water);
            }
        // <!-- -----------  LoD / Water Value Preparing End Here --------------------------------- -->

        // <!-- -----------  AssayPotency Value Preparing Start Here ------------------------------- -->
            var assayPotencyOG=document.getElementById('routStage_AssayPotency').value;

            if((parseFloat(assayPotencyOG).toFixed(6))<='0.000000' || assayPotencyOG=='' || assayPotencyOG==null){
                var assayPotency='0.000000';
                $('#routStage_AssayPotency').val(assayPotency);
            }else{
                var assayPotency=parseFloat(assayPotencyOG).toFixed(6);
                $('#routStage_AssayPotency').val(assayPotency);
            }
        // <!-- -----------  AssayPotency Value Preparing End Here --------------------------------- -->

        var Potency=((100- parseFloat(lod_water))/100)*parseFloat(assayPotency); // Calculation
        $('#routStage_Potency').val(parseFloat(Potency).toFixed(6)); // Set Potency calculated val
    } 

    function add_qc_post_document(){
        var formData = new FormData($('#QcDpcumentFormRouteStage')[0]);  // Form Id
        formData.append("addQcPostDocumentSubmitQCCheckRouteStageBtn",'addQcPostDocumentSubmitQCCheckRouteStageBtn');  // Button Id
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
        });
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
            $('#qCStsQty_' + un_id).val($('#routStage_BatchSize').val());
        }
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

            var BatchQty = $('#routStage_BatchSize').val();
            var QCS_Qty=parseFloat(parseFloat(BatchQty)- parseFloat(sum)).toFixed(3);
            return QCS_Qty;
        // <!-- calculate Quantity for QC status tab end -------------------------------- -->
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

    function addMore(num){
        // Formate manula enter Quantity
        var QC_Quantity = $('#qCStsQty_'+num).val();
        $('#qCStsQty_'+num).val(parseFloat(QC_Quantity).toFixed(3));

        var tr_count=$('#tr-count').val();
        var QCS_Qty = AutocalculateQC_Qty();

        // Proceed with AJAX request only if QCS_Qty is not equal to 0.00
        if (parseFloat(QCS_Qty) !== 0.00) {
            var tr_count=$('#tr-count').val();
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
    }
</script>