<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $mobile = Category::where('slug', 'mobile-phones')->firstOrFail();
        $laptop = Category::where('slug', 'laptops')->firstOrFail();
        $wearable = Category::where('slug', 'wearables-audio')->firstOrFail();

        $products = [
            [
                'category_id' => $mobile->id,
                'name' => 'Apple iPhone 16 Pro Max',
                'description' => 'Premium Apple smartphone with a large Super Retina XDR display, powerful performance and advanced camera system.',
                'image' => 'products/iphone-16-pro-max.jpg',
                'price' => 74999.00,
                'stock' => 14,
            ],
            [
                'category_id' => $mobile->id,
                'name' => 'Samsung Galaxy S25 Ultra',
                'description' => 'Samsung flagship smartphone with a premium display, advanced cameras and high-end performance.',
                'image' => 'products/samsung-galaxy-s25-ultra.jpg',
                'price' => 64999.00,
                'stock' => 18,
            ],
            [
                'category_id' => $mobile->id,
                'name' => 'Google Pixel 10 Pro',
                'description' => 'Google premium smartphone with Pixel software experience, intelligent features and advanced photography.',
                'image' => 'products/google-pixel-10-pro.jpg',
                'price' => 57999.00,
                'stock' => 10,
            ],
            [
                'category_id' => $mobile->id,
                'name' => 'Xiaomi 15 Ultra',
                'description' => 'High-performance Xiaomi flagship with premium cameras, fast charging and a high-quality display.',
                'image' => 'products/xiaomi-15-ultra.jpg',
                'price' => 54999.00,
                'stock' => 16,
            ],
            [
                'category_id' => $mobile->id,
                'name' => 'OnePlus 13',
                'description' => 'Fast Android smartphone with flagship performance, smooth display and fast charging.',
                'image' => 'products/oneplus-13.jpg',
                'price' => 45999.00,
                'stock' => 20,
            ],
            [
                'category_id' => $mobile->id,
                'name' => 'Honor Magic7 Pro',
                'description' => 'Premium Honor smartphone with powerful performance, modern design and advanced camera capabilities.',
                'image' => 'products/honor-magic7-pro.jpg',
                'price' => 49999.00,
                'stock' => 13,
            ],
            [
                'category_id' => $mobile->id,
                'name' => 'OPPO Find X8 Pro',
                'description' => 'Premium OPPO smartphone featuring a high-end display, fast performance and versatile cameras.',
                'image' => 'products/oppo-find-x8-pro.jpg',
                'price' => 51999.00,
                'stock' => 11,
            ],
            [
                'category_id' => $mobile->id,
                'name' => 'vivo X200 Pro',
                'description' => 'Flagship vivo smartphone focused on photography, premium design and powerful everyday performance.',
                'image' => 'products/vivo-x200-pro.jpg',
                'price' => 48999.00,
                'stock' => 9,
            ],
            [
                'category_id' => $mobile->id,
                'name' => 'Samsung Galaxy A56 5G',
                'description' => 'Mid-range Samsung 5G smartphone with a vibrant display, reliable battery and versatile cameras.',
                'image' => 'products/samsung-galaxy-a56-5g.jpg',
                'price' => 23999.00,
                'stock' => 28,
            ],
            [
                'category_id' => $mobile->id,
                'name' => 'Nothing Phone 3',
                'description' => 'Distinctive Android smartphone with a unique design, smooth interface and strong performance.',
                'image' => 'products/nothing-phone-3.jpg',
                'price' => 38999.00,
                'stock' => 17,
            ],

            [
                'category_id' => $laptop->id,
                'name' => 'Apple MacBook Air M4',
                'description' => 'Thin and lightweight Apple laptop with efficient performance, long battery life and a premium display.',
                'image' => 'products/macbook-air-m4.jpg',
                'price' => 69999.00,
                'stock' => 12,
            ],
            [
                'category_id' => $laptop->id,
                'name' => 'Apple MacBook Pro 14 M4 Pro',
                'description' => 'Professional Apple laptop designed for demanding development, creative and productivity workloads.',
                'image' => 'products/macbook-pro-14-m4-pro.jpg',
                'price' => 119999.00,
                'stock' => 7,
            ],
            [
                'category_id' => $laptop->id,
                'name' => 'Dell XPS 13',
                'description' => 'Compact premium Dell laptop with a modern display, lightweight chassis and strong productivity performance.',
                'image' => 'products/dell-xps-13.jpg',
                'price' => 62999.00,
                'stock' => 10,
            ],
            [
                'category_id' => $laptop->id,
                'name' => 'ASUS ROG Zephyrus G14',
                'description' => 'Portable gaming laptop combining powerful hardware, high-refresh display and compact design.',
                'image' => 'products/asus-rog-zephyrus-g14.jpg',
                'price' => 94999.00,
                'stock' => 8,
            ],
            [
                'category_id' => $laptop->id,
                'name' => 'Lenovo ThinkPad X1 Carbon',
                'description' => 'Premium business laptop with a lightweight chassis, comfortable keyboard and professional features.',
                'image' => 'products/lenovo-thinkpad-x1-carbon.jpg',
                'price' => 78999.00,
                'stock' => 9,
            ],
            [
                'category_id' => $laptop->id,
                'name' => 'HP Spectre x360 14',
                'description' => 'Premium convertible laptop with touchscreen display, flexible design and strong productivity performance.',
                'image' => 'products/hp-spectre-x360-14.jpg',
                'price' => 72999.00,
                'stock' => 11,
            ],
            [
                'category_id' => $laptop->id,
                'name' => 'Acer Swift Go 14',
                'description' => 'Portable everyday laptop with a lightweight body, modern hardware and strong battery life.',
                'image' => 'products/acer-swift-go-14.jpg',
                'price' => 41999.00,
                'stock' => 19,
            ],
            [
                'category_id' => $laptop->id,
                'name' => 'Microsoft Surface Laptop 7',
                'description' => 'Premium Windows laptop featuring a clean design, quality display and portable productivity experience.',
                'image' => 'products/microsoft-surface-laptop-7.jpg',
                'price' => 67999.00,
                'stock' => 13,
            ],
            [
                'category_id' => $laptop->id,
                'name' => 'ASUS Zenbook 14 OLED',
                'description' => 'Slim productivity laptop featuring an OLED display, portable design and efficient performance.',
                'image' => 'products/asus-zenbook-14-oled.jpg',
                'price' => 55999.00,
                'stock' => 15,
            ],
            [
                'category_id' => $laptop->id,
                'name' => 'Lenovo Legion 5',
                'description' => 'Powerful gaming laptop with dedicated graphics, fast display and performance-focused cooling.',
                'image' => 'products/lenovo-legion-5.jpg',
                'price' => 82999.00,
                'stock' => 10,
            ],

            [
                'category_id' => $wearable->id,
                'name' => 'Apple Watch Series 10',
                'description' => 'Apple smartwatch with fitness tracking, notifications and comprehensive everyday health features.',
                'image' => 'products/apple-watch-series-10.jpg',
                'price' => 24999.00,
                'stock' => 20,
            ],
            [
                'category_id' => $wearable->id,
                'name' => 'Samsung Galaxy Watch 7',
                'description' => 'Samsung smartwatch with fitness tracking, health features and integration with Galaxy devices.',
                'image' => 'products/samsung-galaxy-watch-7.jpg',
                'price' => 15999.00,
                'stock' => 24,
            ],
            [
                'category_id' => $wearable->id,
                'name' => 'Garmin Venu 3',
                'description' => 'Fitness-focused smartwatch with detailed activity tracking, GPS and long battery life.',
                'image' => 'products/garmin-venu-3.jpg',
                'price' => 21999.00,
                'stock' => 14,
            ],
            [
                'category_id' => $wearable->id,
                'name' => 'Huawei Watch GT 5 Pro',
                'description' => 'Premium Huawei smartwatch featuring fitness tracking, elegant design and long battery life.',
                'image' => 'products/huawei-watch-gt-5-pro.jpg',
                'price' => 18999.00,
                'stock' => 18,
            ],
            [
                'category_id' => $wearable->id,
                'name' => 'Apple AirPods Pro 2',
                'description' => 'Premium wireless earbuds with active noise cancellation, transparency mode and Apple ecosystem integration.',
                'image' => 'products/apple-airpods-pro-2.jpg',
                'price' => 13999.00,
                'stock' => 30,
            ],
            [
                'category_id' => $wearable->id,
                'name' => 'Samsung Galaxy Buds3 Pro',
                'description' => 'Premium Samsung wireless earbuds with active noise cancellation and high-quality wireless audio.',
                'image' => 'products/samsung-galaxy-buds3-pro.jpg',
                'price' => 10999.00,
                'stock' => 26,
            ],
            [
                'category_id' => $wearable->id,
                'name' => 'Sony WF-1000XM5',
                'description' => 'Premium Sony true wireless earbuds with advanced noise cancellation and detailed sound quality.',
                'image' => 'products/sony-wf-1000xm5.jpg',
                'price' => 12999.00,
                'stock' => 21,
            ],
            [
                'category_id' => $wearable->id,
                'name' => 'Nothing Ear',
                'description' => 'Stylish wireless earbuds with distinctive transparent design, noise cancellation and balanced audio.',
                'image' => 'products/nothing-ear.jpg',
                'price' => 7999.00,
                'stock' => 25,
            ],
            [
                'category_id' => $wearable->id,
                'name' => 'JBL Live Beam 3',
                'description' => 'Wireless JBL earbuds with powerful audio, noise cancellation and convenient everyday controls.',
                'image' => 'products/jbl-live-beam-3.jpg',
                'price' => 7499.00,
                'stock' => 32,
            ],
            [
                'category_id' => $wearable->id,
                'name' => 'Beats Studio Buds Plus',
                'description' => 'Compact wireless earbuds with active noise cancellation, clear audio and comfortable fit.',
                'image' => 'products/beats-studio-buds-plus.jpg',
                'price' => 8999.00,
                'stock' => 23,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
