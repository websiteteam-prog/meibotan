<?php
/**
 * Route table.
 * @var App\Core\Router $router
 */
declare(strict_types=1);

use App\Controllers\Front;
use App\Controllers\Api;
use App\Controllers\Admin;

// ---------------------------------------------------------------- Storefront
$router->get('/', [Front\HomeController::class, 'index']);
$router->get('/shop', [Front\ShopController::class, 'index']);
$router->get('/search', [Front\ShopController::class, 'search']);
$router->get('/category/{slug}', [Front\ShopController::class, 'category']);
$router->get('/category/{slug}/{sub}', [Front\ShopController::class, 'subcategory']);
$router->get('/collection/{slug}', [Front\ShopController::class, 'collection']);
$router->get('/product/{slug}', [Front\ProductController::class, 'show']);
$router->post('/product/{slug}/review', [Front\ProductController::class, 'review'], ['auth']);

$router->get('/cart', [Front\CartController::class, 'index']);
$router->get('/checkout', [Front\CheckoutController::class, 'index']);
$router->post('/checkout', [Front\CheckoutController::class, 'place']);
$router->get('/order/{number}', [Front\CheckoutController::class, 'success']);
$router->get('/wishlist', [Front\WishlistController::class, 'index'], ['auth']);
$router->post('/wishlist/{id:\d+}/remove', [Front\WishlistController::class, 'remove'], ['auth']);

// Customer auth
$router->get('/login', [Front\AuthController::class, 'loginForm'], ['guest']);
$router->post('/login', [Front\AuthController::class, 'login'], ['guest']);
$router->get('/register', [Front\AuthController::class, 'registerForm'], ['guest']);
$router->post('/register', [Front\AuthController::class, 'register'], ['guest']);
$router->post('/logout', [Front\AuthController::class, 'logout']);
$router->get('/forgot-password', [Front\AuthController::class, 'forgotForm'], ['guest']);
$router->post('/forgot-password', [Front\AuthController::class, 'forgot'], ['guest']);
$router->get('/reset-password', [Front\AuthController::class, 'resetForm']);
$router->post('/reset-password', [Front\AuthController::class, 'reset']);

// Customer account
$router->get('/account', [Front\AccountController::class, 'dashboard'], ['auth']);
$router->get('/account/profile', [Front\AccountController::class, 'profile'], ['auth']);
$router->post('/account/profile', [Front\AccountController::class, 'updateProfile'], ['auth']);
$router->get('/account/password', [Front\AccountController::class, 'password'], ['auth']);
$router->post('/account/password', [Front\AccountController::class, 'updatePassword'], ['auth']);
$router->get('/account/addresses', [Front\AccountController::class, 'addresses'], ['auth']);
$router->post('/account/addresses', [Front\AccountController::class, 'saveAddress'], ['auth']);
$router->post('/account/addresses/{id:\d+}/delete', [Front\AccountController::class, 'deleteAddress'], ['auth']);
$router->post('/account/addresses/{id:\d+}/default', [Front\AccountController::class, 'defaultAddress'], ['auth']);
$router->get('/account/orders', [Front\AccountController::class, 'orders'], ['auth']);
$router->get('/account/orders/{number}', [Front\AccountController::class, 'order'], ['auth']);
$router->post('/account/orders/{number}/cancel', [Front\AccountController::class, 'cancelOrder'], ['auth']);

// Content pages
$router->get('/about-us', [Front\PageController::class, 'about']);
$router->get('/contact', [Front\PageController::class, 'contact']);
$router->post('/contact', [Front\PageController::class, 'contactSubmit']);
$router->get('/page/{slug}', [Front\PageController::class, 'show']);
$router->get('/sitemap.xml', [Front\SeoController::class, 'sitemap']);
$router->get('/robots.txt', [Front\SeoController::class, 'robots']);

// ---------------------------------------------------------------- AJAX API
$router->get('/api/cart', [Api\CartApi::class, 'show']);
$router->post('/api/cart/add', [Api\CartApi::class, 'add']);
$router->post('/api/cart/update', [Api\CartApi::class, 'update']);
$router->post('/api/cart/remove', [Api\CartApi::class, 'remove']);
$router->post('/api/cart/coupon', [Api\CartApi::class, 'applyCoupon']);
$router->post('/api/cart/coupon/remove', [Api\CartApi::class, 'removeCoupon']);
$router->get('/api/checkout/summary', [Api\CartApi::class, 'checkoutSummary']);
$router->post('/api/wishlist/toggle', [Api\WishlistApi::class, 'toggle']);
$router->get('/api/search', [Api\CatalogApi::class, 'search']);
$router->get('/api/quick-view/{id:\d+}', [Api\CatalogApi::class, 'quickView']);
$router->get('/api/products/tab', [Api\CatalogApi::class, 'homeTab']);
$router->post('/api/newsletter', [Api\NewsletterApi::class, 'subscribe']);
$router->post('/api/payment/razorpay/verify', [Api\PaymentApi::class, 'verify']);
$router->post('/api/payment/razorpay/failed', [Api\PaymentApi::class, 'failed']);
$router->post('/api/payment/razorpay/retry', [Api\PaymentApi::class, 'retry']);
$router->post('/api/payment/razorpay/webhook', [Api\PaymentApi::class, 'webhook'], ['nocsrf']);

// ---------------------------------------------------------------- Admin
$router->get('/admin/login', [Admin\AuthController::class, 'loginForm']);
$router->post('/admin/login', [Admin\AuthController::class, 'login']);
$router->post('/admin/logout', [Admin\AuthController::class, 'logout']);
$router->get('/admin/forgot-password', [Admin\AuthController::class, 'forgotForm']);
$router->post('/admin/forgot-password', [Admin\AuthController::class, 'forgot']);
$router->get('/admin/reset-password', [Admin\AuthController::class, 'resetForm']);
$router->post('/admin/reset-password', [Admin\AuthController::class, 'reset']);

$router->get('/admin', [Admin\DashboardController::class, 'index'], ['admin:dashboard']);

// Catalogue
$router->get('/admin/products', [Admin\ProductController::class, 'index'], ['admin:catalog']);
$router->get('/admin/products/create', [Admin\ProductController::class, 'create'], ['admin:catalog']);
$router->post('/admin/products/save', [Admin\ProductController::class, 'save'], ['admin:catalog']);
$router->get('/admin/products/{id:\d+}/edit', [Admin\ProductController::class, 'edit'], ['admin:catalog']);
$router->post('/admin/products/{id:\d+}/delete', [Admin\ProductController::class, 'delete'], ['admin:catalog']);
$router->post('/admin/products/{id:\d+}/toggle', [Admin\ProductController::class, 'toggle'], ['admin:catalog']);
$router->post('/admin/products/{id:\d+}/duplicate', [Admin\ProductController::class, 'duplicate'], ['admin:catalog']);
$router->post('/admin/products/bulk', [Admin\ProductController::class, 'bulk'], ['admin:catalog']);

$router->get('/admin/categories', [Admin\CategoryController::class, 'index'], ['admin:catalog']);
$router->post('/admin/categories/save', [Admin\CategoryController::class, 'save'], ['admin:catalog']);
$router->post('/admin/categories/{id:\d+}/delete', [Admin\CategoryController::class, 'delete'], ['admin:catalog']);
$router->post('/admin/categories/{id:\d+}/toggle', [Admin\CategoryController::class, 'toggle'], ['admin:catalog']);
$router->post('/admin/categories/reorder', [Admin\CategoryController::class, 'reorder'], ['admin:catalog']);
$router->post('/admin/subcategories/save', [Admin\CategoryController::class, 'saveSub'], ['admin:catalog']);
$router->post('/admin/subcategories/{id:\d+}/delete', [Admin\CategoryController::class, 'deleteSub'], ['admin:catalog']);
$router->post('/admin/subcategories/{id:\d+}/toggle', [Admin\CategoryController::class, 'toggleSub'], ['admin:catalog']);

$router->get('/admin/collections', [Admin\CollectionController::class, 'index'], ['admin:catalog']);
$router->get('/admin/collections/create', [Admin\CollectionController::class, 'create'], ['admin:catalog']);
$router->get('/admin/collections/{id:\d+}/edit', [Admin\CollectionController::class, 'edit'], ['admin:catalog']);
$router->post('/admin/collections/save', [Admin\CollectionController::class, 'save'], ['admin:catalog']);
$router->post('/admin/collections/{id:\d+}/delete', [Admin\CollectionController::class, 'delete'], ['admin:catalog']);

$router->get('/admin/reviews', [Admin\ReviewController::class, 'index'], ['admin:reviews']);
$router->post('/admin/reviews/{id:\d+}/status', [Admin\ReviewController::class, 'status'], ['admin:reviews']);
$router->post('/admin/reviews/{id:\d+}/delete', [Admin\ReviewController::class, 'delete'], ['admin:reviews']);

// Sales
$router->get('/admin/orders', [Admin\OrderController::class, 'index'], ['admin:orders']);
$router->get('/admin/orders/export', [Admin\OrderController::class, 'export'], ['admin:orders']);
$router->get('/admin/orders/{id:\d+}', [Admin\OrderController::class, 'show'], ['admin:orders']);
$router->get('/admin/orders/{id:\d+}/invoice', [Admin\OrderController::class, 'invoice'], ['admin:orders']);
$router->post('/admin/orders/{id:\d+}/status', [Admin\OrderController::class, 'status'], ['admin:orders']);
$router->post('/admin/orders/{id:\d+}/payment', [Admin\OrderController::class, 'payment'], ['admin:orders']);
$router->post('/admin/orders/{id:\d+}/shipping', [Admin\OrderController::class, 'shipping'], ['admin:orders']);
$router->post('/admin/orders/{id:\d+}/refund', [Admin\OrderController::class, 'refund'], ['admin:orders']);

$router->get('/admin/customers', [Admin\CustomerController::class, 'index'], ['admin:customers']);
$router->get('/admin/customers/export', [Admin\CustomerController::class, 'export'], ['admin:customers']);
$router->get('/admin/customers/{id:\d+}', [Admin\CustomerController::class, 'show'], ['admin:customers']);
$router->post('/admin/customers/{id:\d+}', [Admin\CustomerController::class, 'update'], ['admin:customers']);
$router->post('/admin/customers/{id:\d+}/toggle', [Admin\CustomerController::class, 'toggle'], ['admin:customers']);

$router->get('/admin/coupons', [Admin\CouponController::class, 'index'], ['admin:marketing']);
$router->post('/admin/coupons/save', [Admin\CouponController::class, 'save'], ['admin:marketing']);
$router->post('/admin/coupons/{id:\d+}/delete', [Admin\CouponController::class, 'delete'], ['admin:marketing']);
$router->post('/admin/coupons/{id:\d+}/toggle', [Admin\CouponController::class, 'toggle'], ['admin:marketing']);
$router->get('/admin/newsletter', [Admin\InboxController::class, 'newsletter'], ['admin:marketing']);
$router->get('/admin/newsletter/export', [Admin\InboxController::class, 'newsletterExport'], ['admin:marketing']);
$router->post('/admin/newsletter/{id:\d+}/delete', [Admin\InboxController::class, 'newsletterDelete'], ['admin:marketing']);

// Content
$router->get('/admin/banners', [Admin\ContentController::class, 'banners'], ['admin:content']);
$router->post('/admin/banners/save', [Admin\ContentController::class, 'saveBanner'], ['admin:content']);
$router->post('/admin/banners/{id:\d+}/delete', [Admin\ContentController::class, 'deleteBanner'], ['admin:content']);
$router->get('/admin/testimonials', [Admin\ContentController::class, 'testimonials'], ['admin:content']);
$router->post('/admin/testimonials/save', [Admin\ContentController::class, 'saveTestimonial'], ['admin:content']);
$router->post('/admin/testimonials/{id:\d+}/delete', [Admin\ContentController::class, 'deleteTestimonial'], ['admin:content']);
$router->get('/admin/social', [Admin\ContentController::class, 'social'], ['admin:content']);
$router->post('/admin/social/save', [Admin\ContentController::class, 'saveSocial'], ['admin:content']);
$router->post('/admin/social/{id:\d+}/delete', [Admin\ContentController::class, 'deleteSocial'], ['admin:content']);
$router->get('/admin/homepage', [Admin\ContentController::class, 'homepage'], ['admin:content']);
$router->post('/admin/homepage', [Admin\ContentController::class, 'saveHomepage'], ['admin:content']);
$router->get('/admin/pages', [Admin\ContentController::class, 'pages'], ['admin:content']);
$router->get('/admin/pages/create', [Admin\ContentController::class, 'createPage'], ['admin:content']);
$router->get('/admin/pages/{id:\d+}/edit', [Admin\ContentController::class, 'editPage'], ['admin:content']);
$router->post('/admin/pages/save', [Admin\ContentController::class, 'savePage'], ['admin:content']);
$router->post('/admin/pages/{id:\d+}/delete', [Admin\ContentController::class, 'deletePage'], ['admin:content']);
$router->get('/admin/messages', [Admin\InboxController::class, 'messages'], ['admin:messages']);
$router->get('/admin/messages/{id:\d+}', [Admin\InboxController::class, 'message'], ['admin:messages']);
$router->post('/admin/messages/{id:\d+}/delete', [Admin\InboxController::class, 'deleteMessage'], ['admin:messages']);

// Settings & users
$router->get('/admin/settings', [Admin\SettingsController::class, 'index'], ['admin:settings']);
$router->post('/admin/settings', [Admin\SettingsController::class, 'save'], ['admin:settings']);
$router->post('/admin/settings/test-email', [Admin\SettingsController::class, 'testEmail'], ['admin:settings']);
$router->get('/admin/admins', [Admin\AdminUserController::class, 'index'], ['admin:admins']);
$router->post('/admin/admins/save', [Admin\AdminUserController::class, 'save'], ['admin:admins']);
$router->post('/admin/admins/{id:\d+}/delete', [Admin\AdminUserController::class, 'delete'], ['admin:admins']);
$router->get('/admin/profile', [Admin\AdminUserController::class, 'profile'], ['admin']);
$router->post('/admin/profile', [Admin\AdminUserController::class, 'updateProfile'], ['admin']);
$router->post('/admin/profile/password', [Admin\AdminUserController::class, 'updatePassword'], ['admin']);
