# Spécifications Fonctionnelles et Techniques – Parking Manager v1.0

## 1. Objectif du projet

Concevoir et développer un simulateur de parking permettant de gérer dynamiquement l'arrivée, le stationnement et le départ de véhicules de types variés, selon des politiques de tarifications définies. Le but est de maximiser les revenus du parking en appliquant une stratégie tarifaire optimisée.

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
| `Car`, `Truck`, `Motorbike`, `ElectricCar` | Implémentations concrètes                                  |
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
| ElectricCar | 2    | 0.5 |  1      | 3 |
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

Si voiture electrique il faut stocker l'état de la batterie de la voiture électrique (0 = empty , 3 = full). 


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

**Cas spécifique voiture électrique** 
Une voiture electrique pour se recharger doit être sur une place voiture électrique. Idéalement, une fois pleine elle est déplacée par le voiturié sur une place normal. Quand une voiture electrique arrive elle à par défaut un chargement entre 0 et 3 (cf section véhicule). 

**Composition du parking :** 

- 1000 slots. 
- 200 slots voitures electriques



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
| `EcoFriendlyDiscountStrategy` | -20% pour véhicules électriques            |
| `NightRateStrategy`           | Tarif réduit entre 22h et 6h               |
| `RandomBonusStrategy`         | 1 véhicule sur 10 gagne une réduction      |


_Fin du document de spécifications v1.1_
