@extends('layouts.admin.app')
@section('title', 'Kalender Penyewaan')

@section('content')

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-800">Jadwal Penyewaan</h2>
            <div class="text-sm flex gap-4">
                <span class="flex items-center gap-1">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div> Pending
                </span>
                <span class="flex items-center gap-1">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div> Disetujui
                </span>
                <span class="flex items-center gap-1">
                    <div class="w-3 h-3 bg-gray-500 rounded-full"></div> Selesai
                </span>
            </div>
        </div>

        <div id="calendar" class="min-h-[600px]"></div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Tampilan Bulanan
                locale: 'id', // Bahasa Indonesia
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: "{{ route('admin.calendar') }}", // Ambil data dari Controller

                // Saat event diklik
                eventClick: function(info) {
                    // Bisa tambahkan logika modal detail disini nanti
                    // info.jsEvent.preventDefault(); 
                }
            });

            calendar.render();
        });
    </script>

    <style>
        /* Sedikit styling agar tombol kalender sesuai tema TailAdmin */
        .fc-button-primary {
            background-color: #3C50E0 !important;
            border-color: #3C50E0 !important;
        }

        .fc-button-active {
            background-color: #263ba8 !important;
        }
    </style>

@endsection
