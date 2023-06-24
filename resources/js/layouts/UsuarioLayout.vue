<template>
    <v-app id="inspire">
        <v-app-bar flat extended="">
            <v-container class="fill-height d-flex align-center">
                <v-avatar
                    class="me-10 ms-4"
                    color="grey-darken-1"
                    size="32"
                    image="/images/logo.svg"
                    rounded="0"
                >
                </v-avatar>
                <v-btn> Sistema de tramite </v-btn>
                <v-spacer></v-spacer>
                <v-btn icon size="small" @click="router.delete('/sign-out')">
                    <v-icon>mdi-account</v-icon>
                </v-btn>
                <v-btn
                    color="red"
                    icon
                    size="small"
                    @click="router.delete('/sign-out')"
                >
                    <v-icon>mdi-logout</v-icon>
                </v-btn>
                <SwitchTheme />
            </v-container>
            <template v-slot:extension>
                <v-container class="p-0">
                    <v-tabs align-tabs="end">
                        <v-tab v-for="item in items" :key="item" :value="item">
                            {{ item }}
                        </v-tab>
                    </v-tabs>
                </v-container>
            </template>
        </v-app-bar>

        <v-main class="">
            <slot />
        </v-main>
    </v-app>
</template>

<script setup>
import SwitchTheme from "../components/SwitchTheme.vue";
import { router } from "@inertiajs/vue3";
const items = ["Mis tramites", "Ayuda"];
</script>
