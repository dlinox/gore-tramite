<template>
    <SimpleForm
        :formularioJson="formStructure"
        v-model="form"
        @onCancel="$emit('onCancel')"
        @onSumbit="submit"
    >
        <template #field.docu_plantilla_file>
            <template
                v-if="
                    form.docu_plantilla_url &&
                    fileListDocs.length === 0 &&
                    filePreview
                "
            >
                <v-card variant="tonal">
                    <v-list-item>
                        <template v-slot:prepend>
                            <a
                                :href="form.docu_plantilla_url"
                                target="_blank"
                                class="me-3"
                            >
                                <v-icon color="red" icon="mdi-file-pdf-box">
                                </v-icon>
                            </a>
                        </template>

                        <v-list-item-title>
                            <small> {{ form.docu_plantilla }} </small>
                        </v-list-item-title>

                        <template v-slot:append>
                            <v-btn
                                icon="mdi-tray-arrow-up"
                                color="blue"
                                variant="tonal"
                                @click="filePreview = false"
                            >
                            </v-btn>
                        </template>
                    </v-list-item>
                </v-card>
            </template>
            <template v-else>
                <v-file-input
                    @change="handleFileChangeDoc"
                    v-model="form.docu_plantilla_file"
                    show-size
                    single
                    :clearable="false"
                    label="Seleccione el documento"
                    accept="application/pdf"
                    class="mb-1"
                    :error-messages="form.errors.docu_plantilla"
                >
                    <template v-if="form.docu_plantilla_url" #append>
                        <v-btn
                            icon="mdi-close"
                            size="small"
                            @click="cancelUpload"
                        />
                    </template>
                </v-file-input>

                <v-card variant="tonal">
                    <v-list-item
                        v-for="(file, fileIndex) in fileListDocs"
                        :key="file.name"
                    >
                        <template v-slot:prepend>
                            <a :href="file.url" target="_blank" class="me-3">
                                <v-icon color="red" icon="mdi-file-pdf-box">
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
                                {{ form.errors.docu_plantilla }}
                            </small>
                        </v-list-item-subtitle>

                        <template v-slot:append>
                            <v-btn
                                icon="mdi-delete"
                                density="compact"
                                color="dark"
                                variant="tonal"
                                @click="deleteFileDoc(fileIndex)"
                            >
                            </v-btn>
                        </template>
                    </v-list-item>
                </v-card>
            </template>
        </template>
    </SimpleForm>
</template>

<script setup>
import SimpleForm from "@/components/SimpleForm.vue";
import { useForm } from "@inertiajs/vue3";
import { useObjectUrl } from "@vueuse/core";
import { ref } from "vue";

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

const fileListDocs = ref([]);
const filePreview = ref(true);

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
    form.docu_plantilla_file.splice(index, 1);
};

const cancelUpload = () => {
    fileListDocs.value = [];
    form.docu_plantilla_file = null;
    filePreview.value = true;
};

const submit = async () => {
    form.transform((data) => ({
        ...data,
        docu_plantilla: data.docu_plantilla_file
            ? data.docu_plantilla_file[0]
            : null,
    })).post(props.url, option);
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
