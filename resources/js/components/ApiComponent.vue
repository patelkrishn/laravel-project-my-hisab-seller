<template>
<div class="container">
    <div class="row">
                <div class="col-md-6">
                    <label for="selectProduct">Select Product</label>
                    <div class="form-group">
                        <select class="form-control" v-model="selected" @change="onChange()">
                            <option selected>Select...</option>
                                <option v-for="item in items"  v-bind:value="item.id">
                                    {{ item.product_name}}
                                </option>
                           
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <label>Product Price</label>
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="selectedProducted.product_price" disabled>
                    </div>
                </div>
                <div class="col-md-1">
                    <label>Quantity</label>
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="quantity" @change="onChangeQuantity()">
                    </div>
                </div>
                <div class="col-md-2">
                    <label>Total Amount</label>
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="amount">
                    </div>
                </div>
                <div class="col-md-1">
                    <label class="pb-3"></label>
                    <div class="form-group">
                        <button class="btn btn-primary btn-md form-control" v-on:click="onchangeSubmit">Submit</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Product Price</th>
                                <th>Total</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="invoiceAddedProducts.length == 0">
                                <td colspan="6" style="text-align:center">No data available!</td>
                                <!-- No data available! -->
                            </tr>
                            <tr v-for="item in invoiceAddedProducts">
                                    <td>{{item.product_name}}</td>
                                    <td>{{item.invoice_quantity}}</td>
                                    <td>{{item.product_price}}</td>
                                    <td>{{item.total_amount}}</td>
                                    <td><button class="btn btn-primary btn-sm" v-on:click="updateModal(item.id)" >Update Item</button></td>
                                    <td><button class="btn btn-danger btn-sm" v-on:click="deleteModal(item.id)" >Delete Item</button></td>
                            </tr>
                        </tbody>
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
                        <button v-on:click="deleteItem()" class="btn btn-danger">Delete</button>
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
                        <form id="update_invoice_form" class="form-horizontal" enctype="multipart/form-data">
                        

                        <div class="form-group">
                        <label class="control-label col-md-4" >Product Name : </label>
                        <div class="col-md-12">
                            <input type="text" v-model="updateData.product_name" class="form-control" disabled/>
                        </div>
                        </div>

                        <div class="form-group">
                        <label class="control-label col-md-4">Product Price : </label>
                        <div class="col-md-12">
                            <input type="text" v-model="updateData.product_price" class="form-control" disabled/>
                        </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-md-4">Quantity : </label>
                            <div class="col-md-12">
                            <input type="text" class="form-control" v-model="updateData.invoice_quantity" @change="onChangeUpdateQuantity()"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-4">Total Amount : </label>
                            <div class="col-md-12">
                            <input type="text" v-model="updateData.total_amount" class="form-control" />
                            </div>
                        </div>

                        <br />
                        <div class="form-group" align="center">
                            <input type="hidden" name="invoice_id" id="invoice_id" value="null">
                        <button type="button" class="btn btn-warning btn-md" v-on:click="updateItem()">Update</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            </div>
</template>
<script>
    export default {
        
        props: ['access_token'],
 
        data() {
            return {
                selected: null,
                items: [],
                selectedProducted :[],
                quantity : null,
                amount : null,
                invoiceAddedProducts : [],
                invoiceStoreResponse : null,
                invoiceDeleteResponse :null,
                delete_id : null,
                update_id : null,
                updateData :[],
            }
        },
        methods:{
             onChange() {
                this.items.forEach((value, index) => {
                    if (value.id == this.selected) {
                        this.selectedProducted= value;
                        // console.log(value);
                    }
                });
                this.quantity=1;
                this.amount=this.selectedProducted.product_price*this.quantity;
                // console.log(this.selectedProducted);
            },
            onChangeQuantity() {
                this.amount=this.selectedProducted.product_price*this.quantity;
            },
            onchangeSubmit : function(event) {
                let params = {
                    'token':this.access_token,
                    'product_id':this.selectedProducted.id,
                    'product_price':this.selectedProducted.product_price,
                    'invoice_quantity':this.quantity,
                    'total_amount':this.amount,
                }
                axios
                .post('https://console.myhisab.store/api/seller/invoices',params)
                .then(response => (this.invoiceStoreResponse=response.status));
                    toastr.success("Product added to invoice succesfully.");
                // console.log(this.invoiceAddedProducts);
                this.amount=null;
                this.quantity=null;
                this.selectedProducted.product_price=null;
            this.refreshFunction();
            },
            deleteModal : function(delete_id) {
                this.delete_id= delete_id;
                $('#confirmModal').modal('show');
            },
            deleteItem : function (){
                axios
                .delete('https://console.myhisab.store/api/seller/invoices/'+this.delete_id+'?token='+this.access_token)
                .then(response => (this.invoiceDeleteResponse = response.data));
                toastr.success("Product succesfully deleted from invoice.");
                $('#confirmModal').modal('hide');
                this.refreshFunction();
            },
            updateModal :function(update_id){
                axios
                .get('https://console.myhisab.store/api/seller/invoices/'+update_id+'?token='+this.access_token)
                .then(response => (this.updateData = response.data.invoice));
                $('#update_invoice_modal').modal('show');
            },
            onChangeUpdateQuantity() {
                this.updateData.total_amount=this.updateData.invoice_quantity*this.updateData.product_price;
            },
            updateItem :function(){
                $('#update_invoice_modal').modal('hide');
            },
            refreshFunction() {
                 setTimeout(() => {
                  this.getRefreshedData()
                },1000)
            },
            getRefreshedData() {
                axios
                .get('https://console.myhisab.store/api/seller/product?token='+this.access_token)
                .then(response => (this.items = response.data))

                axios
                .get('https://console.myhisab.store/api/seller/invoices?token='+this.access_token)
                .then(response => (this.invoiceAddedProducts = response.data));
            }
        },
        mounted () {
            this.getRefreshedData();
            
        }
    }
</script>