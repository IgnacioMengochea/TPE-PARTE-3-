<?php
require_once 'app/models/PizzaModel.php';

class PizzaApiController {
    private $model;

    public function __construct() {
        $this->model = new PizzaModel();
    }

    public function getAll($req, $res) {
        if (!$this->model) {
            $this->model = new PizzaModel();
        }

        $orderBy = false;
        $order = 'ASC';

        if(isset($req->query->sort)) {
            $orderBy = $req->query->sort;
        }
        if(isset($req->query->order)) {
            $order = $req->query->order;
        }

        $pizzas = $this->model->getAll($orderBy, $order);
        return $res->json($pizzas, 200);
    }

    public function get($req, $res) {
        if (!$this->model) {
            $this->model = new PizzaModel();
        }

        $id = $req->params->id;
        $pizza = $this->model->get($id);

        if(!$pizza) {
            return $res->json("No existe la pizza con el id={$id}", 404);
        }

        return $res->json($pizza, 200);
    }

    public function create($req, $res) {
        if (!$this->model) { $this->model = new PizzaModel(); }

        if (empty($req->body->nombre) || empty($req->body->precio) || empty($req->body->id_categoria_fk)) {
            return $res->json('Faltan datos obligatorios', 400);
        }

        $nombre = $req->body->nombre;
        $ingredientes = $req->body->ingredientes;
        $precio = $req->body->precio;
        $categoria = $req->body->id_categoria_fk;

        $id = $this->model->insert($nombre, $ingredientes, $precio, $categoria);

        if ($id) {
            $nuevaPizza = $this->model->get($id);
            return $res->json($nuevaPizza, 201);
        } else {
            return $res->json("Error al insertar", 500);
        }
    }

    public function update($req, $res) {
        $id = $req->params->id;
        $pizza = $this->model->get($id);

        if (!$pizza) {
            return $res->json("No existe la pizza con el id={$id}", 404);
        }

        if (empty($req->body->nombre) || empty($req->body->precio) || empty($req->body->id_categoria_fk)) {
            return $res->json('Faltan datos obligatorios', 400);
        }

        $nombre = $req->body->nombre;
        $ingredientes = $req->body->ingredientes;
        $precio = $req->body->precio;
        $categoria = $req->body->id_categoria_fk;

        $this->model->update($id, $nombre, $ingredientes, $precio, $categoria);

        $pizzaActualizada = $this->model->get($id);
        return $res->json($pizzaActualizada, 200);
    }
}