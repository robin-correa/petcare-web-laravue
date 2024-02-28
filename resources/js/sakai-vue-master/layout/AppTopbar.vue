<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import { Link } from '@inertiajs/vue3'
import { useLayout } from '@/sakai-vue-master/layout/composables/layout';
import Menu from "primevue/menu";

const { onMenuToggle } = useLayout();

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
    <Link
      href="/"
      class="layout-topbar-logo"
    >
      <img
        src="/layout/images/logo.png"
        alt="logo"
      >
      <span>PETCARE</span>
    </Link>

    <button
      class="p-link layout-menu-button layout-topbar-button"
      @click="onMenuToggle()"
    >
      <i class="pi pi-bars" />
    </button>

    <button
      class="p-link layout-topbar-menu-button layout-topbar-button"
      @click="onTopBarMenuButton()"
    >
      <i class="pi pi-ellipsis-v" />
    </button>

    <div
      class="layout-topbar-menu"
      :class="topbarMenuClasses"
    >
      <Menu
        ref="menu"
        id="overlay_menu"
        :model="loginMenuItems"
        :popup="true"
      >
        <template #item="{ item, props }">
          <Link
            v-ripple
            class="flex align-items-center"
            v-bind="props.action"
            :href="item.href"
          >
            <span :class="item.icon" />
            <span class="ml-2">{{ item.label }}</span>
          </Link>
        </template>
      </Menu>
      <button
        @click="toggle"
        class="p-link layout-topbar-button"
      >
        <i class="pi pi-user" />
        <span>Profile <i class="pi pi-angle-right" /></span>
      </button>
    </div>
  </div>
</template>

<style lang="scss" scoped></style>
