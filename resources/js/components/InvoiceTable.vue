<template>
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
                                    <td><button class="btn btn-primary btn-sm">Update Item</button></td>
                                    <td><button class="btn btn-danger btn-sm" v-on:click="deleteItem(item.id)" >Delete Item</button></td>
                            </tr>
                            <!-- <div v-if="!invoiceAddedProducts.length">
                                <tr>
                                    <td style="text-align:center" colspan="6">No data available!</td>
                                </tr>
                            </div>
                            <div v-else>
                                <tr v-for="item in invoiceAddedProducts">
                                    <td>{{item.product_name}}</td>
                                    <td>{{item.product_price}}</td>
                                    <td>{{item.quantity}}</td>
                                    <td>{{item.amount}}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </div> -->
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
</template>

<script>
    export default {
        props: ['invoiceAddedProducts']
    }
</script>
