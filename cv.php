<?php
require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$cvData = [
    'full_name' => trim($_POST['full_name'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'phone' => trim($_POST['phone'] ?? ''),
    'address' => trim($_POST['address'] ?? ''),
    'summary' => trim($_POST['summary'] ?? ''),
    'skills' => trim($_POST['skills'] ?? ''),
    'education' => trim($_POST['education'] ?? ''),
    'experience' => trim($_POST['experience'] ?? ''),
    'projects' => trim($_POST['projects'] ?? ''),
];

function buildCvHtml(array $cvData): string
{
    $skillsHtml = '';
    if (!empty($cvData['skills'])) {
        $skills = array_filter(array_map('trim', explode(',', $cvData['skills'])));
        foreach ($skills as $skill) {
            $skillsHtml .= '<span class="skill-chip">' . htmlspecialchars($skill) . '</span>';
        }
    }

    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: DejaVu Sans, sans-serif;
                margin: 0;
                padding: 0;
                color: #1c2a44;
                background: #ffffff;
            }
            .cv-card {
                width: 100%;
            }
            .cv-header {
                background: #14345f;
                color: white;
                padding: 30px;
            }
            .cv-header h1 {
                margin: 0 0 8px;
                font-size: 28px;
            }
            .cv-contact {
                font-size: 14px;
                line-height: 1.8;
            }
            .cv-body {
                padding: 28px;
            }
            .cv-section {
                margin-bottom: 24px;
            }
            .cv-section h3 {
                color: #14345f;
                font-size: 18px;
                margin-bottom: 10px;
                padding-bottom: 6px;
                border-bottom: 2px solid #e8eefb;
            }
            .cv-section p {
                margin: 0;
                font-size: 14px;
                line-height: 1.7;
                white-space: pre-line;
            }
            .skill-chip {
                display: inline-block;
                padding: 6px 10px;
                margin: 4px 6px 0 0;
                background: #edf4ff;
                color: #1d4ed8;
                border-radius: 999px;
                font-size: 12px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="cv-card">
            <div class="cv-header">
                <h1>' . htmlspecialchars($cvData['full_name']) . '</h1>
                <div class="cv-contact">';

    if (!empty($cvData['email'])) {
        $html .= 'Email: ' . htmlspecialchars($cvData['email']) . '<br>';
    }
    if (!empty($cvData['phone'])) {
        $html .= 'Phone: ' . htmlspecialchars($cvData['phone']) . '<br>';
    }
    if (!empty($cvData['address'])) {
        $html .= 'Address: ' . htmlspecialchars($cvData['address']);
    }

    $html .= '
                </div>
            </div>
            <div class="cv-body">';

    if (!empty($cvData['summary'])) {
        $html .= '
            <div class="cv-section">
                <h3>Professional Summary</h3>
                <p>' . htmlspecialchars($cvData['summary']) . '</p>
            </div>';
    }

    if (!empty($cvData['skills'])) {
        $html .= '
            <div class="cv-section">
                <h3>Skills</h3>
                <div>' . $skillsHtml . '</div>
            </div>';
    }

    if (!empty($cvData['education'])) {
        $html .= '
            <div class="cv-section">
                <h3>Education</h3>
                <p>' . htmlspecialchars($cvData['education']) . '</p>
            </div>';
    }

    if (!empty($cvData['experience'])) {
        $html .= '
            <div class="cv-section">
                <h3>Work Experience</h3>
                <p>' . htmlspecialchars($cvData['experience']) . '</p>
            </div>';
    }

    if (!empty($cvData['projects'])) {
        $html .= '
            <div class="cv-section">
                <h3>Projects</h3>
                <p>' . htmlspecialchars($cvData['projects']) . '</p>
            </div>';
    }

    $html .= '
            </div>
        </div>
    </body>
    </html>';

    return $html;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['download_pdf'])) {
    $options = new Options();
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);
    $html = buildCvHtml($cvData);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $fileName = !empty($cvData['full_name'])
        ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $cvData['full_name']) . '_CV.pdf'
        : 'CV.pdf';

    $dompdf->stream($fileName, ['Attachment' => true]);
    exit;
}

$hasData =
    !empty($cvData['full_name']) ||
    !empty($cvData['email']) ||
    !empty($cvData['phone']) ||
    !empty($cvData['address']) ||
    !empty($cvData['summary']) ||
    !empty($cvData['skills']) ||
    !empty($cvData['education']) ||
    !empty($cvData['experience']) ||
    !empty($cvData['projects']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Builder | Skill Gap AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --navy: #0d223f;
            --navy-2: #17345f;
            --blue: #2563eb;
            --blue-soft: #eef4ff;
            --ink: #1f2d45;
            --muted: #70809c;
            --line: rgba(37, 99, 235, 0.10);
            --panel: rgba(255, 255, 255, 0.96);
            --shadow: 0 18px 45px rgba(18, 42, 76, 0.10);
            --shadow-soft: 0 10px 28px rgba(18, 42, 76, 0.08);
            --radius-lg: 24px;
            --radius-md: 16px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.08), transparent 22%),
                linear-gradient(180deg, #f7faff 0%, #eef4fb 100%);
            font-family: "Segoe UI", Tahoma, sans-serif;
            color: var(--ink);
        }

        .topbar {
            background: linear-gradient(135deg, var(--navy), var(--navy-2));
            padding: 12px 0;
            box-shadow: 0 10px 24px rgba(13, 34, 63, 0.16);
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
            background: rgba(255, 255, 255, 0.12);
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

        .top-link {
            color: white;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,0.16);
            padding: 8px 16px;
            border-radius: 999px;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .top-link:hover {
            color: white;
            background: rgba(255,255,255,0.08);
        }

        .page-wrap {
            padding: 28px 0 42px;
        }

        .page-head {
            margin-bottom: 22px;
        }

        .page-head h1 {
            font-weight: 800;
            margin-bottom: 6px;
            color: var(--ink);
        }

        .page-head p {
            margin: 0;
            color: var(--muted);
        }

        .layout-grid {
            display: grid;
            grid-template-columns: 390px 1fr;
            gap: 24px;
            align-items: start;
        }

        .form-card,
        .cv-card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
        }

        .form-card {
            padding: 24px;
            position: sticky;
            top: 20px;
        }

        .form-card h3 {
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--navy);
        }

        .form-card .subtitle {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 20px;
        }

        .section-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 22px 0 14px;
        }

        .section-divider span {
            font-size: 13px;
            font-weight: 700;
            color: var(--blue);
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .section-divider::after {
            content: "";
            height: 1px;
            flex: 1;
            background: #e7eef9;
        }

        .form-label {
            font-weight: 600;
            color: #243657;
            margin-bottom: 9px;
        }

        .form-control {
            border-radius: var(--radius-md);
            border: 1px solid rgba(37, 99, 235, 0.12);
            padding: 12px 14px;
            background: #fbfdff;
            color: var(--ink);
        }

        .form-control::placeholder {
            color: #95a3ba;
        }

        .form-control:focus {
            border-color: rgba(37, 99, 235, 0.28);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.10);
            background: white;
        }

        .btn-main,
        .btn-pdf {
            width: 100%;
            border: none;
            border-radius: 14px;
            padding: 13px 18px;
            font-weight: 700;
            color: white;
            transition: 0.22s ease;
        }

        .btn-main {
            background: linear-gradient(135deg, var(--blue), #3b82f6);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.16);
        }

        .btn-main:hover {
            background: linear-gradient(135deg, #1d4ed8, var(--blue));
        }

        .btn-pdf {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            box-shadow: 0 10px 20px rgba(15, 118, 110, 0.16);
        }

        .btn-pdf:hover {
            background: linear-gradient(135deg, #0d5f59, #0f9d8c);
        }

        .action-row {
            display: grid;
            gap: 12px;
            margin-top: 8px;
        }

        .cv-card {
            overflow: hidden;
        }

        .cv-header {
            background: linear-gradient(135deg, var(--navy), var(--blue));
            color: white;
            padding: 30px;
        }

        .cv-header h2 {
            margin: 0 0 8px;
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        .cv-contact {
            color: rgba(255,255,255,0.92);
            line-height: 1.8;
            font-size: 14px;
        }

        .cv-body {
            padding: 28px;
        }

        .cv-section {
            margin-bottom: 24px;
        }

        .cv-section:last-child {
            margin-bottom: 0;
        }

        .cv-section h4 {
            color: var(--navy);
            font-weight: 700;
            margin-bottom: 10px;
            border-bottom: 2px solid #e9eff9;
            padding-bottom: 8px;
            letter-spacing: 0.2px;
        }

        .cv-section p {
            margin-bottom: 0;
            color: #4f6282;
            line-height: 1.75;
            white-space: pre-line;
        }

        .empty-box {
            padding: 70px 30px;
            text-align: center;
            color: #6f84a6;
        }

        .empty-box h3 {
            color: var(--navy);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .skill-chip {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            background: var(--blue-soft);
            color: #1d4ed8;
            font-size: 13px;
            font-weight: 600;
            margin: 4px 6px 0 0;
            border: 1px solid rgba(37, 99, 235, 0.08);
        }

        .cv-preview-label {
            padding: 16px 28px 0;
            font-size: 13px;
            font-weight: 700;
            color: var(--blue);
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }

        @media (max-width: 991px) {
            .layout-grid {
                grid-template-columns: 1fr;
            }

            .form-card {
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
            <a href="selection.php" class="top-link">Back</a>
        </div>
    </nav>

    <div class="container page-wrap">
        <div class="page-head">
            <h1>CV Builder</h1>
            <p>Create a simple, clean CV and download it as a real PDF file.</p>
        </div>

        <div class="layout-grid">
            <div class="form-card">
                <h3>Candidate Details</h3>
                <div class="subtitle">Fill the form and generate a clean professional CV preview.</div>

                <form method="POST">
                    <div class="section-divider"><span>Basic Info</span></div>

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" required value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($_POST['address'] ?? ''); ?>">
                    </div>

                    <div class="section-divider"><span>Profile</span></div>

                    <div class="mb-3">
                        <label class="form-label">Professional Summary</label>
                        <textarea name="summary" class="form-control" rows="4"><?php echo htmlspecialchars($_POST['summary'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Skills</label>
                        <textarea name="skills" class="form-control" rows="3" placeholder="Example: PHP, MySQL, HTML, CSS, JavaScript"><?php echo htmlspecialchars($_POST['skills'] ?? ''); ?></textarea>
                    </div>

                    <div class="section-divider"><span>Qualifications</span></div>

                    <div class="mb-3">
                        <label class="form-label">Education</label>
                        <textarea name="education" class="form-control" rows="4"><?php echo htmlspecialchars($_POST['education'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Work Experience</label>
                        <textarea name="experience" class="form-control" rows="4"><?php echo htmlspecialchars($_POST['experience'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Projects</label>
                        <textarea name="projects" class="form-control" rows="4"><?php echo htmlspecialchars($_POST['projects'] ?? ''); ?></textarea>
                    </div>

                    <div class="action-row">
                        <button type="submit" name="preview_cv" value="1" class="btn-main">Generate CV</button>

                        <?php if ($hasData): ?>
                            <button type="submit" name="download_pdf" value="1" class="btn-pdf">Download CV as PDF</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="cv-card">
                <div class="cv-preview-label">Preview</div>

                <?php if ($hasData): ?>
                    <div class="cv-header">
                        <h2><?php echo htmlspecialchars($cvData['full_name']); ?></h2>
                        <div class="cv-contact">
                            <?php if ($cvData['email']): ?>Email: <?php echo htmlspecialchars($cvData['email']); ?><br><?php endif; ?>
                            <?php if ($cvData['phone']): ?>Phone: <?php echo htmlspecialchars($cvData['phone']); ?><br><?php endif; ?>
                            <?php if ($cvData['address']): ?>Address: <?php echo htmlspecialchars($cvData['address']); ?><?php endif; ?>
                        </div>
                    </div>

                    <div class="cv-body">
                        <?php if ($cvData['summary']): ?>
                            <div class="cv-section">
                                <h4>Professional Summary</h4>
                                <p><?php echo htmlspecialchars($cvData['summary']); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ($cvData['skills']): ?>
                            <div class="cv-section">
                                <h4>Skills</h4>
                                <div>
                                    <?php
                                    $skills = array_filter(array_map('trim', explode(',', $cvData['skills'])));
                                    foreach ($skills as $skill):
                                    ?>
                                        <span class="skill-chip"><?php echo htmlspecialchars($skill); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($cvData['education']): ?>
                            <div class="cv-section">
                                <h4>Education</h4>
                                <p><?php echo htmlspecialchars($cvData['education']); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ($cvData['experience']): ?>
                            <div class="cv-section">
                                <h4>Work Experience</h4>
                                <p><?php echo htmlspecialchars($cvData['experience']); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if ($cvData['projects']): ?>
                            <div class="cv-section">
                                <h4>Projects</h4>
                                <p><?php echo htmlspecialchars($cvData['projects']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-box">
                        <h3>CV Preview</h3>
                        <p>Your generated CV will appear here after you fill out the form.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
