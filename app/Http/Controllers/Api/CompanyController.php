<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Exception;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            return ResponseFormatter::success($user->company, 'Company found');

        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function update(UpdateCompanyRequest $request)
    {
        try {
            $company = Company::find(Auth::user()->company->id);

            if (!$company) {
                throw new Exception('Company not found');
            }

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('public/logos');
            }

            $company->name = $request->name ?? $company->name;
            $company->address = $request->address ?? $company->address;
            $company->logo = isset($path) ? $path : $company->logo;
            $company->save();

            return ResponseFormatter::success($company, 'Company updated');

        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

}
