CREATE TABLE `orc_seo_url`
(
    `seo_url_id` int(11)      NOT NULL AUTO_INCREMENT,
    `query`      varchar(255) NOT NULL, -- Пример: 'product_id=42' или 'category_id=10'
    `keyword`    varchar(255) NOT NULL, -- Пример: 'iphone'
    PRIMARY KEY (`seo_url_id`),
    UNIQUE KEY `keyword` (`keyword`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `orc_product`
(
    `product_id`    INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    `model`         VARCHAR(64)    NOT NULL,
    `image`         VARCHAR(255)            DEFAULT NULL,
    `price`         DECIMAL(15, 4) NOT NULL DEFAULT 0.0000,
    `status`        TINYINT(1)     NOT NULL DEFAULT 1,
    `date_added`    DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_modified` DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`product_id`),
    INDEX `idx_date_added` (`date_added`),
    INDEX `idx_status` (`status`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

CREATE TABLE `orc_product`
(
    `product_id`    int(10) UNSIGNED NOT NULL,
    `name`          varchar(255)     NOT NULL,
    `description`   text                      DEFAULT NULL,
    `model`         varchar(64)      NOT NULL,
    `image`         varchar(255)              DEFAULT NULL,
    `price`         decimal(15, 4)   NOT NULL DEFAULT 0.0000,
    `status`        tinyint(1)       NOT NULL DEFAULT 1,
    `date_added`    datetime         NOT NULL DEFAULT current_timestamp(),
    `date_modified` datetime         NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_general_ci;

CREATE TABLE `orc_category`
(
    `category_id` INT(11)      NOT NULL AUTO_INCREMENT,
    `parent_id`   INT(11)      NOT NULL DEFAULT '0',
    `name`        VARCHAR(255) NOT NULL,
    `status`      TINYINT(1)   NOT NULL DEFAULT '1',
    PRIMARY KEY (`category_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


CREATE TABLE `orc_product_to_category`
(
    `product_id`  INT(11) NOT NULL,
    `category_id` INT(11) NOT NULL,
    PRIMARY KEY (`product_id`, `category_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
