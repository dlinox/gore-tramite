<template>
    <AdminLayout>
        <HeadingPage title="Expedientes" subtitle="Bandeja de entrada">
            <template #actions>
                <v-menu>
                    <template v-slot:activator="{ props }">
                        <v-btn
                            v-bind="props"
                            prepend-icon="mdi-plus"
                            variant="flat"
                        >
                            Nuevo
                        </v-btn>
                    </template>
                    <v-list density="compact">
                        <v-list-item
                            v-for="(item, index) in items"
                            :key="index"
                            :value="index"
                            @click="router.get(item.route)"
                        >
                            <template v-slot:prepend>
                                <v-icon :icon="item.icon"> </v-icon>
                            </template>

                            <v-list-item-title>{{
                                item.title
                            }}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </template>
        </HeadingPage>
    </AdminLayout>
    bandeja
</template>
<script setup>
import AdminLayout from "../../../layouts/AdminLayout.vue";
import HeadingPage from "../../../components/HeadingPage.vue";
import { router } from "@inertiajs/vue3";
const items = [
    {
        title: "Jefatura",
        route: "/a/expedientes/jefatura/crear",
        icon: "mdi-office-building-outline",
    },
    {
        title: "Personal",
        route: "/a/expedientes/personal/crear/",
        icon: "mdi-account-tie",
    },

    {
        title: "Externo",
        route: "/a/expedientes/externo/crear",
        icon: "mdi-account-group-outline",
    },
];
</script>
