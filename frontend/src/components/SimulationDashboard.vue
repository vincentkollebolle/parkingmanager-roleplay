<template>
  <div v-if="simulation" class="w-full max-w-4xl mx-auto space-y-8">
    <SimulationVehicleBreakdown :data="simulation" />
    <SimulationSummary :traffic="simulation.traffic" :revenue="simulation.revenue" />
    <SimulationCO2 :co2="simulation.co2" />
  </div>

  <div v-else class="text-center text-gray-500 mt-8">Chargement des données de simulation...</div>
</template>

<script setup>
import SimulationVehicleBreakdown from './SimulationVehicleBreakdown.vue'
import SimulationSummary from './SimulationSummary.vue'
import SimulationCO2 from './SimulationCO2.vue'

</script>
