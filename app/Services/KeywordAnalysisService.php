<?php

namespace App\Services;

class KeywordAnalysisService
{
    /**
     * Analyze keyword usage in text
     * 
     * @param string $text The text to analyze
     * @param string $keyword The keyword to search for
     * @return array Analysis results
     */
    public static function analyzeKeyword(string $text, string $keyword): array
    {
        if (empty(trim($keyword))) {
            return [
                'keyword' => $keyword,
                'in_title' => false,
                'in_content' => false,
                'count' => 0,
                'density' => 0
            ];
        }

        $cleanText = strip_tags($text);
        $cleanKeyword = strtolower(trim($keyword));
        
        // Check if keyword is in title
        $titleContains = stripos($cleanText, $cleanKeyword) !== false;
        
        // Count keyword occurrences in content
        $contentLower = strtolower($cleanText);
        $keywordCount = substr_count($contentLower, $cleanKeyword);
        
        // Calculate total words for density
        $totalWords = str_word_count($cleanText);
        
        // Calculate density percentage
        $density = $totalWords > 0 ? round(($keywordCount / $totalWords) * 100, 2) : 0;
        
        return [
            'keyword' => $keyword,
            'in_title' => $titleContains,
            'in_content' => $keywordCount > 0,
            'count' => $keywordCount,
            'density' => $density
        ];
    }

    /**
     * Get keyword density level
     */
    public static function getDensityLevel(float $density): string
    {
        if ($density >= 3) return 'High';
        if ($density >= 1.5) return 'Medium';
        if ($density >= 0.5) return 'Low';
        return 'Very Low';
    }

    /**
     * Get density color class
     */
    public static function getDensityColor(float $density): string
    {
        if ($density >= 3) return 'text-success'; // Green theme
        if ($density >= 1.5) return 'text-warning';
        return 'text-danger';
    }

    /**
     * Validate keyword input
     */
    public static function validateKeyword(string $keyword): array
    {
        $errors = [];
        
        if (strlen(trim($keyword)) > 255) {
            $errors['keyword'] = 'Focus keyword must not exceed 255 characters.';
        }
        
        if (!empty(trim($keyword)) && strlen($keyword) < 2) {
            $errors['keyword'] = 'Focus keyword must be at least 2 characters long.';
        }
        
        return $errors;
    }
}
