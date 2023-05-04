<template>
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            
            <div class="page-header">
                <div class="page-title">
                    <h3>Member List</h3>
                </div>
            </div>

            <!-- CONTENT AREA -->
            <div class="col-lg-12 col-12">
                <div class="card">
                    <div class="card-body">
                        
                        <v-data-table :headers="memberHeaders" :items="memberLists" :items-per-page="5" :loading="loadingMember" class="theme--light elevation-2">
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
                            <template v-slot:[`item.user_pass`]="{ item }">
                                <button class="text-primary" @click="showPassword(item)">
                                    (Click to Show)
                                </button>
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
                                                <v-list-item-title class="ma-2" @click="deactivateUser(item)">Deactivate</v-list-item-title>
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
                                                <v-list-item-title class="ma-2" @click="reactivateUser(item)">Reactivate</v-list-item-title>
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
                        <span class="text-h5">Add New Member</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <div class="row">
                                <div class="col-6 col-lg-2">
                                    <v-text-field label="ID" v-model="addIDModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-4">
                                    <v-text-field label="Name" v-model="addNameModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-text-field label="Email" v-model="addEmailModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-text-field label="Type" v-model="addTypeModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="addProvinceModel" :items="addProvinceList" item-value="province" item-text="province" label="Province" @change="(event) => addprovinceOnChange(event)" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="addCityModel" :items="addCityList" item-value="city" item-text="city" label="City" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <v-text-field label="Address" v-model="addAddressModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-text-field label="Phone" v-model="addPhoneModel" @keypress="isNumber($event)" @paste.prevent="onPaste" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="inkindoAreaModel" :items="inkindoAreaList" item-value="province" item-text="province" label="INKINDO Area" @change="(event) => inkindoAreaOnChange(event)" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="inkindoOfficeModel" :items="inkindoOfficeList" item-value="city" item-text="city" label="INKINDO Office" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-12 col-lg-3 text-right">
                                    <v-btn class="btn btn-primary" text @click="addNewMember()" dense>SUBMIT</v-btn>
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
                        <span class="text-h5">Edit User</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <div class="row">
                                <div class="col-6 col-lg-2">
                                    <v-text-field label="ID" v-model="editIdModel" dense disabled></v-text-field>
                                </div>
                                <div class="col-6 col-lg-4">
                                    <v-text-field label="Name" v-model="editNameModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-text-field label="Email" v-model="editEmailModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-text-field label="Type" v-model="editTypeModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="editProvinceModel" :items="editProvinceList" item-value="province" item-text="province" label="Province" @change="(event) => addprovinceOnChange(event)" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="editCityModel" :items="editCityList" item-value="city" item-text="city" label="City" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <v-text-field label="Address" v-model="editAddressModel" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-text-field label="Phone" v-model="editPhoneModel" @keypress="isNumber($event)" @paste.prevent="onPaste" dense></v-text-field>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="editInkindoAreaModel" :items="inkindoAreaList" item-value="province" item-text="province" label="INKINDO Area" @change="(event) => inkindoAreaOnChange(event)" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <v-autocomplete v-model="editInkindoOfficeModel" :items="inkindoOfficeList" item-value="city" item-text="city" label="INKINDO Office" clearable dense></v-autocomplete>
                                </div>
                                <div class="col-12 col-lg-3 text-right">
                                    <v-btn class="btn btn-primary" text @click="editUserSubmit()" dense>SUBMIT</v-btn>
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
            memberHeaders: [
                { text: 'ID', value: 'inkindo_id', align: 'left', class: 'text-primary', sortable:false },
                { text: 'PASSWORD', value: 'user_pass', align: 'left', class: 'text-primary', sortable:false },
                { text: 'NAME', value: 'member_name', align: 'left', class: 'text-primary', sortable:false },
                { text: 'ADDRESS', value: 'member_address', align: 'left', class: 'text-primary', sortable:false },
                { text: 'CITY', value: 'member_city', align: 'left', class: 'text-primary', sortable:false },
                { text: 'PROVINCE', value: 'member_province', align: 'left', class: 'text-primary', sortable:false },
                { text: 'EMAIL', value: 'member_email', align: 'left', class: 'text-primary', sortable:false },
                { text: 'TYPE', value: 'member_type', align: 'left', class: 'text-primary', sortable:false },
                { text: 'RESPOSIBLE BY', value: 'penanggung_jawab', align: 'left', class: 'text-primary', sortable:false },
                { text: 'RESPOSIBLE PHONE', value: 'penanggung_jawab_hp', align: 'left', class: 'text-primary', sortable:false },
                { text: '', value: 'active_flag', align: 'left', class: '', sortable:false },
                { text: '', value: 'action', align: 'left', class: '', sortable:false },
            ],
            memberLists: [],
            loadingMember: false,
            searchItem: '',
            addDialog: false,
            addIDModel: '',
            addNameModel: '',
            addAddressModel: '',
            addProvinceModel: '',
            addProvinceList: '',
            addCityModel: '',
            addCityList: '',
            addEmailModel: '',
            addTypeModel: '',
            addPhoneModel: '',
            editDialog: false,
            editIdModel: '',
            editNameModel: '',
            editAddressModel: '',
            editCityModel: '',
            editCityList: [],
            editProvinceModel: '',
            editProvinceList: [],
            editEmailModel: '',
            editTypeModel: '',
            inkindoAreaModel: '',
            inkindoAreaList: [],
            inkindoOfficeModel: '',
            inkindoOfficeList: [],
            editPhoneModel: '',
            editInkindoAreaModel: '',
            editInkindoOfficeModel: ''

        }
    },
    async mounted() {
        this.initialize()
    },
    methods:{

        initialize(){

            this.getMemberListData()
            this.getProvinceAndCity()

        },

        async getMemberListData(){

            this.loadingmember = true

            await axios.get(`/admin/member_list/getData`, { 
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                } 
            })
            .then(res => {

                this.loadingmember = false
                this.memberLists = res.data.result

            })
            .catch(err => {
                
                console.log(err)

            })

        },

        async addNewMember(){

            if(!this.addIDModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill Inkindo ID !'
                })

                return false

            }

            if(!this.addNameModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill Member Name !'
                })                

                return false

            }

            if(!this.addAddressModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill Member Address !'
                })                

                return false

            }

            if(!this.addProvinceModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill Member Province !'
                })                

                return false

            }

            if(!this.addCityModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill Member City !'
                })                

                return false

            }

            if(!this.addTypeModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill Member Type !'
                })                

                return false

            }

            if(!this.addPhoneModel){

                Swal.fire({
                    title: 'Warning',
                    text: 'Please fill Member Phone !'
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

            // if(!this.inkindoOfficeModel){

            //     Swal.fire({
            //         title: 'Warning',
            //         text: 'Please fill Inkindo Office !'
            //     })                

            //     return false

            // }

            await axios.post(`/admin/member_list/addNewMember`, { 

                    id: this.addIDModel ? this.addIDModel : '',
                    name: this.addNameModel ? this.addNameModel : '',
                    address: this.addAddressModel ? this.addAddressModel : '',
                    province: this.addProvinceModel ? this.addProvinceModel : '',
                    city: this.addCityModel ? this.addCityModel : '',
                    email: this.addEmailModel ? this.addEmailModel : '',
                    type: this.addTypeModel ? this.addTypeModel : '',
                    phone: this.addPhoneModel ? this.addPhoneModel : '',
                    inkindoArea: this.inkindoAreaModel ? this.inkindoAreaModel : '',
                    inkidoOffice: this.inkindoOfficeModel ? this.inkindoOfficeModel : ''

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

                    this.getMemberListData()

                    this.addIDModel = ''
                    this.addNameModel = ''
                    this.addAddressModel = ''
                    this.addProvinceModel = ''
                    this.addCityModel = ''
                    this.addEmailModel = ''
                    this.addTypeModel = ''
                    this.addPhoneModel = ''
                    this.inkindoAreaModel = ''
                    this.inkindoOfficeModel = ''

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

        async editUserSubmit(){

            await axios.post(`/admin/member_list/editMember`, { 

                    id: this.editIdModel ? this.editIdModel : '',
                    name: this.editNameModel ? this.editNameModel : '',
                    address: this.editAddressModel ? this.editAddressModel : '',
                    province: this.editProvinceModel ? this.editProvinceModel : '',
                    city: this.editCityModel ? this.editCityModel : '',
                    email: this.editEmailModel ? this.editEmailModel : '',
                    type: this.editTypeModel ? this.editTypeModel : '',
                    phone: this.editPhoneModel ? this.editPhoneModel : '',
                    inkindoArea: this.editInkindoAreaModel ? this.editInkindoAreaModel : '',
                    inkidoOffice: this.editInkindoOfficeModel ? this.editInkindoOfficeModel : ''

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
                        text: 'Member updated successfully.'
                    })

                    this.getMemberListData()

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

        deactivateUser(id){

            Swal.fire({
                title: 'WARNING',
                text: 'Do you want Deactivate this user ?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No',
                }).then((result) => {
                if (result.isConfirmed) {
                    
                    axios.post(`/admin/member_list/deActivateUser`, { 

                        id: id.inkindo_id ? id.inkindo_id : '',
                        
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

                            this.getMemberListData()

                        }

                    })
                    .catch(err => {

                        console.log(err)

                    })

                }
            })

        },

        async reactivateUser(id){

            Swal.fire({
                title: 'WARNING',
                text: 'Do you want Reactivate this user ?',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: 'No',
                }).then((result) => {
                if (result.isConfirmed) {
                    
                    axios.post(`/admin/member_list/reActivateUser`, { 

                        id: id.inkindo_id ? id.inkindo_id : '',
                        
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
                                text: 'Member Activated successfully.'
                            })

                            this.getMemberListData()

                        }

                    })
                    .catch(err => {

                        console.log(err)

                    })

                }
            })

        },

        async getProvinceAndCity(){

            await axios.get(`/admin/member_list/getProvinceAndCity`, 
            { 
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                } 
            })
            .then(res => {

                this.addProvinceList = res.data.province
                this.editProvinceList = res.data.province
                this.inkindoAreaList = res.data.province
                this.addCityList = res.data.city
                this.editCityList = res.data.city
                this.inkindoOfficeList = res.data.city

            })
            .catch(err => {
                
                console.log(err)

            })

        },

        async inkindoAreaOnChange(id){

            await axios.get(`/admin/member_list/getCity?province=${id ? id : 'all'}`, 
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

        async addprovinceOnChange(id){

            await axios.get(`/admin/member_list/getCity?province=${id ? id : 'all'}`, 
            { 
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Origin': '*',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                } 
            })
            .then(res => {

                this.addCityList = res.data.city
                // console.log(res.data.result);

            })
            .catch(err => {
                
                console.log(err)

            })

        },

        async editItem(id){

            this.editDialog = true

            this.editDialog = true
            this.editIdModel = id.inkindo_id
            this.editNameModel = id.member_name
            this.editAddressModel = id.member_address
            this.editCityModel = id.member_city
            this.editProvinceModel = id.member_province
            this.editEmailModel = id.member_email
            this.editTypeModel = id.member_type
            this.editPhoneModel = id.member_phone
            this.editInkindoAreaModel = id.inkindo_area
            this.editInkindoOfficeModel = id.inkindo_office

        },

        showPassword(item){

            Swal.fire(
                'Username : ' + item.inkindo_id,
                'Password : ' + item.user_pass
            )

        },

        isNumber(event){
            let keyCode = (event.keyCode ? event.keyCode : event.which);
            if ((keyCode < 47 || keyCode > 57 )) { // 46 is dot
                event.preventDefault()
            }
        },

        onPaste(event) {
            console.log("Paste event detected, but prevented.");
        }

    }
}
</script>