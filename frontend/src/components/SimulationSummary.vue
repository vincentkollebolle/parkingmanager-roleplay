<template>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-gray-100 border-l-4 border-blue-500 text-blue-800 p-4 rounded-xl shadow-md">
      <p class="text-md font-semibold">
        🚦 Véhicules générés : <strong>{{ traffic.totalVehiclesGenerated }}</strong><br>
        🅿️ Garés : <strong>{{ traffic.totalVehiclesParked }}</strong><br>
        ❌ Rejetés : <strong>{{ traffic.totalVehiclesRejected }}</strong>
      </p>
    </div>

    <div class="bg-gray-100 border-l-4 border-green-500 text-green-800 p-4 rounded-xl shadow-md">
      <p class="text-md font-semibold">
        💶 Revenus gagnés : <strong>{{ revenue.moneyEarn }} €</strong><br>
        🧾 Manque à gagner : <strong class="text-red-600">{{ revenue.lossOfEarning }} €</strong>
      </p>
    </div>
  </div>
</template>

<script setup>
defineProps({
  traffic: Object,
  revenue: Object
})
</script>
