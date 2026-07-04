<script>
    /* =====================
       SIDEBAR TOGGLE
    ===================== */
    function toggleSidebar() {
        const sidebar = document.getElementById('mainSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const mainContent = document.querySelector('.main-content');
        const isMobile = window.innerWidth <= 768;

        if (isMobile) {
            // Mobile: slide in/out dengan overlay backdrop
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        } else {
            // Desktop: sidebar geser ke kiri, main-content mengembang
            sidebar.classList.toggle('closed');
            mainContent.classList.toggle('expanded');
        }
    }

    function closeSidebar() {
        document.getElementById('mainSidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('show');
    }

    // Tutup sidebar otomatis saat klik menu link di mobile
    document.querySelectorAll('.menu-link').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) closeSidebar();
        });
    });

    // Bersihkan state yang tidak sesuai saat resize
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('mainSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const mainContent = document.querySelector('.main-content');

        if (window.innerWidth > 768) {
            // Kembali ke desktop: hapus state mobile
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        } else {
            // Kembali ke mobile: hapus state desktop
            sidebar.classList.remove('closed');
            mainContent.classList.remove('expanded');
        }
    });

    /* =====================
       PROFILE DROPDOWN
    ===================== */
    function toggleProfileDropdown() {
        document.getElementById('profileDropdown').classList.toggle('show');
    }

    // Tutup dropdown saat klik di luar area
    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profileDropdown');
        const profileBtn = document.querySelector('.profile-dropdown .icon-btn');

        if (dropdown && profileBtn &&
            !dropdown.contains(e.target) &&
            !profileBtn.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });

    /* =====================
       ACCORDION / STEP
    ===================== */
    function toggleStep(element) {
        element.querySelector('.step-content').classList.toggle('open');
        element.querySelector('.chevron-icon').classList.toggle('open');
    }

    function toggleFormSection(header) {
        header.nextElementSibling.classList.toggle('open');
        header.querySelector('.chevron-icon').classList.toggle('open');
    }

    function saveSection(sectionName) {
        alert('Data ' + sectionName + ' berhasil disimpan!');
    }
</script>
