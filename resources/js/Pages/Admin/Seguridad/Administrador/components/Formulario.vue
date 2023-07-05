<template>
    <SimpleForm
        :formularioJson="formStructure"
        v-model="form"
        @onCancel="$emit('onCancel')"
        @onSumbit="submit"
    >
        <template #field.pers_id>
            <div class="d-flex">
                <simple-autocomplete
                    v-model="persona"
                    url="/autocomplete/personas"
                    item-title="pers_nombre"
                    item-value="pers_id"
                    label="Buscar Persona"
                    itemCustom
                    return-object
                    @update:modelValue="setDataPersona"
                    :error-messages="form.errors.pers_id"
                >
                    <template v-slot:custom="{ props, item }">
                        <v-list-item
                            v-bind="props"
                            :title="`${item?.raw?.pers_nombre} ${item?.raw?.pers_paterno} ${item?.raw?.pers_materno}`"
                            :subtitle="item?.raw?.pers_dni"
                        ></v-list-item>
                    </template>
                </simple-autocomplete>

                <BtnDialog title="Nuevo" width="600px">
                    <template v-slot:activator="{ dialog }">
                        <v-btn
                            @click="dialog"
                            prepend-icon="mdi-plus"
                            class="ms-2"
                            variant="tonal"
                            size="large"
                        >
                            Nuevo
                        </v-btn>
                    </template>
                    <template v-slot:content="{ dialog }">
                        <FormularioPersona
                            @on-cancel="dialog"
                            @onSubmit="form.pers_id = $event.pers_id"
                            url="/a/personas"
                            :formStructure="formPersonaStructure"
                        />
                    </template>
                </BtnDialog>
            </div>
        </template>
    </SimpleForm>
    <pre>
        {{ form }}
    </pre>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import SimpleForm from "@/components/SimpleForm.vue";
import BtnDialog from "@/components/BtnDialog.vue";
import SimpleAutocomplete from "@/components/SimpleAutocomplete.vue";
import FormularioPersona from "../../../Persona/components/Formulario.vue";

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

const formPersonaStructure = [
    {
        key: "pers_nombre",
        label: "Nombre",
        type: "text",
        required: true,
        cols: 12,
        default: "",
    },
    {
        key: "pers_paterno",
        label: "Paterno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },
    {
        key: "pers_materno",
        label: "Materno",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },
    {
        key: "pers_dni",
        label: "DNI",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },
    {
        key: "pers_ruc",
        label: "RUC",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },
    {
        key: "pers_celular",
        label: "Celular",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },
    {
        key: "pers_correo",
        label: "Correo",
        type: "text",
        required: true,
        cols: 12,
        colMd: 6,
        default: "",
    },
];


const persona = ref();

const form = useForm({ ...props.formData });

const setDataPersona =  (val) => {

    console.log(val);
    form.pers_id = val.pers_id;
    form.name =  `${val.pers_nombre} ${val.pers_paterno} ${val.pers_materno}`;
    form.email = val.pers_correo;
}

const submit = async () => {
    if (props.edit) form.put(props.url, option);
    else form.post(props.url, option);
};

const option = {
    onSuccess: (page) => {
        console.log("onSuccess");
        emit("onCancel");
    },
    onError: (errors) => {
        console.log("onError");
    },
    onFinish: (visit) => {
        console.log("onFinish");
    },
};
</script>
