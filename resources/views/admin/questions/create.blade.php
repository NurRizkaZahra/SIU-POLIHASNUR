@extends('layouts.app-admin')

@section('title', 'Tambah Soal')
@section('page-title', 'TAMBAH SOAL')

@section('content')
<style>
    .form-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .form-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-label {
        display: block;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    .required {
        color: #ef4444;
    }
    
    .form-input, .form-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #2b6cb0;
        box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.1);
    }
    
    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }
    
    .form-hint {
        font-size: 12px;
        color: #64748b;
        margin-top: 5px;
    }
    
    .answers-section {
        margin-top: 30px;
    }
    
    .answer-item {
        display: flex;
        gap: 12px;
        margin-bottom: 15px;
        align-items: start;
    }
    
    .option-radio {
        margin-top: 12px;
    }
    
    .option-radio input[type="radio"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
    
    .option-label-box {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #2b6cb0 0%, #1e5a9e 100%);
        color: white;
        border-radius: 10px;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }
    
    .option-input {
        flex: 1;
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #e5e7eb;
    }
    
    .btn {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
    }
    
    .btn-cancel:hover {
        background: #e2e8f0;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #2b6cb0 0%, #1e5a9e 100%);
        color: white;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(43, 108, 176, 0.3);
    }
    
    .error-message {
        background: #fee2e2;
        border: 2px solid #ef4444;
        color: #dc2626;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    
    .correct-answer-hint {
        display: inline-block;
        background: #d1fae5;
        color: #065f46;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 10px;
    }

    .psi-score-input {
        width: 120px;
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-container">
    <div class="form-card">
        @if ($errors->any())
        <div class="error-message">
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.questions.store') }}" method="POST">
            @csrf
            
            <!-- Pertanyaan Soal -->
            <div class="form-group">
                <label class="form-label">
                    Pertanyaan Soal <span class="required">*</span>
                </label>
                <textarea 
                    name="question_text" 
                    class="form-input form-textarea" 
                    placeholder="Masukkan pertanyaan soal..."
                    required>{{ old('question_text') }}</textarea>
                <div class="form-hint">Gunakan bahasa yang jelas dan mudah dipahami</div>
            </div>

            <!-- Tipe Soal -->
            <div class="form-group">
                <label class="form-label">
                    Tipe Soal <span class="required">*</span>
                </label>
                <div style="display: flex; gap: 20px; margin-top: 10px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input 
                            type="radio" 
                            name="type" 
                            value="PU" 
                            {{ old('type', 'PU') == 'PU' ? 'checked' : '' }}
                            onchange="toggleQuestionType()"
                            id="type-pu"
                            style="width: 18px; height: 18px;">
                        <span style="font-weight: 500;">Pengetahuan Umum (PU)</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input 
                            type="radio" 
                            name="type" 
                            value="PSI" 
                            {{ old('type') == 'PSI' ? 'checked' : '' }}
                            onchange="toggleQuestionType()"
                            id="type-psi"
                            style="width: 18px; height: 18px;">
                        <span style="font-weight: 500;">Psikotes (PSI)</span>
                    </label>
                </div>
                <div class="form-hint">PU = soal individual | PSI = soal dengan kelompok</div>
            </div>

            <!-- Grup PSI (Wajib untuk PSI) -->
            <div class="form-group" id="group-field" style="display: none;">
                <label class="form-label">
                    Kelompok Soal PSI <span class="required">*</span>
                </label>
                <select name="question_group_id" id="question_group_id" class="form-select">
                    <option value="">-- Pilih Kelompok Soal PSI --</option>
                    @foreach($groups as $group)
                        @if($group->type == 'PSI')
                        <option value="{{ $group->id }}" {{ old('question_group_id') == $group->id ? 'selected' : '' }}>
                            {{ $group->name }}
                        </option>
                        @endif
                    @endforeach
                </select>
                <div class="form-hint">Soal PSI wajib memilih kelompok soal yang sudah dibuat</div>
            </div>

            <!-- Skor (Hanya untuk PU) -->
            <div class="form-group" id="score-field">
                <label class="form-label">
                    Skor <span class="required">*</span>
                </label>
                <input 
                    type="number" 
                    name="score" 
                    id="score-input"
                    class="form-input" 
                    placeholder="Masukkan skor..."
                    value="{{ old('score', 1) }}"
                    step="0.1"
                    min="0.1">
                <div class="form-hint">Bobot poin untuk soal ini jika dijawab benar</div>
            </div>

            <!-- Pilihan Jawaban A-E -->
            <div class="answers-section">
                <!-- Label untuk PU -->
                <div id="pu-label">
                    <label class="form-label">
                        Pilihan Jawaban <span class="required">*</span>
                    </label>
                </div>

                <!-- Label untuk PSI -->
                <div id="psi-label" style="display: none;">
                    <label class="form-label">
                        Pilihan Jawaban <span class="required">*</span>
                    </label>
                </div>

                <!-- Tampilan untuk PU: Text + Radio Button -->
                <div id="pu-answers">
                    <div class="form-hint" style="margin-bottom: 15px;">
                        <span class="correct-answer-hint">Pilih radio button untuk jawaban yang benar</span>
                    </div>

                    @foreach(['A', 'B', 'C', 'D', 'E'] as $option)
                    <div class="answer-item">
                        <div class="option-label-box">{{ $option }}</div>
                        <input 
                            type="text" 
                            name="answer_choices[{{ $option }}]" 
                            class="form-input option-input pu-choice-input" 
                            placeholder="Masukkan pilihan jawaban {{ $option }}..."
                            value="{{ old("answer_choices.$option") }}">
                        <div class="option-radio">
                            <input 
                                type="radio" 
                                name="correct_answer" 
                                value="{{ $option }}"
                                class="pu-correct-radio"
                                {{ old('correct_answer') == $option ? 'checked' : '' }}>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Tampilan untuk PSI: Text + Skor per Pilihan -->
                <div id="psi-answers" style="display: none;">
                    <div class="form-hint" style="margin-bottom: 15px;">
                        Masukkan teks pilihan dan skor untuk setiap opsi jawaban
                    </div>

                    @foreach(['A', 'B', 'C', 'D', 'E'] as $option)
                    <div class="answer-item">
                        <div class="option-label-box">{{ $option }}</div>
                        <input 
                            type="text" 
                            name="answer_choices[{{ $option }}][text]" 
                            class="form-input option-input psi-choice-text" 
                            placeholder="Teks pilihan {{ $option }}..."
                            value="{{ old("answer_choices.$option.text") }}">
                        <input 
                            type="number" 
                            name="answer_choices[{{ $option }}][score]" 
                            class="form-input psi-score-input psi-choice-score" 
                            placeholder="Skor"
                            value="{{ old("answer_choices.$option.score") }}"
                            min="1"
                            step="1">
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.questions.index') }}" class="btn btn-cancel">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
                <button type="submit" class="btn btn-submit">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleQuestionType() {
    const type = document.querySelector('input[name="type"]:checked').value;
    
    const groupField = document.getElementById('group-field');
    const scoreField = document.getElementById('score-field');
    const puAnswers = document.getElementById('pu-answers');
    const psiAnswers = document.getElementById('psi-answers');
    
    const scoreInput = document.getElementById('score-input');
    const groupSelect = document.getElementById('question_group_id');
    
    // Input PU
    const puChoiceInputs = document.querySelectorAll('.pu-choice-input');
    const puCorrectRadios = document.querySelectorAll('.pu-correct-radio');
    
    // Input PSI
    const psiChoiceTexts = document.querySelectorAll('.psi-choice-text');
    const psiChoiceScores = document.querySelectorAll('.psi-choice-score');
    
    if (type === 'PU') {
        // ✅ Tampilkan field PU
        groupField.style.display = 'none';
        scoreField.style.display = 'block';
        puAnswers.style.display = 'block';
        psiAnswers.style.display = 'none';

        // ✅ Aktifkan PU inputs
        scoreInput.disabled = false;
        puChoiceInputs.forEach(i => i.disabled = false);
        puCorrectRadios.forEach(i => i.disabled = false);

        // 🚫 Nonaktifkan PSI inputs
        groupSelect.disabled = true;
        psiChoiceTexts.forEach(i => i.disabled = true);
        psiChoiceScores.forEach(i => i.disabled = true);
        
    } else { // PSI
        // ✅ Tampilkan field PSI
        groupField.style.display = 'block';
        scoreField.style.display = 'none';
        puAnswers.style.display = 'none';
        psiAnswers.style.display = 'block';

        // ✅ Aktifkan PSI inputs
        groupSelect.disabled = false;
        psiChoiceTexts.forEach(i => i.disabled = false);
        psiChoiceScores.forEach(i => i.disabled = false);

        // 🚫 Nonaktifkan PU inputs
        scoreInput.disabled = true;
        puChoiceInputs.forEach(i => i.disabled = true);
        puCorrectRadios.forEach(i => i.disabled = true);
    }
}

// Jalankan saat halaman pertama kali dimuat
document.addEventListener('DOMContentLoaded', () => {
    toggleQuestionType();

    // Update otomatis saat klik tipe
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', toggleQuestionType);
    });
});
</script>


@endsection