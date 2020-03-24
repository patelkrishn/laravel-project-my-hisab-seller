@extends('layouts.app')



@section('nav_title','Create Invoice')
@section('content')
   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Create Invoice</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/seller">Home</a></li>
              <li class="breadcrumb-item">Invoices</li>
              <li class="breadcrumb-item active">Create Invoice</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="container">
        <form method="POST" action="{{route('invoices.store')}}" id="create_invoice" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="selectProduct">Select Product</label>
                    <div class="form-group">
                        <select class="form-control" name="product_id" id="product_id" onchange="getProductDetails()">
                            <option value="">Select...</option>
                            @foreach ($products as $item)
                                <option value="{{$item['id']}}">{{$item['product_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <label>Product Price</label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="product_price" id="product_price">
                    </div>
                </div>
                <div class="col-md-1">
                    <label>Quantity</label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="product_quantity" id="product_quantity" onchange="product_quantity_function()">
                    </div>
                </div>
                <div class="col-md-2">
                    <label>Total Amount</label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="total_amount" id="total_amount">
                    </div>
                </div>
                <div class="col-md-1">
                    <label class="pb-3"></label>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-md form-control" id="create_invoice_submit" value="Submit" name="submit">
                    </div>
                </div>
            </div>
        </form>
        <div class="card">
            {{-- <div class="card-header">
              <h3 class="card-title">Your Inventory Details</h3>
            </div> --}}
            <!-- /.card-header -->
            <div class="card-body">
              <table id="invoice" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Quantity</th>
                  <th>Product Price</th>
                  <th>Total</th>
                  <th>Update</th>
                  <th>Delete</th>
                </thead>
                
<div id="loader" style="display:none">Loading...</div>
                <tfoot>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Product Price</th>
                    <th>Total</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
                </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
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

    <div id="update_invoice_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
         <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Update Product</h4>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                <span id="form_result"></span>
                <form method="post" id="update_invoice_form" class="form-horizontal" enctype="multipart/form-data">
                 @csrf

                <div class="form-group">
                   <label class="control-label col-md-4" >Product Name : </label>
                   <div class="col-md-12">
                    <input type="text" name="product_name" id="product_name" class="form-control" disabled/>
                   </div>
                  </div>

                  <div class="form-group">
                   <label class="control-label col-md-4">Product Price : </label>
                   <div class="col-md-12">
                    <input type="text" name="product_price" id="product_price_update_modal" class="form-control" disabled/>
                   </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-md-4">Quantity : </label>
                    <div class="col-md-12">
                     <input type="text" name="invoice_quantity" id="invoice_quantity" class="form-control" onchange="product_quantity_modal_function()"/>
                    </div>
                   </div>

                   <div class="form-group">
                    <label class="control-label col-md-4">Total Amount : </label>
                    <div class="col-md-12">
                     <input type="text" name="total_amount" id="total_amount_update_modal" class="form-control" />
                    </div>
                   </div>

                  <br />
                  <div class="form-group" align="center">
                      <input type="hidden" name="invoice_id" id="invoice_id" value="null">
                   <input type="submit" name="submit" id="update_invoice_submit" class="btn btn-warning" value="Update" />
                  </div>
                </form>
               </div>
            </div>
           </div>
       </div>
@endsection 

@section('extra-js')
    <script>
        $('#invoice').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "{{route('invoices.create')}}",
            },
            columns:[
                {
                    data: 'product_name',
                    name: 'product_name'
                },
                {
                    data: 'invoice_quantity',
                    name: 'invoice_quantity'
                },
                {
                    data: 'product_price',
                    name: 'product_price',
                    orderable: false
                },
                {
                    data: 'total_amount',
                    name: 'total_amount',
                    orderable: false
                },
                {
                    data: 'update_invoice',
                    name: 'update_invoice',
                    orderable: false
                },
                {
                    data: 'delete',
                    name: 'delete',
                    orderable: false
                }
            ]
        });

        var product_id; 
        var product_price;
        var product_quantity;
        var total_amount;
        var invoice_id;
        function getProductDetails()
        {
            product_id=document.getElementById("product_id").value;
            document.getElementById("loader").style.display = "block";
            var settings = {
                "url": "{{env('API_URL')}}/product/"+product_id,
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Accept": "application/json",
                    "Authorization": "Bearer {{Cookie::get('access_token')}}"
                },
                };

                $.ajax(settings).done(function (response) {
                    // console.log(response.product);
                    product_price=response.product.product_price;
                    $('#product_price').val(product_price);
            document.getElementById("loader").style.display = "none";
                });
        }
        function product_quantity_function()
        {   
            // alert('fjksvbifdb');
            product_quantity=document.getElementById("product_quantity").value; 
            product_price=document.getElementById("product_price").value; 
            total_amount=product_price*product_quantity;
            document.getElementById('total_amount').value=total_amount;
        }

        function product_quantity_modal_function()
        {   
            // alert('fjksvbifdb');
            invoice_quantity=document.getElementById("invoice_quantity").value; 
            product_price_update_modal=document.getElementById("product_price_update_modal").value; 
            total_amount_update_modal=invoice_quantity*product_price_update_modal;
            document.getElementById('total_amount_update_modal').value=total_amount_update_modal;
        }

        $(document).on('click', '.delete', function(){
            invoice_id = $(this).attr('id');
            $('#confirmModal').modal('show');
        });
        $('#ok_button').click(function(){
            $('#ok_button').text('Deleting...');
                var settings = {
            "url": "{{env('API_URL')}}/invoices/"+invoice_id,
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
                $('#invoice').DataTable().ajax.reload();
            });
        });

        $(document).on('click', '.update', function(){
            invoice_id= $(this).attr('id');
            var settings = {
                "url": "{{env('API_URL')}}/invoices/"+invoice_id,
                "method": "GET",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Bearer {{Cookie::get('access_token')}}"
                },
            };

            $.ajax(settings).done(function (response) {
                // console.log(response.invoice.product_price);
                document.getElementById("invoice_id").value = invoice_id;  
                document.getElementById("product_name").value = response.invoice.product_name;  
                document.getElementById("product_price_update_modal").value = response.invoice.product_price;  
                document.getElementById("invoice_quantity").value = response.invoice.invoice_quantity;  
                document.getElementById("total_amount_update_modal").value = response.invoice.total_amount;  
                $('#update_invoice_modal').modal('show');
            });
        });

        $('#update_invoice_form').on('submit', function(event){
            event.preventDefault();
            
            document.getElementById("update_invoice_submit").value = "Updating..."; 
            var invoice_quantity=document.getElementById("invoice_quantity").value;  
            var total_amount_update_modal=document.getElementById("total_amount_update_modal").value;
            var settings = {
                "url": "{{env('API_URL')}}/invoices/"+invoice_id,
                "method": "PUT",
                "timeout": 0,
                "headers": {
                    "Content-Type": "application/x-www-form-urlencoded",
                    "Accept": "application/json",
                    "Authorization": "Bearer {{Cookie::get('access_token')}}"
                },
                "data": {
                    "invoice_quantity": invoice_quantity,
                    "total_amount": total_amount_update_modal 
                }
            };

            $.ajax(settings).done(function (response) {
                $('#update_invoice_form')[0].reset();
                $('#update_invoice_modal').modal('hide');
            document.getElementById("update_invoice_submit").value = "Update"; 
                toastr.success(response.message)
                $('#invoice').DataTable().ajax.reload();
            });
        });
    </script>
@endsection