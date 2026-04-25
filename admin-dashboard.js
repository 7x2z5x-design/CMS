// Mobile Menu Toggle
function toggleMobileMenu() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (sidebar) {
        sidebar.classList.toggle('active');
    }
}

// Initialize mobile menu toggle button
function initializeMobileMenu() {
    // Create mobile menu toggle button
    const toggleBtn = document.createElement('button');
    toggleBtn.className = 'mobile-menu-toggle';
    toggleBtn.innerHTML = `
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
    `;
    toggleBtn.addEventListener('click', toggleMobileMenu);
    
    // Insert toggle button at the beginning of main content
    const mainContent = document.querySelector('.main-content');
    if (mainContent && window.innerWidth <= 1024) {
        mainContent.insertBefore(toggleBtn, mainContent.firstChild);
    }
}

// Search functionality
function initializeSearch() {
    const searchInput = document.querySelector('.search-input');
    const tableRows = document.querySelectorAll('.table-row');
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            tableRows.forEach(row => {
                const userName = row.querySelector('.user-name')?.textContent.toLowerCase() || '';
                const userEmail = row.querySelector('.user-email')?.textContent.toLowerCase() || '';
                const role = row.querySelector('.role-badge')?.textContent.toLowerCase() || '';
                
                const matchesSearch = userName.includes(searchTerm) || 
                                   userEmail.includes(searchTerm) || 
                                   role.includes(searchTerm);
                
                row.style.display = matchesSearch ? '' : 'none';
            });
        });
    }
}

// Notification functionality
function initializeNotifications() {
    const notificationBtn = document.querySelector('.notification-btn');
    
    if (notificationBtn) {
        notificationBtn.addEventListener('click', function() {
            // Simple notification dropdown (you can expand this)
            alert('You have 3 new notifications!');
        });
    }
}

// Action buttons functionality
function initializeActionButtons() {
    // Edit buttons
    const editButtons = document.querySelectorAll('.action-btn.edit');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const userRow = this.closest('.table-row');
            const userName = userRow.querySelector('.user-name').textContent;
            console.log('Edit user:', userName);
            // You can expand this to open an edit modal
        });
    });
    
    // Delete buttons
    const deleteButtons = document.querySelectorAll('.action-btn.delete');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const userRow = this.closest('.table-row');
            const userName = userRow.querySelector('.user-name').textContent;
            
            if (confirm(`Are you sure you want to delete ${userName}?`)) {
                // Add fade out animation
                userRow.style.transition = 'opacity 0.3s ease';
                userRow.style.opacity = '0';
                
                setTimeout(() => {
                    userRow.remove();
                    updateStats();
                }, 300);
            }
        });
    });
}

// Add new user functionality
function initializeAddUserButton() {
    const addBtn = document.querySelector('.btn-primary');
    
    if (addBtn) {
        addBtn.addEventListener('click', function() {
            const userName = prompt('Enter user name:');
            const userEmail = prompt('Enter user email:');
            
            if (userName && userEmail) {
                addUserToTable(userName, userEmail);
            }
        });
    }
}

// Add user to table
function addUserToTable(name, email) {
    const tableBody = document.querySelector('.user-table tbody');
    const initials = name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
    
    const newRow = document.createElement('tr');
    newRow.className = 'table-row fade-in';
    newRow.innerHTML = `
        <td>
            <div class="user-info">
                <div class="user-avatar">${initials}</div>
                <div class="user-details">
                    <div class="user-name">${name}</div>
                    <div class="user-email">${email}</div>
                </div>
            </div>
        </td>
        <td>
            <span class="role-badge viewer">Viewer</span>
        </td>
        <td>
            <span class="status-badge active">Active</span>
        </td>
        <td>
            <div class="joined-date">${new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</div>
        </td>
        <td>
            <div class="action-buttons">
                <button class="action-btn edit">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                </button>
                <button class="action-btn delete">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                </button>
            </div>
        </td>
    `;
    
    tableBody.appendChild(newRow);
    updateStats();
    
    // Re-initialize action buttons for the new row
    const newEditBtn = newRow.querySelector('.action-btn.edit');
    const newDeleteBtn = newRow.querySelector('.action-btn.delete');
    
    newEditBtn.addEventListener('click', function() {
        console.log('Edit user:', name);
    });
    
    newDeleteBtn.addEventListener('click', function() {
        if (confirm(`Are you sure you want to delete ${name}?`)) {
            newRow.style.transition = 'opacity 0.3s ease';
            newRow.style.opacity = '0';
            setTimeout(() => {
                newRow.remove();
                updateStats();
            }, 300);
        }
    });
}

// Update stats cards
function updateStats() {
    const totalUsers = document.querySelectorAll('.table-row').length;
    const activeUsers = document.querySelectorAll('.status-badge.active').length;
    const inactiveUsers = document.querySelectorAll('.status-badge.inactive').length;
    
    // Update total users
    const totalStat = document.querySelector('.stat-number');
    if (totalStat) {
        totalStat.textContent = totalUsers.toLocaleString();
    }
    
    // Update active users
    const activeStat = document.querySelectorAll('.stat-number')[1];
    if (activeStat) {
        activeStat.textContent = activeUsers.toLocaleString();
    }
    
    // Update inactive users
    const inactiveStat = document.querySelectorAll('.stat-number')[2];
    if (inactiveStat) {
        inactiveStat.textContent = inactiveUsers.toLocaleString();
    }
}

// Navigation active state
function initializeNavigation() {
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all nav items
            navLinks.forEach(l => l.parentElement.classList.remove('active'));
            
            // Add active class to clicked nav item
            this.parentElement.classList.add('active');
            
            // Update page title
            const linkText = this.querySelector('span').textContent;
            const pageTitle = document.querySelector('.page-title');
            if (pageTitle) {
                pageTitle.textContent = linkText;
            }
        });
    });
}

// Profile avatar functionality
function initializeProfileAvatar() {
    const avatar = document.querySelector('.avatar-circle');
    
    if (avatar) {
        avatar.addEventListener('click', function() {
            alert('Profile menu would open here');
        });
    }
}

// Handle window resize
function handleResize() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    
    if (window.innerWidth > 1024) {
        // Desktop view
        if (sidebar) {
            sidebar.classList.remove('active');
        }
        if (mainContent) {
            mainContent.style.marginLeft = '280px';
        }
        if (mobileToggle) {
            mobileToggle.remove();
        }
    } else {
        // Mobile/tablet view
        if (mainContent) {
            mainContent.style.marginLeft = '0';
        }
        if (!mobileToggle) {
            initializeMobileMenu();
        }
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeMobileMenu();
    initializeSearch();
    initializeNotifications();
    initializeActionButtons();
    initializeAddUserButton();
    initializeNavigation();
    initializeProfileAvatar();
    updateStats();
});

// Handle window resize
window.addEventListener('resize', handleResize);

// Close mobile menu when clicking outside
document.addEventListener('click', function(e) {
    const sidebar = document.querySelector('.sidebar');
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    
    if (window.innerWidth <= 1024 && 
        sidebar && 
        sidebar.classList.contains('active') &&
        !sidebar.contains(e.target) &&
        (!mobileToggle || !mobileToggle.contains(e.target))) {
        sidebar.classList.remove('active');
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K for search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.focus();
        }
    }
    
    // Escape to close mobile menu
    if (e.key === 'Escape') {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    }
});
