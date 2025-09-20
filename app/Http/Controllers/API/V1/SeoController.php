<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\RoleTypeEnum;
use App\Http\Requests\API\MovementRequest;
use App\Models\Seo;
use App\Services\API\BlogService;
use App\Services\API\MovementService;
use App\Services\API\RangeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SeoResource;
use App\Models\Blog;
use App\Models\OurService;
use App\Services\API\HomeService;
use App\Services\API\OurServiceService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Log;


class SeoController extends Controller
{

    use ResponseTrait;



    public function getAllSeos()
    {
        try {
            return $this->okResponse(
                __('Returned Our Services successfully.'),
                [
                    SeoResource::collection(Seo::orderBy('created_at', 'desc')->get() ?? []),
                ]
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            // dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function getSeo($slug)
    {
        try {
            $seo = Seo::where('slug', $slug)->first();
            if (!$seo) {
                return $this->notFoundResponse('Seo');
            }
            return $this->okResponse(
                __('Returned Our Services successfully.'),
                new SeoResource($seo),
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            // dd($exception);
            return $this->exceptionFailed($exception);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
