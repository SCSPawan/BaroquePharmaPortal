<?php include 'include/header.php' ?>

 <style type="text/css">
.mt-6{margin-top: -6px !important;}
.FreightInput {width: 100px;border: transparent;}
.FreightInput:focus {border: transparent;outline: none;}
 </style>
 <!--start qc check model-->


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
                                    <h4 class="mb-0">Cost Sheet</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Cost Sheet</li>
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
                                        <h4 class="card-title mb-0">Cost Sheet</h4> 
                                    </div>

      
                               <div class="card-body">
                                 <div class="row">
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Document No</label>
                                                <div class="col-lg-8">
                                                     <input class="form-control" type="text" id="" name="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">UOM</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="" name="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Code</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="" name="">
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Validity Date</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="date" id="" name="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                                <label class="col-lg-4 col-form-label mt-6" for="val-skill">Item Name</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="" name="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-group row mb-2">
                                               <label class="col-lg-4 col-form-label mt-6" for="val-skill">FG Qty</label>
                                                <div class="col-lg-8">
                                                    <input class="form-control" type="text" id="" name="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-1 col-md-6">
                                            <div class="form-group row mb-2">
                                               <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Load Data</button>
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
                                                    <table id="tblItemRecord" class="table sample-table-responsive table_inline table-bordered" style="">
                                                        <thead class="fixedHeader1">
                                                            <tr>
                                                                <th>Item Item CodeBOM Component)</th>
                                                                <th>Item Name</th>  
                                                                <th>Quantity</th>
                                                                <th>Last Purchase Price</th>
                                                                <th>Value</th> 
                                                            </tr>
                                                        </thead>
                                                     <tbody>
                                                        <tr>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class=""><input  type="text" id="" name="" class="form-control" ></td>
                                                            <td class="desabled"></td>
                                                         </tr>

                                                          <tr>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class=""><input  type="text" id="" name="" class="form-control" ></td>
                                                            <td class="desabled"></td>
                                                         </tr>

                                                          <tr>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class=""><input  type="text" id="" name="" class="form-control" ></td>
                                                            <td class="desabled"></td>
                                                         </tr>

                                                          <tr>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class=""><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                         </tr>

                                                          <tr>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class="desabled"></td>
                                                            <td class=""><input  type="text" id="" name="" class="form-control"></td>
                                                            <td class="desabled"></td>
                                                         </tr>

                                                        
                                                        </tbody> 

                                                         <tfoot>
                                                            <tr>
                                                            <td  colspan="3"></td>
                                                              <td><label>Total</label><input class="float-end" type="text" name="" value="786" readonly></td>
                                                              <td>676</td>
                                                            </tr>
                                                          </tfoot>

                                                   </table>
                                               </div> 

                                                <div class="bottom-col">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <table id="example" class="table table-bordered nowrap display w-100 dataTable" style="height: 140px;">
                                                        <tfoot class="">
                                                            <tr>
                                                                
                                                                <th colspan="2">Cost of Item</th>
                                                                <td colspan="2">
                                                                    <input type="text" value="676" class="FreightInput">
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                               
                                                                <th class="replaceId" colspan="2"  id="myBtn">FOC</th>
                                                                <td colspan="2">
                                                                    <input type="text" value="10%" class="FreightInput">
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                               
                                                                <th colspan="2">Cost of Item After FOC</th>
                                                                <td colspan="2">
                                                                    <input type="text" name="TaxAmount" id="TaxAmount" value="676
                                                                    " class="FreightInput" readonly="">
                                                                </td>
                                                            </tr>
                                                            
                                                            <tr>
                                                               
                                                                <th colspan="2">Freight</th>
                                                                <td colspan="2">
                                                                    <input type="text" name="FinalTotal" id="FinalTotal" value="15" class="FreightInput" readonly="">
                                                                </td>
                                                            </tr>
                                            
                                                            <tr>
                                                              
                                                                <th colspan="2">Commision (ORC)</th>
                                                                <td colspan="2">
                                                                    <input type="text" name="Rounding" id="Rounding" value="20" class="FreightInput" readonly="">
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                              
                                                                <th colspan="2">Other Charges</th>
                                                                <td colspan="2">
                                                                    <input type="text" name="Rounding" id="Rounding" value="30" class="FreightInput" readonly="">
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                              
                                                                <th colspan="2">Total cost</th>
                                                                <td colspan="2">
                                                                    <input type="text" name="Rounding" id="Rounding" value="741" class="FreightInput" readonly="">
                                                                </td>
                                                            </tr>

                                                        </tfoot>
                                                    </table>
                                                    </div><!--col-md-4 closed-->

                                                    <div class="col-md-4"></div>
                                                     <div class="col-md-4"></div>

                                                     <!-- -------footer button---- -->
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="d-flex flex-wrap gap-2">
                                                                    <!-- Toggle States Button -->
                                                                    <button type="button" class="btn btn-primary" data-bs-toggle="button" autocomplete="off">Add</button>

                                                                     <button type="button" class="btn btn-primary active" data-bs-toggle="button" autocomplete="off">Cancel</button>
                                                                </div>
                                                            </div>
                                                     <!-- -------footer button---- -->
                                          
                                            
                                        </div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div><!-- end col -->

                                                        
                        </form>
                        </div><!--container-fluid-->
                    </div><!--page-content-->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    </div>

     <!--end qc check model-->

     <style type="text/css">
    .modal-body{padding: 0 !important;
     </style>
    }

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



<?php include 'include/footer.php' ?>