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
use App\Http\Controllers\API\V1\ProjectController;
use App\Http\Controllers\API\V1\ServiceController;
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
        // Route::get('/faqs', [FaqController::class, 'getAllFaqs']);
        // Route::get('/tags', [HomeController::class, 'getAllTags']);
        // Route::get('/trip-blog/{slug}', [BlogController::class, 'getBlogOrTripBySlug']);

        // Route::get('/tags/{slug}/trips', [HomeController::class, 'getTagTrips']);
        Route::get('/categories', [CategoryController::class, 'getAllCategories']);
       // Route::get('/category/{slug}/sub-categories', [CategoryController::class, 'getSubCategoriesForCategory']);
        Route::get('/category/{slug}', [CategoryController::class, 'show']);
       // Route::get('/category/{slug}/projects', [CategoryController::class, 'getCategoryProjects']);

        Route::get('/services', [ServiceController::class, 'getAllServices']);
        // Route::get('/sub-category/{slug}/trips', [CategoryController::class, 'getSubCategoryTrips']);
        Route::get('/seo', [SeoController::class, 'getAllSeos']);
        Route::get('/seo/{slug}', [SeoController::class, 'getSeo']);
        Route::post('/submit/subscription', [CountactUsController::class, 'submitSubscription']);
        Route::post('/submit/contact-us', [CountactUsController::class, 'submitContactUs']);
        Route::get('/form/job-application', [CountactUsController::class, 'getFormJobApplication']);
        Route::post('/submit/job-application', [CountactUsController::class, 'submitJobApplication']);
    });

    Route::name('projects.')->prefix('projects')->group(function () {
        Route::get('/search', [ProjectController::class, 'index']);
        Route::get('/', [ProjectController::class, 'index']);
        Route::get('/{slug}', [ProjectController::class, 'show']);
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
