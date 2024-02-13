<script>
export default {
    layout: AppLayout
}
</script>

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
    services: Object,
    flash: Object,
    search: String
})

const toast = useToast();
const services = ref(null);
const serviceDialog = ref(false);
const deleteServiceDialog = ref(false);
const service = ref({});
const dt = ref(null);
const submitted = ref(false);
const statuses = ref(['Active', 'Inactive']);

const first = ref(0);
const currentPage = ref(0);
const search = ref('');
const last = ref(0);
const totalRecords = ref(0);
const perPage = ref(0);
const loading = ref(false);

onMounted(() => {
    reloadDataTable();
});

const reloadDataTable = () => {
    services.value = props.services.data;
    first.value = props.services.meta.from - 1;
    last.value = props.services.meta.last_page;
    totalRecords.value = props.services.meta.total;
    perPage.value = props.services.meta.per_page;
    search.value = props.search;
}

const handlePageUpdate = (page) => {
    currentPage.value = page.page += 1;
    loadData(currentPage, search.value);
}

watch(search, debounce((value) => {
    currentPage.value = 1;
    loadData(currentPage, value);
}, 500));

const loadData = (currentPage, searchKey) => {
    const urlData = {
        page: currentPage.value,
        search: searchKey
    }

    router.get('/admin/services', urlData, {
        preserveScroll: true,
        preserveState: true,
        onBefore: () => {
            loading.value = true;
        },
        onSuccess: () => {
            reloadDataTable();
            loading.value = false;
        }
    });
}

const formatCurrency = (value) => {
    return value.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
};

const openNew = () => {
    service.value = {};
    submitted.value = false;
    serviceDialog.value = true;
};

const hideDialog = () => {
    serviceDialog.value = false;
    submitted.value = false;
};

const saveRecord = () => {
    submitted.value = true;
    if (service.value.name && service.value.name.trim() && service.value.min_price && service.value.max_price && service.value.status) {
        const postData = {
            name: service.value.name,
            description: service.value.description,
            min_price: service.value.min_price,
            max_price: service.value.max_price,
            status: service.value.status
        };

        if (service.value.id) {
            router.put(`/admin/services/${service.value.id}`, postData, {
                onSuccess: () => {
                    reloadDataTable();
                    toast.add({ severity: 'success', summary: 'Successful', detail: props.flash.success, life: 3000 });

                    serviceDialog.value = false;
                    service.value = {};
                },
            });
        } else {
            router.post('/admin/services', postData, {
                onSuccess: () => {
                    reloadDataTable();
                    toast.add({ severity: 'success', summary: 'Successful', detail: props.flash.success, life: 3000 });

                    serviceDialog.value = false;
                    service.value = {};
                },
            });
        }
    }
};

const editRecord = (recordData) => {
    service.value = { ...recordData };
    serviceDialog.value = true;
};

const confirmDeleteRecord = (deleteData) => {
    service.value = deleteData;
    deleteServiceDialog.value = true;
};

const deleteRecord = () => {
    deleteServiceDialog.value = false;

    router.delete(`/admin/services/${service.value.id}`, {
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

                <DataTable ref="dt" lazy paginator :loading="loading" @page="handlePageUpdate"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    currentPageReportTemplate="Showing {first} to {last} of {totalRecords} records"
                    responsiveLayout="scroll" dataKey="id" :value="services" :first="first" :last="last"
                    :totalRecords="totalRecords" :rows="perPage" :rowsPerPageOptions="[perPage]">
                    <template #header>
                        <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
                            <h5 class="m-0">Manage Services</h5>
                            <span class="block mt-2 md:mt-0 p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText v-model="search" placeholder="Search..." id="search" name="search" />
                            </span>
                        </div>
                    </template>

                    <template #empty>No records found. </template>

                    <Column field="id" header="ID" headerStyle="width:14%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">ID</span>
                            {{ slotProps.data.id }}
                        </template>
                    </Column>
                    <Column field="name" header="Name" headerStyle="width:14%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Name</span>
                            {{ slotProps.data.name }}
                        </template>
                    </Column>
                    <Column field="description" header="Description" headerStyle="width:14%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Description</span>
                            {{ slotProps.data.description }}
                        </template>
                    </Column>
                    <Column field="min_price" header="Minimum Price" headerStyle="width:14%; min-width:8rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Minimum Price</span>
                            {{ formatCurrency(slotProps.data.min_price) }}
                        </template>
                    </Column>
                    <Column field="max_price" header="Maximum Price" headerStyle="width:14%; min-width:8rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Maximum Price</span>
                            {{ formatCurrency(slotProps.data.max_price) }}
                        </template>
                    </Column>
                    <Column field="status" header="Status" headerStyle="width:14%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Status</span>
                            <span
                                :class="'product-badge status-' + (slotProps.data.status ? slotProps.data.status.toLowerCase() : '')">{{
                                    slotProps.data.status }}</span>
                        </template>
                    </Column>
                    <Column headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil" class="p-button-rounded p-button-warning mr-2"
                                @click="editRecord(slotProps.data)" />
                            <Button icon="pi pi-trash" class="p-button-rounded p-button-danger mt-2"
                                @click="confirmDeleteRecord(slotProps.data)" />
                        </template>
                    </Column>
                </DataTable>

                <Dialog v-model:visible="serviceDialog" :style="{ width: '450px' }" header="Service Details" :modal="true"
                    class="p-fluid">
                    <div class="field">
                        <label for="name">Name</label>
                        <InputText id="name" v-model.trim="service.name" required="true" name="name" autofocus
                            autocomplete="true" :class="{ 'p-invalid': submitted && !service.name }" />
                        <small class="p-invalid" v-if="submitted && !service.name">Name is required.</small>
                    </div>
                    <div class="field">
                        <label for="description">Description</label>
                        <Textarea id="description" v-model="service.description" required="true" name="description" rows="3"
                            cols="20" />
                    </div>

                    <div class="formgrid grid">
                        <div class="field col">
                            <label for="min_price">Minimum Price</label>
                            <InputText id="min_price" v-model="service.min_price"
                                :class="{ 'p-invalid': submitted && !service.min_price }" :required="true"
                                name="min_price" />
                            <small class="p-invalid" v-if="submitted && !service.min_price">Minimum price is
                                required.</small>
                        </div>
                        <div class="field col">
                            <label for="max_price">Maximum Price</label>
                            <InputText id="max_price" v-model="service.max_price"
                                :class="{ 'p-invalid': submitted && !service.max_price }" :required="true"
                                name="max_price" />
                            <small class="p-invalid" v-if="submitted && !service.max_price">Maximum price is
                                required.</small>
                        </div>
                    </div>

                    <div class="field">
                        <label>Status</label>
                        <SelectButton v-model="service.status" :options="statuses" id="status" name="status"
                            aria-labelledby="basic" />
                    </div>

                    <template #footer>
                        <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="hideDialog" />
                        <Button label="Save" icon="pi pi-check" class="p-button-text" @click="saveRecord" />
                    </template>
                </Dialog>

                <Dialog v-model:visible="deleteServiceDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                        <span v-if="service">Are you sure you want to delete <b>{{ service.name }}</b>?</span>
                    </div>
                    <template #footer>
                        <Button label="No" icon="pi pi-times" class="p-button-text" @click="deleteServiceDialog = false" />
                        <Button label="Yes" icon="pi pi-check" class="p-button-text" @click="deleteRecord" />
                    </template>
                </Dialog>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss"></style>
