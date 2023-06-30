<template>
    <v-card class="mx-auto mb-4 border" elevation="0" :loading="loading">
        <v-toolbar density="compact">
            <v-toolbar-title class="font-weight-bold text-overline">
                {{ title }}
            </v-toolbar-title>
        </v-toolbar>
        <v-card-item>
            <slot />
        </v-card-item>
    </v-card>
</template>
<script setup>
defineProps({
    title: String,
    loading: {
        type: Boolean,
        default: false,
    },
});
</script>
