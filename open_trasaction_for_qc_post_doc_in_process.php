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
    $getAllData=$obj->get_OTFSI_Data($INPROCESSQCPOSTDOC);
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
                        <th>RFP No</th>
                        <th>RFP Doc Entry</th>
                        <th>WO No</th>
                        <th>WO DocEntry</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Material Type</th>
                        <th>UOM</th>
                        <th>Batch No</th>
                        <th>Batch Qty</th>
                        <th>Mfg Date</th>
                        <th>Expiry Date</th>
                        <th>DocDate</th>
                        <th>Sample Intimation No</th>
                        <th>Sample Collection No</th>
                        <th>Branch Name</th>
                        <th>Location</th>
                        <th>MakeBy</th>
                    </tr>
                </thead>
                <tbody>';

                if(count($getAllData)!='0'){
                    for ($i=$r_start; $i <$r_end ; $i++) { 
                        if(!empty($getAllData[$i]->SrNo)){   //  this condition save to extra blank loop
                            // --------------- Convert String code Start Here ---------------------------
                                $MfgDate=(!empty($getAllData[$i]->MfgDate)) ? date("d-m-Y", strtotime($getAllData[$i]->MfgDate)) : null;

                                $ExpiryDate=(!empty($getAllData[$i]->ExpiryDate)) ? date("d-m-Y", strtotime($getAllData[$i]->ExpiryDate)) : null;

                                $DocDate=(!empty($getAllData[$i]->DocDate)) ? date("d-m-Y", strtotime($getAllData[$i]->DocDate)) : null;
                            // --------------- Convert String code End Here-- ---------------------------

                            $option.='
                            <tr>
                                <td class="desabled" style="text-align: center;">'.$getAllData[$i]->SrNo.'.</td>
                                <td style="width: 100px;vertical-align: middle; text-align: center;">
                                    <a href="" class="" data-bs-toggle="modal" data-bs-target=".qc_post_doc_in_process" onclick="OT_PoPup_SampleCollection_in_process(\''.$getAllData[$i]->RFPDocEntry.'\',\''.$getAllData[$i]->BatchNo.'\',\''.$getAllData[$i]->ItemCode.'\',\''.$getAllData[$i]->LineNum.'\')">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>

                                <td class="desabled">'.$getAllData[$i]->RFPNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->RFPDocEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->WONo.'</td>
                                <td class="desabled">'.$getAllData[$i]->WODocEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                <td class="desabled">'.$getAllData[$i]->MaterialType.'</td>
                                <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                <td class="desabled">'.$MfgDate.'</td>
                                <td class="desabled">'.$ExpiryDate.'</td>
                                <td class="desabled">'.$DocDate.'</td>
                                <td class="desabled">'.$getAllData[$i]->SampleIntimationNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->SampleCollectionNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->BranchName.'</td>
                                <td class="desabled">'.$getAllData[$i]->Location.'</td>
                                <td class="desabled">'.$getAllData[$i]->MakeBy.'</td>
                            </tr>';
                        }
                    }
                }else{
                    $option.='<tr><td colspan="20" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
                }
        $option.='</tbody> 
    </table>'; 

    $option.=$pagination;        
    echo $option;
    exit(0);
}
?>
<?php include 'include/header.php' ?>
<?php include 'models/qc_process/qc_post_doc_in_process_model.php' ?>
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
                <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Open Transaction For QC Post Document - In Process</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Open Transaction For QC Post Document - In Process</li>
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
                                <h4 class="card-title mb-0">Open Transaction For QC Post Document - In Process</h4>  
                            </div>

                            <div class="card-body">
                                <div class="table-responsive" id="list-append"></div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Page-content -->

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
        })
    });

    function OT_PoPup_SampleCollection_in_process(DocEntry, BatchNo, ItemCode, LineNum) {
        $.ajax({ 
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: {'DocEntry': DocEntry,'BatchNo': BatchNo,'ItemCode': ItemCode,'LineNum': LineNum,'action': "OT_Open_Transaction_For_QC_popup_in_process"},
            beforeSend: function() {
                $(".loader123").show();
            },
            success: function(result) {
                var JSONObjectAll = JSON.parse(result);

                var JSONObject = JSONObjectAll['SampleCollDetails'];
                // console.log('OT_PoPup_SampleCollection_in_process=>', JSONObject);
                
                $(`#qc-post-general-data-list-append`).html(JSONObjectAll['general_data']);
                $(`#qc-status-list-append`).html(JSONObjectAll['qcStatus']);
                $(`#qc-attach-list-append`).html(JSONObjectAll['qcAttach']);

                $(`#QC_CK_D_ReceiptNo`).val(JSONObject[0].RFPNo);
                $(`#QC_CK_D_ReceiptDocEntry`).val(JSONObject[0].RFPDocEntry);
                $(`#QC_CK_D_WODocEntry`).val(JSONObject[0].WODocEntry);
                $(`#QC_CK_D_WoNo`).val(JSONObject[0].WONo);
                $(`#QC_CK_D_RefNo`).val(JSONObject[0].BpRefNo);
                $(`#QC_CK_D_ItemCode`).val(JSONObject[0].ItemCode);
                $(`#QC_CK_D_ItemName`).val(JSONObject[0].ItemName);
                $(`#QC_CK_D_GenericName`).val(JSONObject[0].FrgnName);
                $(`#QC_CK_D_LabelCliam`).val(JSONObject[0].LabelClaim);
                $(`#QC_CK_D_RecievedQty`).val(JSONObject[0].BatchQty);
                $(`#QC_CK_D_MfgBy`).val(JSONObject[0].MfgBy);
                $(`#QC_CK_D_BatchNo`).val(JSONObject[0].BatchNo);
                $(`#QC_CK_D_BatchSize`).val(JSONObject[0].BatchSize);
                $(`#QC_CK_D_PackSize`).val(JSONObject[0].PackSize);
                $(`#QC_CK_D_Branch`).val(JSONObject[0].BranchName);
                $(`#QC_CK_D_ARNo`).val(JSONObject[0].ARNo);
                $(`#QC_CK_D_QCTesttype`).val(JSONObject[0].GateEntryNo);
                $(`#QC_CK_D_Factor`).val(JSONObject[0].Factor);
                $(`#QC_CK_D_NoOfContainer`).val(JSONObject[0].TNCont);
                $(`#QC_CK_D_FromContainer`).val(JSONObject[0].FCont);
                $(`#QC_CK_D_ToContainer`).val(JSONObject[0].TCont);
                $(`#QC_CK_D_BPLId`).val(JSONObject[0].BPLId);
                $(`#QC_CK_D_BatchQty`).val(JSONObject[0].BatchQty);
                $(`#QC_CK_D_LineNum`).val(JSONObject[0].LineNum);
                $(`#QC_CK_D_LocCode`).val(JSONObject[0].LocCode);
                $(`#QC_CK_D_MfgDate`).val(DateFormatingYMD(JSONObject[0].MfgDate));
                $(`#QC_CK_D_ExpiryDate`).val(DateFormatingYMD(JSONObject[0].ExpiryDate));
                $(`#QC_CK_D_SampleIntimationNo`).val(JSONObject[0].SampleIntimationNo);
                $(`#QC_CK_D_SampleCollectionNo`).val(JSONObject[0].SampleCollectionNo);
                $(`#QC_CK_D_SampleQty`).val(JSONObject[0].SampleQty);
                $(`#QC_CK_D_GateENo`).val(JSONObject[0].GateENo);
                $(`#QC_CK_D_SpecfNo`).val(JSONObject[0].SpecfNo);
                $(`#QC_CK_D_RetestDate`).val(JSONObject[0].RetestDate);
                $(`#QC_CK_D_Loc`).val(JSONObject[0].Location);
                $(`#QC_CK_D_MakeBy`).val(JSONObject[0].MakeBy);
                $(`#QC_CK_D_MaterialType`).val(JSONObject[0].MaterialType);

                $(`#QC_CK_D_Stage`).val('');
                $(`#QC_CK_D_ValidUpTo`).val('');
                $(`#QC_CK_D_Remarks`).val('');
                $(`#QC_CK_D_QtyPerContainer`).val('');

                getstageDropdown();
                QC_StatusByAnalystDropdown(JSONObjectAll.count);
                getResultOutputDropdown(JSONObjectAll.count);
                getQcStatusDropodwn(1);
                getDoneByDroopdown(1);
                GetRowLevelAnalysisByDropdown(JSONObjectAll.count);
                assayapp();
            },
            complete: function(data) {
                Compiled_ByDropdown();
            }
        }) 
    }

    function DateFormatingYMD(DateOG){
        // alert(DateOG);
        if(DateOG!=''){
            let [day, month, year] = DateOG.split(" ")[0].split("-");
            // let Date = `${day}-${month}-${year}`;
            let Date = `${year}-${month}-${day}`;
            return Date;
        }
    }

    function getstageDropdown() {
        var dataString = 'action=getstageDropdown_ajax';
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
                $('#QC_CK_D_Stage').html(JSONObject);
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        })
    }

    function Compiled_ByDropdown(){
        var dataString ='action=Compiled_By_dropdown_ajax';
        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_production_common_ajax.php',  
            data: dataString, 
            beforeSend: function(){
                $(".loader123").show();
            }, 
            success: function(result){ 
                $('#QC_CK_D_CompiledBy').html(result);
                $('#QC_CK_D_CheckedBy').html(result);
                $('#QC_CK_D_AnalysisBy').html(result);
            },
            complete:function(data){
                QC_TestTypeDropdown();
            }
        })
    }

    function QC_TestTypeDropdown(){
        var dataString ='TableId=@SCS_QCINPROC&Alias=PC_QCTType&action=dropdownMaster_ajax';
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
                $('#QC_CK_D_QCTesttype').html(JSONObject);
            },
            complete:function(data){
                SampleTypeDropdown();
            }
        })
    }

    function SampleTypeDropdown(){
        var dataString ='TableId=@SCS_QCPD&Alias=SamType&action=dropdownMaster_ajax';
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
                $('#QC_CK_D_SampleType').html(JSONObject);
            },
            complete:function(data){
                getSeriesDropdown();
            }
        })
    }

    function getSeriesDropdown() {
        var TrDate=$('#QC_CK_D_PostingDate').val();
        var dataString = 'TrDate='+TrDate+'&ObjectCode=SCS_QCINPROC&action=getSeriesDropdown_ajax';
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
                $('#QC_CK_D_DocName').html(SeriesDropdown);

                selectedSeries(); // call Selected Series Single data fun
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        })
    }

    function selectedSeries(){
        var TrDate=$('#QC_CK_D_PostingDate').val();
        var Series=document.getElementById('QC_CK_D_DocName').value;
        var dataString ='TrDate='+TrDate+'&Series='+Series+'&ObjectCode=SCS_QCINPROC&action=getSeriesSingleData_ajax';
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

                $('#QC_CK_D_DocNo').val(NextNumber);
                $('#QC_CK_D_series').val(Series);
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
            success: function(result){
                var JSONObject = JSON.parse(result);
                for (let i = 0; i < trcount; i++) {
                    $('#QC_StatusByAnalyst'+i).html(JSONObject); // dropdown set using Class
                }
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

                $('#routStage_CheckedBy').html(dropdown); // Bottom dropdown set using Id
                $('#routStage_AnalysisBy').html(dropdown); // Bottom dropdown set using Id
            },
            complete:function(data){
                $(".loader123").hide();
            }
        })
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
            $('#qCStsQty_' + un_id).val($('#QC_CK_D_BatchSize').val());
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

        var BatchQty = $('#QC_CK_D_BatchSize').val();
        var QCS_Qty=parseFloat(parseFloat(BatchQty)- parseFloat(sum)).toFixed(3);
        return QCS_Qty;
        // <!-- calculate Quantity for QC status tab end -------------------------------- -->
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
            })
        }
    }

    function setSelectedIndex(s, valsearch){
        // Loop through all the items in drop down list
        for (i = 0; i< s.options.length; i++){ 
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

    function CalculatePotency(){
        // <!-- -----------  LoD / Water Value Preparing Start Here ------------------------------- -->
            var lod_waterOG=document.getElementById('QC_CK_D_LODWater').value;

            if((parseFloat(lod_waterOG).toFixed(6))<='0.000000' || lod_waterOG=='' || lod_waterOG==null){
                var lod_water='0.000000';
                $('#QC_CK_D_LODWater').val(lod_water);
            }else{
                var lod_water=parseFloat(lod_waterOG).toFixed(6);
                $('#QC_CK_D_LODWater').val(lod_water);
            }
        // <!-- -----------  LoD / Water Value Preparing End Here --------------------------------- -->

        // <!-- -----------  AssayPotency Value Preparing Start Here ------------------------------- -->
            var assayPotencyOG=document.getElementById('QC_CK_D_AssayPotency').value;

            if((parseFloat(assayPotencyOG).toFixed(6))<='0.000000' || assayPotencyOG=='' || assayPotencyOG==null){
                var assayPotency='0.000000';
                $('#QC_CK_D_AssayPotency').val(assayPotency);
            }else{
                var assayPotency=parseFloat(assayPotencyOG).toFixed(6);
                $('#QC_CK_D_AssayPotency').val(assayPotency);
            }
        // <!-- -----------  AssayPotency Value Preparing End Here --------------------------------- -->

        var Potency=((100- parseFloat(lod_water))/100)*parseFloat(assayPotency); // Calculation
        $('#QC_CK_D_Potency').val(parseFloat(Potency).toFixed(6)); // Set Potency calculated val
    }  

    function assayapp(){
        var dataString ='action=qc_assay_Calculation_Based_On_ajax';
        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_production_common_ajax.php',  
            data: dataString,  
            success: function(result){ 
                $('#QC_CK_D_Assay').html(result);
            }
        })
    }

    function add_qc_post_document(){
        var formData = new FormData($('#qcPostDocumentForm')[0]);  // Form Id
        formData.append("addQcPostDocumentQCCheckBtn",'addQcPostDocumentQCCheckBtn');  // Button Id
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
        })
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
</script>