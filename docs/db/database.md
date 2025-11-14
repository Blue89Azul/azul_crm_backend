-- ===================================
-- 1. Users テーブル
-- ===================================
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name_last` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '姓',
  `name_first` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'メールアドレス',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'パスワード',
  `user_role_id` bigint unsigned DEFAULT NULL COMMENT 'ユーザーロールID',
  `created_at` int unsigned NOT NULL COMMENT '作成日時(UNIX timestamp)',
  `updated_at` int unsigned NOT NULL COMMENT '更新日時(UNIX timestamp)',
  `loggedin_at` int unsigned NOT NULL COMMENT '最終ログイン日時(UNIX timestamp)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_user_role_id_foreign` (`user_role_id`),
  CONSTRAINT `users_user_role_id_foreign` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================
-- 2. Addresses テーブル  
-- ===================================
CREATE TABLE addresses (
    address_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    country_code CHAR(2) NOT NULL COMMENT 'ISO 3166-1 alpha-2 国コード',
    postal_code VARCHAR(20) COMMENT '郵便番号',
    state_province VARCHAR(100) COMMENT '都道府県/州',
    city VARCHAR(100) NOT NULL COMMENT '市区町村',
    street_address_1 VARCHAR(255) NOT NULL COMMENT '住所1（番地、建物名等）',
    street_address_2 VARCHAR(255) COMMENT '住所2（部屋番号等）',
    created_at INT UNSIGNED NOT NULL COMMENT '作成日時',
    updated_at INT UNSIGNED NOT NULL COMMENT '更新日時',
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='住所テーブル';

-- ===================================
-- 3. Companies テーブル
-- ===================================
CREATE TABLE companies (
    company_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL DEFAULT '' COMMENT '会社名',
    employees INT UNSIGNED NOT NULL DEFAULT 0 COMMENT '従業員数',
    revenue BIGINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '売上高',
    address_id BIGINT COMMENT '住所ID',
    created_at INT UNSIGNED NOT NULL COMMENT '作成日時',
    updated_at INT UNSIGNED NOT NULL COMMENT '更新日時',
    FOREIGN KEY (address_id) REFERENCES addresses(address_id) ON DELETE SET NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='会社テーブル';

-- ===================================
-- 4. Customers テーブル
-- ===================================
CREATE TABLE customers (
    customer_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name_last VARCHAR(100) NOT NULL DEFAULT '' COMMENT '姓',
    name_first VARCHAR(100) NOT NULL DEFAULT '' COMMENT '名',
    email VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'メールアドレス',
    company_id BIGINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '会社ID',
    address_id BIGINT COMMENT '住所ID',
    title VARCHAR(100) NOT NULL DEFAULT '' COMMENT '役職',
    created_at INT UNSIGNED NOT NULL COMMENT '作成日時',
    updated_at INT UNSIGNED NOT NULL COMMENT '更新日時',
    FOREIGN KEY (company_id) REFERENCES companies(company_id) ON DELETE RESTRICT,
    FOREIGN KEY (address_id) REFERENCES addresses(address_id) ON DELETE SET NULL,
    INDEX idx_company_id (company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='顧客テーブル';

-- ===================================
-- 5. Negotiation Status Groups テーブル
-- ===================================
CREATE TABLE negotiation_status_groups (
    negotiation_status_group_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    group_name VARCHAR(100) NOT NULL COMMENT 'ステータスグループ名',
    created_at INT UNSIGNED NOT NULL COMMENT '作成日時',
    updated_at INT UNSIGNED NOT NULL COMMENT '更新日時',
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商談ステータスグループテーブル';

-- ===================================
-- 6. Negotiation Statuses テーブル
-- ===================================
CREATE TABLE negotiation_statuses (
    negotiation_status_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    negotiation_status_group_id BIGINT NOT NULL COMMENT 'ステータスグループID',
    status_name VARCHAR(100) NOT NULL COMMENT 'ステータス名',
    sort_order INT UNSIGNED DEFAULT 0 COMMENT '表示順序',
    created_at INT UNSIGNED NOT NULL COMMENT '作成日時',
    updated_at INT UNSIGNED NOT NULL COMMENT '更新日時',
    FOREIGN KEY (negotiation_status_group_id) REFERENCES negotiation_status_groups(negotiation_status_group_id) ON DELETE CASCADE,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商談ステータステーブル';

-- ===================================
-- 7. Negotiations テーブル
-- ===================================
CREATE TABLE negotiations (
    negotiation_id BIGINT PRIMARY KEY AUTO_INCREMENT,
    customer_id BIGINT COMMENT '顧客ID',
    status_id BIGINT NOT NULL COMMENT 'ステータスID',
    title VARCHAR(255) NOT NULL DEFAULT '' COMMENT '商談タイトル',
    description TEXT COMMENT '商談詳細',
    amount BIGINT UNSIGNED DEFAULT 0 COMMENT '商談金額',
    scheduled_date INT UNSIGNED NOT NULL COMMENT '予定日時)',
    created_at INT UNSIGNED NOT NULL COMMENT '作成日時',
    updated_at INT UNSIGNED NOT NULL COMMENT '更新日時',
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE SET NULL,
    FOREIGN KEY (status_id) REFERENCES negotiation_statuses(negotiation_status_id) ON DELETE RESTRICT,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商談テーブル';

-- ===================================
-- 8. User Roles テーブル
-- ===================================
CREATE TABLE `user_roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ロール名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;