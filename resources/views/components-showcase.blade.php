@extends('layouts.app')

@section('title', 'UI Components Showcase')

@section('content')
<div class="container-lg">
    <!-- Page Header -->
    <div class="mb-2xl">
        <h1 class="mb-sm">Component Showcase</h1>
        <p class="text-secondary">Complete reference for all UI components available in BlogCMS theme.</p>
    </div>

    <!-- Buttons Section -->
    <div class="card mb-2xl">
        <div class="card-header">
            <h3 class="mb-0">Buttons</h3>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-wrap: wrap; gap: var(--space-lg); margin-bottom: var(--space-xl);">
                <button class="btn btn-primary">Primary Button</button>
                <button class="btn btn-secondary">Secondary Button</button>
                <button class="btn btn-danger">Danger Button</button>
                <button class="btn btn-primary btn-sm">Small Primary</button>
                <button class="btn btn-primary btn-lg">Large Primary</button>
                <button class="btn btn-primary" disabled>Disabled Button</button>
            </div>
            
            <!-- Button Block -->
            <div style="max-width: 300px;">
                <button class="btn btn-primary btn-block">Block Button (Full Width)</button>
            </div>
        </div>
    </div>

    <!-- Typography Section -->
    <div class="card mb-2xl">
        <div class="card-header">
            <h3 class="mb-0">Typography</h3>
        </div>
        <div class="card-body">
            <h1>Heading 1 - 40px Bold</h1>
            <h2>Heading 2 - 32px Bold</h2>
            <h3>Heading 3 - 24px Bold</h3>
            <h4>Heading 4 - 20px Semibold</h4>
            <h5>Heading 5 - 18px Semibold</h5>
            <h6>Heading 6 - 16px Semibold</h6>
            
            <div style="margin-top: var(--space-xl);">
                <p>This is regular paragraph text. It uses Poppins font family with 16px size and 1.6 line height for optimal readability. The color is set to --color-text-primary (dark gray).</p>
                <p class="text-secondary">This is secondary text with reduced color saturation, typically used for descriptions or supporting information.</p>
                <p class="text-small">This is smaller text (14px), perfect for captions and metadata.</p>
                <p class="text-xsmall">This is extra small text (12px), ideal for timestamps and tertiary information.</p>
            </div>
        </div>
    </div>

    <!-- Forms Section -->
    <div class="grid grid-cols-2 gap-xl mb-2xl">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Form Controls</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="text-input">Text Input</label>
                        <input type="text" class="form-control" id="text-input" placeholder="Enter text here...">
                    </div>

                    <div class="form-group">
                        <label for="email-input">Email Input</label>
                        <input type="email" class="form-control" id="email-input" placeholder="your@email.com">
                    </div>

                    <div class="form-group">
                        <label for="select">Select Dropdown</label>
                        <select class="form-select" id="select">
                            <option>Choose an option</option>
                            <option>Option 1</option>
                            <option>Option 2</option>
                            <option>Option 3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="textarea">Textarea</label>
                        <textarea class="form-control" id="textarea" placeholder="Enter your message..."></textarea>
                    </div>

                    <div class="form-group">
                        <label style="margin-bottom: 0; font-weight: 500;">Checkbox</label>
                        <div style="display: flex; gap: var(--space-md); margin-top: var(--space-sm);">
                            <label style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; margin-bottom: 0; font-weight: normal;">
                                <input type="checkbox" checked> Remember me
                            </label>
                            <label style="display: flex; align-items: center; gap: var(--space-sm); cursor: pointer; margin-bottom: 0; font-weight: normal;">
                                <input type="checkbox"> Accept terms
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Submit Form</button>
                </form>
            </div>
        </div>

        <!-- Form with Validation -->
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Form States</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="success-input">Success State</label>
                        <input type="text" class="form-control" id="success-input" placeholder="Valid input" value="Successfully saved">
                        <div class="form-success">✓ This field is valid</div>
                    </div>

                    <div class="form-group">
                        <label for="error-input">Error State</label>
                        <input type="text" class="form-control" id="error-input" placeholder="Invalid input" style="border-color: var(--color-danger);">
                        <div class="form-error">✗ This field is required</div>
                    </div>

                    <div class="form-group">
                        <label for="disabled-input">Disabled Input</label>
                        <input type="text" class="form-control" id="disabled-input" placeholder="Disabled" disabled>
                    </div>

                    <button type="submit" class="btn btn-secondary btn-block" disabled>Disabled Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Badges Section -->
    <div class="card mb-2xl">
        <div class="card-header">
            <h3 class="mb-0">Badges & Status Indicators</h3>
        </div>
        <div class="card-body">
            <div style="display: flex; flex-wrap: wrap; gap: var(--space-lg); align-items: center;">
                <span class="badge badge-primary">Primary</span>
                <span class="badge badge-success">Published</span>
                <span class="badge badge-warning">Pending</span>
                <span class="badge badge-danger">Rejected</span>
                <span class="badge badge-info">Draft</span>
            </div>
        </div>
    </div>

    <!-- Alerts Section -->
    <div class="card mb-2xl">
        <div class="card-header">
            <h3 class="mb-0">Alerts & Notifications</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-success">
                <strong>✓ Success!</strong> Your post has been published successfully. You can view it on your blog.
            </div>

            <div class="alert alert-info">
                <strong>ℹ Info:</strong> You have 3 pending comments waiting for review.
            </div>

            <div class="alert alert-warning">
                <strong>⚠ Warning!</strong> Your storage limit is 80% full. Consider cleaning up old media files.
            </div>

            <div class="alert alert-danger">
                <strong>✗ Error!</strong> Failed to save your post. Please check the form for errors.
            </div>
        </div>
    </div>

    <!-- Cards Section -->
    <div class="card mb-2xl">
        <div class="card-header">
            <h3 class="mb-0">Card Variations</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-3 gap-lg">
                <!-- Standard Card -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-md">Standard Card</h5>
                        <p class="text-secondary mb-0">This is a standard card with header, body, and subtle shadows.</p>
                    </div>
                </div>

                <!-- Card with Stats -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted mb-sm">Page Views</h6>
                        <h2 class="mb-md" style="color: var(--color-primary);">2,847</h2>
                        <p class="text-small" style="color: var(--color-success);">↑ 12% increase</p>
                    </div>
                </div>

                <!-- Card with Action -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-md">Card with Action</h5>
                        <p class="text-secondary mb-lg">Click the button below to perform an action.</p>
                        <button class="btn btn-primary btn-sm btn-block">Take Action</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Colors Section -->
    <div class="card mb-2xl">
        <div class="card-header">
            <h3 class="mb-0">Color Palette</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-4 gap-lg">
                <!-- Primary -->
                <div>
                    <div style="width: 100%; aspect-ratio: 1; background-color: var(--color-primary); border-radius: var(--radius-lg); margin-bottom: var(--space-md); box-shadow: var(--shadow-md);"></div>
                    <p class="text-xsmall text-muted mb-xs">PRIMARY</p>
                    <p style="font-weight: 600; font-size: 0.875rem;">#0D9488</p>
                </div>

                <!-- Success -->
                <div>
                    <div style="width: 100%; aspect-ratio: 1; background-color: var(--color-success); border-radius: var(--radius-lg); margin-bottom: var(--space-md); box-shadow: var(--shadow-md);"></div>
                    <p class="text-xsmall text-muted mb-xs">SUCCESS</p>
                    <p style="font-weight: 600; font-size: 0.875rem;">#10B981</p>
                </div>

                <!-- Warning -->
                <div>
                    <div style="width: 100%; aspect-ratio: 1; background-color: var(--color-warning); border-radius: var(--radius-lg); margin-bottom: var(--space-md); box-shadow: var(--shadow-md);"></div>
                    <p class="text-xsmall text-muted mb-xs">WARNING</p>
                    <p style="font-weight: 600; font-size: 0.875rem;">#F59E0B</p>
                </div>

                <!-- Danger -->
                <div>
                    <div style="width: 100%; aspect-ratio: 1; background-color: var(--color-danger); border-radius: var(--radius-lg); margin-bottom: var(--space-md); box-shadow: var(--shadow-md);"></div>
                    <p class="text-xsmall text-muted mb-xs">DANGER</p>
                    <p style="font-weight: 600; font-size: 0.875rem;">#EF4444</p>
                </div>

                <!-- Info -->
                <div>
                    <div style="width: 100%; aspect-ratio: 1; background-color: var(--color-info); border-radius: var(--radius-lg); margin-bottom: var(--space-md); box-shadow: var(--shadow-md);"></div>
                    <p class="text-xsmall text-muted mb-xs">INFO</p>
                    <p style="font-weight: 600; font-size: 0.875rem;">#3B82F6</p>
                </div>

                <!-- Text Primary -->
                <div>
                    <div style="width: 100%; aspect-ratio: 1; background-color: var(--color-text-primary); border-radius: var(--radius-lg); margin-bottom: var(--space-md); box-shadow: var(--shadow-md);"></div>
                    <p class="text-xsmall text-muted mb-xs">TEXT PRIMARY</p>
                    <p style="font-weight: 600; font-size: 0.875rem;">#1F2937</p>
                </div>

                <!-- Border Light -->
                <div>
                    <div style="width: 100%; aspect-ratio: 1; background-color: var(--color-border-light); border-radius: var(--radius-lg); margin-bottom: var(--space-md); box-shadow: var(--shadow-md);"></div>
                    <p class="text-xsmall text-muted mb-xs">BORDER</p>
                    <p style="font-weight: 600; font-size: 0.875rem;">#E5E7EB</p>
                </div>

                <!-- Background -->
                <div>
                    <div style="width: 100%; aspect-ratio: 1; background-color: var(--color-bg-secondary); border-radius: var(--radius-lg); margin-bottom: var(--space-md); box-shadow: var(--shadow-md); border: 1px solid var(--color-border-light);"></div>
                    <p class="text-xsmall text-muted mb-xs">BACKGROUND</p>
                    <p style="font-weight: 600; font-size: 0.875rem;">#F8FAFB</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Grid Demo -->
    <div class="card mb-2xl">
        <div class="card-header">
            <h3 class="mb-0">Responsive Grid System</h3>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-4 gap-lg" style="margin-bottom: var(--space-lg);">
                <div style="background-color: var(--color-primary-bg); padding: var(--space-lg); border-radius: var(--radius-md); text-align: center;">Grid Item 1</div>
                <div style="background-color: var(--color-primary-bg); padding: var(--space-lg); border-radius: var(--radius-md); text-align: center;">Grid Item 2</div>
                <div style="background-color: var(--color-primary-bg); padding: var(--space-lg); border-radius: var(--radius-md); text-align: center;">Grid Item 3</div>
                <div style="background-color: var(--color-primary-bg); padding: var(--space-lg); border-radius: var(--radius-md); text-align: center;">Grid Item 4</div>
            </div>
            <p class="text-secondary text-small">Grid automatically adjusts on mobile: 4 columns on desktop → 2 on tablet → 1 on mobile</p>
        </div>
    </div>
</div>

<style>
    .grid-cols-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
    
    .grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
    
    .grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    
    @media (max-width: 1200px) {
        .grid-cols-4 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .grid-cols-3 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    
    @media (max-width: 768px) {
        .grid-cols-4 {
            grid-template-columns: 1fr;
        }
        
        .grid-cols-3 {
            grid-template-columns: 1fr;
        }
        
        .grid-cols-2 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
