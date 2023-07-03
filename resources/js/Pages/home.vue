<template>
    <v-layout class="landing-page">
        <v-app-bar
            absolute
            class="py-3"
            color="blue-darken-1"
            image="/images/bannerimage.jpg"
            density="prominent"
        >
            <template v-slot:image>
                <v-img
                    gradient="to top right, rgba(200,200,200,.9), rgba(45,73,114,.8)"
                ></v-img>
            </template>

            <template v-slot:prepend>
                <v-img :width="200" src="/images/logo.png"></v-img>
            </template>

            <v-app-bar-title class="text-h5">
                Sistema de Tramite Documentario
            </v-app-bar-title>

            <v-spacer></v-spacer>

            <v-btn color="white">
                consultar <v-icon end>mdi-card-search-outline</v-icon>
            </v-btn>

            <v-btn color="white"  @click="() => router.get('/login')">
                ingresar <v-icon end>mdi-login</v-icon>
            </v-btn>
        </v-app-bar>

        <v-main class="mt-8">
            <v-container>
                <v-row>
                    <v-col cols="12" md="6">
                        <h3
                            class="mtitle font-weight-bold text-blue-darken-2 mb"
                        >
                            Simplifica tu Gestión Documental con nuestro Sistema
                            de Trámite Documentario
                        </h3>

                        <p class="msubtitle">
                            Esta plataforma se habilitó para dar facilidades a
                            la población
                        </p>

                        <p>
                            Para fines de recepción de documentos presentados:
                        </p>

                        <ul class="my-3 ms-6">
                            <li class="my-3">
                                Entre las 08:00 horas y las 16:00h, se
                                consideran presentados el mismo día hábil.
                            </li>
                            <li class="my-3">
                                Después de las 16:00 horas hasta las 23:59
                                horas, se consideran presentados el día hábil
                                siguiente en horario de de atención.
                            </li>
                            <li class="my-3">
                                En día inhábil se consideran presentados al día
                                hábil siguiente.
                            </li>
                            <li class="my-3">
                                En día inhábil se consideran presentados al día
                                hábil siguiente.
                            </li>
                        </ul>
                    </v-col>
                    <v-col
                        cols="12"
                        md="6"
                        class="d-flex align-center flex-wrap"
                    >
                        <v-card variant="tonal" class="w-100 mb-5" rounded="xl">
                            <div
                                class="d-flex flex-no-wrap justify-space-between px-4 py-2"
                            >
                                <div class="">
                                    <v-list theline>
                                        <v-list-item>
                                            <v-list-item-title class="mb-3">
                                                <span class="text-h5">
                                                    Registrate
                                                </span>
                                            </v-list-item-title>

                                            El registro es rápido y sencillo, y
                                            te brindará numerosos beneficios.
                                            Podrás gestionar tus trámites de
                                            manera eficiente, realizar un
                                            seguimiento en tiempo real y
                                            disfrutar de una experiencia
                                            personalizada.
                                        </v-list-item>
                                    </v-list>

                                    <v-card-actions>
                                        <v-btn
                                            class="ms-2"
                                            variant="outlined"
                                            size="small"
                                        >
                                            registrarme
                                            <v-icon end>mdi-plus </v-icon>
                                        </v-btn>
                                    </v-card-actions>
                                </div>

                                <v-avatar class="ma-1" size="150" rounded="0">
                                    <v-img
                                        src="/images/register.svg"
                                        width="100"
                                    ></v-img>
                                </v-avatar>
                            </div>
                        </v-card>

                        <v-card variant="tonal" class="w-100" rounded="xl">
                            <div
                                class="d-flex flex-no-wrap justify-space-between px-4 py-2"
                            >
                                <div class="">
                                    <v-list theline>
                                        <v-list-item>
                                            <v-list-item-title class="mb-3">
                                                <span class="text-h5">
                                                    Seguimiento
                                                </span>
                                            </v-list-item-title>

                                            Permite monitorizar y supervisar el
                                            estado de tus trámites de forma
                                            rápida y sencilla
                                        </v-list-item>
                                    </v-list>

                                    <v-card-actions>
                                        <v-btn
                                            class="ms-2"
                                            variant="outlined"
                                            size="small"
                                        >
                                            CONSULTAR
                                            <v-icon end>mdi-plus </v-icon>
                                        </v-btn>
                                    </v-card-actions>
                                </div>

                                <v-avatar class="ma-1" size="150" rounded="0">
                                    <v-img
                                        src="/images/consultar.svg"
                                        width="100"
                                    ></v-img>
                                </v-avatar>
                            </div>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>

            <v-footer class="d-flex flex-column pa-0" elevation="2">
                <div
                    class="px-4 py-2light-blue-lighten-5 py-3 text-center w-100"
                >
                    {{ new Date().getFullYear() }} —
                    <strong>STD</strong>
                </div>

                <div class="bg-white d-flex w-100 align-center px-4">
                    <strong class="text-center w-100 py-4">
                        Copyright © 2023-2026 Gobierno Regional Puno. Todos los
                        derechos reservados.
                    </strong>
                </div>
            </v-footer>
        </v-main>
    </v-layout>
</template>
<script setup>
import { router } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
</script>
<style lang="scss">
@import url("https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700;800;900&display=swap");

.landing-page {
    background: #fefefe;
    font-family: "Maven Pro", sans-serif;
    .mtitle {
        font-size: 2.5rem;
        line-height: 2.8rem;
        margin-bottom: 1.5rem;
    }
    .msubtitle {
        font-size: 1.5rem;
        line-height: 1.8rem;
        margin-bottom: 1rem;
    }
}
</style>
