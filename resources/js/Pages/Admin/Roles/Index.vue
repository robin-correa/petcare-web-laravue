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
import MultiSelect from 'primevue/multiselect';
import SelectButton from 'primevue/selectbutton';
import AppLayout from "@/sakai-vue-master/layout/AppLayout.vue";
import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';

const props = defineProps({
    roles: Object,
    permissions: Object,
    errors: Object,
    flash: Object,
    search: String
})

defineOptions({ layout: AppLayout })

const toast = useToast();
const records = ref(null);
const record = ref({});
const recordDialog = ref(false);
const deleteRecordDialog = ref(false);
const dt = ref(null);
const submitted = ref(false);
const guards = ref(['web', 'api']);

const currentPage = ref(1);
const first = ref(0);
const last = ref(0);
const totalRecords = ref(0);
const perPage = ref(0);
const search = ref('');
const dataTableLoading = ref(false);
const selectedPermissions = ref([]);

onMounted(() => {
    reloadDataTable();
});

const reloadDataTable = () => {
    records.value = props.roles.data;
    first.value = props.roles.meta.from - 1;
    last.value = props.roles.meta.last_page;
    totalRecords.value = props.roles.meta.total;
    perPage.value = props.roles.meta.per_page;
    search.value = props.search;
}

const handlePageUpdate = (page) => {
    currentPage.value = page.page += 1;
    loadData(currentPage, search.value);
}

watch(search, debounce((value) => {
    loadData(currentPage, value);
}, 500));

const loadData = (currentPage, searchKeyword = '') => {
    const urlData = {
        page: currentPage.value,
        search: searchKeyword
    }

    router.get('/admin/roles', urlData, {
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
    record.value = {};
    submitted.value = false;
    recordDialog.value = true;
};

const hideDialog = () => {
    selectedPermissions.value = [];
    recordDialog.value = false;
    submitted.value = false;
};

const saveRecord = () => {
    submitted.value = true;

    if (record.value.name && record.value.name.trim() && record.value.guard_name && selectedPermissions.value.length > 0) {
        const postData = {
            name: record.value.name,
            guard_name: record.value.guard_name,
            permissions: selectedPermissions.value
        };

        if (record.value.id) {
            router.put(`/admin/roles/${record.value.id}`, postData, {
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
            router.post('/admin/roles', postData, {
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

const editRecord = (recordData) => {
    record.value = { ...recordData };
    selectedPermissions.value = recordData.permissions;
    recordDialog.value = true;
};

const confirmDeleteRecord = (data) => {
    record.value = data;
    deleteRecordDialog.value = true;
};

const deleteRecord = () => {
    deleteRecordDialog.value = false;

    router.delete(`/admin/roles/${record.value.id}`, {
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
                    <template v-slot:start>
                        <div class="my-2">
                            <Button label="New" icon="pi pi-plus" class="p-button-success mr-2" @click="openNew" />
                        </div>
                    </template>
                </Toolbar>

                <DataTable ref="dt" lazy paginator :loading="dataTableLoading" @page="handlePageUpdate"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} records"
                    responsiveLayout="scroll" dataKey="id" :value="records" :first="first" :last="last"
                    :totalRecords="totalRecords" :rows="perPage" :rowsPerPageOptions="[perPage]">
                    <template #header>
                        <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
                            <h5 class="m-0">Manage Roles</h5>
                            <span class="block mt-2 md:mt-0 p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText v-model="search" placeholder="Search..." id="search" name="search" />
                            </span>
                        </div>
                    </template>

                    <template #empty>No records found. </template>

                    <Column field="id" header="ID" headerStyle="width:5%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">ID</span>
                            {{ slotProps.data.id }}
                        </template>
                    </Column>
                    <Column field="name" header="Name" headerStyle="width:15%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Name</span>
                            {{ slotProps.data.name }}
                        </template>
                    </Column>
                    <Column field="name" header="Guard" headerStyle="width:15%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Guard</span>
                            {{ slotProps.data.guard_name }}
                        </template>
                    </Column>
                    <Column headerStyle="width:5%; min-width:10rem;">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil" class="p-button-rounded p-button-warning mr-2"
                                @click="editRecord(slotProps.data)" />
                            <Button icon="pi pi-trash" class="p-button-rounded p-button-danger mt-2"
                                @click="confirmDeleteRecord(slotProps.data)" />
                        </template>
                    </Column>
                </DataTable>

                <Dialog v-model:visible="recordDialog" :style="{ width: '450px' }" header="Role details" :modal="true" @hide="hideDialog" closeOnEscape 
                    class="p-fluid">
                    <div class="field">
                        <label for="name">Name</label>
                        <InputText id="name" v-model.trim="record.name" name="name" autofocus autocomplete="true"
                            :class="{ 'p-invalid': submitted && (errors && errors.name || !record.name) }" />
                        <small class="p-error" v-if="submitted && errors && errors.name">{{ errors.name }}</small>
                        <small class="p-error" v-if="submitted && !record.name">Name is required</small>
                    </div>
                    <div class="field">
                        <label>Guard Type</label>
                        <SelectButton v-model="record.guard_name" :options="guards" id="status" name="status"
                            :class="{ 'p-invalid': submitted && (errors && errors.guard_name || !record.guard_name) }"
                            aria-labelledby="basic" />
                        <small class="p-error" v-if="submitted && errors && errors.guard_name">{{ errors.guard_name }}</small>
                        <small class="p-error" v-if="submitted && !record.guard_name">Guard type is required</small>
                    </div>
                    <div class="field">
                        <label>Permissions</label>
                        <MultiSelect v-model="selectedPermissions" :options="permissions" display="chip" filter optionValue="id" optionLabel="name" :maxSelectedLabels="3" placeholder="Select" class="w-full md:w-50rem" :class="{ 'p-invalid': submitted && (errors && errors.permissions || selectedPermissions.length == 0) }">
                            <template #header>
                                <div class="py-2 px-3">
                                    <b>{{ selectedPermissions ? selectedPermissions.length : 0 }}</b> item{{ (selectedPermissions ? selectedPermissions.length : 0) > 3 ? 's' : '' }} selected.
                                </div>
                            </template>
                        </MultiSelect>
                        <small class="p-error" v-if="submitted && errors && errors.permissions">{{ errors.permissions }}</small>
                        <small class="p-error" v-if="submitted && selectedPermissions.length == 0">Permission(s) is/are required</small>
                    </div>
                    <template #footer>
                        <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog" />
                        <Button label="Save" icon="pi pi-check" class="p-button-text" @click="saveRecord" />
                    </template>
                </Dialog>

                <Dialog v-model:visible="deleteRecordDialog" :style="{ width: '450px' }" header="Confirm" :modal="true" closeOnEscape>
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                        <span v-if="record">Are you sure you want to delete <b>{{ record.name }}</b>?</span>
                    </div>
                    <template #footer>
                        <Button label="No" icon="pi pi-times" class="p-button-text" @click="deleteRecordDialog = false" />
                        <Button label="Yes" icon="pi pi-check" class="p-button-text" @click="deleteRecord" />
                    </template>
                </Dialog>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss"></style>
