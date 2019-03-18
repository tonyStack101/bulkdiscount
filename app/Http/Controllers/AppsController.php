<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Helpers\ProductHelper;
use App\Helpers\SettingHelper;
use App\Http\Requests\InstallAppsRequest;
use App\Jobs\AddAliOrderCodeToThemesJob;
use App\Jobs\InitAppJob;
use App\Jobs\InitSettingDefaultJob;
use App\Jobs\SyncOrderJob;
use App\Jobs\SyncProductJob;
use App\Mail\InstallApps;
use App\Models\ShopModel;
use App\Services\SpfService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\ShopifyApi\ShopsApi;
use App\Repository\ShopRepository;
use App\Jobs\WebHookAppsJob;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use App\Jobs\AffiliateJob;

class AppsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function installApp()
    {
        session(['shopDomain' => null]);
        return view('install_app');
    }

    /**
     * @param InstallAppsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function installAppHandle(Request $request)
    {
        $spfService = new SpfService();
        $urlStore = $request->input('shop_domain', null);

        return redirect($spfService->installURL($urlStore));
    }

    public function storeError($shopDomain)
    {
        return view('errors.store_error', compact('shopDomain'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function auth(Request $request)
    {
        $request = $request->all();
        $spfService = new SpfService($request['shop']);
        $accessToken = $spfService->authApp($request);
        if ($accessToken) {
            $shopDomain = $request['shop'];
            $shopApi = new ShopsApi($shopDomain, $accessToken);
            $shopRepo = new ShopRepository();
            $shopInfoApi = $shopApi->get();

            if (!$shopInfoApi['status'])
                return redirect(route('apps.installApp'))->with('error', 'Error request');

            $shopInfoApi = (array)$shopInfoApi['data']->shop;

            $shopInfoApi['access_token'] = $accessToken;
            $shopInfoApi['status'] = config('common.status.publish');

            //Check shop database
            $shopInfo = $shopRepo->detail($shopInfoApi['id']);
            //Save session accessToken and shopDomain
            session(['accessToken' => $accessToken, 'shopDomain' => $shopDomain, 'shopId' => $shopInfoApi['id'],
                'shopOwner' => $shopInfoApi['shop_owner'], 'shopEmail' => $shopInfoApi['email'],
                'created_at' => strtotime($shopInfoApi['created_at'])]);

            if (!$shopInfo || (isset($shopInfo->status) && !$shopInfo->status)) {
                $shopRepo->createOrUpdate($shopInfoApi['id'], $shopInfoApi);
            }
            return redirect(route('setting.index'));
        }

        return redirect(route('apps.installApp'))->with('error', 'Not verify request, contact Support FireApps- support@fireapps.io');
    }
}














