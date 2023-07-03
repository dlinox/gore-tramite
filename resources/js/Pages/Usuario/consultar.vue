<template>
    <div class="wrapper-login">
        <v-card class="mx-auto my-auto" max-width="400">
            <v-card-title class="pa-5">
                <Logo class="mx-auto"></Logo>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-item>
                <v-form>
                    <v-form ref="formRef" @submit.prevent="submit">
                        <v-row no-gutters>
                            <v-col cols="12" class="my-2">
                                <span class="text-overline my-5"
                                    >Consultar</span
                                >
                            </v-col>
                            <v-col cols="12" class="my-2">
                                <v-text-field
                                    v-model="form.codigo"
                                    prepend-inner-icon="mdi-file-outline"
                                    label="Codigo del Expediente"
                                />
                            </v-col>
                            <v-col cols="12" class="my-2">
                                <v-text-field
                                    v-model="form.password"
                                    type="password"
                                    label="Contraseña del expediente"
                                />
                            </v-col>
                            <v-col cols="12" class="my-2">
                                <v-btn
                                    type="submit"
                                    block
                                    variant="flat"
                                    append-icon="mdi-login-variant"
                                    :loading="form.processing"
                                >
                                    Consultar
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-form>
            </v-card-item>
        </v-card>
    </div>

    <v-snackbar v-model="snackbar" multi-line color="success">
        {{ flash.success }}

        <template v-slot:actions>
            <v-btn
                color="dark"
                variant="text"
                @click="snackbar = false"
                icon="mdi-close"
            ></v-btn>
        </template>
    </v-snackbar>

    <v-snackbar v-model="snackbarError" vertical multi-line color="error">
        <v-expansion-panels>
            <v-expansion-panel
                elevation="0"
                class="bg-transparent w-100"
                :text="error.details"
            >
                <v-expansion-panel-title
                    expand-icon="mdi-plus"
                    collapse-icon="mdi-minus"
                >
                    {{ error.error }}
                </v-expansion-panel-title>
            </v-expansion-panel>
        </v-expansion-panels>

        <template v-slot:actions>
            <v-btn
                class="px-3"
                color="white"
                variant="tonal"
                @click="snackbarError = false"
                prepend-icon="mdi-close"
            >
                Cerrar
            </v-btn>
        </template>
    </v-snackbar>
</template>
<script setup>
import Logo from "@/components/Logo.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";

const form = useForm({
    codigo: "",
    password: "",
});



const flash = computed(() => usePage().props?.flash);
const error = computed(() => usePage().props?.errors);

const snackbar = ref(false);
const snackbarError = ref(false);

watch(
    () => flash.value,
    (newValue) => {
        if (newValue && newValue.success) {
            snackbar.value = true;
        } else {
            snackbar.value = false;
        }
    }
);

watch(
    () => error.value,
    (newValue) => {
        if (newValue.details && newValue.error) {
            snackbarError.value = true;
        } else {
            snackbarError.value = false;
        }
    }
);

const submit = async () => {
    form.post("/consultar", {
        onError: (e) => {
            //console.log(e);
        },
        onSuccess: (e) => {
            //console.log(e);
            console.log("redireccionando");
        },
    });
};
</script>
<style lang="scss">
.wrapper-login {
    display: flex;
    width: 100vw;
    height: 100vh;
    align-items: center;
}
</style>
