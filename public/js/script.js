// Open modal - make it globally available
window.openAuthModal = function() {
  const backdrop = document.getElementById("authBackdrop");
  if (backdrop) {
    backdrop.classList.add("active");
    // Also ensure body doesn't scroll when modal is open
    document.body.style.overflow = 'hidden';
  } else {
    console.error('Auth backdrop not found!');
  }
};

// Also create a regular function for backward compatibility
function openAuthModal() {
  window.openAuthModal();
}

// Close modal - make it globally available
window.closeAuthModal = function() {
  const backdrop = document.getElementById("authBackdrop");
  if (backdrop) {
    backdrop.classList.remove("active");
    // Restore body scroll
    document.body.style.overflow = '';
  }
};

// Also create a regular function for backward compatibility
function closeAuthModal() {
  window.closeAuthModal();
}

// Switch between login / signup - make it globally available
window.switchAuthTab = function(type) {
  const tabLogin = document.getElementById("tabLogin");
  const tabSignup = document.getElementById("tabSignup");
  const formLogin = document.getElementById("loginForm");
  const formSignup = document.getElementById("signupForm");

  if (!tabLogin || !tabSignup || !formLogin || !formSignup) return;

  if (type === "login") {
    tabLogin.classList.add("active");
    tabSignup.classList.remove("active");
    formLogin.classList.remove("hidden");
    formSignup.classList.add("hidden");
  } else {
    tabLogin.classList.remove("active");
    tabSignup.classList.add("active");
    formLogin.classList.add("hidden");
    formSignup.classList.remove("hidden");
  }
};

// Also create a regular function for backward compatibility
function switchAuthTab(type) {
  window.switchAuthTab(type);
}

// Handle login form submission
function handleLoginSubmit(event) {
  // Let the form submit naturally to the backend
  // The form already has action and method set
  // No need to prevent default or show demo message
}

// Handle signup form submission
function handleSignupSubmit(event) {
  // Let the form submit naturally to the backend
  // The form already has action and method set
  // No need to prevent default or show demo message
}

// Social provider redirects are handled via direct links in the views
// No need for handleProvider function anymore as we use direct route links

// Bind events after page load
window.addEventListener("DOMContentLoaded", () => {
  // Get forms once
  const loginForm = document.getElementById('loginForm');
  const signupForm = document.getElementById('signupForm');
  
  // Check for errors in login form
  if (loginForm) {
    const loginErrors = loginForm.querySelector('[style*="background: #f8d7da"]');
    if (loginErrors) {
      openAuthModal();
      switchAuthTab('login');
    }
    // Add submit handler
    loginForm.addEventListener("submit", handleLoginSubmit);
  }
  
  // Check for errors in signup form
  if (signupForm) {
    const signupErrors = signupForm.querySelector('[style*="background: #f8d7da"]');
    if (signupErrors) {
      openAuthModal();
      switchAuthTab('signup');
    }
    // Add submit handler
    signupForm.addEventListener("submit", handleSignupSubmit);
  }

  // Sign In button in header - try multiple ways to ensure it works
  const signBtn = document.getElementById("signInBtn");
  if (signBtn) {
    signBtn.addEventListener("click", function(e) {
      e.preventDefault();
      e.stopPropagation();
      openAuthModal();
    });
    // Also add onclick as fallback
    signBtn.onclick = function(e) {
      e.preventDefault();
      e.stopPropagation();
      openAuthModal();
    };
  } else {
    console.error('Sign In button not found!');
  }

  // X button to close modal
  const closeBtn = document.getElementById("authCloseBtn");
  if (closeBtn) closeBtn.addEventListener("click", closeAuthModal);

  // Close when clicking outside modal
  const backdrop = document.getElementById("authBackdrop");
  if (backdrop) {
    backdrop.addEventListener("click", (e) => {
      if (e.target === backdrop) closeAuthModal();
    });
  }

  // Tab buttons Login / Sign Up
  const tabLogin = document.getElementById("tabLogin");
  const tabSignup = document.getElementById("tabSignup");
  if (tabLogin) tabLogin.addEventListener("click", () => switchAuthTab("login"));
  if (tabSignup) tabSignup.addEventListener("click", () => switchAuthTab("signup"));

  // Google / LinkedIn buttons
  document.querySelectorAll("[data-provider]").forEach((btn) => {
    btn.addEventListener("click", () => handleProvider(btn.dataset.provider));
  });

  // Try it Yourself buttons (demo for code in card)
  document.querySelectorAll("[data-try-example]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const type = btn.dataset.tryExample;
      alert("Demo: Opens editor or page to try example " + type + ".");
    });
  });
});
