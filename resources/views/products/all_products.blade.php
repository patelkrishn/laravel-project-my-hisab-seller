@extends('layouts.app')



@section('nav_title','All Product')
@section('content')
   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">All Products</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/seller">Home</a></li>
              <li class="breadcrumb-item">Products</li>
              <li class="breadcrumb-item active">All Products</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="container">
        <div class="card">
            <div class="card-header">
              <div class="row">
                  <div class="col-md-10">
                    <h3 class="card-title">Your Product Details</h3>
                  </div>
                  <div class="col-md-2">
                    <button type="button" name="add_product" class="add btn btn-info btn-sm">Add product</button>
                  </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="product" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Product Name</th>
                  <th>SKU</th>
                  <th>Stock</th>
                  <th>Price</th>
                  <th>Total Sales</th>
                  <th>Action</th>
                </tr>
                </thead>
                
                <tfoot>
                <tr>
                  <th>Product Name</th>
                  <th>SKU</th>
                  <th>Stock</th>
                  <th>Price</th>
                  <th>Total Sales</th>
                  <th>Action</th>
                </tr>
                </tfoot>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>

    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
         <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add Product</h4>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <div class="modal-body">
                <span id="form_result"></span>
                <form method="post" id="add_product_form" class="form-horizontal" enctype="multipart/form-data">
                 @csrf

                <div class="form-group">
                   <label class="control-label col-md-4" >Product Name : </label>
                   <div class="col-md-12">
                    <input type="text" name="product_name" id="product_name" class="form-control" />
                   </div>
                  </div>

                  <div class="form-group">
                   <label class="control-label col-md-4">Product SKU : </label>
                   <div class="col-md-12">
                    <input type="text" name="product_sku" id="product_sku" class="form-control" />
                   </div>
                  </div>

                  <div class="form-group">
                   <label class="control-label col-md-4">Product Price : </label>
                   <div class="col-md-12">
                    <input type="text" name="product_price" id="product_price" class="form-control" />
                    <span id="store_image"></span>
                   </div>
                  </div>

                  <br />
                  <div class="form-group" align="center">
                   <input type="hidden" name="seller_id" id="seller_id" value="{{AuthApi::id()}}" />
                   <input type="hidden" name="product_stock_quantity" id="product_stock_quantity" value="0" />
                   <input type="hidden" name="product_total_sales" id="product_total_sales" value="0" />
                   <input type="submit" name="submit" id="submit" class="btn btn-warning" value="Submit" />
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
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                       <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                   </div>
               </div>
           </div>
       </div>
@endsection 


@section('extra-js')
<script>
    $('#product').DataTable({
  processing: true,
  serverSide: true,
  ajax:{
   url: "{{ route('products.index') }}",
  },
  columns:[
   {
    data: 'product_name',
    name: 'product_name'
   },
   {
    data: 'product_sku',
    name: 'product_sku'
   },
   {
    data: 'product_stock_quantity',
    name: 'product_stock_quantity',
    orderable: false
   },
   {
    data: 'product_price',
    name: 'product_price',
    orderable: false
   },
   {
    data: 'product_total_sales',
    name: 'product_total_sales',
    orderable: false
   },
   {
    data: 'action',
    name: 'action',
    orderable: false
   }
  ]
 });

 var user_id;

 $(document).on('click', '.delete', function(){
  user_id = $(this).attr('id');
  $('#confirmModal').modal('show');
 });

 $('#ok_button').click(function(){
        var settings = {
    "url": "{{env('API_URL')}}/product/1",
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
        $('#product').DataTable().ajax.reload();
    });
 });

 $('.add').click(function(){
     $('#formModal').modal('show');
 });
    $('#add_product_form').on('submit', function(event){
    event.preventDefault();
    
    var seller_id=document.getElementById("seller_id").value;  
    var product_name=document.getElementById("product_name").value;  
    var product_sku=document.getElementById("product_sku").value;  
    var product_price=document.getElementById("product_price").value;  
    var product_stock_quantity=document.getElementById("product_stock_quantity").value;  
    var product_total_sales=document.getElementById("product_total_sales").value;  
    var addForm = {
    "url": "{{env('API_URL')}}/product",
    "method": "POST",
    "timeout": 0,
    "headers": {
        "Content-Type": "application/x-www-form-urlencoded",
        "Accept": "application/json",
        "Authorization": "Bearer {{Cookie::get('access_token')}}"
        },
    "data": {
                "seller_id": seller_id,
                "product_name": product_name,
                "product_sku": product_sku,
                "product_price": product_price,
                "product_stock_quantity": product_stock_quantity,
                "product_total_sales": product_total_sales
            }
    };

    $.ajax(addForm).done(function (response) {
        $('#add_product_form')[0].reset();
        $('#formModal').modal('hide');
        $('#product').DataTable().ajax.reload();
    });
 });
 </script>
@endsection 