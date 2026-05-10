<div class="text-sm sm:text-base md:text-lg lg:text-xl font-semibold">
    <div id="clock2" class="h3 text-xl font-mono font-bold" style="color:SlateBlue"></div>
    <div id="date2" class="text-xl font-mono font-bold" style="color:Violet"></div>
</div>

@push('styles')

@endpush

@push('scripts')
<script>
    function updateClock(clockId, dateId) {
        const today = new Date();
        let hr = today.getHours();
        let min = today.getMinutes();
        let sec = today.getSeconds();
        const ap = hr >= 12 ? "PM" : "AM";

        hr = hr % 12 || 12;
        hr = hr < 10 ? "0" + hr : hr;
        min = min < 10 ? "0" + min : min;
        sec = sec < 10 ? "0" + sec : sec;

        const time = `${hr}:${min}:${sec} ${ap}`;
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const months = ['January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December'];
        const date = `${days[today.getDay()]}, ${today.getDate()} ${months[today.getMonth()]} ${today.getFullYear()}`;

        document.getElementById(clockId).textContent = time;
        document.getElementById(dateId).textContent = date;
    }

    document.addEventListener("DOMContentLoaded", function () {
        updateClock('clock2', 'date2');
        setInterval(() => updateClock('clock2', 'date2'), 1000);
    });
</script>
@endpush
