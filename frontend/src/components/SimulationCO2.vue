<template>
  <div class="bg-gray-100 border-l-4 border-gray-400 text-gray-800 p-4 rounded-xl shadow-md">
    <p class="text-md font-semibold">
      🌍 Émissions CO₂ pendant l’attente : <strong>{{ co2.totalEmittedWhileWaiting.toFixed(1) }} kg</strong><br>
      🔥 Moyenne par véhicule rejeté : <strong>{{ co2.averageEmissionPerRejectedVehicle }} kg</strong>
    </p>
  </div>
</template>

<script setup>
defineProps({ co2: Object })
</script>
