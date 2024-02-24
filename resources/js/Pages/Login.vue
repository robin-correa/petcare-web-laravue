<script setup>
import { ref } from 'vue';
import AppConfig from '@/sakai-vue-master/layout/AppConfig.vue';
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Button from "primevue/button";

const email = ref('');
const password = ref('');

</script>

<template>
  <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
    <div class="flex flex-column align-items-center justify-content-center">
      <div>
        <div>
          <div class="text-center mb-5">
            <img
              src="/layout/images/logo.png"
              alt="Image"
              width="120px"
              class="mb-3"
            >
            <div class="text-900 text-3xl font-medium mb-3">
              PETCARE
            </div>
            <span class="text-600 font-medium">Sign in to continue</span>
          </div>

          <div>
            <label
              for="email1"
              class="block text-900 text-xl font-medium mb-2"
            >Email</label>
            <InputText
              id="email1"
              type="text"
              placeholder="Email address"
              class="w-full md:w-30rem mb-5"
              style="padding: 1rem"
              v-model="email"
            />

            <label
              for="password1"
              class="block text-900 font-medium text-xl mb-2"
            >Password</label>
            <Password
              id="password1"
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
            <Button
              label="Sign In"
              class="w-full p-3 text-xl"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
  <AppConfig simple />
</template>

<style scoped>
.pi-eye {
    transform: scale(1.6);
    margin-right: 1rem;
}

.pi-eye-slash {
    transform: scale(1.6);
    margin-right: 1rem;
}
</style>
