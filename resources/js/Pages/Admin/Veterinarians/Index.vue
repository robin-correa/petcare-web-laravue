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
import Textarea from 'primevue/textarea';
import SelectButton from 'primevue/selectbutton';
import AppLayout from "@/sakai-vue-master/layout/AppLayout.vue";
import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';

const props = defineProps({
    veterinarians: Object,
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
const statuses = ref(['Active', 'Inactive']);

const currentPage = ref(1);
const first = ref(0);
const last = ref(0);
const totalRecords = ref(0);
const perPage = ref(0);
const search = ref('');
const dataTableLoading = ref(false);

onMounted(() => {
    reloadDataTable();
});

const reloadDataTable = () => {
    records.value = props.veterinarians.data;
    first.value = props.veterinarians.meta.from - 1;
    last.value = props.veterinarians.meta.last_page;
    totalRecords.value = props.veterinarians.meta.total;
    perPage.value = props.veterinarians.meta.per_page;
    search.value = props.search;
}

const handlePageUpdate = (page) => {
    currentPage.value = page.page += 1;
    loadData(currentPage, search.value);
}

watch(search, debounce((value) => {
    loadData(currentPage, value);
}, 1000));

const loadData = (currentPage, searchKeyword = '') => {
    const urlData = {
        page: currentPage.value,
        search: searchKeyword,
    }

    router.get('/admin/veterinarians', urlData, {
        preserveScroll: true,
        preserveState: true,
        onBefore: () => {
            dataTableLoading.value = true;
        },
        onSuccess: () => {
            reloadDataTable();
            dataTableLoading.value = false;
        },
    });
}

const openNew = () => {
    record.value = {};
    submitted.value = false;
    recordDialog.value = true;
};

const hideDialog = () => {
    recordDialog.value = false;
    submitted.value = false;
};

const saveRecord = () => {
    submitted.value = true;

    if (record.value.last_name && record.value.first_name && record.value.email && record.value.contact_number && record.value.specialization && record.value.status) {
        const postData = {
            last_name: record.value.last_name,
            first_name: record.value.first_name,
            email: record.value.email,
            contact_number: record.value.contact_number,
            specialization: record.value.specialization,
            status: record.value.status,
        };

        if (record.value.id) {
            router.put(`/admin/veterinarians/${record.value.id}`, postData, {
                onSuccess: () => {
                    reloadDataTable();
                    toast.add({ severity: 'success', summary: 'Successful', detail: props.flash.success, life: 3000 });
                    recordDialog.value = false;
                    record.value = {};
                },
            });
        } else {
            router.post('/admin/veterinarians', postData, {
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
    recordDialog.value = true;
};

const confirmDeleteRecord = (data) => {
    record.value = data;
    deleteRecordDialog.value = true;
};

const deleteRecord = () => {
    deleteRecordDialog.value = false;

    router.delete(`/admin/veterinarians/${record.value.id}`, {
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
                            <h5 class="m-0">Manage Veterinarians</h5>
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
                    <Column field="last_name" header="Last Name" headerStyle="width:15%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Last Name</span>
                            {{ slotProps.data.last_name }}
                        </template>
                    </Column>
                    <Column field="first_name" header="First Name" headerStyle="width:15%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">First Name</span>
                            {{ slotProps.data.first_name }}
                        </template>
                    </Column>

                    <Column field="email" header="Email" headerStyle="width:15%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Email</span>
                            {{ slotProps.data.email }}
                        </template>
                    </Column>
                    <Column field="contact_no" header="Contact Number" headerStyle="width:15%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Contact Number</span>
                            {{ slotProps.data.contact_number }}
                        </template>
                    </Column>
                    <Column field="specialization" header="Specialization" headerStyle="width:15%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Specialization</span>
                            {{ slotProps.data.specialization }}
                        </template>
                    </Column>
                    <Column field="status" header="Status" headerStyle="width:10%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Status</span>
                            <span
                                :class="'product-badge status-' + (slotProps.data.status ? slotProps.data.status.toLowerCase() : '')">{{
                                    slotProps.data.status }}</span>
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

                <Dialog v-model:visible="recordDialog" :style="{ width: '450px' }" header="Veterinarian details" :modal="true" @hide="hideDialog" closeOnEscape
                    class="p-fluid">
                    <div class="field">
                        <label for="last_name">Last Name</label>
                        <InputText id="last_name" v-model.trim="record.last_name" name="last_name" autofocus autocomplete="true"
                            :class="{ 'p-invalid': submitted && (errors && errors.last_name || !record.last_name) }" />
                        <small class="p-error" v-if="submitted && errors && errors.last_name">{{ errors.last_name }}</small>
                        <small class="p-error" v-if="submitted && !record.last_name">Last Name is required</small>
                    </div>
                    <div class="field">
                        <label for="first_name">First Name</label>
                        <InputText id="first_name" v-model.trim="record.first_name" name="first_name" autocomplete="true"
                            :class="{ 'p-invalid': submitted && (errors && errors.first_name || !record.first_name) }" />
                        <small class="p-error" v-if="submitted && errors && errors.first_name">{{ errors.first_name }}</small>
                        <small class="p-error" v-if="submitted && !record.first_name">First Name is required</small>
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <InputText id="email" v-model.trim="record.email" name="email" autocomplete="true"
                            :class="{ 'p-invalid': submitted && (errors && errors.email || !record.email) }" />
                        <small class="p-error" v-if="submitted && errors && errors.email">{{ errors.email }}</small>
                        <small class="p-error" v-if="submitted && !record.email">Email is required</small>
                    </div>
                    <div class="field">
                        <label for="contact_number">Contact Number</label>
                        <InputText id="contact_number" v-model.trim="record.contact_number" name="name" autocomplete="true"
                            :class="{ 'p-invalid': submitted && (errors && errors.contact_number || !record.contact_number) }" />
                        <small class="p-error" v-if="submitted && errors && errors.contact_number">{{ errors.contact_number }}</small>
                        <small class="p-error" v-if="submitted && !record.contact_number">Contact Number is required</small>
                    </div>
                    <div class="field">
                        <label for="specialization">Specialization</label>
                        <Textarea id="specialization" v-model="record.specialization" name="specialization" rows="5" cols="20"
                            :class="{ 'p-invalid': submitted && (errors && errors.specialization || !record.specialization) }" />
                        <small class="p-error" v-if="submitted && errors && errors.specialization">{{ errors.specialization
                        }}</small>
                        <small class="p-error" v-if="submitted && !record.specialization">Specialization is required</small>
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <SelectButton v-model="record.status" :options="statuses" id="status" name="status"
                            :class="{ 'p-invalid': submitted && (errors && errors.status || !record.status) }"
                            aria-labelledby="basic" />
                        <small class="p-error" v-if="submitted && errors && errors.status">{{ errors.status }}</small>
                        <small class="p-error" v-if="submitted && !record.status">Status is required</small>
                    </div>

                    <template #footer>
                        <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog" />
                        <Button label="Save" icon="pi pi-check" class="p-button-text" @click="saveRecord" />
                    </template>
                </Dialog>

                <Dialog v-model:visible="deleteRecordDialog" :style="{ width: '450px' }" header="Confirm" :modal="true" closeOnEscape>
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                        <span v-if="record">Are you sure you want to delete <b>{{ record.last_name }}, {{ record.first_name }}</b>?</span>
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
