<?php

Route::group(
    ['namespace' => 'Auth'],
    function () {
        if (config('account.can_register')) {
            // Registration Routes...
            Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
            Route::post('register-for-free-user', 'RegisterController@registerForFreeUsers')->name('registerForFreeUsers');
            Route::post('register', 'RegisterController@register');
            Route::post('pay-offline', 'RegisterController@PayOffline')->name('payment.offline');
            Route::get('check-username', 'RegisterController@checkUsername')->name('checkUsername');

            Route::get('/email/verify', 'VerificationController@verificationNotice')->middleware(['auth'])->name('verification.notice');
            Route::get('/email/verify/{id}/{hash}', 'VerificationController@verificationVerify')->middleware(['auth', 'signed'])->name('verification.verify');
            Route::post('/email/verification-notification', 'VerificationController@verificationSend')->middleware(['auth', 'throttle:6,1'])->name('verification.send');
        }

        // Authentication Routes...
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::any('logout', 'LoginController@logout')->name('logout');

        Route::get('login/{provider}', 'LoginController@redirectToProvider')->name('social.login');
        Route::get('login/{provider}/callback', 'LoginController@handleProviderCallback')->name('social.callback');

        // Password Reset Routes...
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');

        //two-step verification routes
        Route::get('verify/resend', 'TwoFactorController@resend')->name('verify.resend');
        Route::get('verify/backup-code', 'TwoFactorController@backUpCode')->name('verify.backup');
        Route::post('verify/backup-code', 'TwoFactorController@updateBackUpCode');
        Route::resource('verify', 'TwoFactorController')->only(['index', 'store']);

        //common or public data access routes
        Route::get('download-sample-file', 'LoginController@downloadSampleFile')->name('sample.file');
    }
);

Route::any('account/{user}/success/{plan}/{payment_method}', 'User\AccountController@successfulRegisterPayment')->name('registers.payment_success');
Route::any('account/{user}/cancel', 'User\AccountController@cancelledRegisterPayment')->name('registers.payment_cancel');
Route::group(
    [
        'namespace'  => 'User',
        'as'         => 'user.',
        'middleware' => ['auth', 'verified'],
    ],
    function () {
        /*
             * User Dashboard Specific
             */
        Route::get('/dashboard', 'UserController@index')->name('home');


        /*
             * switch view
             */
        Route::get('/switch-view', 'AccountController@switchView')->name('switch_view');


        /*
             * User Account Specific
             */
        Route::get('account', 'AccountController@index')->name('account');
        Route::get('avatar', 'AccountController@avatar')->name('avatar');
        Route::post('avatar', 'AccountController@updateAvatar');
        Route::post('remove-avatar', 'AccountController@removeAvatar')->name('remove_avatar');


        /*
             * User Profile Update
             */
        Route::patch('account/update', 'AccountController@update')->name('account.update');
        Route::post('account/update-information', 'AccountController@updateInformation')->name('account.update_information');

        Route::post('account/change-password', 'AccountController@changePassword')->name('account.change.password');

        Route::get('account/two-factor/{status}', 'AccountController@twoFactorAuthentication')->name('account.twofactor.auth');
        Route::get('account/generate-two-factor-code', 'AccountController@generateTwoFactorAuthenticationCode')->name('account.twofactor.generate_code');
        Route::post('account/two-factor/{status}', 'AccountController@updateTwoFactorAuthentication');


        Route::get('account/top-up', 'AccountController@topUp')->name('account.top_up');
        Route::post('account/top-up', 'AccountController@checkoutTopUp');
        Route::post('account/pay-top-up', 'AccountController@payTopUp')->name('account.pay');

        //notifications

        Route::post('account/notifications', 'AccountController@notifications')->name('account.notifications');
        Route::post('account/notifications/{notification}/active', 'AccountController@notificationToggle')->name('account.notifications.toggle');
        Route::post('account/notifications/{notification}/delete', 'AccountController@deleteNotification')->name('account.notifications.delete');
        Route::post('notifications/batch_action', 'AccountController@notificationBatchAction')->name('account.notifications.batch_action');

        //Registration Payment
        // Route::any('account/{user}/success/{plan}/{payment_method}', 'AccountController@successfulRegisterPayment')->name('registers.payment_success');
        // Route::any('account/{user}/cancel', 'AccountController@cancelledRegisterPayment')->name('registers.payment_cancel');
        Route::post('account/{user}/braintree', 'AccountController@braintreeRegister')->name('registers.braintree');
        Route::post('account/{user}/authorize-net', 'AccountController@authorizeNetRegister')->name('registers.authorize_net');
        Route::any('callback/sslcommerz/register', 'AccountController@sslcommerzRegister')->name('callback.sslcommerz.register');
        Route::any('callback/aamarpay/register', 'AccountController@aamarpayRegister')->name('callback.aamarpay.register');
        Route::any('callback/flutterwave/register', 'AccountController@flutterwaveRegister')->name('callback.flutterwave.register');
        Route::post('account/{user}/vodacommpesa', 'AccountController@vodacommpesaRegister')->name('registers.vodacommpesa');
        Route::post('account/{user}/phonepe', 'AccountController@phonepeRegister')->name('registers.phonepe');

        if (config('account.can_delete')) {
            /*
                 * Account delete
                 */
            Route::delete('account/delete', 'AccountController@delete')->name('account.delete');
        }
    }
);


// Partner page

// updated by shubham
// Route::any('account/{user}/success/{plan}/{payment_method}', 'App\Http\Controllers\User\AccountController@successfulRegisterPayment')->name('registers.payment_success');
// Route::any('account/{user}/cancel', 'App\Http\Controllers\User\AccountController@cancelledRegisterPayment')->name('user.registers.payment_cancel');

Route::group(
    [
        'namespace'  => 'Customer',
        'as'         => 'Customer.'
    ],
    function () {

        Route::get('pos-activation', 'PartnerController@posActivation')->name('posActivation');
        Route::get('free-connection', 'PartnerController@freeConnection')->name('freeConnection');
        Route::post('register-pos-user', 'PartnerController@registerPOSUser')->name('registerPOSUser');
        Route::get('pos-thank-you', 'PartnerController@thankYou')->name('posThankYou');
        

        Route::get('/become-a-partner', 'PartnerController@becomePartner')->name('becomePartner');
        Route::post('/store-partner', 'PartnerController@storePartner')->name('storePartner');
        Route::get('/connection-partner', 'PartnerController@connectionsList')->name('connectionPartner');
        Route::get('/thank-you-partner', 'PartnerController@thankYouPartner')->name('thankYouPartner');
    }
);
Route::group(
    [
        'namespace'  => 'Partner',
        'as'         => 'Partner.',
        'middleware' => ['auth', 'verified'],
    ],
    function () {
        Route::get('/partner/panel', 'DashboardController@index')->name('partner.dashboard');


        Route::get('/partner/transactions', 'UserController@allocate')->name('partner-allocate');
        Route::get('/allocate-show', 'UserController@allocateUserShow')->name('allocateUserShow');
        Route::get('/partner/transactions/allocateMessage', 'UserController@allocateMessage')->name('allocateMessage');
        Route::get('/userAllocateMessages-show/{userId}', 'UserController@userAllocateMessagesShow')->name('userAllocateMessagesShow');
        Route::post('/partner/transactions/assgin-messages', 'UserController@assginMessagesToUser')->name('assginMessagesToUser');

        // partner users
        Route::get('/partner/users', 'UserController@index')->name('partners');
        Route::get('/ajax-partner-users', 'UserController@ajaxPartnerUsers')->name('ajaxPartnerUsers');
        Route::get('/partner/users/create', 'UserController@create')->name('create');
        Route::post('/partner/users/store', 'UserController@store')->name('store');
        Route::get('/partner/users/bulk-create', 'UserController@bulkCreate')->name('bulkCreate');
        Route::post('/partner/users/bulk-store', 'UserController@bulkStore')->name('store');

        Route::get('/partner/users/edit/{partner_id}', 'UserController@edit')->name('user-edit');
        Route::post('/partner/users/update/{partner_id}', 'UserController@update')->name('update-user');
        Route::get('/partner/users/transactions/{user_id}', 'UserController@userTransactions')->name('userTransactions');
        Route::get('/partner/users/invoice', 'UserController@invoice')->name('invoice');
    }
);
