<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            ['slug' => 'about', 'title' => 'About ITLAB', 'meta_description' => 'About ITLAB — learn by doing', 'content' => '<p>ITLAB is a hands-on learning platform for web development and cyber security. We focus on short, practical tracks, labs, and quizzes so learners build real skills while working on real examples.</p>'],
            ['slug' => 'getting-started', 'title' => 'Getting Started', 'meta_description' => 'Begin your path at ITLAB', 'content' => '<p>Choose a track that matches your level and follow short daily practice sessions. Start with <a href="/html">HTML</a> and <a href="/css">CSS</a>.</p>'],
            ['slug' => 'students', 'title' => 'Students', 'meta_description' => 'Resources for students', 'content' => '<p>Resources and guidance for learners using ITLAB. Find recommended tracks and study tips.</p>'],
            ['slug' => 'instructors', 'title' => 'Instructors', 'meta_description' => 'Guidance for instructors', 'content' => '<p>Guidance for teachers who want to use ITLAB with students. Contact us for bulk access.</p>'],
            ['slug' => 'roadmap-2025', 'title' => 'Roadmap 2025', 'meta_description' => 'ITLAB roadmap', 'content' => '<ul><li>Scaffold authentication and user profiles</li><li>Admin UI for tracks/quizzes/labs</li><li>Automated testing and CI</li></ul>'],
            ['slug' => 'blog', 'title' => 'Blog & Updates', 'meta_description' => 'ITLAB blog', 'content' => '<p>News, updates and short posts about tracks and labs (placeholder).</p>'],
            ['slug' => 'help-center', 'title' => 'Help Center', 'meta_description' => 'Help & support', 'content' => '<p>FAQs and guides to use ITLAB. If you can\'t find an answer here, contact us.</p>'],
            ['slug' => 'beginner-path', 'title' => 'Beginner Path', 'meta_description' => 'Not sure where to begin? Choose the best starting point for you.', 'content' => '<p style="color:#cbd5e1; line-height:1.7; margin-bottom: 30px;">Not sure where to begin?<br>Choose the best starting point for you.</p>
<p style="color:#cbd5e1; line-height:1.7; margin-bottom: 30px;">ITLAB gives you more than random tutorials. Below is a clear path depending on your current level and your goal. Start with one track, stay consistent, and you\'ll see real progress in a few weeks.</p>

<div style="margin: 40px 0; padding: 30px; background: rgba(255,255,255,0.05); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
    <h2 style="color: #fff; margin-bottom: 15px; font-size: 24px;">Best for absolute beginners</h2>
    <h3 style="color: #60a5fa; margin-bottom: 10px; font-size: 20px;">Web Foundations Track</h3>
    <p style="color:#cbd5e1; line-height:1.7; margin-bottom: 15px;">If you\'ve never coded before, start here. You\'ll build real pages while learning the building blocks of the web.</p>
    <ul style="color:#cbd5e1; line-height:1.7; margin-bottom: 15px; padding-left: 20px;">
        <li>HTML – Basic tags, structure, semantic layout</li>
        <li>CSS – Colors, fonts, layout, responsive design</li>
        <li>Mini Projects – Personal profile page, simple landing page</li>
    </ul>
    <p style="color:#9ca3af; margin-bottom: 15px;"><strong>2–4 weeks</strong></p>
    <p style="color:#cbd5e1; line-height:1.7; margin-bottom: 15px;">After this: you can build clean static websites.</p>
    <a href="/html" style="display: inline-block; padding: 10px 20px; background: #3b82f6; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;">Start with HTML</a>
</div>

<div style="margin: 40px 0; padding: 30px; background: rgba(255,255,255,0.05); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
    <h2 style="color: #fff; margin-bottom: 15px; font-size: 24px;">When you know the basics</h2>
    <h3 style="color: #60a5fa; margin-bottom: 10px; font-size: 20px;">JavaScript & Logic Track</h3>
    <p style="color:#cbd5e1; line-height:1.7; margin-bottom: 15px;">Already comfortable with HTML/CSS? This track focuses on programming logic and interactivity.</p>
    <ul style="color:#cbd5e1; line-height:1.7; margin-bottom: 15px; padding-left: 20px;">
        <li>Variables, conditions, functions, loops</li>
        <li>DOM basics – reacting to user input</li>
        <li>Mini Projects – counter, quiz app, simple to-do list</li>
    </ul>
    <p style="color:#9ca3af; margin-bottom: 15px;"><strong>3–5 weeks</strong></p>
    <p style="color:#cbd5e1; line-height:1.7; margin-bottom: 15px;">After this: you can build interactive pages.</p>
    <a href="/learn-js" style="display: inline-block; padding: 10px 20px; background: #3b82f6; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;">Go to JavaScript</a>
</div>

<div style="margin: 40px 0; padding: 30px; background: rgba(255,255,255,0.05); border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);">
    <h2 style="color: #fff; margin-bottom: 15px; font-size: 24px;">For security-focused learners</h2>
    <h3 style="color: #60a5fa; margin-bottom: 10px; font-size: 20px;">Cyber Security Starter Track</h3>
    <p style="color:#cbd5e1; line-height:1.7; margin-bottom: 15px;">If your goal is cyber security or ethical hacking, start with these fundamentals after you know basic web.</p>
    <ul style="color:#cbd5e1; line-height:1.7; margin-bottom: 15px; padding-left: 20px;">
        <li>Network basics – IP, ports, protocols</li>
        <li>Web app security – common vulnerabilities</li>
        <li>Hands-on labs inside ITLAB</li>
    </ul>
    <p style="color:#9ca3af; margin-bottom: 15px;"><strong>4–6 weeks</strong></p>
    <p style="color:#cbd5e1; line-height:1.7; margin-bottom: 15px;">After this: ready for deeper security labs.</p>
    <a href="/cyber-network" style="display: inline-block; padding: 10px 20px; background: #3b82f6; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;">View Security Labs</a>
</div>

<h2 style="color: #fff; margin-top: 50px; margin-bottom: 20px; font-size: 24px;">How to use this page</h2>
<ol style="color:#cbd5e1; line-height:1.7; padding-left: 20px;">
    <li style="margin-bottom: 10px;"><strong>Pick one track only.</strong><br>Don\'t try to follow everything at once. Choose the track that matches your level.</li>
    <li style="margin-bottom: 10px;"><strong>Commit to a small daily goal.</strong><br>30–60 minutes a day is more powerful than 5 hours once a week.</li>
    <li style="margin-bottom: 10px;"><strong>Build, don\'t just watch.</strong><br>Re-build the examples, then try to change them and create your own mini projects.</li>
    <li style="margin-bottom: 10px;"><strong>Ask questions.</strong><br>Use communities, Discord, or your peers to ask when you\'re stuck. Struggle is normal.</li>
</ol>

<div style="margin-top: 40px; padding: 20px; background: rgba(59, 130, 246, 0.1); border-left: 4px solid #3b82f6; border-radius: 4px;">
    <p style="color:#cbd5e1; line-height:1.7; margin: 0;"><strong>Tip:</strong> If you ever feel lost, go back to the Web Foundations Track. A strong base in HTML, CSS, and basic JavaScript will make every other topic — frameworks, back-end, or security — much easier to understand.</p>
</div>'],
            ['slug' => 'report-bug', 'title' => 'Report a Bug', 'meta_description' => 'Report an issue', 'content' => '<p>Found an issue? Describe steps to reproduce and relevant screenshots. Send to support@example.com.</p>'],
            ['slug' => 'contact', 'title' => 'Contact', 'meta_description' => 'Contact ITLAB', 'content' => '<p>Send us questions, partnership inquiries, or bug reports using the form below.</p>'],
            ['slug' => 'get-certified', 'title' => 'Get Certified', 'meta_description' => 'Certification details', 'content' => '<p>Learn about ITLAB certification paths and passing criteria for each track.</p>'],
            ['slug' => 'js-reference', 'title' => 'JavaScript Reference', 'meta_description' => 'Snippets used in ITLAB for forms, quizzes, and UI interactions', 'content' => '<p>Snippets used in ITLAB for forms, quizzes, and UI interactions. هذه الصفحة مرجع سريع للطلاب أثناء حل اللابات أو بناء صفحات جديدة.</p><p>⬅ رجوع لصفحة JavaScript الرئيسية: <a href="/js">JavaScript main page</a>.</p><pre><code>// فتح المودال
function openAuthModal() {
  document.getElementById("authBackdrop")
    .classList.add("active");
}

// ربط زر "Sign In"
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("signInBtn");
  if (btn) btn.addEventListener("click", openAuthModal);
});</code></pre>'],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
