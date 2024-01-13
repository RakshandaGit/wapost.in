<?php

use App\Http\Controllers\LanguageController;
use App\Library\Tool;
use App\Models\AppConfig;
use App\Models\Campaigns;
use App\Models\EmailTemplates;
use App\Models\PaymentMethods;
use Database\Seeders\Countries;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    // if (config('app.stage') == 'new') {
    //     return redirect('install');
    // }

    if (config('app.stage') == 'Live' && config('app.version') == '3.3.0') {
        return redirect('update');
    }

    // return redirect('login');
    return redirect('home');
});

// contact us page
Route::get('/contact-us', 'PageController@contact_us')->name('contact_us');
Route::post('/post-contact', 'ContactUsController@postContact')->name('postContact');
Route::post('/post-enquiry', 'ContactUsController@postEnquiry')->name('postEnquiry');

// email subscription

Route::post('/subscribe-email', 'ContactUsController@subscribe')->name('subscribe');
// Route::post('/subscribe-wa', 'ContactUsController@subscribe_wa')->name('subscribe_wa');

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
Route::any('languages', [LanguageController::class, 'languages'])->name('languages');

if (config('app.stage') == 'local') {
    Route::get('run-campaign', function () {

        $campaign = Campaigns::find(4);
        $campaign?->run();
    });

    Route::get('get-contacts', function () {

        $campaign = Campaigns::find(1);
        if ($campaign) {
            $campaign->getContactList();
        }
    });

    Route::get('update-file', function (BufferedOutput $outputLog) {
        $app_path = base_path() . '/bootstrap/cache/';
        if (File::isDirectory($app_path)) {
            File::cleanDirectory($app_path);
        }

        Artisan::call('optimize:clear');
        Artisan::call('migrate', ['--force' => true], $outputLog);
        Tool::versionSeeder(config('app.version'));

        AppConfig::setEnv('APP_VERSION', '3.4.0');

        return redirect()->route('login')->with([
            'status'  => 'success',
            'message' => 'You have successfully updated your application.',
        ]);
    });

    Route::get('update-country', function () {
        $countries = new Countries();
        $countries->run();
    });

    Route::get('debug', function () {

        return 'success';
    });


    Route::get('update-demo', function () {
        Artisan::call('demo:update');

        return 'Demo Updated';
    });
}


Route::get('/version-seeder', function () {
    Tool::versionSeeder('3.3.0');
});

Route::get('/clear', function () {

    Artisan::call('optimize:clear');

    return "Cleared!";
});

// Route::get('home', 'PageController@home')->name('home');
Route::get('/', 'PageController@home')->name('home');
Route::get('pricing', 'PageController@pricing')->name('pricing');
Route::get('about-us', 'PageController@about_us')->name('about_us');
Route::get('contact-us', 'PageController@contact_us')->name('contact_us');
Route::get('terms-condition', 'PageController@terms_condition')->name('terms_condition');
Route::get('privacy-policy', 'PageController@privacy_policy')->name('privacy_policy');
Route::get('refund-policy', 'PageController@refund_policy')->name('refund_policy');
Route::get('features', 'PageController@features')->name('features');
Route::get('documentation/dashboard', 'PageController@dashboard')->name('documentation.dashboard');
Route::get('documentation/connection', 'PageController@connection')->name('documentation.connection');
Route::get('documentation/contacts', 'PageController@contacts')->name('documentation.contacts');
Route::get('documentation/blacklist', 'PageController@blacklist')->name('documentation.blacklist');
Route::get('documentation/quicksend', 'PageController@quicksend')->name('documentation.quicksend');
Route::get('documentation/campaign_builder', 'PageController@campaign_builder')->name('documentation.campaign_builder');
Route::get('documentation/reports', 'PageController@reports')->name('documentation.reports');
Route::get('documentation/sent_messages', 'PageController@sent_messages')->name('documentation.sent_messages');
Route::get('blogs', 'PageController@blog')->name('blog');
Route::get('/blogs/{details}', 'PageController@blog_details')->name('blog_details');
Route::get('blog-details2', 'PageController@blog_details2')->name('blog_details2');
Route::get('/subscribe-emails', 'PageController@subscribe')->name('blog.subscribe');
//Route::get('registration', 'PageController@registration')->name('registration');

Route::get('thank-you', function () {
    return response()->view('website.thank-you');
})->name('thank_you');

Route::get('thank-you-for-signup', function () {
    return response()->view('website.thank-you-signup');
})->name('thank_you_signup');

Route::get('/error-page', 'PageController@errorPage')->name('errorPage');
Route::get('/sitemap.xml', function () {
    return response()->view('website.sitemap')->header('Content-Type', 'text/xml');
});

Route::get('/monitor-customer', 'MonitorCustomerController@index');
