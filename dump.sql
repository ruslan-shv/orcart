CREATE TABLE `orc_seo_url`
(
    `seo_url_id` int(11) NOT NULL AUTO_INCREMENT,
    `query`      varchar(255) NOT NULL, -- Пример: 'product_id=42' или 'category_id=10'
    `keyword`    varchar(255) NOT NULL, -- Пример: 'iphone'
    PRIMARY KEY (`seo_url_id`),
    UNIQUE KEY `keyword` (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
