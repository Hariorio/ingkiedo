<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.   <v-chip
                                                        class="ma-2"
                                                        color="success"
                                                        variant="outlined"
                                                        >
                                                        <v-icon start icon="mdi-server-plus"></v-icon>
                                                        Server Status
                                                    </v-chip>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
