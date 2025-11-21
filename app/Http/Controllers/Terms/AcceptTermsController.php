<?php

namespace App\Http\Controllers\Terms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcceptTermsController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $user->terms_accepted_at = now();
        $user->save();

        return redirect(route('terms.view'));
    }
}
