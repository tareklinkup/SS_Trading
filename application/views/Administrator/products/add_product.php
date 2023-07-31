<style>
.v-select {
    margin-bottom: 5px;
}

.v-select.open .dropdown-toggle {
    border-bottom: 1px solid #ccc;
}

.v-select .dropdown-toggle {
    padding: 0px;
    height: 25px;
}

.v-select input[type=search],
.v-select input[type=search]:focus {
    margin: 0px;
}

.v-select .vs__selected-options {
    overflow: hidden;
    flex-wrap: nowrap;
}

.v-select .selected-tag {
    margin: 2px 0px;
    white-space: nowrap;
    position: absolute;
    left: 0px;
}

.v-select .vs__actions {
    margin-top: -5px;
}

.v-select .dropdown-menu {
    width: auto;
    overflow-y: auto;
}

#products label {
    font-size: 13px;
}

#products select {
    border-radius: 3px;
}

#products .add-button {
    padding: 2.5px;
    width: 28px;
    background-color: #298db4;
    display: block;
    text-align: center;
    color: white;
}

#products .add-button:hover {
    background-color: #41add6;
    color: white;
}
</style>
<div id="products">
    <form @submit.prevent="saveProduct">
        <div class="row"
            style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
            <div class="col-md-6">
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Product Id:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.Product_Code" readonly>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Product Name:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.Product_Name" required>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Category:</label>
                    <div class="col-md-7">
                        <select class="form-control" v-if="categories.length == 0"></select>
                        <v-select v-bind:options="categories" v-model="selectedCategory" label="ProductCategory_Name"
                            v-if="categories.length > 0"></v-select>
                    </div>
                    <div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/category" target="_blank"
                            class="add-button"><i class="fa fa-plus"></i></a></div>
                </div>


                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Brand:</label>
                    <div class="col-md-7">
                        <select class="form-control" v-if="brands.length == 0"></select>
                        <v-select v-bind:options="brands" v-model="selectedBrand" label="brand_name"
                            v-if="brands.length > 0"></v-select>
                    </div>
                    <div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/brand " class="add-button"><i
                                class="fa fa-plus"></i></a></div>
                </div>


                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Parts No:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.parts_no">
                    </div>
                </div>



                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Unit:</label>
                    <div class="col-md-7">
                        <select class="form-control" v-if="units.length == 0"></select>
                        <v-select v-bind:options="units" v-model="selectedUnit" label="Unit_Name"
                            v-if="units.length > 0"></v-select>
                    </div>
                    <div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/unit" target="_blank"
                            class="add-button"><i class="fa fa-plus"></i></a></div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">VAT:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.vat">
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Re-order level:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.Product_ReOrederLevel" required>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Purchase Rate:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.Product_Purchase_Rate" required>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Actual Purchase Rate:</label>
                    <div class="col-md-3">
                        <input type="number" class="form-control" id="purchasePercent"
                            v-model="product.purchase_percent" required @input="purchaseTotal" min="0" step="0.01">
                    </div>
                    <span class="col-md-1">%</span>
                    <div class="col-md-3">
                        <input type="number" id="actual_purchase_price" class="form-control"
                            v-model="product.Product_Actual_Purchase_Rate" required min="0" step="0.01"
                            @input="purchaseTotal">
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Sales Rate:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.Product_SellingPrice" required
                            min="1.0" step="0.01">
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Actual Sales Rate:</label>
                    <div class="col-md-3">
                        <!-- <input type="number" class="form-control" id="sales_percent" v-model="product.sales_percent"
                            required @input="salesTotal" min="1.0" step="0.01"> -->

                        <input type="number" class="form-control" id="salesPercent" v-model="product.sales_percent"
                            required @input="salesTotal" min="0" step="0.01">
                    </div>
                    <span class="col-md-1">%</span>
                    <div class="col-md-3">
                        <input type="number" class="form-control" v-model="product.Product_Actual_Sales_Rate" required
                            min="0" step="0.01" @input="salesTotal">
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Wholesale Rate:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.Product_WholesaleRate" required min="0"
                            step="0.01">
                    </div>
                </div>


                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Actual Wholesale Rate:</label>
                    <div class="col-md-3">
                        <input type="number" class="form-control" id="wholeSalePercent"
                            v-model="product.wholesales_percent" required @input="wholesalesTotal" min="0" step="0.01">
                    </div>
                    <span class="col-md-1">%</span>
                    <div class="col-md-3">
                        <input type="number" class="form-control" v-model="product.Product_Actual_WholeSales_Rate"
                            required min="0" step="0.01" @input="wholesalesTotal">
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">IC Rate:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.ic_rate" required>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Is Service:</label>
                    <div class="col-md-7">
                        <input type="checkbox" v-model="product.is_service">
                    </div>
                </div>

                <div class="form-group clearfix">
                    <div class="col-md-7 col-md-offset-4">
                        <input type="submit" class="btn btn-success btn-sm" value="Save">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="products" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.Product_Code }}</td>
                            <td>{{ row.Product_Name }}</td>
                            <td>{{ row.ProductCategory_Name }}</td>
                            <td>{{ row.brand_name }}</td>
                            <td>{{ row.parts_no }}</td>
                            <td>{{ row.Product_Actual_Purchase_Rate }}</td>
                            <td>{{ row.Product_Actual_Sales_Rate }}</td>
                            <td>{{ row.Product_Actual_WholeSales_Rate }}</td>
                            <td>{{ row.ic_rate }}</td>
                            <td>{{ row.vat }}</td>
                            <td>{{ row.is_service }}</td>
                            <td>{{ row.Unit_Name }}</td>
                            <td>
                                <?php if($this->session->userdata('accountType') != 'u'){?>
                                <button type="button" class="button edit" @click="editProduct(row)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" class="button" @click="deleteProduct(row.Product_SlNo)">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <?php }?>
                                <button type="button" class="button"
                                    @click="window.location = `/Administrator/products/barcodeGenerate/${row.Product_SlNo}`">
                                    <i class="fa fa-barcode"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
            </div>
        </div>
    </div>


</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
Vue.component('v-select', VueSelect.VueSelect);
new Vue({
    el: '#products',
    data() {
        return {
            product: {
                Product_SlNo: '',
                Product_Code: "<?php echo $productCode;?>",
                Product_Name: '',
                ProductCategory_ID: '',
                parts_no: '',
                purchase_percent: '',
                sales_percent: '',
                wholesales_percent: '',
                Product_Actual_Purchase_Rate: '',
                Product_Actual_WholeSales_Rate: '',
                Product_Actual_Sales_Rate: '',
                brand: '',
                Product_ReOrederLevel: '',
                Product_Purchase_Rate: '',
                Product_SellingPrice: '',
                Product_WholesaleRate: 0,
                ic_rate: '',
                Unit_ID: '',
                vat: 0,
                is_service: false
            },
            products: [],
            categories: [],
            selectedCategory: null,
            brands: [],
            selectedBrand: null,
            units: [],
            selectedUnit: null,

            columns: [{
                    label: 'Product Id',
                    field: 'Product_Code',
                    align: 'center',
                    filterable: false
                },
                {
                    label: 'Product Name',
                    field: 'Product_Name',
                    align: 'center'
                },
                {
                    label: 'Category',
                    field: 'ProductCategory_Name',
                    align: 'center'
                },
                {
                    label: 'Brand',
                    field: 'brand_name',
                    align: 'center'
                },
                {
                    label: 'Parts No',
                    field: 'parts_no',
                    align: 'center'
                },
                {
                    label: 'Purchase Price',
                    field: 'Product_Actual_Purchase_Rate',
                    align: 'center'
                },
                {
                    label: 'Sales Price',
                    field: 'Product_Actual_Sales_Rate',
                    align: 'center'
                },
                {
                    label: 'Wholesale Price',
                    field: 'Product_Actual_WholeSales_Rate',
                    align: 'center'
                },
                {
                    label: 'IC  Price',
                    field: 'ic_rate',
                    align: 'center'
                },
                {
                    label: 'VAT',
                    field: 'vat',
                    align: 'center'
                },
                {
                    label: 'Is Service',
                    field: 'is_service',
                    align: 'center'
                },
                {
                    label: 'Unit',
                    field: 'Unit_Name',
                    align: 'center'
                },
                {
                    label: 'Action',
                    align: 'center',
                    filterable: false
                }
            ],
            page: 1,
            per_page: 10,
            filter: ''
        }
    },
    created() {
        this.getCategories();
        this.getBrands();
        this.getUnits();
        this.getProducts();
    },
    methods: {
        getCategories() {
            axios.get('/get_categories').then(res => {
                this.categories = res.data;
            })
        },
        getBrands() {
            axios.get('/get_brands').then(res => {
                this.brands = res.data;
            })
        },
        getUnits() {
            axios.get('/get_units').then(res => {
                this.units = res.data;
            })
        },
        getProducts() {
            axios.get('/get_products').then(res => {
                this.products = res.data;
            })
        },

        async purchaseTotal() {


            if (event.target.id == 'purchasePercent') {

                let percent = this.product.Product_Purchase_Rate * this.product.purchase_percent /
                    100;

                let price = this.product.Product_Purchase_Rate;

                let actualPurchasePrice = parseFloat(percent) + parseFloat(price);
                this.product.Product_Actual_Purchase_Rate = actualPurchasePrice;

                console.log(actualPurchasePrice);
            } else {
                //      let percent = this.product.Product_Purchase_Rate * this.product.purchase_percent /
                //     100;

                // let price = this.product.Product_Purchase_Rate;

                // let actualPurchasePrice = parseFloat(percent) + parseFloat(price);
                // this.product.Product_Actual_Purchase_Rate = actualPurchasePrice;

                let percentTaka = this.product.Product_Actual_Purchase_Rate - this.product
                    .Product_Purchase_Rate;

                this.product.purchase_percent = parseFloat(percentTaka).toFixed(2) / this.product
                    .Product_Purchase_Rate * 100;

                console.log(this.product.purchase_percent);

            }

            // $("#actual_purchase_price").val(actualPurchasePrice);

        },

        async purchasePercent() {
            this.product.purchase_percent = '';
            this.product.Product_Actual_Purchase_Rate

        },

        async salesTotal() {

            if (event.target.id == 'salesPercent') {
                let percent = this.product.Product_SellingPrice * this.product.sales_percent /
                    100;
                let price = this.product.Product_SellingPrice;
                const actualSalesPrice = parseFloat(percent) + parseFloat(price);
                this.product.Product_Actual_Sales_Rate = actualSalesPrice;
            } else {
                let percentTaka = this.product.Product_Actual_Sales_Rate - this.product
                    .Product_SellingPrice;
                this.product.sales_percent = parseFloat(percentTaka).toFixed(2) / this.product
                    .Product_SellingPrice * 100;
                console.log(this.product.sales_percent);
            }
        },

        async wholesalesTotal() {

            if (event.target.id == 'wholeSalePercent') {

                let percent = this.product.Product_WholesaleRate * this.product.wholesales_percent /
                    100;

                let price = this.product.Product_WholesaleRate;

                let actualWholeSalesPrice = parseFloat(percent) + parseFloat(price);
                this.product.Product_Actual_WholeSales_Rate = actualWholeSalesPrice;
            } else {

                let percentTaka = this.product.Product_Actual_WholeSales_Rate - this.product
                    .Product_WholesaleRate;

                this.product.wholesales_percent = parseFloat(percentTaka).toFixed(2) / this.product
                    .Product_WholesaleRate * 100;

                console.log(this.product.wholesales_percent);
            }

        },

        saveProduct() {

            if (this.selectedCategory == null) {
                alert('Select category');
                return;
            }

            if (this.selectedBrand == null) {
                alert('Select Brand');
                return;
            }

            if (this.selectedUnit == null) {
                alert('Select unit');
                return;
            }
            if (this.selectedBrand != null) {
                this.product.brand = this.selectedBrand.brand_SiNo;
            }

            this.product.ProductCategory_ID = this.selectedCategory.ProductCategory_SlNo;
            this.product.Unit_ID = this.selectedUnit.Unit_SlNo;

            let url = '/add_product';
            if (this.product.Product_SlNo != 0) {
                url = '/update_product';
            }
            axios.post(url, this.product)
                .then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.clearForm();
                        this.product.Product_Code = r.productId;
                        this.getProducts();
                    }
                })

        },
        editProduct(product) {
            let keys = Object.keys(this.product);
            keys.forEach(key => {
                this.product[key] = product[key];
            })

            this.product.is_service = product.is_service == 'true' ? true : false;

            this.selectedCategory = {
                ProductCategory_SlNo: product.ProductCategory_ID,
                ProductCategory_Name: product.ProductCategory_Name
            }

            this.selectedUnit = {
                Unit_SlNo: product.Unit_ID,
                Unit_Name: product.Unit_Name
            }

            this.selectedBrand = {
                brand_SiNo: product.brand,
                brand_name: product.brand_name
            }
        },
        deleteProduct(productId) {
            let deleteConfirm = confirm('Are you sure?');
            if (deleteConfirm == false) {
                return;
            }
            axios.post('/delete_product', {
                productId: productId
            }).then(res => {
                let r = res.data;
                alert(r.message);
                if (r.success) {
                    this.getProducts();
                }
            })
        },
        clearForm() {
            let keys = Object.keys(this.product);
            keys.forEach(key => {
                if (typeof(this.product[key]) == "string") {
                    this.product[key] = '';
                } else if (typeof(this.product[key]) == "number") {
                    this.product[key] = 0;
                }
            })
        }
    }
})
</script>