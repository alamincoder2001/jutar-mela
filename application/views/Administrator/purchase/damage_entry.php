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
</style>
<div id="damages">
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-8">
            <form class="form-horizontal" @submit.prevent="addDamage">
                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> কোড </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <input type="text" placeholder="Code" class="form-control" v-model="damage.Damage_InvoiceNo" required readonly />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> তারিখ </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <input type="date" placeholder="Date" class="form-control" v-model="damage.Damage_Date" required />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> পণ্য </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <v-select v-bind:options="products" label="display_text" v-model="selectedProduct" placeholder="Select Product" v-on:input="productOnChange"></v-select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> সাইজ </label>
                    <label class="col-md-1">:</label>
                    <div class="col-sm-5">
                        <v-select v-bind:options="pSizes" v-model="selectedSize" label="product_size" v-on:input="sizeOnChange"></v-select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> ডেমজ পরিমাণ </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <input type="number" placeholder="Quantity" class="form-control" v-model="damage.DamageDetails_DamageQuantity" required v-on:input="calculateTotal" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> ডেমজ হার </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <input type="number" step="0.01" placeholder="Rate" class="form-control" v-model="damage.damage_rate" required v-on:input="calculateTotal" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> ডেমজ টাকা </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <input type="number" placeholder="Amount" class="form-control" v-model="damage.damage_amount" required disabled />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> বর্ণনা </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <textarea class="form-control" placeholder="Description" v-model="damage.Damage_Description"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"></label>
                    <label class="col-sm-1 control-label no-padding-right"></label>
                    <div class="col-sm-5">
                        <button type="submit" class="btn btn-sm btn-success">
                            জমা দিন 
                            <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <h1 style="display: none;" v-bind:style="{display: productStock !== '' ? '' : 'none'}">Stock : {{productStock}}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="damages" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.Damage_InvoiceNo }}</td>
                            <td>{{ row.Damage_Date }}</td>
                            <td>{{ row.Product_Code }}</td>
                            <td>{{ row.Product_Article }}</td>
                            <td>{{ row.product_size }}</td>
                            <td>{{ row.DamageDetails_DamageQuantity }}</td>
                            <td>{{ row.damage_rate }}</td>
                            <td>{{ row.damage_amount }}</td>
                            <td>{{ row.Damage_Description }}</td>
                            <td>
                                <?php if ($this->session->userdata('accountType') != 'u') { ?>
                                    <button type="button" class="button edit" @click="editDamage(row)">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <button type="button" class="button" @click="deleteDamage(row.Damage_SlNo)">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                <?php } ?>
                            </td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#damages',
        data() {
            return {
                damage: {
                    Damage_SlNo: 0,
                    Damage_InvoiceNo: '<?php echo $damageCode; ?>',
                    Damage_Date: moment().format('YYYY-MM-DD'),
                    Damage_Description: '',
                    Product_SlNo: '',
                    DamageDetails_DamageQuantity: '',
                    damage_rate: '',
                    damage_amount: 0,
                },
                pSizes: [],
                selectedSize: {
                    Product_SlNo: '',
                    product_size: 'Select'
                },
                products: [],
                selectedProduct: null,
                productStock: '',
                damages: [],
                columns: [{
                        label: 'কোড',
                        field: 'Damage_InvoiceNo',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'তারিখ',
                        field: 'Damage_Date',
                        align: 'center'
                    },
                    {
                        label: 'পণ্য কোড',
                        field: 'Product_Code',
                        align: 'center'
                    },
                    {
                        label: 'পণ্য আর্টিকেল',
                        field: 'Product_Article',
                        align: 'center'
                    },
                    {
                        label: 'সাইজ ',
                        field: 'product_size',
                        align: 'center'
                    },
                    {
                        label: 'পরিমাণ',
                        field: 'DamageDetails_DamageQuantity',
                        align: 'center'
                    },
                    {
                        label: 'ডেমজ হার',
                        field: 'damage_rate',
                        align: 'center'
                    },
                    {
                        label: 'ডেমজ টাকা',
                        field: 'damage_amount',
                        align: 'center'
                    },
                    {
                        label: 'বর্ণনা',
                        field: 'Damage_Description',
                        align: 'center'
                    },
                    {
                        label: 'কর্ম',
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
            this.getProducts();
            this.getDamages();
        },
        methods: {
            async productOnChange() {
                if ((this.selectedProduct.Product_SlNo != '' || this.selectedProduct.Product_SlNo != 0)) {
                    this.damage.damage_rate = this.selectedProduct.Product_Purchase_Rate;

                    let damage_amount = parseFloat(this.damage.damage_rate) * parseFloat(this.damage.DamageDetails_DamageQuantity);
                    this.damage.damage_amount = isNaN(damage_amount) ? 0 : damage_amount;

                    this.productStock = await axios.post('/get_product_stock', {
                        productId: this.selectedProduct.Product_SlNo
                    }).then(res => {
                        return res.data;
                    })
                }
                this.getSize();
            },
            getSize() {
                if (this.selectedProduct.Product_SlNo == '') return;
                axios.post('/get_product_sizes', {
                    productId: this.selectedProduct.Product_SlNo
                }).then(res => {
                    this.pSizes = res.data;

                })
            },
            sizeOnChange() {
                if (this.selectedSize.Product_SlNo == '') return;
                this.productStock = this.selectedSize.stock;
            },
            getProducts() {
                axios.post('/get_products', {
                    isService: 'false'
                }).then(res => {
                    this.products = res.data;
                })
            },
            addDamage() {
                if (this.selectedProduct == null) {
                    alert('Select product');
                    return;
                }
                if (this.selectedSize.Product_SlNo == '') {
                    alert('Select size');
                    return;
                }

                if (this.damage.DamageDetails_DamageQuantity > this.selectedSize.stock) {
                    alert('Stock unavailable');
                    return;
                }

                this.damage.Product_SlNo = this.selectedProduct.Product_SlNo;
                this.damage.product_size = this.selectedSize.product_size;

                let url = '/add_damage';
                if (this.damage.Damage_SlNo != 0) {
                    url = '/update_damage'
                }
                axios.post(url, this.damage).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.resetForm();
                        this.damage.Damage_InvoiceNo = r.newCode;
                        this.getDamages();
                    }
                })
            },

            editDamage(damage) {
                let keys = Object.keys(this.damage);
                keys.forEach(key => this.damage[key] = damage[key]);

                this.selectedProduct = {
                    Product_SlNo: damage.Product_SlNo,
                    display_text: `${damage.Product_Name} - ${damage.Product_Code}`,
                    Product_Purchase_Rate: damage.damage_rate
                }

                this.selectedSize = {
                    Product_SlNo: damage.Product_SlNo,
                    product_size: damage.product_size
                }
            },

            calculateTotal() {
                let damage_amount = parseFloat(this.damage.damage_rate) * parseFloat(this.damage.DamageDetails_DamageQuantity);
                this.damage.damage_amount = isNaN(damage_amount) ? 0 : damage_amount;
            },

            deleteDamage(damageId) {
                let deleteConfirm = confirm('Are you sure?');
                if (deleteConfirm == false) {
                    return;
                }
                axios.post('/delete_damage', {
                    damageId: damageId
                }).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if (r.success) {
                        this.getDamages();
                    }
                })
            },

            getDamages() {
                axios.get('/get_damages').then(res => {
                    this.damages = res.data;
                })
            },

            resetForm() {
                this.damage.Damage_SlNo = '';
                this.damage.Damage_Description = '';
                this.damage.Product_SlNo = '';
                this.damage.DamageDetails_DamageQuantity = '';
                this.damage.damage_rate = '';
                this.damage.damage_amount = 0;
                this.selectedProduct = null;
                this.productStock = '';

                this.selectedSize = {
                    Product_SlNo: '',
                    product_size: 'Select'
                }
            }
        }
    })
</script>