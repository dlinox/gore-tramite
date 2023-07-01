<template>
    <AdminLayout>
        <HeadingPage title="Expedientes" subtitle="Bandeja de entrada">
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
                        <template v-slot:action="{ item }">
                            <div class="d-flex">
                                <v-menu
                                    location="end"
                                    :open-on-hover="!mobile"
                                >
                                    <template v-slot:activator="{ props }">
                                        <v-btn
                                            v-bind="props"
                                            prepend-icon="mdi-plus"
                                            variant="tonal"
                                            density="compact"
                                            icon="mdi-dots-vertical"
                                            
                                        >
                                        </v-btn>
                                    </template>
                                    <v-list density="compact" rounded="0">
                                        <v-list-item
                                            v-for="(item, index) in menuNuevo"
                                            :key="index"
                                            :value="index"
                                            @click="router.get(item.route)"
                                        >
                                            <template v-slot:prepend>
                                                <v-icon :icon="item.icon">
                                                </v-icon>
                                            </template>

                                            <v-list-item-title>{{
                                                item.title
                                            }}</v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>

                                <v-btn
                                    class="text-caption"
                                    density="comfortable"
                                    variant="tonal"
                                    color="light-blue-darken-4"
                                >
                                    <v-icon start color=""
                                        >mdi-card-search-outline</v-icon
                                    >
                                    {{ item.expe_codigo }}
                                </v-btn>
                            </div>
                        </template>

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
const primaryKey = "ofic_id";

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
