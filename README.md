# 🅿️ Parking Manager RolePlay

Un simulateur de parking intelligent développé en PHP 8+ qui intègre des patterns de conception pour gérer dynamiquement l'arrivée, le stationnement et le départ de véhicules de types variés, selon des politiques de tarification définies.

![PHP Version](https://img.shields.io/badge/PHP-8%2B-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Tests](https://img.shields.io/badge/tests-PHPUnit-orange)

## 📋 Table des matières

- [Aperçu du projet](#aperçu-du-projet)
- [Fonctionnalités](#fonctionnalités)
- [Architecture](#architecture)
- [Installation](#installation)
- [Utilisation](#utilisation)
- [Types de véhicules](#types-de-véhicules)
- [Stratégies de tarification](#stratégies-de-tarification)
- [Tests](#tests)
- [API](#api)
- [Structure du projet](#structure-du-projet)
- [Contribution](#contribution)

## 🎯 Aperçu du projet

Ce simulateur permet de :
- **Maximiser les revenus** du parking en appliquant différentes stratégies tarifaires
- **Minimiser l'impact carbone** en optimisant la gestion des véhicules
- **Analyser les performances** de différentes politiques de tarification
- **Simuler des scénarios réalistes** sur une année complète (8760 ticks = 1 tick par heure)

### Objectifs métier
En tant que propriétaire foncier, le projet permet de simuler l'exploitation d'un parking pour :
- Déterminer la stratégie tarifaire optimale
- Réduire l'impact environnemental
- Maximiser la rentabilité

## ✨ Fonctionnalités

### Fonctionnalités principales
- 🚗 **Gestion multi-véhicules** : Support de 4 types de véhicules (voiture, camion, moto, vélo)
- 📊 **Stratégies tarifaires intelligentes** : 6 stratégies différentes interchangeables
- 🌱 **Suivi environnemental** : Tracking des émissions CO₂
- 💰 **Suivi financier** : Revenus générés et pertes
- ⏱️ **Simulation temporelle** : Horloge observable avec système de ticks
- 📈 **Reporting complet** : Statistiques détaillées par type de véhicule
- 🧪 **Tests automatisés** : Couverture complète (Unit, Integration, Performance)

### Fonctionnalités avancées
- **Voiturier automatique** : Gestion automatisée du stationnement/déstationnement
- **Rejet intelligent** : Véhicules refusés si prix trop élevé
- **Occupation dynamique** : Adaptation des prix selon le taux d'occupation
- **Scénarios reproductibles** : Fichier JSON pour tests cohérents

## 🏗️ Architecture

Le projet utilise plusieurs **Design Patterns** pour assurer une architecture modulaire et extensible :

### Patterns utilisés
- **🔄 Observer** : Horloge et propagation des ticks
- **🎯 Strategy** : Politique de tarification interchangeable
- **🏭 Factory** : Génération des véhicules
- **👤 Singleton** : Points d'accès globaux (Parking, Trackers)
- **🎨 Builder** : Construction d'objets complexes
- **🎪 Decorator** : Comportements dynamiques

### Composants principaux
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│     Clock       │───▶│     Road        │───▶│    Parking      │
│   (Observable)  │    │  (Generator)    │    │  (Singleton)    │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         ▼                       ▼                       ▼
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Trackers      │    │ VehicleFactory  │    │   Strategies    │
│ (CO2, Income)   │    │                 │    │   (Pricing)     │
└─────────────────┘    └─────────────────┘    └─────────────────┘
```

## 🚀 Installation

### Prérequis
- PHP 8.0 ou supérieur
- Composer
- Extensions PHP : `json`, `mbstring`

### Installation étape par étape

1. **Cloner le repository**
```bash
git clone https://github.com/votre-nom/parkingmanager-roleplay.git
cd parkingmanager-roleplay
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Vérifier l'installation**
```bash
# Lancer les tests
./vendor/bin/phpunit

# Test de l'API
php -S localhost:8000 index.php
```

## 📖 Utilisation

### Mode CLI (Command Line Interface)

```bash
# Simulation complète avec le fichier de trafic par défaut
php index.php

# Résultat JSON formaté avec statistiques complètes
```

### Mode API Web

1. **Démarrer le serveur**
```bash
php -S localhost:8000 index.php
```

2. **Endpoints disponibles**

**GET** `/index.php?route=scenario`
- Lance une simulation avec `traffic_schedule.json`
- Retourne les résultats en JSON

**POST** `/index.php?route=scenario`
- Lance une simulation avec données personnalisées
- Body : JSON avec structure de trafic

### Exemple de réponse
```json
{
  "simulationName": "ParkingManager_2025-06-13_14-30",
  "parkingSize": 1000,
  "durationTicks": 8760,
  "revenue": {
    "moneyWon": 158340.50,
    "moneyLost": 23400.00
  },
  "traffic": {
    "totalVehiclesGenerated": 12345,
    "totalVehiclesRejected": 2469
  },
  "byVehicleType": {
    "car": {
      "parked": 8234,
      "rejected": 1245,
      "ticketPricePerHour": 2.0
    }
  },
  "co2": {
    "totalEmittedWhileWaiting": 35400.5,
    "averageEmissionPerRejectedVehicle": 3.8
  }
}
```

## 🚗 Types de véhicules

| Type    | Taille | CO₂ (g/tick) | Prix de base (€/tick) | Description |
|---------|--------|--------------|----------------------|-------------|
| **Car** | 2      | 3.5          | 2.0                  | Voiture standard |
| **Truck** | 3    | 6.0          | 3.5                  | Camion/utilitaire |
| **Moto** | 1     | 1.0          | 1.5                  | Moto/scooter |
| **Bike** | 1     | 0.0          | 0.5                  | Vélo (écologique) |

### Propriétés des véhicules
- **Durée souhaitée** : Temps de stationnement désiré (1-11h)
- **Prix maximum accepté** : Seuil de refus du véhicule
- **Émissions CO₂** : Uniquement pendant l'attente (pas en stationnement)

## 💰 Stratégies de tarification

### 1. **FlatRateStrategy** - Tarif fixe
- Prix constant selon le type de véhicule
- Simple et prévisible

### 2. **HourlyStrategy** - Tarif horaire
- Calcul par tranche horaire complète
- Progressif selon la durée

### 3. **DemandBasedStrategy** - Basé sur la demande
- +20% si occupation > 80%
- Adaptation dynamique à la demande

### 4. **EcoFriendlyDiscountStrategy** - Écologique
- -20% pour véhicules écologiques (vélos, véhicules 0 émission)
- Encourage les transports verts

### 5. **NightRateStrategy** - Tarif nuit
- Réduction 22h-6h
- Optimisation occupation nocturne

### 6. **RandomBonusStrategy** - Bonus aléatoire
- 1 véhicule sur 10 bénéficie d'une réduction
- Effet marketing/fidélisation

### Changer de stratégie
```php
// Dans PriceManager ou directement
$parking->setPriceStrategy(new DemandBasedStrategy());
```

## 🧪 Tests

### Structure des tests
```
tests/
├── Unit/           # Tests unitaires (classes individuelles)
├── Integration/    # Tests d'intégration (scénarios complets)
└── Performance/    # Tests de performance (charge)
```

### Lancer les tests

```bash
# Tous les tests
./vendor/bin/phpunit

# Tests spécifiques
./vendor/bin/phpunit tests/Unit
./vendor/bin/phpunit tests/Integration
./vendor/bin/phpunit tests/Performance

# Avec couverture
./vendor/bin/phpunit --coverage-html coverage/
```

### Tests existants
- ✅ **VehicleTest** : Création et propriétés des véhicules  
- ✅ **ParkingTest** : Singleton, stationnement, capacité
- ✅ **ClockTest** : Observer pattern, ticks
- ✅ **StrategiesTest** : Toutes les stratégies tarifaires
- ✅ **TrackersTest** : CO₂ et revenus
- ✅ **IntegrationTest** : Scénarios complets
- ✅ **PerformanceTest** : Tests de charge

## 🌐 API

### Headers CORS
L'API supporte CORS pour intégration frontend :
```
Access-Control-Allow-Origin: *
Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS
Access-Control-Allow-Headers: *
```

### Format du trafic JSON
```json
[
  {
    "date": "12/06/2025 10:55:30",
    "vehicles": [
      {
        "type": "car",
        "wantedDuration": 4,
        "maxPricePerTick": 8
      },
      {
        "type": "bike", 
        "wantedDuration": 2,
        "maxPricePerTick": 5
      }
    ]
  }
]
```

## 📁 Structure du projet

```
parkingmanager-roleplay/
├── 📁 src/                          # Code source principal
│   ├── 📁 Enum/                     # Énumérations (VehicleEnum)
│   ├── 📁 Interfaces/               # Interfaces contractuelles
│   ├── 📁 Strategy/                 # Stratégies de tarification
│   ├── 📁 Tracker/                  # Trackers (CO₂, revenus)
│   ├── 📄 Clock.php                 # Horloge observable
│   ├── 📄 Parking.php               # Singleton parking
│   ├── 📄 Road.php                  # Générateur de véhicules
│   ├── 📄 Vehicle.php               # Entité véhicule
│   ├── 📄 VehicleFactory.php        # Fabrique de véhicules
│   ├── 📄 PriceManager.php          # Gestionnaire de prix
│   └── 📄 SimulationRunner.php      # Orchestrateur principal
├── 📁 tests/                        # Tests automatisés
│   ├── 📁 Unit/                     # Tests unitaires
│   ├── 📁 Integration/              # Tests d'intégration
│   └── 📁 Performance/              # Tests de performance
├── 📁 vendor/                       # Dépendances Composer
├── 📄 index.php                     # Point d'entrée API/CLI
├── 📄 traffic_schedule.json         # Données de simulation (8760 ticks)
├── 📄 composer.json                 # Configuration Composer
├── 📄 phpunit.xml                   # Configuration PHPUnit
├── 📄 README.md                     # Ce fichier
├── 📄 SPEC_TECHNIQUE.md             # Spécifications techniques
└── 📄 Spec.md                       # Cahier des charges
```

### Interfaces principales
- **VehicleInterface** : Contrat des véhicules
- **PriceStrategyInterface** : Contrat des stratégies tarifaires  
- **ObserverInterface** : Pattern Observer pour l'horloge

### Points d'extension
- **Nouveau type de véhicule** : Ajouter dans `VehicleEnum` et `VehicleFactory`
- **Nouvelle stratégie** : Implémenter `PriceStrategyInterface`
- **Nouveau tracker** : Implémenter `ObserverInterface`

## 🤝 Contribution

### Guidelines de développement
1. **PSR-4** : Respecter l'autoloading standard
2. **PSR-12** : Style de code PHP standard
3. **Tests** : Couvrir toute nouvelle fonctionnalité
4. **Documentation** : Commenter les méthodes publiques

### Workflow de contribution
```bash
# 1. Fork du projet
git fork https://github.com/original/parkingmanager-roleplay

# 2. Créer une branche feature
git checkout -b feature/nouvelle-fonctionnalite

# 3. Développer et tester
./vendor/bin/phpunit

# 4. Commit et push
git commit -m "feat: ajouter nouvelle stratégie XYZ"
git push origin feature/nouvelle-fonctionnalite

# 5. Créer une Pull Request
```

### Ajout d'une nouvelle stratégie
```php
<?php
namespace App\Strategy;

use App\Interfaces\PriceStrategyInterface;
use App\Interfaces\VehicleInterface;

class MaStrategieStrategy implements PriceStrategyInterface
{
    public function calculatePrice(VehicleInterface $vehicle, float $occupancyRate = 0.0): float
    {
        // Votre logique de calcul
        return $price;
    }
}
```

## 📊 Métriques et performances

### Capacité de simulation
- **Parking** : 1000 places configurables
- **Durée** : 8760 ticks (1 année simulée)
- **Véhicules** : Plusieurs milliers par simulation
- **Performance** : < 1 seconde pour 1000 véhicules

### Optimisations implémentées
- Singleton pour éviter les instances multiples
- Factory pattern pour l'efficacité de création
- Observer pattern pour la performance des notifications

## 🔧 Configuration avancée

### Variables d'environnement
```bash
# Optionnel : configuration personnalisée
PARKING_SIZE=1000
SIMULATION_DURATION=8760
DEBUG_MODE=false
```

### Paramètres de simulation
- Modifier `$parkingSize` dans `SimulationRunner`
- Adapter `$durationTicks` selon vos besoins
- Personnaliser `traffic_schedule.json`

## 📚 Ressources complémentaires

- 📖 [Spécifications techniques](SPEC_TECHNIQUE.md)
- 📋 [Cahier des charges](Spec.md)  
- 🧪 [Résultats des tests](.phpunit.result.cache)
- 📊 [Documentation API](docs/api.md) *(à venir)*

## 📝 Changelog

### Version 1.2 (Actuelle)
- ✅ 6 stratégies de tarification
- ✅ Support multi-véhicules complet
- ✅ Tests automatisés (Unit/Integration/Performance)
- ✅ API REST avec CORS
- ✅ Documentation complète

### Roadmap v1.3
- 🔄 Interface web de visualisation
- 🔄 Export des résultats (CSV, PDF)
- 🔄 Stratégies ML/AI
- 🔄 API GraphQL

---

**Développé avec ❤️ en PHP 8+ | Projet pédagogique Architecture Logicielle**

*Pour toute question ou suggestion, n'hésitez pas à ouvrir une issue sur GitHub.*
