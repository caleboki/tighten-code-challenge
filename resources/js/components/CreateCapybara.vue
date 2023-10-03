<template>
    <div class="flex flex-wrap w-full bg-gray-100 sm:py-24 py-16 sm:px-10 px-6 relative">

      <div class="text-center relative z-10 w-full">
        <h2 class="text-xl text-gray-900 font-medium title-font mb-2">Create Capybara</h2>
        <div v-if="Object.keys(errors).length" class="bg-red-100 p-4 rounded mb-4">
            <ul>
                <li v-for="(errorMessages, field) in errors" :key="field">
                    <li v-for="errorMessage in errorMessages" :key="errorMessage" class="text-red-600">{{ errorMessage }}</li>
                </li>
            </ul>
        </div>
        <div v-if="successMessage" class="bg-green-100 p-4 rounded mb-4 text-green-600">{{ successMessage }}</div>
        <input v-model="name" placeholder="Name" class="border p-2 rounded w-full mb-2" />
        <input v-model="color" placeholder="Color" class="border p-2 rounded w-full mb-2" />

        <input v-model="size" placeholder="Size" class="border p-2 rounded w-full mb-4" />
        <button :disabled="!isFormValid" @click="create" class="bg-indigo-500 text-white p-2 rounded hover:bg-indigo-600">Create Capybara</button>

      </div>
    </div>
  </template>



<script setup>
import { ref, computed, inject } from 'vue';
import api from '../services/api';

const name = ref('');
const color = ref('');
const size = ref('');
const errors = ref({});
const successMessage = ref('');

const resetForm = () => {
    name.value = '';
    color.value = '';
    size.value = '';
    errors.value = {};
};

const refreshCapybaras = inject('refreshCapybaras');

const create = async () => {
    try {
        await api.createCapybara({ name: name.value, color: color.value, size: size.value });
        successMessage.value = 'A new Capybara was created successfully!';
        // Clear the form
        resetForm();

        setTimeout(() => {
            successMessage.value = '';
        }, 3000);
        refreshCapybaras();

    } catch (error) {
        errors.value = error.response.data.errors;
    }
};

const isFormValid = computed(() => {
    return name.value && color.value && size.value;
});
</script>
