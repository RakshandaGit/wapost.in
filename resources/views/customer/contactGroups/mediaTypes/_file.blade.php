<div class="row">
    <div class="col-12">
        <div class="mb-1">
            <label for="any_file" class="required form-label">{{ __('locale.labels.any_file') }}</label>
            <input type="file" name="file" class="form-control" required="" id="any_file"
                accept="" />
        </div>
    </div>
    <div class="col-12" id="mediaCaption">
        <div class="mb-1">
            <label for="image_caption" class="form-label">Caption</label>
            <div class="position-relative mb-3">
                <div class="wa-editor-area">
                    <div class="wa-editor" id="quillTextMessageEditor" style="height: 200px;"></div>
                    <input type="hidden" class="appnedQuillTextMessage" name="caption">
                </div>
            </div>
        </div>
    </div>
</div>
