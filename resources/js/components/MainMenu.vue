<template>
    <v-list v-model:opened="menu" nav density="compact">
        <v-list-subheader>Menu</v-list-subheader>

        <v-list-item
            prepend-icon="mdi-home"
            title="Dashboard"
            color="primary"
            :class="
                router.page.url == '/a'
                    ? 'v-list-item--active text-primary'
                    : ''
            "
        >
            <Link class="link-list-item" href="/a"> </Link>
        </v-list-item>
        <v-list-group value="expedientes">
            <template v-slot:activator="{ props }">
                <v-list-item
                    v-bind="props"
                    prepend-icon="mdi-content-paste                                     "
                    title="Capacitaciones"
                    color="primary"
                ></v-list-item>
            </template>
            <v-list-item
                v-for="(item, index) in menuExpediente"
                :key="index"
                :title="item.title"
                :value="item.value"
                color="primary"
                :class="
                    item.to == router.page.url
                        ? 'v-list-item--active text-primary'
                        : ''
                "
            >
                <template #prepend>
                    <v-icon class="mr-2" size="x-large"
                        >mdi-circle-small
                    </v-icon>
                </template>
                <Link class="link-list-item" :href="baseUrl + item.to"> </Link>
            </v-list-item>
        </v-list-group>

        <v-list-group value="admin">
            <template v-slot:activator="{ props }">
                <v-list-item
                    v-bind="props"
                    prepend-icon="mdi-cog"
                    title="Administrar"
                    color="primary"
                ></v-list-item>
            </template>
            <v-list-item
                v-for="(item, index) in menuAdministrar"
                :key="index"
                :title="item.title"
                :value="item.value"
                color="primary"
                :class="
                    item.to == router.page.url
                        ? 'v-list-item--active text-primary'
                        : ''
                "
            >
                <Link class="link-list-item" :href="baseUrl + item.to"> </Link>
                <template #prepend>
                    <v-icon class="mr-2" size="x-large"
                        >mdi-circle-small
                    </v-icon>
                </template>
            </v-list-item>
        </v-list-group>
    </v-list>
</template>

<script setup>
import { ref } from "vue";
import { Link, router } from "@inertiajs/vue3";

const baseUrl = "/a/";

const menuExpediente = ref([
    {
        title: "Internos",
        value: "internos",
        icon: null,
        to: "expedientes/internos",
    },
    {
        title: "Externos",
        value: "externos",
        icon: null,
        to: "expedientes/externos",
    },

    {
        title: "Derivados",
        value: "derivados",
        icon: null,
        to: "expedientes/derivados",
    },

    {
        title: "Bandeja de entrada",
        value: "bandeja",
        icon: null,
        to: "expedientes/bandeja",
    },

    {
        title: "Archivados",
        value: "archivados",
        icon: null,
        to: "expedientes/archivados",
    },
]);

const menuAdministrar = ref([
    {
        title: "Administradores",
        value: "admin.administradores",
        icon: null,
        to: "administradores",
    },

    {
        title: "Usuarios",
        value: "admin.usuarios",
        icon: null,
        to: "usuarios",
    },

    {
        title: "Personas",
        value: "admin.personas",
        icon: null,
        to: "personas",
    },

    {
        title: "Oficinas",
        value: "admin.oficinas",
        icon: null,
        to: "oficinas",
    },
    {
        title: "Documentos",
        value: "admin.documentos",
        icon: null,
        to: "documentos",
    },

    {
        title: "Procesos",
        value: "admin.procesos",
        icon: null,
        to: "procesos",
    },

    {
        title: "Acciones",
        value: "admin.acciones",
        icon: null,
        to: "acciones",
    },
]);

//const currentMenu = computed(() => router.page.url.split('/')[1] );
const goToPage = (to) => {
    router.get(to);
};

const menu = ref([router.page.url.split("/")[1]]);
</script>

<style scoped>
.v-list-group__items .v-list-item {
    padding-inline-start: 25px !important;
}
.v-list.v-list--nav .link-list-item {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
}
</style>
