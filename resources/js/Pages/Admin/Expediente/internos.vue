<template>
    <AdminLayout>
        <HeadingPage title="Expedientes Internos" subtitle="Expedientes">
            <template #actions>
                <v-menu location="start">
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
                        actions-start
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
                            <div class="d-flex">
                                <v-tooltip
                                    text="Editar"
                                    v-if="item.expe_editar"
                                >
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            v-bind:="props"
                                            icon
                                            class="text-caption"
                                            density="comfortable"
                                            variant="tonal"
                                            color="teal-darken-3"
                                            @click="
                                                () =>
                                                    router.get(
                                                        url +
                                                            '/' +
                                                            item.tram_id +
                                                            '/editar'
                                                    )
                                            "
                                        >
                                            <v-icon color="">
                                                mdi-file-edit-outline
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                </v-tooltip>

                                <v-tooltip text="Seguimiento">
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            v-bind:="props"
                                            class="text-caption"
                                            variant="tonal"
                                            color="blue-grey-darken-1"
                                        >
                                            <v-icon start color=""
                                                >mdi-card-search-outline</v-icon
                                            >
                                            {{ item.expe_codigo }}
                                        </v-btn>
                                    </template>
                                </v-tooltip>
                            </div>
                        </template>

                        <template v-slot:item.expe_proc_id="{ item }">
                            {{ item.proceso.proc_nombre }}
                        </template>

                        <template v-slot:item.expe_esta_id="{ item }">
                            <v-chip label color="black">
                                <small>
                                    {{ item.estado.esta_nombre }}
                                </small>
                            </v-chip>
                        </template>

                        <template v-slot:item.expe_pers_id="{ item }">
                            <v-list-item
                                :title="`${item.persona.pers_nombre} ${item.persona.pers_paterno} ${item.persona.pers_materno}`"
                                :subtitle="item.persona.pers_dni"
                            >
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

const url = "/a/expedientes/internos";
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
];

const recibirTramte = (item) => {};
</script>
