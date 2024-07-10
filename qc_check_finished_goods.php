<?php 
require_once './classes/function.php';
require_once './classes/kri_function.php';
$obj= new web();
$objKri=new webKri();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}


// $UT_data = array();
// $itme = array();

// $UT_data['DocEntry'] = 1126;
// // $UT_data['Object'] = 'SCS_QCPDFG';
// $itme['LineId'] = 1;
// $itme['Object'] = 'SCS_QCPDFG';
// $itme['U_PC_ITNo'] = 20407;

// $UT_data['SCS_QCPDFG2Collection'][] = $itme;

// echo '<pre>';
// print_r(json_encode($UT_data));
// die ();


if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list')
{
    $tdata=array();
    $tdata['FromDate']=date('Ymd', strtotime($_POST['fromDate']));
    $tdata['ToDate']=date('Ymd', strtotime($_POST['toDate']));
    $tdata['DocEntry']=trim(addslashes(strip_tags($_POST['DocEntry'])));
    $getAllData=$obj->getSimpleIntimation($FGQCPOSTDOCUMENTDETAILS,$tdata);

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
                    <th>DocEntry</th>
                    <th>WO No</th>
                    <th>RFP Entry</th>
                    <th>Material Type</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Unit</th>
                    <th>WO Qty</th> 
                    <th>Batch No</th>
                    <th>Batch Qty</th>
                    <th>MFG Date</th>
                    <th>Expiry Date</th>
                    <th>Branch Name</th>
                </tr>
                </thead>
                <tbody>';
 
                if(count($getAllData)!='0'){
                    for ($i=$r_start; $i <$r_end ; $i++) { 
                        if(!empty($getAllData[$i]->RFPNo)){   //  this condition save to extra blank loop
                            $SrNo=$i+1;
                            // --------------- Convert String code Start Here ---------------------------
                                if(empty($getAllData[$i]->MfgDate)){
                                    $MfgDate='';
                                }else{
                                    $MfgDate = str_replace('/', '-', $getAllData[$i]->MfgDate);
                                    $MfgDate=date("d-m-Y", strtotime($MfgDate));
                                }

                                if(empty($getAllData[$i]->ExpiryDate)){
                                    $ExpiryDate='';
                                }else{
                                    $ExpiryDate = str_replace('/', '-', $getAllData[$i]->ExpiryDate);
                                    $ExpiryDate=date("d-m-Y", strtotime($ExpiryDate));
                                }
                            // --------------- Convert String code End Here-- ---------------------------

                        $option.='
                            <tr>
                                <td class="desabled">'.$SrNo.'</td>
                                <td style="text-align: center;">
                                    <input type="radio" id="list'.$getAllData[$i]->DocEntry.'" name="listRado" value="'.$getAllData[$i]->DocEntry.'" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedRecord('.$getAllData[$i]->DocEntry.')">
                                </td>
                                <td class="desabled">'.$getAllData[$i]->DocEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->WONo.'</td>
                                <td class="desabled">'.$getAllData[$i]->RFPEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->MatType.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                <td class="desabled">'.$getAllData[$i]->Unit.'</td>
                                <td class="desabled">'.$getAllData[$i]->WOQty.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                <td class="desabled">'.$MfgDate.'</td>
                                <td class="desabled">'.$ExpiryDate.'</td>
                                <td class="desabled">'.$getAllData[$i]->Branch.'</td>
                            </tr>';
                        }
                    }
                }else{
                     $option.='<tr><td colspan="16" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
                }
        $option.='</tbody> 
    </table>'; 

    $option.=$pagination;        
    echo $option;
    exit(0);
}
?>

<?php include 'include/header.php' ?>
<?php include 'models/qc_process/qc_check_finished_goods_model.php' ?>
<div class="loader-top" style="height: 100%;width: 100%;background: #cccccc73;">
    <div class="loader123" style="text-align: center;z-index: 10000;position: fixed;top: 0; left: 0;bottom: 0;right: 0;background: #cccccc73;">
        <img src="loader/loader2.gif" style="width: 5%;padding-top: 288px !important;">
    </div>
</div>
<style type="text/css">
    .form-control[readonly] {
        background-color: #efefef;
        opacity: 1;
        border: 1px solid #efefef !important;
    }
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
                            <h4 class="mb-0"></h4>QC Post document (QC Check) - Finished Goods

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">QC Post document (QC Check) - Finished Goods</li>
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
                                <h4 class="card-title mb-0">QC Post document (QC Check) - Finished Goods</h4>  
                            </div>

                            <div class="card-body">

                                <div class="top_filter">
                                    <div class="row">

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label" for="val-skill" style="margin-top: -6px;">From Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="FromDate" name="FromDate" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d').'-3 days'))?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label" for="val-skill" style="margin-top: -6px;">To Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="ToDate" name="ToDate" value="<?php echo date("Y-m-d") ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label" for="val-skill" style="margin-top: -6px;">Intimation No</label>
                                                <div class="col-lg-8">
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control" name="DocEntry" id="DocEntry">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                         

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row">
                                                <div class="col-lg-4" style="">
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

                <br>

                <div class="row" id="footerProcess">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <form role="form" class="form-horizontal" id="QcDpcumentFormfinisheGoods" method="post">

                                    <input type="hidden" id="QC_P_DOC_FG_DocEntry" name="QC_P_DOC_FG_DocEntry">
                                    <input type="hidden" id="QC_P_DOC_FG_BranchID" name="QC_P_DOC_FG_BranchID">
                                    <input type="hidden" id="QC_P_DOC_FG_FromWhs" name="QC_P_DOC_FG_FromWhs">
                                    <input type="hidden" id="QC_P_DOC_FG_ToWhs" name="QC_P_DOC_FG_ToWhs">
                                    <input type="hidden" id="QC_P_DOC_FG_DocNum" name="QC_P_DOC_FG_DocNum">
                                    <!-- <input type="hidden" id="QC_P_DOC_FG_LocCode" name="QC_P_DOC_FG_LocCode"> -->
                                    <input type="hidden" id="QC_P_DOC_FG_WOEntry" name="QC_P_DOC_FG_WOEntry">
                                    <input type="hidden" id="QC_P_DOC_FG_MfgDate" name="QC_P_DOC_FG_MfgDate">
                                    <input type="hidden" id="QC_P_DOC_FG_ExpiryDate" name="QC_P_DOC_FG_ExpiryDate">
                                    <input type="hidden" id="QC_P_DOC_FG_SampleIntimationNo" name="QC_P_DOC_FG_SampleIntimationNo">
                                    <input type="hidden" id="QC_P_DOC_FG_SampleCollectionNo" name="QC_P_DOC_FG_SampleCollectionNo">
                                    <input type="hidden" id="QC_P_DOC_FG_SampleQty" name="QC_P_DOC_FG_SampleQty">
                                    <input type="hidden" id="QC_P_DOC_FG_RetainQty" name="QC_P_DOC_FG_RetainQty">
                                    <input type="hidden" id="QC_P_DOC_FG_GateENo" name="QC_P_DOC_FG_GateENo">
                                    <input type="hidden" id="QC_P_DOC_FG_SpecfNo" name="QC_P_DOC_FG_SpecfNo"> 
                                    <input type="hidden" id="QC_P_DOC_FG_GRQty" name="QC_P_DOC_FG_GRQty"> 
                                    <input type="hidden" id="QC_P_DOC_FG_RelDate" name="QC_P_DOC_FG_RelDate">
                                    <input type="hidden" id="QC_P_DOC_FG_ReTsDt" name="QC_P_DOC_FG_ReTsDt">
                                    <input type="hidden" id="QC_P_DOC_FG_RMWQC" name="QC_P_DOC_FG_RMWQC">

                                    <div class="row">

                                       
                                    <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="QC_P_DOC_FG_WONo" name="QC_P_DOC_FG_WONo" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="QC_P_DOC_FG_WODocEntry" name="QC_P_DOC_FG_WODocEntry" readonly>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-xl-3 col-md-6"   style="display: none;">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_LocCode" name="QC_P_DOC_FG_LocCode">

                                                  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location </label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_Loc" name="QC_P_DOC_FG_Loc">

                                                  
                                                </div>
                                            </div>
                                        </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="QC_P_DOC_FG_ReceiptNo" name="QC_P_DOC_FG_ReceiptNo" readonly>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input class="form-control desabled" type="text" id="QC_P_DOC_FG_ReceiptDocEntry" name="QC_P_DOC_FG_ReceiptDocEntry" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_ItemCode" name="QC_P_DOC_FG_ItemCode">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_ItemName" name="QC_P_DOC_FG_ItemName">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Generic Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_GenericName" name="QC_P_DOC_FG_GenericName">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Cliam</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_LabelCliam" name="QC_P_DOC_FG_LabelCliam">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Recieved Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_RecievedQty" name="QC_P_DOC_FG_RecievedQty">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_MfgBy" name="QC_P_DOC_FG_MfgBy">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">MakeBy</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_MakeBy" name="QC_P_DOC_FG_MakeBy">
                                                </div>
                                            </div>
                                        </div>


                                        <!-- <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="QC_P_DOC_FG_ReceiptNo" name="QC_P_DOC_FG_ReceiptNo" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="QC_P_DOC_FG_ReceiptDocEntry" name="QC_P_DOC_FG_ReceiptDocEntry" readonly>
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-7 col-form-label mt-6" for="val-skill">Release Material Without QC</label>
                                                <div class="col-lg-5">
                                                    <select class="form-select" id="QC_P_DOC_FG_RelMaterialWithoutQC" name="QC_P_DOC_FG_RelMaterialWithoutQC">
                                                        <option value="Yes">Yes</option>
                                                        <option value="No" Selected>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ref No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_RefNo" name="QC_P_DOC_FG_RefNo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_BatchNo" name="QC_P_DOC_FG_BatchNo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_BatchSize" name="QC_P_DOC_FG_BatchSize">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Pack Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_PackSize" name="QC_P_DOC_FG_PackSize">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                                <div class="col-lg-8">
                                                    <select class="form-select desabled" id="QC_P_DOC_FG_SampleType" name="QC_P_DOC_FG_SampleType"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_MaterialType" name="QC_P_DOC_FG_MaterialType">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_Branch" name="QC_P_DOC_FG_Branch">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No.</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="QC_P_DOC_FG_ARNo" name="QC_P_DOC_FG_ARNo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>

                                                <div class="col-lg-4">
                                                    <select class="form-control desabled" type="text" id="QC_P_DOC_FG_DocName" name="QC_P_DOC_FG_DocName" onchange="selectedSeries()"></select>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="QC_P_DOC_FG_DocNo" name="QC_P_DOC_FG_DocNo" readonly>
                                                </div>

                                                
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="QC_P_DOC_FG_PostingDate" name="QC_P_DOC_FG_PostingDate" value="<?php echo date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="QC_P_DOC_FG_AnalysisDate" name="QC_P_DOC_FG_AnalysisDate" value="<?php echo date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">QC Test type</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control desabled" type="text" id="QC_P_DOC_FG_QCTesttype" name="QC_P_DOC_FG_QCTesttype"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stage</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control desabled" type="text" id="QC_P_DOC_FG_Stage" name="QC_P_DOC_FG_Stage"></select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Valid Up To</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="QC_P_DOC_FG_ValidUpTo" name="QC_P_DOC_FG_ValidUpTo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-wrap gap-2"></div>

                                    </div>
                                    <br><br>


                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card">                                
                                                <div class="card-body">

                                                    <ul class="nav nav-tabs" role="tablist">

                                                        <li class="nav-item">
                                                            <a class="nav-link active" data-bs-toggle="tab" href="#general_data2" role="tab">
                                                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                                <span class="d-none d-sm-block">General Data</span>    
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#qc_status2" role="tab">
                                                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                                <span class="d-none d-sm-block">QC Status</span>    
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a class="nav-link" data-bs-toggle="tab" href="#attatchment2" role="tab">
                                                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                                <span class="d-none d-sm-block">Attatchment</span>    
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <div class="tab-content p-3 text-muted">
                                                        <div class="tab-pane active" id="general_data2" role="tabpanel">
                                                            <div class="table-responsive qc_list_table table_item_padding" id="list2">
                                                                <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                                    <thead class="fixedHeader1">
                                                                    <tr>
                                                                            <th>Sr.No</th>
                                                                            <th>Parameter Code</th>
                                                                            <th>Parameter Name</th>
                                                                            <th>Specification</th>
                                                                            <th>Result OutPut</th>
                                                                            <th>Comparison Result</th>
                                                                            <th>Result Output By QC Dept.</th>
                                                                            <th>Parameter Data Type</th>
                                                                            <th>Logical</th>
                                                                            <th>Lower Min</th>
                                                                            <th>Upper Max</th>
                                                                            <th>Mean</th>
                                                                            <th>QC Status by Analyst</th>
                                                                            <th>Test Method</th>
                                                                            <th>Material Type</th>
                                                                            <th>Pharmacopoeial Standard</th>
                                                                            <th>UOM</th>
                                                                            <th>Retest</th>
                                                                            <th>External Sample</th>
                                                                            <th>Analysis By</th>
                                                                            <th>Analyst Remarks</th>
                                                                            <th>Lower Max</th>
                                                                            <th>Release</th>
                                                                            <th>Descriptive Details</th>
                                                                            <th>Upper Min</th>
                                                                            <th>Lower Min - Result</th>
                                                                            <th>Upper Min - Result</th>
                                                                            <th>Upper Max - Result</th>
                                                                            <th>Mean - Result</th>
                                                                            <th>User Text-1</th>
                                                                            <th>User Text-2</th>
                                                                            <th>User Text-3</th>
                                                                            <th>User Text-4</th>
                                                                            <th>User Text-5</th>
                                                                            <th>QC Setup Remark</th>
                                                                            <th>Stability</th>
                                                                            <th>Applicable for Assay</th>
                                                                            <th>Applicable for LOD</th>
                                                                            <th>Instrument Code</th>
                                                                            <th>Instrument Name</th>
                                                                            <th>Start Date</th>
                                                                            <th>Start Time</th>
                                                                            <th>End Date</th>
                                                                            <th>End Time</th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody id="qc-post-general-data-list-append"></tbody> 

                                                                </table>
                                                            </div> 
                                                        </div> 

                                                        <div class="tab-pane" id="qc_status2" role="tabpanel">

                                                            <div class="table-responsive" id="list">
                                                                <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                                    <thead class="fixedHeader1">
                                                                    <tr>
                                                                     <th>Sr. No</th>

                                                                     <th style="width:150px;display: block;">Status</th>
                                                                     <th>Quantity</th>
                                                                     <th>Release Date</th>
                                                                     <th>Release Time</th>
                                                                     <th>IT No</th>
                                                                     <th style="width:150px;display: block;">Done By</th>
                                                                     <th>Attachment 1</th>
                                                                     <th>Attachment 2</th>
                                                                     <th>Attachment 3</th>
                                                                     <th>Deviation Date</th>
                                                                     <th>Deviation No</th>
                                                                     <th>Deviation Reason</th>
                                                                     <th>Remarks</th>

                                                                 </tr>
                                                                    </thead>
                                                                    <tbody id="qc-status-list-append" class="testingAppend"></tbody> 

                                                                </table>
                                                            </div>

                                                            <div class="row">

                                                                <div class="col-xl-3 col-md-6" style="display: none;">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-5 col-form-label mt-6" for="val-skill">GRPO Remaining Qty</label>
                                                                        <div class="col-lg-7">
                                                                            <input class="form-control" type="text" id="" name="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>       
                                                        </div>

                                                        <div class="tab-pane" id="attatchment2" role="tabpanel">

                                                            <div class="row">
                                                                <div class="col-md-10">
                                                                    <div class="table-responsive" id="list">
                                                                        <table id="tblItemRecord" class="table table-bordered" style="">
                                                                            <thead class="fixedHeader1">
                                                                                <tr>
                                                                                    <th>Sr. No</th>
                                                                                    <th>Target Path</th>
                                                                                    <th>File Name</th>
                                                                                    <th>Attatchment Date</th>
                                                                                    <th>Free Text</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="qc-attach-list-append"></tbody> 
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <div class="gap-2">
                                                                        <label class="btn btn-primary active  mb-2">Browse <input type="file" hidden></label>
                                                                        <br>
                                                                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Display</button>
                                                                        <br>
                                                                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Delete</button>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- tfoot start -->

                                                        <div class="general_data_footer">
                                                            <div class="row">

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-5 col-form-label mt-6" for="val-skill">Assay Potency %</label>
                                                                        <div class="col-lg-7">
                                                                            <input class="form-control" type="text" id="QC_P_DOC_FG_AssayPotency" name="QC_P_DOC_FG_AssayPotency" onfocusout="CalculatePotency();" value="0.000000">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">LOD/Water %</label>
                                                                        <div class="col-lg-8">
                                                                            <input class="form-control" type="text" id="QC_P_DOC_FG_LODWater" name="QC_P_DOC_FG_LODWater" onfocusout="CalculatePotency();" value="0.000000">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-7 col-form-label mt-6" for="val-skill">Assay Calculation Based On</label>
                                                                        <div class="col-lg-5">
                                                                            <select class="form-select" id="QC_P_DOC_FG_AssayCalc" name="QC_P_DOC_FG_AssayCalc"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Potency</label>
                                                                        <div class="col-lg-8">
                                                                            <input class="form-control" type="text" id="QC_P_DOC_FG_Potency" name="QC_P_DOC_FG_Potency" readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Factor</label>
                                                                        <div class="col-lg-8">
                                                                            <input class="form-control" type="text" id="QC_P_DOC_FG_Factor" name="QC_P_DOC_FG_Factor">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Compiled By</label>
                                                                        <div class="col-lg-8">
                                                                            <select class="form-control" type="text" id="QC_P_DOC_FG_CompiledBy" name="QC_P_DOC_FG_CompiledBy"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Checked By</label>
                                                                        <div class="col-lg-8">
                                                                            <select class="form-control" type="text" id="QC_P_DOC_FG_CheckedBy" name="QC_P_DOC_FG_CheckedBy"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis By</label>
                                                                        <div class="col-lg-8">
                                                                            <select class="form-control" type="text" id="QC_P_DOC_FG_AnalysisBy" name="QC_P_DOC_FG_AnalysisBy"></select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">No Of Container</label>
                                                                        <div class="col-lg-8">
                                                                            <input class="form-control" type="text" id="QC_P_DOC_FG_NoOfContainer" name="QC_P_DOC_FG_NoOfContainer">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">From Container</label>
                                                                        <div class="col-lg-8">
                                                                            <input class="form-control" type="text" id="QC_P_DOC_FG_FromContainer" name="QC_P_DOC_FG_FromContainer">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-6 col-form-label mt-6" for="val-skill">Qty Per Container</label>
                                                                        <div class="col-lg-6">
                                                                            <input class="form-control" type="text" id="QC_P_DOC_FG_QtyPerContainer" name="QC_P_DOC_FG_QtyPerContainer">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                                                                        <div class="col-lg-8">
                                                                            <input class="form-control" type="text" id="QC_P_DOC_FG_ToContainer" name="QC_P_DOC_FG_ToContainer">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-3 col-md-6">
                                                                    <div class="form-group row mb-2">
                                                                        <label class="col-lg-4 col-form-label mt-6" for="val-skill">Remarks</label>
                                                                        <div class="col-lg-8">
                                                                            <textarea class="form-control" rows="1" id="QC_P_DOC_FG_Remarks" name="QC_P_DOC_FG_Remarks"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>    
                                                        </div>  

                                                        <!-- -------footer button---- -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="d-flex flex-wrap gap-2">
                                                                        
                                                                    <button type="button" class="btn btn-primary" id="addQcPostDocumentSubmitQCCheckBtn" name="addQcPostDocumentSubmitQCCheckBtn" onclick="return add_qc_post_document();">Update</button>

                                                                    <button type="button" class="btn btn-primary active" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="button" autocomplete="off">Cancel</button>

                                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" autocomplete="off" onclick="TransToUnder();">Inventory Transfer</button>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="btn-group">
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Work Sheet Print</button>
                                                                        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent"><i class="fa fa-angle-down"></i>
                                                                            <span class="visually-hidden"></span>
                                                                        </button>

                                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                                                                            <li><a class="dropdown-item" href="#">Approval Label Print</a></li>
                                                                            <li><a class="dropdown-item" href="#">Rejected Label Print</a></li>
                                                                            <li><a class="dropdown-item" href="#">On-Hold Label Print</a></li>
                                                                            <li><a class="dropdown-item" href="#">Print Certificate</a></li>
                                                                        </ul>

                                                                    </div>
                                                                </div>

                                                            </div>
                                                        <!-- ------footer button end---- -->

                                                        <!-- tfoot end -->


                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
<!-- End Page-content -->
<br>

<?php include 'include/footer.php' ?>

<script type="text/javascript">

    $(".loader123").hide(); // loader default hide script
    $("#footerProcess").hide(); // Afer Doc Selection Process default hide script

    $(document).ready(function(){
        var fromDate=document.getElementById('FromDate').value;
        var toDate=document.getElementById('ToDate').value;
        var DocEntry=document.getElementById('DocEntry').value;

        var dataString ='fromDate='+fromDate+'&toDate='+toDate+'&DocEntry='+DocEntry+'&action=list';
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

    function selectedRecord(DocEntry){

        var dataString ='DocEntry='+DocEntry+'&action=QC_Post_document_QC_Check_Finished_Goods_ajax';
        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_production_common_ajax.php',  
            data: dataString,  
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {  
                $("#footerProcess").show();
                var JSONObjectAll = JSON.parse(result);
                //console.log('selectedRecord=>', JSONObjectAll['qcStatus']);

                var JSONObject=JSONObjectAll['SampleCollDetails'];
                $(`#qc-post-general-data-list-append`).html(JSONObjectAll['general_data']); // Extra Issue Table Tr tag append here
                // $(`#qc-status-list-append`).html(JSONObjectAll['qcStatus']); // External Issue Table Tr tag append here
                $(`#qc-attach-list-append`).html(JSONObjectAll['qcAttach']);
                $(`.testingAppend`).html(JSONObjectAll['qcStatus']); // External Issue Table Tr tag append here
                
                
                $(`#QC_P_DOC_FG_BranchID`).val(JSONObject[0].BPLId);
                $(`#QC_P_DOC_FG_DocEntry`).val(JSONObject[0].DocEntry);
                $(`#QC_P_DOC_FG_WONo`).val(JSONObject[0].WONo);
                $(`#QC_P_DOC_FG_ItemCode`).val(JSONObject[0].ItemCode);
                $(`#QC_P_DOC_FG_ItemName`).val(JSONObject[0].ItemName);
                $(`#QC_P_DOC_FG_GenericName`).val(JSONObject[0].GenericName);
                $(`#QC_P_DOC_FG_LabelCliam`).val(JSONObject[0].LabelClaim);
                $(`#QC_P_DOC_FG_RecievedQty`).val(JSONObject[0].RecQty);
                $(`#QC_P_DOC_FG_MfgBy`).val(JSONObject[0].MfgBy);
                $(`#QC_P_DOC_FG_RefNo`).val(JSONObject[0].RefNo);
                $(`#QC_P_DOC_FG_BatchNo`).val(JSONObject[0].BatchNo);
                $(`#QC_P_DOC_FG_BatchSize`).val(JSONObject[0].BatchQty);
                $(`#QC_P_DOC_FG_PackSize`).val(JSONObject[0].PackSize);
                $(`#QC_P_DOC_FG_SampleType`).val(JSONObject[0].SamType);
                $(`#QC_P_DOC_FG_MaterialType`).val(JSONObject[0].MatType);
                $(`#QC_P_DOC_FG_Branch`).val(JSONObject[0].Branch);
                $(`#QC_P_DOC_FG_ARNo`).val(JSONObject[0].ARNo);
                // $(`#QC_P_DOC_FG_PostingDate`).val(JSONObject[0].PostingDate);
                // $(`#QC_P_DOC_FG_AnalysisDate`).val(JSONObject[0].ADate);
                $(`#QC_P_DOC_FG_QCTesttype`).val(JSONObject[0].QCTType);
                $(`#QC_P_DOC_FG_Stage`).val(JSONObject[0].Stage);
                $(`#QC_P_DOC_FG_ValidUpTo`).val(JSONObject[0].ValidUpto);
                $(`#QC_P_DOC_FG_NoOfContainer`).val(JSONObject[0].NoCont);
                $(`#QC_P_DOC_FG_Factor`).val(JSONObject[0].Factor);
                $(`#QC_P_DOC_FG_FromContainer`).val(JSONObject[0].NoCont1);
                $(`#QC_P_DOC_FG_QtyPerContainer`).val(JSONObject[0].NoCont2);
                $(`#QC_P_DOC_FG_ToContainer`).val(JSONObject[0].NoCont3);
                $(`#QC_P_DOC_FG_Remarks`).val('');
                $(`#QC_P_DOC_FG_ToWhs`).val(JSONObject[0].ToWhse);
                $(`#QC_P_DOC_FG_FromWhs`).val(JSONObject[0].FrmWhse);
                $(`#QC_P_DOC_FG_DocNum`).val(JSONObject[0].DocNum);
                $(`#QC_P_DOC_FG_LocCode`).val(JSONObject[0].LocCode);
                $(`#QC_P_DOC_FG_Loc`).val(JSONObject[0].Loc);
                $(`#QC_P_DOC_FG_WOEntry`).val(JSONObject[0].WOEntry);
                $(`#QC_P_DOC_FG_MfgDate`).val(JSONObject[0].MfgDate);
                $(`#QC_P_DOC_FG_ExpiryDate`).val(JSONObject[0].ExpiryDate);
                $(`#QC_P_DOC_FG_SampleIntimationNo`).val(JSONObject[0].SampleIntimationNo);
                $(`#QC_P_DOC_FG_SampleCollectionNo`).val(JSONObject[0].SampleCollectionNo);
                $(`#QC_P_DOC_FG_SampleQty`).val(JSONObject[0].SampleQty);
                $(`#QC_P_DOC_FG_RetainQty`).val(JSONObject[0].RetainQty);
                $(`#QC_P_DOC_FG_GateENo`).val(JSONObject[0].GateENo);
                $(`#QC_P_DOC_FG_SpecfNo`).val(JSONObject[0].SpecfNo);
                $(`#QC_P_DOC_FG_GRQty`).val(JSONObject[0].GRQty);
                $(`#QC_P_DOC_FG_RelDate`).val(JSONObject[0].RelDate);
                $(`#QC_P_DOC_FG_ReTsDt`).val(JSONObject[0].ReTsDt);
                $(`#QC_P_DOC_FG_RMWQC`).val(JSONObject[0].RMWQC);
                $(`#QC_P_DOC_FG_MakeBy`).val(JSONObject[0].MakeBy);
                // $(`#QC_P_DOC_FG_ReceiptNo`).val(JSONObject[0].RFPNo);
                $(`#QC_P_DOC_FG_WONo`).val(JSONObject[0].WONo);
                $(`#QC_P_DOC_FG_WODocEntry`).val(JSONObject[0].WOEntry);
                $(`#QC_P_DOC_FG_ReceiptNo`).val(JSONObject[0].RFPNo);
                $(`#QC_P_DOC_FG_ReceiptDocEntry`).val(JSONObject[0].RFPEntry);
                SampleTypeDropdown();
                getSeriesDropdown(); // DocName By using API to get dropdown 
                QC_TestTypeDropdown();

                StageDropdown();
                qc_assayCalculationDropdown();
                Compiled_ByDropdown();
                getSeriesDropdownForIT();
                QC_StatusByAnalystDropdown(JSONObjectAll.count);
                getResultOutputDropdown(JSONObjectAll.count);
                getQcStatusDropodwn(1);
                getDoneByDroopdown(1);
                getResultOutputDropdownWithSelectedOption(JSONObjectAll.count);
                GetRowLevelAnalysisByDropdownWithSelectedOption(JSONObjectAll.count);
                // // --------------- bottom popup button hide & show script end here-----------------------
            },complete:function(data){
                $(".loader123").hide();
            }
        });
    }    

    function getResultOutputDropdown(trcount){

        $.ajax({ 
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data:{'action':"ResultOutputDropdown_ajax"},

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                console.log(result);
                for (let i = 0; i < trcount; i++) {
                    $('.dropdownResutl'+i).html(result); // dropdown set using class                            
                }
            },
            complete:function(data){
                $(".loader123").hide();
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

    function Compiled_ByDropdown(){
        var dataString ='action=Compiled_By_dropdown_ajax';
        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_production_common_ajax.php',  
            data: dataString,  
            success: function(result){ 
                $('#QC_P_DOC_FG_CompiledBy').html(result);
                $('#QC_P_DOC_FG_CheckedBy').html(result);
                $('#QC_P_DOC_FG_AnalysisBy').html(result);
            }
       });
    }

    function qc_assayCalculationDropdown(){
        var dataString ='action=qc_FGassay_Calculation_Based_On_ajax';
        $.ajax({  
            type: "POST",  
            url: 'ajax/kri_production_common_ajax.php',  
            data: dataString,  
            success: function(result){ 
                // console.log(result);
                $('#QC_P_DOC_FG_AssayCalc').html(result);
            }
       });
    }

    function QC_TestTypeDropdown(){

        var dataString ='TableId=@SCS_QCPDFG&Alias=PC_QCTType&action=dropdownMaster_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/common-ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);

                $('#QC_P_DOC_FG_QCTesttype').html(JSONObject);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }

    function StageDropdown(){

        var dataString ='action=StageDropdown_ajax';
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
                $('#QC_P_DOC_FG_Stage').html(JSONObject);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
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
                $('#QC_P_DOC_FG_SampleType').html(JSONObject);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }

    function SearchData(){
        var fromDate=document.getElementById('FromDate').value;
        var toDate=document.getElementById('ToDate').value;
        var DocEntry=document.getElementById('DocEntry').value;

        var dataString ='fromDate='+fromDate+'&toDate='+toDate+'&DocEntry='+DocEntry+'&action=list';

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
    }  

    

      function getSeriesDropdown() {
            var TrDate = $('#QC_P_DOC_FG_PostingDate').val();
            var dataString = 'TrDate=' + TrDate + '&ObjectCode=SCS_QCPDFG&action=getSeriesDropdown_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result)
            {
                var SeriesDropdown = JSON.parse(result);
                $('#QC_P_DOC_FG_DocName').html(SeriesDropdown);
                selectedSeries(); // call Selected Series Single data function
            },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        }










    function selectedSeries() {
            var TrDate = $('#QC_P_DOC_FG_PostingDate').val();
            var Series = document.getElementById('QC_P_DOC_FG_DocName').value;
            var dataString = 'TrDate=' + TrDate + '&Series=' + Series + '&ObjectCode=SCS_QCPDFG&action=getSeriesSingleData_ajax';

            // console.log('dataString',dataString)
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    // var JSONObject = JSON.parse(result);




                    var JSONObject = JSON.parse(result);

                    // console.log('JSONObject',JSONObject);
                    var NextNumber = JSONObject[0]['NextNumber'];
                    var Series = JSONObject[0]['Series'];

                    // $('#itP_series').val(Series);
                   // $('#QC_P_DOC_FG_DocName').val(Series);

                    $('#QC_P_DOC_FG_DocNo').val(NextNumber);
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        }











    function CalculatePotency()
    {
        // <!-- -----------  LoD / Water Value Preparing Start Here ------------------------------- -->
            var lod_waterOG=document.getElementById('QC_P_DOC_FG_LODWater').value;

            if((parseFloat(lod_waterOG).toFixed(6))<='0.000000' || lod_waterOG=='' || lod_waterOG==null){
                var lod_water='0.000000';
                $('#QC_P_DOC_FG_LODWater').val(lod_water);
            }else{
                var lod_water=parseFloat(lod_waterOG).toFixed(6);
                $('#QC_P_DOC_FG_LODWater').val(lod_water);
            }
        // <!-- -----------  LoD / Water Value Preparing End Here --------------------------------- -->

        // <!-- -----------  AssayPotency Value Preparing Start Here ------------------------------- -->
            var assayPotencyOG=document.getElementById('QC_P_DOC_FG_AssayPotency').value;

            if((parseFloat(assayPotencyOG).toFixed(6))<='0.000000' || assayPotencyOG=='' || assayPotencyOG==null){
                var assayPotency='0.000000';
                $('#QC_P_DOC_FG_AssayPotency').val(assayPotency);
            }else{
                var assayPotency=parseFloat(assayPotencyOG).toFixed(6);
                $('#QC_P_DOC_FG_AssayPotency').val(assayPotency);
            }
        // <!-- -----------  AssayPotency Value Preparing End Here --------------------------------- -->

        var Potency=((100- parseFloat(lod_water))/100)*parseFloat(assayPotency); // Calculation
        $('#QC_P_DOC_FG_Potency').val(parseFloat(Potency).toFixed(6)); // Set Potency calculated val
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


        function getResultOutputDropdownWithSelectedOption(trcount) {
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: {
                    'action': "getResultOutputDropdownWithSelectedOption_Ajax"
                },

                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(opt) {
                    var JSONObject = JSON.parse(opt);
                    let count = JSONObject.length;

                    for (let i = 0; i < trcount; i++) {
                        const dropdown = document.getElementById('ResultOutputByQCDept' + i);

                        let selectedValue = $('#ResultOutputByQCDept_Old' + i).val();

                        let options = '';
                        for (let j = 0; j < count; j++) {
                            let selected = (selectedValue == JSONObject[j].Code) ? 'selected' : '';
                            options += `<option value="${JSONObject[j].Code}" ${selected}>${JSONObject[j].Name}</option>`;
                        }

                        dropdown.innerHTML = options;
                        OnChangeResultOutputByQCDept(i);
                    }
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }

        function OnChangeResultOutputByQCDept(un_id) {
            var ResultOutputByQCDept = $('#ResultOutputByQCDept' + un_id).val();

            if (ResultOutputByQCDept == 'FAIL') {
                $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #f8a4a4');
                $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
            } else if (ResultOutputByQCDept == 'PASS') {
                $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #c7f3c7');
                $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
            } else {
                $('#ResultOutputByQCDeptTd' + un_id).attr('style', 'background-color: #FFFFFF');
                $('#ResultOutputByQCDept' + un_id).attr('style', 'background-color: #FFFFFF;border:1px solid #FFFFFF !important;');
            }
        }


        function GetRowLevelAnalysisByDropdownWithSelectedOption(trcount) {
            $.ajax({
                type: "POST",
                url: 'ajax/kri_common-ajax.php',
                data: {
                    'action': "GetRowLevelAnalysisByDropdownWithSelectedOption_Ajax"
                },

                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(opt) {
                    var JSONObject = JSON.parse(opt);
                    let count = JSONObject.length;

                    for (let i = 0; i < trcount; i++) {
                        const dropdown = document.getElementById('AnalysisBy' + i);
                        let selectedValue = $('#AnalysisBy_Old' + i).val();
                        let options = `<option value="" >Select</option>`;
                        // $option.='<option value="">Select</option>';
                        for (let j = 0; j < count; j++) {
                            let selected = (selectedValue == JSONObject[j].UserName) ? 'selected' : '';
                            options += `<option value="${JSONObject[j].UserCode}" ${selected}>${JSONObject[j].UserName}</option>`;
                        }

                        dropdown.innerHTML = options;
                    }
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            });
        }

    function setSelectedIndex(s, valsearch)
    {
        for (i = 0; i< s.options.length;i++)
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
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                for (let i = 0; i < trcount; i++) {
                    $('.qc_statusbyab'+i).html(JSONObject); // dropdown set using Class                            
                }
            },
            complete:function(data){
                $(".loader123").hide();
            }
        });
    }

    function TransToUnder()
    {
        var selectedRadio = document.querySelector('input[name="listRado[]"]:checked');

          // Check if a radio button is selected
          if (selectedRadio) {
            // Get the value of the selected radio button
            var selectedValue = selectedRadio.value;
            var qCStsQty = $('#qCStsQty' + selectedValue).val();
            var QCstatus = $('#qc_Status' + selectedValue).val();
            var QCS_LineId = $('#QCS_LineId' + selectedValue).val();
        } else {
            var qCStsQty = 0.000;
            var QCstatus = '';
            var QCS_LineId = '';
        }

        var qcD_DocEntry = document.getElementById('QC_P_DOC_FG_DocEntry').value;
        var BatchNo = document.getElementById('QC_P_DOC_FG_BatchNo').value;
        var ItemCode = document.getElementById('QC_P_DOC_FG_ItemCode').value;
        // var LineNum = document.getElementById('QCS_LineId').value;

        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data:{'DocEntry':qcD_DocEntry,'QC_Status': QCstatus,'action':"qc_post_document_QC_Check_Finished_Goods_pupup_ajax"},
            cache: false,
            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {  
                var JSONObjectAll = JSON.parse(result);
                var JSONObject=JSONObjectAll['DataDetails'];

                $(`#qc-post-data-list-append`).html(JSONObjectAll['options']); // Extra Issue Table Tr tag append here

                $('#IT_QC_supplierCode').val(JSONObject[0].SupplierCode);
                // $('#IT_QC_Series').val(JSONObject[0].Series);
                $('#IT_QC_SupplierName').val(JSONObject[0].SupplierName);
                $('#IT_QC_Branch').val(JSONObject[0].Branch);
                $('#IT_QC_BaseDocType').val('SCS_SINTIFG');
                // $('#IT_QC_PostingDate').val(JSONObject[0].PostingDate);
                // $('#IT_QC_DocumentDate').val('');
                $('#IT_QC_BaseDocNum').val(JSONObject[0].DocNum);

                $('#IT_QC_BranchId').val($('#QC_P_DOC_FG_BranchID').val());

                $('#inventoryTransferFG_i_BQty').val(qCStsQty);
                $('#QCPD_QCS_LineId').val(QCS_LineId);

                ContainerSelection(); // get Container Selection Table List
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }









    function addMore(num) {
            // Formate manula enter Quantity
            var QC_Quantity = $('#qCStsQty_' + num).val();
            $('#qCStsQty_' + num).val(parseFloat(QC_Quantity).toFixed(3));

            var tr_count = $('#tr-count').val();
            var QCS_Qty = AutocalculateQC_Qty();

            // Proceed with AJAX request only if QCS_Qty is not equal to 0.00
            if (parseFloat(QCS_Qty) !== 0.00) {
                var tr_count = $('#tr-count').val();
                $.ajax({
                    type: "POST",
                    url: 'ajax/kri_common-ajax.php',
                    data: ({
                        index: tr_count,
                        action: 'add_qc_status_input_more'
                    }),
                    success: function(result) {
                        $('#add-more_' + tr_count).after(result);
                        tr_count++;
                        $('#tr-count').val(tr_count);
                        $('#qCStsQty_' + tr_count).val(QCS_Qty);

                        getQcStatusDropodwn(tr_count);
                        getDoneByDroopdown(tr_count);
                    }
                });
            }
        }

 
    function ContainerSelection(){

        var DocEntry=document.getElementById('QC_P_DOC_FG_DocEntry').value;
        var BatchNo=document.getElementById('QC_P_DOC_FG_BatchNo').value;
        var ItemCode=document.getElementById('QC_P_DOC_FG_ItemCode').value;
        var FromWhs=document.getElementById('QC_P_DOC_FG_FromWhs').value;
        var ToWhse=document.getElementById('QC_P_DOC_FG_ToWhs').value;
      
        var dataString ='ItemCode='+ItemCode+'&WareHouse='+FromWhs+'&BatchNo='+BatchNo+'&DocEntry='+DocEntry+'&action=getInventoryFinishedGoodsQccotainerSelection_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                var JSONObject = JSON.parse(result);
                $('#ContainerSelectionItemAppend').html(JSONObject);
            },
            complete:function(data){
                $(".loader123").hide();
            }
        }); 
    }

    function getSelectedContener(un_id){
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionItemAppend");
 
        //Reference all the CheckBoxes in Table.
        var chks = tblFruits.getElementsByTagName("INPUT");
 
        // Loop and push the checked CheckBox value in Array.
        for (var i = 0; i < chks.length; i++) {
            if (chks[i].checked) {
                selected.push(chks[i].value);
            }
        }
            // console.log('selected=>', selected);

        // <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
            const array = selected;
            let sum = 0;

            for (let i = 0; i < array.length; i++) {
                sum += parseFloat(array[i]);

            }
            // console.log('sum=>', sum);
            document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->

        // <!-- --------------------- when user select checkbox update flag start here -------------- -->
            var usercheckListVal=document.getElementById('usercheckList'+un_id).value;

            if(usercheckListVal=='0'){
                $(`#usercheckList`+un_id).val('1');
            }else{
                $(`#usercheckList`+un_id).val('0');
            }
        // <!-- --------------------- when user select checkbox update flag End here ---------------- -->
    }

    function EnterQtyValidation_GI(un_id) {
        var BatchQty=document.getElementById('itp_BatchQty'+un_id).value;
        var SelectedQty=document.getElementById('SelectedQty'+un_id).value;

        if(SelectedQty!=''){

            if(parseFloat(SelectedQty)<=parseFloat(BatchQty)){
            // if(SelectedQty<=BatchQty){
                $('#SelectedQty'+un_id).val(parseFloat(SelectedQty).toFixed(6));
                $('#itp_CS'+un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value
            }else{
                $('#SelectedQty'+un_id).val(BatchQty); // if user enter grater than val
                $('#itp_CS'+un_id).val(parseFloat(BatchQty).toFixed(6)); 
                swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
            }

        }else{
            $('#SelectedQty'+un_id).val(BatchQty); // if user enter blank val
            $('#itp_CS'+un_id).val(parseFloat(BatchQty).toFixed(6)); 
            swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error");
        }

        getSelectedContenerGI_Manual(un_id); // if user change selected Qty value after selection       
    }

    function getSelectedContenerGI_Manual(un_id){
        //Create an Array.
        var selected = new Array();
 
        //Reference the Table.
        var tblFruits = document.getElementById("ContainerSelectionItemAppend");
 
        //Reference all the CheckBoxes in Table.
        var chks = tblFruits.getElementsByTagName("INPUT");
 
        // Loop and push the checked CheckBox value in Array.
        for (var i = 0; i < chks.length; i++) {
            if (chks[i].checked) {
                selected.push(chks[i].value);
            }
        }
            // console.log('selected=>', selected);

        // <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
            const array = selected;
            let sum = 0;

            for (let i = 0; i < array.length; i++) {
                sum += parseFloat(array[i]);

            }
            // console.log('sum=>', sum);
            document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
        // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
    }

    function add_qc_post_document(){

        var formData = new FormData($('#QcDpcumentFormfinisheGoods')[0]);  // Form Id
        formData.append("addQcPostDocumentSubmitQCCheckFinishesGoodaBtn",'addQcPostDocumentSubmitQCCheckFinishesGoodaBtn');  // Button Id
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
            success: function(result)
            {                
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

    function getSeriesDropdownForIT() {
            var TrDate = $('#IT_QC_PostingDate').val();
            var dataString = 'TrDate=' + TrDate + '&ObjectCode=67&action=getSeriesDropdown_ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    var SeriesDropdown = JSON.parse(result);

                console.log('SeriesDropdown',SeriesDropdown);
                    $('#IT_QC_Series').html(SeriesDropdown);

                    selectedSeriesForIT(); // call Selected Series Single data fun
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        }

        function selectedSeriesForIT() {
            var TrDate = $('#IT_QC_PostingDate').val();
            var Series = document.getElementById('IT_QC_Series').value;
            var dataString = 'TrDate=' + TrDate + '&Series=' + Series + '&ObjectCode=67&action=getSeriesSingleData_ajax';

            // console.log('dataString',dataString)
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,

                beforeSend: function() {
                    // Show image container
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);




                    var JSONObject = JSON.parse(result);

                    var NextNumber = JSONObject[0]['NextNumber'];
                    var Series = JSONObject[0]['Series'];

                    // $('#itP_series').val(Series);
                    $('#IT_QC_Series_DocNo').val(NextNumber);

                    // $('#IT_QC_BranchId').val(Series);
                },
                complete: function(data) {
                    // Hide image container
                    $(".loader123").hide();
                }
            });
        }    

    function SubmitInventoryTransferQC_ckeck(){

        var selectedQtySum=document.getElementById('cs_selectedQtySum').value; // final Qty sum
        var PostingDate=document.getElementById('IT_QC_PostingDate').value;
        var DocDate=document.getElementById('IT_QC_PostingDate').value;
        var ItemCode=document.getElementById('inventoryTransferFG_i_ItemCode').value;
        var item_BQty=parseFloat(document.getElementById('inventoryTransferFG_i_BQty').value).toFixed(6);  // item available Qty
        var fromWhs=document.getElementById('inventoryTransferFG_i_FromWhs').value;
        var ToWhs=document.getElementById('inventoryTransferFG_i_ToWhs').value;


        if(selectedQtySum==item_BQty){ // Container selection Qty validation

            if(ToWhs!=''){ // Item level To Warehouse validation

                if(PostingDate!=''){ // Posting Date validation

                    if(DocDate!=''){ // Document Date validation

                    // <!-- ---------------- form submit process start here ----------------- -->
                        var formData = new FormData($('#inventrotyTransferQC_ckecked')[0]); 
                        formData.append("btnInventoryTransfeckQCCheckFinishedGoods",'btnInventoryTransfeckQCCheckFinishedGoods'); 

                        var error = true;

                        if(error)
                        {
                            $.ajax({
                                url: 'ajax/kri_production_common_ajax.php',
                                type: "POST",
                                data:formData,
                                processData: false,
                                contentType: false,
                                beforeSend: function(){
                                    $(".loader123").show();
                                },
                                success: function(result)
                                {
                                
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
                                                location.replace(window.location.href); //ok btn... cuurent URL called
                                            }else{
                                                location.replace(window.location.href); // cancel btn... cuurent URL called
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
                    // <!-- ---------------- form submit process end here ------------------- -->
                    }else{
                        swal("Oops!", "Please Select A Document Date.", "error");
                    }

                }else{
                    swal("Oops!", "Please Select A Posting Date.", "error");
                }
            }else{
                swal("Oops!", "To Warehouse Mandatory.", "error");
            }

        }else{
            swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
        }
    }
    
    
    function AutocalculateQC_Qty() {
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

            var BatchQty = $('#QC_P_DOC_FG_BatchSize').val();
            var QCS_Qty = parseFloat(parseFloat(BatchQty) - parseFloat(sum)).toFixed(3);
            return QCS_Qty;
            // <!-- calculate Quantity for QC status tab end -------------------------------- -->
        }







    function SelectionOfQC_Status(un_id) {
            var tr_count = parseInt($('#tr-count').val());
            //console.log('tr_count',tr_count);
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
                $('#qCStsQty_' + un_id).val($('#qc_Check_Batch_Size').val());
            }
        }





  
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

  </script>