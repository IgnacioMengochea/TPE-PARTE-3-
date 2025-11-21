<?php

class PizzaModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=tpe2;charset=utf8', 'root', '');
    }

    public function getAll($orderBy = false, $order = 'ASC') {
        $sql = 'SELECT * FROM items';

        if($orderBy) {
            switch($orderBy) {
                case 'precio':
                    $sql .= ' ORDER BY precio ' . $order;
                    break;
                case 'nombre':
                    $sql .= ' ORDER BY nombre ' . $order;
                    break;
            }
        }

        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function get($id) {
        $query = $this->db->prepare('SELECT * FROM items WHERE id_item = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function insert($nombre, $ingredientes, $precio, $categoria) {
        $query = $this->db->prepare('INSERT INTO items (nombre, ingredientes, precio, id_categoria_fk) VALUES (?, ?, ?, ?)');
        $query->execute([$nombre, $ingredientes, $precio, $categoria]);
        return $this->db->lastInsertId();
    }

    public function update($id, $nombre, $ingredientes, $precio, $categoria) {
        $query = $this->db->prepare('UPDATE items SET nombre = ?, ingredientes = ?, precio = ?, id_categoria_fk = ? WHERE id_item = ?');
        $query->execute([$nombre, $ingredientes, $precio, $categoria, $id]);
    }
}