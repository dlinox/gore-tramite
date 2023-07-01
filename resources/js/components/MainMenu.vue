<template>
    <v-list v-model:opened="menuOpen" nav density="compact">
        <v-list-subheader>Menu</v-list-subheader>

        <template v-for="(menu, index) in menuMain" :key="index">
            <template v-if="menu.group == null">
                <v-list-item
                    :prepend-icon="menu.icon"
                    :title="menu.title"
                    color="primary"
                    :class="
                        router.page.url == menu.to
                            ? 'v-list-item--active text-primary'
                            : ''
                    "
                    @click="router.get(`${baseUrl}/${menu.to}`)"
                />
            </template>
            <template v-else>
                <v-list-group :value="menu.value">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            :prepend-icon="menu.icon"
                            :title="menu.title"
                            color="primary"
                        ></v-list-item>
                    </template>
                    <template v-for="submenu in menu.group">
                        <template v-if="submenu.group == null">
                            <v-list-item
                                :title="submenu.title"
                                color="primary"
                                :class="
                                    router.page.url == '/a/' + submenu.to
                                        ? 'v-list-item--active text-primary'
                                        : ''
                                "
                                @click="router.get(`${baseUrl}/${submenu.to}`)"
                            >
                                <template #prepend>
                                    <v-icon class="ms-0 me-2" size="x-large"
                                        >mdi-circle-small
                                    </v-icon>
                                </template>
                            </v-list-item>
                        </template>
                        <template v-else>
                            <v-list-group :value="submenu.value">
                                <template v-slot:activator="{ props }">
                                    <v-list-item
                                        v-bind="props"
                                        :title="submenu.title"
                                        color="primary"
                                    >
                                        <template #prepend>
                                            <v-icon class="mr-2" size="x-large"
                                                >mdi-circle-small
                                            </v-icon>
                                        </template>
                                    </v-list-item>
                                </template>

                                <v-list-item
                                    v-for="(subsubmenu, k) in submenu.group"
                                    :key="k"
                                    :title="subsubmenu.title"
                                    :value="subsubmenu.value"
                                    color="primary"
                                    @click="goToPage(subsubmenu.to)"
                                    :class="
                                        subsubmenu.to == router.page.url
                                            ? 'v-list-item--active text-primary'
                                            : ''
                                    "
                                >
                                    <template #prepend>
                                        <v-icon class="ms-3 me-2" size="x-large"
                                            >mdi-circle-small
                                        </v-icon>
                                    </template>
                                </v-list-item>
                            </v-list-group>
                        </template>
                    </template>
                </v-list-group>
            </template>
        </template>
    </v-list>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const baseUrl = "/a";
const menuOpen = ref([router.page.url.split("/")[2]]);

const menuExpedientes = [
    {
        title: "Bandeja",
        value: "bandeja",
        icon: null,
        to: "expedientes",
        group: null,
    },
    {
        title: "Mis tramites",
        value: "emitidos",
        icon: null,
        to: "expedientes/emitidos",
        group: null,
    },
    {
        title: "Internos",
        value: "internos",
        icon: null,
        to: "expedientes/internos",
        group: null,
    },
    {
        title: "Externos",
        value: "expedientes/externos",
        icon: null,
        to: "expedientes/externos",
        group: null,
    },
];

const menuAdmininstrador = [
    {
        title: "Oficinas",
        value: "oficinas",
        icon: null,
        to: "oficinas",
        group: null,
    },
    {
        title: "Acciones",
        value: "oficinas",
        icon: null,
        to: "acciones",
        group: null,
    },

    {
        title: "Documentos",
        value: "documentos",
        icon: null,
        to: "documentos",
        group: null,
    },
    {
        title: "Procesos",
        value: "procesos",
        icon: null,
        to: "procesos",
        group: null,
    },
];

const menuMain = [
    {
        title: "Dashboard",
        value: "dashboard",
        icon: "mdi-monitor-dashboard",
        to: "",
        group: null,
    },

    {
        title: "Expedientes",
        value: "expedientes",
        icon: "mdi-file-cabinet",
        to: "#",
        group: menuExpedientes,
    },

    {
        title: "Administrar",
        value: menuAdmininstrador.some((item) => item.to === menuOpen.value[0])
            ? menuOpen.value[0]
            : "admin",
        icon: "mdi-cog-outline",
        to: "#",
        group: menuAdmininstrador,
    },
];

//const currentMenu = computed(() => router.page.url.split('/')[1] );
const goToPage = (to) => {
    console.log("to");
    router.get(`${baseUrl}/${to}`);
};
</script>

<style scoped>
.v-list-group__items .v-list-item {
    padding-inline-start: 25px !important;
}
</style>
