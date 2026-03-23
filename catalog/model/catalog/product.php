<?php

class ModelCatalogProduct extends Model
{

    /**
     * Получаем последние добавленные товары
     */
    public function getLatest($limit = 8)
    {
        $sql = "SELECT p.*
                FROM  " . DB_PREFIX . "product p 
                WHERE p.status = '1' 
                ORDER BY p.date_added DESC 
                LIMIT " . (int)$limit;

        $query = $this->db->query($sql);

        return $query->rows;
    }

    /**
     * Получение одного товара по ID (пригодится для карточки товара)
     */
    public function getProduct($product_id)
    {
        $sql = "SELECT DISTINCT * FROM  " . DB_PREFIX . "product p
                WHERE p.product_id = '" . (int)$product_id . "' 
                AND p.status = '1'";

        $query = $this->db->query($sql);

        return $query->row;
    }

    public function getProducts($data = array()) {
        // Выбираем уникальные товары (DISTINCT на случай дублей в связях)
        // p.* — все поля товара, p2c — таблица связей
        $sql = "SELECT DISTINCT p.* FROM " . DB_PREFIX . "product p 
            LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) 
            WHERE p.status = '1'";

        // Если передан фильтр по ID категории
        if (!empty($data['filter_category_id'])) {
            $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
        }

        // Сортировка по новизне
        $sql .= " ORDER BY p.product_id DESC";

        // Пагинация (лимиты)
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) $data['start'] = 0;
            if ($data['limit'] < 1) $data['limit'] = 20;

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }


}
