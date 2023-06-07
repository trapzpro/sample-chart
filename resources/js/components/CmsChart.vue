<template>
    <div class="">
        <p class="mb-4">This chart shows the number of procedures performed per procedure, for the selected state.</p>
        <div class="flex w-full justify-between space-x-2 lg:space-x-6">
            <select v-model="selectedState" class="w-3/4 border border-gray-300 rounded p-2 mb-4">
                <option disabled value="">Please select a state</option>
                <option v-for="state in states" :key="state" :value="state">
                    {{ state }}
                </option>
            </select>

            <button class="w-1/4 border border-gray-300 rounded p-2 mb-4" @click="applyFilters">Apply</button>

                <Bar :data="data" :options="options" />

        </div>
    </div>

</template>

<script lang="ts">
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js'
import { Bar } from 'vue-chartjs'
import axios from 'axios'

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

export default {
    name: 'CmsChart',
    components: {
        Bar
    },
    data() {
        return {
            states: [],
            selectedState: '',
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }

        };
    },
    created() {
        // Fetch states from '/api/states'
        axios.get('/api/states')
            .then(response => {
                this.states = response.data;
            })
            .catch(error => {
                console.log(error);
            });

    },
    methods: {
        applyFilters() {
            // get the data from the API
            axios.get('/api/chartForState', {
                params: {
                    state: this.selectedState,
                    // procedure: this.selectedProcedure
                }
            })
                .then(response => {
                    // update the chart data
                    this.data = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};

</script>
