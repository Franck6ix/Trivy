-- ============================================
-- Trivy — Export SQLite → MySQL
-- Généré le 21/05/2026 à 01:11:17
-- ============================================

SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;

-- ── users (1 ligne(s)) ──
TRUNCATE TABLE `users`;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `travel_type`, `preferences`, `notifications_enabled`, `onboarding_completed`) VALUES ('1', 'ye', 'test@test.com', NULL, '$2y$12$EYbB2B9k6t9aHmge7n32uuo3yNAhalY8kD/5bw4uHQpKrKEvBQ7g2', NULL, '2026-05-20 16:22:18', '2026-05-20 17:36:32', 'couple', '[\"plage\",\"bien-\\u00eatre\"]', '1', '1');

-- ── trips (2 ligne(s)) ──
TRUNCATE TABLE `trips`;
INSERT INTO `trips` (`id`, `user_id`, `destination`, `start_date`, `end_date`, `transport_type`, `accommodation`, `trip_types`, `activities`, `amenities`, `created_at`, `updated_at`) VALUES ('1', '1', 'Allemagne, Allemagne', '2026-05-19 00:00:00', '2026-05-30 00:00:00', 'avion', 'hotel', '[\"croisi\\u00e8re\"]', '[\"rando\",\"plage\",\"ski\"]', '[]', '2026-05-20 17:31:46', '2026-05-20 17:31:46');
INSERT INTO `trips` (`id`, `user_id`, `destination`, `start_date`, `end_date`, `transport_type`, `accommodation`, `trip_types`, `activities`, `amenities`, `created_at`, `updated_at`) VALUES ('2', '1', 'Santorin, Grèce', '2026-05-07 00:00:00', '2026-05-08 00:00:00', 'avion', 'hotel', '[\"loisirs\"]', '[\"plage\",\"bien-\\u00eatre\"]', '[\"lave-linge\",\"spa\",\"berceau\"]', '2026-05-20 17:36:32', '2026-05-20 17:36:32');

-- ── travellers (6 ligne(s)) ──
TRUNCATE TABLE `travellers`;
INSERT INTO `travellers` (`id`, `trip_id`, `name`, `age_group`, `is_baby`, `is_child`, `specific_needs`, `created_at`, `updated_at`) VALUES ('1', '1', NULL, 'adult', '0', '0', NULL, '2026-05-20 17:31:46', '2026-05-20 17:31:46');
INSERT INTO `travellers` (`id`, `trip_id`, `name`, `age_group`, `is_baby`, `is_child`, `specific_needs`, `created_at`, `updated_at`) VALUES ('2', '1', NULL, 'adult', '0', '0', NULL, '2026-05-20 17:31:46', '2026-05-20 17:31:46');
INSERT INTO `travellers` (`id`, `trip_id`, `name`, `age_group`, `is_baby`, `is_child`, `specific_needs`, `created_at`, `updated_at`) VALUES ('3', '1', NULL, 'child', '0', '1', NULL, '2026-05-20 17:31:46', '2026-05-20 17:31:46');
INSERT INTO `travellers` (`id`, `trip_id`, `name`, `age_group`, `is_baby`, `is_child`, `specific_needs`, `created_at`, `updated_at`) VALUES ('4', '2', NULL, 'adult', '0', '0', NULL, '2026-05-20 17:36:32', '2026-05-20 17:36:32');
INSERT INTO `travellers` (`id`, `trip_id`, `name`, `age_group`, `is_baby`, `is_child`, `specific_needs`, `created_at`, `updated_at`) VALUES ('5', '2', NULL, 'adult', '0', '0', NULL, '2026-05-20 17:36:32', '2026-05-20 17:36:32');
INSERT INTO `travellers` (`id`, `trip_id`, `name`, `age_group`, `is_baby`, `is_child`, `specific_needs`, `created_at`, `updated_at`) VALUES ('6', '2', NULL, 'child', '0', '1', NULL, '2026-05-20 17:36:32', '2026-05-20 17:36:32');

-- ── checklist_items (20 ligne(s)) ──
TRUNCATE TABLE `checklist_items`;
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('1', '2', 'Vêtements', 'Tee-shirts × 5', '0', '0', '2026-05-20 17:53:05', '2026-05-20 18:10:27');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('2', '2', 'Vêtements', 'Pantalons × 2', '0', '1', '2026-05-20 17:53:05', '2026-05-20 18:10:28');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('3', '2', 'Vêtements', 'Veste imperméable', '0', '2', '2026-05-20 17:53:05', '2026-05-20 18:10:28');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('4', '2', 'Vêtements', 'Chaussures de sport', '0', '3', '2026-05-20 17:53:05', '2026-05-20 18:10:29');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('5', '2', 'Vêtements', 'Sous-vêtements × 5', '0', '4', '2026-05-20 17:53:05', '2026-05-20 18:10:29');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('6', '2', 'Vêtements', 'Pyjama', '0', '5', '2026-05-20 17:53:05', '2026-05-20 18:09:50');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('7', '2', 'Toilettes', 'Brosse à dents', '0', '0', '2026-05-20 17:53:05', '2026-05-20 17:53:05');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('8', '2', 'Toilettes', 'Dentifrice', '0', '1', '2026-05-20 17:53:05', '2026-05-20 17:53:05');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('9', '2', 'Toilettes', 'Crème solaire SPF50', '0', '2', '2026-05-20 17:53:05', '2026-05-20 17:53:05');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('10', '2', 'Toilettes', 'Déodorant', '0', '3', '2026-05-20 17:53:05', '2026-05-20 17:53:05');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('11', '2', 'Toilettes', 'Shampoing', '0', '4', '2026-05-20 17:53:05', '2026-05-20 17:53:05');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('12', '2', 'Toilettes', 'Médicaments essentiels', '0', '5', '2026-05-20 17:53:05', '2026-05-20 17:53:05');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('13', '2', 'Électronique', 'Chargeur USB-C', '1', '0', '2026-05-20 17:53:05', '2026-05-20 18:10:02');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('14', '2', 'Électronique', 'Adaptateur EU', '1', '1', '2026-05-20 17:53:05', '2026-05-20 18:10:02');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('15', '2', 'Électronique', 'Écouteurs', '0', '2', '2026-05-20 17:53:05', '2026-05-20 17:53:05');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('16', '2', 'Électronique', 'Batterie externe', '0', '3', '2026-05-20 17:53:05', '2026-05-20 17:53:05');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('17', '2', 'Documents', 'Passeport', '1', '0', '2026-05-20 17:53:05', '2026-05-20 18:09:59');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('18', '2', 'Documents', 'Billets d\'avion', '1', '1', '2026-05-20 17:53:05', '2026-05-20 18:09:59');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('19', '2', 'Documents', 'Assurance voyage', '1', '2', '2026-05-20 17:53:05', '2026-05-20 18:10:00');
INSERT INTO `checklist_items` (`id`, `trip_id`, `category`, `label`, `is_checked`, `sort_order`, `created_at`, `updated_at`) VALUES ('20', '2', 'Documents', 'Réservation hôtel', '0', '3', '2026-05-20 17:53:05', '2026-05-20 17:53:05');

-- ── sessions (2 ligne(s)) ──
TRUNCATE TABLE `sessions`;
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('8VOfWmxpf4mLJIYfawItp5Z1NcSklrnw4yUgVVLd', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.119.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'eyJfdG9rZW4iOiJrYm5sakNRallOYVZOUWpqUHRSM1ZxVlFMd3p0c0ZiU3B2SThhR2FWIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDAiLCJyb3V0ZSI6ImhvbWUifX0=', '1779307776');
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('cV53dHrk1iMiniY0D6F8Cz9iNSeW8n2RMfbwo08d', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.119.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'eyJfdG9rZW4iOiJ1UUZaT2hKRnAxWGJnakxlYWFDTGFVYzAydlpYRXdtV29YdnJCZEpwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', '1779325284');

-- ── cache (0 ligne(s)) ──
TRUNCATE TABLE `cache`;

SET FOREIGN_KEY_CHECKS = 1;