<?php

declare(strict_types=1);

namespace App\Services;

class SEOComplianceService
{
    /**
     * Validate SEO compliance for a post
     */
    public static function validateCompliance(string $title, string $content, ?string $focusKeyword = null): array
    {
        $checks = [
            'title_length' => self::checkTitleLength($title),
            'has_h2_tag' => self::checkH2TagPresence($content),
            'focus_keyword_in_title' => self::checkFocusKeywordInTitle($title, $focusKeyword),
            'focus_keyword_in_first_paragraph' => self::checkFocusKeywordInFirstParagraph($content, $focusKeyword),
            'word_count' => self::checkWordCount($content),
        ];

        $overallScore = self::calculateOverallScore($checks);
        $complianceLevel = self::getComplianceLevel($overallScore);

        return [
            'checks' => $checks,
            'overall_score' => $overallScore,
            'compliance_level' => $complianceLevel,
            'total_checks' => count($checks),
            'passed_checks' => count(array_filter($checks, fn($check) => $check['passed'])),
        ];
    }

    /**
     * Check title length (50-60 characters)
     */
    private static function checkTitleLength(string $title): array
    {
        $length = strlen($title);
        $passed = $length >= 50 && $length <= 60;
        
        return [
            'passed' => $passed,
            'message' => $passed 
                ? "Title length is optimal ({$length} chars)" 
                : "Title should be 50-60 characters (currently {$length} chars)",
            'status' => $passed ? 'success' : ($length < 50 ? 'warning' : 'error'),
            'current_value' => $length,
            'target_range' => '50-60'
        ];
    }

    /**
     * Check presence of at least one H2 tag
     */
    private static function checkH2TagPresence(string $content): array
    {
        $hasH2 = preg_match('/<h2[^>]*>/i', $content);
        $h2Count = preg_match_all('/<h2[^>]*>/i', $content);
        
        return [
            'passed' => $hasH2,
            'message' => $hasH2 
                ? "Found {$h2Count} H2 tag(s)" 
                : "No H2 tags found - add at least one H2 tag",
            'status' => $hasH2 ? 'success' : 'error',
            'current_value' => $h2Count,
            'target_range' => '1+'
        ];
    }

    /**
     * Check if focus keyword is present in title
     */
    private static function checkFocusKeywordInTitle(string $title, ?string $focusKeyword): array
    {
        if (empty($focusKeyword)) {
            return [
                'passed' => false,
                'message' => "No focus keyword specified",
                'status' => 'warning',
                'current_value' => 'N/A',
                'target_range' => 'Present'
            ];
        }

        $keywordPresent = stripos($title, $focusKeyword) !== false;
        
        return [
            'passed' => $keywordPresent,
            'message' => $keywordPresent 
                ? "Focus keyword '{$focusKeyword}' found in title" 
                : "Focus keyword '{$focusKeyword}' not found in title",
            'status' => $keywordPresent ? 'success' : 'error',
            'current_value' => $keywordPresent ? 'Yes' : 'No',
            'target_range' => 'Yes'
        ];
    }

    /**
     * Check if focus keyword is present in first paragraph
     */
    private static function checkFocusKeywordInFirstParagraph(string $content, ?string $focusKeyword): array
    {
        if (empty($focusKeyword)) {
            return [
                'passed' => false,
                'message' => "No focus keyword specified",
                'status' => 'warning',
                'current_value' => 'N/A',
                'target_range' => 'Present'
            ];
        }

        // Extract first paragraph (text before first double newline or closing p tag)
        $firstParagraph = '';
        if (preg_match('/^(.*?)(?:\n\n|<\/p>)/is', $content, $matches)) {
            $firstParagraph = strip_tags($matches[1]);
        } else {
            // Fallback: first 200 characters
            $firstParagraph = strip_tags(substr($content, 0, 200));
        }

        $keywordPresent = stripos($firstParagraph, $focusKeyword) !== false;
        
        return [
            'passed' => $keywordPresent,
            'message' => $keywordPresent 
                ? "Focus keyword '{$focusKeyword}' found in first paragraph" 
                : "Focus keyword '{$focusKeyword}' not found in first paragraph",
            'status' => $keywordPresent ? 'success' : 'error',
            'current_value' => $keywordPresent ? 'Yes' : 'No',
            'target_range' => 'Yes'
        ];
    }

    /**
     * Check word count (300+ words)
     */
    private static function checkWordCount(string $content): array
    {
        $cleanContent = strip_tags($content);
        $wordCount = str_word_count($cleanContent);
        $passed = $wordCount >= 300;
        
        return [
            'passed' => $passed,
            'message' => $passed 
                ? "Word count is sufficient ({$wordCount} words)" 
                : "Word count should be at least 300 words (currently {$wordCount} words)",
            'status' => $passed ? 'success' : ($wordCount >= 200 ? 'warning' : 'error'),
            'current_value' => $wordCount,
            'target_range' => '300+'
        ];
    }

    /**
     * Calculate overall SEO score
     */
    private static function calculateOverallScore(array $checks): int
    {
        $totalChecks = count($checks);
        $passedChecks = count(array_filter($checks, fn($check) => $check['passed']));
        
        return (int) round(($passedChecks / $totalChecks) * 100);
    }

    /**
     * Get compliance level based on score
     */
    private static function getComplianceLevel(int $score): string
    {
        return match(true) {
            $score >= 80 => 'Excellent',
            $score >= 60 => 'Good',
            $score >= 40 => 'Fair',
            $score >= 20 => 'Poor',
            default => 'Very Poor'
        };
    }

    /**
     * Get compliance level color
     */
    public static function getComplianceColor(string $level): string
    {
        return match($level) {
            'Excellent' => '#28a745',
            'Good' => '#17a2b8',
            'Fair' => '#ffc107',
            'Poor' => '#fd7e14',
            'Very Poor' => '#dc3545',
            default => '#6c757d'
        };
    }
}
