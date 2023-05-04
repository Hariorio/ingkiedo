<template>
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
  <v-container fluid class="mb-8 mt-5">
      <v-row>
        <v-col cols="12">
          <v-container>
            <v-row>
              <v-col
                class="col-12"
                xs="12"
                sm="3"
                md="3"
              >
                <h6>
                  Hi , Welcome to Dashboard Vroh
                </h6>
              </v-col>
            </v-row>
            <v-row class="mt-4">
              <v-col cols="12" sm="6" md="4">
                <v-card class="rounded-l" outlined>
                  <v-card-text class="p-4">
                    <v-row>
                      <v-col cols="12">
                        <div class="d-flex">
                          <v-icon color="#2083b4">
                            mdi-currency-usd
                          </v-icon>
                          <div class="ml-8">
                            <p class="pb-1 mb-0">Target Budget</p>
                            <h4 style="font-weight:600" class="mt-0 pt-0">
                              Rp 
                            </h4>
                          </div>
                        </div>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-card class="rounded-l" outlined>
                  <v-card-text class="p-4">
                    <v-row>
                      <v-col cols="12">
                        <div class="d-flex">
                          <v-icon color="#2083b4">
                            mdi-currency-usd
                          </v-icon>
                          <div class="ml-8">
                            <p class="pb-1 mb-0">Alokasi Budget</p>
                            <h4 style="font-weight:600" class="mt-0 pt-0">
                              Rp 
                            </h4>
                          </div>
                        </div>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-col>
              <v-col cols="12" sm="6" md="4">
                <v-card class="rounded-l" outlined>
                  <v-card-text class="p-4">
                    <v-row>
                      <v-col cols="12">
                        <div class="d-flex">
                          <v-icon color="#2083b4">
                            mdi-currency-usd
                          </v-icon>
                          <div class="ml-8">
                            <p class="pb-1 mb-0">Total Paid Budget</p>
                            <h4 style="font-weight:600" class="mt-0 pt-0">
                              Rp 
                            </h4>
                          </div>
                        </div>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>
            <v-row class="mt-5">
              <v-col cols="12" sm="8" md="8">
                <v-card class="rounded-l" outlined>
                  <v-card-text class="p-4 mb-5">
                    <v-row>
                      <v-col cols="12">
                        <h6 class="pb-1 mb-5" style="font-weight:600">Budget</h6>
                        <div id="chartContainer" style="height: 375px; width: 100%;"></div>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-col>
              <v-col cols="12" sm="4" md="4">
                <v-card class="rounded-l" outlined>
                  <v-card-text class="p-4">
                    <v-row>
                      <v-col cols="12">
                        <h6 class="pb-1 mb-5" style="font-weight:600">Balance Sheet</h6>
                      </v-col>
                      <v-divider class="mt-0 pt-0 mb-0 pb-0"></v-divider>
                      <v-col cols="12">
                        <v-card class="rounded-xl cyan lighten-5" outlined>
                          <v-card-text class="p-3">
                            <div class="d-flex">
                              <v-icon color="primary">
                                mdi-application-outline
                              </v-icon>
                              <div class="ml-3">
                                Asset
                              </div>
                            </div>
                            <div class="d-flex mt-1">
                              <h6 class="text-primary" style="font-weight:600">Rp </h6>
                            </div>
                          </v-card-text>
                        </v-card>
                      </v-col>
                      <v-col cols="12" class="mt-0">
                        <v-card class="rounded-xl orange lighten-5" outlined>
                          <v-card-text class="p-3">
                            <div class="d-flex">
                              <v-icon color="orange">
                                mdi-clipboard
                              </v-icon>
                              <div class="ml-3">
                                Liabilities
                              </div>
                            </div>
                            <div class="d-flex mt-1">
                              <h6 class="text-orange" style="font-weight:600">Rp</h6>
                            </div>
                          </v-card-text>
                        </v-card>
                      </v-col>
                      <v-col cols="12" class="mt-0">
                        <v-card class="rounded-xl purple lighten-5" outlined>
                          <v-card-text class="p-3">
                            <div class="d-flex">
                              <v-icon color="purple">
                                mdi-poll
                              </v-icon>
                              <div class="ml-3">
                                Expanse
                              </div>
                            </div>
                            <div class="d-flex mt-1">
                              <h6 class="text-purple" style="font-weight:600">Rp </h6>
                            </div>
                          </v-card-text>
                        </v-card>
                      </v-col>
                      <v-col cols="12" class="mt-0">
                        <v-card class="rounded-xl green lighten-5" outlined>
                          <v-card-text class="p-3">
                            <div class="d-flex">
                              <v-icon color="green">
                                mdi-poll
                              </v-icon>
                              <div class="ml-3">
                                Income
                              </div>
                            </div>
                            <div class="d-flex mt-1">
                              <h6 class="text-green" style="font-weight:600">Rp </h6>
                            </div>
                          </v-card-text>
                        </v-card>
                      </v-col>
                    </v-row>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
        </v-col>
      </v-row>
  </v-container>



            <!-- CONTENT AREA -->
            

         
  


            <!-- CONTENT AREA -->

        </div>
    </div>
    <!--  END CONTENT AREA  -->
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    }
}
</script>