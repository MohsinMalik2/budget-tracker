<script setup>
import { ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import axios from 'axios';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DisapproveModal from '@/Pages/Admin/RequestPartials/DisapproveModal.vue';
import PartialApproveModal from '@/Pages/Admin/RequestPartials/PartialApproveModal.vue';  // Import the new modal
import { Head } from '@inertiajs/vue3';

// Constants
const STATUS = {
  PENDING: 'Pending',
  APPROVED: 'Approved',
  DISAPPROVED: 'Disapproved',
  PARTIAL_APPROVED: 'Partial Approved',
};

// Props
const { request } = usePage().props;

// Reactive state
const requestDetails = ref(request || {
  user: { name: 'N/A' },
  requested_amount: 0,
  reason: 'N/A',
  title: 'N/A',
  status: 'N/A',
  created_at: 'N/A',
});

const isUpdating = ref(false);
const showDisapproveModal = ref(false);
const showPartialApproveModal = ref(false);  // To control the partial approve modal visibility

// Methods
const updateRequestStatus = async (status, remarks = '', approvedAmount = 0) => {
  isUpdating.value = true;
  try {
    await axios.post('/admin/requests/update-status', {
      id: requestDetails.value.id,
      status,
      remarks,
      approvedAmount,
    });
    requestDetails.value.status = status;
  } catch (error) {
    alert('Something went wrong while updating the request status.');
  } finally {
    isUpdating.value = false;
  }
};

const openDisapproveModal = () => {
  showDisapproveModal.value = true;
};

const closeDisapproveModal = () => {
  showDisapproveModal.value = false;
};

const openPartialApproveModal = () => {
  showPartialApproveModal.value = true;  // Show the partial approval modal
};

const closePartialApproveModal = () => {
  showPartialApproveModal.value = false;
};

const handleDisapprove = (remarks) => {
  updateRequestStatus(STATUS.DISAPPROVED, remarks);
  closeDisapproveModal();
};

const handlePartialApprove = (payload) => {
  updateRequestStatus(STATUS.PARTIAL_APPROVED, payload.remarks, payload.approvedAmount);
  closePartialApproveModal();
};

const goBack = () => {
  router.get('/admin/requests');
};
</script>

<template>
  <Head title="Request Details" />

  <AdminLayout>
    <template #header>
      <h2 class="text-2xl font-semibold text-gray-800">Request Details</h2>
    </template>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
      <h3 class="text-xl font-semibold mb-4">Request Information</h3>
      <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
          <p class="text-gray-600 font-medium">User Name:</p>
          <p class="text-gray-800">{{ requestDetails.user?.name || 'N/A' }}</p>
        </div>
        <div>
          <p class="text-gray-600 font-medium">Requested Amount:</p>
          <p class="text-gray-800">Rs. {{ requestDetails.requested_amount || '0' }}</p>
        </div>
        <div>
          <p class="text-gray-600 font-medium">Reason:</p>
          <p class="text-gray-800">{{ requestDetails.reason || 'N/A' }}</p>
        </div>
        <div>
          <p class="text-gray-600 font-medium">Title:</p>
          <p class="text-gray-800">{{ requestDetails.title || 'N/A' }}</p>
        </div>
        <div>
          <p class="text-gray-600 font-medium">Status:</p>
          <p class="text-gray-800 capitalize">{{ requestDetails.status || 'N/A' }}</p>
        </div>
        <div>
          <p class="text-gray-600 font-medium">Created At:</p>
          <p class="text-gray-800">{{ requestDetails.created_at || 'N/A' }}</p>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end gap-4">
        <button
          v-if="requestDetails.status === STATUS.PENDING"
          @click="updateRequestStatus(STATUS.APPROVED)"
          :disabled="isUpdating"
          class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
        >
          Approve
        </button>

        <button
          v-if="requestDetails.status === STATUS.PENDING"
          @click="openDisapproveModal"
          :disabled="isUpdating"
          class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
        >
          Disapprove
        </button>

        <button
          v-if="requestDetails.status === STATUS.PENDING"
          @click="openPartialApproveModal"
          :disabled="isUpdating"
          class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
        >
          Partially Approve
        </button>

        <button
          @click="goBack"
          class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded"
        >
          Back
        </button>
      </div>
    </div>

    <!-- Disapprove Modal -->
    <DisapproveModal
      v-if="showDisapproveModal"
      :showModal="showDisapproveModal"
      :isUpdating="isUpdating"
      :requestDetails="requestDetails"
      @close-modal="closeDisapproveModal"
      @disapprove-request="handleDisapprove"
    />

    <!-- Partial Approve Modal -->
    <PartialApproveModal
      v-if="showPartialApproveModal"
      :showModal="showPartialApproveModal"
      :isUpdating="isUpdating"
      :requestDetails="requestDetails"
      @close-modal="closePartialApproveModal"
      @partial-approve-request="handlePartialApprove"
    />
  </AdminLayout>
</template>
