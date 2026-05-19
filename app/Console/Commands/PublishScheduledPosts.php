<?php

namespace App\Console\Commands;

use App\Models\Content;
use App\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PublishScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-scheduled-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled posts when their scheduled time arrives';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for scheduled posts to publish...');

        // Find posts that are scheduled to be published now or in the past
        $scheduledPosts = Content::where('status', 'scheduled')
            ->where('scheduled_at', '<=', now())
            ->get();

        if ($scheduledPosts->isEmpty()) {
            $this->info('No scheduled posts to publish.');
            return 0;
        }

        $publishedCount = 0;
        foreach ($scheduledPosts as $post) {
            try {
                // Update the post status to published
                $post->update([
                    'status' => 'published',
                    'published_at' => now(),
                    'scheduled_at' => null, // Clear the scheduled timestamp
                ]);

                // Create notification for the author
                Notification::create([
                    'user_id' => $post->user_id,
                    'title' => 'Post Published Automatically',
                    'message' => "Your post '{$post->title}' has been automatically published as scheduled.",
                    'type' => 'success',
                    'read' => false,
                ]);

                $this->info("Published: {$post->title}");
                $publishedCount++;
            } catch (\Exception $e) {
                $this->error("Failed to publish post ID {$post->id}: {$e->getMessage()}");
                Log::error("Failed to publish scheduled post", [
                    'post_id' => $post->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->info("Successfully published {$publishedCount} scheduled posts.");
        return 0;
    }
}
