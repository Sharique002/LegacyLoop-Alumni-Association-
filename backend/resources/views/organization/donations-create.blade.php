@extends('layouts.organization')

@section('title', 'Create Donation Campaign')

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
    input[type="file"] {
        padding: 10px 16px;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Create Donation Campaign</h1>
        <p class="page-subtitle">Start a new fundraising campaign for your institution</p>
    </div>
    <a href="{{ route('organization.donations') }}" class="btn btn-outline">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 8px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Campaigns
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('organization.donations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-4">
                <div class="col-12">
                    <h5 class="section-title">Campaign Details</h5>
                </div>

                <div class="col-12">
                    <label class="form-label">Campaign Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title') }}" placeholder="e.g., Scholarship Fund 2026" required>
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" 
                              placeholder="Describe the purpose of this campaign and how funds will be used..." required>{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-4">
                    <h5 class="section-title">Funding Goals</h5>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Goal Amount (₹) <span class="text-danger">*</span></label>
                    <input type="number" name="goal_amount" class="form-control @error('goal_amount') is-invalid @enderror" 
                           value="{{ old('goal_amount') }}" placeholder="100000" min="1000" required>
                    @error('goal_amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Start Date <span class="text-danger">*</span></label>
                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                           value="{{ old('start_date', date('Y-m-d')) }}" required>
                    @error('start_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" 
                           value="{{ old('end_date') }}">
                    <small class="text-muted">Leave empty for ongoing campaign</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="scholarship" {{ old('category') == 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                        <option value="infrastructure" {{ old('category') == 'infrastructure' ? 'selected' : '' }}>Infrastructure</option>
                        <option value="research" {{ old('category') == 'research' ? 'selected' : '' }}>Research</option>
                        <option value="equipment" {{ old('category') == 'equipment' ? 'selected' : '' }}>Equipment</option>
                        <option value="events" {{ old('category') == 'events' ? 'selected' : '' }}>Events</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Minimum Donation Amount (₹)</label>
                    <input type="number" name="min_amount" class="form-control" 
                           value="{{ old('min_amount', 100) }}" min="1">
                </div>

                <div class="col-12 mt-4">
                    <h5 class="section-title">Campaign Media & Settings</h5>
                </div>

                <div class="col-12">
                    <label class="form-label">Campaign Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Recommended: 1200x630 pixels</small>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" name="show_donors" value="1" class="form-check-input" id="showDonors" {{ old('show_donors', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="showDonors">
                            Display donor names publicly
                        </label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" name="allow_recurring" value="1" class="form-check-input" id="allowRecurring" {{ old('allow_recurring') ? 'checked' : '' }}>
                        <label class="form-check-label" for="allowRecurring">
                            Allow recurring monthly donations
                        </label>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <hr style="border-color: rgba(79, 70, 229, 0.2);">
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" name="status" value="active" class="btn btn-primary">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 8px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Launch Campaign
                        </button>
                        <button type="submit" name="status" value="draft" class="btn btn-outline">
                            Save as Draft
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
