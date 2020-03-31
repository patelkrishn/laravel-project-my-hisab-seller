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
    <div id="app">
    <api-component access_token="{{Cookie::get('access_token')}}"></api-component>
    </div>
  </div>
    
    <script src="{{ asset('js/app.js') }}"></script>
@endsection 

@section('extra-js')
<script>
    $('#invoice').DataTable();
    

        // $(document).on('click', '.update', function(){
        //     invoice_id= $(this).attr('id');
        //     var settings = {
        //         "url": "{{env('API_URL')}}/invoices/"+invoice_id,
        //         "method": "GET",
        //         "timeout": 0,
        //         "headers": {
        //             "Content-Type": "application/json",
        //             "Accept": "application/json",
        //             "Authorization": "Bearer {{Cookie::get('access_token')}}"
        //         },
        //     };

        //     $.ajax(settings).done(function (response) {
        //         // console.log(response.invoice.product_price);
        //         document.getElementById("invoice_id").value = invoice_id;  
        //         document.getElementById("product_name").value = response.invoice.product_name;  
        //         document.getElementById("product_price_update_modal").value = response.invoice.product_price;  
        //         document.getElementById("invoice_quantity").value = response.invoice.invoice_quantity;  
        //         document.getElementById("total_amount_update_modal").value = response.invoice.total_amount;  
        //         $('#update_invoice_modal').modal('show');
        //     });
        // });

        // $('#update_invoice_form').on('submit', function(event){
        //     event.preventDefault();
            
        //     document.getElementById("update_invoice_submit").value = "Updating..."; 
        //     var invoice_quantity=document.getElementById("invoice_quantity").value;  
        //     var total_amount_update_modal=document.getElementById("total_amount_update_modal").value;
        //     var settings = {
        //         "url": "{{env('API_URL')}}/invoices/"+invoice_id,
        //         "method": "PUT",
        //         "timeout": 0,
        //         "headers": {
        //             "Content-Type": "application/x-www-form-urlencoded",
        //             "Accept": "application/json",
        //             "Authorization": "Bearer {{Cookie::get('access_token')}}"
        //         },
        //         "data": {
        //             "invoice_quantity": invoice_quantity,
        //             "total_amount": total_amount_update_modal 
        //         }
        //     };

        //     $.ajax(settings).done(function (response) {
        //         $('#update_invoice_form')[0].reset();
        //         $('#update_invoice_modal').modal('hide');
        //     document.getElementById("update_invoice_submit").value = "Update"; 
        //         toastr.success(response.message)
        //         $('#invoice').DataTable().ajax.reload();
        //     });
        // });
    </script> 
@endsection