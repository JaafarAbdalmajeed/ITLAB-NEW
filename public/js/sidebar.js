// Sidebar functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    
    // Create toggle button if it doesn't exist (for mobile)
    if (!sidebarToggle && sidebar) {
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'sidebar-toggle';
        toggleBtn.innerHTML = '<i class="fa-solid fa-bars"></i>';
        toggleBtn.setAttribute('aria-label', 'Toggle sidebar');
        document.body.appendChild(toggleBtn);
        
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            if (sidebarOverlay) {
                sidebarOverlay.classList.toggle('active');
            }
        });
    }
    
    // Create overlay if it doesn't exist
    if (!sidebarOverlay && sidebar) {
        const overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        document.body.appendChild(overlay);
        
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
    }
    
    // Handle existing toggle button
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            if (sidebar) {
                sidebar.classList.toggle('active');
            }
            if (sidebarOverlay) {
                sidebarOverlay.classList.toggle('active');
            }
        });
    }
    
    // Keep sidebar open on desktop when clicking links
    const isMobile = window.innerWidth <= 1024;
    if (!isMobile && sidebar) {
        sidebar.classList.add('active');
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        const currentIsMobile = window.innerWidth <= 1024;
        if (!currentIsMobile && sidebar) {
            sidebar.classList.add('active');
            if (sidebarOverlay) {
                sidebarOverlay.classList.remove('active');
            }
        }
    });
    
    // Sidebar section toggle functionality
    document.querySelectorAll('.sidebar-section-title').forEach(function(title) {
        title.addEventListener('click', function() {
            const toggleId = this.getAttribute('data-toggle');
            const content = document.getElementById(toggleId + 'Content');
            const icon = this.querySelector('i');
            
            if (content) {
                const isActive = content.classList.contains('active');
                
                // Toggle active class
                if (isActive) {
                    content.classList.remove('active');
                    this.classList.remove('active');
                    if (icon) {
                        icon.style.transform = 'rotate(0deg)';
                    }
                } else {
                    content.classList.add('active');
                    this.classList.add('active');
                    if (icon) {
                        icon.style.transform = 'rotate(90deg)';
                    }
                }
            }
        });
    });

    // Sidebar search functionality
    const searchInput = document.getElementById('sidebarSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            const links = document.querySelectorAll('.sidebar-link');
            const sections = document.querySelectorAll('.sidebar-section-content');
            
            if (searchTerm === '') {
                // Show all links and sections when search is empty
                links.forEach(function(link) {
                    link.style.display = 'block';
                });
                sections.forEach(function(section) {
                    section.style.display = '';
                });
                return;
            }
            
            // Track which sections have visible links
            const sectionsWithMatches = new Set();
            
            links.forEach(function(link) {
                const text = link.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    link.style.display = 'block';
                    // Find the parent section
                    const section = link.closest('.sidebar-section-content');
                    if (section) {
                        sectionsWithMatches.add(section);
                    }
                } else {
                    link.style.display = 'none';
                }
            });
            
            // Show/hide sections based on whether they have matches
            sections.forEach(function(section) {
                if (sectionsWithMatches.has(section)) {
                    section.style.display = 'block';
                    // Also show the section title
                    const sectionTitle = section.previousElementSibling;
                    if (sectionTitle && sectionTitle.classList.contains('sidebar-section-title')) {
                        sectionTitle.style.display = 'flex';
                    }
                } else {
                    // Check if this section should be hidden
                    const visibleLinks = section.querySelectorAll('.sidebar-link[style*="display: block"], .sidebar-link:not([style*="display: none"])');
                    if (visibleLinks.length === 0 && searchTerm !== '') {
                        section.style.display = 'none';
                        const sectionTitle = section.previousElementSibling;
                        if (sectionTitle && sectionTitle.classList.contains('sidebar-section-title')) {
                            sectionTitle.style.display = 'none';
                        }
                    }
                }
            });
        });
        
        // Clear search on Escape key
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                this.dispatchEvent(new Event('input'));
                this.blur();
            }
        });
    }

    // Active link highlighting (optional - for hash links)
    document.querySelectorAll('.sidebar-link[href^="#"]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            // Remove active class from all links in the same section
            const section = this.closest('.sidebar-section-content');
            if (section) {
                section.querySelectorAll('.sidebar-link').forEach(function(l) {
                    l.classList.remove('active');
                });
            }
            // Add active class to clicked link
            this.classList.add('active');
        });
    });
});

