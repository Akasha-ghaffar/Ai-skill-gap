<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next Steps | Skill Gap AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-main: #06101d;
            --bg-secondary: #0b1730;
            --panel-dark: rgba(8, 19, 38, 0.94);
            --panel-dark-2: rgba(10, 24, 48, 0.96);
            --panel-border: rgba(96, 156, 255, 0.16);
            --panel-glow: 0 18px 45px rgba(0, 0, 0, 0.32);
            --text-main: #eef4ff;
            --text-soft: #9cb0d0;
            --blue: #4b7bec;
            --blue-2: #2563eb;
            --cyan: #5fd4ff;
            --green: #1ec98a;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            background:
                radial-gradient(circle at top left, rgba(95, 212, 255, 0.07), transparent 24%),
                radial-gradient(circle at top right, rgba(75, 123, 236, 0.10), transparent 28%),
                linear-gradient(180deg, var(--bg-main) 0%, var(--bg-secondary) 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-main);
        }

        .top-navbar {
            background: rgba(6, 16, 29, 0.72);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(96, 156, 255, 0.10);
            padding: 8px 0;
        }

        .brand-logo {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.22);
        }

        .navbar-title {
            color: var(--text-main);
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .page-wrap {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        .selection-card {
            width: 100%;
            max-width: 760px;
            border-radius: 30px;
            background: linear-gradient(180deg, var(--panel-dark) 0%, var(--panel-dark-2) 100%);
            border: 1px solid var(--panel-border);
            box-shadow: var(--panel-glow);
            padding: 42px 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .selection-card::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            top: -120px;
            right: -80px;
            background: rgba(95, 212, 255, 0.06);
            border-radius: 50%;
        }

        .selection-card::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            bottom: -120px;
            left: -80px;
            background: rgba(75, 123, 236, 0.08);
            border-radius: 50%;
        }

        .badge-top {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(95, 212, 255, 0.08);
            border: 1px solid rgba(95, 212, 255, 0.12);
            color: #bde6ff;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 18px;
        }

        h2 {
            color: var(--text-main);
            font-weight: 700;
            margin-bottom: 14px;
            position: relative;
            z-index: 2;
        }

        .subtitle {
            color: var(--text-soft);
            margin-bottom: 34px;
            position: relative;
            z-index: 2;
        }

        .action-grid {
            position: relative;
            z-index: 2;
        }

        .action-btn {
            min-height: 190px;
            border-radius: 22px;
            border: 1px solid rgba(96, 156, 255, 0.14);
            text-decoration: none;
            color: white;
            padding: 26px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: 0.28s ease;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18);
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: 0.28s ease;
            background: linear-gradient(135deg, rgba(255,255,255,0.10), rgba(255,255,255,0.02));
        }

        .action-btn:hover::before {
            opacity: 1;
        }

        .action-btn:hover {
            transform: translateY(-6px);
            color: white;
            box-shadow: 0 18px 34px rgba(0, 0, 0, 0.26);
        }

        .btn-gap {
            background: linear-gradient(135deg, #1f4ed8 0%, #2563eb 55%, #38bdf8 100%);
        }

        .btn-job {
            background: linear-gradient(135deg, #0f766e 0%, #2563eb 50%, #4f46e5 100%);
        }

        .icon-box {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 16px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.12);
        }

        .action-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .action-text {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.88);
            margin: 0;
        }

        .bottom-link {
            position: relative;
            z-index: 2;
            margin-top: 28px;
        }

        .bottom-link a {
            color: #aac7f7;
            text-decoration: none;
            font-weight: 500;
            transition: 0.2s ease;
        }

        .bottom-link a:hover {
            color: white;
        }

        @media (max-width: 576px) {
            .selection-card {
                padding: 30px 20px;
                border-radius: 24px;
            }

            .action-btn {
                min-height: 170px;
            }
        }
    </style>
</head>
<body>

    <nav class="top-navbar">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <div class="brand-logo">AI</div>
                <span class="navbar-title">Skill Gap AI</span>
            </div>
        </div>
    </nav>

    <div class="page-wrap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="selection-card">
                        <div class="badge-top">Next Step Selection</div>
                        <h2>What would you like to do today?</h2>
                        <p class="subtitle">
                            Choose an option below to continue your journey with Skill Gap AI.
                        </p>
<div class="row g-4 action-grid">
    <div class="col-md-4 d-flex">
        <a href="wel.php" class="action-btn btn-gap w-100">
            <span class="icon-box">🔍</span>
            <div class="action-title">Find Your Gap</div>
            <p class="action-text">Analyze a CV and detect missing skills for your target role.</p>
        </a>
    </div>

    <div class="col-md-4 d-flex">
        <a href="job.php" class="action-btn btn-job w-100">
            <span class="icon-box">💼</span>
            <div class="action-title">Find Your Job</div>
            <p class="action-text">Explore the next opportunity and continue with role matching.</p>
        </a>
    </div>

    <div class="col-md-4 d-flex">
        <a href="cv.php" class="action-btn btn-job w-100">
            <span class="icon-box">📄</span>
            <div class="action-title">Generate  CV</div>
            <p class="action-text">Create a professional CV that highlights your skills and experience.</p>
        </a>
    </div>
</div>



                        <div class="bottom-link">
                            <a href="index.php">← Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
