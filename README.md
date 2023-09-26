## SHOPPING CART API

The shopping cart API allows for the creation of products and buyers. Buyers can have multiple carts over time, but only one open cart where they can add products.

Each time a product is added, an open cart is created, and the quantity of products of the same type is incremented by +1. If products are removed, and the quantity reaches 0, it is removed from the shopping cart.

Finally, the buyer can confirm the cart as complete for later processing.

## Stack

* PHP 8
* Symfony 6
* Mysql
* Nginx
* Upcoming: Swagger API Documentation

## Getting Started

### Prerequisites

* Docker: https://docs.docker.com/get-docker/

### Installation and Setup

1. Clone the repository: `git clone https://github.com/adolfoaguirrem/shopping-api.git`
2. Initialize the Docker images: 
    * cd shopping-api
    * docker/up
3. Initialize the Symfony project with your PHP container name: 
    * docker exec -it shopping-api-php-1 bash
    * composer install

## API Endpoints

### **Create a product**

**Endpoint:** `/api/products`

**Method:** `POST`

**Request body:**

```json
{
    "name": "Smartwatch",
    "price": 42.99
}
```

**Response:**

```json
{
    "message": "Product created"
}
```

### **Create a Buyer**

**Endpoint:** `/api/buyers`

**Method:** `POST`

**Request body:**

```json
{
    "name": "jhon Doe",
}
```

**Response:**

```json
{
    "message": "Buyer created"
}
```

### **Add a product to a cart (increase Quantity)**

**Endpoint:** `/api/carts/products`

**Method:** `POST`

**Request body:**

```json
{
    "buyer_id": 1,
    "product_id" : 3
}
```

**Response:**

```json
{
    "message": "New product added to cart"
}
```

### **Delete a product on cart (decrease Quantity)**

**Endpoint:** `/api/carts/products`

**Method:** `DELETE`

**Request body:**

```json
{
    "buyer_id": 1,
    "product_id" : 3
}
```

**Response:**

```json
{
    "message": "Product from cart deleted"
}
```


### **Get all products in a cart**

**Endpoint:** `/api/carts/{cart_id}/products`

**Method:** `GET`

**Response:**

```json
{
    "cart": [
        {
            "product": "Sun glasses",
            "quantity": 1
        },
        {
            "product": "Sport Shoes",
            "quantity": 4
        }
    ]
}
```

## API Endpoints
### **Running Tests**

```sh
{
    php bin/phpunit --testdox
}
```
### **Tests**

Add Product To Cart Use Case
 * Add product action

Confirm Cart Use Case
 * Confirm an open cart
 * Confirm with invalid id

Create Buyer Use Case
 * Create buyer use case

Create Product Use Case
 * Create product use case

Delete Product On Cart Use Case
 * Delete existing product with quantity greater than one
 * Delete non existing product

Get Buyer Use Case
 * Execute with valid buyer
 * Execute with invalid  buyer

Buyer
 * Buyer constructor
 * Buyer set new name
 * Buyer set invalid new name

Cart Product
 * Modify quantity

Cart
 * Cart constructor
 * Get cart status value
 * Create invalid staus
 * Cart set new status

Product
 * Product constructor
 * Product set new name
 * Product set new price
 * Product set invalid new price