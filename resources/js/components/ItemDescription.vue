<template>
    <v-list-item class="px-0">
        <v-list-item-subtitle> {{ title }} </v-list-item-subtitle>
        <v-list-item-title>
            <slot>
                {{ description }}
            </slot>
        </v-list-item-title>
        <v-list-item-subtitle> </v-list-item-subtitle>
    </v-list-item>
</template>
<script setup>
defineProps({
    title: String,
    description: String,
});
</script>
