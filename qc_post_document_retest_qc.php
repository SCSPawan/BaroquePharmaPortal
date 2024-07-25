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
    $getAllData = $objKri->getQCREtestCollection($RETESTQCPOSTDOCUMENTDETAILS, $tdata);

    // echo "<pre>";
    // print_r($getAllData);
    // echo "</pre>";
    // exit;
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
                        <th>Branch Name</th>
                    </tr>
                </thead>
                <tbody>';

    if (count($getAllData) != '0') {
        for ($i = $r_start; $i < $r_end; $i++) {
            if (!empty($getAllData[$i]->DocEntry)) {   //  this condition save to extra blank loop
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
                                    <input type="radio" id="list' . $getAllData[$i]->DocEntry . '" name="listRado" value="' . $getAllData[$i]->DocEntry . '" class="form-check-input" style="width: 17px;height: 17px;" onclick="selectedRecord(' . $getAllData[$i]->DocEntry . ')"  style="width: 17px;height: 17px;">
                                </td>
                                <td class="desabled">' . $getAllData[$i]->DocEntry . '</td>
                                <td class="desabled">' . $getAllData[$i]->GRPONo . '</td>

                                <td class="desabled">' . $getAllData[$i]->GRPOEntry . '</td>
                                <td class="desabled">' . $getAllData[$i]->SupplierCode . '</td>
                                <td class="desabled">' . $getAllData[$i]->SupplierName . '</td>
                                <td class="desabled">' . $getAllData[$i]->RefNo . '</td>
                                <td class="desabled">' . $getAllData[$i]->LineNum . '</td>
                                <td class="desabled">' . $getAllData[$i]->ItemCode . '</td>
                                <td class="desabled">' . $getAllData[$i]->ItemName . '</td>
                                <td class="desabled">' . $getAllData[$i]->LabelClaimUOM . '</td>  
                                <td class="desabled">' . $getAllData[$i]->GRQty . '</td>
                                <td class="desabled">' . $getAllData[$i]->BatchNo . '</td>
                                <td class="desabled">' . $getAllData[$i]->BatchQty . '</td>
                                <td class="desabled">' . $MfgDate . '</td>
                                <td class="desabled">' . $ExpiryDate . '</td>
                                <td class="desabled">' . $getAllData[$i]->SampleIntimationNo . '</td>
                                <td class="desabled">' . $getAllData[$i]->SampleCollectionNo . '</td>
                                <td class="desabled">' . $getAllData[$i]->Branch . '</td>
                            </tr>';
            }
        }
    } else {
        $option .= '<tr><td colspan="18" style="color:red;text-align:center;font-weight: bold;">No record</td></tr>';
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
<div class="loader-top" style="height: 100%;width: 100%;background: #cccccc73;">
    <div class="loader123" style="text-align: center;z-index: 10000;position: fixed;top: 0; left: 0;bottom: 0;right: 0;background: #cccccc73;">
        <img src="loader/loader2.gif" style="width: 5%;padding-top: 288px !important;">
    </div>
</div>

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
                        <h4 class="mb-0">Qc Post Document-Retest QC</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Qc Post Document-Retest QC</li>
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
                            <h4 class="card-title mb-0">Qc Post Document-Retest QC</h4>

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
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
            <br>
            <div class="row" id="footerProcess">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form role="form" class="form-horizontal" id="qcPostDocumentRetestForm_update" method="post">
                                <div class="row">
                                    <input type="hidden" id="qcD_LineNum" name="qcD_LineNum">
                                    <input type="hidden" id="qcD_DocEntry" name="qcD_DocEntry">
                                    <input type="hidden" id="U_PC_BPLId" name="U_PC_BPLId">
                                    <input type="hidden" id="U_PC_LocCode" name="U_PC_LocCode">
                                    <input type="hidden" id="U_PC_Loc" name="U_PC_Loc">
                                    <input type="hidden" id="U_PC_GDEntry" name="U_PC_GDEntry">
                                    <input type="hidden" id="U_PC_GRQty" name="U_PC_GRQty">
                                    <input type="hidden" id="U_PC_RelDt" name="U_PC_RelDt">
                                    <input type="hidden" id="U_PC_RetstDt" name="U_PC_RetstDt">
                                    <input type="hidden" id="U_PC_RMQC" name="U_PC_RMQC" value="No">
                                    <input type="hidden" id="U_PC_RecQty" name="U_PC_RecQty">
                                    <input type="hidden" id="U_PC_SType" name="U_PC_SType">
                                    <input type="hidden" id="QCPD" name="QCPD" value="">
                                    <input type="hidden" id="itP_FromWhs" name="itP_FromWhs">
                                    <input type="hidden" id="itP_ToWhs" name="itP_ToWhs">
                                    <input type="hidden" id="qcD_Unit" name="qcD_Unit">


                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">GRPO No</label>
                                            <!-- <div class="col-lg-8">
                                                    <input class="form-control desabled" readonly type="text" id="qcD_GRPONo" name="qcD_GRPONo">
                                                </div> -->

                                            <div class="col-lg-4">
                                                <input class="form-control desabled" type="text" id="qcD_GRPONo" name="qcD_GRPONo" readonly>
                                            </div>
                                            <div class="col-lg-4">
                                                <input class="form-control desabled" type="text" id="GRPODocEntry-re" name="GRPODocEntry" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Code</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_SupplierCode" name="qcD_SupplierCode">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Supplier Name</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_SupplierName" name="qcD_SupplierName">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_ItemCode" name="qcD_ItemCode">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_ItemName" name="qcD_ItemName">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Generic Name</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_GenericName" name="qcD_GenericName">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Cliam</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_LabelClaim" name="qcD_LabelClaim">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Claim UOM</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_LabelClaimUOM" name="qcD_LabelClaimUOM">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Recieved Qty</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_RetainQty" name="qcD_RetainQty">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg By</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_MfgBy" name="qcD_MfgBy">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ref No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_RefNo" name="qcD_RefNo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_BatchNo" name="qcD_BatchNo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Size</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_BatchQty" name="qcD_BatchQty">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_MfgDate" name="qcD_MfgDate">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Exp. Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_ExpiryDate" name="qcD_ExpiryDate">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Int. No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_SampleIntimationNo" name="qcD_SampleIntimationNo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Coll. No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_SampleCollectionNo" name="qcD_SampleCollectionNo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="number" id="qcD_SampleQty" name="qcD_SampleQty">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Pack Size</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_PckSize" name="qcD_PckSize">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" type="text" id="qcD_SamType" name="qcD_SamType" readonly>
                                                <!-- <select class="form-select desabled" disabled>
                                                        <option>Regular</option>
                                                    </select> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_MatType" name="qcD_MatType">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Specification No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_SpecfNo" name="qcD_SpecfNo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc. No</label>
                                            <div class="col-lg-6">
                                                <input class="form-control" type="text" id="qcD_Series" name="qcD_Series" readonly>

                                                <!-- <select class="form-select desabled" disabled>
                                                        <option>Primary</option>
                                                    </select> -->
                                            </div>
                                            <div class="col-lg-2">
                                                <input class="form-control desabled" readonly type="text" id="qcD_DocNum" name="qcD_DocNum">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_PostingDate" name="qcD_PostingDate">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Date</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_ADate" name="qcD_ADate">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">No. Container</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_NoCont" name="qcD_NoCont">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">QC Test Type</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_QCTType" name="qcD_QCTType">
                                                <!-- <select class="form-select desabled" disabled>
                                                        <option>Regular</option>
                                                    </select> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stage</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_Stage" name="qcD_Stage">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_Branch" name="qcD_Branch">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Valid Up To</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_ValidUpto" name="qcD_ValidUpto">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No.</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_ARNo" name="qcD_ARNo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-6">
                                                <div class="form-group row mb-2">
                                                   <label class="col-lg-4 col-form-label mt-6" for="val-skill">Make By</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control desabled" type="text" id="qcD_MakeBy" name="qcD_MakeBy" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry No</label>
                                            <div class="col-lg-8">
                                                <input class="form-control desabled" readonly type="text" id="qcD_GateENo" name="qcD_GateENo">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="form-group row mb-2">
                                            <label class="col-lg-7 col-form-label mt-6" for="val-skill">Release Material Without QC</label>
                                            <div class="col-lg-5">
                                                <select class="form-select" id="RMWQC" name="RMWQC">
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        <!-- Toggle States Button -->
                                        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Container Selection</button> -->
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
                                                        <a class="nav-link active" data-bs-toggle="tab" href="#general_data2" role="tab">
                                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                            <span class="d-none d-sm-block">General Data</span>
                                                        </a>
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

                                                <!-- Tab panes -->

                                                <div class="tab-content p-3 text-muted">
                                                    <div class="tab-pane active" id="general_data2" role="tabpanel">

                                                        <div class="table-responsive qc_list_table table_item_padding" id="list">
                                                            <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                                <thead class="fixedHeader1">
                                                                    <tr>
                                                                        <th>Sr. No</th>
                                                                        <th>Parameter Code</th>
                                                                        <th>Parameter Name </th>
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
                                                                        <th>Analyst Remark</th>
                                                                        <th>Lower Max</th>
                                                                        <th>Release</th>
                                                                        <th>Descriptive Details</th>
                                                                        <th>Upper Min</th>
                                                                        <th>Lower Min - Result</th>
                                                                        <!--<th>Lower Max - Result</th>-->
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
                                                                        <th>Applicable For Assay</th>
                                                                        <th>Applicable For LOD</th>
                                                                        <th>Instrument Code</th>
                                                                        <th>Instrument Name</th>
                                                                        <th>Star Date</th>
                                                                        <th>Start Time</th>
                                                                        <th>End Date</th>
                                                                        <th>End Time</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="qc-post-general-data-list-append">


                                                                </tbody>

                                                            </table>
                                                        </div>
                                                        <!--end table-->

                                                    </div> <!-- tab_pane samp details end -->



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
                                                                <tbody id="qc-status-list-append">

                                                                </tbody>

                                                            </table>
                                                        </div><!--table responsive end-->

                                                        <!-- <div class="row">
                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-5 col-form-label mt-6" for="val-skill">GRPO Remaining Qty</label>
                                                                    <div class="col-lg-7">
                                                                        <input class="form-control" type="text" id="" name="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                        <hr>


                                                    </div> <!-- tab_pane qc status end -->




                                                    <div class="tab-pane" id="attatchment2" role="tabpanel">

                                                        <div class="row">
                                                            <div class="col-md-10">
                                                                <div class="table-responsive" id="list">
                                                                    <table id="tblItemRecord" class="table table-bordered" style="">
                                                                        <thead class="fixedHeader1">
                                                                            <tr>
                                                                                <th>Select</th>
                                                                                <th>Status</th>
                                                                                <th>Quantity</th>
                                                                                <th>IT No</th>
                                                                                <th>Done By</th>
                                                                                <th>Remarks</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="qc-attach-list-append">


                                                                        </tbody>

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
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Lod/Water %</label>
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
                                                                        <input class="form-control" type="number" id="factor" name="factor">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Compiled By</label>
                                                                    <div class="col-lg-8">
                                                                        <input class="form-control qc_post_compiled_by_class" type="text" id="qc_post_compiled_by" name="qc_post_compiled_by">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">No Of Container</label>
                                                                    <div class="col-lg-4">
                                                                        <input class="form-control" type="text" id="fnoOfCont1" name="fnoOfCont1">
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <input class="form-control" type="text" id="fnoOfCont2" name="fnoOfCont2">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Checked By</label>
                                                                    <div class="col-lg-8">
                                                                        <input class="form-control checked_by_class" type="text" id="checked_by" name="checked_by">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis By</label>
                                                                    <div class="col-lg-8">
                                                                        <input class="form-control analysis_by_class" type="text" id="analysis_by" name="analysis_by">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-md-6">
                                                                <div class="form-group row mb-2">
                                                                    <label class="col-lg-4 col-form-label mt-6" for="val-skill">Remarks</label>
                                                                    <div class="col-lg-8">
                                                                        <textarea class="form-control SetRemarkVal" id="qc_remarks" name="qc_remarks" rows="1"></textarea>
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
                                                                <button type="button" class="btn btn-primary" id="updateQcPostDocumentRetestBtn" name="updateQcPostDocumentRetestBtn" onclick="return update_qc_post_document_retest_qc();">Update</button>

                                                                <button type="button" class="btn btn-danger active" data-bs-toggle="button" autocomplete="off">Cancel</button>

                                                                <!--  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" data-bs-toggle="button" autocomplete="off">Inventory Transfer</button> -->

                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" autocomplete="off" onclick="TransToUnder();">Inventory Transfer</button>

                                                                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Update Result</button> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Label & COA Print</button>
                                                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-bs-toggle="dropdown" aria-expanded="false" data-bs-reference="parent"><i class="fa fa-angle-down"></i>
                                                                    <span class="visually-hidden"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target=".QC_PostDocPrintLayout" autocomplete="off" onclick="ViewRPT_Print_Open('INWARDQCAPPROVLABEL','Approval Label Print')">Approval Label Print</a></li>

                                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target=".QC_PostDocPrintLayout" autocomplete="off" onclick="ViewRPT_Print_Open('RETESTQCPOSTREJECT','Rejected Label Print')">Rejected Label Print</a></li>

                                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target=".QC_PostDocPrintLayout" autocomplete="off" onclick="ViewRPT_Print_Open('RETESTQCPOSTONHOLD','On-Hold Label Print')">On-Hold Label Print</a></li>

                                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target=".QC_PostDocPrintLayout" autocomplete="off" onclick="ViewRPT_Print_Open('INWARDQCPRINTCERTIFICATE','Print Certificate')">Print Certificate</a></li>
                                                                </ul>



                                                            </div>
                                                        </div>

                                                    </div>



                                                </div> <!-- tab content end -->

                                            </div>
                                        </div><!-- end card-body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                            </form>
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
<br>

<?php include 'include/footer.php' ?>
<?php include 'include/header.php' ?>
<?php include 'models/qc_post_document_kri_modal.php' ?>

<style type="text/css">
    body[data-layout=horizontal] .page-content {
        padding: 20px 0 0 0;
        padding: 40px 0 60px 0;
    }
</style>


<script type="text/javascript">
    $(".loader123").hide(); // loader default hide script
    $("#footerProcess").hide(); // Afer Doc Selection Process default hide script

    $(document).ready(function() {
        var fromDate = document.getElementById('FromDate').value;
        var toDate = document.getElementById('ToDate').value;
        var docEntry = document.getElementById('DocEntry').value;

        var dataString = 'fromDate=' + fromDate + '&toDate=' + toDate + '&docEntry=' + docEntry + '&action=list';

        $.ajax({
            type: "POST",
            url: window.location.href,
            data: dataString,
            beforeSend: function() {
                // Show image container
                $(".loader123").show();
            },
            success: function(result) {
                $('#list-append').html(result);
            },
            complete: function(data) {
                // Hide image container
                $(".loader123").hide();
            }
        });
    });

    function change_page(page_id)
    { 
        var fromDate = document.getElementById('FromDate').value;
        var toDate = document.getElementById('ToDate').value;
        var DocEntry = document.getElementById('DocEntry').value;

        var dataString = 'page_id=' + page_id + '&fromDate=' + fromDate + '&toDate=' + toDate + '&DocEntry=' + DocEntry + '&action=list';

        // var dataString ='page_id='+page_id+'&action=list';

        $.ajax({
            type: "POST",
             url: window.location.href,  
            data: dataString,
            cache: false,
            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result)
            {
                $('#list-append').html(result);
            },
            complete:function(data){
                // Hide image container
                $(".loader123").hide();
            }
        });
    }

    
    function SearchData() { 
        var fromDate = document.getElementById('FromDate').value;
        var toDate = document.getElementById('ToDate').value;
        var DocEntry = document.getElementById('DocEntry').value;

        var dataString = 'fromDate=' + fromDate + '&toDate=' + toDate + '&DocEntry=' + DocEntry + '&action=list';

        $.ajax({
            type: "POST",
            url: window.location.href,
            data: dataString,
            beforeSend: function() {
                // Show image container
                $(".loader123").show();
            },
            success: function(result) {
                $("#footerProcess").hide();
                $('#list-append').html(result);
            },
            complete: function(data) {
                // Hide image container
                $(".loader123").hide();
            }
        });
    }



    function selectedRecord(DocEntry) {

        var dataString = 'DocEntry=' + DocEntry + '&action=qc_post_document_retest_qc_ajax';

        $.ajax({
            type: "POST",
            url: 'ajax/kri_common-ajax.php',
            data: dataString,
            beforeSend: function() {
                // Show image container
                $(".loader123").show();
            },
            success: function(result) {
                $("#footerProcess").show(); // footer section Show script
                var JSONObjectAll = JSON.parse(result);

                var JSONObject = JSONObjectAll['SampleCollDetails']; // sample collection details var
                // Unit
                // console.log('dd=>',JSONObject);
                $(`#qc-post-general-data-list-append`).html(JSONObjectAll['general_data']); // Extra Issue Table Tr tag append here
                $(`#qc-status-list-append`).html(JSONObjectAll['qcStatus']); // External Issue Table Tr tag append here
                $(`#qc-attach-list-append`).html(JSONObjectAll['qcAttach']); // External Issue Table Tr tag append here

                
                // <!-- ----------------- Bottom Hidden Field start here ----------------------- -->
                    $(`#qcD_GRPONo`).val(JSONObject[0]['GRPONo']);
                    $(`#GRPODocEntry-re`).val(JSONObject[0]['GRPOEntry']);
                    $(`#qcD_LineNum`).val(JSONObject[0]['LineNum']);
                    $(`#qcD_DocEntry`).val(JSONObject[0]['DocEntry']);
                    $(`#qcD_SupplierCode`).val(JSONObject[0]['SupplierCode']);
                    $(`#qcD_SupplierName`).val(JSONObject[0]['SupplierName']);
                // <!-- ----------------- Bottom Hidden Field end here ------------------------- -->

                // <!-- --------------- Tab Layout Sample Collection Details Mapping Start Here ------------------ -->
                $(`#qcD_ItemCode`).val(JSONObject[0]['ItemCode']);
                $(`#qcD_ItemName`).val(JSONObject[0]['ItemName']);
                $(`#qcD_GenericName`).val(JSONObject[0]['GenericName']);
                $(`#qcD_LabelClaim`).val(JSONObject[0]['LabelClaim']);
                $(`#qcD_LabelClaimUOM`).val(JSONObject[0]['LabelClaimUOM']);
                $(`#qcD_RetainQty`).val(JSONObject[0]['RecQty']);
                $(`#qcD_MfgBy`).val(JSONObject[0]['MfgBy']);
                $(`#qcD_RefNo`).val(JSONObject[0]['RefNo']);
                $(`#qcD_BatchNo`).val(JSONObject[0]['BatchNo']);
                $(`#qcD_BatchQty`).val(JSONObject[0]['BatchQty']);
                $(`#qcD_MakeBy`).val(JSONObject[0]['MakeBy']);
                // console.log('qc_remarks=>',JSONObject[0]['Remarks']);
                $(`.SetRemarkVal`).val(JSONObject[0]['Remarks']);
                // <!-- --------------- Tab Layout Sample Collection Details Mapping End Here -------------------- -->

                $(`#qcD_SampleIntimationNo`).val(JSONObject[0]['SampleIntimationNo']);
                $(`#qcD_SampleCollectionNo`).val(JSONObject[0]['SampleCollectionNo']);
                $(`#qcD_SampleQty`).val(JSONObject[0]['SampleQty']);
                $(`#qcD_PckSize`).val(JSONObject[0]['PckSize']);
                $(`#qcD_SamType`).val(JSONObject[0]['SamType']);
                $(`#qcD_MatType`).val(JSONObject[0]['MatType']);
                $(`#qcD_SpecfNo`).val(JSONObject[0]['SpecfNo']);
                $(`#qcD_Series`).val(JSONObject[0]['Series']);
                $(`#qcD_DocNum`).val(JSONObject[0]['DocNum']);
                $(`#qcD_NoCont`).val(JSONObject[0]['NoCont']);
                $(`#fnoOfCont1`).val('1');
                $(`#fnoOfCont2`).val(JSONObject[0]['NoCont']); 
                $(`#qcD_QCTType`).val(JSONObject[0]['QCTType']);
                $(`#qcD_Stage`).val(JSONObject[0]['Stage']);
                $(`#qcD_Branch`).val(JSONObject[0]['Branch']);
                $(`#qcD_ValidUpto`).val(JSONObject[0]['ValidUpto']);
                $(`#qcD_ARNo`).val(JSONObject[0]['ARNo']);
                $(`#qcD_GateENo`).val(JSONObject[0]['GateENo']);
                $(`#itP_FromWhs`).val(JSONObject[0]['FrmWhse']);
                $(`#itP_ToWhs`).val(JSONObject[0]['ToWhse']);
                $(`#qcD_Unit`).val(JSONObject[0]['Unit']);

                $(`#qcD_PostingDate`).val(DateFormatingDMY(JSONObject[0]['PostingDate']));
                $(`#qcD_ADate`).val(DateFormatingDMY(JSONObject[0]['ADate']));
                $(`#qcD_MfgDate`).val(DateFormatingDMY(JSONObject[0]['MfgDate']));
                $(`#qcD_ExpiryDate`).val(DateFormatingDMY(JSONObject[0]['ExpiryDate']));
                            
                // <!-- ----------- Select Dropdown using value start ---------------------- -->
                    // Example usage: Select the option with value
                    var value = JSONObject[0]['RMWQC'];
                    var selectElement = document.getElementById('RMWQC');
                    selectElement.value = value;
                // <!-- ----------- Select Dropdown using value end ------------------------ -->

                GetRowLevelAnalysisByDropdownWithSelectedOption(JSONObjectAll.count);

                // QC_StatusByAnalystDropdown(JSONObjectAll.count);

                //alert('hiii');
                // getResultOutputDropdown(JSONObjectAll.count);

                getQcStatusDropodwn(1);
                getDoneByDroopdown(1);
                dropdownFunction('checked_by', JSONObject[0]['ChkBy']);
                dropdownFunction('analysis_by', JSONObject[0]['AnlBy']);
                getResultOutputDropdownWithSelectedOption(JSONObjectAll.count);
                QC_StatusByAnalystDropdownWithSelectedOption(JSONObjectAll.count);
                // qcAsseyCalculation();
                // tablayoutvalidation();
            },
            complete: function(data) {
                // Hide image container
                $(".loader123").hide();
            }
        });
    }

    function DateFormatingDMY(DateOG){
        if(DateOG!=''){
            let [day, month, year] = DateOG.split(" ")[0].split("-");
            let Date = `${day}-${month}-${year}`;
            return Date;
        }
    }

    $(document).ready(function() {
        var dataString = 'action=qc_get_SAMINTTRBY_ajax';
        $.ajax({
            type: "POST",
            dataType: 'JSON',
            url: 'ajax/kri_common-ajax.php',
            data: dataString,
            success: function(result) {

                // console.log(result);

                $('.qc_post_compiled_by_class').val(result[0]['TRBy']);
                $('.checked_by_class').val(result[0]['TRBy']);
                $('.analysis_by_class').val(result[0]['TRBy']);

                var html = "";
                result.forEach(function(value, index) {
                    html += '<option value="' + value.TRBy + '">' + value.TRBy + '</option>';
                });

                $('.done-by-mo').html(html);
            }
        });
    });

    function dropdownFunction(attr, idvalue) {
        $.ajax({
            type: "POST",
            url: 'ajax/kri_common-ajax.php',
            data: {
                'action': "GetRowLevelAnalysisByDropdown_Ajax",
                'value_id': idvalue
            },
            success: function(result) {
                var dropdown = JSON.parse(result);
                $('#' + attr).html(dropdown);

            },
            complete: function(data) {
                $(".loader123").hide();
            }
        });



    }


    // function qcAsseyCalculation(){
    //      var dataString ='action=qc_assay_Calculation_Based_On_ajax';
    //     $.ajax({  
    //         type: "POST",  
    //         url: 'ajax/kri_common-ajax.php',  
    //         data: dataString,  
    //         success: function(result){ 

    //             // console.log(result);
    //             $('.assayapp').html(result);
    //         }
    //    });
    // }

    $(document).ready(function() {
        var dataString = 'action=qc_assay_Calculation_Based_On_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/kri_common-ajax.php',
            data: dataString,
            success: function(result) {

                // console.log(result);
                $('.assayapp').html(result);
            }
        });
    });


    //  function QC_StatusByAnalystDropdown(trcount){

    //     var dataString ='TableId=@SCS_QCPD1&Alias=QCStatus&action=dropdownMaster_ajax';

    //     $.ajax({
    //         type: "POST",
    //         url: 'ajax/common-ajax.php',
    //         data: dataString,
    //         cache: false,

    //         beforeSend: function(){
    //             // Show image container
    //             $(".loader123").show();
    //         },

    //         success: function(result)
    //         {
    //             var JSONObject = JSON.parse(result);

    //             //console.log('JSONObject anliysby----',JSONObject);
    //             for (let i = 0; i < trcount; i++) {
    //                 $('.AnalysisBy'+i).html(JSONObject); // dropdown set using Class                            
    //             }
    //         },
    //         complete:function(data){
    //             // Hide image container
    //             $(".loader123").hide();
    //         }
    //     });
    // }




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
                    // console.log('selectedValue=>'+i, selectedValue);

                    let options = `<option value="" >Select</option>`;
                    // $option.='<option value="">Select</option>';
                    for (let j = 0; j < count; j++) {
                        let selected = (selectedValue == JSONObject[j].UserCode) ? 'selected' : '';
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

    // function QC_StatusByAnalystDropdown(trcount) {


    //     var dataString = 'TableId=@SCS_QCPD1&Alias=QCStatus&action=dropdownMaster_ajax';

    //     $.ajax({
    //         type: "POST",
    //         url: 'ajax/common-ajax.php',
    //         data: dataString,
    //         cache: false,

    //         beforeSend: function() {
    //             $(".loader123").show();
    //         },
    //         success: function(result) {
    //             var JSONObject = JSON.parse(result);

    //             //console.log('JSONObject=>', JSONObject);
    //             for (let i = 0; i < trcount; i++) {
    //                 $('#qC_status_by_analyst' + i).html(JSONObject); // dropdown set using Class                            
    //             }
    //         },
    //         complete: function(data) {
    //             $(".loader123").hide();
    //         }
    //     });
    // }

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

    function getQcStatusDropodwn(n) {
        var dataString = 'action=qc_api_OQCSTATUS_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/kri_common-ajax.php',
            data: dataString,
            success: function(result) {

                //console.log('result-- getQcStatusDropodwn',result);
                $('.qc_status_selecte' + n).html(result);
            }
        });
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
                });

                $('.done-by-mo' + n).html(html);
            }
        });
    }

    // function CalculateResultOut(un_id) {

    //     var lowMin = document.getElementById('LowMin' + un_id).value;
    //     var uppMax = document.getElementById('UppMax' + un_id).value;
    //     var UOM = document.getElementById('GDUOM' + un_id).value;

    //     var lowMinResOG = document.getElementById('lower_min_result' + un_id).value; // this value enter by user

    //     var lowMinRes = parseFloat(lowMinResOG).toFixed(6); // this value enter by user

    //     if (lowMinRes != '') {
    //         $('#lower_min_result' + un_id).val(lowMinRes);

    //         $('#remarks' + un_id).val(lowMinResOG + ' ' + UOM);

    //         if (parseFloat(lowMinRes) >= parseFloat(lowMin) && parseFloat(lowMinRes) <= parseFloat(uppMax)) {

    //             $('.dropdownResutl' + un_id).val('PASS');
    //             $('#ResultOutTd' + un_id).attr('style', 'background-color: #c7f3c7');
    //             $('.dropdownResutl' + un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');

    //             setSelectedIndex(document.getElementsByClassName("dropdownResutl" + un_id), "PASS");
    //         } else {

    //             $('.dropdownResutl' + un_id).val('FAIL');
    //             $('#ResultOutTd' + un_id).attr('style', 'background-color: #f8a4a4');
    //             $('.dropdownResutl' + un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');

    //             setSelectedIndex(document.getElementsByClassName("dropdownResutl" + un_id), "FAIL");
    //         }
    //     }
    // }

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

    function update_qc_post_document_retest_qc() {

        var formData = new FormData($('#qcPostDocumentRetestForm_update')[0]); // Form Id
        formData.append("updateQcPostDocumentRetestBtn", 'updateQcPostDocumentRetestBtn'); // Button Id
        var error = true;

        $.ajax({
            url: 'ajax/kri_common-ajax.php',
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                // Show image container
                // $(".loader123").show();
            },
            success: function(result) {
                console.log(result);
                // var JSONObject = JSON.parse(result);

                // var status = JSONObject['status'];
                // var message = JSONObject['message'];
                // var DocEntry = JSONObject['DocEntry'];
                // if (status == 'True') {
                //     swal({
                //             title: `${message}`,
                //             text: `${DocEntry}`,
                //             icon: "success",
                //             buttons: true,
                //             dangerMode: false,
                //         })
                //         .then((willDelete) => {
                //             if (willDelete) {
                //                 location.replace(window.location.href); //ok btn
                //             } else {
                //                 location.replace(window.location.href); // cancel btn
                //             }
                //         });
                // } else {
                //     swal("Oops!", `${message}`, "error");
                // }
            },
            complete: function(data) {
                // Hide image container
                // $(".loader123").hide();
            }
        });
    }


    function TransToUnder() {
        // Use querySelector to find the checked radio button within the group
        var selectedRadio = document.querySelector('input[name="listRado[]"]:checked');

        // console.log('selectedRadio',selectedRadio);
        // Check if a radio button is selected
        if (selectedRadio) {
            // Get the value of the selected radio button
            var selectedValue = selectedRadio.value;
            var qCStsQty = $('#qCStsQty'+selectedValue).val();
            var QCstatus = $('#qc_Status'+selectedValue).val();
            var QCS_LineId = $('#QCS_LineId'+selectedValue).val();
        } else {
            var qCStsQty = 0.000;
            var QCstatus = '';
            var QCS_LineId ='';
        }


        var qcD_DocEntry = document.getElementById('qcD_DocEntry').value;
        var BatchNo = document.getElementById('qcD_BatchNo').value;
        var ItemCode = document.getElementById('qcD_ItemCode').value;
        var LineNum = document.getElementById('LineNum').value;

        // console.log('qcD_DocEntry',qcD_DocEntry);

        // console.log('BatchNo',BatchNo);

        // console.log("ItemCode",ItemCode);

        // console.log('LineNum',LineNum);

        // console.log({'DocEntry':qcD_DocEntry,'action':"qc_post_document_retest_qc_pupup_ajax"});
        // var hideToware="1";
        // var dataString ='DocEntry='+DocEntry+'&SupplierCode='+SupplierCode+'&SupplierName='+SupplierName+'&BranchName='+BranchName+'&action=SC_OpenInventoryTransfer_ajax';

        // alert('hiii');

        $.ajax({
          
            type: "POST",
            url: 'ajax/kri_common-ajax.php',
            // data:{'DocEntry':GRPODocEntry,'BatchNo':BatchNo,'ItemCode':ItemCode,'LineNum':LineNum,'action':"qc_post_document_retest_qc_pupup_ajax"},
            data: {
                
                'DocEntry': qcD_DocEntry,
                'QC_Status': QCstatus,
                'action': "qc_post_document_retest_qc_pupup_ajax"
            },
            cache: false,
            dataType: 'JSON',
            beforeSend: function() {
              
                // Show image container
                $(".loader123").show();
            },
            success: function(result) {
                
                // console.log('inventoryClick=>',result);
                // // $("#hideToWhs").hide();
                $('#it_SupplierCode').val(result[0].SupplierCode);
                $('#it_SupplierName').val(result[0].SupplierName);
                $('#it_BranchName').val(result[0].Branch);
                $('#it_DocEntry').val(result[0].GRPODocEntry);
                // $('#it_postingDate').val(result[0].PostingDate);
                $('#qc_status_LineId').val(QCS_LineId);
                $('#it_BAseDocNum').val(result[0].DocNum);
                $('#it_BaseDocEntry').val(result[0].BaseDocType);


                $('#tb_itme_code').val(result[0].ItemCode);
                $('#tb_item_name').val(result[0].ItemName);
                // $('#tb_quality').val(result[0].Qty);
                $('#tb_quality').val(qCStsQty);
                
                $('#from_whs').val(result[0].FrmWhse);
                $('#to_whs').val(result[0].ToWhse);

                $('#tb_location').val(result[0].Loc);
                $('#tb_UOM').val(result[0].Unit);
                $('#BranchId').val(result[0].BranchId);
                $('#_DocEntry').val(result[0].DocEntry);





                // var SampleQuantity = document.getElementById('qcD_SampleQty').value;
                // var JSONObject = JSON.parse(result);
                // $('#InventoryTransferItemAppend').html(JSONObject);

                // //Item Quantity Recalculate according sample quantity start here -------------------
                // var itP_BQty = document.getElementById('qcD_BatchQty').value;
                // var calculated_itP_BQty = parseFloat(Number(itP_BQty) - Number(SampleQuantity)).toFixed(6);
                // $('#tb_quality').val(calculated_itP_BQty);
                // //Item Quantity Recalculate according sample quantity end here --------------------- 

                getSeriesDropdown(); // DocName By using API to get dropdown 
                ContainerSelection() // get Container Selection Table List
            },
            complete: function(data) {
                // Hide image container
                $(".loader123").hide();
            }
        });
    }

    function getSeriesDropdown() {
        var TrDate=$('#it_postingDate').val();
        var dataString = 'TrDate='+TrDate+'&ObjectCode=67&action=getSeriesDropdown_ajax';

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

                // console.log(SeriesDropdown);
                $('#it_SeriesName').html(SeriesDropdown);

                selectedSeries(); // call Selected Series Single data fun
            },
            complete: function(data) {
                // Hide image container
                $(".loader123").hide();
            }
        });
    }

    function selectedSeries() {
        var TrDate=$('#it_postingDate').val();
        var Series = document.getElementById('it_SeriesName').value;
        var dataString = 'TrDate='+TrDate+'&Series=' + Series + '&ObjectCode=67&action=getSeriesSingleData_ajax';

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


                //console.log('JSONObject=>',JSONObject);

                var NextNumber = JSONObject[0]['NextNumber'];
                //console.log('NextNumber=>',NextNumber);
                var Series = JSONObject[0]['Series'];

                // $('#DocNo1').val(Series);
                $('#it_SeriesId').val(Series);

                $('#it_DocNo1').val(NextNumber);
            },
            complete: function(data) {
                // Hide image container
                $(".loader123").hide();
            }
        });
    }

    function ContainerSelection() {

        // var GRPODEnt=document.getElementById('U_GRPODEnt').value;
        var BatchNo = document.getElementById('qcD_BatchNo').value;
        var ItemCode = document.getElementById('tb_itme_code').value;
        var FromWhs = document.getElementById('from_whs').value;
        var ToWhse = document.getElementById('itP_ToWhs').value;
        // $(`#itP_ToWhs`).val(JSONObject[0]['ToWhse']);

        // alert(ItemCode);

        // var dataString ='GRPODEnt='+GRPODEnt+'&BNo='+BNo+'&ItemCode='+ItemCode+'&FromWhs='+FromWhs+'&action=SC_OpenInventoryTransferCS_ajax';
        // ?ItemCode=A00116&WareHouse=QCUT-GEN&BatchNo=BT2106-2
        var dataString = 'ItemCode=' + ItemCode + '&WareHouse=' + FromWhs + '&BatchNo=' + BatchNo + '&action=getInventoryRetestQccotainerSelection_ajax';

        // alert(dataString);

        $.ajax({
            type: "POST",
            url: 'ajax/kri_common-ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function() {
                // Show image container
                $(".loader123").show();
            },
            success: function(result) {
                // console.log(result);
                var JSONObject = JSON.parse(result);
                $('#ContainerSelectionItemAppend').html(JSONObject);
            },
            complete: function(data) {
                // Hide image container
                $(".loader123").hide();
            }
        });
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
                // if(SelectedQty<=BatchQty){
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

    function SubmitInventoryTransfer() {

        var selectedQtySum = document.getElementById('cs_selectedQtySum').value; // final Qty sum
        var item_BQty = parseFloat(document.getElementById('tb_quality').value).toFixed(6); // item available Qty
        var PostingDate = document.getElementById('it_postingDate').value;
        var DocDate = document.getElementById('it_documentDate').value;
        var ToWhs = document.getElementById('to_whs').value;

        // console.log(item_BQty);
        // console.log(selectedQtySum);


        if (selectedQtySum == item_BQty) { // Container selection Qty validation

            if (ToWhs != '') { // Item level To Warehouse validation

                if (PostingDate != '') { // Posting Date validation

                    if (DocDate != '') { // Document Date validation

                        // <!-- ---------------- form submit process start here ----------------- -->
                        var formData = new FormData($('#inventory_transfer_form')[0]); // form Id
                        formData.append("SC_SubIT_Btn", 'SubIT_Btn'); // submit btn Id
                        var error = true;

                        if (error) {
                            $.ajax({
                                url: 'ajax/kri_common-ajax.php',
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                beforeSend: function() {
                                    // Show image container
                                    // $(".loader123").show();
                                },
                                success: function(result) {
                                    //console.log(result);
                                    var JSONObject = JSON.parse(result);
                                    // console.log(JSONObject);
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
                                    // Hide image container
                                     $(".loader123").hide();
                                }
                            });
                        }
                        // <!-- ---------------- form submit process end here ------------------- -->
                    } else {
                        swal("Oops!", "Please Select A Document Date.", "error");
                    }

                } else {
                    swal("Oops!", "Please Select A Posting Date.", "error");
                }
            } else {
                swal("Oops!", "To Warehouse Mandatory.", "error");
            }

        } else {
            swal("Oops!", "Container Selected Qty Should Be Equal To Item Qty!", "error");
        }
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

    function getResultOutputDropdown(trcount) {

        //console.log('trcount------------',trcount);
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
                // This will log the result to the console
                for (let i = 0; i < trcount; i++) {

                    $('#ResultOutputByQCDept' + i).html(result); // dropdown set using class
                }
            },
            complete: function(data) {
                $(".loader123").hide();
            }
        });
    }

    function QC_StatusByAnalystDropdownWithSelectedOption(trcount) {
        var dataString = 'TableId=@SCS_QCPD1&Alias=QCStatus&action=QC_StatusByAnalystDropdownWithSelectedOption_Ajax';
        //console.log('trcount',trcount)
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

                        //alert("hii");
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
        });
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

    //     function getResultOutputDropdownWithSelectedOption(trcount) {
    //     $.ajax({ 
    //         type: "POST",
    //         url: 'ajax/common-ajax.php',
    //         data: {'action': "getResultOutputDropdownWithSelectedOption_Ajax"},

    //         beforeSend: function() {
    //             $(".loader123").show();
    //         },
    //         success: function(opt) {
    //             var JSONObject = JSON.parse(opt);
    //             console.log(JSONObject);  // This will log the parsed JSON object to the console
    //             let count = JSONObject.length;

    //             for (let i = 0; i < trcount; i++) {
    //                 const dropdown = document.getElementById('ResultOutputByQCDept' + i);

    //                 let selectedValue = $('#ResultOutputByQCDept_Old' + i).val();

    //                 let options = '';
    //                 for (let j = 0; j < count; j++) {
    //                     let selected = (selectedValue == JSONObject[j].Code) ? 'selected' : '';
    //                     options += `<option value="${JSONObject[j].Code}" ${selected}>${JSONObject[j].Name}</option>`;
    //                 }

    //                 dropdown.innerHTML = options;
    //                 OnChangeResultOutputByQCDept(i);
    //             }
    //         },
    //         complete: function(data) {
    //             $(".loader123").hide();
    //         }
    //     });
    // }

    function SelectionOfQC_Status(un_id) {
        // // <!-- -------- Get QC Status Table tbody > tr count start here ------------------------- -->
        //     // Get the tbody element by its ID
        //     var tbody = document.getElementById("qc-status-list-append");

        //     // Get all tr elements within this tbody
        //     var trElements = tbody.getElementsByTagName("tr");

        //     // Get the count of tr elements
        //     var trCount = trElements.length;

        //     // Log the count to the console
        //     console.log("Number of <tr> elements:", trCount);
        // // <!-- -------- Get QC Status Table tbody > tr count end here --------------------------- -->

        var tr_count = parseInt($('#tr-count').val());
        // console.log('tr_count',tr_count);
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
            $('#qCStsQty_' + un_id).val($('#qcD_BatchQty').val());
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

            var BatchQty = $('#qcD_BatchQty').val();
            var QCS_Qty=parseFloat(parseFloat(BatchQty)- parseFloat(sum)).toFixed(3);
            return QCS_Qty;
        // <!-- calculate Quantity for QC status tab end -------------------------------- -->
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

    function AllCheckCheckbox() {
        var mainCheckbox = document.querySelector('.itp_checkboxall');
        var checkboxes = document.querySelectorAll('#ContainerSelectionItemAppend .form-check-input');
        var hiddenFields = document.querySelectorAll('input[name="usercheckList[]"]');

        if (mainCheckbox.checked) {
            checkboxes.forEach((checkbox, index) => {
                checkbox.checked = true;
                hiddenFields[index].value = '1';
            });
        } else {
            checkboxes.forEach((checkbox, index) => {
                checkbox.checked = false;
                hiddenFields[index].value = '0';
            });
        }
        AllcalculateSum();
    }

    function AllcalculateSum() {
        var selectedQtyFields = document.querySelectorAll('input[name="SelectedQty[]"]');
        var hiddenFields = document.querySelectorAll('input[name="usercheckList[]"]');
        var total = 0;

        selectedQtyFields.forEach((field, index) => {
            if (hiddenFields[index].value === '1') {
                var value = parseFloat(field.value) || 0;
                total += value;
            }
        });

        document.getElementById('cs_selectedQtySum').value = total.toFixed(6);
    }
</script>

<script type="text/javascript">
    function ViewRPT_Print_Open(API_Name, FormTitle) {
        var DocEntry = $('#GRPODocEntry-re').val();
        if (DocEntry != '') {
            var PrintOutURL = `http://192.168.1.30:8082/API/SAP/${API_Name}?DocEntry=${DocEntry}`;
            document.getElementById("PrintQuarantine_Link").src = PrintOutURL;
        }

        document.getElementById('RPT_title').innerHTML = FormTitle;
    }

    function ViewRPT_Print_Close() {
        document.getElementById('RPT_title').innerHTML = '';
        document.getElementById("PrintQuarantine_Link").src = '';
    }
</script>
<!-- 2265 (12 July 2023) -->