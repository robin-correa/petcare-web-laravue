<script setup>
import Button from "primevue/button";
import Divider from "primevue/divider";
import SelectButton from "primevue/selectbutton";
import Dialog from "primevue/dialog";
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const statuses = ref(['Pet Owner', 'Vet']);

const showLoginSignupDialog = ref(false);
const selectedAccountType = ref('');

const smoothScroll = (id) => {
  document.querySelector(id).scrollIntoView({
    behavior: 'smooth'
  });
};

const showLoginDialog = () => {
  showLoginSignupDialog.value = true;
};

const hideLoginSignupDialog = () => {
  showLoginSignupDialog.value = false;
  selectedAccountType.value = '';
}

const routeUserByAccountType = () => {
  let accountType = selectedAccountType.value == 'Pet Owner' ? 'customer' : 'veterinarian';

  router.visit('login', {
    data: {
      accountType: accountType
    },
    onSuccess: () => {
      showLoginSignupDialog.value = false;
    },
    onError: () => {
      selectedAccountType.value = '';
      showLoginSignupDialog.value = false;
    },
  });
}

</script>

<template>
  <div class="surface-0 flex justify-content-center">
    <div
      id="home"
      class="landing-wrapper overflow-hidden"
    >
      <div
        class="py-4 px-4 mx-0 md:mx-6 lg:mx-8 lg:px-8 flex align-items-center justify-content-between relative lg:static mb-3"
      >
        <a
          class="flex align-items-center"
          href="#"
        > <img
          src="/layout/images/logo.png"
          alt="PETCARE Logo"
          height="50"
          class="mr-0 lg:mr-2"
        ><span class="text-900 font-medium text-2xl line-height-3 mr-8">PETCARE</span> </a>
        <a
          class="cursor-pointer block lg:hidden text-700 p-ripple"
          v-ripple
          v-styleclass="{ selector: '@next', enterClass: 'hidden', leaveToClass: 'hidden', hideOnOutsideClick: true }"
        >
          <i class="pi pi-bars text-4xl" />
        </a>
        <div
          class="align-items-center surface-0 flex-grow-1 justify-content-between hidden lg:flex absolute lg:static w-full left-0 px-6 lg:px-0 z-2"
          style="top: 120px"
        >
          <ul class="list-none p-0 m-0 flex lg:align-items-center select-none flex-column lg:flex-row cursor-pointer">
            <li>
              <a
                @click="smoothScroll('#hero')"
                class="flex m-0 md:ml-5 px-0 py-3 text-900 font-medium line-height-3 p-ripple"
                v-ripple
              >
                <span>Home</span>
              </a>
            </li>
            <li>
              <a
                @click="smoothScroll('#features')"
                class="flex m-0 md:ml-5 px-0 py-3 text-900 font-medium line-height-3 p-ripple"
                v-ripple
              >
                <span>Our Services</span>
              </a>
            </li>
            <li>
              <a
                @click="smoothScroll('#highlights')"
                class="flex m-0 md:ml-5 px-0 py-3 text-900 font-medium line-height-3 p-ripple"
                v-ripple
              >
                <span>About Us</span>
              </a>
            </li>
            <li>
              <a
                @click="smoothScroll('#pricing')"
                class="flex m-0 md:ml-5 px-0 py-3 text-900 font-medium line-height-3 p-ripple"
                v-ripple
              >
                <span>Our Team</span>
              </a>
            </li>
          </ul>
          <div
            class="flex justify-content-between lg:block border-top-1 lg:border-top-none surface-border py-3 lg:py-0 mt-3 lg:mt-0"
          >
            <Button
              label="Login or Sign up"
              class="p-button-text p-button-rounded border-none font-light line-height-2 text-teal"
              @click="showLoginDialog"
            />
            <Button
              label="Enquire Now"
              type="button"
              class="p-button-outlined"
            />
          </div>
        </div>
      </div>

      <div
        id="hero"
        class="flex flex-column pt-4 px-4 lg:px-8 overflow-hidden"
        style="background: linear-gradient(0deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.2)), radial-gradient(77.36% 256.97% at 77.36% 57.52%, rgb(238, 239, 175) 0%, rgb(195, 227, 250) 100%); clip-path: ellipse(150% 87% at 93% 13%)"
      >
        <div class="mx-4 md:mx-8 mt-0 md:mt-4">
          <h1 class="text-6xl font-bold text-gray-900 line-height-2">
            <span class="font-light block">Discover Comprehensive</span> Pet Care Services
          </h1>
          <p class="font-normal text-2xl line-height-3 md:mt-3 text-gray-700">
            Explore a range of specialized services tailored to meet the unique needs of your beloved pets. From veterinary care to grooming, we ensure top-notch care for your furry companions.
          </p>
          <Button
            label="Book Appointment"
            type="button"
            class="mr-3 p-button-raised"
          />
        </div>
        <div class="flex justify-content-center md:justify-content-end">
          <img
            src="/demo/images/landing/screen-1.png"
            alt="Hero Image"
            class="w-9 md:w-auto"
          >
        </div>
      </div>

      <div
        id="features"
        class="py-4 px-4 lg:px-8 mt-5 mx-0 lg:mx-8"
      >
        <div class="grid justify-content-center">
          <div class="col-12 text-center mt-8 mb-4">
            <h2 class="text-900 font-normal mb-2">
              Services
            </h2>
            <span class="text-600 text-2xl">Experience the Ultimate Pet Care Journey with PetCare. Start Exploring
              Today!</span>
          </div>

          <div class="col-12 md:col-12 lg:col-4 p-0 lg:pr-5 lg:pb-5 mt-4 lg:mt-0">
            <div
              style="height: 160px; padding: 2px; border-radius: 10px; background: linear-gradient(90deg, rgba(253, 228, 165, 0.2), rgba(187, 199, 205, 0.2)), linear-gradient(180deg, rgba(253, 228, 165, 0.2), rgba(187, 199, 205, 0.2))"
            >
              <div
                class="p-3 surface-card h-full"
                style="border-radius: 8px"
              >
                <div
                  class="flex align-items-center justify-content-center bg-yellow-200 mb-3"
                  style="width: 3.5rem; height: 3.5rem; border-radius: 10px"
                >
                  <i class="pi pi-fw pi-users text-2xl text-yellow-700" />
                </div>
                <h5 class="mb-2 text-900">
                  Expert Veterinarians at Your Service
                </h5>
                <span class="text-600">Posuere morbi leo urna molestie.</span>
              </div>
            </div>
          </div>

          <div class="col-12 md:col-12 lg:col-4 p-0 lg:pr-5 lg:pb-5 mt-4 lg:mt-0">
            <div
              style="height: 160px; padding: 2px; border-radius: 10px; background: linear-gradient(90deg, rgba(145, 226, 237, 0.2), rgba(251, 199, 145, 0.2)), linear-gradient(180deg, rgba(253, 228, 165, 0.2), rgba(172, 180, 223, 0.2))"
            >
              <div
                class="p-3 surface-card h-full"
                style="border-radius: 8px"
              >
                <div
                  class="flex align-items-center justify-content-center bg-cyan-200 mb-3"
                  style="width: 3.5rem; height: 3.5rem; border-radius: 10px"
                >
                  <i class="pi pi-fw pi-palette text-2xl text-cyan-700" />
                </div>
                <h5 class="mb-2 text-900">
                  Create Lasting Memories with Your Pet
                </h5>
                <span class="text-600">Semper risus in hendrerit.</span>
              </div>
            </div>
          </div>

          <div class="col-12 md:col-12 lg:col-4 p-0 lg:pb-5 mt-4 lg:mt-0">
            <div
              style="height: 160px; padding: 2px; border-radius: 10px; background: linear-gradient(90deg, rgba(145, 226, 237, 0.2), rgba(172, 180, 223, 0.2)), linear-gradient(180deg, rgba(172, 180, 223, 0.2), rgba(246, 158, 188, 0.2))"
            >
              <div
                class="p-3 surface-card h-full"
                style="border-radius: 8px"
              >
                <div
                  class="flex align-items-center justify-content-center bg-indigo-200"
                  style="width: 3.5rem; height: 3.5rem; border-radius: 10px"
                >
                  <i class="pi pi-fw pi-map text-2xl text-indigo-700" />
                </div>
                <h5 class="mb-2 text-900">
                  Schedule Hassle-Free Appointments
                </h5>
                <span class="text-600">Non arcu risus quis varius quam quisque.</span>
              </div>
            </div>
          </div>

          <div class="col-12 md:col-12 lg:col-4 p-0 lg:pr-5 lg:pb-5 mt-4 lg:mt-0">
            <div
              style="height: 160px; padding: 2px; border-radius: 10px; background: linear-gradient(90deg, rgba(187, 199, 205, 0.2), rgba(251, 199, 145, 0.2)), linear-gradient(180deg, rgba(253, 228, 165, 0.2), rgba(145, 210, 204, 0.2))"
            >
              <div
                class="p-3 surface-card h-full"
                style="border-radius: 8px"
              >
                <div
                  class="flex align-items-center justify-content-center bg-bluegray-200 mb-3"
                  style="width: 3.5rem; height: 3.5rem; border-radius: 10px"
                >
                  <i class="pi pi-fw pi-id-card text-2xl text-bluegray-700" />
                </div>
                <h5 class="mb-2 text-900">
                  Secure Online Payments
                </h5>
                <span class="text-600">Nulla malesuada pellentesque elit.</span>
              </div>
            </div>
          </div>

          <div class="col-12 md:col-12 lg:col-4 p-0 lg:pr-5 lg:pb-5 mt-4 lg:mt-0">
            <div
              style="height: 160px; padding: 2px; border-radius: 10px; background: linear-gradient(90deg, rgba(187, 199, 205, 0.2), rgba(246, 158, 188, 0.2)), linear-gradient(180deg, rgba(145, 226, 237, 0.2), rgba(160, 210, 250, 0.2))"
            >
              <div
                class="p-3 surface-card h-full"
                style="border-radius: 8px"
              >
                <div
                  class="flex align-items-center justify-content-center bg-orange-200 mb-3"
                  style="width: 3.5rem; height: 3.5rem; border-radius: 10px"
                >
                  <i class="pi pi-fw pi-star text-2xl text-orange-700" />
                </div>
                <h5 class="mb-2 text-900">
                  Join Our Pet Community
                </h5>
                <span class="text-600">Condimentum lacinia quis vel eros.</span>
              </div>
            </div>
          </div>

          <div class="col-12 md:col-12 lg:col-4 p-0 lg:pb-5 mt-4 lg:mt-0">
            <div
              style="height: 160px; padding: 2px; border-radius: 10px; background: linear-gradient(90deg, rgba(251, 199, 145, 0.2), rgba(246, 158, 188, 0.2)), linear-gradient(180deg, rgba(172, 180, 223, 0.2), rgba(212, 162, 221, 0.2))"
            >
              <div
                class="p-3 surface-card h-full"
                style="border-radius: 8px"
              >
                <div
                  class="flex align-items-center justify-content-center bg-pink-200 mb-3"
                  style="width: 3.5rem; height: 3.5rem; border-radius: 10px"
                >
                  <i class="pi pi-fw pi-moon text-2xl text-pink-700" />
                </div>
                <h5 class="mb-2 text-900">
                  24/7 Support
                </h5>
                <span class="text-600">Convallis tellus id interdum velit laoreet.</span>
              </div>
            </div>
          </div>

          <div class="col-12 md:col-12 lg:col-4 p-0 lg:pr-5 mt-4 lg:mt-0">
            <div
              style="height: 160px; padding: 2px; border-radius: 10px; background: linear-gradient(90deg, rgba(145, 210, 204, 0.2), rgba(160, 210, 250, 0.2)), linear-gradient(180deg, rgba(187, 199, 205, 0.2), rgba(145, 210, 204, 0.2))"
            >
              <div
                class="p-3 surface-card h-full"
                style="border-radius: 8px"
              >
                <div
                  class="flex align-items-center justify-content-center bg-teal-200 mb-3"
                  style="width: 3.5rem; height: 3.5rem; border-radius: 10px"
                >
                  <i class="pi pi-fw pi-shopping-cart text-2xl text-teal-700" />
                </div>
                <h5 class="mb-2 text-900">
                  Grooming Services
                </h5>
                <span class="text-600">Mauris sit amet massa vitae.</span>
              </div>
            </div>
          </div>

          <div class="col-12 md:col-12 lg:col-4 p-0 lg:pr-5 mt-4 lg:mt-0">
            <div
              style="height: 160px; padding: 2px; border-radius: 10px; background: linear-gradient(90deg, rgba(145, 210, 204, 0.2), rgba(212, 162, 221, 0.2)), linear-gradient(180deg, rgba(251, 199, 145, 0.2), rgba(160, 210, 250, 0.2))"
            >
              <div
                class="p-3 surface-card h-full"
                style="border-radius: 8px"
              >
                <div
                  class="flex align-items-center justify-content-center bg-blue-200 mb-3"
                  style="width: 3.5rem; height: 3.5rem; border-radius: 10px"
                >
                  <i class="pi pi-fw pi-globe text-2xl text-blue-700" />
                </div>
                <h5 class="mb-2 text-900">
                  Emergency Care
                </h5>
                <span class="text-600">Elementum nibh tellus molestie nunc non.</span>
              </div>
            </div>
          </div>

          <div class="col-12 md:col-12 lg:col-4 p-0 lg-4 mt-4 lg:mt-0">
            <div
              style="height: 160px; padding: 2px; border-radius: 10px; background: linear-gradient(90deg, rgba(160, 210, 250, 0.2), rgba(212, 162, 221, 0.2)), linear-gradient(180deg, rgba(246, 158, 188, 0.2), rgba(212, 162, 221, 0.2))"
            >
              <div
                class="p-3 surface-card h-full"
                style="border-radius: 8px"
              >
                <div
                  class="flex align-items-center justify-content-center bg-purple-200 mb-3"
                  style="width: 3.5rem; height: 3.5rem; border-radius: 10px"
                >
                  <i class="pi pi-fw pi-eye text-2xl text-purple-700" />
                </div>
                <h5 class="mb-2 text-900">
                  Nutritional Counseling
                </h5>
                <span class="text-600">Neque egestas congue quisque.</span>
              </div>
            </div>
          </div>

          <div
            id="highlights"
            class="col-12 mt-8 mb-8 p-2 md:p-8"
            style="border-radius: 20px; background: linear-gradient(0deg, rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.6)), radial-gradient(77.36% 256.97% at 77.36% 57.52%, #efe1af 0%, #c3dcfa 100%)"
          >
            <div class="flex flex-column justify-content-center align-items-center text-center px-3 py-3 md:py-0">
              <h3 class="text-gray-900 mb-2">
                Robin Correa
              </h3>
              <span class="text-gray-600 text-2xl">Software Developer</span>
              <p
                class="text-gray-900 sm:line-height-2 md:line-height-4 text-2xl mt-4"
                style="max-width: 800px"
              >
                Experienced software developer with over 7 years of expertise in multi-platform environments, object-oriented application development, and multi-tiered web application design and development. Holder of two AWS certifications - AWS Certified Developer and AWS Certified Practitioner, demonstrating proficiency in cloud technologies. Skilled in utilizing cutting-edge development tools and practices, effective self-management for independent projects, and a valuable collaborator within productive teams.
              </p>
              <img
                src="/demo/images/landing/robin_logo.png"
                class="mt-4"
                width="200px"
                alt="Robin Correa"
              >
            </div>
          </div>
        </div>
      </div>

      <div
        id="pricing"
        class="py-4 px-4 lg:px-8 my-2 md:my-4"
      >
        <div class="text-center">
          <h2 class="text-900 font-normal mb-2">
            Matchless Pricing
          </h2>
          <span class="text-600 text-2xl">Amet consectetur adipiscing elit...</span>
        </div>

        <div class="grid justify-content-between mt-8 md:mt-0">
          <div class="col-12 lg:col-4 p-0 md:p-3">
            <div
              class="p-3 flex flex-column border-200 pricing-card cursor-pointer border-2 hover:border-primary transition-duration-300 transition-all"
              style="border-radius: 10px"
            >
              <h3 class="text-900 text-center my-5">
                Free
              </h3>
              <img
                src="/demo/images/landing/free.svg"
                class="w-10 h-10 mx-auto"
                alt="free"
              >
              <div class="my-5 text-center">
                <span class="text-5xl font-bold mr-2 text-900">$0</span>
                <span class="text-600">per month</span>
                <Button
                  label="Get Started"
                  class="block mx-auto mt-4 p-button-rounded border-none ml-3 font-light line-height-2 bg-blue-500 text-white"
                />
              </div>
              <Divider class="w-full bg-surface-200" />
              <ul class="my-5 list-none p-0 flex text-900 flex-column">
                <li class="py-2">
                  <i class="pi pi-fw pi-check text-xl text-cyan-500 mr-2" />
                  <span class="text-xl line-height-3">Responsive Layout</span>
                </li>
                <li class="py-2">
                  <i class="pi pi-fw pi-check text-xl text-cyan-500 mr-2" />
                  <span class="text-xl line-height-3">Unlimited Push Messages</span>
                </li>
                <li class="py-2">
                  <i class="pi pi-fw pi-check text-xl text-cyan-500 mr-2" />
                  <span class="text-xl line-height-3">50 Support Ticket</span>
                </li>
                <li class="py-2">
                  <i class="pi pi-fw pi-check text-xl text-cyan-500 mr-2" />
                  <span class="text-xl line-height-3">Free Shipping</span>
                </li>
              </ul>
            </div>
          </div>

          <div class="col-12 lg:col-4 p-0 md:p-3 mt-4 md:mt-0">
            <div
              class="p-3 flex flex-column border-200 pricing-card cursor-pointer border-2 hover:border-primary transition-duration-300 transition-all"
              style="border-radius: 10px"
            >
              <h3 class="text-900 text-center my-5">
                Startup
              </h3>
              <img
                src="/demo/images/landing/startup.svg"
                class="w-10 h-10 mx-auto"
                alt="startup"
              >
              <div class="my-5 text-center">
                <span class="text-5xl font-bold mr-2 text-900">$1</span>
                <span class="text-600">per month</span>
                <Button
                  label="Try Free"
                  class="block mx-auto mt-4 p-button-rounded border-none ml-3 font-light line-height-2 bg-blue-500 text-white"
                />
              </div>
              <Divider class="w-full bg-surface-200" />
              <ul class="my-5 list-none p-0 flex text-900 flex-column">
                <li class="py-2">
                  <i class="pi pi-fw pi-check text-xl text-cyan-500 mr-2" />
                  <span class="text-xl line-height-3">Responsive Layout</span>
                </li>
                <li class="py-2">
                  <i class="pi pi-fw pi-check text-xl text-cyan-500 mr-2" />
                  <span class="text-xl line-height-3">Unlimited Push Messages</span>
                </li>
                <li class="py-2">
                  <i class="pi pi-fw pi-check text-xl text-cyan-500 mr-2" />
                  <span class="text-xl line-height-3">50 Support Ticket</span>
                </li>
                <li class="py-2">
                  <i class="pi pi-fw pi-check text-xl text-cyan-500 mr-2" />
                  <span class="text-xl line-height-3">Free Shipping</span>
                </li>
              </ul>
            </div>
          </div>

          <div class="col-12 lg:col-4 p-0 md:p-3 mt-4 md:mt-0">
            <div
              class="p-3 flex flex-column border-200 pricing-card cursor-pointer border-2 hover:border-primary transition-duration-300 transition-all"
              style="border-radius: 10px"
            >
              <h3 class="text-900 text-center my-5">
                Enterprise
              </h3>
              <img
                src="/demo/images/landing/enterprise.svg"
                class="w-10 h-10 mx-auto"
                alt="enterprise"
              >
              <div class="my-5 text-center">
                <span class="text-5xl font-bold mr-2 text-900">$999</span>
                <span class="text-600">per month</span>
                <Button
                  label="Get a Quote"
                  class="block mx-auto mt-4 p-button-rounded border-none ml-3 font-light line-height-2 bg-blue-500 text-white"
                />
              </div>
              <Divider class="w-full bg-surface-200" />
              <ul class="my-5 list-none p-0 flex text-900 flex-column">
                <li class="py-2">
                  <i class="pi pi-fw pi-check text-xl text-cyan-500 mr-2" />
                  <span class="text-xl line-height-3">Responsive Layout</span>
                </li>
                <li class="py-2">
                  <i class="pi pi-fw pi-check text-xl text-cyan-500 mr-2" />
                  <span class="text-xl line-height-3">Unlimited Push Messages</span>
                </li>
                <li class="py-2">
                  <i class="pi pi-fw pi-check text-xl text-cyan-500 mr-2" />
                  <span class="text-xl line-height-3">50 Support Ticket</span>
                </li>
                <li class="py-2">
                  <i class="pi pi-fw pi-check text-xl text-cyan-500 mr-2" />
                  <span class="text-xl line-height-3">Free Shipping</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="py-4 px-4 mx-0 mt-8 lg:mx-8">
        <div class="grid justify-content-between">
          <div
            class="col-12 md:col-2"
            style="margin-top: -1.5rem"
          >
            <a
              @click="smoothScroll('#home')"
              class="flex flex-wrap align-items-center justify-content-center md:justify-content-start md:mb-0 mb-3 cursor-pointer"
            >
              <img
                src="/layout/images/logo.png"
                alt="footer sections"
                width="100"
                class="mr-2"
              >
              <h4 class="font-medium text-3xl text-900">PETCARE</h4>
            </a>
          </div>

          <div class="col-12 md:col-10 lg:col-7">
            <div class="grid text-center md:text-left">
              <div class="col-12 md:col-3">
                <h4 class="font-medium text-2xl line-height-3 mb-3 text-900">
                  Company
                </h4>
                <a class="line-height-3 text-xl block cursor-pointer mb-2 text-700">About Us</a>
                <a class="line-height-3 text-xl block cursor-pointer mb-2 text-700">News</a>
                <a class="line-height-3 text-xl block cursor-pointer mb-2 text-700">Investor Relations</a>
                <a class="line-height-3 text-xl block cursor-pointer mb-2 text-700">Careers</a>
                <a class="line-height-3 text-xl block cursor-pointer text-700">Media Kit</a>
              </div>

              <div class="col-12 md:col-3 mt-4 md:mt-0">
                <h4 class="font-medium text-2xl line-height-3 mb-3 text-900">
                  Resources
                </h4>
                <a class="line-height-3 text-xl block cursor-pointer mb-2 text-700">Get Started</a>
                <a class="line-height-3 text-xl block cursor-pointer mb-2 text-700">Learn</a>
                <a class="line-height-3 text-xl block cursor-pointer text-700">Case Studies</a>
              </div>

              <div class="col-12 md:col-3 mt-4 md:mt-0">
                <h4 class="font-medium text-2xl line-height-3 mb-3 text-900">
                  Community
                </h4>
                <a class="line-height-3 text-xl block cursor-pointer mb-2 text-700">Discord</a>
                <a class="line-height-3 text-xl block cursor-pointer mb-2 text-700">Events<img
                  src="/demo/images/landing/new-badge.svg"
                  class="ml-2"
                ></a>
                <a class="line-height-3 text-xl block cursor-pointer mb-2 text-700">FAQ</a>
                <a class="line-height-3 text-xl block cursor-pointer text-700">Blog</a>
              </div>

              <div class="col-12 md:col-3 mt-4 md:mt-0">
                <h4 class="font-medium text-2xl line-height-3 mb-3 text-900">
                  Legal
                </h4>
                <a class="line-height-3 text-xl block cursor-pointer mb-2 text-700">Brand Policy</a>
                <a class="line-height-3 text-xl block cursor-pointer mb-2 text-700">Privacy Policy</a>
                <a class="line-height-3 text-xl block cursor-pointer text-700">Terms of Service</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <Dialog
    v-model:visible="showLoginSignupDialog"
    modal
    header="Login or Sign up as"
    close-on-escape
    @hide="hideLoginSignupDialog"
    :style="{ width: '25rem' }"
  >
    <div class="flex justify-content-center">
      <SelectButton
        v-model="selectedAccountType"
        :options="statuses"
        @change="routeUserByAccountType"
        id="accountType"
        name="accountType"
        aria-labelledby="basic"
      />
    </div>
  </Dialog>
</template>