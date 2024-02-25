<script setup>
import { ref } from 'vue';
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Button from "primevue/button";
import Divider from "primevue/divider";
import Chip from "primevue/chip";
import { router, Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const email = ref('');
const password = ref('');

const currentAccountType = route().params.accountType;

const isAccountTypeValid = () => {
    const validAccountTypes = ['customer', 'veterinarian', 'admin'];
    return validAccountTypes.includes(currentAccountType);
}

if (!currentAccountType || !isAccountTypeValid()) {
    router.visit('/');
}

</script>

<template>
  <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
    <div class="flex flex-column align-items-center justify-content-center">
      <img
        src="/layout/images/logo.png"
        alt="PETCARE LOGO"
        width="120px"
        class="mb-5 w-8rem flex-shrink-0"
      >
      <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
        <div
          class="w-full surface-card py-8 px-5 sm:px-8"
          style="border-radius: 53px"
        >
          <div class="text-center mb-5">
            <div class="text-900 text-3xl font-medium mb-3">
              Welcome to PETCARE
            </div>
            <span
              class="text-600 font-medium"
              v-if="route().params.accountType == 'veterinarian'"
            >Sign in as <Chip
              label="Vet"
              icon="pi pi-user"
            /></span>
            <span
              class="text-600 font-medium"
              v-if="route().params.accountType == 'customer'"
            >Sign in as <Chip
              label="Pet Owner"
              icon="pi pi-user"
            /></span>
          </div>

          <div>
            <label
              for="email"
              class="block text-900 text-xl font-medium mb-2"
            >Email</label>
            <InputText
              id="email"
              name="email"
              type="text"
              placeholder="Email address"
              class="w-full md:w-30rem mb-5"
              style="padding: 1rem"
              v-model="email"
            />

            <label
              class="block text-900 font-medium text-xl mb-2"
            >Password</label>
            <Password
              id="password"
              name="password"
              :feedback="false"
              v-model="password"
              placeholder="Password"
              :toggle-mask="true"
              class="w-full mb-3"
              input-class="w-full"
              :input-style="{ padding: '1rem' }"
            />

            <div class="flex align-items-center justify-content-between mb-5 gap-5">
              <a
                class="font-medium no-underline ml-2 text-right cursor-pointer"
                style="color: var(--primary-color)"
              >Forgot password?</a>
            </div>
            <div class="formgrid grid">
              <div class="field col">
                <Link href="/">
                  <Button
                    label="Back"
                    outlined
                    severity="secondary"
                    class="w-full"
                  />
                </Link>
              </div>
              <div class="field col">
                <div class="half-width">
                  <Button
                    label="Sign In"
                    class="w-full"
                  />
                </div>
              </div>
            </div>
            <Divider
              align="center"
              type="dashed"
            >
              <b>OR</b>
            </Divider>
            <div class="text-center">
              Need an account? <a
                class="font-medium no-underline cursor-pointer"
                style="color: var(--primary-color)"
              >Sign Up</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

/* .half-width {
    width: 50%;
}

.full-width-button {
    width: 100%;
} */
</style>
