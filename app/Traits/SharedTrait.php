<?php

namespace App\Traits;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;



trait  SharedTrait
{


    // ========================================================================
    // ===================== Get Auth User Type Function ======================
    // ========================================================================
    public function authUserType()
    {

        if (Auth::guard('super_admin')->check()) {
            return 'Super Admin';
        } else {
            return 'undefined';
        }
    }
    
    // ================================================================
    // ================= Save File In Folder Function =================
    // ================================================================
    public function paginate($items, $perPage = 50, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage;
        $itemstoshow = array_slice($items, $offset, $perPage);
        return new LengthAwarePaginator($itemstoshow, $total, $perPage);
    }


    // ================================================================
    // =============== Any Third Party Request Function ===============
    // ================================================================
    public function sendRequest($base_uri, $authorization, $method, $uri)
    {

        $client = new Client(['base_uri' => $base_uri]);
        $headers = [
            'Authorization' => $authorization,
            'Accept'        => 'application/json',
        ];
        $response = $client->request($method, $uri, [
            'headers' => $headers
        ]);
        if ($response->getStatusCode() != 200) {
            return 'Error in request';
        }
        return $response = json_decode($response->getBody(), true);
    }
}
