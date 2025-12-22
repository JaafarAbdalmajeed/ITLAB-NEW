  <footer class="itlab-footer">
    <div class="footer-main">
      <!-- Brand + short description -->
      <div class="footer-brand">
        <div class="footer-logo">
          <span class="footer-logo-square">IT</span>
          <span class="footer-logo-text">LAB</span>
        </div>
        <p class="footer-brand-text">
          ITLAB is a lab-style learning platform for web development &amp; cyber security.
          Learn by doing with guided tracks, practical labs, and real-world projects.
        </p>

        <!-- Active button -->
        <a href="{{ route('pages.getting-started') }}" class="footer-cta">Join ITLAB Labs</a>
      </div>

      <!-- Links columns -->
      <div class="footer-links">
        <div class="footer-col">
          <h4>About</h4>
          <ul>
            <li><a href="{{ route('pages.about') }}">What is ITLAB?</a></li>
            <li><a href="{{ route('pages.students') }}">For Students</a></li>
            <li><a href="{{ route('pages.instructors') }}">For Instructors</a></li>
            <li><a href="{{ route('pages.roadmap') }}">Roadmap 2025</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Tracks</h4>
          <ul>
            <li><a href="{{ route('pages.html.track') }}">HTML &amp; CSS Basics</a></li>
            <li><a href="{{ route('pages.js.track') }}">JavaScript Essentials</a></li>
            <li><a href="{{ route('pages.cyber-network') }}">Network Security</a></li>
            <li><a href="{{ route('pages.cyber-web') }}">Web Application Security</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Resources</h4>
          <ul>
            <li><a href="{{ route('pages.beginner-path') }}">Beginner Path</a></li>
            <li><a href="{{ route('pages.html.reference') }}">Cheat Sheets</a></li>
            <li><a href="{{ route('pages.labs') }}">Practice Labs</a></li>
            <li><a href="{{ route('pages.blog') }}">Blog &amp; Updates</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h4>Support</h4>
          <ul>
            <li><a href="{{ route('pages.help') }}">Help Center</a></li>
            <li><a href="{{ route('pages.help') }}">Discord Community</a></li>
            <li><a href="{{ route('pages.report-bug') }}">Report a Bug</a></li>
            <li><a href="{{ route('pages.contact') }}">Contact Us</a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- bottom bar -->
    <div class="footer-bottom">
      <div class="footer-bottom-left">
        <span>© 2025 ITLAB. All rights reserved.</span>
        <span class="footer-divider">•</span>
        <span>Made with ❤ for learners.</span>
      </div>

      <div class="footer-bottom-right">
        <div class="footer-social">
          <a href="https://facebook.com/itlab" target="_blank" aria-label="ITLAB on Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="https://x.com/itlab" target="_blank" aria-label="ITLAB on X"><i class="fab fa-x-twitter"></i></a>
          <a href="https://instagram.com/itlab" target="_blank" aria-label="ITLAB on Instagram"><i class="fab fa-instagram"></i></a>
          <a href="https://linkedin.com/company/itlab" target="_blank" aria-label="ITLAB on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://github.com/itlab" target="_blank" aria-label="ITLAB on GitHub"><i class="fab fa-github"></i></a>
        </div>
      </div>
    </div>
  </footer>
