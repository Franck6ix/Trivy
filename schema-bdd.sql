Table users {
  id                int [pk, increment]
  name              varchar
  email             varchar [unique]
  password          varchar
  travel_type       varchar
  notifications_enabled boolean
  preferences       json   // préférences user (plage, ski, gastronomie…)
}

Table trips {
  id                int [pk, increment]
  user_id           int [ref: > users.id]
  destination       varchar
  start_date        date
  end_date          date
  transport_type    varchar
  accommodation     varchar
  trip_types        json   // loisirs, aventure, culturel…
  activities        json   // activités prévues (ski, rando…)
}

Table travellers {
  id                int [pk, increment]
  trip_id           int [ref: > trips.id]
  name              varchar
  age_group         varchar // adult, child, baby
  is_baby           boolean
  is_child          boolean
}

Table categories {
  id                int [pk, increment]
  name              varchar
  emoji             varchar
  sort_order        int
}

Table checklist_items {
  id                int [pk, increment]
  trip_id           int [ref: > trips.id]
  category_id       int [ref: > categories.id]
  name              varchar
  quantity          int
  is_checked        boolean
  is_ai_generated   boolean
}

Table weather_cache {
  id                int [pk, increment]
  destination       varchar
  data              json
  cached_at         datetime
}

Table user_habits {
  id                int [pk, increment]
  user_id           int [ref: > users.id]
  often_forgotten   json
  overpacked        json
}
