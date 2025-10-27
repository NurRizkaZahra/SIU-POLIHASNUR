<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        
        sidebar.classList.toggle('closed');
        mainContent.classList.toggle('expanded');
    }

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

    // Tutup sidebar saat klik di luar sidebar pada mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.querySelector('.sidebar');
        const menuToggle = document.querySelector('.menu-toggle');
        
        if (!sidebar.contains(event.target) && 
            !menuToggle.contains(event.target) && 
            window.innerWidth < 768 && 
            !sidebar.classList.contains('closed')) {
            toggleSidebar();
        }
    });
</script>