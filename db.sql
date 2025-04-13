CREATE TABLE IF NOT EXISTS global_vars (
    `id` int(11) NOT NULL,
    `var_key` text NOT NULL,
    `var_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `global_vars` (`id`, `var_key`, `var_value`) VALUES
(1, 'site_baslik', ''),
(2, 'site_aciklama', ''),
(3, 'site_keywords', ''),
(4, 'og:title', ''),
(5, 'og:description', ''),
(6, 'og:image', ''),
(7, 'og:url', ''),
(8, 'og:type', ''),
(9, 'og:site_name', ''),
(10, 'twitter:card', ''),
(11, 'twitter:title', ''),
(12, 'twitter:description', ''),
(13, 'twitter:image', ''),
(14, 'twitter:site', ''),
(15, 'about_info', ''),
(16, 'facebook_link', ''),
(17, 'instagram_link', ''),
(18, 'twitter_link', ''),
(19, 'youtube_link', ''),
(20, 'linkedin_link', ''),
(21, 'tiktok_link', ''),
(22, 'google_analytics', ''),
(23, 'google_search', '');