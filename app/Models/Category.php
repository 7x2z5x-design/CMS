<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    // Category group constants
    const GROUP_BLOG_ARTICLES = 'Blog & Articles';
    const GROUP_MEDIA_CONTENT = 'Media & Content';
    const GROUP_PRODUCTS_SERVICES = 'Products & Services';
    const GROUP_EVENTS = 'Events';
    const GROUP_PORTFOLIO_PROJECTS = 'Portfolio & Projects';
    const GROUP_KNOWLEDGE_BASE = 'Knowledge Base / Docs';
    const GROUP_COMMUNITY_SOCIAL = 'Community & Social';
    const GROUP_JOBS_CAREERS = 'Jobs & Careers';
    const GROUP_COURSES_LEARNING = 'Courses & Learning';
    const GROUP_CUSTOM = 'Custom / Uncategorized';

    // All category groups
    const CATEGORY_GROUPS = [
        self::GROUP_BLOG_ARTICLES => [
            'News', 'Tutorials', 'How-To Guides', 'Opinion', 'Case Studies', 'Press Releases'
        ],
        self::GROUP_MEDIA_CONTENT => [
            'Videos', 'Podcasts', 'Infographics', 'Galleries', 'Webinars', 'E-books'
        ],
        self::GROUP_PRODUCTS_SERVICES => [
            'Physical Products', 'Digital Products', 'Services', 'Subscriptions', 'Bundles'
        ],
        self::GROUP_EVENTS => [
            'Conferences', 'Webinars', 'Workshops', 'Meetups', 'Online Events'
        ],
        self::GROUP_PORTFOLIO_PROJECTS => [
            'Web Design', 'App Development', 'Branding', 'Photography', 'Case Studies'
        ],
        self::GROUP_KNOWLEDGE_BASE => [
            'FAQs', 'Guides', 'API Docs', 'Release Notes', 'Troubleshooting'
        ],
        self::GROUP_COMMUNITY_SOCIAL => [
            'Forums', 'Announcements', 'Q&A', 'User Stories', 'Discussions'
        ],
        self::GROUP_JOBS_CAREERS => [
            'Full-time', 'Part-time', 'Remote', 'Freelance', 'Internship'
        ],
        self::GROUP_COURSES_LEARNING => [
            'Free Courses', 'Paid Courses', 'Certifications', 'Workshops', 'Quizzes'
        ],
        self::GROUP_CUSTOM => [
            'Miscellaneous', 'Drafts', 'Archived'
        ],
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'category_group',
        'color',
        'post_count',
        'status',
        'seo_title',
        'seo_description',
        'featured_image',
    ];

    protected $casts = [
        'post_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get parent category.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get child categories.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get posts for category.
     */
    public function posts()
    {
        return $this->belongsToMany(Content::class, 'category_content');
    }

    /**
     * Get post count attribute.
     */
    public function getPostCountAttribute(): int
    {
        return $this->attributes['post_count'] ?? 0;
    }

    /**
     * Scope to get active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get inactive categories.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope to get root categories (no parent).
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get status badge HTML.
     */
    public function getStatusBadgeAttribute(): string
    {
        if ($this->status === 'active') {
            return '<span class="status-badge active">Active</span>';
        }
        
        return '<span class="status-badge inactive">Inactive</span>';
    }

    /**
     * Get color dot HTML.
     */
    public function getColorDotAttribute(): string
    {
        $color = $this->color ?? '#6B7B3A';
        return '<div class="color-dot" style="background-color: ' . $color . ';"></div>';
    }

    /**
     * Check if category has posts.
     */
    public function hasPosts(): bool
    {
        return $this->post_count > 0;
    }

    /**
     * Get formatted created date.
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('M d, Y');
    }

    /**
     * Get category hierarchy path.
     */
    public function getHierarchyPathAttribute(): string
    {
        $path = [];
        $current = $this;
        
        while ($current) {
            array_unshift($path, $current->name);
            $current = $current->parent;
        }
        
        return implode(' > ', $path);
    }

    /**
     * Get category depth level.
     */
    public function getDepthAttribute(): int
    {
        $depth = 0;
        $current = $this->parent;
        
        while ($current) {
            $depth++;
            $current = $current->parent;
        }
        
        return $depth;
    }

    /**
     * Get all descendants (children, grandchildren, etc.).
     */
    public function descendants(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->with('descendants');
    }

    /**
     * Check if category has children.
     */
    public function hasChildren(): bool
    {
        return $this->children()->count() > 0;
    }

    /**
     * Get category group icon.
     */
    public function getGroupIconAttribute(): string
    {
        $icons = [
            self::GROUP_BLOG_ARTICLES => 'ph ph-article',
            self::GROUP_MEDIA_CONTENT => 'ph ph-video',
            self::GROUP_PRODUCTS_SERVICES => 'ph ph-shopping-cart',
            self::GROUP_EVENTS => 'ph ph-calendar',
            self::GROUP_PORTFOLIO_PROJECTS => 'ph ph-briefcase',
            self::GROUP_KNOWLEDGE_BASE => 'ph ph-book',
            self::GROUP_COMMUNITY_SOCIAL => 'ph ph-users',
            self::GROUP_JOBS_CAREERS => 'ph ph-briefcase',
            self::GROUP_COURSES_LEARNING => 'ph ph-graduation-cap',
            self::GROUP_CUSTOM => 'ph ph-folder',
        ];

        return $icons[$this->category_group] ?? 'ph ph-folder';
    }

    /**
     * Get category group color.
     */
    public function getGroupColorAttribute(): string
    {
        $colors = [
            self::GROUP_BLOG_ARTICLES => '#6B7B3A',
            self::GROUP_MEDIA_CONTENT => '#8B5CF6',
            self::GROUP_PRODUCTS_SERVICES => '#F59E0B',
            self::GROUP_EVENTS => '#EF4444',
            self::GROUP_PORTFOLIO_PROJECTS => '#3B82F6',
            self::GROUP_KNOWLEDGE_BASE => '#10B981',
            self::GROUP_COMMUNITY_SOCIAL => '#F97316',
            self::GROUP_JOBS_CAREERS => '#06B6D4',
            self::GROUP_COURSES_LEARNING => '#8B5CF6',
            self::GROUP_CUSTOM => '#6B7280',
        ];

        return $colors[$this->category_group] ?? '#6B7280';
    }

    /**
     * Scope to get categories by group.
     */
    public function scopeByGroup($query, $group)
    {
        return $query->where('category_group', $group);
    }

    /**
     * Scope to get categories ordered by name and id.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Get category count by group.
     */
    public static function getCountByGroup(): array
    {
        $counts = [];
        
        foreach (self::CATEGORY_GROUPS as $group => $categories) {
            $counts[$group] = self::where('category_group', $group)->count();
        }
        
        return $counts;
    }

    /**
     * Update post count for category and its children.
     */
    public function updatePostCount(): void
    {
        // Update current category post count
        $this->post_count = $this->posts()->count();
        $this->save();
        
        // Update parent categories
        $parent = $this->parent;
        while ($parent) {
            $parent->post_count = $parent->posts()->count() + $parent->children()->sum('post_count');
            $parent->save();
            $parent = $parent->parent;
        }
    }
}
