# TPE Parte 3 - API Web 2

Trabajo Práctico Especial - Parte 3 (API REST)
Materia: Web 2

Alumnos:
* Ignacio Mengochea
* Juan Manuel Juarez

## Sobre el trabajo
Profe, acá le dejamos la API para la pizzería que veníamos haciendo. Lo que hicimos fue crear los endpoints para poder consultar, agregar y editar las pizzas desde Postman sin necesidad de usar la web vieja.

Lo probamos con el Postman y anda todo (GET, POST y PUT).

## Como probarlo
1. Bajar los archivos del repo.
2. Importar la base de datos `tpe3.sql` (es la misma de siempre pero por las dudas la subimos).
3. Configurar el usuario y contraseña en `app/models/PizzaModel.php` si no le conecta.
4. Usar Postman para pegarles a las rutas.

## Lista de Endpoints

Acá explicamos cómo se usan los servicios que creamos:

### 1. Ver todas las pizzas
Ruta: `GET /api/items`

Te devuelve la lista completa.
* Si querés ordenar, le podés agregar `?sort=precio` o `?sort=nombre`.
* Tambien `&order=DESC` si queres que vaya al revés.

### 2. Ver una pizza sola
Ruta: `GET /api/items/:id`

Ejemplo: `/api/items/5`
Te devuelve los datos de esa pizza. Si no existe te tira un 404.

### 3. Agregar una pizza (POST)
Ruta: `POST /api/items`

Hay que enviarle un JSON en el body con los datos.
Ejemplo:
```json
{
    "nombre": "Pizza Nueva",
    "ingredientes": "Muzzarella y Huevo",
    "precio": 14000,
    "id_categoria_fk": 1
}