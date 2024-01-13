<div class="row">

    <div class="col-12">
        <div class="mb-1">
            <label for="image_caption" class="required form-label">Title</label>
            <input type="text" name="title" required="" class="form-control" id="btn_title" />
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="reply_button" class="form-label">{{ __('Reply Button Title') }}</label>
            <input type="text" name="reply_button_title" class="form-control" id="reply_button_title" />
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="url_button" class="form-label">{{ __('URL Button Title') }}</label>
            <input type="text" name="url_button_title" class="form-control" id="url_button_title" />
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="url_button_payload" class="form-label">{{ __('URL Button Payload') }}</label>
            <input type="text" name="url_button_payload" class="form-control" id="url_button_payload"
                placeholder="url" />
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="call_button" class="form-label">{{ __('Call Button Title') }}</label>
            <input type="text" name="call_button" class="form-control" id="call_button" placeholder="title" />
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="call_button_payload" class="form-label">{{ __('Call Button Payload') }}</label>
            <input type="text" name="call_button_payload" class="form-control" id="call_button_payload"
                placeholder="number" />
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="footer_text" class="form-label">{{ __('Footer Text') }}</label>
            <div class="position-relative footertextbtn mb-3">
                <div class="wa-editor-area">
                    <div class="wa-editor" id="quillTextMessageEditor" style="height: 200px;"></div>
                    <input type="hidden" class="appnedQuillTextMessage" name="footertext">
                </div>
            </div>
        </div>
    </div>
</div>
