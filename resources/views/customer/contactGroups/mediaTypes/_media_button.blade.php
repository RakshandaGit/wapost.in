<div class="row">
    
    <div class="col-12">
        <div class="mb-1">
            <label for="title" class="required form-label">{{ __('Title Of Message') }}</label>
            <input type="text" name="title" class="form-control" required="" id="mediatitle" />

        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="reply_button" class="form-label">{{ __('Reply Button Title') }}</label>
            <input type="text" name="reply_button" class="form-control" id="reply_button" />
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="call_button" class="form-label">{{ __('Call Button Title') }}</label>
            <input type="text" name="call_button" class="form-control" id="call_button" />
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="call_button_payload" class="form-label">{{ __('Phone Number') }}</label>
            <input type="tel" name="call_button_payload" class="form-control" id="call_button_payload"  maxlength="12"/>
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="doc_file" class="required form-label">{{ __('locale.labels.doc_file') }}</label>
            <input type="file" class="form-control" required="" name="button_media_file" id="button_media_file"
                accept="image/*" />
            <input type="hidden" name="button_media_file" />
            <input type="hidden" name="media_file_type" />
            <input type="hidden" name="media_file_mime" />
            {{-- @error('doc_file')
            <div class="text-danger">
                {{ $message }}
            </div>
            @enderror --}}
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="footertext" class="form-label">{{ __('Footer Text') }}</label>
            <div class="position-relative footertextbtn mb-3">
                <div class="wa-editor-area">
                    <div class="wa-editor" id="quillTextMessageEditor" style="height: 200px;"></div>
                    <input type="hidden" class="appnedQuillTextMessage" name="footertext">
                </div>
            </div>
        </div>
    </div>
    
</div>
