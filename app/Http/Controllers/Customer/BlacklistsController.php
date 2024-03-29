<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\Blacklists\StoreBlacklist;
use App\Models\Blacklists;
use App\Repositories\Contracts\BlacklistsRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class BlacklistsController extends CustomerBaseController
{
    protected BlacklistsRepository $blacklists;


    /**
     * BlacklistsController constructor.
     *
     * @param  BlacklistsRepository  $blacklists
     */

    public function __construct(BlacklistsRepository $blacklists)
    {
        $this->blacklists = $blacklists;
    }

    /**
     * @return Application|Factory|View
     * @throws AuthorizationException
     */

    public function index(): Factory|View|Application
    {

        $this->authorize('view_blacklist');

        $breadcrumbs = [
                ['link' => url("dashboard"), 'name' => __('locale.menu.Dashboard')],
                ['name' => __('locale.menu.Blacklist')],
        ];

        return view('customer.Blacklists.index', compact('breadcrumbs'));
    }


    /**
     * @param  Request  $request
     *
     * @return void
     * @throws AuthorizationException
     */
    #[NoReturn] public function search(Request $request): void
    {

        $this->authorize('view_blacklist');

        $columns = [
                0 => 'responsive_id',
                1 => 'uid',
                2 => 'uid',
                3 => 'number',
                4 => 'reason',
                5 => 'actions',
        ];

        $totalData = Blacklists::where('user_id', Auth::user()->id)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $blacklists = Blacklists::where('user_id', Auth::user()->id)->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
        } else {
            $search = $request->input('search.value');

            $blacklists = Blacklists::where('user_id', Auth::user()->id)->whereLike(['uid', 'number', 'reason'], $search)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

            $totalFiltered = Blacklists::where('user_id', Auth::user()->id)->whereLike(['uid', 'number', 'reason'], $search)->count();

        }

        $data = [];
        if ( ! empty($blacklists)) {
            foreach ($blacklists as $blacklist) {

                if ($blacklist->reason) {
                    $reason = $blacklist->reason;
                } else {
                    $reason = '--';
                }


                $nestedData['responsive_id'] = '';
                $nestedData['uid']           = $blacklist->uid;
                $nestedData['number']        = $blacklist->number;
                $nestedData['reason']        = $reason;
                $data[]                      = $nestedData;

            }
        }

        $json_data = [
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => $totalData,
                "recordsFiltered" => $totalFiltered,
                "data"            => $data,
        ];

        echo json_encode($json_data);
        exit();

    }


    /**
     * @return Application|Factory|View
     * @throws AuthorizationException
     */

    public function create(): Factory|View|Application
    {
        $this->authorize('create_blacklist');

        $breadcrumbs = [
                ['link' => url("dashboard"), 'name' => __('locale.menu.Dashboard')],
                ['link' => url('blacklists'), 'name' => __('locale.menu.Blacklist')],
                ['name' => __('locale.blacklist.add_new_blacklist')],
        ];

        return view('customer.Blacklists.create', compact('breadcrumbs'));
    }


    /**
     * @param  StoreBlacklist  $request
     *
     * @return RedirectResponse
     */

    public function store(StoreBlacklist $request): RedirectResponse
    {

        if (config('app.stage') == 'demo') {
            return redirect()->route('customer.blacklists.index')->with([
                    'status'  => 'error',
                    'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        // dd($request->all());
        $test = $this->blacklists->store($request->input());
        if(empty(count($test)))
        {
            return redirect()->route('customer.blacklists.index')->with([
                'status'  => 'error',
                'message' => 'Phone Numbers is Invalid',
            ]);
        }
        return redirect()->route('customer.blacklists.index')->with([
                'status'  => 'success',
                'message' => __('locale.blacklist.blacklist_successfully_added'),
        ]);

    }

    /**
     * @param  Blacklists  $blacklist
     *
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Blacklists $blacklist): JsonResponse
    {
        if (config('app.stage') == 'demo') {
            return response()->json([
                    'status'  => 'error',
                    'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }


        $this->authorize('delete_blacklist');

        $this->blacklists->destroy($blacklist);

        return response()->json([
                'status'  => 'success',
                'message' => __('locale.blacklist.blacklist_successfully_updated'),
        ]);

    }

    /**
     * Bulk Action with Enable, Disable and Delete
     *
     * @param  Request  $request
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */

    public function batchAction(Request $request): JsonResponse
    {
        if (config('app.stage') == 'demo') {
            return response()->json([
                    'status'  => 'error',
                    'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $action = $request->get('action');
        $ids    = $request->get('ids');

        if ($action == 'destroy') {
            $this->authorize('delete_blacklist');

            $this->blacklists->batchDestroy($ids);

            return response()->json([
                    'status'  => 'success',
                    'message' => __('locale.blacklist.blacklist_successfully_updated'),
            ]);
        }

        return response()->json([
                'status'  => 'error',
                'message' => __('locale.exceptions.invalid_action'),
        ]);

    }

}
