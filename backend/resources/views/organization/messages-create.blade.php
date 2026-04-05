@extends('layouts.organization')

@section('title', 'Compose Message')

@section('styles')
<style>
    .section-title {
        color: var(--university-accent);
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 16px;
        padding: 8px 12px;
        background: rgba(79, 70, 229, 0.1);
        border-left: 3px solid var(--university-accent);
        border-radius: 4px;
        display: inline-block;
    }
    .form-label {
        color: var(--cream);
        font-weight: 500;
        margin-bottom: 8px;
        font-size: 13px;
        display: block;
    }
    .form-control, .form-select {
        background: rgba(26, 31, 58, 0.8);
        border: 1px solid rgba(79, 70, 229, 0.3);
        color: var(--cream);
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
        background: rgba(26, 31, 58, 0.95);
        border-color: var(--university-accent);
        color: var(--cream);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2), 0 5px 20px rgba(79, 70, 229, 0.1);
        outline: none;
    }
    .form-control::placeholder {
        color: var(--gray);
    }
    .form-select option {
        background: var(--primary);
        color: var(--cream);
    }
    .form-check {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        background: rgba(79, 70, 229, 0.1);
        border: 1px solid rgba(79, 70, 229, 0.2);
        border-radius: 10px;
        transition: all 0.3s ease;
        margin-bottom: 12px;
    }
    .form-check:hover {
        background: rgba(79, 70, 229, 0.15);
    }
    .form-check-input {
        width: 20px;
        height: 20px;
        background-color: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(79, 70, 229, 0.4);
        border-radius: 4px;
        cursor: pointer;
        margin: 0;
        flex-shrink: 0;
    }
    .form-check-input:checked {
        background-color: var(--university-accent);
        border-color: var(--university-accent);
    }
    .form-check-label {
        color: var(--cream);
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        margin: 0;
    }
    .invalid-feedback {
        color: #fca5a5;
        font-size: 12px;
        margin-top: 6px;
    }
    .text-danger {
        color: #f87171 !important;
    }
    .text-muted {
        color: var(--gray) !important;
        font-size: 12px;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Compose Message</h1>
        <p class="page-subtitle">Send a message to your alumni network</p>
    </div>
    <a href="{{ route('organization.messages') }}" class="btn btn-outline">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 8px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Messages
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('organization.messages.store') }}" method="POST">
            @csrf
            
            <div class="row g-4">
                <div class="col-12">
                    <h5 class="section-title">Message Details</h5>
                </div>

                <div class="col-12">
                    <label class="form-label">Subject <span class="text-danger">*</span></label>
                    <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" 
                           value="{{ old('subject') }}" placeholder="Enter message subject" required>
                    @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-4">
                    <h5 class="section-title">Target Audience</h5>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Target Audience <span class="text-danger">*</span></label>
                    <select name="target_audience" class="form-select" required>
                        <option value="all" {{ old('target_audience') == 'all' ? 'selected' : '' }}>All Alumni</option>
                        <option value="batch" {{ old('target_audience') == 'batch' ? 'selected' : '' }}>Specific Batch Year</option>
                        <option value="branch" {{ old('target_audience') == 'branch' ? 'selected' : '' }}>Specific Branch/Department</option>
                        <option value="recent" {{ old('target_audience') == 'recent' ? 'selected' : '' }}>Recent Graduates (Last 2 years)</option>
                        <option value="donors" {{ old('target_audience') == 'donors' ? 'selected' : '' }}>Previous Donors</option>
                        <option value="event_attendees" {{ old('target_audience') == 'event_attendees' ? 'selected' : '' }}>Event Attendees</option>
                    </select>
                </div>
                
                <div class="col-md-6" id="batchYearField" style="display: none;">
                    <label class="form-label">Select Batch Year <span class="text-danger">*</span></label>
                    <select name="target_value" class="form-control @error('target_value') is-invalid @enderror">
                        @for($year = date('Y'); $year >= 1990; $year--)
                        <option value="{{ $year }}" {{ old('target_value') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                    @error('target_value')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6" id="branchField" style="display: none;">
                    <label class="form-label">Select Branch/Department <span class="text-danger">*</span></label>
                    <input type="text" name="target_value" class="form-control @error('target_value') is-invalid @enderror" 
                           value="{{ old('target_value') }}" placeholder="e.g., Computer Science">
                    @error('target_value')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-4">
                    <h5 class="section-title">Message Content</h5>
                </div>

                <div class="col-12">
                    <label class="form-label">Message Content <span class="text-danger">*</span></label>
                    <textarea name="content" rows="8" class="form-control @error('content') is-invalid @enderror" 
                              placeholder="Write your message here. You can use @{{name}} to personalize with recipient's name." required>{{ old('content') }}</textarea>
                    @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Tip: Use @{{ @{{name}} @}} to insert recipient's name automatically</small>
                </div>

                <div class="col-12 mt-4">
                    <h5 class="section-title">Delivery Settings</h5>
                </div>

                <div class="col-md-6">
                    <label class="form-label" style="margin-bottom: 12px;">Delivery Method</label>
                    @error('delivery')
                    <div class="invalid-feedback" style="display: block; margin-bottom: 12px;">{{ $message }}</div>
                    @enderror
                    <div class="form-check">
                        <input type="checkbox" name="send_email" value="1" class="form-check-input" id="sendEmail" {{ old('send_email', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="sendEmail">Send via Email</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="send_notification" value="1" class="form-check-input" id="sendNotification" {{ old('send_notification', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="sendNotification">Send In-app Notification</label>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Schedule (Optional)</label>
                    <input type="datetime-local" name="scheduled_at" class="form-control" 
                           value="{{ old('scheduled_at') }}">
                    <small class="text-muted">Leave empty to send immediately</small>
                </div>

                <div class="col-12 mt-4">
                    <hr style="border-color: rgba(79, 70, 229, 0.2);">
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" name="action" value="send" class="btn btn-primary">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 8px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Send Message
                        </button>
                        <button type="submit" name="action" value="draft" class="btn btn-outline">
                            Save as Draft
                        </button>
                        <button type="button" class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#previewModal">
                            Preview
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
const targetAudienceSelect = document.querySelector('[name="target_audience"]');
const batchField = document.getElementById('batchYearField');
const branchField = document.getElementById('branchField');
const batchInput = batchField.querySelector('select[name="target_value"]');
const branchInput = branchField.querySelector('input[name="target_value"]');

function updateFieldsVisibility() {
    // Hide all conditional fields first
    batchField.style.display = 'none';
    branchField.style.display = 'none';
    
    // Disable inputs that are hidden to prevent form submission issues
    batchInput.disabled = true;
    branchInput.disabled = true;
    
    // Show and enable only the relevant field
    if (targetAudienceSelect.value === 'batch') {
        batchField.style.display = 'block';
        batchInput.disabled = false;
    } else if (targetAudienceSelect.value === 'branch') {
        branchField.style.display = 'block';
        branchInput.disabled = false;
    }
}

// Initialize on page load (important for validation errors / old input)
updateFieldsVisibility();

// Update on change
targetAudienceSelect.addEventListener('change', updateFieldsVisibility);
</script>
@endsection
