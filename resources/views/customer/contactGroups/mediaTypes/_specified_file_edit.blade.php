<div class="row">
    <div class="col-12">
        <div class="mb-1">
            <label for="image_number" class="required form-label d-block">
                Select File Type
            </label>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="fileType" value="image"
                    onchange="mediaTypeChange(this.value)"
                    {{ $messageData->mediaType == 'image' ? 'checked' : '' }}>Image
                <label class="form-check-label"></label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="fileType" value="video"
                    onchange="mediaTypeChange(this.value)"
                    {{ $messageData->mediaType == 'video' ? 'checked' : '' }}>Video
                <label class="form-check-label"></label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" class="form-check-input" name="fileType" value="audio"
                    onchange="mediaTypeChange(this.value)"
                    {{ $messageData->mediaType == 'audio' ? 'checked' : '' }}>Audio
                <label class="form-check-label"></label>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="image_file" class="required form-label">{{ __('locale.labels.media_file') }}</label>
            <input type="file" name="file" class="form-control" id="image_file" accept="image/*" />
        </div>
    </div>

    @if ($messageData->mediaType != 'audio')
        <div class="col-12" id="mediaCaption">
            <div class="mb-1">
                <label for="image_caption" class="form-label">Caption</label>
                <div class="position-relative mb-3">
                    <div class="wa-editor-area">
                        <div class="wa-editor" id="quillTextMessageEditor" style="height: 200px;">
                            {{ @$messageData->message }}</div>
                        <input type="hidden" class="appnedQuillTextMessage" name="caption"
                            value="{{ @$messageData->message }}">
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
