<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team | AI Skill Gap Finder</title>
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
        }

        body {
            background:
                radial-gradient(circle at top left, rgba(95, 212, 255, 0.07), transparent 24%),
                radial-gradient(circle at top right, rgba(75, 123, 236, 0.10), transparent 28%),
                linear-gradient(180deg, var(--bg-main) 0%, var(--bg-secondary) 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-main);
            min-height: 100vh;
        }

       
        .top-navbar {
            background: rgba(6, 16, 29, 0.72);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(96, 156, 255, 0.10);
            padding: 15px 0;
        }

        .navbar-shell {
            border: 1px solid rgba(96, 156, 255, 0.12);
            background: rgba(9, 20, 37, 0.52);
            box-shadow: 0 14px 34px rgba(0, 0, 0, 0.18);
            border-radius: 50px;
            padding: 8px 24px;
            max-width: 1000px;
            width: 100%;
            margin: 0 auto;
        }

        .brand-logo {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            display: inline-flex;
            align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 12px;
        }

        .nav-link-soft {
            color: #c8d7f0;
            font-weight: 500;
            font-size: 0.9rem;
            transition: 0.2s ease;
        }

        .nav-link-soft:hover { color: var(--cyan); }

        .btn-custom {
            background: linear-gradient(135deg, var(--blue), var(--blue-2));
            border: none; color: white; border-radius: 50px; font-weight: 600;
        }

        
        .team-header { padding: 60px 0 40px; text-align: center; }

        .team-card {
            background: linear-gradient(180deg, var(--panel-dark) 0%, var(--panel-dark-2) 100%);
            border: 1px solid var(--panel-border);
            border-radius: 24px;
            padding: 40px 20px;
            text-align: center;
            transition: 0.3s ease;
            height: 100%;
        }

        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--panel-glow);
            border-color: var(--cyan);
        }

        .profile-img-wrapper {
            width: 110px;
            height: 110px;
            margin: 0 auto 20px;
            border-radius: 50%;
            padding: 4px;
            background: linear-gradient(45deg, var(--blue), var(--cyan));
        }

        .profile-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--bg-main);
            background: var(--bg-secondary);
        }

        .role-badge {
            display: inline-block;
            background: rgba(95, 212, 255, 0.1);
            color: var(--cyan);
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 50px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg top-navbar sticky-top">
        <div class="container">
            <div class="navbar-shell">
                <div class="row align-items-center g-0">
                    <div class="col-3">
                        <a href="welcome.php" class="navbar-brand d-flex align-items-center gap-2 mb-0 text-decoration-none">
                            <div class="brand-logo">AI</div>
                            <span class="navbar-title d-none d-md-inline" style="color:white; font-weight:700;">Skill Gap AI</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
                            <ul class="navbar-nav gap-lg-2">
                                <li class="nav-item"><a href="index.php" class="nav-link nav-link-soft">Home</a></li>
                                <li class="nav-item"><a href="about.html" class="nav-link nav-link-soft">About</a></li>
                                <li class="nav-item"><a href="team.php" class="nav-link nav-link-soft active" style="color: var(--cyan);">Team</a></li>
                                <li class="nav-item"><a href="contact.php" class="nav-link nav-link-soft">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="team-header">
            <h1 class="display-5 fw-bold">The Minds Behind AI Skill Gap</h1>
            <p class="text-soft mx-auto" style="max-width: 600px;">
                Our diverse team works together to simplify career paths through intelligent analysis.
            </p>
        </div>

        <div class="row g-4 pb-5">
            <div class="col-md-4">
                <div class="team-card">
                    <div class="profile-img-wrapper">
                        <img src="e.jpeg" alt="Akasha" class="profile-img">
                    </div>
                    <span class="role-badge">Frontend Developer</span>
                    <h4 class="mb-1">Akasha</h4>
                    <p class="text-soft small mb-3">Responsive Layouts & Interactivity</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="team-card">
                    <div class="profile-img-wrapper">
                        <img src="a.jpg" alt="Naveen" class="profile-img">
                    </div>
                    <span class="role-badge">Backend Developer</span>
                    <h4 class="mb-1">Naveen</h4>
                    <p class="text-soft small mb-3">Database Management & API Logic</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="team-card">
                    <div class="profile-img-wrapper">
                        <img src="l.jpeg" alt="Javeriya" class="profile-img">
                    </div>
                    <span class="role-badge">Project Manager</span>
                    <h4 class="mb-1">Javeriya</h4>
                    <p class="text-soft small mb-3">Strategy & Coordination</p>
                </div>
            </div>
        </div>
        </div>

    <footer class="text-center py-4">
        <p class="text-soft small mb-0">&copy; 2026 AI Skill Gap Finder. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>