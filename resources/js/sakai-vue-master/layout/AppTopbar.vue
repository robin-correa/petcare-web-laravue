<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import { useLayout } from '@/sakai-vue-master/layout/composables/layout';
import NavLink from "@/Components/NavLink.vue";
import Menu from "primevue/menu";

const { layoutConfig, onMenuToggle } = useLayout();

const outsideClickListener = ref(null);
const topbarMenuActive = ref(false);

onMounted(() => {
    bindOutsideClickListener();
});

onBeforeUnmount(() => {
    unbindOutsideClickListener();
});

const onTopBarMenuButton = () => {
    topbarMenuActive.value = !topbarMenuActive.value;
};
const onSettingsClick = () => {
    topbarMenuActive.value = false;
};
const topbarMenuClasses = computed(() => {
    return {
        'layout-topbar-menu-mobile-active': topbarMenuActive.value
    };
});

const bindOutsideClickListener = () => {
    if (!outsideClickListener.value) {
        outsideClickListener.value = (event) => {
            if (isOutsideClicked(event)) {
                topbarMenuActive.value = false;
            }
        };
        document.addEventListener('click', outsideClickListener.value);
    }
};
const unbindOutsideClickListener = () => {
    if (outsideClickListener.value) {
        document.removeEventListener('click', outsideClickListener);
        outsideClickListener.value = null;
    }
};
const isOutsideClicked = (event) => {
    if (!topbarMenuActive.value) return;

    const sidebarEl = document.querySelector('.layout-topbar-menu');
    const topbarEl = document.querySelector('.layout-topbar-menu-button');

    return !(sidebarEl.isSameNode(event.target) || sidebarEl.contains(event.target) || topbarEl.isSameNode(event.target) || topbarEl.contains(event.target));
};

const menu = ref();

const loginMenuItems = ref([
    {
        label: 'Settings',
        icon: 'pi pi-cog',
        href: '/auth/user'
    },
    {
        label: 'Logout',
        icon: 'pi pi-sign-out',
        href: '/logout'
    }]);

const toggle = (event) => {
    menu.value.toggle(event);
};

</script>

<template>
    <div class="layout-topbar">
        <NavLink href="/" class="layout-topbar-logo">
            <img src="/layout/images/logo.png" alt="logo" />
            <span>PETCARE</span>
        </NavLink>

        <button class="p-link layout-menu-button layout-topbar-button" @click="onMenuToggle()">
            <i class="pi pi-bars"></i>
        </button>

        <button class="p-link layout-topbar-menu-button layout-topbar-button" @click="onTopBarMenuButton()">
            <i class="pi pi-ellipsis-v"></i>
        </button>

        <div class="layout-topbar-menu" :class="topbarMenuClasses">
            <Menu ref="menu" id="overlay_menu" :model="loginMenuItems" :popup="true">
            <template #item="{ item, props }">
                <NavLink v-ripple class="flex align-items-center" v-bind="props.action" :href="item.href">
                    <span :class="item.icon" />
                    <span class="ml-2">{{ item.label }}</span>
                </NavLink>
            </template>
            </Menu>
            <button @click="toggle" class="p-link layout-topbar-button">
                <i class="pi pi-user"></i>
                <span>Profile <i class="pi pi-angle-right"></i></span>
            </button>
        </div>
    </div>
</template>

<style lang="scss" scoped></style>
