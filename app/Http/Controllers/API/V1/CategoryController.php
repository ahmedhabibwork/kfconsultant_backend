<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\RoleTypeEnum;
use App\Http\Requests\API\MovementRequest;
use App\Services\API\BlogService;
use App\Services\API\MovementService;
use App\Services\API\RangeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Services\API\CategoryService;
use App\Services\API\HomeService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    use ResponseTrait;

    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    public function show($slug)
    {
        return $this->categoryService->getCategoryBySlug($slug);
    }
    /**
     * Display a listing of the resource.
     */
    public function getAllCategories()
    {
        return $this->categoryService->getAllCategories();
    }
        public function getSubCategoriesForCategory($slug)
    {
        return $this->categoryService->getSubCategoriesForCategory($slug);
    }

    

    public function getCategoryTrips($slug)
    {
        return $this->categoryService->getCategoryTrips($slug);
    }
    public function getSubCategoryTrips($slug)
    {
        return $this->categoryService->getSubCategoryTrips($slug);
    }
}
