<?php

namespace App\Services\API;;

use App\Enums\CongestionLevelEnum;
use App\Enums\MovementTypeEnum;
use App\Enums\RoleTypeEnum;

use App\Filament\Resources\CategoryResource;
use App\Http\Requests\API\MovementRequest;
use App\Http\Resources\BannerResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\CategoryResource as ResourcesCategoryResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\MovementResource;
use App\Http\Resources\OptionsRangeResource;
use App\Http\Resources\PointResource;
use App\Http\Resources\RangeResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\ReviewStandardResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\TripResource;
use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\City;
use App\Models\Comment;
use App\Models\ContactInfo;
use App\Models\Movement;
use App\Models\OurService;
use App\Models\Point;
use App\Models\Range;
use App\Models\Review;
use App\Models\ReviewStandard;
use App\Models\Trip;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Pest\Laravel\call;
use function Symfony\Component\String\s;


class TripService
{
    const SORT_DIRECTIONS = ['asc', 'desc'];
    use ResponseTrait;


    public function index($request)
    {
        try {

            $perPage = request()->input('per_page', 15);
            $currentPage = request()->input('page', 1);
            $tripsQuery = Trip::orderByDesc('trips.created_at');

            if (!empty($request['hajj_umrah']) && $request['hajj_umrah'] == true) {
                $trips = $tripsQuery->where('category_id', Category::Hajj_Umrah);
            } elseif (!empty($request['best_offer']) && $request['best_offer'] == true) {
                $trips = $tripsQuery->bestOffer(); // ✅ استخدم scope
            } elseif (!empty($request['popular']) && $request['popular'] == true) {
                $trips = $tripsQuery->popular(); // ✅ استخدم scope
            } else {
                $trips = $tripsQuery;
            }

            $trips = $trips->paginate($perPage, ['*'], 'page', $currentPage);

            return $this->okResponse(
                __('Returned trips successfully.'),
                [
                    'trips' => TripResource::collection($trips),
                    'pagination' => [
                        'total' => $trips->total(),
                        'per_page' => $trips->perPage(),
                        'current_page' => $trips->currentPage(),
                        'last_page' => $trips->lastPage(),
                    ],
                ]
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->exceptionFailed($exception);
        }
    }


    public function getTripBySlug(string $slug)
    {
        try {
            $trip = Trip::where('slug', $slug)->first();
            if (!$trip) {
                return $this->notFoundResponse('Trip');
            }
            return $this->okResponse(
                __('Returned Trip Details successfully'),
                [
                    'trip'=>new TripResource($trip),
                    'popular_trips' => TripResource::collection(Trip::popular()->limit(4)->get()),

                ]
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return $this->exceptionFailed($exception);
        }
    }
}
