# Parking Manager v1.0

## Objectif
Simulateur de parking intelligent intégrant des patterns de conception pour gérer dynamiquement les véhicules et maximiser les revenus tout en minimisant les émissions de CO₂.

---

## Langage
- PHP 8+

---

## Design Patterns Utilisés
- **Singleton** : pour les points d'accès globaux (ex. : `Router`, `IncomeTracker`, `CO2Tracker`)
- **Observer** : pour le `Clock` et la propagation des ticks
- **Strategy** : pour la politique de tarification
- **Factory** : pour générer les `Vehicle`
- **Builder** : pour instancier des `Vehicle` complexes
- **Decorator** : pour ajouter des comportements dynamiques (ex. réduction éco, bonus)
- **Composite (optionnel)** : pour le regroupement logique des emplacements

---

## Fonctionnement par Tick
- Un tick = une heure simulée
- Le `Clock` émet un `tick()`
- Les observateurs (route, parking, trackers...) réagissent
- Les véhicules peuvent :
  - Arriver
  - Être garés si place disponible
  - Partir si durée atteinte
- Les changements d’état déclenchent une mise à jour d’un fichier JSON

---

## Arborescence du Projet

```

ParkingManager/
├── Core/                  # Logique principale (Clock, Parking, Manager)
├── Entities/              # Entités (Vehicle, ParkingSpot, etc.)
├── Strategies/            # Stratégies tarifaires
├── Trackers/              # Trackers (revenus, CO₂)
├── Factories/             # Fabriques d’objets (VehicleFactory, etc.)
├── Builder/               # Constructeurs pour entités complexes
├── Route/                 # Simulation de la route (générateur véhicules)
├── Interfaces/            # Interfaces contractuelles
├── Tests/
│   ├── Fixtures/
│   ├── Unit/
│   └── Integration/
├── public/
│   └── index.php          # Point d'entrée
└── README.md

```

---

## Fichiers JSON
- **`traffic_schedule.json`** : scénario des arrivées/départs
- **`state.json`** (mis à jour à chaque tick) :
```json
{
  "tick": 37,
  "vehicles": [
    {
      "uid": 1,
      "type": "Car",
      "isParked": true,
      "co2": 0,
      "battery": null
    },
    {
      "uid": 2,
      "type": "ElectricCar",
      "isParked": false,
      "co2": 0.5,
      "battery": 1
    }
  ],
  "income": 470,
  "co2_emitted": 128.5,
  "occupied_spots": 817
}
```

---

## Exposition des Données

* Route **GET /status** (JSON actuel)

  * Implémentée via un `Router` Singleton exposant les données mises à jour

---

## Tests

* **Unit Tests** : sur chaque classe métier
* **Integration Tests** : scénarios complets avec fichier de trafic
* **Fixtures** : exemples de traffic

---

## Installation

TODO

---

## Extensibilité

* Ajouter un `Vehicle` : implémenter `VehicleInterface` et l’enregistrer dans `VehicleFactory`
* Ajouter une stratégie : implémenter `PriceStrategyInterface`
* Ajouter un tracker : observer le `Clock`

---

## Interfaces Principales

* `VehicleInterface`
* `PriceStrategyInterface`
* `ParkingSpotInterface`
* `ClockInterface` (Observable)
* `RouteInterface`
* `IncomeTrackerInterface`
* `CO2TrackerInterface`
* `DashboardInterface`

---

## Spécificités Voiturier

* Stationne et déstationne les véhicules
* Déplace les `ElectricCar` rechargés vers un slot normal

---

## Composition Parking

* 1000 places totales
* 200 places réservées aux véhicules électriques

---

## Objectifs d’Optimisation

* Maximiser revenus
* Réduire CO₂ émis pendant l’attente
* Comparer l'efficacité des stratégies avec les mêmes données

---

## Liste Stratégies Implémentables

| Nom                 | Description                             |
| ------------------- | --------------------------------------- |
| FlatRateStrategy    | Tarif fixe quel que soit le temps       |
| HourlyStrategy      | Tarif par heure complète                |
| DemandBasedStrategy | +X% si > 80% des places sont occupées   |
| EcoFriendlyDiscount | -20% pour véhicules électriques         |
| NightRateStrategy   | Réduction 22h-6h                        |
| RandomBonusStrategy | 1 véhicule/10 a une réduction aléatoire |
