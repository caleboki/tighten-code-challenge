<template>
    <div class="bg-gray-100 p-6 mt-6">
        <h2 class="text-2xl text-gray-900 font-medium mb-4">Observations</h2>
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Date</th>
                    <th class="py-2 px-4 border-b">Capybara</th>
                    <th class="py-2 px-4 border-b">City</th>
                    <th class="py-2 px-4 border-b">Hat Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="observation in observations" :key="observation.id">
                    <td class="py-2 px-4 border-b text-gray-700">{{ formatDate(observation.date) }}</td>
                    <td class="py-2 px-4 border-b text-indigo-500">{{ getCapybaraName(observation.capybara_id) }}</td>
                    <td class="py-2 px-4 border-b text-gray-700">{{ observation.city }}</td>
                    <td class="py-2 px-4 border-b" :class="observation.hat ? 'text-green-500' : 'text-red-500'">
                        {{ observation.hat ? 'Wearing a hat' : 'Not wearing a hat' }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="mt-4 flex justify-center items-center">
            <button @click="fetchPage(observationsState.prevPageUrl)" :disabled="!observationsState.prevPageUrl" class="mx-1 px-4 py-2 border rounded-md bg-blue-500 text-white hover:bg-blue-600" :class="{'opacity-50 cursor-not-allowed': !observationsState.prevPageUrl}">Previous</button>
            <span class="mx-2">Page {{ observationsState.currentPage }} of {{ observationsState.lastPage }}</span>
            <button @click="fetchPage(observationsState.nextPageUrl)" :disabled="!observationsState.nextPageUrl" class="mx-1 px-4 py-2 border rounded-md bg-blue-500 text-white hover:bg-blue-600" :class="{'opacity-50 cursor-not-allowed': !observationsState.nextPageUrl}">Next</button>
        </div>


    </div>
</template>

<script setup>
import { ref, onMounted, inject } from 'vue';
import api from '../services/api';
import moment from 'moment';

const fetchObservations = inject('fetchObservations');
const observationsState = inject('observations');

const fetchPage = (url) => {
    if (url) {
        fetchObservations(url);
    }
};

const props = defineProps({
    observations: {
        type: Array,
        required: true
    }
});

const capybaras = inject('capybaras');

const fetchCapybaras = async () => {
    try {
        const response = await api.listCapybaras();
        capybaras.value = response.data.data;
    } catch (error) {
        console.error("Failed to fetch capybaras:", error);
    }
};

// Fetch the list of capybaras when the component is mounted
onMounted(fetchCapybaras);

const getCapybaraName = (id) => {
    //const capybara = capybaras.value.find(c => c.id === id);
    const capybara = capybaras.data.find(c => c.id === id);
    return capybara ? capybara.name : 'Unknown';
};

const formatDate = (date) => {
  return moment(date).format("MMM Do YY");
};


</script>
