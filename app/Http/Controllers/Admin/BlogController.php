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
use App\Http\Requests\Blog\StoreBlog;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Blog\UpdateBlog;
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

class BlogController extends AdminBaseController
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

        $breadcrumbs = [
                ['link' => url(config('app.admin_path')."/dashboard"), 'name' => __('locale.menu.Dashboard')],
                ['link' => url(config('app.admin_path')."/dashboard"), 'name' => __('Blog')],
                ['name' => __('locale.menu.Blogs')],
        ];

        return view('admin.blogs.index', compact('breadcrumbs'));
    }


    /**
     * @param  Request  $request
     *
     * @return void
     * @throws AuthorizationException
     */
    #[NoReturn] public function search(Request $request): void
    {
        $data = $this->authorize('view administrator');

        $columns = [
                0 => 'responsive_id',
                1 => 'id',
                2 => 'id',
                3 => 'title',
                4 => 'url',
                5 => 'created_at',
                6 => 'status',
                7 => 'actions',
        ];

        $totalData = Blog::whereIn('role_id',[1,4])->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
        if ($order == 'title'){
            $order = 'title';
        }

        if (empty($request->input('search.value'))) {
            $blogs = Blog::whereIn('role_id',[1,4])->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get(); 
        } else {
            $search = $request->input('search.value');

            $blogs = Blog::whereIn('role_id',[1,4])->whereLike(['id', 'title', 'status', 'created_at'], $search)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

            $totalFiltered = Blog::whereIn('role_id',[1,4])->whereLike(['id', 'title', 'status', 'created_at'], $search)->count();
        }

        $data = [];
        if ( ! empty($blogs)) {
            foreach ($blogs as $blog) {
                $show = route('admin.blogs.show', $blog->id);

                if ($blog->status) {
                    $status = 'checked';
                } else {
                    $status = '';
                }

                // $get_roles = collect($blog->roles)->map(function ($key) {
                //     return ucfirst($key->display_name());
                // })->join(',');

                // if ($get_roles) {
                //     $roles = $get_roles;
                // } else {
                //     $roles = __('locale.administrator.no_active_roles');
                // }

                $edit   = null;
                $delete = null;

                if (Auth::user()->can('edit administrator')) {
                    $edit .= $show;
                }

                if (Auth::user()->can('delete administrator')) {
                    $delete .= $blog->id;
                }


                $nestedData['id']           = $blog->id;
                $nestedData['responsive_id'] = '';
                $nestedData['title']          = $blog->title;
                $nestedData['url']         = '<a href="'.url('/blogs',$blog->slug).'" target="_blank">'.url('/blogs',$blog->slug).'</a>';
                $nestedData['created_at']    = Tool::formatDate($blog->created_at);
                $nestedData['status']        = "<div class='form-check form-switch form-check-primary'>
                <input type='checkbox' class='form-check-input get_status' id='status_$blog->id' data-id='$blog->id' name='status' $status>
                <label class='form-check-label' for='status_$blog->id'>
                  <span class='switch-icon-left'><i data-feather='check'></i> </span>
                  <span class='switch-icon-right'><i data-feather='x'></i> </span>
                </label>
              </div>";


                $nestedData['edit']   = $edit;
                $nestedData['delete'] = $delete;
                $data[]               = $nestedData;

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
     * create new administrator
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     * @throws AuthorizationException
     */
    public function create(): \Illuminate\Contracts\View\View|Factory|Application
    {

        $breadcrumbs = [
                ['link' => url(config('app.admin_path')."/dashboard"), 'name' => __('locale.menu.Dashboard')],
                ['link' => url(config('app.admin_path')."/blogs"), 'name' => __('blogs')],
                ['name' => __('create blog')],
        ];

        $roles = $this->roles->getAllowedRoles();

        $all_tags = Tag::get(['id','tag']);
        $authors = Author::where('status','1')->get();
        $selectTags = array();

        return view('admin.blogs.create', compact('breadcrumbs', 'roles', 'all_tags', 'authors', 'selectTags'));
    }


    public function store(Request $request)
    {        
        $rules = [
            'title' => 'required|max:100', 
            'description' => 'required', 
            'blog_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ];

        $messages = [
            'title.required' => 'Title can not be empty',
            'description.required' => 'Content can not be empty',
        ];

        $this->validate($request, $rules, $messages);

        $creat_slug = Str::slug($request->title);
        $check = Blog::where('slug',$creat_slug)->count();
        if ($check != 0) {
            $slug = $creat_slug.'-'.$check.rand(20,80);
        }
        else{
            $slug = $creat_slug;
        }
        
        $blog_banner = '';
        if($request->blog_banner != null){
            $uploadedImage = $this->uploadImage($request);
            if($uploadedImage['status'] == false){
                return response()->json(['status'=>false, 'message'=> $uploadedImage['message']]);
            }else{
                $blog_banner = $uploadedImage['file'];
            }
        }

        $tags = '';
        if($request->tags){
            $tags = implode(',', $request->tags);
        }

        $blog = new Blog;
        $blog->user_id = Auth::user()->id;
        $blog->role_id = 1;
        $blog->author_id = $request->author;
        $blog->title = $request->title;
        $blog->slug = $slug;
        $blog->image = $blog_banner;
        $blog->content = $request->description;
        $blog->tags = $tags;
        $blog->meta_title = $request->meta_title;
        $blog->meta_keyword = $request->meta_keyword;
        $blog->meta_description = $request->meta_description;
        $blog->status = $request->status;
        $blog->featured = $request->featured;
        $blog->save();

        return redirect()->route('admin.blogs.index')->with([
                'status'  => 'success',
                'message' => __('Blog Added Successfully'),
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

    public function show(Blog $blog): Factory|View|Application
    {

        $breadcrumbs = [
                ['link' => url(config('app.admin_path')."/dashboard"), 'name' => __('locale.menu.Dashboard')],
                ['link' => url(config('app.admin_path')."/blogs"), 'name' => __('Blogs')],
                ['name' => __('edit blog')],
        ];

        $get_roles = collect($blog->roles)->map(function ($key) {
            return $key->id;
        })->join(',');

        // $languages = Language::where('status', 1)->get();
        $roles     = $this->roles->getAllowedRoles();

        $blogInfo = Blog::find($blog->id); 
        $authors = Author::where('status','1')->get();
        $all_tags = Tag::get(['id','tag']);

        $selectTags=array();
        
        if($blogInfo->tags != null){
            $tags = $blogInfo->tags;
            $selectTags = explode(',', $tags);
        }  

        return view('admin.blogs.show', compact('breadcrumbs', 'blog', 'roles', 'get_roles', 'blogInfo', 'all_tags', 'selectTags', 'authors'));
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
            'title' => 'required|max:100',
            'slug' => 'required|max:200', 
            'description' => 'required',
            'blog_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ];

        $messages = [
            'title.required' => 'Title can not be empty',
            'description.required' => 'Content can not be empty',
            'slug.required' => 'Slug can not be empty',
        ];

        $this->validate($request, $rules, $messages);

        $blog = Blog::find($id);

        $blog_banner = '';
        if($request->hasFile('blog_banner'))
        {
            /* Delete from banner folder start */
            $file_path = base_path('../images/assets/blogs/banners/'.$blog['image']);
            $file_path_thumbnails = base_path('../images/assets/blogs/banners/thumbnails/'.$blog['image']);
            //You can also check existance of the file in storage.
            if(file_exists($file_path)) {
               @unlink($file_path); 
               @unlink($file_path_thumbnails); 
            }
            /*  Delete from banner folder end */



            $uploadedImage = $this->uploadImage($request);
            if($uploadedImage['status'] == false){
                return response()->json(['status'=>false, 'message'=> $uploadedImage['message']]);
            }else{
                $blog_banner = $uploadedImage['file'];
            }
        }else{
            $blog_banner = $blog->image;
        }

        $tags = '';
        if($request->tags){
            $tags = implode(',', $request->tags);
        }
        $blog->author_id = $request->author;
        $blog->title = $request->title;
        $blog->slug = $request->slug;
        $blog->image = $blog_banner;
        $blog->content = $request->description;
        $blog->tags = $tags;
        $blog->meta_title = $request->meta_title;
        $blog->meta_keyword = $request->meta_keyword;
        $blog->meta_description = $request->meta_description;
        $blog->status = $request->status;
        $blog->featured = $request->featured;
        $blog->updated_at = $request->updated_at;
        $blog->save();

        return redirect()->route('admin.blogs.index')->with([
            'status'  => 'success',
            'message' => __('Blog Updated Successfully'),
        ]);
    }


    /**
     * change administrator status
     *
     * @param  User  $administrator
     *
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws GeneralException
     */
    public function activeToggle(Blog $blog): JsonResponse
    {
        if (config('app.stage') == 'demo') {
            return response()->json([
                    'status'  => 'error',
                    'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }
        try {
            $this->authorize('edit administrator');
            if ($blog->update(['status' => ! $blog->status])) {
                return response()->json([
                        'status'  => 'success',
                        'message' => __('Blog Successfully Change'),
                ]);
            }

            throw new GeneralException(__('locale.exceptions.something_went_wrong'));

        } catch (ModelNotFoundException $exception) {
            return response()->json([
                    'status'  => 'error',
                    'message' => $exception->getMessage(),
            ]);
        }
    }


    /**
     * delete administrator
     *
     * @param  User  $administrator
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Blog $blog): JsonResponse
    {
        if (config('app.stage') == 'demo') {
            return response()->json([
                    'status'  => 'error',
                    'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        Blog::destroy($blog->id);

        return response()->json([
                'status'  => 'success',
                'message' => __('Blog Successfully Deleted'),
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

        switch ($action) {
            case 'destroy':

                Blog::whereIn('id', $ids)->delete();

                return response()->json([
                        'status'  => 'success',
                        'message' => __('Blogs Deleted'),
                ]);

            case 'enable':
                
                Blog::whereIn('id', $ids)->update(['status' => 1]);
                return response()->json([
                        'status'  => 'success',
                        'message' => __('Blogs Enabled'),
                ]);

            case 'disable':

                Blog::whereIn('id', $ids)->update(['status' => 0]);

                return response()->json([
                        'status'  => 'success',
                        'message' => __('Blogs disabled'),
                ]);
        }

        return response()->json([
                'status'  => 'error',
                'message' => __('locale.exceptions.invalid_action'),
        ]);

    }


    /**
     * @return Generator
     */

    public function AdministratorGenerator(): Generator
    {
        foreach (User::where('is_admin', 1)->cursor() as $administrator) {
            yield $administrator;
        }
    }


    /**
     *
     * @return RedirectResponse|BinaryFileResponse
     * @throws AuthorizationException
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws UnsupportedTypeException
     * @throws WriterNotOpenedException
     */
    // public function export(): BinaryFileResponse|RedirectResponse
    // {

    //     if (config('app.stage') == 'demo') {
    //         return redirect()->route('admin.administrators.index')->with([
    //                 'status'  => 'error',
    //                 'message' => 'Sorry! This option is not available in demo mode',
    //         ]);
    //     }

    //     $this->authorize('edit administrator');

    //     $file_name = (new FastExcel($this->AdministratorGenerator()))->export(storage_path('Administrator_'.time().'.xlsx'));

    //     return response()->download($file_name);
    // }

    /**
     * get allowed roles
     *
     * @return Collection
     */
    public function getRoles(): Collection
    {
        return $this->roles->getAllowedRoles();
    }

    public function add_tags(Request $request){

        if($request->tag){
            $tag = Tag::updateOrCreate([
                'tag' => $request->tag,
            ]);

           return json_encode(array("type"=>"success", "data" => $tag, "message"=>"Successfully Added."));
        }
    }

    public function uploadImage($request){

        if($request->hasFile('blog_banner'))
        {
            $image = $request->file('blog_banner');
            $extension = $image->getClientOriginalExtension();
            $size = $image->getSize();
            $extension = $image->getClientOriginalExtension();
            $fileName = 'wapost-'.date('dmYhis',time()) . '.' . $extension;
            
            /* thumbnails start */
            $destinationPath = base_path('public/images/assets/blogs/banners/thumbnails/');
            $img = Image::make($image->path());
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath. $fileName);
            /* thumbnails end */
      

            $destinationPath = base_path('public/images/assets/blogs/banners/');
            $img = Image::make($image->path());
            // $img->resize(1024, 1024, function ($constraint) {
            //     $constraint->aspectRatio();
            // });
            if(!File::isDirectory($destinationPath)){
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            
            $image_resize = Image::make($image->getRealPath());
            $image_resize->resize(1024 ,1024,function ($constraint) {
            $constraint->aspectRatio();
            })->save($destinationPath. $fileName);

            return ['status'=>true, 'file' => $fileName];

        }else{
            return ['status'=>false, 'message'=> 'Please select an Blog Image.'];
        }
    }

    // Upload image from CK EDITOR
    public function upload(Request $request)
    {
        $target_dir = base_path('public/images/assets/blogs/banners/');
        if(!File::isDirectory($target_dir)){
            File::makeDirectory($target_dir, 0777, true, true);
        }

        $target_file = $target_dir . basename($_FILES["upload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["upload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        }

        $filename = 'blog-'.date('dmYhis',time()) . '.' . $imageFileType;
        $saveFile = $target_dir .$filename;
        // Check if file already exists
        if (file_exists($saveFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["upload"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {

            if (move_uploaded_file($_FILES["upload"]["tmp_name"], $saveFile)) {

                $CKEditorFuncNum = $request->input('CKEditorFuncNum');

                $url = url('public/images/assets/blogs/banners/'.$filename);
                $msg = 'Image uploaded successfully';
                $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                @header('Content-type: text/html; charset=utf-8');
                echo $response;
                
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }    

        public function updateSettings1(Request $request){

            $rules = [
                'title' => 'required', 
                'description' => 'required'
            ];
    
            $messages = [
                'title.required' => 'Title can not be empty',
                'description.required' => 'Content can not be empty',
            ];
    
            $this->validate($request, $rules, $messages);
    
            BlogsSetting::where('id', 1)
            ->update([
                'title'=> $request->title,
                'description'=>$request->description
            ]);

            return redirect()->route('admin.blogs.settings')->with([
                'status'  => 'success',
                'message' => __('Blog Settings Successfully Updated.'),
            ]);
        }
    
        public function updateSettings2(Request $request){
    
            BlogsSetting::where('id', 1)
            ->update([
                'show_subscription'=>$request->subscribe_form,
                // 'show_category'=>$request->categories,
                'show_top_post'=>$request->top_posts
            ]);

            return redirect()->route('admin.blogs.settings')->with([
                'status'  => 'success',
                'message' => __('Blog Settings Successfully Updated.'),
            ]);
        }
    
        public function updateSettings3(Request $request){
    
            $rules = [
                'meta_title' => 'required',
            ];
    
            $messages = [
                'meta_title.required' => 'Title can not be empty',
            ];
    
            $this->validate($request, $rules, $messages);
    
            BlogsSetting::where('id', 1)
            ->update([
                'meta_title'=> $request->meta_title,
                'meta_description'=>$request->meta_description,
                'meta_keywords'=>$request->meta_keywords
            ]);

            return redirect()->route('admin.blogs.index')->with([
                'status'  => 'success',
                'message' => __('Blog page SEO details are updated.'),
            ]);
        }
    
        public function destroyBlog(Request $request, $id)
        {
            Blog::destroy($id);
    
    
    
            return response()->json([
                'status' => true,
                'message' => 'Blog deleted successfully'
            ]);
        }
    
        public function changeBlogStatus(Request $request, $id)
        {
            $page = Blog::findorFail($id);
            if($page->status == 1){
                $status = 0;
                $hide = 'active-badge';
                $show = 'deactive-badge';
            }else{
                $status = 1;
                $hide = 'deactive-badge';
                $show = 'active-badge';
            }
            $page->status = $status;
            $page->save();
    
    
    
            return response()->json([
                'status' => true,
                'hide' => $hide,
                'show' => $show,
                'message' => 'Blog status changed successfully'
            ]);
        }

        public function settings(Request $request){

            $settings = BlogsSetting::first();
    
            return view('admin.blogs.settings', compact('settings'));
        }
}
