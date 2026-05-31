<?php
session_start();

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/cv_analysis_logic.php';

$error = '';
$result = null;

if (isset($_GET['reset'])) {
    unset($_SESSION['analysis_result']);
    unset($_SESSION['analysis_error']);
    header('Location: wel.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_FILES['cv_pdf']) || $_FILES['cv_pdf']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Please upload a valid PDF file.');
        }

        $fileName = $_FILES['cv_pdf']['name'] ?? '';
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($fileExtension !== 'pdf') {
            throw new Exception('Only PDF files are allowed.');
        }

        $targetJob = trim($_POST['target_job'] ?? '');

        if ($targetJob === '') {
            throw new Exception('Please enter target job.');
        }

        $analyzer = new CvSkillAnalyzer();
        $result = $analyzer->analyze(
            $_FILES['cv_pdf']['tmp_name'],
            $targetJob,
            ''
        );

        $_SESSION['analysis_result'] = $result;
        $_SESSION['analysis_error'] = '';

        header('Location: wel.php?result=1');
        exit;
    } catch (Throwable $e) {
        $_SESSION['analysis_result'] = null;
        $_SESSION['analysis_error'] = $e->getMessage();

        header('Location: wel.php?result=1');
        exit;
    }
}

if (isset($_GET['result'])) {
    $result = $_SESSION['analysis_result'] ?? null;
    $error = $_SESSION['analysis_error'] ?? '';
} else {
    unset($_SESSION['analysis_result']);
    unset($_SESSION['analysis_error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Skill Gap Analyzer</title>
    <style>
        :root {
            --bg: #07111f;
            --bg-2: #0b1730;
            --panel: rgba(10, 21, 42, 0.88);
            --panel-2: rgba(13, 28, 56, 0.92);
            --border: rgba(102, 163, 255, 0.18);
            --line: rgba(77, 132, 255, 0.25);
            --text: #e9f1ff;
            --muted: #8ea4c9;
            --primary: #3b82f6;
            --primary-2: #2563eb;
            --cyan: #22d3ee;
            --green: #22c55e;
            --red: #ef476f;
            --shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
            --glow: 0 0 0 1px rgba(59, 130, 246, 0.12), 0 0 40px rgba(37, 99, 235, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(34, 211, 238, 0.08), transparent 24%),
                radial-gradient(circle at top right, rgba(59, 130, 246, 0.10), transparent 28%),
                linear-gradient(135deg, var(--bg), var(--bg-2));
        }

        .page {
            max-width: 1120px;
            margin: 0 auto;
            padding: 36px 18px 56px;
        }

        .shell {
            background: linear-gradient(180deg, rgba(8, 18, 36, 0.96), rgba(10, 21, 42, 0.92));
            border: 1px solid var(--border);
            border-radius: 28px;
            padding: 30px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .shell::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent 0%, rgba(59, 130, 246, 0.05) 50%, transparent 100%);
            pointer-events: none;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 28px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-mark {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), var(--cyan));
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.32);
            font-size: 24px;
            font-weight: 700;
            color: white;
        }

        .brand-copy h1 {
            margin: 0;
            font-size: 32px;
            line-height: 1.05;
            letter-spacing: -0.8px;
        }

        .brand-copy p {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
            max-width: 620px;
        }

        .tech-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: rgba(11, 23, 48, 0.75);
            color: #b9ceef;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .error {
            background: rgba(239, 71, 111, 0.12);
            color: #ff9bb4;
            border: 1px solid rgba(239, 71, 111, 0.22);
            border-radius: 18px;
            padding: 14px 16px;
            margin-bottom: 22px;
            font-weight: 600;
        }

        .upload-panel {
            background: linear-gradient(180deg, rgba(13, 28, 56, 0.95), rgba(10, 21, 42, 0.94));
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 18px;
            box-shadow: var(--glow);
            margin-bottom: 24px;
        }

        .upload-zone {
            border: 1px dashed rgba(102, 163, 255, 0.30);
            background: linear-gradient(180deg, rgba(12, 24, 48, 0.95), rgba(9, 18, 35, 0.98));
            border-radius: 20px;
            padding: 28px 20px;
            text-align: center;
            transition: 0.25s ease;
        }

        .upload-zone:hover {
            transform: translateY(-2px);
            border-color: rgba(34, 211, 238, 0.45);
            box-shadow: 0 0 30px rgba(34, 211, 238, 0.08);
        }

        .upload-icon {
            width: 78px;
            height: 78px;
            margin: 0 auto 14px;
            border-radius: 22px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.18), rgba(34, 211, 238, 0.16));
            border: 1px solid rgba(102, 163, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7dd3fc;
            font-size: 34px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.05);
        }

        .upload-zone h2 {
            margin: 0 0 8px;
            font-size: 24px;
            letter-spacing: -0.4px;
        }

        .upload-zone p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .or-text {
            margin: 16px 0 14px;
            color: #7f95bb;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .file-wrap {
            position: relative;
            display: inline-flex;
        }

        .file-input {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .btn,
        .file-btn {
            border: none;
            border-radius: 14px;
            padding: 14px 22px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .file-btn,
        .btn-primary {
            color: white;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.28);
        }

        .file-btn:hover,
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 36px rgba(37, 99, 235, 0.36);
            background: linear-gradient(135deg, #4d93ff, #2f6fff);
        }

        .btn-secondary {
            color: #cae0ff;
            background: rgba(18, 34, 66, 0.95);
            border: 1px solid rgba(102, 163, 255, 0.18);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            background: rgba(24, 44, 81, 1);
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.22);
        }

        .selected-file {
            margin-top: 14px;
            color: #8ecbff;
            font-size: 14px;
            font-weight: 600;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .field-card {
            background: linear-gradient(180deg, rgba(12, 24, 48, 0.98), rgba(9, 18, 35, 0.98));
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 20px;
            box-shadow: var(--glow);
            transition: 0.22s ease;
        }

        .field-card:hover {
            transform: translateY(-3px);
            border-color: rgba(34, 211, 238, 0.25);
        }

        .field-label {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .field-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(102, 163, 255, 0.14);
            color: #7dd3fc;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .field-label label {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
        }

        input[type="text"] {
            width: 100%;
            border: 1px solid rgba(102, 163, 255, 0.16);
            background: rgba(7, 17, 31, 0.88);
            color: var(--text);
            border-radius: 14px;
            padding: 14px 15px;
            font-size: 15px;
            outline: none;
            transition: 0.2s ease;
        }

        input[type="text"]::placeholder {
            color: #6780aa;
        }

        input:focus {
            border-color: rgba(34, 211, 238, 0.42);
            box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.08);
            transform: translateY(-1px);
        }

        .hint {
            margin-top: 8px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .actions {
            margin-top: 26px;
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 26px;
        }

        .result-header h2 {
            margin: 0 0 8px;
            font-size: 30px;
            letter-spacing: -0.5px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(19, 35, 65, 0.95);
            border: 1px solid rgba(102, 163, 255, 0.16);
            color: #bdd6fb;
            font-size: 13px;
            font-weight: 700;
        }

        .match-box {
            min-width: 180px;
            background: linear-gradient(135deg, rgba(18, 63, 45, 0.95), rgba(10, 46, 33, 0.98));
            border: 1px solid rgba(34, 197, 94, 0.16);
            border-radius: 22px;
            padding: 18px 22px;
            text-align: center;
            box-shadow: 0 16px 30px rgba(34, 197, 94, 0.10);
        }

        .match-box .small {
            display: block;
            color: #86efac;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .match-box .big {
            color: #dcfce7;
            font-size: 32px;
            font-weight: 800;
            line-height: 1;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .info-card {
            background: linear-gradient(180deg, rgba(12, 24, 48, 0.98), rgba(9, 18, 35, 0.98));
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 22px;
            box-shadow: var(--glow);
            transition: 0.22s ease;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--cyan));
        }

        .info-card:hover {
            transform: translateY(-4px);
            border-color: rgba(34, 211, 238, 0.26);
        }

        .card-head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }

        .card-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(102, 163, 255, 0.14);
            color: #7dd3fc;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .card-head h3 {
            margin: 0;
            font-size: 21px;
        }

        .skill-list {
            margin: 0;
            padding-left: 20px;
        }

        .skill-list li {
            margin-bottom: 10px;
            color: #d6e4fb;
            line-height: 1.45;
        }

        .empty {
            margin: 0;
            color: var(--muted);
            font-style: italic;
        }

        .result-actions {
            margin-top: 28px;
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        @media (max-width: 860px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .brand-copy h1 {
                font-size: 27px;
            }

            .result-header h2 {
                font-size: 26px;
            }
        }

        @media (max-width: 560px) {
            .page {
                padding: 24px 12px 40px;
            }

            .shell {
                padding: 20px;
                border-radius: 22px;
            }

            .btn,
            .file-btn {
                width: 100%;
            }

            .result-actions {
                flex-direction: column;
            }

            .match-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <section class="shell">
            <div class="topbar">
                <div class="brand">
                    <div class="brand-mark">AI</div>
                    <div class="brand-copy">
                        <h1>CV Skill Gap Analyzer</h1>
                        <p>resume parsing, target-role comparison, and missing skill detection.</p>
                    </div>
                </div>

                <div class="tech-badge">System Ready</div>
            </div>

            <?php if ($result === null): ?>
                <?php if ($error !== ''): ?>
                    <div class="error">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <div class="upload-panel">
                    <div class="upload-zone">
                        <div class="upload-icon">⬆</div>
                        <h2>Upload Resume PDF</h2>
                        <p>Select the candidate CV and start a new skill-gap analysis.</p>

                        <div class="or-text">Choose File</div>

                        <div class="file-wrap">
                            <input type="file" id="cv_pdf" name="cv_pdf" class="file-input" accept=".pdf" form="analysisForm" required>
                            <label for="cv_pdf" class="file-btn">Upload PDF</label>
                        </div>

                        <div class="selected-file" id="selectedFile">No file selected</div>
                    </div>
                </div>

                <form method="POST" enctype="multipart/form-data" id="analysisForm" >
                    <div class="form-grid">
                        <div class="field-card">
                            <div class="field-label">
                                <span class="field-icon">T</span>
                                <label for="target_job">Target Job</label>
                            </div>
                            <input
                                type="text"
                                id="target_job"
                                name="target_job"
                                placeholder="Example: PHP Developer"
                                required
                            >
                            <div class="hint">Use a clear role title for better matching.</div>
                        </div>
                    </div>

                    <div class="actions">
                        <button type="submit" class="btn btn-primary">Run Analysis</button>
                    </div>
                </form>
            <?php else: ?>
                <div class="result-header">
                    <div>
                        <h2>Analysis Result</h2>
                        <div class="badge">Target Job: <?php echo htmlspecialchars($result['target_job']); ?></div>
                    </div>

                    <div class="match-box">
                        <span class="small">Overall Match</span>
                        <span class="big"><?php echo htmlspecialchars((string) $result['match_percentage']); ?>%</span>
                    </div>
                </div>

                <div class="grid">
                    <div class="info-card">
                        <div class="card-head">
                            <span class="card-icon">C</span>
                            <h3>CV Skills</h3>
                        </div>
                        <?php if (!empty($result['cv_skills'])): ?>
                            <ul class="skill-list">
                                <?php foreach ($result['cv_skills'] as $skill): ?>
                                    <li><?php echo htmlspecialchars($skill); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="empty">No CV skills detected.</p>
                        <?php endif; ?>
                    </div>

                    <div class="info-card">
                        <div class="card-head">
                            <span class="card-icon">T</span>
                            <h3>Target Skills</h3>
                        </div>
                        <?php if (!empty($result['target_skills'])): ?>
                            <ul class="skill-list">
                                <?php foreach ($result['target_skills'] as $skill): ?>
                                    <li><?php echo htmlspecialchars($skill); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="empty">No target skills detected.</p>
                        <?php endif; ?>
                    </div>

                    <div class="info-card">
                        <div class="card-head">
                            <span class="card-icon">M</span>
                            <h3>Matched Skills</h3>
                        </div>
                        <?php if (!empty($result['matched_skills'])): ?>
                            <ul class="skill-list">
                                <?php foreach ($result['matched_skills'] as $skill): ?>
                                    <li><?php echo htmlspecialchars($skill); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="empty">No matched skills found.</p>
                        <?php endif; ?>
                    </div>

                    <div class="info-card">
                        <div class="card-head">
                            <span class="card-icon">!</span>
                            <h3>Missing Skills</h3>
                        </div>
                        <?php if (!empty($result['missing_skills'])): ?>
                            <ul class="skill-list">
                                <?php foreach ($result['missing_skills'] as $skill): ?>
                                    <li><?php echo htmlspecialchars($skill); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="empty">No missing skills found.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="result-actions">
                    <a href="selection.php?reset=1" class="btn btn-secondary">Back</a>
                    <a href="wel.php?reset=1" class="btn btn-primary">Analyze Another CV</a>
                </div>
            <?php endif; ?>
        </section>
    </div>

    <script>
        const fileInput = document.getElementById('cv_pdf');
        const selectedFile = document.getElementById('selectedFile');

        if (fileInput && selectedFile) {
            fileInput.addEventListener('change', function () {
                if (this.files && this.files.length > 0) {
                    selectedFile.textContent = 'Selected: ' + this.files[0].name;
                } else {
                    selectedFile.textContent = 'No file selected';
                }
            });
        }
    </script>
</body>
</html>
