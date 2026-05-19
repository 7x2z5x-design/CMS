<?php

namespace App\Services;

class HeadingAnalysisService
{
    /**
     * Analyze heading structure in post content
     */
    public static function analyzeHeadings($content)
    {
        // Extract all heading tags
        preg_match_all('/<h([1-6])[^>]*>(.*?)<\/h[1-6]>/i', $content, $matches);
        
        $headings = [];
        $counts = ['h1' => 0, 'h2' => 0, 'h3' => 0, 'h4' => 0, 'h5' => 0, 'h6' => 0];
        
        if (!empty($matches[1])) {
            foreach ($matches[1] as $index => $level) {
                $text = strip_tags($matches[2][$index]);
                $headings[] = $level . ': ' . $text;
                $counts['h' . $level]++;
            }
        }
        
        $issues = [];
        
        // Check for proper heading hierarchy
        $lastLevel = 0;
        foreach ($headings as $heading) {
            $level = (int)$heading[0];
            if ($level < $lastLevel) {
                $issues[] = "H{$level} used before H{$lastLevel}";
            } elseif ($level > $lastLevel + 1) {
                $issues[] = "H{$level} used after H{$lastLevel}";
            }
            $lastLevel = $level;
        }
        
        return [
            'headings' => $headings,
            'counts' => $counts,
            'issues' => $issues
        ];
    }
}
