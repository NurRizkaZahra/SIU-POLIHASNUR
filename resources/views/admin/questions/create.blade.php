@extends('layouts.app-admin')

@section('title', 'Tambah Soal')
@section('page-title', 'TAMBAH SOAL')

@section('content')
<style>
    .form-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        box-sizing: border-box;
    }

    .form-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .form-group { margin-bottom: 25px; }

    .form-label {
        display: block;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .required { color: #ef4444; }

    .form-input, .form-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s;
        box-sizing: border-box;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #2b6cb0;
        box-shadow: 0 0 0 3px rgba(43,108,176,0.1);
    }

    .form-textarea { min-height: 120px; resize: vertical; }

    .form-hint { font-size: 12px; color: #64748b; margin-top: 5px; }

    /* ── Answer Items ── */
    .answers-section { margin-top: 30px; }

    .answer-item {
        display: flex;
        gap: 12px;
        margin-bottom: 15px;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .option-radio { margin-top: 12px; flex-shrink: 0; }
    .option-radio input[type="radio"] { width: 20px; height: 20px; cursor: pointer; }

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

    .option-input { flex: 1; min-width: 0; }

    /* ── Form Actions ── */
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #e5e7eb;
        flex-wrap: wrap;
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
        white-space: nowrap;
    }

    .btn-cancel { background: #f1f5f9; color: #475569; }
    .btn-cancel:hover { background: #e2e8f0; }

    .btn-submit {
        background: linear-gradient(135deg, #2b6cb0 0%, #1e5a9e 100%);
        color: white;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(43,108,176,0.3);
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

    /* Kelompok soal radio group */
    .group-radio-wrap {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .group-radio-wrap label {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-weight: 500;
    }

    .group-radio-wrap input[type="radio"] { width: 18px; height: 18px; }

    /* ════════════════════════════
       RESPONSIVE
    ════════════════════════════ */

    @media (max-width: 768px) {
        .form-container { padding: 14px; }
        .form-card { padding: 20px; border-radius: 12px; }
        .form-label { font-size: 13px; }
        .form-input, .form-select { font-size: 13px; padding: 11px 13px; }
    }

    @media (max-width: 480px) {
        .form-container { padding: 10px; }
        .form-card { padding: 16px; }

        /* Answer item: label box lebih kecil */
        .option-label-box { width: 38px; height: 38px; font-size: 14px; }

        /* Radio ke kanan */
        .answer-item { gap: 8px; }

        /* Tombol aksi full width */
        .form-actions {
            flex-direction: column-reverse;
            gap: 10px;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .correct-answer-hint {
            margin-left: 0;
            margin-top: 6px;
            display: block;
        }

        .group-radio-wrap { gap: 12px; }
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

        <form action="{{ route('admin.questions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Pertanyaan Soal -->
            <div class="form-group">
                <label class="form-label">
                    Pertanyaan Soal <span class="required">*</span>
                </label>
                <textarea name="question_text" class="form-input form-textarea"
                    placeholder="Masukkan pertanyaan soal...">{{ old('question_text') }}</textarea>
                <div class="form-hint">Gunakan bahasa yang jelas dan mudah dipahami</div>
            </div>

            <!-- Video Tutorial PSI -->
            <div class="form-group" id="psi-video-field" style="display:none;">
                <label class="form-label">Video Tutorial PSI</label>
                <input type="url" name="video_tutorial" class="form-input psi-video-input"
                    placeholder="Masukkan link video (YouTube / Google Drive / dll)">
            </div>

            <!-- Kelompok Soal -->
            <div class="form-group">
                <label class="form-label">
                    Kelompok Soal <span class="required">*</span>
                </label>
                <div class="group-radio-wrap">
                    @foreach($groups as $group)
                    <label>
                        <input type="radio" name="question_group_id"
                            value="{{ $group->id }}"
                            data-type="{{ $group->type }}"
                            onchange="toggleQuestionType()">
                        <span>{{ $group->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Gambar Soal PSI -->
            <div class="form-group" id="psi-question-image" style="display:none;">
                <label class="form-label">
                    Upload Gambar Soal PSI <span class="required">*</span>
                </label>
                <input type="file" name="question_image" class="form-input" accept="image/*">
                <div class="form-hint">Format: JPG, PNG, JPEG</div>
            </div>

            <!-- Skor -->
            <div class="form-group" id="score-field">
                <label class="form-label">
                    Skor <span class="required">*</span>
                </label>
                <input type="number" name="score" id="score-input" class="form-input"
                    placeholder="Masukkan skor..."
                    value="{{ old('score', 1) }}" step="0.1" min="0.1">
                <div class="form-hint">Bobot poin untuk soal ini jika dijawab benar</div>
            </div>

            <!-- Pilihan Jawaban -->
            <div class="answers-section">
                <div id="pu-label">
                    <label class="form-label">Pilihan Jawaban <span class="required">*</span></label>
                </div>
                <div id="psi-label" style="display:none;">
                    <label class="form-label">Pilihan Jawaban <span class="required">*</span></label>
                </div>

                <!-- PU: Text + Radio -->
                <div id="pu-answers">
                    <div class="form-hint" style="margin-bottom:15px;">
                        <span class="correct-answer-hint">Pilih radio button untuk jawaban yang benar</span>
                    </div>
                    @foreach(['A','B','C','D','E'] as $option)
                    <div class="answer-item">
                        <div class="option-label-box">{{ $option }}</div>
                        <input type="text" name="answer_choices[{{ $option }}]"
                            class="form-input option-input pu-choice-input"
                            placeholder="Masukkan pilihan jawaban {{ $option }}..."
                            value="{{ old("answer_choices.$option") }}">
                        <div class="option-radio">
                            <input type="radio" name="correct_answer" value="{{ $option }}"
                                class="pu-correct-radio"
                                {{ old('correct_answer') == $option ? 'checked' : '' }}>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- PSI: Upload Gambar -->
                <div id="psi-answers" style="display:none;">
                    <div class="form-hint" style="margin-bottom:15px;">
                        <span class="correct-answer-hint">Pilih jawaban yang benar</span>
                    </div>
                    @foreach(['A','B','C','D','E'] as $option)
                    <div class="answer-item">
                        <div class="option-label-box">{{ $option }}</div>
                        <input type="file" name="answer_choices[{{ $option }}][image]"
                            class="form-input psi-choice-image" accept="image/*">
                        <div class="option-radio">
                            <input type="radio" name="correct_answer" value="{{ $option }}">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.questions.index') }}" class="btn btn-cancel">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
                <button type="submit" class="btn btn-submit">
                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    const selected       = document.querySelector('input[name="question_group_id"]:checked');
    const type           = selected ? selected.dataset.type : null;
    const psiQuestionImg = document.getElementById('psi-question-image');
    const puAnswers      = document.getElementById('pu-answers');
    const psiAnswers     = document.getElementById('psi-answers');
    const scoreField     = document.getElementById('score-field');
    const psiVideoField  = document.getElementById('psi-video-field');

    const puChoiceInputs  = document.querySelectorAll('.pu-choice-input');
    const puCorrectRadios = document.querySelectorAll('.pu-correct-radio');
    const psiImages       = document.querySelectorAll('.psi-choice-image');
    const psiVideoInput   = document.querySelector('.psi-video-input');

    if (type === 'PU') {
        psiQuestionImg.style.display = 'none';
        puAnswers.style.display      = 'block';
        psiAnswers.style.display     = 'none';
        scoreField.style.display     = 'block';
        psiVideoField.style.display  = 'none';

        puChoiceInputs.forEach(i => i.disabled = false);
        puCorrectRadios.forEach(i => i.disabled = false);
        psiImages.forEach(i => i.disabled = true);
        psiVideoInput.disabled = true;
    } else {
        psiQuestionImg.style.display = 'block';
        puAnswers.style.display      = 'none';
        psiAnswers.style.display     = 'block';
        scoreField.style.display     = 'block';
        psiVideoField.style.display  = 'block';

        puChoiceInputs.forEach(i => i.disabled = true);
        puCorrectRadios.forEach(i => i.disabled = true);
        psiImages.forEach(i => i.disabled = false);
        psiVideoInput.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleQuestionType();
    document.querySelectorAll('input[name="question_group_id"]').forEach(r => {
        r.addEventListener('change', toggleQuestionType);
    });
});
</script>
@endsection