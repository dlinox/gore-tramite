<template>
    <AdminLayout>
        <HeadingPage :title="'Expediente E-' + tramite.expe_codigo">
            <template #actions>
                <v-btn class="ml-2" prepend-icon="mdi-timeline-text-outline">
                    Seguimiento
                </v-btn>

                <v-btn class="ml-2">
                    <v-icon>mdi-reload</v-icon>
                </v-btn>
            </template>
        </HeadingPage>

        <v-container fluid class="pt-0">
            <v-row>
                <v-col cols="12">
                    <v-card>
                        <v-card-item class="">
                            <v-row>
                                <v-col cols="12" md="4">
                                    <ItemDescription
                                        title="Estado"
                                        :description="`${tramite.tram_esta_nombre} | ${tramite.tram_fecha_recibido}`"
                                    />
                                </v-col>

                                <v-col cols="12" md="4">
                                    <ItemDescription title="Origen">
                                        <span class="text-grey">
                                            {{ tramite.admin?.ofic_name }}
                                        </span>
                                        - {{ tramite.admin?.name }}
                                    </ItemDescription>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <ItemDescription
                                        title="Origen"
                                        :description="
                                            tramite.tram_ofic_fin_nombre
                                        "
                                    />
                                </v-col>
                                <v-col cols="12" md="4">
                                    <ItemDescription
                                        title="Accion"
                                        :description="
                                            tramite.tram_acci_id ?? '-'
                                        "
                                    />
                                </v-col>
                                <v-col cols="12">
                                    <ItemDescription
                                        title="Asunto"
                                        :description="
                                            tramite.expe_asunto ?? '-'
                                        "
                                    />
                                </v-col>
                            </v-row>
                        </v-card-item>

                        <v-card-actions>
                            <v-spacer></v-spacer>

                            <BtnDialog title="Observar" width="400px">
                                <template v-slot:activator="{ dialog }">
                                    <v-btn
                                        class="px-3"
                                        variant="outlined"
                                        color="red-accent-3"
                                        prepend-icon="mdi-file-cancel-outline"
                                        @click="dialog"
                                    >
                                        Observar
                                    </v-btn>
                                </template>
                                <template v-slot:content="{ dialog }">
                                    <FormObservar
                                        @onCancel="dialog"
                                        :item="tramite"
                                        :url="`${url}observar`"
                                    />
                                </template>
                            </BtnDialog>

                            <BtnDialog title="derivar" width="800px">
                                <template v-slot:activator="{ dialog }">
                                    <v-btn
                                        class="px-3"
                                        variant="outlined"
                                        color="blue-darken-4"
                                        prepend-icon="mdi-file-arrow-left-right-outline"
                                        @click="dialog"
                                    >
                                        derivar
                                    </v-btn>
                                </template>
                                <template v-slot:content="{ dialog }">
                                    <FormDerivar
                                        @onCancel="dialog"
                                        :oficinas="oficinas"
                                        :acciones="acciones"
                                        :item="tramite"
                                        :url="`${url}derivar`"
                                    />
                                </template>
                            </BtnDialog>

                            <BtnDialog title="Archivar" width="400px">
                                <template v-slot:activator="{ dialog }">
                                    <v-btn
                                        class="px-3"
                                        variant="outlined"
                                        color="teal-accent-4"
                                        prepend-icon="mdi-file-clock-outline"
                                        @click="dialog"
                                    >
                                        Archivar
                                    </v-btn>
                                </template>
                                <template v-slot:content="{ dialog }">
                                    <FormArchivar
                                        @onCancel="dialog"
                                        :item="tramite"
                                        :url="`${url}archivar`"
                                    />
                                </template>
                            </BtnDialog>
                            <BtnDialog title="Finalizar" width="450px">
                                <template v-slot:activator="{ dialog }">
                                    <v-btn
                                        class="px-3"
                                        variant="outlined"
                                        color="green"
                                        prepend-icon="mdi-file-check-outline"
                                        @click="dialog"
                                    >
                                        finalizar
                                    </v-btn>
                                </template>
                                <template v-slot:content="{ dialog }">
                                    <FormFinalizar
                                        @onCancel="dialog"
                                        :item="tramite"
                                        :url="`${url}finalizar`"
                                    />
                                </template>
                            </BtnDialog>
                        </v-card-actions>
                    </v-card>
                </v-col>
                <v-col cols="12" md="7">
                    <v-row>
                        <v-col cols="12">
                            <v-card>
                                <v-toolbar density="compact">
                                    <v-toolbar-title class="text-overline">
                                        Datos del expediente
                                    </v-toolbar-title>
                                </v-toolbar>

                                <v-card-item>
                                    <v-row>
                                        <v-col cols="6">
                                            <ItemDescription
                                                title="Codigo del expediente"
                                                :description="`${tramite.expe_codigo}`"
                                            />
                                        </v-col>

                                        <v-col cols="6">
                                            <ItemDescription
                                                title="Fecha de registro"
                                                :description="`${tramite.expe_fecha_registro}`"
                                            />
                                        </v-col>

                                        <v-col cols="12">
                                            <ItemDescription
                                                title="Documento"
                                                :description="`${tramite.documento.docu_nombre} | ${tramite.expe_numero}-${tramite.expe_periodo}-${tramite.expe_sigla}`"
                                            />
                                        </v-col>

                                        <v-col cols="6">
                                            <ItemDescription
                                                title="Folios"
                                                :description="`${tramite.expe_folios}`"
                                            />
                                        </v-col>

                                        <v-col cols="6">
                                            <ItemDescription
                                                title="Folios"
                                                :description="`${tramite.estado.esta_nombre}`"
                                            />
                                        </v-col>

                                        <v-col cols="12">
                                            <div class="text-grey">Resumen</div>
                                            <div>
                                                {{ tramite.expe_resumen }}
                                            </div>
                                        </v-col>
                                    </v-row>
                                </v-card-item>
                            </v-card>
                        </v-col>
                        <v-col cols="12">
                            <v-card>
                                <v-toolbar density="compact">
                                    <v-toolbar-title class="text-overline">
                                        Datos del remitente
                                    </v-toolbar-title>
                                </v-toolbar>

                                <v-card-item>
                                    <v-row>
                                        <v-col cols="6">
                                            <ItemDescription
                                                title="Tipo de persona"
                                                :description="`${tramite.expe_remi_tipo}`"
                                            />
                                        </v-col>

                                        <v-col cols="6">
                                            <ItemDescription
                                                title="DNI | Nombre"
                                                :description="`${tramite.persona.pers_dni} | ${tramite.persona.pers_nombre} ${tramite.persona.pers_paterno} ${tramite.persona.pers_materno}`"
                                            />
                                        </v-col>

                                        <v-col cols="6">
                                            <ItemDescription
                                                title="Telefono"
                                                :description="`${tramite.persona.pers_celular}`"
                                            />
                                        </v-col>

                                        <v-col cols="6">
                                            <ItemDescription
                                                title="Correo"
                                                :description="`${tramite.persona.pers_correo}`"
                                            />
                                        </v-col>
                                    </v-row>
                                </v-card-item>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col cols="12" md="5">
                    <v-card>
                        <v-toolbar density="compact">
                            <v-toolbar-title class="text-overline">
                                Archivos
                            </v-toolbar-title>
                        </v-toolbar>
                        <v-card-item>
                            <v-row>
                                <v-col cols="12">
                                    <div class="text-grey">Documento</div>
                                    <v-list lines="one">
                                        <v-list-item
                                            v-for="(
                                                item, index
                                            ) in tramite.archivos.filter(
                                                (el) =>
                                                    el.exar_tipo === 'PRINCIPAL'
                                            )"
                                            :key="item.exar_id"
                                        >
                                            <v-list-item-title>
                                                <a
                                                    :href="item.exar_url"
                                                    target="_blank"
                                                    class="blue-darken-4 text-decoration-none"
                                                >
                                                    {{
                                                        item.exar_url
                                                            .split("/")
                                                            .pop()
                                                    }}
                                                </a>
                                            </v-list-item-title>
                                            <v-list-item-subtitle>
                                                15/05/2023 10:AM | Firma digital
                                            </v-list-item-subtitle>
                                            <template v-slot:prepend>
                                                <v-icon
                                                    color="red"
                                                    icon="mdi-file-pdf-box"
                                                ></v-icon>
                                            </template>
                                        </v-list-item>
                                    </v-list>
                                </v-col>

                                <v-col cols="12">
                                    <div class="text-grey">Anexos</div>
                                    <v-list lines="one">
                                        <v-list-item
                                            v-for="(
                                                item, index
                                            ) in tramite.archivos.filter(
                                                (el) => el.exar_tipo === 'ANEXO'
                                            )"
                                            :key="item.exar_id"
                                        >
                                            <v-list-item-title>
                                                <a
                                                    :href="item.exar_url"
                                                    target="_blank"
                                                    class="blue-darken-4 text-decoration-none"
                                                >
                                                    {{
                                                        item.exar_url
                                                            .split("/")
                                                            .pop()
                                                    }}
                                                </a>
                                            </v-list-item-title>
                                            <v-list-item-subtitle>
                                                15/05/2023 10:AM | Firma digital
                                            </v-list-item-subtitle>

                                            <template v-slot:prepend>
                                                <v-icon
                                                    color="red"
                                                    icon="mdi-file-pdf-box"
                                                ></v-icon>
                                            </template>
                                        </v-list-item>
                                    </v-list>
                                </v-col>
                            </v-row>
                        </v-card-item>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </AdminLayout>
</template>
<script setup>
import { router } from "@inertiajs/vue3";
import AdminLayout from "@/layouts/AdminLayout.vue";
import HeadingPage from "@/Components/HeadingPage.vue";
import BtnDialog from "@/Components/BtnDialog.vue";
import ItemDescription from "@/Components/ItemDescription.vue";
import FormObservar from "./components/FormObservar.vue";
import FormArchivar from "./components/FormArchivar.vue";
import FormFinalizar from "./components/FormFinalizar.vue";
import FormDerivar from "./components/FormDerivar.vue";

const props = defineProps({
    tramite: Object,
    oficinas: Array,
    acciones: Array,
});

const url = "/a/expedientes/";
</script>
