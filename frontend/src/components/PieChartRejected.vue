<template>
    <Pie :data="chartData" :options="chartOptions" class="bg-gray-100 border-l-8 border-red-600 text-slate-50 p-2 rounded-xl shadow-md"/>
</template>

<script setup>
import { computed } from 'vue'
import { Pie } from 'vue-chartjs'
import {
  Chart as ChartJS,
  ArcElement, Tooltip, Legend, Title
} from 'chart.js'
import ChartDataLabels from 'chartjs-plugin-datalabels'
ChartJS.register(ArcElement, Tooltip, Legend, ChartDataLabels, Title)

const props = defineProps({
  vehiculesData: Object
})

const chartData = computed(() => {
  const labels = []
  const data = []
  if (props.vehiculesData) {
    for (const [type, value] of Object.entries(props.vehiculesData)) {
      let label = ''
      switch (type) {
        case 'car':
          label = 'Voitures'
          break
        case 'electric':
          label = 'Voitures électriques'
          break
        case 'truck':
          label = 'Camions'
          break
        case 'moto':
          label = 'Motos'
          break
        case 'bike':
          label = 'Vélos'
          break
      }
      labels.push(label)
      data.push(value.rejected)
    }
  }
  return {
    labels,
    datasets: [
      {
        label: 'Nombre de véhicules',
        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
        data
      }
    ]
  }
})

const chartOptions = {
  responsive: true,
  plugins: {
    legend: { position: 'bottom' },
    title: {
      display: true,
      text: 'Nombre de véhicules refusés par type',
      font: { size: 18, weight: 'bold' }
    },
    datalabels: {
      formatter: (value, context) => {
        const data = context.chart.data.datasets[0].data
        const total = data.reduce((a, b) => a + b, 0)
        const percentage = ((value / total) * 100).toFixed(1) + '%'
        return percentage
      },
      color: '#fff',
      font: { weight: 'bold' }
    }
  }
}
</script>
