@extends('layouts.app')



@section('nav_title','Product Inventory')
@section('content')
   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Product Inventory</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/seller">Home</a></li>
              <li class="breadcrumb-item">Inventories</li>
              <li class="breadcrumb-item active">Product Inventory</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="container">
        <h2 align="center">{{$product_name}}</h2>
    </div>
    <br>
    <div class="container">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Your Inventory Details</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="inventory" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Quantity</th>
                  <th>Principle Amount</th>
                  <th>Date</th>
                  <th>Update Inventory</th>
                  <th>Delete</th>
                </thead>
                
                <tfoot>
                <tr>
                  <th>Quantity</th>
                  <th>Principle Amount</th>
                  <th>Date</th>
                  <th>Update Inventory</th>
                  <th>Delete</th>
                </tr>
                </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>

       <div id="update_inventory_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
         <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Update Inventory</h4>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                <span id="form_result"></span>
                <form id="update_inventory_form" class="form-horizontal" enctype="multipart/form-data">
                 @csrf

                <div class="form-group">
                   <label class="control-label col-md-4" >Stock Quantity : </label>
                   <div class="col-md-12">
                    <input type="text" name="stock_quantity" id="stock_quantity" class="form-control" />
                   </div>
                  </div>

                  <div class="form-group">
                   <label class="control-label col-md-4">Principle Amount : </label>
                   <div class="col-md-12">
                    <input type="text" name="principle_amount" id="principle_amount" class="form-control" />
                   </div>
                  </div>

                  <br />
                  <div class="form-group" align="center">
                   <input type="submit" name="submit" id="update_inventory_modal_ok_button" class="btn btn-warning" value="Submit" />
                  </div>
                </form>
               </div>
            </div>
           </div>
       </div>
       
       <div id="confirmModal" class="modal fade" role="dialog">
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                    <h2 class="modal-title">Confirmation</h2>
                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                   </div>
                   <div class="modal-body">
                       <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                   </div>
                   <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Delete</button>
                       <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                   </div>
               </div>
           </div>
       </div>
@endsection 


@section('extra-js')
<script>
  $('.select2').select2();
  $('#inventory').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "{{ asset('/inventories/'.$product_id) }}",
            },
            columns:[
                {
                    data: 'stock_quantity',
                    name: 'stock_quantity'
                },
                {
                    data: 'principle_amount',
                    name: 'principle_amount'
                },
                {
                    data: 'create_date',
                    name: 'create_date',
                    orderable: false
                },
                {
                    data: 'update_inventory',
                    name: 'update_inventory',
                    orderable: false
                },
                {
                    data: 'delete',
                    name: 'delete',
                    orderable: false
                }
            ]
        });

 var inventory_id;
 var product_id;

 $(document).on('click', '.delete', function(){
  inventory_id = $(this).attr('id');
  $('#confirmModal').modal('show');
 });

 $('#ok_button').click(function(){
    $('#ok_button').text('Deleting...');
        var settings = {
    "url": "{{env('API_URL')}}/inventory/"+inventory_id,
    "method": "DELETE",
    "timeout": 0,
    "headers": {
        "Content-Type": "application/x-www-form-urlencoded",
        "Accept": "application/json",
        "Authorization": "Bearer {{Cookie::get('access_token')}}"
    },
    };

    $.ajax(settings).done(function (response) {
        $('#confirmModal').modal('hide');
        $('#ok_button').text('Delete');
        toastr.success(response.message)
        $('#inventory').DataTable().ajax.reload();
    });
 });



 $(document).on('click', '.update', function(){
    inventory_id= $(this).attr('id');
    var settings = {
    "url": "{{env('API_URL')}}/inventory/"+inventory_id,
    "method": "GET",
    "timeout": 0,
    "headers": {
        "Content-Type": "application/x-www-form-urlencoded",
        "Accept": "application/json",
        "Authorization": "Bearer {{Cookie::get('access_token')}}"
    },
    };

    $.ajax(settings).done(function (response) {
      // console.log(response);
    $('#stock_quantity').val(response.stock_quantity);
    // console.log(response);
    $('#principle_amount').val(response.principle_amount);
    $('#update_inventory_modal').modal('show');
    });
 });
 $('#update_inventory_modal_ok_button').on('submit', function(event){
    event.preventDefault();  
    var stock_quantity=document.getElementById("stock_quantity").value;  
    var principle_amount=document.getElementById("principle_amount").value;
        $('#update_inventory_modal_ok_button').text('Submitting...'); 
    var add_inventory_Form = {
    "url": "{{env('API_URL')}}/inventory/"+inventory_id,
    "method": "PUT",
    "timeout": 0,
    "headers": {
        "Content-Type": "application/x-www-form-urlencoded",
        "Accept": "application/json",
        "Authorization": "Bearer {{Cookie::get('access_token')}}"
        },
    "data": {
                "stock_quantity": stock_quantity,
                "principle_amount": principle_amount
            }
    };

    $.ajax(add_inventory_Form).done(function (response) {
        $('#update_inventory_form')[0].reset();
        $('#update_inventory_modal').modal('hide');
        $('#update_inventory_modal_ok_button').text('Submit');
        toastr.success(response.message)
        $('#product').DataTable().ajax.reload();
    });
    });

 </script>
@endsection 