<template>
    <v-app id="inspire">
        <v-app-bar flat extended="">
            <v-container class="fill-height d-flex align-center">
                
                <v-avatar density="x-large" rounded="0">
                    <Logo></Logo>
                </v-avatar>
            
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
import Logo from "../components/Logo.vue";
import SwitchTheme from "../components/SwitchTheme.vue";
import { router } from "@inertiajs/vue3";
const items = ["Mis tramites", "Ayuda"];
</script>
