<button type="button" class="btn btn-sm btn-success mb-75 me-75" data-bs-toggle="modal"
    data-bs-target="#allocateMessage"><i data-feather="alert-circle"></i> {{ __('Allocate Messages') }}</button>

{{-- Modal --}}
<div class="modal fade text-left" id="allocateMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">{{ __('Allocate Messages') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form" action="{{ route('admin.assginMessagesToCustomer', $customer->uid) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group form-float mb-2">
                            <label class="form-label">{{ __('Amount') }} <span
                                    class="required"></span></label>
                            <div class="form-line">
                                <input type="text" id="amount" class="form-control" name="amount" required
                                    >
                            </div>
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group form-float mb-2">
                            <label class="form-label">{{ __('Message quantity') }}<span class="required"></span></label>
                            <div class="form-line">
                                <input type="number" class="form-control" name="message_qty" id="message_qty"
                                    value="{{ old('message_qty') }}" required minlength="1" maxlength="10">
                            </div>
                            @error('message_qty')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ __('Allocate Messages') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('website/js/jquery-3.6.0.min.js') }}"></script>
<script>
    $(function() {
            jQuery.validator.addMethod("greaterThanZero", function(value, element) {
                return parseFloat(value) > 0;
            }, "Amount must be greater than 0.");


            var mainform = $("#form");
            var mainformRules = mainform.find("[data-rules]");
            var allrules = getRuls(mainformRules);
            var additionalRules = {
                amount:{
                    required: true,
                    greaterThanZero: true,
                },
            };

            $.extend(allrules, additionalRules);
            mainform.validate({
                rules: allrules,
                messages: {
                    
                },
            });
        });
</script>