<?php

namespace App\Http\Controllers\Frontend;

use App\Enum\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class ShortenedLinkController extends BaseController
{
    public function handleRedirect(Request $request, $code)
    {
        $shortenedLinks = SystemSetting::from(SystemSettingKeyEnum::SHORTENED_LINKS)->get(null, []);

        $redirectTo = data_get($shortenedLinks, $code);

        if ($redirectTo) {
            return redirect()->to($redirectTo);
        }

        return redirect()->route('fe.web.home');
    }
}
