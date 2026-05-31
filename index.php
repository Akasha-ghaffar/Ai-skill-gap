<?php
include('db.php');
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/cv_analysis_logic.php';

$result = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_FILES['cv_pdf']) || $_FILES['cv_pdf']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Please upload a valid PDF file.');
        }

        $targetJob = trim($_POST['target_job'] ?? '');

        if ($targetJob === '') {
            throw new Exception('Please enter target job.');
        }

        $analyzer = new CvSkillAnalyzer();
        $result = $analyzer->analyze($_FILES['cv_pdf']['tmp_name'], $targetJob, '');
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Skill Gap Finder | Welcome</title>
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
            --pink: #f26ca7;
            --green-bg: rgba(22, 101, 52, 0.22);
            --green-text: #8ef0b1;
            --danger-bg: rgba(239, 68, 68, 0.16);
            --danger-text: #ffb4b4;
        }

        body {
            background:
                radial-gradient(circle at top left, rgba(95, 212, 255, 0.07), transparent 24%),
                radial-gradient(circle at top right, rgba(75, 123, 236, 0.10), transparent 28%),
                linear-gradient(180deg, var(--bg-main) 0%, var(--bg-secondary) 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-main);
        }

        .top-navbar {
            background: rgba(6, 16, 29, 0.72);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(96, 156, 255, 0.10);
            padding: 6px 0;
        }

        .navbar-shell {
            border: 1px solid rgba(96, 156, 255, 0.12);
            background: rgba(9, 20, 37, 0.52);
            box-shadow: 0 14px 34px rgba(0, 0, 0, 0.18);
            border-radius: 18px;
            padding: 8px 14px;
        }

        .brand-logo {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 12px;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.22);
        }

        .navbar-title {
            color: var(--text-main);
            font-weight: 700;
            font-size: 0.98rem;
            letter-spacing: 0.2px;
        }

        .nav-link-soft {
            color: #c8d7f0;
            font-weight: 600;
            font-size: 0.94rem;
            padding: 8px 12px !important;
            border-radius: 999px;
            transition: 0.2s ease;
        }

        .nav-link-soft:hover,
        .nav-link-soft:focus {
            color: #ffffff;
            background: rgba(95, 212, 255, 0.08);
        }

        .navbar-toggler {
            border: 1px solid rgba(96, 156, 255, 0.18);
            background: rgba(13, 28, 56, 0.9);
            border-radius: 12px;
            padding: 6px 9px;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(95, 212, 255, 0.16);
        }

        .hero-section {
            background: linear-gradient(135deg, #10213f 0%, #13305f 100%);
            color: white;
            padding: 90px 0 110px;
            border-bottom-left-radius: 48px;
            border-bottom-right-radius: 48px;
            box-shadow: 0 12px 34px rgba(0, 0, 0, 0.22);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            top: -90px;
            right: -70px;
            background: rgba(95, 212, 255, 0.08);
            border-radius: 50%;
        }

        .hero-section::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            bottom: -80px;
            left: -60px;
            background: rgba(75, 123, 236, 0.10);
            border-radius: 50%;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.10);
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 18px;
            color: #c7dcff;
        }

        .hero-section .lead {
            max-width: 720px;
            margin: 0 auto;
            color: #bfd3f6;
        }

        .main-panel {
            margin-top: -55px;
            position: relative;
            z-index: 5;
        }

        .feature-card,
        .analyzer-card,
        .result-card {
            background: linear-gradient(180deg, var(--panel-dark) 0%, var(--panel-dark-2) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid var(--panel-border);
            border-radius: 24px;
            box-shadow: var(--panel-glow);
            transition: 0.28s ease;
        }

        .feature-card:hover,
        .analyzer-card:hover,
        .result-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 52px rgba(0, 0, 0, 0.36);
        }

        .feature-icon {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(75, 123, 236, 0.16), rgba(95, 212, 255, 0.14));
            color: var(--cyan);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 16px;
        }

        .section-title {
            color: #dbe8ff;
            font-weight: 700;
        }

        .btn-custom {
            background: linear-gradient(135deg, var(--blue), var(--blue-2));
            border: none;
            color: white;
            padding: 12px 28px;
            border-radius: 999px;
            transition: 0.25s ease;
            font-weight: 600;
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.22);
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 14px 28px rgba(37, 99, 235, 0.30);
        }

        .btn-outline-soft {
            border-radius: 999px;
            border: 1px solid rgba(96, 156, 255, 0.18);
            color: #d4e6ff;
            background: rgba(13, 28, 56, 0.9);
            font-weight: 600;
            padding: 9px 18px;
            font-size: 0.9rem;
        }

        .btn-outline-soft:hover {
            background: rgba(20, 39, 74, 1);
            color: white;
        }

        .form-control,
        .form-control:focus {
            border-radius: 16px;
            border: 1px solid rgba(96, 156, 255, 0.16);
            box-shadow: none;
            background: rgba(6, 16, 29, 0.78);
            color: white;
        }

        .form-control::placeholder {
            color: #7890b8;
        }

        .form-control:focus {
            border-color: rgba(95, 212, 255, 0.40);
            box-shadow: 0 0 0 4px rgba(95, 212, 255, 0.10);
        }

        .upload-box {
            border: 2px dashed rgba(96, 156, 255, 0.18);
            border-radius: 20px;
            background: linear-gradient(180deg, rgba(11, 23, 48, 0.96) 0%, rgba(8, 19, 38, 0.98) 100%);
            padding: 24px;
            text-align: center;
        }

        .upload-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 14px;
            border-radius: 22px;
            background: linear-gradient(135deg, rgba(75, 123, 236, 0.18), rgba(95, 212, 255, 0.16));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: var(--cyan);
        }

        .metric-badge {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 999px;
            background: var(--green-bg);
            color: var(--green-text);
            font-weight: 700;
            border: 1px solid rgba(34, 197, 94, 0.14);
        }

        .skills-box {
            background: linear-gradient(180deg, rgba(11, 23, 48, 0.96) 0%, rgba(8, 19, 38, 0.98) 100%);
            border: 1px solid rgba(96, 156, 255, 0.12);
            border-radius: 18px;
            padding: 18px;
            height: 100%;
        }

        .skills-box h5 {
            color: var(--text-main);
            font-weight: 700;
            margin-bottom: 14px;
        }

        .skills-box ul {
            margin-bottom: 0;
        }

        .skills-box li {
            margin-bottom: 8px;
            color: var(--text-soft);
        }

        .footer-text {
            color: var(--text-soft);
        }

        .text-muted {
            color: var(--text-soft) !important;
        }

        .alert-danger {
            background: var(--danger-bg);
            color: var(--danger-text);
        }

        @media (max-width: 991.98px) {
            .navbar-shell {
                padding: 10px 14px;
            }

            .navbar-collapse {
                padding-top: 14px;
            }

            .navbar-actions {
                margin-top: 14px;
                width: 100%;
            }

            .navbar-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 70px 0 90px;
            }

            .main-panel {
                margin-top: -35px;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg top-navbar sticky-top">
        <div class="container d-flex justify-content-center">
            <div class="navbar-shell" style="max-width: 1000px; width: 100%;">
                <div class="row align-items-center g-0">

                    <div class="col-3">
                        <a href="" class="navbar-brand d-flex align-items-center gap-2 mb-0 text-decoration-none">
                            <div class="brand-logo">AI</div>
                            <span class="navbar-title d-none d-md-inline">Skill Gap Finder</span>
                        </a>
                    </div>

                    <div class="col-6">
                        <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
                            <ul class="navbar-nav gap-lg-2">
                                <li class="nav-item">
                                    <a href="index.php" class="nav-link nav-link-soft">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a href="about.html" class="nav-link nav-link-soft">About</a>
                                </li>
                                <li class="nav-item">
                                    <a href="team.php" class="nav-link nav-link-soft">Team</a>
                                </li>
                                <li class="nav-item">
                                    <a href="contact.php" class="nav-link nav-link-soft">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-3 text-end d-flex justify-content-end align-items-center gap-2">
                        <a href="signup.php" class="btn btn-outline-soft btn-sm px-3 d-none d-sm-block">Sign Up</a>
                        <a href="login.php" class="btn btn-custom btn-sm px-3">Login</a>

                        <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" style="border:none; padding:0;">
                            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </nav>

    <header class="hero-section text-center">
        <div class="container">
            <div class="hero-badge">Career Intelligence Platform</div>
            <h1 class="display-4 fw-bold">Welcome to AI Skill Gap Finder</h1>
            <p class="lead">
                Bridging the gap between learning and professional success through smart CV analysis and skill matching.
            </p>
        </div>
    </header>

    <main class="container main-panel">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="feature-card p-4 h-100 text-center">
                    <div class="feature-icon">🔍</div>
                    <h5 class="fw-bold">Find Skill Gaps</h5>
                    <p class="text-muted mb-0">Upload resume PDFs quickly and start analyzing skill gaps in seconds.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card p-4 h-100 text-center">
                    <div class="feature-icon">🎯</div>
                    <h5 class="fw-bold">Target Job Match</h5>
                    <p class="text-muted mb-0">Compare candidate skills against a target role and uncover missing areas.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card p-4 h-100 text-center">
                    <div class="feature-icon">📄</div>
                    <h5 class="fw-bold">Generate CV</h5>
                    <p class="text-muted mb-0">Create a professional CV based on your skills and experience.</p>
                </div>
            </div>
        </div>
        <div class="text-center">
            <a href="signup.php" class="btn btn-custom btn-lg">Try It Now</a>
        </div>

    </main>
    <style>
    
    .ai-robot-trigger {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 65px;
        height: 65px;
        background: linear-gradient(135deg, #5fd4ff, #4b7bec);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        cursor: pointer;
        z-index: 1000;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 25px rgba(95, 212, 255, 0.4);
    }
    .ai-robot-trigger:hover { transform: scale(1.1) rotate(10deg); }

    
    .ai-offcanvas {
        background: #0b1730 !important;
        border-left: 1px solid rgba(96, 156, 255, 0.25) !important;
        width: 380px !important;
        color: #eef4ff;
    }
    .chat-container {
        height: 480px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 20px;
        scrollbar-width: thin;
    }

   
    .msg {
        padding: 12px 16px;
        border-radius: 18px;
        max-width: 85%;
        font-size: 0.9rem;
        line-height: 1.5;
        animation: fadeInUp 0.3s ease;
    }
    .msg-ai {
        background: rgba(95, 212, 255, 0.1);
        border: 1px solid rgba(95, 212, 255, 0.2);
        align-self: flex-start;
        border-bottom-left-radius: 2px;
    }
    .msg-user {
        background: #2563eb;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 2px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

   
    .chat-input-area {
        background: rgba(255,255,255,0.03);
        border-top: 1px solid rgba(96, 156, 255, 0.15);
        padding: 20px;
    }
    .chat-input-group {
        background: rgba(10, 20, 40, 0.8);
        border-radius: 30px;
        padding: 5px 15px;
        border: 1px solid rgba(96, 156, 255, 0.3);
        display: flex;
        align-items: center;
    }
    .chat-input {
        background: transparent;
        border: none;
        color: white;
        flex: 1;
        padding: 8px 5px;
        outline: none;
    }
    .chat-send-btn {
        background: #5fd4ff;
        border: none;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        transition: 0.2s;
        cursor: pointer;
    }
    .chat-send-btn:hover { background: #fff; transform: scale(1.1); }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="ai-robot-trigger" data-bs-toggle="offcanvas" data-bs-target="#aiChatSidebar">🤖</div>

<div class="offcanvas offcanvas-end ai-offcanvas" tabindex="-1" id="aiChatSidebar">
    <div class="offcanvas-header border-bottom border-secondary">
        <div class="d-flex align-items-center gap-2">
            <div style="width:30px; height:30px; background:linear-gradient(135deg, #4b7bec, #5fd4ff); border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:bold; color:white;">AI</div>
            <h6 class="mb-0 text-white">Career Assistant</h6>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    
    <div class="offcanvas-body d-flex flex-column p-0">
        <div class="chat-container" id="chatWindow">
            <div class="msg msg-ai">Hi! I'm your AI guide. How can I help you with your CV today?</div>
        </div>
        
        <div class="chat-input-area">
            <div class="chat-input-group">
                <input type="text" id="aiUserInput" class="chat-input" placeholder="Ask about Canva, Match Score, or how it works..." onkeypress="if(event.key === 'Enter') processChat()">
                <button class="chat-send-btn" onclick="processChat()">↑</button>
            </div>
            <div class="mt-3 text-center">
                <small class="text-muted" style="font-size:0.7rem;">Powered by Skill Analyzer Engine</small>
            </div>
        </div>
    </div>
</div>

<script>
    const chatWin = document.getElementById('chatWindow');
    const chatInp = document.getElementById('aiUserInput');

    const botKnowledge = {
        "how it works": "It's simple: 1. Upload your PDF. 2. Enter your Target Job. 3. Our AI scans your CV text and matches it against industry-standard requirements to find what's missing.",
        "method": "We use **Semantic Skill Mapping** and **NLP (Natural Language Processing)**. This allows us to understand the professional context of your skills, not just match simple keywords.",
        "canva": "CVs from **Canva** or graphic tools often use 'heavy' layers that our AI can't read. If yours won't upload, try using our **Generate CV** tool here for a system-friendly version!",
        "heavy": "If your file is too 'heavy' with images and graphics, text extraction might fail. Simple, text-based PDFs work best for high-accuracy analysis.",
        "not upload": "Upload errors usually happen with complex layouts (like Canva). Please try a simplified PDF version or use our **built-in CV creator** to ensure it works.",
        "create cv": "Yes! We recommend our **Generate CV** feature. It creates professional, ATS-friendly resumes that our AI can analyze with 100% precision.",
        "finding gaps": "We identify 'gaps' by checking which skills are mandatory for your target role but are missing from your current CV text.",
        "score": "The **Match Score** shows how well your profile fits the job. A score of 70% or higher is good, but our 'Recommended Skills' will help you reach 90%+!",
        "file type": "Currently, we only support **PDF** files. Please ensure your document is saved as a PDF and isn't password-protected.",
        "price": "This tool is currently free for students and job seekers looking to improve their professional profiles!",
        "privacy": "Your data is safe. We only process the text to identify skill gaps and do not share your personal information with third parties.",
        "contact": "If you need more help, you can reach out via our **Contact Us** page in the navigation bar!"
    };

    function processChat() {
        const text = chatInp.value.trim();
        if (!text) return;

        appendMessage(text, 'user');
        chatInp.value = '';

        const typingDiv = document.createElement('div');
        typingDiv.className = 'msg msg-ai';
        typingDiv.id = 'typing-indicator';
        typingDiv.innerText = "...";
        chatWin.appendChild(typingDiv);
        chatWin.scrollTop = chatWin.scrollHeight;

       
        setTimeout(() => {
           
            const indicator = document.getElementById('typing-indicator');
            if (indicator) indicator.remove();

            const query = text.toLowerCase();
            let reply = "I'm not sure about that. Try asking about 'Canva CVs', 'how it works', 'match scores', or 'creating a CV here'.";

           
            for (const key in botKnowledge) {
                if (query.includes(key)) {
                    reply = botKnowledge[key];
                    break;
                }
            }
            appendMessage(reply, 'ai');
        }, 800);
    }

    function appendMessage(msg, sender) {
        const div = document.createElement('div');
        div.className = `msg msg-${sender}`;
        div.innerHTML = msg; 
        chatWin.appendChild(div);
        chatWin.scrollTop = chatWin.scrollHeight;
    }
</script>

    <footer class="text-center py-4 footer-text">
        <p class="mb-0">&copy; <?php echo date("Y"); ?> AI Skill Gap Finder. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
