<template>
  <AdminLayout>
      <HeadingPage title="Expedientes" subtitle="Bandeja de expedientes creados">
          <template #actions>
              <v-menu>
                  <template v-slot:activator="{ props }">
                      <v-btn
                          v-bind="props"
                          prepend-icon="mdi-plus"
                          variant="flat"
                      >
                          Nuevo
                      </v-btn>
                  </template>
                  <v-list density="compact">
                      <v-list-item
                          v-for="(item, index) in menuNuevo"
                          :key="index"
                          :value="index"
                          @click="router.get(item.route)"
                      >
                          <template v-slot:prepend>
                              <v-icon :icon="item.icon"> </v-icon>
                          </template>

                          <v-list-item-title>{{
                              item.title
                          }}</v-list-item-title>
                      </v-list-item>
                  </v-list>
              </v-menu>
          </template>
      </HeadingPage>
      <v-container fluid>
          <v-card>
              <v-card-item>
                  <DataTable
                      :headers="headers"
                      :items="items"
                      with-action
                      :url="url"
                  >
                      <template v-slot:header="{ filter }">
                          <v-row class="py-3" justify="end">
                              <v-col cols="6">
                                  <v-text-field
                                      v-model="filter.search"
                                      label="Buscar"
                                  />
                              </v-col>
                          </v-row>
                      </template>

                      <template v-slot:action="{ item }">
                          <BtnDialog title="Editar" width="500px">
                              <template v-slot:activator="{ dialog }">
                                  <v-btn
                                      color="info"
                                      icon
                                      variant="outlined"
                                      density="comfortable"
                                      @click="dialog"
                                  >
                                      <v-icon
                                          size="x-small"
                                          icon="mdi-pencil"
                                      ></v-icon>
                                  </v-btn>
                              </template>
                              <template v-slot:content="{ dialog }">
                                  <!-- <Formulario
                                      @on-cancel="dialog"
                                      :form-data="item"
                                      :formStructure="formStructure"
                                      :edit="true"
                                      :url="url + '/' + item[`${primaryKey}`]"
                                  /> -->
                              </template>
                          </BtnDialog>

                          <v-btn
                              icon
                              variant="outlined"
                              density="comfortable"
                              class="ml-1"
                              color="red"
                          >
                              <DialogConfirm
                                  @onConfirm="
                                      () =>
                                          router.delete(
                                              url +
                                                  '/' +
                                                  item[`${primaryKey}`]
                                          )
                                  "
                              />
                              <v-icon
                                  size="x-small"
                                  icon="mdi-delete-empty"
                              ></v-icon>
                          </v-btn>
                      </template>
                  </DataTable>
              </v-card-item>
          </v-card>
      </v-container>
      
  </AdminLayout>
</template>
<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";
import BtnDialog from "@/components/BtnDialog.vue";
import DataTable from "@/components/DataTable.vue";
import DialogConfirm from "@/components/DialogConfirm.vue";

const props = defineProps({
  items: Object,
  headers: Array,
  filters: Object,
  perPageOptions: Array,
});

const url = "/a/expedientes/emitidos";
const primaryKey = "expe_id";


const menuNuevo = [
  {
      title: "Jefatura",
      route: "/a/expedientes/jefatura/crear",
      icon: "mdi-office-building-outline",
  },
  {
      title: "Personal",
      route: "/a/expedientes/personal/crear/",
      icon: "mdi-account-tie",
  },

  {
      title: "Externo",
      route: "/a/expedientes/externo/crear",
      icon: "mdi-account-group-outline",
  },
];
</script>
