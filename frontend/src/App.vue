<script setup>
import SimulationSummary from './components/SimulationSummary.vue'
import SimulationCO2 from './components/SimulationCO2.vue'
import SimulationVehicleBreakdown from './components/SimulationVehicleBreakdown.vue'
import PieChartParked from './components/PieChartParked.vue'
import PieChartRejected from './components/PieChartRejected.vue'

import { ref, onMounted, computed } from 'vue'

const simulation = ref(null)

const fetchSimulation = async () => {
  const res = await fetch('/api/dashboard.json')
  simulation.value = await res.json()
}

onMounted(() => {
  fetchSimulation()
  setInterval(fetchSimulation, 30000)
})

// Format simulation name to a human-readable date
const formattedSimulationName = computed(() => {
  if (!simulation.value?.simulationName) return ''
  const raw = simulation.value.simulationName // ex: "ParkingManager_2025-06-11_14-00"

  const parts = raw.split('_')
  if (parts.length < 3) return raw

  const datePart = parts[1] // "2025-06-11"
  const timePart = parts[2] // "14-00"

  const [year, month, day] = datePart.split('-')
  const [hour, minute] = timePart.split('-')

  const date = new Date(`${year}-${month}-${day}T${hour}:${minute}:00`)
  return date.toLocaleString('fr-FR', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
})
</script>

<template>
  <div class="min-h-screen bg-white-300 p-4">
    <h1 class="text-3xl font-bold text-center text-slate-900 mb-6">
      Résultat du parking –
      <span v-if="formattedSimulationName">{{ formattedSimulationName }}</span>
    </h1>

    <div class="flex gap-6 mb-8">
      <!-- Left widget -->
      <div class="flex-1 space-y-4">
        <SimulationVehicleBreakdown v-if="simulation" :data="simulation" />
      </div>

      <!-- Right widget -->
      <div class="flex-1 space-y-4">
        <SimulationSummary
            v-if="simulation"
            :traffic="simulation.traffic"
            :revenue="simulation.revenue"
        />
        <SimulationCO2
            v-if="simulation"
            :co2="simulation.co2"
        />
      </div>
    </div>

    <div class="flex gap-6 mb-8" style="height: 350px;">
      <div class="flex-1 space-y-4 h-full flex justify-center" >
        <PieChartParked :vehicules-data="simulation?.byVehicleType" />
      </div>
      <div class="flex-1 space-y-4 h-full flex justify-center">
        <PieChartRejected :vehicules-data="simulation?.byVehicleType" />
      </div>
    </div>
  </div>
</template>
