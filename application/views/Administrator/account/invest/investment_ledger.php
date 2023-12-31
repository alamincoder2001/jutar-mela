<style>
    .v-select{
		margin-bottom: 5px;
        float: right;
        min-width: 150px;
        margin-left: 5px;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
        height: 23px;
	}
	.v-select input[type=search], .v-select input[type=search]:focus{
		margin: 0px;
	}
	.v-select .vs__selected-options{
		overflow: hidden;
		flex-wrap:nowrap;
	}
	.v-select .selected-tag{
		margin: 2px 0px;
		white-space: nowrap;
		position:absolute;
		left: 0px;
	}
	.v-select .vs__actions{
		margin-top:-5px;
	}
	.v-select .dropdown-menu{
		width: auto;
		overflow-y:auto;
	}
    #loanTransactionReport label{
        font-size: 13px;
    }
    #loanTransactionReport select{
        border-radius: 3px;
        padding: 0px;
    }
    #loanTransactionReport .form-group{
        margin-right: 5px;
    }
    #loanTransactionReport .search-button{
        margin-top: -6px;
    }
    #transactionsTable th{
        text-align: center;
    }
</style>
<div id="loanTransactionReport">
    <div class="row" style="border-bottom: 1px solid #ccc;margin-bottom: 15px;">
        <div class="col-md-12">
            <form class="form-inline" @submit.prevent="getTransactions">
                <div class="form-group">
                    <label>হিসাব</label>
                    <v-select v-bind:options="computedAccounts" v-model="selectedAccount" label="display_text" @input="resetData"></v-select>
                </div>

                <div class="form-group">
                    <label>তারিখ হতে</label>
                    <input type="date" class="form-control" v-model="filter.dateFrom" @change="resetData">
                </div>

                <div class="form-group">
                    <label>থেকে</label>
                    <input type="date" class="form-control" v-model="filter.dateTo" @change="resetData">
                </div>

                <div class="form-group">
                    <input type="submit" value="সার্চ" class="search-button">
                </div>
            </form>
        </div>
    </div>

    <div class="row" style="display:none;" v-bind:style="{display: transactions.length > 0 ? '' : 'none'}" v-if="transactions.length > 0">
        <div class="col-md-12" style="margin-bottom: 10px;">
            <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
        </div>
        <div class="col-md-12">
            <div class="table-responsive" id="reportContent">
                <table class="table table-bordered table-condensed" id="transactionsTable">
                    <thead>
                        <tr>
                            <th>লেনদেন তারিখ</th>
                            <th>বর্ণনা</th>
                            <th>নোট</th>
                            <th>গ্রহণ </th>
                            <th>লাভ</th>
                            <th>পেমেন্ট</th>
                            <th>ব্যালেন্স</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="6" style="text-align:left;"> পূর্বের ব্যালেন্স</td>
                            <td style="text-align:right;">{{ previousBalance }}</td>
                        </tr>
                        <tr v-for="(transaction, sl) in transactions">
                            <td style="text-align:left;">{{ transaction.transaction_date }}</td>
                            <td style="text-align:left;">{{ transaction.description }}</td>
                            <td style="text-align:left;">{{ transaction.note }}</td>
                            <td style="text-align:right">{{ transaction.receive }}</td>
                            <td style="text-align:right">{{ transaction.profit }}</td>
                            <td style="text-align:right">{{ transaction.payment }}</td>
                            <td style="text-align:right">{{ transaction.balance }}</td>
                        </tr>
                        <tr style="font-weight:bold;">
                            <td colspan="3" style="text-align:right;">Total</td>
                            <td style="text-align:right;">{{ transactions.reduce((p, c) => { return +p + +c.receive }, 0) }}</td>
                            <td style="text-align:right;">{{ transactions.reduce((p, c) => { return +p + +c.profit }, 0) }}</td>
                            <td style="text-align:right;">{{ transactions.reduce((p, c) => { return +p + +c.payment }, 0) }}</td>
                            <td style="text-align:right;">{{ transactions[transactions.length - 1].balance }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#loanTransactionReport',
        data(){
            return {
                accounts: [],
                selectedAccount: null,
                previousBalance: 0.00,
                transactions: [],
                filter: {
                    accountId: null,
                    dateFrom: moment().format('YYYY-MM-DD'),
                    dateTo: moment().format('YYYY-MM-DD'),
                    ledger: true,
                }
            }
        },
        computed:{
            computedAccounts(){
                let accounts = this.accounts;
                return accounts.map(account => {
                    account.display_text = `${account.Acc_Code} - ${account.Acc_Name}`;
                    return account;
                })
            }
        },
        watch: {
            selectedAccount(account) {
                this.filter.accountId = account?.Acc_SlNo ?? null;
            }
        },
        created(){
            this.getAccounts();
        },
        methods: {
            getAccounts(){
                axios.get('/get_investment_accounts')
                .then(res => {
                    this.accounts = res.data;
                })
            },

            getTransactions(){
                if(this.selectedAccount == null){
                    alert('Select account');
                    return;
                }

                axios.post('/get_all_investment_transactions', this.filter)
                .then(res => {
                    this.previousBalance = res.data.previousBalance;
                    this.transactions = res.data.transactions;
                })
                .catch(error => {
                    if(error.response){
                        alert(`${error.response.status}, ${error.response.statusText}`);
                    }
                })
            },

            resetData(){
                this.previousBalance = 0;
                this.transactions = [];
            },

            async print(){
                let accountText = '';
                if(this.selectedAccount != null){
                    accountText = `<strong>Account: </strong> ${account.Acc_Code} - ${account.Acc_Name}<br>`;
                }

                dateText = '';
                if(this.filter.dateFrom != '' && this.filter.dateTo != ''){
                    dateText = `Statement from <strong>${this.filter.dateFrom}</strong> to <strong>${this.filter.dateTo}</strong>`;
                }
                
                let reportContent = `
					<div class="container">
						<h4 style="text-align:center">Loan Transaction Report</h4 style="text-align:center">
                        <div class="row">
                            <div class="col-xs-6">${accountText}</div>
                            <div class="col-xs-6 text-right">${dateText}</div>
                        </div>
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportContent').innerHTML}
							</div>
						</div>
					</div>
				`;

				var printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}`);
				printWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php');?>
				`);

                printWindow.document.head.innerHTML += `
                    <style>
                        #transactionsTable th{
                            text-align: center;
                        }
                    </style>
                `;
				printWindow.document.body.innerHTML += reportContent;

				printWindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                printWindow.print();
                printWindow.close();
            }
        }
    })
</script>
