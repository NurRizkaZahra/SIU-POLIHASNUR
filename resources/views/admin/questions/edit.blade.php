@extends('layouts.app-admin')

@section('title', 'Edit Soal')
@section('page-title', 'EDIT SOAL')

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

    .edit-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fef3c7;
        color: #92400e;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 20px;
        flex-wrap: wrap;
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
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(245,158,11,0.3);
    }

    .error-message {
        background: #fee2e2;
        border: 2px solid #ef4444;
        color: #dc2626;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .success-message {
        background: #d1fae5;
        border: 2px solid #10b981;
        color: #065f46;
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

    /* Gambar preview */
    .img-preview {
        max-width: 200px;
        width: 100%;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        margin-bottom: 8px;
        display: block;
    }

    .img-preview-sm {
        max-width: 120px;
        margin-bottom: 8px;
        border-radius: 6px;
        border: 2px solid #e5e7eb;
        display: block;
    }

    /* ════════════════════════════
       RESPONSIVE
    ════════════════════════════ */

    @media (max-width: 768px) {
        .form-container { padding: 14px; }
        .form-card { padding: 20px; border-radius: 12px; }
        .form-label { font-size: 13px; }
        .form-input, .form-select { font-size: 13px; padding: 11px 13px; }
        .edit-badge { font-size: 12px; padding: 7px 13px; }
    }

    @media (max-width: 480px) {
        .form-container { padding: 10px; }
        .form-card { padding: 16px; }

        .option-label-box { width: 38px; height: 38px; font-size: 14px; }
        .answer-item { gap: 8px; }

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

        .img-preview    { max-width: 100%; }
        .img-preview-sm { max-width: 100px; }
    }
</style>

<div class="form-container">
    <div class="form-card">
        <div class="edit-badge">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Mode Edit — Soal ID #{{ $question->id }}
        </div>

        @if(session('success'))
        <div class="success-message">
            <strong>✓ Berhasil!</strong> {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="error-message">
            <strong>✗ Terjadi kesalahan:</strong>
            <ul style="margin:8px 0 0 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="type"              value="{{ $currentType }}">
            <input type="hidden" name="question_group_id" value="{{ $question->question_group_id }}">

            <!-- Pertanyaan Soal -->
            <div class="form-group">
                <label class="form-label">
                    Pertanyaan Soal <span class="required">*</span>
                </label>
                <textarea name="question_text" class="form-input form-textarea"
                    placeholder="Masukkan pertanyaan soal...">{{ old('question_text', $question->question_text) }}</textarea>
                <div class="form-hint">Gunakan bahasa yang jelas dan mudah dipahami</div>
            </div>

            <!-- Gambar Soal PSI -->
            @if($currentType == 'PSI')
            <div class="form-group">
                <label class="form-label">Gambar Soal PSI</label>
                @if($question->question_image)
                    <img src="{{ asset('storage/'.$question->question_image) }}" class="img-preview">
                    <div class="form-hint" style="margin-bottom:8px;">Gambar saat ini. Upload baru untuk mengganti.</div>
                @endif
                <input type="file" name="question_image" class="form-input" accept="image/png,image/jpg,image/jpeg">
                <div class="form-hint">Format: JPG, PNG, JPEG. Kosongkan jika tidak ingin mengganti.</div>
            </div>
            @endif

            <!-- Kelompok Soal (read-only) -->
            <div class="form-group">
                <label class="form-label">Kelompok Soal</label>
                <div style="display:inline-block;padding:8px 16px;
                    background:{{ $currentType=='PSI' ? '#dbeafe' : '#d1fae5' }};
                    color:{{ $currentType=='PSI' ? '#1e40af' : '#065f46' }};
                    border-radius:20px;font-weight:600;">
                    {{ $currentType=='PSI' ? '🧠 Psikotes (PSI)' : '📚 Pengetahuan Umum (PU)' }}
                    — {{ $question->questionGroup->name ?? '-' }}
                </div>
                <div class="form-hint">Tipe dan kelompok soal tidak dapat diubah setelah dibuat</div>
            </div>

            <!-- Video Tutorial PSI -->
            @if($currentType == 'PSI')
            <div class="form-group">
                <label class="form-label">Video Tutorial PSI</label>
                @if($question->video_tutorial)
                    <div style="margin-bottom:8px;">
                        <a href="{{ $question->video_tutorial }}" target="_blank">Lihat Video Tutorial</a>
                        <div class="form-hint">Video saat ini. Isi baru untuk mengganti.</div>
                    </div>
                @endif
                <input type="url" name="video_tutorial" class="form-input"
                    placeholder="Masukkan link video tutorial (YouTube)"
                    value="{{ old('video_tutorial', $question->video_tutorial) }}">
            </div>
            @endif

            <!-- Skor -->
            <div class="form-group">
                <label class="form-label">Skor <span class="required">*</span></label>
                <input type="number" name="score" class="form-input"
                    placeholder="Masukkan skor..."
                    value="{{ old('score', $question->score) }}"
                    step="0.1" min="0.1" required>
                <div class="form-hint">Bobot poin untuk soal ini jika dijawab benar</div>
            </div>

            <!-- Pilihan Jawaban -->
            <div class="answers-section">
                <label class="form-label">Pilihan Jawaban <span class="required">*</span></label>

                @if($currentType == 'PU')
                <div class="form-hint" style="margin-bottom:15px;">
                    <span class="correct-answer-hint">Pilih radio button untuk jawaban yang benar</span>
                </div>
                @foreach(['A','B','C','D','E'] as $option)
                <div class="answer-item">
                    <div class="option-label-box">{{ $option }}</div>
                    <input type="text"
                        name="answer_choices[{{ $option }}]"
                        class="form-input option-input"
                        placeholder="Masukkan pilihan jawaban {{ $option }}..."
                        value="{{ old("answer_choices.$option", $question->answer_choices[$option] ?? '') }}">
                    <div class="option-radio">
                        <input type="radio" name="correct_answer" value="{{ $option }}"
                            {{ old('correct_answer', $question->correct_answer) == $option ? 'checked' : '' }}>
                    </div>
                </div>
                @endforeach

                @else
                <div class="form-hint" style="margin-bottom:15px;">
                    <span class="correct-answer-hint">Pilih jawaban yang benar</span>
                </div>
                @foreach(['A','B','C','D','E'] as $option)
                <div class="answer-item">
                    <div class="option-label-box">{{ $option }}</div>
                    <div class="option-input">
                        @if(isset($question->answer_choices[$option]['image']))
                            <img src="{{ asset('storage/'.$question->answer_choices[$option]['image']) }}"
                                 class="img-preview-sm">
                            <div class="form-hint" style="margin-bottom:6px;">Gambar saat ini. Upload baru untuk mengganti.</div>
                        @endif
                        <input type="file"
                            name="answer_choices[{{ $option }}][image]"
                            class="form-input"
                            accept="image/png,image/jpg,image/jpeg">
                    </div>
                    <div class="option-radio">
                        <input type="radio" name="correct_answer" value="{{ $option }}"
                            {{ old('correct_answer', $question->correct_answer) == $option ? 'checked' : '' }}>
                    </div>
                </div>
                @endforeach
                @endif
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
                    Update Soal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    if (!confirm('Apakah Anda yakin ingin menyimpan perubahan soal ini?')) {
        e.preventDefault();
    }
});
</script>
@endsection