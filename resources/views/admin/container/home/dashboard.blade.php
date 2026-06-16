@extends('layouts.admin')
@section('title', 'Dashboard')
@section('admin-content')
    <div x-data="dashboardState()" class="w-full">
        <div class="w-full flex items-center justify-between gap-5">
            <div>
                <div class="text-2xl font-extrabold text-theme-text-main">Welcome back, {{ Auth::user()->name }}! 👋</div>
                <div class="text-[13px] text-theme-text-muted mt-1">
                    Here's what's happening at Franklin's Forever Care today.
                </div>
            </div>
            <div class="flex gap-3">
                <button @click="showReminderModal = true"
                    class="px-5 py-2.5 bg-theme-card border border-theme-primary text-theme-primary rounded-[10px] text-[13px] font-bold hover:bg-theme-hover transition-all">+
                    Add Reminder</button>
            </div>
        </div>
        <div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-4 gap-5 my-5">
            <a href="{{ route('admin.clients.index') }}"
                class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm hover:shadow-md transition-shadow group">
                <div
                    class="w-10 h-10 rounded-[10px] bg-theme-primary-light flex items-center justify-center text-theme-primary mb-5 group-hover:bg-theme-primary group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div class="text-theme-text-muted text-[12.5px] font-medium uppercase tracking-wide">Total Clients</div>
                <div class="text-2xl font-extrabold text-theme-text-main mt-1">{{ $stats['total_clients'] }}</div>
                <div class="mt-3 flex items-center">
                    <span class="px-2 py-0.5 rounded-full bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 text-[10.5px] font-bold">↑ {{ $stats['client_growth'] }}% total growth</span>
                </div>
            </a>
            <a href="{{ route('admin.employees.index') }}"
                class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm hover:shadow-md transition-shadow group">
                <div
                    class="w-10 h-10 rounded-[10px] bg-red-50 dark:bg-red-900/30 flex items-center justify-center text-[#e63b3b] dark:text-red-400 mb-5 group-hover:bg-[#e63b3b] group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <div class="text-theme-text-muted text-[12.5px] font-medium uppercase tracking-wide">Specialists (PCA)</div>
                <div class="text-2xl font-extrabold text-theme-text-main mt-1">{{ $stats['specialists'] }}</div>
                <div class="mt-3 flex items-center">
                    <span class="px-2 py-0.5 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 text-[10.5px] font-bold">{{ $stats['active_duty'] }} Active Duty</span>
                </div>
            </a>
            <a href="{{ route('admin.employees.index') }}"
                class="bg-theme-primary rounded-[14px] p-5 shadow-lg relative overflow-hidden text-white hover:bg-theme-primary-hover transition-colors group">
                <div
                    class="w-10 h-10 rounded-[10px] bg-white/20 flex items-center justify-center text-white mb-5 group-hover:bg-white group-hover:text-[#1a3cdc] transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 8v4m0 4h.01" />
                    </svg>
                </div>
                <div class="text-white/70 text-[12.5px] font-medium uppercase tracking-wide">Pending Apps & Bookings</div>
                <div class="text-2xl font-extrabold text-white mt-1">{{ $stats['pending_requests'] + $stats['pending_applications'] }}</div>
                <div class="mt-3 flex items-center">
                    <span class="px-2 py-0.5 rounded-full bg-white/20 text-white text-[10.5px] font-bold">{{ $stats['pending_applications'] }} New Career Submissions</span>
                </div>
                <div class="absolute -right-5 -bottom-5 w-24 h-24 bg-white/10 rounded-full"></div>
            </a>
            <a href="{{ route('admin.payments') }}"
                class="bg-theme-card rounded-[14px] p-5 border border-theme-border shadow-sm hover:shadow-md transition-shadow group">
                <div
                    class="w-10 h-10 rounded-[10px] bg-green-50 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 mb-5 group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="2" />
                        <line x1="2" y1="10" x2="22" y2="10" />
                    </svg>
                </div>
                <div class="text-theme-text-muted text-[12.5px] font-medium uppercase tracking-wide">Monthly Revenue</div>
                <div class="text-2xl font-extrabold text-theme-text-main mt-1">${{ number_format($stats['monthly_revenue'] / 1000, 1) }}K</div>
                <div class="mt-3 flex items-center">
                    <span class="px-2 py-0.5 rounded-full bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 text-[10.5px] font-bold">This month</span>
                </div>
            </a>
        </div>
        <div class="grid sm:grid-cols-1 xm:grid-cols-1 grid-cols-3 gap-5">
            <div class="col-span-2 space-y-5">
                <div class="bg-theme-card rounded-[14px] border border-theme-border shadow-sm min-h-[400px]">
                    <div class="px-6 py-5 border-b border-theme-border flex items-center justify-between">
                        <h3 class="text-[15px] font-extrabold text-theme-text-main">Recent Client Activities</h3>
                        <a href="{{ route('admin.clients.index') }}" class="text-[12px] font-bold text-theme-primary hover:underline">View All →</a>
                    </div>
                    <div class="divide-y divide-theme-border">
                        @forelse($recentActivities as $activity)
                        <div class="px-6 py-4 flex items-start gap-4">
                            <div
                                class="w-9 h-9 rounded-full bg-theme-primary-light text-theme-primary flex items-center justify-center font-bold text-[12px]">
                                {{ strtoupper(substr($activity->patient_name, 0, 2)) }}</div>
                            <div>
                                <div class="text-[13.5px] text-theme-text-main"><b>{{ $activity->patient_name }}</b> <span class="text-theme-text-muted">booked {{ $activity->service->title }} ({{ $activity->plan_type }})</span></div>
                                <div class="text-[11.5px] text-theme-text-muted mt-1">{{ $activity->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-10 text-center text-theme-text-muted text-sm italic">No recent activity</div>
                        @endforelse
                    </div>
                </div>
                <div class="w-full flex justify-between gap-5">
                     <div class="w-full bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-bold text-theme-text-main">Schedule: <span class="text-theme-primary" x-text="formatSelectedDate()"></span></h3>
                    </div>
                    
                    <div class="space-y-3">
                        <template x-for="booking in selectedDateBookings" :key="booking.id">
                            <div class="p-3 bg-theme-hover rounded-xl border border-theme-border flex flex-col gap-1 transition-all">
                                <div class="flex items-center justify-between">
                                    <span class="text-[13px] font-bold text-theme-text-main" x-text="booking.patient_name"></span>
                                    <span class="px-2 py-0.5 rounded-full bg-theme-primary-light text-theme-primary text-[9.5px] font-bold uppercase" x-text="booking.plan_type"></span>
                                </div>
                                <div class="text-[11.5px] text-theme-text-muted" x-text="booking.service_title"></div>
                            </div>
                        </template>
                        
                        <div x-show="selectedDateBookings.length === 0" class="text-center py-6 text-theme-text-muted text-[12.5px] italic">
                            No bookings scheduled for this date.
                        </div>
                    </div>
                </div>
                
                </div>
            </div>
            <div class="space-y-5">
                <div class="bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm min-h-[400px]">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-[14.5px] font-bold text-theme-text-main" x-text="monthNames[currentMonth] + ' ' + currentYear"></h3>
                        <div class="flex gap-2">
                            <button @click="prevMonth()"
                                class="w-7 h-7 rounded-full border border-theme-border flex items-center justify-center text-theme-text-muted hover:bg-theme-hover">‹</button>
                            <button @click="nextMonth()"
                                class="w-7 h-7 rounded-full border border-theme-border flex items-center justify-center text-theme-text-muted hover:bg-theme-hover">›</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-7 gap-1 text-center">
                        <template x-for="dayName in ['S', 'M', 'T', 'W', 'T', 'F', 'S']">
                            <div class="text-[11px] font-bold text-theme-text-muted py-2" x-text="dayName"></div>
                        </template>
                        
                        <template x-for="day in days" :key="day.dateString">
                            <div
                                class="py-2 text-[12.5px] hover:bg-theme-hover rounded-full cursor-pointer flex flex-col items-center justify-center relative transition-all"
                                :class="{
                                    'bg-theme-primary text-white font-bold shadow-sm': selectedDate === day.dateString,
                                    'border border-theme-primary text-theme-primary font-bold': isToday(day.dateString) && selectedDate !== day.dateString,
                                    'text-theme-text-main': day.isCurrentMonth && selectedDate !== day.dateString,
                                    'text-theme-text-muted opacity-40': !day.isCurrentMonth && selectedDate !== day.dateString
                                }"
                                @click="selectDate(day.dateString)">
                                <span x-text="day.day"></span>
                                <span x-show="hasBooking(day.dateString)" 
                                      class="w-1.5 h-1.5 rounded-full mt-0.5" 
                                      :class="selectedDate === day.dateString ? 'bg-white' : 'bg-theme-primary'"></span>
                            </div>
                        </template>
                    </div>
                </div>
                 <div class="w-full bg-theme-card rounded-[14px] border border-theme-border p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-sm font-bold text-theme-text-main">Reminders</h3>
                        <button @click="showReminderModal = true"
                            class="w-8 h-8 rounded-full bg-theme-primary text-white flex items-center justify-center text-lg shadow-sm hover:bg-theme-primary-hover transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 5v14m-7-7h14" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-3 max-h-[350px] overflow-y-auto pr-1">
                        <template x-for="reminder in reminders" :key="reminder.id">
                            <div class="flex items-start justify-between gap-3 p-3 rounded-xl border border-theme-border bg-theme-hover transition-all"
                                 :class="{ 'opacity-60 bg-theme-bg': reminder.is_completed }">
                                <div class="flex items-start gap-3">
                                    <input type="checkbox" 
                                           :checked="reminder.is_completed" 
                                           @change="toggleReminder(reminder)"
                                           class="mt-1 w-4.5 h-4.5 rounded border-theme-border text-theme-primary focus:ring-theme-primary cursor-pointer">
                                    <div>
                                        <div class="text-[13px] font-bold text-theme-text-main transition-all" 
                                             :class="{ 'line-through text-theme-text-muted': reminder.is_completed }" 
                                             x-text="reminder.title"></div>
                                        <div x-show="reminder.description" 
                                             class="text-[11.5px] text-theme-text-muted mt-0.5" 
                                             x-text="reminder.description"></div>
                                        <div class="text-[10px] font-bold text-red-600 dark:text-red-400 mt-1 uppercase tracking-wider flex items-center gap-1">
                                            <span>📅 <span x-text="reminder.due_date.substring(0, 10)"></span></span>
                                            <span x-show="reminder.due_time"> | ⏰ <span x-text="reminder.due_time.substring(0, 5)"></span></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <button @click="deleteReminder(reminder.id)" class="text-theme-text-muted hover:text-red-500 transition-colors p-1">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                                                <div x-show="reminders.length === 0" class="text-center py-8 text-theme-text-muted text-[12.5px] italic">
                            No reminders found.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div x-show="showReminderModal" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             style="display: none;">
            
            <div class="bg-theme-card border border-theme-border rounded-2xl max-w-md w-full p-6 shadow-2xl relative"
                 @click.away="showReminderModal = false">
                
                <button @click="showReminderModal = false" class="absolute top-4 right-4 text-theme-text-muted hover:text-theme-text-main transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <h3 class="text-lg font-extrabold text-theme-text-main mb-4">Add New Reminder</h3>
                
                <form @submit.prevent="submitReminder()" class="space-y-4">
                    <div>
                        <label class="block text-[12.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1.5">Title</label>
                        <input type="text" x-model="newReminder.title" required placeholder="e.g. Health Appointment"
                               class="w-full px-4 py-2.5 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-sm">
                    </div>
                    
                    <div>
                        <label class="block text-[12.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1.5">Details (Optional)</label>
                        <textarea x-model="newReminder.description" placeholder="e.g. Meet with Specialist Dr. Vance" rows="3"
                                  class="w-full px-4 py-2.5 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-sm resize-none"></textarea>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1.5">Due Date</label>
                            <input type="date" x-model="newReminder.due_date" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-sm">
                        </div>
                        
                        <div>
                            <label class="block text-[12.5px] font-bold text-theme-text-muted uppercase tracking-wider mb-1.5">Due Time (Optional)</label>
                            <input type="time" x-model="newReminder.due_time"
                                   class="w-full px-4 py-2.5 rounded-xl border border-theme-border bg-theme-bg text-theme-text-main focus:outline-none focus:border-theme-primary text-sm">
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="showReminderModal = false"
                                class="px-5 py-2.5 rounded-xl border border-theme-border bg-theme-hover text-theme-text-main text-[13px] font-bold hover:bg-theme-border transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-5 py-2.5 rounded-xl bg-theme-primary text-white text-[13px] font-bold hover:bg-theme-primary-hover shadow-md transition-colors">
                            Save Reminder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function dashboardState() {
            // Local date ISO format function
            const getLocalTodayString = () => {
                const d = new Date();
                const offset = d.getTimezoneOffset();
                return new Date(d.getTime() - (offset * 60 * 1000)).toISOString().split('T')[0];
            };

            return {
                // Reminders data
                reminders: @json($reminders),
                showReminderModal: false,
                newReminder: {
                    title: '',
                    description: '',
                    due_date: getLocalTodayString(),
                    due_time: ''
                },

                // Calendar data
                calendarBookings: @json($calendarBookings),
                currentMonth: new Date().getMonth(),
                currentYear: new Date().getFullYear(),
                selectedDate: getLocalTodayString(),
                monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                days: [],

                init() {
                    this.generateCalendar();
                },

                generateCalendar() {
                    const firstDayIndex = new Date(this.currentYear, this.currentMonth, 1).getDay();
                    const totalDays = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
                    const prevTotalDays = new Date(this.currentYear, this.currentMonth, 0).getDate();

                    const daysArr = [];

                    // Previous month's trailing days
                    for (let i = firstDayIndex - 1; i >= 0; i--) {
                        const prevMonthVal = this.currentMonth === 0 ? 11 : this.currentMonth - 1;
                        const prevYearVal = this.currentMonth === 0 ? this.currentYear - 1 : this.currentYear;
                        const dateStr = `${prevYearVal}-${String(prevMonthVal + 1).padStart(2, '0')}-${String(prevTotalDays - i).padStart(2, '0')}`;
                        daysArr.push({
                            day: prevTotalDays - i,
                            dateString: dateStr,
                            isCurrentMonth: false
                        });
                    }

                    // Current month's days
                    for (let i = 1; i <= totalDays; i++) {
                        const dateStr = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                        daysArr.push({
                            day: i,
                            dateString: dateStr,
                            isCurrentMonth: true
                        });
                    }

                    // Next month's leading days to make a complete grid (multiple of 7)
                    const remainingSlots = 42 - daysArr.length;
                    for (let i = 1; i <= remainingSlots; i++) {
                        const nextMonthVal = this.currentMonth === 11 ? 0 : this.currentMonth + 1;
                        const nextYearVal = this.currentMonth === 11 ? this.currentYear + 1 : this.currentYear;
                        const dateStr = `${nextYearVal}-${String(nextMonthVal + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                        daysArr.push({
                            day: i,
                            dateString: dateStr,
                            isCurrentMonth: false
                        });
                    }

                    this.days = daysArr;
                },

                prevMonth() {
                    if (this.currentMonth === 0) {
                        this.currentMonth = 11;
                        this.currentYear--;
                    } else {
                        this.currentMonth--;
                    }
                    this.generateCalendar();
                },

                nextMonth() {
                    if (this.currentMonth === 11) {
                        this.currentMonth = 0;
                        this.currentYear++;
                    } else {
                        this.currentMonth++;
                    }
                    this.generateCalendar();
                },

                isToday(dateString) {
                    return getLocalTodayString() === dateString;
                },

                hasBooking(dateString) {
                    return this.calendarBookings.some(b => b.date === dateString);
                },

                selectDate(dateString) {
                    this.selectedDate = dateString;
                },

                formatSelectedDate() {
                    if (!this.selectedDate) return '';
                    const d = new Date(this.selectedDate + 'T00:00:00');
                    return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                },

                get selectedDateBookings() {
                    return this.calendarBookings.filter(b => b.date === this.selectedDate);
                },

                // Reminders CRUD using AJAX
                toggleReminder(reminder) {
                    fetch(`/dashboard/reminders/${reminder.id}/toggle`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            reminder.is_completed = data.is_completed;
                            toastr.success(data.message);
                        } else {
                            toastr.error('Failed to update status');
                        }
                    })
                    .catch(() => toastr.error('An error occurred'));
                },

                deleteReminder(id) {
                    if (!confirm('Are you sure you want to delete this reminder?')) return;
                    fetch(`/dashboard/reminders/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.reminders = this.reminders.filter(r => r.id !== id);
                            toastr.success(data.message);
                        } else {
                            toastr.error('Failed to delete reminder');
                        }
                    })
                    .catch(() => toastr.error('An error occurred'));
                },

                submitReminder() {
                    if (!this.newReminder.title || !this.newReminder.due_date) {
                        toastr.error('Please enter a title and date.');
                        return;
                    }

                    fetch('/dashboard/reminders', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.newReminder)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.reminders.push(data.reminder);
                            // Re-sort reminders
                            this.reminders.sort((a, b) => {
                                if (a.is_completed !== b.is_completed) return a.is_completed ? 1 : -1;
                                return new Date(a.due_date + 'T' + (a.due_time || '00:00')) - new Date(b.due_date + 'T' + (b.due_time || '00:00'));
                            });
                            
                            toastr.success(data.message);
                            this.showReminderModal = false;
                            this.newReminder = {
                                title: '',
                                description: '',
                                due_date: getLocalTodayString(),
                                due_time: ''
                            };
                        } else {
                            toastr.error('Failed to add reminder');
                        }
                    })
                    .catch(() => toastr.error('An error occurred'));
                }
            };
        }
    </script>
@endsection