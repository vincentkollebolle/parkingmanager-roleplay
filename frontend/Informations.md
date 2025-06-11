# Dashboard - Cahier des charges

## 🧩 Fonctionnalités à implémenter

- ✅ **Auto-refresh** du dashboard toutes les 30 secondes
- ✅ **Compteur de véhicules garés** :
  - Voitures
  - Voitures électriques garées sur **places électriques**
  - Camions
  - Motos
- ✅ **Compteur du nombre total de véhicules en circulation**
- ✅ **Compteur de places** : affichage places **prises/libres** (ex : 100/1000)
- ✅ **Affichage des 10 derniers tickets d'entrée**
- ✅ **Affichage des logs d'entrées et de sorties** (avec type de véhicule)
- ✅ **Alerte** quand il reste moins de 100 places disponibles
- ✅ **Panneau d'informations** :
  - Types de véhicules autorisés (voiture, camion, voiture électrique, moto)
  - Taille (nombre de places occupées) par type de véhicule
- 🔄 **Graphiques sur 24 ticks (1 jour)** :
  - Statistiques d’influence (camembert des types de véhicules garés)
  - Revenu généré sur les 24 dernières heures

## 📊 Données disponibles dans le JSON

### ✅ Fonctionnalités couvertes dans ce JSON :
- Compteurs par type de véhicule garé
- Véhicules électriques garés sur places électriques uniquement
- Total véhicules en circulation
- Places occupées / totales
- Derniers tickets d'entrée
- Logs d'entrée/sortie
- Alerte < 100 places
- Panneau info véhicules autorisés + taille

---

## ✅ JSON complet utilisé

```json
{
  "tick": 42,
  "tirelire": 154.75,
  "dashboard": {
    "places": {
      "totales": 1000,
      "electriques": 100,
      "classiques": 900,
      "utilisées": 230,
      "libres": 770
    },
    "vehicules_garés": {
      "motos": 10,
      "voitures": 20,
      "voitures_elec": 5,
      "voitures_elec_sur_place_elec": 4,
      "camions": 3
    },
    "vehicules_en_circulation": 38
  },
  "tickets_recents": [
    {
      "id": 101,
      "vehicle_id": 350,
      "vehicle_type": "voiture",
      "entry_tick": 40,
      "place_id": 22,
      "price": 0
    },
    {
      "id": 100,
      "vehicle_id": 349,
      "vehicle_type": "moto",
      "entry_tick": 39,
      "place_id": 135,
      "price": 0
    },
    {
      "id": 99,
      "vehicle_id": 348,
      "vehicle_type": "voiture_elec",
      "entry_tick": 38,
      "place_id": 903,
      "price": 0
    }
    // ...7 autres tickets
  ],
  "logs": [
    {
      "tick": 41,
      "action": "entrée",
      "vehicle_type": "voiture",
      "vehicle_id": 351
    },
    {
      "tick": 40,
      "action": "sortie",
      "vehicle_type": "moto",
      "vehicle_id": 212
    },
    {
      "tick": 39,
      "action": "entrée",
      "vehicle_type": "camion",
      "vehicle_id": 402
    }
    // ...
  ],
  "types_autorises": [
    {
      "type": "moto",
      "taille": 1
    },
    {
      "type": "voiture",
      "taille": 2
    },
    {
      "type": "voiture_elec",
      "taille": 2
    },
    {
      "type": "camion",
      "taille": 3
    }
  ]
}
````

---

## 🔍 Récapitulatif des données extraites côté dashboard

| Élément                       | Clé JSON                             |
| ----------------------------- | ------------------------------------ |
| 🕒 Tick actuel                | `tick`                               |
| 💰 Argent en banque           | `tirelire`                           |
| 🚗 Véhicules garés (par type) | `dashboard.vehicules_garés`          |
| 🚙 Circulation totale         | `dashboard.vehicules_en_circulation` |
| 🅿️ Places disponibles        | `dashboard.places`                   |
| 🎫 Derniers tickets           | `tickets_recents`                    |
| 🪪 Logs d'entrée/sortie       | `logs`                               |
| 📋 Véhicules autorisés        | `types_autorises`                    |

---

## 🧰 Technologies prévues

* **Vue** : Interface frontend
* **Tailwind CSS** : Design UI
* **Chart.js** : Visualisation des statistiques

---

## 🚧 Prochaines étapes

* Intégration des **graphes sur 24 ticks** (camembert + revenus)
* Vérification de l'alerte automatique à <100 places
* Tests et mise en place de l’**auto-refresh** en frontend

```
