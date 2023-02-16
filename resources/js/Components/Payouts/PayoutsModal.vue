<template>
  <v-row justify="center">
    <v-dialog
        v-model="dialog"
        persistent
        width="80vw"
    >
      <template v-slot:activator="{ props }">
        <v-btn
            color="primary"
            v-bind="props"
        >
          Добавить заявку на выплату
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="text-h5">Добавление заявки на выплату</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-autocomplete
                    :items="$props.users"
                    color="white"
                    item-title="name"
                    item-value="id"
                    v-model="form.user_id"
                    variant="solo"
                    label="User"
                ></v-autocomplete>
              </v-col>
              <v-col cols="12">
                <v-textarea
                    name="input-7-1"
                    variant="filled"
                    label="details"
                    auto-grow
                    v-model="form.details"
                ></v-textarea>
              </v-col>
              <v-col
                  cols="12"
                  sm="4"
              >
                <v-text-field
                    class="pa-1"
                    label="amount"
                    type="number"
                    min="1"
                    variant="solo"
                    v-model="form.amount"
                ></v-text-field>
              </v-col>
              <v-col
                  cols="12"
                  sm="4"
              >
                <v-text-field
                    class="pa-1"
                    label="Currency"
                    variant="solo"
                    v-model="form.currency"
                ></v-text-field>
              </v-col>
              <v-col
                  cols="12"
                  sm="4"
              >
                <v-select
                    :items="[{name:'Не оплачено',id:0}, {name:'Оплачено',id:1}]"
                    class="pa-1"
                    item-title="name"
                    item-value="id"
                    label="Status"
                    variant="solo"
                    v-model="form.status"
                ></v-select>
              </v-col>

            </v-row>
          </v-container>
          <small>*Обязательные к заполнению поля</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
              color="blue-darken-1"
              variant="text"
              @click="dialog = false"
          >
            Закрыть
          </v-btn>
          <v-btn
              color="blue-darken-1"
              variant="text"
              @click="formSubmit"

          >
            Сохранить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  name: "PayoutsModal",

  data: () => ({
    dialog: false,
    form: {
      user_id: null,
      details: null,
      amount: null,
      currency: null,
      status: 0,
    }
  }),
  props: {
    users: Array
  },
  methods: {
    formSubmit() {
      this.dialog = false;
      this.$emit('payout-added', this.form)
    }
  }
}
</script>
