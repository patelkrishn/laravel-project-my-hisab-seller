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
                                    <td><button class="btn btn-primary btn-sm" v-on:click="updateItem(item.id)" >Update Item</button></td>
                                    <td><button class="btn btn-danger btn-sm" v-on:click="deleteItem(item.id)" >Delete Item</button></td>
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
                invoiceDeleteResponse :[],
                delete_id : null
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
            deleteItem : function (delete_id){
                axios
                .delete('https://console.myhisab.store/api/seller/invoices/'+delete_id+'?token='+this.access_token)
                .then(response => (this.invoiceDeleteResponse = response.data));
                toastr.success(this.invoiceDeleteResponse.message);
                this.refreshFunction();
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