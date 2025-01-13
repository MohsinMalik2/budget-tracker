<script setup>
    import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { ref, onMounted } from 'vue';
    import { usePage, router } from '@inertiajs/vue3';
    import axios from 'axios';


    // Fetch the initial paginated data passed from the backend
    const { requests: initialRequests } = usePage().props;

    const requestList = ref(initialRequests.data); // Store the list of requests
    const isLoading = ref(false);
    const error = ref(null);


    // Method to handle viewing the request
    const viewRequest = (requestId) => {
        // Use Inertia.js to navigate to the request details page
        router.get(`/admin/requests/${requestId}`);
    };

    // Method to handle approving the request
    const approveRequest = (requestId) => {
        updateRequestStatus(requestId, 'Approved');
    };

    // Method to handle disapproving the request
    const disapproveRequest = (requestId) => {
        updateRequestStatus(requestId, 'Disapproved');
    };

    // Method to update the request status
    const updateRequestStatus = (requestId, status) => {
        axios.post('/admin/requests/update-status', {
            id: requestId,
            status: status
        })
        .then(response => {
            // Optionally, refresh the request list or show success message
            location.reload(); // This reloads the entire page
        })
        .catch(error => {
            console.error('Failed to update status:', error);
            alert('Something went wrong while updating the request status.');
        });
    };
</script>

<template>
  <Head title="Request List" />

  <AdminLayout>
    <template #header>
      <h2 class="text-2xl font-semibold text-gray-800">Request List</h2>
    </template>

    <div class="overflow-x-auto">
      <!-- Action Buttons -->
      <div class="py-5 text-right">
        <button
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >
          + Create New Request
        </button>
      </div>

      <!-- Error Message -->
      <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ error }}
      </div>

      <!-- Loading State -->
      <div v-if="isLoading" class="text-center py-4">
        <span class="text-gray-500">Loading requests...</span>
      </div>

      <!-- Table -->
      <table v-else class="min-w-full table-auto">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested Amount</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
          </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="(request, index) in requestList" :key="index">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ request.user.name}}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rs. {{ request.requested_amount }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ request.reason }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ request.title || 'N/A' }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ request.status }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <button
                @click="viewRequest(request.id)"
                class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600"
              >
                View
              </button>
              <button
                v-if="request.status === 'Pending'"
                @click="approveRequest(request.id)"
                class="px-4 py-2 ml-2 text-white bg-green-500 rounded-md hover:bg-green-600 border"
                >
                Approve
                </button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Empty State -->
      <div v-if="!isLoading && !requestList.length" class="text-center py-4">
        <span class="text-gray-500">No requests found.</span>
      </div>
    </div>
  </AdminLayout>
</template>
