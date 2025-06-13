<template>
    <Bar :data="chartData" :options="chartOptions"/>
</template>

<script setup>
import { Bar } from 'vue-chartjs';
import {
    Chart as ChartJS,
    CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend,
} from 'chart.js';
ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

const hours = Array.from({ length: 24 }, (_, i) => `${i.toString().padStart(2, '0')}h`);
const entrees = Array.from({ length: 24 }, (_, i) => Math.floor(Math.random() * 20));
const sorties = Array.from({ length: 24 }, (_, i) => Math.floor(Math.random() * 20));

const chartData = {
    labels: hours,
    datasets: [
        {
            label: 'Entrées',
            backgroundColor: 'rgba(34, 197, 94, 0.8)',
            data: entrees
        },
        {
        label: 'Sorties',
        data: sorties,
        backgroundColor: 'rgba(239, 68, 68, 0.8)' // rouge
        }   
    ]
}

const chartOptions = {
    responsive: true,
    plugins: {
        legend: {
            position: 'bottom',
        },
        title: {
            display: true,
            text: 'Entrées et sorties de véhicules par heure'
        },
        datalabels: {
            display: false
        }
    },
    scales: {
        x: {
            grid: {
                display: false
            },
            ticks: {
                callback: function(value, index) {
                    // Affiche seulement une heure sur 2
                    return index % 2 === 0 ? this.getLabelForValue(value) : '';
                }
            }
        },
        y: {
            title: {
                display: true,
                text: 'Nombre de véhicules'
            },
            grid: {
                display: false,
            },
            ticks: {
                stepSize: 5,
            }
        }
    }
}
</script>