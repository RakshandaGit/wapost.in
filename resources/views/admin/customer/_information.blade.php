<div class="card">
    <div class="card-header border-bottom">
        <h4 class="card-title">{{ __('locale.customer.personal_information') }}</h4>
    </div>
    <div class="card-body pt-1">
        <form id="information-form" class="form form-vertical mt-2 pt-50" action="{{ route('admin.customers.update_information', $customer->uid) }}" method="post">
            @csrf
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="mb-1">
                        <label for="phone" class="form-label required">{{__('locale.labels.phone')}}</label>
                        <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $customer->customer->phone }}" name="phone" required>
                        @error('phone')
                        <p><small class="text-danger">{{ $message }}</small></p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="company" class="form-label">{{__('locale.labels.company')}}</label>
                        <input type="text" id="company" class="form-control @error('company') is-invalid @enderror" value="{{ $customer->customer->company }}" name="company">
                        @error('company')
                        <p><small class="text-danger">{{ $message }}</small></p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="website" class="form-label">{{__('locale.labels.website')}}</label>
                        <input type="url" id="website" class="form-control @error('website') is-invalid @enderror" value="{{ $customer->customer->website }}" name="website">
                        @error('website')
                        <p><small class="text-danger">{{ $message }}</small></p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="address" class="form-label required">{{__('locale.labels.address')}}</label>
                        <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ $customer->customer->address }}" name="address" required>
                        @error('address')
                        <p><small class="text-danger">{{ $message }}</small></p>
                        @enderror
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="mb-1">
                        <label for="city" class="form-label required">{{__('locale.labels.city')}}</label>
                        <input type="text" id="city" class="form-control @error('city') is-invalid @enderror" value="{{ $customer->customer->city }}" name="city" required>
                        @error('city')
                        <p><small class="text-danger">{{ $message }}</small></p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="state" class="form-label">{{__('locale.labels.state')}}</label>
                        <input type="text" id="state" class="form-control @error('state') is-invalid @enderror" value="{{ $customer->customer->state }}" name="state">
                        @error('state')
                        <p><small class="text-danger">{{ $message }}</small></p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="postcode" class="form-label">{{__('locale.labels.postcode')}}</label>
                        <input type="text" id="postcode" class="form-control @error('postcode') is-invalid @enderror" value="{{ $customer->customer->postcode }}" name="postcode">
                        @error('postcode')
                        <p><small class="text-danger">{{ $message }}</small></p>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <label for="country" class="form-label required">{{__('locale.labels.country')}}</label>
                        <select class="select2 form-select" id="country" name="country">
                            @foreach(\App\Helpers\Helper::countries() as $country)
                                <option value="{{$country['name']}}" {{ $customer->customer->country == $country['name'] ? 'selected': null }}> {{ $country['name'] }}</option>
                            @endforeach
                        </select>
                        @error('country')
                        <p><small class="text-danger">{{ $message }}</small></p>
                        @enderror
                    </div>
                </div>


                <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                    <button type="submit" class="btn btn-primary mt-1 me-1"><i data-feather="save"></i> {{ __('locale.buttons.save_changes') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('website/js/jquery-3.6.0.min.js') }}"></script>
<script>
    $(function() {
        $('#phone').on('input', function(e) {
            var inputValue = e.target.value;
            var numericValue = inputValue.replace(/[^0-9]/g, '');

            $(this).val(numericValue);
        });

        // Prevent paste of non-numeric characters
        $('#phone').on('paste', function(e) {
            e.preventDefault();
            var pastedText = (e.originalEvent || e).clipboardData.getData('text/plain');
            var numericValue = pastedText.replace(/[^0-9]/g, '');
            document.execCommand('insertText', false, numericValue);
        });

    });
    $(function() {
        jQuery.validator.addMethod(
            "customPhoneValidation",
            function(value, element) {
                return this.optional(element) || /^[6789]\d{9}$/.test(value);
            },
            "Must be 10 digits and start with 6, 7, 8, or 9"
        );
        jQuery.validator.addMethod(
            "uniquePhone",
            function(value, element) {
                var result = false
                var phone = $("#phone").val();
                $.ajax({
                    async: false,
                    type: "GET",
                    url: window.location.origin + "/check-username?phone=" + phone,
                    success: function(response) {
                        if (response.error) {
                            result = false;
                        } else {
                            result = true;
                        }
                    },
                });
                return result;
            },
            "The phone has already been taken."
        );

        var mainform = $("#information-form");
        var mainformRules = mainform.find("[data-rules]");
        var allrules = getRuls(mainformRules);
        var additionalRules = {
            city: {
                required: true,
            },
            address: {
                required: true,
            },
            phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10,
                uniquePhone: true,
                customPhoneValidation: true,
            },
        };

        $.extend(allrules, additionalRules);
        mainform.validate({
            rules: allrules,
            messages: {
                phone: {
                    minlength: "Please enter at least {0} digits.",
                    maxlength: "Please enter no more than {0} digits.",
                },
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
