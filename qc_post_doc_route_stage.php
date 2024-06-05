
<?php 
require_once './classes/function.php';
require_once './classes/kri_function.php';
$obj= new web();
$objKri=new webKri();

if(empty($_SESSION['Baroque_EmployeeID'])) {
  header("Location:login.php");
  exit(0);
}
// echo $RSQCPOSTDOCUMENTDETAILS;
// exit;
if(isset($_REQUEST['action']) && $_REQUEST['action'] =='list')
{
    $tdata=array();
    $tdata['FromDate']=date('Ymd', strtotime($_POST['fromDate']));
    $tdata['ToDate']=date('Ymd', strtotime($_POST['toDate']));
    $tdata['DocEntry']=trim(addslashes(strip_tags($_POST['DocEntry'])));

    // echo $RSQCPOSTDOCUMENTDETAILS;

    $getAllData=$obj->getSimpleIntimation($RSQCPOSTDOCUMENTDETAILS,$tdata);

  // echo "<pre>";
  // print_r($getAllData);
  // echo "</pre>";
  // exit();
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
                        <th>Sr. No </th>  
                        <th>Item View</th>
                        <th>DocEntry</th>
                        <th>WO No</th>
                        <th>WOEntry</th>
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Stage Name</th>
                        <th>Batch No</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Warehouse</th>
                       
                        <th>MFG Date</th>
                        <th>Expiry Date</th>
                        <th>Sample Intimation No</th>
                        <th>Sample Collection No</th>
                        <th>Location</th>
                        <th>Branch Name</th
                        
                       
                    </tr>
                </thead>
                <tbody>';
 
                if(count($getAllData)!='0'){
                    for ($i=$r_start; $i <$r_end ; $i++) { 
                        if(!empty($getAllData[$i]->DocEntry)){   //  this condition save to extra blank loop
                            $SrNo=$i+1;
                            // --------------- Convert String code Start Here ---------------------------
                                // if(empty($getAllData[$i]->WODate)){
                                //     $WODate='';
                                // }else{
                                //     $WODate=date("d-m-Y", strtotime($getAllData[$i]->WODate));
                                // }

                                if(empty($getAllData[$i]->MfgDate)){
                                    $MfgDate='';
                                }else{
                                    $MfgDate=date("d-m-Y", strtotime($getAllData[$i]->MfgDate));
                                }

                                if(empty($getAllData[$i]->ExpiryDate)){
                                    $ExpDate='';
                                }else{
                                    $ExpDate=date("d-m-Y", strtotime($getAllData[$i]->ExpiryDate));
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
                                <td class="desabled">'.$getAllData[$i]->WoEntry.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemCode.'</td>
                                <td class="desabled">'.$getAllData[$i]->ItemName.'</td>
                                <td class="desabled">'.$getAllData[$i]->Stage.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->BatchQty.'</td>
                                <td class="desabled">'.$getAllData[$i]->PackSize.'</td>
                                <td class="desabled">'.$getAllData[$i]->ToWhse.'</td>
                             
                                <td class="desabled">'.$MfgDate.'</td>
                                <td class="desabled">'.$ExpDate.'</td>

                                <td class="desabled">'.$getAllData[$i]->SampleIntimationNo.'</td>
                                <td class="desabled">'.$getAllData[$i]->SampleCollectionNo.'</td>

                                <td class="desabled">'.$getAllData[$i]->Loc.'</td>
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
<?php include 'models/qc_process/qc_post_doc_in_process_model.php' ?>

<div class="loader-top" style="height: 100%;width: 100%;background: #cccccc73;">
<div class="loader123" style="text-align: center;z-index: 10000;position: fixed;top: 0; left: 0;bottom: 0;right: 0;background: #cccccc73;">
<img src="loader/loader2.gif" style="width: 5%;padding-top: 288px !important;">
</div>
</div>

<style type="text/css">
    .input_disable{
        border: 1px solid #efefef !important;
        background-color: #efefef !important;
    }
    .input_disable{
        border: 1px solid #efefef !important;
        background-color: #efefef !important;
    }
</style>
<!--  // <th>Sr.No </th> 
                        // <th>Item View</th>
                        // <th>DocEntry</th>
                        // <th>WO No</th>
                        // <th>WOEntry</th>
                        // <th>Item Code</th>
                        // <th>Item Name</th>
                        // <th>Stage Name</th>
                        // <th>Batch No</th>
                        // <th>Quantity</th>
                        // <th>Unit</th>
                        // <th>Warehouse</th>
                        // <th>WO Date</th>
                        // <th>Mfg Date</th>
                        // <th>Expiry Date</th>
                        // <th>Sample Intimation No</th>
                        // <th>Sample Collection No</th>
                        // <th>Location</th>
                        // <th>Batch Name</th> -->
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
                                    <h4 class="mb-0"></h4>QC Post document (QC Check) - Route Stage

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">QC Post document (QC Check) - Route Stage</li>
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
                                        <h4 class="card-title mb-0">QC Post document (QC Check) - Route Stage</h4>  
                                       
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

                                                <div class="table-responsive" id="list-append">
                                                      <!-- <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                                <th>Item View</th>
                                                                <th>Sr.No </th>  
                                                                <th>WO No</th>
                                                                <th>WOEntry</th>
                                                                <th>Item Code</th>
                                                                <th>Item Name</th>
                                                                <th>Stage Name</th>
                                                                <th>Batch No</th>
                                                                <th>Quantity</th>
                                                                <th>Unit</th>
                                                                <th>Warehouse</th>
                                                                <th>WO Date</th>
                                                                <th>Mfg Date</th>
                                                                <th>Expiry Date</th>
                                                                <th>Sample Intimation No</th>
                                                                <th>Sample Collection No</th>
                                                                <th>Location</th>
                                                                <th>Batch Name</th>
                                                            </tr>
                                                        </thead>
                                                     <tbody>
                                                        <tr>
                                                            <td style="text-align: center;">
                                                                 <input class="form-check-input" type="radio" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>                               
                                                         </tr>

                                                         <tr>
                                                            <td style="text-align: center;">
                                                                 <input class="form-check-input" type="radio" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>                               
                                                         </tr>


                                                        <tr>
                                                            <td style="text-align: center;">
                                                                 <input class="form-check-input" type="radio" value="" id="flexCheckDefault" style="width: 17px;height: 17px;">
                                                            </td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>
                                                            <td class="desabled">1</td>                               
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

                        <br>

                           <div class="row" id="footerProcess">
                            <div class="col-lg-12">
                                <div class="card">
                                     <form role="form" class="form-horizontal" id="qcPostDocumentForm_route_stage" method="post">
                                <div class="card-body">

<input type="text" id="qc_post_doc_Routestage_DocEntry" name="qc_post_doc_Routestage_DocEntry">
<input type="text" id="qc_post_doc_Routestage_BPLId" name="qc_post_doc_Routestage_BPLId">
<input type="text" id="qc_post_doc_Routestage_LocCode" name="qc_post_doc_Routestage_LocCode">
<input type="text" id="qc_post_doc_Routestage_RMWQC" name="qc_post_doc_Routestage_RMWQC">

                                   <!-- qcPostDocumentForm -->
                                <div class="row">

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_wono" name="qc_post_doc_Routestage_wono" readonly>
                                                </div>
                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_woEntry" name="qc_post_doc_Routestage_woEntry" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                <div class="col-lg-8">
                                                     <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_ItemCode" name="qc_post_doc_Routestage_ItemCode" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                <div class="col-lg-8">
                                                     <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_ItemName" name="qc_post_doc_Routestage_ItemName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Generic Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_GenericName" name="qc_post_doc_Routestage_GenericName" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Cliam</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_LabelCliam" name="qc_post_doc_Routestage_LabelCliam" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Label Cliam UOM</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_LabelCliamUOM" name="qc_post_doc_Routestage_LabelCliamUOM" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Recieved Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_RecievedQty" name="qc_post_doc_Routestage_RecievedQty" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg By</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_MfgBy" name="qc_post_doc_Routestage_MfgBy" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Ref No</label>
                                                <div class="col-lg-8">
                                                     <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_RefNo" name="qc_post_doc_Routestage_RefNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Specification No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="number" id="qc_post_doc_Routestage_SpecificationNo" name="qc_post_doc_Routestage_SpecificationNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch No</label>
                                                <div class="col-lg-8">
                                                     <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_BatchNo" name="qc_post_doc_Routestage_BatchNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Batch Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_BatchSize" name="qc_post_doc_Routestage_BatchSize" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Mfg Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="qc_post_doc_Routestage_MfgDate" name="qc_post_doc_Routestage_MfgDate" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Expiry Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="qc_post_doc_Routestage_ExpiryDate" name="qc_post_doc_Routestage_ExpiryDate" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">WO Date</label>
                                                <div class="col-lg-8">
                                                     <input class="form-control" type="date" id="qc_post_doc_Routestage_WODate" name="qc_post_doc_Routestage_WODate">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-8 col-form-label mt-6" for="val-skill">Sample Intimation Route Stage No</label>
                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_SampleIntima" name="qc_post_doc_Routestage_SampleIntima" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-8 col-form-label mt-6" for="val-skill">Sample Collection Route Stage No</label>
                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_SampleColl" name="qc_post_doc_Routestage_SampleColl" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_SampleQty" name="qc_post_doc_Routestage_SampleQty" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retain Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_RetainQty" name="qc_post_doc_Routestage_RetainQty" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Sample Type</label>
                                                <div class="col-lg-8">
                                                    <select class="form-select" id="qc_post_doc_Routestage_SampleType" name="qc_post_doc_Routestage_SampleType">
                                                        <!-- <option>Regular</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Material Type</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_MaterialType" name="qc_post_doc_Routestage_MaterialType" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Pack Size</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_PackSize" name="qc_post_doc_Routestage_PackSize" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-8   col-form-label mt-6" for="val-skill">Release Material without QC</label>
                                                <div class="col-lg-4">
                                                    <select class="form-select desabled" id="qc_post_doc_Routestage_releaseMaterial" name="qc_post_doc_Routestage_releaseMaterial">
                                                       <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Doc No</label>
                                                <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_DocName" name="qc_post_doc_Routestage_DocName" readonly>
                                                    <!-- <select class="form-select desabled" name="qc_post_doc_Routestage_DocName" id="qc_post_doc_Routestage_DocName">
                                                       
                                                    </select> -->
                                                </div>

                                                <div class="col-lg-4">
                                                     <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_DocNo" name="qc_post_doc_Routestage_DocNo" readonly>
                                                </div>

                                               <!--  <div class="col-lg-2">
                                                     <input class="form-control desabled" type="text" id="" name="" readonly>
                                                </div> -->
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Posting Date</label>
                                                <div class="col-lg-8">
                                                     <input class="form-control" type="date" id="qc_post_doc_Routestage_PostingDate" name="qc_post_doc_Routestage_PostingDate" >
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="qc_post_doc_Routestage_AnalysisDate" name="qc_post_doc_Routestage_AnalysisDate">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">No. Container</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_NoContainer" name="qc_post_doc_Routestage_NoContainer" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">QC Test type</label>
                                                <div class="col-lg-8">
                                                    <select class="form-select desabled" name="qc_post_doc_Routestage_QCTesttype" id="qc_post_doc_Routestage_QCTesttype">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Stage</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_stage" name="qc_post_doc_Routestage_stage" readonly>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Branch</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_branch" name="qc_post_doc_Routestage_branch" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Location</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_Location" name="qc_post_doc_Routestage_Location" readonly>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Valid Up To</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="qc_post_doc_Routestage_ValidUpTo" name="qc_post_doc_Routestage_ValidUpTo">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">A/R No.</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_ARNo" name="qc_post_doc_Routestage_ARNo" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        
                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Gate Entry No</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_GateEntryNo" name="qc_post_doc_Routestage_GateEntryNo" readonly>
                                                </div>

                                                 <!-- <div class="col-lg-4">
                                                    <input class="form-control desabled" type="text" id="qc_post_doc_Routestage_GateEntryNo1" name="qc_post_doc_Routestage_GateEntryNo1" readonly>
                                                </div> -->
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Release Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="qc_post_doc_Routestage_ReleaseDate" name="qc_post_doc_Routestage_ReleaseDate">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">Retest Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="qc_post_doc_Routestage_RetestDate" name="qc_post_doc_Routestage_RetestDate">
                                                </div>
                                            </div>
                                        </div>

                                   </div>
                                </div>
                              <br>


                            <div class="row">
                            <div class="col-xl-12">
                                <div class="card">                                
                                    <div class="card-body">
                                         <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">

                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#general_data8" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">General Data</span>    
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#qc_status8" role="tab">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">QC Status</span>    
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#attatchment8" role="tab">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Attatchment</span>    
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->

                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="general_data8" role="tabpanel">
                                        
                                                <div class="table-responsive qc_list_table table_item_padding" id="list2">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                           

                                                            <!-- <tr>
                                                                <th>Sr. No</th>
                                                                <th>Parameter Code</th>
                                                                <th>Parameter Name </th>  
                                                                <th>Standard</th>
                                                                <th>Release</th>
                                                                <th>Parameter Data Type</th> 
                                                                <th>Descriptive Details</th> 
                                                                <th>Logical</th>
                                                                <th>Lower Min</th> 
                                                                <th>Lower Max</th> 
                                                                <th>Upper Min</th> 
                                                                <th>Upper Max</th> 
                                                                <th>Mean</th>
                                                                <th>Lower Min - Result</th>
                                                                <th>Lower Max - Result</th>
                                                                <th>Upper Min - Result</th> 
                                                                <th>Upper Max - Result</th>
                                                                <th>Mean</th>
                                                                <th>Result Output</th>
                                                                <th>Remarks</th>
                                                                <th>QC Status by Analyst</th>
                                                                <th>Test Method</th>
                                                                <th>Material Type</th>
                                                                <th>User Text-1</th>
                                                                <th>User Text-2</th>
                                                                <th>User Text-3</th>
                                                                <th>User Text-4</th>
                                                                <th>User Text-5</th>
                                                                <th>QC Status Result</th>
                                                                <th>UOM</th> 
                                                                <th>Retest</th> 
                                                                <th>Stability</th> 
                                                                <th>External Sample</th>
                                                                <th>Applicable For As</th>
                                                                <th>Applicable For LOD</th> 
                                                                <th>Analysis By</th>
                                                                <th>Analyst Remark</th>
                                                                <th>Instrument Code</th> 
                                                                <th>Instrument Name</th>
                                                                <th>Star Date</th>
                                                                <th>Start Time</th>
                                                                <th>End Date</th>
                                                                <th>End Time</th> 
                                                            </tr> -->
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
                                                     <tbody id="qc-post-general-data-list-append_">
                                                        

                                                       </tbody> 

                                                   </table>
                                               </div> 
                                            <!--end table-->

                                         </div> <!-- tab_pane samp details end -->

                                           

                                             <div class="tab-pane" id="qc_status8" role="tabpanel">

                                                <div class="table-responsive" id="list">
                                                    <table id="tblItemRecord" class="table sample-table-responsive table-bordered" style="">
                                                          <thead class="fixedHeader1">
                                                                <tr>
                                                                    <th>Sr. No</th>
                                                                    <th>Status</th>
                                                                    <th>Quantity</th>
                                                                    <th>IT No</th>
                                                                    <!-- <th>Release Time</th> -->
                                                                    <th>Done By</th>
                                                                    <!-- <th>Attatchment 1</th> 
                                                                    <th>Attatchment 2</th> 
                                                                    <th>Attatchment 3</th>   -->
                                                                    <!-- <th>Deviation Date</th> -->
                                                                    <!-- <th>Deviation No</th> -->
                                                                    <!-- <th>Deviation Reason</th> -->
                                                                    <th>Remarks</th>
                                                                </tr>
                                                            </thead>
                                                         <tbody id="qc-status-list-append_">
                                                           <!--  <tr>
                                                                <td></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                             </tr> -->
                                                           </tbody> 

                                                       </table>
                                               </div><!--table responsive end-->     

                                            </div> <!-- tab_pane qc status end -->




                                            <div class="tab-pane" id="attatchment8" role="tabpanel">

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
                                                         <tbody id="qc-attach-list-append_">
                                                            <!-- <tr>
                                                                <td class="desabled">
                                                                1
                                                                </td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td class="desabled"><input class="border_hide desabled" type="text" id="" name="" class="form-control" readonly></td>
                                                                <td><input class="border_hide" type="text" id="" name="" class="form-control"></td>
                                                             </tr> -->
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
                                                                    <input class="form-control" type="text" id="qc_post_doc_Routestage_AssayPotency" name="qc_post_doc_Routestage_AssayPotency" onfocusout="CalculatePotency();" value="0.000000">
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">LOD/Water %</label>
                                                                <div class="col-lg-8">
                                                                     <input class="form-control" type="text" id="qc_post_doc_Routestage_LODWater" name="qc_post_doc_Routestage_LODWater" onfocusout="CalculatePotency();" value="0.000000">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-7 col-form-label mt-6" for="val-skill">Assay Calculation Based On</label>
                                                                <div class="col-lg-5">
                                                                    <select class="form-select" id="qc_post_doc_Routestage_AssayCalc" name="qc_post_doc_Routestage_AssayCalc" >
                                                                        <!-- <option>On As is Basis</option> -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Potency</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="qc_post_doc_Routestage_Potency" name="qc_post_doc_Routestage_Potency" readonly>
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Factor</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="number" id="qc_post_doc_Routestage_Factor" name="qc_post_doc_Routestage_Factor">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Compiled By</label>
                                                                <div class="col-lg-8">
                                                                    <select class="form-control" id="qc_post_doc_Routestage_CompiledBy" name="qc_post_doc_Routestage_CompiledBy"></select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Checked By</label>
                                                                <div class="col-lg-8">
                                                                    <select class="form-control" id="qc_post_doc_Routestage_CheckedBy" name="qc_post_doc_Routestage_CheckedBy"></select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Analysis By</label>
                                                                <div class="col-lg-8">
                                                                    <select class="form-control" id="qc_post_doc_Routestage_AnalysisBy" name="qc_post_doc_Routestage_AnalysisBy"></select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                         <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">No Of Container</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" id="qc_post_doc_Routestage_NoOfContainer1" name="qc_post_doc_Routestage_NoOfContainer1">
                                                                </div>
                                                                <!-- <div class="col-lg-4">
                                                                    <input class="form-control" type="text" id="qc_post_doc_Routestage_NoOfContainer2" name="qc_post_doc_Routestage_NoOfContainer2">
                                                                </div> -->

                                                            </div>
                                                        </div>


                                                        <div class="col-xl-3 col-md-6">
                                                            <div class="form-group row mb-2">
                                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Remarks</label>
                                                                <div class="col-lg-8">
                                                                    <textarea class="form-control" rows="1" id="qc_post_doc_Routestage_Remarks" name="qc_post_doc_Routestage_Remarks"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                </div>    
                                            </div>  <!--general data footer end-->
                                            
                                            <!-- -------footer button---- -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="d-flex flex-wrap gap-2">
                                                             <!-- Toggle States Button -->
                                                             <button type="button" class="btn btn-primary" id="addQcPostDocumentBtn_RouteStage" name="addQcPostDocumentBtn_RouteStage" onclick="return add_qc_post_document();">Add</button>
                                                             <!-- <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Add</button> -->

                                                             <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off" data-bs-dismiss="modal" aria-label="Close">Cancel</button>

                                                             <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".inventory_transfer" data-bs-toggle="button" autocomplete="off">Inventory Transfer</button>

                                                              <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Update Result</button> -->
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
                                                    <!--row end-->
                                                    <!-- ------footer button end---- -->
                                                    <!-- tfoot end -->
                                              </div> <!-- tab content end -->
                                            </div>
                                       
                                        </div><!-- end card-body -->
                                     </div><!-- end card -->
                                 </div><!-- end col -->
                              </div><!--row closed-->
                                                 
            
                            </div>
                                    <!-- end card body -->

                                </form>
                             
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

           <style type="text/css">
            body[data-layout=horizontal] .page-content {
                padding: 20px 0 0 0;
                padding: 40px 0 60px 0;
            }
           </style>


           <script type="text/javascript">
               
    // <!-- -------------- Direct called function diclear Start Here --------------------------------
        $(".loader123").hide(); // loader default hide script
        $("#footerProcess").hide(); // Afer Doc Selection Process default hide script
    // <!-- -------------- Direct called function diclear End Here ----------------------------------

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
            success: function(result)
            {   
                $('#list-append').html(result);
            },
            complete:function(data){
                $(".loader123").hide();
            }
       });
    });

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
            // Show image container
            $(".loader123").show();
            },
            success: function(result)
            {  
            $("#footerProcess").hide();
            $('#list-append').html(result);
            },
            complete:function(data){
            // Hide image container
            $(".loader123").hide();
            }
        });
}


    function selectedRecord(DocEntry)
    {
        $.ajax({ 
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data:{'DocEntry':DocEntry,'action':"QCPostdocumentQCCheckRouteStage_Selected_row"},

            beforeSend: function(){
                $(".loader123").show();
            },
            success: function(result)
            {
                $("#footerProcess").show(); // Afer Doc Selection Process show script

                var JSONObjectAll = JSON.parse(result);

                 var JSONObject=JSONObjectAll['SampleCollDetails']; // sample collection details var
                // console.log('dd=>',JSONObject);
                    $(`#qc-post-general-data-list-append_`).html(JSONObjectAll['general_data']); // Extra Issue Table Tr tag append here
                    $(`#qc-status-list-append_`).html(JSONObjectAll['qcStatus']); // External Issue Table Tr tag append here
                    $(`#qc-attach-list-append_`).html(JSONObjectAll['qcAttach']);

                   // console.log(JSONObject);

                // $(`#SIRSU_ReceiptNo`).val(JSONObject[0]['ReceiptNo']);
                // $(`#SIRSU_ReceiptEntry`).val(JSONObject[0]['ReceiptEntry']);
                // $('#SIRSU_DocNo').val(JSONObject[0]['DocNum']);
                $(`#qc_post_doc_Routestage_wono`).val(JSONObject[0]['WONo']);
                $(`#qc_post_doc_Routestage_woEntry`).val(JSONObject[0]['WOEntry']);
                // $(`#SIRSU_DocEntry`).val(JSONObject[0]['DocEntry']);
                // $(`#SIRSU_RouteStage`).val(JSONObject[0]['RouteStage']);
                // $(`#SIRSU_SampleType`).val(JSONObject[0]['SampleType']);
                // $(`#SIRSU_TrBy`).val(JSONObject[0]['TRBy']);
                $(`#qc_post_doc_Routestage_ItemCode`).val(JSONObject[0]['ItemCode']);
                $(`#qc_post_doc_Routestage_ItemName`).val(JSONObject[0]['ItemName']);
                $('#qc_post_doc_Routestage_GenericName').val(JSONObject[0]['GenericName']);
                $('#qc_post_doc_Routestage_LabelCliam').val(JSONObject[0]['LabelClaim']);
                
                $(`#qc_post_doc_Routestage_LabelCliamUOM`).val(JSONObject[0]['LabelClaimUOM']);
                $(`#qc_post_doc_Routestage_RecievedQty`).val(JSONObject[0]['RecQty']);
                $('#qc_post_doc_Routestage_MfgBy').val(JSONObject[0]['MfgBy']);
                $(`#qc_post_doc_Routestage_RefNo`).val(JSONObject[0]['RefNo']);
                $(`#qc_post_doc_Routestage_SpecificationNo`).val(JSONObject[0]['SpecNo']);
                // $(`#SIRSU_RetainQty`).val(JSONObject[0]['RetainQty']);
                // $(`#SIRSU_Unit`).val(JSONObject[0]['unit']);
                $(`#qc_post_doc_Routestage_BatchNo`).val(JSONObject[0]['BatchNo']);
                $(`#qc_post_doc_Routestage_BatchSize`).val(JSONObject[0]['BatchQty']);
                $(`#qc_post_doc_Routestage_SampleIntima`).val(JSONObject[0]['SampleIntimationNo']);
                $(`#qc_post_doc_Routestage_SampleColl`).val(JSONObject[0]['SampleCollectionNo']);
                $(`#qc_post_doc_Routestage_SampleQty`).val(JSONObject[0]['SampleQty']);
                $(`#qc_post_doc_Routestage_RetainQty`).val(JSONObject[0]['RetainQty']);


                $(`#qc_post_doc_Routestage_SampleType`).val(JSONObject[0]['SamType']);
                $(`#qc_post_doc_Routestage_MaterialType`).val(JSONObject[0]['MatType']);
                $(`#qc_post_doc_Routestage_PackSize`).val(JSONObject[0]['PackSize']);
                $(`#qc_post_doc_Routestage_NoContainer`).val(JSONObject[0]['NoCont']);
                // $(`#SIRSU_Location`).val(JSONObject[0]['Location']);
                $(`#qc_post_doc_Routestage_QCTesttype`).val(JSONObject[0]['QCTType']);
                $(`#qc_post_doc_Routestage_stage`).val(JSONObject[0]['Stage']);
                $(`#qc_post_doc_Routestage_branch`).val(JSONObject[0]['Branch']);
                $(`#qc_post_doc_Routestage_Location`).val(JSONObject[0]['Loc']);

                $(`#qc_post_doc_Routestage_ARNo`).val(JSONObject[0]['ARNo']);
                $(`#qc_post_doc_Routestage_GateEntryNo`).val(JSONObject[0]['GateENo']);

                $(`#qc_post_doc_Routestage_BPLId`).val('');
                $(`#qc_post_doc_Routestage_LocCode`).val('');
                $(`#qc_post_doc_Routestage_RMWQC`).val(JSONObject[0]['RMWQC']);
                 $(`#qc_post_doc_Routestage_DocEntry`).val(JSONObject[0]['DocEntry']);
                
                // ValidUpto
                // $(`#qc_post_doc_Routestage_ValidUpTo`).val(JSONObject[0]['ValidUpto']);

                // <!-- ------------ Posting Date Start Here --------------------- -->
                    // PostingDate
                    var PostingDateOG = JSONObject[0]['PostingDate'];
                    if(PostingDateOG!=''){
                        let [day, month, year] = PostingDateOG.split(" ")[0].split("-");
                        let ExpiryDate = `${year}-${month}-${day}`;

                        $(`#qc_post_doc_Routestage_PostingDate`).val(ExpiryDate);
                    }
                // <!-- ------------ Posting Date End Here ----------------------- -->

                // <!-- ----------- ValidUpto Start Here ----------------------- -->
                    var validUpToOG = JSONObject[0]['ValidUpto'];
                    if(validUpToOG!=''){
                        // validUpTo = validUpToOG.split(' ')[0];
                        // $(`#qc_post_doc_Routestage_validUpTo`).val(validUpTo);

                        let [day, month, year] = validUpToOG.split(" ")[0].split("-");
                        let ExpiryDate = `${year}-${month}-${day}`;

                        $(`#qc_post_doc_Routestage_ValidUpTo`).val(ExpiryDate);
                    }
                // <!-- ----------- ValidUpto End Here ------------------------- -->

                // <!-- ----------- MfgDate Start Here ----------------------- -->
                    var mfgDateOG = JSONObject[0]['MfgDate'];
                    if(mfgDateOG!=''){
                        // MfgDate = mfgDateOG.split(' ')[0];
                        // $(`#qc_post_doc_Routestage_MfgDate`).val(MfgDate);

                        let [day, month, year] = mfgDateOG.split(" ")[0].split("-");
                        let ExpiryDate = `${year}-${month}-${day}`;

                        $(`#qc_post_doc_Routestage_MfgDate`).val(ExpiryDate);
                    }
                // <!-- ----------- MfgDate End Here ------------------------- -->

                // <!-- ----------- Expiry Date Start Here ----------------------- -->
                    // var expiryDateOG = JSONObject[0]['ExpiryDate'];
                    // if(mfgDateOG!=''){
                    //     ExpiryDate = expiryDateOG.split(' ')[0];
                    //     $(`#qc_post_doc_Routestage_ExpiryDate`).val(ExpiryDate);
                    // }
                // <!-- ----------- Expiry Date End Here --------------------------- -->

                // <!-- ----------- Expiry Date Start Here ----------------------- -->
                    var ExpiryDateOG = JSONObject[0].ExpiryDate;
                    if(ExpiryDateOG!=''){
                        let [day, month, year] = ExpiryDateOG.split(" ")[0].split("-");
                        let ExpiryDate = `${year}-${month}-${day}`;

                        $(`#qc_post_doc_Routestage_ExpiryDate`).val(ExpiryDate);
                    }
                // <!-- ----------- Expiry Date End Here ------------------------- -->

                // <!-- ----------- WO Date Start Here ----------------------- -->
                    // var woDateOG = JSONObject[0]['WODate'];
                    // if(woDateOG!=null){
                    //     woDate = woDateOG.split(' ')[0];
                    //     $(`#qc_post_doc_Routestage_WODate`).val(woDate);
                    // }
                // <!-- ----------- WO Date End Here --------------------------- -->

                // // <!-- ----------- ReleaseDate Start Here ----------------------- -->
                    var releaseDateDateOG = JSONObject[0]['RelDate'];
                    if(releaseDateDateOG =='' || releaseDateDateOG==null){
                    }else{
                        releaseDateDateOG = releaseDateDateOG.split(' ')[0];
                        $(`#qc_post_doc_Routestage_ReleaseDate`).val(releaseDateDateOG);
                    }
                // // <!-- ----------- ReleaseDate End Here ------------------------- -->

                // <!-- ----------- retest Date Start Here ----------------------- -->
                    var retestDateDateOG = JSONObject[0]['ReTsDt'];
                    if(retestDateDateOG =='' || retestDateDateOG==null){
                    }else{
                        retestDateDateOG = retestDateDateOG.split(' ')[0];
                        $(`#qc_post_doc_Routestage_RetestDate`).val(retestDateDateOG);
                    }
                // <!-- ----------- retest Date End Here ------------------------- -->

                // // <!-- ----------- GateEnrty Date Start Here ----------------------- -->
                //     var gateEntryDateOG = JSONObject[0]['GateEntryDate'];
                //     if(gateEntryDateOG !=''){
                //         GateEntryDateOG = gateEntryDateOG.split(' ')[0];
                //         $(`#SIRSU_GateEntryDate`).val(GateEntryDateOG);
                //     }
                // // <!-- ----------- GateEnrty Date End Here ------------------------- -->

                // //  <!-- --------------- Cancelled Checkbox Set Value Start Here ---------------- -->
                //     var Canceled=JSONObject[0]['Canceled'];

                //     if(Canceled=='N'){
                //         document.getElementById("SIRSU_StatusChekBox").checked = false; // Uncheck
                //         $(`#SIRSU_StatusChekBox_val`).val(Canceled);
                //     }else{
                //         document.getElementById("SIRSU_StatusChekBox").checked = true; // Check
                //         $(`#SIRSU_StatusChekBox_val`).val(Canceled);
                //     }
                // //  <!-- --------------- Cancelled Checkbox Set Value end Here ---------------- -->

                // // <!-- --------------------- Hidden Field Start Here ------------------------- -->
                //     $(`#SIRSU_LineNum`).val(JSONObject[0]['LineNum']);
                //     $(`#SIRSU_LocId`).val(JSONObject[0]['LocId']);
                //     $(`#SIRSU_QtyPerCont`).val(JSONObject[0]['QtyPerCont']);
                //     $(`#SIRSU_BPLId`).val(JSONObject[0]['BPLId']);
                //     $(`#SIRSU_WareHouse`).val(JSONObject[0]['WareHouse']);
                // // <!-- --------------------- Hidden Field End Here --------------------------- -->

                $(`#qc_post_doc_Routestage_DocName`).val(JSONObject[0]['Series']);
                $(`#qc_post_doc_Routestage_DocNo`).val(JSONObject[0]['DocNum']);



                // getSeriesData(JSONObject[0]['Series']) // DocName By using API to get dropdown 
                QC_StatusByAnalystDropdownWithSelectedOption(JSONObjectAll.count);                
                getResultOutputDropdownWithSelectedOption(JSONObjectAll.count);
                GetRowLevelAnalysisByDropdownWithSelectedOption(JSONObjectAll.count);
                // QC_StatusByAnalystDropdown(JSONObjectAll.count);
                                    // getResultOutputDropdown(JSONObjectAll.count);
            },
            complete:function(data){
                SampleTypeDropdown();
                // $(".loader123").hide();
            }
        }); 
    }

function SampleTypeDropdown(){
// http://10.80.4.55:8081/api/sap/VALIDVALUES?TableId=@SCS_QCRSTAGE&Alias=PC_SamType
        var dataString ='TableId=@SCS_QCRSTAGE&Alias=PC_SamType&action=dropdownMaster_ajax';
        $.ajax({
            type: "POST",
            url: 'ajax/kri_production_common_ajax.php',
            data: dataString,
            cache: false,

            beforeSend: function(){
                // Show image container
                $(".loader123").show();
            },
            success: function(result){
                var JSONObject = JSON.parse(result);
                // console.log(JSONObject);
                $('#qc_post_doc_Routestage_SampleType').html(JSONObject);
            },
            complete:function(data){
                // Hide image container
                // $(".loader123").hide();
                // getSeriesDropdown();
                // releaseMaterialwithoutQC();
                QC_TestTypeDropdown();
            }
        });
    }

    // function getSeriesDropdown()
    // {
    //     var TrDate= $('#qc_post_doc_Routestage_PostingDate').val();
    //     var dataString ='TrDate='+TrDate+'&ObjectCode=SCS_QCRSTAGE&action=getSeriesDropdown_ajax';
    //     $.ajax({
    //         type: "POST",
    //         url: 'ajax/kri_production_common_ajax.php',
    //         data: dataString,
    //         cache: false,
    //         beforeSend: function(){
    //             // Show image container
    //             $(".loader123").show();
    //         },
    //         success: function(result){
    //             var SeriesDropdown = JSON.parse(result);
    //             // console.log(SeriesDropdown);
    //             $('#qc_post_doc_Routestage_DocName').html(SeriesDropdown);
    //             selectedSeries(); // call Selected Series Single data function
    //         },
    //         complete:function(data){
    //           // alert('hiiii');
    //             // Hide image container
    //             // $(".loader123").hide();
    //         }
    //     }); 
    // }

    // function selectedSeries(){

    //     var TrDate= $('#qc_post_doc_Routestage_PostingDate').val();
    //     var Series=document.getElementById('qc_post_doc_Routestage_DocName').value;
    //     var dataString ='Series='+Series+'&ObjectCode=SCS_QCRSTAGE&action=getSeriesSingleData_ajax';
    //     $.ajax({
    //         type: "POST",
    //         url: 'ajax/kri_production_common_ajax.php',
    //         data: dataString,
    //         cache: false,
    //         beforeSend: function(){
    //             // Show image container
    //             $(".loader123").show();
    //         },
    //         success: function(result)
    //         {
    //             var JSONObject = JSON.parse(result);
    //             var NextNumber=JSONObject[0]['NextNumber'];
    //             var Series=JSONObject[0]['Series'];
    //             $('#qc_post_doc_Routestage_DocNo').val(Series);
    //             $('#NextNumber').val(NextNumber);
    //         },
    //         complete:function(data){
    //            // alert('hiiii2');
    //             // $(".loader123").hide();
    //             releaseMaterialwithoutQC();
    //         }
    //     }); 
    // }

//     function releaseMaterialwithoutQC(){
    
//      var dataString ='&action=releaseMaterial_dropdownMaster_ajax';
//         $.ajax({
//             type: "POST",
//             url: 'ajax/kri_production_common_ajax.php',
//             data: dataString,
//             cache: false,

//             beforeSend: function(){
//                 // Show image container
//                 $(".loader123").show();
//             },
//             success: function(result){
//                 var JSONObject = JSON.parse(result);
//                 // console.log(JSONObject);
//                 $('#qc_post_doc_Routestage_releaseMaterial').html(JSONObject);
//             },
//             complete:function(data){
//                 // Hide image container
//                 // $(".loader123").hide();
//                 // getSeriesDropdown();
//                 QC_TestTypeDropdown();
//             }
//         });

// }

function QC_TestTypeDropdown(){

        var dataString ='TableId=@SCS_QCRSTAGE&Alias=PC_QCTType&action=dropdownMaster_ajax';

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

                $('#qc_post_doc_Routestage_QCTesttype').html(JSONObject);
            },
            complete:function(data){
                // Hide image container
                // $(".loader123").hide();
                qc_assayCalculationDropdown();
            }
        });
    }


function qc_assayCalculationDropdown(){
// $(document).ready(function(){
  // http://10.80.4.55:8081//api/sap/VALIDVALUES?TableId=@SCS_QCRSTAGE&Alias=PC_AsyCal
            var dataString ='action=qc_FGassay_Calculation_Based_On_routStage_ajax';
            $.ajax({  
                type: "POST",  
                url: 'ajax/kri_production_common_ajax.php',  
                data: dataString,  
                beforeSend: function(){
                // Show image container
                $(".loader123").show();
                },
                success: function(result){ 
                    // console.log(result);
                    $('#qc_post_doc_Routestage_AssayCalc').html(result);
                },
                complete:function(data){
                // Hide image container
                // $(".loader123").hide();
                Compiled_ByDropdown();
            }
           });
    }

         function Compiled_ByDropdown(){
// $(document).ready(function(){
            var dataString ='action=Compiled_By_dropdown_ajax';
            $.ajax({  
                type: "POST",  
                url: 'ajax/kri_production_common_ajax.php',  
                data: dataString, 
                 beforeSend: function(){
                // Show image container
                $(".loader123").show();
                },
                success: function(result){ 
                    // console.log(result);
                    $('#qc_post_doc_Routestage_CompiledBy').html(result);
                    $('#qc_post_doc_Routestage_CheckedBy').html(result);
                    $('#qc_post_doc_Routestage_AnalysisBy').html(result);
                },
                complete:function(data){
                // Hide image container
                // alert('hiii3');
                    getQcStatusDropodwn(1);
                    getDoneByDroopdown(1);
                $(".loader123").hide();
                // Compiled_ByDropdown();
            }
           });
        // })
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

     function CalculatePotency()
        {
            // <!-- -----------  LoD / Water Value Preparing Start Here ------------------------------- -->
                var lod_waterOG=document.getElementById('qc_post_doc_Routestage_LODWater').value;

                if((parseFloat(lod_waterOG).toFixed(6))<='0.000000' || lod_waterOG=='' || lod_waterOG==null){
                    var lod_water='0.000000';
                    $('#qc_post_doc_Routestage_LODWater').val(lod_water);
                }else{
                    var lod_water=parseFloat(lod_waterOG).toFixed(6);
                    $('#qc_post_doc_Routestage_LODWater').val(lod_water);
                }
            // <!-- -----------  LoD / Water Value Preparing End Here --------------------------------- -->

            // <!-- -----------  AssayPotency Value Preparing Start Here ------------------------------- -->
                var assayPotencyOG=document.getElementById('qc_post_doc_Routestage_AssayPotency').value;

                if((parseFloat(assayPotencyOG).toFixed(6))<='0.000000' || assayPotencyOG=='' || assayPotencyOG==null){
                    var assayPotency='0.000000';
                    $('#qc_post_doc_Routestage_AssayPotency').val(assayPotency);
                }else{
                    var assayPotency=parseFloat(assayPotencyOG).toFixed(6);
                    $('#qc_post_doc_Routestage_AssayPotency').val(assayPotency);
                }
            // <!-- -----------  AssayPotency Value Preparing End Here --------------------------------- -->

            var Potency=((100- parseFloat(lod_water))/100)*parseFloat(assayPotency); // Calculation
            $('#qc_post_doc_Routestage_Potency').val(parseFloat(Potency).toFixed(6)); // Set Potency calculated val
        }   

 // function getResultOutputDropdown(trcount){

 //            $.ajax({ 
 //                type: "POST",
 //                url: 'ajax/kri_production_common_ajax.php',
 //                data:{'action':"ResultOutputDropdown_ajax"},

 //                beforeSend: function(){
 //                    // Show image container
 //                    $(".loader123").show();
 //                },
 //                success: function(result)
 //                {
 //                    for (let i = 0; i < trcount; i++) {
 //                        $('.dropdownResutl'+i).html(result); // dropdown set using Id                            
 //                    }
 //                },
 //                complete:function(data){
 //                    // Hide image container
 //                    // $(".loader123").hide();
 //                }
 //            });         
 //        }


        // function QC_StatusByAnalystDropdown(trcount){

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
        //             for (let i = 0; i < trcount; i++) {
        //                 $('.qc_statusbyab'+i).html(JSONObject); // dropdown set using Class                            
        //             }
        //         },
        //         complete:function(data){
        //             // Hide image container
        //             // $(".loader123").hide();
        //         }
        //     });
        // }

function QC_StatusByAnalystDropdownWithSelectedOption(trcount) {
    var dataString ='TableId=@SCS_QCPD1&Alias=QCStatus&action=QC_StatusByAnalystDropdownWithSelectedOption_Ajax';

    $.ajax({
        type: "POST",
        url: 'ajax/common-ajax.php',
        data: dataString,
        cache: false,
        beforeSend: function(){
            $(".loader123").show();
        },
        success: function(opt) {
            var JSONObject = JSON.parse(opt);
                // console.log('JSONObject=>', JSONObject);

            let count = JSONObject.length;
                // console.log('count=>', count);


            for (let i = 0; i < trcount; i++) {
                const dropdown = document.getElementById('qC_status_by_analyst' + i);

                let selectedValue =$('#qC_status_by_analyst_Old' + i).val();
                   
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
    });
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

                let selectedValue =$('#ResultOutputByQCDept_Old' + i).val();
                   
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

                let selectedValue =$('#AnalysisBy_Old' + i).val();
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


         function CalculateResultOut(un_id){

            var lowMin=document.getElementById('LowMin'+un_id).value;
            var uppMax=document.getElementById('UppMax'+un_id).value;
            var UOM=document.getElementById('GDUOM'+un_id).value;

            var lowMinResOG=document.getElementById('lower_min_result'+un_id).value; // this value enter by user

            var lowMinRes=parseFloat(lowMinResOG).toFixed(6); // this value enter by user

            if(lowMinRes!=''){
                $('#lower_min_result'+un_id).val(lowMinRes);

                $('#remarks'+un_id).val(lowMinResOG+' '+UOM);

                if(parseFloat(lowMinRes)>=parseFloat(lowMin) && parseFloat(lowMinRes)<=parseFloat(uppMax)){

                    $('.dropdownResutl'+un_id).val('PASS');    
                    $('#ResultOutTd'+un_id).attr('style', 'background-color: #c7f3c7');
                    $('.dropdownResutl'+un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
                
                    setSelectedIndex(document.getElementsByClassName("dropdownResutl"+un_id),"PASS");
                }else{

                    $('.dropdownResutl'+un_id).val('FAIL');
                    $('#ResultOutTd'+un_id).attr('style', 'background-color: #f8a4a4');
                    $('.dropdownResutl'+un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');

                    setSelectedIndex(document.getElementsByClassName("dropdownResutl"+un_id),"FAIL");
                }
            }
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

    //   function SelectedQCStatus(un_id){

    //     var QC_StatusByAnalyst=document.getElementById('qC_status_by_analyst'+un_id).value;

        
    //     if(QC_StatusByAnalyst=='Complies'){

    //         $('#QC_StatusByAnalystTd'+un_id).attr('style', 'background-color: #c7f3c7');
    //         $('#QC_StatusByAnalyst'+un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
        
    //     }else if(QC_StatusByAnalyst=='Non Complies'){

    //         $('#QC_StatusByAnalystTd'+un_id).attr('style', 'background-color: #f8a4a4');
    //         $('#QC_StatusByAnalyst'+un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
        
    //     }else {

    //         $('#QC_StatusByAnalystTd'+un_id).attr('style', 'background-color: #ffffff');
    //         $('#QC_StatusByAnalyst'+un_id).attr('style', 'background-color: #ffffff;border:1px solid #ffffff !important;');
        
    //     }

    // }

    function SelectedQCStatus(un_id){
        var QC_StatusByAnalyst=document.getElementById('qC_status_by_analyst'+un_id).value;
        // console.log('QC_StatusByAnalyst=>', QC_StatusByAnalyst);

        if(QC_StatusByAnalyst=='Complies'){
            $('#QC_StatusByAnalystTd'+un_id).attr('style', 'background-color: #c7f3c7');
            $('#qC_status_by_analyst'+un_id).attr('style', 'background-color: #c7f3c7;border:1px solid #c7f3c7 !important;');
        }else if(QC_StatusByAnalyst=='Non Complies'){
            $('#QC_StatusByAnalystTd'+un_id).attr('style', 'background-color: #f8a4a4');
            $('#qC_status_by_analyst'+un_id).attr('style', 'background-color: #f8a4a4;border:1px solid #f8a4a4 !important;');
        }else {
            $('#QC_StatusByAnalystTd'+un_id).attr('style', 'background-color: #ffffff');
            $('#qC_status_by_analyst'+un_id).attr('style', 'background-color: #ffffff;border:1px solid #ffffff !important;');
        }
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

    function add_qc_post_document(){

        var formData = new FormData($('#qcPostDocumentForm_route_stage')[0]);  // Form Id
        formData.append("addQcPostDocumentBtn_RouteStage",'addQcPostDocumentBtn_RouteStage');  // Button Id
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
         },
                complete:function(data){
                // Hide image container
                $(".loader123").hide();
                }
        });
}

</script>
<!-- 1911 (03 June 2024) -->