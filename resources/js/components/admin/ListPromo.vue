<template>
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            
            <div class="page-header">
                <div class="page-title">
                    <h3>Master Promo</h3>
                </div>
            </div>

            <!-- CONTENT AREA -->
            <div class="col-lg-12 col-12">
                <div class="card">
                    <div class="card-body">
                        
                        <v-data-table :headers="promoHeaders" :items="promoLists" :items-per-page="5" :loading="loadingPromo" class="theme--light elevation-2">
                            <template v-slot:top>
                                <v-toolbar flat color="white">
                                    <div class="col-6 col-lg-6 text-left">
                                        <v-text-field v-model="searchItem" append-icon="mdi-magnify" label="Search" dense single-line hide-details></v-text-field>
                                    </div>
                                    <div class="col-6 col-lg-6 text-right">
                                        <v-btn class="mt-3" color="primary" elevation="2" small rounded @click="addDialog = true">Add New<v-icon right dark>mdi-account-plus</v-icon></v-btn>
                                    </div>
                                </v-toolbar>
                            </template>
                            <template v-slot:[`item.action`]="{ item }">

                                <div v-if="item.active_flag == 'Y'">
                                    <v-menu offset-y>
                                        <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on">
                                            <v-icon>mdi-dots-vertical</v-icon>
                                        </v-btn>
                                        </template>
                                        <v-list>
                                            <v-list-item link>
                                                <v-list-item-title class="ma-2" @click="editItem(item)">Edit</v-list-item-title>
                                            </v-list-item>
                                            <v-list-item link>
                                                <v-list-item-title class="ma-2" @click="deactivatePromo(item)">Deactivate</v-list-item-title>
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>
                                </div>
                                <div v-else>
                                    <v-menu offset-y>
                                        <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on">
                                            <v-icon>mdi-dots-vertical</v-icon>
                                        </v-btn>
                                        </template>
                                        <v-list>
                                            <v-list-item link>
                                                <v-list-item-title class="ma-2" @click="reactivatePromo(item)">Reactivate</v-list-item-title>
                                            </v-list-item>
                                        </v-list>
                                    </v-menu>
                                </div>

                            </template>
                            <template v-slot:[`item.active_flag`]="{ item }">
                                <div v-if="item.active_flag == 'Y'">
                                    <v-chip color="green" dark>Y</v-chip>
                                </div>
                                <div v-else>
                                    <v-chip color="red" dark>N</v-chip>
                                </div>
                            </template>
                        </v-data-table>

                    </div>
                </div>
            </div>

            <v-dialog v-model="addDialog" persistent max-width="1024px">
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Add New Promo</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <div class="row">
                                <div class="col-6 col-lg-6">
                                    <v-text-field label="PROMO DESC." v-model="promoDescModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="inkindoAreaModel" :items="inkindoAreaList" item-value="province" item-text="province" label="AREA" @change="(event) => inkindoAreaOnChange(event)" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="inkindoOfficeModel" :items="inkindoOfficeList" item-value="city" item-text="city" label="OFFICE" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-dialog ref="dialog" v-model="dateStartModal" :return-value.sync="dateStartModel" persistent width="290px" >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="dateStartModel" label="Start Promo" readonly v-bind="attrs" v-on="on" dense clearable prepend-icon="mdi-calendar-check"></v-text-field>
                                        </template>
                                        <v-date-picker v-model="dateStartModel" :show-current="true" @click:date="$refs.dialog.save(dateStartModel)" scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="dateStartModal = false">Cancel</v-btn>
                                        </v-date-picker>
                                    </v-dialog>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-dialog ref="dialog2" v-model="dateEndModal" :return-value.sync="dateEndModel" persistent width="290px" >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="dateEndModel" label="End Promo" readonly v-bind="attrs" v-on="on" dense clearable prepend-icon="mdi-calendar-check"></v-text-field>
                                        </template>
                                        <v-date-picker v-model="dateEndModel" :show-current="true" @click:date="$refs.dialog2.save(dateEndModel)" scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="dateEndModal = false">Cancel</v-btn>
                                        </v-date-picker>
                                    </v-dialog>
                                </div>
                                <div class="col-12 col-lg-6 text-right">
                                    <v-btn class="btn btn-primary" text @click="newPromoSubmit()" dense>SUBMIT</v-btn>
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

            <v-dialog v-model="editDialog" persistent max-width="1024px">
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Add New Promo</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <div class="row">
                                <div class="col-6 col-lg-6">
                                    <v-text-field label="PROMO DESC." v-model="editPromoDescModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="editInkindoAreaModel" :items="editInkindoAreaList" item-value="province" item-text="province" label="AREA" @change="(event) => editInkindoAreaOnChange(event)" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="editInkindoOfficeModel" :items="editInkindoOfficeList" item-value="city" item-text="city" label="OFFICE" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-dialog ref="dialog3" v-model="editDateStartModal" :return-value.sync="editDateStartModel" persistent width="290px" >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="editDateStartModel" label="Start Promo" readonly v-bind="attrs" v-on="on" dense clearable prepend-icon="mdi-calendar-check"></v-text-field>
                                        </template>
                                        <v-date-picker v-model="editDateStartModel" :show-current="true" @click:date="$refs.dialog3.save(editDateStartModel)" scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="editDateStartModal = false">Cancel</v-btn>
                                        </v-date-picker>
                                    </v-dialog>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-dialog ref="dialog4" v-model="editDateEndModal" :return-value.sync="editDateEndModel" persistent width="290px" >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="editDateEndModel" label="End Promo" readonly v-bind="attrs" v-on="on" dense clearable prepend-icon="mdi-calendar-check"></v-text-field>
                                        </template>
                                        <v-date-picker v-model="editDateEndModel" :show-current="true" @click:date="$refs.dialog4.save(editDateEndModel)" scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="editDateEndModal = false">Cancel</v-btn>
                                        </v-date-picker>
                                    </v-dialog>
                                </div>
                                <div class="col-12 col-lg-6 text-right">
                                    <v-btn class="btn btn-primary" text @click="editPromoSubmit()" dense>SUBMIT</v-btn>
                                </div>
                            </div>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="editDialog = false">Close</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <!-- CONTENT AREA -->

        </div>
    </div>
    <!--  END CONTENT AREA  -->
</template>

<script>

export default {
    data() {
        return {
            promoHeaders: [
                { text: 'PROMO DESC.', value: 'descr', align: 'left', class: 'text-primary', sortable:false },
                { text: 'AREA', value: 'inkindo_area', align: 'left', class: 'text-primary', sortable:false },
                { text: 'OFFICE', value: 'inkindo_office', align: 'left', class: 'text-primary', sortable:false },
                { text: 'START DATE', value: 'dt_start', align: 'left', class: 'text-primary', sortable:false },
                { text: 'END DATE', value: 'dt_end', align: 'left', class: 'text-primary', sortable:false },
                { text: 'CREATE DATE', value: 'created_date', align: 'left', class: 'text-primary', sortable:false },
                { text: 'CREATED BY', value: 'created_by', align: 'left', class: 'text-primary', sortable:false },
                { text: 'STAT', value: 'active_flag', align: 'left', class: 'text-primary', sortable:false },
                { text: '', value: 'action', align: 'left', class: 'text-primary', sortable:false }
            ],
            promoLists: [],
            loadingPromo: false,
            searchItem: '',
            addDialog: false,
            promoDescModel: '',
            inkindoAreaModel: '',
            inkindoAreaList: [],
            inkindoOfficeModel: '',
            inkindoOfficeList: [],
            dateStartModal: false,
            dateStartModel: '',
            dateEndModal: false,
            dateEndModel: '',
            editDialog: false,
            editPromoId: '',
            editPromoDescModel: '',
            editInkindoAreaModel: '',
            editInkindoAreaList: [],
            editInkindoOfficeModel: '',
            editInkindoOfficeList: [],
            editDateStartModal: false,
            editDateStartModel: '',
            editDateEndModal: false,
            editDateEndModel: '',
        }
    },
    async mounted() {
        this.initialize()
        
    },
    methods:{

        async initialize(){

            this.getProvinceAndCity()
            this.getPromoListData()

        },

        async getPromoListData(){

            this.loadingPromo = true

            await axios.get(`/admin/list_promo/getData`, { 
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                } 
            })
            .then(res => {

                this.loadingPromo = false
                this.promoLists = res.data.result

            })
            .catch(err => {
                
                console.log(err)

            })

        },

        async newPromoSubmit(){

            if(!this.promoDescModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill Inkindo Promo !'
                })

                return false

            }

            if(!this.inkindoAreaModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill Inkindo Area !'
                })

                return false

            }

            if(!this.dateStartModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill Start Date Promo !'
                })

                return false

            }

            if(!this.dateEndModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill End Date Promo !'
                })

                return false

            }

            await axios.post(`/admin/list_promo/newPromoSubmit`, { 

                    promoDesc: this.promoDescModel ? this.promoDescModel : '',
                    inkindoArea: this.inkindoAreaModel ? this.inkindoAreaModel : '',
                    inkindoOffice: this.inkindoOfficeModel ? this.inkindoOfficeModel : '',
                    startPromo: this.dateStartModel ? this.dateStartModel : '',
                    endPromo: this.dateEndModel ? this.dateEndModel : '',

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

                    this.getPromoListData()

                    this.promoDescModel = ''
                    this.inkindoAreaModel = ''
                    this.inkindoOfficeModel = ''
                    this.dateStartModel = ''
                    this.dateEndModel = ''

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

            await axios.get(`/admin/list_promo/getProvinceAndCity`, 
            { 
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                } 
            })
            .then(res => {

                this.inkindoAreaList = res.data.province
                this.inkindoOfficeList = res.data.city
                this.editInkindoAreaList = res.data.province
                this.editInkindoOfficeList = res.data.city

            })
            .catch(err => {
                
                console.log(err)

            })

        },

        async inkindoAreaOnChange(id){

            await axios.get(`/admin/list_promo/getCity?province=${id ? id : 'all'}`, 
            { 
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                } 
            })
            .then(res => {

                this.inkindoOfficeList = res.data.city

            })
            .catch(err => {
                
                console.log(err)

            })

        },

        editItem(item){

            this.editDialog = true

            this.editPromoId = item.id
            this.editPromoDescModel = item.descr
            this.editInkindoAreaModel = item.inkindo_area
            this.editInkindoOfficeModel = item.inkindo_office
            this.editDateStartModel = item.dt_start
            this.editDateEndModel = item.dt_end

        },

        async editPromoSubmit(){

            await axios.post(`/admin/list_promo/editPromoSubmit`, { 

                    id : this.editPromoId ? this.editPromoId : '',
                    promoDesc: this.editPromoDescModel ? this.editPromoDescModel : '',
                    inkindoArea: this.editInkindoAreaModel ? this.editInkindoAreaModel : '',
                    inkindoOffice: this.editInkindoOfficeModel ? this.editInkindoOfficeModel : '',
                    startPromo: this.editDateStartModel ? this.editDateStartModel : '',
                    endPromo: this.editDateEndModel ? this.editDateEndModel : '',

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

                    this.editDialog = false

                    Swal.fire({
                        title: 'Success',
                        text: 'Promo updated !'
                    })

                    this.getPromoListData()

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

        deactivatePromo(id){

            Swal.fire({
                title: 'WARNING',
                text: 'Do you want Deactivate this Promo ?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No',
                }).then((result) => {
                if (result.isConfirmed) {
                    
                    axios.post(`/admin/list_promo/deactivatePromo`, { 

                        id: id.id ? id.id : '',
                        
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
                                text: 'Member Deactivated successfully.'
                            })

                            this.getPromoListData()

                        }

                    })
                    .catch(err => {

                        console.log(err)

                    })

                }
            })

        },

        async reactivatePromo(id){

            Swal.fire({
                title: 'WARNING',
                text: 'Do you want Reactivate this Promo ?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No',
                }).then((result) => {
                if (result.isConfirmed) {
                    
                    axios.post(`/admin/list_promo/reactivatePromo`, { 

                        id: id.id ? id.id : '',
                        
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
                                text: 'Promo Activated successfully.'
                            })

                            this.getPromoListData()

                        }

                    })
                    .catch(err => {

                        console.log(err)

                    })

                }
            })

        },

    }
}
</script>