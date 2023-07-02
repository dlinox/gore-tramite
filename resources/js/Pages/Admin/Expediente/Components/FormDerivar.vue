<template>
  <v-form ref="formRef" @submit.prevent="submit">
    <v-row>
      <v-col cols="12" class="py-2">

        <v-select class="mt-3" v-model="selectOficina" @update:model-value="selectedOficina" :items="oficinas"
          label="Seleccione una oficina" item-title="ofic_nombre" item-value="ofic_id" return-object
          :error-messages="form.errors.destinatarios" />

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
            <tr v-for="(
                                            item, index
                                        ) in form.destinatarios" :key="index">
              <td>
                <small>
                  {{ item.ofic_nombre }}
                </small>
              </td>
              <td>
                <v-select density="compact" clearable v-model="item.para" :items="item.personal" multiple chips
                  label="Para" item-title="name" item-value="id" :error-messages="form.errors[
                    `destinatarios.${index}.para`
                  ]
                    ">
                </v-select>
              </td>
              <td class="text-left">
                <v-btn prepend-icon="mdi-delete-outline" text="quitar" variant="tonal" color="red" @click="() => {
                  form.destinatarios.splice(
                    index,
                    1
                  );
                }
                  " />
              </td>
            </tr>
          </tbody>
        </v-table>

      </v-col>
      <v-col cols="12" class="py-2">
        <v-textarea v-model="form.observacion" label="Observación" :clearable="false" :rules="[isRequired]" />
      </v-col>

      <v-col cols="12" class="py-2">


        <v-file-input @change="handleFileChangeDoc" v-model="form.archivo" show-size single :clearable="false"
          label="Seleccione el documento" accept="application/pdf" :error-messages="form.errors.archivo
            ">
        </v-file-input>

        <v-card class="mt-2" variant="tonal">
          <v-list-item v-for="(file, fileIndex) in fileListDocs" :key="file.name">
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
                {{
                  form.errors[
                    `archivo.${fileIndex}`
                  ]
                }}
              </small>
            </v-list-item-subtitle>

            <template v-slot:append>
              <v-btn icon="mdi-delete" density="compact" color="dark" variant="tonal" @click="deleteFileDoc(index)">
              </v-btn>
            </template>
          </v-list-item>
        </v-card>

      </v-col>

      <v-col cols="6" class="py-2">
        <v-autocomplete v-model="form.accion" label="Accion" :items="acciones" item-title="acci_nombre"
          item-value="acci_id" :error-messages="form.errors.accion" :rules="[isRequired]" />
      </v-col>
      <v-col cols="6" class="py-2">
        <v-list-item color="primary" density="compact">
          <template v-slot:append>
            <v-switch v-model="form.notificar" color="primary"></v-switch>
          </template>

          <v-list-item-title> Notificar </v-list-item-title>
        </v-list-item>
      </v-col>
      <v-col cols="12" class="py-2 d-flex">
        <v-spacer></v-spacer>
        <v-btn type="button" color="red" variant="tonal" class="me-3">
          Cancelr
        </v-btn>
        <v-btn type="submit" :loading="form.processing" :disabled="!form.isDirty">
          Finalizar
        </v-btn>
      </v-col>

    </v-row>
  </v-form>
</template>
<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { isRequired } from "@/helpers/validations.js";
import { useObjectUrl } from "@vueuse/core";
import axios from 'axios';

const emit = defineEmits(["onCancel", "onSubmit"]);
const props = defineProps({
  item: Object,
  url: String,
  oficinas: Array,
  acciones: Array
});
const formRef = ref(null);

const fileListDocs = ref([]);
const firmaDigital = ref(false);

const selectOficina = ref(null);
const loadingSelectOficina = ref(false);

const form = useForm({
  tramite: props.item?.tram_id,
  expediente: props.item?.expe_id,
  codigo: props.item?.expe_codigo,
  notificar: false,
  archivo: null,
  observacion: "",
  accion: null,
  destinatarios: []
});


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
  form.archivo.splice(index, 1);
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

const submit = async () => {
  const { valid } = await formRef.value.validate();
  if (!valid) return;
  form.post(props.url, option);
  emit("onSubmit");
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
