<template>
    <AdminLayout>
        <HeadingPage
            title="Expedientes de Jefatura"
            subtitle="Nuevo expedietn jefatura"
        >
        </HeadingPage>
        <v-container fluid>
            <v-form ref="formRef" @submit.prevent="submit">
                <v-row>
                    <v-col cols="12" md="8">
                        <CardToolbar v-if="externo" title="Remitente">
                            <v-row class="py-3">
                                <v-col cols="12" class="d-flex">
                                    <simple-autocomplete
                                        v-model="persona"
                                        url="/autocomplete/personas"
                                        item-title="pers_nombre"
                                        item-value="pers_id"
                                        label="Buscar Persona"
                                        return-object
                                        itemCustom
                                        :error-messages="
                                            form.errors.expe_pers_id
                                        "
                                        @update:modelValue="
                                            $event
                                                ? (form.expe_pers_id =
                                                      $event?.pers_id)
                                                : (form.expe_pers_id = null)
                                        "
                                    >
                                        <template
                                            v-slot:custom="{ props, item }"
                                        >
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
                                                @onSubmit="persona = $event"
                                                url="/a/personas"
                                                :formStructure="
                                                    formPersonaStructure
                                                "
                                            />
                                        </template>
                                    </BtnDialog>
                                </v-col>

                                <template v-if="persona?.pers_id">
                                    <v-col cols="12" md="6" class="py-2">
                                        <v-list-item>
                                            <v-list-item-subtitle>
                                                Nombre y Apellidos
                                            </v-list-item-subtitle>
                                            <v-list-item-title>
                                                {{ persona?.pers_nombre }}
                                                {{ persona?.pers_paterno }}
                                                {{ persona?.pers_materno }}
                                            </v-list-item-title>
                                        </v-list-item>
                                    </v-col>

                                    <v-col cols="12" md="6" class="py-2">
                                        <v-list-item>
                                            <v-list-item-subtitle>
                                                DNI
                                            </v-list-item-subtitle>
                                            <v-list-item-title>
                                                {{ persona?.pers_dni }}
                                            </v-list-item-title>
                                        </v-list-item>
                                    </v-col>

                                    <v-col cols="12" md="6" class="py-2">
                                        <v-list-item>
                                            <v-list-item-subtitle>
                                                Correo
                                            </v-list-item-subtitle>
                                            <v-list-item-title>
                                                {{ persona?.pers_correo }}
                                            </v-list-item-title>
                                        </v-list-item>
                                    </v-col>

                                    <v-col cols="12" md="6" class="py-2">
                                        <v-list-item>
                                            <v-list-item-subtitle>
                                                Celular
                                            </v-list-item-subtitle>
                                            <v-list-item-title>
                                                {{ persona?.pers_celular }}
                                            </v-list-item-title>
                                        </v-list-item>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        class="py-2 d-flex justify-end"
                                    >
                                        <BtnDialog title="Nuevo" width="600px">
                                            <template
                                                v-slot:activator="{ dialog }"
                                            >
                                                <v-btn
                                                    @click="dialog"
                                                    prepend-icon="mdi-pencil"
                                                    class="ms-2"
                                                    variant="outlined"
                                                >
                                                    Actualizar datos
                                                </v-btn>
                                            </template>
                                            <template
                                                v-slot:content="{ dialog }"
                                            >
                                                <FormularioPersona
                                                    @on-cancel="dialog"
                                                    @onSubmit="persona = $event"
                                                    :formStructure="
                                                        formPersonaStructure
                                                    "
                                                    :form-data="persona"
                                                    :edit="true"
                                                    :url="
                                                        '/a/personas/' +
                                                        persona.pers_id
                                                    "
                                                />
                                            </template>
                                        </BtnDialog>
                                    </v-col>
                                </template>
                            </v-row>
                        </CardToolbar>

                        <CardToolbar v-else title="Remitente">
                            <v-row>
                                <v-col cols="12" md="6" class="py-2">
                                    <v-list-item>
                                        <v-list-item-subtitle>
                                            Nombre y Apellidos
                                        </v-list-item-subtitle>
                                        <v-list-item-title>
                                            {{ user.name }}
                                        </v-list-item-title>
                                    </v-list-item>
                                </v-col>

                                <v-col cols="12" md="6" class="py-2">
                                    <v-list-item>
                                        <v-list-item-subtitle>
                                            Correo
                                        </v-list-item-subtitle>
                                        <v-list-item-title>
                                            {{ user.email }}
                                        </v-list-item-title>
                                    </v-list-item>
                                </v-col>

                                <v-col cols="12" md="12" class="py-2">
                                    <v-list-item>
                                        <v-list-item-subtitle>
                                            Oficina
                                        </v-list-item-subtitle>
                                        <v-list-item-title>
                                            {{ user.ofic_name }}
                                        </v-list-item-title>
                                    </v-list-item>
                                </v-col>
                            </v-row>
                        </CardToolbar>

                        <CardToolbar title="Resumen">
                            <v-row class="py-3">
                                <v-col cols="5">
                                    <v-select
                                        v-model="form.expe_proc_id"
                                        @update:model-value="changeProceso"
                                        :items="procesos"
                                        label="Tramite (Proceso)"
                                        item-title="proc_nombre"
                                        item-value="proc_id"
                                        :error-messages="
                                            form.errors.expe_proc_id
                                        "
                                        @update:modelValue="getNumeroDocumento"
                                    />
                                </v-col>

                                <v-col cols="5">
                                    <v-select
                                        v-model="form.expe_docu_id"
                                        :items="documentos"
                                        label="Tipo de documento"
                                        item-title="docu_nombre"
                                        item-value="docu_id"
                                        :error-messages="
                                            form.errors.expe_docu_id
                                        "
                                        @update:modelValue="getNumeroDocumento"
                                    />
                                </v-col>

                                <v-col cols="2">
                                    <v-text-field
                                        v-model="form.expe_numero"
                                        label="Número"
                                        :error-messages="
                                            form.errors.expe_numero
                                        "
                                    />
                                </v-col>

                                <v-col cols="2">
                                    <v-text-field
                                        v-model="form.expe_folios"
                                        label="Folios"
                                        :error-messages="
                                            form.errors.expe_folios
                                        "
                                    />
                                </v-col>

                                <v-col cols="3">
                                    <v-text-field
                                        v-model="form.expe_periodo"
                                        label="Periodo"
                                        :error-messages="
                                            form.errors.expe_periodo
                                        "
                                    />
                                </v-col>

                                <v-col cols="3">
                                    <v-text-field
                                        v-model="form.expe_sigla"
                                        label="Sigla"
                                        :error-messages="form.errors.expe_sigla"
                                    />
                                </v-col>

                                <v-col cols="4">
                                    <v-text-field
                                        type="date"
                                        v-model="form.expe_fecha_registro"
                                        label="Fecha de registro"
                                        :error-messages="
                                            form.errors.expe_fecha_registro
                                        "
                                    />
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field
                                        v-model="form.expe_asunto"
                                        label="Asunto"
                                        :error-messages="
                                            form.errors.expe_asunto
                                        "
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <v-textarea
                                        v-model="form.expe_resumen"
                                        label="Resumen"
                                        rows="2"
                                        :error-messages="
                                            form.errors.expe_resumen
                                        "
                                    />
                                </v-col>
                            </v-row>
                        </CardToolbar>

                        <CardToolbar
                            title="Destinatario"
                            :loading="loadingSelectOficina"
                        >
                            <v-select
                                class="mt-3"
                                v-model="selectOficina"
                                @update:model-value="selectedOficina"
                                :items="oficinas"
                                label="Seleccione una oficina"
                                item-title="ofic_nombre"
                                item-value="ofic_id"
                                return-object
                                :error-messages="form.errors.destinatarios"
                            />

                            <v-table>
                                <thead>
                                    <tr>
                                        <th class="text-left">
                                            <small class="font-weight-bold">{{
                                                "Oficina".toUpperCase()
                                            }}</small>
                                        </th>
                                        <th class="text-left">
                                            <small class="font-weight-bold">{{
                                                "Usuario".toUpperCase()
                                            }}</small>
                                        </th>
                                        <th class="text-left font-weight-bold">
                                            <small>{{
                                                "Opciones".toUpperCase()
                                            }}</small>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr
                                        v-for="(
                                            item, index
                                        ) in form.destinatarios"
                                        :key="index"
                                    >
                                        <td>
                                            <small>
                                                {{ item.ofic_nombre }}
                                            </small>
                                        </td>
                                        <td>
                                            <v-select
                                                density="compact"
                                                clearable
                                                v-model="item.para"
                                                :items="item.personal"
                                                multiple
                                                chips
                                                label="Para"
                                                item-title="name"
                                                item-value="id"
                                                :error-messages="
                                                    form.errors[
                                                        `destinatarios.${index}.para`
                                                    ]
                                                "
                                            >
                                            </v-select>
                                        </td>
                                        <td class="text-left">
                                            <v-btn
                                                prepend-icon="mdi-delete-outline"
                                                text="quitar"
                                                variant="tonal"
                                                color="red"
                                                @click="
                                                    () => {
                                                        form.destinatarios.splice(
                                                            index,
                                                            1
                                                        );
                                                    }
                                                "
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </v-table>
                        </CardToolbar>
                    </v-col>
                    <v-col cols="12" md="4">
                        <CardToolbar title="Documentos">
                            <v-list-item>
                                <v-list-item-title>
                                    Documento
                                </v-list-item-title>

                                <v-list-item-subtitle>
                                    <v-checkbox
                                        v-model="firmaDigital"
                                        label="Firma Digital"
                                    ></v-checkbox>
                                    <template v-if="!firmaDigital">
                                        <v-file-input
                                            @change="handleFileChangeDoc"
                                            v-model="form.expe_archivo"
                                            show-size
                                            single
                                            :clearable="false"
                                            label="Seleccione el documento"
                                            accept="application/pdf"
                                            :error-messages="
                                                form.errors.expe_archivo
                                            "
                                        ></v-file-input>
                                    </template>
                                </v-list-item-subtitle>
                            </v-list-item>

                            <v-card variant="tonal">
                                <v-list-item
                                    v-for="(file, fileIndex) in fileListDocs"
                                    :key="file.name"
                                >
                                    <template v-slot:prepend>
                                        <a
                                            :href="file.url"
                                            target="_blank"
                                            class="me-3"
                                        >
                                            <v-icon
                                                color="red"
                                                icon="mdi-file-pdf-box"
                                            >
                                            </v-icon>
                                        </a>
                                    </template>

                                    <v-list-item-title>
                                        <small> {{ file.name }} </small>
                                    </v-list-item-title>
                                    <v-list-item-subtitle>
                                        {{ file.size }} bytes
                                    </v-list-item-subtitle>

                                    <v-list-item-subtitle class="text-red">
                                        <small>
                                            {{
                                                form.errors[
                                                    `expe_archivo.${fileIndex}`
                                                ]
                                            }}
                                        </small>
                                    </v-list-item-subtitle>

                                    <template v-slot:append>
                                        <v-btn
                                            icon="mdi-delete"
                                            density="compact"
                                            color="dark"
                                            variant="tonal"
                                            @click="deleteFileDoc(index)"
                                        >
                                        </v-btn>
                                    </template>
                                </v-list-item>
                            </v-card>

                            <v-list-item>
                                <v-list-item-title> Anexos </v-list-item-title>

                                <v-list-item-subtitle>
                                    <v-checkbox
                                        v-model="anexos"
                                        label="Anexos"
                                    ></v-checkbox>

                                    <template v-if="anexos">
                                        <v-card>
                                            <v-card-item class="">
                                                <v-file-input
                                                    v-model="form.expe_anexos"
                                                    class="my-2"
                                                    show-size
                                                    counter
                                                    multiple
                                                    :clearable="false"
                                                    label="Seleccione el documento"
                                                    accept="application/pdf"
                                                    :error-messages="
                                                        form.errors.expe_anexos
                                                    "
                                                    @change="
                                                        handleFileChangeAnex
                                                    "
                                                ></v-file-input>
                                            </v-card-item>
                                        </v-card>
                                    </template>
                                </v-list-item-subtitle>
                            </v-list-item>

                            <v-card variant="tonal">
                                <v-list-item
                                    v-for="(file, fileIndex) in fileListAnex"
                                    :key="file.name"
                                >
                                    <template v-slot:prepend>
                                        <v-icon
                                            color="red"
                                            icon="mdi-file-pdf-box"
                                        ></v-icon>
                                    </template>
                                    <v-list-item-title>{{
                                        file.name
                                    }}</v-list-item-title>
                                    <v-list-item-subtitle>
                                        {{ file.size }} bytes
                                    </v-list-item-subtitle>
                                    <v-list-item-subtitle class="text-red">
                                        <small>
                                            {{
                                                form.errors[
                                                    `expe_anexos.${fileIndex}`
                                                ]
                                            }}
                                        </small>
                                    </v-list-item-subtitle>

                                    <template v-slot:append>
                                        <v-btn
                                            icon="mdi-delete"
                                            density="compact"
                                            color="dark"
                                            variant="tonal"
                                            @click="deleteFileAnex(index)"
                                        >
                                        </v-btn>
                                    </template>
                                </v-list-item>
                            </v-card>
                        </CardToolbar>

                        <v-row>
                            <v-col cols="12">
                                <v-btn block type="submit"> guardar </v-btn>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-form>
        </v-container>
    </AdminLayout>
</template>
<script setup>
import axios from "axios";
import { ref, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useObjectUrl } from "@vueuse/core";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/components/HeadingPage.vue";
import CardToolbar from "@/components/CardToolbar.vue";
import BtnDialog from "@/components/BtnDialog.vue";
import SimpleAutocomplete from "@/components/SimpleAutocomplete.vue";

import FormularioPersona from "../Persona/components/Formulario.vue";

const props = defineProps({
    procesos: Array,
    documentos: Array,
    oficinas: Array,
    siglas: String,
    periodo: String,
    tipo: String,
    externo: Boolean,
});

const user = computed(() => usePage().props?.auth?.user);

const selectOficina = ref(null);
const loadingSelectOficina = ref(false);
const firmaDigital = ref(false);
const anexos = ref(true);

const persona = ref(null);

const form = useForm({
    expe_codigo: null, //back
    expe_password: null, //back
    expe_admin_id: usePage().props?.auth?.user.id,
    expe_pers_id: props.externo ? null : usePage().props?.auth?.user.pers_id,
    expe_ofic_id: usePage().props?.auth?.user.ofic_id,
    expe_remi_tipo: "NATURAL",
    expe_origen: 1, //interno = 1
    expe_numero: "",
    expe_periodo: props.periodo,
    expe_sigla: props.siglas,
    expe_tipo: props.tipo.toUpperCase(),
    expe_asunto: "",
    expe_resumen: "",
    expe_folios: "",
    expe_observacion: "",
    expe_fecha_registro: null,
    expe_plazo: "",
    expe_esta_id: 2,
    expe_proc_id: null,
    expe_docu_id: null,

    expe_archivo: null,
    expe_anexos: null,
    destinatarios: [],
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

const changeProceso = (newVal) => {
    let proseso = props.procesos.find((val) => newVal == val.proc_id);
    form.expe_docu_id = proseso.proc_docu_id;
};

const selectedOficina = async (newVal) => {
    if (form.destinatarios.some((item) => item.ofic_id === newVal.ofic_id))
        return;

    loadingSelectOficina.value = true;
    let res = await axios.get(
        "/a/expedientes/get-admins-by-ofic/" + newVal.ofic_id
    );

    let responsable = res.data.find(
        (item) => item.id === newVal.ofic_responsable
    );

    form.destinatarios.push({
        ...newVal,
        personal: res.data,
        para: responsable?.id ? [responsable?.id] : null,
    });

    loadingSelectOficina.value = false;

    setTimeout(() => {
        selectOficina.value = null;
    }, 50);
};

const getNumeroDocumento = async () => {
    let res = await axios.get("/a/expedientes/get-next-num-documento", {
        params: {
            docu: form.expe_docu_id,
            tipo: form.expe_tipo,
            sigla: form.expe_sigla,
        },
    });
    form.expe_numero = res.data;
};

const fileListDocs = ref([]);
const fileListAnex = ref([]);

const handleFileChangeDoc = (event) => {
    const files = event.target.files; // Obtén los archivos seleccionados
    const _fileList = []; // Array para almacenar los objetos de archivo

    // Recorre los archivos y crea un objeto para cada uno
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const fileObject = {
            url: useObjectUrl(file),
            name: file.name,
            size: file.size,
            type: file.type,
        };

        _fileList.push(fileObject); // Agrega el objeto de archivo al array
    }

    // Asigna el array fileList a una propiedad en el data del componente
    fileListDocs.value = _fileList;
};

const deleteFileDoc = (index) => {
    fileListDocs.value.splice(index, 1);
    form.expe_archivo.splice(index, 1);
};

const handleFileChangeAnex = (event) => {
    const files = event.target.files; // Obtén los archivos seleccionados
    const _fileList = []; // Array para almacenar los objetos de archivo

    // Recorre los archivos y crea un objeto para cada uno
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const fileObject = {
            name: file.name,
            size: file.size,
            type: file.type,
        };

        _fileList.push(fileObject); // Agrega el objeto de archivo al array
    }

    // Asigna el array fileList a una propiedad en el data del componente
    fileListAnex.value = _fileList;
};

const deleteFileAnex = (index) => {
    fileListAnex.value.splice(index, 1);
    form.expe_anexos.splice(index, 1);
};

const submit = () => {
    form.post("/a/expedientes", {
        onSuccess: (page) => {
            console.log("onSuccess");
            form.reset();
            fileListDocs.value = [];
            fileListAnex.value = [];
        },
        onError: (errors) => {
            console.log("onError");
        },
        onFinish: (visit) => {
            console.log("onFinish");
        },
    });
};
</script>
