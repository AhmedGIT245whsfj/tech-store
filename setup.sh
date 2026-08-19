#!/bin/bash

set -e

if [ ! -f "artisan" ]; then
    echo "artisan not found"
    exit 1
fi

php artisan make:model Product -m
php artisan make:model Order -m
php artisan make:model OrderItem -m

php artisan make:controller Api/AuthController
php artisan make:controller Api/ProductController --api
php artisan make:controller Api/OrderController --api
php artisan make:controller Api/UserController --api

php artisan make:middleware RoleMiddleware

php artisan make:request RegisterRequest
php artisan make:request LoginRequest
php artisan make:request StoreProductRequest
php artisan make:request UpdateProductRequest
php artisan make:request StoreOrderRequest
php artisan make:request UpdateOrderStatusRequest

php artisan make:resource UserResource
php artisan make:resource ProductResource
php artisan make:resource OrderResource
php artisan make:resource OrderItemResource

php artisan make:seeder AdminSeeder
php artisan make:seeder ProductSeeder

php artisan make:controller Web/AuthController
php artisan make:controller Web/DashboardController
php artisan make:controller Web/ProductController
php artisan make:controller Web/OrderController
php artisan make:controller Web/AdminController

mkdir -p resources/views/layouts
mkdir -p resources/views/auth
mkdir -p resources/views/products
mkdir -p resources/views/orders
mkdir -p resources/views/admin/products
mkdir -p resources/views/admin/orders
mkdir -p resources/views/admin/users

touch resources/views/layouts/app.blade.php
touch resources/views/auth/login.blade.php
touch resources/views/auth/register.blade.php
touch resources/views/dashboard.blade.php

touch resources/views/products/index.blade.php
touch resources/views/products/show.blade.php

touch resources/views/orders/index.blade.php
touch resources/views/orders/create.blade.php
touch resources/views/orders/show.blade.php

touch resources/views/admin/dashboard.blade.php

touch resources/views/admin/products/index.blade.php
touch resources/views/admin/products/create.blade.php
touch resources/views/admin/products/edit.blade.php

touch resources/views/admin/orders/index.blade.php
touch resources/views/admin/orders/show.blade.php

touch resources/views/admin/users/index.blade.php
touch resources/views/admin/users/show.blade.php

echo "Project structure created"
