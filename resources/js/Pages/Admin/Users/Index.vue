<script setup>
import { ref, onMounted, watch } from 'vue';
import { useToast } from 'primevue/usetoast';
import DataTable from 'primevue/datatable';
import Toolbar from 'primevue/toolbar';
import Column from 'primevue/column';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import Toast from 'primevue/toast';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import SelectButton from 'primevue/selectbutton';
import Dropdown from 'primevue/dropdown';
import MultiSelect from 'primevue/multiselect';
import AppLayout from "@/sakai-vue-master/layout/AppLayout.vue";
import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';

const props = defineProps({
  users: {
    type: Object,
    default() {
      return {}
    }
  },
  roles: {
    type: Object,
    default() {
      return {}
    }
  },
  permissions: {
    type: Object,
    default() {
      return {}
    }
  },
  errors: {
    type: Object,
    default() {
      return {}
    }
  },
  flash: {
    type: Object,
    default() {
      return {}
    }
  },
  search: {
    type: String,
    default: ''
  }
})

defineOptions({ layout: AppLayout })

const toast = useToast();
const records = ref(null);
const record = ref({});
const recordDialog = ref(false);
const deleteRecordDialog = ref(false);
const dt = ref(null);
const submitted = ref(false);
const statuses = ref(['Active', 'Inactive']);
const permissionsDialog = ref(false);
const submittedPermissions = ref(false);

const currentPage = ref(1);
const first = ref(0);
const last = ref(0);
const totalRecords = ref(0);
const perPage = ref(0);
const searchKeyword = ref('');
const dataTableLoading = ref(false);

const password = ref('');
const confirmPassword = ref('');
const selectedRole = ref(0);
const selectedPermissions = ref([]);

onMounted(() => {
  reloadDataTable();
});

const reloadDataTable = () => {
  records.value = props.users.data;
  first.value = props.users.meta.from - 1;
  last.value = props.users.meta.last_page;
  totalRecords.value = props.users.meta.total;
  perPage.value = props.users.meta.per_page;
  searchKeyword.value = props.search;
}

const handlePageUpdate = (page) => {
  currentPage.value = page.page += 1;
  loadData(currentPage, searchKeyword.value);
}

watch(searchKeyword, debounce((value) => {
  loadData(currentPage, value);
}, 500));

const loadData = (currentPage, searchKeyword = '') => {
  const urlData = {
    page: currentPage.value,
    search: searchKeyword
  }

  router.get('/admin/users', urlData, {
    preserveScroll: true,
    preserveState: true,
    onBefore: () => {
      dataTableLoading.value = true;
    },
    onSuccess: () => {
      reloadDataTable();
      dataTableLoading.value = false;
    }
  });
}

const openNew = () => {
  password.value = '';
  confirmPassword.value = '';
  record.value = {};
  submitted.value = false;
  recordDialog.value = true;
};

const hideDialog = () => {
  password.value = '';
  confirmPassword.value = '';
  selectedRole.value = 0;
  recordDialog.value = false;
  submitted.value = false;
};

const hidePermissionsDialog = () => {
  permissionsDialog.value = false;
  submittedPermissions.value = false;
};

const saveRecord = () => {
  submitted.value = true;

  if (record.value.name && record.value.email && record.value.status && selectedRole.value) {
    const postData = {
      name: record.value.name,
      email: record.value.email,
      status: record.value.status,
      role: selectedRole.value
    };

    if (record.value.id) {
      router.put(`/admin/users/${record.value.id}`, postData, {
        onSuccess: () => {
          reloadDataTable();
          toast.add({ severity: 'success', summary: 'Successful', detail: props.flash.success, life: 3000 });
          recordDialog.value = false;
          record.value = {};
        },
        onError: errors => {
          if (errors) {
            toast.add({ severity: 'error', summary: 'Error', detail: 'Validation failed', life: 3000 });
          } else {
            toast.add({ severity: 'error', summary: 'Error', detail: 'Oops, something went wrong. Please try again later.', life: 3000 });
          }
        },
      });
    } else {
      postData.password = password.value;
      postData.password_confirm = confirmPassword.value;

      router.post('/admin/users', postData, {
        onSuccess: () => {
          reloadDataTable();
          toast.add({ severity: 'success', summary: 'Successful', detail: props.flash.success, life: 3000 });
          recordDialog.value = false;
          record.value = {};
        },
        onError: errors => {
          if (errors) {
            toast.add({ severity: 'error', summary: 'Error', detail: 'Validation failed', life: 3000 });
          } else {
            toast.add({ severity: 'error', summary: 'Error', detail: 'Oops, something went wrong. Please try again later.', life: 3000 });
          }
        },
      });
    }
  }
};

const savePermissions = () => {
  submittedPermissions.value = false;
  permissionsDialog.value = false;

  const postData = {
    permissions: selectedPermissions.value || []
  };

  router.put(`/admin/users/${record.value.id}/updatePermissions`, postData, {
    onSuccess: () => {
      reloadDataTable();
      toast.add({ severity: 'success', summary: 'Successful', detail: props.flash.success, life: 3000 });
      permissionsDialog.value = false;
      record.value = {};
    },
    onError: errors => {
      if (errors) {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Validation failed', life: 3000 });
      } else {
        toast.add({ severity: 'error', summary: 'Error', detail: 'Oops, something went wrong. Please try again later.', life: 3000 });
      }
    },
  });
}

const editRecord = (recordData) => {
  record.value = { ...recordData };
  if (recordData.roles.length == 0) {
    selectedRole.value = 0;
  } else {
    selectedRole.value = recordData.roles[0].id;
  }
  recordDialog.value = true;
};

const editPermissions = (recordData) => {
  record.value = { ...recordData };
  if (recordData.roles.length == 0) {
    selectedRole.value = 0;
  } else {
    selectedRole.value = record.value.roles[0].id;
  }

  selectedPermissions.value = recordData.permissions || [];

  permissionsDialog.value = true;
};

const confirmDeleteRecord = (data) => {
  record.value = data;
  deleteRecordDialog.value = true;
};

const deleteRecord = () => {
  deleteRecordDialog.value = false;

  router.delete(`/admin/users/${record.value.id}`, {
    onSuccess: () => {
      reloadDataTable();
      toast.add({ severity: 'success', summary: 'Successful', detail: props.flash.success, life: 3000 });
    },
  });
};

</script>

<template>
  <div class="grid">
    <div class="col-12">
      <div class="card">
        <Toast />
        <Toolbar class="mb-4">
          <template #start>
            <div class="my-2">
              <Button
                label="New"
                icon="pi pi-plus"
                class="p-button-success mr-2"
                @click="openNew"
              />
            </div>
          </template>
        </Toolbar>

        <DataTable
          ref="dt"
          lazy
          paginator
          :loading="dataTableLoading"
          @page="handlePageUpdate"
          paginator-template="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
          current-page-report-template="Showing {first} to {last} of {totalRecords} records"
          responsive-layout="scroll"
          data-key="id"
          :value="records"
          :first="first"
          :last="last"
          :total-records="totalRecords"
          :rows="perPage"
          :rows-per-page-options="[perPage]"
        >
          <template #header>
            <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
              <h5 class="m-0">
                Manage Users
              </h5>
              <span class="block mt-2 md:mt-0 p-input-icon-left">
                <i class="pi pi-search" />
                <InputText
                  v-model="searchKeyword"
                  placeholder="Search..."
                  id="search"
                  name="search"
                />
              </span>
            </div>
          </template>

          <template #empty>
            No records found.
          </template>

          <Column
            field="id"
            header="ID"
            header-style="width:5%; min-width:10rem;"
          >
            <template #body="slotProps">
              <span class="p-column-title">ID</span>
              {{ slotProps.data.id }}
            </template>
          </Column>
          <Column
            field="name"
            header="Name"
            header-style="width:15%; min-width:10rem;"
          >
            <template #body="slotProps">
              <span class="p-column-title">Name</span>
              {{ slotProps.data.name }}
            </template>
          </Column>
          <Column
            field="email"
            header="Email"
            header-style="width:25%; min-width:10rem;"
          >
            <template #body="slotProps">
              <span class="p-column-title">Email</span>
              {{ slotProps.data.email }}
            </template>
          </Column>
          <Column
            field="status"
            header="Status"
            header-style="width:10%; min-width:10rem;"
          >
            <template #body="slotProps">
              <span class="p-column-title">Status</span>
              <span
                :class="'product-badge status-' + (slotProps.data.status ? slotProps.data.status.toLowerCase() : '')"
              >{{
                slotProps.data.status }}</span>
            </template>
          </Column>
          <Column header-style="width:25%; min-width:10rem;">
            <template #body="slotProps">
              <Button
                icon="pi pi-key"
                class="p-button-rounded p-button-info mr-2"
                @click="editPermissions(slotProps.data)"
              />
              <Button
                icon="pi pi-pencil"
                class="p-button-rounded p-button-warning mr-2"
                @click="editRecord(slotProps.data)"
              />
              <Button
                icon="pi pi-trash"
                class="p-button-rounded p-button-danger mt-2"
                @click="confirmDeleteRecord(slotProps.data)"
              />
            </template>
          </Column>
        </DataTable>

        <Dialog
          v-model:visible="recordDialog"
          :style="{ width: '450px' }"
          header="User details"
          :modal="true"
          @hide="hideDialog"
          close-on-escape
          class="p-fluid"
        >
          <div class="field">
            <label for="name">Name</label>
            <InputText
              id="name"
              v-model.trim="record.name"
              name="name"
              autofocus
              autocomplete="true"
              :class="{ 'p-invalid': submitted && (errors && errors.name || !record.name) }"
            />
            <small
              class="p-error"
              v-if="submitted && errors && errors.name"
            >{{ errors.name }}</small>
            <small
              class="p-error"
              v-if="submitted && !record.name"
            >Name is required</small>
          </div>
          <div class="field">
            <label for="email">Email</label>
            <InputText
              id="email"
              v-model.trim="record.email"
              name="email"
              autocomplete="true"
              :class="{ 'p-invalid': submitted && (errors && errors.email || !record.email) }"
            />
            <small
              class="p-error"
              v-if="submitted && errors && errors.email"
            >{{ errors.email }}</small>
            <small
              class="p-error"
              v-if="submitted && !record.email"
            >Email is required</small>
          </div>

          <div v-if="!record.id">
            <div class="field">
              <label>Password</label>
              <Password
                id="password"
                v-model.trim="password"
                name="password"
                toggle-mask
                :class="{ 'p-invalid': ((submitted && errors.password) || (submitted && !password) || ((password && confirmPassword && password != confirmPassword))) }"
              />
              <small
                class="p-error"
                v-if="submitted && errors && errors.password"
              >{{ errors.password
              }}</small>
              <small
                class="p-error"
                v-if="submitted && !password"
              >Password is required</small>
              <small
                class="p-error"
                v-if="((submitted && errors.password) || (submitted && !password) || ((password && confirmPassword && password != confirmPassword)))"
              >Passwords
                don't match</small>
            </div>

            <div class="field">
              <label>Confirm Password</label>
              <Password
                id="password"
                v-model.trim="confirmPassword"
                name="confirmPassword"
                toggle-mask
                :class="{ 'p-invalid': ((submitted && errors.password) || (submitted && !password) || ((password && confirmPassword && password != confirmPassword))) }"
              />
              <small
                class="p-error"
                v-if="submitted && errors && errors.password_confirm"
              >{{
                errors.password_confirm }}</small>
              <small
                class="p-error"
                v-if="submitted && !confirmPassword"
              >Confirm Password is
                required</small>&nbsp;
              <small
                class="p-error"
                v-if="((submitted && errors.password) || (submitted && !password) || ((password && confirmPassword && password != confirmPassword)))"
              >Passwords
                don't match</small>
            </div>
          </div>

          <div class="field">
            <label>Role</label>
            <Dropdown
              v-model="selectedRole"
              :options="roles"
              filter
              option-value="id"
              option-label="name"
              placeholder="Select a Role"
              class="w-full md:w-40rem"
            />
            <small
              class="p-error"
              v-if="submitted && errors && errors.role"
            >{{ errors.role }}</small>
            <small
              class="p-error"
              v-if="submitted && !selectedRole"
            >Role is required</small>
          </div>

          <div class="field">
            <label>Status</label>
            <SelectButton
              v-model="record.status"
              :options="statuses"
              id="status"
              name="status"
              :class="{ 'p-invalid': submitted && (errors && errors.status || !record.status) }"
              aria-labelledby="basic"
            />
            <small
              class="p-error"
              v-if="submitted && errors && errors.status"
            >{{ errors.status }}</small>
            <small
              class="p-error"
              v-if="submitted && !record.status"
            >Status is required</small>
          </div>

          <template #footer>
            <Button
              label="Cancel"
              icon="pi pi-times"
              class="p-button-text"
              @click="hideDialog"
            />
            <Button
              label="Save"
              icon="pi pi-check"
              class="p-button-text"
              @click="saveRecord"
            />
          </template>
        </Dialog>

        <Dialog
          v-model:visible="deleteRecordDialog"
          :style="{ width: '450px' }"
          header="Confirm"
          :modal="true"
          close-on-escape
        >
          <div class="flex align-items-center justify-content-center">
            <i
              class="pi pi-exclamation-triangle mr-3"
              style="font-size: 2rem"
            />
            <span v-if="record">Are you sure you want to delete <b>{{ record.name }}</b>?</span>
          </div>
          <template #footer>
            <Button
              label="No"
              icon="pi pi-times"
              class="p-button-text"
              @click="deleteRecordDialog = false;"
            />
            <Button
              label="Yes"
              icon="pi pi-check"
              class="p-button-text"
              @click="deleteRecord"
            />
          </template>
        </Dialog>

        <Dialog
          v-model:visible="permissionsDialog"
          :style="{ width: '450px' }"
          header="Permissions"
          :modal="true"
          @hide="hidePermissionsDialog"
          close-on-escape
          class="p-fluid"
        >
          <div class="field">
            <label for="name">Name</label>
            <InputText
              id="name"
              v-model.trim="record.name"
              name="name"
              autofocus
              autocomplete="true"
              disabled
            />
          </div>
          <div class="field">
            <label for="email">Email</label>
            <InputText
              id="email"
              v-model.trim="record.email"
              name="email"
              autocomplete="true"
              disabled
            />
          </div>

          <div class="field">
            <label>Role</label>
            <Dropdown
              v-model="selectedRole"
              :options="roles"
              filter
              option-value="id"
              option-label="name"
              placeholder="Select a Role"
              class="w-full md:w-40rem"
              disabled
            />
          </div>

          <div class="field">
            <label>Status</label>
            <SelectButton
              v-model="record.status"
              :options="statuses"
              id="status"
              name="status"
              aria-labelledby="basic"
              disabled
            />
          </div>

          <div class="field">
            <label>Permissions</label>
            <MultiSelect
              v-model="selectedPermissions"
              :options="permissions"
              display="chip"
              filter
              option-value="id"
              option-label="name"
              :max-selected-labels="3"
              placeholder="Select"
              class="w-full md:w-50rem"
            >
              <template #header>
                <div class="py-2 px-3">
                  <b>{{ selectedPermissions ? selectedPermissions.length : 0 }}</b> item{{
                    (selectedPermissions ? selectedPermissions.length : 0) > 3 ? 's' : '' }} selected.
                </div>
              </template>
            </MultiSelect>
          </div>

          <template #footer>
            <Button
              label="Cancel"
              icon="pi pi-times"
              class="p-button-text"
              @click="hidePermissionsDialog"
            />
            <Button
              label="Save"
              icon="pi pi-check"
              class="p-button-text"
              @click="savePermissions"
            />
          </template>
        </Dialog>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss"></style>
