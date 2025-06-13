# ParkingManager Roleplay

## Présentation

ParkingManager est une application web de simulation de gestion de parking. Elle permet de visualiser et d'analyser les données liées à l'entrée, au stationnement et au rejet de différents types de véhicules dans un parking. L'application propose également des statistiques sur les émissions de CO2 et des visualisations graphiques pour permettre de choisir la stratégie de tarification idéale pour un parking.

## Fonctionnalités principales

- **Simulation de véhicules** : Affichage des véhicules entrés, garés et rejetés par type (voiture, camion, moto, etc.).
- **Statistiques CO2** : Affichage des émissions de CO2 générées par les véhicules.
- **Visualisations graphiques** : Diagrammes circulaires pour la répartition des véhicules garés et rejetés.
- **Tableaux de bord** : Vue synthétique des données de simulation.

## Structure du projet

```
parkingmanager-roleplay/
├── frontend/                # Application frontend Vue.js
│   ├── src/
│   │   ├── components/      # Composants Vue.js (Simulation, Graphiques, etc.)
│   │   ├── App.vue
│   │   └── main.js
│   ├── index.html
│   └── ...
├── public/
│   ├── api/                 # API simulée ou fichiers d'API
│   └── medias/              # Fichiers médias (images, vidéos, etc.)
├── README.md                # Ce fichier
└── ...
```

## Installation

1. **Prérequis** :
    - Node.js >= 16
    - npm >= 8

2. **Installation des dépendances** :

```bash
cd frontend
npm install
```

3. **Lancement du serveur de développement** :

```bash
npm run dev
```

L'application sera accessible sur `http://localhost:5173` (ou le port affiché dans le terminal).

## Utilisation

- Accédez à l'application via votre navigateur.
- Visualisez les statistiques et les graphiques générés à partir des données de simulation.

## Technologies utilisées

- [Vue.js 3](https://vuejs.org/)
- [Vite](https://vitejs.dev/)
- [Tailwind CSS](https://tailwindcss.com/)

## Licence

Ce projet est sous licence MIT.

