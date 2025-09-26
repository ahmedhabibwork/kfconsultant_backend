<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\RoleTypeEnum;
use App\Http\Requests\API\MovementRequest;
use App\Services\API\BlogService;
use App\Services\API\MovementService;
use App\Services\API\RangeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\Blog;
use App\Models\Faq;
use App\Services\API\HomeService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Log;


class FaqController extends Controller
{
    use ResponseTrait;


    public function getAllFaqs()
    {
        try {
            $faqs = Faq::where('is_published', true)->get();

            return $this->okResponse(
                __('Returned Faqs successfully.'),

                FaqResource::collection($faqs),

            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
}
