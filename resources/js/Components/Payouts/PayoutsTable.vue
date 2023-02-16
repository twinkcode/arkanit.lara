<template>
  <v-alert
      v-if="hasError"
      style="position: absolute;top:calc(50% - (200px));left:calc(50% - (50vw / 2));width: 50vw;height: auto;z-index: 2000"
      color="#C51162ca"
      theme="dark"
      icon="mdi-alert-octagram"
      border
  >
    <v-alert-title>Error <v-spacer></v-spacer><v-btn icon="mdi-close" @click="hasError = false"></v-btn></v-alert-title>
    <pre>
        {{ errorMsg.response.data}}
      </pre>
  </v-alert>
  <div>
    <v-data-table
        :headers="headers"
        :items="payouts"
        :items-length="totalPayouts"
        :loading="loading"
        :items-per-page="itemsPerPage"
        item-value="id"
        class="elevation-1"
        @update:options="options = $event"
    >
      <!--      density="compact"-->
      <template v-slot:item="{ item }">
        <tr :key="item.columns.id">
          <td>{{ item.columns.id }}</td>
          <td>{{ item.columns.user_id }}</td>
          <td>{{ item.columns.details }}</td>
          <td>{{ item.columns.amount }}</td>
          <td>{{ item.columns.currency }}</td>
          <td>
            <v-menu>
              <template v-slot:activator="{ props }">
                <v-btn v-bind="props">{{ item.columns.status ? 'Оплачен' : 'Не оплачен' }}
                  <v-icon size="15" icon="mdi-chevron-double-down"></v-icon>
                </v-btn>
              </template>

              <v-list>
                <v-list-item @click="changeStatus(item.columns,true)">
                  <v-list-item-title>Оплачен</v-list-item-title>
                </v-list-item>
                <v-list-item @click="changeStatus(item.columns,false)">
                  <v-list-item-title>Не оплачен</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>


          </td>
        </tr>
      </template>
      <template v-slot:bottom>
        <div class="flex justify-between align-center border-2 border-t-orange-300">
          <PayoutsModal v-if="users.length > 0" :users="users" @payout-added="addPayout"/>
          <div class="text-center w-75 pt-2">
            <v-pagination

                v-model="page"
                :length="options.pageCount"
                circle
                @click="getDataFromApi"
            />
          </div>
          <div style="width: 150px;float: right">
            <v-text-field
                :model-value="itemsPerPage"
                class="pa-1"
                label="Items per page"
                type="number"
                min="1"
                variant="solo"
                @update:model-value="itemsPerPage = parseInt($event, 10)"
            ></v-text-field>
          </div>
        </div>
      </template>

    </v-data-table>


  </div>
</template>

<script>
import {VDataTable} from 'vuetify/labs/VDataTable'
import PayoutsModal from '@/Components/Payouts/PayoutsModal.vue'

export default {
  name: "PayoutsTable",
  components: {VDataTable, PayoutsModal},
  data() {
    return {
      modalShow: false,
      hasError: false,
      errorMsg: '',
      users: [],
      options: {
        pageCount: 1,
      },
      page: 1,
      itemsPerPage: 5,
      totalPayouts: 0,
      payouts: [],
      loading: true,
      headers: [
        {
          title: 'id',
          align: 'start',
          sortable: false,
          key: 'id',
        },
        {title: 'Имя пользователя', key: 'user_id'},
        {title: 'Реквизиты', key: 'details'},
        {title: 'Сумма', key: 'amount'},
        {title: 'Валюта', key: 'currency'},
        {title: 'Статус заявки', key: 'status'},
      ],
    }
  },
  watch: {
    options: {
      handler() {
        this.getDataFromApi()
      },
      deep: true,
    },
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    getUsers() {
      axios.get('/api/users').then(response => {
        this.users = response.data;
        this.getDataFromApi()
      }).catch(e => {
        this.hasError = true
        this.errorMsg = e
      });
    },
    async addPayout(form) {
      const response = await axios.post('/api/payouts', {...form})
          .catch(e => {
            this.hasError = true
            this.errorMsg = e
          });
    },
    async changeStatus(col, status) {
      const response = await axios.put('/api/payouts/' + col.id, {status: status})
          .catch(e => {
            this.hasError = true
            this.errorMsg = e
          });
      this.payouts.find(v => v.id === col.id).status = response.status;
      this.getDataFromApi()
    },
    getDataFromApi() {
      this.loading = true
      this.apiCall().then(data => {
        this.payouts = data.items
        this.totalPayouts = data.total
        this.options.pageCount = data.last_page
        this.loading = false
      })
    },

    apiCall() {
      return new Promise(async (resolve, reject) => {
        // const {sortBy = [], page, itemsPerPage} = this.options
        const response = await axios.get('/api/payouts', {
          params: {
            itemsPerPage: this.itemsPerPage,
            page: this.page,
          }
        }).catch(e => {
          this.hasError = true
          this.errorMsg = e
        });
        const items = response.data.data
        const total = response.data.meta.total
        const last_page = response.data.meta.last_page
        resolve({
          items,
          total,
          last_page,
        })

      })
    },

  },
}
</script>

<style scoped>

</style>
