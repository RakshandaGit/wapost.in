<div class="card">
    <div class="card-body py-2 my-25">
        <!-- header section -->
        <div class="d-flex">
            <a href="{{ route('admin.customers.show', $customer->uid) }}" class="me-25">
                <img src="{{ route('admin.customers.avatar', $customer->uid) }}" alt="{{ $customer->displayName() }}"
                    class="uploadedAvatar rounded me-50" height="100" width="100" />
            </a>
            <!-- upload and reset button -->
            <div class="d-flex align-items-end mt-75 ms-1">
                <div>
                    {{-- <h5 class="mb-1 text-uppercase">{{__('locale.labels.sms_credit')}} : {{ $customer->sms_unit == '-1' ? __('locale.labels.unlimited') : $customer->sms_unit }}</h5> --}}
                    @if ($customer->is_enterprise)
                        <h5 class="mb-1 text-capitalize">
                            {{ __('Available Message') }} :
                            {{ $available_balance }}
                        </h5>
                        <h5 class="mb-1 text-capitalize">
                            {{ __('Requested Message') }} :
                            {{ $pending_balance }}
                            @if ($pending_balance > 0)
                                <a href="{{ route('admin.customers.approveTransaction', $customer->uid) }}"
                                    class="btn btn-sm btn-success text-capitalize ms-2"><i data-feather="check-square"></i>
                                    {{ __('Approve') }}</a>
                            @endif
                        </h5>
                        @include('admin.customer._allocate_message')
                    @endif

                    @include('admin.customer._update_avatar')
                    {{-- @if ($customer->customer->activeSubscription())
                        @include('admin.customer._add_unit')
                        @include('admin.customer._remove_unit')
                    @endif --}}
                    <a href="{{ route('admin.customers.login_as', $customer->uid) }}"
                        class="btn btn-sm btn-info mb-75 me-75 text-capitalize"><i data-feather="log-in"></i>
                        {{ __('locale.customer.login_as_customer') }}</a>

                    <button id="remove-avatar" data-id="{{ $customer->uid }}"
                        class="btn btn-sm btn-danger mb-75 me-75"><i data-feather="trash-2"></i>
                        {{ __('locale.labels.remove') }}</button>

                </div>
            </div>
            <!--/ upload and reset button -->
        </div>
        <!--/ header section -->

        <!-- form -->
        <form id="form" class="form form-vertical mt-2 pt-50"
            action="{{ route('admin.customers.update', $customer->uid) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="row">
                <div class="col-12 col-sm-6">
                    {{-- @dd($customer->is_enterprise) --}}
                    {{-- <div class="col-12">
                        <div class="mb-1">
                            <label class="required form-label b-block me-2">{{ __('Is Partner') }}</label>
                            <input name="is_enterprise" type="radio" id="yes_enterprises" value="1" required
                                {{ $customer->is_enterprise == '1' ? 'checked' : '' }}>
                            <label for="yes_enterprises" class="me-1">Yes</label>
                            <input name="is_enterprise" type="radio" id="no_enterprises" value="0" required
                                {{ $customer->is_enterprise == '0' ? 'checked' : '' }}>
                            <label for="no_enterprises">No</label>

                            <label id="role-error" class="error" for="role"></label>
                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}
                    {{-- <div class="row">
                        <div class="col-12 col-sm-6" id="amount_container"
                            style="display: {{ $customer->is_enterprise == '1' ? 'block' : 'none' }}">
                            <div class="mb-1">
                                <label for="amount" class="required form-label">{{ __('Amount') }}</label>
                                <input type="text" id="amount"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount') }}" name="amount">
                                @error('amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6" id="msg_quantity_container"
                            style="display: {{ $customer->is_enterprise == '1' ? 'block' : 'none' }}">
                            <div class="mb-1">
                                <label for="msg_quantity"
                                    class="required form-label">{{ __('Message quantity') }}</label>
                                <input type="text" id="msg_quantity"
                                    class="form-control @error('msg_quantity') is-invalid @enderror"
                                    value="{{ old('msg_quantity') }}" name="msg_quantity">
                                @error('msg_quantity')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="mb-1">
                                <label for="first_name"
                                    class="form-label required">{{ __('locale.labels.first_name') }}</label>
                                <input type="text" id="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    value="{{ $customer->first_name }}" name="first_name" required>
                                @error('first_name')
                                    <p><small class="text-danger">{{ $message }}</small></p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-1">
                                <label for="last_name" class="form-label">{{ __('locale.labels.last_name') }}</label>
                                <input type="text" id="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ $customer->last_name }}" name="last_name">
                                @error('last_name')
                                    <p><small class="text-danger">{{ $message }}</small></p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-1">
                            <label class="form-label" for="password">{{ __('locale.labels.password') }}</label>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    value="{{ old('password') }}" name="password" />
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>

                            @if ($errors->has('password'))
                                <p><small class="text-danger">{{ $errors->first('password') }}</small></p>
                            @else
                                <p><small class="text-primary"> {{ __('locale.customer.leave_blank_password') }}
                                    </small></p>
                            @endif
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-1">
                            <label class="form-label"
                                for="password_confirmation">{{ __('locale.labels.password_confirmation') }}</label>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" id="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    value="{{ old('password_confirmation') }}" name="password_confirmation" />
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="col-12">
                        <div class="mb-1">
                            <label for="email" class="form-label required">{{ __('locale.labels.email') }}</label>
                            <input type="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ $customer->email }}" name="email" required>
                            @error('email')
                                <p><small class="text-danger">{{ $message }}</small></p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-2">
                            <label for="timezone"
                                class="required form-label">{{ __('locale.labels.timezone') }}</label>
                            <select class="select2 form-select" id="timezone" name="timezone">
                                @foreach (\App\Library\Tool::allTimeZones() as $timezone)
                                    <option value="{{ $timezone['zone'] }}"
                                        {{ $customer->timezone == $timezone['zone'] ? 'selected' : null }}>
                                        {{ $timezone['text'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('timezone')
                            <p><small class="text-danger">{{ $message }}</small></p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="mb-1">
                            <label for="locale"
                                class="required form-label">{{ __('locale.labels.language') }}</label>
                            <select class="select2 form-select" id="locale" name="locale">
                                @foreach ($languages as $language)
                                    <option value="{{ $language->code }}"
                                        {{ $customer->locale == $language->code ? 'selected' : null }}>
                                        {{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('locale')
                            <p><small class="text-danger">{{ $message }}</small></p>
                        @enderror
                    </div>
                </div>

                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                    <button type="submit" class="btn btn-primary mt-1 me-1"><i data-feather="save"></i>
                        {{ __('locale.buttons.save_changes') }}</button>
                </div>

            </div>
        </form>
        <!--/ form -->
    </div>
</div>
<script src="{{ asset('website/js/jquery-3.6.0.min.js') }}"></script>
<script>
    $(function() {

        jQuery.validator.addMethod(
            "customEmail",
            function(value, element) {
                return (
                    this.optional(element) ||
                    /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value)
                );
            },
            "Please enter valid email address!"
        );
        // jQuery.validator.addMethod(
        //     "uniqueEmail",
        //     function(value, element) {
        //         var result = false
        //         var email = $("#email").val();
        //         $.ajax({
        //             async: false,
        //             type: "GET",
        //             url: window.location.origin + "/check-username?email=" + email,
        //             success: function(response) {
        //                 if (response.error) {
        //                     result = false;
        //                 } else {
        //                     result = true;
        //                 }
        //             },
        //         });
        //         return result;
        //     },

        //     "The email has already been taken."
        // );
        var mainform = $("#form");
        var mainformRules = mainform.find("[data-rules]");
        var allrules = getRuls(mainformRules);
        var additionalRules = {
            first_name: {
                required: true,
                minlength: 2,
            },
            email: {
                required: true,
                customEmail: true,
                // uniqueEmail: true,
            },
        };

        $.extend(allrules, additionalRules);
        mainform.validate({
            rules: allrules,
            messages: {

            },
        });
    });

    function getRuls(inputs) {
        var rules = {};
        inputs.each(function(index, element) {
            var curInput = $(element);
            var dataName = curInput.attr("name");
            var dataRules = curInput.attr("data-rules");

            if (dataName && dataRules) {
                var parsedDataRules = dataRules;
                try {
                    rules[dataName] = JSON.parse(parsedDataRules);
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                }
            }
        });
        return rules;
    }
</script>
