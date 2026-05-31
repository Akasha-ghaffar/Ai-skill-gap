<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "skill_gap_db";

$conn = new mysqli($host, $user, $pass, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$results = null;


$job_requirements = [
    "Frontend Developer" => ["HTML", "CSS", "JavaScript", "React", "Vue", "Sass"],
    "Data Analyst"       => ["Python", "SQL", "Excel", "Power BI", "Tableau", "Statistics"],
    "Backend Developer"  => ["PHP", "MySQL", "Node.js", "Python", "API", "Docker"]
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["resume"])) {
    $target_role = $_POST["job_role"];
    $upload_dir = "uploads/";
    
    
    if (!is_dir($upload_dir)) mkdir($upload_dir);

    $file_name = basename($_FILES["resume"]["name"]);
    $target_file = $upload_dir . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
        
      
        $pdf_content = file_get_contents($target_file);
        $clean_text = strtolower(strip_tags($pdf_content));

        
        $required_skills = $job_requirements[$target_role] ?? [];
        $found_skills = [];
        $missing_skills = [];

        foreach ($required_skills as $skill) {
            if (strpos($clean_text, strtolower($skill)) !== false) {
                $found_skills[] = $skill;
            } else {
                $missing_skills[] = $skill;
            }
        }

        $stmt = $conn->prepare("INSERT INTO analysis_results (job_role, file_path) VALUES (?, ?)");
        $stmt->bind_param("ss", $target_role, $target_file);
        $stmt->execute();

        $results = [
            'role' => $target_role,
            'found' => $found_skills,
            'missing' => $missing_skills,
            'required' => $required_skills
        ];
    } else {
        $message = "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Skill Gap Finder</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 40px; }
        .container { max-width: 600px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin: auto; }
        h2 { color: #333; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #218838; }
        .result-box { margin-top: 30px; padding: 20px; border-top: 2px solid #eee; }
        .tag { display: inline-block; padding: 5px 10px; margin: 5px; border-radius: 20px; font-size: 12px; }
        .found { background: #d4edda; color: #155724; }
        .missing { background: #f8d7da; color: #721c24; }
        .required { background: #e2e3e5; color: #383d41; }
    </style>
</head>
<body>

<div class="container">
    <h2>🔍 Skill Gap Finder</h2>
    
    <form id="skillForm" action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="form-group">
            <label>Target Job Role:</label>
            <select name="job_role" id="job_role">
                <option value="">-- Select Role --</option>
                <?php foreach($job_requirements as $role => $skills): ?>
                    <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Upload Resume (PDF):</label>
            <input type="file" name="resume" id="resume" accept=".pdf">
        </div>

        <button type="submit">Analyze Skills</button>
    </form>

    <p id="error" style="color: red; text-align: center;"></p>

    <?php if ($results): ?>
        <div class="result-box">
            <h3>Analysis for: <?php echo $results['role']; ?></h3>
            
            <p><strong>Your Skills (from CV):</strong><br>
            <?php foreach($results['found'] as $s): ?> <span class="tag found"><?php echo $s; ?></span> <?php endforeach; ?>
            <?php if(empty($results['found'])) echo "None detected."; ?>
            </p>

            <p><strong>Missing Skills:</strong><br>
            <?php foreach($results['missing'] as $s): ?> <span class="tag missing"><?php echo $s; ?></span> <?php endforeach; ?>
            <?php if(empty($results['missing'])) echo "No gaps found! You're a match."; ?>
            </p>

            <p><strong>Total Requirements:</strong><br>
            <?php foreach($results['required'] as $s): ?> <span class="tag required"><?php echo $s; ?></span> <?php endforeach; ?>
            </p>
        </div>
    <?php endif; ?>
</div>

<script>
function validateForm() {
    const fileInput = document.getElementById('resume');
    const roleInput = document.getElementById('job_role');
    const errorMsg = document.getElementById('error');
    
    
    if (roleInput.value === "") {
        errorMsg.innerText = "Please select a target job role.";
        return false;
    }

    
    if (fileInput.files.length === 0) {
        errorMsg.innerText = "Please upload a PDF file.";
        return false;
    }

    
    const fileName = fileInput.files[0].name;
    if (!fileName.toLowerCase().endsWith('.pdf')) {
        errorMsg.innerText = "Only PDF files are allowed.";
        return false;
    }

    return true;
}
</script>

</body>
</html>