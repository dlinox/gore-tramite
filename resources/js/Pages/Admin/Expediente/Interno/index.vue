<template>
  <AdminLayout>
      <v-toolbar color="white">
          <v-app-bar-nav-icon>
              <v-icon>mdi-arrow-left</v-icon>
          </v-app-bar-nav-icon>

          <v-toolbar-title>
              <v-list-item>
                  <v-list-item-subtitle>
                      Bandeja de entrada
                  </v-list-item-subtitle>
                  <v-list-item-title>
                      <strong> Expedienters </strong>
                  </v-list-item-title>
                  
              </v-list-item>
          </v-toolbar-title>

          <v-spacer></v-spacer>

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

                      <v-list-item-title>{{ item.title }}</v-list-item-title>
                  </v-list-item>
              </v-list>
          </v-menu>

          <template v-slot:extension>
              <v-tabs v-model="tab" align-tabs="title">
                  <v-tab v-for="item in itemst" :key="item" :value="item">
                      {{ item }}
                  </v-tab>
              </v-tabs>
          </template>
      </v-toolbar>

      <v-window v-model="tab">
          <v-window-item v-for="item in itemst" :key="item" :value="item">
              <v-card flat>
                  <v-card-text v-text="text"></v-card-text>
              </v-card>
          </v-window-item>
      </v-window>
  </AdminLayout>
</template>
<script setup>
import AdminLayout from "@/layouts/AdminLayout.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
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

const tab = ref(null);

const itemst = ["web", "shopping", "videos", "images", "news"];
const text =
  "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";
</script>
