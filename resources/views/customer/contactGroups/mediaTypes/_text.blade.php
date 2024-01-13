<div class="row">
    <div class="col-12">
        <div class="mb-1">
            <label for="text_message" class="required form-label">Message</label>
            <div class="position-relative mb-3">
                <div class="wa-editor-area">
                    <div class="wa-editor" id="quillTextMessageEditor" style="height: 200px;" >{{@$messageData->message}}</div>
                    <input type="text" class="appnedQuillTextMessage" name="message" required="" style="visibility: hidden;" value="{{@$messageData->message}}">
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <small class="text-primary text-uppercase text-start" id="remaining"><span id="remains-count">4096 </span> characters</small>
                {{-- <small class="text-primary text-uppercase text-end" id="messages">1 Message (s)</small> --}}
            </div>
        </div>
    </div>
</div>