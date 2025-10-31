@extends('layouts.app')

@section('content')
<div class="calendar-container">
    <div class="calendar-wrapper">
        <aside class="calendar-sidebar">
            <div class="sidebar-content">
                <button class="add-event-btn" id="btnAddEvent">
                    <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Acara Baru
                </button>

                <div class="filter-section">
                    <h6 class="filter-title">Filter Acara</h6>
                    <label class="filter-checkbox">
                        <input type="checkbox" checked>
                        <span class="checkmark"></span>
                        <span class="filter-label">Tampilkan Semua Acara</span>
                    </label>
                </div>

                <div class="calendar-info">
                    <div class="info-item">
                        <div class="info-dot info-dot-blue"></div>
                        <span>Acara Pribadi</span>
                    </div>
                    <div class="info-item">
                        <div class="info-dot info-dot-gray"></div>
                        <span>Acara Sekolah</span>
                    </div>
                    <div class="info-item">
                        <div class="info-dot info-dot-purple"></div>
                        <span>Penting</span>
                    </div>
                    <div class="info-item">
                        <div class="info-dot info-dot-pink"></div>
                        <span>Acara Lainnya</span>
                    </div>
                </div>
            </div>
        </aside>

        <main class="calendar-main">
            <div class="calendar-card">
                <header class="calendar-header">
                    <div class="calendar-nav">
                        <button class="nav-btn" data-action="prev">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button class="nav-btn" data-action="next">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                        <button class="today-btn" data-action="today">Hari Ini</button>
                    </div>

                    <h2 class="calendar-title" id="calendarTitle">{{ date('F Y') }}</h2>

                    <div class="view-buttons">
                        <button class="view-btn active" data-view="dayGridMonth">Bulan</button>
                        <button class="view-btn" data-view="timeGridWeek">Minggu</button>
                        <button class="view-btn" data-view="timeGridDay">Hari</button>
                        <button class="view-btn" data-view="listWeek">Daftar</button>
                    </div>
                </header>

                <div class="calendar-body">
                    <div id="calendar"
                        data-events='@json($events)'
                        data-base-url="{{ $baseUrl }}"
                        data-update-url="{{ $updateUrl }}"
                        data-delete-url="{{ $deleteUrl }}">
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

{{-- Modal --}}
@include('admin.calendar.modal')

{{-- External Libraries --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
.calendar-container {
    min-height: 100vh;
    padding: 2rem;
}

.calendar-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
    min-height: calc(100vh - 4rem);
}

.calendar-sidebar {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    height: fit-content;
}

.sidebar-content {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.add-event-btn {
    background: linear-gradient(135deg, #93c5fd 0%, #6366f1 100%);
    color: white;
    border: none;
    padding: 1rem 1.5rem;
    border-radius: 16px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(99, 102, 241, 0.3);
}

.add-event-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(99, 102, 241, 0.4);
}

.btn-icon {
    width: 20px;
    height: 20px;
}

.filter-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.filter-title {
    color: #4b5563;
    font-weight: 600;
    margin: 0;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-checkbox {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    position: relative;
}

.filter-checkbox input {
    display: none;
}

.checkmark {
    width: 18px;
    height: 18px;
    background: #e5e7eb;
    border-radius: 6px;
    position: relative;
    transition: all 0.2s ease;
}

.filter-checkbox input:checked + .checkmark {
    background: linear-gradient(135deg, #93c5fd 0%, #6366f1 100%);
}

.filter-checkbox input:checked + .checkmark::after {
    content: '';
    position: absolute;
    left: 6px;
    top: 3px;
    width: 4px;
    height: 8px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.filter-label {
    color: #374151;
    font-size: 0.875rem;
}

.calendar-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #6b7280;
    font-size: 0.875rem;
}

.info-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.info-dot-blue { background: #6366f1; }
.info-dot-gray { background-color: #6b7280; }
.info-dot-purple { background: #a855f7; }
.info-dot-pink { background: #ec4899; }

.calendar-main {
    display: flex;
    flex-direction: column;
}

.calendar-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.calendar-nav {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.nav-btn, .today-btn {
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 12px;
    padding: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.nav-btn svg {
    width: 16px;
    height: 16px;
    color: #6b7280;
}

.today-btn {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #6b7280;
}

.nav-btn:hover, .today-btn:hover {
    background: rgba(99, 102, 241, 0.1);
    border-color: rgba(99, 102, 241, 0.3);
}

.calendar-title {
    color: #1f2937;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    text-align: center;
    flex: 1;
}

.view-buttons {
    display: flex;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 16px;
    padding: 0.25rem;
    gap: 0.25rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.view-btn {
    background: transparent;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.2s ease;
}

.view-btn.active,
.view-btn:hover {
    background: linear-gradient(135deg, #93c5fd 0%, #6366f1 100%);
    color: white;
    transform: translateY(-1px);
}

.fc-theme-standard .fc-scrollgrid {
    border: none;
}

.fc-theme-standard td, 
.fc-theme-standard th {
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.fc-col-header-cell {
    background: rgba(99, 102, 241, 0.05);
    color: #6b7280;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    padding: 1rem 0;
}

.fc-daygrid-day {
    background: rgba(255, 255, 255, 0.8);
    transition: all 0.2s ease;
}

.fc-daygrid-day:hover {
    background: rgba(99, 102, 241, 0.05);
}

.fc-day-today {
    background: rgba(99, 102, 241, 0.1) !important;
    border: 2px solid rgba(99, 102, 241, 0.3) !important;
}

.fc-daygrid-day-number {
    color: #374151;
    font-weight: 500;
    padding: 0.5rem;
}

.fc-event {
    border-radius: 8px;
    border: none !important;
    padding: 0.25rem 0.5rem;
    margin: 0.125rem;
    font-size: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.fc-event:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.fc-event-title {
    color: white;
}

@media (max-width: 1024px) {
    .calendar-wrapper {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .calendar-sidebar {
        order: 2;
        padding: 1.5rem;
    }
    
    .sidebar-content {
        flex-direction: row;
        gap: 1rem;
        align-items: center;
        justify-content: space-between;
    }
}

@media (max-width: 768px) {
    .calendar-container {
        padding: 1rem;
    }
    
    .calendar-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .view-buttons {
        order: -1;
    }
    
    .sidebar-content {
        flex-direction: column;
        gap: 1rem;
    }
    
    .calendar-title {
        font-size: 1.25rem;
    }
    
    .view-btn {
        padding: 0.5rem 0.75rem;
        font-size: 0.813rem;
    }
    
    .fc-col-header-cell {
        font-size: 0.688rem;
        padding: 0.75rem 0.25rem;
    }
}

@media (max-width: 480px) {
    .calendar-container {
        padding: 0.75rem;
    }
    
    .calendar-sidebar,
    .calendar-card {
        border-radius: 16px;
        padding: 1rem;
    }
    
    .calendar-title {
        font-size: 1.125rem;
    }
    
    .view-btn {
        padding: 0.5rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .fc-col-header-cell {
        font-size: 0.625rem;
        padding: 0.5rem 0.125rem;
    }
    
    .fc-daygrid-day-number {
        font-size: 0.813rem;
        padding: 0.25rem;
    }
    
    .fc-event {
        font-size: 0.688rem;
        padding: 0.188rem 0.375rem;
    }
}

@media (max-width: 375px) {
    .calendar-container {
        padding: 0.5rem;
    }
    
    .calendar-sidebar,
    .calendar-card {
        padding: 0.75rem;
    }
    
    .calendar-title {
        font-size: 1rem;
    }
    
    .view-btn {
        padding: 0.438rem 0.375rem;
        font-size: 0.688rem;
    }
    
    .fc-col-header-cell {
        font-size: 0.563rem;
    }
    
    .fc-event {
        font-size: 0.625rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const catatanModalEl = document.getElementById('catatanModal');
    const hapusModalEl = document.getElementById('hapusCatatanModal');
    if (!catatanModalEl || !hapusModalEl) return;

    const catatanModal = new bootstrap.Modal(catatanModalEl);
    const hapusModal = new bootstrap.Modal(hapusModalEl);
    const catatanForm = document.getElementById('catatanForm');
    const confirmHapusBtn = document.getElementById('confirmHapusBtn');
    const btnDeleteEvent = document.getElementById('btnDeleteEvent');
    const kategoriSelect = document.getElementById('kategoriEvent');
    let selectedEvent = null;

    const flatpickrInstance = flatpickr("#catatanTanggal", {
        dateFormat: "Y-m-d",
        allowInput: true,
        theme: "material_blue"
    });

    // 🎨 Warna kategori 100% fix dan konsisten
    const categoryColors = {
        'Acara Pribadi': '#6366f1',    // Biru (Sesuai gambar)
        'Acara Sekolah': '#6b7280',    // Abu-abu
        'Penting': '#a855f7',          // Ungu
        'Acara Lainnya': '#ec4899'     // Pink
    };

    // Ambil event data dari Blade
    let eventsData = [];
    try {
        const raw = document.getElementById('calendar').dataset.events || '[]';
        eventsData = JSON.parse(raw);
    } catch (e) { console.error('Error parsing events:', e); }

    // 💡 Pastikan warna selalu diset dari kategori (bukan dari DB)
    const events = eventsData.map(e => {
        const kategori = e.kategori || 'Acara Pribadi';
        const color = categoryColors[kategori] || categoryColors['Acara Pribadi'];

        return {
            id: e.id,
            title: e.title || e.catatan || 'Tanpa Judul',
            start: e.start || e.tanggal,
            allDay: true,
            backgroundColor: color,
            borderColor: color,
            textColor: '#fff',
            extendedProps: { kategori }
        };
    });

    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: events,
        headerToolbar: false,
        locale: 'id',
        height: 'auto',

        dateClick: function(info) {
            const day = info.date.getDay();
            if (day === 0 || day === 6) {
                Swal.fire({
                    icon: 'warning',
                    title: '<b>Hari Libur!</b>',
                    html: 'Tidak bisa menambahkan acara di hari <b>Sabtu</b> atau <b>Minggu</b>.',
                    confirmButtonColor: '#6366f1'
                });
                return;
            }
            selectedEvent = null;
            catatanForm.reset();
            document.getElementById('catatanId').value = '';
            flatpickrInstance.setDate(info.dateStr, true);
            kategoriSelect.value = 'Acara Pribadi';
            btnDeleteEvent?.classList.add("d-none");
            catatanModal.show();
        },

        eventClick: function(info) {
            selectedEvent = info.event;
            document.getElementById('catatanId').value = info.event.id || '';
            document.getElementById('catatanText').value = info.event.title || '';
            flatpickrInstance.setDate(info.event.startStr.substring(0,10), true);
            kategoriSelect.value = info.event.extendedProps.kategori || 'Acara Pribadi';
            btnDeleteEvent?.classList.remove("d-none");
            catatanModal.show();
        },

        dayCellDidMount: function(info) {
            const day = info.date.getDay();
            if (day === 0 || day === 6) {
                info.el.style.backgroundColor = '#f8f9fc';
            }
        }
    });

    calendar.render();

    // Navigasi bulan / view
    const calendarTitleEl = document.getElementById('calendarTitle');
    if (calendarTitleEl) calendarTitleEl.innerText = calendar.view.title;

    document.querySelectorAll('[data-action]').forEach(btn => {
        btn.addEventListener('click', () => {
            const action = btn.dataset.action;
            if (calendar[action]) {
                calendar[action]();
                if (calendarTitleEl) calendarTitleEl.innerText = calendar.view.title;
            }
        });
    });

    document.querySelectorAll('[data-view]').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            calendar.changeView(btn.dataset.view);
            if (calendarTitleEl) calendarTitleEl.innerText = calendar.view.title;
        });
    });

    // Tombol tambah acara
    document.getElementById('btnAddEvent')?.addEventListener('click', () => {
        selectedEvent = null;
        catatanForm.reset();
        document.getElementById('catatanId').value = '';
        flatpickrInstance.setDate(new Date(), true);
        kategoriSelect.value = 'Acara Pribadi';
        btnDeleteEvent?.classList.add("d-none");
        catatanModal.show();
    });

    // Simpan / update acara
catatanForm?.addEventListener('submit', async function(e) {
    e.preventDefault();

    const id = document.getElementById('catatanId').value || '';
    const tanggal = document.getElementById('catatanTanggal').value;
    const catatan = document.getElementById('catatanText').value.trim();
    const kategori = kategoriSelect.value || 'Acara Pribadi';
    const color = categoryColors[kategori];

    if (!tanggal || !catatan) {
        Swal.fire({ icon: 'error', title: 'Lengkapi Data!', text: 'Tanggal dan catatan harus diisi.' });
        return;
    }

    const baseUrl = "{{ $baseUrl ?? '' }}";
    const rawUpdateUrl = "{{ $updateUrl ?? '' }}";
    const url = id ? rawUpdateUrl.replace(':id', id) : baseUrl;
    const method = id ? 'PUT' : 'POST';

    try {
        const res = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ tanggal, catatan, kategori })
        });

        const data = await res.json();
        if (!res.ok) throw new Error(data.message || 'Gagal menyimpan data');

        // Ambil ID baru dari response server
        const eventId = data.id || id || Date.now();

        // Hapus event lama jika sedang update
        if (id && selectedEvent) {
            selectedEvent.remove();
        }

        // Tambahkan ulang event ke kalender
        calendar.addEvent({
            id: eventId,
            title: catatan,
            start: tanggal,
            allDay: true,
            backgroundColor: color,
            borderColor: color,
            textColor: '#fff',
            extendedProps: { kategori }
        });

        catatanModal.hide();

        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: id ? 'Catatan berhasil diperbarui.' : 'Catatan baru ditambahkan.',
            timer: 1500,
            showConfirmButton: false
        });
    } catch (err) {
        Swal.fire({ icon: 'error', title: 'Gagal!', text: err.message });
    }
});

// Hapus event
btnDeleteEvent?.addEventListener('click', () => {
    if (selectedEvent) {
        catatanModal.hide(); // Tutup modal utama dulu
        setTimeout(() => hapusModal.show(), 300); // Tampilkan modal hapus setelah sedikit jeda
    }
});

confirmHapusBtn?.addEventListener('click', async () => {
    if (!selectedEvent) return;
    const rawDeleteUrl = "{{ $deleteUrl ?? '' }}";
    const deleteUrl = rawDeleteUrl.replace(':id', selectedEvent.id);

    try {
        const res = await fetch(deleteUrl, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });

        if (!res.ok) throw new Error('Gagal menghapus data.');

        selectedEvent.remove();
        hapusModal.hide();

        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Terhapus!',
                timer: 1500,
                showConfirmButton: false
            });
        }, 300);

    } catch (err) {
        Swal.fire({ icon: 'error', title: 'Gagal!', text: err.message });
    }
});

});
</script>

@endsection