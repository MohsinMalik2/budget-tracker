<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const { totalRequests, approvedRequests, pendingRequests, declinedRequests, totalSpent } = usePage().props;

const requestsData = ref({
  totalRequests : totalRequests,
  approvedRequests : approvedRequests,
  pendingRequests : pendingRequests,
  declinedRequests : declinedRequests,
  totalSpent : totalSpent,
});

onMounted(() => {
  // If you want to fetch the data again when the component is mounted, you can make an API call here.
});
</script>

<template>
  <Head title="Admin Dashboard" />

  <AdminLayout>
    <template #header>
      <h2 class="text-2xl font-semibold text-gray-800">Admin Dashboard</h2>
    </template>
    <div class="grid grid-cols-3 gap-4">
      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Total Requests</h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ requestsData.totalRequests }} Requests</p>
        </div>
      </div>

      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Approved Requests</h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ requestsData.approvedRequests }} Approved</p>
        </div>
      </div>

      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Pending Requests</h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ requestsData.pendingRequests }} Pending</p>
        </div>
      </div>

      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Declined Requests</h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ requestsData.declinedRequests }} Declined</p>
        </div>
      </div>

      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Total Spent</h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">Rs. {{ requestsData.totalSpent }}</p>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
