<?php
class ModelCatalogCategory extends Model {
    // Получить данные одной категории
    public function getCategory($category_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "' AND status = '1'");
        return $query->row;
    }

    // Получить список подкатегорий конкретного родителя
    public function getCategories($parent_id = 0) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$parent_id . "' AND status = '1' ORDER BY name ASC");
        return $query->rows;
    }


}
