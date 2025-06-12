# Spécifications Fonctionnelles et Techniques – Parking Manager v1.2

## 1. Objectif du projet

En tant que propriétaire foncier nous venons d'acheter un terrain à côté d'une route.
Nous voulons ouvrir un parking dessus et donc faire des simulations pour savoir combien on peut
gagner tout en réduisant l'impact carbone au maximum de notre parking (quelle politique de prix mettre en place, et comment organiser notre parking).

Pour cela nous vous demandons de concevoir et développer un simulateur de parking permettant de gérer dynamiquement l'arrivée, le stationnement et le départ de véhicules de types variés, selon des politiques de tarifications définies. Le but est de maximiser les revenus du parking en appliquant une stratégie tarifaire optimisée.

Une autre entreprise est chargée de développer le front-end affichant le résultat des simulations. 
(cf projet dédié ).


**En entrée** 
- Nombre de tour de simulation = tick (par défault =  = 1 an) 
- Nombre de place (par défault = 1000 places)
- Affluence des voitures ( Fichier json descriptif de l'affluence). 

**Format du Json simulant l'affluence sur la route** 

Doit paraître un peu réaliste (alternance jour/nuit, été/hiver etc...).
Durée de la simulation : 1ans = 8760 ticks (1 tick = 1h). 


```json
// Exemple de JSON 
[
    {
        'date': 01-01-2025 00:00,
        'vehicles': [
            { 'type': 'car', 'wantedDuration':2, 'maxPricePerTick': 2 },
            { 'type':'car', 'wantedDuration':2, 'maxPricePerTick': 2 },
            { 'type':'car', 'wantedDuration':2, 'maxPricePerTick': 2 },
            { 'type':'truck', 'wantedDuration':3, 'maxPricePerTick': 2 },
            { 'type':'truck', 'wantedDuration':3, 'maxPricePerTick': 2 },
            { 'type':'moto', 'wantedDuration':1, 'maxPricePerTick': 2 },
            { 'type':'bike', 'wantedDuration':0, 'maxPricePerTick': 2 },
        ]
    },
    ...
]
```
Règles métier : 
```json
{ 
    type: string; // Décrit le type de véhicule (car | truck | moto | bike) 
    wantedDuration': number; // 0 .. n 
    maxPricePerHour: number; // Prix maximum que la personne est prête à mettre par Heure.  
},
``` 
Réonse Attendu :
```json
{
  "simulationName": "ParkingManager_2025-06-11_14-00",
  "parkingSize": 1000,
  "durationTicks": 8760,

  "revenue": {
    "moneyWon": 158340,
    "moneyLost": 23400
  },

  "traffic": {
    "totalVehiclesGenerated": 12345,
    "totalVehiclesParked": 9876,
    "totalVehiclesRejected": 2469
  },

  "byVehicleType": {
    "car": {
      "parked": 5200,
      "rejected": 900,
      "ticketPricePerHour": 2
    },
    "electric": {
      "parked": 1500,
      "rejected": 300,
      "ticketPricePerHour": 1.5
    },
    "truck": {
      "parked": 800,
      "rejected": 200,
      "ticketPricePerHour": 3.5
    },
    "bike": {
      "parked": 2376,
      "rejected": 1069,
      "ticketPricePerHour": 0.5
    }
  },

  "co2": {
    "totalEmittedWhileWaiting": 35400.5,
    "averageEmissionPerRejectedVehicle": 3.8
  }
}
```

## 2. Contexte pédagogique

Ce projet permet de mettre en pratique la programmation orientée objet, la conception modulaire et l'utilisation de patrons de conception comme **Singleton**, **Factory**, **Builder**, **Decorator**, **Strategy**, **Observer**... etc. Il favorise également l'expérimentation algorithmique dans un environnement contrôlé et reproductible. 

## 3. Fonctionnalités attendues

### Fonctionnalités principales

- Génération de véhicules à intervalles réguliers.    
- Affectation automatique des véhicules aux places disponibles.
- Calcul du coût de stationnement via une stratégie tarifaire interchangeable.
- Suivi du temps via une horloge observable déclenchant des `tick()`.
- Départ automatique des véhicules après un temps de stationnement donné.
- Affichage du revenu total généré.
- Évaluation des performances de la stratégie (revenus, occupation...).

## 4. Contraintes techniques et architecturales
### 4.1 Langage

- PHP-8
### 4.2 Design Patterns

- **Observer** : pour l'horloge et la progression du temps.
- **Strategy** : pour la politique de tarification.
- **Singleton** : pour la route
- .... 

### 4.3 Composants modulaires attendus

- Interface `Vehicle`
- Interface `PriceStrategy`
- Interface `ParkingSpot`
- Interface `Clock` (observable)
- Interface `Route` (générateur de véhicules)
- ...

### 4.4 Format des entrées

- Séquence de véhicules prédéfinie et rejouable
- Durées de stationnement connues à l'avance

## 5. Modèle de données (entités)

| Entité                                     | Description                                                |
| ------------------------------------------ | ---------------------------------------------------------- |
| `Vehicle`                                  | Interface des véhicules (type, consommation, encombrement) |
| `Car`, `Truck`, `Motorbike` | Implémentations concrètes                                  |
| `ParkingSpot`                              | Place de parking avec type, capacité, occupation           |
| `Clock`                                    | Observable déclenchant des `tick()`                        |
| `Route`                                    | Génère les véhicules à intervalles réguliers               |
| `PriceStrategy`                            | Interface de calcul de prix                                |

## 6. Diagramme de séquence simplifié

```plaintext
[Clock] -> tick() every minute
    -> [Route] generates Vehicle
        -> [ParkingManager] assigns to [ParkingSpot]
            -> [PriceStrategy] calculates price
                -> [Vehicle] stays until duration ends
                    -> [ParkingManager] releases spot
```

## 7. Exigences de qualité logicielle

Le code doit respecter les critères suivants :

- Respect des principes de conception orientée objet (encapsulation, modularité, SOLID)
- Respect des PSR principales
- Indépendance entre les modules (ex. : stratégies tarifaires remplaçables sans impacter le reste)
- Extensibilité prévue (ajout de nouveaux types de véhicules ou de stratégies)
- Facilité de test (notamment sur les composants critiques comme `PriceStrategy`)
- Documentation minimale : commentaires pertinents.

## 8. Données de test fournies

- Fichier `vehicles.json` contenant : 
    - `type`
    - `arriveeMinute`
    - `duree`

- Le simulateur doit être capable d'utiliser ces données pour des résultats reproductibles.  

## 9. Livrables attendus

1. Code source complet, documenté disponible via git.     
2. Fichier `README.md` comprenant :    
    - Description de l'architecture
    - Description du fonctionnement
    - Liste des stratégies disponibles
    - Instructions d'installation et d'exécution
    - Points d’extension possibles

## 10. Spécifications des interfaces communes

### 10.1 Interface `Vehicle`

Les véhicules émettent du CO2 quand ils ne sont pas en stationnement (g/tick). 
Les véhicules en attente d’une place émettent du CO₂ à chaque tick, selon leur type. Une fois garés, ils n’émettent plus. Plusieurs type de Véhicule existe. 

**Types de Véchicules**

| Type        | Size | CO2 |   Price (/tick)  | Reload Time (nb Tick) | 
| ----------- | ---- | --- | ---      |  |
| `Car`       | `2`  | 3.5 |  10      | na  |
| Truck       | 3    | 6.0 |  25      | na  |
| Moto        | 1    | 1.0 |  7       | na  |
|             |      |     |          |  | 
...en options (cheval, vélo ...)

| Attribut         | Type    | Description                         |     |
| ---------------- | ------- | ----------------------------------- | --- |
| `uid`            | `int`   | Identifiant unique du véhicule      |     |
| `arrivalTick`    | `int`   | Tick d'arrivée dans la simulation   |     |
| `wantedDuration` | `int`   | Durée souhaitée de stationnement    |     |
| `co2`            | `float` | g/Tick de cO2 emi si en circulation |     |
| `isParked`       | `bool`  | Véhicule en stationnement ou non    |     |
|                  |         |                                     |     |


10.2 La Route (`Road`)

La route stock et accueil les véhicules en circulation. 

10.3 L'Horloge  (`Clock`)

Génère des ticks notifiant le temps qui passe. 

10.4 La Tirelire  (`IncomeTracker`)

Suivie de l'argent généré par le parking.

10.5 Le capteur  (`CO2Tracker`)

Suivi des emissions carbones

10.6 Le Dashboard (`Dashboard`)

Réaliser par une entreprise externe (autre équipe indépendante). 
Affiche les informations sur le parking et les impacts carbones.

10.7 Le Parking (`Parking`)

Le parking fonctionne avec un "voiturier". C'est lui qui s'occupe d'acceuillir, garer et dégarer les voitures. En gros on donne ses clés à l'arrivé et on est notifié pour récupérer sa voiture à heure dite (ou fourière ;)). 
Une voiture arrive avec une durée d'arrêt décidée à l'avance (`wantedDuration`) elle est viré par le voiturié quand elle a "fait son temps". 


**Composition du parking :** 

- 1000 slots. 



## 11. Jeu de données 

Un fichier `traffic_schedule.json` donne un scénario d'arrivé de véhicules et leur ordre.
Il sera utiliser pour comparer les stratégies. 

## 12. Stratégie 

L’objectif pour un jeu de données est de concevoir une stratégie qui :
- maximise les revenus,
- minimise le CO₂ émis par attente.

Exemple de stratégies possibles :

| Nom de la stratégie           | Description                                |
| ----------------------------- | ------------------------------------------ |
| `FlatRateStrategy`            | Tarif fixe pour toute durée                |
| `HourlyStrategy`              | Tarif par tranche horaire                  |
| `DemandBasedStrategy`         | Majoration si > 80% des places sont prises |
| `NightRateStrategy`           | Tarif réduit entre 22h et 6h               |
| `RandomBonusStrategy`         | 1 véhicule sur 10 gagne une réduction      |


_Fin du document de spécifications v1.3_
