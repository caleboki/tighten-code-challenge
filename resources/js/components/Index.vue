<template>
    <section class="text-gray-600 body-font">
      <div class="container px-5 py-24 mx-auto flex flex-wrap">
        <div class="lg:w-2/3 mx-auto">

          <!-- Smaller horizontal containers -->
          <div class="flex flex-wrap -mx-2 mb-4">
            <div class="px-2 w-1/2">
              <!-- Create Capybara Component -->
              <CreateCapybara />
            </div>
            <div class="px-2 w-1/2">
              <!-- Submit Observation Component -->
              <SubmitObservation :key="submitObservationKey"/>
            </div>
          </div>

          <!-- Wider container -->
        <div class="flex flex-wrap w-full bg-gray-100 justify-center items-center relative">
            <!-- List Observations Component -->
            <ListObservations  :observations="observations.data" />
        </div>

        </div>
      </div>
    </section>
  </template>



<script setup>
import { reactive, onMounted, ref, provide } from 'vue';
import CreateCapybara from './CreateCapybara.vue';
import SubmitObservation from './SubmitObservation.vue';
import ListObservations from './ListObservations.vue';
import api from '../services/api';

const observations = reactive({ data: [], currentPage: 1, lastPage: 1, nextPageUrl: null, prevPageUrl: null });


const fetchObservations = async (url = null) => {
    try {
        let response;
        if (url && typeof url === 'string') {
            response = await api.listObservations(url);
        } else {
            response = await api.listObservations();
        }
        observations.data = response.data.data;
        observations.currentPage = response.data.meta.current_page[0];
        observations.lastPage = response.data.meta.last_page[0];
        observations.nextPageUrl = response.data.links.next[0];
        observations.prevPageUrl = response.data.links.prev[0];
        console.log(observations.nextPageUrl)
    } catch (error) {
        console.error("Failed to fetch observations:", error);
    }
};



const refreshList = async () => {
    await fetchObservations();
};

const submitObservationKey = ref(0);

const refreshCapybaras = async () => {
    submitObservationKey.value++; // Increment the key
};

provide('refreshList', refreshList);
provide('refreshCapybaras', refreshCapybaras);

provide('fetchObservations', fetchObservations);
provide('observations', observations);

onMounted(fetchObservations);

</script>
