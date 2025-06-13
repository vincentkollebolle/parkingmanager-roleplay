<template>
  <div class="bg-white rounded-xl shadow-md p-6">
    <h3 class="text-lg font-semibold mb-4 text-gray-700">🚘 Données des véhicules entrés</h3>

    <table class="w-full text-xs text-left text-gray-700 border-separate border-spacing-y-1">
      <thead>
      <tr class="text-xs text-gray-500 uppercase bg-gray-100 rounded">
        <th class="p-3 rounded-l-xl">Type</th>
        <th class="p-3 text-center">Garés</th>
        <th class="p-3 text-center">Rejetés</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(type, key) in data.byVehicleType" :key="key" class="bg-white hover:bg-blue-50 rounded">
        <td class="p-3 font-medium text-gray-900">
          {{ getEmoji(key) }} {{ translateType(key) }}
        </td>
        <td class="text-center">{{ type.parked }}</td>
        <td class="text-center">{{ type.rejected }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
defineProps({ data: Object })

const capitalize = (str) => str.charAt(0).toUpperCase() + str.slice(1)

const getEmoji = (type) => {
  switch (type) {
    case 'car': return '🚗'
    case 'electric': return '⚡🚗'
    case 'truck': return '🚛'
    case 'moto': return '🏍️'
    case 'bike': return '🚲'
    default: return '🚙'
  }
}

const vehicleTypeTranslations = {
  car: "Voiture",
  electric: "Voiture électrique",
  truck: "Camion",
  moto: "Moto",
  bike: "Vélo",
}

const translateType = (key) => vehicleTypeTranslations[key] || capitalize(key)
</script>
