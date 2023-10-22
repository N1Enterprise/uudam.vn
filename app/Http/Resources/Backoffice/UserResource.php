<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Facades\Route;

class UserResource extends BaseJsonResource
{
    public function toArray($request)
    {
        $showEmail = $request->user()->can('users.show-user-email');
        $showPhone = $request->user()->can('users.show-user-phone');

        $email = $showEmail ? $this->email : '*****';
        $phoneNumberBeautify = $showPhone ? $this->phone_number_beautify : '*****';
        $nationalPhoneNumber = $showPhone ? $this->national_phone_number : '*****';

        return array_merge([
            'id' => $this->id,
            'username' => $this->username,
            'email' => $email,
            'serialized_status' => $this->serialized_status,
            'serialized_status_name' => $this->serialized_status_name,
            'contact_number' => $nationalPhoneNumber,
            'phone_number_beautify' => $phoneNumberBeautify,
            'created_at' => $this->created_at_localized,
            'status' => $this->status,
            'updated_at' => $this->updated_at_localized,
        ], $this->generateActionPermissions());
    }

    public function generateActionPermissions()
    {
        $showPermission = $this->getPermissionByAction('show');

        return array_filter([
            'actions' => array_filter([
                'show' => $showPermission ? Route::findByName('bo.web.users.edit', ['id' => $this->getKey()]) : null,
            ]),
        ]);
    }
}
