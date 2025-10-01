<?php


use App\Http\Controllers\API\V1\AuthenticationController;
use App\Http\Controllers\API\V1\BlogController;
use App\Http\Controllers\API\V1\BookingController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\CountactUsController;
use App\Http\Controllers\API\V1\FaqController;
use App\Http\Controllers\API\V1\MovementController;
use App\Http\Controllers\API\V1\PointController;
use App\Http\Controllers\API\V1\RangeController;
use App\Http\Controllers\API\V1\ReviewController;
use App\Http\Controllers\API\V1\SeoController;
use App\Http\Controllers\API\V1\SocietyReviewController;
use App\Http\Controllers\API\V1\EvaluationController;
use App\Http\Controllers\API\V1\ContestController;
use App\Http\Controllers\API\V1\HomeController;
use App\Http\Controllers\API\V1\TripController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

Route::group([
    'middleware' => [
        'api',
        'localization',
        'forceJson'
    ],
    'prefix' => 'v1',
    'name' => 'api.',
], function () {

    Route::group([], function () {

        Route::get('/home', [HomeController::class, 'home']);
        Route::get('/contactinfo', [HomeController::class, 'contactinfo']);
        Route::get('/about-us', [HomeController::class, 'getAboutUs']);
        Route::get('/blogs', [BlogController::class, 'getAllBlogs']);
        Route::get('/blogs/{slug}', [BlogController::class, 'getblogDetails']);
        Route::get('/faqs', [FaqController::class, 'getAllFaqs']);
        Route::get('/tags', [HomeController::class, 'getAllTags']);
        Route::get('/tags/{slug}/trips', [HomeController::class, 'getTagTrips']);
        Route::get('/categories', [CategoryController::class, 'getAllCategories']);
        Route::get('/category/{slug}/sub-categories', [CategoryController::class, 'getSubCategoriesForCategory']);
        Route::get('/category/{slug}', [CategoryController::class, 'show']);
        Route::get('/category/{slug}/trips', [CategoryController::class, 'getCategoryTrips']);
        Route::get('/sub-category/{slug}/trips', [CategoryController::class, 'getSubCategoryTrips']);
        Route::get('/seo', [SeoController::class, 'getAllSeos']);
        Route::get('/seo/{slug}', [SeoController::class, 'getSeo']);
        Route::post('/submit/subscription', [CountactUsController::class, 'submitSubscription']);
        Route::post('/submit/contact-us', [CountactUsController::class, 'submitContactUs']);
        Route::post('/trip/{slug}/booking', [BookingController::class, 'submitContactUsTrip']);
        Route::get('/hotel-booking', [BookingController::class, 'hotelBookingOptions']);
        Route::post('/hotel-booking', [BookingController::class, 'hotelBooking']);
        Route::get('/transport-booking', [BookingController::class, 'transportBookingOptions']);
        Route::post('/transport-booking', [BookingController::class, 'transportBooking']);
        Route::get('/fight-booking', [BookingController::class, 'fightBookingOptions']);
        Route::post('/fight-booking', [BookingController::class, 'fightBooking']);

        Route::post('/tailor-made-request', [BookingController::class, 'tailorMadeRequest']);
    });

    Route::name('trips.')->prefix('trips')->group(function () {
        Route::get('/search', [TripController::class, 'index']);
        Route::get('/', [TripController::class, 'index']);
        Route::get('/{slug}', [TripController::class, 'show']);
    });

    Route::get('/get-point-byslug/{slug}', [PointController::class, 'getPointBySlug']);
    Route::group([
        'middleware' => [
            'auth:sanctum',
            'checkActiveStatus',
        ],
        'name' => 'auth.',
    ], function () {});



    Route::group([
        'middleware' => [
            // 'guest:sanctum'
        ],
        'name' => 'all.',
    ], function () {});
});
