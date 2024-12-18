# API Documentation

## Authorization
- **Type**: JWT (JSON Web Token)
- **Algorithm**: HS256
- **Secret**: `HUTECH`

## API Endpoints

### 1. Create a New Product
- **Method**: POST
- **Endpoint**: `http://localhost:82/webbanhang/api/product/create`
- **Description**: Use this endpoint to create a new product.

### 2. Retrieve a Product
- **Method**: GET
- **Endpoint**: `http://localhost:82/webbanhang/api/product/1`
- **Description**: Fetch the details of a product with the ID of `1`.

### 3. Update a Product
- **Method**: PUT
- **Endpoint**: `http://localhost:82/webbanhang/api/product/1`
- **Description**: Update the details of a product with the ID of `1`.

### 4. Delete a Product
- **Method**: DELETE
- **Endpoint**: `http://localhost:82/webbanhang/api/product/1`
- **Description**: Remove the product with the ID of `1` from the system.

