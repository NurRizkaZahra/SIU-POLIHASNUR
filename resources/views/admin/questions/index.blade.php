@extends('layouts.app-admin')

@section('title', 'Bank Soal')
@section('page-title', 'BANK SOAL')

@section('content')
<style>
    /* Questions Container - JANGAN OVERRIDE APAPUN DARI GLOBAL! */
    .questions-container {
        padding: 20px;
    }
    
    .header-actions-bank {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }
    
    .search-box {
        position: relative;
        flex: 1;
        max-width: 350px;
    }
    
    .search-input {
        width: 100%;
        padding: 10px 35px 10px 40px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #2b6cb0;
        box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.1);
    }
    
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        width: 20px;
        height: 20px;
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fbbf24;
        color: #1e293b;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-add:hover {
        background: #f59e0b;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
        color: #1e293b;
    }
    
    .btn-add-group {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #10b981;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .btn-add-group:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        color: white;
    }
    
    .btn-icon {
        width: 16px;
        height: 16px;
    }
    
    .questions-grid {
        display: grid;
        gap: 20px;
    }
    
    .question-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 15px;
        padding: 20px;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    
    .question-card:hover {
        border-color: #2b6cb0;
        box-shadow: 0 8px 20px rgba(43, 108, 176, 0.1);
        transform: translateY(-2px);
    }
    
    .question-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(135deg, #2b6cb0 0%, #1e5a9e 100%);
    }
    
    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 15px;
        gap: 15px;
    }
    
    .question-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #2b6cb0 0%, #1e5a9e 100%);
        color: white;
        border-radius: 10px;
        font-weight: 700;
        font-size: 18px;
        flex-shrink: 0;
    }
    
    .question-actions {
        display: flex;
        gap: 8px;
    }
    
    .btn-action {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }
    
    .btn-edit {
        background: #10b981;
        color: white;
    }
    
    .btn-edit:hover {
        background: #059669;
        transform: scale(1.05);
    }
    
    .btn-delete {
        background: #ef4444;
        color: white;
    }
    
    .btn-delete:hover {
        background: #dc2626;
        transform: scale(1.05);
    }
    
    .btn-video {
        background: #8b5cf6;
        color: white;
    }
    
    .btn-video:hover {
        background: #7c3aed;
        transform: scale(1.05);
    }
    
    .question-content {
        flex: 1;
    }
    
    .question-meta {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }
    
    .group-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #dbeafe;
        color: #1e40af;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .question-text {
        font-size: 16px;
        color: #1e293b;
        font-weight: 500;
        margin-bottom: 15px;
        line-height: 1.6;
    }
    
    .answers-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 10px;
        margin-top: 15px;
    }
    
    .answer-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 15px;
        background: #f8fafc;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        transition: all 0.3s;
    }
    
    .answer-option.correct {
        background: #d1fae5;
        border-color: #10b981;
    }
    
    .option-label {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: 2px solid #cbd5e1;
        border-radius: 50%;
        font-weight: 700;
        font-size: 14px;
        color: #475569;
        flex-shrink: 0;
    }
    
    .answer-option.correct .option-label {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }
    
    .option-text {
        flex: 1;
        font-size: 14px;
        color: #475569;
    }
    
    .answer-option.correct .option-text {
        color: #065f46;
        font-weight: 600;
    }
    
    .correct-indicator {
        display: none;
        color: #10b981;
        font-weight: 700;
        font-size: 12px;
    }
    
    .answer-option.correct .correct-indicator {
        display: block;
    }
    
    .video-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ede9fe;
        color: #7c3aed;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 15px;
        border: 2px dashed #cbd5e1;
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        color: #cbd5e1;
    }
    
    .empty-title {
        font-size: 20px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 10px;
    }
    
    .empty-text {
        color: #94a3b8;
        margin-bottom: 20px;
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 30px;
    }
    
    .page-btn {
        min-width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #e5e7eb;
        background: white;
        border-radius: 8px;
        color: #64748b;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .page-btn:hover {
        border-color: #2b6cb0;
        color: #2b6cb0;
    }
    
    .page-btn.active {
        background: #2b6cb0;
        border-color: #2b6cb0;
        color: white;
    }
    
    @media (max-width: 768px) {
        .questions-container {
            padding: 15px;
        }
        
        .header-actions-bank {
            flex-direction: column;
            align-items: stretch;
        }
        
        .action-buttons {
            width: 100%;
        }
        
        .btn-add,
        .btn-add-group {
            flex: 1;
        }
        
        .search-box {
            max-width: 100%;
        }
        
        .answers-list {
            grid-template-columns: 1fr;
        }
        
        .question-header {
            flex-direction: column;
        }
        
        .question-actions {
            width: 100%;
            justify-content: flex-end;
        }
    }
</style>

<div class="questions-container">
    <!-- Header Actions -->
    <div class="header-actions-bank">
        <div class="search-box">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" class="search-input" placeholder="Cari soal...">
        </div>
        
        <div class="action-buttons">
            <a href="{{ route('admin.question-groups.index') }}" class="btn-add-group">
                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
                Kelompok Soal
            </a>
            
            <a href="{{ route('admin.questions.create') }}" class="btn-add">
                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Soal
            </a>
        </div>
    </div>

    <!-- Questions Grid -->
    <div class="questions-grid">
        @forelse($questions as $index => $question)
        <div class="question-card">
            <div class="question-header">
                <div style="display: flex; align-items: start; gap: 15px; flex: 1;">
                    <div class="question-number">{{ $questions->firstItem() + $index }}</div>
                    <div class="question-content">
                        <!-- Question Meta (Group & Video) -->
                        <div class="question-meta">
                            @if($question->questionGroup)
                            <span class="group-badge">
                                <svg style="width: 14px; height: 14px;" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                </svg>
                                {{ $question->questionGroup->name }}
                            </span>
                            @endif
                            
                            @if($question->video_tutorial)
                            <span class="video-badge">
                                <svg style="width: 14px; height: 14px;" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 6v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"/>
                                </svg>
                                Video Tutorial
                            </span>
                            @endif
                        </div>
                        
                        <div class="question-text">{{ $question->question_text }}</div>
                        
                        <div class="answers-list">
                            @php
                               $choices = $question->answer_choices ?? [];
                            @endphp
                            
                            @foreach(['A', 'B', 'C', 'D', 'E'] as $option)
                                @if(isset($choices[$option]) && !empty($choices[$option]))
                                <div class="answer-option {{ $option == $question->correct_answer ? 'correct' : '' }}">
                                    <span class="option-label">{{ $option }}</span>
                                    <span class="option-text">
                                        @if(is_array($choices[$option]))
                                            {{ $choices[$option]['text'] ?? '' }} (skor: {{ $choices[$option]['score'] ?? '' }})
                                        @else
                                            {{ $choices[$option] }}
                                        @endif
                                    </span>
                                    <span class="correct-indicator">✓</span>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="question-actions">
                    @if($question->video_tutorial)
                    <a href="{{ $question->video_tutorial }}" target="_blank" class="btn-action btn-video" title="Lihat Video">
                        <svg style="width: 18px; height: 18px;" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                        </svg>
                    </a>
                    @endif
                    
                    <a href="{{ route('admin.questions.edit', $question->id) }}" class="btn-action btn-edit" title="Edit">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </a>
                    
                    <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete" title="Hapus">
                            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="empty-title">Belum Ada Soal</h3>
            <p class="empty-text">Mulai buat soal pertama kamu dengan klik tombol "Tambah Soal"</p>
            <a href="{{ route('admin.questions.create') }}" class="btn-add">
                <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Soal Pertama
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($questions->hasPages())
    <div class="pagination">
        @if($questions->onFirstPage())
            <span class="page-btn" style="opacity: 0.5; cursor: not-allowed;">‹</span>
        @else
            <a href="{{ $questions->previousPageUrl() }}" class="page-btn">‹</a>
        @endif
        
        @foreach($questions->getUrlRange(1, $questions->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="page-btn {{ $page == $questions->currentPage() ? 'active' : '' }}">
                {{ $page }}
            </a>
        @endforeach
        
        @if($questions->hasMorePages())
            <a href="{{ $questions->nextPageUrl() }}" class="page-btn">›</a>
        @else
            <span class="page-btn" style="opacity: 0.5; cursor: not-allowed;">›</span>
        @endif
    </div>
    @endif
</div>

<script>
// Search functionality
document.querySelector('.search-input').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const questionCards = document.querySelectorAll('.question-card');
    
    questionCards.forEach(card => {
        const questionText = card.querySelector('.question-text').textContent.toLowerCase();
        if (questionText.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
@endsection