<template>
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="page-header">
                <div class="page-title">
                    <h3>Budget List</h3>
                </div>
            </div>


            <!-- CONTENT AREA -->

            <div class="col-lg-12 col-12">
                <div class="card">
                    <div class="card-body">

                        <v-data-table :headers="budgetPlanHeaders" :items="budgetPlanLists" :items-per-page="5" :loading="loadingbudgetPlan" class="theme--light elevation-2">
                            <template v-slot:top>
                                <v-toolbar flat color="white">
                                    <div class="col-6 col-lg-6 text-left">
                                        <v-text-field v-model="searchItem" append-icon="mdi-magnify" label="Search" dense single-line hide-details></v-text-field>
                                    </div>
                                    <div class="col-6 col-lg-6 text-right">
                                        
                                    </div>
                                </v-toolbar>
                            </template>
                            <template v-slot:[`item.file_name`]="{ item }">
                                <v-chip class="ma-2" color="primary" small >
                                    <span class="text-white" @click="showImage(item.path_id)" >{{ item.file_name }}</span>
                                </v-chip>
                            </template>
                            <template v-slot:[`item.action`]="{ item }">
                                <v-menu offset-y>
                                    <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on">
                                        <v-icon>mdi-dots-vertical</v-icon>
                                    </v-btn>
                                    </template>
                                    <v-list>
                                        <v-list-item link>
                                            <v-list-item-title class="ma-2" @click="validateBudget(item.tr_id)">Validate</v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                            </template>
                        </v-data-table>

                    </div>
                </div>
            </div>

            <v-dialog v-model="validateDialog" persistent max-width="1024px">
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Validate Coupon</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <div class="row">
                                <div class="col-6 col-lg-4">
                                    <v-text-field label="Validated Luas" v-model="validateLuasModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-4">
                                    <v-text-field label="Total Coupon" v-model="totalCouponModel" dense></v-text-field>
                                </div>
                                <div class="col-12 col-lg-4 text-right">
                                    <v-btn class="btn btn-primary" text @click="validateSubmit()" dense>SUBMIT</v-btn>
                                </div>
                            </div>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="validateDialog = false">Close</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <div class="modal fade modal-md" id="imgModal" tabindex="-1" aria-labelledby="imgModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <v-img :src=imageUrl ></v-img>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENT AREA -->

        </div>
    </div>
    <!--  END CONTENT AREA  -->
</template>

<script>
export default {
    data() {
        return {
            budgetPlanHeaders: [
                { text: 'ID', value: 'tr_id', align: 'left', class: 'text-primary', sortable:false },
                { text: 'USER ID', value: 'inkindo_id', align: 'left', class: 'text-primary', sortable:false },
                { text: 'NAME', value: 'member_name', align: 'left', class: 'text-primary', sortable:false },
                { text: 'AREA', value: 'inkindo_area', align: 'left', class: 'text-primary', sortable:false },
                { text: 'OFFICE', value: 'inkindo_office', align: 'left', class: 'text-primary', sortable:false },
                { text: 'LUAS', value: 'luas_persegi', align: 'left', class: 'text-primary', sortable:false },
                { text: 'PROMO', value: 'descr', align: 'left', class: 'text-primary', sortable:false },
                { text: 'VALIDATION', value: 'validation', align: 'right', class: 'text-primary', sortable:false },
                { text: 'COUPON', value: 'coupon', align: 'right', class: 'text-primary', sortable:false },
                { text: 'FILE', value: 'file_name', align: 'left', class: 'text-primary', sortable:false },
                { text: 'DATE', value: 'created_date', align: 'left', class: 'text-primary', sortable:false },
                { text: '', value: 'action', align: 'center', class: 'text-primary', sortable:false }
            ],
            budgetPlanLists: [],
            loadingbudgetPlan: false,
            searchItem: '',
            imageUrl: '',
            validateDialog: false,
            validateID: '',
            validateLuasModel: '',
            totalCouponModel: '',
        }
    },
    mounted() {
        this.initialize()
    },
    methods:{

        initialize(){

            this.getBudgetPlanListData()

        },

        async getBudgetPlanListData(){

            this.loadingbudgetPlan = true

            await axios.get(`/admin/budget_list/getData`, { 
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                } 
            })
            .then(res => {

                this.loadingbudgetPlan = false
                this.budgetPlanLists = res.data.result

            })
            .catch(err => {
                
                console.log(err)

            })

        },

        showImage(id){

            $('#imgModal').modal('show')
            this.imageUrl = id
            console.log(id)

        },

        async validateBudget(id){

            this.validateDialog = true
            this.validateID = id

            console.log(id);

        },

        async validateSubmit(){

            axios.post(`/admin/budget_list/validateSubmit`, { 

                id: this.validateID ? this.validateID : '',
                validateLuasModel : this.validateLuasModel ? this.validateLuasModel : '',
                totalCouponModel : this.totalCouponModel ? this.totalCouponModel : '',
                
            },{
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                } 
            })
            .then(res => {

                this.validateDialog = false
                
                if(res.data.result == 'OK') {

                    Swal.fire({
                        title: 'Success',
                        text: 'Validation success'
                    })

                    this.getBudgetPlanListData()

                }

            })
            .catch(err => {

                console.log(err)

            })

        }

    }
}
</script>