<?php

namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use File;
use Image;
use Generator;
use App\Models\Tag;
use App\Models\Blog;
use App\Models\User;
use App\Library\Tool;
use App\Models\Author;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\BlogsSetting;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Exceptions\GeneralException;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Box\Spout\Common\Exception\IOException;
use App\Repositories\Contracts\RoleRepository;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Auth\Access\AuthorizationException;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Box\Spout\Common\Exception\UnsupportedTypeException;
use Box\Spout\Writer\Exception\WriterNotOpenedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Storage;

class AuthorController extends AdminBaseController
{
    /**
     * @var UserRepository
     */
    protected UserRepository $users;

    /**
     * @var RoleRepository
     */
    protected RoleRepository $roles;

    /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $users
     * @param  RoleRepository  $roles
     */
    public function __construct(UserRepository $users, RoleRepository $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }

    /**
     * @return Application|Factory|View
     * @throws AuthorizationException
     */

    public function index(): Factory|View|Application
    {
        $this->authorize('view administrator');

        $breadcrumbs = [['link' => url(config('app.admin_path') . '/dashboard'), 'name' => __('locale.menu.Dashboard')], ['link' => url(config('app.admin_path') . '/dashboard'), 'name' => __('Author')], ['name' => __('locale.menu.Authors')]];

        return view('admin.author.index', compact('breadcrumbs'));
    }

    /**
     * @param  Request  $request
     *
     * @return void
     * @throws AuthorizationException
     */
    #[NoReturn]
    public function search(Request $request): void {
        $data = $this->authorize('view administrator');

        $columns = [
            0 => 'responsive_id',
            1 => 'id',
            2 => 'id',
            3 => 'name',
            4 => 'email',
            5 => 'designation',
            6 => 'actions',
        ];

        $totalData = Author::where('created_by', 1)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if ($order == 'name') {
            $order = 'name';
        }

        if (empty($request->input('search.value'))) {
            $authors = Author::where('created_by', 1)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $authors = Author::where('created_by', 1)
                ->whereLike(['id', 'name', 'email', 'designation'], $search)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Author::where('created_by', 1)
                ->whereLike(['id', 'name', 'email', 'designation'], $search)
                ->count();
        }

        $data = [];
        if (!empty($authors)) {
            foreach ($authors as $author) {
                $show = route('admin.author.show', $author->id);

                $edit = null;
                $delete = null;

                if (Auth::user()->can('edit administrator')) {
                    $edit .= $show;
                }

                if (Auth::user()->can('delete administrator')) {
                    $delete .= $author->id;
                }

                $nestedData['id'] = $author->id;
                $nestedData['responsive_id'] = '';
                $nestedData['name'] = $author->name;
                $nestedData['email'] = $author->email;
                $nestedData['designation'] = $author->designation;

                $nestedData['edit'] = $edit;
                $nestedData['delete'] = $delete;
                $data[] = $nestedData;
            }
        }

        $json_data = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ];

        echo json_encode($json_data);
        exit();
    }

    /**
     * create new administrator
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function create(): \Illuminate\Contracts\View\View|Factory|Application
    {
        $breadcrumbs = [['link' => url(config('app.admin_path') . '/dashboard'), 'name' => __('locale.menu.Dashboard')], ['link' => url(config('app.admin_path') . '/blogs'), 'name' => __('Author')], ['name' => __('create author')]];

        return view('admin.author.create', compact('breadcrumbs'));
    }

    public function checkSocialLinks($request)
    {
        $findfb = 'facebook.com';
        $findin = 'instagram.com';
        $findli = 'linkedin.com';

        $find_fb_url = strpos($request->facebook, $findfb);
        if ($request->facebook != '' && ($find_fb_url === false || strpos($request->facebook, 'https') === false)) {
            return 'Please enter valid facebook page link.';
        }

        $insta_profile_url = strpos($request->instagram, $findin);
        if ($request->instagram != '' && ($insta_profile_url === false || strpos($request->instagram, 'https') === false)) {
            return 'Please enter valid instagram profile link.';
        }

        $find_li_company_url = strpos($request->linkedin, $findli);
        if ($request->linkedin != '' && ($find_li_company_url === false || strpos($request->linkedin, 'https') === false)) {
            return 'Please enter valid linkedin page link.';
        }
        return '';
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:100',
        ];

        $validator = $this->validate($request, $rules);

        $checkSocial = $this->checkSocialLinks($request);

        if (!empty($checkSocial)) {
            return redirect()
                ->back()
                ->with('success', $checkSocial);
        }

        if (!empty($request->imagestring)) {
            $image = preg_replace('/^data:image\/\w+;base64,/', '', $request->imagestring);
            $image = base64_decode($image);

            $safeName = 'author_logo' . str_random(10) . '.' . 'jpg';
            $demo = file_put_contents('public/images/assets/blogs/authors/' . $safeName, $image);
        }

        $author = new Author();
        $author->created_by = Auth::user()->id;
        $author->name = $request->name;
        $author->email = $request->email;
        $author->designation = $request->designation;
        $author->bio = $request->bio;
        $author->facebook_profile = $request->facebook;
        $author->instagram_profile = $request->instagram;
        $author->linkedin_profile = $request->linkedin;
        if (!empty($request->imagestring)) {
            $author->profile_pic = $safeName;
        }

        $author->save();

        return redirect()
            ->route('admin.author.index')
            ->with([
                'status' => 'success',
                'message' => __('Author Added Successfully'),
            ]);
    }

    /**
     * View administrator for edit
     *
     * @param  User  $administrator
     *
     * @return Application|Factory|View
     *
     * @throws AuthorizationException
     */

    public function show(Author $author): Factory|View|Application
    {
        $breadcrumbs = [['link' => url(config('app.admin_path') . '/dashboard'), 'name' => __('locale.menu.Dashboard')], ['link' => url(config('app.admin_path') . '/blogs'), 'name' => __('Authors')], ['name' => __('edit author')]];

        $author = Author::find($author->id);

        return view('admin.author.show', compact('breadcrumbs', 'author'));
    }

    /**
     * @param  User  $administrator
     * @param  UpdateAdministrator  $request
     *
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:100',
        ];
        $checkSocial = $this->checkSocialLinks($request);

        if (!empty($checkSocial)) {
            return redirect()
                ->back()
                ->with('success', $checkSocial);
        }
        $validator = $this->validate($request, $rules);

        if (!empty($request->imagestring)) {
            $image = preg_replace('/^data:image\/\w+;base64,/', '', $request->imagestring);
            $image = base64_decode($image);

            $safeName = 'author_logo' . str_random(10) . '.' . 'jpg';
            file_put_contents('public/images/assets/blogs/authors/' . $safeName, $image);
        }

        $author = Author::find($id);
        $author->created_by = Auth::user()->id;
        $author->name = $request->name;
        $author->email = $request->email;
        $author->designation = $request->designation;
        $author->bio = $request->bio;
        $author->facebook_profile = $request->facebook;
        $author->instagram_profile = $request->instagram;
        $author->linkedin_profile = $request->linkedin;
        if (!empty($request->imagestring)) {
            $author->profile_pic = $safeName;
        }

        $author->save();

        return redirect()
            ->route('admin.author.index')
            ->with([
                'status' => 'success',
                'message' => __('Author Updated Successfully'),
            ]);
    }

    /**
     * delete administrator
     *
     * @param  User  $administrator
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Author $author): JsonResponse
    {
        if (config('app.stage') == 'demo') {
            return response()->json([
                'status' => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        Author::destroy($author->id);

        return response()->json([
            'status' => 'success',
            'message' => __('Author Successfully Deleted'),
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
                'status' => 'error',
                'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $action = $request->get('action');
        $ids = $request->get('ids');

        switch ($action) {
            case 'destroy':
                Author::whereIn('id', $ids)->delete();

                return response()->json([
                    'status' => 'success',
                    'message' => __('Authors Deleted'),
                ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => __('locale.exceptions.invalid_action'),
        ]);
    }

    public function destroyAuthor(Request $request, $id)
    {
        Author::destroy($id);

        return response()->json([
            'status' => true,
            'message' => 'Author deleted successfully',
        ]);
    }
}
