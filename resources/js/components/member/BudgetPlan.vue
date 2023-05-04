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
                                        <v-btn class="mt-3" color="primary" elevation="2" small rounded @click="addDialog = true">Add New<v-icon right dark>mdi-domain</v-icon></v-btn>
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
                                            <v-list-item-title class="ma-2" @click="deleteBudgetPlan(item.tr_id)">Delete</v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                            </template>
                        </v-data-table>

                    </div>
                </div>
            </div>

            <v-dialog v-model="addDialog" max-width="1024px">
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Add New Budget Plan</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <div class="row">
                                <div class="col-6 col-lg-3">
                                    <v-text-field label="Budget Name" v-model="projectNameModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="provinceModel" :items="provinceList" item-value="province" item-text="province" label="Province" @change="(event) => addprovinceOnChange(event)" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="cityModel" :items="cityList" item-value="city" item-text="city" label="City" clearable dense></v-autocomplete>
                                </div>
                                <!-- <div class="col-6 col-lg-3">
                                    <v-dialog ref="dialog" v-model="budgetPlanDateModal" :return-value.sync="budgetPlanDateModel" persistent width="290px" >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="budgetPlanDateModel" label="Budget Plan Date" readonly v-bind="attrs" v-on="on" dense clearable prepend-icon="mdi-calendar-check"></v-text-field>
                                        </template>
                                        <v-date-picker v-model="budgetPlanDateModel" :show-current="true" @click:date="$refs.dialog.save(budgetPlanDateModel)" scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="budgetPlanDateModal = false">Cancel</v-btn>
                                        </v-date-picker>
                                    </v-dialog>
                                </div> -->
                                <div class="col-6 col-lg-3">
                                    <v-text-field label="Luas M(persegi)" @keypress="isNumber($event)" @paste.prevent="onPaste" v-model="luasModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-4">
                                    <v-autocomplete v-model="productModel" :items="productLists" default="" item-value="value" item-text="text" label="Product" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <input type="file" name="image" id="image" @change="fileChange" class="" accept="image/*" />
                                </div>
                                <div class="col-12 col-lg-4 text-right">
                                    <v-btn class="btn btn-primary" text @click="budgetPlanSubmit()" dense>SUBMIT</v-btn>
                                </div>
                            </div>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="addDialog = false">Close</v-btn>
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
                { text: 'PROJECT', value: 'project_name', align: 'left', class: 'text-primary', sortable:false },
                { text: 'NAME', value: 'member_name', align: 'left', class: 'text-primary', sortable:false },
                { text: 'LUAS', value: 'luas_persegi', align: 'left', class: 'text-primary', sortable:false },
                { text: 'PROMO', value: 'descr', align: 'left', class: 'text-primary', sortable:false },
                { text: 'COUPON', value: 'coupon', align: 'left', class: 'text-primary', sortable:false },
                { text: 'FILE', value: 'file_name', align: 'left', class: 'text-primary', sortable:false },
                { text: 'DATE', value: 'created_date', align: 'left', class: 'text-primary', sortable:false },
                { text: '', value: 'action', align: 'center', class: 'text-primary', sortable:false }
            ],
            budgetPlanLists: [],
            loadingbudgetPlan: false,
            searchItem: '',
            addDialog: false,
            projectNameModel: '',
            provinceList: [],
            provinceModel: '',
            cityList: [],
            cityModel: '',
            budgetPlanDateModal: false,
            budgetPlanDateModel: '',
            productModel: '',
            productLists:[
                {
                    value:'ZINIUM Ruby (AZ 70)',
                    text:'ZINIUM® Ruby (AZ 70)'
                },
                {
                    value:'ZINIUM Emerald (AZ 100)',
                    text:'ZINIUM® Emerald (AZ 100)'
                },
                {
                    value:'ZINIUM Sapphire (AZ 150)',
                    text:'ZINIUM® Sapphire (AZ 150)'
                },
                {
                    value:'ZINIUM Allnat (AZ 200)',
                    text:'ZINIUM® Allnat (AZ 200)'
                },
                {
                    value:'ZINIUM Diverso Emerald (AZ 100)',
                    text:'ZINIUM® Diverso Emerald (AZ 100)'
                },
                {
                    value:'ZINIUM Diverso Sapphire (AZ 150)',
                    text:'ZINIUM® Diverso Sapphire (AZ 150)'
                }
            ],
            luasModel: '',
            imageModel: '',
            imageUrl: ''
        }
    },
    mounted() {
        this.initialize()
    },
    methods:{

        initialize(){

            this.getBudgetPlanListData()
            this.getProvinceAndCity()

        },

        async getBudgetPlanListData(){

            this.loadingbudgetPlan = true

            await axios.get(`/member/budget_list/getData`, { 
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

        async budgetPlanSubmit(){

            if(!this.projectNameModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill Project name !'
                })

                return false

            }

            if(!this.provinceModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill Province !'
                })

                return false

            }

            // if(!this.cityModel){

            //     Swal.fire({
            //         title: 'Warning',
            //         text: 'Please fill City !'
            //     })

            //     return false

            // }

            // if(!this.budgetPlanDateModel){

            //     Swal.fire({
            //         title: 'Warning',
            //         text: 'Please fill Project Date !'
            //     })

            //     return false

            // }

            // if(!this.productModel){

            //     Swal.fire({
            //         title: 'Warning',
            //         text: 'Please fill Product !'
            //     })

            //     return false

            // }

            if(!this.luasModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill Luas Persegi !'
                })

                return false

            }

            if(!this.imageModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please Upload project image !'
                })

                return false

            }

            await axios.post(`/member/budget_list/budgetPlanSubmit`, { 

                    name: this.projectNameModel ? this.projectNameModel : '',
                    province: this.provinceModel ? this.provinceModel : '',
                    city: this.cityModel ? this.cityModel : '',
                    // date: this.budgetPlanDateModel ? this.budgetPlanDateModel : '',
                    product: this.productModel ? this.productModel : '',
                    luas: this.luasModel ? this.luasModel : '',
                    image: this.imageModel ? this.imageModel : '',

                },
                {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*',
                        'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    } 
                }
            )
            .then(res => {
                
                if(res.data.result == 'OK') {

                    this.addDialog = false

                    Swal.fire({
                        title: 'Success',
                        text: 'Member added successfully.'
                    })

                    this.getBudgetPlanListData()

                    this.projectNameModel = ''
                    this.provinceModel = ''
                    this.cityModel = ''
                    this.budgetPlanDateModel = ''
                    this.productModel = ''
                    this.luasModel = ''
                    this.imageModel = ''

                } else {

                    Swal.fire({
                        title: 'WARNING',
                        text: 'This ID is already exists !'
                    })

                }

            })
            .catch(err => {

                console.log(err)

            })

        },

        async getProvinceAndCity(){

            await axios.get(`/member/budget_list/getProvinceAndCity`, 
            { 
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                } 
            })
            .then(res => {

                this.provinceList = res.data.province
                this.cityList = res.data.city

            })
            .catch(err => {
                
                console.log(err)

            })

        },

        async addprovinceOnChange(id){

            await axios.get(`/member/budget_list/getCity?province=${id ? id : 'all'}`, 
            { 
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                } 
            })
            .then(res => {

                this.cityList = res.data.city
                // console.log(res.data.result);

            })
            .catch(err => {
                
                console.log(err)

            })

        },

        fileChange(e) {
            let file = e.target.files[0]

            if (typeof FileReader === 'function') {
                const reader = new FileReader()
                reader.onload = (e) => {
                    this.imageModel = e.target.result
                }
                reader.readAsDataURL(file)
            } else {
                swal("Error", "Sorry, FileReader API not supported", "error");
            }
        },

        isNumber(event){
            let keyCode = (event.keyCode ? event.keyCode : event.which);
            if ((keyCode < 46 || keyCode > 57 )) { // 46 is dot
                event.preventDefault()
            }
        },

        showImage(id){

            $('#imgModal').modal('show')
            this.imageUrl = id

        },

        deleteBudgetPlan(id){

            // console.log(id);

            Swal.fire({
                title: 'WARNING',
                text: 'Do you want delete this ?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No',
                }).then((result) => {
                if (result.isConfirmed) {
                    
                    axios.post(`/member/budget_list/deleteItem`, { 

                        id: id ? id : '',
                        
                    },{
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'Access-Control-Allow-Origin': '*',
                            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        } 
                    })
                    .then(res => {
                        
                        if(res.data.result == 'OK') {

                            Swal.fire({
                                title: 'Success',
                                text: 'Deleted Successfully.'
                            })

                            this.getBudgetPlanListData()

                        }

                    })
                    .catch(err => {

                        console.log(err)

                    })

                }
            })

        }

    }
}
</script>