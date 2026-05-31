<?php

declare(strict_types=1);

use Smalot\PdfParser\Parser;

class CvSkillAnalyzer
{
    private array $skillDictionary = [
        'php' => ['php', 'core php', 'laravel', 'codeigniter', 'symfony'],
        'mysql' => ['mysql', 'mariadb', 'sql', 'sql queries', 'database design'],
        'html' => ['html', 'html5'],
        'css' => ['css', 'css3', 'bootstrap', 'tailwind'],
        'javascript' => ['javascript', 'js', 'ecmascript', 'jquery', 'ajax'],
        'git' => ['git', 'github', 'gitlab', 'version control'],
        'oop' => ['oop', 'object oriented programming'],
        'mvc' => ['mvc', 'model view controller'],
        'rest api' => ['rest api', 'restful api', 'api integration'],
        'communication' => ['communication', 'written communication', 'verbal communication'],
        'problem solving' => ['problem solving', 'analytical thinking', 'critical thinking'],
        'debugging' => ['debugging', 'troubleshooting'],
    ];

    private array $jobSkillMap = [
        'php developer' => ['php', 'mysql', 'html', 'css', 'javascript', 'git', 'oop', 'mvc', 'rest api', 'debugging'],
        'backend developer' => ['php', 'mysql', 'rest api', 'git', 'oop', 'mvc', 'debugging', 'problem solving'],
        'frontend developer' => ['html', 'css', 'javascript', 'git', 'rest api', 'problem solving', 'communication'],
        'full stack developer' => ['php', 'mysql', 'html', 'css', 'javascript', 'git', 'rest api', 'oop', 'mvc', 'problem solving'],
        'web developer' => ['php', 'mysql', 'html', 'css', 'javascript', 'git', 'debugging'],
    ];

    public function analyze(string $pdfPath, string $targetJob, string $jobDescription = ''): array
    {
        $cvText = $this->extractTextFromPdf($pdfPath);
        $normalizedCvText = $this->normalizeText($cvText);
        $normalizedJobText = $this->normalizeText($targetJob . ' ' . $jobDescription);

        $cvSkills = $this->detectSkills($normalizedCvText);
        $targetSkills = $this->resolveTargetSkills($targetJob, $normalizedJobText);

        $missingSkills = array_values(array_diff($targetSkills, $cvSkills));
        $matchedSkills = array_values(array_intersect($targetSkills, $cvSkills));

        $matchPercentage = count($targetSkills) > 0
            ? round((count($matchedSkills) / count($targetSkills)) * 100, 2)
            : 0;

        return [
            'target_job' => $targetJob,
            'cv_skills' => $cvSkills,
            'target_skills' => $targetSkills,
            'matched_skills' => $matchedSkills,
            'missing_skills' => $missingSkills,
            'match_percentage' => $matchPercentage,
        ];
    }

    private function extractTextFromPdf(string $pdfPath): string
    {
        if (!file_exists($pdfPath)) {
            throw new RuntimeException('PDF file not found.');
        }

        $parser = new Parser();
        $pdf = $parser->parseFile($pdfPath);
        $text = $pdf->getText();

        if (trim($text) === '') {
            throw new RuntimeException('No readable text found in PDF.');
        }

        return $text;
    }

    private function normalizeText(string $text): string
    {
        $text = mb_strtolower($text);
        $text = preg_replace('/[^\p{L}\p{N}\s\+\.\-#]/u', ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    private function detectSkills(string $text): array
    {
        $detected = [];

        foreach ($this->skillDictionary as $mainSkill => $keywords) {
            foreach ($keywords as $keyword) {
                if ($this->containsWholeTerm($text, $keyword)) {
                    $detected[] = $mainSkill;
                    break;
                }
            }
        }

        sort($detected);
        return array_values(array_unique($detected));
    }

    private function resolveTargetSkills(string $targetJob, string $jobText): array
    {
        $normalizedJobTitle = $this->normalizeText($targetJob);
        $roleSkills = [];

        foreach ($this->jobSkillMap as $role => $skills) {
            if (str_contains($normalizedJobTitle, $role)) {
                $roleSkills = array_merge($roleSkills, $skills);
            }
        }

        $descriptionSkills = $this->detectSkills($jobText);
        $targetSkills = array_values(array_unique(array_merge($roleSkills, $descriptionSkills)));

        sort($targetSkills);
        return $targetSkills;
    }

    private function containsWholeTerm(string $text, string $term): bool
    {
        $escaped = preg_quote($term, '/');
        return (bool) preg_match('/(?<!\w)' . $escaped . '(?!\w)/u', $text);
    }
}
