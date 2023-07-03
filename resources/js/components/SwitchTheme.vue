<template>
    <VBtn
        @click="toggleTheme"
        :icon="themeIcon"
        size="small"
        :color="themeColor"
        variant="tonal"
        rounded="lg"
    >
    </VBtn>
</template>
<script setup>
import { computed } from "vue";
import { useTheme } from "vuetify";
const theme = useTheme();
const toggleTheme = () =>
    (theme.global.name.value = theme.global.current.value.dark
        ? "light"
        : "dark");

const themeIcon = computed(() =>
    theme.global.name.value == "light"
        ? "mdi-weather-night"
        : "mdi-white-balance-sunny"
);

const themeColor = computed(() =>
    theme.global.name.value == "light"
        ? "grey-darken-3"
        : "yellow-accent-2"
);
</script>
