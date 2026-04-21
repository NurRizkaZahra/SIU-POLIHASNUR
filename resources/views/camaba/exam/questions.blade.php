@extends('layouts.app')

@section('page-title', 'UJIAN')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Disable text selection */
    .exam-wrapper {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .no-select {
        user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }

    .exam-wrapper {
        background: #f5f7fa;
        min-height: 100vh;
        padding: 1.5rem;
    }

    /* Info Bar */
    .exam-info-bar {
        background: white;
        padding: 1.25rem 1.75rem;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        flex-wrap: wrap;
        gap: 1rem;
    }

    .session-badge {
        background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
        color: white;
        padding: 0.6rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .progress-section {
        flex: 1;
        max-width: 350px;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .progress-bar-wrapper {
        flex: 1;
        height: 10px;
        background: #e0e0e0;
        border-radius: 20px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #27ae60 0%, #2ecc71 100%);
        border-radius: 20px;
        transition: width 0.5s ease;
    }

    .progress-text {
        font-weight: 600;
        color: #27ae60;
        min-width: 45px;
        text-align: right;
        font-size: 0.9rem;
    }

    .timer-section {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f8f9fa;
        padding: 0.65rem 1.15rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1.05rem;
    }

    .timer-icon {
        width: 20px;
        height: 20px;
    }

    /* Main Container */
    .exam-container {
        display: flex;
        gap: 1.5rem;
    }

    /* Question Navigation Sidebar */
    .question-sidebar {
        width: 260px;
        background: white;
        border-radius: 10px;
        padding: 1.25rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        height: fit-content;
        position: sticky;
        top: 1.5rem;
    }

    .sidebar-title {
        font-size: 1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e0e0e0;
    }

    .question-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 8px;
    }

    .question-number-box {
        aspect-ratio: 1;
        background: #e74c3c;
        color: white;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 3px solid transparent;
    }

    .question-number-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .question-number-box.answered {
        background: #27ae60;
    }

    .question-number-box.active {
        border-color: #f39c12;
        box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.3);
    }

    /* Question Content */
    .question-content-area {
        flex: 1;
    }

    .question-card {
        background: white;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
    }

    /* ===== VIDEO CONTAINER ===== */
    .video-container {
        margin-bottom: 1.5rem;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .video-container video {
        width: 100%;
        max-width: 100%;
        max-height: 360px;
        display: block;
        object-fit: contain;
        background: #000;
    }

    .video-container iframe {
        display: block;
        width: 100%;
        height: 360px;
        border: none;
        border-radius: 10px;
    }

    /* ===== QUESTION IMAGES ===== */
    .question-image-wrap {
        margin-top: 12px;
        text-align: left;
    }

    .question-image-wrap img {
        max-width: 280px;
        width: 100%;
        max-height: 200px;
        height: auto;
        object-fit: contain;
        border-radius: 8px;
        display: block;
        border: 1px solid #e0e0e0;
    }

    /* ===== OPTION IMAGES ===== */
    .option-image-wrap {
        margin-top: 6px;
    }

    .option-image-wrap img {
        max-width: 120px;
        max-height: 80px;
        width: auto;
        height: auto;
        object-fit: contain;
        border-radius: 6px;
        display: block;
        border: 1px solid #e0e0e0;
    }

    /* Question Header */
    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e0e0e0;
    }

    .question-number-label {
        font-size: 0.9rem;
        color: #7f8c8d;
        font-weight: 500;
    }

    .question-type-badge {
        padding: 0.45rem 0.9rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-pu {
        background: #d4edda;
        color: #155724;
    }

    .badge-psi {
        background: #d1ecf1;
        color: #0c5460;
    }

    .question-text {
        font-size: 1.05rem;
        line-height: 1.7;
        color: #2c3e50;
        margin-bottom: 1.75rem;
        font-weight: 500;
    }

    /* Options */
    .options-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }

    .option-item {
        background: #f8f9fa;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 0.9rem 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: flex-start;
    }

    .option-item:hover {
        background: #e8f4f8;
        border-color: #2980b9;
        transform: translateX(5px);
    }

    .option-item.selected {
        background: #d4edda;
        border-color: #27ae60;
        box-shadow: 0 2px 8px rgba(39, 174, 96, 0.2);
    }

    .option-item input[type="radio"] {
        display: none;
    }

    .option-label {
        display: flex;
        align-items: flex-start;
        gap: 0.9rem;
        cursor: pointer;
        width: 100%;
    }

    .option-letter {
        width: 34px;
        height: 34px;
        background: white;
        border: 2px solid #2980b9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #2980b9;
        font-size: 0.95rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .option-item.selected .option-letter {
        background: #27ae60;
        border-color: #27ae60;
        color: white;
    }

    .option-text {
        flex: 1;
        font-size: 0.95rem;
        color: #2c3e50;
        line-height: 1.5;
    }

    /* Navigation Buttons */
    .navigation-controls {
        background: white;
        padding: 1.25rem 1.75rem;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }

    .btn-exam {
        padding: 0.75rem 1.75rem;
        border: none;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-exam:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-exam svg {
        width: 16px;
        height: 16px;
    }

    .btn-prev {
        background: #cdbf07;
        color: white;
    }

    .btn-prev:hover:not(:disabled) {
        background: #b8aa06;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(127, 140, 141, 0.3);
    }

    .btn-next {
        background: linear-gradient(135deg, #2980b9 0%, #3498db 100%);
        color: white;
    }

    .btn-next:hover:not(:disabled) {
        background: linear-gradient(135deg, #1e5f8c 0%, #2980b9 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(41, 128, 185, 0.3);
    }

    .btn-submit {
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        color: white;
    }

    .btn-submit:hover:not(:disabled) {
        background: linear-gradient(135deg, #1e8449 0%, #27ae60 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
    }

    /* Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .modal-box {
        background: white;
        padding: 2.25rem;
        border-radius: 14px;
        max-width: 480px;
        width: 90%;
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from { opacity: 0; transform: translateY(-50px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .modal-box h3 {
        color: #2c3e50;
        margin-bottom: 1rem;
        font-size: 1.4rem;
    }

    .modal-box p {
        color: #555;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .modal-warning {
        color: #e74c3c;
        font-weight: 600;
    }

    .modal-buttons {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn-modal {
        padding: 0.7rem 1.4rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel  { background: #95a5a6; color: white; }
    .btn-cancel:hover  { background: #7f8c8d; }
    .btn-confirm { background: #27ae60; color: white; }
    .btn-confirm:hover { background: #1e8449; }

    /* Responsive */
    @media (max-width: 1024px) {
        .exam-container { flex-direction: column; }
        .question-sidebar { width: 100%; position: relative; top: 0; }
        .question-grid { grid-template-columns: repeat(8, 1fr); }
    }

    @media (max-width: 768px) {
        .exam-wrapper { padding: 1rem; }
        .exam-info-bar { flex-direction: column; align-items: stretch; }
        .progress-section { max-width: 100%; }
        .question-grid { grid-template-columns: repeat(5, 1fr); }
        .question-card { padding: 1.25rem; }
        .navigation-controls { flex-direction: column; gap: 1rem; }
        .btn-exam { width: 100%; justify-content: center; }
        .question-image-wrap img { max-width: 100%; }
        .video-container video,
        .video-container iframe { height: 220px; }
    }
</style>

<div class="exam-wrapper">

    <!-- Info Bar -->
    <div class="exam-info-bar">
        <div class="session-badge" id="sessionBadge">Pengetahuan Umum</div>

        <div class="progress-section">
            <div class="progress-bar-wrapper">
                <div class="progress-bar-fill" id="progressBar" style="width: 0%"></div>
            </div>
            <div class="progress-text">
                <span id="progressPercent">0</span>%
            </div>
        </div>

        <div class="timer-section">
            <svg class="timer-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span id="timerDisplay">05:00</span>
        </div>
    </div>

    <!-- Main Container -->
    <div class="exam-container">

        <!-- Sidebar Navigation -->
        <aside class="question-sidebar">
            <div class="sidebar-title">Navigasi Soal</div>
            <div class="question-grid" id="questionGrid">
                @foreach($questions as $index => $q)
                    <div class="question-number-box"
                         data-index="{{ $index }}"
                         data-question-id="{{ $q->id }}"
                         onclick="goToQuestion({{ $index }})">
                        {{ $index + 1 }}
                    </div>
                @endforeach
            </div>
        </aside>

        <!-- Question Content -->
        <div class="question-content-area">
            <div class="question-card">

                <!-- Video Tutorial (untuk PSI) -->
                <div class="video-container" id="videoContainer" style="display: none;"></div>

                <!-- Question Header -->
                <div class="question-header">
                    <div class="question-number-label">
                        Soal <span id="currentNumber">1</span> dari {{ $totalQuestions }}
                    </div>
                    <div class="question-type-badge badge-pu" id="typeBadge">
                        Pengetahuan Umum
                    </div>
                </div>

                <!-- Question Text -->
                <div class="question-text" id="questionText"></div>

                <!-- Options -->
                <div class="options-wrapper" id="optionsContainer"></div>
            </div>

            <!-- Navigation Buttons -->
            <div class="navigation-controls">
                <button class="btn-exam btn-prev" id="btnPrev" onclick="previousQuestion()" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    Kembali
                </button>

                <button class="btn-exam btn-next" id="btnNext" onclick="nextQuestion()">
                    Selanjutnya
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>

                <button class="btn-exam btn-submit" id="btnSubmit" onclick="showSubmitModal()" style="display: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    Selesai
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Submit Confirmation -->
<div class="modal-overlay" id="submitModal">
    <div class="modal-box">
        <h3>Konfirmasi Selesai Ujian</h3>
        <p>Apakah Anda yakin ingin menyelesaikan ujian?</p>
        <p class="modal-warning">
            Anda telah menjawab <span id="modalAnsweredCount">0</span> dari {{ $totalQuestions }} soal.
        </p>
        <div class="modal-buttons">
            <button class="btn-modal btn-cancel" onclick="closeSubmitModal()">Batal</button>
            <button class="btn-modal btn-confirm" onclick="submitExam()">Ya, Selesai</button>
        </div>
    </div>
</div>

<!-- Modal Time Up -->
<div class="modal-overlay" id="timeUpModal">
    <div class="modal-box">
        <h3>Waktu Habis!</h3>
        <p>Waktu ujian telah berakhir. Ujian akan otomatis diselesaikan.</p>
        <div class="modal-buttons">
            <button class="btn-modal btn-confirm" onclick="submitExam()">OK</button>
        </div>
    </div>
</div>

<script>
    const groupId = {{ $groupId }};
    // Data dari Backend
    const examId      = {{ $exam->id }};
    const questions   = @json($questions->values());
    // FIX: hanya simpan jawaban yang relevan dengan soal di halaman ini
    const questionIds = questions.map(q => q.id);
    const rawAnswers  = @json($savedAnswers);
    const csrfToken   = '{{ csrf_token() }}';

    // State — filter savedAnswers agar hanya berisi soal yang ada di halaman ini
    let currentIndex = 0;
    let answers = {};
    for (const [key, val] of Object.entries(rawAnswers)) {
        if (questionIds.includes(parseInt(key))) {
            answers[key] = val;
        }
    }

    let timerInterval    = null;
    let remainingSeconds = 300; // 5 menit untuk testing

    // Initialize
    document.addEventListener('DOMContentLoaded', function () {
        loadQuestion(0);
        updateQuestionGrid();
        updateProgress();
        startTimer();
    });

    // =====================
    // Load Question
    // =====================
    function loadQuestion(index) {
        if (index < 0 || index >= questions.length) return;

        currentIndex = index;
        const question = questions[index];

        document.getElementById('currentNumber').textContent = index + 1;

        const sessionBadge   = document.getElementById('sessionBadge');
        const typeBadge      = document.getElementById('typeBadge');
        const videoContainer = document.getElementById('videoContainer');

        if (question.group && question.group.type === 'PSI') {
            sessionBadge.textContent  = 'Psikotes - ' + question.group.name;
            typeBadge.textContent     = 'Psikotes';
            typeBadge.className       = 'question-type-badge badge-psi';

            if (question.group.video_tutorial && question.is_first_in_group) {
                const videoUrl = question.group.video_tutorial;

                if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                    let embedUrl = videoUrl;
                    if (videoUrl.includes('watch?v=')) {
                        const vid = videoUrl.split('watch?v=')[1].split('&')[0];
                        embedUrl  = `https://www.youtube.com/embed/${vid}`;
                    } else if (videoUrl.includes('youtu.be/')) {
                        const vid = videoUrl.split('youtu.be/')[1].split('?')[0];
                        embedUrl  = `https://www.youtube.com/embed/${vid}`;
                    }
                    videoContainer.innerHTML = `
                        <iframe
                            src="${embedUrl}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>`;
                } else {
                    videoContainer.innerHTML = `
                        <video id="tutorialVideo" controls controlsList="nodownload" preload="metadata">
                            <source src="${videoUrl}" type="video/mp4">
                            Browser Anda tidak mendukung pemutaran video.
                        </video>`;

                    const video = videoContainer.querySelector('video');
                    video.onerror = () => {
                        videoContainer.innerHTML = `
                            <div style="padding:20px;text-align:center;color:#e74c3c;background:#fee;border-radius:10px;">
                                <p style="font-weight:600;">Video tutorial tidak dapat dimuat</p>
                                <p style="font-size:0.9rem;margin-top:4px;">Silakan lanjutkan mengerjakan soal</p>
                            </div>`;
                    };
                }
                videoContainer.style.display = 'block';
            } else {
                videoContainer.style.display = 'none';
                videoContainer.innerHTML = '';
            }
        } else {
            sessionBadge.textContent = 'Pengetahuan Umum';
            typeBadge.textContent    = 'Pengetahuan Umum';
            typeBadge.className      = 'question-type-badge badge-pu';
            videoContainer.style.display = 'none';
            videoContainer.innerHTML = '';
        }

        // Question text + image
        let questionHtml = question.question_text ?? '';
        if (question.question_image) {
            questionHtml += `
                <div class="question-image-wrap">
                    <img src="/storage/${question.question_image}" alt="Gambar soal">
                </div>`;
        }
        document.getElementById('questionText').innerHTML = questionHtml;

        // Options
        const optionsContainer = document.getElementById('optionsContainer');
        optionsContainer.innerHTML = '';

        ['A', 'B', 'C', 'D', 'E'].forEach(letter => {
            const optionText  = question['option_' + letter.toLowerCase()] ?? '';
            const optionImage = question['option_' + letter.toLowerCase() + '_image'];
            const isSelected  = answers[question.id] === letter;

            // Skip kosong (tidak ada teks dan tidak ada gambar)
            if (!optionText && !optionImage) return;

            const optionDiv = document.createElement('div');
            optionDiv.className = 'option-item' + (isSelected ? ' selected' : '');
            optionDiv.onclick   = (e) => selectOption(e, letter, question.id);

            optionDiv.innerHTML = `
                <input type="radio"
                    name="answers[${question.id}]"
                    id="option${letter}"
                    value="${letter}"
                    ${isSelected ? 'checked' : ''}>
                <label class="option-label" for="option${letter}">
                    <span class="option-letter">${letter}</span>
                    <span class="option-text">
                        ${optionText ? optionText : ''}
                        ${optionImage
                            ? `<div class="option-image-wrap">
                                    <img src="/storage/${optionImage}" alt="Pilihan ${letter}">
                               </div>`
                            : ''}
                    </span>
                </label>`;

            optionsContainer.appendChild(optionDiv);
        });

        updateNavigationButtons();
        updateQuestionGrid();
    }

    // =====================
    // Select Option — FIX: gunakan parameter event eksplisit
    // =====================
    function selectOption(e, letter, questionId) {
        document.querySelectorAll('.option-item').forEach(opt => opt.classList.remove('selected'));
        e.currentTarget.classList.add('selected');

        const radio = document.getElementById(`option${letter}`);
        if (radio) radio.checked = true;

        answers[questionId] = letter;

        saveAnswer(questionId, letter);
        updateQuestionGrid();
        updateProgress();
    }

    // =====================
    // Save Answer via AJAX
    // =====================
    function saveAnswer(questionId, selectedAnswer) {
        fetch(`/exam/${examId}/save-answer`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                question_id:     questionId,
                selected_answer: selectedAnswer,
            }),
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) console.error('❌ Gagal menyimpan jawaban');
        })
        .catch(err => console.error('❌ Error saving answer:', err));
    }

    // =====================
    // Update Progress — FIX: max 100%
    // =====================
    function updateProgress() {
        const answeredCount = Object.keys(answers).length;
        const total         = questions.length;
        const progress      = total > 0 ? Math.min(Math.round((answeredCount / total) * 100), 100) : 0;

        document.getElementById('progressBar').style.width = progress + '%';
        document.getElementById('progressPercent').textContent = progress;
    }

    // =====================
    // Update Question Grid
    // =====================
    function updateQuestionGrid() {
        document.querySelectorAll('.question-number-box').forEach((box, index) => {
            const questionId = questions[index].id;
            box.classList.remove('active', 'answered');
            if (index === currentIndex) box.classList.add('active');
            if (answers[questionId])    box.classList.add('answered');
        });
    }

    // =====================
    // Navigation
    // =====================
    function previousQuestion() {
        if (currentIndex > 0) loadQuestion(currentIndex - 1);
    }

    function nextQuestion() {
        if (currentIndex < questions.length - 1) loadQuestion(currentIndex + 1);
    }

    function goToQuestion(index) {
        loadQuestion(index);
    }

    function updateNavigationButtons() {
        const btnPrev   = document.getElementById('btnPrev');
        const btnNext   = document.getElementById('btnNext');
        const btnSubmit = document.getElementById('btnSubmit');

        btnPrev.disabled = currentIndex === 0;

        if (currentIndex === questions.length - 1) {
            btnNext.style.display   = 'none';
            btnSubmit.style.display = 'inline-flex';
        } else {
            btnNext.style.display   = 'inline-flex';
            btnSubmit.style.display = 'none';
        }
    }

    // =====================
    // Timer
    // =====================
    function startTimer() {
        timerInterval = setInterval(() => {
            remainingSeconds--;
            if (remainingSeconds <= 0) {
                clearInterval(timerInterval);
                timeUp();
                return;
            }
            updateTimerDisplay();
        }, 1000);
    }

    function updateTimerDisplay() {
        const m = Math.floor(remainingSeconds / 60);
        const s = remainingSeconds % 60;
        document.getElementById('timerDisplay').textContent =
            `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;

        if (remainingSeconds < 60) {
            document.getElementById('timerDisplay').style.color = '#e74c3c';
        }
    }

    function timeUp() {
        document.getElementById('timeUpModal').style.display = 'flex';
    }

    // =====================
    // Submit Modal
    // =====================
    function showSubmitModal() {
        document.getElementById('modalAnsweredCount').textContent = Object.keys(answers).length;
        document.getElementById('submitModal').style.display = 'flex';
    }

    function closeSubmitModal() {
        document.getElementById('submitModal').style.display = 'none';
    }

    // =====================
    // Submit Exam
    // =====================
    function submitExam() {
    clearInterval(timerInterval);

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/exam/${examId}/submit`;

    // CSRF
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    form.appendChild(csrfInput);

    // TAMBAHKAN INI (FIX UTAMA)
    const groupInput = document.createElement('input');
    groupInput.type = 'hidden';
    groupInput.name = 'group_id';
    groupInput.value = groupId;
    form.appendChild(groupInput);

    // answers
    for (const [questionId, answer] of Object.entries(answers)) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `answers[${questionId}]`;
        input.value = answer;
        form.appendChild(input);
    }

    document.body.appendChild(form);
    form.submit();
}
    // =====================
    // Security
    // =====================
    window.addEventListener('beforeunload', (e) => {
        if (remainingSeconds > 0) { e.preventDefault(); e.returnValue = ''; }
    });

    document.addEventListener('copy',        (e) => e.preventDefault());
    document.addEventListener('cut',         (e) => e.preventDefault());
    document.addEventListener('paste',       (e) => e.preventDefault());
    document.addEventListener('contextmenu', (e) => e.preventDefault());

    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && ['c','x','v','p'].includes(e.key)) {
            e.preventDefault();
        }
        if (e.key === 'PrintScreen') {
            navigator.clipboard.writeText('');
            alert('Fitur screenshot dinonaktifkan selama ujian!');
        }
    });
</script>
@endsection