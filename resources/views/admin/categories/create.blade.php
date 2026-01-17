@extends('admin.layouts.app')

@section('title', 'Add Category')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="card card-primary card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="general-tab" data-bs-toggle="pill" href="#general" role="tab">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="seo-tab" data-bs-toggle="pill" href="#seo" role="tab">SEO</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="categoryTabsContent">
                        <!-- General Tab -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="E.g. Rings" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Parent Category</label>
                                    <select name="parent_id" class="form-select">
                                        <option value="">-- None (Top Level) --</option>
                                        @foreach($categories as $parent)
                                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                     <label class="form-label">Description</label>
                                     <textarea name="description" class="form-control" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Icon Class (Optional)</label>
                                    <input type="text" name="icon" class="form-control" placeholder="bi bi-gem">
                                    <div class="form-text">Bootstrap Icon class</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Position</label>
                                    <input type="number" name="position" class="form-control" value="0">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Category Banner</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="isActive" name="is_active" checked>
                                        <label class="form-check-label" for="isActive">Active Status</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- SEO Tab -->
                        <div class="tab-pane fade" id="seo" role="tabpanel">
                            <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control">
                            </div>
                             <div class="mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" name="meta_keywords" class="form-control" placeholder="comma, separated, keywords">
                            </div>
                             <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                 <div class="card-footer text-end">
                     <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Save Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </div>
            <!-- /.card -->
        </form>
    </div>
</div>
@endsection
