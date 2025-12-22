<?php

namespace Database\Seeders;

use App\Models\Track;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Lab;
use Illuminate\Database\Seeder;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure cyber tracks exist with predictable slugs so CyberController can find them
        $cyberNetwork = Track::firstOrCreate(
            ['slug' => 'cyber-network'],
            ['title' => 'Network Security', 'description' => 'Hands-on network security labs and practical packet analysis.']
        );

        $cyberWeb = Track::firstOrCreate(
            ['slug' => 'cyber-web'],
            ['title' => 'Web Application Security', 'description' => 'Learn common web vulnerabilities and how to defend against them.']
        );

        // Add a simple quiz and a lab to each cyber track if missing
        if ($cyberNetwork->quizzes()->count() === 0) {
            $q = Quiz::create(['track_id' => $cyberNetwork->id, 'title' => 'Network Basics Quiz']);
            QuizQuestion::create([ 'quiz_id' => $q->id, 'question' => 'Which device is used to separate networks and filter traffic?', 'option_a' => 'Switch', 'option_b' => 'Firewall', 'option_c' => 'Access Point', 'correct_answer' => 'b' ]);
            QuizQuestion::create([ 'quiz_id' => $q->id, 'question' => 'Which protocol is secure for remote login?', 'option_a' => 'Telnet', 'option_b' => 'SSH', 'option_c' => 'FTP', 'correct_answer' => 'b' ]);
            QuizQuestion::create([ 'quiz_id' => $q->id, 'question' => 'In Wireshark, which field identifies machines?', 'option_a' => 'MAC address', 'option_b' => 'IP address', 'option_c' => 'Port', 'correct_answer' => 'b' ]);
        }
        if ($cyberNetwork->labs()->count() === 0) {
            Lab::create(['track_id' => $cyberNetwork->id, 'title' => 'Packet Capture Lab', 'scenario' => 'Capture HTTP traffic with Wireshark and identify insecure credentials.']);
        }

        if ($cyberWeb->quizzes()->count() === 0) {
            $q = Quiz::create(['track_id' => $cyberWeb->id, 'title' => 'Web Security Basics Quiz']);
            QuizQuestion::create([ 'quiz_id' => $q->id, 'question' => 'SQL Injection happens when...', 'option_a' => 'Input is validated', 'option_b' => 'Input is concatenated into SQL', 'option_c' => 'Database is encrypted', 'correct_answer' => 'b' ]);
            QuizQuestion::create([ 'quiz_id' => $q->id, 'question' => 'XSS allows an attacker to...', 'option_a' => 'Inject JS in browser', 'option_b' => 'Sniff traffic', 'option_c' => 'Crack Wi-Fi', 'correct_answer' => 'a' ]);
            QuizQuestion::create([ 'quiz_id' => $q->id, 'question' => 'Best protection against SQLi is...', 'option_a' => 'Parameterized queries', 'option_b' => 'Client validation', 'option_c' => 'Long passwords', 'correct_answer' => 'a' ]);
        }
        if ($cyberWeb->labs()->count() === 0) {
            Lab::create(['track_id' => $cyberWeb->id, 'title' => 'SQL Injection Lab', 'scenario' => 'Find and fix an SQL injection vulnerability in a sample app.']);
        }

        // Ensure basic subject tracks exist (HTML/CSS/JS)
        $html = Track::firstOrCreate(
            ['slug' => 'html'],
            ['title' => 'HTML', 'description' => 'HTML tutorials, reference, and quizzes.']
        );
        if ($html->quizzes()->count() === 0) {
            $q = Quiz::create(['track_id' => $html->id, 'title' => 'HTML Quiz']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'What does HTML stand for?', 'option_a' => 'Home Tool Markup Language', 'option_b' => 'HyperText Markup Language', 'option_c' => 'Hyperlinks and Text Making Language', 'correct_answer' => 'b']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which tag defines the main content visible to the user?', 'option_a' => '&lt;head&gt;', 'option_b' => '&lt;body&gt;', 'option_c' => '&lt;html&gt;', 'correct_answer' => 'b']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which tag is used to create a hyperlink?', 'option_a' => '&lt;link&gt;', 'option_b' => '&lt;a&gt;', 'option_c' => '&lt;href&gt;', 'correct_answer' => 'b']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which element is best for grouping a section like the hero in ITLAB?', 'option_a' => '&lt;div&gt;', 'option_b' => '&lt;section&gt;', 'option_c' => '&lt;span&gt;', 'correct_answer' => 'b']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which tag pair is used to show code blocks (like examples)?', 'option_a' => '&lt;code&gt; + &lt;pre&gt;', 'option_b' => '&lt;strong&gt; + &lt;em&gt;', 'option_c' => '&lt;ul&gt; + &lt;li&gt;', 'correct_answer' => 'a']);
        }

        $css = Track::firstOrCreate(
            ['slug' => 'css'],
            ['title' => 'CSS', 'description' => 'Styling fundamentals and layout techniques.']
        );
        if ($css->quizzes()->count() === 0) {
            $q = Quiz::create(['track_id' => $css->id, 'title' => 'CSS Quiz']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which property changes the background color?', 'option_a' => 'color', 'option_b' => 'background-color', 'option_c' => 'border-color', 'correct_answer' => 'b']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which layout is used to align items horizontally in the navbar?', 'option_a' => 'grid', 'option_b' => 'flex', 'option_c' => 'block', 'correct_answer' => 'b']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'To make buttons rounded like ITLAB, which property do we use?', 'option_a' => 'border-radius', 'option_b' => 'text-align', 'option_c' => 'padding', 'correct_answer' => 'a']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which selector targets elements with class "hero"?', 'option_a' => 'hero', 'option_b' => '.hero', 'option_c' => '#hero', 'correct_answer' => 'b']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which property adds inner space inside a button?', 'option_a' => 'padding', 'option_b' => 'margin', 'option_c' => 'gap', 'correct_answer' => 'a']);
        }

        $js = Track::firstOrCreate(
            ['slug' => 'js'],
            ['title' => 'JavaScript', 'description' => 'Client-side programming and DOM manipulation.']
        );
        if ($js->quizzes()->count() === 0) {
            $q = Quiz::create(['track_id' => $js->id, 'title' => 'JavaScript Quiz']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which keyword declares a variable that can change?', 'option_a' => 'const', 'option_b' => 'let', 'option_c' => 'static', 'correct_answer' => 'b']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which method is used to select an element by its id?', 'option_a' => 'querySelectorAll()', 'option_b' => 'getElementById()', 'option_c' => 'getElementsByClassName()', 'correct_answer' => 'b']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which event do we use when a button is clicked?', 'option_a' => 'change', 'option_b' => 'click', 'option_c' => 'submit', 'correct_answer' => 'b']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'How do we prevent a form from submitting and reloading the page?', 'option_a' => 'event.stop()', 'option_b' => 'event.preventDefault()', 'option_c' => 'return false without event', 'correct_answer' => 'b']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which type is returned by document.querySelector()?', 'option_a' => 'A single Element', 'option_b' => 'An array of elements', 'option_c' => 'A string', 'correct_answer' => 'a']);
        }

        $java = Track::firstOrCreate(
            ['slug' => 'java'],
            ['title' => 'Java', 'description' => 'Learn Java programming language - object-oriented programming, classes, methods, and more.']
        );
        if ($java->quizzes()->count() === 0) {
            $q = Quiz::create(['track_id' => $java->id, 'title' => 'Java Quiz']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'What is the correct way to print "Hello World" in Java?', 'option_a' => 'System.out.print("Hello World")', 'option_b' => 'System.out.println("Hello World")', 'option_c' => 'print("Hello World")', 'correct_answer' => 'b']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which keyword is used to create a class in Java?', 'option_a' => 'class', 'option_b' => 'Class', 'option_c' => 'className', 'correct_answer' => 'a']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'What is the entry point of a Java program?', 'option_a' => 'main() method', 'option_b' => 'start() method', 'option_c' => 'run() method', 'correct_answer' => 'a']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'Which data type is used to store whole numbers in Java?', 'option_a' => 'float', 'option_b' => 'int', 'option_c' => 'String', 'correct_answer' => 'b']);
            QuizQuestion::create(['quiz_id' => $q->id, 'question' => 'What does OOP stand for in Java?', 'option_a' => 'Object-Oriented Programming', 'option_b' => 'Object-Optimized Program', 'option_c' => 'Object-Ordered Process', 'correct_answer' => 'a']);
        }
        if ($java->labs()->count() === 0) {
            Lab::create(['track_id' => $java->id, 'title' => 'Java Basics Lab', 'scenario' => 'Create a simple Java program that prints "Hello World" and demonstrates basic variable usage.']);
        }

        // Create 4 example tracks
        $tracks = Track::factory()->count(4)->create();

        foreach ($tracks as $track) {
            // Lessons
            Lesson::factory()->count(6)->create(['track_id' => $track->id]);

            // Quizzes and questions
            $quizzes = Quiz::factory()->count(2)->create(['track_id' => $track->id]);
            foreach ($quizzes as $quiz) {
                QuizQuestion::factory()->count(5)->create(['quiz_id' => $quiz->id]);
            }

            // Labs
            Lab::factory()->count(1)->create(['track_id' => $track->id]);
        }
    }
}
