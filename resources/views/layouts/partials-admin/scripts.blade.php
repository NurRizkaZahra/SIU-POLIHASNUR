<script>
    /* ══════════════════════════════════════
       SIDEBAR TOGGLE
       - Desktop  : geser margin main-content
       - Mobile   : slide-in sidebar + tampilkan overlay
    ══════════════════════════════════════ */
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        const overlay = document.getElementById('sidebarOverlay');

        const isMobile = window.innerWidth <= 768;

        if (isMobile) {
            /* Mobile: sidebar mulai closed, toggle dengan menghapus/menambah 'closed' */
            sidebar.classList.toggle('closed');
            const isOpen = !sidebar.classList.contains('closed');
            if (overlay) overlay.classList.toggle('show', isOpen);
        } else {
            /* Desktop: toggle seperti semula */
            sidebar.classList.toggle('closed');
            if (mainContent) mainContent.classList.toggle('expanded');
        }
    }

    /* Tutup sidebar saat navigasi di mobile */
    function closeSidebarOnMobile() {
        if (window.innerWidth <= 768) {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.add('closed');
            if (overlay) overlay.classList.remove('show');
        }
    }

    /* Tutup sidebar saat resize ke desktop supaya layout tidak kacau */
    window.addEventListener('resize', function() {
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        const overlay = document.getElementById('sidebarOverlay');

        if (window.innerWidth > 768) {
            /* Kembali ke desktop: pastikan sidebar terlihat */
            sidebar.classList.remove('closed');
            if (mainContent) mainContent.classList.remove('expanded');
            if (overlay) overlay.classList.remove('show');
        } else {
            /* Kembali ke mobile: sembunyikan sidebar secara default */
            sidebar.classList.add('closed');
            if (overlay) overlay.classList.remove('show');
        }
    });

    /* Inisialisasi: sembunyikan sidebar saat pertama kali di mobile */
    (function initSidebar() {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar && window.innerWidth <= 768) {
            sidebar.classList.add('closed');
        }
    })();

    /* ══════════════════════════════════════
       ACCORDION STEPS
    ══════════════════════════════════════ */
    function toggleStep(element) {
        const content = element.querySelector('.step-content');
        const chevron = element.querySelector('.chevron-icon');
        content.classList.toggle('open');
        chevron.classList.toggle('open');
    }

    function toggleFormSection(header) {
        const body = header.nextElementSibling;
        const chevron = header.querySelector('.chevron-icon');
        body.classList.toggle('open');
        chevron.classList.toggle('open');
    }

    function saveSection(sectionName) {
        alert('Data ' + sectionName + ' berhasil disimpan!');
    }
</script>
