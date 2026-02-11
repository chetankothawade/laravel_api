<?php

namespace App\Http\Requests\Api\Module;

use App\Http\Requests\Api\BaseApiRequest;

class ModuleStoreRequest extends BaseApiRequest
{
    public function rules(): array
    {
        return [
            'parent_id' => 'nullable|integer|min:0',
            'name' => 'required|string|max:255|unique:modules,name',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'seq_no' => 'nullable|integer',
            'is_sub_module' => 'required|in:Y,N',
            'is_permission' => 'required|in:Y,N',
            'status' => 'required|in:active,inactive',
        ];
    }
}
