<?php
$recommendedJobs = [];
$error = '';

$jobSkillMap = [
    [
        'title' => 'PHP Developer',
        'description' => 'Build dynamic web applications and handle backend logic.',
        'skills' => ['php', 'mysql', 'html', 'css', 'javascript', 'git', 'mvc'],
    ],
    [
        'title' => 'Frontend Developer',
        'description' => 'Create responsive user interfaces and interactive web experiences.',
        'skills' => ['html', 'css', 'javascript', 'bootstrap', 'react', 'ui design'],
    ],
    [
        'title' => 'Backend Developer',
        'description' => 'Develop APIs, business logic, and database-driven systems.',
        'skills' => ['php', 'mysql', 'api', 'git', 'oop', 'laravel'],
    ],
    [
        'title' => 'Full Stack Developer',
        'description' => 'Work on both frontend and backend parts of web applications.',
        'skills' => ['php', 'mysql', 'html', 'css', 'javascript', 'api', 'git'],
    ],
    [
        'title' => 'WordPress Developer',
        'description' => 'Build and customize WordPress websites, themes, and plugins.',
        'skills' => ['wordpress', 'php', 'html', 'css', 'javascript', 'mysql'],
    ],
    [
        'title' => 'UI/UX Designer',
        'description' => 'Design interfaces, improve user experience, and create wireframes.',
        'skills' => ['figma', 'ui design', 'ux', 'wireframe', 'prototype'],
    ],
    [
        'title' => 'Software Tester',
        'description' => 'Test applications, report bugs, and improve software quality.',
        'skills' => ['testing', 'qa', 'bug reporting', 'manual testing'],
    ],
    [
        'title' => 'Data Entry Specialist',
        'description' => 'Handle records, organize data, and maintain digital information.',
        'skills' => ['excel', 'typing', 'data entry', 'communication'],
    ],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skillsInput = trim($_POST['skills'] ?? '');

    if ($skillsInput === '') {
        $error = 'Please enter your current skills.';
    } else {
        $userSkills = array_filter(array_map('trim', explode(',', strtolower($skillsInput))));
        $userSkills = array_values(array_unique($userSkills));

        foreach ($jobSkillMap as $job) {
            $matchedSkills = array_values(array_intersect($userSkills, $job['skills']));
            $matchCount = count($matchedSkills);
            $totalSkills = count($job['skills']);
            $matchPercentage = $totalSkills > 0 ? round(($matchCount / $totalSkills) * 100) : 0;

            if ($matchCount > 0) {
                $recommendedJobs[] = [
                    'title' => $job['title'],
                    'description' => $job['description'],
                    'matched_skills' => $matchedSkills,
                    'missing_skills' => array_values(array_diff($job['skills'], $userSkills)),
                    'match_percentage' => $matchPercentage,
                ];
            }
        }

        usort($recommendedJobs, function ($a, $b) {
            return $b['match_percentage'] <=> $a['match_percentage'];
        });
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Recommendation | Skill Gap AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --navy: #0b1730;
            --navy-2: #102240;
            --navy-3: #163055;
            --navy-4: #1b3c69;
            --blue: #3b82f6;
            --blue-light: #67d4ff;
            --white: #ffffff;
            --text-light: #eef4ff;
            --text-soft: #9fb3d3;
            --text-dark-soft: #c4d4ee;
            --border-light: rgba(120, 170, 255, 0.14);
            --border-soft: rgba(255, 255, 255, 0.08);
            --success-bg: rgba(34, 197, 94, 0.16);
            --success-text: #8cf0b5;
            --danger-bg: rgba(255, 99, 132, 0.14);
            --danger-text: #ffb8c7;
            --chip-match-bg: rgba(59, 130, 246, 0.14);
            --chip-match-text: #b7d2ff;
            --chip-missing-bg: rgba(255, 99, 132, 0.16);
            --chip-missing-text: #ffc3d1;
            --shadow-main: 0 18px 45px rgba(0, 0, 0, 0.25);
            --shadow-card: 0 12px 28px rgba(0, 0, 0, 0.20);
            --radius-lg: 22px;
            --radius-md: 16px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(103, 212, 255, 0.08), transparent 24%),
                radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.08), transparent 28%),
                linear-gradient(180deg, #081322 0%, #0d1d36 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-light);
        }

        .topbar {
            background: linear-gradient(135deg, #091324, #102240);
            padding: 12px 0;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.20);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-box {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--blue), var(--blue-light));
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .brand-text {
            color: white;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .btn-top {
            border: 1px solid rgba(255,255,255,0.14);
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 999px;
            font-weight: 600;
            transition: 0.2s ease;
            background: rgba(255,255,255,0.04);
        }

        .btn-top:hover {
            color: white;
            background: rgba(255,255,255,0.10);
        }

        .page-wrap {
            padding: 28px 0 40px;
        }

        .page-header {
            margin-bottom: 20px;
        }

        .page-title {
            margin-bottom: 6px;
            font-weight: 800;
            color: var(--text-light);
        }

        .page-subtitle {
            margin: 0;
            color: var(--text-soft);
        }

        .layout-grid {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 22px;
            align-items: start;
        }

        .sidebar-card,
        .results-panel {
            background: linear-gradient(180deg, rgba(16, 34, 64, 0.96), rgba(11, 23, 48, 0.98));
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-main);
        }

        .sidebar-card {
            padding: 22px;
            position: sticky;
            top: 20px;
        }

        .sidebar-title {
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--text-light);
        }

        .sidebar-subtitle {
            color: var(--text-soft);
            font-size: 14px;
            margin-bottom: 18px;
            line-height: 1.6;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 10px;
        }

        .form-control {
            border-radius: var(--radius-md);
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255,255,255,0.04);
            color: white;
            padding: 14px 16px;
        }

        .form-control::placeholder {
            color: #93a8c8;
        }

        .form-control:focus {
            border-color: rgba(103, 212, 255, 0.30);
            background: rgba(255,255,255,0.06);
            color: white;
            box-shadow: 0 0 0 4px rgba(103, 212, 255, 0.08);
        }

        .helper-box {
            margin-top: 14px;
            padding: 14px 16px;
            border-radius: var(--radius-md);
            background: rgba(255,255,255,0.04);
            color: var(--text-soft);
            font-size: 13px;
            line-height: 1.6;
            border: 1px solid rgba(255,255,255,0.06);
        }

        .btn-main {
            width: 100%;
            border: none;
            border-radius: 14px;
            padding: 13px 18px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--blue), #2563eb);
            color: white;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.22);
            transition: 0.22s ease;
        }

        .btn-main:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 24px rgba(37, 99, 235, 0.28);
        }

        .btn-reset {
            width: 100%;
            display: inline-block;
            text-align: center;
            text-decoration: none;
            border-radius: 14px;
            padding: 12px 18px;
            font-weight: 600;
            border: 1px solid rgba(255,255,255,0.10);
            background: rgba(255,255,255,0.03);
            color: white;
            transition: 0.2s ease;
        }

        .btn-reset:hover {
            background: rgba(255,255,255,0.08);
            color: white;
        }

        .alert-box {
            background: var(--danger-bg);
            color: var(--danger-text);
            border: 1px solid rgba(255, 99, 132, 0.12);
            border-radius: 14px;
            padding: 12px 14px;
            margin-bottom: 14px;
            font-size: 14px;
        }

        .results-panel {
            padding: 22px;
            min-height: 520px;
        }

        .results-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .results-top h4 {
            margin: 0 0 4px;
            font-weight: 700;
            color: var(--text-light);
        }

        .results-top p {
            margin: 0;
            color: var(--text-soft);
        }

        .result-count {
            display: inline-block;
            padding: 9px 14px;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.14);
            color: #b7d2ff;
            font-weight: 700;
            font-size: 14px;
            border: 1px solid rgba(59, 130, 246, 0.12);
        }

        .job-list {
            display: grid;
            gap: 16px;
        }

        .job-card {
            border: 1px solid var(--border-soft);
            border-radius: 18px;
            padding: 20px;
            background: linear-gradient(180deg, rgba(22, 48, 85, 0.92), rgba(16, 34, 64, 0.96));
            box-shadow: var(--shadow-card);
            transition: 0.22s ease;
        }

        .job-card:hover {
            transform: translateY(-3px);
            border-color: rgba(103, 212, 255, 0.18);
        }

        .job-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 14px;
        }

        .job-left {
            display: flex;
            gap: 12px;
        }

        .job-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.18), rgba(103, 212, 255, 0.14));
            color: #9fd8ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .job-title {
            margin-bottom: 4px;
            font-weight: 700;
            color: var(--text-light);
        }

        .job-desc {
            margin: 0;
            color: var(--text-dark-soft);
            font-size: 14px;
            line-height: 1.6;
        }

        .match-pill {
            white-space: nowrap;
            background: var(--success-bg);
            color: var(--success-text);
            border-radius: 999px;
            padding: 8px 13px;
            font-weight: 700;
            font-size: 14px;
            border: 1px solid rgba(34, 197, 94, 0.10);
        }

        .skill-block {
            margin-top: 14px;
        }

        .skill-block h6 {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 10px;
        }

        .chip {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            margin: 4px 6px 0 0;
        }

        .chip-match {
            background: var(--chip-match-bg);
            color: var(--chip-match-text);
        }

        .chip-missing {
            background: var(--chip-missing-bg);
            color: var(--chip-missing-text);
        }

        .welcome-box,
        .empty-box {
            border: 1px dashed rgba(255,255,255,0.10);
            border-radius: 18px;
            padding: 28px;
            background: rgba(255,255,255,0.03);
            text-align: center;
        }

        .welcome-box h5,
        .empty-box h5 {
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 8px;
        }

        .welcome-box p,
        .empty-box p {
            color: var(--text-soft);
            margin-bottom: 0;
            line-height: 1.7;
        }

        .footer-text {
            color: var(--text-soft);
        }

        @media (max-width: 991px) {
            .layout-grid {
                grid-template-columns: 1fr;
            }

            .sidebar-card {
                position: static;
            }
        }
    </style>
</head>
<body>
    <nav class="topbar">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="brand-wrap">
                <div class="brand-box">AI</div>
                <div class="brand-text">Skill Gap AI</div>
            </div>
            <a href="selection.php" class="btn-top">Back</a>
        </div>
    </nav>

    <main class="container page-wrap">
        <div class="page-header">
            <h2 class="page-title">Job Recommendation</h2>
            <p class="page-subtitle">Enter current skills on the left and view matching jobs on the right.</p>
        </div>

        <div class="layout-grid">
            <aside class="sidebar-card">
                <h4 class="sidebar-title">Current Skills</h4>
                <p class="sidebar-subtitle">Write skills separated by commas to generate job recommendations.</p>

                <?php if ($error): ?>
                    <div class="alert-box">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Skills</label>
                        <textarea
                            name="skills"
                            class="form-control"
                            rows="7"
                            placeholder="Example: php, mysql, html, css, javascript"
                            required
                        ><?php echo htmlspecialchars($_POST['skills'] ?? ''); ?></textarea>
                    </div>

                    <div class="helper-box">
                        Example:
                        <br>
                        php, mysql, html, css, javascript, git
                    </div>

                    <div class="d-grid gap-3 mt-4">
                        <button type="submit" class="btn-main">Recommend Jobs</button>
                        <a href="job.php" class="btn-reset">Reset</a>
                    </div>
                </form>
            </aside>

            <section class="results-panel">
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$error): ?>
                    <div class="results-top">
                        <div>
                            <h4>Recommended Jobs</h4>
                            <p>Jobs are sorted by match percentage.</p>
                        </div>
                        <div class="result-count">
                            <?php echo count($recommendedJobs); ?> Result(s)
                        </div>
                    </div>

                    <?php if (!empty($recommendedJobs)): ?>
                        <div class="job-list">
                            <?php foreach ($recommendedJobs as $job): ?>
                                <div class="job-card">
                                    <div class="job-head">
                                        <div class="job-left">
                                            <div class="job-icon">💼</div>
                                            <div>
                                                <h5 class="job-title"><?php echo htmlspecialchars($job['title']); ?></h5>
                                                <p class="job-desc"><?php echo htmlspecialchars($job['description']); ?></p>
                                            </div>
                                        </div>
                                        <div class="match-pill">
                                            <?php echo htmlspecialchars((string) $job['match_percentage']); ?>%
                                        </div>
                                    </div>

                                    <div class="skill-block">
                                        <h6>Matched Skills</h6>
                                        <?php if (!empty($job['matched_skills'])): ?>
                                            <?php foreach ($job['matched_skills'] as $skill): ?>
                                                <span class="chip chip-match"><?php echo htmlspecialchars($skill); ?></span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p class="text-muted mb-0" style="color:#9fb3d3 !important;">No matched skills.</p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="skill-block">
                                        <h6>Missing Skills</h6>
                                        <?php if (!empty($job['missing_skills'])): ?>
                                            <?php foreach ($job['missing_skills'] as $skill): ?>
                                                <span class="chip chip-missing"><?php echo htmlspecialchars($skill); ?></span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p class="text-muted mb-0" style="color:#9fb3d3 !important;">You already match all required skills.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-box">
                            <h5>No Job Match Found</h5>
                            <p>Try adding broader skills like php, frontend, testing, wordpress, or excel.</p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="welcome-box">
                        <h5>Recommended jobs will appear here</h5>
                        <p>Enter skills in the left panel and click <strong>Recommend Jobs</strong> to see job suggestions, matched skills, and missing skills.</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <footer class="text-center py-4 footer-text">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> Skill Gap AI - Job Recommendation</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
