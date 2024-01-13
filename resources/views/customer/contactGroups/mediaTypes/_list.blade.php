<div class="row">
    <div class="col-12">
        <div class="mb-1">
            <label for="button_text" class="form-label">{{ __('Button Text') }}</label>
            <input type="text" name="button_text" class="form-control" required="" id="button_text" />
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="message" class="required form-label">Message</label>
            <div class="position-relative mb-3">
                <div class="wa-editor-area">
                    <div class="wa-editor" id="quillTextMessageEditor" style="height: 200px;"></div>
                    <input type="hidden" class="appnedQuillTextMessage" name="message">
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="title" class="required form-label">{{ __('Title') }}</label>
            <input type="text" name="title" required="" class="form-control" id="title" />
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="description" class="required form-label">{{ __('Description') }}</label>
            <input type="text" name="description" required="" class="form-control" id="description" />
        </div>
    </div>

    <div class="col-12">
        <div class="mb-1">
            <label for="list_title" class="required form-label">{{ __('List Title') }}</label>
            <input type="text" name="list_title" required="" class="form-control" id="list_title" />
        </div>
    </div>

    <div class="col-6">
        <div class="mb-1">
            <button type="button" class="form-control" onclick="addMoreList(this)" id="addrowbtn"> Add Row </button>
        </div>
    </div>

    <div id="list_row_div" style="border: 1px solid black;padding: 7%;}">
        <label for="list" class="form-label font-weight-bold">{{ __('LIST') }}</label>
        <div class="col-12" id="list_row_append">
            <div class="mb-1">
                <label for="list_title" class="required form-label">{{ __('Row Title') }}</label>
                <input type="text" name="row_title[]" required="" class="form-control" id="row_title" />
            </div>
            <div class="mb-1">
                <label for="list_title" class="required form-label">{{ __('Row Description') }}</label>
                <input type="text" name="row_desc[]" required="" class="form-control" id="row_desc" />
            </div>
        </div>
    </div>
</div>
