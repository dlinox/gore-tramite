<template>
    <AdminLayout>
        <HeadingPage title="Proceso" subtitle="Listado de procesos">
            <template #actions>
                <BtnDialog title="Nuevo" width="600px">
                    <template v-slot:activator="{ dialog }">
                        <v-btn
                            @click="dialog"
                            prepend-icon="mdi-plus"
                            variant="flat"
                        >
                            Nuevo
                        </v-btn>
                    </template>
                    <template v-slot:content="{ dialog }">
                        <Formulario
                            @on-cancel="dialog"
                            :url="url"
                            :formStructure="formStructure"
                        />
                        
                    </template>
                </BtnDialog>
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
                        <template v-slot:item.proc_plazo="{ item }">
                            {{item.proc_plazo}} dia(s)
                        </template>
                        <template v-slot:item.documento="{ item }">
                            {{item.documento.docu_nombre}}
                        </template>
                        <template v-slot:action="{ item }">
                            <BtnDialog title="Editar" width="600px">
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
                                    <Formulario
                                        @on-cancel="dialog"
                                        :form-data="item"
                                        :formStructure="formStructure"
                                        :edit="true"
                                        :url="url + '/' + item[`${primaryKey}`]"
                                    />
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
import { router } from "@inertiajs/vue3";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";
import BtnDialog from "@/components/BtnDialog.vue";
import DataTable from "@/components/DataTable.vue";
import DialogConfirm from "@/components/DialogConfirm.vue";
import Formulario from "./components/Formulario.vue";

const props = defineProps({
    items: Object,
    itemsDocuments: Array,
    headers: Array,
    filters: Object,
    perPageOptions: Array,
});

const url = "/a/procesos";
const primaryKey = "proc_id";
const formStructure = [
    {
        key: "proc_nombre",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    // {
    //     key: "proc_descripcion",
    //     label: "Descripción",
    //     type: "textarea",
    //     required: false,
    //     cols: 12,
    //     default: "",
    // },

    {
        key: "proc_docu_id",
        label: "Documento",
        type: "combobox",
        options: props.itemsDocuments,
        itemTitle: "docu_nombre",
        itemValue: "docu_id",
        required: true,
        colMd: 8,
        default: "",
    },

    {
        key: "proc_plazo",
        label: "Plazo (dias)",
        type: "number",
        required: false,
        colMd: 4,
        default: 0,
    },

    {
        key: "proc_activo",
        label: "Activo",
        type: "checkbox",
        required: false,
        colMd: 6,
        default: true,
    },
];


</script>
