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
                    'trip' => new TripResource($trip),
                    'popular_trips' => TripResource::collection(Trip::popular()->limit(4)->get()),

                ]
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return $this->exceptionFailed($exception);
        }
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 15);
            $currentPage = $request->input('page', 1);

            // ✅ validate sort field and direction
            $sortField = $request->input('sort_field', 'price');
            $sortDirection = strtolower($request->input('sort_direction', 'desc'));

            $allowedSortFields = ['price', 'title', 'created_at'];
            if (!in_array($sortField, $allowedSortFields)) {
                $sortField = 'price';
            }

            $allowedDirections = ['asc', 'desc'];
            if (!in_array($sortDirection, $allowedDirections)) {
                $sortDirection = 'desc';
            }

            // ✅ start query
            $tripsQuery = Trip::with('city');

            // ✅ apply search
            if ($search = $request->query('search')) {
                $tripsQuery->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('type', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%")
                        ->orWhere('overview', 'LIKE', "%{$search}%")
                        ->orWhere('highlights', 'LIKE', "%{$search}%")
                        ->orWhere('itinerary', 'LIKE', "%{$search}%")
                        ->orWhere('accommodation', 'LIKE', "%{$search}%")
                        ->orWhere('inclusions', 'LIKE', "%{$search}%")
                        ->orWhere('price', 'LIKE', "%{$search}%")
                        ->orWhereHas('city', function ($cityQuery) use ($search) {
                            $cityQuery->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('slug', 'LIKE', "%{$search}%");
                        });
                });
            }
            $tripsQuery->distinct('trips.id');
            // ✅ sorting
            $tripsQuery->orderBy($sortField, $sortDirection);

            // ✅ paginate
            $trips = $tripsQuery->paginate($perPage, ['*'], 'page', $currentPage);

            return $this->paginateResponse(TripResource::collection($trips));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return $this->exceptionFailed($exception);
        }
    }
}
