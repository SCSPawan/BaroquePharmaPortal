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
    $tdata['FromDate'] = date('Ymd', strtotime($_POST['fromDate']));
    $tdata['ToDate'] = date('Ymd', strtotime($_POST['toDate']));
    $tdata['DocEntry'] = trim(addslashes(strip_tags($_POST['DocEntry'])));

    $getAllData = $obj->getSimpleIntimation($INPROCESSQCPOSTDOCUMENTDETAILS, $tdata);
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

    $option .= '<table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
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

    if (count($getAllData) != '0') {
        for ($i = $r_start; $i < $r_end; $i++) {
            if (!empty($getAllData[$i]->RFPNo)) {   //  this condition save to extra blank loop
                $SrNo = $i + 1;
                // --------------- Convert String code Start Here ---------------------------
                if (empty($getAllData[$i]->MfgDate)) {
                    $MfgDate = '';
                } else {
                    $MfgDate = str_replace('/', '-', $getAllData[$i]->MfgDate);
                    // All (/) replace to (-)
                    $MfgDate = date("d-m-Y", strtotime($MfgDate));
                }

                if (empty($getAllData[$i]->ExpiryDate)) {
                    $ExpiryDate = '';
                } else {
                    $ExpiryDate = str_replace('/', '-', $getAllData[$i]->ExpiryDate);
                    // All (/) replace to (-)
                    $ExpiryDate = date("d-m-Y", strtotime($ExpiryDate));
                }
                // --------------- Convert String code End Here-- ---------------------------

                $option .= '
                            <tr>
                                <td class="desabled">' . $SrNo . '</td>
                                <td style="text-align: center;">
                                    <input type="radio" id="list' . $getAllData[$i]->DocEntry . '" name="listRado" value="' . $getAllData[$i]->DocEntry . '" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedRecord(' . $getAllData[$i]->DocEntry . ')">
                                </td>
                                <td class="desabled">' . $getAllData[$i]->DocEntry . '</td>
                                <td class="desabled">' . $getAllData[$i]->WONo . '</td>
                                <td class="desabled">' . $getAllData[$i]->RFPEntry . '</td>
                                <td class="desabled">' . $getAllData[$i]->MatType . '</td>
                                <td class="desabled">' . $getAllData[$i]->ItemCode . '</td>
                                <td class="desabled">' . $getAllData[$i]->ItemName . '</td>
                                <td class="desabled">' . $getAllData[$i]->Unit . '</td>
                                <td class="desabled">' . $getAllData[$i]->WOQty . '</td>
                                <td class="desabled">' . $getAllData[$i]->BatchNo . '</td>
                                <td class="desabled">' . $getAllData[$i]->BatchQty . '</td>
                                <td class="desabled">' . $MfgDate . '</td>
                                <td class="desabled">' . $ExpiryDate . '</td>
                                <td class="desabled">' . $getAllData[$i]->Branch . '</td>
                            </tr>';
            }
        }
    } else {
        $option .= '<tr><td colspan="16" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
    }
    $option .= '</tbody> 
    </table>';

    $option .= $pagination;
    echo $option;
    exit(0);
}
?>
<?php include 'include/header.php' ?>
<?php include 'models/qc_process/qc_post_doc_in_process_model.php' ?>
<style type="text/css">
    body[data-layout=horizontal] .page-content {padding: 20px 0 0 0;padding: 40px 0 60px 0;}
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
                            <h4 class="mb-0"></h4>QC Post document (QC Check) - In Process
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                    <li class="breadcrumb-item active">QC Post document (QC Check) - In Process</li>
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
                            <h4 class="card-title mb-0">QC Post document (QC Check) - In Process</h4>
                        </div><!-- end card header -->

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
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->

            <br>

            <div class="row2 mt-3" id="footerProcess">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- form start -->
                            <form role="form" class="form-horizontal" id="QcDpcumentFormInProcess" method="post">
                                <!-- ------------ hiden field define here start ----------------------------- -->
                                    <input type="hidden" id="qc_Check_LineNum" name="qc_Check_LineNum">
                                    <input type="hidden" id="qc_Check_DocEntry" name="qc_Check_DocEntry">
                                    <input type="hidden" id="U_PC_BPLId" name="U_PC_BPLId">
                                    <input type="hidden" id="qc_Check_LocCode" name="qc_Check_LocCode">
                                    <input type="hidden" id="qc_Check_GateENo" name="qc_Check_GateENo">
                                    <input type="hidden" id="qc_Check_SpecfNo" name="qc_Check_SpecfNo">
                                    <input type="hidden" id="qc_Check_GRQty" name="qc_Check_GRQty">
                                    <input type="hidden" id="qc_Check_RelDate" name="qc_Check_RelDate">
                                    <input type="hidden" id="qc_Check_ReTsDt" name="qc_Check_ReTsDt">
                                    <input type="hidden" id="qc_Check_RMWQC" name="qc_Check_RMWQC">
                                    <input type="hidden" id="qc_Check_WOEntry" name="qc_Check_WOEntry">
                                    <input type="hidden" id="itP_FromWhs" name="itP_FromWhs">
                                    <input type="hidden" id="itP_ToWhs" name="itP_ToWhs">
                                    <input type="hidden" id="itP_series" name="itP_series">
                                <!-- ------------ hiden field define here end ------------------------------- -->

                                <div class="row">
                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" type="text" id="qc_Check_WONo" name="qc_Check_WONo" readonly>
                                            </div>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" type="text" id="qc_Check_WODocEntry" name="qc_Check_WODocEntry" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="qc_Check_Loc" name="qc_Check_Loc" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make By</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" type="text" id="qc_Check_MakeBy" name="qc_Check_MakeBy" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Receipt No</label>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" type="text" id="qc_Check_ReceiptNo" name="qc_Check_ReceiptNo" readonly>
                                            </div>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" type="text" id="qc_Check_ReceiptDocEntry" name="qc_Check_ReceiptDocEntry" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-7 col-form-label mt-6" for="val-skill">Release Material Without QC</label>
                                            <div class="col-lg-5">
                                                <select class="form-select" id="QC_CK_D_RelMaterialWithoutQC" name="QC_CK_D_RelMaterialWithoutQC">
                                                    <option value="Yes">Yes</option>
                                                    <option value="No" Selected>No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_Item_Code" name="qc_Check_Item_Code">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_Item_Name" name="qc_Check_Item_Name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Generic Name</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_Generic_Name" name="qc_Check_Generic_Name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Cliam</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_Label_Cliam" name="qc_Check_Label_Cliam">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_SampleQty" name="qc_Check_SampleQty">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Recieved Qty</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_Recieved_Qty" name="qc_Check_Recieved_Qty">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg By</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_Mfg_By" name="qc_Check_Mfg_By">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Intimation No</label>
                                            <div class="col-lg-6">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_SampleIntimationNo" name="qc_Check_SampleIntimationNo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-6 col-form-label mt-6" for="val-skill">Sample Collection No</label>
                                            <div class="col-lg-6">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_SampleCollectionNo" name="qc_Check_SampleCollectionNo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ref No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_Ref_No" name="qc_Check_Ref_No">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_Batch_No" name="qc_Check_Batch_No">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Size</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_Batch_Size" name="qc_Check_Batch_Size">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Pack Size</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_Pack_Size" name="qc_Check_Pack_Size">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                            <div class="col-lg-8">
                                                <select class="form-select" id="qc_Check_Sample_Type" name="qc_Check_Sample_Type">
                                                    <!-- <option>Regular</option> -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_Material_Type" name="qc_Check_Material_Type">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_Branch" name="qc_Check_Branch">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No.</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qc_Check_ARNo" name="qc_Check_ARNo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                            <div class="col-lg-6">
                                                <select class="form-select" id="qc_Check_DocNo" name="qc_Check_DocNo" onchange="selectedSeries()"></select>
                                            </div>

                                            <div class="col-lg-2">
                                                <input class="form-control desabled" type="text" id="NextNumber" name="NextNumber" readonly="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="text" id="qc_Check_MfgDate" name="qc_Check_MfgDate" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Exp. Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="text" id="qc_Check_ExpiryDate" name="qc_Check_ExpiryDate" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="date" id="qc_Check_PostingDate" name="qc_Check_PostingDate" value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="date" id="qc_Check_AnalysisDate" name="qc_Check_AnalysisDate" value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">QC Test type</label>
                                            <div class="col-lg-8">
                                                <select class="form-control " id="qc_Check_QCTesttype" name="qc_Check_QCTesttype"></select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stage</label>
                                            <div class="col-lg-8">
                                                <select class="form-control " type="text" id="qc_Check_Stage" name="qc_Check_Stage"></select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Valid Up To</label>
                                            <div class="col-lg-8">
                                                <input class="form-control " type="Date" id="qc_Check_ValidUpTo" name="qc_Check_ValidUpTo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br><br>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <!-- Nav tabs -->
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-bs-toggle="tab" href="#general_data3" role="tab">
                                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                            <span class="d-none d-sm-block">General Data</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-bs-toggle="tab" href="#qc_status3" role="tab">
                                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                            <span class="d-none d-sm-block">QC Status</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-bs-toggle="tab" href="#attatchment3" role="tab">
                                                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                            <span class="d-none d-sm-block">Attatchment</span>
                                                        </a>
                                                    </li>
                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content p-3 text-muted">

                                                    <div class="tab-pane active" id="general_data3" role="tabpanel">
                                                        <div class="table-responsive qc_list_table table_item_padding" id="list2">
                                                            <table id="tblItemRecord" class="table sample-table-responsive table-bordered">
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
                                                                <tbody id="qc-post-general-data-list-append_"></tbody>

                                                            </table>
                                                        </div>
                                                        <!--end table-->
                                                    </div> <!-- tab_pane samp details end -->

                                                    <div class="tab-pane" id="qc_status3" role="tabpanel">
                                                        <div class="table-responsive" id="list">
                                                            <table id="tblItemRecord" class="table sample-table-responsive table-bordered">
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
                                                                <tbody id="qc-status-list-append_"></tbody>
                                                            </table>
                                                        </div><!--table responsive end-->
                                                    </div> <!-- tab_pane qc status end -->

                                                    <div class="tab-pane" id="attatchment3" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="table-responsive" id="list">
                                                                    <table id="tblItemRecord" class="table table-bordered">
                                                                        <thead class="fixedHeader1">
                                                                            <tr>
                                                                                <th>Sr. No</th>
                                                                                <th>Target Path</th>
                                                                                <th>File Name</th>
                                                                                <th>Attatchment Date</th>
                                                                                <th>Free Text</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="qc-attach-list-append_"></tbody>
                                                                    </table>
                                                                </div><!--table responsive end-->
                                                            </div><!--col closed-->

                                                            <div class="col-md-2">
                                                                <div class="gap-2">
                                                                    <!-- Toggle States Button -->
                                                                    <label class="btn btn-primary active  mb-2">
                                                                        Browse <input type="file" hidden>
                                                                    </label>
                                                                    <br>
                                                                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Display</button>
                                                                    <br>
                                                                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="button" autocomplete="off">Delete</button>
                                                                </div>
                                                            </div><!--col closed-->
                                                        </div><!--row closed-->
                                                    </div> <!-- tab_pane attatchment end -->

                                                    <!-- tfoot start -->

                                                    <div class="general_data_footer">
                                                        <div class="row">
                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">Assay Potency %</label>
                                                                    <div class="col-lg-7">
                                                                        <input class="form-control" type="text" id="AssayPotency_xyz" name="AssayPotency_xyz" onfocusout="CalculatePotency();" value="0.000000">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">LOD/Water %</label>
                                                                    <div class="col-lg-8">
                                                                        <input class="form-control" type="text" id="LoD_Water_xyz" name="LoD_Water_xyz" onfocusout="CalculatePotency();" value="0.000000">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-7 col-form-label mt-6" for="val-skill">Assay Calculation Based On</label>
                                                                    <div class="col-lg-5">
                                                                        <select class="form-select assayapp" id="assay-append" name="assay_append"></select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Potency</label>
                                                                    <div class="col-lg-8">
                                                                        <input class="form-control" type="text" id="potency_xyz" name="potency_xyz" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Factor</label>
                                                                    <div class="col-lg-8">
                                                                        <input class="form-control" type="text" id="Factor" name="Factor">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Compiled By</label>
                                                                    <div class="col-lg-8">
                                                                        <select class="form-control" type="text" id="qc_Check_Compiled_By" name="qc_Check_Compiled_By"></select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Checked By</label>
                                                                    <div class="col-lg-8">
                                                                        <select class="form-control" type="text" id="CheckedBy" name="CheckedBy"></select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis By</label>
                                                                    <div class="col-lg-8">
                                                                        <select class="form-control" type="text" id="CheckedBy" name="CheckedBy"></select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Approved By By</label>
                                                                    <div class="col-lg-8">
                                                                        <select class="form-control" type="text" id="qc_Check_ApprovedBy" name="qc_Check_ApprovedBy"></select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">No Of Container</label>
                                                                    <div class="col-lg-8">
                                                                        <input class="form-control" type="text" id="NoOfContainer" name="NoOfContainer">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">From Container</label>
                                                                    <div class="col-lg-7">
                                                                        <input class="form-control" type="text" id="FromContainer" name="FromContainer">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">To Container</label>
                                                                    <div class="col-lg-8">
                                                                        <input class="form-control" type="text" id="ToContainer" name="ToContainer" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Remarks</label>
                                                                    <div class="col-lg-8">
                                                                        <textarea class="form-control" rows="1" id="Remarks" name="Remarks"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> <!--general data footer end-->

                                                    <!-- -------footer button---- -->
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="d-flex flex-wrap gap-2">
                                                                    <!-- Toggle States Button -->
                                                                    <button type="button" class="btn btn-primary" id="addQcPostDocumentSubmitQCCheckBtn" name="addQcPostDocumentSubmitQCCheckBtn" onclick="return add_qc_post_document();">Update</button>

                                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" autocomplete="off" onclick="TransToUnder();">Inventory Transfer</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Label & COA Print</button>
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
                                                        <!--row end-->
                                                    <!-- ------footer button end---- -->
                                                </div> <!-- tab content end -->
                                            </div>
                                        </div><!-- end card-body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                            </form>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div> <!-- container-fluid -->
    </div>
</div>
    <!-- End Page-content -->
    <br>

    <?php include 'include/footer.php' ?>

    <script type="text/javascript">
        // <!-- -------------- Direct called function diclear Start Here --------------------------------
            $(".loader123").hide(); // loader default hide script
            $("#footerProcess").hide(); // Afer Doc Selection Process default hide script
        // <!-- -------------- Direct called function diclear End Here ----------------------------------

        $(document).ready(function() {
            var fromDate = document.getElementById('FromDate').value;
            var toDate = document.getElementById('ToDate').value;
            var DocEntry = document.getElementById('DocEntry').value;

            var dataString = 'fromDate=' + fromDate + '&toDate=' + toDate + '&DocEntry=' + DocEntry + '&action=list';
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
            })
        });

        function change_page(page_id){ 
            var fromDate = document.getElementById('FromDate').value;
            var toDate = document.getElementById('ToDate').value;
            var DocEntry = document.getElementById('DocEntry').value;

            var dataString = 'fromDate=' + fromDate + '&toDate=' + toDate + '&DocEntry=' + DocEntry +'&page_id='+page_id+'&action=list';
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
            })
        }

        function SearchData() {
            var fromDate = document.getElementById('FromDate').value;
            var toDate = document.getElementById('ToDate').value;
            var DocEntry = document.getElementById('DocEntry').value;

            var dataString = 'fromDate=' + fromDate + '&toDate=' + toDate + '&DocEntry=' + DocEntry +'&action=list';
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
            })
        }

        function selectedRecord(DocEntry) {
            var dataString = 'DocEntry=' + DocEntry + '&action=QC_Post_document_QC_Check_In_Process';
            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: dataString,
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    $("#footerProcess").show();

                    var JSONObjectAll = JSON.parse(result);
                    var JSONObject = JSONObjectAll['SampleCollDetails']; // sample collection details var

                    $(`#qc-post-general-data-list-append_`).html(JSONObjectAll['general_data']); // Extra Issue Table Tr tag append here
                    $(`#qc-status-list-append_`).html(JSONObjectAll['qcStatus']); // External Issue Table Tr tag append here
                    $(`#qc-attach-list-append_`).html(JSONObjectAll['qcAttach']);

                    $(`#qc_Check_WONo`).val(JSONObject[0].WONo);
                    $(`#qc_Check_Item_Code`).val(JSONObject[0].ItemCode);
                    $(`#qc_Check_Item_Name`).val(JSONObject[0].ItemName);
                    $(`#qc_Check_Generic_Name`).val(JSONObject[0].GenericName);
                    $(`#qc_Check_Label_Cliam`).val(JSONObject[0].LabelClaim);
                    $(`#qc_Check_Recieved_Qty`).val(JSONObject[0].RecQty);
                    $(`#qc_Check_Mfg_By`).val(JSONObject[0].MfgBy);
                    $(`#qc_Check_Ref_No`).val(JSONObject[0].RefNo);
                    $(`#qc_Check_Batch_No`).val(JSONObject[0].BatchNo);
                    $(`#qc_Check_Batch_Size`).val(JSONObject[0].BatchQty);
                    $(`#qc_Check_Pack_Size`).val(JSONObject[0].PackSize);
                    $(`#qc_Check_Sample_Type`).val(JSONObject[0].SamType);
                    $(`#qc_Check_Material_Type`).val(JSONObject[0].MatType);
                    $(`#qc_Check_Branch`).val(JSONObject[0].Branch);
                    $(`#qc_Check_ARNo`).val(JSONObject[0].ARNo);
                    $(`#qc_Check_QCTesttype`).val(JSONObject[0].QCTType);
                    $(`#qc_Check_Stage`).val(JSONObject[0].Stage);
                    $(`#qc_Check_ValidUpTo`).val(JSONObject[0].ValidUpto);
                    $(`#qc_Check_Compiled_By`).val(JSONObject[0].CompBy);
                    $(`#CheckedBy`).val(JSONObject[0].CheckBy);
                    $(`#qc_Check_AnalysisBy`).val(JSONObject[0].AnylBy);
                    $(`#qc_Check_ApprovedBy`).val(JSONObject[0].AnylBy);
                    $(`#NoOfContainer`).val(JSONObject[0].NoCont);
                    $(`#Factor`).val(JSONObject[0].Factor);
                    $(`#qc_Check_DocEntry`).val(JSONObject[0].DocEntry);
                    $(`#itP_FromWhs`).val(JSONObject[0].FromWhse);
                    $(`#itP_ToWhs`).val(JSONObject[0].ToWhse);
                    $(`#U_PC_BPLId`).val(JSONObject[0].BPLId);
                    $(`#qc_Check_LineNum`).val(0);
                    $(`#qc_Check_LocCode`).val(JSONObject[0].LocCode);
                    $(`#qc_Check_MfgDate`).val(DateFormatingDMY(JSONObject[0].MfgDate));
                    $(`#qc_Check_ExpiryDate`).val(DateFormatingDMY(JSONObject[0].ExpiryDate));
                    $(`#qc_Check_SampleIntimationNo`).val(JSONObject[0].SampleIntimationNo);
                    $(`#qc_Check_SampleCollectionNo`).val(JSONObject[0].SampleCollectionNo);
                    $(`#qc_Check_SampleQty`).val(JSONObject[0].SampleQty);
                    $(`#qc_Check_GateENo`).val(JSONObject[0].GateENo);
                    $(`#qc_Check_SpecfNo`).val(JSONObject[0].SpecfNo);
                    $(`#qc_Check_GRQty`).val(JSONObject[0].GRQty);
                    $(`#qc_Check_RelDate`).val(JSONObject[0].RelDate);
                    $(`#qc_Check_ReTsDt`).val(JSONObject[0].ReTsDt);
                    $(`#qc_Check_MakeBy`).val(JSONObject[0].MakeBy);
                    $(`#qc_Check_RMWQC`).val(JSONObject[0].RMWQC);
                    $(`#qc_Check_Loc`).val(JSONObject[0].Location);
                    $(`#qc_Check_WODocEntry`).val(JSONObject[0].WOEntry);
                    $(`#qc_Check_ReceiptNo`).val(JSONObject[0].RFPNo);
                    $(`#qc_Check_ReceiptDocEntry`).val(JSONObject[0].RFPEntry);
                    $(`#FromContainer`).val(JSONObject[0].NoCont1);
                    $(`#ToContainer`).val(JSONObject[0].NoCont2);

                    GetRowLevelAnalysisByDropdown(JSONObjectAll.count);
                    getResultOutputDropdown(JSONObjectAll.count);
                    getQcStatusDropodwn(1);
                    getDoneByDroopdown(1);
                    getstageDropdown();
                    getResultOutputDropdownWithSelectedOption(JSONObjectAll.count);
                    QC_StatusByAnalystDropdownWithSelectedOption(JSONObjectAll.count);
                    GetRowLevelAnalysisByDropdownWithSelectedOption(JSONObjectAll.count);
                    getSeriesDropdownForIT();
                    getSeriesDropdown(); // DocName By using API to get dropdown 
                },
                complete: function(data) {
                    Compiled_ByDropdown();
                }
            })
        }

        function DateFormatingDMY(DateOG){
            if(DateOG!=''){
                let [day, month, year] = DateOG.split(" ")[0].split("-");
                let Date = `${day}-${month}-${year}`;
                return Date;
            }
        }

        function Compiled_ByDropdown() {
            var dataString = 'action=Compiled_By_dropdown_ajax';
            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: dataString,
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    $('#qc_Check_Compiled_By').html(result);
                    $('#CheckedBy').html(result);
                    $('#qc_Check_AnalysisBy').html(result);
                },
                complete: function(data) {
                    SampleTypeDropdown();
                }
            })
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
                    $('#qc_Check_Sample_Type').html(JSONObject);
                },
                complete: function(data) {
                    QC_TestTypeDropdown();
                }
            })
        }

        function QC_StatusByAnalystDropdownWithSelectedOption(trcount) {
            var dataString = 'TableId=@SCS_QCPD1&Alias=QCStatus&action=QC_StatusByAnalystDropdownWithSelectedOption_Ajax';

            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: dataString,
                cache: false,
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(opt) {
                    var JSONObject = JSON.parse(opt);
                    let count = JSONObject.length;

                    for (let i = 0; i < trcount; i++) {
                        const dropdown = document.getElementById('qC_status_by_analyst' + i);

                        let selectedValue = $('#qC_status_by_analyst_Old' + i).val();

                        let options = '';
                        for (let j = 0; j < count; j++) {
                            let selected = (selectedValue == JSONObject[j].FldValue) ? 'selected' : '';
                            options += `<option value="${JSONObject[j].FldValue}" ${selected}>${JSONObject[j].Description}</option>`;
                        }

                        dropdown.innerHTML = options;
                        SelectedQCStatus(i);
                    }
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            })
        }

        function getResultOutputDropdownWithSelectedOption(trcount) {
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: {'action': "getResultOutputDropdownWithSelectedOption_Ajax"},
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
            })
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
                data: {'action': "GetRowLevelAnalysisByDropdownWithSelectedOption_Ajax"},
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
            })
        }

        function QC_TestTypeDropdown() {
            var dataString = 'TableId=@SCS_QCINPROC&Alias=PC_QCTType&action=dropdownMaster_ajax';

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

                    $('#qc_Check_QCTesttype').html(JSONObject);
                },
                complete: function(data) {
                    getSeriesDropdown();
                }
            })
        }

        function getSeriesDropdownForIT() {
            var TrDate = $('#qc_check_posting_date').val();
            var dataString = 'TrDate=' + TrDate + '&ObjectCode=67&action=getSeriesDropdown_ajax';

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

                    $('#qcD_Series').html(SeriesDropdown);
                    selectedSeriesForIT(); // call Selected Series Single data fun
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            })
        }

        function selectedSeriesForIT() {
            var TrDate = $('#qc_check_posting_date').val();
            var Series = document.getElementById('qcD_Series').value;
            var dataString = 'TrDate=' + TrDate + '&Series=' + Series + '&ObjectCode=67&action=getSeriesSingleData_ajax';

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

                    var NextNumber = JSONObject[0]['NextNumber'];
                    var Series = JSONObject[0]['Series'];

                    $('#qc_check_seriesDocNum').val(NextNumber);
                    $('#qc_check_SeriesId').val(Series);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            })
        }

        function getSeriesDropdown() {
            var TrDate = $('#qc_Check_PostingDate').val();
            var dataString = 'TrDate=' + TrDate + '&ObjectCode=SCS_QCINPROC&action=getSeriesDropdown_ajax';

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
                    $('#qc_Check_DocNo').html(SeriesDropdown);

                    selectedSeries(); // call Selected Series Single data fun
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            })
        }

        function selectedSeries() {
            var TrDate = $('#qc_Check_PostingDate').val();
            var Series = document.getElementById('qc_Check_DocNo').value;
            var dataString = 'TrDate=' + TrDate + '&Series=' + Series + '&ObjectCode=SCS_QCINPROC&action=getSeriesSingleData_ajax';

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

                    var NextNumber = JSONObject[0]['NextNumber'];
                    var Series = JSONObject[0]['Series'];

                    $('#itP_series').val(Series);
                    $('#qc_Check_DocNo').val(Series);
                    $('#NextNumber').val(NextNumber);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            })
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
                    $('#qc_Check_Stage').html(JSONObject);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            })
        }

        function getResultOutputDropdown(trcount) {
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: {'action': "ResultOutputDropdown_ajax"},
                success: function(result) {
                    for (let i = 0; i < trcount; i++) {
                        $('#ResultOutputByQCDept' + i).html(result);
                    }
                }
            })
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

        function GetRowLevelAnalysisByDropdown(trcount) {
            $.ajax({
                type: "POST",
                url: 'ajax/common-ajax.php',
                data: {'action': "GetRowLevelAnalysisByDropdown_Ajax"},
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var dropdown = JSON.parse(result);

                    for (let i = 0; i < trcount; i++) {
                        $('#AnalysisBy' + i).html(dropdown); // dropdown set using Id
                    }

                    $('#routStage_CheckedBy').html(dropdown); // Bottom dropdown set using Id
                    $('#routStage_AnalysisBy').html(dropdown); // Bottom dropdown set using Id
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            })
        }

        $(document).ready(function() {
            var dataString = 'action=qc_assay_Calculation_Based_On_ajax';
            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: dataString,
                success: function(result) {
                    $('.assayapp').html(result);
                }
            })
        });

        function CalculatePotency() {
            // <!-- -----------  LoD / Water Value Preparing Start Here ------------------------------- -->
                var lod_waterOG = document.getElementById('LoD_Water_xyz').value;

                if ((parseFloat(lod_waterOG).toFixed(6)) <= '0.000000' || lod_waterOG == '' || lod_waterOG == null) {
                    var lod_water = '0.000000';
                    $('#LoD_Water_xyz').val(lod_water);
                } else {
                    var lod_water = parseFloat(lod_waterOG).toFixed(6);
                    $('#LoD_Water_xyz').val(lod_water);
                }
            // <!-- -----------  LoD / Water Value Preparing End Here --------------------------------- -->

            // <!-- -----------  AssayPotency Value Preparing Start Here ------------------------------- -->
                var assayPotencyOG = document.getElementById('AssayPotency_xyz').value;

                if ((parseFloat(assayPotencyOG).toFixed(6)) <= '0.000000' || assayPotencyOG == '' || assayPotencyOG == null) {
                    var assayPotency = '0.000000';
                    $('#AssayPotency_xyz').val(assayPotency);
                } else {
                    var assayPotency = parseFloat(assayPotencyOG).toFixed(6);
                    $('#AssayPotency_xyz').val(assayPotency);
                }
            // <!-- -----------  AssayPotency Value Preparing End Here --------------------------------- -->

            var Potency = ((100 - parseFloat(lod_water)) / 100) * parseFloat(assayPotency); // Calculation
            $('#potency_xyz').val(parseFloat(Potency).toFixed(6)); // Set Potency calculated val
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

        function SelectedQCStatus(un_id) {
            var QC_StatusByAnalyst = document.getElementById('qC_status_by_analyst' + un_id).value;

            if (QC_StatusByAnalyst == 'Complies') {
                $('#QC_StatusByAnalystTd' + un_id).attr('style', 'background-color: #c7f3c7');
                $('#qC_status_by_analyst' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
            } else if (QC_StatusByAnalyst == 'Non Complies') {
                $('#QC_StatusByAnalystTd' + un_id).attr('style', 'background-color: #f8a4a4');
                $('#qC_status_by_analyst' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
            } else {
                $('#QC_StatusByAnalystTd' + un_id).attr('style', 'background-color: #ffffff');
                $('#qC_status_by_analyst' + un_id).attr('style', 'background-color: #ffffff;border:1px solid #ffffff !important;');
            }
        }

        function ManualSelectedTResultOut(un_id) {
            var ResultOut = document.getElementById('ResultOut' + un_id).value;

            if (ResultOut == '-') {
                // BLANK
                $('#ResultOutTd' + un_id).attr('style', 'background-color: #ffffff');
                $('#ResultOut' + un_id).attr('style', 'background-color: #ffffff;border:1px solid #ffffff !important;');
            } else if (ResultOut == 'FAIL') {
                // FAIL
                $('#ResultOutTd' + un_id).attr('style', 'background-color: #f8a4a4');
                $('#ResultOut' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
            } else {
                $('#ResultOutTd' + un_id).attr('style', 'background-color: #c7f3c7');
                $('#ResultOut' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
            }
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
            })
        }

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
                    })
                    $('.done-by-mo' + n).html(html);
                }
            })
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
                $('#qCStsQty_' + un_id).val($('#qc_Check_Batch_Size').val());
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

                var BatchQty = $('#qc_Check_Batch_Size').val();
                var QCS_Qty = parseFloat(parseFloat(BatchQty) - parseFloat(sum)).toFixed(3);
                return QCS_Qty;
            // <!-- calculate Quantity for QC status tab end -------------------------------- -->
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
                    data: ({index: tr_count,action: 'add_qc_status_input_more'}),
                    success: function(result) {
                        $('#add-more_' + tr_count).after(result);
                        tr_count++;
                        $('#tr-count').val(tr_count);
                        $('#qCStsQty_' + tr_count).val(QCS_Qty);

                        getQcStatusDropodwn(tr_count);
                        getDoneByDroopdown(tr_count);
                    }
                })
            }
        }

        function TransToUnder() {
            // Use querySelector to find the checked radio button within the group
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

            var qcD_DocEntry = document.getElementById('qc_Check_DocEntry').value;
            var BatchNo = document.getElementById('qc_Check_Batch_No').value;
            var ItemCode = document.getElementById('qc_Check_Item_Code').value;
            var LineNum = document.getElementById('qc_Check_LineNum').value;
            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: {'DocEntry': qcD_DocEntry,'QC_Status': QCstatus,'action': "qc_post_document_in_process_pupup_ajax"},
                cache: false,
                dataType: 'JSON',
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    $('#qc_check_DocEntry').val(result[0].DocEntry);
                    $('#qc_check_branchID').val(result[0].BPLId);
                    $('#it_SupplierCode').val(result[0].SupplierCode);
                    $('#it_SupplierName').val(result[0].SupplierName);
                    $('#it_BranchName').val(result[0].Branch);
                    $('#it_DocEntry').val(result[0].GRPODocEntry);
                    $('#qc_check_LineID').val(QCS_LineId);
                    $('#it_BAseDocNum').val(result[0].DocNum);
                    $('#it_BaseDocEntry').val(result[0].BaseDocType);
                    $('#qc_check_itemCode').val(result[0].ItemCode);
                    $('#qc_check_ItemName').val(result[0].ItemName);
                    $('#qc_check_Quality').val(qCStsQty);
                    $('#qc_check_FromWhs').val(result[0].FromWhse);
                    $('#qc_check_ToWhs').val(result[0].ToWhse);
                    $('#qc_check_Location').val(result[0].Location);
                    $('#qc_check_UOM').val(result[0].Unit);
                    $('#BranchId').val(result[0].BranchId);
                    $('#_DocEntry').val(result[0].DocEntry);

                    getSeriesDropdown(); // DocName By using API to get dropdown 
                    ContainerSelection() // get Container Selection Table List
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            })
        }

        function ContainerSelection() {
            var BNo = document.getElementById('qc_Check_Batch_No').value;
            var ItemCode = document.getElementById('qc_Check_Item_Code').value;
            var FromWhs = document.getElementById('qc_check_FromWhs').value;

            var dataString = 'BNo=' + BNo + '&ItemCode=' + ItemCode + '&FromWhs=' + FromWhs + '&action=QC_Post_document_QC_Check_ContainerList_ajax';
            $.ajax({
                type: "POST",
                url: 'ajax/kri_production_common_ajax.php',
                data: dataString,
                cache: false,
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
                    var JSONObject = JSON.parse(result);
                    $('#ContainerSelectionItemAppend').html(JSONObject);
                },
                complete: function(data) {
                    $(".loader123").hide();
                }
            })
        }

        function getSelectedContener(un_id) {
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

            // <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
                const array = selected;
                let sum = 0;

                for (let i = 0; i < array.length; i++) {
                sum += parseFloat(array[i]);
                }
                document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
            // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->

            // <!-- --------------------- when user select checkbox update flag start here -------------- -->
                var usercheckListVal = document.getElementById('usercheckList' + un_id).value;

                if (usercheckListVal == '0') {
                    $(`#usercheckList` + un_id).val('1');
                } else {
                    $(`#usercheckList` + un_id).val('0');
                }
            // <!-- --------------------- when user select checkbox update flag End here ---------------- -->
        }

        function EnterQtyValidation_GI(un_id) {
            var BatchQty = document.getElementById('itp_BatchQty' + un_id).value;
            var SelectedQty = document.getElementById('SelectedQty' + un_id).value;

            if (SelectedQty != '') {
                if (parseFloat(SelectedQty) <= parseFloat(BatchQty)) {
                    $('#SelectedQty' + un_id).val(parseFloat(SelectedQty).toFixed(6));
                    $('#itp_CS' + un_id).val(parseFloat(SelectedQty).toFixed(6)); // same value set on checkbox value
                } else {
                    $('#SelectedQty' + un_id).val(BatchQty); // if user enter grater than val
                    $('#itp_CS' + un_id).val(parseFloat(BatchQty).toFixed(6));
                    swal("Oops!", "User Not Allow to Enter Selected Qty greater than Batch Qty!", "error");
                }
            } else {
                $('#SelectedQty' + un_id).val(BatchQty); // if user enter blank val
                $('#itp_CS' + un_id).val(parseFloat(BatchQty).toFixed(6));
                swal("Oops!", "User Not Allow to Enter Selected Qty is blank!", "error");
            }

            getSelectedContenerGI_Manual(un_id); // if user change selected Qty value after selection       
        }

        function getSelectedContenerGI_Manual(un_id) {
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

            // <!-- ------------------- Container Selection Final Sum calculate Start Here ------------- -->
                const array = selected;
                let sum = 0;

                for (let i = 0; i < array.length; i++) {
                    sum += parseFloat(array[i]);
                }
                document.getElementById("cs_selectedQtySum").value = parseFloat(sum).toFixed(6); // Container Selection final sum
            // <!-- ------------------- Container Selection Final Sum calculate End Here ---------------- -->
        }

        function SubmitInventoryTransferQC_ckeck() {
            var selectedQtySum = document.getElementById('cs_selectedQtySum').value; // final Qty sum
            var PostingDate = document.getElementById('qc_check_posting_date').value;
            var DocDate = document.getElementById('qc_check_document_date').value;
            var ItemCode = document.getElementById('qc_check_itemCode').value;
            var ItemName = document.getElementById('qc_check_ItemName').value;
            var item_BQty = parseFloat(document.getElementById('qc_check_Quality').value).toFixed(6); // item available Qty
            var fromWhs = document.getElementById('qc_check_FromWhs').value;
            var ToWhs = document.getElementById('qc_check_ToWhs').value;
            var Location = document.getElementById('qc_check_Location').value;

            if (selectedQtySum == item_BQty) { // Container selection Qty validation
                if (fromWhs != '') { // Item level To Warehouse validation
                    if (PostingDate != '') { // Posting Date validation
                        if (DocDate != '') { // Document Date validation
                            // <!-- ---------------- form submit process start here ----------------- -->
                                var formData = new FormData($('#inventrotyTransferQC_ckecked')[0]);
                                formData.append("SubIT_Btn_In_process_QC_check_sample_issue", 'SubIT_Btn_In_process_QC_check_sample_issue');

                                var error = true;

                                if (error) {
                                    $.ajax({
                                        url: 'ajax/kri_production_common_ajax.php',
                                        type: "POST",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        beforeSend: function() {
                                            $(".loader123").show();
                                        },
                                        success: function(result) {
                                            var JSONObject = JSON.parse(result);

                                            var status = JSONObject['status'];
                                            var message = JSONObject['message'];
                                            var DocEntry = JSONObject['DocEntry'];
                                            if (status == 'True') {
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
                                                    } else {
                                                        location.replace(window.location.href); // cancel btn... cuurent URL called
                                                    }
                                                });
                                            } else {
                                                swal("Oops!", `${message}`, "error");
                                            }
                                        },
                                        complete: function(data) {
                                            $(".loader123").hide();
                                        }
                                    })
                                }
                            // <!-- ---------------- form submit process end here ------------------- -->
                        } else {
                            swal("Oops!", "Please Select A Document Date.", "error");
                        }
                    } else {
                        swal("Oops!", "Please Select A Posting Date.", "error");
                    }
                } else {
                    swal("Oops!", "From Warehouse Mandatory.", "error");
                }
            } else {
                swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
            }
        }

        function add_qc_post_document() {
            var formData = new FormData($('#QcDpcumentFormInProcess')[0]); // Form Id
            formData.append("addQcPostDocumentSubmitQCCheckBtn", 'addQcPostDocumentSubmitQCCheckBtn'); // Button Id
            var error = true;

            $.ajax({
                url: 'ajax/kri_production_common_ajax.php',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(".loader123").show();
                },
                success: function(result) {
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
            })
        }
    </script>