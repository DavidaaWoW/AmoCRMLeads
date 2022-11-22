<?php

namespace App\Http\Controllers;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Exceptions\AmoCRMMissedTokenException;
use AmoCRM\Exceptions\AmoCRMoAuthApiException;
use AmoCRM\Filters\BaseRangeFilter;
use AmoCRM\OAuth2\Client\Provider\AmoCRMException;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Lead;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Collections\LinksCollection;
use AmoCRM\Collections\NullTagsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Filters\LeadsFilter;
use AmoCRM\Models\CompanyModel;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFieldsValues\BirthdayCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\DateTimeCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\NullCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;


class LeadsController extends Controller
{
    public function getLeads()
    {
        $clientId = "d7769f4f-6857-4a94-94b0-11dba1392f08";
        $clientSecret = "kTlc74AkwoE0znsUgXz60Jg44kObDyKmeLVyBkZlg1grdOU5W3LNyZ2MrgSbvdj3";
        $redirectUri = "http://test.com";
        $user = Auth::user();
        $apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        $oauth = $apiClient->getOAuthClient();
        $oauth->setBaseDomain($user->domain.'.amocrm.ru');
        $apiClient->setAccessToken(new AccessToken(['access_token' => $user->access_token, 'refresh_token' => $user->refresh_token, 'expires' => $user->token_expires, 'domain' => $user->domain]));
        $filter = new LeadsFilter();
        $filter2 = new LeadsFilter();
        $baserange = new BaseRangeFilter();
        $baserange->setFrom((int)$user->latest_lead_update);
        $now = strtotime("now");
        $baserange->setTo($now);
        $filter->setCreatedAt($baserange);
        $filter2->setUpdatedAt($baserange);
        try {
            $leads = $apiClient->leads()->get($filter);
        } catch (AmoCRMApiException $e) {
            $leads = [];
        }
        try {
            $leads2 = $apiClient->leads()->get($filter2);
        }
        catch (AmoCRMApiException $e){
            $leads2 = [];
        }
        $pipeline = $apiClient->pipelines()->get()->first();
        foreach ($leads as $lead){
//            if(in_array($lead, $leads2)){
//                $leads2 = array_diff($leads2, )
//            }
            $_lead = new Lead();
            $_lead->id = $lead->id;
            $_lead->name = $lead->name;
            $_lead->price = $lead->price;
            $_lead->status = $apiClient->statuses($pipeline->id)->getOne($lead->statusId)->name;
            $_lead->responsibleUserId = $lead->responsibleUserId;
            $_lead->createdBy = $lead->createdBy;
            $_lead->updatedBy = $lead->updatedBy;
            $_lead->pipelineId = $lead->pipelineId;
            if($lead->company) {
                $_lead->companyId = $lead->company->id;
            }
            $_lead->createdAt = $lead->createdAt;
            $_lead->updatedAt = $lead->updatedAt;
            $_lead->save();
            if(!count(Company::where('id', '=', $lead->companyId)->get()) && $lead->company){
                $_company = new Company();
                $company = $apiClient->companies()->getOne($lead->company->id);
                $_company->id = $company->id;
                $_company->name = $company->name;
                $_company->responsibleUserId = $company->responsibleUserId;
                $_company->createdBy = $company->createdBy;
                $_company->updatedBy = $company->updatedBy;
                $_company->createdAt = $company->createdAt;
                $_company->updatedAt = $company->updatedAt;
                $_company->closestTaskAt = $company->closestTaskAt;
                $_company->save();
                $_lead->company()->associate($_company);
                $_lead->save();
            }
        }
        foreach ($leads2 as $lead2){
            $_lead2 = Lead::where('id', '=', $lead2->id)->get()->first();
            $_lead2->id = $lead2->id;
            $_lead2->name = $lead2->name;
            $_lead2->price = $lead2->price;
            $_lead2->status = $apiClient->statuses($pipeline->id)->getOne($lead2->statusId)->name;
            $_lead2->responsibleUserId = $lead2->responsibleUserId;
            $_lead2->createdBy = $lead2->createdBy;
            $_lead2->updatedBy = $lead2->updatedBy;
            $_lead2->pipelineId = $lead2->pipelineId;
            if($lead2->company) {
                $_lead2->companyId = $lead2->company->id;
            }
            $_lead2->createdAt = $lead2->createdAt;
            $_lead2->updatedAt = $lead2->updatedAt;
            $_lead2->save();
        }
        $user->latest_lead_update=$now;
        $user->save();
        return redirect(route('leads'));
    }

    public function leads(){
        return view('leads', ['leads' => Lead::all()->sortByDesc('updatedAt')]);
    }
}
