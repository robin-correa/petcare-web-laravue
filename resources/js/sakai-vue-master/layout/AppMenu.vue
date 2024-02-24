<script setup>
import { ref } from 'vue';

import AppMenuItem from './AppMenuItem.vue';

const model = ref([
    {
        label: 'Home',
        items: [
            { label: 'Dashboard', icon: 'pi pi-fw pi-chart-bar', to: '/admin/dashboard' },
        ]
    },
    {
        label: 'Admin',
        items: [
            { label: 'Appointments', icon: 'pi pi-fw pi-calendar-plus', to: '/admin/appointments' },
            { label: 'Veterinarians', icon: 'pi pi-fw pi-id-card', to: '/admin/veterinarians' },
            { label: 'Pets', icon: 'pi pi-verified', to: '/admin/pets' },
            { label: 'Specie Types', icon: 'pi pi-tags', to: '/admin/specieTypes' },
            { label: 'Services', icon: 'pi pi-fw pi-book', to: '/admin/services' },
            { label: 'Payments', icon: 'pi pi-fw pi-credit-card', to: '/admin/payments' },
        ]
    },
    {
        label: 'System',
        items: [
            { label: 'Users', icon: 'pi pi-fw pi-user', to: '/admin/users' },
            { label: 'Roles', icon: 'pi pi-fw pi-cog', to: '/admin/roles' },
        ]
    }
]);
</script>

<template>
  <ul class="layout-menu">
    <template
      v-for="(item, i) in model"
      :key="item"
    >
      <app-menu-item
        v-if="!item.separator"
        :item="item"
        :index="i"
      />
      <li
        v-if="item.separator"
        class="menu-separator"
      />
    </template>
  </ul>
</template>

<style lang="scss" scoped></style>
