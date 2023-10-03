<template>
    <div class="flex flex-wrap w-full bg-gray-100 sm:py-24 py-16 sm:px-10 px-6 relative">

      <div class="text-center relative z-10 w-full">
        <h2 class="text-xl text-gray-900 font-medium title-font mb-2">Submit Observation</h2>

        <!-- Error Messages -->
        <div v-if="Object.keys(errors).length" class="bg-red-100 p-4 rounded mb-4">
          <ul>
            <li v-for="(errorMessages, field) in errors" :key="field">
              <li v-for="errorMessage in errorMessages" :key="errorMessage" class="text-red-600">{{ errorMessage }}</li>
            </li>
          </ul>
        </div>
        <!-- Display Success Message -->
        <div v-if="successMessage" class="text-green-500">{{ successMessage }}</div>

        <!-- Form Fields -->
        <div class="mt-4">
          <select v-model="capybaraId" class="border p-2 rounded w-full mb-2">
            <option v-for="capybara in capybaras.data" :key="capybara.id" :value="capybara.id">
              {{ capybara.name }}
            </option>
          </select>
          <input type="date" v-model="date" placeholder="Date" class="border p-2 rounded w-full mb-2" />
          <select v-model="city" class="border p-2 rounded w-full mb-2">
            <option value="chicago">Chicago</option>
            <option value="atlanta">Atlanta</option>
            <option value="new york">New York</option>
            <option value="houston">Houston</option>
            <option value="san francisco">San Francisco</option>
          </select>
          <label class="flex items-center mb-2">
            <input type="checkbox" v-model="hat" class="mr-2" />
            Wearing a Hat?
          </label>
          <button :disabled="!isFormValid" @click="submitObservation" class="bg-indigo-500 text-white p-2 rounded hover:bg-indigo-600">Submit Observation</button>
        </div>
      </div>
    </div>
  </template>




<script setup>
import { ref, onMounted, computed, inject } from 'vue';
import api from '../services/api';

const capybaraId = ref(null);
const date = ref('');
const city = ref('');
const hat = ref(false);
const errors = ref({});
const capybaras = ref([]); // This will hold the list of capybaras
const successMessage = ref('');

const fetchCapybaras = async () => {
    try {
        const response = await api.listCapybaras();
        capybaras.value = response.data;
        console.log(capybaras.value.data)
    } catch (error) {
        console.error("Failed to fetch capybaras:", error);
    }
};

const refreshList = inject('refreshList');


const resetForm = () => {
    capybaraId.value = null;
    date.value = '';
    city.value = '';
    hat.value = false;
    errors.value = {};
};

const submitObservation = async () => {
    try {
        await api.submitObservation({
            capybara_id: capybaraId.value,
            date: date.value,
            city: city.value,
            hat: hat.value
        });

        successMessage.value = 'Observation added successfully!';

        // Clear the form
        resetForm();

        setTimeout(() => {
            successMessage.value = '';
        }, 3000);


    } catch (error) {
        if (error.response && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            errors.value = {};
        }
    }
    refreshList();
};

const isFormValid = computed(() => {
    return capybaraId.value && date.value && city.value;
});

// Fetch the list of capybaras when the component is mounted
onMounted(() => {
    fetchCapybaras();
});
</script>
