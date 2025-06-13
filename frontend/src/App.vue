<script setup>
import SimulationSummary from './components/SimulationSummary.vue'
import SimulationCO2 from './components/SimulationCO2.vue'
import SimulationVehicleBreakdown from './components/SimulationVehicleBreakdown.vue'
import PieChartParked from './components/PieChartParked.vue'
import PieChartRejected from './components/PieChartRejected.vue'

import { ref, onMounted, computed } from 'vue'

const simulation = ref(null)

const fetchSimulation = async () => {
  const res = await fetch('https://3ff6-79-174-192-82.ngrok-free.app/index.php?route=scenario', {
    headers: {
      'ngrok-skip-browser-warning': 'true'
    }
  })
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
  <div class="min-h-screen bg-gradient-to-br from-gray-100 via-white to-gray-100 p-6 font-sans">
    <h1 class="text-4xl font-extrabold text-center text-slate-800 mb-10">
      Résultat du parking –
      <span v-if="formattedSimulationName" class="text-blue-600">{{ formattedSimulationName }}</span>
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
      <div class="bg-white rounded-2xl shadow-lg p-6 transition hover:shadow-xl">
        <SimulationVehicleBreakdown v-if="simulation" :data="simulation" />
      </div>

      <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 transition hover:shadow-xl">
          <SimulationSummary
              v-if="simulation"
              :traffic="simulation.traffic"
              :revenue="simulation.revenue"
          />
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 transition hover:shadow-xl">
          <SimulationCO2
              v-if="simulation"
              :co2="simulation.co2"
          />
        </div>
      </div>
    </div>

    <div class="flex gap-6 mb-8" style="min-height: 400px;">
      <div class="bg-white rounded-2xl shadow-lg p-6 flex justify-center items-center transition hover:shadow-xl">
        <PieChartParked :vehicules-data="simulation?.byVehicleType" />
      </div>
      <div class="bg-white rounded-2xl shadow-lg p-6 flex justify-center items-center transition hover:shadow-xl">
        <PieChartRejected :vehicules-data="simulation?.byVehicleType" />
      </div>
<!--      image frontend/public/medias/car_park.jpg-->
      <div class="bg-white rounded-2xl flex justify-center items-center transition hover:shadow-xl">
        <img src="/medias/car_park.jpg" alt="Parking" class="w-full h-auto rounded-lg shadow-md" />
      </div>
    </div>
  </div>
</template>
