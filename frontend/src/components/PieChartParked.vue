<template>
    <Pie :data="chartData" :options="chartOptions" class="bg-gray-100 border-l-8 border-green-500 text-slate-50 p-2 rounded-xl shadow-md" />
</template>

<script setup>
import dashboard from '../../public/api/dashboard.json';
import { Pie } from 'vue-chartjs';
import {
    Chart as ChartJS,
    ArcElement, Tooltip, Legend, Title
} from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';
ChartJS.register(ArcElement, Tooltip, Legend, ChartDataLabels, Title);

const vehiculesData = dashboard.byVehicleType;
const labels = [];
const data = [];

for (const [type, value] of Object.entries(vehiculesData)) {
    let label = ''
    switch (type) {
        case 'car':
            label = 'Voitures';
            break;
        case 'electric':
            label = 'Voitures électriques';
            break;
        case 'truck':
            label = 'Camions';
            break;
        case 'bike':
            label = 'Motos';
            break;
    }
    labels.push(label);
    data.push(value.parked);
}
 
const chartData = {
    labels: labels,
    datasets: [
        {
            label: 'Nombre de véhicules',
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
            data: data
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
            text: 'Nombre de véhicules garés par type',
            font: {
                size: 18,
                weight: 'bold'
            }
        },
        datalabels: {
            formatter: (value, context) => {
                const data = context.chart.data.datasets[0].data;
                const total = data.reduce((a, b) => a + b, 0);
                const percentage = ((value / total) * 100).toFixed(1) + '%';
                return percentage;
            },
            color: '#fff',
            font: {
                weight: 'bold'
            }
        }
    }
}
</script>
