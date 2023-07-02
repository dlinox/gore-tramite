<template>
  <v-form ref="formRef" @submit.prevent="submit">
    <v-row>

      <v-col cols="12" class="py-2">
        <v-textarea v-model="form.observacion" label="Observación" :clearable="false" :rules="[isRequired]" />
      </v-col>

      <v-col cols="12" class="py-2">
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
          Archivar
        </v-btn>
      </v-col>
    </v-row>
  </v-form>
</template>
<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { isRequired } from "@/helpers/validations.js";

const emit = defineEmits(["onCancel", "onSubmit"]);
const props = defineProps({
  item: Object,
  url: String,
});
const formRef = ref(null);
const form = useForm({
  tramite: props.item.tram_id,
  notificar: false,
  observacion: "",
});

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
