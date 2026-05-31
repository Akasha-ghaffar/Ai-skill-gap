<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | AI Skill Gap Finder</title>
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
        }

        .brand-logo {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 12px;
        }

        .navbar-title { font-weight: 700; color: var(--text-main); }

        .nav-link-soft {
            color: #c8d7f0;
            font-weight: 500;
            font-size: 0.9rem;
            transition: 0.2s ease;
        }

        .nav-link-soft:hover { color: var(--cyan); }

        .btn-custom {
            background: linear-gradient(135deg, var(--blue), var(--blue-2));
            border: none;
            color: white;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
        }
        
        .btn-custom:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        
        .contact-section { padding: 60px 0 100px; }

        .contact-card {
            background: linear-gradient(180deg, var(--panel-dark) 0%, var(--panel-dark-2) 100%);
            border: 1px solid var(--panel-border);
            border-radius: 24px;
            padding: 40px;
            box-shadow: var(--panel-glow);
        }

        .info-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--panel-border);
            border-radius: 16px;
            padding: 30px 20px;
            margin-bottom: 24px;
            transition: 0.3s ease;
        }

        .info-icon {
            font-size: 1.8rem;
            color: var(--cyan);
            margin-bottom: 12px;
        }

        .form-control {
            background: rgba(6, 16, 29, 0.78);
            border: 1px solid rgba(96, 156, 255, 0.16);
            color: white;
            border-radius: 12px;
            padding: 12px;
        }

        .form-control:focus {
            background: rgba(6, 16, 29, 0.9);
            border-color: var(--cyan);
            box-shadow: 0 0 0 0.25rem rgba(95, 212, 255, 0.1);
            color: white;
        }

        label { color: var(--text-soft); font-size: 0.9rem; margin-bottom: 8px; }

        #form-feedback {
            display: none; 
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg top-navbar sticky-top">
        <div class="container d-flex justify-content-center">
            <div class="navbar-shell">
                <div class="row align-items-center g-0">
                    <div class="col-3">
                        <a href="index.php" class="navbar-brand d-flex align-items-center gap-2 mb-0 text-decoration-none">
                            <div class="brand-logo">AI</div>
                            <span class="navbar-title d-none d-md-inline">Skill Gap AI</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
                            <ul class="navbar-nav gap-lg-2">
                                <li class="nav-item"><a href="index.php" class="nav-link nav-link-soft">Home</a></li>
                                <li class="nav-item"><a href="about.html" class="nav-link nav-link-soft">About</a></li>
                                <li class="nav-item"><a href="team.php" class="nav-link nav-link-soft">Team</a></li>
                                <li class="nav-item"><a href="contact.php" class="nav-link nav-link-soft active" style="color: var(--cyan);">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container contact-section">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Get In Touch</h1>
            <p class="text-soft">Have questions about Skill Gap AI? We're here to help.</p>
        </div>

        <div id="form-feedback" class="mx-auto mb-4" style="max-width: 800px;">
            <div class="alert alert-success" style="border-radius: 15px; background: rgba(25, 135, 84, 0.2); color: #fff; border: 1px solid #198754; backdrop-filter: blur(10px);">
                <strong>Success!</strong> Your message has been sent successfully.
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-lg-4">
                <div class="info-item text-center">
                    <div class="info-icon">✉️</div>
                    <h6>Email Us</h6>
                    <p class="text-soft small mb-0">support@skillgapai.com</p>
                </div>
                <div class="info-item text-center">
                    <div class="info-icon">📞</div>
                    <h6>Call Us</h6>
                    <p class="text-soft small mb-0">+92 300 1234567</p>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="contact-card">
                    <form id="contactForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" placeholder="john@example.com" required>
                            </div>
                            <div class="col-12">
                                <label for="subject">Subject</label>
                                <input type="text" class="form-control" id="subject" placeholder="How can we help?" required>
                            </div>
                            <div class="col-12">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" rows="5" placeholder="Write your message here..." required></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-custom px-5 py-2 mt-2">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4">
        <p class="text-soft small mb-0">&copy; 2026 AI Skill Gap Finder. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault(); 

            
            const feedback = document.getElementById('form-feedback');
            feedback.style.display = 'block';

            
            this.reset();

            
            feedback.scrollIntoView({ behavior: 'smooth', block: 'center' });

            
            setTimeout(function() {
                window.location.reload();
            }, 2500);
        });
    </script>
</body>
</html>