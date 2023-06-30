<template>
    <SimpleForm
        :formularioJson="formStructure"
        v-model="form"
        @onCancel="$emit('onCancel')"
        @onSumbit="submit"
    >
    </SimpleForm>

    <v-card class="mt-4" v-if="edit">
        <v-toolbar density="compact">
            <v-toolbar-title> <small> Requisitos </small> </v-toolbar-title>
            <v-spacer></v-spacer>

            <BtnDialog title="Nuevo" width="600px">
                <template v-slot:activator="{ dialog }">
                    <v-btn color="info" @click="dialog">
                        Agregar Requisito
                    </v-btn>
                </template>
                <template v-slot:content="{ dialog }">
                    <SimpleForm
                        :formularioJson="formStructureRequisito"
                        v-model="formRequisito"
                        formId="prre"
                        @onSumbit="
                            submitRequisito();
                            dialog();
                        "
                    >
                        <!-- <template #actions>
                            <v-btn
                                type="button"
                                class="ms-2"
                                :loading="formRequisito.processing"
                                :disabled="!formRequisito.isDirty"
                                @click="submitRequisito()"
                                >Guardar</v-btn
                            >
                            <v-btn variant="tonal" color="red" @click="dialog">
                                cancelar
                            </v-btn>
                        </template> -->
                    </SimpleForm>
                </template>
            </BtnDialog>
        </v-toolbar>

        <v-card>
            <v-table fixed-header height="200px">
                <thead>
                    <tr>
                        <th class="text-left">Nombre</th>
                        <th class="text-left">Archivo</th>
                        <th class="text-left">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="item in formData.requisitos"
                        :key="item.prre_nombre"
                    >
                        <td>{{ item.prre_nombre }}</td>
                        <td>{{ item.prre_tipo_archivo }}</td>
                        <td>
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
                                                urlRequisito +
                                                    '/' +
                                                    item[
                                                        `${primaryKeyRequisito}`
                                                    ]
                                            )
                                    "
                                />
                                <v-icon
                                    size="x-small"
                                    icon="mdi-delete-empty"
                                ></v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>
    </v-card>
</template>

<script setup>
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import SimpleForm from "@/components/SimpleForm.vue";
import BtnDialog from "@/components/BtnDialog.vue";
import DialogConfirm from "@/components/DialogConfirm.vue";
const emit = defineEmits(["onCancel", "onSubmit"]);

const props = defineProps({
    formData: {
        type: Object,
        default: (props) =>
            props.formStructure?.reduce((acc, item) => {
                acc[item.key] = item.default;
                return acc;
            }, {}),
    },
    formStructure: {
        type: Array,
    },
    edit: {
        type: Boolean,
        default: false,
    },
    url: String,
});

const form = useForm({ ...props.formData });

const formStructureRequisito = [
    {
        key: "prre_nombre",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "prre_tipo_archivo",
        label: "Tipo de Archivo",
        type: "select",
        required: true,
        options: ["PDF", "WORD", "ZIP"],
        cols: 12,
        default: null,
    },
];

const formRequisito = useForm({
    ...formStructureRequisito?.reduce((acc, item) => {
        acc[item.key] = item.default;
        return acc;
    }, {}),
});

const urlRequisito = "/a/proceso-requisitos";
const primaryKeyRequisito = "prre_id";

const submitRequisito = async () => {
    formRequisito
        .transform((data) => ({
            ...data,
            prre_proc_id: form.proc_id,
        }))
        .post(urlRequisito, {
            onSuccess: (page) => {
                console.log("onSuccess formRequisito");
            },
            onError: (errors) => {
                console.log("onError formRequisito");
            },
            onFinish: (visit) => {
                console.log("onFinish formRequisito");
            },
        });
};

const submit = async () => {
    if (props.edit) form.put(props.url, option);
    else form.post(props.url, option);
};

const option = {
    onSuccess: (page) => {
        console.log("onSuccess");
        //console.log(page.props.flash.data);
        // formRequisito.prre_proc_id =
        if(!props.edit) emit("onCancel");
    },
    onError: (errors) => {
        console.log("onError");
    },
    onFinish: (visit) => {
        console.log("onFinish");
    },
};
</script>
