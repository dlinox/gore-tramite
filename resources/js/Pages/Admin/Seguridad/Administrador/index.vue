<template>
    <AdminLayout>
        <HeadingPage title="Administradores" subtitle="Seguridad">
            <template #actions>
                <BtnDialog title="Nuevo" width="500px">
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
                        <template v-slot:item.active="{ item }">
                            <v-btn
                                variant="tonal"
                                class="ml-1"
                                :color="item.active ? 'blue' : 'orange'"
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
                                    :text="`Cambiar estado a ${
                                        item.active ? 'Inactivo' : 'Activo'
                                    }`"
                                />
                                {{ !item.active ? "Inactivo" : "Activo" }}
                            </v-btn>
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
                                        :formStructure="formStructure"
                                        :form-data="item"
                                        :edit="true"
                                        :url="url + '/' + item[`${primaryKey}`]"
                                    />
                                </template>
                            </BtnDialog>
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
    headers: Array,
    filters: Object,
    roles: Array,
    oficinas: Array,
});

const url = "/a/seguridad/administradores";
const primaryKey = "id";

const formStructure = [
    {
        key: "pers_id",
        label: "Buscar Persona",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },

    {
        key: "name",
        label: "Nombre",
        type: "text",
        readonly: true,
        required: true,
        clearable: false,
        cols: 12,
        default: "",
    },

    {
        key: "email",
        label: "Correo",
        type: "text",
        required: true,
        readonly:true,
        clearable: false,
        cols: 12,
        default: "",
    },

    {
        key: "rol_name",
        label: "Rol",
        type: "combobox",
        options: props.roles,
        itemTitle: "name",
        itemValue: "name",
        required: true,
        colMd: 12,
        default: "",
    },

    {
        key: "ofic_id",
        label: "Oficina",
        type: "combobox",
        options: props.oficinas,
        itemTitle: "ofic_nombre",
        itemValue: "ofic_id",
        required: true,
        colMd: 12,
        default: "",
    },

];
</script>
