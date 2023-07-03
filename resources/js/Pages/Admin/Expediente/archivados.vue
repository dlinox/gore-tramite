<template>
  <AdminLayout>
      <HeadingPage title="Expedientes archivados" subtitle="Expedientes">
        
      </HeadingPage>
      <v-container fluid>
          <v-card>
              <v-card-item>
                  <DataTable :headers="headers" :items="items" with-action actions-start :url="url">
                      <template v-slot:header="{ filter }">
                          <v-row class="py-3" justify="end">
                              <v-col cols="6">
                                  <v-text-field v-model="filter.search" label="Buscar" />
                              </v-col>
                          </v-row>
                      </template>

                      <template v-slot:action="{ item }">
                          <div class="d-flex">
                              <template v-if="item.tram_esta_id === 5">
                                  <v-btn class="text-caption" density="comfortable" variant="tonal"
                                      color="indigo-accent-4">
                                      <DialogConfirm title="RECIBIR EXPEDIENTE" text="¿Seguro de recibir este expediente?"
                                          @onConfirm="() =>
                                                  router.post(
                                                      url + '/recibir',

                                                      {
                                                          tramite:
                                                              item.tram_id,
                                                      }
                                                  )
                                              " />

                                      <v-icon start color="">
                                          mdi-send-check-outline
                                      </v-icon>
                                      Recibir
                                  </v-btn>
                              </template>
                              <template v-else>
                                  <v-btn class="text-caption" density="comfortable" variant="tonal" color="teal-darken-1"
                                      @click="() =>
                                              router.get(url + '/' + item.tram_id + '/revisar')
                                          ">
                                      <v-icon start color="">
                                          mdi-send-check-outline
                                      </v-icon>
                                      Ver
                                  </v-btn>
                              </template>

                              <v-btn class="text-caption" density="comfortable" variant="tonal"
                                  color="blue-grey-darken-2">
                                  <v-icon start color="">mdi-card-search-outline</v-icon>
                                  {{ item.expe_codigo }}
                              </v-btn>
                          </div>
                      </template>

                      <template v-slot:item.expe_proc_id="{ item }">
                          {{ item.proceso.proc_nombre }}
                      </template>

                      <template v-slot:item.tram_esta_nombre="{ item }">
                          <v-chip label color="black">
                              <small>
                                  {{ item.tram_esta_nombre }}
                              </small>
                          </v-chip>
                      </template>

                      <template v-slot:item.expe_pers_id="{ item }">
                          <v-list-item
                              :title="`${item.persona.pers_nombre} ${item.persona.pers_paterno} ${item.persona.pers_materno}`"
                              :subtitle="item.persona.pers_dni">
                          </v-list-item>
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
import { useDisplay } from "vuetify";
const { mobile } = useDisplay();

const props = defineProps({
  items: Object,
  headers: Array,
  filters: Object,
  perPageOptions: Array,
});

const url = "/a/expedientes";
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

const recibirTramte = (item) => { };
</script>
