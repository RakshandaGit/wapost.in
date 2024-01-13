<div class="row">
    <div class="col-12">
        <div class="mb-1">
            <label for="text_number" class="required form-label">
                Full Name
            </label>
            <input type="text" id="fullname" class="form-control " value="{{@$messageData->fullname}}" name="fullname" required=""
                placeholder="Required" autofocus="">
            <input type="hidden" id="displayname" class="form-control " value="{{@$messageData->displayname}}" name="displayname"
                placeholder="Required" autofocus="">
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="text_number" class="required form-label">
                Organization Name
            </label>
            <input type="text" id="organization" class="form-control " value="{{@$messageData->organization}}" name="organization"
                required="" placeholder="Required" autofocus="">
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="text_number" class="required form-label">
                Phone Number
            </label>
            <input type="tel" id="phonenumber" class="form-control " value="{{@$messageData->phonenumber}}" name="phonenumber"
                required="" placeholder="Required" autofocus="" maxlength="12">
        </div>
    </div>
</div>
<script>
    $('#fullname').change(function() {
        $('#displayname').val($(this).val());
    });
</script>
