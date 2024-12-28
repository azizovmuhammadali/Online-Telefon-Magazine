<?php

namespace App\Http\Controllers;

use App\Filters\PhoneFilter;
use App\Http\Requests\PhoneSearchRequest;
use App\Http\Resources\PhoneResource;
use App\Models\Phone;
use Illuminate\Http\Request;

class FindController extends Controller
{
    public function search(PhoneSearchRequest $request)
    {
        $filter = new PhoneFilter();
        $phones = Phone::query();
        $filteredphones = $filter->apply($phones, $request->all())->get();
    return $this->success(PhoneResource::collection($filteredphones->load('user.images','category.images','comments')),__('messages.phone_search'));
    }
}
