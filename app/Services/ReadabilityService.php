<?php

namespace App\Services;

class ReadabilityService
{
    /**
     * Calculate readability score based on Flesch Reading Ease formula
     */
    public static function calculateScore($text)
    {
        if (empty($text)) {
            return 0;
        }

        // Count sentences, words, and syllables
        $sentences = preg_match_all('/[.!?]+/', $text, $matches) ? count($matches[0]) : 1;
        $words = str_word_count($text);
        $syllables = 0;
        
        // Count syllables in each word (improved approximation)
        foreach (str_word_count($text, 1) as $word) {
            $word = strtolower($word);
            $syllableCount = 0;
            
            // Count vowel groups
            $syllableCount += preg_match_all('/[aeiouy]+/', $word, $matches);
            
            // Subtract 1 for silent 'e' at the end
            if (preg_match('/[^aeiou]e$/', $word)) {
                $syllableCount--;
            }
            
            // Ensure at least 1 syllable
            $syllables += max(1, $syllableCount);
        }
        
        // Calculate average words per sentence
        $avgWordsPerSentence = $sentences > 0 ? $words / $sentences : $words;
        
        // Calculate average syllables per word
        $avgSyllablesPerWord = $words > 0 ? $syllables / $words : 0;
        
        // Flesch Reading Ease Score (simplified formula)
        $score = 206.835 - (1.015 * $avgWordsPerSentence) - (84.6 * $avgSyllablesPerWord);
        
        // Ensure score is between 0-100
        return max(0, min(100, round($score)));
    }

    /**
     * Get comprehensive readability analysis
     */
    public static function analyzeText($text)
    {
        if (empty($text)) {
            return [
                'score' => 0,
                'word_count' => 0,
                'sentence_count' => 0,
                'difficulty' => 'Very Easy',
                'difficulty_color' => '#28a745',
                'avg_words_per_sentence' => 0,
                'character_count' => 0
            ];
        }

        $score = self::calculateScore($text);
        $wordCount = str_word_count($text);
        $sentenceCount = preg_match_all('/[.!?]+/', $text, $matches) ? count($matches[0]) : 1;
        $characterCount = strlen($text);
        $avgWordsPerSentence = $sentenceCount > 0 ? round($wordCount / $sentenceCount, 1) : 0;

        return [
            'score' => $score,
            'word_count' => $wordCount,
            'sentence_count' => $sentenceCount,
            'character_count' => $characterCount,
            'avg_words_per_sentence' => $avgWordsPerSentence,
            'difficulty' => self::getDifficultyLabel($score),
            'difficulty_color' => self::getDifficultyColor($score)
        ];
    }

    /**
     * Get difficulty label based on score
     */
    private static function getDifficultyLabel($score)
    {
        if ($score >= 90) return 'Very Easy';
        if ($score >= 80) return 'Easy';
        if ($score >= 70) return 'Fairly Easy';
        if ($score >= 60) return 'Standard';
        if ($score >= 50) return 'Fairly Difficult';
        if ($score >= 30) return 'Difficult';
        return 'Very Difficult';
    }

    /**
     * Get difficulty color based on score
     */
    private static function getDifficultyColor($score)
    {
        if ($score >= 80) return '#28a745'; // Green
        if ($score >= 60) return '#ffc107'; // Yellow
        if ($score >= 40) return '#fd7e14'; // Orange
        return '#dc3545'; // Red
    }
}
